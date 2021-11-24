<?php

namespace App\Console\Commands;

use App\Services\Thesieure;
use Illuminate\Console\Command;

class SyncCardTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'card-type:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync card types';

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
        $total = 0;
        $total += Thesieure::syncCardTypes()->count();

        $this->info('Total synced card types: ' . $total);
        return Command::SUCCESS;
    }
}
