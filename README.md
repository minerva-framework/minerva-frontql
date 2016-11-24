# minerva-frontql
FrontQL é uma linguagem de queries para front-end para utilização com o Zend Framework. Utilizando o FrontQL você ganha mais flexibilidade no momento de montar suas consultas e realizar implementações de API.

```
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

$.get('/my/api/address', select);
```
