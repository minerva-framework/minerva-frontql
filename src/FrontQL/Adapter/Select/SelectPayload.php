<?php

namespace Minerva\FrontQL\Adapter\Select;

use Minerva\FrontQL\Adapter\Select\Basis\Exception\InvalidColumnNameException;
use Minerva\FrontQL\Adapter\Where\WhereAdapter;

/**
 * Class SelectPayload
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\FrontQL\Adapter\Select
 */
class SelectPayload
{
    /**
     * Payload recebido do front-end
     *
     * @var array
     */
    protected $payload;

    /**
     * Constrói o payload
     *
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Retorna as colunas filtradas no select
     * @return array
     * @throws InvalidColumnNameException
     */
    public function getColumns()
    {
        // Se nenhuma coluna foi definida todas serão retornadas
        if(!isset($this->payload['columns']) || !is_array($this->payload['columns']))
            return ['*'];

        $regex = '/^[a-zA-Z_][a-zA-Z0-9_]*$/';
        $columns = array();

        foreach ($this->payload['columns'] as $column){
            // Valida o nome da coluna
            if(!is_string($column) || !preg_match($regex, $column))
                throw new InvalidColumnNameException();

            $columns[] = $column;
        }

        if(count($columns) == 0)
            return ['*'];

        return $columns;
    }

    /**
     * Retorna o limite de linhas
     *
     * @return int|null
     */
    public function getLimit()
    {
        if(!isset($this->payload['limit']))
            return null;

        if(!is_int($this->payload['limit']))
            return null;

        return $this->payload['limit'];
    }
    
    /**
     * Retorna o offset de linhas
     *
     * @return int|null
     */
    public function getOffset()
    {
        if(!isset($this->payload['offset']))
            return null;

        if(!is_int($this->payload['offset']))
            return null;

        return $this->payload['offset'];
    }

    /**
     * Retorna a ordem definida pelo usuário em string
     *
     * @return string
     */
    public function getOrder()
    {
        $allowed = ['ASC', 'DESC'];

        if(!isset($this->payload['order']) || !is_array($this->payload['order']))
            return '';

        $orders = array();

        foreach ($this->payload['order'] as $order){
            $columns  = implode(', ', $order[0]);
            $command  = in_array($order[1], $allowed) ? $order[1] : 'ASC';
            $orders[] = "{$columns}, {$command}";
        }

        return implode(', ', $orders);
    }

    /**
     * Retorna o where do payload de seleção
     *
     * @return array
     */
    public function getWhere()
    {
        if(!is_array($this->payload['where']))
            return [];

        $adapter = new WhereAdapter();
        $where = $adapter->fromArray($this->payload['where']);

        return $where;
    }
}
