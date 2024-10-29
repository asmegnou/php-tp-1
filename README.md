# TP PHP 1 - Tableaux, Upload, API

## Introduction
Ce TP a pour objectif d'acquérir des compétences fondamentales en PHP, en travaillant avec des tableaux, le téléversement de fichiers, et la conception d'une API simple. Le TP se compose de trois exercices distincts qui permettent d'appliquer ces concepts de manière pratique.

## Contenu du TP
L'archive téléchargée sur Moodle contient les fichiers nécessaires pour ce TP. Voici un aperçu des principaux fichiers :
- `tableau.php` : Fichier principal qui affiche les articles et les taux de TVA.
- `creer.php` : Script pour créer les tableaux de données.
- `afficher.php` : Script pour générer le tableau HTML à partir des données.
- `upload.php` : Formulaire pour le téléversement de fichiers.
- Dossier `api` : Contient les fichiers nécessaires pour la mise en place de l'API.

## Exercice 1 : TVA et Coûts TTC

### Objectifs
- Créer un tableau d'articles avec des prix et des taux de TVA associés.
- Afficher ces informations sous forme de tableau HTML, incluant les calculs de taxe et de coût total TTC.
- Trier le tableau par taux de TVA croissant et prix décroissant.

### Instructions
1. **Création des données (`creer.php`)** :
   - Créez deux tableaux indicés :
     - Un tableau d'articles : `["A", "B", ..., "K"]`.
     - Un tableau de taux de TVA : `[0.05, 0.10, 0.20]`.
   - Générez un tableau associatif `$prix_taux` pour associer chaque article à un prix aléatoire (entre 0 et 100) et un taux de TVA aléatoire, sans utiliser de boucles.

2. **Affichage des données (`afficher.php`)** :
   - Complétez le fichier `afficher.php` pour afficher le tableau HTML avec les informations suivantes pour chaque article :
     - Prix
     - Taux de TVA
     - Taxe
     - Coût total (TTC).
   - Utilisez la syntaxe HEREDOC et la fonction `array_walk` pour générer les lignes du tableau.

3. **Tri des données** :
   - Modifiez `afficher.php` pour trier le tableau d'articles par taux de TVA croissant et par prix décroissant. Ajoutez un hyperlien dans la cellule Taux T.V.A. pour rappeler le script.

## Exercice 2 : Téléversement de Fichiers

### Objectifs
- Compléter un formulaire pour permettre le téléversement de fichiers ZIP de taille limitée à 1 Mo.
- Afficher des informations sur le fichier téléchargé, telles que le nom et la taille, ainsi qu'une confirmation de réception côté serveur.

### Instructions
- Modifiez `upload.php` pour gérer le téléversement de fichiers et afficher les détails requis après la réception.

## Exercice 3 : Conception d’API - Premiers Pas

### Objectifs
- Comprendre et mettre en œuvre une API simple pour gérer des informations sur les continents et les pays.
- Tester les points de terminaison (endpoints) à l'aide de Postman.

### Instructions
1. **Lecture de la documentation** :
   - Lisez intégralement la documentation fournie pour comprendre les différents points de terminaison disponibles.

2. **Installation et test avec Postman** :
   - Installez l'application Postman et importez les collections fournies.
   - Testez chaque endpoint de l'API, en prenant soin de modifier les URLs en fonction de votre configuration.

3. **Implémentation des endpoints** :
   - Implémentez les points de terminaison pour gérer les pays dans `countries.php` en vous inspirant des implémentations de `continents.php`.

## Conclusion
Ce TP vous permettra d'approfondir vos connaissances en PHP, notamment en ce qui concerne la gestion des données, le téléversement de fichiers, et la création d'API. Assurez-vous de bien comprendre chaque partie avant de passer à la suivante. 

Pour toute question ou problème, n'hésitez pas à consulter le forum de la classe ou à demander de l'aide à votre professeur.

## Ressources Utiles
- [Documentation PHP](https://www.php.net/manual/fr/)
- [Postman](https://www.postman.com/)
- Tutoriels PHP sur les tableaux et les API.

