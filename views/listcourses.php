<?php
    include_once 'header.php';
?>

<?php
    require_once '../models/User.php';
    require_once '../controllers/ParkingDB.php';

    $hasCourses = false;
    $courses = array();

    if (is_logged_in()) {
        $courses = User::getCourses(ParkingDB::getInstance()->getConnection(), $_SESSION['u_id']);
        $hasCourses = sizeof($courses) > 0;
    }
?>

<?php if (is_logged_in() && $hasCourses) { ?>
    <div class="container float-left">
        <h2>Моите Курсове</h2>
        <br>
        <table class="table">
            <thead>
            <tr>
                <th>Име</th>
                <th>Ден</th>
                <th>Времетраене</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= $course->getTitle() ?></td>
                    <td><?= $course->getCourseDay() ?></td>
                    <td>От <?= $course->getCourseFrom() ?> До <?= $course->getCourseTo()?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } else if (is_logged_in() && !$hasCourses) {?>
<div class="alert alert-warning" role="alert">Нямате регистрирани курсове.</div>
<?php } ?>


<?php
    include_once 'footer.php';
?>
