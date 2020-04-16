<?php
 session_start();
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <li class="nav-item" style="list-style-type: none;"><a class="nav-link" href="notifications.php"><img src="images/icons/bell.svg" width="19" height="19"/></a></li>

</ul>
<ul>
	<li class="nav-item dropdown" style="list-style-type:none;">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img src="images/icons/three-bars.svg" width="25" height="25"/>
        </a>
        <div class="dropdown-menu dropdown-pull-right" aria-labelledby="navbarDropdown" style="float:right !important;right:0;left:auto;">
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
<!-- Config -->
<div class="container" style="width:80%">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="conta-tab" data-toggle="tab" href="#conta" role="tab" aria-controls="profile" aria-selected="true">Conta</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="privacidade-tab" data-toggle="tab" href="#privacidade" role="tab" aria-controls="privacidade" aria-selected="false">Privacidade</a>
  </li>
</ul>
<br>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="conta" role="tabpanel" aria-labelledby="conta-tab">
  <form method = "post">  
<?php
require ("mysqli_connect.php");

	$userid = $_SESSION['id'];
		mysqli_set_charset($conn, 'utf8');
			if($stmt = mysqli_prepare($conn, "SELECT Users_Id, Users_FirstName, Users_LastName, Users_Number FROM users WHERE Users_Id = ?")) {
				mysqli_stmt_bind_param($stmt, "i", $userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $userid, $userfirstname, $userlastname, $usernumber);
				$row = mysqli_stmt_fetch($stmt);	
				mysqli_stmt_close($stmt);
			}
				
	if(isset($_POST['submit'])){
				
		if($row > 0){
			if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['number']) && isset($_POST['password']) && isset($_POST['newpassword'])){
				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];
				$number = $_POST['number'];
				$password = $_POST['password'];
				$newpassword = $_POST['newpassword'];
				if($number != $usernumber){
					if($password == $newpassword){
						mysqli_set_charset($conn, 'utf8');	
							if($stmt = mysqli_prepare($conn, "UPDATE users SET Users_FirstName = ?, Users_LastName = ?, Users_Number = ?, Users_Password = ? WHERE Users_Id = '$userid'")){
								mysqli_stmt_bind_param($stmt, "ssis", $firstname, $lastname, $number, $password);
								mysqli_stmt_execute($stmt);				
								mysqli_stmt_close($stmt);
								
								$sucsess = '<div class="alert alert-success" role="alert">
								<a href="#" class="close"></a>
								<strong>Sucesso!</strong> Alteração realizada com sucesso!!
								</div>';	
							}
						mysqli_close($conn);
						
					}else{
						$passdontmatch = '<div class="alert alert-danger" role="alert">
						<a href="#" class="close"></a>
						<strong>Erro!</strong> Passwords não correspondem!!
						</div>';
					}
				}else{
					$samenumber = '<div class="alert alert-danger" role="alert">
					<a href="#" class="close"></a>
					<strong>Erro!</strong> Esse número de aluno já existe!!
					</div>';
				}
			}else{
				header("Location: config.php");
			}
		}else{
			$wrongaccount = '<div class="alert alert-danger" role="alert">
			<a href="#" class="close"></a>
			<strong>Erro!</strong> Não existe esse utilizador!!
			</div>';
		}
	}
?>  
    <h3>Conta</h3>
  <hr>
  <div class="form-row">
    <div class="form-group col-md-6">
		<label>Nome</label>
		<input class='form-control' type='text' value="<?php echo $userfirstname; ?>" id='firstname' required name='firstname' maxlength='20'>
    </div>
    <div class="form-group col-md-6">
		<label>Apelido</label>
		<input class="form-control" type="text" value="<?php echo $userlastname; ?>" id="lastname" required name="lastname" maxlength="20">
    </div>
	</div>
    <div class="form-row">
    <div class="form-group col-md-6">
		<label>Nº de Aluno</label>
		<input class="form-control" type="number" value="<?php echo $usernumber; ?>" id="number" required name="number" min="10000" max="9999999999">
    </div>
    <div class="form-group col-md-6">
    </div>
	</div>
    <div class="form-row">
    <div class="form-group col-md-6">
		<label>Nova password</label>
		<input class="form-control" type="password" id="password" required name="password" maxlength="32">
    </div>
    <div class="form-group col-md-6">
		<label>Nova password</label>
		<input class="form-control" type="password" id="newpassword" required name="newpassword" maxlength="32">
    </div>
	</div>
  <hr>
  <?php if(isset($samenumber)) echo $samenumber ?>
  <?php if(isset($passdontmatch)) echo $passdontmatch ?>
  <?php if(isset($wrongaccount)) echo $wrongaccount ?>
  <?php if(isset($sucsess)) echo $sucsess ?>
  <button type="submit" name="submit" value="Send" class="btn btn-primary">Guardar</button>
  </form>
  </div>

  <div class="tab-pane fade" id="privacidade" role="tabpanel" aria-labelledby="privacidade-tab"> 
  <h3>Privacidade</h3>
<?php
	if($stmt = mysqli_prepare($conn, "SELECT Privacy_Gender, Privacy_BirthDate, Privacy_Post, Privacy_Location FROM privacy, users WHERE Users_Number = ? AND Privacy_Users_Id = Users_Id")) {
		mysqli_stmt_bind_param($stmt, "i", $usernumber);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $privacygender, $privacybirthdate, $privacypost, $privacylocation);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
	if(isset($_POST['sub'])){
		$gender = $_POST['gender'];
		$age = $_POST['age'];
		$post = $_POST['post'];
		$location = $_POST['location'];
		if($stmt = mysqli_prepare($conn, "UPDATE privacy SET Privacy_Gender = ?, Privacy_BirthDate = ?, Privacy_Post = ?, Privacy_Location = ? WHERE Privacy_Users_Id = ?")){
			mysqli_stmt_bind_param($stmt, "iiii", $gender, $age, $post, $location,$userid);							
			mysqli_stmt_execute($stmt);								
			mysqli_stmt_close($stmt);
		}
		
		if($stmt = mysqli_prepare($conn, "SELECT Privacy_Gender, Privacy_BirthDate, Privacy_Post, Privacy_Location FROM privacy, users WHERE Users_Number = ? AND Privacy_Users_Id = Users_Id")) {
		mysqli_stmt_bind_param($stmt, "i", $usernumber);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $privacygender, $privacybirthdate, $privacypost, $privacylocation);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		}
		
	}
?>
<hr>
<form method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>Quem pode ver as minhas publicações:</label><br>
		<div class="form-check form-check-inline" name="post">
		<input class="form-check-input" type="radio" name="post" id="inlineRadio4" value="1" <?php if($privacypost == 1){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio4">Todos&nbsp;&nbsp;</label>
		<input class="form-check-input" type="radio" name="post" id="inlineRadio5" value="2" <?php if($privacypost == 2){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio5">Apenas utilizadores&nbsp;&nbsp;</label>
		<input class="form-check-input" type="radio" name="post" id="inlineRadio6" value="3" <?php if($privacypost == 3){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio6">Apenas seguidores</label>
		</div>
  </div>
  <br>
    <div class="form-group col-md-6">
      <label>Quem pode ver o meu genero:</label><br>
		<div class="form-check form-check-inline" name="gender">
		<input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="1" <?php if($privacygender == 1){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio7">Todos&nbsp;&nbsp;</label>
		<input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="2" <?php if($privacygender == 2){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio8">Apenas seguidores&nbsp;&nbsp;</label>
		<input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="3" <?php if($privacygender == 3){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio9">Ninguem</label>
		</div>
    </div>
    <div class="form-group col-md-6">
      <label>Quem pode ver a minha localização:</label><br>
		<div class="form-check form-check-inline" name="location">
		<input class="form-check-input" type="radio" name="location" id="inlineRadio3" value="1" <?php if($privacylocation == 1){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio10">Todos&nbsp;&nbsp;</label>
		<input class="form-check-input" type="radio" name="location" id="inlineRadio3" value="2" <?php if($privacylocation == 2){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio11">Apenas seguidores&nbsp;&nbsp;</label>
		<input class="form-check-input" type="radio" name="location" id="inlineRadio3" value="3" <?php if($privacylocation == 3){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio12">Ninguem</label>
		</div>
    </div>
  <br>
    <div class="form-group col-md-6">
      <label>Quem pode ver a minha idade:</label><br>
		<div class="form-check form-check-inline" name="age">
		<input class="form-check-input" type="radio" name="age" id="inlineRadio4" value="1" <?php if($privacybirthdate == 1){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio13">Todos&nbsp;&nbsp;</label>
		<input class="form-check-input" type="radio" name="age" id="inlineRadio4" value="2" <?php if($privacybirthdate == 2){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio14">Apenas seguidores&nbsp;&nbsp;</label>
		<input class="form-check-input" type="radio" name="age" id="inlineRadio4" value="3" <?php if($privacybirthdate == 3){echo 'checked';} ?>>
		<label class="form-check-label" for="inlineRadio15">Ninguem</label>
		</div>
    </div>
  </div>
  <hr>
  <br>
  <button type="submit" name="sub" class="btn btn-primary">Guardar</button>
</form>
  </div>
</div>
</div>
</body>
</html>