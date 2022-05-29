<?php  
session_start();

if(isset($_POST['username']) &&
   isset($_POST['password'])){

   include '../db.conn.php';
   
   $password = $_POST['password'];
   $username = mb_strtolower(trim($_POST['username']));
   
   if(empty($username)){
      $em = "Почта не указана";
      
      header("Location: ../../index.php?error=$em");
   }else if(empty($password)){

      $em = "Пароль не указан";

      header("Location: ../../index.php?error=$em");
   }else {
      $sql  = "SELECT * FROM 
               users WHERE username=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$username]);

      if($stmt->rowCount() === 1){
        $user = $stmt->fetch();

        if ($user['username'] === $username) {
           
          if (password_verify($password, $user['password'])) {

            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['user_id'];

            header("Location: ../../chat.php?user=");

          }else {
            $em = "Неверная почта или пароль";
            header("Location: ../../index.php?error=$em");
          }
        }else {
          $em = "Неверная почта или пароль";

          header("Location: ../../index.php?error=$em");
        }
      }
      else {
        $em = "Неверная почта или пароль";

        header("Location: ../../index.php?error=$em");
      }
   }
}else {
  header("Location: ../../index.php");
  exit; 
}