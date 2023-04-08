# Eventplace

***Created by [Rihantiana]() and [Loïc]()***

Our main goal is to allow people to **buy tickets** for any type of event easily. Eventplace is a platform where both ticket buyers and event organisator can fulfill their needs.

Notre but principal est de permettre aux gens **d'acheter des tickets** pour n'importe quel type d'évènement. Eventplace est une plateforme où les clients et les organisateurs d'évènements peuvent satisfaire leurs besoins.

## How to install | Comment installer

### Database configuration | Configuration de base de données

Create a database called **"eventplace_db"** in your mysql databases and then, import the file at **"eventplace/server/app/config/database.sql"**

Créez une base de données appelée **"eventplace_db"** dans vos bases de données mysql et ensuite, importez le fichier du répertoire **"eventplace/server/app/config/database.sql"**

### Edit your .env | Editer votre .env

Create a ***.env*** file in the **server** folder, follow the template bellow and then change the informations in it according to your informations.

Créez un fichier ***.env*** dans le dossier **server**, suivez le modèle ci-dessous et ensuite, changez les informations qui s'y trouvent afin qu'ils correspondent à vos informations.

```dotenv
# Database info
DB_NAME = "eventplace_db"
DB_USER = "your_username"
DB_PASSWORD = "your_password"

PORT = 80

SECRET_KEY = "souper_seekret_key"
```

### Include dependencies | Inclure les dépendances

Open a new **Terminal**. Go to the client directory using this command :

Ouvrez un nouveau **Terminal**. Allez dans le dossier client en utilisant cette commande :

```bash
cd ./client
```

Then execute this command :

Ensuite, exécutez cette commande :

```bash
npm install
```

Repeat the same process but instead, go to the **server** directory (**cd ./server**) and execute this other command :

Répéter le même processus mais rendez-vous dans le dossier **server** (**cd ./server**) et exécuter cette autre commande :

```bash
composer install
```