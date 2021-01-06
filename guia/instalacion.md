# Instrucciones de instalación y despliegue

## En local

- PHP 7.4.x
- PostgreSQL.
- Composer 1.1.1.
- Servidor Integrado PHP (localhost).
- Gmail. 


---
 **Pasos a seguir**
  
   1. Clonar el proyecto desde github https://github.com/97jorx/adventure.git
   2. Comando en la terminal **``cd``** adventure desde el directorio donde se ha   clonado.
   3. Escribir el comando **```composer update```**. Se generará la carpeta vendor.
      ```
      adventure/     # Directorio Root.
      |- vendor/      # Las extensiones por Composer se almacenan en el directorio vendor
      ```
   4.  Por ultimo ejecutar el servidor de php: **```php -S localhost:8080```** 
   5.  Ir al navegador y escribir la URL localhost:8080.
---    

## En la nube


- PHP 7.4.x
- PostgreSQL.
- Composer 1.1.1.
- Gmail. 
- Cuenta de Heroku. Heroku.com


---
 **Pasos a seguir**
  
   1. Una vez tengamos cuenta de Heroku realizar los siguientes pasos:
      ```sh
        heroku login # Loguearse en Heroku.
        heroku apps:create nombreAplicacion --region eu # Crear la aplicación en Heroku.
        heroku addons:create heroku-postgresql # Agregar el Addon de heroku-postgresql 
        heroku pg:psql < db/nombreBaseDeDatos.sql --app # Subir los cambios de SQL al Dyno de heroku.
        heroku pg:psql # Acceder al terminal interativo de PostgreSQL en el dyno de Heroku.
        create extension pgcrypto; # Crear la extension para encriptar contraseñas.
        heroku config:set SMTP_PASS=clave # Agregar las claves de entorno en heroku.
        git push -u heroku master  # Subir los cambios de la rama master de github a la rama de Heroku.
      ```
--- 