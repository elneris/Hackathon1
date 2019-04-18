<?php


namespace App\Model;

class UserManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectLogin($login): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE login =:login");
        $statement->bindValue(':login', $login, \PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetchAll();
    }


    public function insert($user)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (login, password, id_character) 
        VALUE (:login,:password,:id_character)");
        $statement->bindValue(':login', $user['login'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue(':id_character', $user['id_character'], \PDO::PARAM_STR);

        return $statement->execute();
    }
    public function bestUsers()
    {
        return $this->pdo->query("SELECT * FROM $this->table ORDER BY point DESC LIMIT 3" )->fetchAll();
    }

    public function randomUsers()
    {
        return $this->pdo->query("SELECT * FROM $this->table ORDER BY RAND() LIMIT 3" )->fetchAll();

    }

    public function selectAllWithIdAndLogin()
    {
        return $this->pdo->query('SELECT id,login,id_character FROM ' . $this->table)->fetchAll();
    }

}
