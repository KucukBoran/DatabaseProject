<?php
$serverName = "DESKTOP-MT912UL\SQLEXPRESS"; // SQL Server sunucu adı
$connectionOptions = array(
    "Database" => "DatabaseProject",        // Veritabanı adı
    "Uid" => "",                           // SQL Server kullanıcı adı
    "PWD" => ""                            // SQL Server şifre
);

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database={$connectionOptions['Database']}", $connectionOptions['Uid'], $connectionOptions['PWD']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
