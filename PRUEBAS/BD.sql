CREATE DATABASE Pruebas;
USE Pruebas;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    edad INT,
    email VARCHAR(100),
    telefono VARCHAR(20)
);