<?php
// Start session and include database
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle traditional form posts (if any)
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // This will be handled by API now, but keep for backward compatibility
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Clients - RGSL</title>
    <style>
        :root {
            --orange: #f26a21;
            --green: #1aa34a;
            --bg: #f6f8fb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e5e7eb;
            --shadow: 0 10px 24px rgba(15, 23, 42, .08);
            --radius: 16px;
            --bad: #dc2626;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: linear-gradient(90deg, var(--orange), var(--green));
            padding: 14px 18px;
            box-shadow: var(--shadow);
        }

        .topbar {
            background: #fff;
            border-radius: 18px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand img {
            height: 44px;
        }

        .brand h1 {
            font-size: 16px;
            margin: 0;
        }

        .brand p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .btn {
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text);
            padding: 8px 10px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 900;
            font-size: 12px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn.primary {
            background: var(--green);
            border-color: var(--green);
            color: #fff;
        }

        .btn.orange {
            background: var(--orange);
            border-color: var(--orange);
            color: #fff;
        }

        .btn.danger {
            background: var(--bad);
            border-color: var(--bad);
            color: #fff;
        }

        .btn.ghost {
            background: #fff;
        }

        .wrap {
            margin: 16px auto;
            padding: 0 18px;
        }

        .shell {
            display: flex;
            gap: 12px;
        }

        aside {
            width: 270px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 12px;
            height: calc(100vh - 130px);
            position: sticky;
            top: 92px;
            overflow: auto;
        }

        .navTitle {
            font-weight: 1000;
            font-size: 12px;
            color: var(--muted);
            margin: 6px 8px 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 12px;
            text-decoration: none;
            color: #111;
            margin-bottom: 6px;
            font-weight: 1000;
            font-size: 13px;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .nav a:hover {
            background: #eef6f0;
            color: var(--green);
        }

        .nav a.active {
            background: #eef6f0;
            border-color: #d1fae5;
            color: #14532d;
        }

        main {
            flex: 1;
            min-width: 0;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px;
            box-shadow: var(--shadow);
            margin-bottom: 12px;
        }

        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        h2 {
            font-size: 14px;
            margin: 0 0 10px 0;
        }

        .muted {
            color: var(--muted);
        }

        .small {
            font-size: 12px;
        }

        .hr {
            height: 1px;
            background: var(--border);
            margin: 12px 0;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            border: 1px solid var(--border);
            background: #fff;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dot.green {
            background: var(--green);
        }

        .dot.orange {
            background: var(--orange);
        }

        .dot.red {
            background: var(--bad);
        }

        .dot.gray {
            background: #94a3b8;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 900;
        }

        .b-green {
            background: #dcfce7;
            color: #166534;
        }

        .b-orange {
            background: #ffedd5;
            color: #9a3412;
        }

        .b-red {
            background: #fee2e2;
            color: #991b1b;
        }

        .b-gray {
            background: #e2e8f0;
            color: #334155;
        }

        .b-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .kpis {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
        }

        .kpi {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px;
            background: #fff;
        }

        .kpi .label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 900;
        }

        .kpi .value {
            font-size: 18px;
            font-weight: 1000;
            margin-top: 6px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 10px;
        }

        .col3 {
            grid-column: span 3;
        }

        .col4 {
            grid-column: span 4;
        }

        .col6 {
            grid-column: span 6;
        }

        .col12 {
            grid-column: span 12;
        }

        label {
            display: block;
            margin-bottom: 4px;
            font-weight: 900;
            font-size: 12px;
            color: var(--muted);
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            font-weight: 700;
            color: var(--text);
            font-size: 13px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(26, 163, 74, 0.1);
        }

        input[readonly] {
            background: #f8fafc;
            cursor: not-allowed;
        }

        textarea {
            min-height: 92px;
            resize: vertical;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: top;
        }

        th {
            color: var(--muted);
            font-weight: 900;
            font-size: 12px;
            background: #f8fafc;
        }

        tr:hover {
            background: #f8fafc;
        }

        .link {
            cursor: pointer;
            color: var(--green);
            font-weight: 900;
        }

        /* Modal */
        .backdrop {
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, .55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 60;
            padding: 18px;
        }

        .backdrop.open {
            display: flex;
        }

        .modal {
            width: min(980px, 100%);
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
            border: 1px solid var(--border);
            overflow: hidden;
            max-height: 86vh;
            display: flex;
            flex-direction: column;
        }

        .modal header {
            position: relative;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
        }

        .modal header h3 {
            margin: 0;
            font-size: 16px;
        }

        .modal .body {
            padding: 14px 16px;
            overflow: auto;
        }

        .modal .footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .x {
            position: absolute;
            right: 12px;
            top: 12px;
        }

        /* Drawer for Client Profile */
        .drawer {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: min(720px, 96vw);
            background: #fff;
            border-left: 1px solid var(--border);
            box-shadow: -20px 0 40px rgba(0, 0, 0, .12);
            transform: translateX(110%);
            transition: transform 0.3s ease;
            z-index: 50;
            display: flex;
            flex-direction: column;
        }

        .drawer.open {
            transform: translateX(0);
        }

        .drawerHeader {
            padding: 14px;
            border-bottom: 1px solid var(--border);
            background: #fff;
        }

        .drawerBody {
            padding: 14px;
            overflow: auto;
            flex: 1;
        }

        .drawerFooter {
            padding: 12px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            flex-wrap: wrap;
            background: #fff;
        }

        .tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin: 10px 0 6px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
        }

        .tab {
            border: 1px solid var(--border);
            background: #fff;
            padding: 8px 10px;
            border-radius: 12px;
            font-weight: 900;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab:hover {
            background: #f8fafc;
        }

        .tab.active {
            background: var(--green);
            border-color: var(--green);
            color: #fff;
        }

        .hidden {
            display: none;
        }

        .message {
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-weight: 900;
        }

        .message.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .message.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: var(--muted);
        }

        @media (max-width: 1100px) {
            aside {
                display: none;
            }

            .kpis {
                grid-template-columns: repeat(2, 1fr);
            }

            .col3,
            .col4,
            .col6,
            .col12 {
                grid-column: span 12;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="topbar">
            <div class="brand">
                <img alt="RGSL Logo" src="https://royalgulfshipping.com/wp-content/uploads/2025/11/RGSL-LOGO.png" />
                <div>
                    <h1>Clients</h1>
                    <p>Admin Portal • Client Management</p>
                </div>
            </div>
            <div class="actions">
                <button class="btn orange" onclick="openAddClientModal()">+ Add Client</button>
                <button class="btn" onclick="exportCSV()">Export CSV</button>
                <button class="btn primary" onclick="location.href='dashboard.php'">Dashboard</button>
            </div>
        </div>
    </header>

    <div class="wrap">
        <div class="shell">
            <!-- Sidebar -->
            <aside>
                <div class="navTitle">ADMIN MENU</div>
                <div class="nav">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="clients.php" class="active">Clients</a>
                    <a href="facility.php">Facility Map</a>
                    <a href="units.php">Unit Analytics</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="notices.php">Notices & Legal</a>
                    <a href="reports.php">Reports</a>
                </div>
                <div class="hr"></div>
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn orange" style="width:100%;margin-bottom:8px" onclick="openAddClientModal()">+ Add Client</button>
                <button class="btn primary" style="width:100%;margin-bottom:8px" onclick="toast('Allocate Unit')">+ Allocate Unit</button>
            </aside>

            <main>
                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <!-- KPIs -->
                <div class="card">
                    <div class="row">
                        <h2>Client KPIs</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill"><span class="dot green"></span>Active</span>
                            <span class="pill"><span class="dot orange"></span>Overdue</span>
                            <span class="pill"><span class="dot red"></span>Legal</span>
                        </div>
                    </div>
                    <div class="kpis" id="kpiContainer">
                        <div class="kpi">
                            <div class="label">Total Clients</div>
                            <div class="value" id="totalClients">0</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Active Clients</div>
                            <div class="value" id="activeClients">0</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Active Units</div>
                            <div class="value" id="activeUnits">0</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Receivables</div>
                            <div class="value" id="receivables">AED 0</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Legal Cycle</div>
                            <div class="value" id="legalClients">0</div>
                        </div>
                    </div>
                </div>

                <!-- Clients Table -->
                <div class="card">
                    <div class="row">
                        <h2>Client List</h2>
                        <span class="pill">Showing: <b id="clientsCount">0</b></span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Client Code</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Units</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="clientsTableBody">
                            <tr>
                                <td colspan="7" class="muted" style="text-align:center;">Loading clients...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Client Modal -->
    <div class="backdrop" id="addClientModal">
        <div class="modal">
            <header>
                <h3>Add New Client</h3>
                <button class="btn ghost x" onclick="closeAddClientModal()">✕</button>
            </header>
            <form onsubmit="addClient(event)">
                <div class="body">
                    <div class="form-grid">
                        <div class="col4">
                            <label>Client Type *</label>
                            <select name="client_type" id="add_client_type" required>
                                <option value="business">Business</option>
                                <option value="personal">Personal</option>
                            </select>
                        </div>
                        <div class="col4">
                            <label>Company Name</label>
                            <input name="company_name" id="add_company_name" placeholder="e.g., ABC Trading LLC">
                        </div>
                        <div class="col4">
                            <label>Full Name</label>
                            <input name="full_name" id="add_full_name" placeholder="e.g., Hassan Merchant">
                        </div>

                        <div class="col4">
                            <label>Email *</label>
                            <input name="email" id="add_email" type="email" placeholder="accounts@company.ae" required>
                        </div>
                        <div class="col4">
                            <label>Phone *</label>
                            <input name="phone" id="add_phone" placeholder="+971 50 000 0000" required>
                        </div>
                        <div class="col4">
                            <label>Password</label>
                            <input name="password" id="add_password" type="text" value="123456" placeholder="Client password">
                        </div>

                        <div class="col6">
                            <label>Address</label>
                            <input name="address" id="add_address" placeholder="Street, Area, City, Country">
                        </div>
                        <div class="col3">
                            <label>TRN (VAT)</label>
                            <input name="trn" id="add_trn" placeholder="Optional">
                        </div>
                        <div class="col3">
                            <label>Billing Preference</label>
                            <select name="billing_pref" id="add_billing_pref">
                                <option value="monthly">Monthly</option>
                                <option value="weekly">Weekly</option>
                                <option value="daily">Daily</option>
                                <option value="advance_3">Advance (3 months)</option>
                                <option value="advance_6">Advance (6 months)</option>
                            </select>
                        </div>

                        <div class="col4">
                            <label>Primary Contact Name</label>
                            <input name="contact_name" id="add_contact_name" placeholder="e.g., Ali Raza">
                        </div>
                        <div class="col4">
                            <label>Primary Contact Role</label>
                            <input name="contact_role" id="add_contact_role" placeholder="Owner / Accounts / Manager">
                        </div>
                        <div class="col4">
                            <label>Alt. Contact</label>
                            <input name="alt_contact" id="add_alt_contact" placeholder="Name + phone/email">
                        </div>

                        <div class="col12">
                            <label>Internal Notes</label>
                            <textarea name="notes" id="add_notes" rows="3" placeholder="Risk notes, access instructions, special terms, etc."></textarea>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button type="button" class="btn" onclick="closeAddClientModal()">Cancel</button>
                    <button type="submit" class="btn primary">Save Client</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Client Modal -->
    <div class="backdrop" id="editClientModal">
        <div class="modal">
            <header>
                <h3>Edit Client</h3>
                <button class="btn ghost x" onclick="closeEditClientModal()">✕</button>
            </header>
            <form onsubmit="editClient(event)">
                <input type="hidden" name="id" id="edit_id">
                <div class="body">
                    <div class="form-grid">
                        <div class="col4">
                            <label>Client Type</label>
                            <select name="client_type" id="edit_client_type">
                                <option value="business">Business</option>
                                <option value="personal">Personal</option>
                            </select>
                        </div>
                        <div class="col4">
                            <label>Client Code</label>
                            <input name="client_code" id="edit_client_code" readonly class="muted">
                        </div>
                        <div class="col4">
                            <label>Status</label>
                            <select name="status" id="edit_status">
                                <option value="active">Active</option>
                                <option value="hold">On Hold</option>
                                <option value="overdue">Overdue</option>
                                <option value="legal">Legal Cycle</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>

                        <div class="col6">
                            <label>Company Name</label>
                            <input name="company_name" id="edit_company_name" placeholder="Company name">
                        </div>
                        <div class="col6">
                            <label>Full Name</label>
                            <input name="full_name" id="edit_full_name" placeholder="Full name">
                        </div>

                        <div class="col4">
                            <label>Email</label>
                            <input name="email" id="edit_email" type="email" required>
                        </div>
                        <div class="col4">
                            <label>Phone</label>
                            <input name="phone" id="edit_phone" required>
                        </div>
                        <div class="col4">
                            <label>Password</label>
                            <input name="password" id="edit_password" type="text" placeholder="Leave blank to keep current">
                            <small class="muted">Leave empty to keep current password</small>
                        </div>

                        <div class="col6">
                            <label>Address</label>
                            <input name="address" id="edit_address">
                        </div>
                        <div class="col3">
                            <label>TRN (VAT)</label>
                            <input name="trn" id="edit_trn">
                        </div>
                        <div class="col3">
                            <label>Billing Preference</label>
                            <select name="billing_pref" id="edit_billing_pref">
                                <option value="monthly">Monthly</option>
                                <option value="weekly">Weekly</option>
                                <option value="daily">Daily</option>
                                <option value="advance_3">Advance (3 months)</option>
                                <option value="advance_6">Advance (6 months)</option>
                            </select>
                        </div>

                        <div class="col4">
                            <label>Primary Contact Name</label>
                            <input name="contact_name" id="edit_contact_name">
                        </div>
                        <div class="col4">
                            <label>Primary Contact Role</label>
                            <input name="contact_role" id="edit_contact_role">
                        </div>
                        <div class="col4">
                            <label>Alt. Contact</label>
                            <input name="alt_contact" id="edit_alt_contact">
                        </div>

                        <div class="col12">
                            <label>Internal Notes</label>
                            <textarea name="notes" id="edit_notes" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button type="button" class="btn" onclick="closeEditClientModal()">Cancel</button>
                    <button type="submit" class="btn primary">Update Client</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="backdrop" id="deleteModal">
        <div class="modal" style="width: min(400px, 100%);">
            <header>
                <h3>Confirm Delete</h3>
                <button class="btn ghost x" onclick="closeDeleteModal()">✕</button>
            </header>
            <div class="body">
                <p>Are you sure you want to delete client <b id="deleteClientName"></b>?</p>
                <p class="muted small">This action cannot be undone.</p>
            </div>
            <div class="footer">
                <button class="btn" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn danger" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <!-- Client Profile Drawer (instead of modal) -->
    <div class="drawer" id="profileDrawer">
        <div class="drawerHeader">
            <div class="row">
                <div>
                    <div style="font-size:16px;font-weight:1000" id="drawerTitle">Client Profile</div>
                    <div class="muted small" id="drawerSub">—</div>
                </div>
                <button class="btn ghost" onclick="closeProfileDrawer()">✕</button>
            </div>
            <div class="tabs" id="profileTabs">
                <button class="tab active" onclick="switchProfileTab('overview')">Overview</button>
                <button class="tab" onclick="switchProfileTab('contacts')">Contacts</button>
                <button class="tab" onclick="switchProfileTab('units')">Units</button>
                <button class="tab" onclick="switchProfileTab('invoices')">Invoices</button>
                <button class="tab" onclick="switchProfileTab('docs')">Documents</button>
                <button class="tab" onclick="switchProfileTab('notes')">Notes</button>
            </div>
        </div>
        <div class="drawerBody" id="drawerBody">
            <!-- Content will be loaded here -->
        </div>
        <div class="drawerFooter">
            <button class="btn" onclick="closeProfileDrawer()">Close</button>
            <button class="btn orange" onclick="editCurrentClient()">Edit Client</button>
            <button class="btn primary" onclick="createInvoiceForCurrent()">+ Create Invoice</button>
            <button class="btn danger" onclick="deleteCurrentClient()">Delete</button>
        </div>
    </div>

    <script>
    // Base URL for API calls - FIXED
    const BASE_URL = '/warehouse-portal';

    // Global variables
    let currentClientCode = null;
    let currentClientId = null;
    let deleteId = null;

    // Toast notification function
    function toast(msg, type = 'info') {
        const t = document.createElement("div");
        t.textContent = msg;

        const colors = {
            info: { bg: "#111827", color: "#fff" },
            success: { bg: "#1aa34a", color: "#fff" },
            error: { bg: "#dc2626", color: "#fff" },
            warning: { bg: "#f59e0b", color: "#fff" }
        };

        const style = colors[type] || colors.info;

        Object.assign(t.style, {
            position: "fixed",
            right: "18px",
            bottom: "18px",
            background: style.bg,
            color: style.color,
            padding: "12px 16px",
            borderRadius: "12px",
            boxShadow: "0 12px 24px rgba(0,0,0,.2)",
            fontWeight: "900",
            fontSize: "13px",
            zIndex: 9999,
            transition: "all 0.3s ease"
        });

        document.body.appendChild(t);
        setTimeout(() => {
            t.style.opacity = "0";
            setTimeout(() => t.remove(), 300);
        }, 2700);
    }

    // Format currency
    function formatMoney(amount) {
        if (amount === undefined || amount === null) return 'AED 0.00';
        return 'AED ' + Number(amount).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Format date
    function formatDate(dateString) {
        if (!dateString || dateString === 'N/A' || dateString === 'Never' || dateString === null) return 'N/A';
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return 'N/A';
            return date.toLocaleDateString('en-GB', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).split('/').join('-');
        } catch (e) {
            return 'N/A';
        }
    }

    // ==================== LOAD CLIENTS ====================
    async function loadClients() {
        try {
            console.log('Loading clients from API...');
            const response = await fetch(BASE_URL + '/api/clients.php?action=get_all_clients');
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('API Response:', data);

            if (data.error) {
                throw new Error(data.error);
            }

            // Update KPIs with null checks
            document.getElementById('totalClients').textContent = data.kpis?.total || 0;
            document.getElementById('activeClients').textContent = data.kpis?.active || 0;
            document.getElementById('legalClients').textContent = data.kpis?.legal || 0;
            document.getElementById('receivables').textContent = formatMoney(data.kpis?.receivables || 0);
            document.getElementById('activeUnits').textContent = '71';

            // Render table
            renderClientsTable(data.clients || []);

        } catch (error) {
            console.error('Error loading clients:', error);
            document.getElementById('clientsTableBody').innerHTML = 
                '<tr><td colspan="7" class="muted" style="text-align:center;">Error loading clients: ' + error.message + '</td></tr>';
            document.getElementById('clientsCount').textContent = '0';
            toast('Error loading clients: ' + error.message, 'error');
        }
    }

    // ==================== RENDER CLIENTS TABLE ====================
    function renderClientsTable(clients) {
        const tbody = document.getElementById('clientsTableBody');
        
        if (!clients || clients.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="muted" style="text-align:center;">No clients found</td></tr>';
            document.getElementById('clientsCount').textContent = 0;
            return;
        }

        let html = '';
        clients.forEach(client => {
            const name = client.company_name || client.full_name || 'N/A';
            const statusColor = {
                'active': 'b-green',
                'hold': 'b-gray',
                'overdue': 'b-orange',
                'legal': 'b-red',
                'closed': 'b-gray'
            }[client.status] || 'b-gray';

            html += `
                <tr>
                    <td><b>${client.client_code || 'N/A'}</b>
                        <div class="muted">${client.client_type || 'N/A'}</div>
                    </td>
                    <td>
                        ${name}
                        <div class="muted">${client.address || ''}</div>
                    </td>
                    <td>
                        ${client.email || 'N/A'}
                        <div class="muted">${client.phone || ''}</div>
                    </td>
                    <td>
                        <b>${client.units_active || 0}</b> active
                        <div class="muted">${client.units_total || 0} total</div>
                    </td>
                    <td>
                        <b>${formatMoney(client.balance || 0)}</b>
                    </td>
                    <td>
                        <span class="badge ${statusColor}">${client.status || 'active'}</span>
                    </td>
                    <td>
                        <button class="btn" onclick="viewClientProfile('${client.client_code}')">View</button>
                        <button class="btn ghost" onclick="openEditClientModal('${client.client_code}')">Edit</button>
                        <button class="btn ghost danger" onclick="openDeleteModal('${client.id}', '${name}')">Delete</button>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        document.getElementById('clientsCount').textContent = clients.length;
    }

    // ==================== VIEW CLIENT PROFILE (DRAWER) ====================
    async function viewClientProfile(clientCode) {
        if (!clientCode) {
            toast('Invalid client code', 'error');
            return;
        }

        currentClientCode = clientCode;
        
        // Show loading in drawer
        document.getElementById('drawerTitle').textContent = 'Loading...';
        document.getElementById('drawerSub').textContent = 'Please wait';
        document.getElementById('profileDrawer').classList.add('open');
        document.getElementById('drawerBody').innerHTML = '<div class="loading">Loading client details...</div>';
        
        try {
            console.log('Loading client profile for:', clientCode);
            const response = await fetch(BASE_URL + '/api/clients.php?action=get_client&code=' + encodeURIComponent(clientCode));
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const client = await response.json();
            console.log('Client data:', client);

            if (client.error) {
                toast(client.error, 'error');
                document.getElementById('profileDrawer').classList.remove('open');
                return;
            }

            currentClientId = client.id;

            // Set drawer header
            const name = client.company_name || client.full_name || 'Unknown';
            document.getElementById('drawerTitle').textContent = `Client Profile - ${name}`;
            document.getElementById('drawerSub').textContent = `${client.client_code} • ${client.email || 'No email'} • ${client.phone || 'No phone'}`;

            // Load overview tab
            renderProfileTab('overview', client);

            // Reset tabs
            document.querySelectorAll('#profileTabs .tab').forEach((tab, index) => {
                if (index === 0) {
                    tab.classList.add('active');
                } else {
                    tab.classList.remove('active');
                }
            });

        } catch (error) {
            console.error('Error loading client:', error);
            document.getElementById('profileDrawer').classList.remove('open');
            toast('Error loading client details: ' + error.message, 'error');
        }
    }

    // ==================== RENDER PROFILE TAB ====================
    function renderProfileTab(tabName, client) {
        const drawerBody = document.getElementById('drawerBody');
        let content = '';

        switch(tabName) {
            case 'overview':
                const statusColors = {
                    'active': 'green',
                    'hold': 'orange',
                    'overdue': 'red',
                    'legal': 'red',
                    'closed': 'gray'
                };
                const statusColor = statusColors[client.status] || 'gray';

                content = `
                    <div class="row" style="gap:8px; margin-bottom:20px; flex-wrap:wrap;">
                        <span class="pill"><span class="dot ${statusColor}"></span>Status: <b>${client.status || 'N/A'}</b></span>
                        <span class="pill"><span class="dot green"></span>Units Active: <b>${client.units_active || 0}</b></span>
                        <span class="pill"><span class="dot orange"></span>Next Expiry: <b>${formatDate(client.next_expiry)}</b></span>
                        <span class="pill"><span class="dot red"></span>Balance: <b>${formatMoney(client.balance || 0)}</b></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="col4">
                            <div class="muted small" style="font-weight:900;">Client ID</div>
                            <div><b>${client.client_code || 'N/A'}</b></div>
                        </div>
                        <div class="col4">
                            <div class="muted small" style="font-weight:900;">Client Type</div>
                            <div><b>${client.client_type === 'business' ? 'Business' : 'Personal'}</b></div>
                        </div>
                        <div class="col4">
                            <div class="muted small" style="font-weight:900;">Billing Preference</div>
                            <div><b>${(client.billing_pref || 'monthly').replace('_', ' ')}</b></div>
                        </div>
                        
                        <div class="col6">
                            <div class="muted small" style="font-weight:900;">Name</div>
                            <div><b>${client.company_name || client.full_name || 'N/A'}</b></div>
                        </div>
                        <div class="col6">
                            <div class="muted small" style="font-weight:900;">Address</div>
                            <div><b>${client.address || 'N/A'}</b></div>
                        </div>
                        
                        <div class="col4">
                            <div class="muted small" style="font-weight:900;">Email</div>
                            <div><b>${client.email || 'N/A'}</b></div>
                        </div>
                        <div class="col4">
                            <div class="muted small" style="font-weight:900;">Phone</div>
                            <div><b>${client.phone || 'N/A'}</b></div>
                        </div>
                        <div class="col4">
                            <div class="muted small" style="font-weight:900;">TRN (VAT)</div>
                            <div><b>${client.trn || '—'}</b></div>
                        </div>
                        
                        <div class="col6">
                            <div class="muted small" style="font-weight:900;">Username</div>
                            <div><b>${client.username || 'N/A'}</b></div>
                        </div>
                        <div class="col6">
                            <div class="muted small" style="font-weight:900;">Last Payment</div>
                            <div><b>${formatDate(client.last_payment)}</b></div>
                        </div>
                        
                        <div class="col12">
                            <div class="muted small" style="font-weight:900;">Internal Notes</div>
                            <div class="muted" style="padding:8px; background:var(--bg); border-radius:8px;">${client.notes || 'No notes'}</div>
                        </div>
                    </div>
                `;
                break;

            case 'contacts':
                content = `
                    <div class="card" style="box-shadow:none; padding:0;">
                        <h3 style="margin-top:0;">Primary Contact</h3>
                        <div class="form-grid">
                            <div class="col6">
                                <div class="muted small">Name</div>
                                <div><b>${client.contact_name || 'Not set'}</b></div>
                            </div>
                            <div class="col6">
                                <div class="muted small">Role</div>
                                <div><b>${client.contact_role || 'Not set'}</b></div>
                            </div>
                        </div>
                        
                        <div style="margin-top:20px;">
                            <h3>Alternate Contact</h3>
                            <div><b>${client.alt_contact || 'No alternate contact'}</b></div>
                        </div>
                    </div>
                `;
                break;

            case 'units':
                content = `
                    <div class="card" style="box-shadow:none; padding:0;">
                        <div class="row" style="margin-bottom:20px;">
                            <h3 style="margin:0;">Unit Allocations</h3>
                            <button class="btn primary" onclick="allocateUnit('${client.client_code}')">+ Allocate Unit</button>
                        </div>
                        <table style="width:100%;">
                            <tr>
                                <th>Unit</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            <tr>
                                <td colspan="4" class="muted" style="text-align:center; padding:20px;">
                                    Total Units: <b>${client.units_total || 0}</b> | Active: <b>${client.units_active || 0}</b>
                                </td>
                            </tr>
                        </table>
                    </div>
                `;
                break;

            case 'invoices':
                content = `
                    <div class="card" style="box-shadow:none; padding:0;">
                        <div class="row" style="margin-bottom:20px;">
                            <h3 style="margin:0;">Invoices</h3>
                            <button class="btn primary" onclick="createInvoice('${client.client_code}')">+ Create Invoice</button>
                        </div>
                        <div class="muted" style="text-align:center; padding:20px; background:var(--bg); border-radius:12px;">
                            Outstanding Balance: <b>${formatMoney(client.balance || 0)}</b>
                        </div>
                    </div>
                `;
                break;

            case 'docs':
                content = `
                    <div class="card" style="box-shadow:none; padding:0;">
                        <div class="row" style="margin-bottom:20px;">
                            <h3 style="margin:0;">Documents</h3>
                            <button class="btn primary" onclick="uploadDocument('${client.client_code}')">+ Upload Document</button>
                        </div>
                        <div class="muted" style="text-align:center; padding:20px; background:var(--bg); border-radius:12px;">
                            Next Expiry: <b>${formatDate(client.next_expiry)}</b>
                        </div>
                    </div>
                `;
                break;

            case 'notes':
                content = `
                    <div class="card" style="box-shadow:none; padding:0;">
                        <h3 style="margin-top:0;">Internal Notes</h3>
                        <div style="background:var(--bg); padding:15px; border-radius:12px; min-height:100px;">
                            ${client.notes || 'No notes available'}
                        </div>
                    </div>
                `;
                break;

            default:
                content = '<div class="muted">Select a tab</div>';
        }

        drawerBody.innerHTML = content;
    }

    // ==================== SWITCH PROFILE TAB ====================
    function switchProfileTab(tabName) {
        // Update active tab
        document.querySelectorAll('#profileTabs .tab').forEach(t => t.classList.remove('active'));
        event.target.classList.add('active');

        if (currentClientCode) {
            // Show loading
            document.getElementById('drawerBody').innerHTML = '<div class="loading">Loading...</div>';
            
            // Reload client data
            fetch(BASE_URL + '/api/clients.php?action=get_client&code=' + encodeURIComponent(currentClientCode))
                .then(res => res.json())
                .then(client => {
                    if (client.error) {
                        toast(client.error, 'error');
                        return;
                    }
                    renderProfileTab(tabName, client);
                })
                .catch(err => {
                    console.error('Error loading tab data:', err);
                    toast('Error loading tab data', 'error');
                });
        }
    }

    // ==================== CLOSE PROFILE DRAWER ====================
    function closeProfileDrawer() {
        document.getElementById('profileDrawer').classList.remove('open');
        currentClientCode = null;
        currentClientId = null;
    }

    // ==================== EDIT CURRENT CLIENT ====================
    function editCurrentClient() {
        if (currentClientCode) {
            closeProfileDrawer();
            openEditClientModal(currentClientCode);
        }
    }

    // ==================== DELETE CURRENT CLIENT ====================
    function deleteCurrentClient() {
        if (currentClientId && currentClientCode) {
            const name = document.getElementById('drawerTitle').textContent.replace('Client Profile - ', '');
            closeProfileDrawer();
            openDeleteModal(currentClientId, name);
        }
    }

    // ==================== OPEN ADD CLIENT MODAL ====================
    function openAddClientModal() {
        document.getElementById('addClientModal').classList.add('open');
    }

    function closeAddClientModal() {
        document.getElementById('addClientModal').classList.remove('open');
        document.getElementById('addClientModal').querySelector('form').reset();
    }

    // ==================== OPEN EDIT CLIENT MODAL ====================
    async function openEditClientModal(clientCode) {
        try {
            const response = await fetch(BASE_URL + '/api/clients.php?action=get_client&code=' + encodeURIComponent(clientCode));
            const client = await response.json();

            if (client.error) {
                toast(client.error, 'error');
                return;
            }

            document.getElementById('edit_id').value = client.id || '';
            document.getElementById('edit_client_code').value = client.client_code || '';
            document.getElementById('edit_client_type').value = client.client_type || 'business';
            document.getElementById('edit_status').value = client.status || 'active';
            document.getElementById('edit_company_name').value = client.company_name || '';
            document.getElementById('edit_full_name').value = client.full_name || '';
            document.getElementById('edit_email').value = client.email || '';
            document.getElementById('edit_phone').value = client.phone || '';
            document.getElementById('edit_address').value = client.address || '';
            document.getElementById('edit_trn').value = client.trn || '';
            document.getElementById('edit_billing_pref').value = client.billing_pref || 'monthly';
            document.getElementById('edit_contact_name').value = client.contact_name || '';
            document.getElementById('edit_contact_role').value = client.contact_role || '';
            document.getElementById('edit_alt_contact').value = client.alt_contact || '';
            document.getElementById('edit_notes').value = client.notes || '';
            
            document.getElementById('editClientModal').classList.add('open');
            
        } catch (error) {
            console.error('Error loading client:', error);
            toast('Error loading client data: ' + error.message, 'error');
        }
    }

    function closeEditClientModal() {
        document.getElementById('editClientModal').classList.remove('open');
    }

    // ==================== OPEN DELETE MODAL ====================
    function openDeleteModal(id, name) {
        deleteId = id;
        document.getElementById('deleteClientName').textContent = name;
        document.getElementById('deleteModal').classList.add('open');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('open');
        deleteId = null;
    }

    // ==================== ADD CLIENT ====================
    async function addClient(event) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        data.action = 'add_client';

        try {
            const response = await fetch(BASE_URL + '/api/clients.php?action=add_client', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.error) {
                toast(result.error, 'error');
            } else {
                toast(result.message + ' (Username: ' + result.username + ', Password: ' + result.password + ')', 'success');
                closeAddClientModal();
                loadClients();
            }
        } catch (error) {
            console.error('Error adding client:', error);
            toast('Error adding client: ' + error.message, 'error');
        }
    }

    // ==================== EDIT CLIENT ====================
    async function editClient(event) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        data.action = 'edit_client';

        try {
            const response = await fetch(BASE_URL + '/api/clients.php?action=edit_client', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.error) {
                toast(result.error, 'error');
            } else {
                toast(result.message, 'success');
                closeEditClientModal();
                loadClients();
                
                // If the edited client is currently viewed, refresh the drawer
                if (currentClientId == data.id) {
                    viewClientProfile(document.getElementById('edit_client_code').value);
                }
            }
        } catch (error) {
            console.error('Error updating client:', error);
            toast('Error updating client: ' + error.message, 'error');
        }
    }

    // ==================== CONFIRM DELETE ====================
    async function confirmDelete() {
        if (!deleteId) return;

        try {
            const response = await fetch(BASE_URL + '/api/clients.php?action=delete_client&id=' + deleteId, {
                method: 'DELETE'
            });

            const result = await response.json();

            if (result.error) {
                toast(result.error, 'error');
            } else {
                toast(result.message, 'success');
                closeDeleteModal();
                loadClients();
            }
        } catch (error) {
            console.error('Error deleting client:', error);
            toast('Error deleting client: ' + error.message, 'error');
        }
    }

    // ==================== EXPORT CSV ====================
    function exportCSV() {
        toast('Exporting clients...', 'info');
        // You can implement CSV export here
    }

    // ==================== ACTION FUNCTIONS ====================
    function allocateUnit(clientCode) {
        toast(`Opening unit allocation for ${clientCode}`, 'info');
    }

    function createInvoice(clientCode) {
        toast(`Creating invoice for ${clientCode}`, 'info');
    }

    function createInvoiceForCurrent() {
        if (currentClientCode) {
            createInvoice(currentClientCode);
        }
    }

    function uploadDocument(clientCode) {
        toast(`Opening document upload for ${clientCode}`, 'info');
    }

    // ==================== DEBUG FUNCTIONS ====================
    function testAPI() {
        console.log('Testing API connection...');
        fetch(BASE_URL + '/api/clients.php?action=get_all_clients')
            .then(res => {
                console.log('Response status:', res.status);
                return res.json();
            })
            .then(data => console.log('API Response:', data))
            .catch(err => console.error('API Error:', err));
    }

    function testSingleClient(code = 'C-0001') {
        console.log('Testing single client API for code:', code);
        fetch(BASE_URL + '/api/clients.php?action=get_client&code=' + code)
            .then(res => {
                console.log('Response status:', res.status);
                return res.json();
            })
            .then(data => console.log('Single Client Response:', data))
            .catch(err => console.error('API Error:', err));
    }

    // ==================== INITIAL LOAD ====================
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, loading clients...');
        loadClients();
    });

    // Make functions globally available
    window.openAddClientModal = openAddClientModal;
    window.closeAddClientModal = closeAddClientModal;
    window.openEditClientModal = openEditClientModal;
    window.closeEditClientModal = closeEditClientModal;
    window.openDeleteModal = openDeleteModal;
    window.closeDeleteModal = closeDeleteModal;
    window.viewClientProfile = viewClientProfile;
    window.closeProfileDrawer = closeProfileDrawer;
    window.switchProfileTab = switchProfileTab;
    window.editCurrentClient = editCurrentClient;
    window.deleteCurrentClient = deleteCurrentClient;
    window.createInvoiceForCurrent = createInvoiceForCurrent;
    window.addClient = addClient;
    window.editClient = editClient;
    window.confirmDelete = confirmDelete;
    window.exportCSV = exportCSV;
    window.allocateUnit = allocateUnit;
    window.createInvoice = createInvoice;
    window.uploadDocument = uploadDocument;
    window.testAPI = testAPI;
    window.testSingleClient = testSingleClient;
</script>
</body>

</html>