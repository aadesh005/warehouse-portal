<?php
require_once  __DIR__ . '/../config/database.php';
require_once  __DIR__ . '/../includes/session.php';
require_once __DIR__  . '/../includes/functions.php';

requireClient();

// Get client data
$client = getClientByUserId($pdo, $_SESSION['user_id']);

// Get active allocations
$stmt = $pdo->prepare("SELECT a.*, u.unit_code, u.unit_type, u.zone 
                       FROM allocations a 
                       JOIN units u ON a.unit_id = u.id 
                       WHERE a.client_id = ? AND a.status = 'active'
                       ORDER BY a.end_date ASC");
$stmt->execute([$client['id']]);
$activeAllocations = $stmt->fetchAll();

// Get unpaid invoices
$stmt = $pdo->prepare("SELECT * FROM invoices WHERE client_id = ? AND balance > 0 ORDER BY due_date ASC");
$stmt->execute([$client['id']]);
$unpaidInvoices = $stmt->fetchAll();

// Get recent movements
$stmt = $pdo->prepare("SELECT m.*, u.unit_code FROM movements m 
                       JOIN units u ON m.unit_id = u.id 
                       WHERE m.client_id = ? 
                       ORDER BY m.movement_date DESC LIMIT 5");
$stmt->execute([$client['id']]);
$recentMovements = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - Client Dashboard</title>
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
            --bad: #dc2626;
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

        .kpis {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
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
            font-weight: 900;
        }

        .kpi .value {
            font-size: 20px;
            font-weight: 1000;
            margin-top: 6px;
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

        @media (max-width: 1100px) {
            aside {
                display: none;
            }

            .kpis {
                grid-template-columns: repeat(2, 1fr);
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
                    <p>Welcome, <?php echo htmlspecialchars($client['company_name'] ?: $client['full_name']); ?></p>
                </div>
            </div>
            <div class="actions">
                <span class="pill">ID: <b><?php echo $client['client_code']; ?></b></span>
                <button class="btn" onclick="location.href='profile.php'">Profile</button>
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
                    <a href="movements.php">Inbound / Outbound</a>
                    <a href="documents.php">Documents</a>
                    <a href="notices.php">Notices</a>
                    <a href="support.php">Support</a>
                </div>

                <div class="hr"></div>

                <div class="navTitle">QUICK ACTIONS</div>
                <button class="btn green" style="width:100%;margin-bottom:8px" onclick="location.href='storage.php?action=request'">+ Request Storage</button>
                <button class="btn" style="width:100%;margin-bottom:8px" onclick="location.href='movements.php?action=new'">+ Log Movement</button>
                <button class="btn orange" style="width:100%" onclick="location.href='invoices.php'">Pay Now</button>
            </aside>

            <main>
                <!-- KPIs -->
                <div class="card">
                    <div class="kpis">
                        <div class="kpi">
                            <div class="label">Active Units</div>
                            <div class="value"><?php echo count($activeAllocations); ?></div>
                        </div>
                        <div class="kpi">
                            <div class="label">Outstanding Balance</div>
                            <div class="value"><?php
                                                $totalBalance = array_sum(array_column($unpaidInvoices, 'balance'));
                                                echo formatMoney($totalBalance);
                                                ?></div>
                        </div>
                        <div class="kpi">
                            <div class="label">Open Invoices</div>
                            <div class="value"><?php echo count($unpaidInvoices); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Active Allocations -->
                <div class="card">
                    <div class="row">
                        <h2>My Active Storage</h2>
                        <button class="btn" onclick="location.href='storage.php'">View All</button>
                    </div>
                    <table>
                        <tr>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th>Billing</th>
                            <th>Rate</th>
                            <th>Status</th>
                        </tr>
                        <?php foreach ($activeAllocations as $alloc): ?>
                            <tr>
                                <td><b><?php echo htmlspecialchars($alloc['unit_code']); ?></b></td>
                                <td><?php echo ucfirst($alloc['unit_type']); ?></td>
                                <td><?php echo $alloc['start_date'] . ' → ' . $alloc['end_date']; ?></td>
                                <td><?php echo str_replace('_', ' ', $alloc['billing_type']); ?></td>
                                <td><?php echo formatMoney($alloc['rate']); ?></td>
                                <td><span class="badge b-green">Active</span></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($activeAllocations)): ?>
                            <tr>
                                <td colspan="6" class="muted">No active allocations</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>

                <!-- Recent Movements -->
                <div class="card">
                    <div class="row">
                        <h2>Recent Movements</h2>
                        <button class="btn" onclick="location.href='movements.php'">View All</button>
                    </div>
                    <table>
                        <tr>
                            <th>Date/Time</th>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>Reference</th>
                        </tr>
                        <?php foreach ($recentMovements as $movement): ?>
                            <tr>
                                <td><?php echo date('Y-m-d H:i', strtotime($movement['movement_date'])); ?></td>
                                <td><?php echo htmlspecialchars($movement['unit_code']); ?></td>
                                <td>
                                    <span class="badge <?php echo $movement['movement_type'] === 'inbound' ? 'b-green' : 'b-orange'; ?>">
                                        <?php echo ucfirst($movement['movement_type']); ?>
                                    </span>
                                </td>
                                <td><?php echo $movement['packages_in']; ?></td>
                                <td><?php echo $movement['packages_out']; ?></td>
                                <td><?php echo htmlspecialchars($movement['movement_no']); ?></td>
                            </tr>
                        <?php endforeach; ?>
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
    </script>
</body>

</html>