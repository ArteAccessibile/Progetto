<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["email"])) {
        session_destroy();
        header("Location: ../index.php");
        exit;
    }

    if(!isset($_POST['new_user_submit'])) {
        require_once "../config.php";
        $page = file_get_contents($html_path . "registrati.html");
        $page = str_replace("<error/>", "<div class=\"errors-forms\"><p> Si è verificato un errore clicca <a href=\"../index.php\">qui</a>  per tornare allla <span lang=\"en\">home</span></p></div>", $page); 
        $page = str_replace("<visibility/>", "<div class=\"nascosto\">", $page);
        echo $page;
        exit;
    }

    require_once "../php/clean-input.php";

    $name = clearInput($_POST['new_user_name']);
    $surname = clearInput($_POST['new_user_surname']);
    $email = clearInput($_POST['new_user_email']);
    $password = clearInput($_POST['new_user_password']);
    $password_confirm = clearInput($_POST['new_user_password_confirm']);
    $role = "utente";

    $error_messages = "";

    if (strlen($name) == 0){
        $error_messages .= '<li>Nome non inserito</li>';
    }

    if (strlen($email) == 0){
        $error_messages .= "<li><span lang=\"en\">Email</span> non inserita</li>";
    }

    if (strlen($password) == 0){
        $error_messages .= "<li><span lang=\"en\">Password</span> non inserita</li>";
    }

    if (strlen($password_confirm) == 0){
        $error_messages .= "<li>Conferma <span lang=\"en\">password</span> non inserita</li>";
    }

    if (strlen($password_confirm) > 0 && $password != $password_confirm){
        $error_messages .= "<li>Le <span lang=\"en\">password</span> non corrispondono</li>";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 0){
        $error_messages .= '<li><span lang=\"en\">Email</span> non valida</li>';
    }

    if (strpos($password, ' ') !== false && strlen($password) > 0){
        $error_messages .= '<li>La <span lang=\"en\">password</span> non può contenere spazi</li>';
    }

    if (strlen($password) < 3 || strlen($password) > 20){
        $error_messages .= '<li>La <span lang=\"en\">password</span> deve essere lunga almeno 3 caratteri e al massimo 20</li>';
    }

    if (preg_match('/[0-9]/', $name) || preg_match('/[0-9]/', $surname)){
        $error_messages .= '<li>Nome e cognome non possono contenere numeri</li>';
    }


    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_messages .= '<li><span lang=\"en\">Email</span> non valida</li>';
    }

    require_once "DBAccess.php";
    use DB\DBAccess;
    if(!strlen($error_messages)){
        $funzioniDB = new DBAccess();
        $conn = $funzioniDB->openDBConnection();
    
        if($conn){
            if(!$funzioniDB->checkEmail($email)) {
                $error_messages .= '<li><span lang=\"en\">Email</span> già in uso</li>';
            }
            else if ($funzioniDB->registerUser($name, $surname, $email, $password, $role)){
                $ok = "Registrazione avvenuta con successo, clicca <a href=\"../index.php\">qui</a> per tornare alla <span lang=\"en\">home</span>.<br/> Oppure clicca <a href=\"../php/login.php\">qui</a> per effettuare l'accesso.";
                require_once "../config.php";
                $page = file_get_contents($html_path . "registrati.html");
                $page = str_replace("<visibility/>", "<div class=\"nascosto\">", $page);
                $page = str_replace("<ok/>", "<p class=\"ok-message\">".$ok."</p>", $page);
                echo $page;
                exit;
            }else {
                $error_messages = "Si è verificato un errore nell'inserimento dei dati, riprova.";
            }
        }else{
            die("Errore nella connessione al <span lang=\"en\">database</span>");
        }
    }
        
    if(strlen($error_messages) > 0){
        require_once "../config.php";
        $page = file_get_contents($html_path . "registrati.html");
        $page = str_replace("<error/>", "<ul class=\"errors-forms\"><ul>" . $error_messages . "</ul></div>", $page);
        $page = str_replace("<visibility/>", "<div>", $page);
        echo $page;
        exit;
    }

?>


