<?php
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "0");
	define("DB_NAME", "club_db");

	$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.,DB_NAME,DB_PASS);
	if(!$pdo){
		echo "Could not connect to mysql";
	 	exit;
	}
	$sql = "SELECT * FROM feed_details";
	$sth = $pdo->prepare($sql);
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $key => $value) {
		# code...
		// $get_time = new DateTime($value['create_time']);
		// $get_time->add(new DateInterval('PT24H'));
		// $current_time = new DateTime();
		// $current_time->setTimezone(new DateTimeZone('UTC'));
		// if(($get_time<$current_time)&&($value['state']==1)){
		// 	$sql_temp = "UPDATE hire_tb SET state=4 WHERE _id=".$value['_id'];
		// 	$update = $pdo->prepare($sql_temp);
		// 	$update->execute();
		// }
		$sql1 = "SELECT * FROM device_tokens WHERE notify=1 AND bundle_id='".$value->app_bundle_id."'";
		$sth1 = $pdo->prepare($sql1);
		$sth1->execute();
		$result1 = $sth1->fetchAll();
		if(count($result1)){

		}
	}
	 	$q="NBC";

		//find out which feed was selected
		if($q=="Google") {
		    $xml=("https://www.theguardian.com/international/rss");
		} elseif($q=="NBC") {
		  $xml=("http://rss.msnbc.msn.com/id/3032091/device/rss/rss.xml");
		}

	  $xmlDoc = new \DOMDocument();
	  $xmlDoc->load($xml);
	  //get and output "<item>" elements
	  $x=$xmlDoc->getElementsByTagName('item');
	  $now = new \DateTime();
	  $now->sub(new \DateInterval('PT1H'));
	  $count = 0;
	  $length = $x->length;
	  for ($i=0; $i<$length; $i++) {
	     $item_date=$x->item($i)->getElementsByTagName('pubDate')
	    ->item(0)->childNodes->item(0)->nodeValue;
	    $date = new \DateTime($item_date);
	    if($date>=$now){
	      $count++;
	    }
	}
	echo $count;
?>