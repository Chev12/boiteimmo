# Lbi (temps recommandé : 2h00-3h00)

Lbi dispose d'une base de films conçue pour une application précédente. Nous souhaitons développer une nouvelle application qui permettra d'interagir avec cette base via des APIs REST. Cette application doit être écrite en Symfony ou laravel

Prérequis : un serveur avec Symfony ou laravel  installé et une base SQL où importer les fichiers fournis.

##Première Lbi

L'équipe produit n'ayant pas eu le temps de faire un cahier des charges précis, il faudra faire preuve de "bon sens" dans le développement de l’application. Les seules exigences clairement identifiées sont les suivantes :
- Les opérations en lecture sur les différents objets doivent être réalisables via des APIs publiques
- Les opérations en écriture (ajout de films ou acteurs) doivent nécessiter d’être authentifié via un compte ou une clé
- Lbi étant convaincu du potentiel commercial de ce projet, nous nous attendons à avoir à la fois des volumes importants de données et des gros pics de charges. Les aspects performance sont donc particulièrement importants.

##Deuxième partie

Après une démo faite à un prospect, l’équipe commerciale a ajouté un besoin critique : il faut pouvoir inclure l’URL du poster du film chaque fois qu’il est disponible !

Pour cela, il est possible d’utiliser l’API IMDB suivante : https://rapidapi.com/apidojo/api/imdb8/ (compte de test :   à créer sur le site web de rapidapi) en faisant une recherche sur le titre du film. S’il y a plusieurs résultats, le premier fera l’affaire.

La direction de Lbi a par contre bien noté que ces APIs sont payantes si utilisées en gros volume, il faudra en tenir compte.

##Rendu et autres instructions

Le projet est à rendre sous la forme d’un dépôt git. Si la structure SQL a bougé, inclure les scripts modifiés. L’objectif n’est pas nécessairement de tout finir, mais d’en faire assez pour servir de base de discussion lors de l’entretien technique.
