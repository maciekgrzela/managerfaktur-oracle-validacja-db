<?php
require "databaseConnection.php";
session_start();
$insert = $_POST['insert'];
try {
    $dbh->beginTransaction();
    $stmt = $dbh->prepare("INSERT INTO DOKUMENTY(PLATNIK_ID, KWOTA, RODZAJ_PLATNOSCI, TYP_DOKUMENTU, UWAGA_ID, DATA_WYSTAWIENIA, DATA_PLATNOSCI, MIEJSCE_DOSTAWY, NUMER_DOKUMENTU) VALUES (?,?,?,?,NULL,TO_DATE(?, 'dd/mm/yyyy, hh24:mi:ss'),TO_DATE(?, 'dd/mm/yyyy, hh24:mi:ss'),?,?)");
    $stmt->execute([$insert[1], $insert[3], $insert[4], $insert[0], $insert[5], $insert[6], $insert[2], $insert[7]]);
    $stmt = $dbh->prepare("SELECT DOCUMENTS.CURRVAL AS curval FROM DUAL");
    $stmt->execute();
    $insertedID = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $dbh->prepare("INSERT INTO PRZEKAZANIA_DOKUMENTOW(DOKUMENT_ID, NADAWCA_ID, ODBIORCA_ID, ZATWIERDZONO, DATA_PRZEKAZANIA) VALUES (?,?,?,?,TO_DATE(?, 'dd/mm/yyyy, hh24:mi:ss'))");
    $stmt->execute([$insertedID['CURVAL'], $_SESSION['user_data'][0]['PRACOWNIK_ID'],$_SESSION['user_data'][0]['PRACOWNIK_ID'], 1, $insert[5]]);
    $dbh->commit();
    $_SESSION['pass_to_worker_info'] = "Pomyślnie wprowadzono dokument do systemu";
    header("Location: ../templates/dashboard.php");
}catch (PDOException $e){
    $dbh->rollBack();
    $_SESSION['pass_to_worker_info'] = "Nie udało się wprowadzić dokumentu do systemu";
    header("Location: ../templates/dashboard.php");
}