<?php
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	require ("mysqli_connect.php");
		if (isset($_POST['submit'])) {
			$email = test_input($_POST['email']);
			$password = md5($_POST['password']);
		
			mysqli_set_charset($conn, 'utf8');
			if($stmt = mysqli_prepare($conn, "SELECT Users_Id, Users_Email, Users_Password, Users_FirstName, Users_LastName, Users_Number FROM users WHERE Users_Email = ? AND  Users_Password = ? ")) {
				mysqli_stmt_bind_param($stmt, "ss", $email, $password);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $userid, $useremail, $userpassword, $userfirstname, $userlastname, $usernumber);
				
				$row = mysqli_stmt_fetch($stmt);
				if($email == $useremail AND $password == $userpassword){	
					if ($row > 0){
						session_start();
						$_SESSION['id'] = $userid;
						$_SESSION['email'] = $_POST['email'];
						$_SESSION['password'] = $_POST['password'];
						$_SESSION['active'] = '1';
						$_SESSION['firstname'] = ucfirst($userfirstname);
						$_SESSION['lastname'] = ucfirst($userlastname);
						$_SESSION['number'] = $usernumber;
						header('Location: index.php');
						 
					}else{
						header('Location: login.php');
					}
					mysqli_stmt_close($stmt);
				}else{
				$wrong = '<div class="alert alert-danger" role="alert">
				<a href="#" class="close"></a>
				<strong>Erro!</strong> Email ou Password encontram-se incorretos!!
				</div>';
				}
			}
			mysqli_close($conn);
		}
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Socialgram</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

</html>
<body>
	<div class="container" style="width:90%; padding-top: 15%">
	<div class="row">
	<div class=" col-md-6">
		 <div class="imgcontainer">
		 <img src="images/logo/instituto.jpg" alt="Avatar" height="250px" width="450px">
	</div>
	</div>
	<div class=" col-md-6">
	<form action="" method = "post">
		<center>
		<h2 style="font-size:45px; color:grey;">IPSocial</h2>
		</center>
			<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" required name="email">
			</div>
			<div class="form-group">
			<label for="pwd">Password:</label>
			<input type="password" class="form-control" id="password" required name="password">
			</div>
<?php if(isset($wrong)) echo $wrong ?>
  <button type="submit" name="submit" value="Send" class="btn btn-info btn-md">Login</button><br>
  <div class="newaccount" style="line-height: 35%"><br>
  <p><a href="register.php">Crir conta</a></p>
  <p><a href="forgotpass.php">Esqueceu-se da password?</a></p>
  </div>
</form> 
</div>
</div>
</div>
</body>