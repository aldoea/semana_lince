# Semana Lince App
### Control de registro de asistencia (backend)

## Requerimientos de Servidor

Se requiere un servidor con sistema operativo Linux, distribución Debian o Ubuntu (preferiblemente, ya que son las distribuciones con más soporte técnico y consideradas entre las mejores opciones para servidores actualmente).

El servidor deberá tener lo siguiente:
* Sistema gestor de base de datos MySQL o MariaDB
* Servidor web Apache con reescritura de URLs o URLs limpias (módulo mod_rewrite activo).
* PHP versión 5.5 o una versión más reciente.
* [Composer](https://getcomposer.org/download/)

Se requiere el SGBD MySQL/MariaDB, ya que será el encargado de almacenar toda la información que será administrada y gestionada por las diversas aplicaciones.

Se requiere el Servidor Apache para publicar (en caso de desarrollarse) el sitio web, así como los servicios web a desarrollarse.

Se requiere la reescritura de URLs o URLs limpias en el servidor Apache, PHP y Composer para la instalación y uso del micro framework de PHP Slim, el cual servirá para el desarrollo de los servicios web.

_Nota: Si se desea que el sitio web o los servicios web estén disponibles desde Internet, se requiere una dirección IP publica que este asignada al servidor, para así poder tener acceso a el desde fuera de la red._
