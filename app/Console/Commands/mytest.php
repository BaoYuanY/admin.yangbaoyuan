<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class mytest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mytest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        dd(enAes128Ecb('yuque@0304', '语雀'));
//        dd(deAes128Ecb('2EyPljoY+5AghOGtWgsYkg', 'QQ'));
    }
}