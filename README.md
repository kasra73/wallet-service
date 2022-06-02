# E-Wallet API

## Project Description

We are going to have a micro-service to keep all data of user wallet. We need to have two API to expose them to other micro-services.

### API Information

1. ### get-balance

This API should return a JSON to show current balance of a user. The parameter which is
needed for this API is user_id and the output should be like the below sample:

**Input**:

* `user_id int`

**Output**: `{"balance":4000}`

2. ### add-money

This API should add money to wallet of a user and at the end return the transaction
reference number. The parameter which is needed for this API is user_id and amount
and the output should be like the below sample:

**Input**:

* `user_id int`
* `amount int` (this parameter can be negative)

**Output**: `{"reference_id":12312312312}`

____

## Please consider the below points:

* Please Dockerize the project
* Use MySql as a database to store your data
* We need to Save all transaction logs of user
* We need an API to show balance of each user
* We need an API to add money to wallet of user
* We need to have some necessary test cases (just 6 test case to make sure you know
about this procedure)
* We need a daily job to calculate total amount of transactions and print it on terminal
* You don’t have to develop any API or service for user, just develop the necessary
* services which are related to wallet

___

## Testing, Running, and Using the API

### Testing

To run the tests, first migrate database using command `php artisan migrate:fresh`; then execute `php artisan test`

### Running

There are two docker-compose files available: one for production and another for development.

You can use the following command to run the application in production mode: `docker-compose up -d`

Or use `docker-compose -f docker-compose.yml up -d` to run in development mode.

Make sure to migrate the database before start using the api:

`docker-compose exec app php artisan migrate`

### Using

`GET http://127.0.0.1:8002/api/get-balance/3`

**Sample Response:**

200 OK

```json
{
    "balance": "21424.00"
}
```

404 OK

```json
{
    "title": "Not Found",
    "message": "Wallet not found"
}
```

`POST http://127.0.0.1:8002/api/add-money`

422 Unprocessable Content

```json
{
    "title": "Unprocessable Request",
    "message": "Insufficient funds",
    "code": 16
}
```

```json
{
    "reference_id": "",
}
```

* There are two commands available to check data consistency:

`php artisan transactions:wallets:calculate-total {--type=} {--date-from=} {--date-to=} {--confirm-only=true}`

and

`php artisan transactions:calculate-total {--type=} {--date-from=} {--date-to=} {--confirm-only=true}`
