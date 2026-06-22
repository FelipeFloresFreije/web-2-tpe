
# TPE Parte 2 - Diario Digital

### Integrantes:
* Flores Freije Felipe (felipefloresfreije@gmail.com)
* Cremona Maximiliano (maxicremona7@gmail.com)

### Temática:
La temática del trabajo es un diario digital.

### Descripción:
Este proyecto consiste en un portal de noticias organizado por secciones. Cualquier usuario puede leer el contenido, pero solo el administrador puede gestionar (crear, editar y eliminar) las noticias y las secciones. Se utiliza una relación 1 a N donde cada noticia pertenece a una única sección específica.

### Entregables técnicos:
* El diagrama de entidad relación se encuentra adjunto en el archivo `tpe.pdf`.
* El archivo `tpe.sql` contiene el código necesario para generar la estructura de la base de datos (tablas `noticia`, `seccion` y `usuario`).

### Instrucciones de Despliegue:
1. Clonar el repositorio dentro de la carpeta `htdocs` de XAMPP (la subcarpeta debe llamarse obligatoriamente `web-2-tpe`).
2. Configurar los accesos del servidor MySQL en el archivo `config.php` si es necesario.
3. Al ingresar al sitio por primera vez desde el navegador (`http://localhost/web-2-tpe/`), la base de datos y sus tablas correspondientes se crearán y poblarán de forma automática (Autodeploy).

### Credenciales de Administración:
* **Usuario / Email:** webadmin
* **Contraseña:** admin