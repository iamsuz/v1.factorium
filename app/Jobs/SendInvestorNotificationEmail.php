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

class SendInvestorNotificationEmail extends Job implements SelfHandling, ShouldQueue
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
        //
        $user = $this->investor;
        $amount = $user->investments->last()->pivot->amount;
        $project = $this->project;
        $this->to = $user->email;
        $this->view = 'emails.interest';
        $this->subject = 'Thank you for investing in '.$project->title;
        $this->data = compact('user', 'project','amount');

        $mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, 'Estate Baron')->to($this->to)->subject($this->subject);
        });

    }
}
