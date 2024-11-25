
# Sistema de Gestión PRAXIS LTDA

PLADECO es un sistema desarrollado para Praxis LTDA, una consultora de sociólogos, cuyo objetivo es facilitar la administración de Planes de Desarrollo Comunal (PLADECO) para las distintas comunas de Chile, actualmente, siendo la de Pedro Aguirre Cerda. Este sistema permite la gestión de tareas, seguimiento de avances, verificación de actividades, y notificaciones, todo ello adaptado a los diferentes roles de usuarios y administradores.


## ¿Que incluye?

- Registro e inicio de sesión con roles diferenciados.
- Sistema de tareas: Agregar tareas a usuarios, verificar tareas, corregirlas.
- Gestión de Lineamientos e Iniciativas.
- Dashboard de reportes gráficos descargables en Excel..
- Envío de verificación de tareas por parte de los usuarios.


## Autores

- [Antonia Galaz](https://www.github.com/anyiae)


## Instalación

Para instalar el proyecto, primero descargaremos la base de datos llamada `pladeco.sql` e importarla a MySQL PHPMyAdmin. Seleccionaremos la opción "Nueva" en la barra lateral izquierda, e importaremos la base de datos.

##
Luego, iremos a Visual Studio Code y clonaremos el proyecto dentro de la carpeta htdocs de la carpeta donde está instalado XAMPP, creando una carpeta llamada `PLADECO`. No se puede cambiar el nombre, para asegurar el funcionamiento de las funcionalidades.

```bash
git clone https://github.com/anyiae/PLADECO.git
```
##
Ahora, instalaremos las dependencias, la cual están en Composer. Este se descargará desde su página oficial.

```bash
https://getcomposer.org/
```
Luego de descargarlo e instalarlo en su pc, podrá utilizar la página.
##

Ahora, podremos usar el link en el navegador, lo cual nos redireccionará a la página principal.
```bash
http://localhost/pladeco/pladeco/
```
Con esto, estará lista nuestra sesión.



## Credenciales



| Tipo | Correo     | Contraseña              |
| :-------- | :------- | :------------------------- |
| `usuario` | `usuario@admin.cl` | 123 |




| Tipo | Correo     | Contraseña                       |
| :-------- | :------- | :-------------------------------- |
| `administrador`      | `admin@admin.cl` | 123 |



## 👩‍💻 Tecnologías utilizadas

| ![JavaScript](https://shields.io/badge/JavaScript-F7DF1E?logo=JavaScript&logoColor=000&style=flat-square) | ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white) | ![PHP](https://shields.io/badge/-PHP-777BB4?style=flat-square&logo=php&logoColor=white) | ![HTML](https://shields.io/badge/HTML-f06529?logo=html5&logoColor=white&style=flat-square) |
|:-------------------------------------------------------------------------------------------------------:|:-------------------------------------------------------------------------------------------:|:-------------------------------------------------------------------------------------:|:--------------------------------------------------------------------------------------:|
