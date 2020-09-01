<?php
	require ("mysqli_connect.php");
	session_start();
	
	$target_dir = "images\usersubmited\GroupProfilePhotos\\";
	$target_file = $target_dir . date('mdYhis', time()) . rand(0,100000000000) . basename($_FILES["uploaded_file"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
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
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["uploaded_file"]["size"] > 8000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["uploaded_file"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	//Registers on DB
	if ($uploadOk == 1) {
		$name = $_POST['groupname'];
		$description = $_POST['description'];
		$id = $_SESSION['id'];
	
		mysqli_set_charset($conn, 'utf8');
		if($stmt = mysqli_prepare($conn, "INSERT INTO groups (Groups_Name, Groups_Photo, Groups_Description, Groups_Users_Id) VALUES(?,?,?,?)")){
			mysqli_stmt_bind_param($stmt, "sssi",$name, $target_file, $description, $id);
			if (mysqli_stmt_execute($stmt)==TRUE){
				$lastid = mysqli_insert_id($conn);
				mysqli_stmt_close($stmt);
				if($stmt = mysqli_prepare($conn, "INSERT INTO groupmembers (GroupMembers_Follower_Id, GroupMembers_Groups_Id) VALUES(?,?)")){
				mysqli_stmt_bind_param($stmt, "ii",$id, $lastid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);	
				$header = 'Location: groupprofile.php?group='.$lastid.'';
				header($header); 
				}			
			}
		mysqli_close($conn);
		}
	
	}
?>