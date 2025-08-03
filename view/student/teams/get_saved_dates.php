<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

$year = intval($_GET['year'] ?? date('Y'));
$month = intval($_GET['month'] ?? date('m'));

$start = sprintf('%04d-%02d-01', $year, $month);
$end = date("Y-m-t", strtotime($start));

$stmt = $conn->prepare("SELECT defense_date FROM tbl_defdates WHERE defense_date BETWEEN ? AND ?");
$stmt->execute([$start, $end]);
$dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($dates);
?>