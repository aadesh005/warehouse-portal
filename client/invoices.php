<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - Invoices & Payments</title>
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

        a {
            color: var(--green);
            text-decoration: none;
            font-weight: 900;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #fff;
            border-bottom: 4px solid var(--orange);
            box-shadow: var(--shadow);
            padding: 12px 18px;
        }

        .topbar {
            max-width: 1380px;
            margin: 0 auto;
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
            height: 42px;
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

        .btn.orange {
            background: var(--orange);
            border-color: var(--orange);
            color: #fff;
        }

        .btn.green {
            background: var(--green);
            border-color: var(--green);
            color: #fff;
        }

        .wrap {
           /*  max-width: 1380px; */
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 10px;
        }

        .col3 {
            grid-column: span 3;
        }

        label {
            display: block;
            margin-bottom: 4px;
            font-weight: 900;
            font-size: 12px;
            color: var(--muted);
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            font-weight: 800;
            color: var(--text);
            font-size: 13px;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(26, 163, 74, 0.1);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }

        .col7 {
            grid-column: span 7;
        }

        .col5 {
            grid-column: span 5;
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

        .modalHeader {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modalHeader h3 {
            margin: 0;
            font-size: 16px;
        }

        .modalBody {
            padding: 14px 16px;
            overflow: auto;
        }

        @media (max-width: 1100px) {
            aside {
                display: none;
            }

            .col3,
            .col7,
            .col5 {
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
                    <h1>Client Portal</h1>
                    <p>Royal Gulf Shipping & Logistics • Self Storage</p>
                </div>
            </div>
            <div class="actions">
                <span class="pill">Currency: <b>AED</b></span>
                <span class="pill">VAT: <b>5%</b></span>
                <button class="btn" onclick="location.href='dashboard.php'">Dashboard</button>
                <button class="btn" onclick="location.href='profile.php'">My Profile</button>
                <button class="btn orange" onclick="location.href='login.php'">Logout</button>
            </div>
        </div>
    </header>

    <div class="wrap">
        <div class="shell">
            <aside>
                <div class="navTitle">MY ACCOUNT</div>
                <div class="nav">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="storage.php">My Storage</a>
                    <a href="invoices.php" class="active">Invoices & Payments</a>
                    <a href="statement.php">Statement</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="documents.php">Documents</a>
                    <a href="notices.php">Notices</a>
                    <a href="support.php">Support</a>
                </div>
                <div class="hr"></div>
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn green" style="width:100%;margin-bottom:8px"
                    onclick="location.href='storage.php#request'">+ Request Storage</button>
                <button class="btn" style="width:100%;margin-bottom:8px" onclick="location.href='movements.php#new'">+
                    Log Movement Request</button>
                <button class="btn" style="width:100%;margin-bottom:8px"
                    onclick="toast('Download contract pack')">Download Contracts</button>
                <button class="btn orange" style="width:100%" onclick="openPayModal()">Pay Now</button>
            </aside>

            <main>
                <!-- Header -->
                <div class="card">
                    <div class="row">
                        <div>
                            <h2 style="margin:0">Invoices & Payments</h2>
                            <div class="muted small">View invoices, pay, download PDFs, and see payment receipts.</div>
                        </div>
                        <div class="row" style="gap:8px">
                            <button class="btn orange" onclick="openPayModal()">Pay Selected</button>
                            <button class="btn" onclick="toast('Download invoice PDFs')">Download PDFs</button>
                            <button class="btn" onclick="toast('Request invoice copy via email')">Email Copies</button>
                        </div>
                    </div>
                    <div class="hr"></div>

                    <!-- Filters -->
                    <div class="form-grid">
                        <div class="col3">
                            <label>Status</label>
                            <select id="invStatus" onchange="renderInvoices()">
                                <option value="all" selected>All</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Overdue">Overdue</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Period</label>
                            <select id="invPeriod" onchange="renderInvoices()">
                                <option value="all" selected>All</option>
                                <option value="Advance">Advance (3/6 months)</option>
                                <option value="Daily">Daily</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Search</label>
                            <input id="invQ" placeholder="INV-1022..."
                                onkeydown="if(event.key==='Enter')renderInvoices()" />
                        </div>
                        <div class="col3" style="display:flex;gap:10px;align-items:flex-end">
                            <button class="btn green" style="width:100%" onclick="renderInvoices()">Apply</button>
                            <button class="btn" style="width:100%" onclick="resetInvFilters()">Reset</button>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <!-- Invoices -->
                    <div class="card col7">
                        <div class="row">
                            <h2>Invoices</h2>
                            <span class="pill">VAT auto: <b>5%</b></span>
                        </div>
                        <table id="invTable">
                            <tr>
                                <th>Invoice</th>
                                <th>Subtotal</th>
                                <th>VAT</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Due</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            <tr>
                                <td>
                                    <b>INV-1022</b>
                                    <div class="muted small">Oct–Dec 2025 (Advance)</div>
                                </td>
                                <td>AED 9,600</td>
                                <td>AED 480</td>
                                <td><b>AED 10,080</b></td>
                                <td>AED 10,080</td>
                                <td><b>AED 0</b></td>
                                <td>
                                    2025-10-05
                                    <div class="muted small">—</div>
                                </td>
                                <td><span class="badge b-green">Paid</span></td>
                                <td>
                                    <button class="btn" onclick="openInvoice('INV-1022')">Open</button>
                                    <button class="btn orange" onclick="toast('Pay invoice INV-1022')">Pay</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>INV-1120</b>
                                    <div class="muted small">Dec 2025 (Daily)</div>
                                </td>
                                <td>AED 2,550</td>
                                <td>AED 128</td>
                                <td><b>AED 2,678</b></td>
                                <td>AED 0</td>
                                <td><b>AED 2,678</b></td>
                                <td>
                                    2025-12-20
                                    <div class="muted small">0 days</div>
                                </td>
                                <td><span class="badge b-orange">Unpaid</span></td>
                                <td>
                                    <button class="btn" onclick="openInvoice('INV-1120')">Open</button>
                                    <button class="btn orange" onclick="toast('Pay invoice INV-1120')">Pay</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Payments -->
                    <div class="card col5">
                        <div class="row">
                            <h2>Payments</h2>
                            <button class="btn" onclick="toast('Download receipts')">Download Receipts</button>
                        </div>
                        <table id="payTable">
                            <tr>
                                <th>Date</th>
                                <th>Receipt</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Notes</th>
                            </tr>
                            <tr>
                                <td>2025-12-10</td>
                                <td><b>RCPT-5541</b></td>
                                <td>Bank</td>
                                <td><b>AED 10,080</b></td>
                                <td class="muted">Advance period payment (INV-1022)</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Invoice Modal -->
    <div class="backdrop" id="invoiceModal">
        <div class="modal">
            <div class="modalHeader">
                <h3 id="modalTitle">Invoice Details</h3>
                <button class="btn" onclick="closeModal()">✕</button>
            </div>
            <div class="modalBody" id="modalBody"></div>
        </div>
    </div>

    <script>
        const invoices = [
            {
                no: "INV-1022",
                period: "Oct–Dec 2025 (Advance)",
                tags: ["Advance"],
                subtotal: 9600,
                vat: 480,
                total: 10080,
                paid: 10080,
                balance: 0,
                due: "2025-10-05",
                status: "Paid",
                lines: [
                    { item: "Storage fee", desc: "CONT-07 (40FT) Advance – Oct–Dec 2025", qty: 3, unit: "Month", rate: 3200, amount: 9600 }
                ]
            },
            {
                no: "INV-1120",
                period: "Dec 2025 (Daily)",
                tags: ["Daily"],
                subtotal: 2550,
                vat: 128,
                total: 2678,
                paid: 0,
                balance: 2678,
                due: "2025-12-20",
                status: "Unpaid",
                lines: [
                    { item: "Storage fee", desc: "Shed-09 shared – 30 days", qty: 30, unit: "Day", rate: 85, amount: 2550 },
                    { item: "Add-on", desc: "Repacking", qty: 1, unit: "Job", rate: 0, amount: 0 }
                ]
            }
        ];

        const payments = [
            { date: "2025-12-10", ref: "RCPT-5541", method: "Bank", amount: 10080, note: "Advance period payment (INV-1022)" }
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

        function money(n) { return "AED " + Number(n || 0).toLocaleString("en-US"); }

        function daysUntil(dateStr) {
            const today = new Date("2025-12-20T00:00:00");
            const d = new Date(dateStr + "T00:00:00");
            return Math.round((d - today) / (1000 * 60 * 60 * 24));
        }

        function openInvoice(invNo) {
            const i = invoices.find(x => x.no === invNo);
            if (!i) return toast("Invoice not found");

            const sBadge = i.status === "Paid" ? "b-green" : (i.status === "Overdue" ? "b-red" : "b-orange");

            const lines = i.lines.map(l => {
                const amt = l.amount || (Number(l.qty || 0) * Number(l.rate || 0));
                return `
                    <tr>
                        <td><b>${l.item}</b><div class="muted small">${l.desc || ""}</div></td>
                        <td>${l.qty || "—"}</td>
                        <td>${l.unit || "—"}</td>
                        <td>${money(l.rate || 0)}</td>
                        <td><b>${money(amt || 0)}</b></td>
                    </tr>
                `;
            }).join("");

            document.getElementById("modalTitle").textContent = "Invoice Details - " + i.no;
            document.getElementById("modalBody").innerhtml = `
                <div class="row">
                    <div>
                        <div class="pill"><span class="dot info"></span>Invoice: <b>${i.no}</b></div>
                        <div class="muted small">Period: ${i.period} • Due: ${i.due} • VAT 5%</div>
                    </div>
                    <div class="row" style="gap:8px">
                        <span class="badge ${sBadge}">${i.status}</span>
                        <button class="btn orange" onclick="toast('Pay invoice ${i.no}')">Pay</button>
                        <button class="btn" onclick="toast('Download PDF')">Download PDF</button>
                    </div>
                </div>
                <div class="hr"></div>
                <table>
                    <tr><th>Item</th><th>Qty</th><th>Unit</th><th>Rate</th><th>Amount</th></tr>
                    ${lines || '<tr><td colspan="5" class="muted">No lines.</td></tr>'}
                </table>
                <div class="hr"></div>
                <div class="grid" style="grid-template-columns:repeat(12,1fr)">
                    <div class="card" style="grid-column:span 4;box-shadow:none">
                        <div class="muted small" style="font-weight:900">Subtotal</div>
                        <div style="font-size:18px;font-weight:1000">${money(i.subtotal)}</div>
                    </div>
                    <div class="card" style="grid-column:span 4;box-shadow:none">
                        <div class="muted small" style="font-weight:900">VAT (5%)</div>
                        <div style="font-size:18px;font-weight:1000">${money(i.vat)}</div>
                    </div>
                    <div class="card" style="grid-column:span 4;box-shadow:none">
                        <div class="muted small" style="font-weight:900">Total / Balance</div>
                        <div style="font-size:18px;font-weight:1000">${money(i.total)} / ${money(i.balance)}</div>
                    </div>
                </div>
            `;
            document.getElementById("invoiceModal").classList.add("open");
        }

        function closeModal() {
            document.getElementById("invoiceModal").classList.remove("open");
        }

        function openPayModal() {
            toast('Payment gateway integration - Coming soon');
        }

        function resetInvFilters() {
            document.getElementById("invStatus").value = "all";
            document.getElementById("invPeriod").value = "all";
            document.getElementById("invQ").value = "";
            renderInvoices();
            toast("Invoice filters reset");
        }

        function renderInvoices() {
            const st = document.getElementById("invStatus").value;
            const pr = document.getElementById("invPeriod").value;
            const q = document.getElementById("invQ").value.toLowerCase().trim();

            let list = invoices.slice();
            if (st !== "all") list = list.filter(i => i.status === st);
            if (pr !== "all") {
                if (pr === "Advance") list = list.filter(i => i.tags.includes("Advance"));
                if (pr === "Daily") list = list.filter(i => i.tags.includes("Daily"));
                if (pr === "Monthly") list = list.filter(i => i.tags.includes("Monthly"));
            }
            if (q) list = list.filter(i => `${i.no} ${i.period} ${i.status}`.toLowerCase().includes(q));

            const rows = list.map(i => {
                const sBadge = i.status === "Paid" ? "b-green" : (i.status === "Overdue" ? "b-red" : "b-orange");
                const dueIn = daysUntil(i.due);
                const dueTxt = i.status === "Paid" ? "—" : (dueIn < 0 ? `${Math.abs(dueIn)} days overdue` : `${dueIn} days`);
                return `
                    <tr>
                        <td>
                            <b>${i.no}</b>
                            <div class="muted small">${i.period}</div>
                        </td>
                        <td>${money(i.subtotal)}</td>
                        <td>${money(i.vat)}</td>
                        <td><b>${money(i.total)}</b></td>
                        <td>${money(i.paid)}</td>
                        <td><b>${money(i.balance)}</b></td>
                        <td>
                            ${i.due}
                            <div class="muted small">${dueTxt}</div>
                        </td>
                        <td><span class="badge ${sBadge}">${i.status}</span></td>
                        <td>
                            <button class="btn" onclick="openInvoice('${i.no}')">Open</button>
                            <button class="btn orange" onclick="toast('Pay invoice ${i.no}')">Pay</button>
                        </td>
                    </tr>
                `;
            }).join("");

            document.getElementById("invTable").innerhtml = `
                <tr><th>Invoice</th><th>Subtotal</th><th>VAT</th><th>Total</th><th>Paid</th><th>Balance</th><th>Due</th><th>Status</th><th>Actions</th></tr>
                ${rows || '<tr><td colspan="9" class="muted">No invoices found.</td></tr>'}
            `;
        }

        // Check URL params
        const urlParams = new URLSearchParams(window.location.search);
        const invParam = urlParams.get('inv');
        if (invParam) {
            setTimeout(() => openInvoice(invParam), 100);
        }
    </script>
</body>

</html>