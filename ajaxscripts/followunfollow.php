<?php
	session_start();
    require ("../mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
    $userid = $_POST['id'];
	$profilenumber = $_POST['number'];
	
	if($stmt = mysqli_prepare($conn, "SELECT Users_Id FROM users WHERE Users_Number = ?")){
		mysqli_stmt_bind_param($stmt, "i", $profilenumber);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $profileid);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	if($profileid == $userid){
		$owner = 1;
	}
	
	if(isset($_POST['follow'])){
		if($stmt = mysqli_prepare($conn, "INSERT INTO follows (Follower_Id, Following_Id) VALUES(?,?)")){
			mysqli_stmt_bind_param($stmt,"ii", $userid, $profileid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);			
		}
		
		
		if($profileid != $userid){
			$str = " começou a seguir-te. ";
			if($stmt = mysqli_prepare($conn, "INSERT INTO notifications (Notifications_Content, Notifications_date, Notifications_Sender_Id, Notifications_Receiver_Id) VALUES(?,NOW(),?,?)")){
			mysqli_stmt_bind_param($stmt,"sii", $str, $userid, $profileid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);			
			}
		}
		
	}
	
	if(isset($_POST['unfollow'])){
		if($stmt = mysqli_prepare($conn, "DELETE FROM follows WHERE Follower_Id = ? AND Following_Id = ?")){
			mysqli_stmt_bind_param($stmt, "ii", $userid, $profileid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);			
		}
	}
	
	//-------------------------------------------------
        mysqli_set_charset($conn, 'utf8');
        if($stmt = mysqli_prepare($conn, "SELECT Users_FirstName, Users_LastName, Users_Gender,Users_Year, EXTRACT(YEAR FROM (FROM_DAYS(DATEDIFF(NOW(),Users_BirthDate)))) , Users_Country, Users_District, Users_City, Users_Photo, School_name, Course_Name FROM users, school, course WHERE Users_Number = ? AND Users_Course_Id = Course_Id AND School_Id = Course_School_Id")) {
			mysqli_stmt_bind_param($stmt, "i", $profilenumber);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $name, $lastname, $gender,$courseyear, $age, $country, $district, $city, $photo, $schoolname, $coursename);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }
    
				mysqli_set_charset($conn, 'utf8');
				if($stmt = mysqli_prepare($conn, "SELECT(SELECT COUNT(Following_Id) FROM users, follows WHERE Users_Id = Following_Id AND Users_Number = ?), (SELECT COUNT(Follower_Id) FROM users, follows WHERE Users_Id = Follower_Id AND Users_Number = ?)From users, follows;")){
					mysqli_stmt_bind_param($stmt, "ii", $profilenumber, $profilenumber);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $followers, $following);
					mysqli_stmt_fetch($stmt);
					mysqli_stmt_close($stmt);
				}
		
		if(isset($_SESSION['id'])){
				mysqli_set_charset($conn, 'utf8');
				if($stmt = mysqli_prepare($conn, "SELECT count(Following_Id) FROM users,follows WHERE Follower_Id = ? AND Following_Id = Users_Id AND Users_Number = ?")){
					mysqli_stmt_bind_param($stmt, "ii", $userid, $profilenumber);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $isfollowing);
					mysqli_stmt_fetch($stmt);
					mysqli_stmt_close($stmt);
				}
		}
		
		if($stmt = mysqli_prepare($conn, "SELECT Privacy_Gender, Privacy_BirthDate, Privacy_Post, Privacy_Location FROM privacy, users WHERE Users_Number = ? AND Privacy_Users_Id = Users_Id")) {
				mysqli_stmt_bind_param($stmt, "i", $profilenumber);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $privacygender, $privacybirthdate, $privacypost, $privacylocation);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
			}
		$owner = 0;
	if(isset($_SESSION['id'])){
		if($profilenumber == $_SESSION['number']){
			$owner = 1;
			echo "<a href='editprofile.php' class='btn btn-info float-right' role='button'><i class='fa fa-edit'></i> Editar</a>"; 
		}
	}
	
	echo"
<br>
<br>
<div class='text-center'>
   <img src='$photo' class='rounded-circle img-responsive' width='150' height='150'>
</div>
<center><h3><b>$name $lastname</b></h3></center>
<div class='container' style='width:80%'>
	<div class='d-flex flex-row justify-content-center'>
  <div class='p-4'>
	<tr>
		<tr>
		<td><b>Segue:</b></td>
		<td>$following</td>
		</tr>
	</tr>
	</div>
	<div class='p-4'>
	<tr>
		<tr>
		<td><b>Seguidores:</b></td>
		<td>$followers</td>
		</tr>
	</div>
	</div>
</div>
<br>
<div class='container' style='width:80%'>
<div class='row'>";
	if($privacylocation == 1 || ($privacylocation == 2 && $isfollowing > 0) || $owner == 1){
		echo "
		<div class='col-4' align='center'>
			<tr>
			<td><b>Localização:</b></td>
			<td>$country, $district, $city</td>
			</tr>
		</div>
		";
	}
	if($privacygender == 1 || ($privacygender == 2 && $isfollowing > 0) || $owner == 1){
		echo "
		<div class='col-4' align='center'>
			<tr>
			<td><b>Genero:</b></td>
			<td>$gender</td>
			</tr>
		</div>
		";
	}
	if($privacybirthdate == 1 || ($privacybirthdate == 2 && $isfollowing > 0) || $owner == 1){
		echo "
		<div class='col-4' align='center'>
			<tr>
			<td><b>Idade:</b></td>
			<td>$age</td>
			</tr>
		</div>
		";
	}
	echo "
	<div class='col-sm-4' align='center'>
		<tr>
		<td><b>Escola:</b></td>
		<td>$schoolname</td>
		</tr>
	</div>
	";
	echo "
	<div class='col-sm-4' align='center'>
		<tr>
		<td><b>Curso:</b></td>
		<td>$coursename</td>
		</tr>
	</div>
	";
	echo "
	<div class='col-sm-4' align='center'>
		<tr>
		<td><b>Ano:</b></td>
		<td>$courseyear</td>
		</tr>
	</div>
	</div>
	</div>
	";	
	if(isset($_SESSION['active'])){
		if ($isfollowing > 0 && $owner != 1){
			echo "<button type='button' class='btn btn-danger float-right' onClick='unfollow($userid,$profilenumber)'><i class='fa fa-minus'></i> Deixar de Seguir</button><br>";
		}
		if ($isfollowing == 0 && $owner != 1){
			echo "<button type='button' class='btn btn-success float-right' onClick='follow($userid,$profilenumber)'><i class='fa fa-plus'></i> Seguir</button><br>";
		}
	}
	echo"<br>";
	
    mysqli_close($conn);
?>


