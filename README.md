## Feature

- Register as owner / regular user / premium user
- Allow owner to add, update, and delete kost
- Allow owner to see his kost list
- Allow user to search kost that have been added by owner
- Allow user to see kost detail
- Allow user to ask about room availability


## Requirements

- Regular user will be given 20 credit, premium user will be given 40 credit after register. Owner will have no credit.
- Owner can add more than 1 kost
- Search kost by several criteria: name, location, price
- Search kost sorted by: price
- Ask about room availability will reduce user credit by 5 point
- Owner API & ask room availability API need to have authentication
- Implement scheduled command to recharge user credit on every start of the month
- Bonus point if you can create Owner dashboard that use your API

## How to install with docker

```
docker-compose up --build
docker exec -it php /var/www/artisan migrate
docker exec -it php /var/www/artisan passport:install --uuids
docker exec -it php /var/www/artisan db:seed
```

now you can access API from http://localhost:8080/api

## How to install without docker

```
git clone https://github.com/
cd mamikos-test
set your .env
php artisan migrate
php artisan passport:install --uuids
php artisan db:seed
php artisan serve --port 8080
```

you can access API from http://localhost:8080/api

don't forget import *MamikosTest.postman_collection* to try