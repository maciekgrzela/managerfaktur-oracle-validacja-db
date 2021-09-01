<?php
require "databaseConnection.php";
session_start();
if(isset($_POST['loginCode']) && !empty($_POST['loginCode'])){
    $stmt = $dbh->prepare("SELECT PRACOWNIK_ID, IMIE, NAZWISKO, KOD_LOGOWANIA, STANOWISKO, MAGAZYN FROM PRACOWNICY WHERE KOD_LOGOWANIA=?");
    $stmt->execute([$_POST['loginCode']]);
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($user) == 1){
        $_SESSION['logged'] = true;
        $_SESSION['login_status'] = "Zalogowano pomyslnie";
        $_SESSION['user_data'] = $user;
        $stmt = $dbh->prepare("SELECT UPRAWNIENIE_ID FROM UPRAWNIENIA_PRACOWNIKOW WHERE PRACOWNIK_ID =?");
        $stmt->execute([$_SESSION['user_data'][0]['PRACOWNIK_ID']]);
        $userPrivileges = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $_SESSION['user_privileges'] = $userPrivileges;
        header("Location: ../templates/dashboard.php");
    }else {
        if(isset($_SESSION['logged'])){
            unset($_SESSION['logged']);
        }
        $_SESSION['login_status'] = "Pracownik o podanym kodzie nie istnieje";
        $_SESSION['user_data'] = array();
        header("Location: ../index.php");
    }
}else {
    if(isset($_SESSION['logged'])){
        unset($_SESSION['logged']);
    }
    $_SESSION['login_status'] = "Pracownik o podanym kodzie nie istnieje";
    $_SESSION['user_data'] = array();
    header("Location: ../index.php");
}
?>