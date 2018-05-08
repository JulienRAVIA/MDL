# Maison des Ligues - Application Web

![Maison des Ligues](https://julienravia.fr/img/miniature-mdl.png)

Application web du Projet Personnel Encadré "Maison des Ligues" de deuxième année de BTS SIO.

Cette application sert à recenser les avis des participants aux ateliers

## Installation

Installer les composants: 
Executez la commande ``composer install --no-dev`` dans l'invite de commande à la racine du dossier

**Si en environnement de dev pour générer les tests unitaires, la documentation, executer la commande ``composer install --dev``**

Changer les identifiants de base de données: Dans le fichier ``src\App\Database.php`` changer les valeurs des variables de la classe

## Démarrage

Il faut placer le projet dans un serveur local
Si possible, créer un virtual host (avec WAMP par exemple) qui pointe vers public, sinon decommenter la ligne suivante dans ``/public/index.php`` (ligne 7) :
```
// $router->setBasePath('/MDL/public');
```

Ne mettre en production que la version de "prod", c'est à dire sans les dépendances de dev, pour supprimer les dépendances de dev si elles sont installées, executer la commande ``composer install --no-dev`` avant d'envoyer en production

## Documentation

* Lien vers la documentation de l'application PHP  : https://julienravia.github.io/MDL/
* Lien vers la documentation de l'application C# : https://julienravia.github.io/MDL/csharp

Lancer la mise à jour/regénération de la documentation avec la commande suivante (à la racine du projet) : 
``vendor\bin\apigen generate src --destination docs``

## Composants

* [Twig](https://twig.symfony.com/doc/2.x/) - Moteur de template
* [PHPUnit](https://phpunit.de) - Système de tests unitaires pour PHP
* [AltoRouter](http://altorouter.com) - Système de routeur pour PHP
* [ApiGen](https://github.com/ApiGen/ApiGen) -Génération de la documentation (PHP 7.1)

## Auteurs

* [Julien Ravia](http://julienravia.fr)

## Participants du projet

* [Leo Leroy](http://leoleroy.fr)
* [Thomas Cianfarani](http://thomascianfarani.fr)
