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
        $iduser = $request->iduser;
        $cidade = $request->cidade;
        $UF = $request->UF;
        $bairro = $request->bairro;
                
        $mysqli = new mysqli("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
            if ($mysqli->connect_errno) {
                echo "Sorry, this website is experiencing problems.";


                echo "Error: Failed to make a MySQL connection, here is why: \n";
                echo "Errno: " . $mysqli->connect_errno . "\n";
                echo "Error: " . $mysqli->connect_error . "\n";

                exit;
            }
        mysqli_set_charset($mysqli, 'utf8');
        
        $sql2 = "SELECT  * FROM diwoDB.posts a LEFT JOIN (SELECT  iduserrelacao FROM diwoDB.postsrelacoes WHERE iduser = '$iduser') b ON a.iduser = b.iduserrelacao WHERE b.iduserrelacao IS NULL AND a.bairro = '$bairro' and a.cidade = '$cidade' AND  a.UF = '$UF'  and a.postEstado = '0' ORDER BY a.datadeacao desc";

        

        $dados = array();
        $result = mysqli_query($mysqli,$sql2); 
         if(mysqli_num_rows($result) >= 1){
            while($row = mysqli_fetch_assoc($result)){
                $dados[] = $row; 
            }
            $json_str = json_encode(array($dados));
            echo  "$json_str";
         }
    else{
            echo  "Error";
        }


    }
    else {
                        echo  "Error, favor relogue"; 
        }
$mysqli->close();
?>


