
# Pet Management System
## Description
This is a pet management system application built with Vue.js for the frontend and Symfony for the backend. It allows users to manage pets, including registration, viewing, and editing.
## Setup
### Prerequisites
- Docker
- PHP
- Composer
- Node.js
- npm
### Installation
1. Clone the repository:

```
git clone git@github.com:mail2nisam/docupet.git
```
2. Navigate to the project directory:
```
cd docupet
```
3. Run Docker Compose to set up the project:
```
docker-compose up -d
```
### Configuration
#### Backend
1. Navigate to the `backend` folder:
```
cd backend
```
2. Create the database if it is not created:
```
php bin/console doctrine:database:create
```
3. Load fixtures:
```
php bin/console doctrine:fixtures:load
```
#### Frontend

No additional configuration required.
## Usage
1. Access the application in your web browser:
- Frontend: [http://localhost:8080](http://localhost:8080)
- Backend: [http://localhost:9000](http://localhost:9000)
2. Login with the following credentials:
- Username: admin
- Password: pass_1234
## Folders
-  `frontend`: Contains the Vue.js frontend code.
-  `backend`: Contains the Symfony backend code.
## Packages used
### Backend
- `lexik/jwt-authentication-bundle` for simple `jwt` auth
- `nelmio/cors-bundle` for dev `CORS`
- `doctrine/doctrine-migrations-bundle` for DB migration
### Frontend
- `fortawesome/fontawesome-free`
- `vueform/multiselect`
- `vuepic/vue-datepicker`
- `vuex`
- `vue-router`
### Note
- `vuex` implementation is not fully utilized in the app