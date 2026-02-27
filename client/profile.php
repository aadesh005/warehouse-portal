<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - My Profile</title>
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
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { height: 42px; }
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
        .btn.orange { background: var(--orange); border-color: var(--orange); color: #fff; }
        .btn.green { background: var(--green); border-color: var(--green); color: #fff; }
        
        .wrap { /* max-width: 1380px; */ margin: 16px auto; padding: 0 18px; }
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
        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
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
        .dot.ok { background: var(--green); }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 10px;
        }
        .col6 { grid-column: span 6; }
        .col12 { grid-column: span 12; }
        
        label {
            display: block;
            margin-bottom: 4px;
            font-weight: 900;
            font-size: 12px;
            color: var(--muted);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            font-weight: 800;
            color: var(--text);
            font-size: 13px;
            font-family: inherit;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(26, 163, 74, 0.1);
        }
        textarea { min-height: 80px; resize: vertical; }
        
        @media (max-width: 1100px) {
            aside { display: none; }
            .col6 { grid-column: span 12; }
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <div class="brand">
                <img alt="RGSL Logo" src="https://royalgulfshipping.com/wp-content/uploads/2025/11/RGSL-LOGO.png"/>
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
                    <a href="notices.php">Notices</a>
                    <a href="support.php">Support</a>
                </div>
                <div class="hr"></div>
                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn green" style="width:100%;margin-bottom:8px" onclick="location.href='storage.php#request'">+ Request Storage</button>
                <button class="btn" style="width:100%;margin-bottom:8px" onclick="location.href='movements.php#new'">+ Log Movement Request</button>
                <button class="btn" style="width:100%;margin-bottom:8px" onclick="toast('Download contract pack')">Download Contracts</button>
                <button class="btn orange" style="width:100%" onclick="location.href='invoices.php#pay'">Pay Now</button>
            </aside>

            <main>
                <div class="card">
                    <div class="row">
                        <div>
                            <h2 style="margin:0">My Profile</h2>
                            <div class="muted small">Profile & Contacts (client side)</div>
                        </div>
                        <div class="row" style="gap:8px;">
                            <button class="btn" onclick="location.href='dashboard.php'">Close</button>
                            <button class="btn green" onclick="toast('Save profile changes')">Save</button>
                        </div>
                    </div>
                    <div class="hr"></div>
                    
                    <div class="pill" style="margin-bottom:16px;"><span class="dot ok"></span>Account: <b>ABC Trading LLC</b></div>
                    
                    <div class="form-grid">
                        <div class="col6">
                            <label>Company / Full Name</label>
                            <input value="ABC Trading LLC"/>
                        </div>
                        <div class="col6">
                            <label>TRN</label>
                            <input value="TRN-100012345600003"/>
                        </div>
                        <div class="col6">
                            <label>Email</label>
                            <input value="accounts@abctrading.ae"/>
                        </div>
                        <div class="col6">
                            <label>Phone</label>
                            <input value="+971 55 123 4567"/>
                        </div>
                        <div class="col12">
                            <label>Address</label>
                            <input value="Al Quoz, Dubai, UAE"/>
                        </div>
                        <div class="col6">
                            <label>Primary Contact Name</label>
                            <input value="Ahmed Khan"/>
                        </div>
                        <div class="col6">
                            <label>Role</label>
                            <input value="Accounts"/>
                        </div>
                        <div class="col12">
                            <label>Notes</label>
                            <textarea>Preferred invoices by email. Often pays in advance.</textarea>
                        </div>
                        <div class="col12">
                            <div class="pill"><span class="dot info"></span>Invoice Preference: <b>Monthly</b></div>
                        </div>
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
    </script>
</body>
</php>