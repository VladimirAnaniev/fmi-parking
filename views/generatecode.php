<?php
    include '../vendor/phpqrcode/qrlib.php';
    
    session_start();

    if(isset($_SESSION['u_id'])) {
        $email = $_SESSION['u_email'];

        $payload = array(
            "id" => $_SESSION['u_id'], 
            "name" => $_SESSION['u_first']." ".$_SESSION['u_last']
        );

        QRcode::png(json_encode($payload), false, QR_ECLEVEL_L, 10);
    } else {
        header("Location: index.php?action=notauthorised");
        exit();
    }
?>