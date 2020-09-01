<?php
if(!isset($_GET['group'])){
	header('Location: groups.php');
}
 session_start();
 require ("mysqli_connect.php");
 mysqli_set_charset($conn, 'utf8');
 
 $groupid = $_GET['group'];
	
	if($stmt = mysqli_prepare($conn, "SELECT Groups_Id FROM groups WHERE Groups_Id = $groupid")){
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $groupsid);
		$row = mysqli_stmt_fetch($stmt);
		if($row < 1){
			header('Location: groups.php');
		}
		mysqli_stmt_close($stmt);
	}
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>IPSocial</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script><head><head><head>
</head>
<body>  
<!-- Nav Bar -->
<nav class="navbar navbar-expand-xl bg-light navbar-light"> 
<div class="container-fluid"> 
<!--Logo Aqui --> 
<div class="navbar-header"> 
	<a class="navbar-brand" href="index.php">
    <img src="images/logo/ipsocial.png" width="150" height="40" class="d-inline-block align-top" alt="">
  </a>
</div>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> 
<!--Menu --> 
<div class="collapse navbar-collapse" id="navbarSupportedContent"> 
<ul class="navbar-nav navbar-left"> 
	<li class="nav-item"><a class="nav-link" href="index.php"><img src="images/icons/home.svg" width="16" height="16"/> Pagina Inicial</a></li> 
	<li class="nav-item"><a class="nav-link" href="groups.php"><img src="images/icons/organization.svg" width="16" height="16"/> Grupos</a></li> 
<?php
	if (isset($_SESSION['active'])){
		echo '<li class="nav-item"><a class="nav-link" href="messages.php"><img src="images/icons/inbox.svg" width="16" height="16"/> Mensagens</a></li>';	     
	}
?> 
</ul>
<ul class="navbar-nav mx-auto"> 
<?php
	if (isset($_SESSION['active'])){
		echo '<li class="nav-item"><a class="nav-link" href="post.php"><img src="images/icons/diff-added.svg" width="16" height="16"/> Publicação</a></li>';	     
	}
?>
</ul>
<a class="navbar-nav mx-auto" style="width:35%">
	<form class="form-inline" action="search.php" method="post">
		<input class="form-control mr-sm-2" type="search" placeholder="Search" name="searchname">
		<button class="btn btn-outline-light my-2 my-sm-0" type="submit"><img src="images/icons/search.svg" width="16" height="16"/></button>
	</form>
</a>
<ul class="navbar-nav navbar-right">
<?php
	$Login=('<li class="nav-item" style="list-style-type: none;"><a class="nav-link" href="register.php"><img src="images/icons/person.svg" width="16" height="16"/> Registar</a></li>
	<li class="nav-item" style="list-style-type: none;padding-right:30px"><a class="nav-link" href="login.php"><img src="images/icons/sign-in.svg" width="16" height="16"/> Login</a></li>');
	
	
	if(isset($_SESSION['active'])){
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		echo '<li class="nav-item" style="list-style-type: none;padding-right:30px"><a class="nav-link" href="profile.php"><img src="images/icons/person.svg" width="16" height="16"/>&nbsp;&nbsp;&nbsp;'.$firstname.' '.$lastname.'</a></li>';
	     
	}else if (!isset($_SESSION['active'])){
		echo $Login;
	}
?>
<?php
	if (isset($_SESSION['active'])){
		echo '<li class="nav-item"><a class="nav-link" href="notifications.php"><img src="images/icons/bell.svg" width="16" height="16"/></a></li>';
	}		  
?>
</ul>
<?php
	if (isset($_SESSION['active'])){
		echo '<ul><li class="nav-item dropdown" style="list-style-type:none;">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img src="images/icons/three-bars.svg" width="25" height="25"/>
        </a>
        <div class="dropdown-menu dropdown-pull-right" aria-labelledby="navbarDropdown" style="float:right !important;right:0;left:auto;">
          <a class="dropdown-item text-left" href="config.php"><img src="images/icons/gear.svg" width="16" height="16"/> Configurações</a>
		  <a class="dropdown-item text-left" href="faq.php"><img src="images/icons/repo.svg" width="16" height="16"/> F.A.Q</a>
          <a class="dropdown-item text-left" href="terms.php"><img src="images/icons/repo.svg" width="16" height="16"/> Termos e condições</a>
          <a class="dropdown-item text-left" href="logout.php"><img src="images/icons/sign-out.svg" width="16" height="16"/> Sair</a>
        </div>
		</li></ul>';	     
	}
?> 
</div> 
</div> 
</nav>﻿

<br>
<br>
<br>
<?php
	$userid = $_SESSION['id'];
	$groupid = $_GET['group'];
	
	if($stmt = mysqli_prepare($conn, "SELECT Groups_Name, Groups_Photo, Groups_Description, Groups_Users_Id FROM groups WHERE Groups_Id = ?")){
		mysqli_stmt_bind_param($stmt, "i", $groupid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $groupname, $groupphoto, $groupdescription, $groupowner);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	if($stmt = mysqli_prepare($conn, "SELECT COUNT(GroupMembers_Follower_Id) FROM groupmembers WHERE GroupMembers_Follower_Id = ? AND GroupMembers_Groups_Id = ?")){
		mysqli_stmt_bind_param($stmt, "ii", $userid, $groupid);
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


?>
<!-- Profile -->
<br>
<div class="container" style="width:85%; background:#f6f6f6">
<br>
<div class="row">
<div class='col-md-4'>
	<a href='#' class='d-block mb-4 h-100'>
		<img class='img-fluid img-thumbnail img-responsive' src='<?php echo $groupphoto;?>' style='width:350px; height:350px;'>
	</a>
</div>
<div class='col-md-8' id="following">
<?php
	echo "<h5 align='left'><b>$groupname</b></h5>";

	if ($groupowner == $userid){
		echo "<form action='groupmanager.php' method='post'><input type='hidden' name='groupid' value='$groupid'><button class='btn btn-info float-right' type='submit'><i class='fa fa-edit'></i> Editar</Button></form><br><br>";			
	}
	if ($isfollowing > 0 || $groupowner == $userid){
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

	if ($isfollowing > 0 && $groupowner != $userid){
		echo "<button type='button' class='btn btn-danger float-right' onClick='leave_group($userid,$groupid)'><i class='fa fa-minus'></i> Sair do Grupo</button><br>";
	}
	if ($isfollowing == 0 && $groupowner != $userid){
		echo "<button type='button' class='btn btn-success float-right' onClick='join_group($userid,$groupid)'><i class='fa fa-plus'></i> Entrar no Grupo</button><br>";
	}
?>
</div>
</div>
</div>
<!-- Modal do gui-->
<div class='modal' tabindex='-1' role='dialog' id='infoimg'></div>

<div class="container" style="width:80%">
	<div id="" class="row">
<?php 
		mysqli_set_charset($conn, 'utf8');
			if($stmt = mysqli_prepare($conn, "SELECT Post_Image, Post_Id FROM post,local WHERE Post_Id = Local_Post_Id AND Local_Group_Id = ? ORDER BY Post_Id Desc")) {
				mysqli_stmt_bind_param($stmt, "i", $groupid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $postimage, $postid);
				while(mysqli_stmt_fetch($stmt)){
				echo"<div class='col-md-4 imgpost'>
				<form method='post'>
				<input type='hidden' name='id' value=".$postid.">
				<button data-toggle='modal' data-target='#infoimg'  name='submiting' class='astext' type='button' style='border: none;background-color: transparent;outline: none;'>
				<img class='img-fluid img-thumbnail img-responsive' style='width:900px; height:300px' src=".$postimage.">
				</button>
				</form>
				</div>";
				}
				
				mysqli_stmt_close($stmt);
			}
			mysqli_close($conn);	
?>

	</div>
</div>
</body>
<?php
	if(isset($_SESSION['number'])){
		echo "<script>
$(document).on('click', '.imgpost', function(e){
        var idClick = $('input[type=hidden]',this).val();
        var dataString = 'id=' + idClick;
	
        $.ajax({
            type: 'POST',
            url: 'postup.php',
            data: dataString,
            success: function (data) {
				 document.getElementById('infoimg').innerHTML = data;

        }
    });
});

$('.modal').on('hidden.bs.modal', function(){
    $('.modal').html('');
});

function like_add(postid,state){
	$.ajax({
            type: 'POST',
            url: 'givealike.php',
            data: {postid:postid,state:state},
            success: function (data) {
				 like_update(data,postid);

        }
    });
}

function like_update(data,postid){
	index = data.indexOf(',');
	count = data.substr(0, index);
	btn = data.substr(index + 1);
	document.getElementById('likecount'+postid).innerHTML = count + ' pessoas gostam disto';
	document.getElementById('likebuttondiv'+postid).innerHTML = btn;
}

function comment_add(postid){
	comment = document.getElementById('addcomment').value;
	if(comment != ''){
		$.ajax({
				type: 'POST',
				url: 'postacomment.php',
				data: {postid:postid,comment:comment},
				success: function (data) {
					 comment_update(data);

			}
		});
	}
}

function comment_update(data){
	document.getElementById('commentlistdiv').innerHTML = data;
	document.getElementById('addcomment').value = '';
}
</script>";
	}
		
?>
<script>
function join_group(id,groupid){
	$.ajax({
		type: "POST",
		url: "ajaxscripts/joinleavegroup.php",
		data: {groupid:groupid,id:id,join:"join"},
		success: function (data) {
			group_update(data);
		}
	});
}

function leave_group(id,groupid){
	$.ajax({
		type: "POST",
		url: "ajaxscripts/joinleavegroup.php",
		data: {groupid:groupid,id:id,leave:"leave"},
		success: function (data) {
			group_update(data);
		}
	});
}

function group_update(data){
	document.getElementById("following").innerHTML = data;
}
</script>
</html>