<?php

use App\Model\Manager\VideoManager;

class HomeController extends AbstractController
{
    /**
     * @return void
     */
    public function index()
    {
        $this->render('home/home', [
            'video' => VideoManager::findAll(3),
        ]);
    }
}
