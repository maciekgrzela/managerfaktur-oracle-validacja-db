<?php
foreach(PDO::getAvailableDrivers() as $driver)
    echo $driver, '<br>';


$tns = "
    (DESCRIPTION =
        (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
        (CONNECT_DATA =
            (SERVER = localhost)
            (SERVICE_NAME = xe)
        )
    )
";
$pdo_string = 'oci:dbname='.$tns;

try {
    $dbh = new PDO($pdo_string, 'ManagerFaktur', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed to obtain database handle: " . $e->getMessage();
    exit;
}

?>