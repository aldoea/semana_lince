# Comiendo data desde los archivos de google docs :+1: :metal: :octocat:

## Requerimientos:
* Python ~2.7
* Google API console (Credentials (JSON))
* [Obtain OAuth2 credentials from Google Developers Console](http://gspread.readthedocs.org/en/latest/oauth2.html)

[Cómo usar y configurar gspread](https://www.youtube.com/watch?v=vISRn5qFrkM&lc=z22dfx0htnirxhmzu04t1aokgeyynemeui1ccch3u15nrk0h00410)
[o más detallado](https://www.twilio.com/blog/2017/02/an-easy-way-to-read-and-write-to-a-google-spreadsheet-in-python.html?utm_source=youtube&utm_medium=video&utm_campaign=youtube_python_google_sheets)

### Primero instalar los modulos necesarios
	
	pip install gspread oauth2client

y tambien para conectarse a la base de datos

	pip install mysql-connector

#### _Recuerda que el archivo client_secret.json son las credenciales creadas en la consola de Google APIs_

### Configurar el archivo ``DB.py``
_En la carpeta hay un archivo de ejemplo llamado ``Db.example.py``_
```python
config = {
  'user': 'scott',
  'password': 'password',
  'host': '127.0.0.1',
  'database': 'employees',
  'raise_on_warnings': True,
}
```

Aquí se configura la conexión a la base de datos, la cual ya debe de existir.

### Por ultimo se corre el script
_Depende de la variable de entorno como se ejecute Python_

	python data_from_sheets.py >> all_logs.logs

Si en el archivo nuevo de ``all_logs.logs`` no hay mayor problema que mensajes de no replica de registros, entonces habremos concluido.