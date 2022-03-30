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
        $idevento = $request->idevento;
        $nomeevento = $request->nomeevento;
        $duracao = $request->duracao;
        $diainicio = $request->diainicio;
        $semana = $request->semana;
        $dialimiteconfirmacao = $request->dialimiteconfirmacao;
        $diafim = $request->diafim;
        $descricao = $request->descricao;
        $preco = $request->preco;
        $precopor = $request->precopor;    
        $pmin = $request->pmin;
        $pmax = $request->pmax;
        $patual = $request->patual;
        $estado = $request->estado;
        $nomelocal = $request->nomelocal;
        $endereco = $request->endereco;
        $cidade = $request->cidade;
        $lat = $request->lat;
        $lng = $request->lng;
        $dificuldade = $request->dificuldade;
        $genero = $request->genero;
        $notifica = $request->notifica;
        $eventopic = $request->eventopic;
        $datamodificacao = $request->datamodificacao;


	
        $mysqli = new mysqli("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
                if ($mysqli->connect_errno) {
                    echo "Sorry, this website is experiencing problems.";


                    echo "Error: Failed to make a MySQL connection, here is why: \n";
                    echo "Errno: " . $mysqli->connect_errno . "\n";
                    echo "Error: " . $mysqli->connect_error . "\n";

                    exit;
                }
                mysqli_set_charset($mysqli, 'utf8');
            $sql = "UPDATE diwoDB.evento SET nomeevento='$nomeevento', dialimiteconfirmacao='$dialimiteconfirmacao', duracao='$duracao', descricao='$descricao', preco='$preco', precopor='$precopor', estado='$estado', pmin='$pmin', patual='$patual', pmax='$pmax', diainicio='$diainicio', semana='$semana', diafim='$diafim', endereco='$endereco', cidade='$cidade', lat='$lat', lng='$lng', dificuldade='$dificuldade', genero='$genero', notifica='$notifica', eventopic='$eventopic', datamodificacao='$datamodificacao' WHERE idevento='$idevento'";
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
		echo "Not called properly with username parameter!";
	}
$mysqli->close();
?>
