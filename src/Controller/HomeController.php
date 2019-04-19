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

        return $this->twig->render('Home/index.html.twig',['info1'=>$result1,'info'=>$result,'session'=>$_SESSION, 'users'=>$bestUsers,'randomUsers'=>$randomUsers]);
    }

}
