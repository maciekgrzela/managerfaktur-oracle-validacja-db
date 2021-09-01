<?php
require "databaseConnection.php";
session_start();
if($_SESSION['pass_to_worker'] == 'client'){
    $stmt = $dbh->prepare("INSERT INTO PRZEKAZANIA_DOKUMENTOW(DOKUMENT_ID, NADAWCA_ID, ZATWIERDZONO, DATA_PRZEKAZANIA) VALUES (?,?,?,sysdate)");
}else {
    $stmt = $dbh->prepare("INSERT INTO PRZEKAZANIA_DOKUMENTOW(DOKUMENT_ID, NADAWCA_ID, ODBIORCA_ID, ZATWIERDZONO, DATA_PRZEKAZANIA) VALUES (?,?,?,?,sysdate)");
}
$i = 0;
try {
    $dbh->beginTransaction();
    foreach ($_POST['documentid'] as $row){
        if($_SESSION['pass_to_worker'] == 'client'){
            $stmt->execute([$row, $_SESSION['user_data'][0]["PRACOWNIK_ID"], 0]);
        }else {
            $stmt->execute([$row, $_SESSION['user_data'][0]["PRACOWNIK_ID"], $_SESSION['pass_to_worker'], 0]);
        }
        $i++;
    }
    $dbh->commit();
}catch (PDOException $e){
    $dbh->rollBack();
    echo $e->getMessage();
    echo $i;
    $_SESSION['pass_to_worker_info'] = "Nie udało się przekazać dokumentu pracownikowi";
    header("Location: ../templates/dashboard.php");
}

$_SESSION['pass_to_worker_info'] = "Dokumenty zostały przekazane pomyślnie";
header("Location: ../templates/dashboard.php");

echo '<pre>Uzytkownik: '.print_r($_SESSION['user_data'], true).'</pre>';
echo '<pre>Pracownikowi o numerze: '.print_r($_SESSION['pass_to_worker'], true).'</pre>';
echo '<pre>Przekazuje dokumenty: '.print_r($_POST['documentid'], true).'</pre>';