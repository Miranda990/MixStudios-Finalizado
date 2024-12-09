<?php

$host = 'sql306.infinityfree.com'; 
$user = 'if0_37830679';        
$password = 'sYMkRIrBaOY'; 
$dbname = 'if0_37830679_meu_site'; 
$port = '3306';


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
?>
