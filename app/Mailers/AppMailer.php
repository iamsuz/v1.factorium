<?php

namespace App\Mailers;

use Mail;
use App\Role;
use App\User;
use App\Project;
use App\IdImage;
use App\MailSetting;
use App\UserRegistration;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\TransportManager;
use App\Helpers\SiteConfigurationHelper;
use Swift_MailTransport as MailTransport;

class AppMailer
{
    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    protected $mailer;
    protected $from = 'info@estatebaron.com';
    protected $to;
    protected $bcc;
    protected $view;
    protected $subject;
    protected $pathToFile;
    protected $data = [];

    public function recommendTo($email, Article $article)
    {
        Mail::queue('emails.article', ['article' => $article], function ($message) use ($email) {
            $message->to($email)->subject('Recommendation');
        });
    }

    public function sendEmailConfirmationTo(User $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.confirm';
        $siteTitle = ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron';
        $this->subject = 'Please complete your registration on '.$siteTitle;
        $this->data = compact('user');

        $this->deliver();
    }

    public function sendRegistrationConfirmationTo(UserRegistration $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.registrationConfirm';
        $siteTitle = ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron';
        $this->subject = 'Please complete your registration on '.$siteTitle;
        $this->data = compact('user');

        $this->deliver();
    }

    public function sendInterestNotificationInvestor(User $user, Project $project)
    {
        $this->to = $user->email;
        $this->view = 'emails.interest';
        $this->subject = 'Application Received for '.$project->title;
        $this->data = compact('user', 'project');

        $this->deliver();
    }

    public function sendInterestNotificationDeveloper(Project $project, User $investor)
    {
        $this->to = $project->user->email;
        $this->view = 'emails.developer';
        $this->subject = 'Application Received for '.$project->title;
        $this->data = compact('project', 'investor');

        $this->deliver();
    }

    public function sendRegistrationNotificationAdmin(User $investor,$referrer)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.regNotification';
        $this->subject = 'New User Sign Up '.$investor->first_name.' '.$investor->last_name.' '.$investor->phone_number;
        $this->data = compact('investor','referrer');

        $this->deliver();
    }

    public function sendRegistrationNotificationAdminOther(User $investor,$referrer)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.regNotificationOther';
        $this->subject = 'New User Sign Up '.$investor->first_name.' '.$investor->last_name.' '.$investor->phone_number;
        $this->data = compact('investor','referrer');

        $this->deliver();
    }

    public function sendInterestNotificationAdmin(Project $project, User $investor)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.admin';
        $this->subject = 'Application Received for '.$project->title;
        $this->data = compact('project', 'investor');

        $this->deliver();
    }

    public function sendSubdivideEmailToAdmin($details)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.subdivide';
        $this->subject = 'Received a subdivide request';
        $this->data = compact('details');

        $this->deliver();
    }
    public function sendProjectSubmit(User $investor, Project $project)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.projectSubmit';
        $this->subject = 'New Project Submitted';
        $this->data = compact('investor', 'project');

        $this->deliver();
    }

    public function sendIdVerificationEmailToAdmin($details)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.idVerification';
        $this->subject = 'Received an verification request';
        $this->data = compact('details');

        $this->deliver();
    }

    public function sendVerificationNotificationToUser(User $user, $status, IdImage $idimages)
    {
        $this->to = $user->email;
        $this->view = 'emails.verifyNotification';
        if($status == '1')
        {
            $this->subject = 'Verification Status';
        }
        elseif ($status == '-1') {
            $this->subject = 'Verification Unsuccessful';
        }
        else{
            $this->subject = 'Verification Successful';
        }
        $this->data = compact('user', 'status', 'idimages');

        $this->deliver();
    }

    public function sendInviteToUser($email, User $user, $token)
    {
        $this->to = $email;
        $this->view = 'emails.invitation';
        $siteTitle = ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron';
        $this->subject = 'You have been invited to '.$siteTitle.' by '.$user->first_name;
        $this->data = compact('user', 'token');

        $this->deliver();
    }

    public function sendInvoiceToUser($investment)
    {
        $this->to = $investment->user->email;
        $this->view = 'emails.invoice';

        if($investment->project->share_vs_unit) {
            $this->subject = 'Share certificate for '.$investment->project->title;
        }else {
            $this->subject = 'Unit certificate for '.$investment->project->title;

        }
        $this->data = compact('investment');

        if($investment->project->share_vs_unit) {
            $this->pathToFile = storage_path().'/app/invoices/Share-Certificate-'.$investment->id.'.pdf';
        }else {
            $this->pathToFile = storage_path().'/app/invoices/Unit-Certificate-'.$investment->id.'.pdf';

        }

        $this->deliverWithFile();
    }

    public function sendInvoiceToAdmin($investment)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.adminInvoice';
        if($investment->project->share_vs_unit) {
            $this->subject = 'Share certificate for '.$investment->project->title.' for '.$investment->user->first_name.' '.$investment->user->last_name;
        }else {
            $this->subject = 'Unit certificate for '.$investment->project->title.' for '.$investment->user->first_name.' '.$investment->user->last_name;
        }
        $this->data = compact('investment');
        if($investment->project->share_vs_unit) {
            $this->pathToFile = storage_path().'/app/invoices/Share-Certificate-'.$investment->id.'.pdf';
        }else {
            $this->pathToFile = storage_path().'/app/invoices/Unit-Certificate-'.$investment->id.'.pdf';

        }
        $this->deliverWithFile();
    }

    public function sendMoneyReceivedConfirmationToUser($investment)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->to = $investment->user->email;
        $this->bcc = $recipients;
        $this->view = 'emails.moneyReceivedConfirm';
        $this->subject = 'Funds received for '.$investment->project->title;
        $this->data = compact('investment');
        
        $this->deliverWithBcc();
    }

    public function sendInvestmentReminderToUser($investment)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->to = $investment->user->email;
        $this->bcc = $recipients;
        $this->view = 'emails.investmentReminder';
        $this->subject = 'Investment Reminder for '.$investment->project->title;
        $this->data = compact('investment');
        
        $this->deliverWithBcc();   
    }
    public function sendInvestmentConfirmationToUser($investment)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->to = $investment->user->email;
        $this->bcc = $recipients;
        $this->view = 'emails.investmentConfirmation';
        $this->subject = 'Investment Confirmed for '.$investment->project->title;
        $this->data = compact('investment');

        $this->deliverWithBcc();
    }

    public function sendUpcomingProjectInterestMailToAdmins($project, $email, $phone)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->bcc = 'abhi.mahavarkar@gmail.com';
        $this->to = $recipients;
        $this->view = 'emails.upcomingProjectInterestNotification';
        $this->subject = 'User Expressed Interest in '.$project->title;
        $this->data = compact('project', 'email', 'phone');
        
        $this->deliver();
    }

    public function sendInvestmentCancellationConfirmationToUser($investment, $shareInit, $investing, $shareStart, $shareEnd)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->to = $investment->user->email;
        $this->bcc = $recipients;
        $this->view = 'emails.investmentCancelNotification';
        $this->subject = 'Your investment in '.$investment->project->title.' has been cancelled';
        $this->data = compact('investment', 'shareInit', 'investing','shareStart', 'shareEnd');
        $this->deliverWithBcc();
    }

    public function sendDividendDistributionNotificationToAdmin($investments, $dividendPercent, $dateDiff, $csvPath, $project)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->to = $recipients;
        $this->view = 'emails.adminDividendDistributioNotify';
        $this->subject = 'Distribute dividend amount to investors';
        $this->data = compact('investments', 'dividendPercent', 'dateDiff', 'project');
        $this->pathToFile = $csvPath;

        $this->deliverWithFile();
    }

    public function sendRepurchaseNotificationToAdmin($investments, $repurchaseRate, $csvPath, $project)
    {
        $role = Role::findOrFail(1);
        $recipients = ['info@estatebaron.com'];
        foreach ($role->users as $user) {
            if($user->registration_site == url()){
                array_push($recipients, $user->email);
            }
        }
        $this->to = $recipients;
        $this->view = 'emails.adminRepurchaseNotify';
        if($project->share_vs_unit) {
            $this->subject = 'Shares Repurchase';
        } else {
            $this->subject = 'Units Repurchase';
        }
        $this->data = compact('investments', 'repurchaseRate', 'project');
        $this->pathToFile = $csvPath;

        $this->deliverWithFile();
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
        $app = \App::getInstance();
        $app['swift.transport'] = $app->share(function ($app) {
           return new TransportManager($app);
       });

        $mailer = new \Swift_Mailer($app['swift.transport']->driver());
        Mail::setSwiftMailer($mailer);
    }

    public function deliver()
    {
        $siteconfig = SiteConfigurationHelper::getConfigurationAttr();
        $config = $siteconfig->mailSetting()->first();
        if($config){
            $this->overrideMailerConfig();
        }
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron')->to($this->to)->subject($this->subject);
        });
    }

    public function deliverWithFile()
    {
        $siteconfig = SiteConfigurationHelper::getConfigurationAttr();
        $config = $siteconfig->mailSetting()->first();
        if($config){
            $this->overrideMailerConfig();
        }
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron')->to($this->to)->subject($this->subject)->attach($this->pathToFile);
        });
    }

    public function deliverWithBcc()
    {
        $siteconfig = SiteConfigurationHelper::getConfigurationAttr();
        $config = $siteconfig->mailSetting()->first();
        if($config){
            $this->overrideMailerConfig();
        }
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron')->to($this->to)->bcc($this->bcc)->subject($this->subject);
        });
    }
}