<?php
//serve il bottone di login / logout
    const GUEST_ROLE = "guest";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $path_prefix = "";
    if (isset($_SESSION["nav_page"]) && $_SESSION["nav_page"]=="home"){
        $path_prefix = "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR;
    }
    
    $logoutPath = $path_prefix . "logout.php";
    $accountPath = $path_prefix . "account.php";
    $logout_ref = "<li class> <a href=\"" . $logoutPath . "\"> Logout </a> </li><li> <a href=\"" . $accountPath . "\" > Gestisci <span lang=\"en\"> Account</span> </a></li>";
    
    $loginPath = $path_prefix . "login.php";
    $login_ref = "<li><a href=\"" . $loginPath . "\" >Accedi</a></li>";

    $log_status = " ";
    
    if (isset($_SESSION["role"])) {
        $log_status = $_SESSION["role"] == GUEST_ROLE ? $login_ref : $logout_ref;
    } else {
        $_SESSION["role"] = GUEST_ROLE;
        $log_status = $login_ref;
    }
?>