<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mexico_City');

$host_name = 'db630619280.db.1and1.com';
$database = 'db630619280';
$user_name = 'dbo630619280';
$password = 'Outlet876..';

$resultadoarray = array();
$email = trim($_GET['email']);

$dbh = mysqli_connect($host_name, $user_name, $password, $database);
mysqli_set_charset($dbh, "utf8mb4"); 

if (mysqli_connect_errno()) {
  die('<p>Error al conectar con servidor MySQL contacte al +52 3321349874 24 hrs. o enviar correo a miguelbermejo@hotmail: '.mysqli_connect_error().'</p>');
}

$result = mysqli_query($dbh,"SELECT * FROM registro26 WHERE email='$email'");
$total = mysqli_num_rows($result);

if ($total>0){
  $data = array('status' => 'registrado', 'msj' => 'Este email ya fue registrado en esta edición, utilice uno diferente');
  echo json_encode($data);
} else {
  $result = mysqli_query($dbh,"SELECT * FROM asistido24 WHERE email='$email'");
  
  if (!$result) {

      $data = array('status' => 'false', 'msj' => 'error');
      echo json_encode($data);
  } else {

    $rows = array();

    while ($row = mysqli_fetch_assoc($result)) {

    $rows["data"][] = $row;

    }
    if(count($rows["data"]) < 1)
    {
        $data = array('status' => 'false', 'msj' => 'no existen coicidencias');
        echo json_encode($data);
    }
    if(count($rows["data"]) > 0)
    {

      $data = array('status' => 'true', 'data' => $rows, 'msj' => 'encontrado');
      echo json_encode($data);
      //echo json_encode(utf8_encode_all($data));

    }
  }
  mysqli_free_result($result);

  mysqli_close($dbh);

  function utf8_encode_all($dat) // -- It returns $dat encoded to UTF8
  {
    if (is_string($dat)) return utf8_encode($dat);
    if (!is_array($dat)) return $dat;
    $ret = array();
    foreach($dat as $i=>$d) $ret[$i] = utf8_encode_all($d);
    return $ret;
  }
}
?>