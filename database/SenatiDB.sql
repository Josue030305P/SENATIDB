CREATE DATABASE SENATIDB;
USE SENATIDB;

CREATE TABLE marcas
(

	idmarca 	INT AUTO_INCREMENT PRIMARY KEY,
    marca		VARCHAR(30)		NOT NULL,
    create_at	DATETIME 		NOT NULL DEFAULT NOW(),
    inactive_at	DATETIME		NULL,
    updated_at	DATETIME 		NULL,
    CONSTRAINT ul_marca_mar	 UNIQUE(marca)
  

);



INSERT INTO marcas(marca)
	VALUES
    ('Toyota'),
    ('Nissan'),
    ('Volvo'),
    ('Hyundai'),
    ('KYA');

SELECT * FROM marcas;

CREATE TABLE vehiculos

(

	idvehiculo		INT AUTO_INCREMENT PRIMARY KEY,
    idmarca			INT 	NOT NULL,
    modelo			VARCHAR(50)	NOT NULL,
    color			VARCHAR(30) NOT NULL,
    tipocombustible	CHAR(3) NOT NULL,
    peso			SMALLINT	NOT NULL,
    afabricacion	CHAR(4)		NOT NULL,
    placa			CHAR(7) NOT NULL,
	create_at	DATETIME 		NOT NULL DEFAULT NOW(),
    inactive_at	DATETIME		NULL,
    updated_at	DATETIME 		NULL,
    CONSTRAINT fk_idmarca FOREIGN KEY(idmarca) REFERENCES marcas(idmarca),
    CONSTRAINT ck_tipocombustible_veh CHECK(tipocombustible IN('GSL','DSL','GNV','GLP')),
    CONSTRAINT ck_peso_vech CHECK(peso >0),
	CONSTRAINT uk_placa UNIQUE(placa)
);


CREATE TABLE sedes
(
idsede 		INT AUTO_INCREMENT 	PRIMARY KEY,
sede		VARCHAR(30) 	NOT NULL,
create_at	DATETIME 		NOT NULL DEFAULT NOW(),
inactive_at	DATETIME		NULL,
updated_at	DATETIME 		NULL,

CONSTRAINT un_sede UNIQUE(sede)

);



INSERT INTO sedes(sede)
			VALUES('Ayacucho'),
				('Lima');


UPDATE empleados SET
nombres = "Victor Cesár"
WHERE idempleado = 6;

CREATE TABLE empleados(
idempleado		INT AUTO_INCREMENT PRIMARY KEY,
idsede			INT			NOT NULL,
apellidos		VARCHAR(50) NOT NULL,
nombres			VARCHAR(50) NOT NULL,
ndocumento		CHAR(8) NOT NULL,
fechanacimiento	DATE 		NOT NULL,
telefono		CHAR(9) 	NOT NULL,
create_at	DATETIME 		NOT NULL DEFAULT NOW(),
inactive_at	DATETIME		NULL,
updated_at	DATETIME 		NULL,


CONSTRAINT fk_idsede FOREIGN KEY(idsede) REFERENCES sedes(idsede),
CONSTRAINT un_ndoc UNIQUE(ndocumento),
CONSTRAINT un_telefono UNIQUE(telefono),
CONSTRAINT chk_telefono CHECK(telefono REGEXP '^9[0-9]{8}$')

);



INSERT INTO empleados(idsede,apellidos,nombres,ndocumento,fechanacimiento,telefono)
			VALUES(1,'Pilpe Yataco','Ernesto','71880056','2005-03-03','936557176');
			

SELECT * FROM empleados;

INSERT INTO vehiculos
	(idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
    VALUES
		(1,'Hilux','Blanco','DSL',1800,'2020','ABC-111	'),
		(2,'Sentra','Gris','GSL',1200,'2021','ABC-112'),
        (3,'EX30','Negro','GNV',1350,'2023','ABC-113'),
        (4,'Tucson','Rojo','GLP',1800,'2022','ABC-114'),
        (5,'Sportage','Rojo','DSL',1500,'2010','ABC-115');

SELECT * FROM vehiculos;


DELIMITER $$
CREATE PROCEDURE spu_vehiculos_buscar(IN _placa CHAR(7))
BEGIN

	SELECT 
			VEH.idvehiculo,
            MAR.marca,
            VEH.modelo,
            VEH.color,
            VEH.tipocombustible,
            VEH.peso,
            VEH.afabricacion,
            VEH.placa
			FROM vehiculos 	VEH
			INNER JOIN marcas MAR ON MAR.idmarca = VEH.idmarca
			WHERE (VEH.inactive_at IS NULL) AND
				  (VEH.placa = _placa);

END $$


CALL spu_vehiculos_buscar('ABC-111	');


DELIMITER $$
CREATE PROCEDURE spu_vehiculos_registrar
(
IN _idmarca		INT,
IN _modelo		VARCHAR(50),
IN _color		VARCHAR(30),
IN _tipocombustible	CHAR(3),
IN _peso		SMALLINT,
IN _afabricacion CHAR(4),
IN _placa		CHAR(7)
)

BEGIN

	INSERT INTO vehiculos(idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
				VALUES(_idmarca,_modelo,_color,_tipocombustible,_peso,_afabricacion,_placa);
	SELECT @@last_insert_id 'idvehiculo';

END $$

CALL  spu_vehiculos_registrar(1,'Lauren','Azul','GNV',1200,2023,'ABC-116');
CALL  spu_vehiculos_registrar(4,'Creta','Azul','GNV',1200,2021,'ABC-118');

SELECT * FROM vehiculos;


DELIMITER $$
CREATE PROCEDURE spu_marcas_listar()

BEGIN
SELECT 
	idmarca,
    marca
	FROM marcas
    WHERE inactive_at IS NULL
    ORDER BY marca;
END $$

CALL spu_marcas_listar();

DELIMITER $$
CREATE PROCEDURE spu_empleados_listar()
BEGIN

	SELECT
    em.idempleado,
    sed.sede,
    em.apellidos,
    em.nombres,
    em.ndocumento,
    em.fechanacimiento,
    em.telefono
     
     
     FROM empleados em
     INNER JOIN sedes sed ON sed.idsede = em.idsede
     WHERE em.inactive_at IS NULL
     ORDER BY em.apellidos;

END $$

CALL spu_empleados_listar()

UPDATE empleados 
SET inactive_at = NOW()
WHERE idempleado = 6;

DELIMITER $$
CREATE PROCEDURE spu_empleados_registrar(
IN _idsede 			INT,
IN _apellidos 		VARCHAR(50),
IN _nombres			VARCHAR(50),
IN _ndocumento 		VARCHAR(15),
IN _fechanacimiento	 DATE,
IN _telefono 		CHAR(9)

)

BEGIN

	INSERT INTO empleados(idsede,apellidos,nombres,ndocumento,fechanacimiento,telefono)
    
				VALUES(_idsede,_apellidos,_nombres,_ndocumento,_fechanacimiento,_telefono);
	SELECT @@last_insert_id 'idempleado';

END $$
drop procedure spu_empleados_registrar

CALL  spu_empleados_registrar(1,'Gabriel','Pachas Meneses','78955624','1982-05-15','963366441');	

SELECT * FROM SEDES;

DELIMITER  $$

CREATE PROCEDURE spu_sedes_listar()

BEGIN

	SELECT
		idsede,
        sede
		FROM sedes
        WHERE inactive_at IS NULL
        ORDER BY sede;

END $$

CALL spu_sedes_listar();

DELIMITER $$
CREATE PROCEDURE spu_empleados_buscar(IN _ndocumento char(8))

BEGIN

	SELECT
    em.idempleado,
    sed.sede,
    em.apellidos,
    em.nombres,
    em.fechanacimiento,
    em.telefono
    
    FROM empleados em
    INNER JOIN sedes sed ON sed.idsede = em.idsede
    WHERE (em.inactive_at IS NULL) AND
		(em.ndocumento =_ndocumento);


END $$
USE SENATIDB;
CALL  spu_empleados_buscar('71547825');
SELECT * FROM empleados;

DELIMITER $$
CREATE PROCEDURE spu_empleados_por_sede()
BEGIN
    SELECT
        sed.idsede,
        sed.sede,
        COUNT(em.idempleado) AS cantidad_empleados,
        GROUP_CONCAT(em.nombres, ' ', em.apellidos) AS nombres_empleados
    FROM sedes sed
    LEFT JOIN empleados em ON sed.idsede = em.idsede AND em.inactive_at IS NULL
    GROUP BY sed.idsede
    ORDER BY sed.sede;
END $$
DELIMITER ;

CALL spu_empleados_por_sede();