# Symfony API Rest

Projet symfony pour générer des utilisateurs et les ajouter en base de données pour pouvoir les ajouter à notre API Rest et pouvoir utiliser ces données dans d'autres projets.

## Exercice

- Création de l'entité Membre
- Création du controller API
- Installation de api-platform
- Configuration de la base de donnée
- Configuration des entités
- Mapper l'entité Membre avec l'api-platform
- Ajouter un membre généré par l'api https://randomuser.me/api/ dans la base de données depuis un bouton de formulaire
- Gestion du formulaire pour ajouter un membre en base de données

## Installation

- Initialisation du projet symfony
    ```bash
    symfony new ${project_name} --webapp
    ```

- Installation des dépendances
    ```bash
    cd ${project_name}
    composer install
    ```
- Installation de api-platform

    ```bash
    composer require api
    ```

## Configuration

- Configuration de la base de données

    ```bash
    symfony console doctrine:database:create
    ```

- Configuration des entités

    ```bash
    symfony console make:entity Membre
    ```

- Création du controller API

    ```bash
    symfony console make:controller ApiController
    ```

- Instancier une URI pour l'api generateur d'utilisateur pour les tests

    ```yaml
    # config/packages/framework.yaml
      http_client:
        scoped_clients:
            jph:
                base_uri: https://randomuser.me/api/
    ```
