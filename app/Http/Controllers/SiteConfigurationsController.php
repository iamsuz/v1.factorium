<?php

namespace App\Http\Controllers;

use File;
use Session;
use App\Color;
use App\Media;
use Validator;
use App\Project;
use Carbon\Carbon;
use App\Investment;
use App\MailSetting;
use App\ProjectProg;
use App\Http\Requests;
use App\SiteConfigMedia;
use App\SiteConfiguration;
use Illuminate\Http\Request;
use App\ProjectConfiguration;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\ProjectConfigurationPartial;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class SiteConfigurationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('superadmin');
        $this->middleware('admin',['only'=>['addProgressDetails']]);
    }

    /**
     * Upload the Brand Logo to server.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadLogo(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $validation_rules = array(
                'brand_logo'   => 'required|mimes:png',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: png');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('brand_logo') && $request->file('brand_logo')->isValid()){
                $fileExt = $request->file('brand_logo')->getClientOriginalExtension();
                $fileName = time().'.'. $fileExt;
                
                $origWidth = Image::make($request->brand_logo)->width();
                $origHeight = Image::make($request->brand_logo)->height();

                $image = Image::make($request->brand_logo)->save(public_path($destinationPath.$fileName));

                if($image){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'something went wrong.');
                }
            }
        }
    }

    public function cropUploadedImage(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin'))
        {

            $type = [];
            $type['brand logo'] = 'brand_logo';
            $type['back image'] = 'homepg_back_img';
            $type['investment image'] = 'investment_page_image';
            $type['howItWorks image'] = 'how_it_works_image'.substr($request->hiwImgAction, -1);
            $type['favicon image'] = 'favicon_image_url';
            $type['project_thumbnail'] = 'project_thumbnail';
            $type['spv_logo_image'] = '';
            $type['spv_md_sign_image'] = '';
            $type['projectPg back image'] = 'projectpg_back_img';
            $type['projectPg thumbnail image'] = $request->projectThumbAction;

            if($request->imageName) {
                $src  = $request->imageName;
                $origWidth = $request->origWidth;
                $origHeight = $request->origHeight;
                $convertedWidth = 530;
                $convertedHeight = ($origHeight/$origWidth) * $convertedWidth;

                $newWValue = ($request->wValue * $origWidth) / $convertedWidth;
                $newHValue = ($request->hValue * $origHeight) / $convertedHeight;
                $newXValue = ($request->xValue * $origWidth) / $convertedWidth;
                $newYValue = ($request->yValue * $origHeight) / $convertedHeight;

                $extension = strtolower(File::extension($src));

                $projectId = '';
                if($request->projectId) {
                    $projectId = $request->projectId;
                }

                if($request->currentProjectId) {
                    $projectId = $request->currentProjectId;
                }

                $result = $this->cropImage($src, $newWValue, $newHValue, $newXValue, $newYValue);
                if ($result && !$projectId) {
                    $saveLoc = 'assets/images/media/home_page/';
                    $finalFile = time().'.'. $extension;
                    $finalpath = 'assets/images/media/home_page/'.$finalFile;
                    $image = Image::make($result)->save(public_path($saveLoc.$finalFile));

                    if($type[$request->imgAction] == 'brand_logo') {
                        $image->resize(274, null, function ($constraint) {
						    $constraint->aspectRatio();
						})->save(public_path($saveLoc.$finalFile));
                    }
                    $siteConfigurationId = SiteConfiguration::where('project_site', url())->first()->id;
                    $siteMedia = SiteConfigMedia::where('site_configuration_id', $siteConfigurationId)
                    ->where('type', $type[$request->imgAction])
                    ->first();
                    if($siteMedia) {
                        File::delete(public_path($siteMedia->path));    
                    }
                    else {
                        $siteMedia = new SiteConfigMedia;
                        $siteMedia->site_configuration_id = $siteConfigurationId;
                        $siteMedia->type = $type[$request->imgAction];
                        $siteMedia->caption = 'Home Page Main fold Back Image';
                    }
                    $siteMedia->filename = $finalFile;
                    $siteMedia->path = $finalpath;
                    $siteMedia->save();
                    File::delete($src);
                    return $resultArray = array('status' => 1, 'message' => 'Image Successfully Updated.', 'imageSource' => $src);
                } elseif ($result && $projectId) {
                    $saveLoc = 'assets/images/media/project_page/';
                    $finalFile = 'proj_'.time().'.'. $extension;
                    $finalpath = $saveLoc.$finalFile;

                    $image = Image::make($result)->save(public_path($saveLoc.$finalFile));

                    if($type[$request->imgAction] == 'projectpg_back_img') {
                        $image->resize(1080, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path($saveLoc.$finalFile));
                    }
                    $projectMedia = Media::where('project_id', $projectId)
                    ->where('project_site', url())
                    ->where('type', $type[$request->imgAction])
                    ->first();                    
                    if($projectMedia){
                            File::delete(public_path($projectMedia->path));    
                    }
                    else{
                        $projectMedia = new Media;
                        $projectMedia->project_id = $projectId;
                        $projectMedia->type = $type[$request->imgAction];
                        $projectMedia->project_site = url();
                        $projectMedia->caption = 'Project Page Main fold back Image';
                    }
                    $projectMedia->filename = $finalFile;
                    $projectMedia->path = $finalpath;
                    $projectMedia->save();
                    File::delete($src);
                    return $resultArray = array('status' => 1, 'message' => 'Image Successfully Updated.', 'imageSource' => $src);
                }

                else {
                    return $resultArray = array('status' => 0, 'message' => 'Something went wrong.');
                }
            }

        }
    }

    public function cropImage($srcImg, $wValue, $hValue, $xValue, $yValue)
    {
        $bg_image = Image::make($srcImg);
        return $bg_image->crop( (int) $wValue, (int) $hValue, (int) $xValue, (int) $yValue);
    }

    public function saveHomePageText1(Request $request)
    {
        $str = $request->text1;
        $siteconfiguration = SiteConfiguration::all();
        $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
        if(!$siteconfiguration)
        {
            $siteconfiguration = new SiteConfiguration;
            $siteconfiguration->save();
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
        }
        $siteconfiguration->update(['homepg_text1' => $str]);
        return array('status' => 1, 'Message' => 'Data Successfully Updated');
    }

    public function saveHomePageBtn1Text(Request $request)
    {
        $uinput = $request->text1;
        $gotoid = $request->gotoid;
        $siteconfiguration = SiteConfiguration::all();
        $siteconfiguration = $siteconfiguration->where('project_site',url());
            // dd($siteconfiguration);
        if($siteconfiguration->isEmpty())
        {
            $siteconfiguration = new SiteConfiguration;
            $siteconfiguration->project_site = url(); 
            $siteconfiguration->save();
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();        
        }
        $siteconfiguration = $siteconfiguration->first();
        $siteconfiguration->update(['homepg_btn1_text' => $uinput,'homepg_btn1_gotoid' => $gotoid]);
        return array('status' => 1, 'Message' => 'Data Successfully Updated');
    }

    public function uploadHomePgBackImg1 (Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $validation_rules = array(
                'homepg_back_img'   => 'required|mimes:jpeg,png,jpg',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('homepg_back_img') && $request->file('homepg_back_img')->isValid()){
                // Image::make($request->homepg_back_img)->resize(530, null, function($constraint){
                //     $constraint->aspectRatio();
                // })->save();
                // Image::make($request->homepg_back_img)->resize(1920, null, function($constraint){
                //     $constraint->aspectRatio();
                // })->save();
                $fileExt = $request->file('homepg_back_img')->getClientOriginalExtension();
                $fileName = 'main_bg'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('homepg_back_img')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus) {
                    if($fileExt != 'jpg') {
                        Image::make($destinationPath.$fileName)->encode('jpg', 90)->save(public_path('assets/images/main_bg.jpg'));
                    }
                    else {
                        Image::make($destinationPath.$fileName)->save(public_path('assets/images/main_bg.jpg'));
                    }
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }
    }

    public function updateFavicon(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $validation_rules = array(
                'favicon_image_url'   => 'required|mimes:png',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: png');
            }
            $destinationPath = '/';

            if($request->hasFile('favicon_image_url') && $request->file('favicon_image_url')->isValid()){
                Image::make($request->favicon_image_url)->resize(null, 200, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('favicon_image_url')->getClientOriginalExtension();
                $fileName = 'favicon'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('favicon_image_url')->move(public_path($destinationPath), $fileName);
                list($origWidth, $origHeight) = getimagesize(public_path($destinationPath).$fileName);
                if($uploadStatus){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }    if (Auth::user()->roles->contains('role', 'superadmin')){
            $validation_rules = array(
                'favicon_image_url'   => 'required|mimes:png',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: png');
            }
            $destinationPath = '/';

            if($request->hasFile('favicon_image_url') && $request->file('favicon_image_url')->isValid()){
                Image::make($request->favicon_image_url)->resize(null, 200, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('favicon_image_url')->getClientOriginalExtension();
                $fileName = 'favicon'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('favicon_image_url')->move(public_path($destinationPath), $fileName);
                list($origWidth, $origHeight) = getimagesize(public_path($destinationPath).$fileName);
                if($uploadStatus){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }    
    }

    public function updateSiteTitle(Request $request)
    {
        $title = $request->title_text_imput;
        if($title != ""){
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            if(!$siteconfiguration)
            {
                $siteconfiguration = new SiteConfiguration;
                $siteconfiguration->project_site = url();
                $siteconfiguration->save();
                $siteconfiguration = SiteConfiguration::all();
                $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            }
            $siteconfiguration->update(['title_text'=>$title]);
            Session::flash('message', 'Title Updated Successfully');
            Session::flash('action', 'site-title');
            return redirect()->back();
        }
    }

    public function updateWebsiteName(Request $request)
    {
        $websiteName = $request->site_name_input;
        if($websiteName != ""){
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            if(!$siteconfiguration)
            {
                $siteconfiguration = new SiteConfiguration;
                $siteconfiguration->project_site = url();
                $siteconfiguration->save();
                $siteconfiguration = SiteConfiguration::all();
                $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            }
            $siteconfiguration->update(['website_name'=>$websiteName]);
            Session::flash('message', 'Website Name Updated Successfully');
            Session::flash('action', 'website-name');
            return redirect()->back();
        }
    }

    public function updateSocialSiteLinks(Request $request)
    {
        $this->validate($request, array(
            'facebook_link' => 'url|required',
            'twitter_link' => 'url|required',
            'youtube_link' => 'url|required',
            'linkedin_link' => 'url|required',
            'google_link' => 'url|required',
            'instagram_link' => 'url|required',
            ));
        $siteconfiguration = SiteConfiguration::all();
        $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
        // dd($siteconfiguration);
        $result = $siteconfiguration->update([
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
            'youtube_link' => $request->youtube_link,
            'linkedin_link' => $request->linkedin_link,
            'google_link' => $request->google_link,
            'instagram_link' => $request->instagram_link,
            ]);
        if($result){
            Session::flash('socialLinkUpdateMessage', 'Saved Successfully');
        }
        return redirect()->back();
    }

    public function updateSitemapLinks(Request $request)
    {
        $this->validate($request, array(
            'blog_link' => 'url|required',
            // 'terms_conditions_link' => 'url|required',
            // 'privacy_link' => 'url|required',
            // 'financial_service_guide_link' => 'url|required',
            // 'media_kit_link' => 'url|required',
            ));
        $siteconfiguration = SiteConfiguration::all();
        $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
        $result = $siteconfiguration->update([
            'blog_link' => $request->blog_link,
            // 'terms_conditions_link' => $request->terms_conditions_link,
            // 'privacy_link' => $request->privacy_link,
            // 'financial_service_guide_link' => $request->financial_service_guide_link,
            // 'media_kit_link' => $request->media_kit_link,
            ]);
        if($result){
            Session::flash('sitemapLinksUpdateMessage', 'Saved Successfully');
        }
        return redirect()->back();
    }

    public function editHomePgInvestmentTitle1(Request $request)
    {
        $this->validate($request, array(
            'investment_title_text1' => 'required',
            ));
        $siteconfiguration = SiteConfiguration::all();
        $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
        $siteconfiguration->update([
            'investment_title_text1' => $request->investment_title_text1,
            ]);
        return redirect()->back();
    }

    public function editHomePgInvestmentTitle1Description(Request $request)
    {
        $this->validate($request, array(
            'investment_title1_description' => 'required',
            ));
        $siteconfiguration = SiteConfiguration::all();
        $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
        $siteconfiguration->update([
            'investment_title1_description' => $request->investment_title1_description,
            ]);
        return redirect()->back();
    }

    public function uploadHomePgInvestmentImage(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $validation_rules = array(
                'investment_page_image'   => 'required|mimes:jpeg,png,jpg',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('investment_page_image') && $request->file('investment_page_image')->isValid()){
                Image::make($request->investment_page_image)->resize(530, null, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('investment_page_image')->getClientOriginalExtension();
                $fileName = 'Disclosure-250'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('investment_page_image')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }
    }

    public function storeShowFundingOptionsFlag(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $fundingFlag = $request->show_funding_options;
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            $siteconfiguration->update([
                'show_funding_options' => $request->show_funding_options,
                ]);
            return redirect()->back();
        }
    }

    public function storeHowItWorksContent(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $this->validate($request, array(
                'how_it_works_title1' => 'required',
                'how_it_works_title2' => 'required',
                'how_it_works_title3' => 'required',
                'how_it_works_title4' => 'required',
                'how_it_works_title5' => 'required',
                'how_it_works_desc1' => 'required',
                'how_it_works_desc2' => 'required',
                'how_it_works_desc3' => 'required',
                'how_it_works_desc4' => 'required',
                'how_it_works_desc5' => 'required',
                ));
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            // trim(preg_replace('/\s+/', ' ', $string));
            $siteconfiguration->update([
                'how_it_works_title1' => $request->how_it_works_title1,
                'how_it_works_title2' => $request->how_it_works_title2,
                'how_it_works_title3' => $request->how_it_works_title3,
                'how_it_works_title4' => $request->how_it_works_title4,
                'how_it_works_title5' => $request->how_it_works_title5,
                'how_it_works_desc1' => trim(preg_replace('/\s+/', ' ', $request->how_it_works_desc1)),
                'how_it_works_desc2' => trim(preg_replace('/\s+/', ' ', $request->how_it_works_desc2)),
                'how_it_works_desc3' => trim(preg_replace('/\s+/', ' ', $request->how_it_works_desc3)),
                'how_it_works_desc4' => trim(preg_replace('/\s+/', ' ', $request->how_it_works_desc4)),
                'how_it_works_desc5' => trim(preg_replace('/\s+/', ' ', $request->how_it_works_desc5)),
                ]);
            return redirect()->back();
        }
    }
    public function uploadProgressImage(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        // dd($project);
        $image_type = 'progress_images';

        $destinationPath = 'assets/images/projects/progress/'.$project_id;
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
    public function uploadGallaryImage(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        // dd($project);
        $image_type = 'gallary_images';

        $destinationPath = 'assets/images/projects/gallary/'.$project_id;
        $filename = $request->file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $extension = $request->file->getClientOriginalExtension();
        $photo = $request->file->move($destinationPath, $filename);
        $photo= Image::make($destinationPath.'/'.$filename);
        $photo->resize(1566, 885, function ($constraint) {
            $constraint->aspectRatio();
        })->save();
        $media = new \App\Media(['type'=>$image_type, 'filename'=>$filename, 'path'=>$destinationPath.'/'.$filename, 'thumbnail_path'=>$destinationPath.'/'.$filename,'extension'=>$extension, 'project_site'=>url()]);
        $project->media()->save($media);
        return 1;
    }

    public function uploadHowItWorksImages(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $validation_rules = array(
                'how_it_works_image'   => 'required|mimes:jpeg,png,jpg',
                'imgAction' => 'required',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('how_it_works_image') && $request->file('how_it_works_image')->isValid()){
                Image::make($request->how_it_works_image)->resize(530, null, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('how_it_works_image')->getClientOriginalExtension();
                $fileName = 'how_it_works_img'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('how_it_works_image')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
                    // if($fileExt != 'png'){
                    //     Image::make($destinationPath.$fileName)->encode('png', 9)->save(public_path('assets/images/main_bg.jpg'));
                    // }
                    // else{
                    //     Image::make($destinationPath.$fileName)->save(public_path('assets/images/main_bg.jpg'));
                    // }
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }
    }
    public function addProgressDetails(Request $request, $project_id)
    {
        $this->validate($request, array(
            'updated_date'=>'required|date',
            'progress_description'=>'required',
            'progress_details'=>'required',
            'video_url'=>''
            ));
        // dd($request->updated_date);
        $project = Project::findOrFail($project_id);
        $project_prog = new ProjectProg;
        $project_prog->project_id = $project_id;
        $project_prog->updated_date = \DateTime::createFromFormat('m/d/Y', $request->updated_date);
        // dd($project_prog->updated_date);
        $project_prog->progress_description = $request->progress_description;
        $project_prog->progress_details = $request->progress_details;
        $project_prog->video_url = $request->video_url;
        $project_prog->save();
        return redirect()->back();
    }

    public function updateProjectDetails(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $this->validate($request, array(
                'project_title_txt' => 'required',
                'project_description_txt' => 'required',
                ));
            $projectId = $request->current_project_id;
            Project::where('id', $projectId)->update([
                'title' => $request->project_title_txt,
                'description' => $request->project_description_txt,
                'button_label'=>$request->project_button_invest_txt,
                ]);
            Investment::where('project_id', $projectId)->first()->update([
                'minimum_accepted_amount' => $request->project_min_investment_txt,
                'hold_period' => $request->project_hold_period_txt,
                'projected_returns' => $request->project_returns_txt,
                'goal_amount' => $request->project_goal_amount_txt,
                'summary' => trim(preg_replace('/\s+/', ' ', $request->project_summary_txt)),
                'security_long' => trim(preg_replace('/\s+/', ' ', $request->project_security_long_txt)),
                'exit_d' => trim(preg_replace('/\s+/', ' ', $request->project_investor_distribution_txt)),
                'marketability' => trim(preg_replace('/\s+/', ' ', $request->project_marketability_txt)),
                'residents' => trim(preg_replace('/\s+/', ' ', $request->project_residents_txt)),
                'investment_type' => trim(preg_replace('/\s+/', ' ', $request->project_investment_type_txt)),
                'security' => trim(preg_replace('/\s+/', ' ', $request->project_security_txt)),
                'expected_returns_long' => trim(preg_replace('/\s+/', ' ', $request->project_expected_returns_txt)),
                'returns_paid_as' => trim(preg_replace('/\s+/', ' ', $request->project_return_paid_as_txt)),
                'taxation' => trim(preg_replace('/\s+/', ' ', $request->project_taxation_txt)),
                'proposer' => trim(preg_replace('/\s+/', ' ', $request->project_developer_txt)),
                'current_status' => trim(preg_replace('/\s+/', ' ', $request->project_current_status_txt)),
                'rationale' => trim(preg_replace('/\s+/', ' ', $request->project_rationale_txt)),
                'risk' => trim(preg_replace('/\s+/', ' ', $request->project_risk_txt)),
                'PDS_part_1_link' => $request->project_pds1_link_txt,
                'PDS_part_2_link' => $request->project_pds2_link_txt,
                'how_to_invest' => trim(preg_replace('/\s+/', ' ', $request->project_how_to_invest_txt)),
                'bank' => trim($request->bank_name),
                'bank_account_name' => trim($request->account_name),
                'bsb' => trim($request->bsb_name),
                'bank_account_number' => trim($request->account_number),
                'bank_reference' => trim($request->bank_reference),
                ]);
            return redirect()->back();
        }
    }
    public function uploadProjectPgBackImg(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $validation_rules = array(
                'projectpg_back_img'   => 'required|mimes:jpeg,png,jpg',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('projectpg_back_img') && $request->file('projectpg_back_img')->isValid()){
                Image::make($request->projectpg_back_img)->resize(1510, null, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('projectpg_back_img')->getClientOriginalExtension();
                $fileName = 'bgimage_sample'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('projectpg_back_img')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }
    }
    
    public function editHomePgFundingSectionContent(Request $request)
    {
        $this->validate($request, array(
            'funding_section_title1' => 'required',
            'funding_section_title2' => 'required',
            'funding_section_btn1_text' => 'required',
            'funding_section_btn2_text' => 'required',
            ));
        SiteConfiguration::where('project_site', url())->first()->update([
            'funding_section_title1' => trim(preg_replace('/\s+/', ' ', $request->funding_section_title1)),
            'funding_section_title2' => trim(preg_replace('/\s+/', ' ', $request->funding_section_title2)),
            'funding_section_btn1_text' => $request->funding_section_btn1_text,
            'funding_section_btn2_text' => $request->funding_section_btn2_text,
            ]);
        return redirect()->back();
    }

    public function uploadprojectPgThumbnailImages(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'superadmin')){
            $validation_rules = array(
                'projectpg_thumbnail_image'   => 'required|mimes:jpeg,png,jpg',
                'imgAction' => 'required',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('projectpg_thumbnail_image') && $request->file('projectpg_thumbnail_image')->isValid()){
                Image::make($request->projectpg_thumbnail_image)->resize(530, null, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('projectpg_thumbnail_image')->getClientOriginalExtension();
                $fileName = 'projectpg_thumbnail_image'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('projectpg_thumbnail_image')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }
    }

    public function updateProjectSpvLogo(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'admin')){
            $validation_rules = array(
                'spv_logo'   => 'required|mimes:png,jpg,jpeg',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: png,jpg,jpeg');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('spv_logo') && $request->file('spv_logo')->isValid()){
                Image::make($request->spv_logo)->resize(450, null, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('spv_logo')->getClientOriginalExtension();
                $fileName = 'spv_logo'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('spv_logo')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }
    }

    public function updateProjectSpvMDSign(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'admin')){
            $validation_rules = array(
                'spv_md_sign'   => 'required|mimes:png,jpg,jpeg',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: png,jpg,jpeg');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('spv_md_sign') && $request->file('spv_md_sign')->isValid()){
                Image::make($request->spv_md_sign)->resize(400, null, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('spv_md_sign')->getClientOriginalExtension();
                $fileName = 'spv_md_sign'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('spv_md_sign')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }
    }

    public function updateClientName(Request $request)
    {
        $clientName = $request->client_name_input;
        if($clientName != ""){
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            if(!$siteconfiguration)
            {
                $siteconfiguration = new SiteConfiguration;
                $siteconfiguration->project_site = url();
                $siteconfiguration->save();
                $siteconfiguration = SiteConfiguration::all();
                $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            }
            $siteconfiguration->update(['client_name'=>$clientName]);
            Session::flash('message', 'Client Name Updated Successfully');
            Session::flash('action', 'client-name');
            return redirect()->back();
        }
    }

    public function uploadProjectThumbImage(Request $request)
    {
        if (Auth::user()->roles->contains('role', 'admin')){
            $validation_rules = array(
                'project_thumb_image'   => 'required|mimes:jpeg,png,jpg',
                'imgAction' => 'required',
                'projectId' => 'required',
                );
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->fails()){
                return $resultArray = array('status' => 0, 'message' => 'The user image must be a file of type: jpeg,png,jpg');
            }
            $destinationPath = 'assets/images/websiteLogo/';

            if($request->hasFile('project_thumb_image') && $request->file('project_thumb_image')->isValid()){
                // Image::make($request->project_thumb_image)->resize(530, null, function($constraint){
                //     $constraint->aspectRatio();
                // })->save();
                $fileExt = $request->file('project_thumb_image')->getClientOriginalExtension();
                $fileName = 'project_thumbnail_'.$request->projectId.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('project_thumb_image')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
                    return $resultArray = array('status' => 1, 'message' => 'Image Uploaded Successfully', 'destPath' => $destinationPath, 'fileName' => $fileName, 'origWidth' =>$origWidth, 'origHeight' => $origHeight);
                }
                else {
                    return $resultArray = array('status' => 0, 'message' => 'Image upload failed.');
                }
            }
        }
    }

    public function saveShowMapStatus(Request $request)
    {
        $showMap = 0;
        if($request->showMap == 'true'){
            $showMap = 1;
        }
        $projectId =$request->projectId;
        $projectConfiguration = ProjectConfiguration::all();
        $projectConfiguration = $projectConfiguration->where('project_id', (int)$projectId)->first();
        if(!$projectConfiguration)
        {
            $projectConfiguration = new ProjectConfiguration;
            $projectConfiguration->project_id = (int)$projectId;
            $projectConfiguration->save();
            $projectConfiguration = ProjectConfiguration::all();
            $projectConfiguration = $projectConfiguration->where('project_id', $projectId)->first();
        }
        $projectConfiguration->update(['show_suburb_profile_map'=>$showMap]);
        return $resultArray = array('status' => 1);
    }

    public function updateProjectPageSubHeading(Request $request)
    {
        $projectId =$request->projectId;
        $projectConfiguration = ProjectConfiguration::all();
        $projectConfiguration = $projectConfiguration->where('project_id', (int)$projectId)->first();
        if(!$projectConfiguration)
        {
            $projectConfiguration = new ProjectConfiguration;
            $projectConfiguration->project_id = (int)$projectId;
            $projectConfiguration->save();
            $projectConfiguration = ProjectConfiguration::all();
            $projectConfiguration = $projectConfiguration->where('project_id', $projectId)->first();
        }
        $projectConfiguration->update([
            'project_summary_label'=>$request->project_summary_label,
            'summary_label'=>$request->summary_label,
            'security_label'=>$request->security_label,
            'investor_distribution_label'=>$request->investor_distribution_label,
            'suburb_profile_label'=>$request->suburb_profile_label,
            'marketability_label'=>$request->marketability_label,
            'residents_label'=>$request->residents_label,
            'investment_profile_label'=>$request->investment_profile_label,
            'investment_type_label'=>$request->investment_type_label,
            'investment_security_label'=>$request->investment_security_label,
            'expected_returns_label'=>$request->expected_returns_label,
            'return_paid_as_label'=>$request->return_paid_as_label,
            'taxation_label'=>$request->taxation_label,
            'project_profile_label'=>$request->project_profile_label,
            'developer_label'=>$request->developer_label,
            'venture_label'=>$request->venture_label,
            'duration_label'=>$request->duration_label,
            'current_status_label'=>$request->current_status_label,
            'rationale_label'=>$request->rationale_label,
            'investment_risk_label'=>$request->investment_risk_label,
            ]);
        return $resultArray = array('status' => 1);
    }

    public function updateOverlayOpacity(Request $request)
    {
        $action = $request->action;
        if($action != ''){
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            if(!$siteconfiguration)
            {
                $siteconfiguration = new SiteConfiguration;
                $siteconfiguration->project_site = url();
                $siteconfiguration->save();
                $siteconfiguration = SiteConfiguration::all();
                $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            }
            $overlayOpacity = $siteconfiguration->overlay_opacity;
            if($action == 'increase' && $overlayOpacity<1.0){
                $overlayOpacity += 0.1;
            }
            if($action == 'decrease' && $overlayOpacity>0.0){
                $overlayOpacity -= 0.1;
            }
            $siteconfiguration->update(['overlay_opacity'=>$overlayOpacity]);
            return $resultArray = array('status' => 1, 'opacity' => $siteconfiguration->overlay_opacity);
        }
    }

    public function updateProjectPgOverlayOpacity(Request $request)
    {
        $action = $request->action;
        if($action != ''){
            $projectId =$request->projectId;
            $projectConfigurationPartial = ProjectConfigurationPartial::all();
            $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', (int)$projectId)->first();
            if(!$projectConfigurationPartial)
            {
                $projectConfigurationPartial = new ProjectConfigurationPartial;
                $projectConfigurationPartial->project_id = (int)$projectId;
                $projectConfigurationPartial->save();
                $projectConfigurationPartial = ProjectConfigurationPartial::all();
                $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', $projectId)->first();
            }
            $overlayOpacity = $projectConfigurationPartial->overlay_opacity;
            if($action == 'increase' && $overlayOpacity<1.0){
                $overlayOpacity += 0.1;
            }
            if($action == 'decrease' && $overlayOpacity>0.0){
                $overlayOpacity -= 0.1;
            }
            $projectConfigurationPartial->update(['overlay_opacity'=>$overlayOpacity]);
            return $resultArray = array('status' => 1, 'opacity' => $projectConfigurationPartial->overlay_opacity);
        }
    }
    public function createMailSettings(Request $request)
    {
        $this->validate($request, array(
            'driver'=>'required',
            'encryption'=>'required',
            'host'=>'required',
            'port'=>'required',
            'from'=>'required',
            'username'=>'required',
            'password'=>'required'
            ));
        $siteconfiguration = SiteConfiguration::where('project_site',url())->first();
        $mail_setting = new MailSetting;
        $mail_setting->site_configuration_id = $siteconfiguration->id;
        $mail_setting->driver = $request->driver; 
        $mail_setting->encryption = $request->encryption;
        $mail_setting->host = $request->host;
        $mail_setting->port = $request->port;
        $mail_setting->from = $request->from;
        $mail_setting->username = $request->username;
        $mail_setting->password = $request->password;
        $mail_setting->save();
        Session::flash('message', 'Mail Settings Created Successfully');
        Session::flash('action', 'mail_setting');
        return redirect()->back();
    }
    public function updateMailSetting(Request $request, $id)
    {
        $this->validate($request, array(
            'driver'=>'required',
            'encryption'=>'required',
            'host'=>'required',
            'port'=>'required',
            'from'=>'required',
            'username'=>'required',
            'password'=>'required'
            ));
        $mail_setting = MailSetting::findOrFail($id);
        $mail_setting->update($request->all());
        Session::flash('message', 'Mail Settings Updated Successfully');
        Session::flash('action', 'mail_setting');
        return redirect()->back();
    }
    public function toggleSubSectionsVisibility(Request $request)
    {
        $action = $request->action;
        if($action != ''){
            $projectId =$request->projectId;
            $projectConfigurationPartial = ProjectConfigurationPartial::all();
            $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', (int)$projectId)->first();
            if(!$projectConfigurationPartial)
            {
                $projectConfigurationPartial = new ProjectConfigurationPartial;
                $projectConfigurationPartial->project_id = (int)$projectId;
                $projectConfigurationPartial->save();
                $projectConfigurationPartial = ProjectConfigurationPartial::all();
                $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', $projectId)->first();
            }
            $projectConfigurationPartial->update([$action=>$request->checkValue]);
            return $resultArray = array('status' => 1);
        }   
    }
    public function toggleProspectusText(Request $request)
    {
        $projectId =$request->projectId;
        $projectConfigurationPartial = ProjectConfigurationPartial::all();
        $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', (int)$projectId)->first();
        if(!$projectConfigurationPartial)
        {
            $projectConfigurationPartial = new ProjectConfigurationPartial;
            $projectConfigurationPartial->project_id = (int)$projectId;
            $projectConfigurationPartial->save();
            $projectConfigurationPartial = ProjectConfigurationPartial::all();
            $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', $projectId)->first();
        }
        $projectConfigurationPartial->update(['show_prospectus_text'=>$request->checkValue]);
        return $resultArray = array('status' => 1);
    }

    public function toggleProjectProgress(Request $request)
    {
        $projectId =$request->projectId;
        $projectConfigurationPartial = ProjectConfigurationPartial::all();
        $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', (int)$projectId)->first();
        if(!$projectConfigurationPartial)
        {
            $projectConfigurationPartial = new ProjectConfigurationPartial;
            $projectConfigurationPartial->project_id = (int)$projectId;
            $projectConfigurationPartial->save();
            $projectConfigurationPartial = ProjectConfigurationPartial::all();
            $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', $projectId)->first();
        }
        $projectConfigurationPartial->update(['show_project_progress'=>$request->checkValue]);
        return $resultArray = array('status' => 1);
    }

    public function swapProjectRanking(Request $request)
    {
        $project0 = Project::where('project_rank', (int)$request->projectRanks[0])->first();
        $project1 = Project::where('project_rank', (int)$request->projectRanks[1])->first();
        $project0->update(['project_rank' => (int)$request->projectRanks[1]]);
        $project1->update(['project_rank' => (int)$request->projectRanks[0]]);
        return $resultArray = array('status' => 1);
    }

    public function toggleProjectElementVisibility(Request $request)
    {
        $toggleAction = $request->toggleAction;
        if($toggleAction){
            $projectId =$request->projectId;
            $projectConfigurationPartial = ProjectConfigurationPartial::all();
            $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', (int)$projectId)->first();
            if(!$projectConfigurationPartial)
            {
                $projectConfigurationPartial = new ProjectConfigurationPartial;
                $projectConfigurationPartial->project_id = (int)$projectId;
                $projectConfigurationPartial->save();
                $projectConfigurationPartial = ProjectConfigurationPartial::all();
                $projectConfigurationPartial = $projectConfigurationPartial->where('project_id', $projectId)->first();
            }
            $projectConfigurationPartial->update(['show_'.$toggleAction=>$request->checkValue]);
            return $resultArray = array('status' => 1);
        }
    }

    public function editProjectPageLabelText(Request $request)
    {
        $newLabelText = $request->newLabelText;
        $projectId = $request->projectId;
        $effectScope = $request->effect;
        if($projectId!='' && $newLabelText!=''){
            $projectConfiguration = ProjectConfiguration::all();
            $projectConfiguration = $projectConfiguration->where('project_id', (int)$projectId)->first();
            if(!$projectConfiguration)
            {
                $projectConfiguration = new ProjectConfiguration;
                $projectConfiguration->project_id = (int)$projectId;
                $projectConfiguration->save();
                $projectConfiguration = ProjectConfiguration::all();
                $projectConfiguration = $projectConfiguration->where('project_id', $projectId)->first();
            }
            $projectConfiguration->update([$effectScope => $newLabelText]);
            return array('status' => 1, 'newLabelText' => $newLabelText);
        }
    }

    public function editVisibilityOfSiteConfigItems(Request $request)
    {
        $checkValue = $request->checkValue;
        $action = $request->action;
        if($action != ''){
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            $siteconfiguration->update([$action=>$request->checkValue]);
            return $resultArray = array('status' => 1);            
        }
    }

    public function updateInterestFormLink(Request $request)
    {
        $interestLink = $request->interest_link_input;
        if($interestLink != ""){
            $siteconfiguration = SiteConfiguration::all();
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
            $siteconfiguration->update(['embedded_offer_doc_link'=>$interestLink]);
            Session::flash('message', 'Interest Link Updated Successfully');
            Session::flash('action', 'embedded_link');
            return redirect()->back();
        }        
    }
}
