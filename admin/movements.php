<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inbound / Outbound - RGSL</title>
    <style>
        :root {
            --orange: #f26a21;
            --green: #1aa34a;
            --bg: #f6f8fb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e5e7eb;
            --shadow: 0 10px 24px rgba(15,23,42,.08);
            --radius: 16px;
            --bad: #dc2626;
            --info: #0ea5e9;
        }
        * { box-sizing: border-box; }
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
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { height: 44px; }
        .brand h1 { font-size: 16px; margin: 0; }
        .brand p { margin: 0; color: var(--muted); font-size: 12px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end; }
        
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
        }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .btn.primary { background: var(--green); border-color: var(--green); color: #fff; }
        .btn.orange { background: var(--orange); border-color: var(--orange); color: #fff; }
        .btn.danger { background: var(--bad); border-color: var(--bad); color: #fff; }
        
        .wrap { margin: 16px auto; padding: 0 18px; }
        .shell { display: flex; gap: 12px; }
        
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
        .nav a:hover { background: #eef6f0; color: var(--green); }
        .nav a.active { background: #eef6f0; border-color: #d1fae5; color: #14532d; }
        
        main { flex: 1; min-width: 0; }
        
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px;
            box-shadow: var(--shadow);
            margin-bottom: 12px;
        }
        .row { display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
        h2 { font-size: 14px; margin: 0 0 10px 0; }
        .muted { color: var(--muted); }
        .small { font-size: 12px; }
        .hr { height: 1px; background: var(--border); margin: 12px 0; }
        
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
        .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .dot.green { background: var(--green); }
        .dot.orange { background: var(--orange); }
        .dot.red { background: var(--bad); }
        .dot.gray { background: #94a3b8; }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 900;
        }
        .b-green { background: #dcfce7; color: #166534; }
        .b-orange { background: #ffedd5; color: #9a3412; }
        .b-red { background: #fee2e2; color: #991b1b; }
        .b-gray { background: #e2e8f0; color: #334155; }
        .b-blue { background: #dbeafe; color: #1e40af; }
        
        .kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 14px;
        }
        .kpi {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px;
            background: #fff;
        }
        .kpi .label { font-size: 12px; color: var(--muted); font-weight: 900; }
        .kpi .value { font-size: 20px; font-weight: 1000; margin-top: 6px; }
        
        .form-grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 10px; }
        .col3 { grid-column: span 3; }
        .col4 { grid-column: span 4; }
        .col6 { grid-column: span 6; }
        .col12 { grid-column: span 12; }
        
        label { display: block; margin-bottom: 4px; font-weight: 900; font-size: 12px; color: var(--muted); }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            font-weight: 700;
            color: var(--text);
            font-size: 13px;
        }
        textarea { min-height: 80px; resize: vertical; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th, td {
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
        tr:hover { background: #f8fafc; }
        .link { cursor: pointer; color: var(--green); font-weight: 900; }
        
        .backdrop {
            position: fixed;
            inset: 0;
            background: rgba(2,6,23,.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 60;
            padding: 18px;
        }
        .backdrop.open { display: flex; }
        .modal {
            width: min(700px, 100%);
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 24px 60px rgba(0,0,0,.25);
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
        .modal header h3 { margin: 0; font-size: 16px; }
        .modal .body { padding: 14px 16px; overflow: auto; }
        .modal .footer { padding: 12px 16px; border-top: 1px solid var(--border); display: flex; gap: 10px; justify-content: flex-end; }
        .x { position: absolute; right: 12px; top: 12px; }
        
        @media (max-width: 1100px) {
            aside { display: none; }
            .kpis { grid-template-columns: repeat(2, 1fr); }
            .col3, .col4, .col6, .col12 { grid-column: span 12; }
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <div class="brand">
                <img alt="RGSL Logo" src="https://royalgulfshipping.com/wp-content/uploads/2025/11/RGSL-LOGO.png"/>
                <div>
                    <h1>Inbound / Outbound</h1>
                    <p>Admin Portal • Movement Tracking & History</p>
                </div>
            </div>
            <div class="actions">
                <button class="btn orange" onclick="openLogMovement()">+ Log Movement</button>
                <button class="btn primary" onclick="location.href='admin-dashboard.html'">Back to Dashboard</button>
            </div>
        </div>
    </header>

    <div class="wrap">
        <div class="shell">
            <aside>
                <div class="navTitle">ADMIN MENU</div>
                <div class="nav">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="clients.php">Clients</a>
                    <a href="facility.php">Facility Map</a>
                    <a href="units.php">Unit Analytics</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="movements.php" class="active">Inbound / Outbound</a>
                    <a href="notices.php">Notices & Legal</a>
                    <a href="reports.php">Reports</a>
                </div>
                
                <div class="hr"></div>
                
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn orange" style="width:100%;margin-bottom:8px" onclick="openLogMovement()">+ Log Movement</button>
                <button class="btn primary" style="width:100%;margin-bottom:8px" onclick="openScheduleMovement()">+ Schedule Pickup</button>
                <button class="btn" style="width:100%" onclick="toast('Export Movements')">Export CSV</button>
            </aside>

            <main>
                <!-- KPIs -->
                <div class="card">
                    <div class="kpis">
                        <div class="kpi">
                            <div class="label">Total Movements (Today)</div>
                            <div class="value">24</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Inbound Today</div>
                            <div class="value">15</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Outbound Today</div>
                            <div class="value">9</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Scheduled Pickups</div>
                            <div class="value">7</div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card">
                    <div class="row">
                        <h2>Search & Filters</h2>
                        <div class="row" style="gap:8px">
                            <button class="btn" onclick="applyQuick('today')">Today</button>
                            <button class="btn" onclick="applyQuick('week')">This Week</button>
                            <button class="btn" onclick="applyQuick('month')">This Month</button>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="col3">
                            <label>Date From</label>
                            <input type="date" id="dateFrom" value="2025-12-01">
                        </div>
                        <div class="col3">
                            <label>Date To</label>
                            <input type="date" id="dateTo" value="2025-12-31">
                        </div>
                        <div class="col3">
                            <label>Movement Type</label>
                            <select id="movementType">
                                <option value="all">All</option>
                                <option value="inbound">Inbound</option>
                                <option value="outbound">Outbound</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Client</label>
                            <select id="clientFilter">
                                <option value="all">All Clients</option>
                                <option value="C-1001">ABC Trading LLC</option>
                                <option value="C-1002">XYZ Imports</option>
                            </select>
                        </div>
                        <div class="col6">
                            <label>Search</label>
                            <input id="search" placeholder="Unit #, Reference #, Notes...">
                        </div>
                        <div class="col6" style="display:flex;align-items:flex-end;gap:10px">
                            <button class="btn primary" style="width:100%" onclick="applyFilters()">Apply</button>
                            <button class="btn" style="width:100%" onclick="resetFilters()">Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Movements Table -->
                <div class="card">
                    <div class="row">
                        <h2>Movement Log</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill">Showing: <b>12</b></span>
                            <button class="btn" onclick="toast('Export CSV')">Export CSV</button>
                        </div>
                    </div>
                    <table>
                        <tr>
                            <th>Date/Time</th>
                            <th>Client</th>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>In (pkgs)</th>
                            <th>Out (pkgs)</th>
                            <th>Reference</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td>2025-12-18 10:22</td>
                            <td><b>ABC Trading LLC</b></td>
                            <td>Shed-09</td>
                            <td><span class="badge b-green">Inbound</span></td>
                            <td>45</td>
                            <td>0</td>
                            <td>MOV-9001</td>
                            <td class="muted">Electronics cartons</td>
                            <td>
                                <button class="btn" onclick="openMovement('MOV-9001')">View</button>
                                <button class="btn ghost" onclick="toast('Edit movement')">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2025-12-18 15:10</td>
                            <td><b>ABC Trading LLC</b></td>
                            <td>Shed-09</td>
                            <td><span class="badge b-orange">Outbound</span></td>
                            <td>0</td>
                            <td>12</td>
                            <td>MOV-9002</td>
                            <td class="muted">Partial delivery</td>
                            <td>
                                <button class="btn" onclick="openMovement('MOV-9002')">View</button>
                                <button class="btn ghost" onclick="toast('Edit movement')">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2025-12-19 09:30</td>
                            <td><b>XYZ Imports</b></td>
                            <td>Shed-12</td>
                            <td><span class="badge b-green">Inbound</span></td>
                            <td>30</td>
                            <td>0</td>
                            <td>MOV-9003</td>
                            <td class="muted">Spare parts</td>
                            <td>
                                <button class="btn" onclick="openMovement('MOV-9003')">View</button>
                                <button class="btn ghost" onclick="toast('Edit movement')">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2025-12-19 14:15</td>
                            <td><b>Noor Electronics</b></td>
                            <td>CONT-14</td>
                            <td><span class="badge b-orange">Outbound</span></td>
                            <td>0</td>
                            <td>8</td>
                            <td>MOV-9004</td>
                            <td class="muted">Export shipment</td>
                            <td>
                                <button class="btn" onclick="openMovement('MOV-9004')">View</button>
                                <button class="btn ghost" onclick="toast('Edit movement')">Edit</button>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Scheduled Pickups -->
                <div class="card">
                    <div class="row">
                        <h2>Scheduled Pickups / Deliveries</h2>
                        <button class="btn orange" onclick="openScheduleMovement()">+ Schedule New</button>
                    </div>
                    <table>
                        <tr>
                            <th>Date/Time</th>
                            <th>Client</th>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>Est. Packages</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td>2025-12-20 10:00</td>
                            <td>ABC Trading LLC</td>
                            <td>Shed-09</td>
                            <td><span class="badge b-orange">Pickup</span></td>
                            <td>25</td>
                            <td><span class="badge b-gray">Confirmed</span></td>
                            <td><button class="btn" onclick="toast('Manage schedule')">Manage</button></td>
                        </tr>
                        <tr>
                            <td>2025-12-21 14:30</td>
                            <td>XYZ Imports</td>
                            <td>Shed-12</td>
                            <td><span class="badge b-green">Delivery</span></td>
                            <td>40</td>
                            <td><span class="badge b-gray">Pending</span></td>
                            <td><button class="btn" onclick="toast('Manage schedule')">Manage</button></td>
                        </tr>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Log Movement Modal -->
    <div class="backdrop" id="movementModal">
        <div class="modal">
            <header>
                <h3>Log New Movement</h3>
                <button class="btn x" onclick="closeModal()">✕</button>
            </header>
            <div class="body">
                <div class="form-grid">
                    <div class="col6">
                        <label>Client</label>
                        <select id="moveClient">
                            <option value="">Select Client...</option>
                            <option value="C-1001">ABC Trading LLC</option>
                            <option value="C-1002">XYZ Imports</option>
                            <option value="C-1003">Noor Electronics</option>
                        </select>
                    </div>
                    <div class="col6">
                        <label>Unit</label>
                        <select id="moveUnit">
                            <option value="">Select Unit...</option>
                            <option value="Shed-09">Shed-09</option>
                            <option value="Shed-12">Shed-12</option>
                            <option value="CONT-07">CONT-07</option>
                        </select>
                    </div>
                    <div class="col4">
                        <label>Movement Type</label>
                        <select id="moveType">
                            <option value="inbound">Inbound</option>
                            <option value="outbound">Outbound</option>
                        </select>
                    </div>
                    <div class="col4">
                        <label>Date & Time</label>
                        <input type="datetime-local" value="2025-12-20T09:00">
                    </div>
                    <div class="col4">
                        <label>Reference #</label>
                        <input value="MOV-" placeholder="Auto or manual">
                    </div>
                    <div class="col4">
                        <label>Packages In</label>
                        <input type="number" value="0" min="0">
                    </div>
                    <div class="col4">
                        <label>Packages Out</label>
                        <input type="number" value="0" min="0">
                    </div>
                    <div class="col4">
                        <label>Carrier/Vehicle</label>
                        <input placeholder="Truck #, etc.">
                    </div>
                    <div class="col12">
                        <label>Notes</label>
                        <textarea placeholder="Package details, special instructions..."></textarea>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn" onclick="closeModal()">Cancel</button>
                <button class="btn primary" onclick="saveMovement()">Save Movement</button>
            </div>
        </div>
    </div>

    <!-- Schedule Movement Modal -->
    <div class="backdrop" id="scheduleModal">
        <div class="modal">
            <header>
                <h3>Schedule Pickup/Delivery</h3>
                <button class="btn x" onclick="closeModal()">✕</button>
            </header>
            <div class="body">
                <div class="form-grid">
                    <div class="col6">
                        <label>Client</label>
                        <select>
                            <option>ABC Trading LLC</option>
                            <option>XYZ Imports</option>
                        </select>
                    </div>
                    <div class="col6">
                        <label>Unit</label>
                        <select>
                            <option>Shed-09</option>
                            <option>Shed-12</option>
                        </select>
                    </div>
                    <div class="col4">
                        <label>Type</label>
                        <select>
                            <option>Pickup (Outbound)</option>
                            <option>Delivery (Inbound)</option>
                        </select>
                    </div>
                    <div class="col4">
                        <label>Scheduled Date</label>
                        <input type="date" value="2025-12-21">
                    </div>
                    <div class="col4">
                        <label>Scheduled Time</label>
                        <input type="time" value="10:00">
                    </div>
                    <div class="col4">
                        <label>Est. Packages</label>
                        <input type="number" value="25">
                    </div>
                    <div class="col8">
                        <label>Contact Person</label>
                        <input placeholder="Name & phone">
                    </div>
                    <div class="col12">
                        <label>Notes</label>
                        <textarea placeholder="Special instructions for warehouse..."></textarea>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn" onclick="closeModal()">Cancel</button>
                <button class="btn primary" onclick="saveSchedule()">Schedule</button>
            </div>
        </div>
    </div>

    <script>
        function toast(msg) {
            const t = document.createElement("div");
            t.textContent = msg;
            Object.assign(t.style, {
                position: "fixed", right: "18px", bottom: "18px",
                background: "#111827", color: "#fff", padding: "12px 16px",
                borderRadius: "12px", boxShadow: "0 12px 24px rgba(0,0,0,.2)",
                fontWeight: "900", fontSize: "13px", zIndex: 9999
            });
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 2700);
        }

        function openLogMovement() {
            document.getElementById("movementModal").classList.add("open");
        }

        function openScheduleMovement() {
            document.getElementById("scheduleModal").classList.add("open");
        }

        function openMovement(ref) {
            toast("Opening movement: " + ref);
        }

        function closeModal() {
            document.querySelectorAll(".backdrop").forEach(b => b.classList.remove("open"));
        }

        function saveMovement() {
            toast("Movement logged successfully!");
            closeModal();
        }

        function saveSchedule() {
            toast("Movement scheduled successfully!");
            closeModal();
        }

        function applyFilters() {
            toast("Filters applied");
        }

        function applyQuick(period) {
            toast("Quick filter: " + period);
        }

        function resetFilters() {
            document.getElementById("dateFrom").value = "2025-12-01";
            document.getElementById("dateTo").value = "2025-12-31";
            document.getElementById("movementType").value = "all";
            document.getElementById("clientFilter").value = "all";
            document.getElementById("search").value = "";
            toast("Filters reset");
        }
    </script>
</body>
</html>