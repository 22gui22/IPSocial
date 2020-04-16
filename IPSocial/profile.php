<?php
	session_start();
	require ("mysqli_connect.php");
	
	if(isset($_GET['number'])){
		$number = $_GET['number'];
		$owner = 0;
		
	}else{
		if(isset($_SESSION['number'])){
		$number = $_SESSION['number'];
		$owner = 1;
		}else{
			header('Location: login.php');
		}
	}
	
	if(isset($_SESSION['id'])){
		$userid = $_SESSION['id'];
	}
	
	mysqli_set_charset($conn, 'utf8');
		if($stmt = mysqli_prepare($conn, "SELECT Privacy_Gender, Privacy_BirthDate, Privacy_Post, Privacy_Location FROM privacy, users WHERE Users_Number = ? AND Privacy_Users_Id = Users_Id")) {
			mysqli_stmt_bind_param($stmt, "i", $number);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $privacygender, $privacybirthdate, $privacypost, $privacylocation);
			mysqli_stmt_fetch($stmt);
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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
<?php
	if (isset($_SESSION['active'])){
		echo '<li class="nav-item"><a class="nav-link" href="notifications.php"><img src="images/icons/bell.svg" width="16" height="16"/></a></li>';
	}		  
?>
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
<?php
    mysqli_set_charset($conn, 'utf8');
    if($stmt = mysqli_prepare($conn, "SELECT Users_FirstName, Users_LastName, Users_Gender, Users_ProfileColor, Users_ProfileColor2,Users_Year, EXTRACT(YEAR FROM (FROM_DAYS(DATEDIFF(NOW(),Users_BirthDate)))) , Users_Country, Users_District, Users_City, Users_Photo, School_name, Course_Name FROM users, school, course WHERE Users_Number = ? AND Users_Course_Id = Course_Id AND School_Id = Course_School_Id")) {
		mysqli_stmt_bind_param($stmt, "i", $number);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $name, $lastname, $gender, $pcolor, $pcolor2,$courseyear, $age, $country, $district, $city, $photo, $schoolname, $coursename);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

	if($stmt = mysqli_prepare($conn, "SELECT(SELECT COUNT(Following_Id) FROM users, follows WHERE Users_Id = Following_Id AND Users_Number = ? ), (SELECT COUNT(Follower_Id) FROM users, follows WHERE Users_Id = Follower_Id AND Users_Number = ? )From users, follows;")){
		mysqli_stmt_bind_param($stmt, "ii", $number,$number);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $followers, $following);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	} 

	if(isset($_SESSION['id'])){
		if($stmt = mysqli_prepare($conn, "SELECT count(Following_Id) FROM users,follows WHERE Follower_Id = ? AND Following_Id = Users_Id AND Users_Number = ?")){
			mysqli_stmt_bind_param($stmt, "ii", $userid,$number);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $isfollowing);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
		}
	}
    
?>
<div class="container" id="page" style="background:<?php echo $pcolor; ?> ; width:100%; border-bottom: 10px solid <?php echo $pcolor2; ?> ;border-top: 10px solid <?php echo $pcolor2; ?>;">
<?php 
	if(isset($_SESSION['id'])){
		if($number == $_SESSION['number']){
			$owner = 1;
			echo "<a href='editprofile.php' class='btn btn-info float-right' role='button'><i class='fa fa-edit'></i> Editar</a>"; 
		}
	}
?>

<br>
<br>
<div class="text-center">
   <img src="<?php echo $photo; ?>" class="rounded-circle img-responsive" width="150" height="150">
</div>
<center><h3><b><?php echo $name . " " . $lastname; ?></b></h3></center>
<div class="container" style="width:80%">
	<div class="d-flex flex-row justify-content-center">
  <div class="p-4">
	<tr>
		<tr>
		<td><b>Segue:</b></td>
		<td><?php echo $following; ?></td>
		</tr>
	</tr>
	</div>
	<div class="p-4">
	<tr>
		<tr>
		<td><b>Seguidores:</b></td>
		<td><?php echo $followers; ?></td>
		</tr>
	</div>
	</div>
</div>
<br>
<div class="container" style="width:80%">
<div class="row">
<?php
	if($privacylocation == 1 || ($privacylocation == 2 && $isfollowing > 0) || $owner == 1){
		echo "
		<div class='col-4' align='center'>
			<tr>
			<td><b>Localização:</b></td>
			<td>".$country.", ".$district.", ".$city."</td>
			</tr>
		</div>
		";
	}
	if($privacygender == 1 || ($privacygender == 2 && $isfollowing > 0) || $owner == 1){
		echo "
		<div class='col-4' align='center'>
			<tr>
			<td><b>Genero:</b></td>
			<td>".$gender."</td>
			</tr>
		</div>
		";
	}
	if($privacybirthdate == 1 || ($privacybirthdate == 2 && $isfollowing > 0) || $owner == 1){
		echo "
		<div class='col-4' align='center'>
			<tr>
			<td><b>Idade:</b></td>
			<td>".$age."</td>
			</tr>
		</div>
		";
	}
	echo "
	<div class='col-sm-4' align='center'>
		<tr>
		<td><b>Escola:</b></td>
		<td>".$schoolname."</td>
		</tr>
	</div>
	";
	echo "
	<div class='col-sm-4' align='center'>
		<tr>
		<td><b>Curso:</b></td>
		<td>".$coursename."</td>
		</tr>
	</div>
	";
	echo "
	<div class='col-sm-4' align='center'>
		<tr>
		<td><b>Ano:</b></td>
		<td>".$courseyear."</td>
		</tr>
	</div>
	";
	?>
</div>
</div>
<?php
	if(isset($_SESSION['active'])){
		if ($isfollowing > 0 && $owner != 1){
			echo "<button type='button' class='btn btn-danger float-right' onClick='unfollow($userid,$number)'><i class='fa fa-minus'></i> Deixar de Seguir</button><br>";
		}
		if ($isfollowing == 0 && $owner != 1){
			echo "<button type='button' class='btn btn-success float-right' onClick='follow($userid,$number)'><i class='fa fa-plus'></i> Seguir</button><br>";
		}
	}
?>
<br>
</div>
<br>
<br>

<!-- Modal do gui-->
<?php
	if(isset($_SESSION['number'])){
		echo "<div class='modal' tabindex='-1' role='dialog' id='infoimg'></div>";
	}
?>




<div class="container" style="width:80%">
	<div id="" class="row">
<?php 
	if($privacypost == 1 || ($privacypost == 2 && $isfollowing > 0) || $owner == 1){
		mysqli_set_charset($conn, 'utf8');
			if($stmt = mysqli_prepare($conn, "SELECT Post_Image, Post_Id FROM post,local,users WHERE Post_Id = Local_Post_Id AND Local_Users_Id  = Users_Id AND Users_Number = $number ORDER BY Post_Id Desc")) {
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
		
	}	
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
function follow(id,number){
	$.ajax({
		type: "POST",
		url: "ajaxscripts/followunfollow.php",
		data: {number:number,id:id,follow:"follow"},
		success: function (data) {
			profile_update(data);
		}
	});
}

function unfollow(id,number){
	$.ajax({
		type: "POST",
		url: "ajaxscripts/followunfollow.php",
		data: {number:number,id:id,unfollow:"unfollow"},
		success: function (data) {
			profile_update(data);
		}
	});
}

function profile_update(data){
	document.getElementById("page").innerHTML = data;
}
</script>
</html>
