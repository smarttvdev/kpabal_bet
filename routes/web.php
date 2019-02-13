<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//Payment IPN
Route::get('/ipnbtc', 'PaymentController@ipnBchain')->name('ipn.bchain');
Route::get('/ipnblockbtc', 'PaymentController@blockIpnBtc')->name('ipn.block.btc');
Route::get('/ipnblocklite', 'PaymentController@blockIpnLite')->name('ipn.block.lite');
Route::get('/ipnblockdog', 'PaymentController@blockIpnDog')->name('ipn.block.dog');
Route::post('/ipnpaypal', 'PaymentController@ipnpaypal')->name('ipn.paypal');
Route::post('/ipnperfect', 'PaymentController@ipnperfect')->name('ipn.perfect');
Route::post('/ipnstripe', 'PaymentController@ipnstripe')->name('ipn.stripe');
Route::post('/ipnskrill', 'PaymentController@skrillIPN')->name('ipn.skrill');
Route::post('/ipncoinpaybtc', 'PaymentController@ipnCoinPayBtc')->name('ipn.coinPay.btc');
Route::post('/ipncoinpayeth', 'PaymentController@ipnCoinPayEth')->name('ipn.coinPay.eth');
Route::post('/ipncoinpaybch', 'PaymentController@ipnCoinPayBch')->name('ipn.coinPay.bch');
Route::post('/ipncoinpaydash', 'PaymentController@ipnCoinPayDash')->name('ipn.coinPay.dash');
Route::post('/ipncoinpaydoge', 'PaymentController@ipnCoinPayDoge')->name('ipn.coinPay.doge');
Route::post('/ipncoinpayltc', 'PaymentController@ipnCoinPayLtc')->name('ipn.coinPay.ltc');
Route::post('/ipncoin', 'PaymentController@ipnCoin')->name('ipn.coinpay');
Route::post('/ipncoingate', 'PaymentController@ipnCoinGate')->name('ipn.coingate');
//Payment IPN


Route::get('/', 'FrontendController@index')->name('homepage');
Route::get('/all-match', 'FrontendController@viewMore')->name('view.more');
Route::get('/events/{id}/{slug}', 'FrontendController@matches')->name('matches');
Route::get('/match/{id}/{slug}', 'FrontendController@question')->name('match.question');
Route::get('/option/{id}/{slug}', 'FrontendController@questionByMatch')->name('match.option');

Route::get('/soccer-event/{id}/{slug}', 'FrontendController@soccerEvent');
Route::get('/soccer-match/{id}/{slug}', 'FrontendController@soccerMatch');

Route::get('/menu/{slug}', 'FrontendController@menu');
Route::get('/about-us', 'FrontendController@about');
Route::get('/faqs', 'FrontendController@faqs');

Route::get('/click-add/{id}', 'FrontendController@clickadd');
Route::get('/contact-us', 'FrontendController@contactUs');
Route::post('/contact-us', ['uses' => 'FrontendController@contactSubmit', 'as' => 'contact-submit']);


Auth::routes();
Route::group(['middleware' => ['guest']], function () {
    Route::get('/register/{reference}', 'FrontendController@register')->name('refer.register');
});

Route::group(['prefix' => 'user'], function () {

    Route::get('authorization', 'HomeController@authCheck')->name('user.authorization');

    Route::post('verification', 'HomeController@sendVcode')->name('user.send-vcode');
    Route::post('smsVerify', 'HomeController@smsVerify')->name('user.sms-verify');

    Route::post('verify-email', 'HomeController@sendEmailVcode')->name('user.send-emailVcode');
    Route::post('postEmailVerify', 'HomeController@postEmailVerify')->name('user.email-verify');


    Route::middleware(['CheckStatus'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('/betByUser', 'HomeController@betByUser')->name('betByUser');

        Route::get('/deposit', ['uses' => 'HomeController@deposit', 'as' => 'deposit']);
        Route::post('/deposit', ['uses' => 'HomeController@deposit', 'as' => 'deposit']);
        Route::post('/deposit-data-insert', 'HomeController@depositDataInsert')->name('deposit.data-insert');
        Route::get('/deposit-preview', 'HomeController@depositPreview')->name('user.deposit.preview');
        Route::post('/deposit-confirm', 'PaymentController@depositConfirm')->name('deposit.confirm');



        Route::get('/deposit-log', 'HomeController@depositLog')->name('user.depositLog');

        Route::get('/withdraw-money', 'HomeController@withdrawMoney')->name('withdraw.money');
        Route::post('/withdraw-preview', 'HomeController@requestPreview')->name('withdraw.preview');
        Route::post('/withdraw-submit', 'HomeController@requestSubmit')->name('withdraw.submit');

        Route::get('/transaction-log', 'HomeController@activity')->name('user.trx');
        Route::get('/referral-list', 'HomeController@referLog')->name('user.referLog');
        Route::get('/withdraw-log', 'HomeController@withdrawLog')->name('user.withdrawLog');

        Route::get('change-password', ['as' => 'user.change-password', 'uses' => 'HomeController@changePassword']);
        Route::post('change-password', ['as' => 'user.change-password', 'uses' => 'HomeController@submitPassword']);

        Route::get('edit-profile', ['as' => 'edit-profile', 'uses' => 'HomeController@editProfile']);
        Route::post('edit-profile', ['as' => 'edit-profile', 'uses' => 'HomeController@submitProfile']);
    });
});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminLoginController@index')->name('admin.loginForm');
    Route::post('/', 'AdminLoginController@authenticate')->name('admin.login');
});


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {


        Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

        Route::get('/events', 'DashboardController@events')->name('admin.events');
        Route::post('/events', 'DashboardController@UpdateEvents')->name('update.events');

        Route::get('/closed-matches', 'DashboardController@closeMatches')->name('close.matches');
        Route::get('/matches', 'DashboardController@matches')->name('admin.matches');
        Route::post('/search-matches', 'DashboardController@searchMatches')->name('admin.search.matches');
        Route::get('/add-match', 'DashboardController@addMatch')->name('add.match');
        Route::post('/add-match', 'DashboardController@saveMatch')->name('add.match');
        Route::get('/edit-match/{id}', 'DashboardController@editMatch')->name('edit.match');
        Route::post('update-match', 'DashboardController@updateMatch')->name('update.match');
        Route::get('add-question/{id}', 'DashboardController@addQuestion')->name('add.question');
        Route::post('add-question', 'DashboardController@saveQuestion')->name('save.question');

        Route::get('view-question/{id}', 'DashboardController@viewQuestion')->name('view.question');
        Route::post('update-question', 'DashboardController@updateQuestion')->name('update.question');

        Route::get('single-matchBy-question/{id}', 'DashboardController@singleMatchByQuestion')->name('view.match.question');
        Route::get('endtime-option/{id}', 'DashboardController@viewOptionEndTime')->name('view.option.endtime');
        Route::post('make-winner', 'DashboardController@makeWinner')->name('make.winner');


    Route::get('awaiting-winner', 'DashboardController@endDateByQuestion')->name('awaiting.winner');




    Route::get('add-option/{id}', 'DashboardController@addOption')->name('add.option');
        Route::post('add-option', 'DashboardController@storeOption')->name('store.option');
        Route::get('view-option/{id}', 'DashboardController@viewOption')->name('view.option');
        Route::post('createNewOption', 'DashboardController@createNewOption')->name('createNewOption');
        Route::get('view-all-option/{id}', 'DashboardController@viewAllOption')->name('view.allOption');
        Route::post('update-option', 'DashboardController@updateOption')->name('update.option');


        //Gateway
        Route::get('/gateway', 'GatewayController@show')->name('gateway');
        Route::post('/gateway', 'GatewayController@update')->name('update.gateway');

        //Deposit
        Route::get('/deposits', 'DepositController@index')->name('deposits');
        Route::get('/deposits/requests', 'DepositController@requests')->name('deposits.requests');
        Route::put('/deposit/approve/{id}', 'DepositController@approve')->name('deposit.approve');
        Route::get('/deposit/{deposit}/delete', 'DepositController@destroy')->name('deposit.destroy');

        //withdraw
        Route::get('/withdraw', 'WithdrawController@index')->name('withdraw');
        Route::post('/withdraw', 'WithdrawController@store')->name('add.withdraw.method');
        Route::post('/withdraw-update', 'WithdrawController@withdrawUpdateSettings')->name('update.wsettings');
        Route::get('/withdraw/requests', 'WithdrawController@requests')->name('withdraw.requests');
        Route::put('/withdraw/approve/{id}', 'WithdrawController@approve')->name('withdraw.approve');
        Route::post('/withdraw/refund', 'WithdrawController@refundAmount')->name('withdraw.refund');


        //Email Template
        Route::get('/template', 'EtemplateController@index')->name('email.template');
        Route::post('/template-update', 'EtemplateController@update')->name('template.update');
        //Sms Api
        Route::get('/sms-api', 'EtemplateController@smsApi')->name('sms.api');
        Route::post('/sms-update', 'EtemplateController@smsUpdate')->name('sms.update');


        // General Settings
        Route::get('/general-settings', 'GeneralSettingController@GenSetting')->name('admin.GenSetting');
        Route::post('/general-settings', 'GeneralSettingController@UpdateGenSetting')->name('admin.UpdateGenSetting');
        Route::get('/change-password', 'GeneralSettingController@changePassword')->name('admin.changePass');
        Route::post('/change-password', 'GeneralSettingController@updatePassword')->name('admin.changePass');
        Route::get('/profile', 'GeneralSettingController@profile')->name('admin.profile');
        Route::post('/profile', 'GeneralSettingController@updateProfile')->name('admin.profile');


        //User Management
        Route::get('users', ['as' => 'users', 'uses' => 'GeneralSettingController@users']);
        Route::post('user-search', ['as' => 'search.users', 'uses' => 'GeneralSettingController@userSearch']);
        Route::get('user/{user}', ['as' => 'user.single', 'uses' => 'GeneralSettingController@singleUser']);
        Route::put('user/pass-change/{user}', ['as' => 'user.passchange', 'uses' => 'GeneralSettingController@userPasschange']);
        Route::put('user/status/{user}', ['as' => 'user.status', 'uses' => 'GeneralSettingController@statupdate']);
        Route::get('mail/{user}', ['as' => 'user.email', 'uses' => 'GeneralSettingController@userEmail']);
        Route::post('/sendmail', ['as' => 'send.email', 'uses' => 'GeneralSettingController@sendemail']);
        Route::get('/user-login-history/{id}', ['as' => 'user.login.history', 'uses' => 'GeneralSettingController@loginLogsByUsers']);
        Route::get('/user-balance/{id}', ['as' => 'user.balance', 'uses' => 'GeneralSettingController@ManageBalanceByUsers']);
        Route::post('/user-balance', ['as' => 'user.balance.update', 'uses' => 'GeneralSettingController@saveBalanceByUsers']);
        Route::get('/user-banned', ['as' => 'user.ban', 'uses' => 'GeneralSettingController@banusers']);
        Route::get('login-logs/{user?}', ['as' => 'user.login-logs', 'uses' => 'GeneralSettingController@loginLogs']);

        Route::get('/user-transaction/{id}', ['as' => 'user.trans', 'uses' => 'GeneralSettingController@userTrans']);
        Route::get('/user-deposit/{id}', ['as' => 'user.deposit', 'uses' => 'GeneralSettingController@userDeposit']);
        Route::get('/user-withdraw/{id}', ['as' => 'user.withdraw', 'uses' => 'GeneralSettingController@userWithdraw']);


        //Contact Setting
        Route::get('contact-setting', ['as' => 'contact-setting', 'uses' => 'WebSettingController@getContact']);
        Route::put('contact-setting/{id}', ['as' => 'contact-setting-update', 'uses' => 'WebSettingController@putContactSetting']);

        Route::get('manage-logo', ['as' => 'manage-logo', 'uses' => 'WebSettingController@manageLogo']);
        Route::post('manage-logo', ['as' => 'manage-logo', 'uses' => 'WebSettingController@updateLogo']);

        Route::get('manage-footer', ['as' => 'manage-footer', 'uses' => 'WebSettingController@manageFooter']);
        Route::put('manage-footer', ['as' => 'manage-footer-update', 'uses' => 'WebSettingController@updateFooter']);


        Route::get('manage-social', ['as' => 'manage-social', 'uses' => 'WebSettingController@manageSocial']);
        Route::post('manage-social', ['as' => 'manage-social', 'uses' => 'WebSettingController@storeSocial']);
        Route::get('manage-social/{product_id?}', ['as' => 'social-edit', 'uses' => 'WebSettingController@editSocial']);
        Route::put('manage-social/{product_id?}', ['as' => 'social-edit', 'uses' => 'WebSettingController@updateSocial']);
        Route::delete('manage-social/{product_id?}', ['as' => 'social-delete', 'uses' => 'WebSettingController@deleteSocial']);

        Route::get('menu-create', ['as' => 'menu-create', 'uses' => 'WebSettingController@createMenu']);
        Route::post('menu-create', ['as' => 'menu-create', 'uses' => 'WebSettingController@storeMenu']);
        Route::get('menu-control', ['as' => 'menu-control', 'uses' => 'WebSettingController@manageMenu']);
        Route::get('menu-edit/{id}', ['as' => 'menu-edit', 'uses' => 'WebSettingController@editMenu']);
        Route::post('menu-update/{id}', ['as' => 'menu-update', 'uses' => 'WebSettingController@updateMenu']);
        Route::delete('menu-delete', ['as' => 'menu-delete', 'uses' => 'WebSettingController@deleteMenu']);


        Route::get('manage-breadcrumb', ['as' => 'manage-breadcrumb', 'uses' => 'WebSettingController@mangeBreadcrumb']);
        Route::post('manage-breadcrumb', ['as' => 'manage-breadcrumb', 'uses' => 'WebSettingController@updateBreadcrumb']);

        Route::get('manage-about', ['as' => 'manage-about', 'uses' => 'WebSettingController@manageAbout']);
        Route::post('manage-about', ['as' => 'manage-about', 'uses' => 'WebSettingController@updateAbout']);


        Route::get('faqs-create', ['as' => 'faqs-create', 'uses' => 'WebSettingController@createFaqs']);
        Route::post('faqs-create', ['as' => 'faqs-create', 'uses' => 'WebSettingController@storeFaqs']);
        Route::get('faqs-all', ['as' => 'faqs-all', 'uses' => 'WebSettingController@allFaqs']);
        Route::get('faqs-edit/{id}', ['as' => 'faqs-edit', 'uses' => 'WebSettingController@editFaqs']);
        Route::put('faqs-edit/{id}', ['as' => 'faqs-update', 'uses' => 'WebSettingController@updateFaqs']);
        Route::delete('faqs-delete', ['as' => 'faqs-delete', 'uses' => 'WebSettingController@deleteFaqs']);

        Route::resource('advertisement', 'AdvertisementController');

    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
});


/*============== User Password Reset Route list ===========================*/
Route::get('user-password/reset', 'User\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
Route::post('user-password/email', 'User\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
Route::get('user-password/reset/{token}', 'User\ResetPasswordController@showResetForm')->name('user.password.reset');
Route::post('user-password/reset', 'User\ResetPasswordController@reset');




// <----------  Api Integration Part  ---------------->
Route::get('/TournamentList/{league_group}/{language_code}','SoccerController@getTournamentList');
Route::get('/dailySchedule/{league_group}/{language_code}/{year}/{month}/{date}','SoccerController@getDailySchedule');
Route::get('/dailyResults/{league_group}/{language_code}/{year}/{month}/{date}','SoccerController@getDailyResults');
Route::get('/DeletedMatches/{league_group}/{language_code}','SoccerController@getDeletedMatches');
Route::get('/LiveResults/{league_group}/{language_code}','SoccerController@getLiveResults');
Route::get('/MatchFun/{match_id}/{league_group}/{language_code}','SoccerController@getMatchFun');
Route::get('/MatchLineup/{match_id}/{league_group}/{language_code}','SoccerController@getMatchLineup');
Route::get('/MatchProbability/{match_id}/{league_group}/{language_code}','SoccerController@getMatchProbability');
Route::get('/MatchSummary/{match_id}/{league_group}/{language_code}','SoccerController@getMatchSummary');
Route::get('/MatchTimeline/{match_id}/{league_group}/{language_code}','SoccerController@getMatchTimeline');
Route::get('/MissingPlayer/{tournament_id}/{league_group}/{language_code}','SoccerController@getMissingPlayer');
Route::get('/PlayerProfile/{player_id}/{league_group}/{language_code}','SoccerController@getPlayerProfile');
Route::get('/TeamProfile/{team_id}/{league_group}/{language_code}','SoccerController@getTeamProfile');
Route::get('/TeamResults/{team_id}/{league_group}/{language_code}','SoccerController@getTeamResults');
Route::get('/TeamSchedule/{team_id}/{league_group}/{language_code}','SoccerController@getTeamSchedule');
Route::get('/TeamStatistics/{tournament_id}/{team_id}/{league_group}/{language_code}','SoccerController@getTeamStatistics');
Route::get('/TeamVsTeam/{team_id1}/{team_id2}/{league_group}/{language_code}','SoccerController@getTeamVsTeam');
Route::get('/TournamentInfo/{tournament_id}/{league_group}/{language_code}','SoccerController@getTournamentInfo');
Route::get('/TournamentLeaders/{tournament_id}/{league_group}/{language_code}','SoccerController@getTournamentLeaders');
Route::get('/TournamentLiveStandings/{tournament_id}/{league_group}/{language_code}','SoccerController@getTournamentLiveStandings');
Route::get('/TournamentResults/{tournament_id}/{league_group}/{language_code}','SoccerController@getTournamentResults');
Route::get('/TournamentSchedule/{tournament_id}/{league_group}/{language_code}','SoccerController@getTournamentSchedule');
Route::get('/TournamentSeasons/{tournament_id}/{league_group}/{language_code}','SoccerController@getTournamentSeasons');
Route::get('/TournamentStandings/{tournament_id}/{league_group}/{language_code}','SoccerController@getTournamentStandings');




Route::get('bookmaker/construct/{country}/{entry_type}/{stake_type}/{bookmaker_id}/{odds_type_id}/{odds_field_id}/{referrer_id}',
            'SoccerController@ConstructBookMark');

Route::get('bookmaker/linkpattern/{package}/{access_level}/{language_code}/{odds_format}','SoccerController@BookMarkLink');

Route::get('books/{package}/{access_level}/{language_code}/{odds_format}','SoccerController@getBooks');


// <------------------   My Code   ----------------------->

Route::get('/soccer/news/feed','NewsController@feed');



