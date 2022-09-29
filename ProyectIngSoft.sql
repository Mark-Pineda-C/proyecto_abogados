create database DBAbogado
go
use DBAbogado
go

create table Usuario(
ID varbinary(80) primary key,
username varchar(80),
pswd varchar(30),
access int
)
go
create table Distritos_Legales(
Codigo char(4) primary key,
Ubicacion varchar(150)
)
go
create table Juzgados(
Codigo char(2) primary key,
Juzgado varchar(50)
)
go
create table Materias(
Codigo char(2) primary key,
Materia varchar(50)
)
go
create table Cliente(
ID_Cliente varbinary(80) primary key,
Nombre_Cliente varchar(30),
Apellido_Cliente varchar(30),
DNI char(8),
Direccion varchar(150),
Correo varchar(50),
foreign key (ID_Cliente) references Usuario (ID)
)
go
create table Abogado(
ID_Abogado varbinary(80) primary key,
Nombre_Abogado varchar(30),
Apellido_Abogado varchar(30),
DNI char(8),
NroColegiatura char(10),
Correo varchar(50),
foreign key (ID_Abogado) references Usuario (ID)
)
go
create table Codificacion_Expediente(
Cod_Expediente char(30) primary key,
Nro_Expediente char(5),
FechaY char(4),
Ubicacion char(4),
NumCarpetas char(4),
Juzgado char(2),
Materia char(2),
NumJuzgado char(2),
foreign key (Ubicacion) references Distritos_Legales (Codigo),
foreign key (Juzgado) references Juzgados (Codigo),
foreign key (Materia) references Materias (Codigo)
)
go
create table Expediente(
Cod_Expediente char(30) primary key,
Abogado_Encargado varbinary(80),
Cliente_Representado varbinary(80),
Fecha_Apertura datetime,
foreign key (Cod_Expediente) references Codificacion_Expediente (Cod_Expediente),
foreign key (Abogado_Encargado) references Abogado (ID_Abogado),
foreign key (Cliente_Representado) references Cliente (ID_Cliente)
)
go
create table Procedimiento(
ID_prod int primary key,
Cod_Expediente char(30),
Nombre_Procedimiento varchar(150),
Fecha_Inicio datetime,
Fecha_Plazo datetime,
Estado varchar(100),
foreign key (Cod_Expediente) references Expediente (Cod_Expediente)
)
go
create table Archivo(
Cod_Expediente char(30),
ID_Archivo int,
Tipo_Archivo varchar(100),
Descripcion varchar(200),
Archivo varchar(150),
foreign key (Cod_Expediente) references Expediente (Cod_Expediente)
)
go
/*--- PROCEDIMIENTOS ---*/
create procedure insertUsuario(@nombre varchar(80),@pass varchar(30), @acc int, @mail varchar(50))as
	declare @id varbinary(80)
	set @id = CONVERT(varbinary,@nombre)
	insert into Usuario values (@id,@nombre,@pass,@acc)
	if @acc = 1
	begin 
		insert into Cliente (ID_Cliente,Correo) values (@id,@mail)
	end
	else
	begin
		insert into Abogado (ID_Abogado,Correo) values (@id,@mail)
	end
go
create procedure ActualizardatosA (@codigo varchar(80),@nombre varchar(30),@apellido varchar(30),@dni char(8),@nroC char(10)) as
	declare @cod varbinary(80)
	set @cod = CONVERT(varbinary,@codigo)
	update Abogado set Nombre_Abogado = @nombre, Apellido_Abogado = @apellido, DNI = @dni, NroColegiatura = @nroC where ID_Abogado = @cod
go
create procedure ActualizardatosC (@codigo varchar(80),@nombre varchar(30),@apellido varchar(30),@dni char(8),@dir varchar(150))as
	declare @cod varbinary(80)
	set @cod = CONVERT(varbinary,@codigo)
	update CLiente set Nombre_Cliente = @nombre, Apellido_Cliente = @apellido, DNI = @dni, Direccion = @dir where ID_Cliente = @cod
go
create procedure ValidarUsuario (@nom varchar(80),@pass varchar(30),@men varchar(max) output)as
	declare @var varbinary(80)
	set @var = CONVERT(varbinary,@nom)
	declare @var2 int
	set @var2 = (select COUNT(ID) from Usuario where ID = @var AND pswd = @pass)
	if @var2 = 1
		set @men = 'OK,Usuario Verificado'
	else
		set @men = 'NOK,Usuario Denegado'
go
create procedure ObtenerUsuario (@nom varchar(80)) as
	declare @var varbinary(80)
	set @var = CONVERT(varbinary,@nom)
	declare @var2 int
	set @var2 = (select access from Usuario where ID = @var)
	if @var2 = 1
		select * from Cliente where ID_Cliente = @var
	else
		select * from Abogado where ID_Abogado = @var
go
create procedure ObetenrUserName(@mail varchar(50)) as
	select CONVERT(varchar,ID_Cliente) from Cliente where Correo = @mail
go
create procedure NivelAcceso (@nom varchar(80), @acceso int output) as
	declare @var varbinary(80)
	set @var = CONVERT(varbinary,@nom)
	set @acceso = (select access from Usuario where ID = @var)
go
create procedure insertInfoExp (@cod char(30), @nro char(5), @FechaY datetime,@ubi char(4), @numC char(4), @Jur char(2), @Ma char(2), @numJ varchar(2)) as
	insert into Codificacion_Expediente values (@cod, @nro, CONVERT(char,year(@FechaY)),@ubi,@numC, @Jur, @Ma,@numJ)
go
create procedure insertExpediente(@cod char(30), @Abog varchar(80), @CliC varchar(50)) as
	declare @fecha datetime
	set @fecha = GETDATE()
	declare @CR varbinary(80)
	set @CR = (select ID_Cliente from Cliente where Correo = @CliC)
	declare @AE varbinary(80)
	set @AE = CONVERT(varbinary,@Abog)
	insert into Expediente values (@cod,@AE,@CR,@fecha)
go
create procedure validarCliente(@correo varchar(50),@resul varchar(2) output) as
	declare @var int
	set @var = (select COUNT(ID_Cliente) from Cliente where Correo = @correo)
	if @var = 1
		set @resul = 'SI'
	else
		set @resul = 'NO'
go
create procedure verificarYcrearUsuario(@mail varchar(50)) as
	declare @var int
	declare @var1 int
	declare @var2 varchar(20)
	declare @cont varchar(20)
	set @var = (select count(username) from Usuario where username like 'cli-%')
	if @var = 0
	begin
		set @var1 = 1
		set @var2 = 'cli-'+CONVERT(varchar,@var)
		set @cont ='12'+@var2+'34'
		execute insertUsuario @var2,@cont,1,@mail
	end
	else
	begin
		set @cont = (select top 1 CONVERT(int,(select top 1 value from string_split(username,'-') order by value asc)) as valor from Usuario where username like 'cli-%' order by valor desc)
		set @cont += 1
		set @var2 = 'cli-'+CONVERT(varchar,@cont)
		set @cont = '12'+@var2+'34'
		execute insertUsuario @var2, @cont, 1,@mail
	end
go
create procedure insertArchivo(@CodExp char(30), @TA varchar(100), @Desc varchar(200), @Arc varchar(150))as
	declare @IDA int
	set @IDA = (select COUNT(ID_Archivo) from Archivo where Cod_Expediente =@CodExp)
	if @IDA = 0
	begin
		insert into Archivo values (@CodExp,1,@TA,@Desc,@Arc)
	end
	else
	begin
		set @IDA = (select top 1 ID_Archivo from Archivo where Cod_Expediente = @CodExp order by ID_Archivo desc)
		set @IDA += 1
		insert into Archivo values (@CodExp,@IDA,@TA,@Desc,@Arc)
	end
go
create procedure InsertProcedimiento (@CodExp char(30), @NomProc varchar(150),@FP datetime) as
	declare @var datetime
	set @var = SYSDATETIME()
	declare @var2 varchar(100)
	set @var2 = 'Iniciado'
	declare @id int
	set @id = (select COUNT(ID_prod) from Procedimiento)
	if @id = 0
		insert into Procedimiento VALUES (1,@CodExp,@NomProc,@var,@FP,@var2)
	else
		set @id = (select top 1 ID_prod from Procedimiento order by ID_Prod desc)
		set @id += 1;
		insert into Procedimiento VALUES (@id,@CodExp,@NomProc,@var,@FP,@var2)
go
create procedure UpdateProcedimiento (@cod char(30),@id int, @est varchar(100)) as
	update Procedimiento set Estado = @est where ID_Prod = @id and Cod_Expediente = @cod
go
create procedure ReadSubUbicaciones (@Ubi varchar(50)) as
	set @Ubi += '%'
	select Codigo, (select top 1 value from string_split(Ubicacion,'-') order by value asc) as Dist from Distritos_Legales where Ubicacion like @ubi
go
create procedure ObternerInfo (@cod char(30)) as
	Select CE.Nro_Expediente, CE.FechaY, DL.Ubicacion, J.Juzgado, M.Materia, CONVERT(varchar,E.Abogado_Encargado) as Abogado, (select top 1 Nombre_Procedimiento from Procedimiento as P where P.Cod_Expediente=@cod ORDER BY Fecha_Inicio desc) as Proce, CE.NumJuzgado
	from Codificacion_Expediente as CE 
	inner join Distritos_Legales as DL on CE.Ubicacion=DL.Codigo 
	inner join Juzgados as J on CE.Juzgado = J.Codigo
	inner join Materias as M on CE.Materia = M.Codigo
	inner join Expediente as E on CE.Cod_Expediente = E.Cod_Expediente
	where CE.Cod_Expediente = @cod
go
/*-- INSERTS --*/
execute insertUsuario 'Alexander','12alexander34',2,'santos16promo@gmail.com'
execute ActualizardatosA 'Alexander','Alexander Ruben','Santos Sifuentes','12345678','CA01320436'
go
execute insertUsuario 'Luis','12luis34',2,'me@example.com'
execute ActualizardatosA 'Luis','Luis Enrique','Cuya Chuica','33224411','CA20190234'
go
execute insertUsuario 'Mark','12mark34',2,'mfpc1500@gmail.com'
execute ActualizardatosA 'Mark','Mark Franklin','Pineda Cubillas','70597138','CA20214650'
go
execute insertUsuario 'Robert','12robert34',2,'me2@example.com'
execute ActualizardatosA 'Robert','Robert Angel Junior','Siqueiros Flores','25053421','CA20180289'
go


insert into Distritos_Legales values
('0101','AMAZONAS - CHACHAPOYAS'),
('0102','AMAZONAS - BAGUA'),
('0103','AMAZONAS - BONGARA'),
('0104','AMAZONAS - CONDORCANQUI'),
('0105','AMAZONAS - LUYA'),
('0106','AMAZONAS - RODRIGUEZ DE MENDOZA'),
('0107','AMAZONAS - UTCUBAMBA'),
('0201','ANCASH - HUARAZ'),
('0202','ANCASH - AIJA'),
('0203','ANCASH - ANTONIO RAYMONDI'),
('0204','ANCASH - ASUNCION'),
('0205','ANCASH - BOLOGNESI'),
('0206','ANCASH - CARHUAZ'),
('0207','ANCASH - CARLOS F. FITZCARRALD'),
('0208','ANCASH - CASMA'),
('0209','ANCASH - CORONGO'),
('0210','ANCASH - HUARI'),
('0211','ANCASH - HUARMEY'),
('0212','ANCASH - HUAYLAS'),
('0213','ANCASH - MARISCAL LUZURIAGA'),
('0214','ANCASH - OCROS'),
('0215','ANCASH - PALLASCA'),
('0216','ANCASH - POMABAMBA'),
('0217','ANCASH - RECUAY'),
('0218','ANCASH - SANTA'),
('0219','ANCASH - SIHUAS'),
('0220','ANCASH - YUNGAY'),
('0301','APURIMAC - ABANCAY'),
('0302','APURIMAC - ANDAHUAYLAS'),
('0303','APURIMAC - ANTABAMBA'),
('0304','APURIMAC - AYMARAES'),
('0305','APURIMAC - COTABAMBAS'),
('0306','APURIMAC - CHINCHEROS'),
('0307','APURIMAC - GRAU'),
('0401','AREQUIPA - AREQUIPA'),
('0402','AREQUIPA - CAMANA'),
('0403','AREQUIPA - CARAVELI'),
('0404','AREQUIPA - CASTILLA'),
('0405','AREQUIPA - CAYLLOMA'),
('0406','AREQUIPA - CONDESUYOS'),
('0407','AREQUIPA - ISLAY'),
('0408','AREQUIPA - LA UNION'),
('0501','AYACUCHO - HUAMANGA'),
('0502','AYACUCHO - CANGALLO'),
('0503','AYACUCHO - HUANCA SANCOS'),
('0504','AYACUCHO - HUANTA'),
('0505','AYACUCHO - LA MAR'),
('0506','AYACUCHO - LUCANAS'),
('0507','AYACUCHO - PARINACOCHAS'),
('0508','AYACUCHO - PAUCAR DEL SARA SARA'),
('0509','AYACUCHO - SUCRE'),
('0510','AYACUCHO - VICTOR FAJARDO'),
('0511','AYACUCHO - VILCAS HUAMAN'),
('0601','CAJAMARCA - CAJAMARCA'),
('0602','CAJAMARCA - CAJABAMBA'),
('0603','CAJAMARCA - CELENDIN'),
('0604','CAJAMARCA - CHOTA'),
('0605','CAJAMARCA - CONTUMAZA'),
('0606','CAJAMARCA - CUTERVO'),
('0607','CAJAMARCA - HUALGAYOC'),
('0608','CAJAMARCA - JAEN'),
('0609','CAJAMARCA - SAN IGNACIO'),
('0610','CAJAMARCA - SAN MARCOS'),
('0611','CAJAMARCA - SAN MIGUEL'),
('0612','CAJAMARCA - SAN PABLO'),
('0613','CAJAMARCA - SANTA CRUZ'),
('0701','CALLAO - CALLAO'),
('0702','CALLAO - BELLAVISTA'),
('0703','CALLAO - CARMEN DE LA LEGUA REYNOSO'),
('0704','CALLAO - LA PERLA'),
('0705','CALLAO - LA PUNTA'),
('0706','CALLAO - VENTANILLA')
INSERT INTO Distritos_Legales VALUES
('0801','CANHETE - SAN VICENTE'),
('0802','CANHETE - ASIA'),
('0803','CANHETE - CALANGO'),
('0804','CANHETE - CERRO AZUL'),
('0805','CANHETE - COAYLLO'),
('0806','CANHETE - CHILCA'),
('0807','CANHETE - IMPERIAL'),
('0808','CANHETE - LUNAHUANÁ'),
('0809','CANHETE - MALA'),
('0810','CANHETE - NUEVO IMPERIAL'),
('0811','CANHETE - PACARÁN'),
('0812','CANHETE - QUILMANA'),
('0813','CANHETE - SAN ANTONIO'),
('0814','CANHETE - SAN LUIS'),
('0815','CANHETE - SANTA CRUZ DE FLORES'),
('0816','CANHETE - ZÚÑIGA')
go
('0901','CUSCO - CUSCO'),
('0902','CUSCO - ACOMAYO'),
('0903','CUSCO - ANTA'),
('0904','CUSCO - CALCA'),
('0905','CUSCO - CANAS'),
('0906','CUSCO - CANCHIS'),
('0907','CUSCO - CHUMBIVILCAS'),
('0908','CUSCO - ESPINAR'),
('0909','CUSCO - LA CONVENCION'),
('0910','CUSCO - PARURO'),
('0911','CUSCO - PAUCARTAMBO'),
('0912','CUSCO - QUISPICANCHI'),
('0913','CUSCO - URUBAMBA'),
('1001','DEL SANTA - DEL SANTA'),
('1101','HUANCAVELICA - HUANCAVELICA'),
('1102','HUANCAVELICA - ACOBAMBA'),
('1103','HUANCAVELICA - ANGARAES'),
('1104','HUANCAVELICA - CASTROVIRREYNA'),
('1105','HUANCAVELICA - CHURCAMPA'),
('1106','HUANCAVELICA - HUAYTARA'),
('1107','HUANCAVELICA - TAYACAJA'),
('1201','HUANUCO - HUANUCO'),
('1202','HUANUCO - AMBO'),
('1203','HUANUCO - DOS DE MAYO'),
('1204','HUANUCO - HUACAYBAMBA'),
('1205','HUANUCO - HUAMALIES'),
('1206','HUANUCO - LEONCIO PRADO'),
('1207','HUANUCO - MARAÑON'),
('1208','HUANUCO - PACHITEA'),
('1209','HUANUCO - PUERTO INCA'),
('1210','HUANUCO - LAURICOCHA'),
('1211','HUANUCO - YAROWILCA'),
('1301','HUAURA - AMBAR'),
('1302','HUAURA - CALETA DE ARQUIN'),
('1303','HUAURA - CHECRAS'),
('1304','HUAURA - HUALMAY'),
('1305','HUAURA - HUACHO'),
('1306','HUAURA - HUAURA'),
('1307','HUAURA - LEONCIO PRADO'),
('1308','HUAURA - PACCHO'),
('1309','HUAURA - SANTA LEONOR'),
('1310','HUAURA - SANTA MARIA'),
('1311','HUAURA - SAYÁN'),
('1312','HUAURA - VÉGUETA'),
('1401','ICA - ICA'),
('1402','ICA - CHINCHA'),
('1403','ICA - NAZCA'),
('1404','ICA - PALPA'),
('1405','ICA - PISCO'),
('1501','JUNIN - HUANCAYO'),
('1502','JUNIN - CONCEPCION'),
('1503','JUNIN - CHANCHAMAYO'),
('1504','JUNIN - JAUJA'),
('1505','JUNIN - JUNIN'),
('1506','JUNIN - SATIPO'),
('1507','JUNIN - TARMA'),
('1508','JUNIN - YAULI'),
('1509','JUNIN - CHUPACA'),
('1601','LA LIBERTAD - TRUJILLO'),
('1602','LA LIBERTAD - ASCOPE'),
('1603','LA LIBERTAD - BOLIVAR'),
('1604','LA LIBERTAD - CHEPEN'),
('1605','LA LIBERTAD - JULCAN'),
('1606','LA LIBERTAD - OTUZCO'),
('1607','LA LIBERTAD - PACASMAYO'),
('1608','LA LIBERTAD - PATAZ'),
('1609','LA LIBERTAD - SANCHEZ CARRION'),
('1610','LA LIBERTAD - SANTIAGO DE CHUCO'),
('1611','LA LIBERTAD - GRAN CHIMU'),
('1612','LA LIBERTAD - VIRU'),
('1701','LAMBAYEQUE - CHICLAYO'),
('1702','LAMBAYEQUE - FERREÑAFE'),
('1703','LAMBAYEQUE - LAMBAYEQUE'),
('1801','LIMA - LIMA'),
('1802','LIMA - BARRANCO'),
('1803','LIMA - BREÑA'),
('1804','LIMA - INDEPENDENCIA'),
('1805','LIMA - JESUS MARIA'),
('1806','LIMA - LA VICTORIA'),
('1807','LIMA - LINCE'),
('1808','LIMA - MAGDALENA DEL MAR'),
('1809','LIMA - PUEBLO LIBRE (MAGDALENA VIEJA)'),
('1810','LIMA - MIRAFLORES'),
('1811','LIMA - RIMAC'),
('1812','LIMA - SAN BORJA'),
('1813','LIMA - SAN ISIDRO'),
('1814','LIMA - SAN LUIS'),
('1815','LIMA - SAN MIGUEL'),
('1816','LIMA - SANTIAGO DE SURCO'),
('1817','LIMA - SURQUILLO'),
('1818','LIMA - BARRANCA'),
('1819','LIMA - CAJATAMBO'),
('1820','LIMA - CANTA'),
('1821','LIMA - CAÑETE'),
('1822','LIMA - HUARAL'),
('1823','LIMA - HUAROCHIRI'),
('1824','LIMA - HUAURA'),
('1825','LIMA - OYON'),
('1826','LIMA - YAUYOS'),
('1901','LIMA ESTE - ATE'),
('1902','LIMA ESTE - CHACLACAYO'),
('1903','LIMA ESTE - CIENEGUILLA'),
('1904','LIMA ESTE - EL AGUSTINO'),
('1905','LIMA ESTE - LA MOLINA'),
('1906','LIMA ESTE - LURIGANCHO-CHOSICA'),
('1907','LIMA ESTE - SAN JUAN DE LURIGANCHO'),
('1908','LIMA ESTE - SANTA ANITA'),
('2001','LIMA NORTE - ANCON'),
('2002','LIMA NORTE - CARABAYLLO'),
('2003','LIMA NORTE - COMAS'),
('2004','LIMA NORTE - LOS OLIVOS'),
('2005','LIMA NORTE - PUENTE PIEDRA'),
('2006','LIMA NORTE - SAN MARTIN DE PORRES'),
('2007','LIMA NORTE - SANTA ROSA'),
('2101','LIMA SUR - CHORRILLOS'),
('2102','LIMA SUR - LURIN'),
('2103','LIMA SUR - PACHACAMAC'),
('2104','LIMA SUR - PUCUSANA'),
('2105','LIMA SUR - PUNTA HERMOSA'),
('2106','LIMA SUR - PUNTA NEGRA'),
('2107','LIMA SUR - SAN BARTOLO'),
('2108','LIMA SUR - SAN JUAN DE MIRAFLORES'),
('2109','LIMA SUR - SANTA MARIA DEL MAR'),
('2110','LIMA SUR - VILLA EL SALVADOR'),
('2111','LIMA SUR - VILLA MARIA DEL TRIUNFO'),
('2201','LORETO - MAYNAS'),
('2202','LORETO - ALTO AMAZONAS'),
('2203','LORETO - LORETO'),
('2204','LORETO - MARISCAL RAMON CASTILLA'),
('2205','LORETO - REQUENA'),
('2206','LORETO - UCAYALI'),
('2207','LORETO - DATEM DEL MARAÑON'),
('2208','LORETO - IQUITOS'),
('2301','MADRE DE DIOS - TAMBOPATA'),
('2302','MADRE DE DIOS - MANU'),
('2303','MADRE DE DIOS - TAHUAMANU'),
('2304','MADRE DE DIOS - PTO. MALDONADO'),
('2401','MOQUEGUA - MARISCAL NIETO'),
('2402','MOQUEGUA - GENERAL SANCHEZ CERRO'),
('2403','MOQUEGUA - ILO'),
('2501','PASCO - PASCO'),
('2502','PASCO - DANIEL ALCIDES CARRION'),
('2503','PASCO - OXAPAMPA'),
('2601','PIURA - PIURA'),
('2602','PIURA - AYABACA'),
('2603','PIURA - HUANCABAMBA'),
('2604','PIURA - MORROPON'),
('2605','PIURA - PAITA'),
('2606','PIURA - SULLANA'),
('2607','PIURA - TALARA'),
('2608','PIURA - SECHURA'),
('2701','PUNO - PUNO'),
('2702','PUNO - AZANGARO'),
('2703','PUNO - CARABAYA'),
('2704','PUNO - CHUCUITO'),
('2705','PUNO - EL COLLAO'),
('2706','PUNO - HUANCANE'),
('2707','PUNO - LAMPA'),
('2708','PUNO - MELGAR'),
('2709','PUNO - MOHO'),
('2710','PUNO - SAN ANTONIO DE PUTINA'),
('2711','PUNO - SAN ROMAN'),
('2712','PUNO - SANDIA'),
('2713','PUNO - YUNGUYO'),
('2714','PUNO - JULIACA'),
('2801','SAN MARTIN - MOYOBAMBA'),
('2802','SAN MARTIN - BELLAVISTA'),
('2803','SAN MARTIN - EL DORADO'),
('2804','SAN MARTIN - HUALLAGA'),
('2805','SAN MARTIN - LAMAS'),
('2806','SAN MARTIN - MARISCAL CACERES'),
('2807','SAN MARTIN - PICOTA'),
('2808','SAN MARTIN - RIOJA'),
('2809','SAN MARTIN - SAN MARTIN'),
('2810','SAN MARTIN - TOCACHE'),
('2811','SAN MARTIN - TARAPOTO'),
('2901','SELVA CENTRAL - SELVA CENTRAL'),
('3001','SULLANA - SULLANA'),
('3101','TACNA - TACNA'),
('3102','TACNA - CANDARAVE'),
('3103','TACNA - JORGE BASADRE'),
('3104','TACNA - TARATA'),
('3201','TUMBES - TUMBES'),
('3202','TUMBES - CONTRALMIRANTE VILLAR'),
('3203','TUMBES - ZARUMILLA'),
('3301','UCAYALI - CORONEL PORTILLO'),
('3302','UCAYALI - ATALAYA'),
('3303','UCAYALI - PADRE ABAD'),
('3401','VENTANILLA - LIMA NOROESTE - VENTANILLA')
go
insert into Juzgados values
('JP','JURADO DE PAZ LETRADO'),
('JE', 'JURADO ESPECIALIZADO'),
('JM','JURADO MIXTO'),
('SS','SALA SUPERIOR')
go
insert into Materias values
('CI','CIVIL'),
('CO','COMERCIAL'),
('FC','FAMILIAR CIVIL'),
('FT','FAMILIAR TUTELAR'),
('LA','LABORAL'),
('CA','CONTENCIOSO ADMINISTRATIVO'),
('PE','PENAL')
go


select * from Usuario
select * from Cliente
select * from Codificacion_Expediente
select * from Expediente
select * from Archivo
select * from Procedimiento
delete from Archivo
delete from Procedimiento
delete from Expediente
delete from Codificacion_Expediente
delete from Cliente
delete from Usuario where username like 'cli-%'

SELECT DISTINCT (select top 1 value from string_split(Ubicacion,'-') order by value desc) as Dist from Distritos_Legales

delete from Distritos_Legales where Codigo like '08%'