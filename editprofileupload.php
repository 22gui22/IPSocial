<?php
 session_start();
 if(!isset($_SESSION['active'])){
	 header('Location: login.php');
 }
 require ("mysqli_connect.php");
 
 function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
 }
 if(isset($_POST['submit'])){
	$bday = test_input($_POST['bday']);
	$gender = test_input($_POST['gender']);
	$course = test_input($_POST['curso']);
	$year = test_input($_POST['ano']);
	$phone = test_input($_POST['phone']);
	$pcolor = test_input($_POST['pcolor']);
	$pcolor2 = test_input($_POST['pcolor2']);
	$userid = $_SESSION['id'];
	
	if($stmt = mysqli_prepare($conn, "UPDATE users SET Users_BirthDate = ?, Users_Gender = ?, Users_Course_Id = ?, Users_Year = ?, Users_Phone = ?, Users_ProfileColor = ?, Users_ProfileColor2 = ? WHERE Users_Id = ?")){
		mysqli_stmt_bind_param($stmt, "ssiiissi", $bday, $gender, $course, $year, $phone, $pcolor, $pcolor2, $userid);							
		mysqli_stmt_execute($stmt);								
		mysqli_stmt_close($stmt);
		header('Location: profile.php');
	}
 }
?>