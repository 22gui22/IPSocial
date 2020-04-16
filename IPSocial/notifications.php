<?php 
session_start();
if(!isset($_SESSION['active'])){
	 header('Location: login.php');
 }

require ("mysqli_connect.php");
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
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<head>
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
	<li class="nav-item"><a class="nav-link" href="messages.php"><img src="images/icons/inbox.svg" width="16" height="16"/> Mensagens</a></li>
</ul>
<ul class="navbar-nav mx-auto"> 
<li class="nav-item"><a class="nav-link" href="post.php"><img src="images/icons/diff-added.svg" width="16" height="16"/> Publicação</a></li>
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
    <li class="nav-item" style="list-style-type: none;"><a class="nav-link" href="notifications.php"><img src="images/icons/bell.svg" width="16" height="16"/></a></li>
</ul>
<ul>
	<li class="nav-item dropdown" style="list-style-type:none;">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img src="images/icons/three-bars.svg" width="25" height="25"/>
        </a>
        <div class="dropdown-menu dropdown-pull-right" aria-labelledby="navbarDropdown" style="float:left !important;right:0;left:auto;">
          <a class="dropdown-item text-left" href="config.php"><img src="images/icons/gear.svg" width="16" height="16"/> Configurações</a>
		  <a class="dropdown-item text-left" href="faq.php"><img src="images/icons/repo.svg" width="16" height="16"/> F.A.Q</a>
          <a class="dropdown-item text-left" href="terms.php"><img src="images/icons/repo.svg" width="16" height="16"/> Termos e condições</a>
          <a class="dropdown-item text-left" href="logout.php"><img src="images/icons/sign-out.svg" width="16" height="16"/> Sair</a>
        </div>
    </li>
</ul>
</div> 
</div> 
</nav>﻿
<div class="row justify-content-md-center">
	<div class="col col-lg-5">
	<br>
	<h3>Notificações</h3>
	  <hr>
		<ul class="list-unstyled">
		<?php
		$userid = $_SESSION['id'];
		$lastdate = date("Y-m-d");
			mysqli_set_charset($conn, 'utf8');
			if($stmt = mysqli_prepare($conn, "SELECT Notifications_Content, Notifications_Photo, Notifications_Date, Users_FirstName, Users_LastName, Users_Photo, DATE(Notifications_Date) FROM users,notifications WHERE Notifications_Receiver_Id = ? AND Notifications_Sender_Id = Users_Id ORDER BY Notifications_Id DESC")) {
				mysqli_stmt_bind_param($stmt, "i", $userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $content, $notphoto, $datetime, $firstname, $lastname, $photo, $date);
				while(mysqli_stmt_fetch($stmt)){
					if($date != $lastdate){
					  echo"<center>$date</center><hr>";
				  }
				  if($notphoto == NULL){
					  echo"<li class='media'>
						<img class='mr-3' src='$photo' style='width:70px;height:70px'>
						<div class='media-body'>
						<h6 class='media-heading'><small><i>".$datetime."</i></small></h6>
						".$firstname." ".$lastname." ".$content."
						</div>
						</li><hr>";
					  
					  $lastdate = $date;
				  }else{
					echo"<li class='media'>
						<img class='mr-3' src='$photo' style='width:70px;height:70px'>
						<div class='media-body'>
						<h6 class='media-heading'><small><i>".$datetime."</i></small></h6>
						".$firstname." ".$lastname." ".$content."
						</div>
						<img class='mr-3' src='$notphoto' style='width:70px;height:70px'>
						</li><hr>";
					  
					  $lastdate = $date;
				  }
				}
				
				mysqli_stmt_close($stmt);
			}
			mysqli_close($conn);
		?>
		</ul>
	</div>
</div>
</body>