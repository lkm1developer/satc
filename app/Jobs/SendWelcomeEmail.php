<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;
use Log;
use App\Template;
use App\User;
use Mail;
class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data; 
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

		
		//	Log::info('queue working');die('fhghg');
       $template=Template::findorfail($this->data);
	    $user = User::find(39);
	   // $users = User::all();
	   //$users = User::find(39);
	   // foreach($users as $user){
		$this->Email($user, $template);
	   // }
    }
	public function Email($user, $template){
		$subject = $template->title;
		$email = $user->email;
		log::critical('mailsentjobs');
		 // $email = 'sharma918.pankaj@gmail.com';
		 $email = 'lakhvinder.auspicioussoft@gmail.com';
		Mail::send(['html' => 'email.template'], ['data' => $template], function($message) use ($email, $subject, $template, $user)
		{
			$message->to($email, 'thisisit')->subject($subject);
		});
	}
}
