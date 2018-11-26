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

Route::get('/', function () {
    return Redirect::to('/login');
});

Auth::routes();




Route::group(array('module' => 'Member', 'prefix' => 'member', 'middleware' => ['auth','member']), function () {
	Route::get('/home', 'MemberController@index')->name('member.home');
	Route::get('/members_invoice', 'MemberController@invoices_view')->name('member.members_invoice');
	Route::get('/account', 'MemberController@account_view')->name('member.account');
	Route::get('/payments', 'MemberController@payments_view')->name('member.payments');
	Route::get('/dues', 'MemberPaymentController@viewDues');
	Route::get('/statement', 'MemberController@viewStatement')->name('member.statement');
	Route::get('/statementpdf', 'MemberController@viewStatementPdf')->name('member.statementpdf');
	Route::get('/chapter', 'MemberController@chapter_view')->name('member.chapter');
	Route::get('/landing', 'MemberController@landing_view')->name('member.landing');
	Route::get('/events', 'MemberController@events_view')->name('member.events');
	Route::get('/map', 'MemberController@loadMap')->name('member.map');
	Route::get('/getmemberinfo', 'MemberController@getMemberInfo');
	Route::post('/profile/update', 'MemberController@updateProfile');
	Route::post('/payment/create', 'MemberPaymentController@paymentPaypal');
	Route::any('/payment/update', ['uses' => 'MemberPaymentController@updatePaypal', 'as' => 'member.updatePaypal']);
	Route::get('/invoice/{invoiceid}', 'AdminXeroController@loadXeroInvoicePDF');
	Route::get('/eventlist', 'MemberController@getEvents');	
	Route::get('/lifemember', 'LifeMemberController@viewLifeMember');	
});


Route::group(array('module' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','admin']), function () {
	//Membership
	Route::get('/membership', 'Admin\MembershipController@index')->name('admin.membership');
	Route::get('/home', 'Admin\MembershipController@index')->name('admin.membership');
	Route::post('/membership/add', ['uses' => 'Admin\MembershipController@createMember', 'as' => 'member.add']);
	Route::post('/membership/update/{id}', ['uses' => 'Admin\MembershipController@updateMember', 'as' => 'member.update']);
	Route::get('/membership/delete', ['uses' => 'Admin\MembershipController@deleteMember', 'as' => 'member.delete']);
	Route::get('/membership/{member}', 'Admin\MembershipController@getMemberInfo');
	Route::any('/membership/getmemberall', 'Admin\MembershipController@getMemberAll');
	Route::get('/getunverifiedaccount', 'Admin\RegistrationController@getUnverifiedAccount');
	Route::get('/mem/getdeletedmember', 'Admin\MembershipController@getDeletedMember');
	Route::any('/membership/restoremember/{id}', 'Admin\MembershipController@restoreMember');
	Route::get('/home/getchapter', 'Admin\MembershipController@getChapters');
	Route::get('/home/getmaxid', 'Admin\MembershipController@getMaxIDMembership');
	//
	Route::get('/invoices/{contactid}', 'AdminXeroController@loadInvoices');	
	//Invoices
	Route::get('/invoices', 'HomeController@loadInvoices')->name('admin.invoices');
	Route::get('/dashboard', ['uses' => 'AdminController@dash', 'as' => 'admin.dashboard']);
	//
	//Chapter
	Route::get('/chapter', 'Admin\ChapterController@index')->name('admin.chapter.index');
	Route::post('/chapter/add', 'Admin\ChapterController@createChapter')->name('admin.chapter.create');
	Route::post('/chapter/update/{id}', ['uses' => 'Admin\ChapterController@updateChapter', 'as' => 'admin.chapter.update']);
	Route::get('/chapter/delete', ['uses' => 'Admin\ChapterController@deleteChapter', 'as' => 'admin.chapter.delete']);
	Route::get('/chapter/{chapter}', 'Admin\ChapterController@getChapter');
	Route::get('/chapter/report/{chapter}', 'Admin\ChapterController@getChapterReport');
	//
	//Payments
	Route::get('/create_payment', 'Admin\PaymentController@index')->name('admin.payments');
	Route::get('/payments/getmembersearch/{key}', 'Admin\PaymentController@getMemberSearch')->name('admin.payments');
	Route::get('/payments/statement/{yearpaid}/{snum}', 'Admin\PaymentController@statement')->name('admin.payments');
	Route::get('/payments/getpaymenthistory/{snum}', 'Admin\PaymentController@getPaymentHistory')->name('admin.payments');
	Route::post('/payments/add', 'Admin\PaymentController@createPayment')->name('admin.payments');
	//
	Route::get('/life', 'AdminController@life_view')->name('admin.life');
	Route::get('/students', 'AdminController@studentsView')->name('admin.students');
	Route::get('/maps', 'AdminController@mapView')->name('admin.maps');
	Route::get('/registration', 'Admin\RegistrationController@registration')->name('admin.registration');
	Route::get('/verifyAccount/{id}', 'Admin\RegistrationController@verifyAccount')->name('admin.verifyAccount');
	Route::get('/deleteAccount/{id}', 'Admin\RegistrationController@deleteAccount')->name('admin.deleteAccount');
	Route::get('/resyncAccount/{id}', 'Admin\RegistrationController@resyncAccount')->name('admin.resyncAccount');

	Route::get('/bluecards', 'AdminController@bluecards_view')->name('admin.bluecards');
	
	Route::any('/deletepayment/{payment}', 'AdminController@deletePayment');

	Route::get('/pdf', 'HomeController@generatePdf')->name('admin.generatePdf');

});
