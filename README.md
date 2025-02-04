# Cloud Environment Applications - PHP Project

## Project Description
This is a web-based application designed to manage users, tasks, comments, and file uploads. The application is built using **PHP**, **MySQL**, and **Docker**. It features role-based access control, where **admin users** can manage all functionalities, while **regular users** have limited access.

## Features
## Features
1. **User Management**:
   - Admins can create, read, update, and delete users.
   - Regular users can only view their own profile.

2. **Task Management**:
   - Admins can create, read, update, and delete tasks.
   - Regular users can only view tasks assigned to them.

3. **Comment System**:
   - Admins can add, view, and delete comments.
   - Regular users can only view comments.

4. **File Upload**:
   - Admins and regular users can upload files.
   - Only admins can delete uploaded files.

5. **Role-Based Access Control**:
   - Admins have full access to all functionalities.
   - Regular users have restricted access.

6. **Login/Logout**:
   - Secure user authentication with session management.

## Technologies Used
- **PHP**: Backend logic and server-side scripting.
- **MySQL**: Database management.
- **Apache**: Web server.
- **Docker**: Containerization for easy deployment.
- **Docker Compose**: Orchestration of multi-container Docker applications.

## Project Setup
### 1️⃣ Clone the Repository
```sh
git clone <repository-url>
cd php-cloud-app
```

### 2️⃣ Run the Application with Docker Compose
```sh
docker compose up -d --build
```

### 3️⃣ Open in Browser
- **Application:** [http://localhost:8080](http://localhost:8080)
- **phpMyAdmin:** [http://localhost:8081](http://localhost:8081) 

### Log in with the following credentials:
- **Admin**:
- **Username**: admin
- **Password**: password

- **Regular User**:
-Register a new account via the registration page.


## Database Initialization
The database is initialized using the init.sql script located in the db directory. It creates the necessary tables and inserts a default admin account.

### Usage
- **Admin**:
- Manage users, tasks, comments, and files.
- Perform CRUD operations on all entities.

- **Regular User**:
- View tasks and comments.
- Upload files (cannot delete them).

## Authors
- Akida Mchomvu - 48037
- Batbold Samdan - 48528

## License
This project is open-source and free to use.

