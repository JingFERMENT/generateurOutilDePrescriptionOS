# 🛠️ Générateur outil de prescription

Le projet consiste à développer une application web pour une demande de lead (ou prospect), avec un formulaire de soumission, un récapitulatif par email et une interface d'administration pour gérer les informations de campagne et d'apporteur. 
Cette application est destinée aux administreurs et utilisateurs internes.

---

## 🔧 Spécifications Techniques

### 📋 1 Développement du formulaire 
- Création d'un **template de formulaire** attaché à la combinaison du **code campagne** et du **code apporteur**.

### ✉️ 2 Gestion de l'envoi de l'email récapitulatif
- Fonctionnalité pour l'envoi d'**emails contenant les informations** soumises via le formulaire.

### 🖥️ 3 Création de l'Interface Administrateur

#### ⚙️ Fonctionnalités principales :
- ➕ Créer des codes de campagnes et d'apporteurs.
- ✏️ Modifier des codes de campagnes et d'apporteurs.
- 🗑️ Supprimer des codes de campagnes et d'apporteurs.

### 🖥️ 4 Enregistrement des informations (**logs**) pour l'audit et la sécurité

---

## 🚀 Installation et utilisation

### 1️⃣ Étape 1 : Cloner le projet
Clonez ce dépôt Git dans un dossier accessible par votre serveur local (MAMP, WAMP, LAMP, etc.).

##  2️⃣ Étape 2 : Configurer la base de données
1. Créez une base de données vide nommée `generateurOutilDePrescription`.
2. Importez le fichier `generateurOutilDePrescriptionOS.sql` inclus dans le projet pour initialiser la structure et les données.

##  3️⃣ Étape 3 : Configurer l'application
1. Renommez le fichier `env.exemple` en `.env`.
2. Renseignez les variables d'environnement appropriées (voir `env.exemple` pour les détails).

##  4️⃣ Étape 4 : Lancer le projet
1. Assurez-vous que votre serveur local est configuré.
2. Ouvrez le projet dans votre navigateur à l'URL locale configurée, par exemple :
   - `http://generateuroutildeprescriptionos.localhost`

##  4️⃣ Étape 5 : Installer les dépendances via composer
1. Installer monolog et phpdotenv 

### 🔐 Connexion
#### 🛡️ Connexion Administrateur
Pour accéder à l'interface administrateur, utilisez les identifiants suivants :
- Login : `C123456`
- Mot de passe : `Zhang`

#### 👤 Connexion Utilisateur
Pour accéder à l'interface utilisateur, utilisez les identifiants suivants :
- Login : `C123457`
- Mot de passe : `user-GOPOS`