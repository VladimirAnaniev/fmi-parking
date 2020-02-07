<?php
    include_once 'header.php';
?>
<main>
	<body>
		<div class="box">
			<h2>Вдигане на бариерата</h2>
			<form autocomplete="off" action="/controllers/api.php/liftbarier" method="POST">
				<div class="inputBox">
					<input type="text" name="email" required="">
					<label for="">E-mail</label>
				</div>
				<input type="submit" name="submit" value="Провери">
			</form>
		</div>
	</body>
</main>