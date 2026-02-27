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

// Handle form submissions (for traditional form posts)
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // This is for traditional form submissions
    // API will handle AJAX requests
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facility Map - RGSL</title>
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

            --c-avail: #94a3b8;
            --c-partial: #f26a21;
            --c-full: #16a34a;
            --c-expiring: #fb923c;
            --c-hold: #dc2626;
            --c-offhire: #0ea5e9;
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
            background: #dc2626;
            border-color: #dc2626;
            color: #fff;
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

        /* Map */
        .mapWrap {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 10px;
            min-height: 300px;
        }

        .zone {
            grid-column: span 6;
            border: 1px dashed #cbd5e1;
            border-radius: 16px;
            padding: 12px;
            background: #fff;
        }

        .zone h3 {
            margin: 0 0 10px 0;
            font-size: 13px;
        }

        .unitGrid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
        }

        .unit {
            border-radius: 14px;
            padding: 10px;
            min-height: 72px;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 10px 18px rgba(15, 23, 42, .10);
            border: 1px solid rgba(255, 255, 255, .25);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s;
        }

        .unit:hover {
            transform: translateY(-2px);
        }

        .unit .top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .unit .id {
            font-weight: 1000;
            font-size: 12px;
        }

        .unit .type {
            font-size: 11px;
            opacity: .92;
        }

        .unit .meta {
            font-size: 11px;
            opacity: .92;
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

        /* Drawer */
        .drawer {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: min(520px, 96vw);
            background: #fff;
            border-left: 1px solid var(--border);
            box-shadow: -20px 0 40px rgba(0, 0, 0, .12);
            transform: translateX(110%);
            transition: transform 0.3s ease;
            z-index: 40;
            display: flex;
            flex-direction: column;
        }

        .drawer.open {
            transform: translateX(0);
        }

        .drawerHeader {
            padding: 14px;
            border-bottom: 1px solid var(--border);
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
        }

        .tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin: 10px 0 6px;
        }

        .tab {
            border: 1px solid var(--border);
            background: #fff;
            padding: 8px 10px;
            border-radius: 12px;
            font-weight: 1000;
            font-size: 12px;
            cursor: pointer;
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

            .zone {
                grid-column: span 12;
            }

            .unitGrid {
                grid-template-columns: repeat(3, 1fr);
            }

            .col3,
            .col4,
            .col6 {
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
                    <h1>Facility Map</h1>
                    <p>Admin Portal • Sheds + Containers • Off-hire supported</p>
                </div>
            </div>
            <div class="row" style="justify-content:flex-end;gap:8px">
                <button class="btn" onclick="location.href='dashboard.php'">Dashboard</button>
                <button class="btn" onclick="location.href='clients.php'">Clients</button>
                <button class="btn orange" onclick="openAddUnitModal()">+ Add Unit</button>
                <button class="btn primary" onclick="exportMap()">Export</button>
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
                    <a href="clients.php">Clients</a>
                    <a href="facility.php" class="active">Facility Map</a>
                    <a href="units.php">Unit Analytics</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="notices.php">Notices & Legal</a>
                    <a href="reports.php">Reports</a>
                </div>

                <div class="hr"></div>

                <div class="navTitle">LEGEND</div>
                <div class="muted small" style="margin-bottom:8px;">
                    <span class="dot" style="background:var(--c-full)"></span> Occupied<br>
                    <span class="dot" style="background:var(--c-partial)"></span> Partial/Shared<br>
                    <span class="dot" style="background:var(--c-avail)"></span> Available<br>
                    <span class="dot" style="background:var(--c-expiring)"></span> Expiring<br>
                    <span class="dot" style="background:var(--c-hold)"></span> Hold/Legal<br>
                    <span class="dot" style="background:var(--c-offhire)"></span> Off-hire
                </div>

                <div class="hr"></div>

                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn orange" style="width:100%;margin-bottom:8px" onclick="openAddUnitModal()">+ Add Unit</button>
                <button class="btn primary" style="width:100%;margin-bottom:8px" onclick="openAllocateModal()">+ Allocate Unit</button>
                <button class="btn" style="width:100%" onclick="exportMap()">Export Map</button>
            </aside>

            <main>
                <!-- Filters -->
                <div class="card">
                    <div class="row">
                        <h2>Filters & View Controls</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill"><span class="dot" style="background:var(--c-full)"></span>Occupied</span>
                            <span class="pill"><span class="dot" style="background:var(--c-partial)"></span>Partial/Shared</span>
                            <span class="pill"><span class="dot" style="background:var(--c-avail)"></span>Available</span>
                            <span class="pill"><span class="dot" style="background:var(--c-expiring)"></span>Expiring</span>
                            <span class="pill"><span class="dot" style="background:var(--c-hold)"></span>Hold/Legal</span>
                            <span class="pill"><span class="dot" style="background:var(--c-offhire)"></span>Off-hire</span>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="col3">
                            <label>Unit Type</label>
                            <select id="fType" onchange="filterUnits()">
                                <option value="all">All</option>
                                <option value="shed">Sheds</option>
                                <option value="container">Containers</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Status</label>
                            <select id="fStatus" onchange="filterUnits()">
                                <option value="all">All</option>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="partial">Partial</option>
                                <option value="expiring">Expiring</option>
                                <option value="hold">Hold/Legal</option>
                                <option value="offhire">Off-hire</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Zone</label>
                            <select id="fZone" onchange="filterUnits()">
                                <option value="all">All</option>
                                <option value="Zone A">Zone A</option>
                                <option value="Zone B">Zone B</option>
                                <option value="Yard">Yard</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Search</label>
                            <input id="q" placeholder="Unit code / location" onkeyup="filterUnits()">
                        </div>
                    </div>
                </div>

                <!-- KPI Strip -->
                <div class="card">
                    <div class="row">
                        <h2>Facility Snapshot</h2>
                        <div class="row" style="gap:8px" id="kpiContainer">
                            <span class="pill">Total Units: <b id="totalUnits">0</b></span>
                            <span class="pill">Occupied: <b id="occupiedUnits">0</b></span>
                            <span class="pill">Available: <b id="availableUnits">0</b></span>
                            <span class="pill">Off-hire: <b id="offhireUnits">0</b></span>
                            <span class="pill">Expiring: <b id="expiringUnits">0</b></span>
                        </div>
                    </div>
                </div>

                <!-- Facility Map -->
                <div class="card">
                    <div class="row">
                        <h2>Facility Map</h2>
                        <div class="row" style="gap:8px">
                            <button class="btn" onclick="toggleView('heatmap')">Heatmap</button>
                            <button class="btn" onclick="toggleView('list')">List</button>
                            <button class="btn orange" onclick="openAddUnitModal()">+ Add Unit</button>
                        </div>
                    </div>

                    <div class="mapWrap" id="facilityMap">
                        <div class="loading">Loading units...</div>
                    </div>
                </div>

                <!-- Units List -->
                <div class="card">
                    <div class="row">
                        <h2>Units List</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill">Showing: <b id="unitsCount">0</b></span>
                            <button class="btn" onclick="exportUnitsCSV()">Export CSV</button>
                        </div>
                    </div>
                    <table id="unitsTable">
                        <thead>
                            <tr>
                                <th>Unit Code</th>
                                <th>Type</th>
                                <th>Zone</th>
                                <th>Location</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="unitsTableBody">
                            <tr>
                                <td colspan="7" class="muted" style="text-align:center;">Loading units...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Unit Modal -->
    <div class="backdrop" id="unitModalBackdrop">
        <div class="modal" style="width: min(600px, 100%);">
            <header>
                <h3 id="unitModalTitle">Add New Unit</h3>
                <button class="btn ghost x" onclick="closeUnitModal()">✕</button>
            </header>
            <form onsubmit="addUnit(event)">
                <div class="body">
                    <div class="form-grid">
                        <!-- Unit Type -->
                        <div class="col6">
                            <label>Unit Type *</label>
                            <select name="unit_type" id="unit_type" required onchange="handleUnitTypeChange()">
                                <option value="">Select Type</option>
                                <option value="shed">Shed</option>
                                <option value="container">Container</option>
                            </select>
                        </div>

                        <!-- Unit Code (auto-generated) -->
                        <div class="col6">
                            <label>Unit Code</label>
                            <input type="text" name="unit_code" id="unit_code" readonly class="muted">
                            <small class="muted">Auto-generated</small>
                        </div>

                        <!-- Zone -->
                        <div class="col6">
                            <label>Zone *</label>
                            <select name="zone" id="zone" required>
                                <option value="">Select Zone</option>
                                <option value="Zone A">Zone A (Sheds)</option>
                                <option value="Zone B">Zone B (Sheds)</option>
                                <option value="Yard">Container Yard</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col6">
                            <label>Status *</label>
                            <select name="status" id="status" required onchange="handleStatusChange()">
                                <option value="available">Available</option>
                                <option value="offhire">Off-hire</option>
                                <option value="hold">Hold/Legal</option>
                                <option value="expiring">Expiring</option>
                                <option value="partial">Partial/Shared</option>
                                <option value="occupied">Occupied</option>
                            </select>
                        </div>

                        <!-- Container Size (shown only for container) -->
                        <div class="col6" id="container_size_field" style="display: none;">
                            <label>Container Size *</label>
                            <select name="size" id="container_size">
                                <option value="">Select Size</option>
                                <option value="20FT">20FT</option>
                                <option value="40FT">40FT</option>
                                <option value="40HC">40HC (High Cube)</option>
                                <option value="45HC">45HC (High Cube)</option>
                            </select>
                        </div>

                        <!-- Internal Label -->
                        <div class="col6">
                            <label>Internal Label</label>
                            <input type="text" name="internal_label" id="internal_label" placeholder="e.g., Premium Location">
                        </div>

                        <!-- Off-hire Reason -->
                        <div class="col12" id="offhire_reason_field" style="display: none;">
                            <label>Off-hire Reason *</label>
                            <select name="offhire_reason" id="offhire_reason">
                                <option value="">Select Reason</option>
                                <option value="maintenance">Maintenance/Repair</option>
                                <option value="damage">Damage</option>
                                <option value="cleaning">Cleaning</option>
                                <option value="inspection">Inspection</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Location Details -->
                        <div class="col4">
                            <label>Row/Area</label>
                            <input type="text" name="row_area" id="row_area" placeholder="e.g., A1">
                        </div>
                        <div class="col4">
                            <label>Bay/Position</label>
                            <input type="text" name="bay_position" id="bay_position" placeholder="e.g., Bay 7">
                        </div>
                        <div class="col4">
                            <label>Dimensions</label>
                            <input type="text" name="dimensions" id="dimensions" placeholder="e.g., 10x20 ft">
                        </div>

                        <!-- Notes -->
                        <div class="col12">
                            <label>Notes</label>
                            <textarea name="notes" id="notes" rows="3" placeholder="Additional details..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button type="button" class="btn" onclick="closeUnitModal()">Cancel</button>
                    <button type="submit" class="btn primary">Add Unit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Unit Modal -->
    <div class="backdrop" id="editUnitModalBackdrop">
        <div class="modal" style="width: min(600px, 100%);">
            <header>
                <h3 id="editUnitModalTitle">Edit Unit</h3>
                <button class="btn ghost x" onclick="closeEditUnitModal()">✕</button>
            </header>
            <form onsubmit="editUnit(event)">
                <input type="hidden" name="id" id="edit_id">
                <div class="body">
                    <div class="form-grid">
                        <div class="col6">
                            <label>Unit Type</label>
                            <select name="unit_type" id="edit_unit_type" required onchange="handleEditUnitTypeChange()">
                                <option value="shed">Shed</option>
                                <option value="container">Container</option>
                            </select>
                        </div>
                        <div class="col6">
                            <label>Unit Code</label>
                            <input type="text" name="unit_code" id="edit_unit_code" readonly class="muted">
                        </div>
                        <div class="col6">
                            <label>Zone *</label>
                            <select name="zone" id="edit_zone" required>
                                <option value="Zone A">Zone A</option>
                                <option value="Zone B">Zone B</option>
                                <option value="Yard">Yard</option>
                            </select>
                        </div>
                        <div class="col6">
                            <label>Status *</label>
                            <select name="status" id="edit_status" required onchange="handleEditStatusChange()">
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="partial">Partial/Shared</option>
                                <option value="expiring">Expiring</option>
                                <option value="hold">Hold/Legal</option>
                                <option value="offhire">Off-hire</option>
                            </select>
                        </div>
                        <div class="col6" id="edit_container_size_field">
                            <label>Container Size</label>
                            <select name="size" id="edit_container_size">
                                <option value="">Select Size</option>
                                <option value="20FT">20FT</option>
                                <option value="40FT">40FT</option>
                                <option value="40HC">40HC</option>
                                <option value="45HC">45HC</option>
                            </select>
                        </div>
                        <div class="col6">
                            <label>Internal Label</label>
                            <input type="text" name="internal_label" id="edit_internal_label">
                        </div>
                        <div class="col12" id="edit_offhire_reason_field" style="display: none;">
                            <label>Off-hire Reason</label>
                            <select name="offhire_reason" id="edit_offhire_reason">
                                <option value="">Select Reason</option>
                                <option value="maintenance">Maintenance/Repair</option>
                                <option value="damage">Damage</option>
                                <option value="cleaning">Cleaning</option>
                                <option value="inspection">Inspection</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col4">
                            <label>Row/Area</label>
                            <input type="text" name="row_area" id="edit_row_area">
                        </div>
                        <div class="col4">
                            <label>Bay/Position</label>
                            <input type="text" name="bay_position" id="edit_bay_position">
                        </div>
                        <div class="col4">
                            <label>Dimensions</label>
                            <input type="text" name="dimensions" id="edit_dimensions">
                        </div>
                        <div class="col12">
                            <label>Notes</label>
                            <textarea name="notes" id="edit_notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button type="button" class="btn" onclick="closeEditUnitModal()">Cancel</button>
                    <button type="submit" class="btn primary">Update Unit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="backdrop" id="deleteModalBackdrop">
        <div class="modal" style="width: min(400px, 100%);">
            <header>
                <h3>Confirm Delete</h3>
                <button class="btn ghost x" onclick="closeDeleteModal()">✕</button>
            </header>
            <div class="body">
                <p>Are you sure you want to delete unit <b id="deleteUnitCode"></b>?</p>
                <p class="muted small">This action cannot be undone.</p>
            </div>
            <div class="footer">
                <button type="button" class="btn" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="btn danger" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <!-- Unit Details Drawer -->
    <div class="drawer" id="drawer">
        <div class="drawerHeader">
            <div class="row">
                <div>
                    <div style="font-size:14px;font-weight:1000" id="dTitle">Unit</div>
                    <div class="muted small" id="dSub">—</div>
                </div>
                <button class="btn ghost" onclick="closeDrawer()">✕</button>
            </div>
            <div class="tabs" id="dTabs">
                <button class="tab active" onclick="switchDrawerTab('overview')">Overview</button>
                <button class="tab" onclick="switchDrawerTab('occupancy')">Occupancy Timeline</button>
                <button class="tab" onclick="switchDrawerTab('actions')">Actions</button>
                <button class="tab" onclick="switchDrawerTab('notes')">Notes</button>
            </div>
        </div>
        <div class="drawerBody">
            <div id="d-overview"></div>
            <div id="d-occupancy" class="hidden"></div>
            <div id="d-actions" class="hidden"></div>
            <div id="d-notes" class="hidden"></div>
        </div>
        <div class="drawerFooter">
            <button class="btn" onclick="openUnitFullPage()">Open</button>
            <button class="btn orange" onclick="editCurrentUnit()">Edit</button>
            <button class="btn danger" onclick="deleteCurrentUnit()">Archive</button>
        </div>
    </div>

    <script>
    // Global variables
    let units = [];
    let nextIds = { shed: 1, container: 1 };
    let currentUnitId = null;
    let deleteId = null;

    // Toast notification
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
            position: "fixed", right: "18px", bottom: "18px",
            background: style.bg, color: style.color,
            padding: "12px 16px", borderRadius: "12px",
            boxShadow: "0 12px 24px rgba(0,0,0,.2)",
            fontWeight: "900", fontSize: "13px", zIndex: 9999,
            transition: "all 0.3s ease"
        });
        document.body.appendChild(t);
        setTimeout(() => {
            t.style.opacity = "0";
            setTimeout(() => t.remove(), 300);
        }, 2700);
    }

    // Load units from API
    async function loadUnits() {
        // Show loading state
        document.getElementById('facilityMap').innerHTML = '<div class="loading">Loading units...</div>';
        document.getElementById('unitsTableBody').innerHTML = '<tr><td colspan="7" class="muted" style="text-align:center;">Loading units...</td></tr>';
        
        try {
            console.log('Fetching units from API...');
            const response = await fetch('../api/units.php');
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('API Response:', data);
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            units = data.units || [];
            const counts = data.counts || {};
            nextIds = data.next_ids || { shed: 1, container: 1 };
            
            console.log('Units loaded:', units.length);
            
            // Update KPIs
            document.getElementById('totalUnits').textContent = counts.total || 0;
            document.getElementById('occupiedUnits').textContent = counts.occupied || 0;
            document.getElementById('availableUnits').textContent = counts.available || 0;
            document.getElementById('offhireUnits').textContent = counts.offhire || 0;
            document.getElementById('expiringUnits').textContent = counts.expiring || 0;
            
            // Render map and table
            renderMap();
            renderTable();
            
            if (units.length === 0) {
                // Show empty state with add button
                document.getElementById('facilityMap').innerHTML = `
                    <div class="col12" style="text-align:center; padding:40px;">
                        <div class="muted">No units found</div>
                        <button class="btn orange" style="margin-top:10px;" onclick="openAddUnitModal()">+ Add First Unit</button>
                    </div>
                `;
            }
            
        } catch (error) {
            console.error('Error loading units:', error);
            document.getElementById('facilityMap').innerHTML = `
                <div class="col12" style="text-align:center; padding:40px;">
                    <div class="muted">Error loading units: ${error.message}</div>
                    <button class="btn primary" style="margin-top:10px;" onclick="loadUnits()">Retry</button>
                </div>
            `;
            document.getElementById('unitsTableBody').innerHTML = `
                <tr><td colspan="7" class="muted" style="text-align:center;">Error loading units. <button class="btn" onclick="loadUnits()">Retry</button></td></tr>
            `;
            toast('Error loading units: ' + error.message, 'error');
        }
    }

    // Render facility map
    function renderMap(filteredUnits = null) {
        const mapDiv = document.getElementById('facilityMap');
        const unitsToRender = filteredUnits || units;
        
        if (unitsToRender.length === 0) {
            mapDiv.innerHTML = `
                <div class="col12" style="text-align:center; padding:40px;">
                    <div class="muted">No units match the current filters</div>
                </div>
            `;
            return;
        }

        // Group by zone
        const zones = {
            'Zone A': unitsToRender.filter(u => u.zone === 'Zone A'),
            'Zone B': unitsToRender.filter(u => u.zone === 'Zone B'),
            'Yard': unitsToRender.filter(u => u.zone === 'Yard')
        };

        const statusColors = {
            'available': 'var(--c-avail)',
            'occupied': 'var(--c-full)',
            'partial': 'var(--c-partial)',
            'expiring': 'var(--c-expiring)',
            'hold': 'var(--c-hold)',
            'offhire': 'var(--c-offhire)'
        };

        let mapHTML = '';

        for (const [zoneName, zoneUnits] of Object.entries(zones)) {
            if (zoneUnits.length === 0) continue;
            
            mapHTML += `
                <div class="zone">
                    <h3>${zoneName}</h3>
                    <div class="unitGrid">
            `;

            zoneUnits.forEach(unit => {
                mapHTML += `
                    <div class="unit" style="background:${statusColors[unit.status]}" onclick="viewUnit('${unit.unit_code}')">
                        <div class="top">
                            <div class="id">${unit.unit_code}</div>
                            <div class="type">${unit.unit_type}</div>
                        </div>
                        <div class="meta">${unit.status}</div>
                        <div class="meta">${unit.location_label || ''}</div>
                        ${unit.internal_label ? `<div class="meta">${unit.internal_label}</div>` : ''}
                    </div>
                `;
            });

            mapHTML += `
                    </div>
                </div>
            `;
        }

        mapDiv.innerHTML = mapHTML;
    }

    // Render table
    function renderTable(filteredUnits = null) {
        const tbody = document.getElementById('unitsTableBody');
        const unitsToRender = filteredUnits || units;
        
        if (unitsToRender.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="muted" style="text-align:center;">No units found</td></tr>';
            document.getElementById('unitsCount').textContent = 0;
            return;
        }

        const statusColors = {
            'available': 'b-gray',
            'occupied': 'b-green',
            'partial': 'b-orange',
            'expiring': 'b-orange',
            'hold': 'b-red',
            'offhire': 'b-blue'
        };

        let html = '';

        unitsToRender.forEach(unit => {
            const color = statusColors[unit.status] || 'b-gray';
            html += `
                <tr data-unit-code="${unit.unit_code}">
                    <td><b>${unit.unit_code}</b>
                        ${unit.internal_label ? `<div class="muted small">${unit.internal_label}</div>` : ''}
                    </td>
                    <td>${unit.unit_type}</td>
                    <td>${unit.zone}</td>
                    <td>
                        ${unit.location_label || ''}
                        ${unit.dimensions ? `<div class="muted small">${unit.dimensions}</div>` : ''}
                    </td>
                    <td>${unit.size || '-'}</td>
                    <td>
                        <span class="badge ${color}">
                            ${unit.status}
                        </span>
                    </td>
                    <td>
                        <button class="btn" onclick="viewUnit('${unit.unit_code}')">View</button>
                        <button class="btn ghost" onclick="openEditUnitModal('${unit.id}')">Edit</button>
                        <button class="btn ghost danger" onclick="openDeleteModal('${unit.id}', '${unit.unit_code}')">Delete</button>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        document.getElementById('unitsCount').textContent = unitsToRender.length;
    }

    // Filter units
    function filterUnits() {
        const type = document.getElementById('fType').value;
        const status = document.getElementById('fStatus').value;
        const zone = document.getElementById('fZone').value;
        const search = document.getElementById('q').value.toLowerCase();

        const filtered = units.filter(unit => {
            if (type !== 'all' && unit.unit_type !== type) return false;
            if (status !== 'all' && unit.status !== status) return false;
            if (zone !== 'all' && unit.zone !== zone) return false;
            if (search) {
                const matchesCode = unit.unit_code.toLowerCase().includes(search);
                const matchesLocation = unit.location_label && unit.location_label.toLowerCase().includes(search);
                const matchesLabel = unit.internal_label && unit.internal_label.toLowerCase().includes(search);
                return matchesCode || matchesLocation || matchesLabel;
            }
            return true;
        });

        renderMap(filtered);
        renderTable(filtered);
    }

    // Reset filters
    function resetFilters() {
        document.getElementById('fType').value = 'all';
        document.getElementById('fStatus').value = 'all';
        document.getElementById('fZone').value = 'all';
        document.getElementById('q').value = '';
        renderMap();
        renderTable();
    }

    // Modal Functions
    function openAddUnitModal() {
        document.getElementById("unitModalTitle").textContent = "Add New Unit";
        document.getElementById("unitModalBackdrop").classList.add("open");
        resetAddForm();
    }

    function closeUnitModal() {
        document.getElementById("unitModalBackdrop").classList.remove("open");
    }

    function closeEditUnitModal() {
        document.getElementById("editUnitModalBackdrop").classList.remove("open");
    }

    function closeDeleteModal() {
        document.getElementById("deleteModalBackdrop").classList.remove("open");
        deleteId = null;
    }

    // Handle unit type change for add modal
    function handleUnitTypeChange() {
        const type = document.getElementById('unit_type').value;
        const containerField = document.getElementById('container_size_field');
        const unitCode = document.getElementById('unit_code');
        
        if (type === 'shed') {
            unitCode.value = `SHED-${nextIds.shed.toString().padStart(2, '0')}`;
            containerField.style.display = 'none';
            document.getElementById('container_size').removeAttribute('required');
        } else if (type === 'container') {
            unitCode.value = `CONT-${nextIds.container.toString().padStart(2, '0')}`;
            containerField.style.display = 'block';
            document.getElementById('container_size').setAttribute('required', 'required');
        } else {
            unitCode.value = '';
            containerField.style.display = 'none';
        }
    }

    // Handle status change
    function handleStatusChange() {
        const status = document.getElementById('status').value;
        const offhireField = document.getElementById('offhire_reason_field');
        offhireField.style.display = status === 'offhire' ? 'block' : 'none';
    }

    function handleEditStatusChange() {
        const status = document.getElementById('edit_status').value;
        const offhireField = document.getElementById('edit_offhire_reason_field');
        offhireField.style.display = status === 'offhire' ? 'block' : 'none';
    }

    function handleEditUnitTypeChange() {
        const type = document.getElementById('edit_unit_type').value;
        document.getElementById('edit_container_size_field').style.display = 
            type === 'container' ? 'block' : 'none';
    }

    // Reset add form
    function resetAddForm() {
        document.getElementById('unit_type').value = '';
        document.getElementById('unit_code').value = '';
        document.getElementById('zone').value = '';
        document.getElementById('status').value = 'available';
        document.getElementById('internal_label').value = '';
        document.getElementById('row_area').value = '';
        document.getElementById('bay_position').value = '';
        document.getElementById('dimensions').value = '';
        document.getElementById('notes').value = '';
        document.getElementById('container_size_field').style.display = 'none';
        document.getElementById('offhire_reason_field').style.display = 'none';
    }

    // Add unit
    async function addUnit(event) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Add action
        data.action = 'add_unit';
        
        try {
            const response = await fetch('../api/units.php?action=add_unit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.error) {
                toast(result.error, 'error');
            } else {
                toast('Unit added successfully!', 'success');
                closeUnitModal();
                loadUnits(); // Reload units
            }
        } catch (error) {
            console.error('Error adding unit:', error);
            toast('Error adding unit', 'error');
        }
    }

    // Open edit modal with unit data
    async function openEditUnitModal(id) {
        try {
            const response = await fetch(`../api/units.php?action=get_unit&id=${id}`);
            const unit = await response.json();
            
            if (unit.error) {
                toast(unit.error, 'error');
                return;
            }

            document.getElementById('edit_id').value = unit.id;
            document.getElementById('edit_unit_type').value = unit.unit_type;
            document.getElementById('edit_unit_code').value = unit.unit_code;
            document.getElementById('edit_zone').value = unit.zone;
            document.getElementById('edit_status').value = unit.status;
            document.getElementById('edit_container_size').value = unit.size || '';
            document.getElementById('edit_internal_label').value = unit.internal_label || '';
            document.getElementById('edit_row_area').value = unit.row_area || '';
            document.getElementById('edit_bay_position').value = unit.bay_position || '';
            document.getElementById('edit_dimensions').value = unit.dimensions || '';
            document.getElementById('edit_notes').value = unit.notes || '';
            document.getElementById('edit_offhire_reason').value = unit.offhire_reason || '';

            // Show/hide container size field
            document.getElementById('edit_container_size_field').style.display = 
                unit.unit_type === 'container' ? 'block' : 'none';
            
            // Show/hide off-hire reason field
            document.getElementById('edit_offhire_reason_field').style.display = 
                unit.status === 'offhire' ? 'block' : 'none';

            document.getElementById('editUnitModalTitle').textContent = `Edit Unit - ${unit.unit_code}`;
            document.getElementById('editUnitModalBackdrop').classList.add('open');
            
        } catch (error) {
            console.error('Error loading unit:', error);
            toast('Error loading unit data', 'error');
        }
    }

    // Edit unit
    async function editUnit(event) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Add action
        data.action = 'edit_unit';
        
        try {
            const response = await fetch('../api/units.php?action=edit_unit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.error) {
                toast(result.error, 'error');
            } else {
                toast('Unit updated successfully!', 'success');
                closeEditUnitModal();
                loadUnits(); // Reload units
            }
        } catch (error) {
            console.error('Error updating unit:', error);
            toast('Error updating unit', 'error');
        }
    }

    // Open delete modal
    function openDeleteModal(id, unitCode) {
        deleteId = id;
        document.getElementById('deleteUnitCode').textContent = unitCode;
        document.getElementById('deleteModalBackdrop').classList.add('open');
    }

    // Confirm delete
    async function confirmDelete() {
        if (!deleteId) return;
        
        try {
            const response = await fetch(`../api/units.php?action=delete_unit&id=${deleteId}`, {
                method: 'DELETE'
            });
            
            const result = await response.json();
            
            if (result.error) {
                toast(result.error, 'error');
            } else {
                toast('Unit deleted successfully!', 'success');
                closeDeleteModal();
                loadUnits(); // Reload units
            }
        } catch (error) {
            console.error('Error deleting unit:', error);
            toast('Error deleting unit', 'error');
        }
    }

    // View unit in drawer
    async function viewUnit(unitCode) {
        try {
            const response = await fetch(`../api/units.php?action=get_unit_by_code&code=${unitCode}`);
            const unit = await response.json();
            
            if (unit.error) {
                toast(unit.error, 'error');
                return;
            }

            currentUnitId = unit.id;

            const statusColors = {
                'available': 'var(--c-avail)',
                'occupied': 'var(--c-full)',
                'partial': 'var(--c-partial)',
                'expiring': 'var(--c-expiring)',
                'hold': 'var(--c-hold)',
                'offhire': 'var(--c-offhire)'
            };

            document.getElementById("dTitle").textContent = unitCode;
            document.getElementById("dSub").textContent = `${unit.zone} • ${unit.location_label || 'No location'} • Status: ${unit.status}`;
            
            document.getElementById("d-overview").innerHTML = `
                <div class="card" style="box-shadow:none">
                    <div class="row" style="gap:8px;margin-bottom:16px; flex-wrap:wrap;">
                        <span class="pill"><span class="dot" style="background:${statusColors[unit.status]}"></span>${unit.status}</span>
                        ${unit.internal_label ? `<span class="pill"><span class="dot" style="background:var(--green)"></span>${unit.internal_label}</span>` : ''}
                        ${unit.size ? `<span class="pill"><span class="dot" style="background:var(--orange)"></span>Size: ${unit.size}</span>` : ''}
                    </div>
                    <div class="form-grid">
                        <div class="col6"><div class="muted small">Unit</div><div><b>${unit.unit_code}</b></div></div>
                        <div class="col6"><div class="muted small">Type</div><div><b>${unit.unit_type}</b></div></div>
                        <div class="col6"><div class="muted small">Zone</div><div><b>${unit.zone}</b></div></div>
                        <div class="col6"><div class="muted small">Location</div><div><b>${unit.location_label || '-'}</b></div></div>
                        ${unit.dimensions ? `<div class="col6"><div class="muted small">Dimensions</div><div><b>${unit.dimensions}</b></div></div>` : ''}
                        ${unit.offhire_reason ? `<div class="col6"><div class="muted small">Off-hire Reason</div><div><b>${unit.offhire_reason}</b></div></div>` : ''}
                        <div class="col12"><div class="muted small">Notes</div><div>${unit.notes || '-'}</div></div>
                    </div>
                </div>
            `;

            document.getElementById("d-notes").innerHTML = `
                <div class="card" style="box-shadow:none">
                    <h3>Internal Notes</h3>
                    <p>${unit.notes || 'No notes available'}</p>
                </div>
            `;

            document.getElementById("drawer").classList.add("open");
            
        } catch (error) {
            console.error('Error loading unit:', error);
            toast('Error loading unit details', 'error');
        }
    }

    // Edit current unit from drawer
    function editCurrentUnit() {
        if (currentUnitId) {
            closeDrawer();
            openEditUnitModal(currentUnitId);
        }
    }

    // Delete current unit from drawer
    function deleteCurrentUnit() {
        if (currentUnitId) {
            const unitCode = document.getElementById("dTitle").textContent;
            closeDrawer();
            openDeleteModal(currentUnitId, unitCode);
        }
    }

    // Close drawer
    function closeDrawer() {
        document.getElementById("drawer").classList.remove("open");
        currentUnitId = null;
    }

    // Switch drawer tabs
    function switchDrawerTab(tabId) {
        ["overview", "occupancy", "actions", "notes"].forEach(id => {
            const el = document.getElementById("d-" + id);
            if (el) el.classList.add("hidden");
        });
        
        const selectedEl = document.getElementById("d-" + tabId);
        if (selectedEl) selectedEl.classList.remove("hidden");
        
        document.querySelectorAll("#dTabs .tab").forEach(b => b.classList.remove("active"));
        event.target.classList.add("active");
    }

    // Export functions
    function exportUnitsCSV() {
        let csv = "Unit Code,Type,Zone,Location,Size,Status,Internal Label,Notes\n";
        
        units.forEach(unit => {
            csv += `"${unit.unit_code}","${unit.unit_type}","${unit.zone}","${unit.location_label || ''}","${unit.size || ''}","${unit.status}","${unit.internal_label || ''}","${unit.notes || ''}"\n`;
        });
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `units_export_${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        window.URL.revokeObjectURL(url);
        
        toast('Export completed!', 'success');
    }

    function exportMap() {
        toast('Exporting facility map...', 'info');
    }

    function toggleView(view) {
        toast(`Switching to ${view} view`, 'info');
    }

    function openAllocateModal() {
        toast('Opening allocation modal...', 'info');
    }

    function openUnitFullPage() {
        if (currentUnitId) {
            window.location.href = `unit-details.php?id=${currentUnitId}`;
        }
    }

    // Load units on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, loading units...');
        loadUnits();
    });

    // Debug function to check API
    async function testAPI() {
        try {
            const response = await fetch('../api/units.php');
            console.log('API Test Response:', await response.json());
        } catch (error) {
            console.error('API Test Error:', error);
        }
    }
    
    // Run test in console
    console.log('Run testAPI() to check API connection');
</script>
</body>

</html>