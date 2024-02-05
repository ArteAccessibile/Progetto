<?php
    ini_set('display_errors',  TRUE);
    ini_set('display_startup_errors', TRUE);
    error_reporting(E_ALL);

    const ADMIN_ROLE = "admin";
    const ARTIST_ROLE = "artista";
    const USER_ROLE = "utente";

    include ".." . DIRECTORY_SEPARATOR . "config.php";
    include  'DBAccess.php';
    include 'clean-input.php' ;
    use DB\DBAccess;

    $connection = new DBAccess();
    $connectionOk = $connection->openDBConnection();

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }    
    $page = file_get_contents($html_path . "login.html");

    if($connectionOk){
        $email = "";
        $password = "";
        $errorString = "";
        if (isset($_POST['submit-login']) && array_key_exists('email', $_POST) && array_key_exists('password', $_POST)) {        
            $email = clearInput($_POST['email']);
            $password = clearInput($_POST['password']);
                    
            $result = $connection->login($email, $password);
            $isArtista = $connection->isArtista($email);
            
            if ($result->num_rows == 0) {       
                $errorString = "<p class='login-error' tabindex='0'><strong>Username o password non corretti!</strong></p>";
                $connection->closeConnection();
            } else {
                while ($row = $result->fetch_assoc()) {
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["name"] = $row["nome"];
                    echo $row["ruolo"];
                    switch($row["ruolo"]){
                        case ADMIN_ROLE:
                            $_SESSION["role"] = ADMIN_ROLE;
                            break;
                        case USER_ROLE:
                            if($isArtista)
                                $_SESSION["role"] = ARTIST_ROLE;
                            else
                                $_SESSION["role"] = USER_ROLE;
                            break;
                        default:
                            $_SESSION["role"] = "guest";
                            break;
                    }
                }

                $result->free_result();
                $connection->closeConnection();

                if(isset($_SESSION["go_back_page"]))
                    header("Location: " . $_SESSION["go_back_page"]);    
                else             
                    header("Location: ../index.php"); 
                die();
            }
        }
    }
    else {
        $errorString = "<p class='login-error' tabindex='0'><strong> I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</strong></p>";
    }

    $page = str_replace("<error/>", $errorString, $page); 
    echo $page;
?>