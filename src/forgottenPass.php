<?php
	session_start();
	if(isset($_SESSION['u_id'])) {
		header("Location: index.php?action=notauthorised");
		exit();
	}
    include_once 'header.php';
?>

<form class="form" autocomplete="off" action="functions/api.php/forgottenpass" method="POST">
	<h1 class="h3 mb-3 font-weight-normal">Забравена парола</h1>

	<label for="emailInput" class="sr-only">Имейл Адрес</label>
	<input type="email" required name="email" class="form-control" id="emailInput" placeholder="Имелйл Адрес">

	<input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Изпрати имейл">
</form>

<?php
    include_once 'footer.php';
?>
