-- DROP DATABASE hospital_system;
-- CREATE DATABASE IF NOT EXISTS hospital_system;
-- USE hospital_system;


CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('patient', 'doctor', 'admin', 'receptionist') NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS doctors (
    doctor_id INT PRIMARY KEY,
    specialization VARCHAR(255) NOT NULL,
    qualification TEXT,
    experience_years INT,
    bio TEXT,
    consultation_fee DECIMAL(10,2),
    rating DECIMAL(3,2) DEFAULT 0,
    total_reviews INT DEFAULT 0,
    is_available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (doctor_id) REFERENCES users(user_id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS patients (
    patient_id INT PRIMARY KEY,
    date_of_birth DATE,
    gender VARCHAR(20),
    blood_type VARCHAR(5),
    address TEXT,
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20),
    FOREIGN KEY (patient_id) REFERENCES users(user_id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason_for_visit TEXT,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS medical_records (
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    appointment_id INT,
    diagnosis TEXT,
    prescriptions TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE SET NULL
);


-- =========================
CREATE TABLE IF NOT EXISTS reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    rating INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE SET NULL,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE SET NULL
);



INSERT INTO users (username, email, password_hash, full_name, role)
VALUES ('admin', 'admin@hospital.com', 'admin_hash', 'System Admin', 'admin');

INSERT INTO users (username, email, password_hash, full_name, phone, role)
VALUES ('dr.abebe', 'dr.abebe@hospital.com', 'doctor_hash', 'Dr. Abebe', '+251911234567', 'doctor');

INSERT INTO doctors (doctor_id, specialization, qualification, experience_years, bio, consultation_fee, is_available)
VALUES (
    (SELECT user_id FROM users WHERE username = 'dr.abebe'),
    'Cardiology',
    'MD, Fellowship in Cardiology',
    12,
    'Experienced cardiologist.',
    1500.00,
    TRUE
);

INSERT INTO users (username, email, password_hash, full_name, phone, role)
VALUES ('sarah.jones', 'sarah.j@email.com', 'patient_hash', 'Sarah Jones', '+1234567890', 'patient');

INSERT INTO patients (patient_id, date_of_birth, gender, blood_type, emergency_contact_name, emergency_contact_phone)
VALUES (
    (SELECT user_id FROM users WHERE username = 'sarah.jones'),
    '1990-05-15',
    'Female',
    'O+',
    'Mike Jones',
    '+1234567891'
);


INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason_for_visit, status)
VALUES (
    (SELECT user_id FROM users WHERE username = 'sarah.jones'),
    (SELECT user_id FROM users WHERE username = 'dr.abebe'),
    DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY),
    '09:00:00',
    'Heart consultation for chronic fatigue and persistent headaches',
    'confirmed'
);



CREATE OR REPLACE VIEW today_appointments AS
SELECT 
    a.appointment_time,
    pu.full_name AS patient_name,
    du.full_name AS doctor_name,
    a.reason_for_visit,
    a.status
FROM appointments a
JOIN patients p ON a.patient_id = p.patient_id
JOIN users pu ON p.patient_id = pu.user_id
JOIN doctors d ON a.doctor_id = d.doctor_id
JOIN users du ON d.doctor_id = du.user_id
WHERE a.appointment_date = CURRENT_DATE
ORDER BY a.appointment_time;

CREATE OR REPLACE VIEW doctor_availability AS
SELECT 
    u.full_name AS doctor_name,
    d.specialization,
    d.consultation_fee,
    d.rating,
    d.is_available
FROM doctors d
JOIN users u ON d.doctor_id = u.user_id;


CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_appointments_date ON appointments(appointment_date);
CREATE INDEX idx_appointments_doctor ON appointments(doctor_id);
CREATE INDEX idx_appointments_patient ON appointments(patient_id);
CREATE INDEX idx_doctors_specialization ON doctors(specialization);