<?php


namespace App\Controller;


use App\Model\UserManager;

class GameController extends AbstractController
{
    public function start()
    {
        return $this->twig->render('Workspace/fight.html.twig');
    }

    public function selectAdverse()
    {
        $userManager = new UserManager();

        $allUsers = $userManager->selectAllWithIdAndLogin();

        $usersWithProfil = $this->getAllUserPersoById($allUsers);

        return $this->twig->render('Game/selectAdverse.html.twig', ['usersWithProfil' => $usersWithProfil]);
    }

    public function fight($idAdverse)
    {

        $userManager = new UserManager();

        $mainUser = $userManager->selectIdAndLoginById($_SESSION['id']);
        $userAdverse = $userManager->selectIdAndLoginById($idAdverse);

        $allUsers[0]= $mainUser;
        $allUsers[1] = $userAdverse;

        $usersWithProfil = $this->getAllUserPersoById($allUsers);

        return $this->twig->render('Game/fight.html.twig', ['mainUser' => $usersWithProfil[0], 'userAdverse' => $usersWithProfil[1]]);
    }



    /******** Method Logic **********/

    public function getAllUserPersoById($dbUsers)
    {
        $result = [];

        $userManager = new UserManager();

        foreach ($dbUsers as $dbUser) {
            $apiUser = $userManager->selectCharactersById($dbUser['id_character']);

            $user = (object) array_merge((array) $apiUser, (array) $dbUser);

            $result[] = $user;

        }
        return $result;
    }
}