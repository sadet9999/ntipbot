<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getConnected(){
// local
//$mysqli = new mysqli("localhost","root","","flu_vacc"); //Connect DB
// www
$mysqli = new mysqli("103.40.148.139","guest","1234","itworks"); //Connect DB

if($mysqli->connect_error)
{
  printf("Connect fail: %s\n",mysqli_connect_error());
  exit();
}
$mysqli->set_charset("utf8");
  return $mysqli;
}

$mysqli = getConnected();
$sql = "select * from tbl_works limit 0,5";
$result = $mysqli->query($sql);

if($result->num_rows>0){
  while ($row = $result->fetch_assoc()) {
    $arr[] = $row;
  }
}
foreach($arr as $val){
  $valtojson[] = array('id' => $val['id'],'fixdetail' => $val['fixdetail']);
}
echo json_encode($valtojson);
?>
