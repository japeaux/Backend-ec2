<?php
	$to = 'dKpOML7ZLIA:APA91bFhTghUqP4gpCkohaf3h1WzCjDwQTrMg2JbUJjEQ9WegZgXWZQSNWtwoeAIu98bLK6wtSByVo1jluGyPmVmBxrvEWu6sluypuLk6O7F_18Z_e2kko7UQdK16Hu7O4qxsvstCmSI';
	$data = array(
	'body' =>'New Message'
	);
	$apiKey = 'AAAATsLpVfo:APA91bEph8ut7xPtKVJXPfK89IwDIRidGVkVKECccLpLPzNsd_YMuVkE7BXDNsvqvCUVyIbaMQ47ZFFAi2r7MeoKT2sjTfcIs_J9DAFYljwZeWsJaV_icyq07Jgf9uY6l0exIt9CmHNJ';
	$fields = array('to'=>$to, 'notification'=>$data);
	$headers = array('Authorization': 'key=AAAATsLpVfo:APA91bEph8ut7xPtKVJXPfK89IwDIRidGVkVKECccLpLPzNsd_YMuVkE7BXDNsvqvCUVyIbaMQ47ZFFAi2r7MeoKT2sjTfcIs_J9DAFYljwZeWsJaV_icyq07Jgf9uY6l0exIt9CmHNJ',
                             'Content-Type': 'application/json');
	$url = 'https://fcm.googleapis.com/fcm/send';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	$result = curl_exec($ch);
	curl_close($ch);
	return json_decode($result,true);

?>
