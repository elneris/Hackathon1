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
        if (isset($_SESSION['email'])) {
            header('Location: /Home/index');
            exit;
        }
        $errors = [];
        if (isset($_POST['submit'])) {
            $userManager = new UserManager();
            $userExist = $userManager->selectEmail($_POST['email']);
            if (isset($userExist[0]['email']) && $userExist[0]['email'] == $_POST['email']) {
                $errors['alreadyUse'] = 'Cette email est déjà utilisé';
            } else {
                if (empty($_POST['firstname']) || empty($_POST['lastname']) ||
                    empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repeatPassword'])) {
                    $errors['empty'] = 'Veuillez remplir tout les champs';
                } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Veuillez entrer un email valide';
                } elseif (!isset($_POST['charte']) || $_POST['charte'] != 'check') {
                    $errors['charte'] = 'Veuillez lire les Termes & Conditions d\'utilisation.';
                } else {
                    $firstname = htmlspecialchars(trim($_POST['firstname']));
                    $lastname = htmlspecialchars(trim($_POST['lastname']));
                    $email = $_POST['email'];
                    $password = htmlspecialchars(trim($_POST['password']));
                    $repeatPassword = htmlspecialchars(trim($_POST['repeatPassword']));
                    if ($firstname && $lastname && $email && $password && $repeatPassword) {
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
                $user = [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'password' => $password,
                ];
                $succes = 'Votre inscription à bien été enregistré';
                $userManager->insert($user);
                return $this->twig->render('Register/fight.html.twig', ['post'=> $_POST,'succes' => $succes]);
            }
        }
        return $this->twig->render('Register/index.html.twig', ['post'=> $_POST,'errors' => $errors]);
    }
}
