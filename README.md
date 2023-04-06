# vms-comics-api

## Project setup

### Prerequisite 
PHP 8.1 or later  
Docker  
Docker compose  
composer  
npm
###

### Clone project
git clone https://github.com/mugiwaranojem/api-service.git 
###

### Navigate api app
```
cd api-service/vms-comics-api/
```

### Prepare env vars
```
cp .env.example .env
```

### Install dependencies
```
composer install
```

### Start or up container services might take time for first time setup
```
./vendor/bin/sail start
```

```
./vendor/bin/sail up
```

### Run migration
```
./vendor/bin/sail artisan migrate
```

### Run command to populate db
```
./vendor/bin/sail artisan app:populator
```

### Get back to root directory
```
cd ..
```

### Frontend app
```
cd vms-superheroes-vuejs-app
```

### Install frontend dependencies
```
npm install
```

### Up frontend localhost:8080
```
npm run serve
```

## Unit test
```
cd vms-comics-api  
./vendor/bin/sail test
```
