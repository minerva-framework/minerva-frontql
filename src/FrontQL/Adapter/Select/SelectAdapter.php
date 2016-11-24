<?php

namespace Minerva\FrontQL\Adapter\Select;

use Minerva\FrontQL\Adapter\Where\WhereAdapter;
use Zend\Db\Sql\Select;

/**
 * Class SelectAdapter
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\FrontQL\Adapter\Select
 */
class SelectAdapter
{
    /**
     * Payload de seleção de dados
     *
     * @var SelectPayload
     */
    protected $selectPayload;

    /**
     * Adaptador de where
     *
     * @var WhereAdapter
     */
    protected $whereAdapter;

    /**
     * Colunas que não podem ser vistas
     *
     * @var array
     */
    protected $protectedColumns;

    /**
     * Retorna o payload de seleção
     *
     * @return SelectPayload
     */
    public function getSelectPayload()
    {
        return $this->selectPayload;
    }

    /**
     * Define o payload de seleção
     *
     * @param SelectPayload $selectPayload
     */
    public function setSelectPayload($selectPayload)
    {
        $this->selectPayload = $selectPayload;
    }

    /**
     * Retorna adaptador de wheres
     *
     * @return WhereAdapter
     */
    public function getWhereAdapter()
    {
        if(is_null($this->whereAdapter))
            $this->whereAdapter = new WhereAdapter();

        return $this->whereAdapter;
    }

    /**
     * Define o adaptador de wheres
     *
     * @param WhereAdapter $whereAdapter
     */
    public function setWhereAdapter($whereAdapter)
    {
        $this->whereAdapter = $whereAdapter;
    }

    /**
     * @return array
     */
    public function getProtectedColumns()
    {
        if(is_null($this->protectedColumns))
            $this->protectedColumns = [];

        return $this->protectedColumns;
    }

    /**
     * @param array $protectedColumns
     */
    public function setProtectedColumns($protectedColumns)
    {
        $this->protectedColumns = $protectedColumns;
    }

    /**
     * Retorna a adaptação do select com base no payload
     *
     * @return Select
     * @throws Basis\Exception\InvalidColumnNameException
     */
    public function getSelect()
    {
        // Remove as colunas protegidas
        $columns = array_diff($this->getProtectedColumns(), $this->getSelectPayload()->getColumns());

        // Adapta o payload ao padrão do zend
        $select = new Select();
        $select->columns($columns);
        $select->order($this->getSelectPayload()->getOrder());
        $select->limit($this->getSelectPayload()->getLimit());

        return $select;
    }
}