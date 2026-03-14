<?php
header('Content-Type: text/html; charset=utf-8');

function conexion(){
//conexion para servidor
$dbh = mysql_connect("db630619280.db.1and1.com","dbo630619280","Outlet876..");

 if (!$dbh){

  die('No se pudo conectar al servidor llame a los Tel. 33 21349874 24 hrs: ' . mysql_error());
 }
  mysql_select_db("db630619280",$dbh);

return($dbh);
}
?>
