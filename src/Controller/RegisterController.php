<?php


namespace App\Controller;

use App\Model\UserManager;

class RegisterController extends AbstractController
{

    /**
     * Display register page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        if (isset($_SESSION['login'])) {

            header('Location: /Home/index');
            exit;
        }
        $errors = [];
        if (isset($_POST['submit'])) {
            $userManager = new UserManager();

            $userExist = $userManager->selectLogin($_POST['login']);
            if (isset($userExist[0]['login']) && $userExist[0]['login'] == $_POST['login']) {
                $errors['alreadyUse'] = 'Ce pseudo est déjà utilisé';
            } else {
                if (empty($_POST['login']) || empty($_POST['password']) || empty($_POST['repeatPassword'])) {
                    $errors['empty'] = 'Veuillez remplir tout les champs';
                } else {
                    $login = htmlspecialchars(trim($_POST['login']));
                    $password = htmlspecialchars(trim($_POST['password']));
                    $repeatPassword = htmlspecialchars(trim($_POST['repeatPassword']));
                    if ($login && $password && $repeatPassword) {
                        if (strlen($password) < 4) {
                            $errors['passwordLen'] = 'Votre mot de passe est trop court';
                        } else {
                            if ($password != $repeatPassword) {
                                $errors['passwordRepeat'] = 'Vous n\'avez pas renseigné le même mot de passe';
                            } else {
                                $password = sha1($password);
                            }
                        }
                    }
                }
            }

            if (count($errors) == 0) {

                $characterManager = new UserManager();
                $character = $characterManager->selectCharactersRandom();
                $user = [
                    'login'=> $login,
                    'password' => $password,
                    'id_character' => $character->id
                ];
                $succes = 'Votre inscription à bien été enregistré';
                $userManager->insert($user);
                return $this->twig->render('Register/index.html.twig', ['post'=> $_POST,'succes' => $succes]);

            }
        }
        return $this->twig->render('Register/index.html.twig', ['post'=> $_POST,'errors' => $errors]);
    }
}
