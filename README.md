# To run the project

> `cp .env.example .env`

> `cp api/.env.example api/.env`

change environment variables as needed in `.env` & `api/.env`

> `docker-compose up --build -d`

> `docker exec -it [api_container_name] composer install`

> `docker exec -it [api_container_name] php artisan migrate`

> `docker exec -it [api_container_name] composer run-script phpunit`

for first time install only

> `docker exec -it [api_container_name] php artisan keys:generate:app`

> `docker exec -it [api_container_name] php artisan db:seed`

## Sequence Diagram

```mermaid
graph LR
A[Rates API] -- to view --> B(View rates per day)
C(Parking spots API) -- to view --> D(View available parking spaces)
E(Bookings API) -- to view --> F(View booked parking slots)
```
