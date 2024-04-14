# Dr Fox

## Description

This task is an exercise and worked out with docker and Symfony 


## Installation and Setup

To install and setup the project please follow the further steps:

```bash

git clone git@github.com:{user}/symfony_oders.git ./

docker-compose up

docker-compose run --rm php composer install

```


After the environment is built up create database:

```bash
docker-compose run --rm php bin/console doctrine:database:drop --force
docker-compose run --rm php bin/console doctrine:database:create 
```

Migrate the database:

```bash
docker-compose run --rm php bin/console doctrine:migrations:migrate -n --all-or-nothing --query-time
```

Create Fixture random data:

```bash
docker-compose run --rm php bin/console doctrine:fixtures:load -n
```

## Usage

Visit your browser:

Open Home official view: 

```bash
http://localhost
```
Login:

In the exercise please use:
<ul>
    <li>email: user@example.com</li>
    <li>password: secret</li>
</ul>

```bash
http://localhost/login
```

Order page is opened with the list of orders if the login is successful 

```bash
http://localhost/orders
```

Order's Items is opened after a click on any order

```bash
http://localhost/items/{order id}
```

Find a list of Items with name, price and rating, where some items randomly already have review and rate. 
But where there is none, this can be added 

The page will reload after the review has been added and the new review is displayed.