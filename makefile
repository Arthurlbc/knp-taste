
start: ## Start project
	docker compose up -d

stop: ## Stop project
	docker compose stop
database:
	docker compose exec -it php bin/console doctrine:database:create
fixtures:
	docker compose exec -it php bin/console doctrine:fixtures:load
