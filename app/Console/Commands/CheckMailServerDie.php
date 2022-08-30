<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SendMail\SendMailServiceInterface;

class CheckMailServerDie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendMailServiceInterface $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->service->checkMailServerDie();
    }
}
