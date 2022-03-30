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

        $hash = $request->hash;
        $senderName = $request->senderName;
        $senderAreaCode = $request->senderAreaCode;
        $senderPhone = $request->senderPhone;
        $senderEmail =  $request->senderEmail;
        $senderCPF =  $request->senderCPF;

        $billingAddressStreet =  $request->billingAddressStreet;
        $billingAddressNumber =  $request->billingAddressNumber;
        $billingAddressDistrict =  $request->billingAddressDistrict;
        $billingAddressPostalCode =  $request->billingAddressPostalCode;
        $billingAddressCity =  $request->billingAddressCity;
        $billingAddressState =  $request->billingAddressState;
        $billingAddressComplement =  $request->billingAddressComplement;

        $reference =  $request->reference;
        $itemAmount1 =  $request->itemAmount1;

        $data['token'] ='seu token do pagseguro disponível no login sandbox'; //token sandbox test
		$data["token"]='5A5CCE8C99C84A5BA72450A5D0CDDE92';
		$data["paymentMode"]="default";
		$data["paymentMethod"]="boleto";
		$data["receiverEmail"]='lucascovatti@hotmail.com';
		$data["senderHash"]=$hash;
		$data["senderName"]=$senderName;
		$data["senderCPF"]=$senderCPF;
		$data["senderAreaCode"]=$senderAreaCode;
		$data["senderPhone"]= $senderPhone;
		$data["senderEmail"]=$senderEmail;
		$data['currency'] = 'BRL';
		$data["itemId1"] = '1';
		$data["itemDescription1"] = 'Website';
		$data["itemQuantity1"] = '1';
		$data["reference"]=$reference;
		$data['shippingAddressRequired'] = 'false';
		$data["itemAmount1"] = $itemAmount1;
		//$data["shippingType"]="1";
		$data["shippingCost"]="0.00";
			// $data["email"]='lucascovatti@hotmail.com';
			// $data["token"]='5A5CCE8C99C84A5BA72450A5D0CDDE92';
			// $data["paymentMode"]="default";
			// $data["paymentMethod"]="boleto";
			// $data["receiverEmail"]='lucascovatti@hotmail.com';
			// $data["currency"]="BRL";
			// $data["itemId1"] = '1';
			// $data["itemDescription1"] = 'Website';
			// $data["itemAmount1"] = $itemAmount1;
			// $data["itemQuantity1"] = '1';
			// //$data["notificationURL="]="https://www.meusite.com.br/notificacao.php";
			// $data["reference"]=$reference;
			// $data["senderName"]=$senderName;
			// $data["senderCPF"]=$senderCPF;
			// $data["senderAreaCode"]=$senderAreaCode;
			// $data["senderPhone"]= $senderPhone;
			// $data["senderEmail"]=$senderEmail;
			// $data["senderHash"]=$hash;
			// $data["shippingType"]="1";
			// $data["shippingAddressStreet"]=$billingAddressStreet;
			// $data["shippingAddressNumber"]=$billingAddressNumber;
			// $data["shippingAddressComplement"]=$billingAddressComplement;
			// $data["shippingAddressDistrict"]=$billingAddressDistrict;
			// $data["shippingAddressPostalCode"]=$billingAddressPostalCode;
			// $data["shippingAddressCity"]=$billingAddressCity;
			// $data["shippingAddressState"]=$billingAddressState ;
			// $data["shippingAddressCountry"]="BRA";
			// $data["shippingType"]="1";
			// $data["shippingCost"]="0.00";
		

                        //$_SERVER['REMOTE_ADDR']
        $emailPagseguro = "lucascovatti@hotmail.com";

        $data = http_build_query($data);
        $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions';

        $curl = curl_init();

        $headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
                );

        curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $xml = curl_exec($curl);

        curl_close($curl);

        $xml= simplexml_load_string($xml);
        $code =  $xml -> code;
		$date =  $xml -> date;
		$paymentLink = $xml -> paymentLink;
		
		//aqui eu ja trato o xml e pego o dado que eu quero, vc pode dar um var_dump no $xml e ver qual dado quer

		$retornoCartao = array(
				'code' => $code,
				'date' => $date,
				'paymentLink' => $paymentLink

		);

		$json_str = json_encode($retornoCartao);
		
		echo  "$json_str"; 
                



	}
	else {
			echo  "Error"; 
	}

?>
