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
            $nomenegocio = $request->nomenegocio;
            $password = $request->password;
            $contato = $request->contato;
            $tipo = $request->tipo;
            $categoria = $request->categoria;
            $qmsomos = $request->qmsomos;
            $oqtem = $request->oqtem;
            $lat = $request->lat;
            $lng = $request->lng;
            $cidade = $request->cidade;
            $bairro = $request->bairro;
            $profilepic = $request->profilepic;
            $metodopagamento = $request->metodopagamento;
            $tipoentrega = $request->tipoentrega;
            $ratioentrega = $request->ratioentrega;
            $seg = $request->seg;
            $ter = $request->ter;
            $qua = $request->qua;
            $qui = $request->qui;
            $sex = $request->sex;
            $sab = $request->sab;
            $dom = $request->dom;
            $estado = $request->estado;
            $devicetokennegocio = $request->devicetokennegocio;


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
                $qmsomos = $mysqli->real_escape_string($qmsomos);
           
                $sql = "INSERT INTO diwoDB.negocio (nomenegocio, contato, password, tipo, categoria, qmsomos, oqtem, lat, lng, cidade, bairro, profilepic, metodopagamento, tipoentrega, ratioentrega, seg, ter, qua, qui, sex, sab, dom, estado, devicetokennegocio) VALUES ('$nomenegocio', '$contato', '$password', '$tipo' , '$categoria', '$qmsomos', '$oqtem', '$lat', '$lng', '$cidade', '$bairro', '$profilepic', '$metodopagamento', '$tipoentrega', '$ratioentrega', '$seg', '$ter', '$qua', '$qui', '$sex', '$sab', '$dom', '$estado', '$devicetokennegocio')";
                if ($mysqli->query($sql) === TRUE) {
                    $data = array("success"=>true, "msg"=>"Conta criada com sucesso", "last"=>$last);
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
