<?php

namespace App\Jobs;

use App\Jobs\Job;
use Mail;
use App\Role;
use App\User;
use App\Project;
use App\UserRegistration;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReminderEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $mailer;
    protected $from = 'info@estatebaron.com';
    protected $to;
    protected $bcc;
    protected $view;
    protected $subject;
    protected $data = [];
    protected $investor;
    protected $project;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Project $project)
    {
        //
        $this->investor = $user;
        $this->project = $project;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $investor = $this->investor;
        $project = $this->project;
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $amount = $user->investments->last()->pivot->amount;
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.admin';
        $this->subject = $user->first_name.' '.$user->last_name.' has invested '.$amount.' in '.$project->title;
        $this->data = compact('project', 'investor');
        $mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, 'Estate Baron')->to($this->to)->subject($this->subject);
        });
    }
}
