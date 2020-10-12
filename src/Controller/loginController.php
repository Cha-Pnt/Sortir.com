<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class loginController extends AbstractController {

    /**
     * @Route( "/login", name="Login")
     */
    public function log(){
        return $this->render("login.html.twig");
    }

}
