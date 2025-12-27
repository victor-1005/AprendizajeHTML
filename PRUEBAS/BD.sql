CREATE DATABASE Pruebas;
USE Pruebas;
-- ========
-- TABLA USUARIO
-- ======== 
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    edad INT,
    email VARCHAR(100),
    telefono VARCHAR(20)
);
-- ========
-- TABLA ROL
-- ======== 
CREATE TABLE rol(
  idRol INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  contra VARCHAR(250) NOT NULL,
  rol ENUM('administrador','consumidor') NOT NULL DEFAULT 'consumidor',
  idUsuario INT NOT NULL,
  CONSTRAINT fk_Rol_Usuaio FOREIGN  KEY (idUsuario)
  REFERENCES usuarios(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE 
);
-- ========
-- TABLA Vehiculo 
-- ======== 
CREATE TABLE vehiculo(
  idVehiculo INT AUTO_INCREMENT PRIMARY KEY,
  marca VARCHAR(50) NOT NULL,
  modelo VARCHAR(50) NOT NULL,
  tipo VARCHAR(50) NOT NULL,
  anio INT NOT NULL,
  matricula VARCHAR(20) NOT NULL UNIQUE,
  idUsuario INT NOT NULL,
  CONSTRAINT fk_Vehiculo_Usuario FOREIGN  KEY (idUsuario)
  REFERENCES usuarios(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE 
);
-- ============================
--  TABLA PRESTACIONES
-- ============================
CREATE TABLE prestaciones (
    idPrestaciones INT AUTO_INCREMENT PRIMARY KEY,
    nombrePrestacion VARCHAR(100) NOT NULL,
    descripcion VARCHAR(100) NOT NULL,
    costo DECIMAL(10,2) NOT NULL
);
-- ======
-- TABLA TAREA
-- ======
CREATE TABLE tarea(
  idServicio int AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(250) NOT NULL,
  precio FLOAT NOT NULL,
  fecha DATE NOT NULL,
  estado ENUM('pendiente','en proceso','finalizada','cancelada') DEFAULT 'pendiente',
  idPrestaciones int NOT NULL,
  idVehiculo int NOT NULL,
  -- Cascada para cuando se elimine una prestación
  CONSTRAINT fk_tarea_prestaciones FOREIGN KEY (idPrestaciones)
  REFERENCES prestaciones(idPrestaciones),
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  -- Cascada para cuando se elimine un vehículo (y por ende un usuario)
  CONSTRAINT fk_tarea_vehiculo FOREIGN KEY (idVehiculo)
  REFERENCES vehiculo(idVehiculo)
  ON DELETE CASCADE
  ON UPDATE CASCADE 
);

/*
INSERSION DE PRIMEROS DATOS DE LA TABLA PRESTACIONES
*/
insert into prestaciones (nombrePrestacion,descripcion,costo)
values ("Cambio de aceite","Se cambia el aceite, filtro de aceite etc.",35);
INSERT INTO prestaciones (nombrePrestacion, descripcion, costo) 
values('Cambio de Bujias','Se cambia las bujias y se limpian los contenedores',20);
