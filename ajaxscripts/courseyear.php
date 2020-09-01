<?php
	session_start();
    require ("../mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
	if(isset($_POST['school'])){
		$schoolid = $_POST['school'];
	}
    if(isset($_POST['course'])){
		$courseid = $_POST['course'];
	}
	
	if(isset($_POST['coursepls'])){
		if($stmt = mysqli_prepare($conn, "SELECT Course_Id, Course_Name FROM course WHERE Course_School_Id = ? ")) {
			mysqli_stmt_bind_param($stmt, "i", $schoolid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $courseid, $coursename);
				while(mysqli_stmt_fetch($stmt)){
					echo "<option value='$courseid'>$coursename</option>";
				}
				mysqli_stmt_close($stmt);
			}
		
	}
	
	if(isset($_POST['yearpls'])){
		if($stmt = mysqli_prepare($conn, "SELECT Course_Year FROM course WHERE Course_Id = $courseid")) {
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $years);
				echo $years;
				mysqli_stmt_fetch($stmt);
				for ($i=1;$i<=$years;$i++){
					echo "<option value='$i'>$i Ano</option>";
				}
				mysqli_stmt_close($stmt);
			}
	}
	
	
    mysqli_close($conn);
?>


