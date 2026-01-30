# php-rest-api-auth

# PHP REST API with Authentication

A lightweight PHP REST API demonstrating user authentication and protected routes.

## Features
- User registration
- User login
- Token-based authentication
- Protected profile endpoint
- PDO + MySQL
- PSR-4 Autoloading

## Endpoints

POST /api/register  
POST /api/login  
GET /api/profile (Bearer token required)

## Setup
1. Copy .env.example to .env
2. Configure database
3. Run composer install
4. Create users table

## Example users table

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
