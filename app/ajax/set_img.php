<?php 
  session_start();

  if (isset($_SESSION['username'])) {

	include '../db.conn.php';

    $username = $_SESSION['username'];


    $user_id = $_SESSION['user_id'];
    
      if (isset($_FILES['pp'])) {
        $img_name  = $_FILES['pp']['name'];
        $tmp_name  = $_FILES['pp']['tmp_name'];
        $error  = $_FILES['pp']['error'];

        if($error === 0){
         
          $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);

          $img_ex_lc = strtolower($img_ex);

          $allowed_exs = array("jpg", "jpeg", "png");

          if (in_array($img_ex_lc, $allowed_exs)) {

              $new_img_name = $username. '.'.$img_ex_lc;

              $img_upload_path = '../../uploads/'.$new_img_name;

              move_uploaded_file($tmp_name, $img_upload_path);
              
          }else {
              $em = "не подходящий тип файла";
                header("Location: ../../set_profile.php?error=$em&$data");
                 exit;
          }

        }
    }
  }
  if (isset($new_img_name)) {

    $sql = "UPDATE users
	        SET p_p = ? 
	        WHERE user_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$new_img_name, $user_id]);
    $em = "Аватар изменён";
    header("Location: ../../set_profile.php?error=$em&$data");
  }

?>