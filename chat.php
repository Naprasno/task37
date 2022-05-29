<?php 
  session_start();

  if (isset($_SESSION['username'])) {

  	include 'app/db.conn.php';
  	include 'app/helpers/conversations.php';
	include 'app/helpers/last_chat.php';
  	include 'app/helpers/user.php';
  	include 'app/helpers/chat.php';
  	include 'app/helpers/opened.php';

  	include 'app/helpers/timeAgo.php';

$user = getUser($_SESSION['username'], $conn);

$conversations = getConversation($user['user_id'], $conn);

  	$chatWith = getUser($_GET['user'], $conn);

  	$chats = getChats($_SESSION['user_id'], $chatWith['user_id'], $conn);

  	opened($chatWith['user_id'], $conn, $chats);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Task 37 Chat App</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" 
	      href="css/style.css">
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>


<div class = "content"> 

<div class ="left_block"> 
	<ul id="chatList" class="">
	<?php if (!empty($conversations)) { ?>
			<?php 
			foreach ($conversations as $conversation){ ?>
			<li class="list-group-item list">
				<a href="chat.php?user=<?=$conversation['username']?>"
				class="d-flex
						justify-content-between
						align-items-center">
					<div class="d-flex
								align-items-center">
						<img src="uploads/<?=$conversation['p_p']?>"
							class="w-10">
						<span>
						<?php if ($conversation['hidden']>0) { 
										echo ($conversation['name']);
										}
										elseif ($conversation['hidden']==0) {
										echo ($conversation['username']);
										if ($conversation['name'] != '') { 
											echo ('('.$conversation['name'].')');
										}
										}
						?>
			<small>
				<?php 
				//echo lastChat($_SESSION['user_id'], $conversation['user_id'], $conn);
				?>
			</small>
						<span>            	
					</div>
					<?php if (last_seen($conversation['last_seen']) == "Active") { ?>
						<div title="online">
							<div class="online"></div>
						</div>
					<?php } ?>
				</a>
			</li>
			<?php } ?>
		<?php }else{ ?>
			<div class="alert alert-info 
						text-center">
			<i class="fa fa-comments d-block fs-big"></i>
			<a href="home.php" class="">Нет чатов, нажмите здесь для поиска друзей</a>
			</div>
		<?php } ?>
	</ul>
</div>



<div class = "middle_block">		 
    <div class="w-400 p-4 rounded">
    	   <div class="d-flex align-items-center">
			<?php if (!empty($chatWith)) {?>
				<h3 class="display-4 fs-sm m-2">
					Чат с пользователем 
					<?php if ($chatWith['hidden']>0) { 
										echo ($chatWith['name']);
										}
										elseif ($chatWith['hidden']==0) {
										echo ($chatWith['username']);
										if ($chatWith['name'] != '') { 
											echo ('('.$chatWith['name'].')');
										}
										}
					?>
					<br>
					<div class="d-flex
								align-items-center"
							title="online">
						<?php
							if (!empty($chatWith)) {
			
							
							if (last_seen($chatWith['last_seen']) == "Active") {
						?>
							<div class="online"></div>
							<small class="d-block p-1">Online</small>
						<?php }else{ ?>
							<small class="d-block p-1">
								был(а):
								<?=last_seen($chatWith['last_seen'])?>
							</small>
						<?php }} ?>
					</div>
				</h3>
			<?php } ?>
    	   </div>

    	   <div class="p-1 rounded
    	               d-flex flex-column
    	               mt-2 chat-box"
    	        id="chatBox">
    	        <?php if (!empty($chatWith)) {
                     if (!empty($chats)) {
                     foreach($chats as $chat){
                     	if($chat['from_id'] == $_SESSION['user_id'])
                     	{ ?>
						<p class="rtext align-self-end
						        border rounded p-2 mb-1">
						    <?=$chat['message']?> 
						    <small class="d-block">
						    	<?=$chat['created_at']?>
						    </small>      	
						</p>
                    <?php }else{ ?>
					<p class="ltext border 
					         rounded p-2 mb-1">
					    <?=$chat['message']?> 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
					    </small>      	
					</p>
                    <?php } 
                     }	
    	        }else{ ?>
               <div class="alert alert-info 
    				            text-center">
				   <i class="fa fa-comments d-block fs-big"></i>
	               Сообщений еще нет
			   </div>
    	   	<?php } } ?>
    	   </div>
		   <?php if (!empty($chatWith)) { ?>
    	   <div class="input-group mb-3 text">
    	   	   <textarea cols="3"
    	   	             id="message"
    	   	             class="form-control"
						 style="border: none; height: 39px;"></textarea>
    	   	   <button class="btn btn-primary"
    	   	           id="sendBtn"
						style="height: 39px;">
				<img src="uploads/image5.png">
    	   	   </button>
    	   </div>
		   <?php } ?>
    </div>
</div>

<div class = "right_block">
	<div class='right_block_elem'><a href="home.php" class="">Профиль</a></div>
	<div class='right_block_elem'><a href="set_profile.php" class="">Настройки</a></div>
	<div class='right_block_elem'><a href="logout.php" class="">Выход</a></div>	
</div>


</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php if (!empty($chatWith)) {?>
	<script>
		var scrollDown = function(){
			let chatBox = document.getElementById('chatBox');
			chatBox.scrollTop = chatBox.scrollHeight;
		}

		scrollDown();

		$(document).ready(function(){
		
		$("#sendBtn").on('click', function(){
			message = $("#message").val();
			if (message == "") return;

			$.post("app/ajax/insert.php",
				{
					message: message,
					to_id: <?=$chatWith['user_id']?>
				},
				function(data, status){
					$("#message").val("");
					$("#chatBox").append(data);
					scrollDown();
				});
		});

		/** 
		 auto update last seen 
		for logged in user
		**/
		let lastSeenUpdate = function(){
			$.get("app/ajax/update_last_seen.php");
		}
		lastSeenUpdate();
		/** 
		 auto update last seen 
		every 10 sec
		**/
		setInterval(lastSeenUpdate, 1000);

		// auto refresh / reload
		let fechData = function(){
			$.post("app/ajax/getMessage.php", 
				{
					id_2: <?=$chatWith['user_id']?>
				},
				function(data, status){
					$("#chatBox").append(data);
					if (data != "") scrollDown();
					});
		}

		fechData();
		/** 
		 auto update last seen 
		every 0.5 sec
		**/
		setInterval(fechData, 500);
		
		});
	</script>		
<?php } ?>

 </body>
 </html>
<?php
  }else{
  	header("Location: index.php");
   	exit;
  }
 ?>