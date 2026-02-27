<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - Inbound / Outbound</title>
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
            width: min(600px, 100%);
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
                <button class="btn orange" onclick="location.href='../logout.php'">Logout</button>
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
                    <a href="statement.php">Statement</a>
                    <a href="movements.php" class="active">Inbound / Outbound</a>
                    <a href="documents.php">Documents</a>
                    <a href="notices.php">Notices</a>
                    <a href="support.php">Support</a>
                </div>
                <div class="hr"></div>
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn green" style="width:100%;margin-bottom:8px" onclick="openMovementModal()">+ Request
                    Movement</button>
                <button class="btn" style="width:100%;margin-bottom:8px" onclick="toast('Export CSV')">Export
                    CSV</button>
                <button class="btn" style="width:100%;margin-bottom:8px" onclick="toast('Export PDF')">Export
                    PDF</button>
                <button class="btn orange" style="width:100%" onclick="location.href='invoices.php#pay'">Pay
                    Now</button>
            </aside>

            <main>
                <!-- Header -->
                <div class="card">
                    <div class="row">
                        <div>
                            <h2 style="margin:0">Inbound / Outbound</h2>
                            <div class="muted small">Pull your inbound/outbound records from <b>X date</b> to <b>Y
                                    date</b>. Export CSV/PDF.</div>
                        </div>
                        <div class="row" style="gap:8px">
                            <button class="btn green" onclick="openMovementModal()">+ Request / Log Movement</button>
                            <button class="btn" onclick="toast('Export CSV')">Export CSV</button>
                            <button class="btn" onclick="toast('Export PDF')">Export PDF</button>
                        </div>
                    </div>
                    <div class="hr"></div>

                    <!-- Filters -->
                    <div class="form-grid">
                        <div class="col3">
                            <label>From</label>
                            <input id="mFrom" value="2025-12-01" type="date" onchange="renderMovements()" />
                        </div>
                        <div class="col3">
                            <label>To</label>
                            <input id="mTo" value="2025-12-31" type="date" onchange="renderMovements()" />
                        </div>
                        <div class="col3">
                            <label>Type</label>
                            <select id="mType" onchange="renderMovements()">
                                <option value="all" selected>All</option>
                                <option value="Inbound">Inbound</option>
                                <option value="Outbound">Outbound</option>
                            </select>
                        </div>
                        <div class="col3">
                            <label>Search</label>
                            <input id="mQ" placeholder="Shed-09, pallets..."
                                onkeydown="if(event.key==='Enter')renderMovements()" />
                        </div>
                    </div>
                </div>

                <!-- Movement Log -->
                <div class="card">
                    <div class="row">
                        <h2>Movement Log</h2>
                        <span class="pill">Showing: <b id="mCount">3</b></span>
                    </div>
                    <table id="moveTable">
                        <tr>
                            <th>Date/Time</th>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>In Pkgs</th>
                            <th>Out Pkgs</th>
                            <th>Notes</th>
                            <th>Ref</th>
                        </tr>
                        <tr>
                            <td>2025-12-18 10:22</td>
                            <td>Shed-09 (shared)</td>
                            <td><span class="badge b-green">Inbound</span></td>
                            <td>45</td>
                            <td>0</td>
                            <td class="muted">Electronics cartons</td>
                            <td><a class="link" onclick="openMovement('MOV-9001')">MOV-9001</a></td>
                        </tr>
                        <tr>
                            <td>2025-12-18 15:10</td>
                            <td>Shed-09 (shared)</td>
                            <td><span class="badge b-orange">Outbound</span></td>
                            <td>0</td>
                            <td>12</td>
                            <td class="muted">Partial delivery pickup</td>
                            <td><a class="link" onclick="openMovement('MOV-9002')">MOV-9002</a></td>
                        </tr>
                        <tr>
                            <td>2025-12-20 09:05</td>
                            <td>CONT-07</td>
                            <td><span class="badge b-green">Inbound</span></td>
                            <td>0</td>
                            <td>0</td>
                            <td class="muted">Container seal check & inventory update</td>
                            <td><a class="link" onclick="openMovement('MOV-9008')">MOV-9008</a></td>
                        </tr>
                    </table>
                    <div class="muted small" style="margin-top:10px">
                        Wireframe note: in real system, admin logs movements and system emails you inbound/outbound
                        notifications automatically.
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Movement Modal -->
    <div class="backdrop" id="movementModal">
        <div class="modal">
            <div class="modalHeader">
                <h3 id="modalTitle">Movement Details</h3>
                <button class="btn" onclick="closeModal()">✕</button>
            </div>
            <div class="modalBody" id="modalBody"></div>
        </div>
    </div>

    <script>
        const movements = [
            { dt: "2025-12-18 10:22", unit: "Shed-09 (shared)", type: "Inbound", inPkgs: 45, outPkgs: 0, note: "Electronics cartons", by: "Warehouse", ref: "MOV-9001" },
            { dt: "2025-12-18 15:10", unit: "Shed-09 (shared)", type: "Outbound", inPkgs: 0, outPkgs: 12, note: "Partial delivery pickup", by: "Warehouse", ref: "MOV-9002" },
            { dt: "2025-12-20 09:05", unit: "CONT-07", type: "Inbound", inPkgs: 0, outPkgs: 0, note: "Container seal check & inventory update", by: "Warehouse", ref: "MOV-9008" }
        ];

        const allocations = ["CONT-07", "Shed-09"];

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

        function isBetween(dtStr, from, to) {
            const d = new Date(dtStr.replace(" ", "T"));
            const f = new Date(from + "T00:00:00");
            const t = new Date(to + "T23:59:59");
            return d >= f && d <= t;
        }

        function openMovement(ref) {
            const m = movements.find(x => x.ref === ref);
            if (!m) return toast("Movement not found");

            const badge = m.type === "Inbound" ? "b-green" : "b-orange";
            document.getElementById("modalTitle").textContent = "Movement Details - " + m.ref;
            document.getElementById("modalBody").innerHTML = `
                <div class="row">
                    <div>
                        <div class="pill"><span class="dot info"></span>Movement Ref: <b>${m.ref}</b></div>
                        <div class="muted small">${m.dt} • Unit: <b>${m.unit}</b></div>
                    </div>
                    <span class="badge ${badge}">${m.type}</span>
                </div>
                <div class="hr"></div>
                <div class="form-grid">
                    <div class="col3">
                        <div class="muted small" style="font-weight:900">Inbound Packages</div>
                        <div style="font-size:18px;font-weight:1000">${m.inPkgs || 0}</div>
                    </div>
                    <div class="col3">
                        <div class="muted small" style="font-weight:900">Outbound Packages</div>
                        <div style="font-size:18px;font-weight:1000">${m.outPkgs || 0}</div>
                    </div>
                    <div class="col6">
                        <div class="muted small" style="font-weight:900">Logged By</div>
                        <div style="font-size:18px;font-weight:1000">${m.by || "Warehouse"}</div>
                    </div>
                    <div class="col12">
                        <div class="muted small" style="font-weight:900">Notes</div>
                        <div class="muted" style="padding:10px;background:#f8fafc;border-radius:8px;">${m.note || "—"}</div>
                    </div>
                    <div class="col12">
                        <div class="muted small" style="font-weight:900">Proof / POD</div>
                        <div class="muted">Upload / view attachments (wireframe)</div>
                    </div>
                </div>
            `;
            document.getElementById("movementModal").classList.add("open");
        }

        function closeModal() {
            document.getElementById("movementModal").classList.remove("open");
        }

        function openMovementModal() {
            document.getElementById("modalTitle").textContent = "Request Movement";
            document.getElementById("modalBody").innerHTML = `
                <div class="pill"><span class="dot info"></span>Inbound/Outbound Request</div>
                <div class="muted small" style="margin-top:8px">
                    Client request can create a ticket for warehouse team to confirm the movement.
                </div>
                <div class="hr"></div>
                <div class="form-grid">
                    <div class="col4">
                        <label>Type</label>
                        <select id="reqType">
                            <option>Inbound</option>
                            <option>Outbound</option>
                        </select>
                    </div>
                    <div class="col4">
                        <label>Unit</label>
                        <select id="reqUnit">
                            ${allocations.map(u => `<option>${u}</option>`).join("")}
                        </select>
                    </div>
                    <div class="col4">
                        <label>Packages Qty</label>
                        <input type="number" value="10" min="0"/>
                    </div>
                    <div class="col12">
                        <label>Notes</label>
                        <textarea style="width:100%;padding:10px;border:1px solid var(--border);border-radius:12px;min-height:80px;" placeholder="Describe packages, PO reference, driver details, etc."></textarea>
                    </div>
                    <div class="col12">
                        <button class="btn orange" style="width:100%" onclick="toast('Movement request submitted');closeModal()">Submit Request</button>
                    </div>
                </div>
            `;
            document.getElementById("movementModal").classList.add("open");
        }

        function renderMovements() {
            const from = document.getElementById("mFrom").value;
            const to = document.getElementById("mTo").value;
            const ty = document.getElementById("mType").value;
            const q = document.getElementById("mQ").value.toLowerCase().trim();

            let list = movements.filter(m => isBetween(m.dt, from, to));
            if (ty !== "all") list = list.filter(m => m.type === ty);
            if (q) list = list.filter(m => `${m.dt} ${m.unit} ${m.type} ${m.note} ${m.ref}`.toLowerCase().includes(q));

            document.getElementById("mCount").textContent = list.length;

            const rows = list.map(m => {
                const badge = m.type === "Inbound" ? "b-green" : "b-orange";
                return `
                    <tr>
                        <td>${m.dt}</td>
                        <td>${m.unit}</td>
                        <td><span class="badge ${badge}">${m.type}</span></td>
                        <td>${m.inPkgs || 0}</td>
                        <td>${m.outPkgs || 0}</td>
                        <td class="muted">${m.note || ""}</td>
                        <td><a class="link" onclick="openMovement('${m.ref}')">${m.ref}</a></td>
                    </tr>
                `;
            }).join("");

            document.getElementById("moveTable").innerHTML = `
                <tr><th>Date/Time</th><th>Unit</th><th>Type</th><th>In Pkgs</th><th>Out Pkgs</th><th>Notes</th><th>Ref</th></tr>
                ${rows || '<tr><td colspan="7" class="muted">No movements for selected range.</td></tr>'}
            `;
        }

        // Check URL params
        const urlParams = new URLSearchParams(window.location.search);
        const refParam = urlParams.get('ref');
        if (refParam) {
            setTimeout(() => openMovement(refParam), 100);
        }

        // Check hash for new movement
        if (window.location.hash === '#new') {
            setTimeout(() => openMovementModal(), 100);
        }
    </script>
</body>

</html>