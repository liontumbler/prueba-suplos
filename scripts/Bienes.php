<?php
include('Database.php');
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'Intelcost_bienes');
define('DB_USER', 'edwin1');
define('DB_PASS', '123.abc');

class Bienes {
	public $db;
	public $dataFromJson;
	public $dataToPass;

	public function __construct(){
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	}

    function add($id) {
    	if($this->getJson()){
    		if($this->findId($id)){

    			$ciudad = $this->db->select("SELECT id_ciudad FROM ciudad WHERE nombre = '".$this->dataToPass['Ciudad']."'");
    			$tipo = $this->db->select("SELECT id_tipo FROM tipo WHERE nombre = '".$this->dataToPass['Tipo']."'");

    			$this->dataToPass['Ciudad'] = $ciudad[0]['id_ciudad'];
    			$this->dataToPass['Tipo']   = $tipo[0]['id_tipo'];

    			$result = $this->db->insert('bienes', $this->dataToPass);
				return $result;
				
    		}
    		else
    			echo json_encode(array("code"=>"error", "message" => "Sin Informacion"));
    	}
    	
    }

    function read(){
    	return $this->db->select("SELECT a.id Id, a.direccion Direccion, b.nombre Ciudad, a.telefono Telefono, a.codigo_postal Codigo_Postal, c.nombre Tipo, a.precio Precio FROM bienes a JOIN ciudad b ON a.ciudad = b.id_ciudad JOIN tipo c ON a.tipo = c.id_tipo");
    }

    function getJson(){
    	$string = file_get_contents("../data/data.json");
		if ($string === false) {
		    echo json_encode(array("code"=>"error", "message" => "no se encontro archivo"));
		}

		$this->dataFromJson = json_decode($string, true);
		if ($this->dataFromJson === null) {
		    echo json_encode(array("code"=>"error", "message" => "Error al decodificar"));
		}
		return true;
	}
	
    function findId($id){
    	foreach ($this->dataFromJson as $key => $value) {
    		if($id == $value['Id']){
    			$this->dataToPass = $value;
    			return true;
    		}
    	}
    	return false;
    }
}
?> 