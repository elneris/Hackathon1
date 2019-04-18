<?php


namespace App\Controller;


class ProfileController extends AbstractController
{
    public function index()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /Home/index');
            exit;
        }
        return $this->twig->render('Profile/index.html.twig',['session'=>$_SESSION]);

    }
}