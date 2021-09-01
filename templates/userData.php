<?php
require "../server/databaseConnection.php";
session_start();
if(!(isset($_SESSION['user_data']))){
    header("Location: login.php");
}
if(isset($_SESSION['pass_to_worker'])){
    unset($_SESSION['pass_to_worker']);
}
$userdata = $_SESSION['user_data'];
$privileges = $_SESSION['user_privileges'];
$stmt = $dbh->prepare("SELECT PRACOWNIK_ID, IMIE, NAZWISKO, STANOWISKO, MAGAZYN FROM PRACOWNICY");
$stmt->execute();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manager Faktur - Przekazywanie dokumentów</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="../css/document.css" rel="stylesheet">
    <link href="../css/jumbotron.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap4.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand text-light navbar-text">Manager Faktur v1.0.0</a>
</nav>
<main role="main">
    <div class="jumbotron p-3">
        <div class="container">
            <h1 class="display-5"><a href="dashboard.php" class="text-dark return-btn"> < </a>  Zmień dane osobowe</h1>
        </div>
    </div>

    <div class="container">
        <form action="../server/updateUserData.php" method="post">
            <div class="form-group">
                <label for="imie">Imię:</label>
                <input type="text" name="imie" class="form-control" value="<?php echo $_SESSION['user_data'][0]['IMIE']; ?>" id="imie" placeholder="Wprowadź imię">
            </div>
            <div class="form-group">
                <label for="nazwisko">Nazwisko:</label>
                <input type="text" name="nazwisko" class="form-control" value="<?php echo $_SESSION['user_data'][0]['NAZWISKO']; ?>" id="nazwisko" placeholder="Wprowadź nazwisko">
            </div>
            <div class="form-group">
                <label for="kod">Kod logowania:</label>
                <input type="text" name="kod" class="form-control" value="<?php echo $_SESSION['user_data'][0]['KOD_LOGOWANIA']; ?>" id="kod" placeholder="Wprowadź kod logowania">
            </div>
            <div class="form-group">
                <label for="stanowisko">Stanowisko:</label>
                <input type="text" name="stanowisko" class="form-control" value="<?php echo $_SESSION['user_data'][0]['STANOWISKO']; ?>" id="stanowisko" placeholder="Wprowadź stanowisko">
            </div>
            <div class="form-group">
                <label for="magazyn">Magazyn:</label>
                <input type="text" name="magazyn" class="form-control" value="<?php echo $_SESSION['user_data'][0]['MAGAZYN']; ?>" id="kod" placeholder="Wprowadź magazyn">
            </div>
            <button type="submit" class="btn btn-info">Zmień dane</button>
        </form>
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="../js/document.js"></script>
</body>
</html>
