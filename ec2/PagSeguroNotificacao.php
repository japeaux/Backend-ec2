<?php

	//http://stackoverflow.com/questions/18382740/cors-not-working-php
	if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }


    $postdata = file_get_contents("php://input");
	if (isset($postdata)) {
		$request = json_decode($postdata);

                        //$_SERVER['REMOTE_ADDR']
		



		$emailPagseguro = "lucascovatti@hotmail.com";
        $Url="https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/{$_POST['notificationCode']}?email=".$emailPagseguro."&token="."5A5CCE8C99C84A5BA72450A5D0CDDE92"."";

		$Curl=curl_init($Url);
		curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,true);
		curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
		$Retorno=curl_exec($Curl);
		curl_close($Curl);

		$Xml=simplexml_load_string($Retorno);
		
		$status =  $Xml -> status;
		$reference =  $Xml -> reference;
		
		// $Crud=$Con->prepare("update diwoDB.pagamentos set status=? where reference=?");
		// $Crud->bindValue(1,$Xml->status);
		// $Crud->bindValue(2,$Xml->reference);
		// $Crud->execute();

        $mysqli = new mysqli("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
        if ($mysqli->connect_errno) {
            echo "Sorry, this website is experiencing problems.";


            echo "Error: Failed to make a MySQL connection, here is why: \n";
            echo "Errno: " . $mysqli->connect_errno . "\n";
            echo "Error: " . $mysqli->connect_error . "\n";

            exit;
        }
        	define( 'API_ACCESS_KEY', 'AAAATsLpVfo:APA91bEph8ut7xPtKVJXPfK89IwDIRidGVkVKECccLpLPzNsd_YMuVkE7BXDNsvqvCUVyIbaMQ47ZFFAi2r7MeoKT2sjTfcIs_J9DAFYljwZeWsJaV_icyq07Jgf9uY6l0exIt9CmHNJ' );
            $registrationIds = array( 'dKpOML7ZLIA:APA91bFhTghUqP4gpCkohaf3h1WzCjDwQTrMg2JbUJjEQ9WegZgXWZQSNWtwoeAIu98bLK6wtSByVo1jluGyPmVmBxrvEWu6sluypuLk6O7F_18Z_e2kko7UQdK16Hu7O4qxsvstCmSI' );
                // prep the bundle
            $msg = array
            (
                'body'   => 'Compra confirmada',
                'title'     => 'Sua compra foi confirmada, atenção para a data do evento',
                // 'subtitle'  => 'This is a subtitle. subtitle',
                'tickerText'    => 'Ticker text here...Ticker text here...Ticker text here',
                'vibrate'   => 1,
                'sound'     => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon'
            );

        mysqli_set_charset($mysqli, 'utf8');
	    $sql = "UPDATE diwoDB.pagamentos SET  status = '$status' WHERE reference = '$Xml->reference'";
	    if ($mysqli->query($sql) === TRUE) {
	        $data = array("success"=>true, "msg"=>'Atualizado');
	        $json_str = json_encode($data);
	        echo  "$json_str"; 
	    } else {
	        $data = array("success"=>false, "errMsg"=>'Aconteceu um erro');
	        $json_str = json_encode($data);
	        echo  "$json_str";  
	    }
	    if($status == '3' || $status == 3){
	    	$sql2="SELECT * FROM diwoDB.pagamentos WHERE reference = '$reference' "; 
	        $result = mysqli_query($mysqli,$sql2);
	        $data = array();
	        if(mysqli_num_rows($result) >= 1){
	            while($row = mysqli_fetch_assoc($result)){
	                $data[] = $row;
	                $json_str = array($row['devicetoken']);
	                $fields = array
	                (
	                    'registration_ids'  => $json_str,
	                    'data'          => $msg
	                );
	               
	                $headers = array
	                (
	                    'Authorization: key=' . API_ACCESS_KEY,
	                    'Content-Type: application/json'
	                );
	                 
	                $ch = curl_init();
	                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	                curl_setopt( $ch,CURLOPT_POST, true );
	                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	                $result = curl_exec($ch );
	                curl_close( $ch );
	                //echo $result;
	            }   
			}

			$sql3 = "UPDATE diwoDB.pessoaevento SET estado='2', confirmacao = 'Confirmação aprovada' WHERE reference = '$reference'";
            if ($mysqli->query($sql3) === TRUE) {
                $data = array("success"=>true, "msg"=>'Atualizado');
                $json_str = json_encode($data);
                echo  "$json_str"; 
            } else {
                $data = array("success"=>false, "errMsg"=>'Aconteceu um erro');
                $json_str = json_encode($data);
                echo  "$json_str";  
            }
	    }
        
        
        

	}
	else {
			echo  "Error"; 
	}
$mysqli->close();
?>
