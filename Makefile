all:
	#sudo mkdir -p /home/ahuge/data/mariadb
	#sudo mkdir -p /home/ahuge/data/wordpress
	docker compose -f srcs/docker-compose.yml up

stop:
	docker compose -f srcs/docker-compose.yml stop

down:
	docker compose -f srcs/docker-compose.yml down --volumes --rmi all

re:
	make down
	make all
