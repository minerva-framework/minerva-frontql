<?php

namespace Minerva\FrontQL\Adapter\Select\Basis\Exception;

use Exception;

/**
 * InvalidColumnNameException
 *
 * Exceção lançada quando o usuário informar um nome de coluna
 * inválido no payload.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\FrontQL\Adapter\Select\Basis\Exception
 */
class InvalidColumnNameException extends Exception {}