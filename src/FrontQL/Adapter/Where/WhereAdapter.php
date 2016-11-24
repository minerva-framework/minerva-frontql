<?php

namespace Minerva\FrontQL\Adapter\Where;

use Zend\Db\Sql\Where;
use Minerva\FrontQL\Adapter\Where\Basis\Exception\InvalidCommandException;

/**
 * Adaptador para comandos Where
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\FrontQL\Adapter\Where
 */
class WhereAdapter
{
    /**
     * Lista de comandos permitidos
     *
     * @var array
     */
    protected $allowed;

    /**
     * Adapter constructor.
     */
    public function __construct()
    {
        // Lista de comandos permitidos
        $this->allowed = [
            'between',
            'notBetween',
            'equalTo',
            'notEqualTo',
            'in',
            'notIn',
            'like',
            'notLike',
            'greaterThan',
            'greaterThanOrEqualTo',
            'lesserThan',
            'lesserThanOrEqualTo',
            'isNull',
            'isNotNull'
        ];
    }
    
    /**
     * Converte um Where em JSON para PHP
     *
     * @param array $jWhere
     * @return Where
     * @throws InvalidCommandException
     */
    public function fromArray(array $jWhere)
    {
        $where = new Where();
        foreach($jWhere as $item){
            if(is_array($item)){
                if(!in_array($item[0], $this->allowed)) {
                    throw new InvalidCommandException();
                }
                $method = $item[0];
                unset($item[0]);
                call_user_func_array([$where, $method], $item);
            }
            if(is_string($item)){
                if(in_array($item, $this->allowed))
                    call_user_func([$where, $item]);
            }
        }
        return $where;
    }
}