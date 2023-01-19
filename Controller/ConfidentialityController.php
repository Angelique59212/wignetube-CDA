<?php

namespace App\Controller;

use App\Controller\AbstractController;

class ConfidentialityController extends AbstractController
{
    /**
     * @return void
     */
    public function index()
    {
        $this->render('confidentiality/confidentiality');
    }
}
