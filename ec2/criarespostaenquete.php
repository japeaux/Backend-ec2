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

            $idpost =$request->idpost;
            $postTitulo = $request->postTitulo;
            $postTexto = $request->postTexto;   
            $respopcao = $request->respopcao;
            $iduser = $request->iduser;
            $nomeuser = $request->nomeuser;
            $responderam = $request->responderam;


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
                

                $sql2 = "UPDATE diwoDB.posts SET responderam='$responderam' WHERE idpost='$idpost'";
                
                $result = mysqli_query($mysqli,$sql2);



                $sql = "INSERT INTO diwoDB.respostasenquete (idpost, postTitulo, postTexto, respopcao, iduser, nomeuser) VALUES ('$idpost', '$postTitulo', '$postTexto', '$respopcao', '$iduser', '$nomeuser')";
               if ($mysqli->query($sql) === TRUE) {
                   
                    $data = array("success"=>true, "msg"=>"Resposta criada com sucesso");
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
