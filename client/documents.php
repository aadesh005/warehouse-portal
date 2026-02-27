<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - Documents</title>
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
            width: min(500px, 100%);
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 10px;
        }

        .col6 {
            grid-column: span 6;
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
                    <a href="dashboard.php">Dashboard</a>
                    <a href="storage.php">My Storage</a>
                    <a href="invoices.php">Invoices & Payments</a>
                    <a href="statement.php">Statement</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="documents.php" class="active">Documents</a>
                    <a href="notices.php">Notices</a>
                    <a href="support.php">Support</a>
                </div>
                <div class="hr"></div>
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn green" style="width:100%;margin-bottom:8px" onclick="openDocUpload()">+ Upload
                    Document</button>
                <button class="btn" style="width:100%;margin-bottom:8px"
                    onclick="toast('Request reminder settings')">Reminders</button>
                <button class="btn" style="width:100%;margin-bottom:8px"
                    onclick="toast('Download contract pack')">Download Contracts</button>
                <button class="btn orange" style="width:100%" onclick="location.href='invoices.php#pay'">Pay
                    Now</button>
            </aside>

            <main>
                <div class="card">
                    <div class="row">
                        <div>
                            <h2 style="margin:0">Documents</h2>
                            <div class="muted small">Upload Trade License / Emirates ID / Passport / Visa and track
                                expiry reminders.</div>
                        </div>
                        <div class="row" style="gap:8px">
                            <button class="btn green" onclick="openDocUpload()">+ Upload Document</button>
                            <button class="btn" onclick="toast('Request reminder settings')">Reminders</button>
                        </div>
                    </div>
                    <div class="hr"></div>

                    <table id="docTable">
                        <tr>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Expiry</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td>
                                <b>Trade License</b>
                                <div class="muted small">TradeLicense_ABC.pdf</div>
                            </td>
                            <td><span class="badge b-green">Valid</span></td>
                            <td>2026-08-12</td>
                            <td>
                                <button class="btn" onclick="openDocUpload('Trade License')">Upload/Replace</button>
                                <button class="btn" onclick="toast('View document file')">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Emirates ID</b>
                                <div class="muted small">EID_Ahmed.jpg</div>
                            </td>
                            <td><span class="badge b-orange">Expiring</span></td>
                            <td>2026-01-06</td>
                            <td>
                                <button class="btn" onclick="openDocUpload('Emirates ID')">Upload/Replace</button>
                                <button class="btn" onclick="toast('View document file')">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Passport</b>
                                <div class="muted small">Passport_Ahmed.jpg</div>
                            </td>
                            <td><span class="badge b-green">Valid</span></td>
                            <td>2028-02-20</td>
                            <td>
                                <button class="btn" onclick="openDocUpload('Passport')">Upload/Replace</button>
                                <button class="btn" onclick="toast('View document file')">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Visa</b>
                                <div class="muted small">—</div>
                            </td>
                            <td><span class="badge b-red">Missing</span></td>
                            <td>—</td>
                            <td>
                                <button class="btn" onclick="openDocUpload('Visa')">Upload/Replace</button>
                                <button class="btn" onclick="toast('View document file')">View</button>
                            </td>
                        </tr>
                    </table>
                    <div class="muted small" style="margin-top:10px">
                        Recommended reminders: 30 / 15 / 7 days before expiry.
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="backdrop" id="uploadModal">
        <div class="modal">
            <div class="modalHeader">
                <h3 id="modalTitle">Upload Document</h3>
                <button class="btn" onclick="closeModal()">✕</button>
            </div>
            <div class="modalBody" id="modalBody"></div>
        </div>
    </div>

    <script>
        const documents = [
            { doc: "Trade License", status: "Valid", expiry: "2026-08-12", file: "TradeLicense_ABC.pdf" },
            { doc: "Emirates ID", status: "Expiring", expiry: "2026-01-06", file: "EID_Ahmed.jpg" },
            { doc: "Passport", status: "Valid", expiry: "2028-02-20", file: "Passport_Ahmed.jpg" },
            { doc: "Visa", status: "Missing", expiry: "—", file: "—" }
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

        function openDocUpload(docName) {
            const name = docName || "Document";
            document.getElementById("modalTitle").textContent = "Upload Document - " + name;
            document.getElementById("modalBody").innerhtml = `
                <div class="pill"><span class="dot info"></span>Upload/Replace: <b>${name}</b></div>
                <div class="hr"></div>
                <div class="form-grid">
                    <div class="col6">
                        <label>Document Type</label>
                        <select id="docType">
                            <option ${name === "Trade License" ? "selected" : ""}>Trade License</option>
                            <option ${name === "Emirates ID" ? "selected" : ""}>Emirates ID</option>
                            <option ${name === "Passport" ? "selected" : ""}>Passport</option>
                            <option ${name === "Visa" ? "selected" : ""}>Visa</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="col6">
                        <label>Expiry Date (if applicable)</label>
                        <input type="date" value="2026-01-06"/>
                    </div>
                    <div class="col12">
                        <label>Choose File</label>
                        <input type="file"/>
                    </div>
                    <div class="col12">
                        <button class="btn green" style="width:100%" onclick="toast('Upload submitted');closeModal()">Submit</button>
                    </div>
                </div>
                <div class="muted small" style="margin-top:10px">Backend will store file + expiry + set reminders automatically.</div>
            `;
            document.getElementById("uploadModal").classList.add("open");
        }

        function closeModal() {
            document.getElementById("uploadModal").classList.remove("open");
        }

        function renderDocs() {
            const rows = documents.map(d => {
                const badge = d.status === "Valid" ? "b-green" : (d.status === "Expiring" ? "b-orange" : "b-red");
                return `
                    <tr>
                        <td>
                            <b>${d.doc}</b>
                            <div class="muted small">${d.file || "—"}</div>
                        </td>
                        <td><span class="badge ${badge}">${d.status}</span></td>
                        <td>${d.expiry}</td>
                        <td>
                            <button class="btn" onclick="openDocUpload('${d.doc}')">Upload/Replace</button>
                            <button class="btn" onclick="toast('View document file')">View</button>
                        </td>
                    </tr>
                `;
            }).join("");

            document.getElementById("docTable").innerhtml = `
                <tr><th>Document</th><th>Status</th><th>Expiry</th><th>Actions</th></tr>
                ${rows || '<tr><td colspan="4" class="muted">No documents.</td></tr>'}
            `;
        }

        renderDocs();
    </script>
</body>

</html>