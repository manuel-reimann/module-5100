# Custom CMS: Pixlify
- Projekt von Manuel Reimann
- WDD 921, Modul WBD5100
- Abgabedatum: 22.10.2022 

- - -
## Informationen zur Datenbank
Die Datenbank-Datei befindet sich direkt im Ordner "Modulprojekt" und heisst "a_pixlify.sql". Diese kann direkt so im localhost installiert werden. 
Um die Datenbank zu konfigurieren, sollte man die DB-Konfigurationsdatei bearbeiten. Diese befindet sich hier: "admin/includes/dbh.inc.php". Momentane Einsttellungen: 

$serverName ="localhost";
$dbUsername ="root";
$dbPassword ="root"; 
$dbName ="a_pixlify";

Sollte Windows / XAMP verwendet werden, sollte die Variable $dbPassword auf "" gesetzt werden. Ausserdem sollte folgende Ordnerpfade noch angepasst werden: 

define( 'IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/Modul_5100/Modulprojekt/'.IMAGE_FOLDER);
define( 'ZIP_PATH', $_SERVER['DOCUMENT_ROOT'].'/Modul_5100/Modulprojekt/'.ZIP_FOLDER);

Hier "/Modul_5100/Modulprojekt/" sollte der Ordnerpfad angepasst werden auf das Verzeichnis wo das Projekt gespeichert wurde. 

## Login
Es gibt grundsätzlich 2 Logins. Ersteres ist nur für Kunden gedacht und befindet sich im Frontend wenn die Navigation geöffnet wird. Das zweite ist für Administratoren und Teammitglieder gedacht und ist zur Sicherheit nur direkt über die Domain aufrufbar. 
-Userlogin: customers.php (oder über Burgermenu links oben)
-Adminlogin: /admin/admin.php 

## Logindaten
### Typ Admin
Benutzername: Admin
Passwort: Test123?

### Typ Teammember
Benutzername: Teammember
Passwort: Test123?

### Typ Customer
Benutzername: Customer
Passwort: Test123?

Benutzername: Swisscom
Passwort: Test123?

## Technische Basis
Das Projekt wurde mit HTML, CSS, Javascript, PHP und MYSQL erstellt. Ausserdem wurden Frameworks & Libaries wie Tailwind und Fontawesome benutzt. Die Umgebung lässt sich wie folgt zusammenfassen: 

PHP-Version: 8.0.8
Webserver: Apache
lokaler Webserver: Mamp
Datenbankserver: MySQL Version 5.7.34
MySQL-Port: 8889


_______________________________________________________________


# Pixlify - about the project / layout / future possibilites
## Custom CMS for my one-man business
I need a website where I can easily display my offers and add/edit them without opening the code editor. It's also designed as a multi-role CMS mainly to give the customers access to their data, but also to give potential colleagues the option to promote their own offerings on my site or if my business would grow. 

## Structure Frontend
### Index
-simple, low contrast design
-short access buttons
-burger menu
-possibility to access customer data via burger menu

### photo, video & web sites
-articles displayed in a blog-post style
-easy customizable in backend

## Structure Backend
### Admin
-login with session start

### Dashboard
-simple, quick access welcome point 
-displays all possible actions for the current user

### Articles
-add new articles to display in the frontendpages photo, video or web
-display list of all articles in the DB with relevant informations
-possibility to delete articles 
-possibility to edit articles in a modal style sub-site
-the name of the last person who created or edited the article is visible in the list
-the timestamp when the article was last edited is shown

### Users
-register new Admins, Teammembers or Customers
-display list of all Users in the DB with relevant informations
-possibility to delete Users 
-possibility to edit Users in a modal style sub-site

### Customers
-upload zip files for the customer to download
-create photogalleries to display photos for the customer
-create keys & links to share with the customer


## PHP Concept 
### Acess restriction
-Users from type customers should not be able to acess the backkend
-Customer content is only acessible for the specific customer or Admins / Teammembers
-Admins can create and edit new Admins, Teammembers and Customers
-Teammembers have no acess to User management
-Admins and Teammembers can create and edit new Articles





