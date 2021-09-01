<?php
session_start();
if(!(isset($_SESSION['logged'])) || ($_SESSION['logged'] == false)){
    header("Location: login.php");
}
if(isset($_SESSION['pass_to_worker'])){
    unset($_SESSION['pass_to_worker']);
}
$userdata = $_SESSION['user_data'][0];
$privileges = $_SESSION['user_privileges'];
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manager Faktur - Zalogowany użytkownik</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="../css/dashboard.css" rel="stylesheet">
    <link href="../css/jumbotron.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand text-light navbar-text">Manager Faktur v1.0.0</a>
    <form class="form-inline" action="../server/logout.php" method="post">
        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Wyloguj</button>
    </form>
</nav>
<main role="main">
    <div class="jumbotron p-3">
        <div class="container">
            <h1 class="display-5">Witaj, <?php echo $userdata["IMIE"]." ".$userdata["NAZWISKO"]; ?>!</h1>
            <h6 class="display-6 d-none d-md-block">Kod logowania: <b><?php echo $userdata['KOD_LOGOWANIA']; ?></b> | Stanowisko: <b><?php echo $userdata['STANOWISKO']; ?></b> | Przypisany magazyn: <b><?php echo $userdata['MAGAZYN']; ?></b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="operation-info alert <?php if(isset($_SESSION['pass_to_worker_info'])) { echo 'alert-dark';}else{ echo 'd-none';} ?>" role="alert">
                    <?php if(isset($_SESSION['pass_to_worker_info'])){ echo $_SESSION['pass_to_worker_info']; unset($_SESSION['pass_to_worker_info']);} ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container options">
        <div class="row">
            <div class="col-md-12">
                <p class="text-dark section-title section-first">Zarządzanie fakturami</p>
                <hr class="border-secondary">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <a href="insertDocument.php" class="btn btn-block btn-info <?php if(!(in_array(1, $privileges))) echo 'disabled';?>">Wprowadź fakturę do systemu</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a href="passToWorker.php" class="btn btn-block btn-info <?php if(!(in_array(2, $privileges))) echo 'disabled';?>">Przekaż fakturę pracownikowi</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a class="client-pass text-white btn btn-block btn-info <?php if(!(in_array(3, $privileges))) echo 'disabled';?>">Przekaż fakturę klientowi</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <a href="addWarning.php" class="btn btn-block btn-info <?php if(!(in_array(4, $privileges))) echo 'disabled';?>">Dodaj uwagę do faktury</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a href="addExplanation.php" class="btn btn-block btn-info <?php if(!(in_array(5, $privileges))) echo 'disabled';?>">Dodaj wyjasnienie do faktury</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a href="toArchive.php" class="btn btn-block btn-info <?php if(!(in_array(8, $privileges))) echo 'disabled';?>">Przenieś fakturę do archiwum</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <a href="trackDocuments.php" class="btn btn-block btn-info <?php if(!(in_array(6, $privileges))) echo 'disabled';?>">Śledź faktury</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a href="archive.php" class="btn btn-block btn-info <?php if(!(in_array(11, $privileges))) echo 'disabled';?>">Wyświetl zawartość archiwum</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="text-dark section-title">Ustawienia administracyjne</p>
                <hr class="border-secondary">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <a href="privileges.php" class="btn btn-block btn-info <?php if(!(in_array(10, $privileges))) echo 'disabled';?>">Zarządzaj uprawnieniami pracowników</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a href="views.php" class="btn btn-block btn-info <?php if(!(in_array(12, $privileges))) echo 'disabled';?>">Zarządzaj widokami pracowników</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a href="workers.php" class="btn btn-block btn-info <?php if(!(in_array(9, $privileges))) echo 'disabled';?>">Zarządzaj pracownikami</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <a href="documents.php" class="btn btn-block btn-info <?php if(!(in_array(13, $privileges))) echo 'disabled';?>">Zarządzaj dokumentami</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a href="clients.php" class="btn btn-block btn-info <?php if(!(in_array(14, $privileges))) echo 'disabled';?>">Zarządzaj płatnikami</a>
            </div>
            <div class="col-md-4 col-xs-12">
                <a href="userData.php" class="btn btn-block btn-info <?php if(!(in_array(7, $privileges))) echo 'disabled';?>">Zmień dane osobowe</a>
            </div>
        </div>
    </div>
</main>
<footer class="container">
    <hr>
    <p>&copy; ManagerFaktur 2019</p>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="../js/dashboard.js"></script>
</body>
</html>
