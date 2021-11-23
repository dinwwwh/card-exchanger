<?php

namespace App\Services;

use App\Interfaces\CardServicable;
use App\Models\Card;
use App\Models\CardType;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Http;
use Arr;
use DB;

class Thesieure implements CardServicable
{
    public static function as()
    {
        return User::firstOrCreate([
            'name' => 'thesieure',
            'email' => 'thesieure',
            'password' => 'thesieure',
        ]);
    }

    protected static function getConfig(): ?array
    {
        $config = config('services.thesieure');

        if (
            !is_array($config) ||
            !array_key_exists('partner_id', $config)  ||
            !array_key_exists('partner_key', $config)  ||
            !array_key_exists('domain', $config)

        ) {
            throw new \Exception('Invalid config for thesieure service');
        }

        return $config;
    }

    public static function syncCardTypes(): Collection
    {
        $callback = [static::class, 'approve'];
        $stringCallback = Arr::toJson($callback);
        $user = static::as();
        CardType::where('callback', $stringCallback)
            ->get()
            ->each(fn ($cardType) => $cardType->delete());

        $config = static::getConfig();
        $cardTypes = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
            ->get('https://' . $config['domain'] . '/chargingws/v2/getfee?partner_id=' . $config['partner_id'])
            ->json();

        $cardTypes = array_map(fn ($cardType) => [
            'telco' => $cardType['telco'],
            'value' => $cardType['value'],
            'fees' => $cardType['fees'],
            'callback' => $callback,
            'creator_id' => $user->getKey(),
            'updater_id' => $user->getKey(),
        ], $cardTypes);

        $createdCardTypes = new Collection;
        foreach ($cardTypes as $cardType) {
            $createdCardTypes->push(CardType::create($cardType));
        }
        return $createdCardTypes;
    }

    public static function approve(CardType $type, Card $card): void
    {
        $config = static::getConfig();

        $response =  Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://' . $config['domain'] . '/chargingws/v2', [
            'telco' => $card->type->telco,
            'amount' => $card->type->value,
            'serial' => $card->serial,
            'code' => $card->code,
            'request_id' => $card->getKey(),
            'partner_id' => $config['partner_id'],
            'sign' => static::generateSign($card),
            'command' => 'charging',
        ]);

        DB::transaction(
            fn () =>
            static::handleServiceResponse($card, $response->json(), $response->status())
        );
    }

    public static function handleServiceResponse(Card $card, array $data, int $status = 200): void
    {
        if ($status > 299 || $status < 200) return;
        if (!is_null($card->received_value)) return;

        $validation = validator($data, [
            'status' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
        ]);
        if ($validation->fails()) return;

        // Prepare data
        $type = $card->type;
        $user = static::as();

        # Case success and correct value
        if ($data['status'] === 1) {
            $card->update([
                'received_value' => (int)($type->value * (100 - $type->fees) / 100),
                'updater_id' =>  $user->getKey(),
                'approver_id' => $user->getKey(),
                'approved_at' => now(),
            ]);
        }

        # Case success but incorrect value
        if ($data['status'] === 2) {
            $card->update([
                'received_value' => (int)($data['amount']),
                'updater_id' =>  $user->getKey(),
                'approver_id' => $user->getKey(),
                'approved_at' => now(),
            ]);
        }

        # Case fail
        elseif (in_array($data['status'], [3, 4, 100])) {
            $card->update([
                'received_value' =>  0,
                'updater_id' =>  $user->getKey(),
                'approver_id' => $user->getKey(),
                'approved_at' => now(),
            ]);
        }
    }

    /** Handle request from thesieure server */
    public function handleServiceRequest()
    {
        $data = request()->all();
        $validation = validator($data, [
            'request_id' => ['required', 'integer'],
            'callback_sign' => ['required', 'string'],
        ]);

        if (!$validation->fails()) {
            $card = Card::find($data['request_id']);

            if ($card && static::checkSign($data['callback_sign'], $card)) {
                DB::transaction(
                    fn () =>
                    static::handleServiceResponse($card, $data)
                );
            }
        }

        return response()->json([], 204);
    }

    /** Generate a sign use to send to thesieure server */
    public static function generateSign(Card $card): string
    {
        $config = static::getConfig();
        return md5($config['partner_key'] . $card->code . $card->serial);
    }

    /** Check a callback sign of thesieure whether valid */
    public static function checkSign(string $sign,  Card $card): bool
    {
        return $sign == static::generateSign($card);
    }
}
