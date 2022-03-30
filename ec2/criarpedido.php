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

            $idofertas =$request->idofertas;
            $nomeoferta =$request->nomeoferta;
            $valoroferta =$request->valoroferta;
            $metodopagamento =$request->metodopagamento;
            $status =$request->status;
            $datadecriacao =$request->datadecriacao;

            $idnegocio =$request->idnegocio;
            $nomenegocio = $request->nomenegocio;

            $iduser =$request->iduser;
            $nomeuser = $request->nomeuser;
    
            $bairro = $request->bairro;
            $endereco = $request->endereco;
            $numeroendereco = $request->numeroendereco;
            $complemento = $request->complemento;
            $devicetokenuser = $request->devicetokenuser;
            $devicetokennegocio = $request->devicetokennegocio;
                        
	$valortotal = $request->valortotal;
	$valorentrega = $request->valorentrega;
	$troco = $request->troco;
	$observacao = $request->observacao;
            $espec = $request->espec;
		$qntositems = $request->qntositems;
	$contatouser = $request->contatouser;
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
           
                $sql = "INSERT INTO diwoDB.pedido (idofertas, nomeoferta, nomeuser, iduser, valoroferta, metodopagamento, endereco, numeroendereco, complemento,  bairro,  status,  datadecriacao,  devicetokenuser,  devicetokennegocio, idnegocio, nomenegocio, valortotal, valorentrega, troco, observacao, espec, qntositems, contatouser) VALUES ('$idofertas', '$nomeoferta', '$nomeuser', '$iduser', '$valoroferta', '$metodopagamento','$endereco', '$numeroendereco', '$complemento', '$bairro', '$status', '$datadecriacao', '$devicetokenuser', '$devicetokennegocio', '$idnegocio', '$nomenegocio', '$valortotal', '$valorentrega', '$troco', '$observacao', '$espec','$qntositems', '$contatouser')";
                if ($mysqli->query($sql) === TRUE) {
                    $sql2 = "SELECT  * FROM diwoDB.pedido where idpedido = LAST_INSERT_ID() ";
                    $dados = array();
                    $result = mysqli_query($mysqli,$sql2);
                    if(mysqli_num_rows($result) >= 1){
                        while($row = mysqli_fetch_assoc($result)){
                            $dados[] = $row; 
                        }
                        $json_str = json_encode($dados);
                        echo  "$json_str";
                    }else{  
                            echo "Error";  
                    }
                    // $data = array("success"=>true, "msg"=>"Pedido efetuado");
                    // $json_str = json_encode($data);
                    // echo  "$json_str"; 
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }   
            
    }
    else {
            echo "Not called properly with username parameter!";
        }
$mysqli->close();
?>
