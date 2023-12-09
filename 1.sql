-- Tạo database db_plane
CREATE DATABASE IF NOT EXISTS db_plane;

-- Sử dụng database db_plane
USE db_plane;

-- Tạo bảng airlines
CREATE TABLE IF NOT EXISTS airlines (
    airline_id INT AUTO_INCREMENT PRIMARY KEY,
    airline_name VARCHAR(255) NOT NULL
);

-- Chèn dữ liệu vào bảng airlines
INSERT INTO airlines (airline_name) VALUES
    ('Vietnam Airlines'),
    ('Vietjet Air'),
    ('Bamboo Airways');

-- Tạo bảng flights
CREATE TABLE IF NOT EXISTS flights (
    flight_id INT AUTO_INCREMENT PRIMARY KEY,
    flight_number VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    total_passengers INT,
    description TEXT,
    airline_id INT,
    FOREIGN KEY (airline_id) REFERENCES airlines(airline_id)
);
