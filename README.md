# Naritive WordPress ↔ React Bridge

This repository contains a practical bridge application demonstrating how to connect a **legacy WordPress backend** with a **modern React + TypeScript frontend**, mirroring real-world work at Naritive Tech.

The focus of this project is **code quality, architecture, security, and maintainability** rather than visual polish.

---

## 📁 Repository Structure

```text
naritive-wp-react-bridge/
├── plugin/          # Custom WordPress plugin (PHP, OOP)
├── dashboard/       # React + TypeScript dashboard
├── README.md        # This documentation
```

---

## 🧩 Part 1: WordPress Plugin (Legacy Foundation)

### Overview
A standalone WordPress plugin that:
- Registers a custom **Campaign** post type
- Stores campaign metadata
- Exposes campaign data via a secure, read-only REST API
- Provides a legacy-style frontend form for campaign creation

### Features
- **Custom Post Type:** Campaigns
- **Meta Fields:**
  - Client Name (string)
  - Budget (numeric)
  - Start Date (date)
  - Status (Active / Paused)
- **Frontend Campaign Creation**
  - Implemented via shortcode
  - Uses standard PHP form handling or jQuery-based AJAX
  - Nonce verification and sanitization included
- **REST API**
  - Namespace: `/wp-json/naritive/v1`
  - Endpoint: `/campaigns`
  - Supports:
    - Pagination (`page`, `per_page`)
    - Filtering (status, budget range)
    - Search (client name)
  - Public read-only access
  - Returns only safe, required fields

---

### 🔧 Plugin Installation (Local)

1. Set up a local WordPress environment  
   Recommended:
   - **LocalWP** (https://localwp.com)

2. Copy the plugin folder:
   ```text
   /plugin
   ```
   into:
   ```text
   wp-content/plugins/
   ```

3. Activate **Naritive Bridge Plugin** from the WordPress Admin panel.

4. (Optional) Create a page and add the shortcode:
   ```text
   [naritive_create_campaign]
   ```
   to access the legacy campaign creation form.

---

### 🔌 REST API Example

```http
GET /wp-json/naritive/v1/campaigns?page=1&per_page=10&status=active&search=acme
```

Example response:
```json
{
  "data": [
    {
      "id": 1,
      "client_name": "Acme Corp",
      "budget": 15000,
      "start_date": "2024-09-01",
      "status": "active"
    }
  ],
  "meta": {
    "page": 1,
    "per_page": 10,
    "total": 42
  }
}
```

---

## 🖥️ Part 2: React + TypeScript Dashboard

### Overview
A modern dashboard that consumes the WordPress REST API and displays campaign data in a clean, interactive UI.

### Tech Stack
- React
- TypeScript
- Vite
- Tailwind CSS

### Features
- Campaign table/grid display
- Currency-formatted budgets
- Search by client name
- Status filter (Active / Paused)
- Server-side pagination
- Loading, error, and empty states

---

### 🚀 Dashboard Setup

```bash
cd dashboard
npm install
npm run dev
```

The app will be available at:
```text
http://localhost:5173
```

### Environment Variables

Create a `.env` file in `/dashboard`:

```env
VITE_API_BASE_URL=http://your-local-wp-site/wp-json/naritive/v1
```

---

## 🧪 Development Notes

- WordPress plugin is written using an **OOP architecture**
- No heavy third-party WP libraries (ACF, CPT UI) are used
- API responses are intentionally shaped to avoid exposing internal WP data
- React components are kept small and composable
- API logic is isolated from UI components

---

## 📦 Deployment (Optional)

- **WordPress:** LocalWP or InstaWP (temporary public demo)
- **React Dashboard:** Vercel (free tier)

---

## 🧭 Git Workflow

- Incremental commits reflecting real-world development
- Clear commit messages
- Monorepo structure for easier review

---

## 👤 Author

Built as part of a technical challenge simulating a day at **Naritive Tech**.
