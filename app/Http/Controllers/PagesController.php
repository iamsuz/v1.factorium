<?php

namespace App\Http\Controllers;

use App\Role;
use App\Member;
use App\Project;
use App\Aboutus;
use App\Color;
use App\Http\Requests;
use GuzzleHttp\Client;
use App\Mailers\AppMailer;
use App\InvestmentInvestor;
use Illuminate\Http\Request;
use PulkitJalan\GeoIP\GeoIP;
use Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SubdivideRequest;
use App\Jobs\SendReminderEmail;
use App\Jobs\SendInvestorNotificationEmail;
use App\Jobs\SendDeveloperNotificationEmail;
use App\Faq;
use Session;
use App\SiteConfiguration;
use Validator;
use Intervention\Image\Facades\Image;
use File;
use Barryvdh\DomPDF\Facade as PDF;
use App\Testimonial;
use App\Helpers\SiteConfigurationHelper;
use App\ProjectInterest;
use App\ThirdPartyListing;


class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['editTeam','updateTeam','updateTeam','createTeamMember','changeColorFooter','cropUploadedImage']]);
        $this->middleware('admin', ['only' => ['editTeam','updateTeam','updateTeam','createTeamMember','changeColorFooter','cropUploadedImage']]);
    }
    /**
    * returns home page
    * @return view [home page is returned]
    */
    public function home(CookieJar $cookieJar, Request $request) {
        // $geoip = new GeoIP();
        // $geoIpArray = $geoip->get();
        $request->referrer = \Request::server('HTTP_REFERER');
        if($request->referrer){
            $cookieJar->queue(cookie('referrer', $request->referrer));
        }
        $url = url();
        $geoIpArray = [];
        $investments = InvestmentInvestor::all();
        $role = Role::findOrFail(3);
        $investors = $role->users->count();
        $color = Color::all();
        $color = $color->where('project_site',url())->first();
        $currentUserRole = '';
        $admin_access = 0;
        if(Auth::guest()) {
            $projects = Project::where(['active'=>'1','project_site'=>url()])->orderBy('project_rank', 'asc')->get();
            $currentUserRole = 'guest';
        } else {
            $user = Auth::user();
            $roles = $user->roles;
            if ($roles->contains('role', 'admin') || $roles->contains('role', 'master')) {
                $projects = Project::whereIn('active', ['1', '2'])->where('project_site',url())->orderBy('project_rank', 'asc')->get();
                // dd($projects);
                if($user->registration_site == url()){
                    $admin_access = 1;
                }
                else {
                    if($roles->contains('role', 'master'))
                        $admin_access = 1;
                }
            } else {
                $projects = Project::where(['active'=>'1','project_site'=>url()])->orderBy('project_rank', 'asc')->get();
            }
        }
        $blog_posts = DB::connection('mysql2')->select('select * from wp_posts where post_type="post" ORDER BY post_date DESC LIMIT 3');
        $blog_posts_attachments = DB::connection('mysql2')->select('select * from wp_posts where post_type="attachment"');


        $BannerCities = ['Adelaide', 'Auckland', 'Brisbane', 'Canberra', 'Darwin', 'Hobart', 'Melbourne', 'Perth', 'Sydney'];
        $siteConfiguration = SiteConfiguration::all();

        $ebConfiguration = $siteConfiguration->where('project_site','https://estatebaron.com')->first();
        //Create configuration variable for settings from estatebaron site
        if(!$ebConfiguration)
        {
            $ebConfiguration = new SiteConfiguration;
            $ebConfiguration->project_site = 'https://estatebaron.com';
            $ebConfiguration->daily_login_bonus_konkrete = '10';
            $ebConfiguration->user_sign_up_konkrete = '100';
            $ebConfiguration->kyc_upload_konkrete = '200';
            $ebConfiguration->kyc_approval_konkrete = '200';
            $ebConfiguration->referrer_konkrete = '200';
            $ebConfiguration->referee_konkrete = '200';
            $ebConfiguration->save();
            $ebConfiguration = SiteConfiguration::all();
            $ebConfiguration = $ebConfiguration->where('project_site', 'https://estatebaron.com')->first();
        }

        $siteConfiguration = $siteConfiguration->where('project_site',url())->first();
        if(!$siteConfiguration)
        {
            $siteConfiguration = new SiteConfiguration;
            $siteConfiguration->project_site = url();
            $siteConfiguration->save();
            $siteConfiguration = SiteConfiguration::all();
            $siteConfiguration = $siteConfiguration->where('project_site',url())->first();
            // dd($siteConfiguration);
        }

        $testimonials = Testimonial::where('project_site', url())->get();
        $isiosDevice = stripos(strtolower($_SERVER['HTTP_USER_AGENT']), 'iphone');
        return view('pages.home', compact('geoIpArray', 'investments', 'investors', 'projects', 'BannerCities', 'blog_posts', 'blog_posts_attachments', 'currentUserRole', 'siteConfiguration','color', 'admin_access', 'testimonials', 'isiosDevice', 'ebConfiguration'));
    }

    /**
    * returns team page
    * @return view [description]
    */
    public function team()
    {
        $aboutus = Aboutus::all();
        $aboutus = $aboutus->where('project_site',url())->first();
        $color = Color::where('project_site',url())->first();
        $adminedit = 0;
        if(Auth::user()){
            $user = Auth::user();
            $role = Role::findOrFail(3);
            $roles = $user->roles;
            if($roles->contains('role','admin') || $roles->contains('role','master')) {
                $adminedit = 1;
            }
        }
        if($aboutus){
            $member = $aboutus->member;
            return view('pages.team', compact('adminedit','aboutus','member','color'));
        }
        return view('pages.team', compact('adminedit','aboutus','color'));
    }
    /**
    * returns faq page
    * @return view [description]
    */
    public function faq()
    {
        $color = Color::where('project_site',url())->first();
        $faqGeneralBasics = Faq::where(['category'=>'General', 'sub_category'=> 'Basics', 'show'=>1,'project_site'=>url()])->get();
        $faqGeneralRegulatory = Faq::where(['category'=>'General', 'sub_category'=> 'Regulatory', 'show'=>1,'project_site'=>url() ])->get();
        $faqGeneralLegalStructure = Faq::where(['category'=>'General', 'sub_category'=> 'Legal Structure', 'show'=>1,'project_site'=>url() ])->get();
        $faqGeneralFees = Faq::where(['category'=>'General', 'sub_category'=> 'Fees', 'show'=>1,'project_site'=>url() ])->get();
        $faqGeneralWebsite = Faq::where(['category'=>'General', 'sub_category'=> 'Website', 'show'=>1,'project_site'=>url() ])->get();
        $faqInvestorInvestingBasics = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investing Basics', 'show'=>1,'project_site'=>url() ])->get();
        $faqInvestorInvestmentType = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investment Type', 'show'=>1,'project_site'=>url() ])->get();
        $faqInvestorInvestmentSpecific = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investment Specific', 'show'=>1,'project_site'=>url() ])->get();
        $faqInvestorInvestmentSupport = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investment Support', 'show'=>1,'project_site'=>url() ])->get();
        $faqInvestorInvestmentRisks = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investment Risks', 'show'=>1,'project_site'=>url() ])->get();
        $faqPropertyDevelopmentVenture = Faq::where(['category'=>'Property Development & Venture', 'show'=>1,'project_site'=>url() ])->get();

        $isAdmin = false;
        if(Auth::user()){
            if(SiteConfigurationHelper::isSiteAdmin()){
                $isAdmin = true;
            }
        }

        return view('pages.faq', compact('faqGeneralBasics','faqGeneralRegulatory','faqGeneralLegalStructure','faqGeneralFees','faqGeneralWebsite','faqInvestorInvestingBasics','faqInvestorInvestmentType','faqInvestorInvestmentSpecific','faqInvestorInvestmentSupport','faqInvestorInvestmentRisks','faqPropertyDevelopmentVenture','isAdmin','color'));
    }
    public function financial()
    {
        $color = Color::where('project_site',url())->first();
        return view('pages.financial',compact('color'));
    }

    /**
    * returns privacy page
    * @return view [description]
    */
    public function privacy()
    {
        $color = Color::where('project_site',url())->first();
        return view('pages.privacy',compact('color'));
    }

    /**
    * returns terms page
    * @return view [description]
    */
    public function terms()
    {
        $color = Color::where('project_site',url())->first();
        return view('pages.terms',compact('color'));
    }

    /**
    * returns terms page
    * @return view [description]
    */
    public function test(AppMailer $mailer)
    {
        $project = \App\Project::find(16);
        $investments = $project->investors;
        $user = \Auth::user();
        $mailer->sendInterestNotificationDeveloper($project, $user);
        // $this->dispatch(new \sendInterestNotificationDeveloper($project, $user));
        // $this->dispatch(new SendReminderEmail($user,$project));
        return 'test';
    }

    public function subdivide()
    {
        $color = Color::where('project_site',url())->first();
        return view('pages.subdivide',compact('color'));
    }

    public function storeSubdivide(SubdivideRequest $request, AppMailer $mailer)
    {
        $mailer->sendSubdivideEmailToAdmin($request->all());
        return redirect()->route('pages.subdivide.thankyou');
    }

    public function subdivideThankyou()
    {
        $color = Color::where('project_site',url())->first();
        return view('pages.subdivideThankyou',compact('color'));
    }

    public function deleteFaq(Request $request, $faq_id){
        if(Auth::user()){
            if(SiteConfigurationHelper::isSiteAdmin()){
                Faq::where('id', $faq_id)
                ->update(['show'=>0]);
                Session::flash('message', 'Successfully Deleted FAQ.');
                return redirect()->back();
            }
        }
    }

    public function createFaq(){
        $color = Color::where('project_site',url())->first();
        if(Auth::user()){
            if(SiteConfigurationHelper::isSiteAdmin()){
                $categories = array('General' => array('Basics', 'Regulatory', 'Legal Structure', 'Fees', 'Website'), 'Investor' => array('Investing Basics', 'Investment Type', 'Investment Specific', 'Investment Support', 'Investment Risks'), 'Property Development & Venture' => '');
                // dd($categories);
                return view('pages.createFaq', compact('categories','color'));
            }
        }
    }

    public function recieveSubCategories(){
        $subCategories =  array('General' => array('Basics', 'Regulatory', 'Legal Structure', 'Fees', 'Website'), 'Investor' => array('Investing Basics', 'Investment Type', 'Investment Specific', 'Investment Support', 'Investment Risks'), 'Property Development & Venture' => '');
        return $subCategories;
    }

    public function storeFaq(Request $request){
        if(Auth::user()){
            if(SiteConfigurationHelper::isSiteAdmin()){
                //Validate the requested form
                $this->validate($request, array(
                    'category'=>'required',
                    'question'=>'required',
                    'answer'=>'required'
                ));
                //Save to database
                $newFaq = new Faq;
                $newFaq->category = $request->category;
                $newFaq->sub_category = $request->sub_category;
                $newFaq->question = $request->question;
                $newFaq->answer = $request->answer;
                $newFaq->project_site = url();
                $newFaq->save();

                Session::flash('message', 'FAQ Created Successfully.');

                return redirect()->route('pages.faq');
            }
        }
    }
    public function editTeam(){
        $color = Color::where('project_site',url())->first();
        $user = Auth::user();
        $user_id = $user->id;
        $aboutus = Aboutus::where('project_site',url())->first();
        if($aboutus)
        {
            $member = $aboutus->member;
            return view('pages.teamedit', compact('user','aboutus','member','color'));
        }
        return view('pages.teamedit', compact('user','aboutus','color'));
    }
    public function createTeam(Request $request){
        $user = Auth::user();
        $this->validate($request, array(
            'main_heading'=>'required',
            'sub_heading'=>'required',
            'content'=>'required'
        ));
        $aboutus = new Aboutus;
        $aboutus->user_id = $user->id;
        $aboutus->project_site = url();
        $aboutus->main_heading = $request->main_heading;
        $aboutus->sub_heading = $request->sub_heading;
        $aboutus->content = $request->content;
        $aboutus->project_site = url();
        $aboutus->save();
        Session::flash('message','Updates Successfully');
        return redirect()->back();
    }
    public function updateTeam(Request $request, $id){
        $this->validate($request, array(
            'main_heading'=>'required',
            'sub_heading'=>'required',
            'content'=>'required'
        ));
        $aboutus = Aboutus::findOrFail($id);
        $some = $aboutus->update($request->all());
        return redirect()->back()->withMessage('Successfully Updated');
    }
    public function createTeamMember(Request $request,$id)
    {
        // dd($request->founder_img_path);
        $this->validate($request, array(
            'founder_name'=>'required',
            'founder_subheading'=>'required',
            'founder_content'=>'required',
            'founder_image_url'=>'required|mimes:jpeg,bmp,png,jpg,JPG',
            'founder_img_path' => 'required',
        ));
        $user = Auth::user();
        $aboutus = Aboutus::findOrFail($id);
        $team = new Member;
        // $destinationPath = 'assets/team_members/'.$aboutus->id.'';
        // if ($request->hasFile('founder_image_url') && $request->file('founder_image_url')->isValid()) {
        //     $filename1 = $request->file('founder_image_url')->getClientOriginalName();
        //     $filename1 = str_slug($filename1.' '.rand(1, 9999));
        //     $fileExtension1 = $request->file('founder_image_url')->getClientOriginalExtension();
        //     $filename1 = $filename1.'.'.$fileExtension1;
        //     $uploadStatus1 = $request->file('founder_image_url')->move($destinationPath, $filename1);
        // }
        // $finaldestination = $destinationPath.'/'.$filename1;
        $team->user_id = $user->id;
        $team->aboutus_id = $aboutus->id;
        $team->founder_name = $request->founder_name;
        $team->founder_subheading = $request->founder_subheading;
        $team->founder_content = $request->founder_content;
        // $team->founder_image_url = $finaldestination;
        $team->founder_image_url = $request->founder_img_path;
        // dd($team);
        $team->save();
        return redirect()->back()->withMessage('Member added Successfully');
    }
    public function updateTeamMember(){
        dd('sujit');
    }
    public function deleteTeamMember($aboutus_id,$member_id){
        $member = Member::findOrFail($member_id);
        \File::delete($member->founder_image_url);
        $member->delete();
        return redirect()->back()->withMessage('Deleted Successfully');
    }
    public function updateFounderLabel(Request $request){
        if (SiteConfigurationHelper::isSiteAdmin()){
            $founderLabel = $request->founder_label;
            $aboutus = Aboutus::all();
            $aboutus = $aboutus->where('project_site',url())->first();
            $aboutus->update([
                'founder_label' => $request->founder_label,
            ]);
            return redirect()->back();
        }
    }
    public function uploadMemberImgThumbnail(Request $request){
        $validation_rules = array(
            'founder_image_url'=>'required|mimes:jpeg,png,jpg,JPG'
        );
        $validator = Validator::make($request->all(), $validation_rules);
        if($validator->fails()){
            return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg,JPG');
        }
        $aboutus = Aboutus::findOrFail($request->aboutus_id);
        $destinationPath = 'assets/team_members/'.$aboutus->id.'';
        if ($request->hasFile('founder_image_url') && $request->file('founder_image_url')->isValid())
        {
            Image::make($request->founder_image_url)->resize(530, null, function($constraint){
                $constraint->aspectRatio();
            })->save();
            $filename1 = $request->file('founder_image_url')->getClientOriginalName();
            $filename1 = str_slug($filename1.' '.rand(1, 9999));
            $fileExtension1 = $request->file('founder_image_url')->getClientOriginalExtension();
            $filename1 = $filename1.'.'.$fileExtension1;
            $uploadStatus1 = $request->file('founder_image_url')->move($destinationPath, $filename1);
            $finaldestination = $destinationPath.'/'.$filename1;
            if($uploadStatus1){
                list($origWidth, $origHeight) = getimagesize($destinationPath.'/'.$filename1);
                return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $filename1, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
            }
            else {
                return $resultArray = array('status' => 0, 'message' => 'something went wrong.');
            }

        }
    }

    public function cropUploadedImage(Request $request){
        if($request->imageName){
            $src  = $request->imageName;
            $xValue = $request->xValue;
            $yValue = $request->yValue;
            $wValue = $request->wValue;
            $hValue = $request->hValue;
            $origWidth = $request->origWidth;
            $origHeight = $request->origHeight;
            $convertedWidth = 530;
            $convertedHeight = ($origHeight/$origWidth) * $convertedWidth;
            $extension = strtolower(File::extension($src));
            $img = '';
            $result = false;
            $rw = 350;
            $rh = 350;

            //Create new coords for image.
            $newXValue = ($xValue * $origWidth) / $convertedWidth;
            $newYValue = ($yValue * $origHeight) / $convertedHeight;
            $newWValue = ($wValue * $origWidth) / $convertedWidth;
            $newHValue = ($hValue * $origHeight) / $convertedHeight;

            switch ($extension) {
                case 'jpg':
                $quality = 90;
                $img  = imagecreatefromjpeg($src);
                $dest = ImageCreateTrueColor($rw, $rh);
                    //Removing black background
                imagealphablending($dest, FALSE);
                imagesavealpha($dest, TRUE);
                imagecopyresampled($dest, $img, 0, 0, $newXValue, $newYValue, $rw, $rh, $newWValue, $newHValue);
                $result = imagejpeg($dest, $src, $quality);
                break;

                case 'jpeg':
                $quality = 90;
                $img  = imagecreatefromjpeg($src);
                $dest = ImageCreateTrueColor($rw, $rh);
                    //Removing black background
                imagealphablending($dest, FALSE);
                imagesavealpha($dest, TRUE);
                imagecopyresampled($dest, $img, 0, 0, $newXValue, $newYValue, $rw, $rh, $newWValue, $newHValue);
                $result = imagejpeg($dest, $src, $quality);
                break;

                case 'png':
                $quality = 9;
                $img  = imagecreatefrompng($src);
                $dest = ImageCreateTrueColor($rw, $rh);
                    //Removing black background
                imagealphablending($dest, FALSE);
                imagesavealpha($dest, TRUE);
                imagecopyresampled($dest, $img, 0, 0, $newXValue, $newYValue, $rw, $rh, $newWValue, $newHValue);
                $result = imagepng($dest, $src, $quality);
                break;

                default:
                return $resultArray = array('status' => 0, 'message' => 'Invalid File Extension.');
                break;
            }
            if($result){
                return $resultArray = array('status' => 1, 'message' => 'Image Successfully Updated.', 'imageSource' => $src);
            } else{
                return $resultArray = array('status' => 0, 'message' => 'Failed to crop.');
            }
        }
    }
    public function changeColorFooter(Request $request)
    {
        // $this->validate($request, array(
        //     'first_color_code'=>'required',
        //     'second_color_code'=>'required'
        //     ));
        // dd($request);
        $validation_rules = array(
            'first_color_code'=>'required',
            'second_color_code'=>'required'
        );
        $validator = Validator::make($request->all(), $validation_rules);
        if($validator->fails()){
            return $resultArray = array('status' => 0, 'message' => 'Both color fields must be specified.');
        }
        $user = Auth::user();
        $color = Color::where('project_site',url())->first();
        if(!$color){
            $color = new Color;
            $color->project_site = url();
        }
        $color->user_id = $user->id;
        $color->nav_footer_color = $request->first_color_code;
        $color->heading_color = $request->second_color_code;
        $color->save();
        // return redirect()->back()->withMessage('Successfully Update color');
        return $resultArray = array('status' => 1, 'message' => 'Successfully Updated color');
    }

    public function termsConditions()
    {
        $siteConfiguration = SiteConfiguration::where('project_site', url())->first();
        $websiteName = $siteConfiguration->website_name;
        $clientName = $siteConfiguration->client_name;
        $docName = "terms-conditions-".$websiteName."-".$clientName.".pdf";
        $pdf = PDF::loadView('pdf.termsConditions');
        return $pdf->stream();
    }

    public function storeTestimonial(Request $request)
    {
        $this->validate($request, array(
            'user_name'=>'required',
            'user_summary'=>'required',
            'user_content'=>'required',
        ));
        if($request->user_image_url){
            $this->validate($request, array(
                'user_image_url'=>'mimes:jpeg,bmp,png,jpg,JPG',
                'testimonial_img_path' => 'required',
            ));
        }
        $testimonial = new Testimonial;
        $testimonial->user_name = $request->user_name;
        $testimonial->user_summary = $request->user_summary;
        $testimonial->user_content = $request->user_content;
        $testimonial->user_image_url = $request->testimonial_img_path;
        $testimonial->project_site = url();
        $testimonial->save();
        return redirect()->back()->withMessage('Member added Successfully');
    }

    public function deleteTestimonial(Request $request)
    {
        $this->validate($request, array(
            'testimonial_id'=>'required'
        ));
        $testimonial = Testimonial::find($request->testimonial_id);
        $testimonial->delete();
        return redirect()->back();
    }

    public function uploadTestimonialImgThumbnail(Request $request){
        $validation_rules = array(
            'user_image_url'=>'required|mimes:jpeg,png,jpg,JPG'
        );
        $validator = Validator::make($request->all(), $validation_rules);
        if($validator->fails()){
            return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg,JPG');
        }
        $destinationPath = 'assets/images/testimonials';
        if ($request->hasFile('user_image_url') && $request->file('user_image_url')->isValid())
        {
            Image::make($request->user_image_url)->resize(400, null, function($constraint){
                $constraint->aspectRatio();
            })->save();
            $filename1 = $request->file('user_image_url')->getClientOriginalName();
            $filename1 = str_slug($filename1.' '.rand(1, 9999));
            $fileExtension1 = $request->file('user_image_url')->getClientOriginalExtension();
            $filename1 = $filename1.'_'.time().'.'.$fileExtension1;
            $uploadStatus1 = $request->file('user_image_url')->move($destinationPath, $filename1);
            $finaldestination = $destinationPath.'/'.$filename1;
            if($uploadStatus1){
                list($origWidth, $origHeight) = getimagesize($destinationPath.'/'.$filename1);
                return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $filename1, 'origWidth' => $origWidth, 'origHeight' => $origHeight, 'imgAction' => $request->imgAction);
            }
            else {
                return $resultArray = array('status' => 0, 'message' => 'something went wrong.');
            }

        }
    }

    public function expressProjectInterest(AppMailer $mailer, Request $request)
    {
        $validation_rules = array(
            'email'=>'required|email',
            'phone'=>'required|numeric'
        );
        $validator = Validator::make($request->all(), $validation_rules);
        if ($validator->fails()){
            return $resultArray = array('status' => 0, 'message'=>$validator->messages()->first());
        }
        $projectId = $request->projectId;
        $email = $request->email;
        $phone = $request->phone;
        $project = Project::find($projectId);
        if($project){
            if($project->is_coming_soon){
                ProjectInterest::create([
                    'project_id' => $projectId,
                    'email' => $email,
                    'phone_number' => $phone,
                    'action_site' => url()
                ]);
                $mailer->sendUpcomingProjectInterestMailToAdmins($project, $email, $phone);
                return $resultArray = array('status' => 1);
            }
        }
        return $resultArray = array('status' => 0);
    }

    public function redirectUsersNotifications(){
        if(Auth::User()){
            $user = Auth::User();
            return redirect()->route('users.notifications', [$user->id]);
        }
        else {
            return redirect()->route('users.login', ['redirectNotification'=>1]);
        }
    }

    public function konkrete(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost:5050/konkrete",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
        // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        dd($response);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            print_r(json_decode($response));
        }
    }

    public function konkreteGuzzle(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET','http://localhost:5050/getBalance',[
            'query' => ['user_id' => '70','project_id'=>'13','securityTokens'=>'30']
        ]);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);
        dd($result->hash);
    }
}
