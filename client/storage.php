<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - My Storage</title>
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

        a:hover {
            text-decoration: underline;
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 10px;
        }

        .col3 {
            grid-column: span 3;
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

        /* Drawer */
        .drawer {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: min(560px, 96vw);
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

        @media (max-width: 1100px) {
            aside {
                display: none;
            }

            .col3 {
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
                    <a href="dashboard.php" class="active">Dashboard</a>
                    <a href="storage.php" class="active">My Storage</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="statement.php">Statement</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="documents.php">Documents</a>
                    <a href="notices.php">Notices</a>
                    <a href="support.php">Support</a>
                </div>
                <div class="hr"></div>
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn green" style="width:100%;margin-bottom:8px" onclick="openRequestModal()">+ Request
                    Storage</button>
                <button class="btn" style="width:100%;margin-bottom:8px" onclick="location.href='movements.php#new'">+
                    Log Movement Request</button>
                <button class="btn" style="width:100%;margin-bottom:8px"
                    onclick="toast('Download contract pack')">Download Contracts</button>
                <button class="btn orange" style="width:100%" onclick="location.href='invoices.php#pay'">Pay
                    Now</button>
            </aside>

            <main>
                <!-- Header Card -->
                <div class="card">
                    <div class="row">
                        <div>
                            <h2 style="margin:0">My Storage</h2>
                            <div class="muted small">All current + historical allocations (sheds & containers). Click
                                any row to open details.</div>
                        </div>
                        <div class="row" style="gap:8px">
                            <button class="btn" onclick="openRequestModal()">+ Request Unit</button>
                            <button class="btn" onclick="toast('Download allocation report PDF')">Download PDF</button>
                        </div>
                    </div>
                    <div class="hr"></div>

                    <!-- Filters -->
                    <div class="form-grid">
                        <div class="col3">
                            <label>Filter Type</label>
                            <select id="stType" onchange="renderStorage()">
                                <option value="all" selected>All</option>
                                <option value="Shed">Shed</option>
                                <option value="Container">Container</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Status</label>
                            <select id="stStatus" onchange="renderStorage()">
                                <option value="all" selected>All</option>
                                <option value="Active">Active</option>
                                <option value="Ended">Ended</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Expiring</label>
                            <select id="stExp" onchange="renderStorage()">
                                <option value="all" selected>All</option>
                                <option value="7">Next 7 days</option>
                                <option value="15">Next 15 days</option>
                                <option value="30">Next 30 days</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Search</label>
                            <input id="stQ" placeholder="Shed-09, CONT-07..."
                                onkeydown="if(event.key==='Enter')renderStorage()" />
                        </div>
                    </div>
                </div>

                <!-- Allocations Table -->
                <div class="card">
                    <div class="row">
                        <h2>Allocations</h2>
                        <span class="pill">Showing: <b id="stCount">3</b></span>
                    </div>
                    <table id="storageTable">
                        <tr>
                            <th>Unit</th>
                            <th>Period</th>
                            <th>Billing</th>
                            <th>Rate</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td>
                                <a class="link" onclick="openUnit('CONT-07')">CONT-07</a>
                                <div class="muted small">Container • Exclusive</div>
                            </td>
                            <td>
                                2025-10-01 → 2026-03-31
                                <div class="muted small">Ends in: <span class="badge b-gray">102 days</span></div>
                            </td>
                            <td>Monthly (Advance)</td>
                            <td><b>AED 3,200/mo</b></td>
                            <td><span class="badge b-green">Active</span></td>
                            <td>
                                <button class="btn" onclick="openUnit('CONT-07')">View</button>
                                <button class="btn orange" onclick="toast('Request renewal for CONT-07')">Renew</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="link" onclick="openUnit('Shed-09')">Shed-09</a>
                                <div class="muted small">Shed • Shared</div>
                            </td>
                            <td>
                                2025-12-01 → 2026-01-15
                                <div class="muted small">Ends in: <span class="badge b-orange">26 days</span></div>
                            </td>
                            <td>Daily</td>
                            <td><b>AED 85/day</b></td>
                            <td><span class="badge b-green">Active</span></td>
                            <td>
                                <button class="btn" onclick="openUnit('Shed-09')">View</button>
                                <button class="btn orange" onclick="toast('Request renewal for Shed-09')">Renew</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="link" onclick="openUnit('Shed-09')">Shed-09</a>
                                <div class="muted small">Shed • Shared</div>
                            </td>
                            <td>
                                2025-01-01 → 2025-02-25
                                <div class="muted small">Ended</div>
                            </td>
                            <td>Daily</td>
                            <td><b>AED 75/day</b></td>
                            <td><span class="badge b-gray">Ended</span></td>
                            <td>
                                <button class="btn" onclick="openUnit('Shed-09')">View</button>
                                <button class="btn orange" onclick="toast('Request renewal for Shed-09')">Renew</button>
                            </td>
                        </tr>
                    </table>
                    <div class="muted small" style="margin-top:10px">
                        Billing supports <b>Daily / Weekly / Monthly / Advance (3 or 6 months in one invoice)</b>.
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Unit Details Drawer -->
    <div class="drawer" id="unitDrawer">
        <div class="drawerHeader">
            <div class="row">
                <div>
                    <div style="font-size:14px;font-weight:1000" id="uTitle">Unit</div>
                    <div class="muted small" id="uSub">—</div>
                </div>
                <button class="btn ghost" onclick="closeUnitDrawer()">✕</button>
            </div>
        </div>
        <div class="drawerBody" id="unitDrawerBody"></div>
        <div class="drawerFooter">
            <button class="btn" onclick="toast('Download unit allocation PDF')">Download</button>
            <button class="btn orange" onclick="toast('Request extension')">Request Extension</button>
            <button class="btn green" onclick="location.href='invoices.php'">Open Invoices</button>
        </div>
    </div>

    <script>
        // Data
        const allocations = [
            { unit: "CONT-07", type: "Container", start: "2025-10-01", end: "2026-03-31", billing: "Monthly (Advance)", rate: "AED 3,200/mo", status: "Active", share: "Exclusive" },
            { unit: "Shed-09", type: "Shed", start: "2025-12-01", end: "2026-01-15", billing: "Daily", rate: "AED 85/day", status: "Active", share: "Shared" },
            { unit: "Shed-09", type: "Shed", start: "2025-01-01", end: "2025-02-25", billing: "Daily", rate: "AED 75/day", status: "Ended", share: "Shared" }
        ];

        const invoices = [
            { no: "INV-1022", period: "Oct–Dec 2025 (Advance)", total: 10080, balance: 0, status: "Paid", due: "2025-10-05", lines: [{ desc: "CONT-07 (40FT) Advance – Oct–Dec 2025" }] },
            { no: "INV-1120", period: "Dec 2025 (Daily)", total: 2678, balance: 2678, status: "Unpaid", due: "2025-12-20", lines: [{ desc: "Shed-09 shared – 30 days" }] }
        ];

        const movements = [
            { dt: "2025-12-18 10:22", unit: "Shed-09 (shared)", type: "Inbound", inPkgs: 45, outPkgs: 0, note: "Electronics cartons", ref: "MOV-9001" },
            { dt: "2025-12-18 15:10", unit: "Shed-09 (shared)", type: "Outbound", inPkgs: 0, outPkgs: 12, note: "Partial delivery pickup", ref: "MOV-9002" },
            { dt: "2025-12-20 09:05", unit: "CONT-07", type: "Inbound", inPkgs: 0, outPkgs: 0, note: "Container seal check & inventory update", ref: "MOV-9008" }
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

        function daysUntil(dateStr) {
            const today = new Date("2025-12-20T00:00:00");
            const d = new Date(dateStr + "T00:00:00");
            return Math.round((d - today) / (1000 * 60 * 60 * 24));
        }

        function money(n) { return "AED " + Number(n || 0).toLocaleString("en-US"); }

        function openUnit(unitId) {
            const allocs = allocations.filter(a => a.unit === unitId).sort((a, b) => b.start.localeCompare(a.start));
            const active = allocs.find(a => a.status === "Active");
            const endIn = active ? daysUntil(active.end) : null;

            document.getElementById("uTitle").textContent = unitId;
            document.getElementById("uSub").textContent = active
                ? `${active.type} • ${active.share} • ${active.start} → ${active.end} • Ends in ${endIn} days`
                : `Unit history`;

            const inv = invoices.filter(i => i.lines.some(l => l.desc.includes(unitId)));
            const invRows = inv.map(i => `
                <tr>
                    <td><b>${i.no}</b><div class="muted small">${i.period}</div></td>
                    <td><b>${money(i.total)}</b></td>
                    <td><b>${money(i.balance)}</b></td>
                    <td><span class="badge ${i.status === 'Paid' ? 'b-green' : 'b-orange'}">${i.status}</span></td>
                    <td><button class="btn" onclick="location.href='invoices.php?inv=${i.no}'">Open</button></td>
                </tr>
            `).join("");

            const mv = movements.filter(m => m.unit.includes(unitId));
            const mvRows = mv.map(m => `
                <tr>
                    <td>${m.dt}</td>
                    <td><span class="badge ${m.type === 'Inbound' ? 'b-green' : 'b-orange'}">${m.type}</span></td>
                    <td>${m.inPkgs || 0}</td>
                    <td>${m.outPkgs || 0}</td>
                    <td class="muted">${m.note}</td>
                    <td><a class="link" href="movements.php?ref=${m.ref}">${m.ref}</a></td>
                </tr>
            `).join("");

            document.getElementById("unitDrawerBody").innerhtml = `
                <div class="pill"><span class="dot info"></span>Unit history is shown to client (active + previous periods).</div>
                <div class="hr"></div>
                <h2>Allocation History</h2>
                <table>
                    <tr><th>Status</th><th>Period</th><th>Billing</th><th>Rate</th><th>Share</th></tr>
                    ${allocs.map(a => `
                        <tr>
                            <td><span class="badge ${a.status === 'Active' ? 'b-green' : 'b-gray'}">${a.status}</span></td>
                            <td>${a.start} → ${a.end}</td>
                            <td>${a.billing}</td>
                            <td><b>${a.rate}</b></td>
                            <td>${a.share}</td>
                        </tr>
                    `).join("")}
                </table>
                <div class="hr"></div>
                <h2>Related Invoices</h2>
                <table>
                    <tr><th>Invoice</th><th>Total</th><th>Balance</th><th>Status</th><th></th></tr>
                    ${invRows || '<tr><td colspan="5" class="muted">No related invoices found.</td></tr>'}
                </table>
                <div class="hr"></div>
                <h2>Movements for this Unit</h2>
                <table>
                    <tr><th>Date/Time</th><th>Type</th><th>In</th><th>Out</th><th>Notes</th><th>Ref</th></tr>
                    ${mvRows || '<tr><td colspan="6" class="muted">No movements for this unit.</td></tr>'}
                </table>
            `;
            document.getElementById("unitDrawer").classList.add("open");
        }

        function closeUnitDrawer() {
            document.getElementById("unitDrawer").classList.remove("open");
        }

        function openRequestModal() {
            toast('Request additional storage - Opening form...');
        }

        function renderStorage() {
            const t = document.getElementById("stType").value;
            const s = document.getElementById("stStatus").value;
            const exp = document.getElementById("stExp").value;
            const q = document.getElementById("stQ").value.toLowerCase().trim();

            let list = allocations.slice();
            if (t !== "all") list = list.filter(a => a.type === t);
            if (s !== "all") list = list.filter(a => a.status === s);
            if (q) list = list.filter(a => `${a.unit} ${a.type} ${a.billing} ${a.rate}`.toLowerCase().includes(q));
            if (exp !== "all") {
                const w = Number(exp);
                list = list.filter(a => a.status === "Active" && daysUntil(a.end) <= w);
            }

            document.getElementById("stCount").textContent = list.length;

            const tbody = list.map(a => {
                const dueIn = daysUntil(a.end);
                const expBadge = a.status !== "Active" ? "b-gray" : (dueIn <= 7 ? "b-red" : (dueIn <= 15 ? "b-orange" : "b-gray"));
                const expTxt = a.status !== "Active" ? "—" : (dueIn < 0 ? "Expired" : `${dueIn} days`);
                return `
                    <tr>
                        <td>
                            <a class="link" onclick="openUnit('${a.unit}')">${a.unit}</a>
                            <div class="muted small">${a.type} • ${a.share}</div>
                        </td>
                        <td>
                            ${a.start} → ${a.end}
                            <div class="muted small">Ends in: <span class="badge ${expBadge}">${expTxt}</span></div>
                        </td>
                        <td>${a.billing}</td>
                        <td><b>${a.rate}</b></td>
                        <td><span class="badge ${a.status === 'Active' ? 'b-green' : 'b-gray'}">${a.status}</span></td>
                        <td>
                            <button class="btn" onclick="openUnit('${a.unit}')">View</button>
                            <button class="btn orange" onclick="toast('Request renewal for ${a.unit}')">Renew</button>
                        </td>
                    </tr>
                `;
            }).join("");

            document.getElementById("storageTable").innerhtml = `
                <tr><th>Unit</th><th>Period</th><th>Billing</th><th>Rate</th><th>Status</th><th>Actions</th></tr>
                ${tbody || '<tr><td colspan="6" class="muted">No allocations.</td></tr>'}
            `;
        }

        // Check URL params for direct unit open
        const urlParams = new URLSearchParams(window.location.search);
        const unitParam = urlParams.get('unit');
        if (unitParam) {
            setTimeout(() => openUnit(unitParam), 100);
        }
    </script>
</body>

</html>