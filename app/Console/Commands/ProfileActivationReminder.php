<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserRegistration;
use App\Mailers\AppMailer;

class ProfileActivationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activation:reminder';

    /**
     * The Mailer service.
     *
     * @var AppMailer
     */
    protected $mailer;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send profile activation reminder emails to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AppMailer $mailer)
    {
        parent::__construct();

        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = UserRegistration::where('email_attempts', '<', 3)->get();
        foreach ($users as $key => $user) {
            $this->mailer->sendUserOnboardingReminderEmail($user);
            $attempts = $user->email_attempts + 1;
            $user->update(['email_attempts' => $attempts]);
        }
    }
}
