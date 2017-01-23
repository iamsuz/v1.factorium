<?php

namespace App\Http\Controllers;

use App\Role;
use App\Member;
use App\Project;
use App\Aboutus;
use App\Color;
use App\Http\Requests;
use App\Mailers\AppMailer;
use App\InvestmentInvestor;
use Illuminate\Http\Request;
use PulkitJalan\GeoIP\GeoIP;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SubdivideRequest;
use App\Faq;
use Session;
use App\SiteConfiguration;
use Validator;
use Intervention\Image\Facades\Image;
use File;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['only' => []]);
        $this->middleware('superadmin', ['only'=>['editTeam','updateTeam','updateTeam','createTeamMember','changeColorFooter','cropUploadedImage',]]);
    }
    /**
    * returns home page
    * @return view [home page is returned]
    */
    public function home() {
        // $geoip = new GeoIP();
        // $geoIpArray = $geoip->get();
        $geoIpArray = [];
        $investments = InvestmentInvestor::all();
        $role = Role::findOrFail(3);
        $investors = $role->users->count();
        $color = Color::first();
        $currentUserRole = '';
        if(Auth::guest()) {
            $projects = Project::where('active', '1')->get();
            $currentUserRole = 'guest';
        } else {
            $user = Auth::user();
            $roles = $user->roles;
            if ($roles->contains('role', 'admin')) {
                $projects = Project::whereIn('active', ['1', '2'])->get();
            } else {
                $projects = Project::where('active', '1')->get();
            }
            if(Auth::user()->roles->contains('role','superadmin')){
                $currentUserRole = 'superadmin';
            }
            else{
                $currentUserRole = Auth::user()->roles->first()->role;
            }
        }
        $blog_posts = DB::connection('mysql2')->select('select * from wp_posts where post_type="post" ORDER BY post_date DESC LIMIT 3');
        $blog_posts_attachments = DB::connection('mysql2')->select('select * from wp_posts where post_type="attachment"');
        

        $BannerCities = ['Adelaide', 'Auckland', 'Brisbane', 'Canberra', 'Darwin', 'Hobart', 'Melbourne', 'Perth', 'Sydney'];
        $siteConfiguration = SiteConfiguration::first();
        if(!$siteConfiguration)
        {
            $siteConfiguration = new SiteConfiguration;
            $siteConfiguration->save();
            $siteConfiguration = SiteConfiguration::first();
        }
        return view('pages.home', compact('geoIpArray', 'investments', 'investors', 'projects', 'BannerCities', 'blog_posts', 'blog_posts_attachments', 'currentUserRole', 'siteConfiguration','color'));
    }

    /**
    * returns team page
    * @return view [description]
    */
    public function team()
    {
        $aboutus = Aboutus::first();
        $color = Color::first();
        $adminedit = 0;
        if(Auth::user()){
            $user = Auth::user();
            $role = Role::findOrFail(3);
            $roles = $user->roles;
            if($roles->contains('role','superadmin')) {
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
        $color = Color::first();
        $faqGeneralBasics = Faq::where(['category'=>'General', 'sub_category'=> 'Basics', 'show'=>1 ])->get();
        $faqGeneralRegulatory = Faq::where(['category'=>'General', 'sub_category'=> 'Regulatory', 'show'=>1 ])->get();
        $faqGeneralLegalStructure = Faq::where(['category'=>'General', 'sub_category'=> 'Legal Structure', 'show'=>1 ])->get();
        $faqGeneralFees = Faq::where(['category'=>'General', 'sub_category'=> 'Fees', 'show'=>1 ])->get();
        $faqGeneralWebsite = Faq::where(['category'=>'General', 'sub_category'=> 'Website', 'show'=>1 ])->get();
        $faqInvestorInvestingBasics = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investing Basics', 'show'=>1 ])->get();
        $faqInvestorInvestmentType = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investment Type', 'show'=>1 ])->get();
        $faqInvestorInvestmentSpecific = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investment Specific', 'show'=>1 ])->get();
        $faqInvestorInvestmentSupport = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investment Support', 'show'=>1 ])->get();
        $faqInvestorInvestmentRisks = Faq::where(['category'=>'Investor', 'sub_category'=> 'Investment Risks', 'show'=>1 ])->get();
        $faqPropertyDevelopmentVenture = Faq::where(['category'=>'Property Development & Venture', 'show'=>1 ])->get();

        $isAdmin = false;
        if(Auth::user()){
            if(Auth::user()->roles->contains('role', 'admin') || Auth::user()->roles->contains('role', 'superadmin')){
                $isAdmin = true;
            }
        }

        return view('pages.faq', compact('faqGeneralBasics','faqGeneralRegulatory','faqGeneralLegalStructure','faqGeneralFees','faqGeneralWebsite','faqInvestorInvestingBasics','faqInvestorInvestmentType','faqInvestorInvestmentSpecific','faqInvestorInvestmentSupport','faqInvestorInvestmentRisks','faqPropertyDevelopmentVenture','isAdmin','color'));
    }
    public function financial()
    {
        $color = Color::first();
        return view('pages.financial',compact('color'));
    }

    /**
    * returns privacy page
    * @return view [description]
    */
    public function privacy()
    {
        $color = Color::first();
        return view('pages.privacy',compact('color'));
    }

    /**
    * returns terms page
    * @return view [description]
    */
    public function terms()
    {
        $color = Color::first();
        return view('pages.terms',compact('color'));
    }

    public function subdivide()
    {
        $color = Color::first();
        return view('pages.subdivide',compact('color'));
    }

    public function storeSubdivide(SubdivideRequest $request, AppMailer $mailer)
    {
        $mailer->sendSubdivideEmailToAdmin($request->all());
        return redirect()->route('pages.subdivide.thankyou');
    }

    public function subdivideThankyou()
    {
        $color = Color::first();
        return view('pages.subdivideThankyou',compact('color'));
    }

    public function deleteFaq(Request $request, $faq_id){
        if(Auth::user()){
            if(Auth::user()->roles->contains('role', 'admin') || Auth::user()->roles->contains('role', 'superadmin')){
                Faq::where('id', $faq_id)
                ->update(['show'=>0]);
                Session::flash('message', 'Successfully Deleted FAQ.');
                return redirect()->back();
            }
        }
    }

    public function createFaq(){
        $color = Color::first();
        if(Auth::user()){
            if(Auth::user()->roles->contains('role', 'admin') || Auth::user()->roles->contains('role', 'superadmin')){
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
            if(Auth::user()->roles->contains('role', 'admin') || Auth::user()->roles->contains('role', 'superadmin')){
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
                $newFaq->save();
                
                Session::flash('message', 'FAQ Created Successfully.');

                return redirect()->route('pages.faq');
            }
        }
    }
    public function editTeam(){
        $color = Color::first();
        $user = Auth::user();
        $user_id = $user->id;
        $aboutus = $user->aboutUs;
        if($user->aboutUs)
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
        $aboutus->main_heading = $request->main_heading;
        $aboutus->sub_heading = $request->sub_heading;
        $aboutus->content = $request->content;
        $aboutus->save();
        Session::flash('message','Upadates Successfully');
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
        if (Auth::user()->roles->contains('role', 'admin')){
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
                $rh = 300;

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
    }
    public function changeColorFooter(Request $request)
    {
        $this->validate($request, array(
            'first_color_code'=>'',
            'second_color_code'=>''
            ));
        // dd($request);
        $user = Auth::user();
        $color = Color::where('user_id',$user->id)->first();
        if(!$color){
            $color = new Color;
        }
        $color->user_id = $user->id;
        $color->nav_footer_color = $request->first_color_code;
        $color->heading_color = $request->second_color_code;
        $color->save();
        return redirect()->back()->withMessage('Successfully Update color');
    }
}