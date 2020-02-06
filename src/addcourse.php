<?php
    session_start();
    if(!isset($_SESSION['u_id']) || $_SESSION['u_role'] != 'admin') {
        header("Location: index.php?action=notauthorised");
        exit();
    }
    include_once ('header.php')
?>

<main>
    <div class="box">
		<h2>Добавяне на курс</h2>
        <form autocomplete="off" action="functions/api.php/addcourse" method="POST">
           	<div class="inputBox">
				<input type="text"    name="email" required="">
				<label for="">E-mail на преподавателя</label>
            </div>
            <div class="inputBox">
				<input type="text"    name="name" required="">
				<label for="">Име на курса</label>
            </div>
            <div class="inputBox">
				<input type="time"    name="from" min="07:15" max="20:15" required="">
				<label for="">Начален час</label>
            </div>
            <div class="inputBox">
				<input type="time"    name="to" min="08:00" max="23:00" required="">
				<label for="">Краен час</label>
            </div>
            
            <label class="button-container">Пн
                <input type="radio" checked="checked" name="day" value="Monday">
                <span class="checkmark"></span>
            </label>
            <label class="button-container">Вт
                <input type="radio" name="day" value="Tuesday">
                <span class="checkmark"></span>
            </label>
            <label class="button-container">Ср
                <input type="radio" name="day" value="Wednesday">
                <span class="checkmark"></span>
            </label>
            <label class="button-container">Чтв
                <input type="radio" name="day" value="Thursday">
                <span class="checkmark"></span>
            </label>
            <label class="button-container">П
                <input type="radio" name="day" value="Friday">
                <span class="checkmark"></span>
            </label>
            <label class="button-container">С
                <input type="radio" name="day" value="Saturday">
                <span class="checkmark"></span>
            </label>
            <label class="button-container">Н
                <input type="radio" name="day" value="Sunday">
                <span class="checkmark"></span>
            </label>

			<input type="submit" name="submit" value="Добавяне">
		</form>
    </div>
</main>

<?php
    include_once ('footer.php')
?>