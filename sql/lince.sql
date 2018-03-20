/**
ACTIVIDADES
  - nombre
  - servicio (interno, externo)
  - tipo (taller, conferencia, curso, actividad)
  - ponente
  - departamento/empresa responsable
  - material necesario (ponente)
  - material necesario (participante)
  - duracion
  - categoria (academia, empresas, arte y cultura, deportiva, desarrollo personal)
  - descripción

PONENTES
  - nombre
  - RFC u otro identificador único

ALUMNOS
  - nocontrol
  - nombre
  - id de especialidad
  
HORARIOS
  - taller
  - fecha y hora
  - ubicacion
  - capacidad

RESPONSABLES
  - clave
  - nombre

ESPECIALIDADES
  - clave / id
  - nombre
 */

CREATE DATABASE lince;

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
  nombre VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS responsable (
  id     INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(150) NOT NULL
);

CREATE TABLE IF NOT EXISTS categoria (
  id     INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS actividad (
  id                    BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre                VARCHAR(255) NOT NULL,
  duracion              TIME         NOT NULL,
  material_ponente      TINYTEXT,
  material_participante TINYTEXT,
  descripcion           TEXT,
  id_servicio           INT          NOT NULL REFERENCES servicio (id),
  id_tipo               INT          NOT NULL REFERENCES tipo (id),
  id_responsable        INT          NOT NULL REFERENCES responsable (id),
  id_categoria          INT          NOT NULL REFERENCES categoria (id),
  FOREIGN KEY (id_servicio) REFERENCES servicio (id),
  FOREIGN KEY (id_tipo) REFERENCES tipo (id),
  FOREIGN KEY (id_responsable) REFERENCES responsable (id),
  FOREIGN KEY (id_categoria) REFERENCES categoria (id)
);

CREATE TABLE IF NOT EXISTS ponente (
  id     BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(150) NOT NULL,
  rfc    CHAR(13)     NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS actividad_ponente (
  id_actividad BIGINT NOT NULL,
  id_ponente   BIGINT NOT NULL,
  PRIMARY KEY (id_actividad, id_ponente),
  FOREIGN KEY (id_actividad) REFERENCES actividad (id),
  FOREIGN KEY (id_ponente) REFERENCES ponente (id)
);

CREATE TABLE IF NOT EXISTS horario (
  id           BIGINT   NOT NULL AUTO_INCREMENT,
  id_actividad BIGINT   NOT NULL,
  fecha_hora   DATETIME NOT NULL UNIQUE,
  id_ubicacion INT      NOT NULL,
  capacidad    INT      NOT NULL,
  PRIMARY KEY (id, id_actividad, fecha_hora),
  FOREIGN KEY (id_actividad) REFERENCES actividad (id),
  FOREIGN KEY (id_ubicacion) REFERENCES ubicacion (id)
);

CREATE TABLE IF NOT EXISTS especialidad (
  id              INT PRIMARY KEY,
  nombre          VARCHAR(150) NOT NULL,
  id_departamento INT          NULL,
  FOREIGN KEY (id_departamento) REFERENCES responsable (id)
);

CREATE TABLE IF NOT EXISTS alumno (
  id              BIGINT PRIMARY KEY,
  nocontrol       CHAR(9)      NOT NULL UNIQUE,
  nombre          VARCHAR(150) NOT NULL,
  id_especialidad INT          NOT NULL,
  FOREIGN KEY (id_especialidad) REFERENCES especialidad (id)
);

CREATE TABLE IF NOT EXISTS registro (
  id_horario BIGINT REFERENCES horario (id),
  id_alumno  BIGINT REFERENCES alumno (id),
  qr         VARCHAR(255) NOT NULL UNIQUE,
  asistencia BOOL         NOT NULL DEFAULT FALSE,
  PRIMARY KEY (id_horario, id_alumno),
  FOREIGN KEY (id_horario) REFERENCES horario (id),
  FOREIGN KEY (id_alumno) REFERENCES alumno (id)
);

CREATE USER 'linceapp'@'localhost'
  IDENTIFIED BY 'aghGQ$fdknpt#0rhmt457490dgfj45052nb3mg1q0r';
GRANT ALL PRIVILEGES ON lince.* TO 'linceapp'@'localhost';