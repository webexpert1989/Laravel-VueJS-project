<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\App;
use App\FeedDetail;
use App\DeviceToken;
use App\DeviceOption;
use Illuminate\Support\Facades\DB;

use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

class SendPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendPush:push_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $sql = "SELECT * FROM feed_details";
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        $apps = Apps::get();
        $results = [];
        foreach ($apps as $key => $value) {
            $temp = [];
            $temp['fcm_key'] = $value->fcm_key;
            $feeds = FeedDetail::select(array('feed_id', 'link'))->get();
            $tokens = Device::select(DB::raw('device_tokens.device_tokens'))->leftjoin('device_options', function($join){
                $join->on('device_tokens.device_id', '=', 'device_options.device_id');
                $join->on('device_tokens.bundle_id', '=', 'device_options.bundle_id');
            })->where('device_tokens.bundle_id', $value->app_bundle_id)->get();
            $temp['feeds'] = [];
            $temp['feeds'] = $feeds;
            $temp['tokens'] = [];
            $temp['tokens'] = $tokens;
            array_push($results, $temp);
        }

        foreach ($results as $key => $value) {
            # code...
            $data = [];
            foreach ($value->feeds as $key1 => $value1) {
                # code...
                array_push($data, ['feed_id'=>$value1->feed_id,'count'=>$this->getCount($value1->link)]);
            }
            $this->sendPush($value->fcm_key, $value->tokens, $data);
        }
    }

    public getCount($xml)
    {        
        $xmlDoc = new \DOMDocument();
        $xmlDoc->load($xml);
        //get and output "<item>" elements
        $x=$xmlDoc->getElementsByTagName('item');
        $now = new \DateTime();
        $now->sub(new \DateInterval('PT1H'));
        $count = 0;
        $length = $x->length;
        for ($i=0; $i<$length; $i++) {
            $item_date=$x->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;
            $date = new \DateTime($item_date);
            if($date>=$now){
              $count++;
            }
        }
        return $count;
    }

    public sendPush($api_key, $tokens, $data)
    {
        $server_key = $api_key;
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        $message = new Message();
        $message->setPriority('high');
        foreach ($tokens as $key => $value) {
            # code...
            $message->addRecipient(new Device($value->device_token));
        }

        $message->setNotification(new Notification('New Rss Feeds', 'You have new rss feeds'))->setData($data);

        $response = $client->send($message);
        var_dump($response->getStatusCode());
        var_dump($response->getBody()->getContents());
    }
}
