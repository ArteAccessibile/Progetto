<?php
//serve il bottone di login / logout
    const GUEST_ROLE = "guest";

    
    $logoutPath = "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "logout.php";
    $accountPath = "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "account.php";
    $logout_ref = "<li> <a href=\"" . $logoutPath . "\" tabindex='0'> Logout </a> </li><li> <a href=\"" . $accountPath . "\" tabindex='0'> Gestisci Account </a></li>";
    
    $loginPath = "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "login.php";
    $login_ref = "<li><a href=\"" . $loginPath . "\" tabindex='0'>Accedi</a></li>";

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