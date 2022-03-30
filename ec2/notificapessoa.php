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
        $idevento = $request->idevento;
		$id_user_recebe = $request->id_user_recebe;
        $id_user_envia = $request->id_user_envia;
        $username_envia = $request->username_envia;
        $apelido_envia = $request->apelido_envia;
        $notificacao = $request->notificacao;
        $tipo = $request->tipo;
        $nomeevento = $request->nomeevento;

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

            $sql = "INSERT INTO diwoDB.notificacao (idevento, id_user_recebe, id_user_envia, username_envia, notificacao, tipo, nomeevento, apelido_envia) VALUES ('$idevento', '$id_user_recebe', '$id_user_envia', '$username_envia', '$notificacao', '$tipo', '$nomeevento', '$apelido_envia') ";
            
                if ($mysqli->query($sql) === TRUE) {
                    $data = array("success"=>true, "msg"=>'Aprovaçao aprovada xD');
                    $json_str = json_encode($data);
                    echo  "$json_str"; 
                } else {
                    $data = array("success"=>false, "msg"=>'Ocorreu uma falha ao reservar sua vaga');
                    $json_str = json_encode($data);
                    echo  "$json_str";
                } 
        
        
	}
	else {
		echo "Not called properly with username parameter!";
	}
$mysqli->close();
?>
