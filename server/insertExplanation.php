<?php
require "databaseConnection.php";
session_start();

try {
    $dbh->beginTransaction();
    $stmt = $dbh->prepare("INSERT INTO UWAGI(AUTOR_ID, TRESC, TYP_ID, DATA_WPROWADZENIA, DATA_MODYFIKACJI) VALUES (?,?,6,sysdate,sysdate)");
    $stmt->execute([$_SESSION['user_data'][0]['PRACOWNIK_ID'], $_POST['warntext']]);
    $stmt3 = $dbh->prepare("SELECT WARNINGS.CURRVAL AS curval FROM DUAL");
    $stmt3->execute();
    $insertedID = $stmt3->fetch(PDO::FETCH_ASSOC);
    $stmt2 = $dbh->prepare("UPDATE DOKUMENTY SET UWAGA_ID=? WHERE DOKUMENT_ID=?");
    $stmt2->execute([$insertedID['CURVAL'], $_POST['docid']]);
    $dbh->commit();
}catch(PDOException $e){
    $dbh->rollBack();
    echo $e->getMessage();
    $_SESSION['pass_to_worker_info'] = "Nie udało się wprowadzić wyjasnienia do dokumentu";
    header("Location: ../templates/dashboard.php");
}
$_SESSION['pass_to_worker_info'] = "Wprowadzono wyjasnienie do dokumentu";
header("Location: ../templates/dashboard.php");
?>