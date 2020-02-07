<?php
	session_start();
	if(!isset($_SESSION['u_id'])) {
		header("Location: index.php?action=notauthorised");
		exit();
	}
    include_once 'header.php';
?>
<main>
	<body>
		<div class="box">
			<h2>Смяна на парола</h2>
			<form autocomplete="off" action="/controllers/api.php/changepass" method="POST">
				<div class="inputBox">
					<input type="password" name="pwd" required="">
					<label for="">Стара парола</label>
                </div>
                <div class="inputBox">
					<input type="password" name="newPwd" required="">
					<label for="">Нова парола</label>
                </div>
                <div class="inputBox">
					<input type="password" name="newPwd2" required="">
					<label for="">Повтори паролата</label>
                </div>
				<input type="submit" name="submit" value="Промени">
			</form>
		</div>
	</body>
</main>