<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Unit Analytics - RGSL</title>
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
            --occ: #1aa34a;
            --empty: #94a3b8;
            --offhire: #0ea5e9;
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
        .dot.blue { background: var(--info); }
        
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
            grid-template-columns: repeat(6, 1fr);
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
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            font-weight: 700;
            color: var(--text);
            font-size: 13px;
        }
        
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
        
        .grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 12px; }
        .span8 { grid-column: span 8; }
        .span6 { grid-column: span 6; }
        .span4 { grid-column: span 4; }
        
        .barLine {
            display: flex;
            border-radius: 999px;
            overflow: hidden;
            height: 14px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }
        .seg { height: 100%; }
        .seg.occ { background: var(--occ); }
        .seg.empty { background: var(--empty); }
        .seg.offhire { background: var(--offhire); }
        
        .drawer {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: min(560px, 96vw);
            background: #fff;
            border-left: 1px solid var(--border);
            box-shadow: -20px 0 40px rgba(0,0,0,.12);
            transform: translateX(110%);
            transition: transform 0.3s ease;
            z-index: 40;
            display: flex;
            flex-direction: column;
        }
        .drawer.open { transform: translateX(0); }
        .drawerHeader {
            padding: 14px;
            border-bottom: 1px solid var(--border);
        }
        .drawerBody { padding: 14px; overflow: auto; flex: 1; }
        .drawerFooter {
            padding: 12px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }
        
        @media (max-width: 1100px) {
            aside { display: none; }
            .kpis { grid-template-columns: repeat(2, 1fr); }
            .col3, .col4, .col6, .col12, .span8, .span6, .span4 { grid-column: span 12; }
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <div class="brand">
                <img alt="RGSL Logo" src="https://royalgulfshipping.com/wp-content/uploads/2025/11/RGSL-LOGO.png"/>
                <div>
                    <h1>Unit Analytics</h1>
                    <p>Admin Portal • Occupancy & Utilization Analysis</p>
                </div>
            </div>
            <div class="actions">
                <button class="btn" onclick="toast('Export Analytics')">Export Report</button>
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
                    <a href="units.php" class="active">Unit Analytics</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="notices.php">Notices & Legal</a>
                    <a href="reports.php">Reports</a>
                </div>
                
                <div class="hr"></div>
                
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn orange" style="width:100%;margin-bottom:8px" onclick="toast('+ Add Unit')">+ Add Unit</button>
                <button class="btn primary" style="width:100%;margin-bottom:8px" onclick="toast('+ Allocate Unit')">+ Allocate Unit</button>
                <button class="btn" style="width:100%" onclick="toast('Export Analytics')">Export</button>
            </aside>

            <main>
                <!-- Filters -->
                <div class="card">
                    <div class="row">
                        <h2>Analytics Filters</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill"><span class="dot green"></span>Occupied</span>
                            <span class="pill"><span class="dot gray"></span>Empty</span>
                            <span class="pill"><span class="dot blue"></span>Off-hire</span>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="col3">
                            <label>Date Range From</label>
                            <input type="date" id="fromDate" value="2025-12-01">
                        </div>
                        <div class="col3">
                            <label>Date Range To</label>
                            <input type="date" id="toDate" value="2025-12-31">
                        </div>
                        <div class="col3">
                            <label>Unit Type</label>
                            <select id="unitType">
                                <option value="all">All</option>
                                <option value="shed">Sheds</option>
                                <option value="container">Containers</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Zone</label>
                            <select id="zone">
                                <option value="all">All</option>
                                <option value="Zone A">Zone A</option>
                                <option value="Zone B">Zone B</option>
                                <option value="Yard">Yard</option>
                            </select>
                        </div>
                        <div class="col4">
                            <label>Status</label>
                            <select id="status">
                                <option value="all">All</option>
                                <option value="occupied">Occupied</option>
                                <option value="available">Available</option>
                                <option value="offhire">Off-hire</option>
                                <option value="hold">Hold/Legal</option>
                                <option value="expiring">Expiring</option>
                            </select>
                        </div>
                        <div class="col4">
                            <label>Search Unit/Client</label>
                            <input id="search" placeholder="e.g., Shed-09, ABC Trading">
                        </div>
                        <div class="col4" style="display:flex;align-items:flex-end;gap:10px">
                            <button class="btn primary" style="width:100%" onclick="applyFilters()">Apply</button>
                            <button class="btn" style="width:100%" onclick="resetFilters()">Reset</button>
                        </div>
                    </div>
                </div>

                <!-- KPIs -->
                <div class="card">
                    <div class="kpis">
                        <div class="kpi">
                            <div class="label">Total Units</div>
                            <div class="value" id="totalUnits">89</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Occupied (range)</div>
                            <div class="value" id="occupiedUnits">71</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Empty (range)</div>
                            <div class="value" id="emptyUnits">12</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Off-hire (range)</div>
                            <div class="value" id="offhireUnits">6</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Avg Occupancy</div>
                            <div class="value" id="avgOccupancy">79%</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Revenue Loss (empty)</div>
                            <div class="value" id="revenueLoss">AED 26,520</div>
                        </div>
                    </div>
                </div>

                <!-- Occupancy Chart -->
                <div class="grid">
                    <div class="card span8">
                        <div class="row">
                            <h2>Occupancy Trend</h2>
                            <div class="row" style="gap:8px">
                                <span class="pill"><span class="dot green"></span>Occupied</span>
                                <span class="pill"><span class="dot gray"></span>Empty</span>
                                <span class="pill"><span class="dot blue"></span>Off-hire</span>
                            </div>
                        </div>
                        <canvas id="occChart" width="900" height="260"></canvas>
                    </div>

                    <div class="card span4">
                        <div class="row">
                            <h2>Occupancy by Type</h2>
                        </div>
                        <canvas id="typeChart" width="400" height="260"></canvas>
                    </div>
                </div>

                <!-- Units Table -->
                <div class="card">
                    <div class="row">
                        <h2>Unit Occupancy Details</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill">Showing: <b id="listCount">8</b></span>
                            <button class="btn" onclick="toast('Export CSV')">Export CSV</button>
                        </div>
                    </div>
                    <table id="unitsTable">
                        <tr>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>Zone</th>
                            <th>Status</th>
                            <th>Occupied Days</th>
                            <th>Empty Days</th>
                            <th>Off-hire Days</th>
                            <th>Utilization</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td><b>Shed-01</b></td>
                            <td>Shed</td>
                            <td>Zone A</td>
                            <td><span class="badge b-green">Occupied</span></td>
                            <td>31</td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                                <div class="barLine" style="width:100px">
                                    <div class="seg occ" style="width:100%"></div>
                                </div>
                            </td>
                            <td><button class="btn" onclick="openUnitDrawer('Shed-01')">Analyze</button></td>
                        </tr>
                        <tr>
                            <td><b>Shed-09</b></td>
                            <td>Shed</td>
                            <td>Zone A</td>
                            <td><span class="badge b-orange">Partial</span></td>
                            <td>25</td>
                            <td>6</td>
                            <td>0</td>
                            <td>
                                <div class="barLine" style="width:100px">
                                    <div class="seg occ" style="width:80%"></div>
                                    <div class="seg empty" style="width:20%"></div>
                                </div>
                            </td>
                            <td><button class="btn" onclick="openUnitDrawer('Shed-09')">Analyze</button></td>
                        </tr>
                        <tr>
                            <td><b>CONT-12</b></td>
                            <td>Container</td>
                            <td>Yard</td>
                            <td><span class="badge b-blue">Off-hire</span></td>
                            <td>0</td>
                            <td>0</td>
                            <td>31</td>
                            <td>
                                <div class="barLine" style="width:100px">
                                    <div class="seg offhire" style="width:100%"></div>
                                </div>
                            </td>
                            <td><button class="btn" onclick="openUnitDrawer('CONT-12')">Analyze</button></td>
                        </tr>
                        <tr>
                            <td><b>CONT-07</b></td>
                            <td>Container</td>
                            <td>Yard</td>
                            <td><span class="badge b-green">Occupied</span></td>
                            <td>31</td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                                <div class="barLine" style="width:100px">
                                    <div class="seg occ" style="width:100%"></div>
                                </div>
                            </td>
                            <td><button class="btn" onclick="openUnitDrawer('CONT-07')">Analyze</button></td>
                        </tr>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Unit Details Drawer -->
    <div class="drawer" id="unitDrawer">
        <div class="drawerHeader">
            <div class="row">
                <div>
                    <div style="font-size:14px;font-weight:1000" id="drawerTitle">Unit Details</div>
                    <div class="muted small" id="drawerSub">—</div>
                </div>
                <button class="btn ghost" onclick="closeDrawer()">✕</button>
            </div>
        </div>
        <div class="drawerBody" id="drawerBody">
            <!-- Content will be populated by JS -->
        </div>
        <div class="drawerFooter">
            <button class="btn" onclick="toast('Open unit page')">Open Unit</button>
            <button class="btn orange" onclick="toast('Edit unit')">Edit</button>
            <button class="btn primary" onclick="toast('Allocate unit')">Allocate</button>
        </div>
    </div>

    <script>
        // Toast notification
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

        // Drawer functions
        function openUnitDrawer(unitId) {
            document.getElementById("drawerTitle").textContent = unitId;
            document.getElementById("drawerSub").textContent = "Unit Analytics • Click tabs for details";
            document.getElementById("unitDrawer").classList.add("open");
            
            document.getElementById("drawerBody").innerHTML = `
                <div class="card" style="box-shadow:none">
                    <div class="tabs" style="margin-bottom:15px">
                        <button class="tab active" onclick="switchDrawerTab('overview')">Overview</button>
                        <button class="tab" onclick="switchDrawerTab('timeline')">Timeline</button>
                        <button class="tab" onclick="switchDrawerTab('invoices')">Invoices</button>
                    </div>
                    <div id="drawerOverview">
                        <div class="row" style="gap:8px;margin-bottom:16px;">
                            <span class="pill"><span class="dot green"></span>Occupied: <b>25 days</b></span>
                            <span class="pill"><span class="dot gray"></span>Empty: <b>6 days</b></span>
                            <span class="pill"><span class="dot blue"></span>Off-hire: <b>0 days</b></span>
                        </div>
                        <div class="form-grid">
                            <div class="col6"><div class="muted small">Unit Type</div><div><b>Shed</b></div></div>
                            <div class="col6"><div class="muted small">Zone</div><div><b>Zone A</b></div></div>
                            <div class="col6"><div class="muted small">Current Client</div><div><b>ABC Trading LLC</b></div></div>
                            <div class="col6"><div class="muted small">Utilization Rate</div><div><b>80%</b></div></div>
                            <div class="col12"><div class="muted small">Period</div><div><b>2025-12-01 → 2025-12-31</b></div></div>
                        </div>
                    </div>
                </div>
            `;
        }

        function closeDrawer() {
            document.getElementById("unitDrawer").classList.remove("open");
        }

        function switchDrawerTab(tab) {
            toast("Switch to " + tab + " tab");
        }

        // Filter functions
        function applyFilters() {
            toast("Filters applied");
        }

        function resetFilters() {
            document.getElementById("fromDate").value = "2025-12-01";
            document.getElementById("toDate").value = "2025-12-31";
            document.getElementById("unitType").value = "all";
            document.getElementById("zone").value = "all";
            document.getElementById("status").value = "all";
            document.getElementById("search").value = "";
            toast("Filters reset");
        }

        // Chart drawing (simplified)
        function drawCharts() {
            const ctx1 = document.getElementById('occChart').getContext('2d');
            ctx1.clearRect(0, 0, 900, 260);
            
            // Simple line chart placeholder
            ctx1.fillStyle = '#f6f8fb';
            ctx1.fillRect(0, 0, 900, 260);
            ctx1.font = '12px Segoe UI';
            ctx1.fillStyle = '#64748b';
            ctx1.fillText('Occupancy trend chart would render here with real data', 50, 130);
        }

        // Initialize
        window.onload = function() {
            drawCharts();
        };
    </script>
</body>
</html>