## How to build

## Environment Variable
Please copy .env.example to .env
And update variables bellow according to your environment
- DB_CONNECTION, I build this with postgre so the driver must be pgsql
- DB_HOST, Database Host
- DB_PORT, Database Port
- DB_DATABASE, Database name
- DB_USERNAME, Database username
- DB_PASSWORD, Database password
- JWT_SECRET, Run php artisan jwt:secret to generate one

## Installation
- Set vhost and clone the repository to vhost folder
- Setup database
- Update the .env according to environment
- Run Composer Update
- Run php artisan migrate
- Run php artisan db:seed

