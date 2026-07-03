all:
	docker compose -f docker/docker-compose.yml up --build -d

stop:
	docker compose -f docker/docker-compose.yml stop

down:
	docker compose -f docker/docker-compose.yml down --volumes --rmi all

re:
	make down
	make all
