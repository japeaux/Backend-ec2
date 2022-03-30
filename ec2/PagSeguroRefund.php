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
		
		$code =  $request->code;


		$emailPagseguro = "lucascovatti@hotmail.com";

		
		

		$Url="https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/refunds?email=".$emailPagseguro."&token="."5A5CCE8C99C84A5BA72450A5D0CDDE92"."&transactionCode={$code}";

		$Curl=curl_init($Url);
		curl_setopt($Curl,CURLOPT_HTTPHEADER,Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
		curl_setopt($Curl,CURLOPT_POST,true);
		curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
		$Retorno=curl_exec($Curl);
		curl_close($Curl);

		$Xml=simplexml_load_string($Retorno);

        $mysqli = new mysqli("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
        if ($mysqli->connect_errno) {
            echo "Sorry, this website is experiencing problems.";


            echo "Error: Failed to make a MySQL connection, here is why: \n";
            echo "Errno: " . $mysqli->connect_errno . "\n";
            echo "Error: " . $mysqli->connect_error . "\n";

            exit;
        }
        	
        mysqli_set_charset($mysqli, 'utf8');
	    $sql = "UPDATE diwoDB.pagamentos SET  status = '6' WHERE code = '$code'";
	    if ($mysqli->query($sql) === TRUE) {
	        $data = array("success"=>true, "msg"=>'Atualizado');
	        $json_str = json_encode($data);
	        echo  "$json_str"; 
	    } else {
	        $data = array("success"=>false, "errMsg"=>'Aconteceu um erro');
	        $json_str = json_encode($data);
	        echo  "$json_str";  
	    }
        
   
	}
	else {
			echo  "Error"; 
	}
$mysqli->close();
?>
