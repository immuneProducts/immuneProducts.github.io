<?php
$db_host = "localhost";
$db_user = "ch05761_app";
$db_password = "SGhnqB7J";
$db_base = 'ch05761_app';
$db_table = "applications";

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="export.csv";');
echo "\xEF\xBB\xBF";

$conn = new mysqli($db_host, $db_user, $db_password, $db_base);

$sql = "SELECT * FROM applications";
$result = $conn->query($sql);

$fp = fopen('php://output', 'w');

while ($row = $result->fetch_assoc()) {
    fputcsv($fp, $row, ";");
}
$conn->close();
?>