<?php
if (!isset($_SESSION)) {
    session_start();
}

// TODO: extract those in a separate php file
function is_logged_in() {
    return isset($_SESSION['u_id']);
}

function is_admin() {
    return $_SESSION['u_role'] == 'admin';
}

function get_greeting() {
    return $_SESSION['u_first'] . ' ' . $_SESSION['u_last'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ФМИ Паркинг</title>

    <link rel="stylesheet" href="/styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/index.php">ФМИ Паркинг</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                <?php if(is_logged_in()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/generatecode.php">Генериране на пропуск</a>
                    </li>

                    <?php if (is_admin()) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Администрация
                            </a>
                            <div class="dropdown-menu" aria-labelledby="adminDropdown">
                                <a class="dropdown-item" href="/views/register.php">Добавяне на преподавател</a>
                                <a class="dropdown-item" href="/views/changestatus.php">Промяна на статус</a>
                                <a class="dropdown-item" href="/views/addcourse.php">Добавяне на курс</a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/views/listcourses.php">Моите курсове</a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>

            <ul class="navbar-nav">
                <?php if (is_logged_in()) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo get_greeting(); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="/views/changepass.php">Смяна на парола</a>
                            <a class="dropdown-item" href="/controllers/api.php/logout">Изход</a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/login.php">Вход</a>
                    </li>
                    <li class="nav-item mr-1">
                        <a class="nav-link" href="/views/register.php">Регистрация</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>
<main>
