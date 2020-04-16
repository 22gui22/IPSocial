<?php
    require ("../mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
    $id = $_POST['id'];
	$groupid = $_POST['groupid'];
	
	
	if($stmt = mysqli_prepare($conn, "DELETE FROM groupmembers WHERE GroupMembers_Groups_Id = ? AND GroupMembers_Follower_Id = ?")){
		mysqli_stmt_bind_param($stmt, "ii", $groupid, $id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);			
	}
	
	if($stmt = mysqli_prepare($conn, "SELECT Groups_Users_Id FROM groups WHERE Groups_Id = ?")){
		mysqli_stmt_bind_param($stmt, "i", $groupid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$groupowner);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
    if($stmt = mysqli_prepare($conn, "SELECT Users_FirstName, Users_LastName,Users_Photo, Users_Number, Users_Id FROM groupmembers,users WHERE GroupMembers_Groups_Id = ? AND GroupMembers_Follower_Id = Users_Id")){
		mysqli_stmt_bind_param($stmt, "i", $groupid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $firstname, $lastname, $photo, $number, $id);
		while(mysqli_stmt_fetch($stmt)){
			if($id != $groupowner){
			echo "
			<div class='col-md-6'>
				<div class='card'>
				  <div class='card-body'>
					<div class='row'>
					<div class='col-md-2'><img src='$photo' class='rounded-circle img-responsive' width='50' height='50'></div>
					<div class='col-md-5'><p style='line-height: 40%;padding-top:5%'>$firstname $lastname</p><p style='line-height: 40%;'>$number</p></div>
					<div class='col-md-2'><a type='button' class='btn btn-info' name='perfil' href='profile.php?number=$number' target='_blank'>Perfil</a></div>
					<div class='col-md-3'><input type='button' class='btn btn-danger' onClick='kick_user($groupid,this.id)' id='$id' value='Expulsar'></div>
					</div>
				  </div>
				</div>
			</div>
			";
			}
		}
		mysqli_stmt_close($stmt);
	}
    mysqli_close($conn);
?>


