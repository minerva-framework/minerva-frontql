![](http://i.imgur.com/1dsGBRD.png)

[![Build Status](https://scrutinizer-ci.com/g/minerva-framework/minerva-frontql/badges/build.png?b=master)](https://scrutinizer-ci.com/g/minerva-framework/minerva-frontql/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/minerva-framework/minerva-frontql/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/minerva-framework/minerva-frontql/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/minerva-framework/minerva-frontql/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/minerva-framework/minerva-frontql/?branch=master)

`composer require minerva-sistemas/minerva-frontql`

FrontQL é uma estrutura simplificada de queries para front-end compatível com Zend Framework. Utilizando o FrontQL você ganha mais flexibilidade no momento de montar suas consultas e realizar implementações de API, além de poupar tempo de trabalho e evitar que sejam criados diversos condicionamentos em suas actions deixando seu código desorganizado ou então com diversas implementações de estratégias desnecessárias.

## No front-end

No front-end você tem as opções de comands where, operadores where, seleção de colunas, limit e ordenamento. Nos comands where, o primeiro elemento da array é o nome do comando no Zend Framework, e os demais parâmetros são exigidos por este. Como operadores temos and, or, nest e unnest.

```js
var where = [
   'nest',
   ['isNotNull', 'email'],
   'and',
   ['isNotNull', 'name'],
   'unnest',
   'or',
   ['greaterThan', 'age', 18],
];

var select = {
   columns: ['name', 'age', 'email' ],
   where  : where,
   limit  : 20,
   order  : [[['name', 'idade'], 'ASC'], [['email'], 'DESC']]
};

// SELECT name, age, email FROM ? 
// WHERE (email != null AND name != null) OR age > 18 
// ORDER BY name,idade ASC, email DESC

$.post('/application/client/list', { fql : select });
```

## No back-end
Quando o payload for recebido, basta instanciar o adapter, realizar a conversão, fazer os overrides se necessário, executar a query e construir a resposta.

```php
// Query recebida do front-end
$payload = $this->params()->fromPost('fql');

// Conversão para Zend\Db\Sql\Select
$adapter = new SelectAdapter();
$adapter->setProtectedColumns(['name']);
$adapter->setSelectPayload(new SelectPayload($payload));
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

## Resposta
Seguindo o esboço acima você receberá uma resposta nesse padrão.

```
[
   {
      name: 'Lucas',
      email: 'lucas@minervasistemas.com.br',
      idade: 21
   },
   {
      name: null,
      email: null,
      idade: 19
   }
]
```
