<?php
#dggsfdgsgsgsg
require 'vendor/autoload.php';

use \Slim\Slim;
use myapp\Classes\DB\DB as DB;

$app = new Slim();
$db = new DB();

$app->get('/buscar(/(:valor))',function($valor=false) use ($db){
    $query = "SELECT * FROM productos
            WHERE id = ?
            OR producto = ?
            OR precio = ?";

        $prod = $db->getInstance()->consultar($query, array($valor, $valor, $valor));
        var_dump($prod->results());
    echo "buscar: ".$valor;    

});

$app->get('/productos(/(:idp))', function($idp=false){
    global $db;
    
    $sql = "SELECT * FROM productos";
    
    if ($idp){
        $sql .= ' WHERE id=' . $idp;
    }
    
    $prod = $db->getInstance()->consultar($sql);
    
    echo json_encode($prod->results());
    
});

$app->get('/categorias/',function(){
    global $db;
    
    $sql = "SELECT * FROM categorias";
    
    $prod = $db->getInstance()->consultar($sql);
    
    echo json_encode($prod->results());
});

$app->post('/addProduct' , function() use ($db){
    // voy a mandar via post unos datos (puedo usar un form html)
    $post = $_POST;
    //var_dump($post);
    $sql = "INSERT INTO productos(producto, precio, cantidad, id_categoria)
        VALUES 
        (?, ?, ?, ?)";

    $insert = $db->getInstance()->consultar($sql, array_values($post));
    echo json_encode($insert);
});


$app->response->headers->set('Content-Type','application/json');
$app->run();
