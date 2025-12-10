CREATE DATABASE IF NOT EXISTS hotel_reservas_db;
USE hotel_reservas_db;



CREATE TABLE habitaciones (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(120) NOT NULL,
    descripcion TEXT,
    capacidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);



CREATE TABLE servicios (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(120) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);



CREATE TABLE reservas (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    habitacion_id INT NOT NULL,
    nombre_cliente VARCHAR(120) NOT NULL,
    email_cliente VARCHAR(120) NOT NULL,   
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'Confirmada',

    FOREIGN KEY (habitacion_id) REFERENCES habitaciones(id)
);



CREATE TABLE reserva_servicios (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    reserva_id INT NOT NULL,
    servicio_id INT NOT NULL,

    FOREIGN KEY (reserva_id) REFERENCES reservas(id) ON DELETE CASCADE,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE
);