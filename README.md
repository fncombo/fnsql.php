#[fnsql.php][0]

Makes PHP's PDO a little easier.

##Setup

Include the file in your ... file.

```php
require_once('fnsql.php');
```

Connect to a database.

```php
$sql = new fnsql('localhost', 'root', 'password', 'database');
```

##Queries

`SELECT` query without any parameters.

```php
$query = $sql->query('SELECT * FROM table LIMIT 1000');
// $query contains the result of the query
```

`SELECT` query with 1 parameter.

```php
$parameter = 'value';
$query = $sql->query('SELECT * FROM table WHERE column = ?', $parameter);
// $query contains the result of the query
```

`SELECT` query with many parameters.

```php
$parameters = array(
    'value1',
    'value2'
);
$query = $sql->query('SELECT * FROM table WHERE column1 = ? OR column2 = ?', $parameters);
// $query contains the result of the query
```

Other queries.

```php
$parameter = 'value';
$sql->query('DELETE FROM table WHERE column = ?', $parameter);
```

##Settings

By default, PDO::FETCH_ASSOC fetch mode is used. You can modify the fetch mode on either a per-query basis, or globally for all queries.

```php
// Modify the fetch mode for all queries.
$sql->setDefaultFetchMode(PDO::FETCH_BOTH);

// Modify the fetch mode for the current query.
$query = $sql->query('SELECT * FROM table LIMIT 1000', false, PDO::FETCH_BOTH);
```

[0]: https://raw.github.com/fncombo/fnsql.php/master/fnsql.php
