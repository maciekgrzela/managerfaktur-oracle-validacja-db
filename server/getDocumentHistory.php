<?php
require "databaseConnection.php";
session_start();
$docid = $_POST['doc'];

$stmt = $dbh->prepare("SELECT p.IMIE, p.NAZWISKO, TO_CHAR(pd.DATA_PRZEKAZANIA, 'dd/mm/yy hh24:mi:ss') AS DATA FROM PRZEKAZANIA_DOKUMENTOW pd, PRACOWNICY p WHERE pd.ODBIORCA_ID = p.PRACOWNIK_ID AND pd.DOKUMENT_ID=? ORDER BY pd.DATA_PRZEKAZANIA ASC");
$stmt->execute([$docid]);

$history = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($history) > 0){
    $retStr = "";
    $retStr .= '<ul class="list-group">';
    for($i = 0; $i < count($history); $i++){
        $retStr .= '<a href="#" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Numer przekazania: '.($i+1).'</h5>
    </div>
    <p class="mb-1">Przekazano dla: '.$history[$i]['IMIE'].' '.$history[$i]['NAZWISKO'].'</p>
    <small class="text-muted">Data: '.$history[$i]['DATA'].'</small>
  </a>';
    }
    $retStr .= '</ul>';
    echo $retStr;
}else {
    echo "Brak historii przekazań tego dokumentu";
}