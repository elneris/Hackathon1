<?php


namespace App\Model;


class EggManager extends AbstractManager
{
    const TABLE = 'user';

    public function addEggByIdEgg($idUser, $idEgg)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (id_user,id_egg) 
        VALUE (:id_user,:id_egg)");

        $statement->bindValue(':id_user', $idUser, \PDO::PARAM_INT);
        $statement->bindValue(':id_egg', $idEgg, \PDO::PARAM_STR);

        return $statement->execute();
    }

}