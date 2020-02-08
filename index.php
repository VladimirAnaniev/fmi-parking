<?php include_once 'views/header.php'; ?>

<?php
require_once 'controllers/ParkingSpotsController.php';

$parking_spots = ParkingSpot::get_all_parking_spots();
$free_spots = ParkingSpotsController::count_free_parking_spots($parking_spots);
?>

<div class="container">
    <?php if (is_logged_in()) { ?>
        <h1>Статус на паркинга</h1>
        <div class="card-deck">
            <?php foreach ($parking_spots as $spot) : ?>
                <div class="card  text-white <?php echo $spot->isFree() ? 'bg-success' : 'bg-danger' ?>">
                    <div class="card-header">Място номер <?php echo $spot->getNumber() ?></div>
                    <div class="card-body">
                        <p class="card-text">
                            <?php if ($spot->isFree()) { ?>
                                Мястото е свободно
                            <?php } else { ?>
                                <p>Заето от <?php echo $spot->getOwner() ?> с номер на колата <?php echo $spot->getCar() ?>. </p>
                                <p>Oт <?php echo $spot->getTimeIn() ?> <?php echo ($spot->getTimeOut() ? "до " . $spot->getTimeOut() : "") ?>.</p>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } else { ?>
        <h1>Добре дошли!</h1>
        <h3>В момента има <?php echo $free_spots ?> свободни места.</h3>
        <h3>За да видите повече детайли или да вдигнете бариерата, моля влезте в профила си.</h3>
    <?php } ?>
</div>

<?php include_once 'views/footer.php'; ?>