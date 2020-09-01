<?php
	session_start();
	require ("mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
	function test_input($data) {
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	$friendid = $_POST['friendid'];
	$msg = test_input($_POST['msg']);
	$userid = $_SESSION['id'];
			if($stmt = mysqli_prepare($conn, "INSERT INTO chat (Chat_Message, Chat_Date, Chat_Sender_Id, Chat_Receiver_Id) VALUES(?,NOW(),?,?)")){
				mysqli_stmt_bind_param($stmt,"sii", $msg, $userid, $friendid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);				
			}
		mysqli_close($conn);
		echo $friendid;
?>
