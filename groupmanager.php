<?php
 session_start();
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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script><head><head>
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
      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <img src="images/icons/bell.svg" width="19" height="19"/></a>
       <ul class="dropdown-menu"></ul>
      </li>
</ul>
<ul>
	<li class="nav-item dropdown" style="list-style-type:none;">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img src="images/icons/three-bars.svg" width="25" height="25"/>
        </a>
        <div class="dropdown-menu dropdown-pull-right" aria-labelledby="navbarDropdown" style="float:right !important;right:0;left:auto;">
          <a class="dropdown-item text-right" href="config.php"><img src="images/icons/gear.svg" width="16" height="16"/> Configurações</a>
		  <a class="dropdown-item text-right" href="faq.php"><img src="images/icons/repo.svg" width="16" height="16"/> F.A.Q</a>
          <a class="dropdown-item text-right" href="terms.php"><img src="images/icons/repo.svg" width="16" height="16"/> Termos e condições</a>
          <a class="dropdown-item text-right" href="logout.php"><img src="images/icons/sign-out.svg" width="16" height="16"/> Sair</a>
        </div>
    </li>
</ul>
</div> 
</div> 
</nav>﻿
<!-- body -->
<div class="container" style="width:80%">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="grupo-tab" data-toggle="tab" href="#grupo" role="tab" aria-controls="grupo" aria-selected="true">Grupo</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="membros-tab" data-toggle="tab" href="#membros" role="tab" aria-controls="membros" aria-selected="false">Membros</a>
  </li>
</ul>
<br>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="grupo" role="tabpanel" aria-labelledby="grupo-tab">
  <?php
	$groupid = $_POST['groupid'];
	mysqli_set_charset($conn, 'utf8');
	if($stmt = mysqli_prepare($conn, "SELECT Groups_Name, Groups_Description, Groups_Users_Id FROM groups WHERE Groups_Id = ?")){
		mysqli_stmt_bind_param($stmt, "i", $groupid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $name, $description,$groupowner);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
	if(isset($_POST['changeinfo'])){
		$name = $_POST['name'];
		$description = $_POST['desc'];
		mysqli_set_charset($conn, 'utf8');
		if($stmt = mysqli_prepare($conn, "UPDATE groups SET Groups_Name = ?, Groups_Description = ? WHERE Groups_Id = ?")){
			mysqli_stmt_bind_param($stmt,"ssi", $name, $description,$groupid);
			mysqli_stmt_execute($stmt);
			$lastid = mysqli_insert_id($conn);
			mysqli_stmt_close($stmt);
		}	
	}
	
  ?>
    <h3>Grupo</h3>
  <hr>
  <form method='post'>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label>Nome</label>
      <input class="form-control" type="text" name="name" value="<?php echo $name;?>" maxlength="50">
    </div>
	</div>
    <div class="form-group">
		<label for="comment">Descrição:</label>
		<textarea class="form-control" rows="5" id="desc" maxlength="350" name="desc" style="resize:none"><?php echo $description;?></textarea>
	</div> 
  <hr>
  <br>
  <input type='hidden' name='groupid' value='<?php echo $groupid;?>'>
  <button type="submit" name="changeinfo" class="btn btn-primary">Guardar</button>
</form>
  
  </div>
  <div class="tab-pane fade" id="membros" role="tabpanel" aria-labelledby="membros-tab">
  
    <h3>Membros</h3>
  <hr>
  <div class="row" id="memberlist">
<?php 
	mysqli_set_charset($conn, 'utf8');
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
?>
	</div>
  </div>
</div>
</div>
</body>
</html>
<script>
function kick_user(groupid,id){
	$.ajax({
		type: "POST",
		url: "ajaxscripts/groupkickuser.php",
		data: {groupid:groupid,id:id},
		success: function (data) {
			members_update(data);
		}
	});
}

function members_update(data){
	document.getElementById("memberlist").innerHTML = data;
}
</script>