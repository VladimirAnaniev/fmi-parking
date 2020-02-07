<?php
    session_start();
    if(!isset($_SESSION['u_id']) || $_SESSION['u_role'] != 'admin') {
        header("Location: index.php?action=notauthorised");
        exit();
    }
include_once('header.php')
?>

<main>
    <div class="box">
		<h2>Промяна в статуса на потребител</h2>
        <form autocomplete="off" action="/controllers/api.php/changestatus" method="POST">
            <div class="inputBox">
				<input type="text"    name="email" required="">
				<label for="">E-mail</label>
            </div>
            <label class="button-container">Щатен
                <input type="radio" checked="checked" name="role" value="permanent">
                <span class="checkmark"></span>
            </label>
            <label class="button-container">Не щатен
                <input type="radio" name="role" value="temporary">
                <span class="checkmark"></span>
            </label>
            <label class="button-container">Администратор
                <input type="radio" name="role" value="admin">
                <span class="checkmark"></span>
            </label> 
            <label class="button-container">Блокиран
                <input type="radio" name="role" value="blocked">
                <span class="checkmark"></span>
            </label>
			<input type="submit" name="submit" value="Промени">
		</form>
    </div>
</main>

<?php
include_once('footer.php')
?>