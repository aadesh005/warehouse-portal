<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - Account Statement</title>
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
            /* max-width: 1380px; */
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

        tr.positive {
            background: #f0fdf4;
        }

        tr.negative {
            background: #fef2f2;
        }

        @media (max-width: 1100px) {
            aside {
                display: none;
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
                    <a href="dashboard.php" class="active">Dashboard</a>
                    <a href="storage.php">My Storage</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="statement.php" class="active">Statement</a>
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
                <button class="btn orange" style="width:100%" onclick="location.href='invoices.php#pay'">Pay
                    Now</button>
            </aside>

            <main>
                <div class="card">
                    <div class="row">
                        <div>
                            <h2 style="margin:0">Account Statement</h2>
                            <div class="muted small">Ledger style: invoices (debit) and payments (credit) with running
                                balance.</div>
                        </div>
                        <div class="row" style="gap:8px">
                            <button class="btn" onclick="toast('Change date range')">Date Range</button>
                            <button class="btn" onclick="toast('Download PDF')">Download PDF</button>
                            <button class="btn orange" onclick="toast('Email statement')">Email</button>
                        </div>
                    </div>
                    <div class="hr"></div>

                    <table id="stmtTable">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Ref</th>
                            <th>Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Running Balance</th>
                        </tr>
                        <tr class="negative">
                            <td>2025-10-01</td>
                            <td><span class="badge b-orange">Invoice</span></td>
                            <td><b>INV-1022</b></td>
                            <td>Oct–Dec 2025 (Advance)</td>
                            <td>AED 10,080</td>
                            <td>—</td>
                            <td><b>AED 10,080</b></td>
                        </tr>
                        <tr class="positive">
                            <td>2025-12-10</td>
                            <td><span class="badge b-green">Payment</span></td>
                            <td><b>RCPT-5541</b></td>
                            <td>Bank</td>
                            <td>—</td>
                            <td>AED 10,080</td>
                            <td><b>AED 0</b></td>
                        </tr>
                        <tr class="negative">
                            <td>2025-12-20</td>
                            <td><span class="badge b-orange">Invoice</span></td>
                            <td><b>INV-1120</b></td>
                            <td>Dec 2025 (Daily)</td>
                            <td>AED 2,678</td>
                            <td>—</td>
                            <td><b>AED 2,678</b></td>
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

        function money(n) { return "AED " + Number(n || 0).toLocaleString("en-US"); }

        // Dynamic statement generation
        const invoices = [
            { date: "2025-10-05", no: "INV-1022", period: "Oct–Dec 2025 (Advance)", total: 10080 },
            { date: "2025-12-20", no: "INV-1120", period: "Dec 2025 (Daily)", total: 2678 }
        ];
        const payments = [
            { date: "2025-12-10", ref: "RCPT-5541", method: "Bank", amount: 10080 }
        ];

        function renderStatement() {
            const lines = [];
            invoices.forEach(i => lines.push({
                date: i.date,
                type: "Invoice",
                ref: i.no,
                debit: i.total,
                credit: 0,
                note: i.period
            }));
            payments.forEach(p => lines.push({
                date: p.date,
                type: "Payment",
                ref: p.ref,
                debit: 0,
                credit: p.amount,
                note: p.method
            }));

            lines.sort((a, b) => a.date.localeCompare(b.date));
            let running = 0;

            const rows = lines.map(l => {
                running += (l.debit || 0) - (l.credit || 0);
                const rowClass = l.type === "Invoice" ? "negative" : "positive";
                return `
                    <tr class="${rowClass}">
                        <td>${l.date}</td>
                        <td><span class="badge ${l.type === 'Invoice' ? 'b-orange' : 'b-green'}">${l.type}</span></td>
                        <td><b>${l.ref}</b></td>
                        <td>${l.note}</td>
                        <td>${l.debit ? money(l.debit) : "—"}</td>
                        <td>${l.credit ? money(l.credit) : "—"}</td>
                        <td><b>${money(running)}</b></td>
                    </tr>
                `;
            }).join("");

            document.getElementById("stmtTable").innerhtml = `
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Ref</th>
                    <th>Description</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Running Balance</th>
                </tr>
                ${rows || '<tr><td colspan="7" class="muted">No statement lines.</td></tr>'}
            `;
        }

        renderStatement();
    </script>
</body>

</html>