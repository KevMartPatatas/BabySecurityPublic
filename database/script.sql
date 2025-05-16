CREATE TABLE docentes (
    matricula VARCHAR(5) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Guardar el hash, no texto plano
    direccion TEXT NOT NULL,
    sexo CHAR(1) NOT NULL,
    telefono VARCHAR(15)
);


CREATE TABLE grupos (
    clave_grupo VARCHAR(5) PRIMARY KEY,
    matricula_docente VARCHAR(5),
    FOREIGN KEY (matricula_docente) REFERENCES docentes(matricula)
);


CREATE TABLE alumnos (
    no_control VARCHAR(5) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    sexo CHAR(1) NOT NULL,
    status VARCHAR(20) NOT NULL,
    tutor_nombre VARCHAR(50) NOT NULL,
    tutor_apellidos VARCHAR(100) NOT NULL,
    direccion TEXT NOT NULL,
    telefono_tutor VARCHAR(15),
    clave_grupo VARCHAR(5),
    FOREIGN KEY (clave_grupo) REFERENCES grupos(clave_grupo)
);


CREATE TABLE asistencias (
    id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
    no_control VARCHAR(5),
    fecha DATE NOT NULL,
    hora TIME,
    estado_asistencia ENUM('presente', 'ausente', 'retardo') NOT NULL,
    FOREIGN KEY (no_control) REFERENCES alumnos(no_control),
    UNIQUE(no_control, fecha) -- Para evitar duplicados en un mismo día
);


CREATE TABLE actividades (
    clave_actividad VARCHAR(5) PRIMARY KEY,
    nombre_actividad VARCHAR(100) NOT NULL
);


CREATE TABLE bitacora (
    clave_bitacora INT AUTO_INCREMENT PRIMARY KEY,
    clave_actividad VARCHAR(5),
    fecha DATE NOT NULL,
    FOREIGN KEY (clave_actividad) REFERENCES actividades(clave_actividad)
);


CREATE TABLE detalle_bitacora (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    clave_bitacora INT,
    no_control VARCHAR(5),
    observaciones TEXT,
    FOREIGN KEY (clave_bitacora) REFERENCES bitacora(clave_bitacora),
    FOREIGN KEY (no_control) REFERENCES alumnos(no_control)
);
