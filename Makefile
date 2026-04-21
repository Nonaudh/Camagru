all:
	#sudo mkdir -p /home/ahuge/data/mariadb
	#sudo mkdir -p /home/ahuge/data/wordpress
	sudo docker compose -f srcs/docker-compose.yml up

stop:
	sudo docker compose -f srcs/docker-compose.yml stop

down:
	sudo docker compose -f srcs/docker-compose.yml down --volumes --rmi all
	sudo rm -rf /home/ahuge/data

re:
	make down
	make all
