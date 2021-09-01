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
$stmt = $dbh->prepare("SELECT DOKUMENT_ID, NUMER_DOKUMENTU, NAZWA_PLATNIKA, KWOTA, KOD_TYPU, TRESC_UWAGI, DATA_WYSTAWIENIA FROM ARCHIWUM");
$stmt->execute();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manager Faktur - Archiwum</title>
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
            <h1 class="display-5"><a href="dashboard.php" class="text-dark return-btn"> < </a>  Archiwum</h1>
        </div>
    </div>

    <div class="container">
        <table id="workers" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
            <tr>
                <th>Dokument</th>
                <th>Numer</th>
                <th>Płatnik</th>
                <th>Kwota</th>
                <th>Typ uwagi</th>
                <th>Treść uwagi</th>
                <th>Data wystawienia</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo '
                        <tr>
                            <td>'.$row['DOKUMENT_ID'].'</td>
                            <td>'.$row['NUMER_DOKUMENTU'].'</td>
                            <td>'.$row['NAZWA_PLATNIKA'].'</td>
                            <td>'.$row['KWOTA'].'</td>
                            <td>'.$row['KOD_TYPU'].'</td>
                            <td>'.$row['TRESC_UWAGI'].'</td>
                            <td>'.$row['DATA_WYSTAWIENIA'].'</td>
                        </tr>
                    ';
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<footer class="container">
    <hr>
    <p>&copy; ManagerFaktur 2019</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="../js/document.js"></script>
</body>
</html>
