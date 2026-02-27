<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Invoices & Payments - RGSL</title>
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
        .kpis { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 14px; }
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
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { padding: 10px; border-bottom: 1px solid var(--border); text-align: left; vertical-align: top; }
        th { color: var(--muted); font-weight: 900; font-size: 12px; background: #f8fafc; }
        tr:hover { background: #f8fafc; }
        .link { cursor: pointer; color: var(--green); font-weight: 900; }
        .grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 12px; }
        .span8 { grid-column: span 8; }
        .span4 { grid-column: span 4; }
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
            width: min(900px, 100%);
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
            .col3, .col4, .col6, .col12, .span8, .span4 { grid-column: span 12; }
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <div class="brand">
                <img alt="RGSL Logo" src="https://royalgulfshipping.com/wp-content/uploads/2025/11/RGSL-LOGO.png"/>
                <div>
                    <h1>Invoices & Payments</h1>
                    <p>Admin Portal • Invoice Management & Receipts</p>
                </div>
            </div>
            <div class="actions">
                <button class="btn orange" onclick="openCreateInvoice()">+ Create Invoice</button>
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
                    <a href="invoices.php" class="active">Invoices & Payments</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="notices.php">Notices & Legal</a>
                    <a href="reports.php">Reports</a>
                </div>
                <div class="hr"></div>
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn orange" style="width:100%;margin-bottom:8px" onclick="openCreateInvoice()">+ Create Invoice</button>
                <button class="btn primary" style="width:100%;margin-bottom:8px" onclick="openRecordPayment()">+ Record Payment</button>
                <button class="btn" style="width:100%" onclick="toast('Export Report')">Export Report</button>
            </aside>

            <main>
                <!-- KPIs -->
                <div class="card">
                    <div class="row">
                        <h2>Finance KPIs</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill"><span class="dot green"></span>VAT: 5%</span>
                            <span class="pill"><span class="dot orange"></span>Currency: AED</span>
                        </div>
                    </div>
                    <div class="kpis">
                        <div class="kpi">
                            <div class="label">Total Invoices (MTD)</div>
                            <div class="value">AED 284,500</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Outstanding Receivables</div>
                            <div class="value" style="color:var(--bad)">AED 96,300</div>
                        </div>
                        <div class="kpi">
                            <div class="label">Overdue (30+ days)</div>
                            <div class="value" style="color:var(--bad)">AED 38,500</div>
                        </div>
                        <div class="kpi">
                            <div class="label">VAT Collected (MTD)</div>
                            <div class="value">AED 14,225</div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card">
                    <div class="row">
                        <h2>Search & Filters</h2>
                        <div class="row" style="gap:8px">
                            <button class="btn" onclick="applyQuick('all')">All</button>
                            <button class="btn" onclick="applyQuick('paid')">Paid</button>
                            <button class="btn" onclick="applyQuick('unpaid')">Unpaid</button>
                            <button class="btn" onclick="applyQuick('overdue')">Overdue</button>
                        </div>
                    </div>
                    <div class="form-grid" style="margin-top:10px">
                        <div class="col4">
                            <label>Client</label>
                            <select id="fClient">
                                <option value="all">All Clients</option>
                                <option value="C-1001">ABC Trading LLC</option>
                                <option value="C-1002">XYZ Imports</option>
                                <option value="C-1003">Noor Electronics</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Status</label>
                            <select id="fStatus">
                                <option value="all">All</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Overdue">Overdue</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Period</label>
                            <select id="fPeriod">
                                <option value="all">All</option>
                                <option value="Advance">Advance (3/6 months)</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Daily">Daily</option>
                            </select>
                        </div>
                        <div class="col2" style="display:flex;align-items:flex-end;gap:10px">
                            <button class="btn primary" style="width:100%" onclick="renderInvoices()">Apply</button>
                            <button class="btn" style="width:100%" onclick="resetFilters()">Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Invoices Table -->
                <div class="card">
                    <div class="row">
                        <h2>All Invoices</h2>
                        <div class="row" style="gap:8px">
                            <span class="pill">Showing: <b id="invCount">2</b></span>
                            <button class="btn" onclick="toast('Export CSV')">Export CSV</button>
                        </div>
                    </div>
                    <table id="invoicesTable">
                        <tr>
                            <th>Invoice #</th>
                            <th>Client</th>
                            <th>Period</th>
                            <th>Subtotal</th>
                            <th>VAT (5%)</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td><b>INV-1022</b></td>
                            <td>ABC Trading LLC</td>
                            <td>Oct–Dec 2025 (Advance)</td>
                            <td>AED 9,600</td>
                            <td>AED 480</td>
                            <td><b>AED 10,080</b></td>
                            <td>AED 10,080</td>
                            <td><b>AED 0</b></td>
                            <td>2025-10-05</td>
                            <td><span class="badge b-green">Paid</span></td>
                            <td>
                                <button class="btn" onclick="openInvoice('INV-1022')">View</button>
                                <button class="btn" onclick="toast('Download PDF')">PDF</button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>INV-1120</b></td>
                            <td>ABC Trading LLC</td>
                            <td>Dec 2025 (Daily)</td>
                            <td>AED 2,550</td>
                            <td>AED 128</td>
                            <td><b>AED 2,678</b></td>
                            <td>AED 0</td>
                            <td><b style="color:var(--bad)">AED 2,678</b></td>
                            <td>2025-12-20</td>
                            <td><span class="badge b-orange">Unpaid</span></td>
                            <td>
                                <button class="btn" onclick="openInvoice('INV-1120')">View</button>
                                <button class="btn orange" onclick="openRecordPayment()">Pay</button>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Recent Payments -->
                <div class="card">
                    <div class="row">
                        <h2>Recent Payments</h2>
                        <button class="btn" onclick="toast('Export Payments CSV')">Export</button>
                    </div>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Receipt #</th>
                            <th>Client</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Applied To</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td>2025-12-10</td>
                            <td><b>RCPT-5541</b></td>
                            <td>ABC Trading LLC</td>
                            <td>Bank Transfer</td>
                            <td><b>AED 10,080</b></td>
                            <td>INV-1022</td>
                            <td><button class="btn" onclick="toast('View Receipt')">View</button></td>
                        </tr>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Create Invoice Modal -->
    <div class="backdrop" id="createModal">
        <div class="modal">
            <header>
                <h3>Create New Invoice</h3>
                <button class="btn x" onclick="closeModal()">✕</button>
            </header>
            <div class="body">
                <div class="form-grid">
                    <div class="col6">
                        <label>Client</label>
                        <select id="newClient">
                            <option value="">Select Client...</option>
                            <option value="C-1001">ABC Trading LLC (C-1001)</option>
                            <option value="C-1002">XYZ Imports (C-1002)</option>
                            <option value="C-1003">Noor Electronics (C-1003)</option>
                        </select>
                    </div>
                    <div class="col6">
                        <label>Allocation/Unit</label>
                        <select id="newUnit">
                            <option value="">Select Unit...</option>
                            <option>CONT-07 (40FT Container)</option>
                            <option>Shed-09 (Shared Shed)</option>
                            <option>Shed-12 (Shed)</option>
                        </select>
                    </div>
                    <div class="col4">
                        <label>Billing Period</label>
                        <select id="newPeriod">
                            <option>Monthly</option>
                            <option>Advance (3 months)</option>
                            <option>Advance (6 months)</option>
                            <option>Daily</option>
                            <option>Weekly</option>
                        </select>
                    </div>
                    <div class="col4">
                        <label>Rate (AED)</label>
                        <input type="number" id="newRate" placeholder="3200" value="3200"/>
                    </div>
                    <div class="col4">
                        <label>Quantity</label>
                        <input type="number" id="newQty" placeholder="1" value="1"/>
                    </div>
                    <div class="col6">
                        <label>From Date</label>
                        <input type="date" id="newFrom" value="2025-12-01"/>
                    </div>
                    <div class="col6">
                        <label>To Date</label>
                        <input type="date" id="newTo" value="2025-12-31"/>
                    </div>
                    <div class="col12">
                        <label>Description</label>
                        <textarea id="newDesc" placeholder="Storage fee for CONT-07 (40FT Container) - December 2025"></textarea>
                    </div>
                    <div class="col12">
                        <div class="pill"><span class="dot" style="background:var(--info)"></span>VAT 5% will be auto-calculated</div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn" onclick="closeModal()">Cancel</button>
                <button class="btn primary" onclick="saveInvoice()">Create Invoice</button>
            </div>
        </div>
    </div>

    <!-- Record Payment Modal -->
    <div class="backdrop" id="paymentModal">
        <div class="modal">
            <header>
                <h3>Record Payment</h3>
                <button class="btn x" onclick="closeModal()">✕</button>
            </header>
            <div class="body">
                <div class="form-grid">
                    <div class="col6">
                        <label>Client</label>
                        <select id="payClient">
                            <option>ABC Trading LLC</option>
                            <option>XYZ Imports</option>
                        </select>
                    </div>
                    <div class="col6">
                        <label>Invoice #</label>
                        <select id="payInvoice">
                            <option>INV-1120 (Balance: AED 2,678)</option>
                            <option>INV-2001 (Balance: AED 4,725)</option>
                        </select>
                    </div>
                    <div class="col4">
                        <label>Payment Date</label>
                        <input type="date" value="2025-12-20"/>
                    </div>
                    <div class="col4">
                        <label>Amount (AED)</label>
                        <input type="number" value="2678"/>
                    </div>
                    <div class="col4">
                        <label>Payment Method</label>
                        <select>
                            <option>Bank Transfer</option>
                            <option>Cash</option>
                            <option>Cheque</option>
                            <option>Credit Card</option>
                        </select>
                    </div>
                    <div class="col12">
                        <label>Reference / Notes</label>
                        <textarea placeholder="Bank reference number, cheque number, etc."></textarea>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn" onclick="closeModal()">Cancel</button>
                <button class="btn primary" onclick="savePayment()">Record Payment</button>
            </div>
        </div>
    </div>

    <!-- View Invoice Modal -->
    <div class="backdrop" id="viewModal">
        <div class="modal">
            <header>
                <h3 id="viewTitle">Invoice Details</h3>
                <button class="btn x" onclick="closeModal()">✕</button>
            </header>
            <div class="body" id="viewBody"></div>
            <div class="footer">
                <button class="btn" onclick="closeModal()">Close</button>
                <button class="btn" onclick="toast('Download PDF')">Download PDF</button>
                <button class="btn orange" onclick="toast('Email to Client')">Email Client</button>
            </div>
        </div>
    </div>

    <script>
        const invoices = [
            { no: "INV-1022", client: "ABC Trading LLC", period: "Oct–Dec 2025 (Advance)", subtotal: 9600, vat: 480, total: 10080, paid: 10080, balance: 0, due: "2025-10-05", status: "Paid" },
            { no: "INV-1120", client: "ABC Trading LLC", period: "Dec 2025 (Daily)", subtotal: 2550, vat: 128, total: 2678, paid: 0, balance: 2678, due: "2025-12-20", status: "Unpaid" }
        ];

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

        function money(n) { return "AED " + Number(n||0).toLocaleString("en-US"); }

        function openCreateInvoice() {
            document.getElementById("createModal").classList.add("open");
        }

        function openRecordPayment() {
            document.getElementById("paymentModal").classList.add("open");
        }

        function openInvoice(no) {
            const inv = invoices.find(i => i.no === no);
            if (!inv) return;
            const statusBadge = inv.status === "Paid" ? "b-green" : (inv.status === "Overdue" ? "b-red" : "b-orange");
            document.getElementById("viewTitle").textContent = "Invoice " + no;
            document.getElementById("viewBody").innerHTML = `
                <div class="row" style="margin-bottom:16px;">
                    <div>
                        <div style="font-size:18px;font-weight:1000">${inv.client}</div>
                        <div class="muted small">Invoice #: ${inv.no}</div>
                        <div class="muted small">Period: ${inv.period}</div>
                    </div>
                    <span class="badge ${statusBadge}">${inv.status}</span>
                </div>
                <div class="grid" style="margin-bottom:16px;">
                    <div class="card span4" style="box-shadow:none">
                        <div class="muted small">Subtotal</div>
                        <div style="font-size:20px;font-weight:1000">${money(inv.subtotal)}</div>
                    </div>
                    <div class="card span4" style="box-shadow:none">
                        <div class="muted small">VAT (5%)</div>
                        <div style="font-size:20px;font-weight:1000">${money(inv.vat)}</div>
                    </div>
                    <div class="card span4" style="box-shadow:none">
                        <div class="muted small">Total / Balance</div>
                        <div style="font-size:20px;font-weight:1000">${money(inv.total)} / ${money(inv.balance)}</div>
                    </div>
                </div>
                <table>
                    <tr><th>Item</th><th>Description</th><th>Qty</th><th>Rate</th><th>Amount</th></tr>
                    <tr>
                        <td>Storage Fee</td>
                        <td>Unit rental for period ${inv.period}</td>
                        <td>1</td>
                        <td>${money(inv.subtotal)}</td>
                        <td><b>${money(inv.subtotal)}</b></td>
                    </tr>
                </table>
            `;
            document.getElementById("viewModal").classList.add("open");
        }

        function closeModal() {
            document.querySelectorAll(".backdrop").forEach(b => b.classList.remove("open"));
        }

        function saveInvoice() {
            toast("Invoice created successfully!");
            closeModal();
        }

        function savePayment() {
            toast("Payment recorded successfully!");
            closeModal();
        }

        function applyQuick(filter) {
            toast("Filter applied: " + filter);
        }

        function resetFilters() {
            document.getElementById("fClient").value = "all";
            document.getElementById("fStatus").value = "all";
            document.getElementById("fPeriod").value = "all";
            toast("Filters reset");
        }

        function renderInvoices() {
            toast("Invoices filtered");
        }
    </script>
</body>
</html>'''


