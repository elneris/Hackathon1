<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 * PHP version 7
 */
namespace App\Model;

use App\Model\Connection;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    /**
     * @var \PDO
     */
    protected $pdo; //variable de connexion

    protected $api;

    /**
     * @var string
     */
    protected $table;
    /**
     * @var string
     */
    protected $className;


    /**
     * Initializes Manager Abstract class.
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
        $this->pdo = (new Connection())->getPdoConnection();
        $this->api = (new Connection())->getApiConnection();
    }

    /**
     * Get all row from database.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */

    /**
     * @return mixed
     */


    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function selectEgg()
    {
        $api = $this->api->request('GET', '/api/eggs');
        $api = $api->getBody();
        $api = $api->getContents();
        return json_decode($api);
    }

    public function selectEggRandom()
    {
        $api = $this->api->request('GET', '/api/eggs/random');
        $api = $api->getBody();
        $api = $api->getContents();
        return json_decode($api);
    }

    public function selectCharacters()
    {
        $api = $this->api->request('GET', '/api/characters');
        $api = $api->getBody();
        $api = $api->getContents();
        return json_decode($api);
    }

    public function selectCharactersRandom()
    {
        $api = $this->api->request('GET', '/api/characters/random');
        $api = $api->getBody();
        $api = $api->getContents();
        return json_decode($api);
    }

    public function selectEggById($id)
    {
        $api = $this->api->request('GET', "/api/eggs/$id");
        $api = $api->getBody();
        $api = $api->getContents();
        return json_decode($api);
    }
    public function selectCharactersById($id)
    {
        $api = $this->api->request('GET', "/api/characters/$id");
        $api = $api->getBody();
        $api = $api->getContents();
        return json_decode($api);
    }
}
