# Description

Docker using compose, configuration file with environment variables, 
creating a nginx 1.13.3 container and a php *-fpm 
container linked via a link and creating a mysql 5.7.19 container.
# Nginx Container Configuration

1. Door Display

        80 and 443

2. Volume (Note: In Docker -> Shared Drivers configuration, c: and / or d: drives are enabled)

        Application: htdocs -> / var / www / html
        
        Logs: nginx / logs -> / var / log / nginx
        
        Virtual Host: nginx / sites -> /etc/nginx/conf.d

3. Virtual Host

Creating vhost template http://localhost

# Php Container Configuration

1. Door Display

        9000

2. Volume (Note: In Docker -> Shared Drivers configuration, c: and / or d: drives are enabled)

        Application: htdocs -> / var / www / html

3. Libraries

    Enabling php libraries through configuration file. Ex: MBSTRING, GD, MCRYPT, PDO_MYSQL, etc.

# Mysql Container Configuration

1. Door Display

        3306

2. Volume (Note: In Docker -> Shared Drivers configuration, c: and / or d: drives are enabled)

        Application: mysql / data -> / var / lib / mysql

3. Connection Setup

- MYSQL_DATABASE = default

    - MYSQL_USER = default

    - MYSQL_PASSWORD = secret

    - MYSQL_ROOT_PASSWORD = root

    - MYSQL_PORT = 3306

# How to use

1. Clone the repository using the command:

        download zip
   
2. Enter the folder and copy the env-example file to .env.

           cp env-example .env

3. Rotate your container:

           docker-compose -p ms_app up -d

4. Add the domains to the windows hosts file.

           127.0.0.1 localhost
         
5. Open in browser

   http: // localhost 


6. Access the container shell:
    
    
        winpty docker exec -it ms_cundo_nginx bash
        
        winpty docker exec -it ms_cundo_php-fpm bash
        
        winpty docker exec -it ms_cundo_mysql bash


 