# EVALUATION EN COURS DE FORMATION :
## Développer L'API d'une Salle de Sport :

Evaluation réalisée par Julien LABATUT lors de la Formation "*Graduate Développeur Mobile Android*", promotion ATIYAH. 

### Livrables contenues dans ce dépôt (Dossier "LIVRABLES") :
- **Création de la base de données.sql :** Fichier SQL regroupant l'ensemble des commandes pour créer la base de données et ses tables, ainsi que les commandes permettant d'insérer dans ces tables des données factices et cohérentes.
- **Documentation technique.pdf :** Fichier PDF regroupant les diagrammes de classe, de cas d'utilisation...
- **Manuel d'utilisation.pdf :** Fichier PDF regroupant les directives nécessaire au fonctionnement et à l'administration de l'application.

### Contexte de l'évaluation :

#### Objectifs :

L’objectif du projet est de mener une étude (Analyse des besoins) et développer l’application web présentée ci-dessous. Il convient également d’élaborer un dossier d’architecture web qui documente entre autres les choix des technologies, les choix d’architecture web et de configuration, les bonnes pratiques de sécurité́ implémentées, etc.

Il est également demandé d’élaborer un document spécifique sur les mesures et bonnes pratiques de sécurité́ mises en place et la justification de chacune d’entre elles. Les bases de données et tout autre composant nécessaire pour faire fonctionner le projet sont également accompagnés d’un manuel de configuration et d’utilisation.

#### Exigences :

Notre client est une grande marque de salle de sport et souhaite la création d’une interface simple à destination de ses équipes qui gèrent les droits d'accès à ses applications web de ses franchisés et partenaires qui possèdent des salles de sport. Ainsi, lorsqu'une salle de sport ouvre et prend la franchise de cette marque, on lui donne accès à un outil de gestion en ligne. En fonction de ce qu’il va reverser à la marque et de son contrat, il a droit à des options ou modules supplémentaires. Par exemple, un onglet “faire son mailing” ou encore "gérer le planning équipe" ou bien “promotion de la salle" ou encore “vendre des boissons” peut être activé ou désactivé.

Le projet a donc pour but la création et la construction d’une interface cohérente et ergonomique afin d’aider leurs équipes à ouvrir des accès aux modules de leur API auprès des franchisés/partenaires.

L’interface devra permettre de donner de la visibilité́ sur les partenaires/franchisés utilisant l’API et quels modules sont accessibles par ces partenaires. Elle doit faciliter l'ajout, la modification ou la suppression des permissions aux modules de chaque partenaire/franchisé.

#### Cible :

L’interface sera utilisée par l’équipe technique de développement de la marque.

#### Périmètre du projet :

L’interface devra avoir un design responsive et être rédigée en Français. Liste des fonctionnalités : - Afficher la liste des partenaires actifs, - Afficher la liste des partenaires désactivés, - Consulter les différentes structures des partenaires (activées et désactivées),
- Modifier les permissions des structures,
- Ajouter une nouvelle structure à un partenaire avec des permissions prédéfinies entre un technicien du client et le partenaire concerné,
- Envoyer automatiquement un email après l’ajout d’une structure au partenaire concerné,
- Possibilité de confirmation d’accès aux données de la structure par le partenaire,
- Afficher le contenu du mail dans un nouvel onglet.
Pour finir, elle devra être intégrée à l’outil interne et la base de données existante. Vous êtes donc libre d’adapter d'éventuelles données entrantes.

### Déploiement en local :
Le déploiement en local de cette application suggère que vous disposez au minimum d'un serveur local (Apache), de PHP 8.1, de MySQL et de Symfony 5, les trois premiers étant fournis par Xampp par exemple.

 - Dans un premier temps, ouvrez un invite de commande, clonez le dépôt Git de l'application et naviguez jusqu'au dossier précédemment créé :
```
https://github.com/Skoognuts/ECF-Graduate-Developpeur.git
cd ECF-Graduate-Developpeur
```
 - Installez les dépendances de l'application :
```
composer install
```
 - Modifiez le fichier environnement ( .env situé dans le dossier racine ) afin d'y lier votre propre base de données. L'URL de cette dernière doit être modifiée dans la ligne suivante :
 ```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name
```
 - Toujours dans ce même fichier .env, modifiez la variable d'environnement afin de la passer en développement, sinon, vos modifications ne seront pas prises en compte :
```
APP_ENV=dev
```
 - Remplacez "db_user" par votre nom d'utilisateur (en règle générale, "root" en local), "db_password" par votre mot de passe et "db_name" par le nom que vous souhaitez donner à votre base de données. Afin de valider cette manipulation, créez la base de données et effectuez la migration.
```
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
 - Enfin, lancez le serveur local :
```
symfony server:start
```
### Déploiement en ligne :
Le déploiement en ligne se fait via Heroku et suggère que vous y ayez un compte.
 - Dans un premier temps, connectez vous à votre compte Heroku depuis un invite de commande, puis créez un nouveau projet :
```
heroku login
heroku create
```
- Si le fichier Procfile ne se trouve pas à la racine de l'application, créez-le. Attention, il est impératif que ce fichier n'ait pas d'extension :
```
echo 'web: heroku-php-apache2 public/' > Procfile
```
- Modifiez le fichier d'environnement afin de passer en mode production :
```
heroku config:set APP_ENV=prod
heroku config:set APP_SECRET=$(php -r 'echo bin2hex(random_bytes(16));')
``` 
- Configurez votre projet Heroku en y ajoutant un gestionnaire de base de données (JawsDB):
```
heroku addons:create jawsdb-maria:kitefin
```
- Reportez l'adresse de votre base de données sur JawsDB dans votre fichier d'environnement :
```
heroku config:get JAWSDB_MARIA_URL
heroku config:set DATABASE_URL=your_db_url
```
- Enfin, lancez le déploiement en créant un commit et en réalisant un push sur votre projet Heroku :
```
git add .
git commit -m "Create heroku production configuration"
git push heroku main
```
---

**Julien Labatut :**
- **Mail :** j.labatut33127@gmail.com.
- **GitHub :** https://github.com/Skoognuts.