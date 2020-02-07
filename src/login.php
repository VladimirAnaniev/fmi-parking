<?php
	session_start();
    if(isset($_SESSION['u_id'])) {
        header("Location: index.php?action=notauthorised");
        exit();
    }

    include_once 'header.php';
?>

<form class="form" autocomplete="off" action="functions/api.php/login" method="POST">
	<h1 class="h3 mb-3 font-weight-normal">Влезте в профила си</h1>

	<div class=form-group>
		<label for="emailInput" class="sr-only">Имейл Адрес</label>
		<input type="email" required name="email" class="form-control grouped" id="emailInput" placeholder="Имелйл Адрес">

		<label for="passwordInput" class="sr-only">Парола</label>
		<input type="password" required name="pwd" class="form-control" id="passwordInput" placeholder="Парола">
	</div>

	<input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Вход">

	<a class="nostyle" href="forgottenPass.php">Забравена парола?</a>
</form>

<?php
    include_once 'footer.php';
?>
