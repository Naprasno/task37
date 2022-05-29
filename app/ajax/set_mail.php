<?php 

session_start();

if (isset($_SESSION['username'])) {

    include '../db.conn.php';
    
    if(isset($_POST['mail_hidden'])){
        $user_id = $_SESSION['user_id'];
        $mail_hidden = $_POST['mail_hidden'];

        $sql = "SELECT * 
        FROM users
        WHERE user_id = ? and name = ''";
        $stmt = $conn->prepare($sql);       
        $stmt->execute([$user_id]);

        if($stmt->rowCount() > 0){
            $em = "Чтобы скрыть почту, должен быть указан ник";
            header("Location: ../../set_profile.php?error=$em&$data");
            exit;
        } else{
            $sql = "UPDATE users
            SET hidden = ? 
            WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$mail_hidden, $user_id]);
            header("Location: ../../set_profile.php");
        }
    
    }

}else {
	header("Location: ../../index.php");
	exit;
}