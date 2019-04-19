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

    public function fightResult($idAdverse)
    {

        $userManager = new UserManager();

        $mainUser = $userManager->selectIdAndLoginById($_SESSION['id']);
        $userAdverse = $userManager->selectIdAndLoginById($idAdverse);

        $allUsers[0]= $mainUser;
        $allUsers[1] = $userAdverse;

        $usersWithProfil = $this->getAllUserPersoById($allUsers);

        $resultFight = $this->getfightResult($usersWithProfil);

        $this->insertFightResultInDn($resultFight, $_SESSION['id'], $idAdverse);



        return $this->twig->render('Game/fightResult.html.twig',
            [
                'mainUser' => $usersWithProfil[0],
                'userAdverse' => $usersWithProfil[1],
                'resultFight' => $resultFight
            ]);
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

    public function getFightResult($users)
    {
        $i = 0;
        $score = [];

        foreach ($users as $user) {
            $score[$i] = $this->getScorePerso($user);
            $i += 1;
        }

        return $score;
    }

    public function getScorePerso($user)
    {
        $skillTotal = 0;
        $userSkills = $user->skills;

        foreach ($userSkills as $skill) {
            $skill = explode(':', $skill);
            $skillTotal += $skill[1];
        }

        $skillTotal += rand(0, 30);

        return $skillTotal;
    }

    public function insertFightResultInDn($resultFight ,$mainId, $idAdverse)
    {
        $userManager = new UserManager();

        if ($resultFight[0] > $resultFight[1]) {
            $userManager->addPointIfWin($mainId);
            $userManager->addPointInPoint($mainId);
            $userManager->addPointIfLoose($idAdverse);
        } elseif ($resultFight[0] < $resultFight[1]) {
            $userManager->addPointIfWin($idAdverse);
            $userManager->addPointInPoint($idAdverse);
            $userManager->addPointIfLoose($mainId);
        } else {
            $userManager->addPointIfEqual($mainId);
            $userManager->addPointIfEqual($idAdverse);
            $userManager->addPointInPoint($mainId);
            $userManager->addPointInPoint($idAdverse);
        }
    }

}