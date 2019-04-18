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

    public function fight($id)
    {

        var_dump($_SESSION['id']);
        return $this->twig->render('Game/fight.html.twig');
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