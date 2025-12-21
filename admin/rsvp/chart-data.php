<?php
// admin/rsvp/chart-data.php
require_once '../../config/config.php';
require_once '../../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$total_attending = $conn->query("SELECT COUNT(*) as count FROM rsvp WHERE attendance = 'Yes'")->fetch_assoc()['count'];
$total_not_attending = $conn->query("SELECT COUNT(*) as count FROM rsvp WHERE attendance = 'No'")->fetch_assoc()['count'];

$data = [
    ['value' => (int)$total_attending, 'name' => 'Attending'],
    ['value' => (int)$total_not_attending, 'name' => 'Not Attending']
];

echo json_encode($data);
?>
