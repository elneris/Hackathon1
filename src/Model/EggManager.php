<?php


namespace App\Model;


class EggManager extends AbstractManager
{
    const TABLE = 'egg';

    public function addEggByIdEgg($idUser, $idEgg)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (id_user,id_egg) 
        VALUE (:id_user,:id_egg)");

        $statement->bindValue(':id_user', $idUser, \PDO::PARAM_INT);
        $statement->bindValue(':id_egg', $idEgg, \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function getAllEgg($id)
    {
        return $this->pdo->query("SELECT id_egg FROM $this->table WHERE id_user = $id")->fetchAll();
    }

    public function getAllEggUserWithImg($id)
    {
        $allEgg = [];

        $allUserEgg = $this->getAllEgg($id);

        foreach ($allUserEgg as $egg) {

            $allEgg[] = $this->selectEggById($egg['id_egg']);
        }

        return $allEgg;
    }

}