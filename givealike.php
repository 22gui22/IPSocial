<?php
	session_start();
	require ("mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
	$id = $_POST['postid'];
	$wtd = $_POST['state'];
	$userid = $_SESSION['id'];
	
			if($stmt = mysqli_prepare($conn, "SELECT COUNT(Likes_Post_Id) FROM post, likes WHERE Post_Id = ? AND Likes_Post_Id = Post_Id AND Likes_Users_Id = ?")){
				mysqli_stmt_bind_param($stmt, "ii", $id, $userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $wasliked);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
			}
	
			if($wasliked <= 0){
				
				if($stmt = mysqli_prepare($conn, "INSERT INTO likes (Likes_Users_Id, Likes_Post_Id) VALUES(?,?)")){
				mysqli_stmt_bind_param($stmt,"ii", $userid, $id);
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
					$str = " gostou do teu post";
					if($stmt = mysqli_prepare($conn, "INSERT INTO notifications (Notifications_Content, Notifications_Photo, Notifications_date, Notifications_Sender_Id, Notifications_Receiver_Id) VALUES(?,?,NOW(),?,?)")){
					mysqli_stmt_bind_param($stmt,"ssii", $str, $postimg, $userid, $postuserid);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);			
					}
				}
				
			}else{
				
				if($stmt = mysqli_prepare($conn, "DELETE FROM likes WHERE Likes_Users_Id = ? And Likes_Post_Id = ?")){
				mysqli_stmt_bind_param($stmt, "ii", $userid, $id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);			
				}
				
			}	
			
			if($stmt = mysqli_prepare($conn, "SELECT COUNT(Likes_Post_Id) FROM post, likes WHERE Post_Id = ? AND Likes_Post_Id = Post_Id ")){
				mysqli_stmt_bind_param($stmt, "i", $id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $likes);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($wasliked <= 0){
				$likebutton = "<button class='btn' type='button' name='$wasliked' onclick='like_add($id,this.id)' id='like'><i class='fas fa-thumbs-up'></i></button>";
			}else{
				$likebutton = "<button class='btn' type='button' onclick='like_add($id,this.id)' id='unlike'><i class='far fa-thumbs-up'></i></button>";
			}
			
			
			echo $likes.",".$likebutton;	
		mysqli_close($conn);
?>