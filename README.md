```
 ______     __  __     ______   ______     ______     ______     ______     __         ______    
/\  __ \   /\ \/\ \   /\__  _\ /\  __ \   /\  ___\   /\  ___\   /\  __ \   /\ \       /\  ___\   
\ \  __ \  \ \ \_\ \  \/_/\ \/ \ \ \/\ \  \ \  __\   \ \ \____  \ \ \/\ \  \ \ \____  \ \  __\   
 \ \_\ \_\  \ \_____\    \ \_\  \ \_____\  \ \_____\  \ \_____\  \ \_____\  \ \_____\  \ \_____\ 
  \/_/\/_/   \/_____/     \/_/   \/_____/   \/_____/   \/_____/   \/_____/   \/_____/   \/_____/ 
                                                                                                 
```
- Installation du scope pour symfony :
```
$ Set-ExecutionPolicy RemoteSigned -scope CurrentUser
$ iwr -useb get.scoop.sh | iex
$ scoop install symfony-cli
$ symfony -v
```
- Au lancement du projet, faire  les commandes suivantes :
```
$ composer install
$ composer require fakerphp/faker
$ composer require --dev doctrine/doctrine-fixtures-bundle
$ composer require --dev orm-fixtures
```
- Créer un projet (uniquement pour les dévs de ce projets) :
```
$ symfony new [Nom du projet] --version=lts --webapp
```
- Démarrer/Arrêter le serveur :
```
$ symfony server:start
$ symfony server:stop
```

- Récupérer les migrations :
```
$ php bin/console doctrine:migrations:migrate
```

- Faire une migration:
```
$ php bin/console make:migration
```

- Récupérer les datasFixtures:
```
$ php bin/console doctrine:fixtures:load
```

- Créer une entitée:
```
$  php bin/console make:entity Test
```

- Admin identifiant:
```
mail : admin@admin.com
mot de passe : admin
```

- Moniteur identifiant:
```
mail : moniteur@moniteur.com
mot de passe : moniteur
```

- Utilisateur identifiant:
```
mail : user@user.com
mot de passe : user
```


