# -*- coding: utf-8 -*-
import gspread
from oauth2client.service_account import ServiceAccountCredentials
import pprint

# use creds to create a client to interact with the Google Drive API
scope = ['https://spreadsheets.google.com/feeds',
         'https://www.googleapis.com/auth/drive'] 
creds = ServiceAccountCredentials.from_json_keyfile_name('client_secret.json', scope)
client = gspread.authorize(creds)

# Find a workbook by name and open the first sheet
# Make sure you use the right name here.
doc = client.open("semana_lince_app")
activ = doc.worksheet("ACTIVIDADES")
replic = doc.worksheet("HORARIOS")

pp = pprint.PrettyPrinter()
# Extract and print all of the values
#result = activ.row_values(6)
#pp.pprint(result)
rows = activ.get_all_records()
pp.pprint(rows)

# for row in rows:
# 	for key,value in row.iteritems():
# 		try:
# 			print(key,value.encode("utf-8"))			
# 		except Exception as e:
# 			print(key,value)

		