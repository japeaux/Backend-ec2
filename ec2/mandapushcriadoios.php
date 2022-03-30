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


    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
	if (isset($postdata)) {
		$request = json_decode($postdata);
		$titulo = $request->titulo;
        $msg = $request->msg;
        $bairro = $request->bairro;
        $cidade = $request->cidade;
         $iduser = $request->iduser;
       $mysqli = new mysqli("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
            if ($mysqli->connect_errno) {
                echo "Sorry, this website is experiencing problems.";


                echo "Error: Failed to make a MySQL connection, here is why: \n";
                echo "Errno: " . $mysqli->connect_errno . "\n";
                echo "Error: " . $mysqli->connect_error . "\n";

                // You might want to show them something nice, but we will simply exit
                exit;
            }
           

         
            
            
        mysqli_set_charset($mysqli, 'utf8');  

        
        // $sql3="SELECT * FROM diwoDB.userbairro WHERE bairro = '$bairro' AND cidade = '$cidade' and contaaprovada = 'confirmado' and iduserbairro!='$iduser'";
        // $result3 = mysqli_query($mysqli,$sql3);
        // $data3 = array();
        // if(mysqli_num_rows($result3) >= 1){
        //     while($row3 = mysqli_fetch_assoc($result3)){
        //         $data3[] = $row3;
        //         $json_str3 = array($row3['devicetoken']);
        //         $fields = array (
        //             'to' => $row3['devicetoken'],
        //             'notification' => array (
        //                     "body" => $msg,
        //                     "title" => $titulo,
        //             )
        //         );
        //         $fields = json_encode ( $fields );
        //         $url = 'https://fcm.googleapis.com/fcm/send';
            
        //         $headers = array (
        //                 'Authorization: key=AAAAIRiNN6Q:APA91bH3fqe2Ju9lxNK0SJVh22YKS3Hiu5rwL878eJtebXKfXKRYdawz3E4UWTDw1dalYthkI4NyuwLAaJNLQvVfDgo-vKcP2MvGyUGeBA7XORyARdEKlUaq3GRRKX87vFX5JFco5j5j' ,//This is Server Key, you can get it from Firebase console ->  App Setting ->  Cloud Messaging Tab - Legacy server key
        //                 'Content-Type: application/json'
        //         );

        //         $ch = curl_init ();
        //         curl_setopt ( $ch, CURLOPT_URL, $url );
        //         curl_setopt ( $ch, CURLOPT_POST, true );
        //         curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        //         curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        //         curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        //         $result = curl_exec ( $ch );
        //         curl_close ( $ch );
        //         // echo  "$row3['devicetoken']";
        //     }   
        //     // $data = array("success"=>true, "msg"=>$msg, "token"=>$json_str3 );
        //     //     $json_str = json_encode($data);
        //     //     echo  "$json_str";
               
        // }

        $msg = array
            (
                "body" => $msg,
                "title" => $titulo,
                
            );

        $sql3="SELECT * FROM diwoDB.userbairro WHERE bairro = '$bairro' AND cidade = '$cidade' and contaaprovada = 'confirmado' and iduserbairro!='$iduser'";
        $result3 = mysqli_query($mysqli,$sql3);
        $data3 = array();
        if(mysqli_num_rows($result3) >= 1){
            while($row3 = mysqli_fetch_assoc($result3)){
                $data3[] = $row3;
                $json_str3 = array($row3['devicetoken']);
                $fields3 = array
                (
                    'registration_ids'  => $json_str3,
                    'to'  => $json_str3,
                    'data'          => $msg,
                    'notification'          => $msg
                );
                $headers = array (
                        'Authorization: key=AAAAIRiNN6Q:APA91bH3fqe2Ju9lxNK0SJVh22YKS3Hiu5rwL878eJtebXKfXKRYdawz3E4UWTDw1dalYthkI4NyuwLAaJNLQvVfDgo-vKcP2MvGyUGeBA7XORyARdEKlUaq3GRRKX87vFX5JFco5j5j' ,//This is Server Key, you can get it from Firebase console ->  App Setting ->  Cloud Messaging Tab - Legacy server key
                        'Content-Type: application/json'
                );
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields3 ) );
                $result = curl_exec($ch );
                curl_close( $ch );

            }  
              $data = array("success"=>true, "msg"=>$msg, "token"=>$json_str3 );
                $json_str = json_encode($data);
                echo  "$json_str";   
        }
       
        
	}

$mysqli->close();
?>
