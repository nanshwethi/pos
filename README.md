This is a [Laravel](https://nextjs.org) project bootstrapped with postgres (DB), Minio (s3), Redis (cache).

## Getting Started

First, run the development server:

```bash
cp .env.local.example .env

docker compose -f docker-local/docker-compose.yml up
```

Open [http://localhost:8000/api/v1](http://localhost:8000/api/v1) with your Postman to test api.


## Install dependencies

First, you need to enter container

```bash
 docker exec -it web-pos-app sh

 # php artisan migrate:fresh --seed

 # composer install your-package
```
