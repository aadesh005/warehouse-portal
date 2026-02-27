<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notices & Legal - RGSL</title>
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
        
        .grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 12px; }
        .span6 { grid-column: span 6; }
        .span12 { grid-column: span 12; }
        
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
        
        .timeline {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin: 10px 0;
        }
        .timeline-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border: 1px solid var(--border);
            border-radius: 12px;
        }
        .timeline-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        .timeline-dot.complete { background: var(--green); }
        .timeline-dot.pending { background: var(--orange); }
        .timeline-dot.missing { background: var(--bad); }
        
        @media (max-width: 1100px) {
            aside { display: none; }
            .kpis { grid-template-columns: repeat(2, 1fr); }
            .col3, .col4, .col6, .col12, .span6 { grid-column: span 12; }
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <div class="brand">
                <img alt="RGSL Logo" src="https://royalgulfshipping.com/wp-content/uploads/2025/11/RGSL-LOGO.png"/>
                <div>
                    <h1>Notices & Legal</h1>
                    <p>Admin Portal • Notice Cycles & Legal Compliance</p>
                </div>
            </div>
            <div class="actions">
                <button class="btn danger" onclick="openGenerateNotice()">+ Generate Notice</button>
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
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="notices.php" class="active">Notices & Legal</a>
                    <a href="reports.php">Reports</a>
                </div>
                
                <div class="hr"></div>
                
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn danger" style="width:100%;margin-bottom:8px" onclick="openGenerateNotice()">+ Generate Notice</button>
                <button class="btn primary" style="width:100%;margin-bottom:8px" onclick="toast('Upload Courier Proof')">Upload Proof</button>
                <button class="btn" style="width:100%" onclick="toast('Export Notice Log')">Export Log</button>
            </aside>

            <main>
                <!-- KPIs -->
                <div class="card">
                    <div class="kpis">
                        <div class="kpi">
                            <div class="label">Active Notice Cycles</div>
                            <div class="value">7</div>
                        </div>
                        <div class="kpi">
                            <div class="label">1st Notice Pending</div>
                            <div class="value">3</div>
                        </div>
                        <div class="kpi">
                            <div class="label">2nd Notice</div>
                            <div class="value">2</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Final/LBA Stage</div>
                            <div class="value">2</div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card">
                    <div class="form-grid">
                        <div class="col4">
                            <label>Notice Stage</label>
                            <select id="stageFilter">
                                <option value="all">All Stages</option>
                                <option value="1st">1st Notice</option>
                                <option value="2nd">2nd Notice</option>
                                <option value="3rd">3rd Notice</option>
                                <option value="lba">Letter Before Action</option>
                                <option value="final">Final Notice</option>
                            </select>
                        </div>
                        <div class="col4">
                            <label>Compliance Status</label>
                            <select id="complianceFilter">
                                <option value="all">All</option>
                                <option value="complete">Email + Courier Complete</option>
                                <option value="missing">Missing Proof</option>
                            </select>
                        </div>
                        <div class="col4">
                            <label>Search Client</label>
                            <input id="search" placeholder="Client name or ID...">
                        </div>
                        <div class="col12" style="display:flex;gap:10px;align-items:flex-end">
                            <button class="btn primary" style="width:100%" onclick="applyFilters()">Apply</button>
                            <button class="btn" style="width:100%" onclick="resetFilters()">Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Active Notices Table -->
                <div class="card">
                    <div class="row">
                        <h2>Active Notice Cycles</h2>
                        <span class="pill">Showing: <b>7</b></span>
                    </div>
                    <table>
                        <tr>
                            <th>Client</th>
                            <th>Outstanding</th>
                            <th>Days Overdue</th>
                            <th>Current Stage</th>
                            <th>Next Due</th>
                            <th>Email Log</th>
                            <th>Courier Proof</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td><b>XYZ Imports</b><div class="muted">C-1002</div></td>
                            <td><b>AED 38,500</b></td>
                            <td>45 days</td>
                            <td><span class="badge b-orange">2nd Notice</span></td>
                            <td>2025-12-21</td>
                            <td><span class="badge b-green">Sent ✓</span></td>
                            <td><span class="badge b-red">Missing ⚠</span></td>
                            <td>
                                <button class="btn" onclick="openNotice('XYZ Imports')">Manage</button>
                                <button class="btn ghost" onclick="uploadProof()">Upload</button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>LMN Traders</b><div class="muted">C-1015</div></td>
                            <td><b>AED 24,750</b></td>
                            <td>62 days</td>
                            <td><span class="badge b-red">LBA</span></td>
                            <td>2025-12-19</td>
                            <td><span class="badge b-green">Sent ✓</span></td>
                            <td><span class="badge b-green">Uploaded ✓</span></td>
                            <td>
                                <button class="btn" onclick="openNotice('LMN Traders')">Manage</button>
                                <button class="btn ghost" onclick="toast('View proof')">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Sigma Auto</b><div class="muted">C-1022</div></td>
                            <td><b>AED 17,100</b></td>
                            <td>38 days</td>
                            <td><span class="badge b-red">Final Notice</span></td>
                            <td>2025-12-24</td>
                            <td><span class="badge b-green">Sent ✓</span></td>
                            <td><span class="badge b-green">Uploaded ✓</span></td>
                            <td>
                                <button class="btn" onclick="openNotice('Sigma Auto')">Manage</button>
                                <button class="btn ghost" onclick="toast('Legal action')">Legal</button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Prime Logistics</b><div class="muted">C-1033</div></td>
                            <td><b>AED 9,450</b></td>
                            <td>12 days</td>
                            <td><span class="badge b-green">1st Notice</span></td>
                            <td>2025-12-28</td>
                            <td><span class="badge b-green">Sent ✓</span></td>
                            <td><span class="badge b-gray">Pending</span></td>
                            <td>
                                <button class="btn" onclick="openNotice('Prime Logistics')">Manage</button>
                                <button class="btn ghost" onclick="uploadProof()">Upload</button>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Notice Timeline & Legal Info -->
                <div class="grid">
                    <div class="card span6">
                        <div class="row">
                            <h2>Notice Cycle Timeline</h2>
                            <span class="pill"><span class="dot red"></span>7-day intervals</span>
                        </div>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot complete"></div>
                                <div style="flex:1"><b>1st Notice</b> - Email + Courier</div>
                                <span class="badge b-green">Complete</span>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot complete"></div>
                                <div style="flex:1"><b>2nd Notice</b> - Email + Courier</div>
                                <span class="badge b-green">Complete</span>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot pending"></div>
                                <div style="flex:1"><b>3rd Notice</b> - Email + Courier</div>
                                <span class="badge b-orange">Pending</span>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div style="flex:1"><b>Letter Before Action (LBA)</b></div>
                                <span class="badge b-gray">Upcoming</span>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div style="flex:1"><b>Final Notice</b></div>
                                <span class="badge b-gray">Upcoming</span>
                            </div>
                        </div>
                        <div class="muted small" style="margin-top:10px">
                            Policy: If unpaid for 2 consecutive months, start notice cycle with 7-day intervals.
                        </div>
                    </div>

                    <div class="card span6">
                        <div class="row">
                            <h2>Legal Compliance</h2>
                            <button class="btn" onclick="toast('View legal templates')">Templates</button>
                        </div>
                        <div style="margin:15px 0">
                            <div class="pill" style="margin-bottom:8px"><span class="dot green"></span>Email logs: 100% compliance</div>
                            <div class="pill" style="margin-bottom:8px"><span class="dot orange"></span>Courier proof: 4 missing</div>
                            <div class="pill"><span class="dot red"></span>Legal cases: 2 pending</div>
                        </div>
                        <div class="hr"></div>
                        <h2>Recent Legal Actions</h2>
                        <table>
                            <tr>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td>2025-12-15</td>
                                <td>XYZ Imports</td>
                                <td>LBA sent</td>
                                <td><span class="badge b-orange">Active</span></td>
                            </tr>
                            <tr>
                                <td>2025-12-10</td>
                                <td>LMN Traders</td>
                                <td>Court filing</td>
                                <td><span class="badge b-red">Pending</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Generate Notice Modal -->
    <div class="backdrop" id="noticeModal">
        <div class="modal">
            <header>
                <h3>Generate Notice</h3>
                <button class="btn x" onclick="closeModal()">✕</button>
            </header>
            <div class="body">
                <div class="form-grid">
                    <div class="col6">
                        <label>Client</label>
                        <select id="noticeClient">
                            <option value="">Select Client...</option>
                            <option value="C-1002">XYZ Imports (Overdue 45 days)</option>
                            <option value="C-1015">LMN Traders (Overdue 62 days)</option>
                            <option value="C-1022">Sigma Auto (Overdue 38 days)</option>
                        </select>
                    </div>
                    <div class="col6">
                        <label>Notice Stage</label>
                        <select id="noticeStage">
                            <option value="1st">1st Notice</option>
                            <option value="2nd">2nd Notice</option>
                            <option value="3rd">3rd Notice</option>
                            <option value="lba">Letter Before Action</option>
                            <option value="final">Final Notice</option>
                        </select>
                    </div>
                    <div class="col6">
                        <label>Due Date</label>
                        <input type="date" value="2025-12-28">
                    </div>
                    <div class="col6">
                        <label>Template</label>
                        <select>
                            <option>Standard Notice - English</option>
                            <option>Standard Notice - Arabic</option>
                            <option>Legal LBA Template</option>
                        </select>
                    </div>
                    <div class="col12">
                        <label>Additional Notes</label>
                        <textarea placeholder="Any special instructions or references..."></textarea>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn" onclick="closeModal()">Cancel</button>
                <button class="btn primary" onclick="generateNotice()">Generate & Send</button>
            </div>
        </div>
    </div>

    <!-- Upload Proof Modal -->
    <div class="backdrop" id="proofModal">
        <div class="modal">
            <header>
                <h3>Upload Courier Proof</h3>
                <button class="btn x" onclick="closeModal()">✕</button>
            </header>
            <div class="body">
                <div class="form-grid">
                    <div class="col6">
                        <label>Client</label>
                        <select>
                            <option>XYZ Imports - 2nd Notice</option>
                            <option>Prime Logistics - 1st Notice</option>
                        </select>
                    </div>
                    <div class="col6">
                        <label>Courier Company</label>
                        <input placeholder="e.g., Aramex, FedEx">
                    </div>
                    <div class="col6">
                        <label>Tracking Number</label>
                        <input placeholder="Tracking #">
                    </div>
                    <div class="col6">
                        <label>Delivery Date</label>
                        <input type="date" value="2025-12-20">
                    </div>
                    <div class="col12">
                        <label>Upload Proof (PDF/Image)</label>
                        <input type="file">
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn" onclick="closeModal()">Cancel</button>
                <button class="btn primary" onclick="uploadProofComplete()">Upload</button>
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

        function openGenerateNotice() {
            document.getElementById("noticeModal").classList.add("open");
        }

        function openNotice(client) {
            toast("Opening notice cycle for: " + client);
        }

        function uploadProof() {
            document.getElementById("proofModal").classList.add("open");
        }

        function closeModal() {
            document.querySelectorAll(".backdrop").forEach(b => b.classList.remove("open"));
        }

        function generateNotice() {
            toast("Notice generated and sent!");
            closeModal();
        }

        function uploadProofComplete() {
            toast("Proof uploaded successfully!");
            closeModal();
        }

        function applyFilters() {
            toast("Filters applied");
        }

        function resetFilters() {
            document.getElementById("stageFilter").value = "all";
            document.getElementById("complianceFilter").value = "all";
            document.getElementById("search").value = "";
            toast("Filters reset");
        }
    </script>
</body>
</html>