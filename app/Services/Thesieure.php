<?php

namespace App\Services;

use App\Interfaces\CardServicable;
use App\Models\Card;
use App\Models\CardType;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Http;
use Arr;

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

    public static function getConfig(): ?array
    {
        return config('services.thesieure');
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
        if (!$config) return new Collection;

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
    }
}
