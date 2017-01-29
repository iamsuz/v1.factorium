<?php
/**
 * Application Routes
 * -------------------------------------------------------------------------------------------------------------------
 */

Route::get('/', ['as'=>'home', 'uses'=>'PagesController@home']);
Route::get('/pages/team', ['as'=>'pages.team', 'uses'=>'PagesController@team']);
Route::get('/pages/team/edit', ['as'=>'pages.team.edit', 'uses'=>'PagesController@editTeam']);
Route::post('/pages/team/create', ['as'=>'pages.team.create', 'uses'=>'PagesController@createTeam']);
Route::patch('/pages/team/edit/{id}', ['as'=>'pages.team.update', 'uses'=>'PagesController@updateTeam']);
Route::post('/pages/team/members/uploadImg', ['as'=>'pages.team.members.uploadImg', 'uses'=>'PagesController@uploadMemberImgThumbnail']);
Route::post('/pages/cropUploadedImage', ['as'=>'pages.cropUploadedImage', 'uses'=>'PagesController@cropUploadedImage']);
Route::post('/pages/team/{aboutus}/members/',['as'=>'team.members.create','uses'=>'PagesController@createTeamMember']);
Route::patch('/pages/team/members/{id}', ['as'=>'team.members.update', 'uses'=>'PagesController@updateTeamMember']);
Route::delete('pages/{aboutus_id}/members/{member_id}', ['as'=>'team.member.destroy', 'uses'=>'PagesController@deleteTeamMember']);
Route::get('/pages/users/sort', ['as'=>'pages.team', 'uses'=>'PagesController@sortusers']);
Route::get('/pages/privacy', ['as'=>'pages.privacy', 'uses'=>'PagesController@privacy']);
Route::get('/pages/financialserviceguide', ['as'=>'pages.financial', 'uses'=>'PagesController@financial']);
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

Route::get('/dashboard/users', ['as'=>'dashboard.users', 'uses'=>'DashboardController@users']);
Route::get('/dashboard/projects', ['as'=>'dashboard.projects', 'uses'=>'DashboardController@projects']);
Route::get('/dashboard/configurations', ['as'=>'dashboard.configurations', 'uses'=>'DashboardController@siteConfigurations']);
Route::post('/dashboard/configurations/uploadSiteLogo', ['as'=>'dashboard.configurations.uploadSiteLogo', 'uses'=>'DashboardController@uploadSiteLogo']);
Route::post('/configuration/changecolor/footer/home',['as'=>'configuration.footercolor.home','uses'=>'PagesController@changeColorFooter']);


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

Route::pattern('project_id', '[0-9]+');
Route::get('/dashboard/projects/{project_id}', ['as'=>'dashboard.projects.show', 'uses'=>'DashboardController@showProject']);
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
Route::get('/users/activation/{token}', ['as'=>'users.activation', 'uses'=>'UserAuthController@activate']);

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
Route::delete('projects/{projects}/faq/{faq_id}', ['as'=>'projects.destroy', 'uses'=>'ProjectsController@deleteProjectFAQ']);

Route::get('projects/invite/users', ['as'=>'projects.invite.only', 'uses'=>'ProjectsController@showInvitation']);
Route::post('projects/invite/users', ['as'=>'projects.invitation.store', 'uses'=>'ProjectsController@postInvitation']);


Route::get('projects/{project_id}/interest', ['as'=>'projects.interest', 'uses'=>'ProjectsController@showInterest']);
Route::get('projects/{project_id}/offerdoc', ['as'=>'projects.offer', 'uses'=>'ProjectsController@showInterestOffer']);
Route::get('projects/{project_id}/completed', ['as'=>'projects.complete', 'uses'=>'ProjectsController@interestCompleted']);
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
Route::post('/configuration/updateSitemapLinks', ['as'=>'configuration.updateSitemapLinks', 'uses'=>'SiteConfigurationsController@updateSitemapLinks']);
Route::post('/configuration/editHomePgInvestmentTitle1', ['as'=>'configuration.editHomePgInvestmentTitle1', 'uses'=>'SiteConfigurationsController@editHomePgInvestmentTitle1']);
Route::post('/configuration/editHomePgInvestmentTitle1Description', ['as'=>'configuration.editHomePgInvestmentTitle1Description', 'uses'=>'SiteConfigurationsController@editHomePgInvestmentTitle1Description']);
Route::post('/configuration/uploadHomePgInvestmentImage', ['as'=>'configuration.uploadHomePgInvestmentImage', 'uses'=>'SiteConfigurationsController@uploadHomePgInvestmentImage']);
Route::post('/configuration/storeShowFundingOptionsFlag', ['as'=>'configuration.storeShowFundingOptionsFlag', 'uses'=>'SiteConfigurationsController@storeShowFundingOptionsFlag']);
Route::post('/configuration/storeHowItWorksContent', ['as'=>'configuration.storeHowItWorksContent', 'uses'=>'SiteConfigurationsController@storeHowItWorksContent']);
Route::post('/siteconfiguration/progress/{id}/images', ['as'=>'configuration.uploadprogress','uses'=>'SiteConfigurationsController@uploadProgressImage']);
Route::post('/configuration/uploadHowItWorksImages', ['as'=>'configuration.uploadHowItWorksImages', 'uses'=>'SiteConfigurationsController@uploadHowItWorksImages']);
Route::post('/siteconfiguration/progress/{id}/details', ['as'=>'configuration.addprogress','uses'=>'SiteConfigurationsController@addProgressDetails']);
Route::post('/configuration/updateProjectDetails', ['as'=>'configuration.updateProjectDetails', 'uses'=>'SiteConfigurationsController@updateProjectDetails']);
Route::post('/configuration/uploadProjectPgBackImg', ['as'=>'configuration.uploadProjectPgBackImg', 'uses'=>'SiteConfigurationsController@uploadProjectPgBackImg']);