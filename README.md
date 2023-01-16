# A Simple News System..

### Overview.
This is a News app that allows users to create a news, edit news, delete news and show all news. 

As per requirement, the database used is sqlite database, upon creating a news, an event is dispatched which simply sends an email to the news owner (`user_id`) containting the news details such as the title and content. 

A simple logger can also be found in the storage logs file which is a text saying that the news has been created "News Created".

Based on the specification, this system also has a CRON JOB that runs everyday, this CRON job delete news that are older than 14days. Incase the CRON JOB fails in a live environment or if the server is down for unknown reason, this system gives room for flexibility, by adding console command which can be manually run from the projects terminal via the command: `php artisan news:delete-older-records`. Running this command will fetch all the news that are older than 14days (default) and delete them. To delete news older than more days like 30days, you may need to specify an argument to the command. For example, `php artisan news:delete-older-records 30`, this will delete news older than 30days.

### Solution Notes.

At a minimum, this solution has the following abilities:

1. Create A News - Route/Endpoint : `api/news/create` HTTP METHOD: `POST` Payloads: [fieldname: `title` Data Type: `string`, fieldname: `content` Data Type: `string`] 
2. Update A News - Route/Endpoint : `api/news/{news_uuid}` HTTP METHOD: `PUT` Payloads: [fieldname: `title` Data Type: `string`, fieldname: `content` Data Type: `string`]
3. Delete A News - Route/Endpoint : `api/news/{news_uuid}` HTTP METHOD: `DELETE`
4. Show A News - Route/Endpoint : `api/news/{news_uuid}` HTTP METHOD: `GET`
5. Fetch All News - Route/Endpoint : `api/news` HTTP METHOD: `GET`

### How has this been done?

- Setup & Installation of Laravel using the CLI command
- I started with creating the application underlying schemas and database structure. The database tables includes the `news` table and `user` table.
- After then, I configured the database env file to use SQLITE and not MYSQL.
- Created a new controller with CRUD functions for the news object and added routes endpoints to it.

- Created a Feature-Test for each CRUD endpoint and validate the JSON result and responses. I have used the PEST testing library for this as it supports Laravel testing out of the box.
- I used Laravel's form requests to inject the validation into the necessary methods and I injected the models repositories into the News Controller that depends on these models to work. Forexample the NewsController needs newsRepository.
- When a news is created, an event gets fired, notifying the news creator (user) about the details of the News they just created.
- This implementation uses the following actions `App\Actions\CreateNewsAction`, `App\Actions\UpdateNewsAction`, `App\Actions\DeleteNewsAction`, to implement the business logic.
- The repository pattern is also used in querying data from the database.
- Created a factory for the news object and fake content using Faker and seeders for News and Users.
- Create a new event NewsCreated and fire it everytime a new news object is created from the controller.
- Added model relationship belongsTo relation bewteen the news and user object using the `user_id` column of the News.
- Added Laravel's default authentication to protect the routes and updates the Feature-Tests using the `$this->actingAs($user)->get(...)` method.
- Assigned every new news entry to the current user `$request->user()` which returns the current user.
- Added console command to trigger news deletion and added a test for testing the Job that deletes the news.
## Getting started and Tooling

Before setting up this repository, the following are the dependencies that needs to be available on your machine:

### Tooling

- [Composer] for dependency management.
- [Pest] [https://pestphp.com/docs/installation] for the test suite.
- [Laravel] dependencies for the backend test suite.
- PHP (I have PHP 8.1.11 installed on my machine)
- For the mail, I have used SMTP - Mailhog, so if you have mailhog setup then no further action is required, else if mailtrap or or sendgrid then it may be required to update the `.env` file to reflect the MAIL configurations.


## Setup & Instruction for the backend:
1. Clone the repository: `git clone https://github.com/deendin/news-app.git`
2. Assuming that the Dependencies listed above are satisfied, you can ```cd``` into the directory called ```news-app.git```
4. Run `composer install` to install the project dependencies. When that is done, duplicate the content of `.env.example` into a new file called `.env` and run  `php artisan migrate --seed` to create the database tables and it's seeders.
5. In the project directory you can either run `php artisan serve` to start the laravel app or if you have valet setup, you can run `valet link` in this directory and then head to `http://news-app.test` to see the application running.
6. To test, duplicate the contnet of the `.env.test.example` to a new `.env.tesing` file, run `php artisan test`, which is expected to run this tests.


## Instruction and testing
1. Running `php artisan test` will test all the feature tests e.g: The create news, update news, delete news, show news features and its JSON expected responses and results.
2. Testing from POSTMAN is also possible by hitting the endpoints states in the overview above. Note that the endpoints are protected using Laravels default authentication system for API's - Laravel Sanctum. To successfully call the endpoints from POSTMAN or via CURL, it is expected to parse a header to every single request. This header can be called: key: 'Authorisation' and should have a value of the generated token which must have been generated when the user registers. But because this system doesn't have an auth system to register and login a user, the test cases has a way of creating a user and generating a user token which is then parsed and used on every request to call the endpoints/routes.
So, runining the test command should be enough to test the functionalities for the time being.


### Example Output - When a news gets created either from the test or Postman
<img width="1302" alt="example_input" src="https://user-images.githubusercontent.com/118926333/212630085-e7662451-3125-41f4-976c-337cc150e95b.png">

### What I could have done better if I had more time (Mostly out of the task specification):

1. More tests for each feature test to test for the console command event though there is a test for the Job that gets triggered to delete the older News.
2. Lint to lint the code files.
3. Handle pagination of news listing.
4. Although, the feature test for the CRUD function tests the expected JSON responses and results, in a more production ready system, it would be ideal to test the Resources and Collections that returns the data.