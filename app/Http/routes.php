<?php
/**
 * Application Routes
 * -------------------------------------------------------------------------------------------------------------------
 */

Route::get('/', ['as'=>'home', 'uses'=>'PagesController@home']);
Route::get('/tests', ['as'=>'home2', 'uses'=>'PagesController@something']);
Route::get('/testemail', ['as'=>'home1', 'uses'=>'PagesController@test']);
Route::get('/pages/team', ['as'=>'pages.team', 'uses'=>'PagesController@team']);
Route::get('/pages/team/edit', ['as'=>'pages.team.edit', 'uses'=>'PagesController@editTeam']);
Route::post('/pages/team/create', ['as'=>'pages.team.create', 'uses'=>'PagesController@createTeam']);
Route::patch('/pages/team/edit/{id}', ['as'=>'pages.team.update', 'uses'=>'PagesController@updateTeam']);
Route::post('/pages/team/members/uploadImg', ['as'=>'pages.team.members.uploadImg', 'uses'=>'PagesController@uploadMemberImgThumbnail']);
Route::post('/pages/cropUploadedImage', ['as'=>'pages.cropUploadedImage', 'uses'=>'PagesController@cropUploadedImage']);
Route::post('/pages/team/{aboutus}/members/',['as'=>'team.members.create','uses'=>'PagesController@createTeamMember']);
Route::patch('/pages/team/members/{id}', ['as'=>'team.members.update', 'uses'=>'PagesController@updateTeamMember']);
Route::delete('pages/{aboutus_id}/members/{member_id}', ['as'=>'team.member.destroy', 'uses'=>'PagesController@deleteTeamMember']);
Route::post('/pages/updateFounderLabel', ['as'=>'pages.updateFounderLabel', 'uses'=>'PagesController@updateFounderLabel']);
Route::get('/pages/users/sort', ['as'=>'pages.team', 'uses'=>'PagesController@sortusers']);
Route::get('/pages/privacy', ['as'=>'pages.privacy', 'uses'=>'PagesController@privacy']);
// Route::get('/pages/financialserviceguide', ['as'=>'pages.financial', 'uses'=>'PagesController@financial']);
Route::get('/pages/faq', ['as'=>'pages.faq', 'uses'=>'PagesController@faq']);
Route::pattern('faq_id', '[0-9]+');
Route::get('/pages/faq/{faq_id}/deleteFaq', ['as'=>'pages.faq.delete', 'uses'=>'PagesController@deleteFaq']);
Route::get('/pages/faq/create', ['as'=>'pages.faq.create', 'uses'=>'PagesController@createFaq']);
Route::post('/pages/faq/recieveSubCategory', 'PagesController@recieveSubCategories');
Route::post('pages/faq/store', ['as'=>'pages.faq.store', 'uses'=>'PagesController@storeFaq']);
Route::get('/pages/terms', ['as'=>'pages.terms', 'uses'=>'PagesController@terms']);
Route::get('/pages/subdivide', ['as'=>'pages.subdivide', 'uses'=>'PagesController@subdivide']);
Route::post('/pages/subdivide', ['as'=>'pages.subdivide.store', 'uses'=>'PagesController@storeSubdivide']);
Route::get('/pages/subdivide/thankyou', ['as'=>'pages.subdivide.thankyou', 'uses'=>'PagesController@subdivideThankyou']);

Route::pattern('dashboard', '[0-9]+');
Route::resource('dashboard', 'DashboardController');

Route::get('/gform', 'ProjectsController@gform');
Route::get('/gformredirect','ProjectsController@gformRedirects');

Route::get('/dashboard/users', ['as'=>'dashboard.users', 'uses'=>'DashboardController@users']);
Route::get('/dashboard/projects', ['as'=>'dashboard.projects', 'uses'=>'DashboardController@projects']);
Route::get('/dashboard/configurations', ['as'=>'dashboard.configurations', 'uses'=>'DashboardController@siteConfigurations']);
Route::post('/dashboard/configurations/uploadSiteLogo', ['as'=>'dashboard.configurations.uploadSiteLogo', 'uses'=>'DashboardController@uploadSiteLogo']);
Route::post('/configuration/changecolor/footer/home',['as'=>'configuration.footercolor.home','uses'=>'PagesController@changeColorFooter']);
Route::get('/dashboard/kyc/requests', ['as'=>'dashboard.kyc', 'uses'=>'DashboardController@kycRequests']);

Route::get('/dashboard/getUsers', ['as'=>'dashboard.getUsers', 'uses'=>'DashboardController@getDashboardUsers']);
Route::get('/dashboard/getProjects', ['as'=>'dashboard.getProjects', 'uses'=>'DashboardController@getDashboardProjects']);

Route::pattern('user_id', '[0-9]+');
Route::get('/dashboard/users/{user_id}', ['as'=>'dashboard.users.show', 'uses'=>'DashboardController@showUser']);
Route::get('/dashboard/users/{user_id}/edit', ['as'=>'dashboard.users.edit', 'uses'=>'DashboardController@edit']);
Route::patch('/dashboard/users/{user_id}/edit', ['as'=>'dashboard.users.update', 'uses'=>'DashboardController@update']);
Route::patch('/users/{user_id}/edit1', ['as'=>'users.fbupdate', 'uses'=>'UsersController@fbupdate']);
Route::get('/dashboard/users/{user_id}/investments', ['as'=>'dashboard.users.investments', 'uses'=>'DashboardController@usersInvestments']);
Route::get('/dashboard/users/{user_id}/activate', ['as'=>'dashboard.users.activate', 'uses'=>'DashboardController@activateUser']);
Route::get('/dashboard/users/{user_id}/deactivate', ['as'=>'dashboard.users.deactivate', 'uses'=>'DashboardController@deactivateUser']);
Route::get('/dashboard/users/{user_id}/verification', ['as'=>'dashboard.users.verification', 'uses'=>'DashboardController@verification']);
Route::post('/dashboard/users/{user_id}/verification', ['as'=>'dashboard.users.verify', 'uses'=>'DashboardController@verifyId']);
Route::get('/dashboard/users/{user_id}/idVerification',['as'=>'dashboard.users.idVerify','uses'=>'DashboardController@idDocVerification']);
Route::post('/dashboard/users/{user_id}/idVerification',['as'=>'dashboard.users.idVerifying','uses'=>'DashboardController@idDocVerify']);

Route::pattern('project_id', '[0-9]+');
/*Route::get('/dashboard/projects/{project_id}', ['as'=>'dashboard.projects.show', 'uses'=>'DashboardController@showProject']);*/
Route::get('/dashboard/projects/{project_id}/edit', ['as'=>'dashboard.projects.edit', 'uses'=>'DashboardController@editProject']);
Route::get('/dashboard/projects/{project_id}/investors', ['as'=>'dashboard.projects.investors', 'uses'=>'DashboardController@projectInvestors']);
Route::get('/dashboard/projects/{project_id}/private', ['as'=>'dashboard.projects.private', 'uses'=>'DashboardController@privateProject']);
Route::get('/dashboard/projects/{project_id}/activate', ['as'=>'dashboard.projects.activate', 'uses'=>'DashboardController@activateProject']);
Route::get('/dashboard/projects/{project_id}/deactivate', ['as'=>'dashboard.projects.deactivate', 'uses'=>'DashboardController@deactivateProject']);
Route::patch('/dashboard/projects/{project_id}/toggleStatus', ['as'=>'dashboard.projects.toggleStatus', 'uses'=>'DashboardController@toggleStatus']);
Route::patch('/dashboard/projects/{investment_id}/investments', ['as'=>'dashboard.investment.update', 'uses'=>'DashboardController@updateInvestment']);
Route::patch('/dashboard/projects/{investment_id}/investments/accept', ['as'=>'dashboard.investment.accept', 'uses'=>'DashboardController@acceptInvestment']);

Route::pattern('notes', '[0-9]+');
Route::resource('notes', 'NotesController');

Route::get('/users/login', ['as'=>'users.login', 'uses'=>'UserAuthController@login']);
Route::get('/users/logout', ['as'=>'users.logout', 'uses'=>'UserAuthController@logout']);
Route::post('/users/login', ['as'=>'users.auth', 'uses'=>'UserAuthController@authenticate']);
Route::post('/users/login/eoi', ['as'=>'users.auth.eoi', 'uses'=>'UserAuthController@authenticateEoi']);
Route::post('/users/login/offer', ['as'=>'users.auth.offer', 'uses'=>'UserAuthController@authenticateOffer']);
Route::get('/users/successfull/eoi', ['as'=>'users.success.eoi', 'uses'=>'UserAuthController@successEoi']);
Route::POST('/users/registration/code', ['as'=>'users.registration.code', 'uses'=>'UserRegistrationsController@registrationCode']);
Route::POST('/users/register/{id}/offer',['as'=>'user.register.offer','uses'=>'UserRegistrationsController@offerRegistrationCode']);
Route::get('/users/register/offer/code',['as'=>'users.register.view.code','uses'=>'UserRegistrationsController@registerCodeView']);
Route::post('/users/login/check', ['as'=>'users.auth.check', 'uses'=>'UserAuthController@authenticateCheck']);
Route::get('/users/activation/{token}', ['as'=>'users.activation', 'uses'=>'UserAuthController@activate']);
Route::get('/users/{id}/documents',['as'=>'users.document','uses'=>'UsersController@documents']);
Route::post('/users/{id}/documents',['as'=>'users.document.upload','uses'=>'UsersController@uploadDocuments']);
// Password reset link request routes...
Route::get('/password/email', 'Auth\PasswordController@getEmail');
Route::post('/password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('/password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('/password/reset', 'Auth\PasswordController@postReset');

Route::pattern('users', '[0-9]+');
Route::resource('users', 'UsersController');

Route::get('/users/{users}/roles/investor/add', ['as'=>'users.investor.add', 'uses'=>'UsersController@addInvestor']);
Route::get('/users/{users}/roles/developer/add', ['as'=>'users.developer.add', 'uses'=>'UsersController@addDeveloper']);

Route::get('/users/{users}/roles/investor/delete', ['as'=>'users.investor.delete', 'uses'=>'UsersController@destroyInvestor']);
Route::get('/users/{users}/roles/developer/delete', ['as'=>'users.developer.delete', 'uses'=>'UsersController@destroyDeveloper']);

Route::get('/users/invitation/{token}', ['as'=>'users.invitation.accepted', 'uses'=>'UserRegistrationsController@acceptedInvitation']);
Route::post('/users/invitation/details', ['as'=>'users.invitation.storeDetails', 'uses'=>'UserRegistrationsController@storeDetailsInvite']);
Route::get('/users/{users}/invitation', ['as'=>'users.invitation', 'uses'=>'UsersController@showInvitation']);
Route::post('/users/{users}/invitation', ['as'=>'users.invitation.store', 'uses'=>'UsersController@sendInvitation']);
Route::get('/users/{users}/verification', ['as'=>'users.verification', 'uses'=>'UsersController@verification']);
Route::post('/users/{users}/verification', ['as'=>'users.verification.upload', 'uses'=>'UsersController@verificationUpload']);
Route::get('/users/{users}/verification/status', ['as'=>'users.verification.status', 'uses'=>'UsersController@verificationStatus']);
Route::get('/users/{users}/interests', ['as'=>'users.interests', 'uses'=>'UsersController@showInterests']);
Route::get('/users/{username}', ['as'=>'users.showUser', 'uses'=>'UsersController@showUser']);
Route::get('/users/{username}/edit', ['as'=>'users.edit', 'uses'=>'UsersController@edit']);
Route::get('/users/{username}/fbedit', ['as'=>'users.fbedit', 'uses'=>'UsersController@fbedit']);
Route::get('/users/{users}/book', ['as'=>'users.book', 'uses'=>'UsersController@book']);
Route::get('/users/{users}/submit', ['as'=>'users.submit', 'uses'=>'UsersController@submit']);

Route::pattern('roles', '[0-9]+');
Route::resource('roles', 'RolesController');

Route::get('/registrations/resend', ['as'=>'registration.resend.activation', 'uses'=>'UserRegistrationsController@resend_activation_link']);
Route::resource('/registrations', 'UserRegistrationsController');
Route::get('/registrations/activation/{token}', ['as'=>'registration.activation', 'uses'=>'UserRegistrationsController@activate']);
// Route::get('facebook/registration', ['as'=>'registration.activation1', 'uses'=>'UserRegistrationsController@fbactivate']);
Route::post('/registrations/details', ['as'=>'registration.storeDetails', 'uses'=>'UserRegistrationsController@storeDetails']);
Route::get('/finish',['as'=>'users.registrationFinish','uses'=>'UsersController@registrationFinish1']);
Route::POST('/finish/addrole',['as'=>'registration.changeRole','uses'=>'UsersController@changeRole']);
Route::pattern('projects', '[0-9]+');
Route::resource('projects', 'ProjectsController');
Route::pattern('comments', '[0-9]+');
Route::group(['prefix' => 'projects/{projects}'], function ($projects) {
	Route::resource('comments', 'CommentsController');
	Route::post('/comments/{comments}/votes', ['as'=>'projects.{projects}.comments.votes', 'uses'=>'CommentsController@storeVote']);
	Route::post('/comments/{comments}/reply', ['as'=>'projects.{projects}.comments.reply', 'uses'=>'CommentsController@storeReply']);
	Route::get('/comments/{comments}/delete', ['as'=>'projects.{projects}.comments.delete', 'uses'=>'CommentsController@deleteComment']);
});

Route::get('projects/{projects}/confirmation', ['as'=>'projects.confirmation', 'uses'=>'ProjectsController@confirmation']);
Route::post('projects/{projects}/photos', ['as'=>'projects.storePhoto', 'uses'=>'ProjectsController@storePhoto']);
Route::post('projects/{projects}/photos4', ['as'=>'projects.storePhotoProjectThumbnail', 'uses'=>'ProjectsController@storePhotoProjectThumbnail']);
Route::post('projects/{projects}/photos5', ['as'=>'projects.storePhotoProjectDeveloper', 'uses'=>'ProjectsController@storePhotoProjectDeveloper']);
Route::post('projects/{projects}/photos3', ['as'=>'projects.storePhotoResidents1', 'uses'=>'ProjectsController@storePhotoResidents1']);
Route::post('projects/{projects}/photos1', ['as'=>'projects.storePhotoMarketability', 'uses'=>'ProjectsController@storePhotoMarketability']);
Route::post('projects/{projects}/photos2', ['as'=>'projects.storePhotoInvestmentStructure', 'uses'=>'ProjectsController@storePhotoInvestmentStructure']);
Route::post('projects/{projects}/photos6', ['as'=>'projects.storePhotoExit', 'uses'=>'ProjectsController@storePhotoExit']);
Route::post('projects/{projects}/investments', ['as'=>'projects.investments', 'uses'=>'ProjectsController@storeInvestmentInfo']);
Route::post('projects/{projects}/faq', ['as'=>'projects.faq', 'uses'=>'ProjectsController@storeProjectFAQ']);
Route::post('projects/{projects}/faq/{faq_id}', ['as'=>'projects.destroy', 'uses'=>'ProjectsController@deleteProjectFAQ']);

Route::get('projects/invite/users', ['as'=>'projects.invite.only', 'uses'=>'ProjectsController@showInvitation']);
Route::post('projects/invite/users', ['as'=>'projects.invitation.store', 'uses'=>'ProjectsController@postInvitation']);


Route::get('projects/{project_id}/interest', ['as'=>'projects.interest', 'uses'=>'ProjectsController@showInterest']);
Route::get('projects/{project_id}/eoi', ['as'=>'projects.eoi', 'uses'=>'ProjectsController@showEoiInterest']);
Route::get('projects/{project_id}/offerdoc', ['as'=>'projects.offer', 'uses'=>'ProjectsController@showInterestOffer']);
Route::get('projects/{project_id}/completed', ['as'=>'projects.complete', 'uses'=>'ProjectsController@interestCompleted']);
Route::post('projects/storeEOI', ['as'=>'projects.eoiStore', 'uses'=>'ProjectsController@storeProjectEOI']);
Route::post('/FormContent/{id}', ['as'=>'AdditionalFormContent', 'uses'=>'ProjectsController@storeAdditionalFormContent']);
Route::post('/ProjectThumbnailText/{id}', ['as'=>'ProjectThumbnailText', 'uses'=>'ProjectsController@storeProjectThumbnailText']);
Route::get('welcome', ['as'=>'pages.welcome', 'uses'=>'ProjectsController@redirectingfromproject']);

// Route::get('/news/financialreview', ['as'=>'news.financialreview', 'uses'=>'NewsController@financialreview']);
// Route::get('/news/startupsmart', ['as'=>'news.startupsmart', 'uses'=>'NewsController@startupsmart']);
// Route::get('/news/crowdfundinsider', ['as'=>'news.crowdfundinsider', 'uses'=>'NewsController@crowdfundinsider']);
// Route::get('/news/realestatebusiness', ['as'=>'news.realestatebusiness', 'uses'=>'NewsController@realestatebusiness']);
// Route::get('/news/startup88', ['as'=>'news.startup88', 'uses'=>'NewsController@startup88']);
// Route::get('/news/startupdaily', ['as'=>'news.startupdaily', 'uses'=>'NewsController@startupdaily']);

Route::get('/password/email', 'Auth\PasswordController@getEmail');
Route::post('/password/email', 'Auth\PasswordController@postEmail');

Route::get('/sitemap.xml', 'SitemapController@generate');

// Password reset routes...
Route::get('/password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('/password/reset', 'Auth\PasswordController@postReset');
// facebook
Route::get('/auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('/auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('/auth/linkedin', 'Auth\AuthController@redirectToProvider1');
Route::get('/auth/linkedin/callback', 'Auth\AuthController@handleProviderCallback1');
Route::get('/auth/twitter', 'Auth\AuthController@redirectToProvider2');
Route::get('/auth/twitter/callback', 'Auth\AuthController@handleProviderCallback2');
Route::get('/auth/google', 'Auth\AuthController@redirectToProvider3');
Route::get('/auth/google/callback', 'Auth\AuthController@handleProviderCallback3');

Route::post('/configuration/uploadLogo', ['as'=>'configuration.uploadlogo', 'uses'=>'SiteConfigurationsController@uploadLogo']);
Route::post('/configuration/cropUploadedImage', ['as'=>'configuration.cropuploadimage', 'uses'=>'SiteConfigurationsController@cropUploadedImage']);
Route::post('/configuration/saveHomePageText1', ['as'=>'configuration.saveHomePageText1', 'uses'=>'SiteConfigurationsController@saveHomePageText1']);
Route::post('/configuration/saveHomePageBtn1Text', ['as'=>'configuration.saveHomePageBtn1Text', 'uses'=>'SiteConfigurationsController@saveHomePageBtn1Text']);
Route::post('/configuration/uploadHomePgBackImg1', ['as'=>'configuration.uploadHomePgBackImg1', 'uses'=>'SiteConfigurationsController@uploadHomePgBackImg1']);
Route::post('/configuration/updateSiteTitle', ['as'=>'configuration.updateSiteTitle', 'uses'=>'SiteConfigurationsController@updateSiteTitle']);
Route::post('/configuration/updateFavicon', ['as'=>'configuration.updateFavicon', 'uses'=>'SiteConfigurationsController@updateFavicon']);
Route::post('/configuration/updateSocialSiteLinks', ['as'=>'configuration.updateSocialSiteLinks', 'uses'=>'SiteConfigurationsController@updateSocialSiteLinks']);
Route::post('/configuration/updateGreyBoxNote', ['as'=>'configuration.updateGreyBoxNote', 'uses'=>'SiteConfigurationsController@updateGreyBoxNote']);
Route::post('/configuration/updateSitemapLinks', ['as'=>'configuration.updateSitemapLinks', 'uses'=>'SiteConfigurationsController@updateSitemapLinks']);
Route::post('/configuration/editHomePgInvestmentTitle1', ['as'=>'configuration.editHomePgInvestmentTitle1', 'uses'=>'SiteConfigurationsController@editHomePgInvestmentTitle1']);
Route::post('/configuration/editHomePgInvestmentTitle1Description', ['as'=>'configuration.editHomePgInvestmentTitle1Description', 'uses'=>'SiteConfigurationsController@editHomePgInvestmentTitle1Description']);
Route::post('/configuration/uploadHomePgInvestmentImage', ['as'=>'configuration.uploadHomePgInvestmentImage', 'uses'=>'SiteConfigurationsController@uploadHomePgInvestmentImage']);
Route::post('/configuration/storeShowFundingOptionsFlag', ['as'=>'configuration.storeShowFundingOptionsFlag', 'uses'=>'SiteConfigurationsController@storeShowFundingOptionsFlag']);
Route::post('/configuration/storeShowSocialLinksFlag', ['as'=>'configuration.storeShowSocialLinksFlag', 'uses'=>'SiteConfigurationsController@storeShowSocialLinksFlag']);
Route::post('/configuration/storeHowItWorksContent', ['as'=>'configuration.storeHowItWorksContent', 'uses'=>'SiteConfigurationsController@storeHowItWorksContent']);
Route::post('/siteconfiguration/progress/{id}/images', ['as'=>'configuration.uploadprogress','uses'=>'SiteConfigurationsController@uploadProgressImage']);
Route::post('/siteconfiguration/gallary/{id}/images1', ['as'=>'configuration.uploadGallaryImage','uses'=>'SiteConfigurationsController@uploadGallaryImage']);
Route::post('/configuration/uploadHowItWorksImages', ['as'=>'configuration.uploadHowItWorksImages', 'uses'=>'SiteConfigurationsController@uploadHowItWorksImages']);
Route::post('/siteconfiguration/progress/{id}/details', ['as'=>'configuration.addprogress','uses'=>'SiteConfigurationsController@addProgressDetails']);
Route::get('/siteconfiguration/progress/{id}/details', ['as'=>'configuration.deleteProgress','uses'=>'SiteConfigurationsController@deleteProgressDetails']);
Route::POST('/configuration/updateProjectDetails/{project_id}', ['as'=>'configuration.updateProjectDetails', 'uses'=>'SiteConfigurationsController@updateProjectDetails']);
Route::post('/configuration/uploadProjectPgBackImg', ['as'=>'configuration.uploadProjectPgBackImg', 'uses'=>'SiteConfigurationsController@uploadProjectPgBackImg']);
Route::post('/configuration/editHomePgFundingSectionContent', ['as'=>'configuration.editHomePgFundingSectionContent', 'uses'=>'SiteConfigurationsController@editHomePgFundingSectionContent']);
Route::post('/configuration/uploadprojectPgThumbnailImages', ['as'=>'configuration.uploadprojectPgThumbnailImages', 'uses'=>'SiteConfigurationsController@uploadprojectPgThumbnailImages']);
Route::post('/configuration/updateWebsiteName', ['as'=>'configuration.updateWebsiteName', 'uses'=>'SiteConfigurationsController@updateWebsiteName']);
Route::post('projects/{projects}/projectSPVDetails', ['as'=>'projects.projectSPVDetails', 'uses'=>'ProjectsController@storeProjectSPVDetails']);
Route::post('/configuration/updateProjectSpvLogo', ['as'=>'configuration.updateProjectSpvLogo', 'uses'=>'SiteConfigurationsController@updateProjectSpvLogo']);
Route::post('/configuration/updateProjectSpvMDSign', ['as'=>'configuration.updateProjectSpvMDSign', 'uses'=>'SiteConfigurationsController@updateProjectSpvMDSign']);
Route::get('/site/termsConditions', ['as'=>'site.termsConditions', 'uses'=>'PagesController@termsConditions']);
Route::post('/configuration/updateClientName', ['as'=>'configuration.updateClientName', 'uses'=>'SiteConfigurationsController@updateClientName']);
Route::post('/configuration/uploadProjectThumbImage', ['as'=>'configuration.uploadProjectThumbImage', 'uses'=>'SiteConfigurationsController@uploadProjectThumbImage']);
Route::post('/configuration/editSmsfReferenceText', ['as'=>'configuration.editSmsfReferenceText', 'uses'=>'SiteConfigurationsController@editSmsfReferenceText']);
Route::post('/configuration/project/saveShowMapStatus', ['as'=>'configuration.project.saveShowMapStatus', 'uses'=>'SiteConfigurationsController@saveShowMapStatus']);
Route::post('/configuration/project/updateProjectPageSubHeading', ['as'=>'configuration.project.updateProjectPageSubHeading', 'uses'=>'SiteConfigurationsController@updateProjectPageSubHeading']);
Route::post('/configuration/uploadVideo', ['as'=>'configuration.uploadVideo', 'uses'=>'SiteConfigurationsController@uploadVideo']);
Route::post('/project/edit/uploadSubSectionImages', ['as'=>'project.uploadSubSectionImages', 'uses'=>'ProjectsController@uploadSubSectionImages']);
Route::patch('/dashboard/projects/{investment_id}/investments/moneyReceived', ['as'=>'dashboard.investment.moneyReceived', 'uses'=>'DashboardController@investmentMoneyReceived']);
Route::get('/dashboard/projects/{investment_id}/investments/reminder', ['as'=>'dashboard.investment.reminder', 'uses'=>'DashboardController@investmentReminder']);
Route::patch('/dashboard/projects/{investment_id}/investments/confirmation', ['as'=>'dashboard.investment.confirmation', 'uses'=>'DashboardController@investmentConfirmation']);
Route::post('/configuration/home/updateOverlayOpacity', ['as'=>'configuration.home.updateOverlayOpacity', 'uses'=>'SiteConfigurationsController@updateOverlayOpacity']);
Route::post('/configuration/project/updateProjectPgOverlayOpacity', ['as'=>'configuration.project.updateProjectPgOverlayOpacity', 'uses'=>'SiteConfigurationsController@updateProjectPgOverlayOpacity']);
Route::patch('/configuration/updatemaileremail', ['as'=>'configuration.updatemaileremail', 'uses'=>'SiteConfigurationsController@uploadMailerEmail']);
Route::patch('/configuration/{id}/updatemailsetting', ['as'=> 'configuration.updatemailsettings', 'uses'=>'SiteConfigurationsController@updateMailSetting']);
Route::post('/configuration/createmailsetting', ['as'=> 'configuration.createmailsettings', 'uses'=>'SiteConfigurationsController@createMailSettings']);
Route::post('/configuration/project/toggleSubSectionsVisibility', ['as'=>'configuration.project.toggleSubSectionsVisibility', 'uses'=>'SiteConfigurationsController@toggleSubSectionsVisibility']);
Route::post('/project/edit/deleteSubSectionImages', ['as'=>'project.deleteSubSectionImages', 'uses'=>'ProjectsController@deleteSubSectionImages']);
Route::post('/project/edit/deleteProjectCarouselImages', ['as'=>'project.deleteProjectCarouselImages', 'uses'=>'ProjectsController@deleteProjectCarouselImages']);
Route::post('/configuration/project/toggleProspectusText', ['as'=>'configuration.project.toggleProspectusText', 'uses'=>'SiteConfigurationsController@toggleProspectusText']);
Route::post('/configuration/home/swapProjectRanking', ['as'=>'configuration.home.swapProjectRanking', 'uses'=>'SiteConfigurationsController@swapProjectRanking']);
Route::post('/project/edit/updateProjectBankDetails', ['as'=>'project.updateProjectBankDetails', 'uses'=>'ProjectsController@updateProjectBankDetails']);
Route::post('/configuration/project/toggleProjectProgress', ['as'=>'configuration.project.toggleProjectProgress', 'uses'=>'SiteConfigurationsController@toggleProjectProgress']);
Route::post('/configuration/project/toggleProjectpayment', ['as'=>'configuration.project.toggleProjectpayment', 'uses'=>'SiteConfigurationsController@toggleProjectpayment']);
Route::post('/configuration/project/toggleProjectElementVisibility', ['as'=>'configuration.project.toggleProjectElementVisibility', 'uses'=>'SiteConfigurationsController@toggleProjectElementVisibility']);
Route::post('/configuration/project/editProjectPageLabelText', ['as'=>'configuration.project.editProjectPageLabelText', 'uses'=>'SiteConfigurationsController@editProjectPageLabelText']);
Route::post('/configuration/edit/visibilityOfSiteItems', ['as'=> 'configuration.edit.visibilityOfSiteItems', 'uses'=>'SiteConfigurationsController@editVisibilityOfSiteConfigItems']);
Route::post('/configuration/updateInterestFormLink', ['as'=> 'configuration.updateInterestFormLink', 'uses'=>'SiteConfigurationsController@updateInterestFormLink']);
Route::get('/dashboard/broadcastMail', ['as'=>'dashboard.broadcastMail', 'uses'=>'DashboardController@createBroadcastMailForm']);
Route::post('/dashboard/mail/broadcast', ['as'=>'dashboard.mail.broadcast', 'uses'=>'DashboardController@sendBroadcastMail']);
Route::get('/users/{user_id}/investments', ['as'=>'users.investments', 'uses'=>'UsersController@usersInvestments']);
Route::get('/users/{user_id}/notification', ['as'=>'users.notifications', 'uses'=>'UsersController@usersNotifications']);
Route::get('/users/{user_id}/referral',['as'=>'users.referral','uses'=>'UsersController@referralUser']);
Route::get('/pages/redirectNotification', ['as'=>'pages.redirectNotifications', 'uses'=>'PagesController@redirectUsersNotifications']);
Route::get('/user/view/{investment_id}/share', ['as'=>'user.view.share', 'uses'=>'UsersController@viewShareCertificate']);
Route::get('/user/view/{investment_id}/unit', ['as'=>'user.view.unit', 'uses'=>'UsersController@viewUnitCertificate']);
Route::get('/user/view/{investment_id}/application', ['as'=>'user.view.application', 'uses'=>'UsersController@viewApplication']);
Route::post('/pages/testimonial/store', ['as'=>'pages.testimonial.store', 'uses'=>'PagesController@storeTestimonial']);
Route::post('/pages/testimonial/uploadImg', ['as'=>'pages.testimonial.uploadImg', 'uses'=>'PagesController@uploadTestimonialImgThumbnail']);
Route::post('/pages/testimonial/delete', ['as'=>'pages.testimonial.delete', 'uses'=>'PagesController@deleteTestimonial']);
Route::post('/configuration/updateTagManager', ['as'=> 'configuration.updateTagManager', 'uses'=>'SiteConfigurationsController@updateTagManager']);
Route::post('/pages/home/expressProjectInterest', ['as'=>'pages.home.expressProjectInterest', 'uses'=>'PagesController@expressProjectInterest']);
Route::post('/configuration/updateConversionPixel', ['as'=> 'configuration.updateConversionPixel', 'uses'=>'SiteConfigurationsController@updateConversionPixel']);
Route::post('/configuration/updateProspectusText', ['as'=> 'configuration.updateProspectusText', 'uses'=>'SiteConfigurationsController@updateProspectusText']);
Route::post('/configuration/updateLegalDetails', ['as'=> 'configuration.updateLegalDetails', 'uses'=>'SiteConfigurationsController@updateLegalDetails']);
Route::post('/configuration/updateKonkreteAllocationChanges', ['as'=> 'configuration.updateKonkreteAllocationChanges', 'uses'=>'SiteConfigurationsController@updateKonkreteAllocationChanges']);
Route::post('/configuration/home/changeFontFamily', ['as'=>'configuration.changeFontFamily', 'uses'=>'SiteConfigurationsController@changeFontFamily']);
Route::resource('offer', 'OfferController');
Route::get('/projects/showedit/{project_id}', ['as'=>'projects.showedit', 'uses'=>'ProjectsController@showedit']);
Route::get('/dashboard/projects/{investment_id}/investments/cancel', ['as'=>'dashboard.investment.cancel', 'uses'=>'DashboardController@investmentCancel']);
Route::post('/dashboard/projects/{project_id}/investment/declareDividend', ['as'=>'dashboard.investment.declareDividend', 'uses'=>'DashboardController@declareDividend']);
Route::post('/dashboard/projects/{project_id}/investment/declareFixedDividend', ['as'=>'dashboard.investment.declareFixedDividend', 'uses'=>'DashboardController@declareFixedDividend']);
Route::post('/dashboard/projects/{project_id}/investment/declareRepurchase', ['as'=>'dashboard.investment.declareRepurchase', 'uses'=>'DashboardController@declareRepurchase']);
Route::post('/dashboard/projects/{project_id}/investment/statement', ['as'=>'dashboard.investment.statement', 'uses'=>'DashboardController@investmentStatement']);
Route::get('/dashboard/projects/{project_id}/investment/statement/send', ['as'=>'dashboard.investment.statement.send', 'uses'=>'DashboardController@sendInvestmentStatement']);

// Mail
Route::get('/dashboard/projects/{investment_id}/investors/imgdoc',['as'=>'dashboard.userdoc.upload','uses'=>'DashboardController@newUserDoc']);
Route::get('/dashboard/projects/{investment_id}/investors/imgdoc/verify',['as'=>'dashboard.userdoc.verify','uses'=>'DashboardController@verifyUserDoc']);
Route::get('/dashboard/project/application/{investment_id}', ['as'=>'dashboard.project.application', 'uses'=>'DashboardController@applicationForm']);
Route::get('/projects/{project_id}/interest/request', ['as'=>'projects.interest.request', 'uses'=>'OfferController@requestFormFilling']);
Route::get('/project/{request_id}/interest/fill', ['as'=>'project.interest.fill', 'uses'=>'OfferController@requestForm']);
Route::get('/project/{request_id}/interest/cancel', ['as'=>'project.interest.cancel', 'uses'=>'OfferController@cancelRequestForm']);
Route::get('/dashboard/investment/requests', ['as'=>'dashboard.investmentRequests', 'uses'=>'DashboardController@investmentRequests']);
Route::get('/project/{request_id}/interest/cancel', ['as'=>'project.interest.cancel', 'uses'=>'OfferController@cancelRequestForm']);
Route::get('/dashboard/investment/requests', ['as'=>'dashboard.investmentRequests', 'uses'=>'DashboardController@investmentRequests']);
Route::post('/configuration/uploadprojectProgressCircleImages', ['as'=>'configuration.uploadprojectProgressCircleImages', 'uses'=>'SiteConfigurationsController@uploadprojectProgressCircleImages']);

Route::post('/projects/prospectus', ['as'=>'projects.prospectus', 'uses'=>'ProjectsController@prospectusDownload']);
Route::get('/dashboard/prospectus/downloads', ['as'=>'dashboard.prospectus.downloads', 'uses'=>'DashboardController@prospectusDownloads']);
Route::post('/dashboard/project/interest/link', ['as'=>'dashboard.project.interest.link', 'uses'=>'DashboardController@sendEoiLink']);
Route::post('/dashboard/project/upload/offerdoc', ['as' => 'dashboard.upload.offerDoc', 'uses' => 'DashboardController@uploadOfferDoc']);
