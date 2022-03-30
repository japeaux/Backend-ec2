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
	//                $sql2 = "SELECT * FROM diwoDB.chat INNER JOIN diwoDB.pessoaevento WHERE diwoDB.pessoaevento.iduser = '$iduser' AND diwoDB.pessoaevento.idevento = diwoDB.chat.idevento and diwoDB.pessoaevento.estado != '4'  group by diwoDB.chat.idevento ORDER BY diwoDB.chat.datadecriacao DESC";
	$sql2 = "SELECT *, MAX(c.datadecriacao) as date_time FROM diwoDB.chat c JOIN diwoDB.pessoaevento t ON t.idevento = c.idevento and t.iduser = '$iduser' and t.estado!='4'  GROUP BY t.nomeevento desc ORDER BY  date_time DESC";

        // $sql2="SELECT * FROM EVENTO WHERE idevento= '$idevento' ";
        $result = mysqli_query($mysqli,$sql2);
        $data = array();
        if(mysqli_num_rows($result) >= 1){
            while($row = mysqli_fetch_assoc($result)){
                $data[] = $row; 
            }
            $json_str = json_encode($data);
			echo  "$json_str"; 
		}else{
			echo  "error"; 
		}
	}
	else {
        $data = array("success"=>false, "msg"=>'Not called properly with username parameter!');
            $json_str = json_encode($data);
			echo  "$json_str"; 
	}
$mysqli->close();
?>