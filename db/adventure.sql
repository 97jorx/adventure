------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id          bigserial    PRIMARY KEY,
    user        varchar(25)  NOT NULL UNIQUE,
    nombre      varchar(255) NOT NULL,
    apellidos   varchar(255) NOT NULL,
    email       varchar(255) NOT NULL UNIQUE,
    rol         VARCHAR(30)  NOT NULL DEFAULT 'usuario',
    created_at  timestamp(0) NOT NULL DEFAULT current_timestamp,
    contrasena  varchar(255),
    auth_key    varchar(255),
    foto_perfil varchar(255),
    poblacion   varchar(255),
    provincia   varchar(255),
    localidad   varchar(255),
    conexion    varchar(255),
);