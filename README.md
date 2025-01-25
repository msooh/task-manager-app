Task Manager Application

A simple Laravel-based task management application that enables users to manage tasks with the following features:

* **Create Tasks**: Add new tasks with a name and priority.
* **Edit Tasks**: Modify existing task details.
* **Delete Tasks**: Remove tasks permanently.
* **Reorder Tasks**: Drag and drop tasks to reorder them in the browser. The priority is automatically updated based on the new order.
- **Project Functionality**: Assign tasks to specific projects and filter tasks by the selected project.

## Features
- Responsive and user-friendly interface.
- Tasks and projects stored in a MySQL database.
- Automatic priority management on task reorder.
- Clean and maintainable code following Laravel best practices.

---
Installation & Setup

### Prerequisites
Ensure you have the following installed on your system:
- PHP (>= 8.1)
- Composer
- MySQL
- Node.js & npm (for frontend dependencies)

### Setup Steps
1. Clone the repository:
git clone https://github.com/your-username/task-manager-app.git
cd task-manager-app

2. Install PHP dependencies with Composer:
composer install

3. Install JavaScript dependencies using npm:
npm install
npm run dev

4. Create a .env file by copying .env.example:
cp .env.example .env

5. Generate an application key:
php artisan key:generate

6. Setup your database:
Update the .env file with your database credentials.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=your_username
DB_PASSWORD=your_password

7. Run the migrations:
php artisan migrate

8. Start the development server:
php artisan serve