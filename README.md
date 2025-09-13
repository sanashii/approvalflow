# GOTeam Demo App

A mini workflow application that showcases automation features, task management, and front/backend integration using modern web technologies.

## 🚀 Features

### Core Functionality
- **User Authentication** - Register, Login, Logout using Laravel Breeze
- **Task Management** - Full CRUD operations for tasks
- **Dashboard** - Overview with task statistics and recent tasks
- **Responsive Design** - Mobile-friendly interface with Tailwind CSS

### Task Management
- Create, read, update, and delete tasks
- Task fields: title, description, priority (Low/Normal/High), status (Pending/In Progress/Completed)
- Real-time updates without page reload
- Inline editing and quick status updates

### Automation Features
- **Auto-completion** - Tasks in "In Progress" status for 7+ days are automatically completed
- **Escalation** - High priority tasks pending for 3+ days are flagged for attention
- **Monitoring** - Automated logging and statistics tracking
- **Manual Trigger** - Run automation workflows on-demand

## 🛠️ Technology Stack

### Backend
- **PHP 8.2+** with **Laravel 12**
- **SQLite** database for easy setup and portability
- **Inertia.js** for seamless Laravel + Vue.js integration
- **Ziggy** for route handling in JavaScript

### Frontend
- **Vue.js 3** with **TypeScript**
- **Vite** for fast development and building
- **Tailwind CSS** for styling
- **Axios** for HTTP requests

### Development Tools
- **Laravel Breeze** for authentication scaffolding
- **Laravel Pint** for code formatting
- **PHPUnit** for testing
- **Concurrently** for running multiple dev processes

## 📁 Project Structure

```
approvalflow/
├── app/
│   ├── Console/Commands/
│   │   └── RunTaskAutomation.php    # Automation command
│   ├── Http/Controllers/
│   │   └── TaskController.php        # Task CRUD operations
│   ├── Models/
│   │   ├── Task.php                  # Task model
│   │   └── User.php                  # User model (extended)
│   └── Services/
│       └── TaskAutomationService.php # Automation logic
├── database/
│   ├── migrations/
│   │   └── create_tasks_table.php    # Tasks schema
│   └── seeders/
│       └── TaskSeeder.php            # Sample data
├── resources/
│   ├── ts/                           # Frontend TypeScript code
│   │   ├── Pages/
│   │   │   ├── Dashboard.vue         # Dashboard with stats
│   │   │   └── Tasks.vue             # Task management page
│   │   ├── Components/               # Reusable Vue components
│   │   └── Layouts/
│   │       └── AuthenticatedLayout.vue
└── routes/
    └── web.php                       # Application routes
```

## 🚀 Quick Start

### Prerequisites
- PHP 8.2 or higher
- Node.js 18+ and npm
- Composer

### Installation

1. **Clone and setup the project:**
   ```bash
   git clone <repository-url>
   cd approvalflow
   composer install
   npm install --legacy-peer-deps
   ```

2. **Environment setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database setup:**
   ```bash
   php artisan migrate
   php artisan db:seed --class=TaskSeeder
   ```

4. **Start development servers:**
   ```bash
   # Terminal 1 - Laravel server
   php artisan serve
   
   # Terminal 2 - Vite dev server
   npm run dev
   ```

5. **Access the application:**
   - Open http://localhost:8000
   - Register a new account or use test credentials:
     - Email: `test@example.com`
     - Password: `password`

## 📊 Database Schema

### Users Table (Laravel Breeze)
- `id`, `name`, `email`, `password`, `timestamps`

### Tasks Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `title` - Task title (required)
- `description` - Task description (optional)
- `priority` - Enum: Low, Normal, High (default: Normal)
- `status` - Enum: Pending, In Progress, Completed (default: Pending)
- `timestamps` - created_at, updated_at

## 🔄 Automation Workflows

### Available Automations

1. **Auto-completion**: Tasks in "In Progress" status for 7+ days are automatically marked as "Completed"
2. **Escalation**: High priority tasks pending for 3+ days are logged for attention
3. **Monitoring**: Tracks high priority tasks and completion rates

### Running Automations

**Command Line:**
```bash
php artisan tasks:automation
```

**Web Interface:**
- Navigate to Tasks page
- Click "Run Automation" button

## 🎯 API Endpoints

### Authentication Routes
- `GET /` - Welcome page
- `GET /dashboard` - Dashboard (auth required)
- `GET /login` - Login page
- `POST /login` - Login
- `GET /register` - Register page
- `POST /register` - Register
- `POST /logout` - Logout

### Task Routes (auth required)
- `GET /tasks` - List all tasks
- `POST /tasks` - Create new task
- `PATCH /tasks/{task}` - Update task
- `DELETE /tasks/{task}` - Delete task
- `PATCH /tasks/{task}/status` - Update task status
- `POST /tasks/automation` - Run automation workflows

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Run automation command to test workflows:
```bash
php artisan tasks:automation
```

## 🚀 Deployment

### Production Build
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Environment Variables
Ensure these are set in production:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_CONNECTION=sqlite` (or configure your preferred database)

## 📈 Features Showcase

### Task Management
- ✅ Create tasks with title, description, priority, and status
- ✅ Edit tasks inline with form validation
- ✅ Quick status updates via dropdown
- ✅ Delete tasks with confirmation
- ✅ Real-time updates without page reload

### Dashboard Analytics
- ✅ Task statistics (total, pending, in progress, completed)
- ✅ Recent tasks overview
- ✅ Visual indicators with color coding
- ✅ Quick navigation to task management

### Automation Demo
- ✅ Automated task completion based on time
- ✅ Priority-based escalation
- ✅ Comprehensive logging and monitoring
- ✅ Manual trigger capability

### Responsive Design
- ✅ Mobile-first approach
- ✅ Tailwind CSS styling
- ✅ Consistent component library
- ✅ Accessible navigation

## 🔧 Development

### Code Style
```bash
php artisan pint
```

### Database Reset
```bash
php artisan migrate:fresh --seed
```

### Clear Caches
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

---

**Built with ❤️ using Laravel, Vue.js, and modern web technologies.**