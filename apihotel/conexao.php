<?php

$host = "localhots";
$db_name = "hotel";
$username = "root";
$password = "root";

try{
    $conn = new PDO("mysql: host=$host; dbname=$db_name", $username, $password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $error){
    echo "Erro na conexão: " . $error->getMessage();

}

?>