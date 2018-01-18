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

use App\App;
use App\Feed;
use App\FeedDetail;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//Feed Source Routing - Web Site
Route::post('feed/upload', 'Backend\BackEndController@uploadFeedLogo')->name('feed.upload');
Route::post('feed/store', array('uses'=>'Backend\BackEndController@storeFeed'));
Route::post('feed/get_source', array('uses'=>'Backend\BackEndController@getFeedSources'));
Route::post('feed/get_feed', array('uses'=>'Backend\BackEndController@getFeed'));
Route::post('feed/delete', array('uses'=>'Backend\BackEndController@deleteFeedSource'));
Route::post('feeditem/get_feed_item', array('uses'=>'Backend\BackEndController@getFeedItem'));
Route::post('feeditem/update', array('uses'=>'Backend\BackEndController@updateFeedItem'));
Route::post('feeditem/delete', array('uses'=>'Backend\BackEndController@deleteFeedItem'));
Route::post('app/store', array('uses'=>'Backend\BackEndController@storeApp'));
Route::post('app/get_app_infos', array('uses'=>'Backend\BackEndController@getAppInfos'));
Route::post('app/delete', array('uses'=>'Backend\BackEndController@deleteApp'));
Route::get('datatable/{what}', function ($what) {
  $itemsPerPage = Input::get('items_per_page', 10);
  $paginator = null;
  if ($what == 'app') {
    $paginator = App::simplePaginate($itemsPerPage);
  }

  if ($what == 'feed') {
    $paginator = Feed::simplePaginate($itemsPerPage);
  }

  if($what == 'feeditem'){
  	$paginator = FeedDetail::select(DB::raw('feed_details.*, IF(feed_details.customed_title IS NULL or feed_details.customed_title="",feeds.title, feed_details.customed_title) as feed_title,IF(feed_details.customed_logo IS NULL or feed_details.customed_logo="",feeds.logo, feed_details.customed_logo) as logo,apps.title as app_title'))->leftjoin('feeds', 'feeds.id','=','feed_details.feed_id')->leftjoin('apps','apps.bundle_id','=','feed_details.app_bundle_id')->simplePaginate($itemsPerPage);
  }

  if ($what == 'users') {
    $paginator = User::simplePaginate($itemsPerPage);
  }
  return response()->json($paginator);
});

//Feed Source Routing - Mobile API

Route::post('/api/get', array('uses'=>'Backend\ApiController@index'));
Route::post('/api/store_token', array('uses'=>'Backend\ApiController@storeDeviceToken'));
Route::post('/api/store_option', array('uses'=>'Backend\ApiController@storeOption'));
Route::post('/api/get_option', array('uses'=>'Backend\ApiController@getOption'));
// Route::get('/api/get_rss', array('uses'=>'Backend\ApiController@getRss'));