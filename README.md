*Seg*uimineto de *Vuln*erabilidades
=========================================

Herramienta para seguimiento de vulnerabilidades desarrollada en Synfony 4.

#Dependencias

```sudo apt install php php-sqlite3 php-xml php-ldap```
	
#Instalación:

1. Clonar el respositorio:

```
$ git clone https://github.com/nachol/segvuln.git
```

2. Modificar archivo del entorno ```.env```:

Ejemplo:

```
# This file is a "template" of which env vars need to be defined for your application
# Copy this file to .env file for development, create environment variables when deploying to production
# https://symfony.com/doc/current/best_practices/configuration.html#infrastructure-related-configuration
###> symfony/framework-bundle ###
APP_ENV=dev
APP_DEBUG=1
APP_SECRET=ChangeMe
#TRUSTED_PROXIES=127.0.0.1,127.0.0.2
#TRUSTED_HOSTS=localhost,example.com
###< symfony/framework-bundle ###
###> doctrine/doctrine-bundle ###
# Format described at http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# For an SQLite database, use: "sqlite:///%kernel.project_dir%/var/data.db"
# Configure your db driver and server_version in config/packages/doctrine.yaml
#DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
###< doctrine/doctrine-bundle ###
#SQLite
DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"
```

3. Instalar Vendors con composer (incluido en el repositorio):

```
$ composer install
```

If vuln notifications it is recommended to update

```
$ composer update  
```

4. Crear base de datos y esquema:

```	
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
```	

5. Crear vulnerabilidades o Importarlas de Serpico (https://github.com/SerpicoProject/Serpico)
	
	1. Creacion Manual

	Componentes --> Tipos de Vulnerabilidad --> Nuevo tipo de Vulnerabilidad

	2. Importación de Serpico
		Componentes --> Tipos de Vulnerabilidad --> Choose File --> Importar Vulnerabilidades


	File Template:

```		
		    [
		      {
		        "id": 41,
		        "title": "Inyección de SQL",
		        "damage": null,
		        "reproducability": null,
		        "exploitability": null,
		        "affected_users": null,
		        "discoverability": null,
		        "dread_total": null,
		        "effort": "Medio",
		        "type": "Web Application",
		        "overview": "<paragraph>Un ataque por inyección SQL consiste en la inserción o “inyección” de una consulta SQL por medio de los datos de entrada desde el cliente hacia la aplicación. Un ataque por inyección SQL exitoso puede leer información sensible desde la base de datos, modificar la información (Insert/ Update/ Delete), ejecutar operaciones de administración sobre la base de datos (tal como parar la base de datos), recuperar el contenido de un determinado archivo presente sobre el sistema de archivos del DBMS y en algunos casos emitir comandos al sistema operativo. Los ataques por inyección SQL son un tipo de ataque de inyección, en el cual los comandos SQL son insertados en la entrada de datos con la finalidad de efectuar la ejecución de comandos SQL predefinidos.</paragraph>",
		        "poc": "<paragraph></paragraph>",
		        "remediation": "<paragraph>[1] Validar todos los datos especificados por el usuario:</paragraph><paragraph>Valide siempre los datos especificados por el usuario mediante comprobaciones de tipo, longitud, formato e intervalo. A la hora de implementar medidas de precaución frente a la especificación de datos dañinos, tenga en cuenta la arquitectura y los escenarios de implementación de la aplicación. Recuerde que los programas diseñados para ejecutarse en un entorno seguro pueden copiarse en un entorno no seguro</paragraph><paragraph></paragraph><paragraph>[2] Revisar el código para la inyección de código SQL:</paragraph><paragraph>Debe revisar todos los códigos que llaman a EXECUTE, EXEC o sp_executesql. Puede utilizar consultas similares a las siguientes para ayudarle a identificar los procedimientos que contienen estas instrucciones. Esta consulta comprueba si hay 1, 2, 3 ó 4 espacios después de las palabras EXECUTE o EXEC.</paragraph>",
		        "references": "<paragraph>https://www.owasp.org/index.php/Inyección_SQL</paragraph><paragraph>https://technet.microsoft.com/es-es/library/ms161953(v=sql.105).aspx</paragraph>",
		        "approved": true,
		        "risk": 4,
		        "affected_hosts": null,
		        "av": null,
		        "ac": null,
		        "au": null,
		        "c": null,
		        "i": null,
		        "a": null,
		        "e": null,
		        "rl": null,
		        "rc": null,
		        "cdp": null,
		        "td": null,
		        "cr": null,
		        "ir": null,
		        "ar": null,
		        "cvss_base": null,
		        "cvss_impact": null,
		        "cvss_exploitability": null,
		        "cvss_temporal": null,
		        "cvss_environmental": null,
		        "cvss_modified_impact": null,
		        "cvss_total": null,
		        "ease": null
		      }
	  	    ]
```


#Docker
```
docker-compose up --build
```
Lleva un tiempo la instalación de dependencias. Luego acceder a [http://127.0.0.1:8080/index.php](http://127.0.0.1:8080/index.php)