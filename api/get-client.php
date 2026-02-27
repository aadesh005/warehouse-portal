<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$clientCode = $_GET['code'] ?? '';

if (empty($clientCode)) {
    echo json_encode(['error' => 'Client code required']);
    exit();
}

// Get client data
$stmt = $pdo->prepare("SELECT c.*, u.username FROM clients c 
                       JOIN users u ON c.user_id = u.id 
                       WHERE c.client_code = ?");
$stmt->execute([$clientCode]);
$client = $stmt->fetch();

if (!$client) {
    echo json_encode(['error' => 'Client not found']);
    exit();
}

// Get units data
$unitStmt = $pdo->prepare("SELECT 
    COUNT(*) as total_units,
    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_units 
    FROM units WHERE client_id = ?");
$unitStmt->execute([$client['id']]);
$units = $unitStmt->fetch();

// Get balance data
$balanceStmt = $pdo->prepare("SELECT 
    SUM(CASE WHEN status = 'paid' THEN 0 ELSE amount END) as outstanding,
    MAX(payment_date) as last_payment 
    FROM invoices WHERE client_id = ?");
$balanceStmt->execute([$client['id']]);
$balance = $balanceStmt->fetch();

$clientData = [
    'id' => $client['id'],
    'client_code' => $client['client_code'],
    'client_type' => $client['client_type'],
    'company_name' => $client['company_name'],
    'full_name' => $client['full_name'],
    'email' => $client['email'],
    'phone' => $client['phone'],
    'address' => $client['address'],
    'trn' => $client['trn'],
    'billing_pref' => $client['billing_preference'],
    'status' => $client['status'] ?? 'active',
    'contact_name' => $client['primary_contact_name'],
    'contact_role' => $client['primary_contact_role'],
    'alt_contact' => $client['alt_contact'],
    'notes' => $client['internal_notes'],
    'username' => $client['username'],
    'units_active' => $units['active_units'] ?? 0,
    'units_total' => $units['total_units'] ?? 0,
    'balance' => $balance['outstanding'] ?? 0,
    'last_payment' => $balance['last_payment'] ?? 'N/A',
    'next_expiry' => $client['next_expiry'] ?? 'N/A'
];

echo json_encode($clientData);