<?php

namespace App\Listeners;

use App\Events\UserReferred;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Credit;

class RewardUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserReferred  $event
     * @return void
     */
    public function handle(UserReferred $event)
    {
        $referral = \App\ReferralLink::where('code',$event->referralId)->get()->first();
        if (!is_null($referral)) {
            \App\ReferralRelationship::create(['referral_link_id' => $referral->id, 'user_id' => $event->user->id]);

    // Example...
            if ($referral->program->name === 'Sign-up Bonus') {
        // User who was sharing link
                $provider = $referral->user;
                // $provider->addCredits(15);
                // User who used the link
                $user = $event->user;
                $credit = Credit::create(['user_id'=>$referral->user->id, 'amount'=>200, 'type'=>'referred '.$user->first_name.' for sign up','currency'=>'konkrete']);
                $credit = Credit::create(['user_id'=>$event->user->id, 'amount'=>200, 'type'=>'referred by '.$referral->user->first_name.' sign up','currency'=>'konkrete']);
                // $user->addCredits(20);
            }

        }
    }
}
