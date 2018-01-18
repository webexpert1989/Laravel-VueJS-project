<?php

namespace App\Http\Controllers\Backend;

use App\App;
use App\Feed;
use App\FeedDetail;
use App\DeviceToken;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BackEndController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
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

//------------ Store --------------//

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function storeFeed(Request $request)
  {
    if(!$request['id']){
      $feed = Feed::create([
        'title' => $request['title'],
        'logo' => $request['url']
      ]);
    }else{
      Feed::where('id', $request['id'])->update([
        'title' => $request['title'],
        'logo' => $request['url']
      ]);
    }

    return response()->json([
      'status' => 'success'
    ]);
  }

/**
   * Store a newly created app in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function storeApp(Request $request)
  {
    $file = $request->file('logo');
    // $path = Storage::disk('public')->put('logos', $file);
    $path = '';
    if($file){
      $name = $file->getClientOriginalName();
      $file_name = pathinfo($name, PATHINFO_FILENAME).time(); // file
      $extension = pathinfo($name, PATHINFO_EXTENSION); // jpg
      $path = 'logos/'.$file_name.'.'.$extension;
      $file->move(public_path('logos/'), $file_name.'.'.$extension);
    }
    if($request['id']){
      $data = [
        'title' => $request['title'],
        'bundle_id' => $request['bundle_id'],
        'layout' => $request['layout'],
        'background' => $request['background'],
        'fcm_key' => $request['fcm_key'],
        'user_id' => Auth::user()->id
      ];
      if($path){
        $data['logo'] = $path;
      }
      App::where('id', $request['id'])->update($data);
    }else{
      App::insert([
        'title' => $request['title'],
        'bundle_id' => $request['bundle_id'],
        'layout' => $request['layout'],
        'logo' => $path,
        'background' => $request['background'],
        'fcm_key' => $request['fcm_key'],
        'user_id' => Auth::user()->id
      ]);
    }
    $feeds = json_decode($request['services']);
    FeedDetail::where('app_bundle_id',$request['bundle_id'])->delete();
    //print_r($request['bundle_id']);
    foreach ($feeds as $key => $value) {
      # code...
      FeedDetail::insert([
        'link' => $value->link,
        'team_name' => $value->team_name,
        'app_bundle_id' => $request['bundle_id'],
        'feed_id' => $value->id,
        'order' => $key,
        'customed_title'=>$value->title==$value->default_title?'':$value->title,
        'customed_logo'=>$value->logo==$value->default_logo?'':$value->logo
      ]);
    }

    return response()->json([
      'status' => 'success'
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function updateFeedItem(Request $request)
  {    
    $data['team_name'] = $request['team_name'];
    $data['link'] = $request['link'];
    $data['customed_title'] = $request['title'];
    $data['customed_logo'] = $request['logo'];
    FeedDetail::where('id', $request['id'])->update($data);
    return response()->json([
      'status' => 'success'
    ]);
  }


  public function uploadFeedLogo(Request $request)
  {
    $file = $request->file('file');
    // $path = Storage::disk('public')->put('logos', $file);
    $name = $file->getClientOriginalName();
    $file_name = pathinfo($name, PATHINFO_FILENAME).time(); // file
    $extension = pathinfo($name, PATHINFO_EXTENSION); // jpg
    $path = 'logos/'.$file_name.'.'.$extension;
    $file->move(public_path('logos/'), $file_name.'.'.$extension);
    return response()->json([
      'status' => 'success',
      'url' => $path
    ]);
  }

//------------ Get --------------//

  public function getFeedSources()
  {
    $feeds = Feed::get();
    return response()->json([
      'status' => 'success',
      'feeds' => $feeds
    ]);
  }

  public function getAppInfos(Request $request)
  {
    $id = $request['id'];
    $app = App::where('id', $id)->first();
    $feedItems = FeedDetail::select(DB::raw('feed_details.*, feeds.title as default_title, feeds.logo as default_logo'))->leftjoin('feeds', 'feeds.id','=','feed_details.feed_id')->orderBy('feed_details.order','ASC')->where('app_bundle_id', $app->bundle_id)->get();
    $filter_feeds = [];
    foreach ($feedItems as $key => $value) {
      # code...
      array_push($filter_feeds, $value->feed_id);
    }
    $provideFeeds = Feed::whereNotIn('id',$filter_feeds)->get();
     return response()->json([
      'status' => 'success',
      'app' => $app,
      'feedItems' => $feedItems,
      'provideFeeds' => $provideFeeds
    ]);
  }

  public function getFeed(Request $request)
  {
    $feed = Feed::where('id', $request['id'])->first();
    $feed['filesize'] = filesize($feed->logo);
    return response()->json([
      'status' => 'success',
      'feed' => $feed
    ]); 
  }

  public function getFeedItem(Request $request)
  {
    $feedItem = FeedDetail::select(DB::raw('feed_details.*, IF(feed_details.customed_title IS NULL or feed_details.customed_title="",feeds.title, feed_details.customed_title) as feed_title, feeds.title as default_title, IF(feed_details.customed_logo IS NULL or feed_details.customed_logo="",feeds.logo, feed_details.customed_logo) as logo,apps.title as app_title'))->leftjoin('feeds', 'feeds.id','=','feed_details.feed_id')->leftjoin('apps','apps.bundle_id','=','feed_details.app_bundle_id')->where('feed_details.id', $request['id'])->first();
      $feedItem['filesize'] = filesize($feedItem->logo);
      return response()->json([
        'status' => 'success',
        'feeditem' => $feedItem
      ]);
  }

//------------ Delete --------------//

  public function deleteFeedItem(Request $request)
  {
    $id = $request['id'];
    FeedDetail::where('id', $id)->delete();
    return response()->json([
        'status' => 'success'
    ]);
  }

  public function deleteApp(Request $request)
  {
    $id = $request['id'];
    $app = App::where('id',$id)->first();
    FeedDetail::where('app_bundle_id', $app->bundle_id)->delete();
    DeviceToken::where('bundle_id', $app->bundle_id)->delete();
    App::where('id', $id)->delete();
    return response()->json([
        'status' => 'success'
    ]);
  }

  public function deleteFeedSource(Request $request)
  {
    $id = $request['id'];
    Feed::where('id', $id)->delete();
    FeedDetail::where('feed_id', $id)->delete();
    return response()->json([
        'status' => 'success'
    ]);
  }
}
