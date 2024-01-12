<?php
class InstallController extends Controller{
    public function index() {
        $this->createUser();
        echo "done";
    }

    private function createUser() {
        $user = new UserModel();
        $user->email = "test@test.it";
        $user->name = "test";
        $user->surname = "test";
        
        //set sha256 password
        $user->password = hash('sha256', "test");
        $user->save();
    }
}
?>