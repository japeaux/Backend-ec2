<?php

  $postdata = file_get_contents("php://input");
  if (isset($postdata)) {
    $request = json_decode($postdata);
    $test = $request->test;
    echo  "$test"; 
  }else {
    echo "Not called properly with username parameter!";
  }
?>
