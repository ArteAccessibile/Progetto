<?php
    ini_set('display_errors',  TRUE);
    ini_set('display_startup_errors', TRUE);
    error_reporting(E_ALL);

    const ADMIN_ROLE = "admin";
    const USER_ROLE = "utente";
    const ARTIST_ROLE = "artista";

    include ".." . DIRECTORY_SEPARATOR . "config.php";
    include  'db-connection.php';
    include 'clean-input.php' ;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }    
    $page = file_get_contents($html_path . "login.html");

    $email = "";
    $password = "";
    $errorString = "";
    if (isset($_POST['submit-login']) && array_key_exists('email', $_POST) && array_key_exists('password', $_POST)) {        
        $email = clearInput($_POST['email']);
        $password = clearInput($_POST['password']);
                
        
        $query = "SELECT * FROM `utente` WHERE `email` = '$email' AND `psw` = '$password'";
        
        $result = $mysqli->query($query);
        
        if ($result->num_rows == 0) {       
            $errorString = "<p class='login-error' tabindex='0'><strong>Username o password non corretti!</strong></p>";
            $mysqli->close();
        } else {
            while ($row = $result->fetch_assoc()) {
                $_SESSION["email"] = $row["email"];
                $_SESSION["name"] = $row["nome"];
                echo $row["ruolo"];
                switch($row["ruolo"]){
                    case ADMIN_ROLE:
                        $_SESSION["role"] = ADMIN_ROLE;
                        break;
                    case ARTIST_ROLE:
                        $_SESSION["role"] = ARTIST_ROLE;
                        break;
                    case USER_ROLE:
                        $_SESSION["role"] = USER_ROLE;
                        break;
                    default:
                        $_SESSION["role"] = "guest";
                        break;
                }
            }

            $result->free_result();
            $mysqli->close();

            if (isset($_SESSION["go_back_page"])) {
                header("Location: " . $_SESSION["go_back_page"]); 
            } else {
                // intanto metto questo per vedere se funziona, poi lo cambiamo con la gobackpage consegna, esame
                header("Location: ../html/home.html"); 
            }
            
            die();
        }
    }

    $page = str_replace("<error/>", $errorString, $page); 
    echo $page;
?>
