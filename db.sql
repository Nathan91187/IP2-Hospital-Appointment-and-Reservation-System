
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
CREATE TABLE users (
    user_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role VARCHAR(50) CHECK (role IN ('patient', 'doctor', 'admin', 'receptionist')) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE doctors (
    doctor_id UUID PRIMARY KEY REFERENCES users(user_id) ON DELETE CASCADE,
    specialization VARCHAR(255) NOT NULL,
    qualification TEXT,
    experience_years INTEGER,
    bio TEXT,
    consultation_fee DECIMAL(10,2),
    rating DECIMAL(3,2) DEFAULT 0,
    total_reviews INTEGER DEFAULT 0,
    is_available BOOLEAN DEFAULT TRUE
);


CREATE TABLE patients (
    patient_id UUID PRIMARY KEY REFERENCES users(user_id) ON DELETE CASCADE,
    date_of_birth DATE,
    gender VARCHAR(20),
    blood_type VARCHAR(5),
    address TEXT,
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20)
);


CREATE TABLE appointments (
    appointment_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    patient_id UUID REFERENCES patients(patient_id) ON DELETE CASCADE,
    doctor_id UUID REFERENCES doctors(doctor_id) ON DELETE CASCADE,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason_for_visit TEXT,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE medical_records (
    record_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    patient_id UUID REFERENCES patients(patient_id) ON DELETE CASCADE,
    doctor_id UUID REFERENCES doctors(doctor_id) ON DELETE CASCADE,
    appointment_id UUID REFERENCES appointments(appointment_id),
    diagnosis TEXT,
    prescriptions TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reviews (
    review_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    patient_id UUID REFERENCES patients(patient_id),
    doctor_id UUID REFERENCES doctors(doctor_id),
    rating INTEGER CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (user_id, username, email, password_hash, full_name, role)
VALUES (uuid_generate_v4(), 'admin', 'admin@hospital.com', 'admin_hash', 'System Admin', 'admin');

INSERT INTO users (user_id, username, email, password_hash, full_name, phone, role)
VALUES (uuid_generate_v4(), 'dr.abebe', 'dr.abebe@hospital.com', 'doctor_hash', 'Dr. Abebe', '+251911234567', 'doctor');

INSERT INTO doctors (doctor_id, specialization, qualification, experience_years, bio, consultation_fee, is_available)
VALUES (
    (SELECT user_id FROM users WHERE username = 'dr.abebe'),
    'Cardiology',
    'MD, Fellowship in Cardiology',
    12,
    'Dr. Abebe is a consultant cardiologist with over 12 years of experience in diagnosing and treating heart conditions.',
    1500.00,
    TRUE
);

INSERT INTO users (user_id, username, email, password_hash, full_name, phone, role)
VALUES (uuid_generate_v4(), 'sarah.jones', 'sarah.j@email.com', 'patient_hash', 'Sarah Jones', '+1234567890', 'patient');

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
    CURRENT_DATE + INTERVAL '1 day',
    '09:00:00',
    'Heart consultation for chronic fatigue and persistent headaches',
    'confirmed'
);

CREATE OR REPLACE VIEW today_appointments AS
SELECT 
    a.appointment_time,
    u.full_name AS patient_name,
    d.full_name AS doctor_name,
    a.reason_for_visit,
    a.status
FROM appointments a
JOIN patients p ON a.patient_id = p.patient_id
JOIN users u ON p.patient_id = u.user_id
JOIN doctors doc ON a.doctor_id = doc.doctor_id
JOIN users d ON doc.doctor_id = d.user_id
WHERE a.appointment_date = CURRENT_DATE
ORDER BY a.appointment_time;

CREATE OR REPLACE VIEW doctor_availability AS
SELECT 
    u.full_name AS doctor_name,
    doc.specialization,
    doc.consultation_fee,
    doc.rating,
    doc.is_available
FROM doctors doc
JOIN users u ON doc.doctor_id = u.user_id;

CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_appointments_date ON appointments(appointment_date);
CREATE INDEX idx_appointments_doctor ON appointments(doctor_id);
CREATE INDEX idx_appointments_patient ON appointments(patient_id);
CREATE INDEX idx_doctors_specialization ON doctors(specialization);