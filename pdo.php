<?php
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
   // echo "Connected to $dbname at $host successfully.";
    } catch (PDOException $pe) {
    die ("Could not connect to the database $dbname :" . $pe->getMessage());
    }
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
