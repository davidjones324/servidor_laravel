Especificación Técnica del Sistema de Gestión de Prácticas del Alumnado (SGPA)
1. Objetivo del Sistema
El sistema permitirá gestionar la información relacionada con alumnos, empresas colaboradoras, tutores duales, coordinadores y acuerdos de prácticas.
Permitirá que los alumnos completen su ficha y que los profesores gestionen y supervisen el proceso de prácticas.

2. Tecnologías y Arquitectura
2.1. Framework y herramientas
Laravel 12

MySQL

Blade (vistas)

Tailwind CSS (estilos)

Laravel Breeze (autenticación y roles)

Seeders y Factories para datos de prueba

3. Infraestructura Docker
La aplicación se ejecutará en un entorno Docker para garantizar estabilidad, disponibilidad y facilidad de despliegue.

3.1. Contenedores obligatorios
Contenedor PHP-FPM
Ejecuta Laravel

Incluye Composer

Extensiones necesarias: pdo_mysql, mbstring, tokenizer, openssl, etc.

Contenedor MySQL
Motor de base de datos

Volumen persistente

Usuario, contraseña y base de datos configurados

Contenedor Servidor Web (Nginx)
Nginx es obligatorio porque:

Laravel no puede servir páginas por sí mismo

php-fpm no escucha en el puerto 80

sin Nginx la aplicación no sería accesible desde el navegador

garantiza estabilidad para alumnos y profesores

es el estándar en Laravel Sail y en producción

3.2. Contenedores no incluidos
No se incluirá phpMyAdmin salvo petición explícita.

4. Roles del Sistema
4.1. Alumno
Puede iniciar sesión

Puede ver su ficha personal

Puede ver sus acuerdos de prácticas

No puede editar datos ni acceder a información de otros alumnos

4.2. Profesor
Acceso completo al sistema

CRUD de alumnos, empresas, contactos, tutores duales, coordinadores y acuerdos

Importación de datos mediante CSV

5. Entidades y Campos
A continuación se detallan las entidades del sistema con sus campos, tipos y relaciones, en formato profesional y sin tablas.

5.1. Entidad: alumnos
Campo	Tipo
id	BIGINT PK
nombre	VARCHAR(100)
apellidos	VARCHAR(150)
fecha_nacimiento	DATE
curso	VARCHAR(20)
grupo	VARCHAR(20)
direccion	VARCHAR(255)
telefono	VARCHAR(20)
email	VARCHAR(150)
carnet_conducir	BOOLEAN
coche_propio	BOOLEAN
estudios_anteriores	TEXT
practicas_pasadas	VARCHAR(255)
apto_ffoe	BOOLEAN
motivo_exclusion	ENUM('no_prl','matricula_incompleta','otros')
residencia	VARCHAR(150)
user_id	BIGINT FK → users.id
created_at	TIMESTAMP
updated_at	TIMESTAMP
5.2. Entidad: empresas
Campo	Tipo
id	BIGINT PK
razon_social	VARCHAR(255)
cif	VARCHAR(20)
direccion	VARCHAR(255)
poblacion	VARCHAR(150)
email	VARCHAR(150)
observaciones	TEXT
campo_laboral	VARCHAR(150)
ciclos	SET('ASIR','SMR','DAM')
created_at	TIMESTAMP
updated_at	TIMESTAMP
5.3. Entidad: contactos_empresa
Campo	Tipo
id	BIGINT PK
empresa_id	BIGINT FK → empresas.id
dni	VARCHAR(20)
nombre	VARCHAR(100)
apellidos	VARCHAR(150)
correo	VARCHAR(150)
telefono	VARCHAR(20)
puesto	VARCHAR(100)
created_at	TIMESTAMP
updated_at	TIMESTAMP
5.4. Entidad: tutores_duales
Campo	Tipo
id	BIGINT PK
dni	VARCHAR(20)
nombre	VARCHAR(100)
apellidos	VARCHAR(150)
email	VARCHAR(150)
telefono	VARCHAR(20)
ciclo	ENUM('ASIR','SMR','DAM')
created_at	TIMESTAMP
updated_at	TIMESTAMP
5.5. Entidad: coordinadores
Campo	Tipo
id	BIGINT PK
dni	VARCHAR(20)
nombre	VARCHAR(100)
apellidos	VARCHAR(150)
email	VARCHAR(150)
telefono	VARCHAR(20)
created_at	TIMESTAMP
updated_at	TIMESTAMP
5.6. Entidad: acuerdos
Campo	Tipo
id	BIGINT PK
alumno_id	BIGINT FK → alumnos.id
empresa_id	BIGINT FK → empresas.id
tutor_dual_id	BIGINT FK → tutores_duales.id
coordinador_id	BIGINT FK → coordinadores.id
localidad	VARCHAR(150)
nombre_acuerdo	VARCHAR(255)
estado_convenio	ENUM('pendiente','realizado','firmado')
horario	TEXT
horas_totales	INT
grupo	VARCHAR(20)
curso	VARCHAR(20)
ano	YEAR
created_at	TIMESTAMP
updated_at	TIMESTAMP
6. Importación CSV
El sistema permitirá cargar datos mediante ficheros CSV para:

alumnos

tutores duales

coordinadores

empresas

Cada carga incluirá:

formulario de subida

validación

controlador dedicado

vista de errores

7. Seeders y Factories
Se crearán factories y seeders para:

alumnos

empresas

contactos

tutores duales

coordinadores

acuerdos

8. Seguridad
Autenticación mediante Laravel Breeze

Middleware auth

Middleware role:profesor y role:alumno

Protección CSRF

Validación de formularios