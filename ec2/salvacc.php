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
		$username = $request->username;
        $senderName = $request->senderName;
        $senderAreaCode = $request->senderAreaCode;
        $senderPhone = $request->senderPhone;
        $senderEmail =  $request->senderEmail;
        $senderCPF =  $request->senderCPF;
        $creditCardHolderBirthDate =  $request->creditCardHolderBirthDate;
        $billingAddressStreet =  $request->billingAddressStreet;
        $billingAddressNumber =  $request->billingAddressNumber;
        $billingAddressDistrict =  $request->billingAddressDistrict;
        $billingAddressPostalCode =  $request->billingAddressPostalCode;
        $billingAddressCity =  $request->billingAddressCity;
        $billingAddressState =  $request->billingAddressState;
        $billingAddressComplement =  $request->billingAddressComplement;

        $NumCartao =  $request->NumCartao;
        $bandeiraNome =  $request->bandeiraNome;
        $NumCVV =  $request->NumCVV;
        $expirationMonth =  $request->expirationMonth;
        $expirationYear =  $request->expirationYear;
       
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
   
        $sql = "INSERT INTO diwoDB.usercc (iduser, username, senderName, senderAreaCode, senderPhone, senderEmail, senderCPF, creditCardHolderBirthDate, billingAddressStreet, billingAddressNumber, billingAddressDistrict, billingAddressPostalCode, billingAddressCity, billingAddressState, billingAddressComplement, NumCartao ,bandeiraNome , NumCVV , expirationMonth, expirationYear) VALUES ('$iduser', '$username', '$senderName', '$senderAreaCode', '$senderPhone', '$senderEmail', '$senderCPF', '$creditCardHolderBirthDate', '$billingAddressStreet', '$billingAddressNumber', '$billingAddressDistrict', '$billingAddressPostalCode', '$billingAddressCity', '$billingAddressState', '$billingAddressComplement', '$NumCartao' ,'$bandeiraNome' , '$NumCVV' , '$expirationMonth', '$expirationYear' )";
        if ($mysqli->query($sql) === TRUE) {
            $data = array("success"=>true, "msg"=>"Conta criada com sucesso", "last"=>$last);
                                $json_str = json_encode($data);
            echo  "$json_str"; 
        } else {
            echo "Error";
        }   
            
    }
    else {
            echo "Not called properly with username parameter!";
        }
$mysqli->close();
?>
