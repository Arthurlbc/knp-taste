# Symfony template project

This a project for Knp-taste

## Initialiser le projet :

``
docker compose up -d --build
``
## initialiser la base de donnée avec fixtures
``
docker exec <container_name> php bin/console app:fixture:load
``