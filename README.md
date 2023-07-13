# Yeallo Utils

## Installation
Pour installer **Yeallo Utils** sur votre projet, suivez la marche à suivre :

1 - Ajouter ceci dans le fichier **composer.json** de votre projet :
```


```

2 - Installer la librairie avec composer :
```
composer require yeallo/utils:dev-master
```

## Mise à jour

Mettre à jour la librairie avec composer :
```
composer update yeallo/utils:dev-master
```

## Utilisation

### Pré-requis

Pour faire un appel API (message slack / création de log), vous devez
créer une variable serveur `ENABLE_YEALLO` qui doit être à `true` :
``` php
$_SERVER['ENABLE_YEALLO'] = true; // projet PHP standard

ENABLE_YEALLO=true # projet Symfony, fichier .env.local
```

Enfin, vous devez le token qui permet d'accéder à l'api :
``` php
$_SERVER['YEALLOG_TOKEN'] = 'XXX'; // projet PHP standard

YEALLOG_TOKEN=XXX # projet Symfony, fichier .env.local
```
Ceci permet d'activer les logs seulement sur le projet en production 
et de les bloquer en local et en préprod.

### Générer un code barre
``` php
$url = YealloUtils::generateBarCode('mon-super-code-barre');
```

### Envoyer un message sur Slack
``` php
$response = YealloUtils::sendSlack('bureau', 'Salut salut !');
```

### Convertir un objet en tableau
``` php
$url = YealloUtils::objectToArray($object);
```

### Les logs

#### Tester les logs
Il est possible de créer des logs de test afin de voir si tout fonctionne.
**Un log de test est automatiquement supprimé 24h après sa création.**

Pour activer la création de logs de test il faut :

Créer une variable serveur `ENABLE_YEALLOG_TEST` qui doit être à `true` :
``` php
$_SERVER['ENABLE_YEALLOG_TEST'] = true; // projet PHP standard

ENABLE_YEALLOG_TEST=true # projet Symfony, fichier .env.local
```
Attention à mettre cette variable à `false` pour le projet en production.

#### Créer un log pour un appel API
``` php
$response = Yeallog::createLog(
    Yeallog::$STATUS_SUCCESS, 
    'Récupération des commandes', 
    $response, 
    'routeur-ad', // slug du projet concerné
    'skyper-ad',  // slug du projet cible
    Yeallog::$TYPE_API, 
    'GET', 
    'https://skyper.fr/orders', 
    $body, 
    200,
    $header
);
```

#### Créer un log custom
``` php
$response = Yeallog::createLog(
    Yeallog::$STATUS_DANGER, 
    'Erreur de code', 
    'Exception dans le code', 
    'routeur-ad',  // slug du projet concerné
    null, 
    Yeallog::$TYPE_LOG_CUSTOM
);
```
