<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use Validator;
use App\Project;
use App\Http\Requests;
use App\InvestingJoint;
use App\ProjectSpvDetail;
use App\Mailers\AppMailer;
use App\InvestmentInvestor;
use App\UserInvestmentDocument;
use App\WholesaleInvestment;
use App\InvestmentRequest;
use App\Color;
use Illuminate\Http\Request;
use App\Jobs\SendReminderEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Jobs\SendInvestorNotificationEmail;
use App\Jobs\SendDeveloperNotificationEmail;
use Barryvdh\DomPDF\Facade as PDF;


class OfferController extends Controller
{
    protected $form_session = 'submit_form';

    /**
     * constructor for OfferController
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['requestForm', 'cancelRequestForm']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
      $request = new Request(array_except($request->all(),['password']));
      
        $project = Project::findOrFail($request->project_id);
        $min_amount_invest = $project->investment->minimum_accepted_amount;
        if((int)$request->amount_to_invest < (int)$min_amount_invest)
        {
            return redirect()->back()->withErrors(['The amount to invest must be at least '.$min_amount_invest]);
        }
        if((int)$request->amount_to_invest % 100 != 0)
        {
            return redirect()->back()->withErrors(['Please enter amount in increments of $100 only']);
        }
        $validation_rules = array(
            'amount_to_invest'   => 'required|integer',
            'line_1' => 'required',
            'state' => 'required',
            'postal_code' => 'required'
        );
        $validator = Validator::make($request->all(), $validation_rules);

        // Return back to form w/ validation errors & session data as input
        if($validator->fails()) {
            return  redirect()->back()->withErrors($validator);
        }
        $user = Auth::user();

        // If application store request received from request form
        if($request->investment_request_id)
        {
            $investmentRequest = InvestmentRequest::find($request->investment_request_id);
            if($investmentRequest) {
                if(\App\Helpers\SiteConfigurationHelper::isSiteAdmin()){
                    if($investmentRequest->project->project_site == url()) {
                        $user = User::find($investmentRequest->user_id);
                        $project = Project::find($investmentRequest->project_id);
                    }
                    else{
                        return redirect()->back()->withErrors('Not Project Admin');
                    }
                }
                else{
                    return redirect()->back()->withErrors('Not Site Admin');
                }
            }
            else {
                return redirect()->back()->withErrors('Something went wrong');
            }
        }

        $amount = floatval(str_replace(',', '', str_replace('A$ ', '', $request->amount_to_invest)));
        $amount_5 = $amount*0.05; //5 percent of investment
        if($user->idDoc != NULL){
            $investingAs = $user->idDoc->get()->last()->investing_as;
        }else{
            $investingAs = $request->investing_as;
        }
        $user->investments()->attach($project, ['investment_id'=>$project->investment->id,'amount'=>$amount,'project_site'=>url(),'investing_as'=>$investingAs, 'signature_data'=>$request->signature_data, 'interested_to_buy'=>$request->interested_to_buy,'signature_data_type'=>$request->signature_data_type,'signature_type'=>$request->signature_type]);
        $investor = InvestmentInvestor::get()->last();
        if($user->idDoc != NULL && $user->idDoc->investing_as != 'Individual Investor'){
            $investing_joint = new InvestingJoint;
            $investing_joint->project_id = $project->id;
            $investing_joint->investment_investor_id = $investor->id;
            $investing_joint->joint_investor_first_name = $user->idDoc->joint_first_name;
            $investing_joint->joint_investor_last_name = $user->idDoc->joint_last_name;
            $investing_joint->investing_company = $user->idDoc->trust_or_company;
            $investing_joint->account_name = $request->account_name;
            $investing_joint->bsb = $request->bsb;
            $investing_joint->account_number = $request->account_number;
            $investing_joint->line_1 = $request->line_1;
            $investing_joint->line_2 = $request->line_2;
            $investing_joint->city = $request->city;
            $investing_joint->state = $request->state;
            $investing_joint->postal_code = $request->postal_code;
            $investing_joint->country = $request->country;
            $investing_joint->country_code = $request->country_code;
            $investing_joint->tfn = $request->tfn;
            $investing_joint->save();
        }elseif($request->investing_as != 'Individual Investor'){
          $investing_joint = new InvestingJoint;
            $investing_joint->project_id = $project->id;
            $investing_joint->investment_investor_id = $investor->id;
            $investing_joint->joint_investor_first_name = $request->joint_investor_first;
            $investing_joint->joint_investor_last_name = $request->joint_investor_last;
            $investing_joint->investing_company = $request->investing_company_name;
            $investing_joint->account_name = $request->account_name;
            $investing_joint->bsb = $request->bsb;
            $investing_joint->account_number = $request->account_number;
            $investing_joint->line_1 = $request->line_1;
            $investing_joint->line_2 = $request->line_2;
            $investing_joint->city = $request->city;
            $investing_joint->state = $request->state;
            $investing_joint->postal_code = $request->postal_code;
            $investing_joint->country = $request->country;
            $investing_joint->country_code = $request->country_code;
            $investing_joint->tfn = $request->tfn;
            $investing_joint->save();
        }
        else{
            $user->update($request->all());
        }
        $investor_joint = InvestingJoint::get()->last();
        if($user->idDoc != NULL && $user->idDoc->investing_as == 'Joint Investor'){
            // dd($user->idDoc->joint_id_filename);
            $user_investment_doc = new UserInvestmentDocument(['type'=>'joint_investor', 'filename'=>$user->idDoc->joint_id_filename, 'path'=>$user->idDoc->joint_id_path,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$user->idDoc->joint_id_extension,'user_id'=>$user->id]);
            $project->investmentDocuments()->save($user_investment_doc);
            $user_ind_investment_doc = new UserInvestmentDocument(['type'=>'normal_name', 'filename'=>$user->idDoc->filename, 'path'=>$user->idDoc->path,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$user->idDoc->extension,'user_id'=>$user->id]);
            $project->investmentDocuments()->save($user_ind_investment_doc);
        }
        if($user->idDoc != NULL && $user->idDoc->investing_as == 'Individual Investor'){
            $user_investment_doc = new UserInvestmentDocument(['type'=>'normal_name', 'filename'=>$user->idDoc->filename, 'path'=>$user->idDoc->path,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$user->idDoc->extension,'user_id'=>$user->id]);
            $project->investmentDocuments()->save($user_investment_doc);
        }
        if($user->idDoc != NULL && $user->idDoc->investing_as == 'Trust or Company'){
            $user_investment_doc = new UserInvestmentDocument(['type'=>'trust_or_company', 'filename'=>$user->idDoc->filename, 'path'=>$user->idDoc->path,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$user->idDoc->extension,'user_id'=>$user->id]);
            $project->investmentDocuments()->save($user_investment_doc);
        }
        if($request->hasFile('joint_investor_id_doc'))
        {
            $destinationPath = 'assets/users/'.$user->id.'/investments/'.$investor->id.'/'.$request->joint_investor_first.'_'.$request->joint_investor_last.'/';
            $filename = $request->file('joint_investor_id_doc')->getClientOriginalName();
            $fileExtension = $request->file('joint_investor_id_doc')->getClientOriginalExtension();
            $request->file('joint_investor_id_doc')->move($destinationPath, $filename);
            $user_investment_doc = new UserInvestmentDocument(['type'=>'joint_investor', 'filename'=>$filename, 'path'=>$destinationPath.$filename,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$fileExtension,'user_id'=>$user->id]);
            $project->investmentDocuments()->save($user_investment_doc);
        }
        if($request->hasFile('trust_or_company_docs'))
        {
            $destinationPath = 'assets/users/'.$user->id.'/investments/'.$investor->id.'/'.$request->investing_company_name.'/';
            $filename = $request->file('trust_or_company_docs')->getClientOriginalName();
            $fileExtension = $request->file('trust_or_company_docs')->getClientOriginalExtension();
            $request->file('trust_or_company_docs')->move($destinationPath, $filename);
            $user_investment_doc = new UserInvestmentDocument(['type'=>'trust_or_company', 'filename'=>$filename, 'path'=>$destinationPath.$filename,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$fileExtension,'user_id'=>$user->id]);
            $project->investmentDocuments()->save($user_investment_doc);

        }
        if($request->hasFile('user_id_doc'))
        {
            $destinationPath = 'assets/users/'.$user->id.'/investments/'.$investor->id.'/normal_name/';
            $filename = $request->file('user_id_doc')->getClientOriginalName();
            $fileExtension = $request->file('user_id_doc')->getClientOriginalExtension();
            $request->file('user_id_doc')->move($destinationPath, $filename);
            $user_investment_doc = new UserInvestmentDocument(['type'=>'normal_name', 'filename'=>$filename, 'path'=>$destinationPath.$filename,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$fileExtension,'user_id'=>$user->id]);
            $project->investmentDocuments()->save($user_investment_doc);

        }

        //Save wholesale project input fields
        if(!$project->retail_vs_wholesale) {
           $wholesale_investor = WholesaleInvestment::get()->last();{
               $wholesale_investing = new WholesaleInvestment;
               $wholesale_investing->project_id = $project->id;
               $wholesale_investing->investment_investor_id = $investor->id;
               $wholesale_investing->wholesale_investing_as = $request->wholesale_investing_as;
               if($request->wholesale_investing_as === 'Wholesale Investor (Net Asset $2,500,000 plus)'){
                  $wholesale_investing->accountant_name_and_firm = $request->accountant_name_firm_txt;
                  $wholesale_investing->accountant_professional_body_designation = $request->accountant_designation_txt;
                  $wholesale_investing->accountant_email = $request->accountant_email_txt;
                  $wholesale_investing->accountant_phone = $request->accountant_phone_txt;
              }
              elseif($request->wholesale_investing_as === 'Sophisticated Investor'){
                  $wholesale_investing->experience_period = $request->experience_period_txt;
                  $wholesale_investing->equity_investment_experience_text = $request->equity_investment_experience_txt;
                  $wholesale_investing->unlisted_investment_experience_text = $request->unlisted_investment_experience_txt;
                  $wholesale_investing->understand_risk_text = $request->understand_risk_txt;
              }
              $wholesale_investing->save();
          }
      }

        // Mark request form link expired
      if($request->investment_request_id){
        InvestmentRequest::find($request->investment_request_id)->update([
            'is_link_expired' => 1
        ]);
    }

        // Create PDF of Application form
    $pdfBasePath = '/app/application/application-'.$investor->id.'-'.time().'.pdf';
    $pdfPath = storage_path().$pdfBasePath;
    $pdf = PDF::loadView('pdf.application', ['project' => $project, 'investment' => $investor, 'user' => $user]);
    $pdf->save($pdfPath);
    $investor->application_path = $pdfBasePath;
    $investor->save();

    $this->dispatch(new SendInvestorNotificationEmail($user,$project, $investor));
    $this->dispatch(new SendReminderEmail($user,$project,$investor));

    return view('projects.gform.thankyou', compact('project', 'user', 'amount_5', 'amount'));
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create a request with the relevant investment link and stores in database.
     *
     * @param int $project_id
     * @return view
     */
    public function requestFormFilling($project_id, AppMailer $mailer)
    {
        $project = Project::find($project_id);
        if(!$project){
            return redirect()->back();
        }
        else{
            if(!$project->url != url()){
                return redirect()->back();
            }
            else{
                $user = Auth::user();
                $investmentRequest = InvestmentRequest::create([
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                ]);
                $formLink = url().'/project/'.$investmentRequest->id.'/interest/fill';
                $mailer->sendInvestmentRequestToAdmin($user, $project, $formLink);
                return view('projects.offer.requestSubmitted',compact('project'));
            }
        }
    }

    /**
     * Show Investment form requested by user
     *
     * @param int $request_id
     * @return view
     */
    public function requestForm($request_id)
    {
        $investmentRequest = InvestmentRequest::find($request_id);
        if($investmentRequest){
            if(\App\Helpers\SiteConfigurationHelper::isSiteAdmin()){
                if($investmentRequest->project->project_site == url()) {
                    $user = User::find($investmentRequest->user_id);
                    $project = $investmentRequest->project;
                    $color = Color::where('project_site',url())->first();
                    $projects_spv = ProjectSpvDetail::where('project_id',$investmentRequest->project_id)->first();
                    return view('projects.requestForm', compact('investmentRequest', 'project', 'projects_spv', 'user', 'color'));
                }
            }
        }
    }

    /**
     * Cancel Investment form request
     *
     * @param int $request_id
     * @return view
     */
    public function cancelRequestForm($request_id)
    {
        $investmentRequest = InvestmentRequest::find($request_id);
        if($investmentRequest){
            if(\App\Helpers\SiteConfigurationHelper::isSiteAdmin()){
                if($investmentRequest->project->project_site == url()) {
                    $investmentRequest->update([
                        'is_link_expired' => 1
                    ]);
                    return redirect()->route('home');
                }
                else {
                    return redirect()->back()->withErrors('Not Project Admin');
                }
            }
            else {
                return redirect()->back()->withErrors('Not Site Admin');
            }
        }
        else {
            return redirect()->back()->withErrors('Something went wrong');
        }
    }
}


