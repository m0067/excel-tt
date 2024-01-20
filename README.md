#Excel TT

Run containers
```shell
docker-compose up -d
```

Migrate db
```shell
docker-compose exec mesh_php php artisan migrate
docker-compose exec mesh_php php artisan migrate --env=testing
```

Run tests
```shell
docker-compose exec mesh_php php artisan test
```