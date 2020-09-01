<?php
 session_start(); 
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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script><head>
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
<!-- Search bar -->
<br>
<br>
<br>
<div class="container" style="width:80%">
	<div class="row">
		<div class="col-md-10">
			<div class="search-box">
				<input class="form-control" style="width:93%" type="text" name="searchgroup" placeholder="Nome do Grupo..." aria-label="Search">
			</div>
		</div>
		<div class="col-md-2">
			<?php
			if (@$_SESSION['active'] == '1'){
				echo '<a  href="newgroup.php" role="button"  class="btn btn-info float-middle">Criar Grupo</a>';	     
			}
			?>
		</div>
	</div>
</div>

<!-- Photos/Groups -->
<br>
<div class="container" style="width:80%">
<hr>
<div class="row" id="grouplist">
<?php 
require ("mysqli_connect.php");
		mysqli_set_charset($conn, 'utf8');
        if($stmt = mysqli_prepare($conn, "SELECT Groups_Id, Groups_Name, Groups_Photo From groups, groupmembers WHERE Groups_Id = Groupmembers_Groups_Id GROUP BY Groups_Id ORDER BY COUNT(Groupmembers_Follower_Id) DESC ")) {
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $groupid, $groupname, $groupphoto);
			while ($row = mysqli_stmt_fetch($stmt)){
				echo "<div class='col-md-4'>
						<a href='groupprofile.php?group=$groupid' class='d-block mb-4 h-100'>
							<center><label>$groupname</label></center>
							<img class='img-fluid img-thumbnail img-responsive' src='$groupphoto' style='width:350px; height:350px' alt=''>
						</a>
					</div>";
			}
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
?>
</div>
<hr>
</div>
</body>
</html>
<script>
$(document).ready(function(){

    $('.search-box input[type="text"]').on("keyup input", function(){

        var inputVal = $(this).val();

        if(inputVal.length){

            $.get("ajaxscripts/groupsearch.php", {term: inputVal}).done(function(data){

				document.getElementById("grouplist").innerHTML = "";
				document.getElementById("grouplist").innerHTML = data;

            });

        } else{
			def = "def";
			$.ajax({
				type: "POST",
				url: "ajaxscripts/groupsearch.php",
				data: {def:def},
				success: function (data) {
					document.getElementById("grouplist").innerHTML = "";
					document.getElementById("grouplist").innerHTML = data;
				}
			});

        }

    });

});
</script>