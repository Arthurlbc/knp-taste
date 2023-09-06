start: ## Start project
	docker compose up -d

stop: ## Stop project
	docker compose stop
database:
	docker exec knp-taste-arthur-php-1 php bin/console doctrine:database:create