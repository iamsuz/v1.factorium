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
use App\Transaction;
use App\Position;
use App\ProjectProg;
use App\Helpers\SiteConfigurationHelper;
use Illuminate\Mail\TransportManager;
use App\ProjectInterest;
use App\InvestmentRequest;
use App\ProjectEOI;
use App\ProspectusDownload;


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
        $investments = InvestmentInvestor::where('user_id', $user->id)
                        ->where('project_site', url())->get();
        return view('dashboard.users.investments', compact('user','color', 'investments'));
    }

//Disabled in routes as well due to no usage
/*    public function showProject($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        return view('dashboard.projects.show', compact('project', 'investments','color'));
    }*/

    public function projectInvestors($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        $shareInvestments = InvestmentInvestor::where('project_id', $project_id)
                    ->where('accepted', 1)
                    ->orderBy('share_certificate_issued_at','ASC')
                    ->get();
        $transactions = Transaction::where('project_id', $project_id)->get();
        $positions = Position::where('project_id', $project_id)->orderBy('effective_date', 'DESC')->get()->groupby('user_id');
        $projectsInterests = ProjectInterest::where('project_id', $project_id)->orderBy('created_at', 'DESC')->get();
        $projectsEois = ProjectEOI::where('project_id', $project_id)->orderBy('created_at', 'DESC')->get();
        // dd($positions);
        // dd($shareInvestments->last()->investingJoint);
        return view('dashboard.projects.investors', compact('project', 'investments','color', 'shareInvestments', 'transactions', 'positions', 'projectsInterests', 'projectsEois'));
    }

    public function editProject($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        if($project->is_coming_soon || $project->eoi_button == '1'){
            $project->active = 1;
            $project->save();
        }
        if($project->is_coming_soon && $project->is_coming_soon == '0' && !$project->projectspvdetail) {
            $project->active = 0;
            $project->save();
        }

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
            if($investment->project->share_vs_unit){
                $investment->share_certificate_path = "/app/invoices/Share-Certificate-".$investment->id.".pdf";
            }else{
                $investment->share_certificate_path = "/app/invoices/Share-Certificate-".$investment->id.".pdf";
            }
            $investment->save();
            // dd($investment);

            // Save details to transaction table
            $noOfShares = $shareEnd-$shareInit;
            $transactionRate = $investment->amount/$noOfShares;
            Transaction::create([
                'user_id' => $investment->user_id,
                'project_id' => $investment->project_id,
                'investment_investor_id' => $investment->id,
                'transaction_type' => 'BUY',
                'transaction_date' => Carbon::now(),
                'amount' => round($investment->amount,2),
                'rate' => round($transactionRate,2),
                'number_of_shares' => $noOfShares,
                ]);

            $investing = InvestingJoint::where('investment_investor_id', $investment->id)->get()->last();

            if($investment->accepted) {
                $pdf = PDF::loadView('pdf.invoice', ['investment' => $investment, 'shareInit' => $shareInit, 'investing' => $investing, 'shareStart' => $shareStart, 'shareEnd' => $shareEnd]);
                $pdf->setPaper('a4', 'landscape');
                if($investment->project->share_vs_unit) {
                    $pdf->save(storage_path().'/app/invoices/Share-Certificate-'.$investment->id.'.pdf');
                }else {
                    $pdf->save(storage_path().'/app/invoices/Unit-Certificate-'.$investment->id.'.pdf');
                }
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

        $shareInit = 0;
        if($investment->share_number){
            $shareNumber = explode('-', $investment->share_number);
            $shareInit = $shareNumber[0]-1; 
        }
        $shareStart = $shareInit+1;
        $shareEnd = $shareInit+(int)$investment->amount;
        $shareCount = (string)($shareStart)."-".(string)($shareEnd);
        
        // Save details to transaction table
        $noOfShares = $shareEnd-$shareInit;
        if($noOfShares == 0){
            $transactionRate = $investment->amount/1;    
        }
        else{
            $transactionRate = $investment->amount/$noOfShares;
        }
        // dd($transactionRate);
        Transaction::create([
            'user_id' => $investment->user_id,
            'project_id' => $investment->project_id,
            'investment_investor_id' => $investment->id,
            'transaction_type' => 'CANCELLED',
            'transaction_date' => Carbon::now(),
            'amount' => round($investment->amount,2),
            'rate' => round($transactionRate,2),
            'number_of_shares' => $noOfShares,
            ]);

        $investing = InvestingJoint::where('investment_investor_id', $investment->id)->get()->last();
        
        $mailer->sendInvestmentCancellationConfirmationToUser($investment, $shareInit, $investing, $shareStart, $shareEnd);

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Investment Successfully Cancelled</p>');
    }

    public function declareDividend(Request $request, AppMailer $mailer, $projectId)
    {
        if(!$request->start_date || !$request->end_date){
            return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Provide valid start date and end date</p>');
        }
        $investorList = $request->investors_list;
        $dividendPercent = $request->dividend_percent;
        $strStartDate = (string)$request->start_date;
        $startDate = date_create((string)$request->start_date);
        $strEndDate = (string)$request->end_date;
        $endDate = date_create((string)$request->end_date);
        $dateDiff = date_diff($startDate, $endDate);
        $dateDiff = (int)$dateDiff->format("%R%a");
        $project = Project::findOrFail($projectId);
        
        if($investorList != ''){
            if($dateDiff >=0){
                $investors = explode(',', $investorList);
                $investments = InvestmentInvestor::findMany($investors);

                // Add the records to project progress table
                ProjectProg::create([
                    'project_id' => $projectId,
                    'updated_date' => Carbon::now(),
                    'progress_description' => 'Dividend Declaration',
                    'progress_details' => 'A Dividend of '.$dividendPercent.'% annualized for the duration between '.date('m-d-Y', strtotime($request->start_date)).' and '.date('m-d-Y', strtotime($request->end_date)).' has been declared.'
                    ]);

                // send dividend email to admins
                $csvPath = $this->exportDividendCSV($investments, $dividendPercent, $dateDiff, $project);
                $mailer->sendDividendDistributionNotificationToAdmin($investments, $dividendPercent, $dateDiff, $csvPath, $project);
                
                // send dividend emails to investors
                $failedEmails = [];
                $subject = 'Dividend declared for '.$project->title;
                foreach ($investments as $investment) {
                    // Save details to transaction table
                    $dividendAmount = round($investment->amount * ((int)$dividendPercent/(365*100)) * $dateDiff, 2);
                    $shareNumber = explode('-', $investment->share_number);
                    $noOfShares = $shareNumber[1]-$shareNumber[0]+1;
                    Transaction::create([
                        'user_id' => $investment->user_id,
                        'project_id' => $investment->project_id,
                        'investment_investor_id' => $investment->id,
                        'transaction_type' => 'DIVIDEND',
                        'transaction_date' => Carbon::now(),
                        'amount' => $dividendAmount,
                        'rate' => $dividendPercent,
                        'number_of_shares' => $noOfShares,
                        ]);

                    $content = \View::make('emails.userDividendDistributioNotify', array('investment' => $investment, 'dividendPercent' => $dividendPercent, 'startDate' => $strStartDate, 'endDate' => $strEndDate, 'project' => $project));
                    $result = $this->queueEmailsUsingMailgun($investment->user->email, $subject, $content->render());
                    if($result->http_response_code != 200){
                        array_push($failedEmails, $investment->user->email);
                    }
                }
                if(empty($failedEmails)){
                    return redirect()->back()->withMessage('<p class="alert alert-success text-center">Dividend distribution have been mailed to Investors and admins</p>');
                }
                else{
                    $emails = '';
                    foreach ($failedEmails as $email) {
                        $emails = $emails.", $email";
                    }
                    return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Dividend distribution email sending failed for investors - '.$emails.'.</p>'); 
                }
            }
            else {
                return redirect()->back()->withMessage('<p class="alert alert-danger text-center">End date must be greater than start date.</p>');
            }
        }
    }

    public function declareRepurchase(Request $request, AppMailer $mailer, $projectId){
        $investorList = $request->investors_list;
        $repurchaseRate = $request->repurchase_rate;
        $project = Project::findOrFail($projectId);
        
        if($investorList != ''){
            $investors = explode(',', $investorList);
            $investments = InvestmentInvestor::findMany($investors);
            
            // Add the records to project progress table
            if($project->share_vs_unit) {
                ProjectProg::create([
                'project_id' => $projectId,
                'updated_date' => Carbon::now(),
                'progress_description' => 'Repurchase Declaration',
                'progress_details' => 'Shares Repurchased by company at $'.$repurchaseRate.' per share.'
                ]);
            }else {
                ProjectProg::create([
                'project_id' => $projectId,
                'updated_date' => Carbon::now(),
                'progress_description' => 'Repurchase Declaration',
                'progress_details' => 'Units Repurchased by company at $'.$repurchaseRate.' per unit.'
                ]);
            }

            // send dividend email to admins
            $csvPath = $this->exportRepurchaseCSV($investments, $repurchaseRate, $project);
            $mailer->sendRepurchaseNotificationToAdmin($investments, $repurchaseRate, $csvPath, $project);

            // send dividend emails to investors
            $failedEmails = [];
            if($project->share_vs_unit) {
                $subject = 'Shares for '.$project->title;
            }else {
                $subject = 'Units for '.$project->title;
            }
            foreach ($investments as $investment) {
                InvestmentInvestor::where('id', $investment->id)->update([
                    'is_cancelled' => 1,
                    'is_repurchased' => 1
                    ]);

                // Save details to transaction table
                $repurchaseAmount = round(($investment->amount * $repurchaseRate), 2);
                $shareNumber = explode('-', $investment->share_number);
                $noOfShares = $shareNumber[1]-$shareNumber[0]+1;
                Transaction::create([
                    'user_id' => $investment->user_id,
                    'project_id' => $investment->project_id,
                    'investment_investor_id' => $investment->id,
                    'transaction_type' => 'REPURCHASE',
                    'transaction_date' => Carbon::now(),
                    'amount' => $repurchaseAmount,
                    'rate' => $repurchaseRate,
                    'number_of_shares' => $noOfShares,
                    ]);

                $shareNumber = explode('-', $investment->share_number);
                $content = \View::make('emails.userRepurchaseNotify', array('investment' => $investment, 'repurchaseRate' => $repurchaseRate, 'project' => $project, 'shareNumber' => $shareNumber));
                $result = $this->queueEmailsUsingMailgun($investment->user->email, $subject, $content->render());
                if($result->http_response_code != 200){
                    array_push($failedEmails, $investment->user->email);
                }
            }
            if(empty($failedEmails)){
                return redirect()->back()->withMessage('<p class="alert alert-success text-center">Repurchase distribution have been mailed to Investors and admins</p>');
            }
            else{
                $emails = '';
                foreach ($failedEmails as $email) {
                    $emails = $emails.", $email";
                }
                return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Repurchase distribution email sending failed for investors - '.$emails.'.</p>'); 
            }
        }
    }

    public function exportDividendCSV($investments, $dividendPercent, $dateDiff, $project)
    {
        $csvPath = storage_path().'/app/dividend/dividend_distribution_'.time().'.csv';
        
        // create a file pointer connected to the output stream
        $file = fopen($csvPath, 'w');

        // Add column names to csv
        if($project->share_vs_unit) {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Share amount", "Number of days", "Rate", "Investor Dividend amount"));
        }else {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Unit amount", "Number of days", "Rate", "Investor Dividend amount"));
        }
        
        // data to add to the csv file
        foreach ($investments as $investment) {
            fputcsv($file, array(
                $investment->user->first_name.' '.$investment->user->last_name,
                $investment->investingJoint ? $investment->investingJoint->account_name : $investment->user->account_name,
                $investment->investingJoint ? $investment->investingJoint->bank_name : $investment->user->bank_name,
                $investment->investingJoint ? $investment->investingJoint->bsb : $investment->user->bsb,
                $investment->investingJoint ? $investment->investingJoint->account_number : $investment->user->account_number,
                $investment->amount,
                $dateDiff,
                $dividendPercent,
                round($investment->amount * ((int)$dividendPercent/(365*100)) * $dateDiff, 2)
            ));
        }

        // Close the file
        fclose($file);

        return $csvPath;
    }

    public function exportRepurchaseCSV($investments, $repurchaseRate, $project){
        $csvPath = storage_path().'/app/repurchase/repurchase_distribution_'.time().'.csv';
        
        // create a file pointer connected to the output stream
        $file = fopen($csvPath, 'w');

        // Add column names to csv
        if($project->share_vs_unit) {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Share amount", "Repurchase Rate", "Investor Repurchase amount"));
        }else {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Unit amount", "Repurchase Rate", "Investor Repurchase amount"));
        }
        
        // data to add to the csv file
        foreach ($investments as $investment) {
            fputcsv($file, array(
                $investment->user->first_name.' '.$investment->user->last_name,
                $investment->investingJoint ? $investment->investingJoint->account_name : $investment->user->account_name,
                $investment->investingJoint ? $investment->investingJoint->bank_name : $investment->user->bank_name,
                $investment->investingJoint ? $investment->investingJoint->bsb : $investment->user->bsb,
                $investment->investingJoint ? $investment->investingJoint->account_number : $investment->user->account_number,
                $investment->amount,
                $repurchaseRate,
                round($investment->amount * $repurchaseRate, 2)
            ));
        }

        // Close the file
        fclose($file);

        return $csvPath;
    }

    public function queueEmailsUsingMailgun($emailStr, $subject, $content, $attachments = [])
    {
        $this->overrideMailerConfig();
        if(filter_var(\Config::get('mail.sendmail'), FILTER_VALIDATE_EMAIL)){
            $fromMail = \Config::get('mail.sendmail');
        } else{
            $fromMail = 'info@estatebaron.com';
        }

        //Disable SSL Check
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        $adapter = new \Http\Adapter\Guzzle6\Client($client);

        # Instantiate the client.
        $mgClient = new Mailgun(env('MAILGUN_API_KEY'), $adapter);
        $domain = env('MAILGUN_DOMAIN');

        # Make the call to the client.
        $result = $mgClient->sendMessage($domain, 
            array(
                'from'    => $fromMail,
                'to'      => $emailStr,
                // 'bcc'     => 'info@estatebaron.com',
                'subject' => $subject,
                'html'    => $content
            ),
            array(
                'attachment' => $attachments
            )
        );

        return $result;
    }

    public function investmentStatement($projectId)
    {
        $investmentRecords = InvestmentInvestor::where('project_id', $projectId)
            ->where(function ($query) { $query->where('is_cancelled', 0)->where('is_repurchased', 0); })
            ->get()->groupby('user_id');
        foreach ($investmentRecords as $userId => $investments) {
            $UserShares = 0;
            foreach ($investments as $key => $investment) {
                if($investment->accepted && $investment->share_number){
                    $shareNumber = explode('-', $investment->share_number);
                    $noOfShares = $shareNumber[1]-$shareNumber[0]+1;
                    $UserShares += $noOfShares;
                }
            }
            // dd($UserShares);
            Position::create([
                'user_id' => $userId,
                'project_id' => $projectId,
                'effective_date' => Carbon::now(),
                'number_of_shares' => $UserShares,
                'current_value' => $UserShares * 1
                ]);
        }
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Latest Investor Statement is successfully generated.<br>You can view it in Position records tab.</p>');
    }

    public function sendInvestmentStatement($projectId)
    {
        $positions = Position::where('project_id', $projectId)->orderBy('effective_date', 'DESC')->get()->groupby('user_id');
        $failedEmails = [];
        foreach ($positions as $userId => $value) {
            $position = $value->first();
            $transactions = Transaction::where('project_id', $projectId)->where('user_id', $userId)->orderBy('transaction_date', 'ASC')->get();
            $project = Project::where('id', $projectId)->first();

            // Create PDF of Investor Statement
            $pdfPath = storage_path().'/app/investorStatement/investor-statement-'.$userId.'-'.time().'.pdf';
            $pdf = PDF::loadView('pdf.investorStatement', ['project' => $project, 'position' => $position, 'transactions' => $transactions]);
            $pdf->setPaper('a4', 'portrait');
            $pdf->save($pdfPath);

            // Send Investor Statement mail to investors
            $projectName = $project->projectspvdetail ? $project->projectspvdetail->spv_name : $project->title;
            $subject = 'Investor statement for '.$position->user->first_name.' '.$position->user->last_name.' for '.$projectName;
            $content = \View::make('emails.investorStatement', array('project' => $project, 'position' => $position));
            $attachments = array($pdfPath);
            $result = $this->queueEmailsUsingMailgun($position->user->email, $subject, $content->render(), $attachments);
            if($result->http_response_code != 200){
                array_push($failedEmails, $position->user->email);
            }
        }
        if(empty($failedEmails)){
            return redirect()->back()->withMessage('<p class="alert alert-success text-center">Investor Statement have been successfully mailed to Investors</p>');
        }
        else{
            $emails = '';
            foreach ($failedEmails as $email) {
                $emails = $emails.", $email";
            }
            return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Investor Statement email sending failed for investors - '.$emails.'.</p>'); 
        }
    }

    public function overrideMailerConfig()
    {
        $siteconfig = SiteConfigurationHelper::getConfigurationAttr();
        $config = $siteconfig->mailSetting()->first();
        if($config){
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
            \Mail::setSwiftMailer($mailer);
        }
    }

    public function applicationForm($investment_id)
    {
        $investment = InvestmentInvestor::find($investment_id);
        // dd($investment);
        if($investment->application_path){
            $filename = $investment->application_path;
            $path = storage_path($filename);

            return \Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }
        else {
            $project = Project::find($investment->project_id);
            $user = User::findOrFail($investment->user_id);
            // dd($user);

            // Create PDF of Application form
            $pdfBasePath = '/app/application/application-'.$investment->id.'-'.time().'.pdf';
            $pdfPath = storage_path().$pdfBasePath;
            $pdf = PDF::loadView('pdf.application', ['project' => $project, 'investment' => $investment, 'user' => $user]);
            $pdf->setPaper('a4', 'portrait');
            $pdf->setWarnings(false);
            $saveResult = $pdf->save($pdfPath);
            $investment->application_path = $pdfBasePath;
            $investment->save();

            if($saveResult){
                return \Response::make(file_get_contents($pdfPath), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$pdfBasePath.'"'
                ]);
            }
        }
    }

    /**
     * Show list of all Investment form filling requests which are pending
     */
    public function investmentRequests()
    {
        $investmentRequests = InvestmentRequest::where('is_link_expired', 0)
                            ->whereRaw('investment_requests.project_id IN (select id from projects where project_site="'.url().'")')
                            ->get();

        $color = Color::where('project_site',url())->first();
        return view('dashboard.requests.requests', compact('investmentRequests', 'color'));
    }

    /**
     * Returns the list of all the users downloaded prospectus
     */
    public function prospectusDownloads()
    {
        $prospectusDownloads = ProspectusDownload::where('project_site', url())
                            ->orderBy('created_at','DESC')
                            ->get();
        $color = Color::where('project_site',url())->first();
        return view('dashboard.prospectusDownloads', compact('prospectusDownloads', 'color'));
    }
}
