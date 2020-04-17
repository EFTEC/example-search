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
} else {
    $searchText='';
    $result=$pdoOne->select('*')->from('test_products')->toList();
}




$blade=new BladeOne();




echo $blade->run('list'
    ,[
        'searchText'=>$searchText
         ,'result'=>$result
     ]);