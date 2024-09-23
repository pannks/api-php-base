all-local: start db-only

all: start

start-local:
	php -S localhost:8000

db-only:
	docker-compose up -d --build mysql

start:
	docker-compose up -d --build

visit-db:
	mysql -h 127.0.0.1 -P 3333 -u root -p

down: 
	docker-compose down

re-api:
	docker-compose up -d --build php-api
