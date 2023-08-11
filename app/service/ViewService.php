<?php
namespace App\Service;

class ViewService
{
    public function view($path)
    {
        return $this->buffer($path);
    }

    public function buffer($path)
    {
        $pathToView = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        if (file_exists($pathToView)) {
            ob_start();
            require_once $pathToView;

            return  ob_get_clean();
        }

        return '';
    }
}