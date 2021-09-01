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
$stmt = $dbh->prepare("SELECT DOKUMENT_ID, NUMER_DOKUMENTU, NAZWA, RODZAJ_PLATNOSCI, KWOTA FROM DOKUMENTY JOIN PLATNICY USING(PLATNIK_ID)");
$stmt->execute();
$stmt2 = $dbh->prepare("SELECT DOKUMENT_ID, NVL(MAX(ODBIORCA_ID) KEEP (DENSE_RANK FIRST ORDER BY DATA_PRZEKAZANIA DESC), 0) AS OSTATNI FROM PRZEKAZANIA_DOKUMENTOW GROUP BY DOKUMENT_ID");
$stmt2->execute();
$stmt3 = $dbh->prepare("SELECT PRACOWNIK_ID, CONCAT(CONCAT(IMIE, ' '), NAZWISKO) AS DANE FROM PRACOWNICY WHERE PRACOWNIK_ID IN (SELECT MAX(ODBIORCA_ID) KEEP (DENSE_RANK FIRST ORDER BY DATA_PRZEKAZANIA DESC) AS ODBIORCA FROM PRZEKAZANIA_DOKUMENTOW GROUP BY DOKUMENT_ID)");
$stmt3->execute();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manager Faktur - Sledz faktury</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="../css/document.css" rel="stylesheet">
    <link href="../css/jumbotron.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand text-light navbar-text">Manager Faktur v1.0.0</a>
</nav>
<main role="main">
    <div class="jumbotron p-3">
        <div class="container">
            <h1 class="display-5"><a href="dashboard.php" class="text-dark return-btn"> < </a>  Śledź faktury</h1>
        </div>
    </div>

    <div class="container">
        <table id="track-docs" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
            <tr>
                <th>ID</th>
                <th>Płatnik</th>
                <th>Rodzaj płatności</th>
                <th>Kwota</th>
                <th>Aktualnie u:</th>
                <th>Droga</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $names = $stmt3->fetchAll(PDO::FETCH_KEY_PAIR);
            $passes = $stmt2->fetchAll(PDO::FETCH_KEY_PAIR);
            function formatRow($owner){
                if($owner == ""){
                }else if ($owner == "KLIENT"){
                    return 'table-success';
                }else {
                    return 'table-warning';
                }
            }
            function getLastWorker($docid, $passes, $names){
                if(in_array($docid, array_keys($passes))){
                    if($passes[$docid] != 0){
                        return $names[$passes[$docid]];
                    }else {
                        return "KLIENT";
                    }
                }else {
                    return "";
                }
            }
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $owner = getLastWorker($row['DOKUMENT_ID'], $passes, $names);
                echo '
                        <tr class="'.formatRow($owner).'">
                            <td>'.$row['NUMER_DOKUMENTU'].'</td>
                            <td>'.$row['NAZWA'].'</td>
                            <td>'.$row['RODZAJ_PLATNOSCI'].'</td>
                            <td>'.$row['KWOTA'].'</td>
                            <td>'.$owner.'</td>
                            <td class="text-center"><i data-document-id="'.$row['DOKUMENT_ID'].'" class="fa fa-bars show-history"></i></td>
                        </tr>
                    ';
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="history-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="h-body p-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 history-body"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../js/trackDocs.js"></script>
</body>
</html>
