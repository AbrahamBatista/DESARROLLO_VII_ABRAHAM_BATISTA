CREATE DATABASE techparts_db;
USE techparts_db;



CREATE TABLE productos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(120) NOT NULL,
  categoria VARCHAR(80) NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  cantidad INT NOT NULL,
  fecha_registro DATETIME DEFAULT NOW()
);



INSERT INTO productos (nombre, categoria, precio, cantidad) VALUES
('Laptop HP 15"', 'Computadoras', 899.99, 5),
('Mouse inalámbrico Logitech', 'Accesorios', 29.99, 10),
('Monitor Samsung 24"', 'Pantallas', 199.50, 3);