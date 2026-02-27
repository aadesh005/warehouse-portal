-- Create database
CREATE DATABASE IF NOT EXISTS rgsl_warehouse;
USE rgsl_warehouse;

-- Users table (for both admin and clients)
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

-- Clients table (detailed client information)
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

-- Units table
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
    row_area VARCHAR(50),
    bay_position VARCHAR(50),
    dimensions VARCHAR(100),
    offhire_reason VARCHAR(100),
    internal_label VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Client allocations
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

-- Invoices table
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
    balance DECIMAL(10,2) GENERATED ALWAYS AS (total - paid_amount) STORED,
    due_date DATE NOT NULL,
    status ENUM('paid', 'unpaid', 'overdue', 'cancelled') DEFAULT 'unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (allocation_id) REFERENCES allocations(id)
);

-- Invoice items
CREATE TABLE invoice_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    invoice_id INT NOT NULL,
    description TEXT NOT NULL,
    quantity INT DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
);

-- Payments table
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    receipt_no VARCHAR(50) UNIQUE NOT NULL,
    client_id INT NOT NULL,
    invoice_id INT,
    payment_date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash', 'bank_transfer', 'cheque', 'credit_card') NOT NULL,
    reference VARCHAR(255),
    notes TEXT,
    status ENUM('completed', 'pending', 'failed') DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);

-- Movements (Inbound/Outbound)
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

-- Documents
CREATE TABLE documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    document_type ENUM('trade_license', 'emirates_id', 'passport', 'visa', 'other') NOT NULL,
    document_name VARCHAR(255),
    file_path VARCHAR(500),
    status ENUM('valid', 'expiring', 'missing', 'expired') DEFAULT 'valid',
    expiry_date DATE,
    notes TEXT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- Notices (Legal)
CREATE TABLE notices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    notice_type ENUM('1st_notice', '2nd_notice', '3rd_notice', 'lba', 'final_notice') NOT NULL,
    sent_date DATE NOT NULL,
    due_date DATE,
    email_sent BOOLEAN DEFAULT FALSE,
    courier_proof VARCHAR(500),
    status ENUM('pending', 'sent', 'delivered', 'responded') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- Audit log
CREATE TABLE audit_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50),
    record_id INT,
    old_data JSON,
    new_data JSON,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert default admin
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@rgsl.com', '$2y$10$YourHashedPasswordHere', 'admin');

-- Insert sample units
INSERT INTO units (unit_code, unit_type, zone, location_label, size, daily_rate, monthly_rate, status) VALUES
('Shed-01', 'shed', 'Zone A', 'Row A1', NULL, 85.00, 2500.00, 'occupied'),
('Shed-09', 'shed', 'Zone A', 'Row A2', NULL, 85.00, 2500.00, 'partial'),
('CONT-07', 'container', 'Yard', 'Bay 7', '40FT', 120.00, 3200.00, 'occupied'),
('CONT-12', 'container', 'Yard', 'Bay 12', '40HC', 130.00, 3500.00, 'offhire');