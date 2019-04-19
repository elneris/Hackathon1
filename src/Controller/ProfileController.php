<?php


namespace App\Controller;


use App\Model\UserManager;

class ProfileController extends AbstractController
{
    public function index()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /Login/index');
            exit;
        }
        $result = [];
        $userManager = new UserManager();
        $user = $userManager->selectOneById($_SESSION['id']);
        $apiUser = $userManager->selectCharactersById($user['id_character']);

        $userAll = (array) array_merge((array) $apiUser, (array) $user);

        $skills = $userAll['skills'];
        foreach ($skills as $skill => $value){
            $results[$skill] = explode(':',$value);
        }

        $result[] = $userAll;

        return $this->twig->render('Profile/index.html.twig', ['user' => $result,'skill'=>$results,'session'=>$_SESSION]);
    }
}