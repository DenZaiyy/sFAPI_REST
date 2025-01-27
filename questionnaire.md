1. Une API REST est un service qui permet de communiquer avec des services externes à l'application initial (par exemple du backend au frontend si on utilise une techno différentes)

2. Les principales caractéristiques de l'API REST sont :
    - Gérer le CRUD (CREATE, READ, UPDATE, DELETE) des données
    - Choisir quel données récupérer sur une entité
    - Filtrer les données
    - Trier les données

3. Les différents types de méthodes HTTP utilisées sont :
    - GET (récupérer les infos)
    - POST (ajouter des infos)
    - PUT (mettre à jour des infos)
    - PATCH (mettre à jour des infos)
    - DELETE (supprimer des infos)

4. J'ai choisi API Platform pour mon projet car le projet initial as été crée en PHP Symfony, donc la gestion des entités et des relations avec la base de données est facile avec Symfony et API Platform.

5. Les avantages d'utiliser api platform par rapport à d'autres framework sont :
    - Facilité de gestion des entités et des relations avec la base de données
    - Facilité de gestion des formulaires
    - Facilité de gestion des routages
    - Facilité de gestion des erreurs
    - Interface facile d'utilisation

6. API Platform facilite la création de ressources et leurs expositions grâce a son interface, elle nous permet de tester les différents endpoints présent sur notre application, de vérifier qu'on récupère les bonnes données, ainsi que crée sous format JSON la plupart du temps.

7. Les principales étapes de création d'une nouvelle ressource dans api platform est simple, j'insère dans le body de ma requête (ou directement depuis un formulaire) les éléments necéssaire pour ajouter un nouvel élément en base de données, les données sont traités dans le controlleur qui vas persister la base de données avec les infos.

8. La validation des données dans API Platform se passe dans mon entité du projet symfony avec l'utilisation de l'attribut [ApiRessource] et les groups sur chaque champ.

9. Pour personnaliser le comportement des endpoints j'utilise une méthode précise selon l'utilisation, pour par exemple récupérer des données, j'utilise que la méthode GET, ce qui empêchera tout autre processus (UPDATE, CREATE, DELETE)

10. Les meilleures pratiques de sécurité à la création d'une API REST sont d'utiliser les Assert de Symfony pour limiter les données par champ, pouvoir définir un rôle précis pour exécuter une tâche précise et gérer les méthodes qu'on souhaite pour chaque endpoint

11. L'authentification et l'autorisation dans API Platform est gérer avec les HEADERS de la requête HTTP, nous avons les CORS qui permettent de limiter l'accès à l'api et décider si elle est privée ou public, également gérer avec un JWT Token

12. Pour optimiser les performances d'une API, nous avons la mise en cache des données récupérer sur les différents endpoint

13. Voici un exemple de code pour une ressource simple (Entité)

- Utilisation de l'attribut ApiRessource dans mon entité Symfony:

```php
#[ORM\Entity(repositoryClass: MembreRepository::class)]
#[ApiResource(
    operations: [
        // Get avec le group membre:item permet d'autoriser la récupération de la données par cette méthode au group membre:item
        new Get(normalizationContext: ['groups' => ['membre:item']]),
        // GetCollection permet de récupérer une collection de données et est groupé par membre:list
        new GetCollection(normalizationContext: ['groups' => ['membre:list']])
    ]
)]
class Membre...
```

- Group sur les différents champ:
```php
#[ORM\Column(length: 20)]
//J'associe le champ "title" as être récupérer par l'API dans les deux groups crée auparavant
#[Groups(['membre:list', 'membre:item'])]
private ?string $title = null;

#[ORM\Column(length: 100)]
//J'associe également le champ "last" a être récupérer dans la requete API
#[Groups(['membre:list', 'membre:item'])]
private ?string $last = null;
```

14. Pour tester notre API, on peut passer par des tests fonctionnels, tests unitaires, en utilisant l'endpoint d'une ressource sur un autre projet pour pouvoir gérer les autorisations.

15. Pour versionner une API, nous devons nous rendre sur le fichier config:
```yaml
#config/packages/api_platform.yaml
api_platform:
    title: Symfony 7 API REST
    version: 1.0.0
    defaults:
        stateless: true
        cache_headers:
            vary: ['Content-Type', 'Authorization', 'Origin']
```
On peut également versionner l'uri de l'api, par exemple /api/v1, /api/v2 ect.
Il est important de versionner son API car l'architecture des données récupérer en format JSON peuvent changer d'une version à l'autre.

16. Pour gérer les relations entre les entités dans API Platform il faut utiliser l'attribut @ApiRessource et le type ManyToOne de Doctrine.

17. Sur API Platform, la pagination, le tri et les filtres sont gérées par defaut. On peu également désactiver grace a l'option "paginationEnabled: false" dans l'attribut @ApiRessource

18. Le concept DTO est un objet qui représente un sous ensemble de donnees de l'entite qui contiendra que les données qui sont transités entre le client et l'api

19.
