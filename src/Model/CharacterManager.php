<?php


namespace App\Model;

class CharacterManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
