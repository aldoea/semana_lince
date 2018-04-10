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

## API ENDPOINTS:

El nombre de dominio es: ``api.semanalince.itcelaya.edu.mx``
Ejemplo: api.semanalince.itcelaya.edu.mx/api/v1/login

### Autenticación:

`POST /api/v1/login`

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
	"message": "¡Bienvenido!"
}
```

Campo requerido: `no_control`

### Lista de Actividades:
_Las actividades deben de ser filtradas por id_especialidad donde excluyan las que correspondan al id_espcialidad del alumno_

`GET /v1/actividad/especialidad/:id_especialidad`

#### Returns:
```JSON
{  
	"actividades":[{
			"id": 1,
			"nombre": "Como cortar tu computadora",
			"duracion": 2,
			"material_participante": "Computadora, tijeras",
			"descripcion":"lorem...",
			"lugar":"LCA",
			"fecha_hora": "2018/03/15 10:00:00",
			"id_responsable":1,
			"nombre_responsable": "Francisco Ramos",
			"id_categoria":1,
			"categoria": "Academica"
		},{
			"id": 2,
			"nombre": "Capturando ondas gravitatorias con un limon",
			"duracion": 1,
			"material_participante": "Acelerador de particulas, resilto 5000, Plutonio A15",
			"descripcion":"lorem...",
			"lugar":"Campo de futbol",
			"fecha_hora": "2018/03/16 10:00:00",
			"id_responsable":1,
			"nombre_responsable": "Stephen Hawkings",
			"id_categoria":1,
			"categoria": "Academica"
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
		"nombre": "Como cortar tu computadora",
		"duracion": 2,
		"material_participante": "Computadora, tijeras",
		"descripcion":"lorem...",
		"lugar":"LCA",
		"fecha_hora": "2018/03/15 10:00:00",
		"id_responsable":1,
		"nombre_responsable": "Francisco Ramos",
		"id_categoria":1,
		"categoria": "Academica"
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
			"duracion": 2,
			"material_participante": "Computadora, tijeras",
			"descripcion":"lorem...",
			"lugar":"LCA",
			"fecha_hora": "2018/03/15 10:00:00",
			"id_responsable":1,
			"nombre_responsable": "Francisco Ramos",
			"id_categoria":1,
			"categoria": "Academica"
		},{
			"id": 2,
			"nombre": "Capturando ondas gravitatorias con un limon",
			"duracion": 1,
			"material_participante": "Acelerador de particulas, resistol 5000, Plutonio A15",
			"descripcion":"lorem...",
			"lugar":"Campo de futbol",
			"fecha_hora": "2018/03/16 10:00:00",
			"id_responsable":1,
			"nombre_responsable": "Stephen Hawkings",
			"id_categoria":1,
			"categoria": "Academica"
		},{
			"id": 3,
			"nombre": "Mapeando el ADN humano",
			"duracion": 3,
			"material_participante": "Sangre, resistol 5000, Plutonio A15",
			"descripcion":"lorem...",
			"lugar":"Campo de futbol",
			"fecha_hora": "2018/03/16 10:00:00",
			"id_responsable":1,
			"nombre_responsable": "Luis Pasteur",
			"id_categoria":1,
			"categoria": "Academica"
		}],
	"num_actividades":3
}
```

### Inscribir actividad

`POST /v1/actividad/alumno`

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
