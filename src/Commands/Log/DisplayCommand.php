<?php

namespace AbdulmatinSanni\APIx\Commands\Log;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class DisplayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-x:log 
        {--l|latest : Displays only the last log entry} 
        {--t|limit= : Specifies the number of logs to display}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays entries of api-x log file';

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
        $log = null;
        $logPath = config('api-x.log_file_path');
        $logEntryDelimiter = config('api-x.log_entry_delimiter');

        try {
            $log = Storage::get($logPath);
        } catch (FileNotFoundException $exception) {
            Storage::put($logPath, null);
        }

        if ($this->option('latest')) {
            $logs = explode(config('api-x.log_entry_delimiter'), $log)[0];
            $this->info($logs);
            return;
        }

        $limit = $this->option('limit');

        if ($limit) {
            $delimitedlogs = null;
            $logs = explode(config('api-x.log_entry_delimiter'), $log);
            $logLimit = ($limit < count($logs)) ? $limit : count($logs);

            for ($i = 0; $i < $logLimit; $i++) {
                $delimitedlogs .= <<< EOF
                
            $logs[$i]
            $logEntryDelimiter
EOF;
            }

            $this->info($delimitedlogs);
            return;
        }

        $this->info($log);
    }
}
