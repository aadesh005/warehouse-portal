<?php
// Database configuration
$host = 'localhost';
$dbname = 'rgsl_warehouse';
$username = 'root';
$password = '';

echo "<h1>Database Connection Test</h1>";

// Test MySQL connection without database
try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✅ MySQL connection successful</p>";
} catch(PDOException $e) {
    echo "<p style='color:red'>❌ MySQL connection failed: " . $e->getMessage() . "</p>";
    exit();
}

// Check if database exists
$stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
if ($stmt->rowCount() > 0) {
    echo "<p style='color:green'>✅ Database '$dbname' exists</p>";
} else {
    echo "<p style='color:red'>❌ Database '$dbname' does not exist</p>";
    echo "<p>Creating database... </p>";
    $pdo->exec("CREATE DATABASE $dbname");
    echo "<p style='color:green'>✅ Database created</p>";
}

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✅ Connected to database '$dbname'</p>";
} catch(PDOException $e) {
    echo "<p style='color:red'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    exit();
}

// Check if users table exists
$stmt = $pdo->query("SHOW TABLES LIKE 'users'");
if ($stmt->rowCount() > 0) {
    echo "<p style='color:green'>✅ Users table exists</p>";
    
    // Check if there are any users
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $stmt->fetch()['count'];
    echo "<p>📊 Total users in database: $count</p>";
    
    if ($count == 0) {
        echo "<p style='color:orange'>⚠️ No users found. Creating default admin user...</p>";
        
        // Create default admin
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@rgsl.com', $hashedPassword, 'admin']);
        
        // Create default client
        $hashedPassword2 = password_hash('client123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['client', 'client@example.com', $hashedPassword2, 'client']);
        
        echo "<p style='color:green'>✅ Default users created:</p>";
        echo "<ul>";
        echo "<li>Admin: admin@rgsl.com / admin123</li>";
        echo "<li>Client: client@example.com / client123</li>";
        echo "</ul>";
    } else {
        // Show users
        $stmt = $pdo->query("SELECT id, username, email, role FROM users");
        $users = $stmt->fetchAll();
        echo "<h3>Current Users:</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['id'] . "</td>";
            echo "<td>" . $user['username'] . "</td>";
            echo "<td>" . $user['email'] . "</td>";
            echo "<td>" . $user['role'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p style='color:red'>❌ Users table does not exist</p>";
    echo "<p>Creating tables... </p>";
    
    // Create tables
    $sql = "
    CREATE TABLE users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'client') DEFAULT 'client',
        status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
    
    CREATE TABLE clients (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNIQUE,
        client_code VARCHAR(20) UNIQUE NOT NULL,
        client_type ENUM('business', 'personal') DEFAULT 'business',
        company_name VARCHAR(255),
        full_name VARCHAR(255),
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20),
        address TEXT,
        trn VARCHAR(50),
        billing_preference ENUM('daily', 'weekly', 'monthly', 'advance_3', 'advance_6') DEFAULT 'monthly',
        primary_contact_name VARCHAR(255),
        primary_contact_role VARCHAR(100),
        alt_contact VARCHAR(255),
        internal_notes TEXT,
        status ENUM('active', 'hold', 'overdue', 'legal', 'closed') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );
    
    CREATE TABLE units (
        id INT PRIMARY KEY AUTO_INCREMENT,
        unit_code VARCHAR(20) UNIQUE NOT NULL,
        unit_type ENUM('shed', 'container') NOT NULL,
        zone VARCHAR(50),
        location_label VARCHAR(100),
        size VARCHAR(20),
        status ENUM('available', 'occupied', 'partial', 'expiring', 'hold', 'offhire') DEFAULT 'available',
        daily_rate DECIMAL(10,2),
        monthly_rate DECIMAL(10,2),
        can_share BOOLEAN DEFAULT FALSE,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    
    CREATE TABLE allocations (
        id INT PRIMARY KEY AUTO_INCREMENT,
        client_id INT NOT NULL,
        unit_id INT NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL,
        billing_type ENUM('daily', 'weekly', 'monthly', 'advance_3', 'advance_6') NOT NULL,
        rate DECIMAL(10,2) NOT NULL,
        is_shared BOOLEAN DEFAULT FALSE,
        status ENUM('active', 'ended', 'cancelled') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (client_id) REFERENCES clients(id),
        FOREIGN KEY (unit_id) REFERENCES units(id)
    );
    
    CREATE TABLE invoices (
        id INT PRIMARY KEY AUTO_INCREMENT,
        invoice_no VARCHAR(50) UNIQUE NOT NULL,
        client_id INT NOT NULL,
        allocation_id INT,
        period_start DATE NOT NULL,
        period_end DATE NOT NULL,
        subtotal DECIMAL(10,2) NOT NULL,
        vat_rate DECIMAL(5,2) DEFAULT 5.00,
        vat_amount DECIMAL(10,2) NOT NULL,
        total DECIMAL(10,2) NOT NULL,
        paid_amount DECIMAL(10,2) DEFAULT 0,
        due_date DATE NOT NULL,
        status ENUM('paid', 'unpaid', 'overdue', 'cancelled') DEFAULT 'unpaid',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (client_id) REFERENCES clients(id),
        FOREIGN KEY (allocation_id) REFERENCES allocations(id)
    );
    
    CREATE TABLE movements (
        id INT PRIMARY KEY AUTO_INCREMENT,
        movement_no VARCHAR(50) UNIQUE NOT NULL,
        client_id INT NOT NULL,
        unit_id INT NOT NULL,
        allocation_id INT,
        movement_type ENUM('inbound', 'outbound') NOT NULL,
        packages_in INT DEFAULT 0,
        packages_out INT DEFAULT 0,
        movement_date DATETIME NOT NULL,
        reference VARCHAR(100),
        notes TEXT,
        logged_by VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (client_id) REFERENCES clients(id),
        FOREIGN KEY (unit_id) REFERENCES units(id),
        FOREIGN KEY (allocation_id) REFERENCES allocations(id)
    );
    ";
    
    try {
        $pdo->exec($sql);
        echo "<p style='color:green'>✅ All tables created successfully</p>";
        
        // Insert sample units
        $sampleUnits = "
        INSERT INTO units (unit_code, unit_type, zone, location_label, size, daily_rate, monthly_rate, status) VALUES
        ('Shed-01', 'shed', 'Zone A', 'Row A1', NULL, 85.00, 2500.00, 'occupied'),
        ('Shed-09', 'shed', 'Zone A', 'Row A2', NULL, 85.00, 2500.00, 'partial'),
        ('CONT-07', 'container', 'Yard', 'Bay 7', '40FT', 120.00, 3200.00, 'occupied'),
        ('CONT-12', 'container', 'Yard', 'Bay 12', '40HC', 130.00, 3500.00, 'offhire');
        ";
        $pdo->exec($sampleUnits);
        echo "<p style='color:green'>✅ Sample units inserted</p>";
        
        // Create default admin
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@rgsl.com', $hashedPassword, 'admin']);
        
        // Create default client
        $hashedPassword2 = password_hash('client123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['client', 'client@example.com', $hashedPassword2, 'client']);
        
        echo "<p style='color:green'>✅ Default users created:</p>";
        echo "<ul>";
        echo "<li>Admin: admin@rgsl.com / admin123</li>";
        echo "<li>Client: client@example.com / client123</li>";
        echo "</ul>";
        
    } catch(PDOException $e) {
        echo "<p style='color:red'>❌ Error creating tables: " . $e->getMessage() . "</p>";
    }
}

echo "<hr>";
echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li><a href='login.php'>Go to Login Page</a></li>";
echo "<li>Try logging in with admin@rgsl.com / admin123</li>";
echo "<li>Try logging in with client@example.com / client123</li>";
echo "</ol>";
?>