# Task for Junior PHP Developer position
Author: Paulius Leveris

## Task

Purpose: create a RESTFul API endpoint for transaction commission calculation.

## Created with the following stack:

- OS: Ubuntu 20.04;
- PHP v8.1;
- Laravel v9.0.

## How to build and/or run?
First, ensure the following Dependencies are available on Ubuntu system:
- Docker;
- Docker-Compose;
- PHP 8.1;
- Composer.

Clone the project from GitHub:
```bash
git clone --recursive https://github.com/pleveris/technical-task.git
git checkout task
```
Then, install Composer Dependencies:
```bash
composer install
```
Then, Change .env.example to .env and edit database credentials there:
```bash
cp .env.example .env
```
To build a Docker container, run:
```bash
./vendor/bin/sail up -d
```
Migrate database by typing:
```bash
./vendor/bin/sail artisan migrate:fresh
```
Set the application key:
```bash
./vendor/bin/sail artisan key:generate
```
Start the container:
```bash
./vendor/bin/sail up
```
The application is available at localhost.

## Tests
To run the tests, use PHPUnit or ARTISAN command like this:
```bash
./vendor/bin/sail artisan test
```

## How to test?
Available API Endpoint:
```bash
POST api/new-tranzaction
Request:
array [tranzaction]
Response: JSONResponse {commission_amount}
```

## Thoughts
This task was really interesting for me to do. I believe it improved my programming skills, this was a perfect opportunity to dig deeper and practise more on REST APIs, as well as think as a coding like in a real project.

## Drawbacks, or what could be done better?
There could be more tests written to test if the application is working as expected. Testing is still one of the things which I need to improve more carefully. Hope to do that in the near future!
