<?php namespace App;

use Framework\Redirect;

class BaseController
{
    public $redirect;
    public $baseTemplatePath;

    public function __construct()
    {
        $this->redirect = new Redirect();
    }
}