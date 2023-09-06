# Symfony project

This a project for Knp-taste

## Initialize project with docker :

```shell
make start
```
## Create database
```shell
make database
````
## Add fixtures

Connect to container

```shell
docker exec -it knp-taste-arthur-php-1 bash
```

add fixtures

```shell
php bin/console doctrine:fixtures:load
```