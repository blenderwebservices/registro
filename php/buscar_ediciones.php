<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mexico_City');

require_once __DIR__ . '/db_config.php';
$host_name = $db_1_host;
$database = $db_1_name;
$user_name = $db_1_user;
$password = $db_1_pass;

$resultadoarray = array();
$edicion = trim($_GET['edicion1']);
$edicion = "edi".$edicion;

$dbh = mysqli_connect($host_name, $user_name, $password, $database);
mysqli_set_charset($dbh, "utf8mb4"); 

if (mysqli_connect_errno()) {
  die('<p>Error al conectar con servidor MySQL contacte al +52 3321349874 24 hrs. o enviar correo a miguelbermejo@hotmail: '.mysqli_connect_error().'</p>');
}

$result = mysqli_query($dbh,"SELECT * FROM edi21 WHERE numdia=2");
$total = mysqli_num_rows($result);

if (!$result){
  $data = $edicion;
  echo json_encode($data);
} else {
  $result = mysqli_query($dbh,"SELECT * FROM edi21 WHERE numdia=2");
  
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

  
}
?>