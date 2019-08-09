<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\Color;
use App\Media;
use Validator;
use App\Project;
use Carbon\Carbon;
use App\Investment;
use App\ProjectFAQ;
use App\ProjectProg;
use App\Http\Requests;
use App\InvestingJoint;
use App\ProjectSpvDetail;
use App\Mailers\AppMailer;
use App\InvestmentInvestor;
use Illuminate\Http\Request;
use App\ProjectConfiguration;
use App\Jobs\SendReminderEmail;
use App\Http\Requests\FAQRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\ProjectConfigurationPartial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProjectRequest;
use Intercom\IntercomBasicAuthClient;
use Intervention\Image\Facades\Image;
use App\Http\Requests\InvestmentRequest;
use App\Jobs\SendInvestorNotificationEmail;
use App\Jobs\SendDeveloperNotificationEmail;
use App\SiteConfiguration;
use App\ProjectEOI;
use App\ProspectusDownload;

class ProjectsController extends Controller
{
    /**
     * constructor for UsersController
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show','redirectingfromproject', 'gform', 'gformRedirects','showEoiInterest','showInterest']]);
        $this->uri = env('KONKRETE_IP', 'http://localhost:5050');
        if(isset(SiteConfiguration::where('project_site', url())->first()->audk_default_project_id)){
            $this->audkID = SiteConfiguration::where('project_site', url())->first()->audk_default_project_id;
        }else{
            $this->audkID = env('AUDK_PROJECT_ID',27);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $color = Color::where('project_site',url())->first();
        $projects = Project::all();
        $pledged_investments = InvestmentInvestor::all();
        return view('projects.index', compact('projects', 'pledged_investments','color'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $color = Color::where('project_site',url())->first();
        return view('projects.create',compact('color'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectRequest  $request
     * @return Response
     */
    public function store(ProjectRequest $request, AppMailer $mailer)
    {
        $request['asking_amount'] = (int)$request->asking_amount;
        $request['invoice_amount'] = (int)$request->invoice_amount;

        if($request->asking_amount > $request->invoice_amount) {
            return redirect()->back()->withInput()->withErrors(['asking_amount' => 'Asking price cannot be greater than Amount.']);
        }

        $user = Auth::user();

        // Prefilled Data
        $request['user_id'] = $request->user()->id;
        $request['project_type'] = 1;
        $request['line_1'] = isset($request->line_1) ? $request->line_1 : '20 Queen st,';
        $request['line_2'] = isset($request->line_2) ? $request->line_2 : 'Level 1,';
        $request['city'] = isset($request->city) ? $request->city : 'Melbourne';
        $request['state'] = isset($request->state) ? $request->state : 'Victoria';
        $request['postal_code'] = isset($request->postal_code) ? $request->postal_code : '3000';
        $request['country'] = isset($request->country) ? $request->country : 'Australia';
        $request['minimum_accepted_amount'] = $request->asking_amount;
        $request['maximum_accepted_amount'] = $request->asking_amount;

        //TODO::add transation
        $request['project_site'] = url();
        $request['project_thumbnail_text'] = "Buy this invoice at a discount and make a return when the invoice is paid";
        $param = array("address"=>$request->line_1.' '.$request->line_2.' '.$request->city.' '.$request->state.' '.$request->country);
        $response = \Geocoder::geocode('json', $param);
        if(json_decode($response)->status != 'ZERO_RESULTS') {
            $latitude =json_decode(($response))->results[0]->geometry->location->lat;
            $longitude =json_decode(($response))->results[0]->geometry->location->lng;
            $request['latitude'] = $latitude;
            $request['longitude'] = $longitude;
        } else {
            return redirect()->back()->withInput()->withMessage('<p class="alert alert-danger text-center">Enter the correct address</p>');
        }
        $project = Project::create($request->all());
        $project->project_rank = $project->id;
        $project->eb_project_rank = $project->id;
        $project->save();

        $location = new \App\Location($request->all());
        $location = $project->location()->save($location);

        // Save SPV to default
        $this->setSpvToDefault($project->id);

        if (!file_exists('assets/documents/projects/'.$project->id)) {
            File::makeDirectory('assets/documents/projects/'.$project->id, 0775, true);
        }
        $destinationPath = 'assets/documents/projects/'.$project->id;

        //TODO::refactor
        if ($request->hasFile('doc1') && $request->file('doc1')->isValid()) {
            $filename1 = $request->file('doc1')->getClientOriginalName();
            $fileExtension1 = $request->file('doc1')->getClientOriginalExtension();
            $filename1 = 'section_32.'.$fileExtension1;
            $uploadStatus1 = $request->file('doc1')->move($destinationPath, $filename1);
            if($uploadStatus1){
                $document1 = new \App\Document(['type'=>'test', 'filename'=>$filename1, 'path'=>$destinationPath.'/'.$filename1,'extension'=>$fileExtension1]);
                $project->documents()->save($document1);
            }
        }

        if ($request->hasFile('doc2') && $request->file('doc2')->isValid()) {
            $filename2 = $request->file('doc2')->getClientOriginalName();
            $fileExtension2 = $request->file('doc2')->getClientOriginalExtension();
            $filename1 = 'plans_permit.'.$fileExtension1;
            $uploadStatus2 = $request->file('doc2')->move($destinationPath, $filename2);
            if($uploadStatus2){
                $document2 = new \App\Document(['type'=>'test', 'filename'=>$filename2, 'path'=>$destinationPath.'/'.$filename2,'extension'=>$fileExtension2]);
                $project->documents()->save($document2);
            }
        }

        if ($request->hasFile('doc3') && $request->file('doc3')->isValid()) {
            $filename3 = $request->file('doc3')->getClientOriginalName();
            $fileExtension3 = $request->file('doc3')->getClientOriginalExtension();
            $filename1 = 'feasiblity_study.'.$fileExtension1;
            $uploadStatus3 = $request->file('doc3')->move($destinationPath, $filename3);
            if($uploadStatus3){
                $document3 = new \App\Document(['type'=>'test', 'filename'=>$filename3, 'path'=>$destinationPath.'/'.$filename3,'extension'=>$fileExtension3]);
                $project->documents()->save($document3);
            }
        }

        if ($request->hasFile('doc4') && $request->file('doc4')->isValid()) {
            $filename4 = $request->file('doc4')->getClientOriginalName();
            $fileExtension4 = $request->file('doc4')->getClientOriginalExtension();
            $filename1 = 'optional_doc1.'.$fileExtension1;
            $uploadStatus4 = $request->file('doc4')->move($destinationPath, $filename4);
            if($uploadStatus4){
                $document4 = new \App\Document(['type'=>'test', 'filename'=>$filename4, 'path'=>$destinationPath.'/'.$filename4,'extension'=>$fileExtension4]);
                $project->documents()->save($document4);
            }
        }

        if ($request->hasFile('doc5') && $request->file('doc5')->isValid()) {
            $filename5 = $request->file('doc5')->getClientOriginalName();
            $fileExtension5 = $request->file('doc5')->getClientOriginalExtension();
            $filename1 = 'optional_doc2.'.$fileExtension1;
            $uploadStatus5 = $request->file('doc5')->move($destinationPath, $filename5);
            if($uploadStatus5){
                $document5 = new \App\Document(['type'=>'test', 'filename'=>$filename5, 'path'=>$destinationPath.'/'.$filename5,'extension'=>$fileExtension5]);
                $project->documents()->save($document5);
            }
        }
        $investmentDetails = new Investment;
        $investmentDetails->project_id = $project->id;
        $investmentDetails->goal_amount = $request->asking_amount;
        $investmentDetails->minimum_accepted_amount = $request->minimum_accepted_amount;
        $investmentDetails->maximum_accepted_amount = $request->maximum_accepted_amount;
        $investmentDetails->total_projected_costs = $request->invoice_amount;
        $investmentDetails->total_debt = 500;
        $investmentDetails->total_equity = 100;
        $investmentDetails->projected_returns = $request->invoice_amount;
        $investmentDetails->hold_period = '24';
        $investmentDetails->developer_equity = 100;
        $investmentDetails->fund_raising_start_date = Carbon::now()->toDateTimeString();
        $investmentDetails->fund_raising_close_date = $request->due_date;
        $investmentDetails->project_site = url();
        $investmentDetails->bank = 'Westpac';
        $investmentDetails->bank_account_name = 'Konkrete Distributed Registries Ltd';
        $investmentDetails->bsb = '033002';
        $investmentDetails->bank_account_number = '968825';
        $investmentDetails->swift_code = 'WPACAU2S';
        $investmentDetails->save();
        $projectConfiguration = ProjectConfiguration::all();
        $projectConfiguration = $projectConfiguration->where('project_id', $project->id)->first();
        if(!$projectConfiguration)
        {
            $projectConfiguration = new ProjectConfiguration;
            $projectConfiguration->project_id = $project->id;
            $projectConfiguration->save();
        }

        $projectConfigurationPartial = ProjectConfigurationPartial::all();
        $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', $project->id)->first();
        if(!$projectConfigurationPartial)
        {
            $projectConfigurationPartial = new ProjectConfigurationPartial();
            $projectConfigurationPartial->project_id = $project->id;
            $projectConfigurationPartial->show_project_progress = 0;
            $projectConfigurationPartial->expected_return_label_text = 'Invoice Amount';
            $projectConfigurationPartial->save();
        }
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET',$this->uri.'/createProject',[
            'query' => ['project_id' => $project->id]
        ]);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);
        $project->wallet_address = $result->signingKey->address;
        $project->save();
        $mailer->sendProjectSubmit($user, $project);
        return redirect()->route('projects.confirmation', $project)->withMessage('<p class="alert alert-success text-center">Successfully Added New Project.</p>');
    }

    public function confirmation($projects)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($projects);
        return view('projects.confirmation', compact('project','color'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $editFlag = false)
    {
        $user_id = Auth::user();
        $project = Project::findOrFail($id);
        // $project_prog = $project->project_progs;
        $project_prog = ProjectProg::where('project_id', $id)->orderBy('updated_date', 'DESC')->get();
        $color = Color::where('project_site',url())->first();
        $completed_percent = 0;
        $pledged_amount = 0;
        $siteConfiguration = SiteConfiguration::all();
        $siteConfiguration = $siteConfiguration->where('project_site',url())->first();

        if($project->investment) {
            $pledged_amount = InvestmentInvestor::where(['project_id'=> $project->id, 'hide_investment'=>'0'])->sum('amount');
            $number_of_investors = InvestmentInvestor::where('project_id', $project->id)->count();
            $completed_percent = ($pledged_amount/$project->investment->goal_amount)*100;
        }
        $projectConfiguration = ProjectConfiguration::all();
        $projectConfiguration = $projectConfiguration->where('project_id', $project->id)->first();
        if(!$projectConfiguration)
        {
            $projectConfiguration = new ProjectConfiguration;
            $projectConfiguration->project_id = $project->id;
            $projectConfiguration->save();
        }

        $projectConfigurationPartial = ProjectConfigurationPartial::all();
        $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', $project->id)->first();
        if(!$projectConfigurationPartial)
        {
            $projectConfigurationPartial = new ProjectConfigurationPartial;
            $projectConfigurationPartial->project_id = $project->id;
            $projectConfigurationPartial->save();
        }

        if(!$project->active && app()->environment() == 'production') {
            if(Auth::guest()) {
                return response()->view('errors.404', [], 404);
            } else {
                $user = Auth::user();
                $roles = $user->roles;
                if (!$roles->contains('role', 'admin') && !$roles->contains('role', 'master')) {
                    return response()->view('errors.404', [], 404);
                }
            }
        }

        if($project->is_coming_soon && app()->environment() == 'production') {
            if(Auth::guest()) {
                return response()->view('errors.404', [], 404);
            } else {
                $user = Auth::user();
                $roles = $user->roles;
                if (!$roles->contains('role', 'admin') && !$roles->contains('role', 'master')) {
                    return response()->view('errors.404', [], 404);
                }
            }
        }

        //delete it if everything is working; this was for admin only
        if($project->active ==  2 && app()->environment() == 'production') {
            if(Auth::guest()) {
                return response()->view('errors.404', [], 404);
            } else {
                $user = Auth::user();
                $roles = $user->roles;
                if (!$roles->contains('role', 'admin') && !$roles->contains('role', 'master')) {
                    return response()->view('errors.404', [], 404);
                }
            }
        }
        if($project->invite_only)
        {
            if(Auth::guest()) {
                return redirect()->to('/users/login?next=projects/'.$project->id)->withMessage('<p class="alert alert-warning text-center">Please log in to access the project</p>');
            }
            if($project->invited_users->contains(Auth::user()))
            {
                if($editFlag){
                    return view('projects.showedit', compact('siteConfiguration', 'project', 'pledged_amount', 'completed_percent', 'number_of_investors','color','project_prog'));
                }
                return view('projects.show', compact('siteConfiguration', 'project', 'pledged_amount', 'completed_percent', 'number_of_investors','color','project_prog'));
            } else {
                return redirect()->route('users.show', Auth::user())->withMessage('<p class="alert alert-warning text-center">This is an Invite Only Project, You do not have access to this project.<br>Please click <a href="/#projects">here</a> to see other projects.</p>');
            }
        }
        if($editFlag){
            return view('projects.showedit', compact('siteConfiguration', 'project', 'pledged_amount', 'completed_percent', 'number_of_investors','color','project_prog'));
        }
        return view('projects.show', compact('siteConfiguration', 'project', 'pledged_amount', 'completed_percent', 'number_of_investors','color','project_prog'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showedit($id){
        if(Auth::guest()){
            return response()->view('errors.404', [], 404);
        } else {
            $user = Auth::user();
            $roles = $user->roles;
            if ($roles->contains('role', 'admin') || $roles->contains('role', 'master')) {
                return $this->show($id, true);
            } else {
                return response()->view('errors.404', [], 404);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ProjectRequest $request, $id)
    {
                //TODO::add transation
        $project = Project::findOrFail($id);
        if($request->invite_only)
        {
            $this->validate($request, ['developerEmail' => 'required|email|exists:users,email']);
            $request['developer_id'] = User::whereEmail($request->developerEmail)->firstOrFail()->id;
        }

        //Check for minimum investment amount
        if((int)$request->project_min_investment_txt % 5 != 0)
        {
            return redirect()->back()->withErrors(['Please enter amount in increments of $5 only']);
        }

        $project->update($request->all());

        if($request->project_status) {
            if($request->project_status == 'eoi') {
                $project->active = 1;
                $project->is_coming_soon = 0;
                $project->eoi_button = 1;
                $project->is_funding_closed = 0;
                $project->save();
            }elseif($request->project_status == 'upcoming') {
                $project->active = 1;
                $project->is_coming_soon = 1;
                $project->eoi_button = 0;
                $project->is_funding_closed = 0;
                $project->save();
            }elseif($request->project_status == 'active') {
                $project->active = 1;
                $project->is_coming_soon = 0;
                $project->eoi_button = 0;
                $project->is_funding_closed = 0;
                $project->save();
            }elseif($request->project_status == 'funding_closed') {
                $project->active = 1;
                $project->is_coming_soon = 0;
                $project->eoi_button = 0;
                $project->is_funding_closed = 1;
                $project->save();
            }else {
                $project->active = 0;
                $project->is_coming_soon = 0;
                $project->eoi_button = 0;
                $project->is_funding_closed = 0;
                $project->save();
            }
        }

        $project->invited_users()->attach(User::whereEmail($request->developerEmail)->first());

        $param = array("address"=>$request->line_1.' '.$request->line_2.' '.$request->city.' '.$request->state.' '.$request->country);
        $response = \Geocoder::geocode('json', $param);
        if(json_decode($response)->status != 'ZERO_RESULTS') {
            $latitude =json_decode(($response))->results[0]->geometry->location->lat;
            $longitude =json_decode(($response))->results[0]->geometry->location->lng;
            $request['latitude'] = $latitude;
            $request['longitude'] = $longitude;
        } else {
            return redirect()->route('projects.edit', $project)->withMessage('<p class="alert alert-danger text-center">Enter the correct address</p>');
        }
        $location = $project->location;
        $location->update($request->all());

        if (!file_exists('assets/documents/projects/'.$project->id)) {
            File::makeDirectory('assets/documents/projects/'.$project->id, 0775, true);
        }
        $destinationPath = 'assets/documents/projects/'.$project->id;
        if ($request->hasFile('doc1') && $request->file('doc1')->isValid()) {
            $filename1 = $request->file('doc1')->getClientOriginalName();
            $fileExtension1 = $request->file('doc1')->getClientOriginalExtension();
            $filename1 = 'section_32.'.$fileExtension1;
            $uploadStatus1 = $request->file('doc1')->move($destinationPath, $filename1);
            if($uploadStatus1){
                $document1 = new \App\Document(['type'=>'test', 'filename'=>$filename1, 'path'=>$destinationPath.'/'.$filename1,'extension'=>$fileExtension1]);
                $project->documents()->save($document1);
            }
        }
        if ($request->hasFile('doc2') && $request->file('doc2')->isValid()) {
            $filename2 = $request->file('doc2')->getClientOriginalName();
            $fileExtension2 = $request->file('doc2')->getClientOriginalExtension();
            $filename1 = 'plans_permit.'.$fileExtension1;
            $uploadStatus2 = $request->file('doc2')->move($destinationPath, $filename2);
            if($uploadStatus2){
                $document2 = new \App\Document(['type'=>'test', 'filename'=>$filename2, 'path'=>$destinationPath.'/'.$filename2,'extension'=>$fileExtension2]);
                $project->documents()->save($document2);
            }
        }
        if ($request->hasFile('doc3') && $request->file('doc3')->isValid()) {
            $filename3 = $request->file('doc3')->getClientOriginalName();
            $fileExtension3 = $request->file('doc3')->getClientOriginalExtension();
            $filename1 = 'feasiblity_study.'.$fileExtension1;
            $uploadStatus3 = $request->file('doc3')->move($destinationPath, $filename3);
            if($uploadStatus3){
                $document3 = new \App\Document(['type'=>'test', 'filename'=>$filename3, 'path'=>$destinationPath.'/'.$filename3,'extension'=>$fileExtension3]);
                $project->documents()->save($document3);
            }
        }
        if ($request->hasFile('doc4') && $request->file('doc4')->isValid()) {
            $filename4 = $request->file('doc4')->getClientOriginalName();
            $fileExtension4 = $request->file('doc4')->getClientOriginalExtension();
            $filename1 = 'optional_doc1.'.$fileExtension1;
            $uploadStatus4 = $request->file('doc4')->move($destinationPath, $filename4);
            if($uploadStatus4){
                $document4 = new \App\Document(['type'=>'test', 'filename'=>$filename4, 'path'=>$destinationPath.'/'.$filename4,'extension'=>$fileExtension4]);
                $project->documents()->save($document4);
            }
        }

        if ($request->hasFile('doc5') && $request->file('doc5')->isValid()) {
            $filename5 = $request->file('doc5')->getClientOriginalName();
            $fileExtension5 = $request->file('doc5')->getClientOriginalExtension();
            $filename1 = 'optional_doc2.'.$fileExtension1;
            $uploadStatus5 = $request->file('doc5')->move($destinationPath, $filename5);
            if($uploadStatus5){
                $document5 = new \App\Document(['type'=>'test', 'filename'=>$filename5, 'path'=>$destinationPath.'/'.$filename5,'extension'=>$fileExtension5]);
                $project->documents()->save($document5);
            }
        }
        $investment = $project->investment;
        $request['projected_returns'] = $request->invoice_amount;
        $request['total_projected_costs'] = $request->invoice_amount;
        $request['goal_amount'] = $request->asking_amount;
        $request['minimum_accepted_amount'] = $request->asking_amount;
        $request['maximum_accepted_amount'] = $request->asking_amount;
        $request['fund_raising_close_date'] = $request->due_date;
        $investment->update($request->all());

        //TODO::refactor

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully Updated.</p>');
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

    public function showInterest($project_id, AppMailer $mailer, Request $request)
    {
        $action = '/offer/submit/'.$project_id.'/step1';
        $projects_spv = ProjectSpvDetail::where('project_id',$project_id)->first();
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        if(!$project->show_invest_now_button) {
            return redirect()->route('projects.show', $project);
        }
        $investments = InvestmentInvestor::where('project_id',$project->id)
                                        ->where('accepted',1)
                                        ->get();
        $acceptedAmount = $investments->sum('amount');
        $goalAmount = $project->investment->goal_amount;
        $maxAmount = $goalAmount - $acceptedAmount;
        // if(Auth::user()->verify_id != 2){
        //     return redirect()->route('users.verification', Auth::user())->withMessage('<p class="alert alert-warning text-center alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> As part of our commitment to meeting Australian Securities Law we are required to do some additional user verification to meet Anti Money Laundering and Counter Terror Financing requirements.<br> This wont take long, promise!</p>');
        // }

        if($project->investment){
            $user = Auth::user();
            if($request->source == 'eoi'){
                dd('EOI');
                $user = User::find($request->uid);
                $eoi = ProjectEOI::find($request->id);
                return view('projects.offer', compact('project','color','action','projects_spv','user', 'eoi','maxAmount'));
            }
            if(!$project->eoi_button){

                return view('projects.offer', compact('project','color','action','projects_spv','user','maxAmount'));
            } else{
                return response()->view('errors.404', [], 404);
            }
        } else {
            return redirect()->back()->withMessage('<p class="alert alert-warning text-center alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Warning!</strong>Project investment plan is not yet done</p>');
        }
    }

    public function showEoiInterest($project_id)
    {
        $projects_spv = ProjectSpvDetail::where('project_id',$project_id)->first();
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        if($project->investment){
            $user = Auth::user();
        }
        if($project->eoi_button) {
            return view('projects.eoiForm', compact('project', 'color', 'projects_spv', 'user'));
        }else {
            return response()->view('errors.404', [], 404);
        }
    }

    public function storeProjectEOI(Request $request, AppMailer $mailer)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($request->project_id);
        $user = Auth::user();
        $user_info = Auth::user();
        $min_amount_invest = $project->investment->minimum_accepted_amount;
        if((int)$request->investment_amount < (int)$min_amount_invest)
        {
            return redirect()->back()->withErrors(['The amount to invest must be at least $'.$min_amount_invest]);
        }

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' =>'required',
            'email' => 'required',
            'phone_number' => 'required',
            'investment_amount' => 'required|numeric',
            'investment_period' => 'required',
            ]);
        $request->merge(['country' => array_search($request->country_code, \App\Http\Utilities\Country::all())]);
        if($project){
            if($project->eoi_button){
                $eoi_data = ProjectEOI::create([
                    'project_id' => $request->project_id,
                    'user_id' => $user->id,
                    'user_name' => $request->first_name.' '.$request->last_name,
                    'user_email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'investment_amount' => $request->investment_amount,
                    'invesment_period' => $request->investment_period,
                    'interested_to_buy' => $request->interested_to_buy,
                    'is_accredited_investor' => $request->is_accredited_investor,
                    'country_code' => $request->country_code,
                    'country'=>$request->country,
                    'project_site' => url(),
                    ]);
                $mailer->sendProjectEoiEmailToAdmins($project, $eoi_data);
                $mailer->sendProjectEoiEmailToUser($project, $user_info);
            }
        }
        return redirect()->route('users.success.eoi')->withMessage('<p class="alert alert-success text-center" style="margin-top: 30px;">Thank you for expressing interest. We will be in touch with you shortly.</p>');
    }

    public function showInterestOffer($project_id, AppMailer $mailer)
    {
        return view('projects.offer');
    }
    public function interestCompleted($project_id, AppMailer $mailer)
    {
        $project = Project::findOrFail($project_id);
        return view('projects.shownInterest',compact('project'));
    }

    public function storePhoto(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $image_type = 'main_image';

        $destinationPath = 'assets/images/projects/'.$project_id;
        $filename = $request->file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->file->getClientOriginalExtension();
        $photo = $request->file->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        $photo->resize(1566, 885, function ($constraint) {
            $constraint->aspectRatio();
        })->save();
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension]);
        $project->media()->save($media);
        return 1;

    }
    public function storePhotoProjectDeveloper(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $image_type = 'project_developer';

        $destinationPath = 'assets/images/projects/'.$project_id.'/developer';
        $filename = $request->file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->file->getClientOriginalExtension();
        $photo = $request->file->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        $photo->resize(1566, 885, function ($constraint) {
            $constraint->aspectRatio();
        })->save();
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension]);
        $project->media()->save($media);
        return 1;

    }
    public function storePhotoProjectThumbnail(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $image_type = 'project_thumbnail';

        $destinationPath = 'assets/images/projects/'.$project_id;
        $filename = $request->file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->file->getClientOriginalExtension();
        $photo = $request->file->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        $photo->resize(1024, 683, function ($constraint) {
            $constraint->aspectRatio();
        })->save();
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension]);
        $project->media()->save($media);
        return 1;

    }
    public function storePhotoResidents1(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $image_type = 'residents';
        // if($project->media->count()){
        //     $destinationPath = 'assets/images/projects';
        //     $filename = 'residents';
        //     // $filename = $request->file->getClientOriginalName();
        //     $extension = $request->file->getClientOriginalExtension();
        //     $photo = $request->file->move($destinationPath, $filename);
        //     $photo= Image::make($destinationPath.'/'.$filename);
        //     $photo->destroy();
        //     // return 1;
        // }
        $destinationPath = 'assets/images/projects/'.$project_id.'/residents';
        $filename = $request->file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->file->getClientOriginalExtension();
        $photo = $request->file->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        // $photo->resize(1366, null, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save();
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension]);
        $project->media()->save($media);
        return 1;
    }
    public function storePhotoMarketability(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $image_type = 'marketability';
        // if($project->media->count()){
        //     $destinationPath = 'assets/images/projects/marketability';
        //     $filename = 'marketability';
        //     $extension = $request->file->getClientOriginalExtension();
        //     $photo = $request->file->move($destinationPath, $filename);
        //     $photo= Image::make($destinationPath.'/'.$filename);
        //     $photo->destroy();
        //     return 1;
        // }
        $destinationPath = 'assets/images/projects/'.$project_id.'/marketability';
        $filename = $request->file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->file->getClientOriginalExtension();
        $photo = $request->file->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        // $photo->resize(1366, null, function ($constraint) {
            // $constraint->aspectRatio();
        // })->save();
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension]);
        $project->media()->save($media);
        return 1;
    }
    public function storePhotoInvestmentStructure(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $image_type = 'investment_structure';
        // if($project->media->count()){
        //     $destinationPath = 'assets/images/projects/marketability';
        //     $filename = 'marketability';
        //     $extension = $request->file->getClientOriginalExtension();
        //     $photo = $request->file->move($destinationPath, $filename);
        //     $photo= Image::make($destinationPath.'/'.$filename);
        //     $photo->destroy();
        //     return 1;
        // }
        $destinationPath = 'assets/images/projects/'.$project_id.'/istructure';
        $filename = $request->file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->file->getClientOriginalExtension();
        $photo = $request->file->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        // $photo->resize(1366, null, function ($constraint) {
            // $constraint->aspectRatio();
        // })->save();
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension]);
        $project->media()->save($media);
        return 1;
    }
    public function storePhotoExit(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $image_type = 'exit_image';
        // if($project->media->count()){
        //     $destinationPath = 'assets/images/projects/marketability';
        //     $filename = 'marketability';
        //     $extension = $request->file->getClientOriginalExtension();
        //     $photo = $request->file->move($destinationPath, $filename);
        //     $photo= Image::make($destinationPath.'/'.$filename);
        //     $photo->destroy();
        //     return 1;
        // }
        $destinationPath = 'assets/images/projects/'.$project_id.'/exit';
        $filename = $request->file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->file->getClientOriginalExtension();
        $photo = $request->file->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        // $photo->resize(1366, null, function ($constraint) {
            // $constraint->aspectRatio();
        // })->save();
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension]);
        $project->media()->save($media);
        return 1;
    }

    public function storeInvestmentInfo(InvestmentRequest $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $investment = new \App\Investment($request->all());
        $project->investment()->save($investment);

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully Added Investment Info.</p>');
    }

    public function storeAdditionalFormContent(Request $request, $id)
    {
        // $this->validate($request, array(
        //     'add_additional_form_content' => 'required',
        //     ));
        $project = Project::where('id', $id);
        $result = $project->update([
            'add_additional_form_content' => $request->add_additional_form_content,
            ]);

        return redirect()->back()->withMessage('Successfully Added Additional Form Content.');
    }

    public function storeProjectThumbnailText(Request $request, $id)
    {
        $project = Project::where('id', $id);
        $result = $project->update([
            'project_thumbnail_text' => $request->project_thumbnail_text,
            ]);
        return redirect()->back();
    }

    public function storeProjectFAQ(FAQRequest $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $faq = new \App\ProjectFAQ($request->all());
        $project->projectFAQs()->save($faq);

        Session::flash('editable', 'true');
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully Added FAQ</p>');
    }
    public function deleteProjectFAQ($faq_id)
    {
        $faq = ProjectFAQ::findOrFail($faq_id);
        $faq->delete();
        Session::flash('editable', 'true');
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully Deleted FAQ</p>');
    }

    public function redirectingfromproject()
    {
        return view('pages.welcome');
    }

    public function showInvitation()
    {
        $user = Auth::user();
        return view('projects.invitation', compact('user'));
    }

    public function postInvitation(Request $request)
    {
        $user = Auth::user();
        $project = Project::findOrFail($request->project);
        $this->validate($request, ['email' => 'required']);
        $str = $request->email;
        $email_array = explode(";",$str);
        $failed_emails = "";
        $sent_emails = "";
        foreach ($email_array as $key => $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $failed_emails = $failed_emails." ".$email;
            } else {
                $investor = User::whereEmail($email)->first();
                if($investor){
                    $project->invited_users()->attach($investor);
                }
            }
        }
        if($failed_emails != "" ) {
            if($sent_emails != "") {
                return redirect()->back()->withMessage('<p class="alert alert-success text-center">Your invitation to '.$sent_emails.' was sent succesfully, we will notify when your invite was accepted.</p><br><p class="alert alert-warning text-center">You can not send Invitation to '.$failed_emails.'</p>');
            } else {
                return redirect()->back()->withMessage('<p class="alert alert-warning text-center">You can not send Invitation to '.$failed_emails.'</p>');
            }
        }
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Your invitation to '.$sent_emails.' was sent succesfully, we will notify when your invite was accepted.</p>');
    }

    public function gformRedirects(Request $request)
    {
        $url = url();
        $amount = $request->amount_to_invest;
        $project_id = $request->project_id;
        $user_id = $request->user_id;
        // if($request->same_account){
        //     $request->withdraw_bank_name = $request->bank_name;
        //     $request->withdraw_account_name = $request->account_name;
        //     $request->withdraw_account_number = $request->account_number;
        //     $request->withdraw_bsb = $request->bsb;
        // }
        return redirect($url.'/gform?amount_to_invest='.$amount.'&project_id='.$project_id.'&user_id='.$user_id.'&line_1='.$request->line_1.'&line_2='.$request->line_2.'&city='.$request->city.'&state='.$request->state.'&country='.$request->country.'&postal_code='.$request->postal_code.'&account_name='.$request->account_name.'&bsb='.$request->bsb.'&account_number='.$request->account_number.'&investing_as='.$request->investing_as.'&joint_investor_first='.$request->joint_investor_first.'&joint_investor_last='.$request->joint_investor_last.'&investing_company_name='.$request->investing_company_name.'&bank_name='.$request->bank_name.'&tfn='.$request->tfn);
    }

    public function gform(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $user = User::findOrFail($request->user_id);
        $amount = floatval(str_replace(',', '', str_replace('A$ ', '', $request->amount_to_invest)));
        // $amount_5 = $amount*0.05; //5 percent of investment
        $user->investments()->attach($project, ['investment_id'=>$project->investment->id,'amount'=>$amount,'project_site'=>url(),'investing_as'=>$request->investing_as]);
        $user->update($request->all());
        $investor = InvestmentInvestor::get()->last();
        if($request->investing_as != 'Individual Investor'){
            $investing_joint = new InvestingJoint;
            $investing_joint->project_id = $project->id;
            $investing_joint->investment_investor_id = $investor->id;
            $investing_joint->joint_investor_first_name = $request->joint_investor_first;
            $investing_joint->joint_investor_last_name = $request->joint_investor_last;
            $investing_joint->investing_company = $request->investing_company_name;
            $investing_joint->save();
        }
        $this->dispatch(new SendInvestorNotificationEmail($user,$project));
        $this->dispatch(new SendReminderEmail($user,$project));

        return view('projects.gform.thankyou', compact('project', 'user', 'amount_5', 'amount'));
    }

    public function storeProjectSPVDetails(Request $request, $project_id)
    {
        $this->validate($request, [
            'spv_name' => 'required',
            'spv_line_1' => 'required',
            'spv_city' => 'required',
            'spv_state' => 'required',
            'spv_postal_code' => 'required',
            'spv_country' => 'required',
            'spv_contact_number' => 'required',
            'spv_md_name' => 'required',
            // 'spv_logo_image_path' => 'required',
            ]);
        //validate SPV logo
        $projectMedia = Media::where('project_id', $project_id)
        ->where('project_site', url())
        ->where('type', 'spv_logo_image')
        ->first();
        if(!$projectMedia){
            $this->validate($request, [
                'spv_logo' => 'required',
                ]);
        }
        //Validate SPV MD Signature
        $projectMedia = Media::where('project_id', $project_id)
        ->where('project_site', url())
        ->where('type', 'spv_md_sign_image')
        ->first();
        if(!$projectMedia){
            $this->validate($request, [
                'spv_md_sign' => 'required',
                ]);
        }
        $projectSpv = ProjectSpvDetail::where('project_id', $project_id)->first();
        if(!$projectSpv)
        {
            $projectSpv = new ProjectSpvDetail;
            $projectSpv->project_id = $project_id;
            $projectSpv->save();
            $projectSpv = ProjectSpvDetail::where('project_id',$project_id)->first();
        }
        $spv_result = $projectSpv->update([
            'spv_name' => $request->spv_name,
            'spv_line_1' => $request->spv_line_1,
            'spv_line_2' => $request->spv_line_2,
            'spv_city' => $request->spv_city,
            'spv_state' => $request->spv_state,
            'spv_postal_code' => $request->spv_postal_code,
            'spv_country' => $request->spv_country,
            'spv_contact_number' => $request->spv_contact_number,
            'spv_md_name' => $request->spv_md_name,
            'certificate_frame' => $request->certificate_frame,
            'spv_email' => $request->spv_email,
            ]);
        if($spv_result)
        {
            if($request->spv_logo_image_path && $request->spv_logo_image_path != ''){
                $saveLoc = 'assets/images/media/project_page/';
                $finalFile = 'spv_logo_'.time().'.png';
                $finalpath = $saveLoc.$finalFile;
                Image::make($request->spv_logo_image_path)->save(public_path($finalpath));
                File::delete($request->spv_logo_image_path);

                $projectMedia = Media::where('project_id', $project_id)
                ->where('project_site', url())
                ->where('type', 'spv_logo_image')
                ->first();
                if($projectMedia){
                    File::delete(public_path($projectMedia->path));
                }
                else{
                    $projectMedia = new Media;
                    $projectMedia->project_id = $project_id;
                    $projectMedia->type = 'spv_logo_image';
                    $projectMedia->project_site = url();
                    $projectMedia->caption = 'Project SPV Logo Image';
                }
                $projectMedia->filename = $finalFile;
                $projectMedia->path = $finalpath;
                $projectMedia->save();
            }
            if($request->spv_md_sign_image_path && $request->spv_md_sign_image_path != ''){
                $saveLoc = 'assets/images/media/project_page/';
                $finalFile = 'spv_md_sign'.time().'.png';
                $finalpath = $saveLoc.$finalFile;
                Image::make($request->spv_md_sign_image_path)->save(public_path($finalpath));
                File::delete($request->spv_md_sign_image_path);
                $projectMedia = Media::where('project_id', $project_id)
                ->where('project_site', url())
                ->where('type', 'spv_md_sign_image')
                ->first();
                if($projectMedia){
                    File::delete(public_path($projectMedia->path));
                }
                else{
                    $projectMedia = new Media;
                    $projectMedia->project_id = $project_id;
                    $projectMedia->type = 'spv_md_sign_image';
                    $projectMedia->project_site = url();
                    $projectMedia->caption = 'Project SPV MD Signature Image';
                }
                $projectMedia->filename = $finalFile;
                $projectMedia->path = $finalpath;
                $projectMedia->save();
            }
            return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully Updated Project SPV Details.</p>');
        }
    }

    public function uploadSubSectionImages(Request $request)
    {
        $validation_rules = array(
            'project_sub_heading_image'   => 'required|mimes:jpeg,png,jpg',
            );
        $validator = Validator::make($request->all(), $validation_rules);
        if($validator->fails()){
            return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg');
        }
        $project = Project::findOrFail($request->projectId);
        $image_type = $request->imgType;
        $destinationPath = 'assets/images/projects/'.$request->projectId;
        $filename = $request->project_sub_heading_image->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->project_sub_heading_image->getClientOriginalExtension();
        $photo = $request->project_sub_heading_image->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension]);
        $project->media()->save($media);
        return $resultArray = array('status' => 1, 'message' => 'The Image uploaded Successfully');
    }

    public function deleteSubSectionImages(Request $request)
    {
        $mediaId = $request->mediaId;
        if($mediaId != '')
        {
            $projectMedia = Media::find($mediaId);
            if($projectMedia)
            {
                if($projectMedia->project->project_site == url())
                {
                    $projectMedia = Media::where('type',$projectMedia->type)->where('project_id',(int)$request->projectId)->get();
                    foreach ($projectMedia as $media) {
                        File::delete($media->path);
                        $media->delete();
                    }
                    return $resultArray = array('status' => 1, 'message' => 'Image deleted Successfully', 'mediaImageId' => $mediaId);
                }
            }
        }
    }

    public function deleteProjectCarouselImages(Request $request)
    {
        $mediaId = $request->mediaId;
        if($mediaId != '')
        {
            $projectMedia = Media::find($mediaId);
            if($projectMedia)
            {
                if($projectMedia->project->project_site == url())
                {
                    File::delete($projectMedia->path);
                    $projectMedia->delete();
                    return $resultArray = array('status' => 1, 'message' => 'Image deleted Successfully', 'mediaImageId' => $mediaId);
                }
            }
        }
    }

    public function prospectusDownload(Request $request)
    {
        $project = Project::find($request->projectId);
        if($project){
            if($project->project_site == url()){
                $data = ProspectusDownload::create([
                    'user_id' => Auth::user()->id,
                    'project_id' => $project->id,
                    'project_site' => url()
                ]);
            }
            return $data;
        }
    }

    /**
     * @param $projectId
     */
    public static function setSpvToDefault($projectId)
    {
        $projectSpv = new ProjectSpvDetail;
        $projectSpv->project_id = $projectId;
        $projectSpv->spv_name = 'Test Invoice';
        $projectSpv->spv_line_1 = '20 Queen st';
        $projectSpv->spv_line_2 = 'Level 1';
        $projectSpv->spv_city = 'Melbourne';
        $projectSpv->spv_state = 'Victoria';
        $projectSpv->spv_postal_code = '3000';
        $projectSpv->spv_country = 'au';
        $projectSpv->spv_contact_number = '1 300 033 221';
        $projectSpv->spv_md_name = 'Moresh Kokane';
        $projectSpv->certificate_frame = 'frame1.jpg';
        $projectSpv->spv_email = 'info@estatebaron.com';
        $projectSpv->save();

        $projectMedia = new Media;
        $projectMedia->project_id = $projectId;
        $projectMedia->type = 'spv_logo_image';
        $projectMedia->project_site = url();
        $projectMedia->caption = 'Project SPV Logo Image';
        $projectMedia->filename = 'spv_logo_dummy.png';
        $projectMedia->path = 'assets/images/media/project_page/spv_logo_dummy.png';
        $projectMedia->save();

        $projectMedia = new Media;
        $projectMedia->project_id = $projectId;
        $projectMedia->type = 'spv_md_sign_image';
        $projectMedia->project_site = url();
        $projectMedia->caption = 'Project SPV Logo Image';
        $projectMedia->filename = 'spv_md_sign_dummy.png';
        $projectMedia->path = 'assets/images/media/project_page/spv_md_sign_dummy.png';
        $projectMedia->save();
    }
}
