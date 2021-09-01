<?php
require "databaseConnection.php";
session_start();
echo 'Dostalem nastepujace docid: '.$_POST['docid'];
try {
    $dbh->beginTransaction();
    $stmt = $dbh->prepare("SELECT UWAGA_ID FROM DOKUMENTY WHERE DOKUMENT_ID=?");
    $stmt->execute([$_POST['docid']]);
    $warn = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($warn);
    if(!(empty($warn))){
        $stmt = $dbh->prepare("INSERT INTO ARCHIWUM(DOKUMENT_ID, NUMER_DOKUMENTU, NAZWA_PLATNIKA, KWOTA, KOD_TYPU, TRESC_UWAGI, DATA_WYSTAWIENIA) (SELECT DOKUMENT_ID, NUMER_DOKUMENTU, NAZWA, KWOTA, TYP_DOKUMENTU, TRESC, DATA_WYSTAWIENIA FROM DOKUMENTY JOIN PLATNICY USING(PLATNIK_ID) JOIN UWAGI USING(UWAGA_ID) WHERE DOKUMENT_ID = ?)");
        $stmt->execute([$_POST['docid']]);
        $stmt = $dbh->prepare("DELETE FROM UWAGI WHERE UWAGA_ID=?");
        $stmt->execute([$warn[0]['UWAGA_ID']]);
    }else {
        $stmt = $dbh->prepare("INSERT INTO ARCHIWUM(DOKUMENT_ID, NUMER_DOKUMENTU, NAZWA_PLATNIKA, KWOTA, KOD_TYPU, TRESC_UWAGI, DATA_WYSTAWIENIA) (SELECT DOKUMENT_ID, NUMER_DOKUMENTU, NAZWA, KWOTA, TYP_DOKUMENTU, NULL , DATA_WYSTAWIENIA FROM DOKUMENTY JOIN PLATNICY USING(PLATNIK_ID) WHERE DOKUMENT_ID = ?)");
        echo $stmt->execute([$_POST['docid']]);
    }
    $stmt = $dbh->prepare("DELETE FROM PRZEKAZANIA_DOKUMENTOW WHERE DOKUMENT_ID=?");
    $stmt->execute([$_POST['docid']]);
    $stmt = $dbh->prepare("DELETE FROM DOKUMENTY WHERE DOKUMENT_ID=?");
    $stmt->execute([$_POST['docid']]);
    $dbh->commit();
    $_SESSION['pass_to_worker_info'] = "Pomyślnie przekazano fakturę do archiwum";
    header("Location: ../templates/dashboard.php");
}catch (PDOException $e){
    $dbh->rollBack();
    $_SESSION['pass_to_worker_info'] = "Nie udało się przekazać dokumentu do archiwum";
    header("Location: ../templates/dashboard.php");
}