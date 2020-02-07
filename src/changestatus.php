<?php
    session_start();
    if(!isset($_SESSION['u_id']) || $_SESSION['u_role'] != 'admin') {
        header("Location: index.php?action=notauthorised");
        exit();
    }
    include_once 'header.php';
?>

<form class="form" autocomplete="off" action="functions/api.php/changestatus" method="POST">
	<h1 class="h3 mb-3 font-weight-normal">Промени потребител</h1>

	<div class=form-group>
		<label for="emailInput" class="sr-only">Имейл Адрес</label>
		<input type="email" required name="email" class="form-control" id="emailInput" placeholder="Имелйл Адрес">
    </div>
    <div class=form-group>
        <label class="button-container">
            <input type="radio" checked="checked" name="role" value="permanent">
            Щатен
        </label>
        <label class="button-container">
            <input type="radio" name="role" value="temporary">
            Не щатен
        </label>

        <br/>

        <label class="button-container">
            <input type="radio" name="role" value="admin">
            Администратор
        </label>
        <label class="button-container">
            <input type="radio" name="role" value="blocked">
            Блокиран
        </label>
    </div>

	<input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Промени">
</form>

<?php
    include_once 'footer.php';
?>
