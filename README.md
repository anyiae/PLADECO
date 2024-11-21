PLADECO - Sistema de Gestión y Seguimiento

PLADECO es un sistema desarrollado para Praxis LTDA, una consultora de sociólogos, cuyo objetivo es facilitar la administración de Planes de Desarrollo Comunal (PLADECO) para las distintas comunas de Chile, actualmente, siendo la de Pedro Aguirre Cerda. Este sistema permite la gestión de tareas, seguimiento de avances, verificación de actividades, y notificaciones, todo ello adaptado a los diferentes roles de usuarios y administradores.

El sistema está diseñado con una estructura modular y funcional basada en la metodología Scrum, utilizando HTML, CSS, JavaScript, MySQL y PHP. Incluye funcionalidades como un dashboard para administradores, un sistema de verificación de tareas y la posibilidad de enviar notificaciones automáticas por correo electrónico.

Funcionalidades
Gestión de Tareas: Asignación de tareas a usuarios, seguimiento y verificación de tareas.
Dashboard de Administración: Gráficos interactivos y reportes descargables en Excel para el administrador.
Semáforo de Estado de Tareas: Visualización de tareas a través de un semáforo que muestra el estado basado en las fechas de inicio y fin.
Verificación de Tareas: Los usuarios pueden subir archivos y añadir comentarios como parte del proceso de verificación, que luego será revisado por el administrador.
Notificaciones por Correo: Envío automático de correos para asignación de tareas y actualizaciones de estado.
Manual de Usuario y Administrador: Guías completas disponibles para facilitar la navegación del sistema según el rol.

Instalación
Sigue estos pasos para instalar el proyecto en tu entorno local:
Clonar el repositorio:

git clone https://github.com/anyiae/PLADECO.git

Instalar dependencias con Composer:
Asegúrate de tener Composer instalado en tu máquina. Luego, desde la raíz del proyecto, ejecuta:
composer install

Configurar la base de datos:

Crea una base de datos llamada pladeco en MySQL.

Puedes crearla a través de PHPMyAdmin o usando la consola de MySQL con el siguiente comando:

sql
CREATE DATABASE pladeco;

Importar la base de datos:

Descarga el archivo pladeco.sql que se encuentra en el repositorio.
Importa el archivo SQL a tu base de datos pladeco. Si usas PHPMyAdmin, sigue estos pasos:
Inicia sesión en PHPMyAdmin.
Selecciona la base de datos pladeco.
Haz clic en la pestaña Importar.
Selecciona el archivo pladeco.sql y haz clic en Ejecutar.

Asegúrate de tener XAMPP o tu servidor PHP en ejecución. Coloca el proyecto en la carpeta htdocs de XAMPP o el directorio correspondiente en tu servidor web.

Acceder a la aplicación:

Abre tu navegador y accede a la siguiente URL:

http://localhost/PLADECO/pladeco

Manuales
Manual de Usuario: Guía detallada para los usuarios sobre cómo navegar y usar el sistema.
Manual de Administrador: Guía para administradores sobre cómo gestionar tareas, usuarios y reportes.
Acceso

El sistema cuenta con dos roles principales:
Administrador: Accede a funcionalidades completas de gestión, verificación de tareas, y generación de reportes.
Usuario: Puede visualizar las tareas asignadas, realizar verificaciones y enviar archivos de respaldo.

Para iniciar sesión, ingresa las credenciales proporcionadas para cada rol.

Tecnologías Utilizadas
Frontend: HTML, CSS, JavaScript (AdminLTE 3, Bootstrap 5)
Backend: PHP, Composer
Base de Datos: MySQL
Librerías: PHP Mailer, Chart.js, PHPExcel