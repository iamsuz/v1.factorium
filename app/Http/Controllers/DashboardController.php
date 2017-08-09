<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Color;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Investment;
use App\InvestmentInvestor;
use App\InvestingJoint;
use App\Invite;
use App\Mailers\AppMailer;
use App\Note;
use App\Project;
use App\User;
use Carbon\Carbon;
use Chumper\Datatable\Datatable;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\SiteConfiguration;
use Session;
use Mailgun\Mailgun;

class DashboardController extends Controller
{
    /**
     * constructor for DashboardController
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $color = Color::where('project_site',url())->first();
        $users = User::where('registration_site',url());
        $projects = Project::all();
        $projects = $projects->where('project_site',url());
        $notes = Note::all();
        $total_goal = Investment::all()->where('project_site',url())->sum('goal_amount');
        $pledged_investments = InvestmentInvestor::all()->where('project_site',url());
        return view('dashboard.index', compact('users', 'projects', 'pledged_investments', 'total_goal', 'notes','color'));
    }

    public function users()
    {
        $color = Color::where('project_site',url())->first();
        $users = User::all()->where('registration_site',url());
        return view('dashboard.users.index', compact('users','color'));
    }

    public function projects()
    {
        $color = Color::where('project_site',url())->first();
        $projects = Project::all();
        $projects = $projects->where('project_site',url());
        $pledged_investments = InvestmentInvestor::all();
        return view('dashboard.projects.index', compact('projects', 'pledged_investments','color'));
    }

    public function getDashboardUsers()
    {
        $datatable = new Datatable();
        return $datatable->collection(User::all())
        ->showColumns('id', 'first_name', 'last_name', 'phone_number','email')
        ->searchColumns('first_name')
        ->orderColumns('id','first_name')
        ->make();

    }

    public function getDashboardProjects()
    {
        $datatable = new Datatable();
        return $datatable->collection(Project::all())
        ->showColumns('id', 'title', 'active', 'description')
        ->searchColumns('title', 'description')
        ->orderColumns('id','title', 'active')
        ->make();
    }

    public function showUser($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        return view('dashboard.users.show', compact('user','color'));
    }

    public function usersInvestments($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        return view('dashboard.users.investments', compact('user','color'));
    }

    public function showProject($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        return view('dashboard.projects.show', compact('project', 'investments','color'));
    }

    public function projectInvestors($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        $shareInvestments = InvestmentInvestor::where('project_id', $project_id)
                    ->where('accepted', 1)
                    ->orderBy('share_certificate_issued_at','ASC')
                    ->get();
        // dd($shareInvestments->last()->investingJoint);
        return view('dashboard.projects.investors', compact('project', 'investments','color', 'shareInvestments'));
    }

    public function editProject($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        return view('dashboard.projects.edit', compact('project', 'investments','color'));
    }

    public function activateUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $status = $user->update(['active'=> 1, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function deactivateUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $status = $user->update(['active'=> 0, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function verification($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        return view('dashboard.users.verification', compact('user','color'));
    }

    public function verifyId(Request $request, AppMailer $mailer, $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->update(['verify_id'=>$request->status]);
        $user->idImage()->get()->last()->update(['verify_id'=>$request->status, 'fixing_message'=>$request->fixing_message, 'fixing_message_for_id'=>$request->fixing_message_for_id]);
        $idimages = $user->idImage()->get()->last();
        if($request->status == '2') {
            $invitee = Invite::whereEmail($user->email)->first();
            if($invitee) {
                Credit::create(['user_id'=>$invitee->user_id, 'invite_id'=>$invitee->id, 'amount'=>50, 'type'=>'User Confirmed by Admin']);
            }
            $message = '<p class="alert alert-success text-center">User has been verified successfully and a notification has been sent.</p>';
        } else {
            $message = '<p class="alert alert-warning text-center">User has to try again.</p>';
        }
        $mailer->sendVerificationNotificationToUser($user, $request->status, $idimages);
        return redirect()->back()->withMessage($message);
    }

    public function privateProject($project_id)
    {
        $project = Project::findOrFail($project_id);
        $status = $project->update(['active'=> 2, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function toggleStatus(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $status = $project->update(['active'=> $request->active, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function updateInvestment(Request $request, $investment_id)
    {
        $this->validate($request, [
            'investor' => 'required',
            'amount' => 'required|numeric',
            ]);

        $investment = InvestmentInvestor::findOrFail($investment_id);
        $investment->amount = $request->amount;
        $investment->save();

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully updated.</p>');

    }

    public function acceptInvestment(Request $request, AppMailer $mailer, $investment_id)
    {
        $this->validate($request, [
            'investor' => 'required',
            ]);

        $investment = InvestmentInvestor::findOrFail($investment_id);

        if($investment){
            $investmentShares = InvestmentInvestor::where('project_id', $investment->project_id)
                            ->where('accepted', 1)
                            ->orderBy('share_certificate_issued_at','DESC')->get()
                            ->first();
            $shareInit = 0;
            if($investmentShares){
                if($investmentShares->share_number){
                    $shareNumber = explode('-', $investmentShares->share_number);
                    $shareInit = $shareNumber[1]; 
                }
            }
            $shareStart = $shareInit+1;
            $shareEnd = $shareInit+$investment->amount;
            $shareCount = (string)($shareStart)."-".(string)($shareEnd);

            //Update current investment and with the share certificate details
            $investment->accepted = 1;
            $investment->money_received = 1;
            $investment->share_certificate_issued_at = Carbon::now();
            $investment->share_number = $shareCount;
            $investment->share_certificate_path = "/app/invoices/Share-Certificate-".$investment->id.".pdf";
            $investment->save();
            // dd($investment);

            $investing = InvestingJoint::where('investment_investor_id', $investment->id)->get()->last();

            if($investment->accepted) {
                $pdf = PDF::loadView('pdf.invoice', ['investment' => $investment, 'shareInit' => $shareInit, 'investing' => $investing, 'shareStart' => $shareStart, 'shareEnd' => $shareEnd]);
                $pdf->setPaper('a4', 'landscape');
                $pdf->save(storage_path().'/app/invoices/Share-Certificate-'.$investment->id.'.pdf');
                $mailer->sendInvoiceToUser($investment);
                $mailer->sendInvoiceToAdmin($investment);
            }
            return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully updated.</p>');
        }
    }

    public function activateProject($project_id)
    {
        $project = Project::findOrFail($project_id);
        $status = $project->update(['active'=> 1, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function deactivateProject($project_id)
    {
        $project = Project::findOrFail($project_id);
        $status = $project->update(['active'=> 0, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        return view('dashboard.users.edit', compact('user','color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function siteConfigurations()
    {
        $color = Color::where('project_site',url())->first();
        $siteconfiguration = SiteConfiguration::where('project_site',url())->first();
        $mail_setting = $siteconfiguration->mailSetting;
        return view('dashboard.configuration.siteConfiguration',compact('color','siteconfiguration','mail_setting'));
    }

    public function investmentMoneyReceived(Request $request, AppMailer $mailer, $investment_id)
    {
        $investment = InvestmentInvestor::findOrFail($investment_id);
        $investment->money_received = 1;
        $investment->save();

        if($investment->money_received) {
            $mailer->sendMoneyReceivedConfirmationToUser($investment);
        }

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully updated.</p>');

    }

    public function investmentReminder(AppMailer $mailer, $investment_id){
        $investment = InvestmentInvestor::findOrFail($investment_id);
        $mailer->sendInvestmentReminderToUser($investment);
        Session::flash('action', $investment->id);
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Reminder sent</p>');        
    }

    public function investmentConfirmation(Request $request, AppMailer $mailer, $investment_id){
        $investment = InvestmentInvestor::findOrFail($investment_id);
        $investment->investment_confirmation = $request->investment_confirmation;
        $investment->save();
        $mailer->sendInvestmentConfirmationToUser($investment);
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Investment Successfully Confirmed</p>');        
    }
    
    public function createBroadcastMailForm(){
        $color = Color::where('project_site',url())->first();
        $siteUsers = User::where('registration_site', url())->get();
        $siteconfiguration = SiteConfiguration::where('project_site',url())->first();
        return view('dashboard.broadcast.broadcastmail',compact('color','siteconfiguration', 'siteUsers'));
    }

    public function sendBroadcastMail(Request $request)
    {
        $this->validate($request, [
            'mail_subject' => 'required',
        ]);

        $subject = $request->mail_subject;
        $content = $request->mail_content;
        $emailStr = $request->email_string;
        
        //Disable SSL Check
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        $adapter = new \Http\Adapter\Guzzle6\Client($client);

        # Instantiate the client.
        $mgClient = new Mailgun(env('MAILGUN_API_KEY'), $adapter);
        $domain = env('MAILGUN_DOMAIN');

        # Make the call to the client.
        $result = $mgClient->sendMessage($domain, array(
            'from'    => 'info@estatebaron.com',
            'to'      => 'info@estatebaron.com',
            'bcc'     => $emailStr,
            'subject' => $subject,
            'html'    => $content
        ));
        if($result->http_response_code == 200){
            Session::flash('message', '<div class="row text-center" style="padding: 12px;border-radius: 8px;background-color: #EEFBF3;">Emails Queued Successfully</div>');
        }
        else{
            Session::flash('message', '<div class="row text-center" style="background-color:#FAEBD7;padding: 12px;border-radius: 8px;">'.$result->http_response_body->message."</div>");
        }
        return redirect()->back();
    }

    public function investmentCancel($investment_id, AppMailer $mailer)
    {
        $investment = InvestmentInvestor::findOrFail($investment_id);
        $investment->is_cancelled = 1;
        $investment->save();

        $investmentShares = InvestmentInvestor::where('project_id', $investment->project_id)
                            ->where('accepted', 1)
                            ->orderBy('share_certificate_issued_at','DESC')->get()
                            ->first();
        $shareInit = 0;
        if($investmentShares){
            if($investmentShares->share_number){
                $shareNumber = explode('-', $investmentShares->share_number);
                $shareInit = $shareNumber[1]; 
            }
        }
        $shareStart = $shareInit+1;
        $shareEnd = $shareInit+$investment->amount;
        $shareCount = (string)($shareStart)."-".(string)($shareEnd);

        $investing = InvestingJoint::where('investment_investor_id', $investment->id)->get()->last();
        
        $mailer->sendInvestmentCancellationConfirmationToUser($investment, $shareInit, $investing, $shareStart, $shareEnd);

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Investment Successfully Cancelled</p>');
    }
}
