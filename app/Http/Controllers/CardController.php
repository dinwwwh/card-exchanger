<?php

namespace App\Http\Controllers;

use App\Http\Requests\Card\ExchangeRequest;
use App\Http\Requests\Card\ViewExchangeRequest;
use App\Http\Requests\Card\ViewHistoryRequest;
use App\Models\Card;
use App\Models\CardType;
use App\Models\Wallet;
use Arr;
use DB;

class CardController extends Controller
{
    /** View exchange screen */
    public function viewExchange(ViewExchangeRequest $request)
    {
        $types = CardType::when($request->search, function ($query, $search) {
            return $query->where('telco', 'like', '%' . $search . '%')
                ->orWhere('value', 'like', '%' . $search . '%');
        })->paginate(12);

        return inertia('Card/Exchange', [
            'types' => Arr::camel($types->toArray()),
            'search' => $request->search,
        ]);
    }

    /** Handle exchange card */
    public function exchange(ExchangeRequest $request)
    {
        try {
            DB::beginTransaction();

            $wallet = Wallet::firstOrCreate([
                'account' => $request->wallet['account'],
                'type' => $request->wallet['type'],
            ]);

            $card = Card::create([
                'wallet_id' => $wallet->id,
                'type_id' => $request->typeId,
                'serial' => $request->serial,
                'code' => $request->code,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        // return redirect()->route('card.viewHistory');
    }

    /** View exchange history */
    public function viewHistory(ViewHistoryRequest $request)
    {
        $cards = Card::orderBy('id', 'desc')
            ->when(
                $request->search,
                fn ($query, $search) => $query
                    ->where('serial', 'like', '%' . $search . '%')
            )
            ->paginate(12);

        return inertia('Card/History', [
            'cards' => Arr::camel($cards->toArray()),
            'oldQueries' => [
                'search' => $request->search,
            ],
        ]);
    }
}
