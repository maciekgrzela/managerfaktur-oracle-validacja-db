<?php
require "../server/databaseConnection.php";
session_start();
if(!(isset($_SESSION['user_data']))){
    header("Location: login.php");
}
$userdata = $_SESSION['user_data'];
$privileges = $_SESSION['user_privileges'];
$stmt = $dbh->prepare("SELECT PLATNIK_ID, NAZWA, MIASTO, ULICA, PROCENT_RABATU FROM PLATNICY");
$stmt->execute();
$stmt2 = $dbh->prepare("SELECT TYP_ID, OPIS FROM TYPY_DOKUMENTOW");
$stmt2->execute();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manager Faktur - Wprowadzanie dokumentów</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../css/document.css" rel="stylesheet">
    <link href="../css/jumbotron.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand text-light navbar-text">Manager Faktur v1.0.0</a>
</nav>
<main role="main">
    <div class="jumbotron p-3">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-xs-12">
                    <h1 class="display-5"><a href="dashboard.php" class="text-dark return-btn"> < </a>  Wprowadź dokument do systemu</h1>
                </div>
                <div class="col-md-3 col-xs-12 text-center my-auto">
                    <button type="button" class="btn btn-insert-doc btn-lg btn-block btn-info">Dodaj</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="form-group">
                        <div>
                            <label for="type-id-label">Typ dokumentu:</label>
                            <input type="text" class="form-control type-blocked" id="type-id-label" placeholder="Wybierz typ dokumentu" disabled>
                        </div>
                        <div class="mt-3">
                            <table id="types" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>TYP_ID</th>
                                    <th>Opis typu</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                    echo '
                        <tr data-type-id="'.$row['TYP_ID'].'">
                            <td>'.$row['TYP_ID'].'</td>
                            <td>'.$row['OPIS'].'</td>
                        </tr>
                        ';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="client-id-label">Identyfikator płatnika:</label>
                            <input type="text" class="clients-blocked form-control" id="client-id-label" placeholder="Wybierz płatnika" disabled>
                        </div>
                        <div class="mt-3">
                            <table id="clients" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Nazwa</th>
                                    <th>Miasto</th>
                                    <th>Adres</th>
                                    <th>Proc. rabatu</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    echo '
                        <tr data-client-id="'.$row['PLATNIK_ID'].'">
                            <td>'.$row['NAZWA'].'</td>
                            <td>'.$row['MIASTO'].'</td>
                            <td>'.$row['ULICA'].' PLN</td>
                            <td>'.$row['PROCENT_RABATU'].'</td>
                        </tr>
                        ';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="delivery-id-label">Identyfikator miejsca dostawy:</label>
                            <input type="text" class="deliveries-blocked form-control" id="delivery-id-label" placeholder="Wybierz miejsce dostawy" disabled>
                        </div>
                        <div class="mt-3">
                            <table id="delivery" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Nazwa</th>
                                    <th>Miasto</th>
                                    <th>Adres</th>
                                    <th>Proc. rabatu</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stmt = $dbh->prepare("SELECT PLATNIK_ID, NAZWA, MIASTO, ULICA, PROCENT_RABATU FROM PLATNICY");
                                $stmt->execute();
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    echo '
                        <tr data-delivery-id="'.$row['PLATNIK_ID'].'">
                            <td>'.$row['NAZWA'].'</td>
                            <td>'.$row['MIASTO'].'</td>
                            <td>'.$row['ULICA'].' PLN</td>
                            <td>'.$row['PROCENT_RABATU'].'</td>
                        </tr>
                        ';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bill-id-label">Numer dokumentu:</label>
                        <input type="text" class="document-number form-control" id="bill-id-label" placeholder="Wprowadź numer dokumentu" >
                    </div>
                    <div class="form-group">
                        <label for="amount-id-label">Kwota:</label>
                        <input type="text" class="document-amount form-control" id="amount-id-label" placeholder="Wprowadź kwotę" >
                    </div>
                    <div class="form-group">
                        <label for="payment-id-label">Płatność:</label>
                        <input type="text" class="payment-type form-control" id="payment-id-label" placeholder="Wprowadź rodzaj płatności" >
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="create-datetime" data-target-input="nearest">
                            <label for="create-date" class="mt-auto mr-3">Data wystawienia</label>
                            <input type="text" id="create-date" class="form-control" placeholder="Wprowadź datę wystawienia dokumentu"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="payment-datetime" data-target-input="nearest">
                            <label for="payment-date" class="mt-auto mr-4">Data płatności</label>
                            <input type="text" id="payment-date" class="form-control" placeholder="Wprowadź datę wystawienia dokumentu"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<footer class="container">
    <hr>
    <p>&copy; ManagerFaktur 2019</p>
</footer>
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Wybierz dokument</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Żaden dokument nie został wybrany do przekazania
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="../js/document.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
</body>
</html>