<?php
    session_start();
    // TODO: we should enable this for external users
    if(!isset($_SESSION['u_id']) || $_SESSION['u_role'] != 'admin') {
        header("Location: index.php?action=notauthorised");
        exit();
    }
    include_once 'header.php';
?>

<form class="form" autocomplete="off" action="functions/api.php/register" method="POST">
	<h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>

	<div class=form-group>
		<label for="emailInput" class="sr-only">Имейл Адрес</label>
		<input type="email" required name="email" class="form-control" id="emailInput" placeholder="Имелйл Адрес">
    </div>
    <div class=form-group>
        <label for="firstNameInput" class="sr-only">Име</label>
		<input type="text" required name="first" class="form-control" id="firstNameInput" placeholder="Име">

        <label for="lastNameInput" class="sr-only">Фамилия</label>
		<input type="text" required name="last" class="form-control" id="lastNameInput" placeholder="Фамилия">
    </div>
        <!-- TODO: Password & repeat password
		<label for="passwordInput" class="sr-only">Парола</label>
		<input type="password" name="pwd" class="form-control" id="passwordInput" placeholder="Парола"> -->
    
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
    </div>

	<input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Регистрация">
</form>

<?php
    include_once 'footer.php';
?>
