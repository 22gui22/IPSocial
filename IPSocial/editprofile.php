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
	$userid = $_SESSION['id'];
	mysqli_set_charset($conn, 'utf8');
	if($stmt = mysqli_prepare($conn, "SELECT Users_FirstName, Users_LastName,Users_Number,Users_Phone,Users_ProfileColor,Users_ProfileColor2, Users_Gender,Users_Year,Users_BirthDate , Users_Country, Users_District, Users_City, School_Id, Course_Id FROM users, school, course WHERE Users_Id = ? AND Users_Course_Id = Course_Id AND School_Id = Course_School_Id")) {
			mysqli_stmt_bind_param($stmt, "i", $userid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $name, $lastname, $number, $phone, $color, $color2, $gender, $courseyear, $bday, $country, $district, $city, $schoolid, $courseid);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }
?>
<div class="container" style="width:80%">
<form method="post" action="editprofileupload.php">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>Nome</label>
      <input class="form-control" type="text" value="<?php echo $name;?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label>Apelido</label>
      <input class="form-control" type="text" value="<?php echo $lastname;?>" readonly>
    </div>
  </div>
  <div class="form-row">
	<div class="form-group col-md-4">
		<label>Pais</label>
		<input class="form-control" type="text" value="<?php echo $country;?>" readonly>
	</div>
	<div class="form-group col-md-4">
		<label>Distrito</label>
		<input class="form-control" type="text" value="<?php echo $district;?>" readonly>
	</div>
	<div class="form-group col-md-4">
		<label>Cidade</label>
		<input class="form-control" type="text" value="<?php echo $city;?>" readonly>
	</div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
		<label>Nº de Aluno</label>
      <input class="form-control" type="number" value="<?php echo $number;?>" readonly>
    </div>
    <div class="form-group col-md-4">
		<label>Data de Nascimento</label><br>
		<input class="form-control" type="date" name="bday" id="bday" value="<?php echo $bday;?>" required>
    </div>
	<div class="form-group col-md-4">
		<label>Género</label><br>
			<div class="form-check form-check-inline" required>
				<input class="form-check-input" type="radio" name="gender" id="gender" value="M" <?php if($gender == 'M'){echo 'checked';}?>>
				<label class="form-check-label" for="inlineRadio1">M&nbsp;&nbsp;</label>
				<input class="form-check-input" type="radio" name="gender" id="gender" value="F" <?php if($gender == 'F'){echo 'checked';}?>>
				<label class="form-check-label" for="inlineRadio1">F</label>
			</div>
	</div>
  </div>
  <div class="form-group">
    <div class="form-row">
		<div class="form-group col-md-4">
			<label>Escola</label>
			<select class="form-control" id="escola" name ="escola" onchange="Curso()" required>
			<?php
			mysqli_set_charset($conn, 'utf8');
				if($stmt = mysqli_prepare($conn, "SELECT School_Id, School_Name FROM school")) {
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $schoolidtemp, $schoolnametemp);
					while(mysqli_stmt_fetch($stmt)){
						if($schoolidtemp == $schoolid){
							echo "<option value='$schoolidtemp' selected='selected'>$schoolnametemp</option>";
							$defschool = $schoolidtemp;
						}else{
							echo "<option value='$schoolidtemp'>$schoolnametemp</option>";
						}
					}
					mysqli_stmt_close($stmt);
				}
				?>
			</select>
		</div>
		<div class='form-group col-md-4'>
			<label>Curso</label>
			<select class='form-control' id='curso' name ='curso' onchange='Ano()' required>
			<?php
			mysqli_set_charset($conn, 'utf8');
				if($stmt = mysqli_prepare($conn, "SELECT Course_Id, Course_Name, Course_Year FROM course WHERE Course_School_Id = ?")) {
					mysqli_stmt_bind_param($stmt, "i", $defschool);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $courseidtemp, $coursenametemp, $courseyeartemp);
					while(mysqli_stmt_fetch($stmt)){
						if($courseidtemp == $courseid){
							echo "<option value='$courseidtemp' selected='selected'>$coursenametemp</option>";
							$defcourseyear = $courseyeartemp;
						}else{
							echo "<option value='$courseidtemp'>$coursenametemp</option>";
						}
					}
					mysqli_stmt_close($stmt);
				}
			?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label>Ano de Curso</label>
			<select class="form-control" id="ano" name ="ano" required>
			<?php
				for ($i=1;$i<=$defcourseyear;$i++){
					if($i == $courseyear){
						echo "<option value='$i' selected='selected'>$i Ano</option>";
					}else{
						echo "<option value='$i'>$i Ano</option>";
					}
				}
			?>
			</select>
		</div>
	</div>
  <div class="form-row">
    <div class="form-group col-md-4">
		<label>Cor de perfil</label>
		<select class="form-control" name="pcolor" required>
		<option value="IndianRed" <?php if($color == "IndianRed"){echo "selected='selected'";}?>>Vermelho</option>
		<option value="Gold" <?php if($color == "Gold"){echo "selected='selected'";}?>>Amarelo</option>
		<option value="LightGreen" <?php if($color == "LightGreen"){echo "selected='selected'";}?>>Verde</option>
		<option value="DarkTurquoise" <?php if($color == "DarkTurquoise"){echo "selected='selected'";}?>>Azul</option>
		<option value="Orange" <?php if($color == "Orange"){echo "selected='selected'";}?>>Laranja</option>
		<option value="Pink" <?php if($color == "Pink"){echo "selected='selected'";}?>>Rosa</option>
		</select>
    </div>
	<div class="form-group col-md-4">
		<label>Cor das bordas do perfil</label>
		<select class="form-control" name="pcolor2" required>
		<option value="LightCoral" <?php if($color2 == "LightCoral"){echo "selected='selected'";}?>>Vermelho</option>
		<option value="GoldenRod" <?php if($color2 == "GoldenRod"){echo "selected='selected'";}?>>Amarelo</option>
		<option value="LawnGreen" <?php if($color2 == "LawnGreen"){echo "selected='selected'";}?>>Verde</option>
		<option value="CornflowerBlue" <?php if($color2 == "CornflowerBlue"){echo "selected='selected'";}?>>Azul</option>
		<option value="DarkOrange" <?php if($color2 == "DarkOrange"){echo "selected='selected'";}?>>Laranja</option>
		<option value="HotPink" <?php if($color2 == "HotPink"){echo "selected='selected'";}?>>Rosa</option>
		</select>
    </div>
	<div class="form-group col-md-4">
		<label>Nº de Telemovel</label>
      <input class="form-control" type="text" name="phone" value="<?php echo $phone;?>" required>
    </div>
  </div>
  <button type="submit" name="submit" id="submit" class="btn btn-primary">Guardar</button>
  <a href='changeprofilephoto.php' class='btn btn-primary float-right' role='button'>Alterar foto de perfil</a>
</form>

</div>






</body>
</html>
<script language="javascript">
function Curso(){
	var selector = document.getElementById('escola');
    var school = selector[selector.selectedIndex].value;

	$.ajax({
		type: "POST",
		url: "ajaxscripts/courseyear.php",
		data: {school:school,coursepls:"coursepls"},
		success: function (data) {
			document.getElementById("curso").innerHTML = data;
			Ano();
		}
	});
}
function Ano(){
	var select = document.getElementById('curso');
    var course = select[select.selectedIndex].value;

	$.ajax({
		type: "POST",
		url: "ajaxscripts/courseyear.php",
		data: {course:course,yearpls:"yearpls"},
		success: function (data) {
			document.getElementById("ano").innerHTML = data;
		}
	});
}

$('#openuploaded_file').click(function(){ $('#uploaded_file').trigger('click'); });

function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

				document.getElementById("uploaded_file").style.display = "none";
				document.getElementById("openuploaded_file").style.display = "none";
				document.getElementById("cont").style.display = "none";
				document.getElementById("foto").style.display = "block"; 
				
                reader.onload = function (e) {
                    $('#foto')
                        .attr('src', e.target.result)
                        .width(350)
                        .height(350);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>