<?php
	require ("mysqli_connect.php");
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	if (isset($_POST['submit'])) {
			$email = test_input($_POST['email']);
			$number = test_input($_POST['number']);
			
			mysqli_set_charset($conn, 'utf8');
			if($stmt = mysqli_prepare($conn, "SELECT Users_Email FROM users WHERE Users_Email = '$email'")) {

				mysqli_stmt_execute($stmt);

				$erro1 = mysqli_stmt_fetch($stmt);
					
				mysqli_stmt_close($stmt);
			}
			if($stmt = mysqli_prepare($conn, "SELECT Users_Number FROM users WHERE Users_Number = '$number'")) {

				mysqli_stmt_execute($stmt);

				$erro2 = mysqli_stmt_fetch($stmt);
					
				mysqli_stmt_close($stmt);
			}
			
		if($erro1 > 0){
			$emailused = '<div class="alert alert-danger" role="alert">
			<a href="#" class="close"></a>
			<strong>Erro!</strong> Email já registado!!
			</div>';
		}else if($erro2 > 0){
			$numberused = '<div class="alert alert-danger" role="alert">
			<a href="#" class="close"></a>
			<strong>Erro!</strong> Número já registado!!
			</div>';
		}else{
			if(isset($_POST['firstname']) && isset($_POST['lastname'])){
				$firstname = test_input($_POST['firstname']);
				$lastname = test_input($_POST['lastname']);
				$country = test_input($_POST['country']);
				$district = test_input($_POST['state']);
				$city = test_input($_POST['cidade']);
				$bday = test_input($_POST['bday']);
				$gender = test_input($_POST['gender']);
				$email = test_input($_POST['email']);
				$phone = test_input($_POST['phone']);
				$number = test_input($_POST['number']);
				$school = test_input($_POST['escola']);
				$course = test_input($_POST['curso']);
				$year = test_input($_POST['ano']);
				$password = md5($_POST['password']);
				$confirmpassword = md5($_POST['confirmpassword']);
				$photo = "images\logo\default.png";
				$pcolor = "Gold";
				$pcolor2 = "GoldenRod";
				if($password == $confirmpassword){
					
					mysqli_set_charset($conn, 'utf8');
						if($stmt = mysqli_prepare($conn, "INSERT INTO users (Users_FirstName, Users_LastName, Users_ProfileColor, Users_ProfileColor2, Users_Country, Users_District, Users_City, Users_BirthDate, Users_Gender, Users_Email, Users_Phone, Users_Number, Users_Password, Users_Photo, Users_Course_Id, Users_Year) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")){
							mysqli_stmt_bind_param($stmt, "ssssssssssiissii", $firstname, $lastname, $pcolor, $pcolor2, $country, $district, $city, $bday, $gender, $email, $phone, $number, $password, $photo, $course,$year);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
						
						$lastid = mysqli_insert_id($conn);
						if($stmt = mysqli_prepare($conn, "INSERT INTO privacy (Privacy_Gender, Privacy_BirthDate,Privacy_Post,Privacy_Location,Privacy_Users_Id) VALUES(1,1,1,1,?)")){
							mysqli_stmt_bind_param($stmt, "i", $lastid);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
						
						mysqli_close($conn);
						header("Location: login.php");
						}
						}
						var_dump(mysqli_prepare($conn, "INSERT INTO users (Users_FirstName, Users_LastName, Users_ProfileColor, Users_ProfileColor2, Users_Country, Users_District, Users_City, Users_BirthDate, Users_Gender, Users_Email, Users_Phone, Users_Number, Users_Password, Users_Photo, Users_Course_Id, Users_Year) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)"));
						var_dump(mysqli_stmt_bind_param($stmt, "ssssssssssiissii", $firstname, $lastname, $pcolor, $pcolor2, $country, $district, $city, $bday, $gender, $email, $phone, $number, $password, $photo, $course,$year));
				}else{
					$passdontmatch = '<div class="alert alert-danger" role="alert">
					<a href="#" class="close"></a>
					<strong>Erro!</strong> Passwords não correspondem!!
					</div>';
				}
			}else{
				header("Location: register.php");
			}
		}
	}	
?>


<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Socialgram</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="js/countries.js"></script>
<br><br><br>
<body>
<div class="container">
	<div class="row">
			<div class=" col-md-6" style="width:90%; padding-top: 2%">
				<div class="imgcontainer">
					<img src="images/logo/instituto.jpg" alt="Avatar" height="250px" width="450px">
				</div>
			</div>
			<div class=" col-md-6" style="width:90% padding-top: 5%;">
			<form action="" method = "post">
				<center>
				<h2 style="font-size:45px; color:grey;">IPSocial</h2>
				</center>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="firstname">Nome:</label>
							<input type="text" class="form-control" id="firstname" required name="firstname">
						</div>
						<div class="form-group col-md-6">
							<label for="lastname">Apelido:</label>
							<input type="text" class="form-control" id="lastname" required name="lastname">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label>Pais</label>
							<select class="form-control" id="country" name ="country"></select>
						</div>
						<div class="form-group col-md-4">
							<label>Distrito</label>
							<select class="form-control" name ="state" id ="state" onchange="javascript:cidades()"></select>
						</div>
						<div class="form-group col-md-4">
							<label>Cidade</label>
							<select class="form-control" name ="cidade" id ="cidade"></select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Data de Nascimento</label><br>
							<input class="form-control" type="date" name="bday" id="bday">
						</div>
						<div class="form-group col-md-6">
						<label>Género</label><br>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" id="gender" value="M"checked>
								<label class="form-check-label" for="inlineRadio1">M&nbsp;&nbsp;</label>
								<input class="form-check-input" type="radio" name="gender" id="gender" value="F">
								<label class="form-check-label" for="inlineRadio1">F</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" required name="email">
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="phone">Número de Telemóvel:</label>
							<input type="text" class="form-control" id="phone" required name="phone">
						</div>
						<div class="form-group">
							<label for="numero">Número de Aluno:</label>
							<input type="number" class="form-control" placeholder="170000000" id="number" required name="number">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label>Escola</label>
							<select class="form-control" id="escola" name ="escola" onchange="Curso()">
							<?php
							mysqli_set_charset($conn, 'utf8');
								if($stmt = mysqli_prepare($conn, "SELECT School_Id, School_Name FROM school")) {
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt, $schoolid, $schoolname);
									while(mysqli_stmt_fetch($stmt)){
										echo "<option value='$schoolid'>$schoolname</option>";
									}
									mysqli_stmt_close($stmt);
								}
							?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label>Curso</label>
							<select class="form-control" id="curso" name ="curso" onchange="Ano()"></select>
						</div>
						<div class="form-group col-md-4">
							<label>Ano de Curso</label>
							<select class="form-control" id="ano" name ="ano">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="password">Password:</label>
							<input type="password" class="form-control" id="password" required name="password">
						</div>
						<div class="form-group col-md-6">
							<label for="password">Confirmar Password:</label>
							<input type="password" class="form-control" id="confirmpassword" required name="confirmpassword">
						</div>
					</div>
				<p>Ao se registar concorda com os nossos <a href="terms.php">Termos e Condições</a></p>
				<?php if(isset($emailused)) echo $emailused ?>
				<?php if(isset($numberused)) echo $numberused ?>
				<?php if(isset($passdontmatch)) echo $passdontmatch ?>
				<button type="submit" name="submit" value="Send" class="btn btn-info btn-md">Registar</button>
		</form> 
		</div>
	</div>
</div>
</body>
</html>
<script>
populateCountries("country", "state", "cidade");
$('#escola').change(Curso());
$('#curso').change(Ano());
	
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
</script>