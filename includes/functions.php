<?php
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function formatMoney($amount) {
    return 'AED ' . number_format($amount, 2);
}

function formatDate($date) {
    return date('Y-m-d', strtotime($date));
}

function getClientById($pdo, $client_id) {
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$client_id]);
    return $stmt->fetch();
}

function getClientByUserId($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

function getUnits($pdo, $filters = []) {
    $sql = "SELECT * FROM units WHERE 1=1";
    $params = [];
    
    if (!empty($filters['type'])) {
        $sql .= " AND unit_type = ?";
        $params[] = $filters['type'];
    }
    
    if (!empty($filters['status'])) {
        $sql .= " AND status = ?";
        $params[] = $filters['status'];
    }
    
    $sql .= " ORDER BY unit_code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function createAuditLog($pdo, $user_id, $action, $table_name, $record_id, $old_data = null, $new_data = null) {
    $stmt = $pdo->prepare("INSERT INTO audit_log (user_id, action, table_name, record_id, old_data, new_data, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        $user_id,
        $action,
        $table_name,
        $record_id,
        $old_data ? json_encode($old_data) : null,
        $new_data ? json_encode($new_data) : null,
        $_SERVER['REMOTE_ADDR']
    ]);
}
?>