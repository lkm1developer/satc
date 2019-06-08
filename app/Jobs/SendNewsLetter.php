<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Template;
use App\User;
use Log;
use Mail;
class SendNewsLetter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
	protected $template; 
	protected $user; 
    public function __construct($template,$user)
    {
        $this->template = $template;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$user= $this->user;
		$template=Template::findorfail($this->template);
		$subject = $template->title;
		$email = $user->email;
		//var_dump($user);
		//var_dump($template);
		 //$email = 'lakhvinder.auspicioussoft@gmail.com';
		$ck =Mail::send(['html' => 'email.template'], ['data' => $template], function($message) use ($email, $subject, $template, $user)
		{
			$message->to($email, $user->name)->subject($subject);
		});
		//var_dump($ck);die;
    }
	// private function Email($user, $template){
		// $user= $this->user;
		// $template =$this->template;
		// $subject = $template->title;
		// $email = $user->email;
		 // $email = 'lakhvinder.auspicioussoft@gmail.com';
		// Mail::send(['html' => 'email.template'], ['data' => $template], function($message) use ($email, $subject, $template, $user)
		// {
			// $message->to($email, $user->name)->subject($subject);
		// });
	// }
}
