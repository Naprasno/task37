<?php 

session_start();

if (isset($_SESSION['username'])) {

    include '../db.conn.php';

    if(isset($_POST['name'])){

        $user_id = $_SESSION['user_id'];
        $name = trim($_POST['name']);

        $sql = "SELECT name 
        FROM users
        WHERE name like ? and name != '' ";
        $stmt = $conn->prepare($sql);       
        $stmt->execute([$name]);

        if($stmt->rowCount() > 0){
        $em = "Такой ник ($name) уже используется";
        header("Location: ../../set_profile.php?error=$em&$data");
        exit;
        } else{
            $sql = "UPDATE users
	        SET name = ? 
	        WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $user_id]);
            $em = "Ник изменён";
            header("Location: ../../set_profile.php?error=$em&$data");
        }
    }
}else {
	header("Location: ../../index.php");
	exit;
}