feature:
  - docker
  - images docker:
    - php8-apache
    - mysql 8
    - php-myadmin
  - framework
    - symfony 6.2

usage:
  - download docker-desktop
  - install docker-desktop
  - OS:
    - windows, modify the host system c:/windows/system32/drivers/etc/host and add the line 127.0.0.1 docker.local
    - linux, modify the host system /etc/host and add the line 127.0.0.1 docker.local
  - run commande docker-compose up -d
  
you can access of the page web to http://docker.local a certificat ssl is enabled

important:
    install a dependance of symfony:
      - docker exec -ti app bash
      - install dependance which you need
  
