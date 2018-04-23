<?php

namespace AbdulmatinSanni\APIx\Commands\Log;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-x:clear-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears entries of api-x log file';

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
        $logPath = config('api-x.log_file_path');

        if ($this->confirm('Are you sure you want to clear API-x log file?')) {
            Storage::put($logPath, "");
            $this->info("Log file {$logPath} has be cleared successfully");
        }
    }
}
