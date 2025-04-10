# To-Do List Application

This is a simple To-Do List application built using Laravel for the backend and React.js (with TypeScript) and Tailwind CSS for the frontend. The application allows users to register, login, and manage tasks, including adding, editing, and soft-deleting tasks. Tasks can be categorized and filtered by their status (pending, completed).

## Features

- **User Authentication**: Implemented using Laravel's built-in authentication system.
- **Task Management**: Users can add, edit, soft delete, and restore tasks.
- **Categories**: Tasks can be categorized (e.g., Work, Personal, Urgent).
- **Task Status**: Each task has a status (e.g., pending, completed).
- **Search and Filter**: Tasks can be searched by title or description and filtered by status.
- **Pagination**: Task listing is paginated to enhance user experience.

## Tech Stack

- **Backend**: Laravel (PHP)
- **Frontend**: React.js, TypeScript, Tailwind CSS
- **Authentication**: Laravel Sanctum 
- **Database**: MySQL 

## Setup and Installation

### Backend (Laravel)

1.Clone the repository:

    ```bash
    git clone https://github.com/ahmedmo2399/todo-app.git
    cd todo-app
    ```

2. Install the dependencies:

    ```bash
    composer install
    ```

3. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

4. Generate the application key:

    ```bash
    php artisan key:generate
    ```

5. Configure your database connection in the `.env` file.

6. Run migrations to set up the database:

    ```bash
    php artisan migrate
    ```

7. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

    Your backend should now be running at `http://localhost:8000`.

### Frontend (React.js)

1.Clone the repository:

    ```bash
    git clone https://github.com/ahmedmo2399/task-manager-frontend.git
    cd task-manager-frontend
    ```

2. Install the dependencies:

    ```bash
    npm install
    ```

3. Start the development server:

    ```bash
    npm run dev
    ```

    Your frontend should now be running at `http://localhost:5173`.

4. Make sure that the frontend is configured to communicate with the backend at `http://localhost:8000`. You can modify the base URL in your API configuration if needed.

### CORS Configuration

If you're running the frontend and backend on different ports (like `localhost:5173` for the frontend and `localhost:8000` for the backend), you need to enable CORS in the Laravel backend. 

In `app/Http/Middleware/HandleCors.php` (or `config/cors.php`), ensure that the allowed origins are correctly set:

```php
'allowed_origins' => ['http://localhost:5173'],
