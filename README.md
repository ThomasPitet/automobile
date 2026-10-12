# Catalogue de Véhicules – Glinche Automobiles

Application web développée avec Laravel (backend) et Vue.js 3 (frontend), permettant de consulter le catalogue de véhicules de l'API Partenaires de Glinche Automobiles avec un filtre dynamique par marque et un affichage moderne et responsive.

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

- PHP 8.3 ou supérieur (recommandé 8.3 ou 8.4) avec les extensions `pdo_sqlite`, `curl`, `mbstring`, `openssl`
- Composer (gestionnaire de dépendances PHP)
- Node.js (v20+) et npm
- Git

---

## Installation du projet

### 1. Se placer dans le dossier du projet

```bash
cd automobile
```

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

```bash
cp .env.example .env
```

Sous Windows PowerShell :

```powershell
copy .env.example .env
```

2. Générez la clé d'application Laravel :

```bash
php artisan key:generate
```

3. Initialisez la base de données SQLite et exécutez les migrations :

Sous Linux / macOS :
```bash
touch database/database.sqlite
php artisan migrate
```

Sous Windows PowerShell :
```powershell
New-Item -ItemType File database/database.sqlite -Force
php artisan migrate
```

> **Important :** Cette étape est indispensable car le cache applicatif (`CACHE_STORE=database`) et les sessions s'appuient sur les tables créées par les migrations.

4. Renseignez les identifiants de l'API Partenaires Glinche à la fin du fichier `.env` :

```env
API_URL="https://marketplace-dev.glinche-automobiles.com/api/partners"
API_EMAIL="votre-email@exemple.com"
API_PASSWORD="votre-mot-de-passe"
```

> Sécurité : le mot de passe contient des caractères spéciaux (`*`, `!`). Il est impératif de l'entourer de guillemets pour éviter toute erreur de syntaxe lors du parsing de l'environnement.

---

## Lancement de l'application

Pour faire fonctionner le projet, deux terminaux doivent être lancés en parallèle dans le dossier `automobile/` :

### 1. Lancer le backend (Laravel)

Dans le premier terminal :

```bash
php artisan serve
```

Le serveur backend démarre par défaut sur : `http://127.0.0.1:8000`
L'API locale est accessible sur : `http://127.0.0.1:8000/api/vehicles`

### 2. Lancer le frontend (Vue.js / Vite)

Dans le deuxième terminal :

```bash
npm run dev
```

Si vous êtes sous Windows et que PowerShell bloque les scripts, utilisez :

```bash
npm.cmd run dev
```

### 3. Accéder à l'application

Ouvrez votre navigateur web et rendez-vous sur :

[http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Choix techniques effectués

### Backend (Laravel)

- Service dédié (`GlincheApiService`) : isole les requêtes vers l'API externe pour garder un contrôleur léger.
- Cache du token (`Cache::remember`) : token stocké 1h pour éviter les appels `/login` répétés.
- Gestion des erreurs : contrôleur sécurisé par `try/catch` renvoyant une réponse JSON avec code 500 en cas de panne.
- Configuration centralisée (`config/services.php`) : variables `.env` propres et compatibles avec le cache Laravel.

### Frontend (Vue.js 3)

- Composition API (`<script setup>`) : syntaxe moderne et réactive.
- Découpage en composants : `App.vue` pilote les données et le filtre, `VehicleCard.vue` affiche chaque véhicule.
- Filtre dynamique (`computed`) : extraction des marques sans doublon (`new Set`) et filtres instantanés sans rechangement de page.

### Design & CSS

- Vanilla CSS : style léger et épuré respectant la charte Glinche (bleu `#1961ac`, blanc, vert).
- Grille responsive : CSS Grid (`auto-fill`) pour s'adapter à tous les écrans.

---

## Difficultés rencontrées & Solutions

| Difficulté rencontrée                        | Solution apportée                                                                                 |
| :--------------------------------------------- | :------------------------------------------------------------------------------------------------- |
| Données de l'API imbriquées                  | Les infos du véhicule sont dans un sous-objet`vehicle`. Résolu en ciblant `vehicle.vehicle`. |
| Codes carburant abrégés (`GO`, `ES`...)  | Utilisation d'un dictionnaire pour afficher le nom complet (Gazole, Essence...).                   |
| Données nulles ou sans photo                  | Utilisation de`??` ("Année non renseignée") et visuel de secours avec `v-if` / `v-else`.   |
| Formatage du prix                              | Prix reçu en texte brut. Converti avec`Number()` et formaté avec `.toLocaleString('fr-FR')`. |
| Casse sous Windows (`app.vue` / `App.vue`) | Conflit de casse dans l'éditeur. Résolu en harmonisant le nom en`App.vue`.                     |

---

## À propos du projet

Ce projet est une application de démonstration pour la consultation d'un catalogue de véhicules avec un backend Laravel et un frontend Vue.js moderne.

Il a été conçu pour mettre en avant :

- la récupération de données depuis une API externe,
- le filtrage dynamique côté client,
- une interface claire et responsive,
- une architecture simple et maintenable.
