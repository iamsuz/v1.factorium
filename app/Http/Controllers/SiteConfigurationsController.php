<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Color;
use App\Project;
use Carbon\Carbon;
use App\ProjectProg;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use Intervention\Image\Facades\Image;
use File;
use Illuminate\Support\Facades\Storage;
use App\SiteConfiguration;
use App\Investment;


class SiteConfigurationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('superadmin');
        $this->middleware('admin',['only'=>['addProgressDetails']]);
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
        //
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
                Image::make($request->brand_logo)->resize(530, null, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('brand_logo')->getClientOriginalExtension();
                $fileName = 'vestabyte_logo'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('brand_logo')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
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


                if($request->imgAction == 'brand logo'){
                    $quality = 9;
                    $img  = imagecreatefrompng($src);
                    $dest = ImageCreateTrueColor(530, 186);
                    
                    //Removing black background
                    imagealphablending($dest, FALSE);
                    imagesavealpha($dest, TRUE);
                    imagecopyresampled ( $dest , $img , 0 , 0 , $xValue , $yValue , 530 , 186 , $wValue , $hValue );                                
                    $newimage = imagepng($dest, $src, $quality);
                    if($newimage)
                    {
                        Image::make($src)->resize(530, null, function($constraint){ $constraint->aspectRatio(); })->save(public_path('assets/images/vestabyte_logo.png'));
                        Image::make($src)->resize(284, null, function($constraint){ $constraint->aspectRatio(); })->save(public_path('assets/images/header_logo.png'));
                        Image::make($src)->resize(284, null, function($constraint){ $constraint->aspectRatio(); })->save(public_path('assets/images/main_logo.png'));
                        File::delete($src);
                        return $resultArray = array('status' => 1, 'message' => 'Image Successfully Updated.', 'imageSource' => $src);
                    }
                    else
                    {
                        return $resultArray = array('status' => 0, 'message' => 'something went wrong.');
                    }
                }
                else if ($request->imgAction == 'back image'){
                    $extension = strtolower(File::extension($src));
                    $img = '';
                    $result = false;
                    $rw = 1920;
                    $rh = 1170;

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
                        // dd($extension);
                        if($extension != 'png'){
                            Image::make($src)->encode('png', 9)->save(public_path('assets/images/main_bg.png'));
                        }
                        else{
                            Image::make($src)->save(public_path('assets/images/main_bg.png'));
                        }
                        File::delete($src);
                        return $resultArray = array('status' => 1, 'message' => 'Image Successfully Updated.', 'imageSource' => $src);
                    } else{
                        return $resultArray = array('status' => 0, 'message' => 'Something went wrong.');
                    }
                }
                else if ($request->imgAction == 'investment image') {
                    $extension = strtolower(File::extension($src));
                    $img = '';
                    $result = false;
                    $rw = 190;
                    $rh = 244;

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
                        // dd($extension);
                        if($extension != 'png'){
                            Image::make($src)->encode('png', 9)->save(public_path('assets/images/Disclosure-250.png'));
                        }
                        else{
                            Image::make($src)->save(public_path('assets/images/Disclosure-250.png'));
                        }
                        File::delete($src);
                        return $resultArray = array('status' => 1, 'message' => 'Image Successfully Updated.', 'imageSource' => $src);
                    } else{
                        return $resultArray = array('status' => 0, 'message' => 'Something went wrong.');
                    }
                }
                else if ($request->imgAction == 'howItWorks image'){
                    $extension = strtolower(File::extension($src));
                    $img = '';
                    $result = false;
                    $rw = 200;
                    $rh = 200;

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
                    $imgName = '';
                    if($request->hiwImgAction == 'hiw_img1'){
                        $imgName = '1.png';
                    }
                    else if ($request->hiwImgAction == 'hiw_img2'){
                        $imgName = '2.png';
                    }
                    else if ($request->hiwImgAction == 'hiw_img3'){
                        $imgName = '3.png';
                    }
                    else if ($request->hiwImgAction == 'hiw_img4'){
                        $imgName = '4.png';
                    }
                    else{
                        $imgName = '5.png';
                    }
                    if($result){
                        if($extension != 'png'){
                            Image::make($src)->encode('png', 9)->save(public_path('assets/images/'.$imgName));
                        }
                        else{
                            Image::make($src)->save(public_path('assets/images/'.$imgName));
                        }
                        File::delete($src);
                        return $resultArray = array('status' => 1, 'message' => 'Image Successfully Updated.', 'imageSource' => $src);
                    } else{
                        return $resultArray = array('status' => 0, 'message' => 'Something went wrong.');
                    }
                }
                else if ($request->imgAction == 'projectPg back image'){
                    $extension = strtolower(File::extension($src));
                    $img = '';
                    $result = false;
                    $rw = 1510;
                    $rh = 782;
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
                        if($extension != 'png'){
                            Image::make($src)->encode('png', 9)->save(public_path('assets/images/bgimage_sample.png'));
                        }
                        else{
                            Image::make($src)->save(public_path('assets/images/bgimage_sample.png'));
                        }
                        File::delete($src);
                        return $resultArray = array('status' => 1, 'message' => 'Image Successfully Updated.', 'imageSource' => $src);
                    } else{
                        return $resultArray = array('status' => 0, 'message' => 'Something went wrong.');
                    }
                }
                else {}
            }
        }
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
            $siteconfiguration = $siteconfiguration->where('project_site',url())->first();        }
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
                Image::make($request->homepg_back_img)->resize(1920, null, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('homepg_back_img')->getClientOriginalExtension();
                $fileName = 'main_bg'.'_'.time().'.'.$fileExt;
                $uploadStatus = $request->file('homepg_back_img')->move($destinationPath, $fileName);
                list($origWidth, $origHeight) = getimagesize($destinationPath.$fileName);
                if($uploadStatus){
                    if($fileExt != 'jpg'){
                        Image::make($destinationPath.$fileName)->encode('jpg', 90)->save(public_path('assets/images/main_bg.jpg'));
                    }
                    else{
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
            $this->validate($request, array(
            'favicon_image_url'   => 'required|mimes:png',
            ));
            $destinationPath = public_path('/');
        
            if($request->hasFile('favicon_image_url') && $request->file('favicon_image_url')->isValid()){
                Image::make($request->favicon_image_url)->resize(null, 200, function($constraint){
                    $constraint->aspectRatio();
                })->save();
                $fileExt = $request->file('favicon_image_url')->getClientOriginalExtension();
                $fileName = 'favicon.'.$fileExt;
                $uploadStatus = $request->file('favicon_image_url')->move($destinationPath, $fileName);
                if($uploadStatus){
                    Session::flash('message', 'Favicon Updated Successfully');
                    Session::flash('action', 'site-favicon');
                }
                return redirect()->back();
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
            'terms_conditions_link' => 'url|required',
            'privacy_link' => 'url|required',
            'financial_service_guide_link' => 'url|required',
            'media_kit_link' => 'url|required',
            ));
        $siteconfiguration = SiteConfiguration::all();
        $siteconfiguration = $siteconfiguration->where('project_site',url())->first();
        $result = $siteconfiguration->update([
            'blog_link' => $request->blog_link,
            'terms_conditions_link' => $request->terms_conditions_link,
            'privacy_link' => $request->privacy_link,
            'financial_service_guide_link' => $request->financial_service_guide_link,
            'media_kit_link' => $request->media_kit_link,
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
            $siteconfiguration->update([
                'how_it_works_title1' => $request->how_it_works_title1,
                'how_it_works_title2' => $request->how_it_works_title2,
                'how_it_works_title3' => $request->how_it_works_title3,
                'how_it_works_title4' => $request->how_it_works_title4,
                'how_it_works_title5' => $request->how_it_works_title5,
                'how_it_works_desc1' => $request->how_it_works_desc1,
                'how_it_works_desc2' => $request->how_it_works_desc2,
                'how_it_works_desc3' => $request->how_it_works_desc3,
                'how_it_works_desc4' => $request->how_it_works_desc4,
                'how_it_works_desc5' => $request->how_it_works_desc5,
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
                ]);
            Investment::where('id', $projectId)->update([
                'minimum_accepted_amount' => $request->project_min_investment_txt,
                'hold_period' => $request->project_hold_period_txt,
                'projected_returns' => $request->project_returns_txt,
                'summary' => $request->project_summary_txt,
                'security_long' => $request->project_security_long_txt,
                'exit_d' => $request->project_investor_distribution_txt,
                'marketability' => $request->project_marketability_txt,
                'residents' => $request->project_residents_txt,
                'investment_type' => $request->project_investment_type_txt,
                'security' => $request->project_security_txt,
                'expected_returns_long' => $request->project_expected_returns_txt,
                'returns_paid_as' => $request->project_return_paid_as_txt,
                'taxation' => $request->project_taxation_txt,
                'current_status' => $request->project_current_status_txt,
                'rationale' => $request->project_rationale_txt,
                'risk' => $request->project_risk_txt,
                'PDS_part_1_link' => $request->project_pds1_link_txt,
                'PDS_part_2_link' => $request->project_pds2_link_txt,
                'how_to_invest' => $request->project_how_to_invest_txt,
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
}
