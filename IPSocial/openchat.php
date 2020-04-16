<?php
	session_start();
	require ("mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
	
	$friendid = $_POST['friendid'];
	$userid = $_SESSION['id'];
	$chat = "";
	$sender = 0;
	$lastdate = date("Y-m-d");		
			if($stmt = mysqli_prepare($conn, "SELECT DISTINCT * FROM (SELECT Chat_Sender_Id, Chat_Message, Chat_Date FROM chat WHERE Chat_Receiver_Id = ? AND Chat_Sender_Id = ? UNION SELECT Chat_Sender_Id, Chat_Message, Chat_Date FROM chat WHERE Chat_Sender_Id = ? AND Chat_Receiver_Id = ?) AS a JOIN (SELECT Users_FirstName,Users_LastName,Users_Photo,Users_Id From users,chat WHERE Users_Id = Chat_Sender_Id) AS b WHERE a.Chat_Sender_Id = b.Users_Id ORDER BY Chat_Date ASC")){
				mysqli_stmt_bind_param($stmt, "iiii", $userid, $friendid, $userid, $friendid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $sender,$message,$date,$firstname,$lastname,$userphoto,$sender);
				while(mysqli_stmt_fetch($stmt)){
					$chat .= "<div id='chatwindow' name='$friendid'>";
					$datee = strtotime($date);
					$dateonly = date( "d/m/Y", $datee);
					$timeonly = date( "H:i:s", $datee);
					if($dateonly != $lastdate){
					  $chat .= "<center>$dateonly</center><hr>";
					}
					$lastdate = $dateonly;
					if($userid == $sender){
						$chat .= "
							<br><div class='row' style='border-radius: 25px;background: rgba(30, 144, 255, .15)'>
								<br><div class='col-1'>
								  <img src='$userphoto' class='rounded-circle' style='width: 50px; height: 50px;'>
								</div>
								<div class='col-5'>
								<b>$firstname $lastname</b><br>
								<p>$message</p>
								</div>
								<div class='col-4'>
								</div>
								<div class='col-1'>
								  <span class='time-right'>$timeonly</span>
								</div>
							</div>
						";
					}else{
						$chat .= "
						<div class='row' style='border-radius: 25px;background: rgba(0, 191, 255, .07)'>
							<div class='col-2'>
							  <span class='time-right'>$timeonly</span>
							</div>
							<div class='col-7 offset-1' style='text-align: right;'>
							<b>$firstname $lastname</b><br>
							<p>$message</p>
							</div>
							<div class='col-md-1' >
								  <img src='$userphoto' class='rounded-circle' style='width: 50px; height: 50px;'>
							</div>
							
						</div>
					";
					}
				}
				mysqli_stmt_close($stmt);
			}
			
		$chat .= "</div>";
		mysqli_close($conn);
		echo $chat;
?>
