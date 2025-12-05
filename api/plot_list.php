<?php
header('Content-Type: application/json');
require_once 'connection.php';

$conn = getConnection();

// Get search term
$search = isset($_GET['search']['value']) ? $conn->real_escape_string($_GET['search']['value']) : '';
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;

// Build query
$where = "WHERE is_deleted = FALSE";
if (!empty($search)) {
    $where .= " AND (location LIKE '%{$search}%' OR description LIKE '%{$search}%')";
}

// Get total records
$total_query = "SELECT COUNT(*) as total FROM plots WHERE is_deleted = FALSE";
$total_result = $conn->query($total_query);
$total_data = $total_result->fetch_assoc();
$total = $total_data['total'];

// Get filtered count
$filtered_query = "SELECT COUNT(*) as filtered FROM plots $where";
$filtered_result = $conn->query($filtered_query);
$filtered_data = $filtered_result->fetch_assoc();
$filtered = $filtered_data['filtered'];

// Get data
$query = "SELECT * FROM plots $where ORDER BY created_at DESC LIMIT $start, $length";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'id' => $row['id'],
        'location' => htmlspecialchars($row['location']),
        'description' => htmlspecialchars($row['description']),
        'created_at' => date('Y-m-d H:i', strtotime($row['created_at'])),
        'updated_at' => date('Y-m-d H:i', strtotime($row['updated_at'])),
        'actions' => $row['id'] // Will be processed in JavaScript
    ];
}

$conn->close();

// Return JSON for DataTables
echo json_encode([
    'draw' => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
    'recordsTotal' => $total,
    'recordsFiltered' => $filtered,
    'data' => $data
]);
?>