<?php

class HomeController extends Controller {
    public function index() {
        $template = new TemplateEngine();
        $template->loadTemplate('home');
        $template->assign('title', 'Home Page');
        $template->assign('content', 'This is the content of the home page.');
        echo $template->render();
    }

    public function about() {
        echo "About Page";
    }
}

?>