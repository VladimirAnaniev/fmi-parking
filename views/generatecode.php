<?php
    include '../vendor/phpqrcode/qrlib.php';
    
    session_start();

    if(isset($_SESSION['u_id'])) {
        $email = $_SESSION['u_email'];
        QRcode::png(json_encode(array("id" => $_SESSION['u_id'])));
    } else {
        header("Location: index.php?action=notauthorised");
        exit();
    }
?>