<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;
use App\User;
class Reward extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
	protected $arr;
    public function __construct(array $arr)
    {
         $this->arr = $arr;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {	
		
		if(Auth::check()){
			if((Auth::user())->notification){
				return ['mail','database'];
			}
		} else {
			if($this->arr['user_id']){
				$thisUser= User::find($this->arr['user_id']);
				if($thisUser->notification){
				return ['mail','database'];
				}
			}
		}
		return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
		
		$url= url('/home/view/'.$this->arr['node']->id);
		$name= $this->arr['node']->masternode->name;
		$amount= $this->arr['APIdata']->last_paid_amount;
		if(Auth::check()){
			$user=Auth::user();
		} else {
			if($this->arr['user_id']){
				$user= User::find($this->arr['user_id']);
			}
		}
        return (new MailMessage)
					->greeting('Hello  '.$user->name.' !')
                    ->line('Your Masternode '.$this->arr['node']->id.' '.$name.' has been rewarded by '.$amount.' '.$name)
                    ->action('View details', $url)
                    ->line('Thank you for using our application!')
                    ->line('Regards')
                    ->salutation('SatoshiSolutions Team');
					
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
           $this->arr
        ];
    }
}
