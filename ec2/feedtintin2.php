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
        $genero = $request->genero;
        $northlat = $request->northlat;
        $southlat = $request->southlat;
        $eastlng = $request->eastlng;
        $westlng = $request->westlng;
		
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
    if($genero){

   

        


       $sql2 = "SELECT  *, a.idevento FROM diwoDB.evento a LEFT JOIN (SELECT idevento FROM diwoDB.pessoanaoevento WHERE iduser = '$iduser') b ON a.idevento = b.idevento LEFT JOIN (SELECT idevento FROM diwoDB.pessoaevento WHERE iduser = '$iduser'  AND (estado = '1' OR estado = '2')) c ON a.idevento = c.idevento WHERE b.idevento IS NULL AND c.idevento IS NULL AND a.estado ='0' AND a.diainicio > CONVERT_TZ(NOW(), @@session.time_zone, '-3:00') AND a.lng < '$eastlng' and a.lng > '$westlng' AND a.lat < '$northlat' AND a.lat > '$southlat' AND (genero = '$genero' or genero = 'todos') AND a.adm != '$iduser' AND (a.privado IS NULL OR a.privado != 'privado')  ORDER BY RAND()  ";
    
    }else{
            $sql2 = "SELECT  *, a.idevento FROM diwoDB.evento a LEFT JOIN (SELECT idevento FROM diwoDB.pessoanaoevento WHERE iduser = '$iduser') b ON a.idevento = b.idevento LEFT JOIN (SELECT idevento FROM diwoDB.pessoaevento WHERE iduser = '$iduser'  AND (estado = '1' OR estado = '2')) c ON a.idevento = c.idevento WHERE b.idevento IS NULL AND c.idevento IS NULL AND a.estado ='0' AND a.diainicio > CONVERT_TZ(NOW(), @@session.time_zone, '-3:00') AND a.lng < '$eastlng' and a.lng > '$westlng' AND a.lat < '$northlat' AND a.lat > '$southlat' AND a.adm != '$iduser' AND (a.privado IS NULL OR a.privado != 'privado') ORDER BY RAND() ";
    }







        
                                       ///// COLOCAR NO FEED    AND a.diainicio > NOW() 
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


