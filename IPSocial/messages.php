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
<!------ Chat ---------->

<div class="container">
    <div class="row">
        <div class="col-lg-3">
			<div class="pull-left col-xs-6">
			    <div class="search-box">
					<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" size="17">
				</div>
			</div>
        </div>

        <div class="col-lg-offset-1 col-lg-7">
        </div>
    </div>
    <div class="row">

        <div class="conversation-wrap col-lg-3" id="friendlist" style="overflow-y: scroll; height:500px;">
		<br>
		<?php 
			$userid = $_SESSION['id'];
			mysqli_set_charset($conn, 'utf8');
			
			if($stmt = mysqli_prepare($conn, "SELECT * FROM (SELECT Users_Id FROM follows, users WHERE Following_Id = ? AND Follower_Id = Users_Id) AS A JOIN (SELECT Users_FirstName,Users_Lastname,Users_Number,Users_Photo,Users_Id FROM follows, users WHERE Follower_Id = ? AND Following_Id = Users_Id) AS B On A.Users_Id = B.Users_Id")) {
				mysqli_stmt_bind_param($stmt, "ii", $userid, $userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $friendid, $friendfirstname, $friendlastname, $friendnumber, $friendphoto, $friendtrash);
				while(mysqli_stmt_fetch($stmt)){
					echo "
					<div class='media conversation'>
					<button onclick='open_chat($friendid)' style='border: none;background-color: transparent;outline: none;'>
						<div class='row align-items-center'>
						<div class='col-4'>
						<a class='pull-left'>
							<img class='media-object' align='left' style='width: 50px; height: 50px;' src='$friendphoto'>
						</a>
						</div>
						<div class='col-8'>
						<div class='media-body'>
							<font size='3' align='right'>$friendfirstname $friendlastname</font>
							<small align='right'>$friendnumber</small>
						</div>
						</div>
						</div>
					</button>
					</div><br>
					";
				}
				mysqli_stmt_close($stmt);
			}
			
			
			
			
			?>
            
			
			
			
        </div>



        <div class="message-wrap col-lg-8" id ="chatscro" style="overflow-y: scroll; height:500px;width:100%;">
            <div class="msg-wrap">
			<ul id="chat">

                
			</ul>
            </div>
			<div id="txtini"><center><h2>Escolhe um amigo para abrir o chat</h2></center></div>
			<div id="sendmsg" style="visibility:hidden">
            <div class="send-wrap ">

                <textarea id="msg" class="form-control send-message" rows="3" maxlength="300" placeholder="Escreva a sua mensagem..."></textarea>


            </div>
            <div class="btn-panel">
                <a class="btn" role="button" id="entermsg" onclick="chat_newmsg()"><i class="fa fa-plus"></i> Send Message</a>
            </div>
			</div>
        </div>
    </div>
</div>



</body>
</html>
<script>
var friendid ="";
window.onload=baixo();

$("#msg").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#entermsg").click();
    }
});

function baixo(){
     var chat = document.getElementById("chatscro");
     chat.scrollTop = chat.scrollHeight;
}

function open_chat(friend){
	document.getElementById("txtini").style.display = "none";
	document.getElementById("sendmsg").style.visibility = "visible"; 
	friendid = friend;
	$.ajax({
		type: "POST",
		url: "openchat.php",
		data: {friendid:friendid},
		success: function (data) {
			chat_update(data);
		}
	});
}

function chat_newmsg(){
	msg = document.getElementById("msg").value;
	$.ajax({
		type: "POST",
		url: "chatsendmessage.php",
		data: {friendid:friendid,msg:msg},
		success: function (data) {
			 open_chat(data);
		}
	});
}

function chat_update(data){
	document.getElementById("chat").innerHTML = data;
	document.getElementById("msg").value = "";
	baixo();
	
	
}

$(document).ready(function(){

    $('.search-box input[type="text"]').on("keyup input", function(){
        var inputVal = $(this).val();
        if(inputVal.length){
            $.get("chatsearch.php", {term: inputVal}).done(function(data){
				document.getElementById("friendlist").innerHTML = "";
				document.getElementById("friendlist").innerHTML = data;
            });

        } else{
			def = "def";
			$.ajax({
				type: "POST",
				url: "chatsearch.php",
				data: {def:def},
				success: function (data) {
					document.getElementById("friendlist").innerHTML = "";
					document.getElementById("friendlist").innerHTML = data;
				}
			});
        }
    });
});
</script>