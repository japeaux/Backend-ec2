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
            $nomeuser = $request->nomeuser;
            $email =$request->email;
            $password = $request->password; 
	    $telefone = $request->telefone;
        	$codigodevalidacaodebairro = $request->codigodevalidacaodebairro;    
	    $cidade = $request->cidade;
            $UF = $request->UF;
	            $cep = $request->cep;
            $bairro = $request->bairro;

            $endereco = $request->endereco;
            $numeroendereco = $request->numeroendereco;
            $complemento = $request->complemento;
            $profilepic = $request->profilepic;
           // $devicetoken = $request->devicetoken;
	$idade =  $request->idade;                        



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
           
                $sql = "INSERT INTO diwoDB.userbairro (email, password, nomeuser, cidade, UF, cep, endereco, numeroendereco, complemento, profilepic, bairro, telefone, codigodevalidacaodebairro,idade) VALUES ('$email', '$password', '$nomeuser', '$cidade', '$UF', '$cep','$endereco', '$numeroendereco', '$complemento', '$profilepic',  '$bairro','$telefone', '$codigodevalidacaodebairro','$idade')";
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


