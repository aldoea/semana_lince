--
-- NOTA IMPORTANTE
-- Si algún valor tiene comillas o porcentajes no se las quites
-- Igual, si algún valor no tiene, déjalo así
--
-- Las fechas son en formato YYYY-MM-DD y las horas HH:MM:SS
-- DATETIME va combinando las dos: YYYY-MM-DD HH:MM:SS pero acepta sólo la fecha si es necesario
--
-- Si tienes algún valor en blanco, mete NULL sin comillas
--

-- A nombre_ponentes lo separas por comas e insertas cada uno reemplazando /nombre_ponente/
INSERT IGNORE INTO ponente (nombre) VALUES ('nombre_ponente');

-- Reemplazas /responsable/ para cada entrada
INSERT IGNORE INTO responsable (nombre) VALUES ('responsable');

-- Reemplazas /lugar/ para cada entrada
INSERT IGNORE INTO ubicacion (nombre) VALUES ('lugar');

-- De aquí en adelante reemplazas los campos según los nombres de las columnas del documento
-- En las subconsultas reemplazas el nombre dentro del '%%' después del LIKE
INSERT INTO actividad (id, nombre, duracion, material_ponente, material_participante,
                       descripcion, id_servicio, id_tipo, id_especialidad,
                       id_responsable, id_categoria)
VALUES (num_actividad, 'nombre_actividad', 'duracion',
                       'material_ponente', 'material_participante', 'descripcion',
                       -- --------------------------------------------------------
                       (SELECT servicio.id
                        FROM servicio
                        WHERE servicio.nombre LIKE '%servicio%'),
                       -- --------------------------------------------------------
                       (SELECT tipo.id
                        FROM tipo
                        WHERE tipo.nombre LIKE '%tipo%'),
                       -- --------------------------------------------------------
                       (SELECT especialidad.id
                        FROM especialidad
                        WHERE especialidad.nombre LIKE '%especialidad%'),
                       -- --------------------------------------------------------
                       (SELECT responsable.id
                        FROM responsable
                        WHERE responsable.nombre LIKE '%responsable%'),
                       -- --------------------------------------------------------
                       (SELECT categoria.id
                        FROM categoria
                        WHERE categoria.nombre LIKE '%categoria%'));

-- Separas cada ponente en nombre_ponentes si son varios y reemplazas nombre_ponente igual
INSERT INTO actividad_ponente (id_actividad, id_ponente)
VALUES (num_actividad, (SELECT ponente.id
                        FROM ponente
                        WHERE ponente.nombre LIKE '%nombre_ponente%'));

INSERT INTO horario (id_actividad, fecha_hora, id_ubicacion, capacidad)
VALUES (num_actividad, 'fecha',
        (SELECT ubicacion.id
         FROM ubicacion
         WHERE ubicacion.nombre LIKE '%lugar%'),
        capacidad);