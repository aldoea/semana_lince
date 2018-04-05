-- DROP DATABASE lince;
CREATE DATABASE IF NOT EXISTS lince
  CHARSET utf8mb4;
USE lince;

CREATE TABLE IF NOT EXISTS servicio (
  id     INT PRIMARY KEY AUTO_INCREMENT,
  nombre CHAR(15) NOT NULL
);

CREATE TABLE IF NOT EXISTS tipo (
  id     INT PRIMARY KEY AUTO_INCREMENT,
  nombre CHAR(15) NOT NULL
);

CREATE TABLE IF NOT EXISTS ubicacion (
  id     INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(64) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS responsable (
  id     INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(150) NOT NULL
);

CREATE TABLE IF NOT EXISTS categoria (
  id     INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS especialidad (
  id     INT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL
);

CREATE TABLE IF NOT EXISTS actividad (
  id                    BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre                VARCHAR(512) NOT NULL,
  duracion              TIME,
  material_ponente      VARCHAR(512),
  material_participante VARCHAR(512),
  descripcion           TEXT,
  id_servicio           INT,
  id_tipo               INT,
  id_especialidad       INT,
  id_responsable        INT,
  id_categoria          INT,
  FOREIGN KEY (id_servicio) REFERENCES servicio (id),
  FOREIGN KEY (id_tipo) REFERENCES tipo (id),
  FOREIGN KEY (id_especialidad) REFERENCES especialidad (id),
  FOREIGN KEY (id_responsable) REFERENCES responsable (id),
  FOREIGN KEY (id_categoria) REFERENCES categoria (id)
);

CREATE TABLE IF NOT EXISTS ponente (
  id     BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS actividad_ponente (
  id_actividad BIGINT NOT NULL,
  id_ponente   BIGINT NOT NULL,
  PRIMARY KEY (id_actividad, id_ponente),
  FOREIGN KEY (id_actividad) REFERENCES actividad (id),
  FOREIGN KEY (id_ponente) REFERENCES ponente (id)
);

CREATE TABLE IF NOT EXISTS horario (
  id           BIGINT NOT NULL  AUTO_INCREMENT,
  id_actividad BIGINT NOT NULL,
  fecha_hora   DATETIME,
  id_ubicacion INT,
  capacidad    INT    NOT NULL,
  PRIMARY KEY (id, id_actividad, fecha_hora),
  FOREIGN KEY (id_actividad) REFERENCES actividad (id),
  FOREIGN KEY (id_ubicacion) REFERENCES ubicacion (id)
);

CREATE TABLE IF NOT EXISTS alumno (
  id              BIGINT PRIMARY KEY AUTO_INCREMENT,
  nocontrol       CHAR(9)      NOT NULL UNIQUE,
  nombre          VARCHAR(150) NOT NULL,
  semestre        SMALLINT     NOT NULL,
  id_especialidad INT          NOT NULL,
  FOREIGN KEY (id_especialidad) REFERENCES especialidad (id)
);

CREATE TABLE IF NOT EXISTS registro (
  id_horario BIGINT NOT NULL,
  id_alumno  BIGINT NOT NULL,
  qr         CHAR(174) UNIQUE,
  asistencia BOOL   NOT NULL DEFAULT FALSE,
  PRIMARY KEY (id_horario, id_alumno),
  FOREIGN KEY (id_horario) REFERENCES horario (id),
  FOREIGN KEY (id_alumno) REFERENCES alumno (id)
);

DROP TRIGGER IF EXISTS registro_qr;
CREATE TRIGGER registro_qr
  BEFORE INSERT
  ON registro
  FOR EACH ROW
  BEGIN
    DECLARE nc VARCHAR(9);
    SELECT nocontrol
    INTO nc
    FROM alumno
    WHERE id = new.id_alumno;
    SET new.qr = to_base64(sha2(concat('$myl1ttl3p0ny$', nc, '|', new.id_horario, '$fr13ndsh1p15m4g1c$'), 512));
  END;

CREATE USER IF NOT EXISTS 'lincews'@'localhost'
  IDENTIFIED BY 'aghGQ$fdknpt#0rhmt457490dgfj45052nb3mg1q0r';
GRANT SELECT, INSERT, DELETE ON lince.registro TO 'lincews'@'localhost';
GRANT SELECT ON lince.actividad TO 'lincews'@'localhost';
GRANT SELECT ON lince.actividad_ponente TO 'lincews'@'localhost';
GRANT SELECT ON lince.alumno TO 'lincews'@'localhost';
GRANT SELECT ON lince.categoria TO 'lincews'@'localhost';
GRANT SELECT ON lince.especialidad TO 'lincews'@'localhost';
GRANT SELECT ON lince.horario TO 'lincews'@'localhost';
GRANT SELECT ON lince.ponente TO 'lincews'@'localhost';
GRANT SELECT ON lince.responsable TO 'lincews'@'localhost';
GRANT SELECT ON lince.servicio TO 'lincews'@'localhost';
GRANT SELECT ON lince.tipo TO 'lincews'@'localhost';
GRANT SELECT ON lince.ubicacion TO 'lincews'@'localhost';