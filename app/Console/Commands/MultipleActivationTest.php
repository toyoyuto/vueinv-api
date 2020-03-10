<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class MultipleActivationTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:multiple-activation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '多重起動防止テスト';

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
     * @return mixed
     */
    public function handle()
    {
        Log::info('start');
        sleep(70);
        Log::info('end');

    }
}
