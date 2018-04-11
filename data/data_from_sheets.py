# -*- coding: utf-8 -*-

import gspread
from oauth2client.service_account import ServiceAccountCredentials
import mysql.connector
from mysql.connector import errorcode
import time
from DB import config
import pprint
import sys


def insert_ponente():
	query=("INSERT IGNORE INTO ponente (nombre) VALUES ('%s');")
	for actividad in actividad_rows:
		ponente = actividad['nombre_ponentes']
		if ponente != 'PENDIENTE' and ponente != '' and ponente is not None:
			ponentes = ponente.split(',')			
			for person in ponentes:
				try:
					cursor.execute(query %(person))				
				except Exception as e:
					print(e)
		
def insert_responsable():	
	query = ("INSERT IGNORE INTO responsable (nombre) VALUES ('%s');")
	for actividad in actividad_rows:
		responsable = actividad['responsable']
		if responsable != 'PENDIENTE' and responsable != '' and responsable is not None:
			try:										
				cursor.execute(query %(responsable))
			except Exception as e:
				print(e)		

def insert_ubitacions():	
	query = ("INSERT IGNORE INTO ubicacion (nombre) VALUES ('%s');")
	for row in horarios_rows:
		ubication = row['lugar']				
		if ubication != 'PENDIENTE' and ubication != '' and ubication is not None:
			try:										
				cursor.execute(query %(ubication))
			except Exception as e:				
				print(e)					
				

def insert_actividad():
	query = (
				"INSERT INTO actividad (id, nombre, material_ponente, material_participante, descripcion, id_servicio, id_tipo, id_especialidad, id_responsable, id_categoria)"
				"VALUES ({num_actividad}, '{nombre_actividad}', '{material_ponente}', '{material_participante}', '{descripcion}',"                       
	                       "(SELECT servicio.id FROM servicio WHERE servicio.nombre LIKE '%{servicio}%'),"
	                       "(SELECT tipo.id FROM tipo WHERE tipo.nombre LIKE '%{tipo}%'),"                      
	                       "(SELECT especialidad.id FROM especialidad WHERE especialidad.nombre LIKE '%{especialidad}%'),"
	                       "(SELECT responsable.id FROM responsable WHERE responsable.nombre = '{responsable}'),"
	                       "(SELECT categoria.id FROM categoria WHERE categoria.nombre LIKE '%{categoria}%'));"
           )	
	
	for actividad_data in actividad_rows:
		if actividad_data['nombre_actividad'] != 'PENDIENTE' and actividad_data['nombre_actividad'] != '' and actividad_data['nombre_actividad'] is not None:
			new_query = query.format(
					num_actividad = actividad_data['num_actividad'],
					nombre_actividad = actividad_data['nombre_actividad'].encode('utf-8'),					
					material_ponente = 'NULL' if actividad_data['material_ponente'] == "Ninguno" or actividad_data['material_ponente'] == '' else actividad_data['material_ponente'].encode('utf-8'),
					material_participante = 'NULL' if actividad_data['material_participante'] == "Ninguno" or actividad_data['material_participante'] == '' else actividad_data['material_participante'].encode('utf-8'),
					descripcion = 'NULL' if actividad_data['descripcion'] == "PENDIENTE" else actividad_data['descripcion'].encode('utf-8'),
					servicio = 'NULL' if actividad_data['servicio'] == '' else actividad_data['servicio'].encode('utf-8'),
					tipo = 'NULL' if actividad_data['tipo'] == '' else actividad_data['tipo'].encode('utf-8'),
					especialidad = 'Neutral' if actividad_data['responsable'] == '' else actividad_data['responsable'].encode('utf-8'),
					responsable = actividad_data['responsable'].encode('utf-8'),
					categoria = 'NULL' if actividad_data['categoria'] == '' else actividad_data['categoria'].encode('utf-8')
			)	

			try:										
				cursor.execute(new_query)
			except Exception as e:
				print(e)
		else:
			print("INTERNAL DATA ERROR: Actividad sin nombre in", actividad_data)

def insert_actividad_ponente():
	query = ("INSERT INTO actividad_ponente (id_actividad, id_ponente)"
			"VALUES ({num_actividad}," 
				"(SELECT ponente.id FROM ponente WHERE ponente.nombre = '{nombre_ponente}'));"
			)
	for actividad in actividad_rows:
		num_actividad = actividad['num_actividad']
		ponente = actividad['nombre_ponentes']
		if ponente != 'PENDIENTE' and ponente != '' and ponente is not None:
			ponentes = ponente.split(',')	
			for person in ponentes:
				new_query = query.format(num_actividad = num_actividad, nombre_ponente = person.encode('utf-8'))
				try:
					cursor.execute(new_query)				
				except Exception as e:
					print(e)

def insert_horario():
	query = (
				"INSERT INTO horario (id_actividad, fecha,hora_inicio, id_ubicacion, capacidad)"
				" VALUES ({num_actividad}, '{fecha}', '{hora_inicio}',"
						"(SELECT ubicacion.id FROM ubicacion WHERE ubicacion.nombre = '{lugar}'), {capacidad});"
	)
	for horario in horarios_rows:
		if horario['fecha'] != '' and horario['hora_inicio'] != '':
			new_query = query.format(
										num_actividad=horario['num_actividad'], 
										fecha = time.strftime('%Y/%m/%d' ,time.strptime(horario['fecha'], '%Y/%m/%d') ),
										hora_inicio = time.strftime('%H:%M:%S' ,time.strptime(horario['hora_inicio'], '%H:%M:%S')),										
										lugar = horario['lugar'] if isinstance(horario['lugar'], int) else horario['lugar'].encode('utf-8'), 
										capacidad = 30 if horario['capacidad'] == '' else horario['capacidad']
						)
			try:
				cursor.execute(new_query)
			except Exception as e:
				print(horario['num_actividad'],e)				

# use creds to create a client to interact with the Google Drive API
scope = ['https://spreadsheets.google.com/feeds',
         'https://www.googleapis.com/auth/drive'] 
creds = ServiceAccountCredentials.from_json_keyfile_name('client_secret.json', scope)
client = gspread.authorize(creds)

doc = client.open("semana_lince_app-7.xlsx")
activ = doc.worksheet("ACTIVIDADES")
horarios = doc.worksheet("HORARIOS")

pp = pprint.PrettyPrinter()
# Extract and print all of the values
actividad_rows = activ.get_all_records()
horarios_rows = horarios.get_all_records()

try:
	cnx = mysql.connector.connect(**config)  	
	cursor = cnx.cursor()

	print('=========================>	 P O N E N T E  L O G S 						<=========================')
	print('')
	insert_ponente()	
	print('')
	print('=========================>	 R E S P O N S A B L E  L O G S 				<=========================')
	print('')
	insert_responsable()
	print('')
	print('=========================>	 U B I C A T I O N  L O G S 					<=========================')
	print('')
	insert_ubitacions()
	print('')
	print('=========================>	 A C T I V I D A D  L O G S 					<=========================')
	print('')
	insert_actividad()	
	print('')
	print('=========================>	 A C T I V I D A D _ P O N E N T E  L O G S 	<=========================')
	print('')
	insert_actividad_ponente()
	print('')
	print('=========================>	 H O R A R I O  L O G S 						<=========================')
	print('') 
	insert_horario()

	cnx.commit()
	cursor.close()
	cnx.close()
except mysql.connector.Error as err:
        if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
            print("Something is wrong with your user name or password")
        elif err.errno == errorcode.ER_BAD_DB_ERROR:
            print("Database does not exist")
        else:
            print(err)
else:
	cnx.close()
