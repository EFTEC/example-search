# example-search
A basic example to create a search feature in php

bootstrap version

![](img/search_bootstrap.jpg)

vanilla html

![](img/search.jpg)

## Configure Composer.

For this step, you will need composer. Install composer and runs the next line (in the root folder of the project)

You chould change the values indicates with **  

> composer init


```
 Welcome to the Composer config generator
Package name (<vendor>/<name>) : **jorge/example-search**
Description []:
Author <you name>, n to skip]:
Minimum Stability []:
Package Type (e.g. library, project, metapackage, composer-plugin) []: **project**
License []: **MIT**
Define your dependencies.
Would you like to define your dependencies (require) interactively yes?
Search for a package: **eftec/bladeone**
Enter the version constraint to require (or leave blank to use the latest version):
Using version ^3.37 for eftec/bladeone
Enter package # to add, or the complete package name if it is not listed: **eftec/bladeone**
Enter the version constraint to require (or leave blank to use the latest version):
Using version ^1.33 for eftec/pdoone
Search for a package:
Would you like to define your dev dependencies (require-dev) interactively yes? **no**

{
    "name": "jorge/example-search",
    "type": "project",
    "require": {
        "eftec/bladeone": "^3.37",
        "eftec/pdoone": "^1.33"
    },
    "license": "MIT",
    "authors": [
        {
            "name": "you",
            "email": "you email"
        }
    ]
}

Do you confirm generation yes? **yes**
Would you like the vendor directory added to your .gitignore yes? **yes**
Would you like to install dependencies now yes? **yes**
Loading composer repositories with package information
Updating dependencies (including require-dev)
```

It will create a file called composer.json. It also will create a folder called vendor (with the libraries)

## Create folder views and compiles (for the templates)

📁 root project   
📁 composer.json (created in the previous step)   
---- 📁 vendor (created in the previous step)  
____ 📁 compiles  
____ 📁 views   


## Connect to the database

including vendor/autoload.php will deal with all the (ahem) includes.   :-3

```php
include "vendor/autoload.php";
```

We will use PdoOne to connect to the database.
Type of database :mysql, server =127.0.0.1, user=root, password =abc.123, database=sakila 
(you must change it according your config) 


```php
use eftec\PdoOne;
$pdoOne=new PdoOne('mysql','127.0.0.1','root','abc.123','sakila');
$pdoOne->connect();
```

## Creating exampling data and the table (optional)

If the table does not exist, then it will create.  
It also will add example data.  

```php
if (!$pdoOne->tableExist('test_products')) {
    // No, then let's create a new table
    $pdoOne->createTable('test_products'
    ,['idProduct'=>'int not null','name'=>'varchar(50)']
    ,['idProduct'=>'PRIMARY KEY']);
    
    // and let's add some example data
    $pdoOne->insertObject('test_products', ['idProduct'=>1,'name'=>'Cocacola']);
    $pdoOne->insertObject('test_products', ['idProduct'=>2,'name'=>'Fanta']);
    // another way to insert values
    $pdoOne->set(['idProduct','i',3,'name','s','Sprite'])
           ->insert('test_products');
}
```

## Creating the view

We will use BladeOne for view.

It will use the folders views and compiles  (created in a previous step).

### Creating the instance

```php
use eftec\bladeone\BladeOne;
$blade=new BladeOne();
```

### using it

The view is called "list", so we must create the next file (in the folder views/)

views/list.blade.php  

```
<body>
....
</body>
```


We will pass to the view the next data searchText and Result.   

```php
echo $blade->run('list'
    ,[
        'searchText'=>$searchText
         ,'result'=>$result
     ]);
```

## Joining all together

See search.php or search_bootstrap.php file

```php
<?php /** @noinspection PhpUnhandledExceptionInspection */

use eftec\bladeone\BladeOne;
use eftec\PdoOne;

include "vendor/autoload.php";

$pdoOne=new PdoOne('mysql','127.0.0.1','root','abc.123','sakila');
$pdoOne->connect();

// Does the table exist?

if (!$pdoOne->tableExist('test_products')) {
    // No, then let's create a new table
    $pdoOne->createTable('test_products'
    ,['idProduct'=>'int not null','name'=>'varchar(50)']
    ,['idProduct'=>'PRIMARY KEY']);
    
    // and let's add some example data
    $pdoOne->insertObject('test_products', ['idProduct'=>1,'name'=>'Cocacola']);
    $pdoOne->insertObject('test_products', ['idProduct'=>2,'name'=>'Fanta']);
    // another way to insert values
    $pdoOne->set(['idProduct','i',3,'name','s','Sprite'])
           ->insert('test_products');
}

$button=@$_POST['button'];

if($button) {
    // we press the button
    $searchText=@$_POST['searchText'];
    $result=$pdoOne->select('*')->from('test_products')->where('name like ?',["%$searchText%"])->toList();
    if($result===false) {
        // result is false if the operation failed.
        $result=[];
    }
} else {
    $searchText='';
    $result=$pdoOne->select('*')->from('test_products')->toList();
}

$blade=new BladeOne();

echo $blade->run('list'
    ,[
        'searchText'=>$searchText
         ,'result'=>$result
        ,'count'=>count($result)
     ]);
```

