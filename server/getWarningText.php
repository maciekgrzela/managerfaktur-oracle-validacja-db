<?php
require "databaseConnection.php";
session_start();

$stmt = $dbh->prepare("SELECT OPIS FROM TYPY_UWAG WHERE TYP_ID=?");
$stmt->execute([$_POST['warn']]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo $row['OPIS'];