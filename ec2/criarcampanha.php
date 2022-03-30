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
        $nomeevento = $request->nomeevento;
        $duracao = $request->duracao;
        $diainicio = $request->diainicio;
        $semana = $request->semana;
        $diafim = $request->diafim;
        $dialimiteconfirmacao = $request->dialimiteconfirmacao;
        $descricao = $request->descricao;
        $preco = $request->preco;
        $precopor = $request->precopor;
        $pmin = $request->pmin;
        $patual = $request->patual;
        $pmax = $request->pmax;
        $adm = $request->adm;
        $estado = $request->estado;
        $admusername = $request->admusername;
        $admapelido = $request->admapelido;
        $nomelocal = $request->nomelocal;
        $endereco = $request->endereco;
        $cidade = $request->cidade;
        $lat = $request->lat;
        $lng = $request->lng;
        $dificuldade = $request->dificuldade;
        $genero = $request->genero;
        $eventopic = $request->eventopic;
        $idComercioParceiro = $request->idComercioParceiro;
        $comerciodevicetoken = $request->comerciodevicetoken;
        $tipodeevento = $request->tipodeevento;
        $descontomin = $request->descontomin;
        $descontomax = $request->descontomax;                                    
        $incluso = $request->incluso;
        $descontopacote = $request->descontopacote;  
	$pushdiainicio = $request->pushdiainicio;
//	$descricao = nl2br(htmlentities($descricao, ENT_QUOTES, 'UTF-8'));
//        $incluso = nl2br(htmlentities($incluso, ENT_QUOTES, 'UTF-8'));
//        $descontopacote = nl2br(htmlentities($descontopacote, ENT_QUOTES, 'UTF-8'));        
		
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
        
        $sql = "INSERT INTO diwoDB.evento (nomeevento, duracao, diainicio, semana, diafim, dialimiteconfirmacao, descricao, pmin, patual, pmax, preco, precopor, adm, estado, admusername, nomelocal, endereco, cidade, lat, lng, dificuldade, genero, admapelido, eventopic, idComercioParceiro, comerciodevicetoken, tipodeevento, descontomin, descontomax, incluso, descontopacote, pushdiainicio) VALUES ('$nomeevento', '$duracao', '$diainicio', '$semana', '$diafim', '$dialimiteconfirmacao', '$descricao', '$pmin', '$patual', '$pmax', '$preco', '$precopor', '$adm', '$estado', '$admusername', '$nomelocal', '$endereco', '$cidade', '$lat', '$lng', '$dificuldade', '$genero','$admapelido','$eventopic', '$idComercioParceiro','$comerciodevicetoken','$tipodeevento', '$descontomin', '$descontomax','$incluso', '$descontopacote', '$pushdiainicio')";

                if ($mysqli->query($sql) === TRUE) {
                    $last = mysqli_insert_id($mysqli);
                    $data = array("success"=>true, "msg"=>'Campanha criada com sucesso', "last"=>$last);
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
