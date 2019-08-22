<?php

namespace App\Jobs;

use App\Jobs\Job;
use Mail;
use App\Role;
use App\User;
use App\Project;
use App\UserRegistration;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\TransportManager;
use App\Helpers\SiteConfigurationHelper;
use Swift_MailTransport as MailTransport;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\InvestmentInvestor;

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
    protected $investment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Project $project, InvestmentInvestor $investor)
    {
        //
        $this->investor = $user;
        $this->project = $project;
        $this->investment = $investor;
    }

    public function overrideMailerConfig()
    {
        $siteconfig = SiteConfigurationHelper::getConfigurationAttr();
        $config = $siteconfig->mailSetting()->first();
        // Config::set('mail.driver',$configs['driver']);
        \Config::set('mail.host',$config->host);
        \Config::set('mail.port',$config->port);
        \Config::set('mail.username',$config->username);
        \Config::set('mail.password',$config->password);
        \Config::set('mail.sendmail',$config->from);
        $this->from = $config->from;
        $app = \App::getInstance();
        $app['swift.transport'] = $app->share(function ($app) {
           return new TransportManager($app);
       });

        $mailer = new \Swift_Mailer($app['swift.transport']->driver());
        Mail::setSwiftMailer($mailer);
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $siteconfig = SiteConfigurationHelper::getConfigurationAttr();
        $config = $siteconfig->mailSetting()->first();
        if($config){
            $this->overrideMailerConfig();
        }
        $user = $this->investor;
        $amount = $user->investments->last()->pivot->amount;
        $investment = $user->investments->last()->pivot;
        $project = $this->project;
        $this->to = $user->email;
        $this->view = 'emails.interest';
        $this->subject = 'Thank you for purchasing receivable '.$project->title;
        $this->data = compact('user', 'project','amount','investment');

        $mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron')->to($this->to)->subject($this->subject);
        });

    }
}
