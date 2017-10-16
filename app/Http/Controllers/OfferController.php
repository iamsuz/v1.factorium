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
        $project = Project::findOrFail($request->project_id);
        $min_amount_invest = $project->investment->minimum_accepted_amount;
        if((int)$request->amount_to_invest < (int)$min_amount_invest)
        {
            return redirect()->back()->withErrors(['The amount to invest must be at least '.$min_amount_invest]);
        }
        if((int)$request->amount_to_invest % 1000 != 0)
        {
            return redirect()->back()->withErrors(['Please enter amount in increments of $1000 only']);
        }
        $validation_rules = array(
            'joint_investor_id_doc'   => 'mimes:jpeg,jpg,png,pdf',
            'trust_or_company_docs'   => 'mimes:jpeg,jpg,png,pdf',
            'user_id_doc'   => 'mimes:jpeg,jpg,png,pdf',
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
        $amount = floatval(str_replace(',', '', str_replace('A$ ', '', $request->amount_to_invest)));
        $amount_5 = $amount*0.05; //5 percent of investment
        $user->investments()->attach($project, ['investment_id'=>$project->investment->id,'amount'=>$amount,'project_site'=>url(),'investing_as'=>$request->investing_as, 'signature_data'=>$request->signature_data]);
        $investor = InvestmentInvestor::get()->last();
        if($request->investing_as != 'Individual Investor'){
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

        // Create PDF of Application form
        $pdfBasePath = '/app/application/application-'.$investor->id.'-'.time().'.pdf';
        $pdfPath = storage_path().$pdfBasePath;
        $pdf = PDF::loadView('pdf.application', ['project' => $project, 'investment' => $investor, 'user' => $user]);
        $pdf->save($pdfPath);
        $investor->application_path = $pdfBasePath;
        $investor->save();

        $this->dispatch(new SendInvestorNotificationEmail($user,$project, $investor));
        $this->dispatch(new SendReminderEmail($user,$project));

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
}
