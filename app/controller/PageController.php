<?php
namespace App\Controller;

use App\Service\ViewService;

class PageController
{
    protected $view;

    public function __construct()
    {
        $this->view = new ViewService();
    }

    public function home()
    {
        $path = 'app/view/home.php';

        return $this->view->view($path);
    }
}