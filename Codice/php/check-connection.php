<?php
//serve il bottone di login / logout
    const GUEST_ROLE = "guest";

    
    $logoutPath = "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "logout.php";
    $logout_ref = "<a href=\"" . $logoutPath . "\" tabindex='0'> Logout </a>";
    
    $loginPath = "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "login.php";
    $login_ref = "<a href=\"" . $loginPath . "\" tabindex='0'>Accedi</a>";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $log_status = " ";
    
    if (isset($_SESSION["role"])) {
        $log_status = $_SESSION["role"] == GUEST_ROLE ? $login_ref : $logout_ref;
    } else {
        $_SESSION["role"] = GUEST_ROLE;
        $log_status = $login_ref;
    }

?>