<?php
	session_start();
	require ("mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
	$id = $_POST['postid'];
	$comment = $_POST['comment'];
	$userid = $_SESSION['id'];
	$commentlist = "";
			if($stmt = mysqli_prepare($conn, "INSERT INTO comments (Comments_Date, Comments_Comment, Comments_Post_Id, Comments_Users_Id) VALUES(NOW(),?,?,?)")){
				mysqli_stmt_bind_param($stmt,"sii", $comment, $id, $userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);			
			}
			
			if($stmt = mysqli_prepare($conn, "SELECT Post_Users_Id, Post_Image FROM post WHERE Post_Id = ?")){
				mysqli_stmt_bind_param($stmt, "i", $id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $postuserid, $postimg);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
			}
			if($postuserid != $userid){
				$str = " comentou do teu post";
				if($stmt = mysqli_prepare($conn, "INSERT INTO notifications (Notifications_Content, Notifications_Photo, Notifications_date, Notifications_Sender_Id, Notifications_Receiver_Id) VALUES(?,?,NOW(),?,?)")){
				mysqli_stmt_bind_param($stmt,"ssii", $str, $postimg, $userid, $postuserid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);			
				}
			}
			
			if($stmt = mysqli_prepare($conn, "SELECT Users_Number, Users_Firstname, Users_Lastname, Comments_Comment FROM comments, users WHERE Users_Id = Comments_Users_Id AND Comments_Post_Id = ? ORDER BY Comments_Id ASC")){
				mysqli_stmt_bind_param($stmt, "i", $id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $tempusernumber,$tempfirstname,$templastname, $comment);
				while(mysqli_stmt_fetch($stmt)){
					$commentlist .= "<p align='left'><b><a href='profile.php?number=$tempusernumber'>$tempfirstname $templastname </a></b>$comment</p>";
				}
				mysqli_stmt_close($stmt);
			}
		mysqli_close($conn);
		echo $commentlist;
?>
