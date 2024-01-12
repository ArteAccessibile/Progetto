<?php
class Controller {
    public function __construct() {
        session_start();
    }

    public function link($path, $args = []){
        $url =  "index.php?path=" . $path;
        if (count($args) > 0) {
            foreach ($args as $key => $value) {
                $url .= "&$key=$value";
            }
        }
        return $url;
    }

    public function redirect($path){
        header("Location: $path");
        exit();
    }
}
?>