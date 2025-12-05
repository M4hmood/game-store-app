# NEXUS//VAULT - Cyberpunk Game Store

A futuristic cyberpunk-themed static web application for an online video game store. Features a retro-futuristic design with neon aesthetics, scanline effects, and an immersive gaming experience.

## ✨ Features

- **Cyberpunk Design System** - Neon colors, glowing effects, and retro-futuristic UI elements
- **Responsive Layout** - Fully responsive design that works on all devices
- **Multiple Pages**:
  - 🏪 Store/Home - Browse featured games and new releases
  - 📚 Library - Manage your game collection
  - 🔐 Sign In/Sign Up - User authentication pages
  - ⚙️ Admin Panel - Administrative dashboard

## 🎨 Design Features

- Custom CSS variables for consistent theming
- Grid-based layout with glassmorphism effects
- Animated hover states and transitions
- Scanline and CRT screen effects
- Neon glow shadows and gradients

## 🚀 Live Demo

Visit the live site: [https://m4hmood.github.io/game-store-app/](https://m4hmood.github.io/game-store-app/)

## 💻 Technologies Used

- HTML5
- CSS3 (Custom Properties, Grid, Flexbox)
- Pure CSS (No frameworks)
- GitHub Pages for hosting
- GitHub Actions for CI/CD

## 📁 Project Structure

```
game-app/
├── index.html          # Home/Store page
├── library.html        # Game library
├── signin.html         # Sign in form
├── signup.html         # Registration form
├── admin.html          # Admin dashboard
├── styles.css          # Main stylesheet
└── .github/
    └── workflows/
        └── deploy.yml  # GitHub Actions workflow
```

## 🛠️ Local Development

1. Clone the repository:
```bash
git clone https://github.com/M4hmood/game-store-app.git
cd game-store-app
```

2. Open with a local server:
```bash
# Using Python
python -m http.server 8000

# Using Node.js live-server
npx live-server

# Or simply open index.html in your browser
```

3. Visit `http://localhost:8000` in your browser

## 📄 License

This project is open source and available for educational purposes.
