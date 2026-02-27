<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

requireAdmin();

// Get stats for dashboard
// Total clients
$stmt = $pdo->query("SELECT COUNT(*) as total FROM clients");
$totalClients = $stmt->fetch()['total'];

// Total units
$stmt = $pdo->query("SELECT COUNT(*) as total, 
                     SUM(CASE WHEN status = 'occupied' THEN 1 ELSE 0 END) as occupied,
                     SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available
                     FROM units");
$units = $stmt->fetch();

// Revenue this month
$stmt = $pdo->query("SELECT SUM(total) as revenue, SUM(balance) as receivables 
                     FROM invoices WHERE MONTH(created_at) = MONTH(CURRENT_DATE())");
$finance = $stmt->fetch();

// Recent movements
$stmt = $pdo->query("SELECT m.*, c.company_name, u.unit_code 
                     FROM movements m 
                     JOIN clients c ON m.client_id = c.id 
                     JOIN units u ON m.unit_id = u.id 
                     ORDER BY m.movement_date DESC LIMIT 5");
$recentMovements = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - RGSL</title>
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
            --ok: #16a34a;
            --warn: #f26a21;
            --bad: #dc2626;
            --info: #0ea5e9;
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

        /* Header */
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

        /* Layout */
        .wrap {
            /* max-width: 1380px; */
            margin: 16px auto;
            padding: 0 18px;
        }

        .shell {
            display: flex;
            gap: 12px;
        }

        /* Sidebar */
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

        /* Main Content */
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

        /* KPIs */
        .kpis {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 12px;
            margin-bottom: 14px;
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
            margin-bottom: 6px;
            font-weight: 900;
        }

        .kpi .value {
            font-size: 18px;
            font-weight: 1000;
        }

        .kpi .delta {
            font-size: 12px;
            margin-top: 6px;
        }

        .delta.up {
            color: var(--green);
        }

        .delta.down {
            color: var(--bad);
        }

        /* Grid Layout */
        .grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }

        .span7 {
            grid-column: span 7;
        }

        .span6 {
            grid-column: span 6;
        }

        .span5 {
            grid-column: span 5;
        }

        .span12 {
            grid-column: span 12;
        }

        /* Filters */
        .filters {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
            margin-bottom: 14px;
        }

        .filter {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 12px;
            box-shadow: var(--shadow);
        }

        .filter label {
            display: block;
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 6px;
            font-weight: 900;
        }

        .filter.small {
            grid-column: span 3;
        }

        .filter.medium {
            grid-column: span 4;
        }

        .filter.large {
            grid-column: span 6;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            font-weight: 600;
            color: var(--text);
            font-size: 13px;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(26, 163, 74, 0.1);
        }

        /* Tables */
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

        /* Canvas */
        canvas {
            width: 100%;
            height: 240px;
            display: block;
        }

        .mini {
            height: 180px;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            aside {
                display: none;
            }

            .kpis {
                grid-template-columns: repeat(4, 1fr);
            }

            .filter.small,
            .filter.medium,
            .filter.large,
            .span7,
            .span6,
            .span5 {
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
                    <h1>Admin Dashboard</h1>
                    <p>Self Storage & Container Warehouse • Dubai</p>
                </div>
            </div>
            <div class="actions">
                <button class="btn orange" onclick="toast('+ Add Client')">+ Add Client</button>
                <button class="btn primary" onclick="toast('+ Allocate Unit')">+ Allocate Unit</button>
                <button class="btn" onclick="toast('+ Create Invoice')">+ Create Invoice</button>
                <button class="btn" onclick="toast('+ Log Movement')">+ In/Out</button>
                <button class="btn" onclick="toast('+ Start Notice Cycle')">+ Notice</button>
                <button class="btn" onclick="toast('Export CSV')">Export CSV</button>
                <button class="btn orange" onclick="location.href='../logout.php'">Logout</button>
            </div>
        </div>
    </header>

    <div class="wrap">
        <div class="shell">
            <!-- Sidebar Navigation -->
            <aside>
                <div class="navTitle">ADMIN MENU</div>
                <div class="nav">
                    <a href="dashboard.php" class="active">Dashboard</a>
                    <a href="clients.php">Clients</a>
                    <a href="facility.php">Facility Map</a>
                    <a href="units.php">Unit Analytics</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="notices.php">Notices & Legal</a>
                    <a href="reports.php">Reports</a>
                </div>

                <div class="hr"></div>

                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn primary" style="width:100%;margin-bottom:8px" onclick="toast('+ Add Client')">+ Add Client</button>
                <button class="btn orange" style="width:100%;margin-bottom:8px" onclick="toast('+ Allocate Unit')">+ Allocate Unit</button>
                <button class="btn" style="width:100%;margin-bottom:8px" onclick="toast('+ Create Invoice')">+ Create Invoice</button>
                <button class="btn" style="width:100%" onclick="toast('Export Report')">Export Report</button>

                <div class="hr"></div>

                <div class="muted small">
                    <strong>System Status:</strong><br>
                    <span class="dot green"></span> Online<br>
                    <span class="dot green"></span> DB Connected<br>
                    VAT Rate: 5%
                </div>
            </aside>

            <main>
                <!-- Filters -->
                <div class="filters">
                    <div class="filter medium">
                        <label>Date Range</label>
                        <select id="range">
                            <option value="7">Last 7 days</option>
                            <option value="30" selected>Last 30 days</option>
                            <option value="mtd">MTD</option>
                            <option value="ytd">YTD</option>
                        </select>
                    </div>
                    <div class="filter medium">
                        <label>Facility Area</label>
                        <select id="area">
                            <option value="all" selected>All</option>
                            <option value="sheds">Sheds</option>
                            <option value="containers">Containers</option>
                        </select>
                    </div>
                    <div class="filter small">
                        <label>Client Type</label>
                        <select id="ctype">
                            <option value="all" selected>All</option>
                            <option value="business">Business</option>
                            <option value="personal">Personal</option>
                        </select>
                    </div>
                    <div class="filter small">
                        <label>Status</label>
                        <select id="status">
                            <option value="all" selected>All</option>
                            <option value="expiring">Expiring</option>
                            <option value="overdue">Overdue</option>
                            <option value="legal">Legal Cycle</option>
                        </select>
                    </div>
                    <div class="filter large">
                        <label>Quick Search (Client / Unit / Invoice)</label>
                        <input id="q" placeholder="e.g., ABC Trading, Shed-09, INV-1022" />
                    </div>
                </div>

                <!-- KPIs -->
                <div class="card kpis">
                    <div class="kpi">
                        <div class="label">Total Units</div>
                        <div class="value">89</div>
                        <div class="delta">59 Sheds • 30 Containers</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Occupied Units</div>
                        <div class="value">71</div>
                        <div class="delta up">79% occupancy</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Available Units</div>
                        <div class="value">18</div>
                        <div class="delta">Ready for allocation</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Revenue (MTD)</div>
                        <div class="value">AED 284,500</div>
                        <div class="delta up">Net + VAT tracked</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Receivables</div>
                        <div class="value">AED 96,300</div>
                        <div class="delta down">Outstanding total</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Overdue (30+)</div>
                        <div class="value">14 • AED 38,500</div>
                        <div class="delta down">Start notice cycle if 2 months unpaid</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Legal / Notices</div>
                        <div class="value">4</div>
                        <div class="delta down">Pipeline active</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Expiring in 7 days</div>
                        <div class="value">12</div>
                        <div class="delta down">Renewals at risk</div>
                    </div>
                </div>

                <div class="grid">
                    <!-- Occupancy Trend -->
                    <div class="card span7">
                        <div class="row">
                            <h2>Occupancy Trend</h2>
                            <div class="row" style="gap:8px">
                                <span class="pill"><span class="dot green"></span>Occupied Units</span>
                                <span class="pill"><span class="dot gray"></span>Available Units</span>
                            </div>
                        </div>
                        <canvas id="occChart" width="900" height="260"></canvas>
                        <div class="muted small">Decision use: spot dips (empty days), plan promotions, price changes, and renewals outreach.</div>
                    </div>

                    <!-- Utilization + Empty Days -->
                    <div class="card span5">
                        <div class="row">
                            <h2>Utilization & Loss</h2>
                            <span class="pill"><span class="dot orange"></span>Empty Days KPI</span>
                        </div>
                        <canvas id="utilChart" class="mini" width="520" height="200"></canvas>
                        <div style="margin-top:10px" class="row">
                            <div>
                                <div class="muted" style="font-size:12px;font-weight:900">Empty Days (selected period)</div>
                                <div style="font-size:22px;font-weight:900">312</div>
                            </div>
                            <div>
                                <div class="muted" style="font-size:12px;font-weight:900">Est. Revenue Loss</div>
                                <div style="font-size:22px;font-weight:900">AED 26,520</div>
                            </div>
                        </div>
                        <div class="muted small">Loss is estimated from average daily rate across active contracts.</div>
                    </div>

                    <!-- Finance -->
                    <div class="card span6">
                        <div class="row">
                            <h2>Finance Overview</h2>
                            <div class="row" style="gap:8px">
                                <span class="pill"><span class="dot green"></span>Revenue</span>
                                <span class="pill"><span class="dot red"></span>Receivables</span>
                            </div>
                        </div>
                        <canvas id="finChart" width="760" height="240"></canvas>
                        <div style="margin-top:10px" class="row">
                            <div class="pill"><span class="dot green"></span>VAT Collected MTD: <b>AED 14,225</b></div>
                            <div class="pill"><span class="dot red"></span>AR Aging Risk: <b>AED 27,900</b></div>
                        </div>
                        <div class="muted small">Advance billing supported: one invoice can cover 3 or 6 months period.</div>
                    </div>

                    <!-- AR Aging -->
                    <div class="card span6">
                        <div class="row">
                            <h2>Receivables Aging</h2>
                            <span class="pill"><span class="dot red"></span>Overdue Control</span>
                        </div>
                        <table>
                            <tr>
                                <th>Bucket</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><span class="badge b-green">Current</span></td>
                                <td><b>AED 41,800</b>
                                    <div class="muted">19 invoices</div>
                                </td>
                                <td><span class="link" onclick="toast('View AR list: Current')">View list</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge b-green">1–30 days</span></td>
                                <td><b>AED 20,100</b>
                                    <div class="muted">12 invoices</div>
                                </td>
                                <td><span class="link" onclick="toast('View AR list: 1-30 days')">View list</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge b-orange">31–60 days</span></td>
                                <td><b>AED 16,500</b>
                                    <div class="muted">7 invoices</div>
                                </td>
                                <td><span class="link" onclick="toast('View AR list: 31-60 days')">View list</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge b-red">61–90 days</span></td>
                                <td><b>AED 10,800</b>
                                    <div class="muted">4 invoices</div>
                                </td>
                                <td><span class="link" onclick="toast('View AR list: 61-90 days')">View list</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge b-red">90+ days</span></td>
                                <td><b>AED 17,100</b>
                                    <div class="muted">3 invoices</div>
                                </td>
                                <td><span class="link" onclick="toast('View AR list: 90+ days')">View list</span></td>
                            </tr>
                        </table>
                        <div class="muted small">Decision use: start notice cycle when unpaid for 2 consecutive months (your policy).</div>
                    </div>

                    <!-- Expiring / Renewals -->
                    <div class="card span6">
                        <div class="row">
                            <h2>Expiring & Renewals</h2>
                            <span class="pill"><span class="dot orange"></span>Next 30 Days</span>
                        </div>
                        <table>
                            <tr>
                                <th>Client / Unit</th>
                                <th>End Date</th>
                                <th>Rate</th>
                                <th>Risk</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><b>ABC Trading LLC</b>
                                    <div class="muted">CONT-07</div>
                                </td>
                                <td>2026-01-05</td>
                                <td>AED 3,200/mo</td>
                                <td><span class="badge b-red">High</span></td>
                                <td><span class="link" onclick="toast('Open renewal: ABC Trading / CONT-07')">Open</span></td>
                            </tr>
                            <tr>
                                <td><b>Noor Electronics</b>
                                    <div class="muted">Shed-12</div>
                                </td>
                                <td>2025-12-27</td>
                                <td>AED 85/day</td>
                                <td><span class="badge b-red">High</span></td>
                                <td><span class="link" onclick="toast('Open renewal: Noor Electronics / Shed-12')">Open</span></td>
                            </tr>
                            <tr>
                                <td><b>Zain Textiles</b>
                                    <div class="muted">Shed-03 (shared)</div>
                                </td>
                                <td>2026-01-12</td>
                                <td>AED 2,500/mo</td>
                                <td><span class="badge b-orange">Med</span></td>
                                <td><span class="link" onclick="toast('Open renewal: Zain Textiles / Shed-03')">Open</span></td>
                            </tr>
                        </table>
                        <div class="muted small">These renewals are your "revenue at risk". Act before the end date.</div>
                    </div>

                    <!-- Legal / Notices Pipeline -->
                    <div class="card span6">
                        <div class="row">
                            <h2>Notices & Legal Pipeline</h2>
                            <span class="pill"><span class="dot red"></span>Compliance Proof</span>
                        </div>
                        <table>
                            <tr>
                                <th>Client</th>
                                <th>Stage</th>
                                <th>Next Due</th>
                                <th>Email</th>
                                <th>Courier</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><b>XYZ Imports</b></td>
                                <td><span class="badge b-orange">2nd Notice</span></td>
                                <td>2025-12-21</td>
                                <td><span class="badge b-gray">Logged ✔</span></td>
                                <td><span class="badge b-orange">Missing ⚠</span></td>
                                <td><span class="link" onclick="toast('Open notice record: XYZ Imports')">Open</span></td>
                            </tr>
                            <tr>
                                <td><b>LMN Traders</b></td>
                                <td><span class="badge b-red">Letter Before Action</span></td>
                                <td>2025-12-19</td>
                                <td><span class="badge b-gray">Logged ✔</span></td>
                                <td><span class="badge b-green">Uploaded ✔</span></td>
                                <td><span class="link" onclick="toast('Open notice record: LMN Traders')">Open</span></td>
                            </tr>
                            <tr>
                                <td><b>Sigma Auto Parts</b></td>
                                <td><span class="badge b-red">Final Notice</span></td>
                                <td>2025-12-24</td>
                                <td><span class="badge b-gray">Logged ✔</span></td>
                                <td><span class="badge b-green">Uploaded ✔</span></td>
                                <td><span class="link" onclick="toast('Open notice record: Sigma Auto Parts')">Open</span></td>
                            </tr>
                        </table>
                        <div class="muted small">Every notice must log email + allow courier receipt upload (legal proof before disposal).</div>
                    </div>

                    <!-- Movements -->
                    <div class="card span12">
                        <div class="row">
                            <h2>Inbound / Outbound Activity Feed</h2>
                            <div class="row" style="gap:8px">
                                <button class="btn" onclick="toast('Filter: Today')">Today</button>
                                <button class="btn" onclick="toast('Filter: This Week')">This Week</button>
                                <button class="btn" onclick="toast('Export: Movements CSV')">Export</button>
                            </div>
                        </div>
                        <table>
                            <tr>
                                <th>Date/Time</th>
                                <th>Client</th>
                                <th>Unit</th>
                                <th>Type</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>2025-12-18 10:22</td>
                                <td><b>ABC Trading LLC</b></td>
                                <td>Shed-09</td>
                                <td><span class="badge b-green">Inbound</span></td>
                                <td>45</td>
                                <td>0</td>
                                <td class="muted">Cartons – electronics</td>
                                <td><span class="link" onclick="toast('Open movement: ABC Trading')">View</span></td>
                            </tr>
                            <tr>
                                <td>2025-12-18 12:05</td>
                                <td><b>Noor Electronics</b></td>
                                <td>Shed-12</td>
                                <td><span class="badge b-orange">Outbound</span></td>
                                <td>0</td>
                                <td>12</td>
                                <td class="muted">Delivery pickup</td>
                                <td><span class="link" onclick="toast('Open movement: Noor Electronics')">View</span></td>
                            </tr>
                            <tr>
                                <td>2025-12-17 16:40</td>
                                <td><b>Zain Textiles</b></td>
                                <td>CONT-03</td>
                                <td><span class="badge b-green">Inbound</span></td>
                                <td>30</td>
                                <td>0</td>
                                <td class="muted">Bales received</td>
                                <td><span class="link" onclick="toast('Open movement: Zain Textiles')">View</span></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Underutilized Units -->
                    <div class="card span12">
                        <div class="row">
                            <h2>Underutilized / Idle Units</h2>
                            <span class="pill"><span class="dot gray"></span>Revenue Opportunity</span>
                        </div>
                        <table>
                            <tr>
                                <th>Unit</th>
                                <th>Empty Days</th>
                                <th>Last Tenant</th>
                                <th>Suggested Action</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><b>Shed-21</b>
                                    <div class="muted">Shed</div>
                                </td>
                                <td><span class="badge b-gray">26 days</span></td>
                                <td>—</td>
                                <td>Discount / short term</td>
                                <td><span class="link" onclick="toast('Open unit: Shed-21')">Open unit</span></td>
                            </tr>
                            <tr>
                                <td><b>CONT-14</b>
                                    <div class="muted">40FT Container</div>
                                </td>
                                <td><span class="badge b-gray">22 days</span></td>
                                <td>ABC Trading</td>
                                <td>Bundle offer</td>
                                <td><span class="link" onclick="toast('Open unit: CONT-14')">Open unit</span></td>
                            </tr>
                            <tr>
                                <td><b>Shed-06</b>
                                    <div class="muted">Shed</div>
                                </td>
                                <td><span class="badge b-gray">18 days</span></td>
                                <td>Noor Electronics</td>
                                <td>Renewal promo</td>
                                <td><span class="link" onclick="toast('Open unit: Shed-06')">Open unit</span></td>
                            </tr>
                        </table>
                        <div class="muted small">Decision use: target these units for discounts/promos or internal re-allocation.</div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toast Notification
        function toast(msg) {
            const t = document.createElement("div");
            t.textContent = msg;
            Object.assign(t.style, {
                position: "fixed",
                right: "18px",
                bottom: "18px",
                background: "#111827",
                color: "#fff",
                padding: "12px 16px",
                borderRadius: "12px",
                boxShadow: "0 12px 24px rgba(0,0,0,.2)",
                fontWeight: "900",
                fontSize: "13px",
                zIndex: 9999
            });
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 2700);
        }

        // Simple Chart Drawing
        function drawLineChart(canvasId, dataA, dataB, colorA, colorB) {
            const c = document.getElementById(canvasId);
            if (!c) return;
            const ctx = c.getContext("2d");
            const W = c.width,
                H = c.height;
            ctx.clearRect(0, 0, W, H);

            // Axes
            ctx.strokeStyle = "#cbd5e1";
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(40, 10);
            ctx.lineTo(40, H - 30);
            ctx.lineTo(W - 10, H - 30);
            ctx.stroke();

            const maxY = Math.max(...dataA, ...dataB) * 1.15;
            const minY = Math.min(...dataA, ...dataB) * 0.85;

            function px(i, n) {
                return 40 + (i * (W - 60) / (n - 1));
            }

            function py(v) {
                return (H - 30) - ((v - minY) * (H - 50) / (maxY - minY));
            }

            // Grid
            ctx.strokeStyle = "#e2e8f0";
            for (let g = 0; g < 4; g++) {
                const y = 10 + g * ((H - 40) / 4);
                ctx.beginPath();
                ctx.moveTo(40, y);
                ctx.lineTo(W - 10, y);
                ctx.stroke();
            }

            // Series A
            ctx.strokeStyle = colorA;
            ctx.lineWidth = 3;
            ctx.beginPath();
            dataA.forEach((v, i) => {
                const x = px(i, dataA.length),
                    y = py(v);
                if (i === 0) ctx.moveTo(x, y);
                else ctx.lineTo(x, y);
            });
            ctx.stroke();

            // Series B
            ctx.strokeStyle = colorB;
            ctx.lineWidth = 3;
            ctx.beginPath();
            dataB.forEach((v, i) => {
                const x = px(i, dataB.length),
                    y = py(v);
                if (i === 0) ctx.moveTo(x, y);
                else ctx.lineTo(x, y);
            });
            ctx.stroke();
        }

        // Generate sample data
        const occTrend = Array.from({
                length: 30
            }, (_, i) =>
            64 + Math.round(6 * Math.sin(i / 5)) + (i % 9 === 0 ? -3 : 0)
        );
        const availTrend = occTrend.map(v => 89 - v);

        const finRev = Array.from({
                length: 12
            }, (_, i) =>
            210000 + Math.round(35000 * Math.sin(i / 2.6)) + i * 2500
        );
        const finAR = Array.from({
                length: 12
            }, (_, i) =>
            80000 + Math.round(18000 * Math.cos(i / 2.2)) + (i % 4 === 0 ? 9000 : 0)
        );

        // Initialize charts
        window.onload = function() {
            drawLineChart("occChart", occTrend, availTrend, "#1aa34a", "#94a3b8");
            drawLineChart("finChart", finRev, finAR, "#1aa34a", "#dc2626");

            // Filter listeners
            ["range", "area", "ctype", "status"].forEach(id => {
                document.getElementById(id).addEventListener("change", () => toast("Filter applied"));
            });
            document.getElementById("q").addEventListener("keydown", (e) => {
                if (e.key === "Enter") toast("Search: " + e.target.value);
            });
        };
    </script>
</body>

</html>