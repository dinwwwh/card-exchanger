<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\Wallet;
use App\Services\Momo;
use Illuminate\Console\Command;

class BankingForSuccessCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'card:bank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bank money for success cards';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $totalMoney = 0;
        $totalCards = 0;
        $momoCards = Card::whereRelation('wallet', 'type', Wallet::MOMO_TYPE)
            ->whereNotNull('received_value')
            ->whereNull('paid_at')
            ->with('wallet')
            ->get();
        foreach ($momoCards as $card) {
            $isSuccess = Momo::bank(
                $card->received_value,
                $card->wallet->account,
                'Thanh toán thẻ cào có serial: ' . $card->serial,
            );

            if ($isSuccess) {
                $card->update([
                    'paid_at' => now(),
                ]);
                $totalMoney += $card->received_value;
                $totalCards++;
            }
        }

        if ($totalCards)
            $this->info('Banked for ' . $totalCards . ' cards. Total money is ' . number_format($totalMoney) . 'đ');

        $failedTotalCards = $momoCards->count() - $totalCards;
        if ($failedTotalCards)
            $this->error('Not banked for ' . $failedTotalCards . ' cards');

        return Command::SUCCESS;
    }
}
