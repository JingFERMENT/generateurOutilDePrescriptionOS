# 🛠️ Générateur outil de prescription

## 🌟 Contexte

### 🏗️ Projet
Création d'un générateur de liens pour le lead.

### 🎯 Objectifs
Développer une application web permettant :
- ✅ La gestion des **codes de campagnes** et **apporteurs**.
- ✅ L'envoi d'**emails récapitulatifs** pour le traitement des demandes.
- ✅ L'enregistrement des informations (**logs**) pour surveiller l'application.

### 👥 Public cible
Administrateurs et utilisateurs internes.

---

## 🔧 Spécifications Techniques

### 📋 2.1 Développement du Formulaire
- Création d'un **template de formulaire** attaché à la combinaison du **code campagne** et du **code apporteur**.

### ✉️ 2.2 Gestion de l'envoi de l'email récapitulatif
- Fonctionnalité pour l'envoi d'**emails contenant les informations** soumises via le formulaire.

### 🖥️ 2.3 Création de l'Interface Administrateur

#### ⚙️ Fonctionnalités principales :
- ➕ Créer des codes de campagnes et d'apporteurs.
- ✏️ Modifier des codes de campagnes et d'apporteurs.
- 🗑️ Supprimer des codes de campagnes et d'apporteurs.

---

## 🚀 Installation et utilisation

### 1️⃣ Étape 1 : Cloner le projet
Clonez ce dépôt Git dans un dossier accessible par votre serveur local (MAMP, WAMP, LAMP, etc.) :
```bash
git clone https://github.com/JingFERMENT/generateurOutilDePrescriptionOS

## Étape 2 : Configurer la base de données
1. Créez une base de données vide nommée `generateurOutilDePrescription`.
2. Importez le fichier `generateurOutilDePrescriptionOS.sql` inclus dans le projet pour initialiser la structure et les données.

## Étape 3 : Configurer l'application
1. Renommez le fichier `env.exemple` en `.env`.
2. Renseignez les variables d'environnement appropriées (voir `env.exemple` pour les détails) :
   - 🛠️ **Database connection** (Format DSN pour MySQL)
   - 🔑 **LOGIN**
   - 🔐 **PASSWORD**
   - 🌐 **URL pour la production**
   - 📧 **SMTP**
   - 📮 **smtp_port**
   - ✉️ **sender**
   - 📩 **recipient**

## Étape 4 : Lancer le projet
1. Assurez-vous que votre serveur local est configuré.
2. Ouvrez le projet dans votre navigateur à l'URL locale configurée, par exemple :
   - `http://generateuroutildeprescriptionos.localhost`

### 🔐 Connexion
#### 🛡️ Connexion Administrateur
Pour accéder à l'interface administrateur, utilisez les identifiants suivants :
- Login : `C123456`
- Mot de passe : `Zhang`

#### 👤 Connexion Utilisateur
Pour accéder à l'interface utilisateur, utilisez les identifiants suivants :
- Login : `C123457`
- Mot de passe : `user-GOPOS`