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
}
