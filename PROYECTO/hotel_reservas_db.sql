CREATE DATABASE hotel_reservas_db;
USE hotel_reservas_db;

CREATE TABLE habitaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion TEXT,
    capacidad INT,
    precio DECIMAL(10,2)
);

CREATE TABLE reservas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    habitacion_id INT,
    nombre_cliente VARCHAR(120),
    fecha_entrada DATE,
    fecha_salida DATE,
    total DECIMAL(10,2),
    estado VARCHAR(20) DEFAULT 'Pagado',
    FOREIGN KEY (habitacion_id) REFERENCES habitaciones(id)
);

CREATE TABLE servicios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    precio DECIMAL(10,2)
);

CREATE TABLE reserva_servicios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reserva_id INT,
    servicio_id INT,
    FOREIGN KEY (reserva_id) REFERENCES reservas(id),
    FOREIGN KEY (servicio_id) REFERENCES servicios(id)
);