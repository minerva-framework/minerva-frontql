# minerva-frontql
FrontQL é uma linguagem de queries para front-end compatível com Zend Framework. Utilizando o FrontQL você ganha mais flexibilidade no momento de montar suas consultas e realizar implementações de API, além de poupar tempo de trabalho e evitar que sejam criados diversos condicionamentos em suas actions deixando seu código desorganizado ou então com diversas implementações de estratégias desnecessárias.

## No Front-end

No front-end você tem as opções de comands where, operadores where, seleção de colunas, limit e ordenamento.

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

$.get('/my/api/address', select);
```
