<?php
    include 'lib/phpqrcode/qrlib.php';
    
    session_start();

    if(isset($_SESSION['u_id'])) {
        $email = $_SESSION['u_email'];
        QRcode::png("http://localhost/project/functions/api.php/checkcode?email=$email");//,'file.png');
        //echo '<img src="file.png" />';
    } else {
    header("Location: index.php?action=notauthorised");
    exit();
}
?>