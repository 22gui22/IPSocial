<?php
 session_start();
 require ("mysqli_connect.php");
 if(!isset($_SESSION['active'])){
	 header('Location: login.php');
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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<script src="js/responsive"></script>
<head>
</head>
<body onLoad="feedSize()">  
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
<!-- Feed -->
<br>
<br>
<br>
<div class='modal' tabindex='-1' role='dialog' id='infoimg'></div>

<div class="container" style="width:35%" align="center" id="feed">
<?php
function getlikes($posid) {
	require ("mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
    if($stmt = mysqli_prepare($conn, "SELECT COUNT(Likes_Post_Id) FROM post, likes WHERE Post_Id = ? AND Likes_Post_Id = Post_Id ")){
		mysqli_stmt_bind_param($stmt, "i", $posid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $likes);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return $likes;
	}
}
function getwasliked($posid) {
	require ("mysqli_connect.php");
	$userid = $_SESSION['id'];
	mysqli_set_charset($conn, 'utf8');
    if($stmt = mysqli_prepare($conn, "SELECT COUNT(Likes_Users_Id) FROM likes WHERE Likes_Users_Id = ? AND Likes_Post_Id = ?")){
		mysqli_stmt_bind_param($stmt, "ii", $userid, $posid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $wasliked);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		if($wasliked > 0){
			$likebutton = "<button class='btn' type='button' onclick='like_add($posid,this.id)' id='like'><i class='fas fa-thumbs-up'></i></button>";
		}else{
			$likebutton = "<button class='btn' type='button' onclick='like_add($posid,this.id)' id='unlike'><i class='far fa-thumbs-up'></i></button>";
		}	
		return $likebutton;
	}
}
function getcomments($posid) {
	require ("mysqli_connect.php");
	$commentlist = "";
	mysqli_set_charset($conn, 'utf8');
	if($stmt = mysqli_prepare($conn, "SELECT * FROM (SELECT Users_Number, Users_Firstname, Users_Lastname, Comments_Comment, Comments_Id FROM comments, users WHERE Users_Id = Comments_Users_Id AND Comments_Post_Id = ? ORDER BY Comments_Id DESC Limit 3)t ORDER BY Comments_Id ASC ")){
		mysqli_stmt_bind_param($stmt, "i", $posid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $tempusernumber,$tempfirstname,$templastname, $comment, $commentid);
		while(mysqli_stmt_fetch($stmt)){
			$commentlist .= "<p align='left'><b><a href='profile.php?number=$tempusernumber'>$tempfirstname $templastname </a></b>$comment</p>";
		}
		mysqli_stmt_close($stmt);
		return $commentlist;
	}
} 
function getgroupname($groupid) {
	require ("mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
	if($stmt = mysqli_prepare($conn, "SELECT Groups_Name FROM groups WHERE Groups_Id = ? ")){
		mysqli_stmt_bind_param($stmt, "i", $groupid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $groupname);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return $groupname;
	}
} 
			mysqli_set_charset($conn, 'utf8');
			$userid = $_SESSION['id'];
			if($stmt = mysqli_prepare($conn, "SELECT Post_Id, Post_Image, Post_Description, Users_Number, Users_Photo, Users_FirstName, Users_LastName, Local_Group_Id FROM follows,post,users,local WHERE Follower_Id = ? AND Following_Id = Post_Users_Id AND Users_Id = Local_Users_Id AND Local_Post_Id = Post_Id UNION SELECT DISTINCT Post_Id, Post_Image, Post_Description, Users_Number, Users_Photo, Users_FirstName, Users_LastName, Local_Group_Id FROM follows,post,users,groupmembers,local WHERE GroupMembers_Follower_Id = ? AND GroupMembers_Groups_Id = Local_Group_Id AND Local_Post_Id = Post_Id AND POST_Users_Id = Users_Id ORDER BY Post_Id DESC")) {
				mysqli_stmt_bind_param($stmt, "ii", $userid, $userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $postid, $postimage,$postdescription,$postusernumber, $postuserphoto,$postuserfirstname, $postuserlastname, $inagroup);
				while(mysqli_stmt_fetch($stmt)){
					$numlikes = getlikes($postid);
					$likebutton = getwasliked($postid);
					$commentlist = getcomments($postid);
					$groupname = getgroupname($inagroup);
					
					if(isset($groupname)){
						echo"<div class='img-thumbnail'>
						 <a href='profile.php?number=$postusernumber' style='color: inherit'><div class='container' align='left'>
						 <p style='float: left;padding-top: 3%;padding-right: 2%;'><img src='$postuserphoto' class='rounded-circle img-responsive' width='40' height='40' href='profile.php?number=$postusernumber'></p>
						  <h6 style='padding-top: 5%;'><b>$postuserfirstname $postuserlastname (Posted on group: $groupname)</b></h6>
						</div></a>
						<div class='imgpost'>
							<input type='hidden' name='id' value='$postid'>
							<button data-toggle='modal' data-target='#infoimg'  name='submiting' class='astext' type='button' style='border: none;background-color: transparent;outline: none;'>
							<img class='img-fluid img-thumbnail img-responsive'  style='max-width: 100%;height: auto;' src='$postimage' style='width:350px; height:350px' alt=''></center>
						</div>
						<div class='container' align='left'>
						  <div id='likebuttondiv$postid'>
						  $likebutton
						  </div>
						  <p align='left'><b id='likecount$postid'>$numlikes pessoas gostam disto</b></p>
						</div>

						<div class='container'>
						  <p align='left'>$postdescription</p>
						</div>

						<div class='container' align='left'>
							$commentlist
						</div> 
						</div><br>";
					}else{
					echo"<div class='img-thumbnail'>
						 <a href='profile.php?number=$postusernumber' style='color: inherit'><div class='container' align='left'>
						 <p style='float: left;padding-top: 3%;padding-right: 2%;'><img src='$postuserphoto' class='rounded-circle img-responsive' width='40' height='40' href='profile.php?number=$postusernumber'></p>
						  <h6 style='padding-top: 5%;'><b>$postuserfirstname $postuserlastname</b></h6>
						</div></a>
						<div class='imgpost'>
							<input type='hidden' name='id' value='$postid'>
							<button data-toggle='modal' data-target='#infoimg'  name='submiting' class='astext' type='button' style='border: none;background-color: transparent;outline: none;'>
							<img class='img-fluid img-thumbnail img-responsive'  style='max-width: 100%;height: auto;' src='$postimage' style='width:350px; height:350px' alt=''></center>
						</div>
						<div class='container' align='left'>
						  <div id='likebuttondiv$postid'>
						  $likebutton
						  </div>
						  <p align='left'><b id='likecount$postid'>$numlikes pessoas gostam disto</b></p>
						</div>

						<div class='container'>
						  <p align='left'>$postdescription</p>
						</div>

						<div class='container' align='left'>
							$commentlist
						</div> 
						</div><br>";
					}
				}
				
				mysqli_stmt_close($stmt);
			}
			mysqli_close($conn);
		
?>
<center><h3>Tens que seguir mais pessoas para teres mais publicações aqui<h3></center>
</div>
<br>
</body>
</html>
<script>
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
</script>