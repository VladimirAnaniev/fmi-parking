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
			<h2>Забравена парола</h2>
			<form autocomplete="off" action="functions/api.php/forgottenpass" method="POST">
				<div class="inputBox">
					<input type="text" name="email" required="">
					<label for="">E-mail</label>
				</div>
				<input type="submit" name="submit" value="Изпрати имейл с нова">
			</form>
		</div>
	</body>
</main>