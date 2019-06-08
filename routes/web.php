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

Route::get('/','PageController@WelcomePage');
Route::get('/masternode', function () {
    return view('masternode');
});
Route::get('/faq', function () {
    return view('faq');
});
Route::get('/admin/siteup', function () {
    \Artisan::call('up');
	return redirect('/');
});
Route::get('/cryptohunterstats', 'PageController@CryptoHunterStats');
Route::get('/makeipsix', 'PageController@makeipsix');
Route::get('/home', 'HomeController@Dashboard')->name('home');
Route::get('/apidata/apidata', 'PageController@Apidata');
Route::get('/apidata/mns', 'PageController@MasternodeStats');
Route::get('/apidata/freeip/{coin?}', 'PageController@FreeIps');
Route::get('/stats', 'CoinPageController@Stats');
Route::get('/coins', 'CoinPageController@coinpage')->name('coinpage');
Route::get('/deductiontest', 'DeductionController@DollarToBTC');
Route::get('/lsmudhai', 'Auth\LoginController@cklogin');
Route::get('/portfolio', 'PortfolioController@index')->name('portfolio');
Route::get('/password/change', 'HomeController@PReset');
Route::get('/home/view/{id}', 'HomeController@view')->name('home');
Route::post('/masternode/delete/{id}', 'MasternodeController@Delete');
Route::post('/rollback', 'RollbackController@Rollback');
Route::get('/notify', 'NotificationController@unreadNotifications')->name('testting');
Route::get('/other-currency', 'PaymentMethodController@PaymentMethod')->name('othercurrency');
Route::post('/other-currency', 'PaymentMethodController@PaymentMethodPost')->name('othercurrencypost');
Route::get('/btc-currency', 'BTCController@PaymentMethod')->name('btccurrency');
Route::post('/btc-currency', 'BTCController@PaymentMethodPost')->name('btccurrencypost');
Route::post('/addbalancebtc', 'BTCController@addBalToOC');
Route::post('/addBalance', 'PaymentMethodController@addBalToOC');
Route::post('/markasread', 'NotificationController@MarkAsRead')->name('markasread');
Route::get('/sapi', 'NotificationController@Sapi');
Route::post('/sapi', 'NotificationController@Sapi');
Route::post('/chargestest', 'NotificationController@PostHosting');
Route::get('/coinss', 'CoinPageController@coinpage');
Route::post('/enable_notification', 'HomeController@EnableNotification')->name('EnableNotification');



Route::get('/ips', 'HomeController@Ip');
Route::get('/ssh', 'ServerController@Moniter');
Route::get('/moniter', 'HomeController@Moniter')->name('moniter');
Route::get('/hostingcharges', 'HomeController@HostingCharges')->name('hostingcharges');
Route::get('/history/fees', 'HistoryController@Fees')->name('feeshistory');
Route::get('/history/withdraw', 'HistoryController@Withdraw')->name('withdrawthistory');
Route::get('/history/deposit', 'HistoryController@Deposit')->name('deposithistory');
Route::get('/moniter/{id}', 'HomeController@Moniter');
Route::get('/tranxaction/{id}', 'ProfileController@Coin');
Route::post('/checkstatus/{id}', 'MasternodeController@CheckStatus');
Route::post('/walletinfo/{id}', 'MasternodeController@WalletInfo');
Route::post('/tranxaction/{id}', 'ProfileController@VerifyTranxaction');
Route::get('/charges', 'ProfileController@GetHosting');
Route::post('/charges', 'ProfileController@PostHosting');
/* Route::post('/tranxaction', 'ProfileController@SaveCredits'); */
Route::post('/logins', 'Auth\LoginController@postLogin')->name('logins');
Route::post('/seedregister', 'Auth\RegisterController@SeedRegister')->name('seedregister');
Route::post('/masternodecreate', 'MasternodeController@MasternodeLaunch')->middleware(['auth']);
Route::post('/masternodecreate/{step}', 'MasternodeController@NodeSetup')->middleware(['auth']);
Route::post('/masternodestart', 'MasternodeController@NodeStart')->middleware(['auth']);
Route::post('/encrypt/{id}', 'MasternodeController@StartNodeInstruction')->middleware(['auth']);
Route::get('/masternodecreate', 'MasternodeController@test');
Route::get('/mn-data', 'Auth\BlockchainController@getMnData');
Route::post('/profile-settings', 'ProfileController@SaveSettings');
Route::get('email', 'EmailController@sendEmail');


//Route::get('/coins-info', 'Auth\BlockchainController@coinsInfo');
Auth::routes();
//admin url 




//Route::get('/withdraw', 'WithdrawController@Index');
//Route::post('/withdraw', 'WithdrawController@Withdraw');
Route::get('/admin/login', 'Admin\LoginController@Login')->name('adminlogin');
Route::post('/admin/login', 'Admin\LoginController@Authenticate')->name('adminloginp');
Route::prefix('admin')->middleware('admin')->namespace('Admin')->group(function () {
   
	Route::get('/', 'AdminController@index')->name('adminhome');
	Route::get('/sample', 'ServerController@getDownload')->name('getDownload');
	Route::post('/home', 'AdminController@UpdateSettings')->name('UpdateSettings');
	Route::get('/home', 'AdminController@index')->name('adminhome');  
	Route::get('/users', 'AdminController@Users')->name('adminuser');
	Route::get('/hosting', 'HostingController@Index')->name('hostingAdmin');
	Route::post('/down', 'AdminController@SiteDown')->name('SiteDown');
	Route::get('/up', 'AdminController@SiteUp')->name('SiteUp');
	Route::post('/ips', 'HomeController@Ip');
	Route::get('/invoice/month/{month}', 'InvoiceController@Month')->name('invoicemonth');
	Route::get('/invoice/export/{month}/{type}', 'InvoiceController@Export')->name('invoiceexport');
	Route::get('/invoice', 'InvoiceController@Index')->name('invoice');
	Route::get('/user/{id}', 'AdminController@User')->name('adminuser');
	Route::get('/user/{id}/suspend', 'AdminController@SuspendUser')->name('SuspandUser');
	Route::get('/user/{id}/activate', 'AdminController@ActivateUser')->name('ActivateUser');
	Route::get('/user/{id}/delete', 'AdminController@DeleteUser')->name('DeleteUser');
	Route::get('/user/{id}/mail', 'AdminController@MailUser')->name('mailUser');
	Route::get('/server', 'ServerController@server')->name('servr');
	Route::get('/server/create', 'ServerController@CreateServer')->name('CreateServer');
	Route::post('/server/create', 'ServerController@CreateServerPost')->name('CreateServerPost');
	Route::get('/server/delete/{id}', 'ServerController@DeleteServer')->name('DelServer');
	Route::get('/server/{id}', 'ServerController@ServerDetail')->name('singleServer');
	Route::get('/server/{server}/ip/{ip}/delete', 'ServerController@DelIP');

	Route::get('/server/{id}/ip', 'ServerController@ServerIP');
	Route::post('/server/{id}', 'ServerController@ServerADDIP')->name('ServerADDIP');
	Route::post('/masternodecreate/{step}', 'MasternodeController@NodeSetup');

	Route::get('/user/{id}/transactions', 'AdminController@TransactionsUser')->name('TransactionsUser');
	Route::get('/user/{id}/masternode/{node}', 'AdminController@MasternodeUser')->name('MasternodeUser');
	Route::get('/transactions', 'AdminController@Transactions')->name('Transactions');
	Route::post('/checkstatus/{id}', 'MasternodeController@CheckStatus');
	Route::post('/checkstatus/{id}', 'MasternodeController@CheckStatus');
	Route::post('/masternode/delete/{id}', 'MasternodeController@Delete');
	Route::resource('coins', 'CoinController');
	Route::get('/wallet', 'WalletController@Index');
	Route::get('/wallet/refresh', 'WalletController@Refreshbal');
	Route::post('/wallet/send', 'WalletController@Send');
	Route::get('/makefree', 'AdminController@MakeFreeIPS');
	Route::get('/template', 'TemplateController@Index');
	Route::resource('template', 'TemplateController');
	// Route::post('/template', 'TemplateController@Store');
	// Route::get('/template/{id}', 'TemplateController@Show');
	// Route::post('/template/{id}', 'TemplateController@Update');
	// Route::post('/template/{id}/delete', 'TemplateController@Destroy');
	Route::post('/mail/{id}', 'TemplateController@SendTemplate')->name('templatesend');
	Route::post('/image/upload', 'TemplateController@Upload')->name('tempimage');
});








