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
        
        $idnegocio = $request->idnegocio;

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
           

           // $sql = "SELECT SUM(quantidade) as n, nomeproduto, idproduto, valorpor FROM diwoDB.pedidoproduto where idnegocio = '$idnegocio'  and MONTH(datadecriacao) = MONTH(CONVERT_TZ(NOW(), @@session.time_zone, '-3:00')) group by idproduto order by n desc";

            $sql = "SELECT SUM(quantidade) as n, nomeproduto, idproduto, valorpor FROM diwoDB.pedidoproduto where app = '$app'  and YEAR(datadecriacao) = YEAR(CONVERT_TZ(NOW(), @@session.time_zone, '-3:00')) and  MONTH(datadecriacao) = MONTH(CONVERT_TZ(NOW(), @@session.time_zone, '-3:00')) group by idproduto order by n desc";


            $dados = array();
            $result = mysqli_query($mysqli,$sql);
            if(mysqli_num_rows($result) >= 1){
                while($row = mysqli_fetch_assoc($result)){
                    $dados[] = $row; 
                }
                $json_str = json_encode($dados);
                echo  "$json_str";
            }else{  
                    echo "Error";  
            }
        
        
    }
    else {
        echo "Not called properly with username parameter!";
    }
$mysqli->close();
?>
