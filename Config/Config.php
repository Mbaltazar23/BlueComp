<?php

const BASE_URL = "http://localhost/BlueComp";

//Zona horaria
date_default_timezone_set('America/Santiago');

//Datos de conexión a Base de Datos
const DB_HOST = "localhost";
const DB_NAME = "bluecomp";
const DB_USER = "root";
const DB_PASSWORD = "1234";
const DB_CHARSET = "utf8";
//Deliminadores decimal y millar Ej. 24,1989.00
const SPD = ".";
const SPM = ",";
//Simbolo de moneda
const SMONEY = "$";
//Datos envio de correo
const TITLE = "Blue-Comp";
const TITLE_ADMIN = "Panel Administrativo";
const NOMBRE_EMPESA = "Blue-Comp";
const WEB_EMPRESA = "www.blueComp.com";
//metodo de encriptacion
const KEY = 'mbaltazar';
const METHODENCRIPT = "AES-128-ECB";


const MENUCAT = "7";
const CANTPORDHOME = 4;
const IDCATCUPON = 10;
const LASTPRODUCTOS = 5;
const SINNEGOCIO = 5;
const ROLCLIENTE = 5;
const ROLCLI = "Cliente";
const ROLJEFA = "Jefa";
const ROLCONTAUD = "Contador Auditor";
const ROLANALIST = "Analista-financiero";
const ROLADMINEMP = "Administrador de Empresas";
const PROPORPAGINA = 4;
const PROCATEGORIA = 4;
const PROBUSCAR = 5;

const COSTOENVIO = 1500;
?>