# Symfony project

This a project for Knp-taste

## Initialize project with docker :

``
docker compose up -d --build
``
## Create database
``
docker compose exec knp-taste-arthur-php-1 php bin/console doctrine:database:create
``
## Add fixtures
Connect to container

``
docker compose exec -it knp-taste-arthur-php-1 bash
``

add fixtures

``
php bin/console doctrine:fixtures:load
``