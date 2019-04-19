<?php


namespace App\Controller;


use App\Model\EggManager;
use App\Model\UserManager;

class ProfileController extends AbstractController
{
    public function index()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /Login/index');
            exit;
        }
        $userManager = new UserManager();

        if(isset($_POST['id'])){
            $userManager->update($_POST['id'],$_SESSION['id']);
        }
        $result = [];

        $user = $userManager->selectOneById($_SESSION['id']);
        $apiUser = $userManager->selectCharactersById($user['id_character']);

        $userAll = (array) array_merge((array) $apiUser, (array) $user);

        $skills = $userAll['skills'];
        foreach ($skills as $skill => $value){
            $results[$skill] = explode(':',$value);
        }

        $result[] = $userAll;

        $eggsManager = new EggManager();
        $eggs = $eggsManager->countEggs();
        foreach ($eggs as $egg => $value){
            if ($value['id_user'] == $_SESSION['id']){
                $countEgg = $value['COUNT(id_egg)'];
            }if($value['id_user'] != $_SESSION['id']) {
                $countEggs = 0;
            }
        }
        if (isset($countEgg)){
            $countEggs = $countEgg;
        }

        $random = [];
        $randomManager = new UserManager();
        $random[0] = $randomManager->selectCharactersRandom();
        $random[1] = $randomManager->selectCharactersRandom();
        $random[2] = $randomManager->selectCharactersRandom();
        $random[3] = $randomManager->selectCharactersRandom();
        $random[4] = $randomManager->selectCharactersRandom();
        $random[5] = $randomManager->selectCharactersRandom();

        return $this->twig->render('Profile/index.html.twig', ['random'=>$random,'countEggs'=>$countEggs,'user' => $result,'skill'=>$results,'session'=>$_SESSION]);
    }

    public function egg()
    {

        $eggManager = new EggManager('egg');
        $eggs = $eggManager->selectEgg();

        $userEggs = $eggManager->getAllEggUserWithImg($_SESSION['id']);

        return $this->twig->render('Profile/egg.html.twig', ['userEggs' => $userEggs]);
    }
}