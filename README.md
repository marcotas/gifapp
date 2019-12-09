## GIF APP

This is a simple project to search and share gif images.

### Requirements

- Docker

### How to run the app

Run the following commands

```
docker-compose build api
docker-compose up -d api
docker-compose exec api php artisan migrate
docker-compose exec api php artisan passport:install
```

Copy the password grant client `id` and `secret` from the last command above, and paste on `.env` file inside the `frontend` directory. For Example:

```
# This is an example
API_CLIENT_ID=2
API_CLIENT_SECRET=FaoSakbFtcF8aTjU5cY1eSry3G35timV7cxeDbF4
```

Then you now can start the app service:

```
docker-compose up -d app
```

Then you can access [http://localhost:5000](http://localhost:5000).

### Tests

The automated tests should be run in your local environament. For now it's not possible to run with docker. And only backend (API) are available.

### Minification algorithm for URL

I used the bijective algorithm to convert a integer number to a base 62 alphabet. I've used this existing algorithm [in this repo](https://github.com/wdalmut/php-bijective/blob/master/src/Bijective.php).

The requested url is stored in database and the minitifed url convert it's integer ID to a string. It's that simple.
