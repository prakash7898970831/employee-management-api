# Employee Management REST API

## Project Overview

This project is a REST API built in PHP (Laravel) to manage employees and departments.

* A company has multiple departments.
* Each employee belongs to one department and can have multiple contact numbers and addresses.
* The API provides CRUD operations for departments and employees.
* Search functionality for employees by name, email, or department.

---

## Features

* Create, Read, Update, Delete departments
* Create, Read, Update, Delete employees
* Search employees by name, email, or department
* Multiple contact numbers and addresses per employee
* Authentication

---

## API Endpoints

### Departments

| Method | Endpoint                 | Description             |
| ------ | ------------------------ | ----------------------- |
| GET    | /api/v1/departments      | List all departments    |
| POST   | /api/v1/departments      | Create a new department |
| GET    | /api/v1/departments/{id} | View a department       |
| PUT    | /api/v1/departments/{id} | Update a department     |
| DELETE | /api/v1/departments/{id} | Delete a department     |

### Employees

| Method | Endpoint                 | Description                  |
| ------ | ------------------------ | ---------------------------- |
| GET    | /api/v1/employees        | List all employees           |
| POST   | /api/v1/employees        | Create a new employee        |
| GET    | /api/v1/employees/{id}   | View an employee             |
| PUT    | /api/v1/employees/{id}   | Update an employee           |
| DELETE | /api/v1/employees/{id}   | Delete an employee           |
| GET    | /api/v1/employees/search | Search employees by criteria |

---

## Database Structure

### Departments Table

| Column      | Type      |
| ----------- | --------- |
| id          | integer   |
| name        | string    |
| description | text      |
| created_at  | timestamp |
| updated_at  | timestamp |
| deleted_at  | timestamp |

### Employees Table

| Column        | Type      |
| ------------- | --------- |
| id            | integer   |
| department_id | integer   |
| first_name    | string    |
| last_name     | string    |
| designation   | string    |
| email         | string    |
| date_of_birth | date      |
| created_at    | timestamp |
| updated_at    | timestamp |
| deleted_at    | timestamp |

### Employee Contacts Table

| Column         | Type      |
| -------------- | --------- |
| id             | integer   |
| employee_id    | integer   |
| contact_number | string    |
| type           | string    |
| created_at     | timestamp |
| updated_at     | timestamp |

### Employee Addresses Table

| Column        | Type      |
| ------------- | --------- |
| id            | integer   |
| employee_id   | integer   |
| address_line1 | string    |
| address_line2 | string    |
| city          | string    |
| state         | string    |
| pincode       | string    |
| country       | string    |
| created_at    | timestamp |
| updated_at    | timestamp |

---

## Setup Instructions

### 1. Clone Repository

```bash
git clone https://github.com/prakash7898970831/employee-management-api.git
cd employee-management-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

```bash
# Copy .env.example to .env
cp .env.example .env
```

* Open `.env` and update your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Start Server

```bash
php artisan serve
```

* Access the API at: `http://127.0.0.1:8000/api/v1`

---

## Testing / Unit Tests

### Create Test

```bash
php artisan make:test EmployeeTest --unit
```

### Run Tests

```bash
php artisan test
```

### Example Test Case

```php
public function test_create_employee()
{
    $response = $this->postJson('/api/v1/employees', [
        'department_id' => 1,
        'first_name' => 'Prakash',
        'last_name' => 'Singh',
        'email' => 'prakash@example.com',
        'date_of_birth' => '1999-08-05'
    ]);

    $response->assertStatus(201)
             ->assertJson([
                 'success' => true
             ]);
}
```

---
### Authentication & Protected APIs
## 1. Register a New User
Endpoint: POST /api/v1/register
Description: Create a new user account.
Request Body Example:
```bash
{
  "name": "Test",
  "email": "abc@gmail.com",
  "password": "123456",
  "password_confirmation": "123456"
}
```
Response Example:
```bash
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "Test",
      "email": "abc@gmail.com"
    }
  }
}
```

## 2. Login / Get Access Token
Endpoint: POST /api/v1/login
Description: Login with email and password to obtain an access token.
Request Body Example:
```bash
{
  "email": "abc@gmail.com",
  "password": "123456"
}
```

Response Example:
```bash
{
  "success": true,
  "token": "YOUR_ACCESS_TOKEN_HERE",
  "token_type": "Bearer",
  "expires_in": 3600
}
```
## 3. Logout
```bash
Endpoint: POST /api/v1/logout
```
Description: Logs out the user and revokes the access token.
Headers:
Authorization: Bearer YOUR_ACCESS_TOKEN_HERE
Response Example:
```bash
{
  "success": true,
  "message": "Logged out successfully"
}
```
------------------
## Notes
* Ensure you have **PHP, Composer, and MySQL** installed.
