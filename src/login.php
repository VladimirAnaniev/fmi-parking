<?php
	session_start();
    if(isset($_SESSION['u_id'])) {
        header("Location: index.php?action=notauthorised");
        exit();
    }

    include_once 'header.php';
?>
<main>
	<body>
		<div class="box">
			<h2>Влизане</h2>
			<form autocomplete="off" action="functions/api.php/login" method="POST">
				<div class="inputBox">
					<input type="text" name="email" required="">
					<label for="">E-mail</label>
				</div>
				<div class="inputBox">
					<input type="password" name="pwd" required="">
					<label for="">Парола</label>
				</div>
				<input type="submit" name="submit" value="Вход">
			</form>
			<a class="nostyle" href="forgottenPass.php">Забравена парола?</a><
		</div>
	</body>
</main>