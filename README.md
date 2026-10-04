# LitePost 🌟
 
A simplified Twitter-style social app built with PHP and Laravel. Users can create an account with a profile picture, post, reply in threads, like posts, and view each other's profiles.
 
## Features
 
- Register with an avatar upload, log in, and log out
- Post to a home feed showing the latest 20 posts
- Threaded replies, with a reply count on each post
- Like and unlike posts
- Profile pages with a user's posts, reachable by ID or `/@username`
- Edit your own bio (other users' profiles can't be edited)
## Tech stack
 
PHP 8.2+, Laravel 12, SQLite, Blade, Tailwind CSS 4, DaisyUI / FlyonUI, Vite

## Getting started
 
Requires PHP 8.2+, Composer, and Node.js 18+.
 
```bash
git clone https://github.com/1DA-1/LitePost.git
cd LitePost
 
composer install
npm install
 
cp .env.example .env
php artisan key:generate
 
touch database/database.sqlite
php artisan migrate
php artisan storage:link
```
 
Then run the app in two terminals:
 
```bash
php artisan serve   # terminal 1
npm run dev         # terminal 2
```
 
Open http://localhost:8000 and register an account.
 
## Technical highlights
 
- **Threaded replies:** each reply stores the post it answers and the first post of the thread, so a whole conversation can be fetched in one query.
- **Efficient feed:** like and reply counts are loaded in the same query as the posts, avoiding an extra query per post.
- **Data integrity:** a unique database index allows only one like per user per post.
- **Validation and authorization:** form request classes validate input, and users can only edit their own profile.
## Roadmap
 
- Follow and unfollow users (database table already in place)
- Notifications for likes and replies (model and table already in place)
- Personalized home feed based on who you follow
- Automated tests for the main user flows
## What I learned
 
- Designing a relational schema with threaded replies, likes, and follows
- Building authentication, validation, and authorization with Laravel
- Structuring a project using the MVC pattern
 
