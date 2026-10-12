# Catalogue de Véhicules – Glinche Automobiles

Application web développée avec **Laravel** (Backend) et **Vue.js 3** (Frontend), permettant de consulter le catalogue de véhicules de l'API Partenaires de Glinche Automobiles avec un filtre dynamique par marque.

---

## Sommaire

1. [Prérequis](#prérequis)
2. [Installation du projet](#installation-du-projet)
3. [Configuration des variables d&#39;environnement](#configuration-des-variables-denvironnement)
4. [Lancement de l&#39;application](#lancement-de-lapplication)
   - [1. Lancer le backend (Laravel)](#1-lancer-le-backend-laravel)
   - [2. Lancer le frontend (Vue.js / Vite)](#2-lancer-le-frontend-vuejs--vite)
5. [Choix techniques effectués](#choix-techniques-effectués)
   - [Architecture Backend (Laravel)](#architecture-backend-laravel)
   - [Architecture Frontend (Vue.js 3)](#architecture-frontend-vuejs-3)
   - [Design &amp; CSS](#design--css)
6. [Difficultés rencontrées &amp; Solutions](#difficultés-rencontrées--solutions)

---

## Prérequis

Assurez-vous d'avoir installé sur votre machine :

* **PHP** 8.3 ou supérieur (recommandé 8.3 ou 8.4) avec les extensions `pdo_sqlite`, `curl`, `mbstring`, `openssl`
* **Composer** (gestionnaire de dépendances PHP)
* **Node.js** (v20+) et **npm**
* **Git**

> **Note sur la configuration PHP (Windows / Mac / Linux) :**  
> Vérifiez dans votre fichier `php.ini` que les extensions suivantes sont bien activées (décommentées, sans point-virgule `;` au début) :  
> `extension=pdo_sqlite`, `extension=curl`, `extension=mbstring`, `extension=openssl`, `extension=fileinfo`.

---

## Installation du projet

### 1. Se placer dans le dossier du projet

```bash
cd automobile
```

*(Si vous venez de cloner le dépôt complet, faites `cd automobile/automobile`).*

### 2. Installer les dépendances PHP (Backend)

```bash
composer install
```

### 3. Installer les dépendances JavaScript (Frontend)

```bash
npm install
```

---

## Configuration des variables d'environnement

1. À la racine du dossier `automobile/`, créez votre fichier `.env` en copiant le fichier d'exemple :

   - Sous Linux / macOS / Git Bash :
     ```bash
     cp .env.example .env
     ```
   - Sous Windows PowerShell :
     ```powershell
     copy .env.example .env
     ```

2. Générez la clé d'application Laravel :

   ```bash
   php artisan key:generate
   ```

3. Initialisez la base de données SQLite et exécutez les migrations :

   - Sous Linux / macOS :
     ```bash
     touch database/database.sqlite
     php artisan migrate
     ```
   - Sous Windows PowerShell :
     ```powershell
     New-Item -ItemType File database/database.sqlite -Force
     php artisan migrate
     ```
   - Sous Windows CMD (Invite de commandes) :
     ```cmd
     type nul > database\database.sqlite
     php artisan migrate
     ```

   > **Important :** Cette étape est indispensable car le cache applicatif (`CACHE_STORE=database`) et les sessions s'appuient sur les tables créées par les migrations.

4. Renseignez les identifiants de l'API Partenaires Glinche à la fin du fichier `.env` :

   ```env
   API_URL="https://marketplace-dev.glinche-automobiles.com/api/partners"
   API_EMAIL="votre-email@exemple.com"
   API_PASSWORD="votre-mot-de-passe"
   ```

> **Sécurité :** Le mot de passe contient des caractères spéciaux (`*`, `!`). Il est impératif de l'entourer de guillemets pour éviter toute erreur de syntaxe lors du parsing de l'environnement.

---

## Lancement de l'application

Pour faire fonctionner le projet, **deux terminaux** doivent être lancés en parallèle dans le dossier `automobile/` :

### 1. Lancer le backend (Laravel)

Dans le **premier terminal** :

```bash
php artisan serve
```

> Le serveur backend démarre par défaut sur : **`http://127.0.0.1:8000`**
> L'API locale est accessible sur : `http://127.0.0.1:8000/api/vehicles`

### 2. Lancer le frontend (Vue.js / Vite)

Dans le **deuxième terminal** :

```bash
npm run dev
```

*(Si vous êtes sous Windows et que PowerShell bloque les scripts, utilisez `npm.cmd run dev`).*

### 3. Accéder à l'application

Ouvrez votre navigateur web et rendez-vous sur :
[http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Choix techniques effectués

### Backend (Laravel)

* **Service dédié (`GlincheApiService`) :** Isole les requêtes vers l'API externe pour garder un contrôleur léger.
* **Cache du token (`Cache::remember`) :** Token stocké 1h pour éviter les appels `/login` répétés.
* **Gestion des erreurs :** Contrôleur sécurisé par `try/catch` renvoyant une réponse JSON (code 500) en cas de panne.
* **Configuration centralisée (`config/services.php`) :** Variables `.env` propres et compatibles avec le cache Laravel.

### Frontend (Vue.js 3)

* **Composition API (`<script setup>`) :** Syntaxe moderne et réactive de Vue 3.
* **Découpage en composants :** `App.vue` pilote les données et le filtre, `VehicleCard.vue` affiche chaque véhicule.
* **Filtre dynamique (`computed`) :** Extraction des marques sans doublon (`new Set`) et filtrage instantané sans rechargement.

### Design & CSS

* **Vanilla CSS :** Style léger et épuré respectant la charte Glinche (bleu `#1961ac`, blanc, vert).
* **Grille responsive :** CSS Grid (`auto-fill`) pour s'adapter à tous les écrans (mobile, tablette, PC).

---

## Difficultés rencontrées & Solutions

| Difficulté rencontrée                                  | Solution apportée                                                                                    |
| :------------------------------------------------------- | :---------------------------------------------------------------------------------------------------- |
| **Données de l'API imbriquées**                  | Les infos du véhicule sont dans un sous-objet `vehicle`. Résolu en ciblant `vehicle.vehicle`.    |
| **Codes carburant abrégés (`GO`, `ES`...)**  | Utilisation d'un dictionnaire pour afficher le nom complet (*Gazole*, *Essence*...).              |
| **Données nulles ou sans photo**                  | Utilisation de `??` (*"Année non renseignée"*) et visuel de secours avec `v-if` / `v-else`.  |
| **Formatage du prix**                              | Prix reçu en texte brut. Converti avec `Number()` et formaté avec `.toLocaleString('fr-FR')`.    |
| **Erreur SSL cURL sous Windows (`cURL 60`)**       | Télécharger `cacert.pem` et renseigner `curl.cainfo` et `openssl.cafile` dans le `php.ini`.       |
| **Expiration du token API distant (401)**         | Renouvellement automatique du token dans `GlincheApiService` et commande `php artisan cache:clear`.|
| **Blocage des scripts sous PowerShell**            | Utiliser `npm.cmd run dev` pour contourner la restriction d'exécution de scripts PowerShell.       |
