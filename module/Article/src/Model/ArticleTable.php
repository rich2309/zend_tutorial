<?php

namespace Article\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;


class ArticleTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {

        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false)
    {
        if ($paginated)
        {
            return $this->fetchPaginatedResults();
        }
        return $this->tableGateway->select();
    }

    private function fetchPaginatedResults()
    {
        $select = new Select($this->tableGateway->getTable());
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Article());
        $paginatorAdapter = new DbSelect($select,$this->tableGateway->getAdapter(),$resultSetPrototype);
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function getArticle($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf("Impossible de trouver l'enregistrement %d", id));
        }
        return $row;
    }

    public function saveArticle(Article $article)
    {
        $data = [
            'designation' => $article->designation,
            'prix_unit' => $article->prix_unit
        ];
        $id = (int)$article->id;
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->getArticle($id)) {
            throw new RuntimeException(sprintf("Impossible de mettre � jour le client avec  l'enregistrement %d, il n'existe pas", $id));
        }

        $this->tableGateway->update($data, array('id' => $id));
    }

    public function deleteArticle($id)
    {
        $this->tableGateway->delete(array('id' => (int)$id));
    }
}