<?php


namespace App\Controller;


use App\Model\UserManager;

class RankingController extends AbstractController
{
    public function index()
    {
        $userManager = new UserManager();
        $bestUsers = $userManager->bestUsers();


        $tenUsers = $userManager->tenUsers();


        return $this->twig->render('Ranking/index.html.twig',['users'=>$bestUsers, 'tenusers' =>$tenUsers]);


    }
}