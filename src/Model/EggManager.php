<?php


namespace App\Model;


class EggManager extends AbstractManager
{
    const TABLE = 'egg';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function addEggByIdEgg($idUser, $idEgg)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (id_user,id_egg) 
        VALUE (:id_user,:id_egg)");

        $statement->bindValue(':id_user', $idUser, \PDO::PARAM_INT);
        $statement->bindValue(':id_egg', $idEgg, \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function countEggs()
    {
        return $this->pdo->query("SELECT COUNT(id_egg),id_user FROM $this->table GROUP BY id_user")->fetchAll();
    }

}