<?php

namespace Minerva\FrontQL\Adapter\Select\Basis\Exception;

use Exception;

/**
 * UndefinedPayloadException
 *
 * Exceção lançada quando houver a tentativa de converter um select
 * sem antes definir o payload recebido do front-end.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\FrontQL\Adapter\Select\Basis\Exception
 */
class UndefinedPayloadException extends Exception {}