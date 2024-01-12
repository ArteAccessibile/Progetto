<?php

class UserController extends Controller{
    public function login() {
        $message = "";
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $user = new UserModel();
            $loggedUser = $user->findByEmailAndPassword($_POST['email'], $_POST['password']);

            if ($loggedUser) {
                $_SESSION['user'] = $loggedUser;
                $this->redirect($this->link('/'));
            } else {
                $message = "Login failed";
            }
        }

        $template = new TemplateEngine();
        $template->loadTemplate('login');
        $template->assign('title', 'Login');
        $template->assign('message', $message);
        echo $template->render();
    }

    public function logout() {
        unset($_SESSION['user']);
        $this->redirect($this->link('/'));
    }

    public function register() {
        $message = "";
        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['surname'])) {
            // find user by email
            $user = new UserModel();
            $existingUser = $user->findByEmail($_POST['email']);
            if ($existingUser) {
                $message = "User already exists";
            }else{
                $user->email = strtolower($_POST['email']);
                $user->password = hash('sha256', $_POST['password']);
                $user->name = $_POST['name'];
                $user->surname = $_POST['surname'];
                $message = "User created";
                $user->save();
                $this->redirect($this->link('/login'));
            }
        }

        $template = new TemplateEngine();
        $template->loadTemplate('register');
        $template->assign('title', 'register');
        $template->assign('link', $this->link('/register'));
        $template->assign('message', $message);
        echo $template->render();
    }

    public function listUsers() {
        $user = new UserModel();
        $users = $user->findAll();

        $template = new TemplateEngine();
        $template->loadTemplate('listUsers');
        $template->assign('title', 'List users');
        $template->assign('users', $users);
        echo $template->render();
    }
}

?>