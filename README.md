# Aplicación para la cátedra de "Testing"

Este trabajo comprende un desarrollo tecnólogico en el framework de Lavarel que utiliza el lenguaje de programación PHP. 

El sistema cuenta con las siguientes funcionalidades:
- Registrar
- Login
- Dashboard con menú lateral
- ABMC de entidades relevantes del dominio

Para crear el sistema nos basamos en la [siguiente plantilla de infyom.](https://infyom.com/open-source/laravelgenerator/docs/8.0/boilerplates)

## Requisitos para realizar el deploy local
- PHP ^8.1
- Composer (gestor de paquetes de PHP)
- Herramienta Laragon/XAMPP

**_Observación:_** Laragon solamente funciona en Windows. 

## Guía para realizar el deploy local del proyecto
### Laragon
<b>Pasos a seguir para laragon:</b>
1. Clonar el proyecto en la carpeta /laragon/www
2. Abrir con un editor de texto el proyecto, quitarle el “.example” al archivo “env.example” y darle guardar. Se debe crear una **DB** y modificar el .env segun la configuración local
3. Iniciar los servicios de Laragon
4. Abrir la terminal de Laragon
5. Hacer cd a la carpeta que contiene el proyecto y ejecutar los siguientes comandos
6. Correr `composer install`
7. Correr `npm install`
8. Correr `php artisan key:generate`
9. Correr `php artisan migrate`
10. Para iniciar la aplicación correr `php artisan serve`

### XAMPP
<b>Pasos a seguir para xampp:</b>
1. Clonar el proyecto en la carpeta /laragon/www
2. Abrir con un editor de texto el proyecto, quitarle el “.example” al archivo “env.example” y darle guardar. Se debe crear una **DB** y modificar el .env segun la configuración local
3. Iniciar los servicios de Xampp
4. Abrir una terminal en la carpeta del proyecto y ejecutar los siguientes comandos
5. Correr `composer install`
6. Correr `npm install`
7. Correr `php artisan key:generate`
8. Correr `php artisan migrate`
9. Para iniciar la aplicación correr `php artisan serve`

