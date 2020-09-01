<?php
	session_start();
	require ("mysqli_connect.php");
	mysqli_set_charset($conn, 'utf8');
	$id = $_POST['id'];
	$userid = $_SESSION['id'];
	$commentlist = "";
	
			if($stmt = mysqli_prepare($conn, "SELECT Users_Photo, Users_Firstname, Users_Lastname, Users_Id FROM users, post WHERE Users_Id = Post_Users_Id AND Post_Id = ? ")){
				mysqli_stmt_bind_param($stmt, "i", $id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $postuserphoto, $postfirstname, $postlastname, $postuserid);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
			}
			//var_dump(mysqli_prepare($conn, "SELECT Post_Id, Post_Image, Post_Description, COUNT(Likes_Post_Id), (SELECT COUNT(Likes_Users_Id) FROM likes WHERE Likes_Users_Id = ? AND Likes_Post_Id = ? ) FROM post, likes WHERE Post_Id = ? AND Likes_Post_Id = ? "));
			if($stmt = mysqli_prepare($conn, "SELECT Post_Id, Post_Image, Post_Description FROM post WHERE Post_Id = ? ")){
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $postid, $postimage, $postdescription);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
            }
            if($stmt = mysqli_prepare($conn, "SELECT COUNT(Likes_Post_Id), (SELECT COUNT(Likes_Users_Id) FROM likes WHERE Likes_Users_Id = ? AND Likes_Post_Id = ? ) FROM post, likes WHERE Post_Id = ? AND Likes_Post_Id = ? ")){
                mysqli_stmt_bind_param($stmt, "iiii", $userid, $id, $id, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $likes, $wasliked);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
            }
			if($wasliked > 0){
				$likebutton = "<button class='btn' type='button' name='$wasliked' onclick='like_add($postid,this.id)' id='like'><i class='fas fa-thumbs-up'></i></button>";
			}else{
				$likebutton = "<button class='btn' type='button' onclick='like_add($postid,this.id)' id='unlike'><i class='far fa-thumbs-up'></i></button>";
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
			$modal = "<div class='modal-dialog modal-lg' role='document'><div class='modal-content'><div class='modal-header'><div class='container' align='left'><p style='float: left;padding-right: 2%;'><img src='$postuserphoto' class='rounded-circle img-responsive' width='40' height='40' ></p><h6 style='padding-top: 2%;'><b>$postfirstname $postlastname</b></h6></div><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><div class='modal-body'><img class='img-fluid img-thumbnail img-responsive' href='#' data-toggle='modal' data-target='#postmodal' style='max-width: 100%;height: auto;' src='$postimage' style='width:350px; height:350px' alt=''></center><div class='container' align='left'><div id='likebuttondiv$postid'>$likebutton</div><p align='left'><b id='likecount$postid'>$likes pessoas gostam disto</b></p></div><div class='container'><p align='left'>$postdescription</p></div><div class='container' align='left'><div id='commentlistdiv'>$commentlist</div>    
	
	<div class='input-group mb-3'>
  <input type='text' class='form-control' id='addcomment' placeholder='Escreve o teu commentario..'>
  <div class='input-group-append'>
    <button class='btn' type='button' id='btnsubmitcomment' onclick='comment_add($postid)'><i class='fas fa-share-square'></i></button>
  </div>
</div>

    </div></div></div></div>";
			
				
				echo $modal;
				
		mysqli_close($conn);
?>
