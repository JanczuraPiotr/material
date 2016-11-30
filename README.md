Pobranie źródeł z repozytorium:

git clone https://JanczuraPiotr@bitbucket.org/JanczuraPiotr/material.git

cd material

Pobrać composer.phar ze strony :

https://getcomposer.org/download/

i zainstalować według wskazówek

uruchomić
./composer.par install

w czasie pracy composer zapyta o dane do bazy danych.
Jeżeli nie zostaną podane w tym momencie można po zakończeniu instalacji uzupełnić plik material/app/config./parameters.yml.

Gdy baza danych istnieje i skonfigurowano dostęp do niej można utworzyć tabele:

php app/console doctrine:schema:create


Może wystąpić problem z prawami dostępu do katalogów app/cache i app/logs rozwiązujemy go poleceniami:

rm -rf app/cache/*
rm -rf app/logs/*
sudo setfacl -R -m u:www-data:rwX -m u:'whoami':rwX app/cache app/logs
sudo setfacl -dR -m u:www-data:rwx -m u:'whoami':rwx app/cache app/logs


Może być konieczność skonfigurowania servera www.

w pliku /etc/hosts/
adres_ip_tego_kompuera: material.pc

a w pliku definiującym servery wirtualne dodać:

```
<VirtualHost *:80>
   ServerName material.pc
   DocumentRoot /home/piotr/public_html/material/web

   <Directory /home/piotr/public_html/material/web>
		AllowOverride All
		#Order allow,deny
		Allow from All
   </Directory>
</VirtualHost>
```