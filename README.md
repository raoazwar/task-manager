# Task Manager

<p align="center">
  <img src="https://img.shields.io/badge/built%20with-Laravel%20%7C%20Livewire%20%7C%20Alpine.js%20%7C%20Tailwind%20CSS-blueviolet" alt="Tech Stack" />
</p>

A modern, beautiful, and responsive web application for managing your daily tasks with ease and style. Task Manager helps you stay organized, productive, and on top of your priorities with a delightful user experience.

**Created and maintained by [Rao Azwar](https://github.com/raoazwar).**

---

## Features

- User authentication (login, register, password reset, email verification)
- Dashboard with task stats and reminders
- Create, edit, delete, and complete tasks
- Task priorities and due dates
- Inline form validation and error feedback
- Reminders and highlights for tasks due soon
- Search and filter tasks
- Calendar view for tasks (FullCalendar.js)
- Responsive and modern UI/UX

## Requirements

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL or compatible database

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/your-username/task-manager.git
cd task-manager
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment setup

Copy the example environment file and set your own values:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

Edit `.env` to set your database and mail credentials.

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Build frontend assets

For development (with hot reload):
```bash
npm run dev
```
For production:
```bash
npm run build
```

### 6. Start the application

```bash
php artisan serve
```
Visit [http://localhost:8000](http://localhost:8000) in your browser.

## Deployment

- Set up your production environment (database, mail, etc.)
- Build assets with `npm run build`
- Use a web server (e.g., Nginx/Apache) pointing to the `public/` directory
- Set correct permissions for `storage/` and `bootstrap/cache/`

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

## License

This project is open-sourced software licensed under the MIT license.
