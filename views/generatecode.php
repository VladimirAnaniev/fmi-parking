<?php
    include '../vendor/phpqrcode/qrlib.php';
    
    session_start();

    if(isset($_SESSION['u_id'])) {
        $email = $_SESSION['u_email'];

        $payload = array(
            "id" => $_SESSION['u_id'], 
            "name" => $_SESSION['u_first']." ".$_SESSION['u_last']
        );

        QRcode::png(json_encode($payload));
    } else {
        header("Location: index.php?action=notauthorised");
        exit();
    }
?>