# Docker-Laravel template

#### Setting up

Run the ```migrate-template``` script using this format:

```./migrate-template.sh ../../path/to/laravel-project```

#### Environments
Set the ```DB_HOST``` from ```.env``` to the ```docker-compose.yml``` service name (currently ```db```)

Comment the ```PMA_USER``` and ```PMA_PASSWORD``` lines from the ```phpmyadmin``` service if you want to disable auto-login when opening the ```phpmyadmin``` in browser.

#### Services running order

1. db: first we create the MySQL database service
2. init-scripts: next we create the service that will run the initial scripts. This service will exit once we run the initial scripts, that's it's sole purpose.
3. app: the service that has the application is created
3. phpmyadmin: the old good pal helper phpmyadmin service is created, to help on checking the DB
4. nginx: the server that is hosting our application is created


#### Starting the app
Run the commands

```
docker-compose build
docker-compose up -d
```

#### Navigating to the services (app/db)
Go in browser to [localhost:8000](http://localhost:8000) the view the app (currently the nginx service uses the 8000 port).

Go in browser to [localhost:7000](http://localhost:7000) to check the database in phpmyadmin (currently the phpmyadmin service uses the 7000 port).

Enjoy.