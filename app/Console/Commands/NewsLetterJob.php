<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Log;
use Artisan;
class NewsLetterJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to send newsletter to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
    public function handle()
    {	
		\Artisan::call('queue:work', ['--tries'=>2]);
		Log::alert('newsletter batch console cron'); 
	}
}
