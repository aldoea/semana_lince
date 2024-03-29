USE lince;

INSERT INTO especialidad (id, nombre) VALUES
  (255, 'Intercambio');

INSERT INTO alumno (nocontrol, nombre, semestre, id_especialidad) VALUES
  ('20132329', 'Jesús Alfredo Amaya Obregón', 0, 255),
  ('55314001', 'Camilo Alejandro Díaz Cárdenas', 0, 255),
  ('20131378', 'Anderson Fabian Velosa Sanabria', 0, 255),
  ('21113168', 'Luis Alfredo Rodríguez Londoño', 0, 255),
  ('29027801', 'Jorge David Peña Carrillo', 0, 255);

INSERT INTO especialidad (id, nombre) VALUES
  (40, 'Maestría en Ingeniería Química'),
  (26, 'Maestría en Ciencias en Ingeniería Bioquímica'),
  (28, 'Maestría en Ciencias en Ingeniería Electrónica'),
  (19, 'Maestría en Ciencias en Ingeniería Mecánica'),
  (18, 'Maestría en Ciencias en Ingeniería Química'),
  (27, 'Maestría en Gestión Administrativa'),
  (29, 'Maestría en Ingeniería Industrial'),
  (45, 'Maestría en Innovación Aplicada');

INSERT INTO alumno (nocontrol, nombre, semestre, id_especialidad) VALUES
  ('M1003069', 'Salazar Ramírez  Mary Ángel', 5, 27),
  ('M1103001', 'Alvarado Perusquía Héctor De Jesús', 4, 27),
  ('M1103004', 'Laguna Córdoba Ángel Maurilio', 5, 27),
  ('M1103010', 'Cordero Becerra  Lourdes Edith', 4, 28),
  ('M1103032', 'Flores Mora  Flor', 4, 18),
  ('M1103064', 'Garcia Rosas Mauricio Daniel', 4, 26),
  ('M1103065', 'Perez Garcia Laura Isabel', 4, 26),
  ('M1103077', 'Mares Pèrez Ricardo', 7, 19),
  ('M1103078', 'Pérez Ramírez  Jorge Miguel', 3, 19),
  ('M1203053', 'Sámano Flores  Yosafat  Jetsemaní', 7, 28),
  ('M1203060', 'Ballesteros Aguayo Alma Rosa', 4, 18),
  ('M1203062', 'Durón Aguirre Ana Matilde', 4, 18),
  ('M1203063', 'Animas Rivera  Sergio', 4, 18),
  ('M1203068', 'Alejandro Javier  José Luis', 2, 18),
  ('M1203069', 'Mosqueda Vidal  Matilde', 2, 18),
  ('M1203079', 'Ramirez Cornejo Miguel Angel', 4, 28),
  ('M1203082', 'Mancera Noriega Maria Guadalupe', 1, 29),
  ('M1203104', 'Posadas Garcia Juan De Dios', 3, 19),
  ('M1203106', 'Ramos Cacique Ernesto', 1, 27),
  ('M1303004', 'Gómez Guerra  Hugo Alejandro', 4, 29),
  ('M1303012', 'Espinosa Mata Juan Manuel', 4, 19),
  ('M1303017', 'Orozco Rincón  Christián Alberto', 1, 19),
  ('M1303021', 'Cuevas Salazar Diana Alejandra', 5, 26),
  ('M1303022', 'Garcia Acosta Jose Alberto', 5, 26),
  ('M1303026', 'Gualito Hernandez Edgar Mauricio', 4, 18),
  ('M1303032', 'Gonzalez Rosillo Monica Del Carmen', 2, 18),
  ('M1303034', 'Calderon Jaramillo Veronica', 5, 26),
  ('M1303040', 'Balcazar Perez Pedro', 4, 28),
  ('M1303047', 'Romero Corrales Efrain Luis', 4, 28),
  ('M1303049', 'Avila Ulloa Berenice', 1, 27),
  ('M1303063', 'Ek Hernandez Carlos Humberto', 3, 27),
  ('M1303068', 'Amaro Silva Alma Angelica', 6, 26),
  ('M1303069', 'Guerrero Rodriguez Jose Antonio', 1, 19),
  ('M1303071', 'Vazquez Acosta Oscar', 1, 19),
  ('M1303074', 'Servín Medina Víctor Alfonso', 1, 19),
  ('M1303075', 'Rafael González Silva', 1, 19),
  ('M1303078', 'Isaac Israel Damian Alberto', 1, 19),
  ('M1303080', 'Roberto González Navarrete', 1, 19),
  ('M1303085', 'González Montes Oscar Daniel', 8, 19),
  ('M1303098', 'Alejandro Coronado De La Cruz', 4, 18),
  ('M1303101', 'Maria Guadalupe Guerrero Villanueva', 0, 29),
  ('M1303106', 'Jose De Jesus Gamez Flores', 3, 29),
  ('M1403002', 'De Los Santos Vázquez Arturo', 5, 28),
  ('M1403006', 'Martínez Espino Héctor', 5, 28),
  ('M1403036', 'Ramos Ontiveros Román Alejandro', 1, 18),
  ('M1403057', 'Moreno Velazquez Alma Linda', 1, 26),
  ('M1403058', 'Cruz Cuevas Jovita', 1, 26),
  ('M1403061', 'Licona Juarez Karla Cecilia', 4, 26),
  ('M1403072', 'Garcia Bustos Roberto', 4, 28),
  ('M1403075', 'Rodriguez Rodriguez Graciela', 5, 27),
  ('M1403096', 'Cárdenas Romero Raúl', 5, 19),
  ('M1403129', 'Juarez Vladimir', 1, 19),
  ('M1403133', 'Gomez Diaz Francisco Ramon', 1, 19),
  ('M1403134', 'Ortiz Hermosillo Citlalin Aurelia', 1, 19),
  ('M1503002', 'Fernandez Soto Diego', 4, 29),
  ('M1503003', 'Martinez Rangel Martha Patricia', 4, 29),
  ('M1503004', 'Gutierrez Vargas Maria Marina', 4, 29),
  ('M1503010', 'Soler Diaz Maria Teresa', 4, 29),
  ('M1503011', 'Ferrel Tierrafría Karina Maria', 5, 26),
  ('M1503013', 'Perez Morales Linda Yaret', 5, 26),
  ('M1503014', 'Rivera Vargas Gilberto Martin', 5, 19),
  ('M1503019', 'Salazar Balderas Francisco', 5, 18),
  ('M1503021', 'Cornejo Romero Jorge', 4, 18),
  ('M1503031', 'Rosas Solorzano Tania', 4, 27),
  ('M1503035', 'Arriaga Medina Roberto Edu', 4, 19),
  ('M1503036', 'Garcia Daza Luis Fernando', 4, 19),
  ('M1503038', 'Flores García Santiago', 5, 19),
  ('M1503093', 'Ana Cristina Maus  Acevedo', 4, 29),
  ('M1503094', 'Guzmán Sáenz Gabriel', 4, 29),
  ('M1503099', 'Morfin Orozco Jorge Ruben', 4, 28),
  ('M1503103', 'Cardenas Leon Angel', 3, 28),
  ('M1503106', 'Villalon Hernandez Miyuki Teri', 4, 28),
  ('M1503110', 'Zugey Argelia Escalera Hernandez', 5, 27),
  ('M1503114', 'Figueroa Reyes Jose Antonio', 4, 27),
  ('M1503115', 'Laguna Estrada Maria Isabel', 4, 26),
  ('M1503116', 'Balderas Vazquez Fatima Del Rosario', 4, 26),
  ('M1503117', 'Quemada Villagómez Luis Isai', 4, 26),
  ('M1503118', 'Elenes Soto Miguel Adrian', 4, 26),
  ('M1503119', 'Meza Reyes Elizabeth Guadalupe', 4, 26),
  ('M1503120', 'Brenda Ríos Fuentes', 4, 26),
  ('M1503121', 'Coral Janeth Morales Sanchez', 4, 26),
  ('M1503124', 'Vargas Fabian  Jose Manuel', 4, 19),
  ('M1503125', 'Escobedo Carranza Ruth Ivonne', 4, 19),
  ('M1503126', 'Jáuregui Ramírez Jose Roberto', 5, 19),
  ('M1503132', 'Tabares  Martinez Juan Manuel', 5, 19),
  ('M1503134', 'Chacon Castillo Ena', 5, 19),
  ('M1503135', 'Resendiz Juarez Sara Inés', 4, 19),
  ('M1503136', 'Julio Alberto Gonzalez Gutierrez', 4, 19),
  ('M1503137', 'Lozano Diaz Alberto', 4, 19),
  ('M1503141', 'García Zúñiga Miguel Ángel', 3, 18),
  ('M1503142', 'Rubí Esmeralda García Velázquez', 4, 18),
  ('M1503145', 'Julio César Barrera Martínez', 4, 18),
  ('M1503147', 'Mendoza Leal  Gabriela', 3, 18),
  ('M1603001', 'Patiño Perez Ana Paulina', 5, 19),
  ('M1603002', 'Arias Vasquez Javier', 4, 29),
  ('M1603003', 'Lara Aguilar Mariana', 4, 29),
  ('M1603005', 'Juan Carlos Torres Vergara', 1, 29),
  ('M1603011', 'Lopez Gonzalez Jesus', 5, 29),
  ('M1603016', 'Peréz Martínez Ramsés', 4, 29),
  ('M1603021', 'Baltazar Hernández Jesús Uriel', 4, 28),
  ('M1603022', 'Hernandez Peña Jose Gabriel', 3, 28),
  ('M1603023', 'Peña Aguirre Julio Cesar', 4, 28),
  ('M1603025', 'Parada Salado Juan Gerardo', 4, 28),
  ('M1603027', 'Antonio De Jesus Tirado Ramirez', 4, 27),
  ('M1603029', 'Bazán Morales Carlos De Jesús', 4, 26),
  ('M1603030', 'Gámez Cordero Juana', 4, 26),
  ('M1603031', 'Gonzalez Gonzalez Manuela Del Rosario', 4, 26),
  ('M1603032', 'Castañón Villegas Alma Leticia', 4, 26),
  ('M1603033', 'Rios Molina Dafne Alejandra', 4, 26),
  ('M1603034', 'Sotres Torres Juan Carlos', 5, 19),
  ('M1603036', 'Vazquez Ramirez Sergio Alberto', 5, 19),
  ('M1603038', 'Garcia Hernandez Jacobo', 5, 19),
  ('M1603039', 'Calderón Soto Alejandro', 5, 19),
  ('M1603040', 'Fonseca Gomez Ricardo', 4, 19),
  ('M1603045', 'Palomares Chimal Daniel', 3, 18),
  ('M1603046', 'Salgado Barrón María Fernanda', 4, 18),
  ('M1603047', 'Bujanos Adame Alejandro Rafael', 4, 18),
  ('M1603050', 'Vázquez Cruz Patricia', 4, 18),
  ('M1603051', 'Ramos Corral Jesus Mario', 4, 18),
  ('M1603053', 'Contreras  Sillero Alina Araceli', 4, 28),
  ('M1603054', 'Rico Gomez Juan Salvador', 3, 27),
  ('M1603055', 'Castañeda Contreras Alfredo', 2, 27),
  ('M1603056', 'Garcia Tovar Rocio', 2, 27),
  ('M1603058', 'Escobedo Landín María De Los Ángeles', 3, 26),
  ('M1603059', 'Estrada Jaloma Manuel Alejandro', 5, 19),
  ('M1603060', 'Franco Aguilera Francisco Javier', 4, 18),
  ('M1603062', 'Ramirez Celestino  Mariel', 4, 29),
  ('M1603064', 'Zuñiga Maldonado Cecilia Abigail', 4, 29),
  ('M1603065', 'Mejia Hernandez Yamil', 4, 29),
  ('M1603066', 'Franco Barrón José Emmanuel', 4, 29),
  ('M1603067', 'Almaraz Mendoza Juan Guillermo', 4, 29),
  ('M1603068', 'Aguirre Ricartti Karla Cristina', 4, 29),
  ('M1603069', 'Estrada Omaña Alejandro', 4, 29),
  ('M1603070', 'Belman Lopez Carlos Eduardo', 4, 29),
  ('M1603071', 'Hernandez Arroyo Alejandro', 4, 29),
  ('M1603073', 'Pedro Eduardo Godinez Salazar', 4, 29),
  ('M1603074', 'Hernandez Miramontes Cindhia Guadalupe', 4, 29),
  ('M1603075', 'Garcia Valencia Alejandro', 4, 29),
  ('M1603076', 'Rivera Lopez Omar', 4, 29),
  ('M1603077', 'Frias Paredes Mayra Lizbeth', 4, 29),
  ('M1603079', 'Ruiz Huitron Francisco Daniel', 4, 28),
  ('M1603080', 'Rafael Garcia Arredondo', 0, 28),
  ('M1603081', 'Miranda Cervantes Ricardo', 4, 28),
  ('M1603082', 'Cruz Camacho Luis Antonio', 4, 28),
  ('M1603083', 'Palomares  Garcia Daniel', 4, 28),
  ('M1603084', 'Espitia Romero Elizabeth', 4, 28),
  ('M1603085', 'Jose Antonio Tellez Perez', 2, 28),
  ('M1603086', 'Adriana Cornejo Mora', 1, 27),
  ('M1603087', 'Lilia Alejandra Cordoba  Castañeda', 1, 27),
  ('M1603088', 'Ledezma Sanchez Andrea', 4, 27),
  ('M1603089', 'García Gómez Miriam Berenice', 4, 27),
  ('M1603090', 'Segura Padilla Marysol', 3, 27),
  ('M1603091', 'Soto Rodríguez Héctor', 2, 27),
  ('M1603092', 'Jose Alberto Robles Gonzalez', 0, 27),
  ('M1603093', 'Lopez Ramos  Jonathan Adrian', 2, 27),
  ('M1603094', 'Gutiérrez  Cardona Citlalli Abigail', 4, 27),
  ('M1603095', 'Bautista Malagon Mariana', 3, 27),
  ('M1603096', 'Nadia Alejandra García Martínez', 1, 27),
  ('M1603097', 'Aguilar Aguilar Veronica', 4, 27),
  ('M1603098', 'Guerrero Valadez David', 3, 27),
  ('M1603099', 'Sanchez Baeza Rosa Isela', 4, 27),
  ('M1603100', 'Lilia Alejandra Cordoba  Castañeda', 0, 27),
  ('M1603101', 'Rico Gomez Juan Salvador', 0, 27),
  ('M1603102', 'Alma Dinorah Galvez Cota', 0, 26),
  ('M1603103', 'Santos Santiago José Manuel', 4, 26),
  ('M1603105', 'Arenas Lara Teresa De Jesus', 4, 26),
  ('M1603106', 'Aquino Medina Edgar Querubin', 4, 26),
  ('M1603107', 'Tinajero Rodriguez Jose Manuel', 4, 26),
  ('M1603109', 'Lopez Gonzalez Maria De La Luz', 4, 26),
  ('M1603110', 'Valadez  Gonzalez Elias Daniel', 4, 19),
  ('M1603111', 'Hernandez Silva  Jose Luis', 4, 19),
  ('M1603112', 'Noriega Quintero Maria Jose', 4, 19),
  ('M1603113', 'Zapatero  Gutiérrez Melissa Karina', 4, 19),
  ('M1603114', 'Serrano García Daniel Alfredo', 4, 19),
  ('M1603115', 'Garcia  Reyes Ivan Alonso', 4, 19),
  ('M1603116', 'Alvarez Rodriguez Jose Juan', 4, 19),
  ('M1603117', 'Alvarado Tovar Carlos Iván', 4, 19),
  ('M1603118', 'Santa Maria Jaramillo Omar', 4, 19),
  ('M1603119', 'Arreguin Hernandez Angelica', 4, 19),
  ('M1603120', 'Alfaro Méndez Jonathan', 4, 19),
  ('M1603121', 'Quemada Villagómez Miriam Lucero', 4, 19),
  ('M1603122', 'Roque Esquinca Juan José', 4, 19),
  ('M1603123', 'Manuel Gonzalez Silva', 1, 19),
  ('M1603124', 'Ortega Alvarez Ricardo', 4, 19),
  ('M1603125', 'Vivas Rios Ivan David', 3, 18),
  ('M1603126', 'Bastidas Moncayo Jeraldin Lizeth', 3, 18),
  ('M1603127', 'Campos Gomez Gerhaldy', 3, 18),
  ('M1603128', 'Guadalupe Nayeli Romero  Robles', 1, 18),
  ('M1603130', 'José Mario Rosete  Barreto', 0, 18),
  ('M1603131', 'Guillén Cuevas Karen De Jesús', 4, 18),
  ('M1603132', 'Diego Villarreal Martinez', 0, 18),
  ('M1603133', 'Valero Hernández Juan Luis', 4, 18),
  ('M1603134', 'Paola  Mata Saavedra', 0, 18),
  ('M1603135', 'Fernando  Arredondo Beltran', 0, 18),
  ('M1603137', 'Misael Cisneros López', 0, 18),
  ('M1603138', 'Carlos Alberto Rendon Montoya', 1, 27),
  ('M1703002', 'Zoila Alejandría Fuentes Sansores', 0, 40),
  ('M1703004', 'Ricardo Tapia  Espinosa', 1, 40),
  ('M1703005', 'Gabriela Rodriguez Macias', 1, 40),
  ('M1703006', 'Naranjo Palacios Fernando', 3, 29),
  ('M1703007', 'Lazarini Diaz Barriga Jorge', 3, 29),
  ('M1703008', 'Almanza Mendoza Abigail Del Carmen', 3, 29),
  ('M1703009', 'Mendoza Ramos Karla Militza', 3, 29),
  ('M1703011', 'Zavala Ortiz  Laura Delia De Jesús', 3, 29),
  ('M1703012', 'Rodriguez Murillo Natalia Arcedalia', 3, 29),
  ('M1703013', 'González Casique Citlaly', 3, 29),
  ('M1703014', 'Orozco Montañez Ilce Nallely', 3, 29),
  ('M1703015', 'Regalado Sánchez Julio Cesar', 3, 28),
  ('M1703016', 'Peralta Lopez  Jose Eleazar', 3, 28),
  ('M1703017', 'Ramirez Arredondo Luis Antonio', 3, 28),
  ('M1703018', 'Padierna Arvizu Diego De Jesús', 3, 28),
  ('M1703019', 'Ruiz Chávez Susana', 3, 26),
  ('M1703022', 'Ortiz Ruiz Aziel Merari', 3, 26),
  ('M1703023', 'Arriaga Gonzalez Efren', 3, 19),
  ('M1703024', 'Soria Perez Hiram Jonathan', 3, 19),
  ('M1703025', 'Victor Hugo Montalvo Fernandez', 1, 19),
  ('M1703026', 'Barradas Delfin Daniel Cipriano', 3, 19),
  ('M1703027', 'Guzmán  Ariza Carlos Augusto', 3, 19),
  ('M1703028', 'Martín Del Campo Gómez Rafael', 3, 19),
  ('M1703029', 'De Lucio Rangel Alejandro', 3, 19),
  ('M1703030', 'Sepúlveda  Vera Francisco Gerardo', 3, 19),
  ('M1703031', 'Lopez Zaragoza Francisco Javier', 3, 19),
  ('M1703032', 'Herrera Paz Sergio', 3, 19),
  ('M1703033', 'Anaya  Guerrero  Christian De Jesus', 3, 19),
  ('M1703034', 'Millán Márquez Ana Rebeca', 3, 18),
  ('M1703035', 'Drury Zamora Jose Galen', 3, 18),
  ('M1703036', 'Trejo López José Joaquín', 3, 18),
  ('M1703037', 'Burelo Sanchez Alejandro', 3, 18),
  ('M1703038', 'Torres Morales Luis Alberto', 3, 18),
  ('M1703039', 'Bautista Perez Maria Fernanda', 1, 18),
  ('M1703041', 'Ernesto Miranda Molina', 1, 40),
  ('M1703042', 'Gomez Cortes Juan Carlos', 3, 28),
  ('M1703043', 'García Arredondo Rafael', 3, 28),
  ('M1703044', 'Morales Guerrero Caren Alejadra', 3, 27),
  ('M1703045', 'López Rodríguez Brenda', 3, 27),
  ('M1703046', 'Soto Rios Thelma Carolina', 3, 27),
  ('M1703047', 'Corrales Gasca Pedro Javier', 3, 27),
  ('M1703048', 'Maya Gomez Aimee', 3, 27),
  ('M1703049', 'Mejia  Rodriguez Rubi Estefani', 3, 27),
  ('M1703050', 'Doñu Perez Yesenia', 3, 27),
  ('M1703051', 'Jose Salvador Villanueva Barragan', 1, 27),
  ('M1703052', 'Monter Rico Hector', 3, 27),
  ('M1703053', 'Ordoñez Caudillo Mariana Rosario', 3, 27),
  ('M1703054', 'Saldierna García María Fernanda', 3, 27),
  ('M1703055', 'Gaitan Velez Brayan Vladimir', 3, 26),
  ('M1703056', 'Villarreal Martinez Diego', 3, 18),
  ('M1703057', 'Ortega Moran Nelson David', 3, 18),
  ('M1703058', 'Mata Saavedra Paola', 3, 18),
  ('M1703059', 'Medina Galvan Xochitl Montserrat', 3, 18),
  ('M1703060', 'Fest Carreño Andres', 3, 18),
  ('M1703063', 'Florencio Javier Pérez Nuñez', 0, 40),
  ('M1703064', 'Stephanie Michelle López Cerritos', 1, 27),
  ('M1703065', 'Gonzalez Morales Juan Pablo', 2, 29),
  ('M1703066', 'García Garza Mirna Elizabeth', 2, 29),
  ('M1703067', 'Marina Magdalena Ruiz Ortega', 0, 29),
  ('M1703068', 'Ramirez Dimas Cristina', 2, 29),
  ('M1703069', 'Ernesto Alonso Pérez López', 0, 29),
  ('M1703070', 'Lozano Torres Rosalinda', 2, 29),
  ('M1703071', 'Sánchez Godínez Sandra Daniela', 2, 29),
  ('M1703072', 'Marco Antonio Constantino Carrillo', 0, 29),
  ('M1703073', 'Buentello Duque Abelardo', 2, 29),
  ('M1703074', 'Bello Morales Rafael', 2, 29),
  ('M1703075', 'Reyes Rodríguez Marco Jesús', 2, 29),
  ('M1703076', 'Araiza Herrera Hilda Alejandra', 2, 29),
  ('M1703077', 'Guerrero González Diana Fabiola', 2, 29),
  ('M1703078', 'Jimenez Zarraga Giovanni Santiago', 2, 29),
  ('M1703079', 'Martinez Valencia Mariana Itzel', 2, 29),
  ('M1703080', 'Ramirez Pedraza Giovanna Gabriela', 2, 29),
  ('M1703081', 'Alvarez Díaz-comas Alfredo', 2, 28),
  ('M1703082', 'Estévez  De Bén Adyr Andrés', 2, 28),
  ('M1703083', 'Castillo Zamora Ibsan Ulises', 2, 28),
  ('M1703084', 'Lazaro Mata David', 2, 28),
  ('M1703085', 'Monroy  Sahade Einar Alam', 2, 28),
  ('M1703086', 'Vazquez Rodriguez Edgar Armando', 2, 28),
  ('M1703087', 'Gonzalez Colunga Paulo', 2, 27),
  ('M1703088', 'Martínez Sonana Scottie Yair', 2, 27),
  ('M1703089', 'Navarrete Mendez Rocio Del Carmen', 2, 27),
  ('M1703090', 'Hernández Palato Susana', 2, 27),
  ('M1703091', 'Fidel Aguilar Aguilar', 0, 26),
  ('M1703093', 'Pardo Arredondo Andrea Paulina', 2, 26),
  ('M1703094', 'Flores Hernandez Hugo Andres', 2, 19),
  ('M1703095', 'Vargas Santacruz Daniel Armando', 2, 19),
  ('M1703096', 'Duran Morales Valdemar', 2, 19),
  ('M1703097', 'Samano Ortega Victor Manuel', 2, 19),
  ('M1703098', 'Guerrero Chavez Nicolas', 2, 19),
  ('M1703099', 'Salmoran  Salgado Roberto Carlos', 2, 19),
  ('M1703100', 'Sámano Muñoz José Pablo', 2, 19),
  ('M1703101', 'Guerrero Prieto Juan Pablo', 2, 19),
  ('M1703102', 'Campa Miranda Jesús Fidel', 2, 19),
  ('M1703103', 'Garcia Urvina Martin', 2, 19),
  ('M1703104', 'Pérez Durán Guadalupe', 2, 18),
  ('M1703105', 'De Jesus Rodriguez Guadalupe', 2, 18),
  ('M1703106', 'Navarro Tovar Roberto', 2, 18),
  ('M1703107', 'Herrera Ovando Saúl', 2, 18),
  ('M1703108', 'Salas  Hernández  Luis Alejandro', 2, 18),
  ('M1703109', 'Franco Gutiérrez Argelia', 2, 18),
  ('M1703110', 'Talamantes Silva Jesus Guerrero', 2, 18),
  ('M1703111', 'Rodriguez Arellano Roberto Esteban', 2, 29),
  ('M1703112', 'Romero Mendoza Rodrigo Emmanuel', 2, 29),
  ('M1703114', 'Cabrera Carrazana Roberto Jesús', 2, 18),
  ('M1703115', 'Hernandez Morales Gabriel', 2, 18),
  ('M1703116', 'Buenavista Centeno Jorge Luis', 2, 19),
  ('M1703117', 'Héctor Manuel  Rodríguez Islas', 0, 45),
  ('M1703118', 'Macias Padilla Esteban', 2, 45),
  ('M1703119', 'Gonzalez Martinez Agustin', 1, 45),
  ('M1703120', 'Fabián Plesníková Pavlína', 1, 45),
  ('M1703121', 'Aldaco González Elsa Isabel', 2, 45),
  ('M1703122', 'Mendoza Arellano Pedro Javier', 1, 45),
  ('M1703123', 'Rubio Casanova Luis Jacobo', 1, 45),
  ('M1703124', 'Pérez Herevia Jesús Julián', 2, 45),
  ('M1703125', 'Gaytán Alonso Héctor Fernando', 2, 45),
  ('M1703126', 'Flores Avalos Mayra Jaqueline', 2, 45),
  ('M1703127', 'Piz Estrada Luis Eduardo', 1, 45),
  ('M1803002', 'Daniel Sámano Domínguez', 0, 45),
  ('M1803003', 'Maldonado Romero David', 0, 45),
  ('M1803004', 'Villarreal Lugo Ana Leticia', 1, 29),
  ('M1803005', 'Triana Garcia Maleni', 1, 29),
  ('M1803006', 'Hernandez Torres Jose Eduardo', 1, 29),
  ('M1803007', 'Bocanegra Lara Mariana', 1, 29),
  ('M1803008', 'Pablo Gonzalez Gomez', 0, 29),
  ('M1803009', 'Veloz Garcia  Juan Pablo', 1, 29),
  ('M1803010', 'Moreno Martinez Tonantzin', 1, 29),
  ('M1803011', 'Sanchez Vazquez Manuel', 1, 29),
  ('M1803012', 'Sandoval Ortega Luis Enrique', 1, 29),
  ('M1803013', 'Laguna Cordoba Angel Maurilio', 1, 29),
  ('M1803014', 'Granados Nieto Osvaldo Alejandro', 1, 29),
  ('M1803015', 'Salmoran Lopez Edgar', 1, 29),
  ('M1803016', 'Puentes Marquez Jorge Armando', 1, 29),
  ('M1803017', 'Luis Fernando Gaona Cardenas', 1, 28),
  ('M1803018', 'Israel Marcial Lemus', 1, 28),
  ('M1803019', 'Palacios Morgado Lucero', 1, 27),
  ('M1803020', 'Cruz Lopez Janet', 1, 27),
  ('M1803021', 'Angeles Pozas Maria Del Rosario', 1, 27),
  ('M1803022', 'Araujo  Alonso Claudio Edivaldo', 1, 27),
  ('M1803023', 'Corona Rosales Erick Ricardo', 1, 27),
  ('M1803024', 'Saldarriaga Cortes  Carol', 1, 27),
  ('M1803025', 'Torres Torres Evelin Anahí', 1, 27),
  ('M1803026', 'Cobarrubias Carapia Soraya', 1, 26),
  ('M1803027', 'Basurto Rentería Angel', 1, 26),
  ('M1803028', 'Esqueda  Morales  Juan Eduardo', 1, 19),
  ('M1803029', 'Garcia Olivo Antonio', 1, 19),
  ('M1803030', 'Aguilar Cortes Guillermo Enrique', 1, 19),
  ('M1803031', 'Garcia Gutierrez Yessil Eduardo', 1, 19),
  ('M1803032', 'Rodriguez Garcia Saul Santos', 1, 19),
  ('M1803033', 'Maria Guadalupe  Garcia Falcon', 1, 18),
  ('M1803034', 'Xavier  Porras  Regalado', 1, 18),
  ('M1803035', 'Luz Elena Miranda Mora', 1, 18),
  ('M1803036', 'Peña De Anda  Beatriz', 0, 45),
  ('M1803037', 'Ortiz  Gallardo Diego', 1, 45),
  ('M1803038', 'Resendiz  Serrano Francisco Javier', 1, 45),
  ('M1803039', 'Landin Moya Juana', 1, 45),
  ('M1803040', 'Ruíz  Ruíz. Guadalupe', 1, 45),
  ('M1803041', 'Morales  Flores José Miguel', 0, 45),
  ('M1803042', 'Ramírez  Patiño Andrea', 0, 45),
  ('M1803043', 'Peralta  Fernando Agustin', 0, 45),
  ('M1803044', 'Ruiz  Mendoza Adriana De Socorro', 0, 45),
  ('M1803045', 'Ramírez  Jaramillo. Ana Lucia', 0, 45),
  ('M1803046', 'Vázquez  Uribe Laura', 0, 45),
  ('M1803047', 'Acosta  Hernández Adriana Erika', 0, 45),
  ('M1803048', 'Monroy Quiroz Ana Maria', 0, 45),
  ('M1803049', 'Luis Enrique Ortega Garcia', 1, 28),
  ('M1803050', 'Elnaz Zadeh Zadeh', 0, 28),
  ('M1803051', 'Osmar Gomez Cesar', 1, 28),
  ('M1803052', 'Carlos Eduardo Garcia Alcala', 1, 28),
  ('M1803053', 'Juarez Lopez  Danae', 0, 27),
  ('M1803054', 'Perales Martinez Cesar Eduardo', 1, 27),
  ('M1803055', 'Sierra  Martinez Ana Cristina', 1, 27),
  ('M1803056', 'Arturo Alejandro Muñiz Ovalle', 0, 18),
  ('M1803057', 'Gabriel Macías Mier', 1, 18);