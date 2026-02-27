<?php
// api/units.php - Full path check
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Path debugging
$possiblePaths = [
    __DIR__ . '/../config/database.php',
    dirname(__DIR__) . '/config/database.php',
    $_SERVER['DOCUMENT_ROOT'] . '/warehouse-portal/config/database.php'
];

$dbFound = false;
foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        require_once $path;
        $dbFound = true;
        break;
    }
}

if (!$dbFound) {
    echo json_encode(['error' => 'Database file not found']);
    exit();
}

require_once dirname(__DIR__) . '/includes/session.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized - Please login as admin']);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    switch ($method) {
        case 'GET':
            if ($action === 'get_unit' && isset($_GET['id'])) {
                $stmt = $pdo->prepare("SELECT * FROM units WHERE id = ?");
                $stmt->execute([$_GET['id']]);
                $unit = $stmt->fetch();
                echo json_encode($unit ?: ['error' => 'Unit not found']);
            } 
            elseif ($action === 'get_unit_by_code' && isset($_GET['code'])) {
                $stmt = $pdo->prepare("SELECT * FROM units WHERE unit_code = ?");
                $stmt->execute([$_GET['code']]);
                $unit = $stmt->fetch();
                echo json_encode($unit ?: ['error' => 'Unit not found']);
            }
            else {
                // Check if table exists
                try {
                    $stmt = $pdo->query("SHOW TABLES LIKE 'units'");
                    if ($stmt->rowCount() == 0) {
                        echo json_encode([
                            'units' => [],
                            'counts' => [
                                'total' => 0,
                                'occupied' => 0,
                                'available' => 0,
                                'offhire' => 0,
                                'expiring' => 0
                            ],
                            'next_ids' => [
                                'shed' => 1,
                                'container' => 1
                            ],
                            'debug' => 'Units table does not exist'
                        ]);
                        exit();
                    }
                } catch (Exception $e) {
                    // Table doesn't exist, return empty data
                    echo json_encode([
                        'units' => [],
                        'counts' => [
                            'total' => 0,
                            'occupied' => 0,
                            'available' => 0,
                            'offhire' => 0,
                            'expiring' => 0
                        ],
                        'next_ids' => [
                            'shed' => 1,
                            'container' => 1
                        ]
                    ]);
                    exit();
                }

                // Get all units
                $stmt = $pdo->query("SELECT * FROM units ORDER BY 
                    CASE 
                        WHEN unit_type = 'shed' THEN 1 
                        ELSE 2 
                    END, unit_code");
                $units = $stmt->fetchAll();
                
                // Get counts
                $totalUnits = count($units);
                $occupiedUnits = 0;
                $availableUnits = 0;
                $offhireUnits = 0;
                $expiringUnits = 0;

                foreach ($units as $unit) {
                    switch($unit['status']) {
                        case 'occupied':
                        case 'partial':
                            $occupiedUnits++;
                            break;
                        case 'available':
                            $availableUnits++;
                            break;
                        case 'offhire':
                            $offhireUnits++;
                            break;
                        case 'expiring':
                            $expiringUnits++;
                            break;
                    }
                }

                // Get next IDs
                $lastShed = 0;
                $lastContainer = 0;
                foreach ($units as $unit) {
                    if ($unit['unit_type'] === 'shed') {
                        preg_match('/(\d+)/', $unit['unit_code'], $matches);
                        if (isset($matches[1])) {
                            $lastShed = max($lastShed, (int)$matches[1]);
                        }
                    } else {
                        preg_match('/(\d+)/', $unit['unit_code'], $matches);
                        if (isset($matches[1])) {
                            $lastContainer = max($lastContainer, (int)$matches[1]);
                        }
                    }
                }

                echo json_encode([
                    'units' => $units,
                    'counts' => [
                        'total' => $totalUnits,
                        'occupied' => $occupiedUnits,
                        'available' => $availableUnits,
                        'offhire' => $offhireUnits,
                        'expiring' => $expiringUnits
                    ],
                    'next_ids' => [
                        'shed' => $lastShed + 1,
                        'container' => $lastContainer + 1
                    ]
                ]);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                $data = $_POST;
            }

            if ($action === 'add_unit') {
                // Validate
                if (empty($data['unit_type']) || empty($data['zone'])) {
                    echo json_encode(['error' => 'Unit type and zone are required']);
                    exit();
                }

                if ($data['unit_type'] === 'container' && empty($data['size'])) {
                    echo json_encode(['error' => 'Container size is required']);
                    exit();
                }

                if (($data['status'] ?? '') === 'offhire' && empty($data['offhire_reason'])) {
                    echo json_encode(['error' => 'Off-hire reason is required']);
                    exit();
                }

                // Set default rates
                $daily_rate = ($data['unit_type'] === 'shed') ? 50.00 : 25.00;
                $monthly_rate = ($data['unit_type'] === 'shed') ? 1200.00 : 600.00;
                $can_share = ($data['unit_type'] === 'shed') ? 1 : 0;
                
                // Location label
                $location_label = trim(($data['row_area'] ?? '') . ' ' . ($data['bay_position'] ?? ''));

                $stmt = $pdo->prepare("INSERT INTO units 
                    (unit_code, unit_type, zone, location_label, size, status, daily_rate, monthly_rate, can_share, notes, row_area, bay_position, dimensions, offhire_reason, internal_label) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                
                $result = $stmt->execute([
                    $data['unit_code'],
                    $data['unit_type'],
                    $data['zone'],
                    $location_label,
                    $data['size'] ?? null,
                    $data['status'] ?? 'available',
                    $daily_rate,
                    $monthly_rate,
                    $can_share,
                    $data['notes'] ?? null,
                    $data['row_area'] ?? null,
                    $data['bay_position'] ?? null,
                    $data['dimensions'] ?? null,
                    $data['offhire_reason'] ?? null,
                    $data['internal_label'] ?? null
                ]);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Unit added successfully', 'id' => $pdo->lastInsertId()]);
                } else {
                    echo json_encode(['error' => 'Failed to add unit']);
                }
            }
            elseif ($action === 'edit_unit') {
                $id = $data['id'] ?? 0;
                
                $location_label = trim(($data['row_area'] ?? '') . ' ' . ($data['bay_position'] ?? ''));
                
                $stmt = $pdo->prepare("UPDATE units SET 
                    unit_type = ?,
                    zone = ?,
                    location_label = ?,
                    size = ?,
                    status = ?,
                    notes = ?,
                    row_area = ?,
                    bay_position = ?,
                    dimensions = ?,
                    offhire_reason = ?,
                    internal_label = ?
                    WHERE id = ?");
                
                $result = $stmt->execute([
                    $data['unit_type'],
                    $data['zone'],
                    $location_label,
                    $data['size'] ?? null,
                    $data['status'],
                    $data['notes'] ?? null,
                    $data['row_area'] ?? null,
                    $data['bay_position'] ?? null,
                    $data['dimensions'] ?? null,
                    $data['offhire_reason'] ?? null,
                    $data['internal_label'] ?? null,
                    $id
                ]);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Unit updated successfully']);
                } else {
                    echo json_encode(['error' => 'Failed to update unit']);
                }
            }
            break;

        case 'DELETE':
            if ($action === 'delete_unit' && isset($_GET['id'])) {
                $id = $_GET['id'];
                
                $stmt = $pdo->prepare("DELETE FROM units WHERE id = ?");
                $result = $stmt->execute([$id]);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Unit deleted successfully']);
                } else {
                    echo json_encode(['error' => 'Failed to delete unit']);
                }
            }
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>