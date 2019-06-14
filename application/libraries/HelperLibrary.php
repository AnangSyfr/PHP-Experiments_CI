<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HelperLibrary {
	protected $CI;

	public function __construct(){
		$this->CI =& get_instance();
	}

	function extract($array){
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	function encrypt($plaintext){
		$string = $this->CI->encryption->encrypt($plaintext);
		$hasil = strtr($string,array('+' => '.', '=' => '-', '/' => '~'));
		return $hasil;
	}
 
	function decrypt($chipertext){
		$hash = strtr($chipertext,array('.' => '+', '-' => '=', '~' => '/'));
		$hasil = $this->CI->encryption->decrypt($hash);
		return $hasil;
	}

}
