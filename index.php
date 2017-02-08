<?php
require 'Driver.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $drv = Driver::getAll();

  if($drv){
    $resp['response'] = 1;
    $resp['drivers'] = $drv;
    print json_encode($resp);
  }
  else {
    print json_encode(array("estado" => 2, "error" => "Error drv"));
  }
}
?>
