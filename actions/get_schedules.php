<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

header('Content-Type: application/json');

$date = $_GET['date'] ?? '';
if (!$date) {
    echo json_encode([]);
    exit;
}

try {
    // Convert date to SQL format (Y-m-d)
    $sqlDate = date('Y-m-d', strtotime($date));

    $stmt = $pdo->prepare("
        SELECT 
            t.*,
            rd.def_date,
            rd.def_time,

            COALESCE(CONCAT(adv.first_name,' ', adv.last_name), 'n/a') AS adviser_name,
            GROUP_CONCAT(DISTINCT CONCAT(m.first_name, ' ', m.last_name) SEPARATOR '\n ') AS members
        FROM teams t
        INNER JOIN request_dates rd 
            ON rd.team_id = t.team_id
            AND rd.def_date = :def_date
        LEFT JOIN users adv ON t.adviser_id = adv.user_id

        LEFT JOIN team_members tm ON t.team_id = tm.team_id
        LEFT JOIN users m ON tm.user_id = m.user_id
        GROUP BY t.team_id, rd.def_date, rd.def_time
        ORDER BY rd.def_time ASC
    ");

    $stmt->execute([':def_date' => $sqlDate]);
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($schedules);

} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
