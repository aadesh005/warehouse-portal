<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - Notices</title>
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

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot.ok {
            background: var(--ok);
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

        .timeline {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border);
        }

        .timeline-step {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .timeline-dot {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--border);
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 900;
            color: #fff;
        }

        .timeline-dot.active {
            background: var(--orange);
        }

        .timeline-dot.completed {
            background: var(--green);
        }

        .timeline-label {
            font-size: 11px;
            color: var(--muted);
            font-weight: 900;
        }

        @media (max-width: 1100px) {
            aside {
                display: none;
            }

            .timeline {
                flex-direction: column;
                gap: 20px;
            }

            .timeline::before {
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
                    <a href="statement.php">Statement</a>
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="documents.php">Documents</a>
                    <a href="notices.php" class="active">Notices</a>
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
                            <h2 style="margin:0">Notices</h2>
                            <div class="muted small">If unpaid for consecutive months, notices can be sent on a 7-day
                                interval (1st, 2nd, 3rd, LBA, Final).</div>
                        </div>
                        <div class="row" style="gap:8px">
                            <button class="btn" onclick="toast('Download notice pack')">Download Pack</button>
                            <button class="btn" onclick="toast('Open legal timeline')">Timeline</button>
                        </div>
                    </div>
                    <div class="hr"></div>

                    <div id="noticeSummary">
                        <div class="pill"><span class="dot ok"></span>No active notices on your account.</div>
                        <div class="muted small" style="margin-top:10px">
                            (If a notice cycle starts, you will see each stage here with email log and courier proof.)
                        </div>
                    </div>

                    <div class="hr"></div>

                    <!-- Notice Timeline (Hidden by default, shown when notices exist) -->
                    <div id="noticeTimeline" style="display:none;">
                        <h3>Notice Cycle Timeline</h3>
                        <div class="timeline">
                            <div class="timeline-step">
                                <div class="timeline-dot completed">1</div>
                                <div class="timeline-label">1st Notice</div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-dot completed">2</div>
                                <div class="timeline-label">2nd Notice</div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-dot active">3</div>
                                <div class="timeline-label">3rd Notice</div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-dot">L</div>
                                <div class="timeline-label">LBA</div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-dot">F</div>
                                <div class="timeline-label">Final</div>
                            </div>
                        </div>
                    </div>

                    <table id="noticeTable">
                        <tr>
                            <th>Stage</th>
                            <th>Sent</th>
                            <th>Next Due</th>
                            <th>Email Log</th>
                            <th>Courier Proof</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td colspan="6" class="muted">No notices.</td>
                        </tr>
                    </table>

                    <div class="muted small" style="margin-top:10px">
                        Wireframe note: Admin uploads courier proof per notice; client can view notice history for
                        transparency.
                    </div>
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

        // Example function to show notices if they existed
        function showSampleNotices() {
            document.getElementById("noticeSummary").innerhtml = `
                <div class="pill"><span class="dot warn"></span>Active notice cycle in progress.</div>
            `;
            document.getElementById("noticeTimeline").style.display = "block";
            document.getElementById("noticeTable").innerhtml = `
                <tr>
                    <th>Stage</th>
                    <th>Sent</th>
                    <th>Next Due</th>
                    <th>Email Log</th>
                    <th>Courier Proof</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>1st Notice</td>
                    <td>2025-12-01</td>
                    <td>—</td>
                    <td><button class="btn" onclick="toast('View email log')">View</button></td>
                    <td><button class="btn" onclick="toast('View courier proof')">View</button></td>
                    <td><button class="btn" onclick="toast('Download PDF')">Download</button></td>
                </tr>
                <tr>
                    <td>2nd Notice</td>
                    <td>2025-12-08</td>
                    <td>—</td>
                    <td><button class="btn" onclick="toast('View email log')">View</button></td>
                    <td><button class="btn" onclick="toast('View courier proof')">View</button></td>
                    <td><button class="btn" onclick="toast('Download PDF')">Download</button></td>
                </tr>
                <tr style="background:#fff7ed;">
                    <td><b>3rd Notice (Current)</b></td>
                    <td>2025-12-15</td>
                    <td>2025-12-22</td>
                    <td><button class="btn" onclick="toast('View email log')">View</button></td>
                    <td><button class="btn" onclick="toast('View courier proof')">View</button></td>
                    <td><button class="btn orange" onclick="location.href='invoices.php'">Pay Now</button></td>
                </tr>
            `;
        }
    </script>
</body>

</html>