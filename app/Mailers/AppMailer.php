<?php

namespace App\Mailers;

use Mail;
use App\Role;
use App\User;
use App\Project;
use App\UserRegistration;
use Illuminate\Contracts\Mail\Mailer;
use App\Helpers\SiteConfigurationHelper;

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

    public function sendRegistrationNotificationAdmin(User $investor)
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
        $this->data = compact('investor');

        $this->deliver();
    }

    public function sendRegistrationNotificationAdminOther(User $investor)
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
        $this->data = compact('investor');

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

    public function sendVerificationNotificationToUser(User $user, $status)
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
        $this->data = compact('user', 'status');

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
        $this->subject = 'Share certificate for '.$investment->project->title;
        $this->data = compact('investment');
        $this->pathToFile = storage_path().'/app/invoices/Share-Certificate-'.$investment->id.'.pdf';

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
        $this->subject = 'Share certificate for '.$investment->project->title.' for '.$investment->user->first_name.' '.$investment->user->last_name;
        $this->data = compact('investment');
        $this->pathToFile = storage_path().'/app/invoices/Share-Certificate-'.$investment->id.'.pdf';

        $this->deliverWithFile();
    }

    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron')->to($this->to)->subject($this->subject);
        });
    }

    public function deliverWithFile()
    {
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, ($titleName=SiteConfigurationHelper::getConfigurationAttr()->title_text) ? $titleName : 'Estate Baron')->to($this->to)->subject($this->subject)->attach($this->pathToFile);
        });
    }
}