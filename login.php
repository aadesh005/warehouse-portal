<?php
// Start session
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/session.php';

$error = '';

// Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    
    if (empty($email) || empty($pass)) {
        $error = 'Please enter email and password';
    } else {
        // Simple query - direct password comparison
        $stmt = $pdo->prepare("SELECT * FROM users WHERE (email = ? OR username = ?) AND password = ?");
        $stmt->execute([$email, $email, $pass]);
        $user = $stmt->fetch();
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                // Get client data
                $clientStmt = $pdo->prepare("SELECT * FROM clients WHERE user_id = ?");
                $clientStmt->execute([$user['id']]);
                $client = $clientStmt->fetch();
                
                $_SESSION['client_id'] = $client['id'] ?? null;
                $_SESSION['client_code'] = $client['client_code'] ?? null;
                
                header('Location: client/dashboard.php');
            }
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}

// First time setup - check if users exist
$checkUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($checkUsers == 0) {
    // Create default users
    $pdo->exec("INSERT INTO users (username, email, password, role) VALUES 
                ('admin', 'admin@rgsl.com', 'admin123', 'admin'),
                ('client', 'client@example.com', 'client123', 'client')");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGSL - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
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
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-box {
            background: white;
            width: 100%;
            max-width: 400px;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            height: 60px;
            margin-bottom: 10px;
        }
        .logo h2 {
            color: var(--text);
            font-size: 24px;
        }
        .logo p {
            color: var(--muted);
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text);
            font-weight: 600;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
        }
        input:focus {
            border-color: var(--green);
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: var(--green);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #15803d;
            transform: translateY(-2px);
        }
        .error {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
        .info {
            background: #e6f3e6;
            color: var(--green);
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
        .info p {
            margin: 5px 0;
        }
        .info .admin { color: #f26a21; font-weight: bold; }
        .info .client { color: #1aa34a; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">
            <img src="https://royalgulfshipping.com/wp-content/uploads/2025/11/RGSL-LOGO.png" alt="RGSL Logo">
            <h2>Welcome Back</h2>
            <p>Sign in to your account</p>
        </div>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email or Username</label>
                <input type="text" name="email" placeholder="Enter your email or username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>

        <div class="info">
            <p><strong>Demo Credentials:</strong></p>
            <p class="admin">👑 Admin: admin@rgsl.com / admin123</p>
            <p class="client">👤 Client: client@example.com / client123</p>
            <p style="margin-top:10px; color:#666;">Simple password system - no encryption</p>
        </div>
    </div>
</body>
</html>