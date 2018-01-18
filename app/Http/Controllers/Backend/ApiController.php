<?php

namespace App\Http\Controllers\Backend;

use App\App;
use App\FeedDetail;
use App\DeviceToken;
use App\DeviceOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $json_array = json_decode($request->getContent(), true);
        $bundle_id = $json_array['bundle_id'];
        // $bundle_id = $request->bundle_id;
        $app = App::where('bundle_id',$bundle_id)->first();
        $feeds = FeedDetail::select(DB::raw('feed_details.feed_id as id,feed_details.team_name as name,feed_details.link as url, IF(feed_details.customed_title IS NULL or feed_details.customed_title="",feeds.title, feed_details.customed_title) as provider,CONCAT("'.url('/').'/",IF(feed_details.customed_logo IS NULL or feed_details.customed_logo="",feeds.logo, feed_details.customed_logo)) as logo'))->leftjoin('feeds', 'feeds.id','=','feed_details.feed_id')->where('feed_details.app_bundle_id',$bundle_id)->get();
        if($app){
          $back_arr = explode(',',$app->background);
          $back = '#'.sprintf("%02X", $back_arr[3]).sprintf("%02X", $back_arr[0]).sprintf("%02X", $back_arr[1]).sprintf("%02X", $back_arr[2]);
        }
        return response()->json([
          'app_name' => isset($app->title)?$app->title:'',
          'bundle_id' => isset($app->bundle_id)?$app->bundle_id:$bundle_id,
          'res' => [
            'layout_type' => isset($app->layout)?$app->bundle_id:'',
            'logo' => isset($app->logo)?url('/').'/'.$app->logo:'',
            'background' =>isset($back)?$back:''
          ],
          'feeds' => $feeds
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeDeviceToken(Request $request)
    {
        //        
        $json_array = json_decode($request->getContent(), true);
        $data = [];
        $data['bundle_id'] = $json_array['bundle_id'];
        $data['device_id'] = $json_array['device_id'];
        $data['device_token'] = $json_array['device_token'];        
        // $data['bundle_id'] = $request->bundle_id;
        // $data['device_id'] = $request->device_id;
        // $data['device_token'] = $request->device_token;
        $device = DeviceToken::where('bundle_id', $data['bundle_id'])->where('device_id', $data['device_id'])->first();
        if($device){
          $device->device_token = $data['device_token'];
          $device->save();
        }else{
          DeviceToken::insert($data);
        }
        return response()->json([
          "status"=> "success"
        ]);
    }

    public function storeOption(Request $request)
    {
        $json_array = json_decode($request->getContent(), true);
        $data = [];
        $data['bundle_id'] = $json_array['bundle_id'];
        $data['device_id'] = $json_array['device_id'];
        $options = $json_array['setting'];
        foreach ($options as $key => $value) {
          # code...
          $device = DeviceOption::where('bundle_id', $data['bundle_id'])->where('device_id', $data['device_id'])->where('id',$value['id'])->first();
          if($device){
            $device->on = $value['on'];
            $device->save();
          }else{
            $data['on'] = $value['on'];
            $data['id'] = $value['id'];
            DeviceOption::insert($data);
          }
        }
        
        return response()->json([
          "status"=> "success"
        ]);
    }

    public function getOption(Request $request)
    {
        $json_array = json_decode($request->getContent(), true);
        $data = [];
        $data['bundle_id'] = $request->bundle_id;
        $data['device_id'] = $request->device_id;
        $device = DeviceOption::select(array('id','on'))->where('bundle_id', $data['bundle_id'])->where('device_id', $data['device_id'])->get();
        if($device){
          return response()->json($device);
        }
        else{
          return response()->json(NULL);
        }
    }
}
