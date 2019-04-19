<?php


namespace App\Controller;


use App\Model\UserManager;

class RankingController extends AbstractController
{
    public function index()
    {
        $userManager = new UserManager();

        $tenUsers = $userManager->tenUsers();

        $bestUsers = $userManager->bestUsers();

        $randomUsers = $userManager->randomUsers() ;
        $result = [];
        $result1 = [];

        foreach ($randomUsers as $randomUser) {
            $allUsers = $userManager->selectIdAndLoginById($randomUser['id']);

            $apiUser = $userManager->selectCharactersById($allUsers['id_character']);

            $user = (object) array_merge((array) $apiUser, (array) $allUsers);

            $result[] = $user;
        }
        foreach ($bestUsers as $bestUser) {
            $allBestUsers = $userManager->selectIdAndLoginById($bestUser['id']);

            $apiUser = $userManager->selectCharactersById($allBestUsers['id_character']);

            $user1 = (object) array_merge((array) $apiUser, (array) $allBestUsers);

            $result1[] = $user1;
        }

        return $this->twig->render('Ranking/index.html.twig',[ 'info1'=>$result1,'users'=>$bestUsers, 'tenusers' =>$tenUsers ]);


    }
}