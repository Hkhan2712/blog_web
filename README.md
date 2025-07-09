Thanks! Since you're using **Pure PHP**, here’s a clean and professional `README.md` for your blog project:

---

# Blog Web 📝

A simple and lightweight blog application built with **Pure PHP** — no frameworks involved. This project demonstrates core web development concepts like routing, form handling, CRUD operations, and basic templating.

## 🚀 Features

* 📰 Create, read, update, and delete (CRUD) blog posts
* 📋 List all posts
* 🔍 View single post details
* 📤 Image upload support
* 🧼 Clean structure with separation of logic and presentation (MVC-style)

## 📁 Folder Structure

```
blog_web/
├── config/           # Database configuration
├── controllers/      # Request handling logic
├── models/           # Data interaction (e.g., Post, User)
├── views/            # HTML templates
├── uploads/          # Uploaded images
├── public/           # Publicly accessible assets (CSS, JS)
├── index.php         # Front controller (entry point)
└── README.md
```

## ⚙️ Requirements

* PHP >= 7.4
* MySQL or MariaDB
* Apache/Nginx with URL rewriting enabled
* A local server like XAMPP, Laragon, or built-in PHP server

## 🛠️ Setup Instructions

1. **Clone the repository**

```bash
git clone https://github.com/Hkhan2712/blog_web.git
cd blog_web
```

2. **Configure your database**

* Create a MySQL database (e.g., `blog_web`)
* Import the SQL file if available (or create tables manually)

3. **Set up environment**

* Edit `config/database.php` and update with your DB credentials:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_web');
define('DB_USER', 'root');
define('DB_PASS', '');
```

4. **Run the project**

* Option A: Start PHP’s built-in server

```bash
php -S localhost:8000
```

* Option B: Place the project in `htdocs/` if using XAMPP or similar

Then visit:
👉 `http://localhost:8000` or `http://localhost/blog_web/`

## ✏️ Usage

* Visit `/` to see the homepage with posts
* Use the "Create" button to add a new post
* Click a post title to view full content
* Use edit/delete options for each post

## 📌 Notes

* CSRF protection, validation, and authentication may be limited (add as needed)
* This is a learning project and not yet production-ready
* Follow MVC principles manually (optional)

## 🤝 Contributing

Feel free to fork the project, open issues, or submit pull requests!

## 📄 License

This project is open-source and free to use under the [MIT License](LICENSE).

---

Let me know if you’d like to add a section for database schema, screenshots, or deployment instructions!
