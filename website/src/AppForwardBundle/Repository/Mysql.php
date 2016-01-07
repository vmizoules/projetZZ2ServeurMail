<?php

namespace AppForwardBundle\Repository;

use AppForwardBundle\Entity\Alias;
use Doctrine\Bundle\DoctrineBundle\Registry;

class Mysql
{
    /**
     * @var Registry
     */
    private $connection;

    public function __construct(Registry $doctrine) {
        $this->connection = $doctrine;
    }

    public function createAlias(Alias $newAlias){
        $query = 'SELECT address FROM alias;';

        $result = $this->connection->getEntityManager()->createQuery($query)->getResult();

        var_dump($result);
    }

}