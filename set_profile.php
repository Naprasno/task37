<?php 
  session_start();

  if (isset($_SESSION['username'])) {

  	include 'app/db.conn.php';

  	include 'app/helpers/user.php';

  	$user = getUser($_SESSION['username'], $conn);



?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Task 37 - settings</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" 
	      href="css/style.css">
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="d-flex
             justify-content-center
             align-items-center
             vh-100">
           
    <div class="p-2 w-400
                rounded shadow">
        Настройки профиля 
    	<div>
    		<div class="d-flex
    		            mb-3 p-3 bg-light
			            justify-content-between
			            align-items-center">
    			<div class="d-flex
    			            align-items-center">
    			    <img src="uploads/<?=$user['p_p']?>"
    			         class="w125 rounded-circle">
					<h3 class="fs-xs m-2"><?=$user['username']?></h3>
                    <?php if ($user['name'] != '') { 
										echo ('('.$user['name'].')');
										}?>
				</div>
				<div>
    			<a href="logout.php"
    			   class="btn btn-dark btnhome">Выход</a> <br><br>
				<a href="home.php"
    			   class="btn btn-dark btnhome">Профиль</a><br><br>
                <a href="chat.php"
    			   class="btn btn-dark btnhome">Чаты</a>
  				</div>
    		</div>
            <?php if (isset($_GET['error'])) { ?>
	 		<div class="alert alert-warning" role="alert">
			  <?php echo htmlspecialchars($_GET['error']);?>
			</div>
			<?php } ?>
            <form method="post"
              action="app/ajax/set_mail.php">
              <label class="form-label">
              <h5>Скрыть почту</h5></label> 
              <?php if ($user['hidden']>0) {echo ('(Сейчас ваша почта скрыта)'); }else{echo ('(Сейчас вашу почту видят другие пользователи)');} ?>
              <p><input name="mail_hidden" type="radio"<?php if($user['hidden']== 1) echo "checked";?> value="1">Да</p>
              <p><input name="mail_hidden" type="radio"<?php if($user['hidden']== 0) echo "checked";?> value="0">Нет</p>
              <button type="submit" 
                        class="btn btn-primary btnset">
                        Сохранить</button>
            </form> 
            <br>
            
            <form method="post" 
              action="app/ajax/set_name.php">
                <label class="form-label">
                <h5>Изменить ник</h5></label>
                <input type="text" 
                    class="form-control"
                    name="name">
                </div>
                <button type="submit" 
                class="btn btn-primary btnset">
                Сохранить</button>
            </form>
            <br>
    		<div class="input-group mb-3">
                <form method="post" 
                      action="app/ajax/set_img.php"
                      enctype="multipart/form-data">
                        <label class="form-label">
                            <h5>Изменить аватар</h5></label>
                        <input type="file" 
                            class="form-control"
                            name="pp">
                        </div>
                        <button type="submit" 
                        class="btn btn-primary">
                        Загрузить аватар</button>
                </form>
    		</div>
        </div>

	  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>
</html>
<?php
  }else{
  	header("Location: index.php");
   	exit;
  }
 ?>