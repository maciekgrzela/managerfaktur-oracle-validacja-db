<?php
require "databaseConnection.php";
session_start();
try {
    $stmt = $dbh->prepare("UPDATE PRACOWNICY SET IMIE=?, NAZWISKO=?, KOD_LOGOWANIA=?, STANOWISKO=?, MAGAZYN=? WHERE PRACOWNIK_ID=?");
    $stmt->execute([$_POST['imie'],$_POST['nazwisko'], $_POST['kod'], $_POST['stanowisko'], $_POST['magazyn'], $_SESSION['user_data'][0]['PRACOWNIK_ID']]);
}catch(PDOException $e){
    $_SESSION['pass_to_worker_info'] = "Nie udało się zmienić danych osobowych";
    header("Location: ../templates/dashboard.php");
}
$_SESSION['pass_to_worker_info'] = "Pomyślnie zmieniono dane osobowe. Zmiana będzie widoczna po ponownym zalogowaniu";
header("Location: ../templates/dashboard.php");