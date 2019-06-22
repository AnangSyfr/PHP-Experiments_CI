<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class MahasiswaModel extends CI_Model {

	protected $table = 'mahasiswa';
	public function __construct(){
		parent::__construct();

	}

	function getAllColumn(){
	 	return $this->db->query("DESCRIBE $this->table")->result();
	}

	function getAllData(){
		return $this->db->get($this->table)->result();
	}

	function getTable(){
		$arr = [];
		array_push($arr,$this->db->query("DESCRIBE $this->table")->result());
		array_push($arr,$this->db->get($this->table)->result());
		return $arr;
	}

	function getPrimaryKey(){
		return $this->db->query("show index from $this->table where key_name = 'PRIMARY'")->result();
	}

	function insert($data){
		return $this->db->insert($this->table,$data);
	}

	function update($data,$key,$id){
		$this->db->where($key,$id);
		return $this->db->update($this->table,$data);
	}

	function delete($key,$id){
		return $this->db->delete($this->table,array( $key => $id));
	}
}
		