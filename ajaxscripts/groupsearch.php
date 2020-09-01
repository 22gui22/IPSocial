<?php
    require ("../mysqli_connect.php");

    
	if(isset($_POST['def'])){
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
		
		
	}

    if(isset($_REQUEST['term'])){
		$search = $_REQUEST['term'];
		mysqli_set_charset($conn, 'utf8');
        if($stmt = mysqli_prepare($conn, "SELECT Groups_Id, Groups_Name, Groups_Photo From groups, groupmembers WHERE Groups_Name LIKE '%$search%' GROUP BY Groups_Id ORDER BY COUNT(Groupmembers_Follower_Id) DESC ")) {
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
    }
     
    mysqli_close($conn);
?>


