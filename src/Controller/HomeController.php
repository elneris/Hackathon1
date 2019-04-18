<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ItemManager;
use App\Model\UserManager;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $userManager = new UserManager();
        $bestUsers = $userManager->bestUsers();

        $randomUsers = $userManager->randomUsers() ;

        return $this->twig->render('Home/index.html.twig',['session'=>$_SESSION, 'users'=>$bestUsers,'randomUsers'=>$randomUsers]);
    }
}
