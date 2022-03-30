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

        $data =$request->data;
        


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

        if(is_array($data)){
            $max = sizeof($data);
            for ($i = 0; $i < $max; $i++) {
                $aux  = $data[$i];
                $items[] = array(
                    "idproduto"     => $aux->{"idproduto"}, 
                    "nomeproduto"    => $aux->{"nomeproduto"},
                    "categoria"    => $aux->{"categoria"},
                    "valor"    => $aux->{"valor"},
                    "valorpor"    => $aux->{"valorpor"},
                    "quantidade"    => $aux->{"quantidade"},
                    "idpedido"    => $aux->{"idpedido"},
                    "statuspedido"    => $aux->{"statuspedido"},
                    "iduser"    => $aux->{"iduser"},
                    "nomeuser"    => $aux->{"nomeuser"},
                    "idnegocio"    => $aux->{"idnegocio"},
                    "nomenegocio"    => $aux->{"nomenegocio"},
                    "app"    => $aux->{"app"},
                    "profilepic"    => $aux->{"profilepic"},
                    "devicetoken" => $aux->{"devicetoken"},
                    "contato" => $aux->{"contato"}
                );
            }
            if (!empty($items)) {
                $values = array();
                foreach($items as $item){
                    $values[] = "('{$item['idproduto']}', '{$item['nomeproduto']}', '{$item['categoria']}', '{$item['valor']}', '{$item['valorpor']}', '{$item['quantidade']}', '{$item['idpedido']}', '{$item['statuspedido']}', '{$item['iduser']}', '{$item['nomeuser']}', '{$item['idnegocio']}', '{$item['nomenegocio']}', '{$item['app']}', '{$item['profilepic']}', '{$item['devicetoken']}', '{$item['contato']}')";
                }

                $values = implode(", ", $values);

                $sql = "INSERT INTO  diwoDB.pedidoproduto (idproduto, nomeproduto,categoria,valor,valorpor,quantidade, idpedido, statuspedido, iduser, nomeuser, idnegocio, nomenegocio, app, profilepic, devicetoken, contato) VALUES  {$values}    ;
                " ;
                if ($mysqli->query($sql) === TRUE) {
                    echo  "OK";
                }else{  
                    echo "Error";  
                }       
            }
        }
    }else {
        echo "Not called properly with username parameter!";
    }
$mysqli->close();
?>
