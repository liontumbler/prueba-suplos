<?php

include('Bienes.php');

$action = (isset($_POST['action'])) ? $_POST['action'] : false;
$id     = (isset($_POST['id'])) ? $_POST['id'] : false;

$Bienes = new Bienes;

switch ($action) {
	case 'add':
		$result = $Bienes->add($id);
		if(is_null($result))
			echo json_encode(array("code"=>"success", "message" => "Guardado con exito"));
		break;
	case 'read':
		echo json_encode($Bienes->read());
		break;
	default:
		echo json_encode(array("code"=>"error", "message" => "Error Parameter"));
		break;
}

?>