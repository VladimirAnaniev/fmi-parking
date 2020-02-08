<?php
    include_once 'header.php';
?>

<form class="form" autocomplete="off" action="/controllers/api.php/forgoliftbarierttenpass" method="POST">
	<h1 class="h3 mb-3 font-weight-normal">Вдигане на бариерата</h1>

	<label for="emailInput" class="sr-only">Имейл Адрес</label>
	<input type="email" required name="email" class="form-control" id="emailInput" placeholder="Имелйл Адрес">

	<input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Вдигни Бариерата">
</form>

<?php
    include_once 'footer.php';
?>