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
        $periodo = $request->periodo;
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
                // $sql2 = " SELECT * FROM diwoDB.evento WHERE '53' = idComercioParceiro AND diainicio BETWEEN '2019-05-03 15:54:00' - INTERVAL 1 DAY AND CURDATE() GROUP BY date(diainicio)";

                    if ($periodo == "Hoje") {
                         $sql2="SELECT * FROM diwoDB.evento WHERE $iduser = idComercioParceiro AND DATE(datadecriacao) = CURDATE() AND MONTH(datadecriacao) = MONTH(CURRENT_DATE()) AND YEAR(datadecriacao) = YEAR(CURRENT_DATE())";
                    }
                    if ($periodo == "Semana") {
                        $sql2="SELECT * FROM diwoDB.evento WHERE $iduser = idComercioParceiro AND YEARWEEK(datadecriacao) = YEARWEEK(CURRENT_DATE())";
                    }
                    if ($periodo == "Mês") {
                       $sql2="SELECT * FROM diwoDB.evento WHERE $iduser = idComercioParceiro AND MONTH(datadecriacao) = MONTH(CURRENT_DATE()) AND YEAR(datadecriacao) = YEAR(CURRENT_DATE())";
                    }
                    if ($periodo == "Total") {
                       $sql2="SELECT * FROM diwoDB.evento WHERE $iduser = idComercioParceiro";
                    }
                
//                 SET @period='1M';

// SELECT CASE WHEN @period='1Y' THEN YEAR(date(diainicio)) 
//             WHEN @period='1M' THEN YEAR(date(diainicio))*100+MONTH(date(diainicio))
//             WHEN @period='2M' THEN FLOOR((YEAR(date(diainicio))*100+MONTH(date(diainicio)))/2)*2
//             WHEN @period='1W' THEN YEARWEEK(date(diainicio))
//             WHEN @period='2W' THEN FLOOR(YEARWEEK(date(diainicio))/2)*2
//        END date(diainicio),
//        SUM(COUNT(genero)) Total
// FROM diwoDB.evento
// GROUP BY date(diainicio)
// ORDER BY date(diainicio) DESC;


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
