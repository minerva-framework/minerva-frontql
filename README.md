# minerva-frontql
FrontQL é uma linguagem de queries para front-end compatível com Zend Framework. Utilizando o FrontQL você ganha mais flexibilidade no momento de montar suas consultas e realizar implementações de API, além de poupar tempo de trabalho e evitar que sejam criados diversos condicionamentos em suas actions deixando seu código desorganizado ou então com diversas implementações de estratégias desnecessárias.

## No front-end

No front-end você tem as opções de comands where, operadores where, seleção de colunas, limit e ordenamento. Nos comands where, o primeiro elemento da array é o nome do comando no Zend Framework, e os demais parâmetros são exigidos por este. Como operadores temos and, or, nest e unnest.

```js
var where = [
   ['isNotNull', 'email'],
   'and',
   ['isNotNull', 'name'],
   'or',
   'nest',
   ['greatherThan', 'age', 18],
   'unnest'
];

var select = {
   columns: ['name', 'age', 'email' ]
   where  : where,
   limit  : 20,
   order  : [['name'], 'ASC']
};

$.post('/application/client/list', { fql : select });
```

## No back-end
```php
// Query recebida do front-end
$payload = $this->params()->fromPost('fql');

// Conversão para Zend\Db\Sql\Select
$adapter = new Minerva\FrontQL\Select\Adapter();
$adapter->setPayload($payload);
$query = $adapter->getSelect();

// Override
$query->limit(2);

// Consulta
$clientTable = new ClientTableGateway();
$resultSet = $clientTable->select($query);

// Resposta
$response = new JsonModel($resultSet->toArray());
return $response;
```
