<?php
$host = 'localhost:3306';
$db   = 'DreamHome';
$user = 'kiki';           
$pass = 'andelous';               
$charset = 'utf8mb4';

    try {
        $db=new \PDO(dsn:"mysql:host=localhost:3306;dbname=DreamHome;charset=utf8mb4",
                    username:'kiki',
                    password:'andelous');
        exit;
    }catch(PDOException $e){
        die($e->getMessage());}
?>