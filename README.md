# LOSTndFOUND HUB

LOSTndFOUND HUB is a modern web application designed to help communities report and track lost or found items. Built with **Laravel 10** and **Vue.js/Vanilla JS**, it features a robust authentication system and a real-time feed for seamless user interaction.

## ✨ Key Features

- **🔐 User Authentication**: Secure Sign-Up, Sign-In, and Logout functionality.
- **📢 Post Management**: Create, view, and manage lost or found item announcements.
- **🔍 Advanced Filtering**: Filter posts by type (Lost/Found) to quickly locate items.
- **⚡ Real-Time Feed**: Dynamic updates for the latest posts without page reloads.
- **📱 Responsive Design**: Fully optimized for desktop and mobile devices using Tailwind CSS.
- **🛡️ Secure API**: Backend API protected with Laravel middleware.

## 🛠️ Tech Stack

- **Backend**: Laravel 10 (PHP)
- **Frontend**: Blade Templates, Tailwind CSS, Vanilla JS
- **Database**: SQLite (Default) / MySQL
- **Build Tool**: Vite

## 🚀 Local Setup Instructions

Follow these steps to get the project running on your local machine.

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/lostnfound-hub.git
cd lostnfound-hub
```

### 2. Install Dependencies
Install PHP and Node.js dependencies:
```bash
composer install
npm install
```

### 3. Configure Environment
Create a `.env` file by copying the example file:
```bash
cp .env.example .env
```

Generate your application key:
```bash
php artisan key:generate
```

### 4. Database Setup
Create the SQLite database file and run migrations:
```bash
# On Linux/Mac
touch database/database.sqlite

# On Windows (PowerShell)
New-Item -ItemType File -Path database/database.sqlite
```

Run the migrations to create tables:
```bash
php artisan migrate
```

### 5. Run the Application
Start the development servers in two separate terminals:

**Terminal 1 (Backend):**
```bash
php artisan serve
```

**Terminal 2 (Frontend Assets):**
```bash
npm run dev
```

The application will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

## 📖 Usage

1.  **Register**: Create an account to access full features.
2.  **Report an Item**: Use the sidebar form to report a Lost or Found item.
3.  **Browse**: View the feed to see items reported by others.
4.  **Filter**: Use the toggle buttons to switch between Lost and Found items.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---


