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
        $messageLog = null;
        $logPath = config('api-x.log_file_path');
        $logEntryDelimiter = config('api-x.log_entry_delimiter');

        $headers = ['From', 'To', 'Message', 'Timestamp'];

        try {
            $messageLog = Storage::get($logPath);
        } catch (FileNotFoundException $exception) {
            Storage::put($logPath, null);
        }

        $messages = json_decode($messageLog, true);

        if ($this->option('latest')) {
            $messages = [$messages[count($messages) - 1]];
        }

        if ($this->option('limit')) {
            $messages = array_slice(
                $messages,
                count($messages) - $this->option('limit')
            );
        }

        if (! is_array($messages)) {
            $this->error("No message in log.");

            return false ;
        }

        $this->table($headers, $messages);
    }
}
