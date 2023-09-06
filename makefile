start: ## Start project
	docker compose up -d

stop: ## Stop project
	docker compose stop
database:
	docker compose exec php bin/console doctrine:database:create