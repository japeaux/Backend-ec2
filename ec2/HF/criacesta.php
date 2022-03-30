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

            $nomeoferta =$request->nomeoferta;
            $descricao = $request->descricao;
            $regras = $request->regras;   
            $chamada = $request->chamada;
            $valoroferta = $request->valoroferta;
            $valorinicial = $request->valorinicial;
            $tipoentrega = $request->tipoentrega;
            $ratioentrega = $request->ratioentrega;

            $idnegocio =$request->idnegocio;
            $nomenegocio = $request->nomenegocio;
    
            $cidade = $request->cidade;
            $bairro = $request->bairro;
            $contato = $request->contato;
            $profilepic = $request->profilepic;
            $datadevalidade = $request->datadevalidade;

            $devicetokennegocio = $request->devicetokennegocio;
            $itensnum = $request->itensnum;
            $tipoespec = $request->tipoespec;
            $app = $request->app;

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
                $nomeoferta = $mysqli->real_escape_string($nomeoferta);
                $descricao = $mysqli->real_escape_string($descricao);
                $regras = $mysqli->real_escape_string($regras);
                $chamada = $mysqli->real_escape_string($chamada);
                $sql = "INSERT INTO diwoDB.ofertas (nomeoferta, descricao, regras, chamada, valoroferta, valorinicial, tipoentrega, ratioentrega, idnegocio, nomenegocio, cidade, bairro, contato, profilepic, datadevalidade, devicetokennegocio, itensnum, tipoespec, app) VALUES ('$nomeoferta', '$descricao', '$regras', '$chamada', '$valoroferta', '$valorinicial', '$tipoentrega', '$ratioentrega', '$idnegocio', '$nomenegocio', '$cidade', '$bairro', '$contato', '$profilepic', '$datadevalidade', '$devicetokennegocio', '$itensnum', '$tipoespec', '$app')";
               if ($mysqli->query($sql) === TRUE) {
                    $last_id = $mysqli->insert_id;
                    $data = array("success"=>true, "msg"=>"Conta criada com sucesso", "last"=>$last_id);
                                        $json_str = json_encode($data);
                    echo  "$json_str"; 
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }   
            
    }
    else {
            echo "Not called properly with username parameter!";
        }
$mysqli->close();
?>
