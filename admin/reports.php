<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports - RGSL</title>
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
        
        .grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }
        .span6 { grid-column: span 6; }
        .span4 { grid-column: span 4; }
        .span8 { grid-column: span 8; }
        .span12 { grid-column: span 12; }
        
        .report-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s;
        }
        .report-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            border-color: var(--green);
        }
        .report-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .report-title {
            font-weight: 1000;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .report-desc {
            color: var(--muted);
            font-size: 12px;
        }
        
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
        }
        th {
            color: var(--muted);
            font-weight: 900;
            font-size: 12px;
            background: #f8fafc;
        }
        
        @media (max-width: 1100px) {
            aside { display: none; }
            .span4, .span6, .span8 { grid-column: span 12; }
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <div class="brand">
                <img alt="RGSL Logo" src="https://royalgulfshipping.com/wp-content/uploads/2025/11/RGSL-LOGO.png"/>
                <div>
                    <h1>Reports</h1>
                    <p>Admin Portal • Analytics & Business Intelligence</p>
                </div>
            </div>
            <div class="actions">
                <button class="btn orange" onclick="toast('Schedule Report')">Schedule Report</button>
                <button class="btn primary" onclick="location.href='admin-dashboard.html'">Back to Dashboard</button>
            </div>
        </div>
    </header>

    <div class="wrap">
        <div class="shell">
            <aside>
                <div class="navTitle">ADMIN MENU</div>
                <div class="nav">
                    <a href="dashboard.php" >Dashboard</a>
                    <a href="clients.php">Clients</a>
                    <a href="facility.php">Facility Map</a>
                    <a href="units.php">Unit Analytics</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="notices.php">Notices & Legal</a>
                    <a href="reports.php" class="active">Reports</a>
                </div>
                
                <div class="hr"></div>
                
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn orange" style="width:100%;margin-bottom:8px" onclick="toast('Generate Financial Report')">Financial Report</button>
                <button class="btn primary" style="width:100%;margin-bottom:8px" onclick="toast('Generate Occupancy Report')">Occupancy Report</button>
                <button class="btn" style="width:100%" onclick="toast('Export All Reports')">Export All</button>
            </aside>

            <main>
                <!-- Report Generation Panel -->
                <div class="card">
                    <div class="row">
                        <h2>Generate Report</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill"><span class="dot green"></span>PDF</span>
                            <span class="pill"><span class="dot orange"></span>CSV</span>
                            <span class="pill">Excel</span>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="col4">
                            <label>Report Type</label>
                            <select id="reportType">
                                <option value="financial">Financial Summary</option>
                                <option value="occupancy">Occupancy Analysis</option>
                                <option value="clients">Client Report</option>
                                <option value="invoices">Invoice Aging</option>
                                <option value="movements">Movement Log</option>
                                <option value="notices">Notice Cycle Report</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>From Date</label>
                            <input type="date" value="2025-12-01">
                        </div>
                        <div class="col3">
                            <label>To Date</label>
                            <input type="date" value="2025-12-31">
                        </div>
                        <div class="col2" style="display:flex;align-items:flex-end">
                            <button class="btn primary" style="width:100%" onclick="toast('Generating report...')">Generate</button>
                        </div>
                    </div>
                </div>

                <!-- Quick Reports Grid -->
                <h2>Quick Reports</h2>
                <div class="grid">
                    <div class="span4">
                        <div class="report-card" onclick="toast('Opening Financial Report')">
                            
                            <div class="report-title">Financial Summary</div>
                            <div class="report-desc">Revenue, receivables, VAT collected, aging analysis</div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="report-card" onclick="toast('Opening Occupancy Report')">
                           
                            <div class="report-title">Occupancy Analysis</div>
                            <div class="report-desc">Occupied vs empty units, utilization trends, off-hire</div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="report-card" onclick="toast('Opening Client Report')">
                            
                            <div class="report-title">Client Report</div>
                            <div class="report-desc">Active clients, document status, balances</div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="report-card" onclick="toast('Opening Invoice Report')">
                            
                            <div class="report-title">Invoice Aging</div>
                            <div class="report-desc">Outstanding invoices by age, payment history</div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="report-card" onclick="toast('Opening Movement Report')">
                            
                            <div class="report-title">Movement Log</div>
                            <div class="report-desc">Inbound/outbound activity, peak times</div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="report-card" onclick="toast('Opening Notice Report')">
                            
                            <div class="report-title">Notice Cycle Report</div>
                            <div class="report-desc">Active notices, compliance status, legal cases</div>
                        </div>
                    </div>
                </div>

                <!-- Scheduled Reports -->
                <div class="card">
                    <div class="row">
                        <h2>Scheduled Reports</h2>
                        <button class="btn orange" onclick="toast('Schedule New Report')">+ Schedule New</button>
                    </div>
                    <table>
                        <tr>
                            <th>Report Name</th>
                            <th>Frequency</th>
                            <th>Format</th>
                            <th>Recipients</th>
                            <th>Last Sent</th>
                            <th>Next Run</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td>Weekly Financial Summary</td>
                            <td>Every Monday</td>
                            <td>PDF</td>
                            <td>finance@rgsl.com</td>
                            <td>2025-12-16</td>
                            <td>2025-12-23</td>
                            <td><button class="btn" onclick="toast('Edit schedule')">Edit</button></td>
                        </tr>
                        <tr>
                            <td>Monthly Occupancy Report</td>
                            <td>1st of month</td>
                            <td>Excel</td>
                            <td>operations@rgsl.com</td>
                            <td>2025-12-01</td>
                            <td>2026-01-01</td>
                            <td><button class="btn" onclick="toast('Edit schedule')">Edit</button></td>
                        </tr>
                        <tr>
                            <td>Daily Movement Log</td>
                            <td>Daily 18:00</td>
                            <td>CSV</td>
                            <td>warehouse@rgsl.com</td>
                            <td>2025-12-19</td>
                            <td>2025-12-20</td>
                            <td><button class="btn" onclick="toast('Edit schedule')">Edit</button></td>
                        </tr>
                    </table>
                </div>

                <!-- Recent Reports -->
                <div class="card">
                    <div class="row">
                        <h2>Recently Generated</h2>
                        <button class="btn" onclick="toast('View all reports')">View All</button>
                    </div>
                    <table>
                        <tr>
                            <th>Report</th>
                            <th>Date Generated</th>
                            <th>Period</th>
                            <th>Format</th>
                            <th>Download</th>
                        </tr>
                        <tr>
                            <td>Financial Summary - Dec 2025</td>
                            <td>2025-12-19 14:30</td>
                            <td>Dec 1-19</td>
                            <td>PDF</td>
                            <td><span class="link" onclick="toast('Downloading PDF')">Download</span></td>
                        </tr>
                        <tr>
                            <td>Occupancy Report - Q4 2025</td>
                            <td>2025-12-18 09:15</td>
                            <td>Oct-Dec</td>
                            <td>Excel</td>
                            <td><span class="link" onclick="toast('Downloading Excel')">Download</span></td>
                        </tr>
                        <tr>
                            <td>Client Aging Report</td>
                            <td>2025-12-17 16:45</td>
                            <td>As of Dec 17</td>
                            <td>CSV</td>
                            <td><span class="link" onclick="toast('Downloading CSV')">Download</span></td>
                        </tr>
                    </table>
                </div>
            </main>
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
    </script>
</body>
</html>