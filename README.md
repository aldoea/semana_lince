# Semana Lince App
### Control de registro de asistencia (backend) :+1: :metal: :octocat:

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

## Paquetería

**Instalar Apache**

`sudo apt-get install apache2`

Habilitar `mod_rewrite`

`sudo a2enmod rewrite`

---
**Instalar MySQL 5.7**

*Es necesario configurar el repositorio para obtener la última versión. [Ver cómo (inglés).](https://dev.mysql.com/doc/mysql-apt-repo-quick-guide/en/)*

`sudo apt-get install mysql-client mysql-server libmysqlclient-dev mysql-connector-python`

---
**Instalar PHP y Composer** *(Versión 7.2 o superior)*

Añadir el siguiente [repositorio](https://launchpad.net/~ondrej/+archive/ubuntu/php):

```
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

Instalar PHP y algunas dependencias:

`sudo apt-get install php7.2 php7.2-mysql php7.2-dev php7.2-zip php7.2-bcmath php7.2-mbstring`

[Instalar Composer](https://getcomposer.org/download/) (Los comandos pueden variar):
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
Mover `composer.phar` a `/usr/bin` (por conveniencia):

`sudo mv composer.phar /usr/bin/composer`

## API ENDPOINTS:

El nombre de dominio es: ``api.semanalince.itcelaya.edu.mx``
Ejemplo: api.semanalince.itcelaya.edu.mx/v1/login

### Autenticación:

`POST /v1/login`

Ejemplo request body:
```JSON
{  
	"no_control": "14030557"
}
```

#### Returns:
```JSON
{  
	"data":{
		"id":1,
		"nocontrol":14030557,
		"nombre":"Benito Juarez",
		"id_especialidad":1
	},
	"message": "¡Bienvenido!",
	"token": "SUPER-SECRET-TOKEN",
    "token_expiration": ...
}
```

Campo requerido: `no_control`

El token retornado debe usarse para cualquier otro request con el header `Authorization` de HTTP (Bearer token)

### Lista de Actividades:
_Las actividades deben de ser filtradas por id_especialidad donde excluyan las que correspondan al id_espcialidad del alumno_

`GET /v1/actividad/especialidad/:id_especialidad`

#### Returns:
```JSON
{  
	"actividades":[{
			"id": 1,
			"id_tipo" : 1,
			"tipo" : "Algo",
			"nombre": "Como cortar tu computadora",			
			"material_participante": "Computadora, tijeras",
			"descripcion":"lorem...",
			"horarios": [
				{
					"id_horario":1,
					"fecha": "2018-03-15",
					"hora_inicio": "10:00:00",
					"hora_final": "12:00:00",
                    "lugar":"LCA"
				},
				{
					"id_horario":2,
					"fecha": "2018-03-14",
					"hora_inicio": "10:00:00",
					"hora_final": "12:00:00",
                    "lugar":"LCA"
				}
			],		
			"id_responsable":1,
			"nombre_responsable": "Francisco Ramos",
			"id_categoria":1,
			"categoria": "Academica",
			"imagen":"image/path.jpg"
		},{
			"id": 2,
			"nombre": "Capturando ondas gravitatorias con un limon",			
			"material_participante": "Acelerador de particulas, resilto 5000, Plutonio A15",
			"descripcion":"lorem...",
			"horarios": [
				{
					"id_horario":5,
					"fecha": "2018-03-15",
					"hora_inicio": "10:00:00",
					"hora_final": "12:00:00",
					"lugar":"Campo de futbol"
                },				
			],
			"id_responsable":1,
			"nombre_responsable": "Stephen Hawkings",
			"id_categoria":1,
			"categoria": "Academica",
			"imagen":"image/path.jpg"
		}
		],
	"num_actividades":2
}
```


### Todas las actividades agrupadas por categoria
_Todas las actividades son filtradas por especialidad y agrupadas por su categoria_
_Si no se tiene el id de especialidad mandar 0_

Autenticado:
`GET /v1/actividad/especialidad/:id_especialidad/categoria`
Sin autenticar:
`GET /v1/actividad/especialidad/0/categoria`

#### Returns:

```json
[
    {
        "nombre": "Academia",
        "actividades": [
            {
                "id": "2",
                "id_tipo": "1",
                "tipo": "Taller",
                "nombre": "Capturando ondas gravitatorias con un limon",
                "material_participante": "Acelerador de particulas, resilto 5000, Plutonio A15",
                "descripcion": "lorem...",
                "id_responsable": "1",
                "nombre_responsable": "Responsable 1",
                "id_categoria": "1",
                "categoria": "Academia",
                "horarios": [
                    {
                        "id_horario": "2",
                        "fecha": "2018-03-15",
                        "hora_inicio": "09:00:00",
                        "hora_final": "10:00:00",
                        "lugar": "Ubicacion1"
                    }
				],
				"imagen":"image/path.jpg"
            },
            {
                "id": "3",
                "id_tipo": "1",
                "tipo": "Taller",
                "nombre": "Actividad ejemplo",
                "material_participante": "Material ejemplo",
                "descripcion": "lorem...",
                "id_responsable": "1",
                "nombre_responsable": "Responsable 1",
                "id_categoria": "1",
                "categoria": "Academia",
                "horarios": [
                    {
                        "id_horario": "3",
                        "fecha": "2018-03-15",
                        "hora_inicio": "12:00:00",
                        "hora_final": "14:00:00",
                        "lugar": "Ubicacion1"
                    }
				],
				"imagen":"image/path.jpg"
            },
            {
                "id": "4",
                "id_tipo": "1",
                "tipo": "Taller",
                "nombre": "Como cocinar un pastel",
                "material_participante": "Harina y huevos",
                "descripcion": "lorem...",
                "id_responsable": "1",
                "nombre_responsable": "Responsable 1",
                "id_categoria": "1",
                "categoria": "Academia",
                "horarios": [
                    {
                        "id_horario": "4",
                        "fecha": "2018-03-15",
                        "hora_inicio": "09:00:00",
                        "hora_final": "11:00:00",
                        "lugar": "Ubicacion1"
                    }
				],
				"imagen":"image/path.jpg"
            }
        ]
    },
    {
        "nombre": "Empresas",
        "actividades": [
            {
                "id": "1",
                "id_tipo": "1",
                "tipo": "Taller",
                "nombre": "Como cortar tu computadora",
                "material_participante": "Computadora, tijeras",
                "descripcion": "lorem..",
                "id_responsable": "1",
                "nombre_responsable": "Responsable 1",
                "id_categoria": "2",
                "categoria": "Empresas",
                "horarios": [
                    {
                        "id_horario": "1",
                        "fecha": "2018-03-15",
                        "hora_inicio": "10:00:00",
                        "hora_final": "12:00:00",
                        "lugar": "Ubicacion1"
                    }
				],
				"imagen":"image/path.jpg"
            }
        ]
    }
]
```

_Las actividades deben de ser filtradas por id_categoria_

-No debe requerir un token para consumirse

### Actividades por una sola categoria

`GET /v1/actividad/categoria/:id_categoria`

#### Returns:
```JSON
{  
	"actividades":[{
			"id": 1,
			"id_tipo" : 1,
			"tipo" : "Algo",
			"nombre": "Como cortar tu computadora",			
			"material_participante": "Computadora, tijeras",
			"descripcion":"lorem...",
			"horarios": [
				{
					"id_horario":1,
					"fecha": "2018-03-15",
					"hora_inicio": "10:00:00",
					"hora_final": "12:00:00",
                    "lugar":"LCA",
				},
				{
					"id_horario":2,
					"fecha": "2018-03-14",
					"hora_inicio": "10:00:00",
					"hora_final": "12:00:00",
                    "lugar":"LCA"
				}
			],		
			"id_responsable":1,
			"nombre_responsable": "Francisco Ramos",
			"id_categoria":1,
			"categoria": "Academica",
			"imagen":"image/path.jpg"
		},{
			"id": 2,
			"nombre": "Capturando ondas gravitatorias con un limon",			
			"material_participante": "Acelerador de particulas, resilto 5000, Plutonio A15",
			"descripcion":"lorem...",
			"lugar":"Campo de futbol",
			"horarios": [
				{
					"id_horario":5,
					"fecha": "2018-03-15",
					"hora_inicio": "10:00:00",
					"hora_final": "12:00:00",
                    "lugar":"LCA"
				},				
			],
			"id_responsable":1,
			"nombre_responsable": "Stephen Hawkings",
			"id_categoria":1,
			"categoria": "Academica",
			"imagen":"image/path.jpg"
		}
		],
	"num_actividades":2
}
```

### Una sola Actividad:
`GET /v1/actividad/:id_actividad`

#### Returns:
```JSON
{  
	"actividad":{
		"id": 1,
		"id_tipo" : 1,
		"tipo" : "Algo",
		"nombre": "Como cortar tu computadora",		
		"material_participante": "Computadora, tijeras",
		"descripcion":"lorem...",
        "horarios": [
			{
				"id_horario":1,
				"fecha": "2018-03-15",
				"hora_inicio": "10:00:00",
				"hora_final": "12:00:00",
                "lugar":"LCA"
			}
		],		
		"id_responsable":1,
		"nombre_responsable": "Francisco Ramos",
		"id_categoria":1,
		"categoria": "Academica",
		"imagen":"image/path.jpg"
	}
}
```

### Actividades inscritas de alumno:

`GET /v1/actividad/alumno/:nocontrol`

#### Returns:
```JSON
{  
	"actividades":[{
			"id": 1,
			"nombre": "Como cortar tu computadora",			
			"material_participante": "Computadora, tijeras",
			"descripcion":"lorem...",
			"lugar":"LCA",
			"id_horario":1,
			"fecha": "2018-03-15",
			"hora_inicio": "10:00:00",
			"hora_final": "12:00:00",
			"id_responsable":1,
			"nombre_responsable": "Francisco Ramos",
			"id_categoria":1,
			"categoria": "Academica",
			"imagen":"image/path.jpg"
		},{
			"id": 2,
			"nombre": "Capturando ondas gravitatorias con un limon",
			"material_participante": "Acelerador de particulas, resistol 5000, Plutonio A15",
			"descripcion":"lorem...",
			"lugar":"Campo de futbol",
			"id_horario": 2,
			"fecha": "2018-03-15",
			"hora_inicio": "10:00:00",
			"hora_final": "12:00:00",
			"id_responsable":1,
			"nombre_responsable": "Stephen Hawkings",
			"id_categoria":1,
			"categoria": "Academica",
			"imagen":"image/path.jpg"
		},{
			"id": 3,
			"nombre": "Mapeando el ADN humano",			
			"material_participante": "Sangre, resistol 5000, Plutonio A15",
			"descripcion":"lorem...",
			"lugar":"Campo de futbol",
			"id_horario": 3,
			"fecha": "2018-03-15",
			"hora_inicio": "10:00:00",
			"hora_final": "12:00:00",
			"id_responsable":1,
			"nombre_responsable": "Luis Pasteur",
			"id_categoria":1,
			"categoria": "Academica",
			"imagen":"image/path.jpg"
		}],
	"num_actividades":3
}
```

### Inscribir actividad

`POST /v1/actividad/alumno`

- El alumno puede inscribir maximo 3 actividades
- Que los horarios de las actividades no se crucen

Ejemplo request body:
```JSON
{
	"no_control":"xxxxxxxx",	
	"id_horario":1	
}
```


#### Returns:
```JSON
{  
	"success":true,
	"code":200
}
```

### desinscribir actividad

`DELETE /v1/actividad/alumno/:id_alumno/:id_horario`

#### Returns:
```JSON
{  
	"success":true,
	"code":200
}
```

### 
