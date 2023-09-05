# Symfony project

This a project for Knp-taste

## Initialize project with docker :

``
docker compose up -d --build
``
## Initialize database with fixtures
``
docker exec <container_name> php bin/console app:fixture:load
``