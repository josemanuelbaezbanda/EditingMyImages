# EditingMyImages
 API Rest para la edición de imagenes

Este documento describe los pasos necesarios para configurar y ejecutar la API REST desarrollada en Laravel 9.52.16.

Este proyecto utiliza PostgreSQL como base de datos, JWT para autenticación, y la biblioteca `Intervention Image` 
para la manipulación de imágenes.

-------------------------------------------------------------------
REQUISITOS PREVIOS
-------------------------------------------------------------------

1. **PHP**: Se requiere la versión 8.2.12 o superior.
2. **Composer**: El gestor de dependencias de PHP.
3. **PostgreSQL**: Base de datos.
4. **Extensiones PHP necesarias**:
    - `pdo_pgsql`
    - `openssl`
    - `pgsql`
    - `gd`
    - `fileinfo`
    - `curl`

-------------------------------------------------------------------
INSTALACIÓN DE PHP Y COMPOSER
-------------------------------------------------------------------

### Instalación de PHP en Windows:

1. Descarga PHP desde [php.net](https://www.php.net/downloads).
2. Descargar XAMPP desde [apachefriends.org](https://www.apachefriends.org/es/download.html).
2. Edita el archivo `php.ini` y habilita las siguientes extensiones (Puede encontrarlo desde la configuración de apache en la aplicación de XAMPP:
   ```ini
   extension=pdo_pgsql
   extension=openssl
   extension=pgsql
   extension=gd
   extension=fileinfo
   extension=curl

### Instalación de Composer en Windows:

    Descarga Composer desde getcomposer.org.
    Sigue las instrucciones de instalación.

-------------------------------------------------------------------
CONFIGURACIÓN DEL REPOSITORIO
-------------------------------------------------------------------

### Instalación de dependencías:

1. Instalar composer en la terminal del proyecto

    ##### `composer install`

2. Copiar el archivo `.env.example` y cambiarle el nombre a `.env`.

3. Editar el archivo `.env` para configurar la conexión a la base de datos con tus datos: 

    ```ini
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=EditingMyImages
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña

4. Generar la clave JWT:

`php artisan jwt:secret`

Generar la clave de aplicación:

`php artisan key:generate`

Editar el archivo `.env` para agregar la clave de aplicación generada:

    JWT_SECRET=key_generada


5. Inicia PosgreSQL y crea la base de datos

`CREATE DATABASE EditingMyImages;`

6. Ejecuta las migraciones para tener todas las tablas necesarias para la ejecución

`php artisan migrate`

-------------------------------------------------------------------
Iniciar la aplicación
-------------------------------------------------------------------
1. Para inicial la aplicación se debe ejecutar el siguiente comando: 

`php artisan serve`

Este comando iniciará la aplicación en el puerto `http://127.0.0.1:8000`.

-------------------------------------------------------------------
Documentación de endpoint
-------------------------------------------------------------------

Para probar los endpoints de la API, utiliza la colección Postman:

    El archivo de la colección EditingMyImages.postman_collection.json se encuentra en la carpeta public/docs/ del proyecto.
    Para importar este archivo en Postman:
        - Abre Postman.
        - Ve a File > Import.
        - Selecciona el archivo postman_collection.json.

-------------------------------------------------------------------
Comando Utiles
-------------------------------------------------------------------

Migrar la base de datos:

`php artisan migrate`

Revertir las migraciones:

`php artisan migrate:rollback`

Refrescar la base de datos (elimina las tablas y las vuelve a crear):

`php artisan migrate:refresh`

-------------------------------------------------------------------
Autoria
-------------------------------------------------------------------

Jose Manuel Baez Banda - Desarrollador principal.
