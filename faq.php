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
<div class="container" style="padding-top: 1%; width: 50%">
	<center>
	<h2 style="font-size:30px; color:#3399ff;">Perguntas mais frequentes</h2>
	</center>
	<br>
<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Como posso criar uma conta no IPSocial ? 
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <h6>Para criares conta basta: </h6>
		<p>1. Acederes à página inicial do<a href="login.php"> IPSocial</a></p>
		<p>2. Clicar em<a href="register.php"> criar conta</a></p>
		<p>3. Preencher os campos Nome, Apelido, Password, Email e Número de Aluno com as devidas informações corretas</p>
		<p>4. Clicar em Registar</p>
		<h6>Nota : Ao fazer o registo, automaticamente concorda com os nossos termos e condições</h6>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Problemas a iniciar sessão
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
		<p>Se estiveres com problemas ao tentar iniciar sessão, podes:</p>
		<p>- Acederes à página inicial do<a href="login.php"> IPSocial</a>, e clicar em esqueceu-se da palavra-passe</p>
		<p>- Identificas a conta através do teu email</p>
		<p>- De seguida irás receber um email com uma palavra-passe</p>
		<h6>Nota: Se continuas com problemas, podemos ajudar-te a recuperar a conta</h6>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          É possivel alterar a palavra-passe ou repor ? 
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
		<h6>Alterar a Palavra-passe</h6>
		<p>Para alterar a palavra-passe se tiveres a sessão iniciada no IPSocial:</p>
		<p>1. Clica no menu no canto superior direito</p>
		<p>2. Clica em Configurações</p>
		<p>3. Clica no separador Conta</p>
		<p>4. Preencher os campos respetivos à nova palavra-passe</p>
		<p>5. Clica em Guardar</p>
		<h6>Nota: Se continuas com problemas, podemos ajudar-te a recuperar a conta</h6>
		<br>
		<h6>Repõe a tua palavra-passe</h6>
		<p>Para respores a palavra-passe se não tiveres a sessão iniciada no IPSocial:</p>
		<p>1. Acede à pagina inicial do<a href="login.php"> IPSocial</a></p>
		<p>2. Clica em <a href="forgotpass.php">Esqueceu-se da palavra-passe?</a></p>
		<p>3. Escreve o email associada à conta</p>
		<p>4. Irás receber um email com uma palavra-passe</p>
		<h6>Nota: Se continuas com problemas, podemos ajudar-te a recuperar a conta</h6>
      </div>
    </div>
	<div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Como posso fortalecer a minha palavra-passe ?
        </button>
      </h5>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
      <div class="card-body">
		<h6>Podes fortalecer a tua palavra-passe das seguintes maneiras:</h6>
		<p>- Quando criares uma nova palavra-passe, certifica-te de que tem pelo menos 23 carateres. Tenta utilizar uma combinação complexa de números, letras e caracteres especiais.</p>
		<p>- Podes tornar a palavra-passe mais complexa ao torná-la com uma frase ou uma série de palavras que sejam fáceis para si, mas que ninguem mais conheça</p>
		<h6>Nota: Lembra-te de que a tua palavra-passe do IPSocial deve ser diferente das palavras-passe que utilizas para iniciar sessão noutras contas, como o teu e-mail ou a tua conta bancária.</h6>
      </div>
    </div>
  </div>
  </div>
</div>
</div>
</body>