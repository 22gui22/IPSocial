<?php
	require ("mysqli_connect.php");
	session_start();
	$username = '_' . $_SESSION['firstname'] . '_' . $_SESSION['lastname'] . '_';
	$target_dir = "images\usersubmited\ProfilePhoto\\";
	$target_file = $target_dir . date('mdYhis', time()) . rand(0,100000000000) . basename($_FILES["uploaded_file"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["uploaded_file"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	if ($_FILES["uploaded_file"]["size"] > 8000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["uploaded_file"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
			$uploadOk == 1;
		}
	}
	$userid = $_SESSION['id'];
	mysqli_set_charset($conn, 'utf8');	
	if($stmt = mysqli_prepare($conn, "UPDATE users SET Users_Photo = ? WHERE Users_Id = $userid")){
		echo 'oi';
		mysqli_stmt_bind_param($stmt, "s", $target_file);							
		mysqli_stmt_execute($stmt);								
		mysqli_stmt_close($stmt);
		header('Location: editprofile.php');
	}
	mysqli_close($conn);
?>