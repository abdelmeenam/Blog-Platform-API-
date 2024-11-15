# Blog Platform API
A RESTful API for a blog platform using Laravel. The API should allow users to
perform CRUD operations on blog posts, with user authentication and role-based
permissions.

## Setup

1. Clone the repository and navigate to the project folder.
2. Run the following commands:
    ```bash
    composer install
    composer dump-autoload
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan jwt:secret
    ```
3. Configure your `.env` file with your database credentials such as : 
DB_CONNECTION=sqlite && DB_DATABASE=/path_to_your_database/database.sqlite



## Authentication

- Use JWT for authentication.
- Register using `/register` and login using `/login`.
- Include the JWT token in the Authorization header as `Bearer <token>` for all protected routes.

## Endpoints

- **POST /api/posts** - Create a new post (Authenticated, Author only).
- **GET /api/posts** - List all posts with filters (Category Date range) and Search blog posts by title, author, or category
- **GET /api/posts/{id}** - Show a single post with author's details.
- **PUT /api/posts/{id}** - Update a post (Admin or Post Author).
- **DELETE /api/posts/{id}** - Delete a post (Admin or Post Author).
- **POST /api/posts/{id}/comments** - Add a comment to a post (Authenticated).

## Roles

- **Admin** - Full access to all posts and users & must be assigned to specifi user through seeders.
- **Author** - Default role that  Can only manage their own posts.

## Database Setup and Seeding

### **General Seeder**
The **DdatabaseSeeder** creates:
- **1 user admin** (can be used for testing as the initial user).
- **5 additional normal users** created with random data using the **User Factory**.
- **50 blog posts** with random titles, content, categories, and assigned to random users (created by ).

### **Role Seeder**
The **Role Seeder** assigns roles to the users:
- The first user gets the **`admin`** role.


## How to Seed the Database

To seed the database with users, posts, and roles, run the following Artisan command:

```bash
php artisan db:seed
php artisan db:seed --class=RolesAndPermissionsSeeder
```

## Running the Application

Run the Laravel development server:

```bash
php artisan serve
