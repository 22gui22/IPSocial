<?php
    require ("mysqli_connect.php");
	session_start();
		$userid = $_SESSION['id'];
    
	if(isset($_POST['def'])){
			echo"<br>";
			if($stmt = mysqli_prepare($conn, "SELECT * FROM (SELECT Users_Id FROM follows, users WHERE Following_Id = $userid AND Follower_Id = Users_Id) AS A JOIN (SELECT Users_FirstName,Users_Lastname,Users_Number,Users_Photo,Users_Id FROM follows, users WHERE Follower_Id = $userid AND Following_Id = Users_Id) AS B On A.Users_Id = B.Users_Id")) {
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
		
		
	}

    if(isset($_REQUEST['term'])){
		$term = $_REQUEST['term'];
		echo"<br>";
        if($stmt = mysqli_prepare($conn, "SELECT * FROM (SELECT Users_Id FROM follows, users WHERE Following_Id = $userid AND Follower_Id = Users_Id) AS A JOIN (SELECT Users_FirstName,Users_LastName,Users_Number,Users_Photo,Users_Id FROM follows, users WHERE Follower_Id = $userid AND Following_Id = Users_Id) AS B On A.Users_Id = B.Users_Id WHERE Users_FirstName LIKE '%$term%' OR Users_LastName LIKE '%$term%' OR CONCAT(Users_FirstName,' ' ,Users_LastName) LIKE '%$term%'")){
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_bind_result($stmt, $searchuserid, $firstname,$lastname,$number,$photo, $searchuserid);
					while(mysqli_stmt_fetch($stmt)){
						echo "
					<div class='media conversation'>
					<button onclick='open_chat($searchuserid)' style='border: none;background-color: transparent;outline: none;'>
						<div class='row align-items-center'>
						<div class='col-4'>
						<a class='pull-left'>
							<img class='media-object' align='left' style='width: 50px; height: 50px;' src='$photo'>
						</a>
						</div>
						<div class='col-8'>
						<div class='media-body'>
							<font size='3' align='right'>$firstname $lastname</font>
							<small align='right'>$number</small>
						</div>
						</div>
						</div>
					</button>
					</div><br>
					";
					}
				}
		}
		mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
?>


