#!/bin/bash

echo "🚀 GOTeam Demo App - Quick Setup"
echo "================================="
echo ""

# Check if we're in the right directory
if [ ! -f "composer.json" ]; then
    echo "❌ Error: Please run this script from the project root directory"
    exit 1
fi

echo "📦 Installing PHP dependencies..."
composer install

echo ""
echo "📦 Installing Node.js dependencies..."
npm install --legacy-peer-deps

echo ""
echo "🔧 Setting up environment..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "   ✓ Created .env file"
fi

echo ""
echo "🔑 Generating application key..."
php artisan key:generate

echo ""
echo "🗄️ Setting up database..."
php artisan migrate

echo ""
echo "🌱 Seeding database with sample data..."
php artisan db:seed --class=TaskSeeder

echo ""
echo "🎭 Running demo setup..."
php demo.php

echo ""
echo "✅ Setup completed successfully!"
echo ""
echo "🚀 To start the application:"
echo "   Terminal 1: php artisan serve"
echo "   Terminal 2: npm run dev"
echo ""
echo "🌐 Then visit: http://localhost:8000"
echo ""
echo "👤 Test credentials:"
echo "   Email: test@example.com"
echo "   Password: password"
echo ""
echo "   Email: demo@example.com"
echo "   Password: password"
echo ""
echo "🎯 Features to explore:"
echo "   • Dashboard with task statistics"
echo "   • Task management (CRUD operations)"
echo "   • Automation workflows"
echo "   • Responsive design"
echo ""
echo "Happy coding! 🎉"
