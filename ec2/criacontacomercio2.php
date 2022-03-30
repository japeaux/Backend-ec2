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


        
        $iduser = $request->iduser;
        $apelido = $request->apelido;
        $profilepic = $request->profilepic;
        $devicetoken = $request->devicetoken;
        $infocomercio = $request->infocomercio;
        $duracao = $request->duracao;
        $horariodeabertura = $request->horariodeabertura;
        $horariodefechamento = $request->horariodefechamento;
        $pmin = $request->pmin;
        $pmax = $request->pmax;
        $pmedio = $request->pmedio;
        $preco = $request->preco;
        $precopor = $request->precopor;
        $lat = $request->lat;
        $lng = $request->lng;
        $endereco = $request->endereco;
        $telefone = $request->telefone;
        $horariofuncionamento = $request->horariofuncionamento;
        $semanafuncionamento = $request->semanafuncionamento;
        
		
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
        
        $sql = "INSERT INTO diwoDB.comercio (iduser, nomecomercio,fotocomercio, comerciotoken, infocomercio, duracao, horariodeabertura, horariodefechamento, pmin, pmax, pmedio, preco, precopor,  lat,  lng,  endereco,  telefone,horariofuncionamento,  telefone, ) VALUES ('$iduser','$apelido','$profilepic','$devicetoken','$infocomercio','$duracao','$semanafuncionamento','$horariodefechamento','$pmax','$pmin','$iduser','$pmedio', '$preco', '$precopor', '$lat', '$lng', '$endereco', '$telefone', '$horariofuncionamento', '$semanafuncionamento')";

                if ($mysqli->query($sql) === TRUE) {
                    $last = mysqli_insert_id($mysqli);
                    $data = array("success"=>true, "msg"=>'Evento criado com sucesso', "last"=>$last);
                    $json_str = json_encode($data);
                    echo  "$json_str"; 
                } else {
                    $data = array("success"=>false, "last" =>$last,"msg"=>'Evento não pode ser criado, por favor tente novamente');
                    $json_str = json_encode($data);
                    echo  "$json_str";
                }   

	}
	else {
			echo  "Error, favor relogue"; 
	}
$mysqli->close();
?>
