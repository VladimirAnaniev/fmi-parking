<?php
    if (!isset($_SESSION)) {
      session_start();
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>ФМИ-Паркинг</title>

<!--CSS styles-->
<link rel="stylesheet" href="/styles/style.css">
<link rel="stylesheet" href="/styles/form.css"?>">
<link rel="stylesheet" href="/styles/navbar.css"?>">
<link rel="stylesheet" href="/styles/radioButton.css"?>">

</head>
<body>
<header>
<nav class="navbar">
  <a href="/index.php">Начало</a>
  
  <?php if(isset($_SESSION['u_id'])) { //if logged?>   
    <?php  if($_SESSION['u_role'] == 'admin') {//if logged as admin?>
        <div class="dropdown">
          <button class="dropbtn">Администрация 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="/views/register.php">Добавяне на преподавател</a>
            <a href="/views/changestatus.php">Промяна на статус</a>
            <a href="/views/addcourse.php">Добавяне на курс</a>
          </div>
        </div> 
    
    <?php } //if logged as teacher?>
    <a href="/views/generatecode.php">Генериране на пропуск</a>
    <div class="right">
      <div class="dropdown">
        <button class="dropbtn"><?php echo $_SESSION['u_first'], ' ', $_SESSION['u_last']; ?> </button>
        <div class="dropdown-content">
          <a href="/views/changePass.php">Смяна на парола</a>
          <a href="/controllers/api.php/logout">Изход</a>
        </div>
      </div> 
    </div>
    <?php } else { ?>
      <div class="right">
        <a href="/views/login.php"> Вход</a>
      </div>
  <?php } ?>
  <a href="/views/checkcode.php">Вдигане на бариерата</a>
</nav>
</header>
