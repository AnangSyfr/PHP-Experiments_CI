<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudGeneratorModel extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	function createTable($table_name,$column_name,$type,$length){
		$data = [];
		foreach($column_name as $c){
			array_push($data,$c);
		}
		foreach($type as $t){
			array_push($data,$t);
		}
		foreach($length as $l){
			array_push($data,$l);
		}
		$total_column = count($column_name);
		$query = [];
		for ($i=0; $i < $total_column; $i++) { 
			array_push($query,$data[$i]." ".$data[$i+$total_column].'('.$data[$i+(2*$total_column)].')');	
		}
		//$this->helperlibrary->extract($query);
		$column = implode(" , ",$query);
		return $this->db->query("create table $table_name($column)");
	}

	function getAllColumn($table){
	 	return $this->db->query("DESCRIBE $table")->result();
	}

	function getAllData($table){
		return $this->db->get($table)->result();
	}
}