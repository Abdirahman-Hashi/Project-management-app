# FAO Project Management System

A full-stack application for managing projects built with Laravel (Backend) and React (Frontend).

## Features

- Create, Read, Update, and Delete projects
- Project status management
- Modern and responsive UI
- RESTful API implementation
- MySQL database integration

## Prerequisites

- PHP >= 8.1
- Composer
- Node.js >= 14.x
- MySQL >= 8.0
- Git

## Installation

### Backend Setup (Laravel)

1. Clone the repository:
```bash
git clone <repository-url>
cd fao-project
```

2. Install PHP dependencies:
```bash
cd backend
composer install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in .env:
```
DB_CONNECTION=mysql
=> Comment out below if you are using SQLite.
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fao_projects
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Run migrations:
```bash
php artisan migrate
```

6. Start the Laravel server:
```bash
php artisan serve
```

### Frontend Setup (React)

1. Navigate to the frontend directory:
```bash
cd frontend
```

2. Install dependencies:
```bash
npm install
```

3. Start the development server:
```bash
npm run dev
```

## Database Schema

```sql
CREATE TABLE projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive', 'completed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## API Documentation

### Available Endpoints

- `GET /api/projects` - Get all projects
- `POST /api/projects` - Create a new project
- `GET /api/projects/{id}` - Get a specific project
- `PUT /api/projects/{id}` - Update a project
- `DELETE /api/projects/{id}` - Delete a project

## Screenshots

<img width="1512" alt="Screenshot 2025-01-21 at 8 52 28 PM" src="https://github.com/user-attachments/assets/3dbb8250-7424-4429-a871-d0701a7c7eb9" />
<img width="1512" alt="Screenshot 2025-01-21 at 8 53 21 PM" src="https://github.com/user-attachments/assets/2d46a025-3c76-4ec1-b057-4bd0ef44f21d" />
<img width="1512" alt="Screenshot 2025-01-21 at 8 53 44 PM" src="https://github.com/user-attachments/assets/4d6c5712-5758-4dd8-b524-ec7aa930c6ab" />
<img width="1450" alt="Screenshot 2025-01-21 at 8 59 49 PM" src="https://github.com/user-attachments/assets/4511b0bc-e8ef-49f4-82bb-c85f4735faf1" />
<img width="1450" alt="Screenshot 2025-01-21 at 9 00 59 PM" src="https://github.com/user-attachments/assets/0b141db1-1821-454d-b07c-67f8feb9bb84" />


## License

This project is licensed under the MIT License.
