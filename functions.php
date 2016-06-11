<?php
	@session_start();
	require_once('dbcon.php');
	
	if(!isset($_SESSION['msg']['error']) && !isset($_SESSION['msg']['success'])){
		$_SESSION['msg']['error'] = array();
		$_SESSION['msg']['success'] = array();
	}
	
	function add_error_msg($msg = null){
		if(!empty($msg)){
			$_SESSION['msg']['error'][] = $msg;
		}
	}
	
	function add_success_msg($msg = null){
		if(!empty($msg)){
			$_SESSION['msg']['success'][] = $msg;
		}
	}
	function read_msg(){
			$msg = "<div class='msg'>";
				$errors = $_SESSION['msg']['error'];
				if(!empty($errors)){
					foreach($errors as $error){
						$msg .= "<p class = 'error'>{$error}</p>";
					}
				}
				$_SESSION['msg']['error'] = array();
				
				$success = $_SESSION['msg']['success'];
				if(!empty($success)){	
					foreach($success as $s){
						$msg .= "<p class = 'success'>{$s}</p>";
					}
				}
				$_SESSION['msg']['success'] = array();
				
				$msg .= "</div>";
				return $msg;
		}
		
	function is_empty($data, $fill_with = ' --- '){
		return empty($data)? $fill_with : $data;
	}
	
	function check_login(){
		if(!isset($_SESSION['login'])){
			lets_go('login.php');
		}
	}
	
	function is_post($url = 'logout.php'){
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			lets_go($url);
		}
	}
	
	function is_superadmin(){
		return isset($_SESSION['role']) && $_SESSION['role'] == 'superadmin';
	}
	
	function is_admin(){
		return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
	}
	
	function lets_go($url='logout.php'){
		if(!empty($url)){
		Header("Location: $url");
		exit();
		}
	}
	
	function save_me($data){
		global $db;
		return trim(mysqli_real_escape_string($db,trim($data)));
	}
	
	function is_duplicate($table,$field,$value){
		global $db;
		$sql = "SELECT * FROM $table WHERE $field = '$value'";
		$qr = mysqli_query($db,$sql);
		return mysqli_num_rows($qr)>0;
	}
	
	function get_single_data($table,$field,$condition,$value){
		global $db;
		$sql = "SELECT $field FROM $table WHERE $condition = '$value'";
		$qr = mysqli_query($db,$sql);
		$data = mysqli_fetch_assoc($qr); 
		return $data[$field];
	}
	
	function upload_me($field,$accepted_size,$accepted_ext,$dir = 'upload'){
		
		$upload_errors = array(
		
			UPLOAD_ERR_OK 			=> "No errors.",
			UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
			UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
			UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
			UPLOAD_ERR_NO_FILE 		=> "No file.",
			UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
			UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
			UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
		);
	
			$name 	= $field['name'];
			$type 	= $field['type'];
			$tmp  	= $field['tmp_name'];
			$error 	= $field['error'];
			$size 	= $field['size'];
		
		@mkdir($dir,0777);
		$ext = pathinfo(strtolower($name),PATHINFO_EXTENSION);
		$filename = uniqid().'.'.$ext;
		$fullpath = $dir.'/'.$filename;
		$accepted_size = $accepted_size*1024;
		$problems = array();
		
		if($error == 4){
			$problems[] = $upload_errors[$error];
		}else{
			if($error != 0){
				$problems[] = $upload_errors[$error];
			}
			if(!in_array($ext,$accepted_ext)){
				$problems[] = implode(', ',$accepted_ext)." support only";
			}
			if($size > $accepted_size){
				$problems[] = "File should be in ".($accepted_size/1024)."K";
			}
		}
		if(empty($problems)){
			if(move_uploaded_file($tmp,$fullpath)){
				return $fullpath;
			}
		}else{
			$errors = implode('<br/>',$problems);
			add_error_msg($errors);
		}
		return false;
	}
	
?>