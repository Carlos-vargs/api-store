# API-STORE

API-STORE is a simple token-based API to perform different actions 

## Installation

 Use Git Clone Command [git clone](https://git-scm.com/docs/git-clone) to install API-STORE.

```bash
 git clone https://github.com/Carlos-vargs/api-store.git myApiStore
 cd myApiStore
```
## Usage

```php

# You will need generate .env file by running

$cp .env.example .env
$php artisan key:generate

# After generating the .env file, you need to
# Configure the database and run the migrations
# The "DB_PASSWORD" is optional depending on 
# Your configuration in mysql

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=store
DB_USERNAME=root
DB_PASSWORD=

# command to run migrations and start the server

$php artisan migrate
$php artisan serve

```


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
