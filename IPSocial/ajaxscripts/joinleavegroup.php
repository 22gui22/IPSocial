<?php
    require ("../mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
    $id = $_POST['id'];
	$groupid = $_POST['groupid'];
	
	if(isset($_POST['join'])){
		if($stmt = mysqli_prepare($conn, "INSERT INTO groupmembers (GroupMembers_Follower_Id, GroupMembers_Groups_Id) VALUES(?,?)")){
			mysqli_stmt_bind_param($stmt,"ii", $id, $groupid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);			
		}
	}
	
	if(isset($_POST['leave'])){
		if($stmt = mysqli_prepare($conn, "DELETE FROM groupmembers WHERE GroupMembers_Groups_Id = ? AND GroupMembers_Follower_Id = ?")){
			mysqli_stmt_bind_param($stmt, "ii", $groupid, $id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);			
		}
	}
	
	if($stmt = mysqli_prepare($conn, "SELECT Groups_Name, Groups_Description, Groups_Users_Id FROM groups WHERE Groups_Id = ?")){
		mysqli_stmt_bind_param($stmt, "i", $groupid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $groupname, $groupdescription, $groupowner);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
	if($stmt = mysqli_prepare($conn, "SELECT COUNT(GroupMembers_Follower_Id) FROM groupmembers WHERE GroupMembers_Follower_Id = ? AND GroupMembers_Groups_Id = ?")){
		mysqli_stmt_bind_param($stmt, "ii", $id,$groupid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $isfollowing);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
	if($stmt = mysqli_prepare($conn, "SELECT COUNT(GroupMembers_Follower_Id) FROM groupmembers WHERE GroupMembers_Groups_Id = ?")){
		mysqli_stmt_bind_param($stmt, "i", $groupid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $followers);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
	echo "<h5 align='left'><b>$groupname</b></h5>";
	if ($groupowner == $id){
		echo "<form action='groupmanager.php' method='post'><input type='hidden' name='groupid' value='$groupid'><button class='btn btn-info float-right' type='submit'><i class='fa fa-edit'></i> Editar</Button></form><br><br>";			
	}
	if ($isfollowing > 0 || $groupowner == $id){
		echo "<form action='grouppost.php' method='post'><input type='hidden' name='groupid' value='$groupid'><button class='btn btn-info float-right' type='submit'><i class='fa fa-edit'></i> Novo Post</Button></form>";			
	}
	echo"
		<br><br><br>
		<div class='row'>
			<div class='col-md-6'><p align='left'><b>Descrição:</b></p><p align='left'>$groupdescription</p></div>
			<div class='col-md-6'><p align='middle'><b>Membros:</b> $followers</p></div>
		</div>
		<br><br><br>
		";
	if ($isfollowing > 0 && $groupowner != $id){
		echo "<button type='button' class='btn btn-danger float-right' onClick='leave_group($id,$groupid)'><i class='fa fa-minus'></i> Sair do Grupo</button><br>";
	}
	if ($isfollowing == 0 && $groupowner != $id){
		echo "<button type='button' class='btn btn-success float-right' onClick='join_group($id,$groupid)'><i class='fa fa-plus'></i> Entrar no Grupo</button><br>";
	}
    mysqli_close($conn);
?>


