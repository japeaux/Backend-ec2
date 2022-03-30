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
                    "descricao"     => $aux->{"descricao"}, 
                    "nomeproduto"    => $aux->{"nomeproduto"},
                    "categoria"    => $aux->{"categoria"},
                    "regras"    => $aux->{"regras"},
                    "valor"    => $aux->{"valor"},
                    "valoraux"    => $aux->{"valoraux"},
                    "valorpor"    => $aux->{"valorpor"},
                    "bairro"    => $aux->{"bairro"},
                    "cidade"    => $aux->{"cidade"},
                    "estado"    => $aux->{"estado"},
                    "itensnum"    => $aux->{"itensnum"},
                    "idnegocio"    => $aux->{"idnegocio"},
                    "nomenegocio"    => $aux->{"nomenegocio"},
                    "app"    => $aux->{"app"},
                    "profilepic"    => $aux->{"profilepic"}
                );
            }
            if (!empty($items)) {
                $values = array();
                foreach($items as $item){
                    $values[] = "('{$item['descricao']}', '{$item['nomeproduto']}', '{$item['categoria']}','{$item['regras']}', '{$item['valor']}','{$item['valoraux']}', '{$item['valorpor']}', '{$item['bairro']}', '{$item['cidade']}', '{$item['estado']}', '{$item['itensnum']}',  '{$item['idnegocio']}', '{$item['nomenegocio']}', '{$item['app']}', '{$item['profilepic']}')";
                }

                $values = implode(", ", $values);

                $sql = "INSERT INTO  diwoDB.produto (descricao, nomeproduto,categoria, regras,valor, valoraux ,valorpor,bairro, cidade, estado, itensnum, idnegocio, nomenegocio, app, profilepic) VALUES  {$values}    ;
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
