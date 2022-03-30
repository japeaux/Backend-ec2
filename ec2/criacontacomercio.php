<?php
     	if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
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
        $apelido = $request->apelido;
        $iduser = $request->iduser;
        $profilepic = $request->profilepic;
        $devicetoken = $request->devicetoken;
        $infocomercio = $request->infocomercio;
        $incluso =  $request->incluso;
        $qmehcomercio =  $request->qmehcomercio;
        $duracao = $request->duracao;
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
        

        
//        $infocomercio = nl2br(htmlentities($infocomercio, ENT_QUOTES, 'UTF-8'));
//        $incluso = nl2br(htmlentities($incluso, ENT_QUOTES, 'UTF-8'));
//        $qmehcomercio = nl2br(htmlentities($qmehcomercio, ENT_QUOTES, 'UTF-8'));
   


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

    
        $sql = "INSERT INTO diwoDB.comercio (iduser, nomecomercio, infocomercio, duracao, fotocomercio, comerciotoken, pmin, pmax, pmedio, preco, precopor, lat, lng, endereco, telefone, horariofuncionamento, semanafuncionamento, qmehcomercio, incluso) VALUES ('$iduser', '$apelido', '$infocomercio', '$duracao', '$profilepic', '$devicetoken', '$pmin', '$pmax', '$pmedio', '$preco', '$precopor', '$lat', '$lng', '$endereco', '$telefone', '$horariofuncionamento', '$semanafuncionamento', '$qmehcomercio','$incluso')";
        if ($mysqli->query($sql) === TRUE) {
            $data = array("success"=>true, "msg"=>"Conta criada com sucesso", "last"=>$last);
                        $json_str = json_encode($data);
            echo  "$json_str"; 
        }else{
            echo "Error" 
        }  
            
    }
    else {
            echo "Not called properly with username parameter!";
        }
$mysqli->close();
?>


