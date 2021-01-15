# SHIFT - Technical Interview Challenge

## Development Stack
The solution involves a
- Laravel 7 API
- React SPA as frontend
- MySQL
- Nginx

I am not as proficient in developing with React as I am with Vue but I chose React because I have to
brush up on and enhance my skills in it to fit with the the stack used at Shift.

## Installation instructions
After cloning the project into project-folder, run the following commands
```
cd project-folder
```
```
docker-compose up
```

Copy the contents of api/.env.example to api/.env.
```
cp api/.env.example api/.env
```

Run the following commands to set up the laravel backend,
```
docker-compose run composer install
```
```
docker-compose run artisan migrate --seed
```

You can run further composer commands against the project by running
```
docker-compose run composer your-command
```

You can run further artisan commands against the project by running
```
docker-compose run artisan your-command
```

Eg. To run tests for backend
```
docker-compose run artisan test
```

Visit http://localhost:3000/ to visit the frontend.

## Future Story Endpoints
I have added endpoints to the API that support the future stories stated in the challenge.
These endpoints are authenticated using bearer tokens. You can get a token by making a request to
```
POST http://localhost:8000/api/login
```
with the following data
```
{
    "email": "user@shift.com",
    "password": "secret"
}
```

The API endpoints to fulfill future stories are:
1. Get mbti details of the authenticated user
```
GET http://localhost:8000/api/mbti_profile
```
2. View responses given by querying with email
```
GET http://localhost:8000/api/responses?email=sample@shift.com
```
