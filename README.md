# Quiz of Kings Remake

A web-based recreation of the popular Iranian trivia game "Quiz of Kings" – an exciting online competition where players test their knowledge across various topics. This project is built as an early personal endeavor using modern web technologies to deliver a fun, interactive trivia experience.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg?style=flat-square&logo=laravel)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-blue.svg?style=flat-square)](https://livewire.laravel.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple.svg?style=flat-square&logo=bootstrap)](https://getbootstrap.com)

## 📖 Description

"Quiz of Kings" is originally a mobile trivia game beloved in Iran, featuring over 1,000,000 questions on topics like general knowledge, sports, cinema, music, math, religion, and more. It supports competitive gameplay for two players, with 6 rounds (each player chooses 3 topics), chat features, friend-making, and group competitions.

This remake brings the essence of the game to the web:
- **Competitive Trivia**: Challenge friends or random opponents in knowledge-based duels.
- **Diverse Questions**: Text and image-based questions across multiple categories.
- **Social Elements**: User profiles, real-time interactions, and potential for group play.
- **Responsive Design**: Seamless experience on desktop and mobile thanks to Bootstrap.

This is an early project, so it focuses on core functionality like user authentication, question management, and basic gameplay. Future enhancements could include advanced scoring, leaderboards, and multiplayer lobbies.

## ✨ Features

- **User Authentication**: Register, login, and manage profiles.
- **Trivia Gameplay**: Select topics, answer questions, and compete in rounds.
- **Question Database**: Administer and categorize questions (text/image-based).
- **Real-Time Updates**: Powered by Livewire for dynamic, AJAX-like interactions without full page reloads.
- **Responsive UI**: Clean, modern interface styled with Bootstrap.
- **Docker Support**: Easy setup for development and deployment.

## 🛠️ Technologies Used

- **Backend**: Laravel (PHP framework for routing, models, controllers, and database management).
- **Frontend**: Bootstrap (CSS framework for styling) + Livewire (for reactive components).
- **Asset Management**: Vite (modern frontend build tool).
- **Database**: MySQL (via Laravel migrations and seeders).
- **Other Tools**: Composer for PHP dependencies, NPM for JS packages, Docker for containerization.

## 📸 Screenshots

<!-- Add screenshots here if available, e.g.: -->
<!-- ![Login Screen](screenshots/login.png) -->
<!-- ![Gameplay](screenshots/gameplay.png) -->

## 🚀 Installation

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL (or another database supported by Laravel)
- Git

### Steps Using Docker (Recommended)

1. Ensure Docker and Docker Compose are installed.
2. Build and start containers:
   ```
   docker-compose up -d
   ```
3. Access the app at `http://localhost:8080` (or the configured port).
4. Run migrations inside the container:
   ```
   docker-compose exec app php artisan migrate --seed
   ```
   
## 🔧 Usage

1. **Register/Login**: Create an account to start playing.
2. **Start a Quiz**: Choose an opponent (or play solo), select topics, and answer questions in rounds.
3. **Admin Features** (if implemented): Add/edit questions via the admin panel.
4. **Customize**: Explore the code in `app/Models` for data structures, `app/Http/Controllers` for logic, `resources/views` for Blade templates, and `routes/web.php` for endpoints.

For development, use `npm run dev` for live asset rebuilding with Vite.

## 🤝 Contributing

Contributions are welcome! This is an early project, so feel free to:
- Report issues or suggest features via GitHub Issues.
- Fork the repo, make changes, and submit a Pull Request.

Please follow Laravel's coding standards and add tests where possible.

## 📄 License

This project is open-source. Feel free to use, modify, and distribute.

---

Built with ❤️ by [smrasoul](https://github.com/smrasoul). Inspired by the original Quiz of Kings game. If you enjoy it, star the repo! ⭐
