# Naritive Bridge Dashboard (React + TypeScript)

This is the **modern frontend dashboard** for the Naritive WordPress ↔ React Bridge challenge.

The dashboard consumes campaign data from a custom WordPress REST API and demonstrates best practices in **React, TypeScript, Tailwind CSS, state management, and API integration**.

---

## 🧰 Tech Stack

- React
- TypeScript
- Vite
- Tailwind CSS

---

## 📦 Features

- Campaign Monitor dashboard (table/grid layout)
- Server-side pagination (Next / Previous)
- Search by client name
- Filter by campaign status (Active / Paused)
- Budget formatted as currency
- Loading, error, empty, and success states
- Lazy-loaded campaign table
- Manual refresh button to re-fetch data

---

## 🔧 Prerequisites

- Node.js **18+** (recommended: Node 20)
- npm

---

## 🚀 Setup & Run

### 1) Install dependencies
```bash
cd dashboard
npm install
```

### 2) Configure API base URL
Create a `.env` file in the `dashboard/` directory:

```env
VITE_API_BASE_URL=http://YOUR-WP-SITE/wp-json/naritive/v1
```

Example (LocalWP):
```env
VITE_API_BASE_URL=http://naritive-bridge.local/wp-json/naritive/v1
```

⚠️ Restart the dev server after creating or updating `.env`.

---

### 3) Start the development server
```bash
npm run dev
```

Open in your browser:
```
http://localhost:5173
```

---

## 🔌 API Contract

The dashboard expects the following endpoint to be available:

```http
GET /wp-json/naritive/v1/campaigns
```

### Example Response
```json
{
  "data": [
    {
      "id": 12,
      "title": "Acme Q4 Campaign",
      "client_name": "Acme Corp",
      "budget": 15000,
      "start_date": "2024-09-01",
      "status": "active"
    }
  ],
  "meta": {
    "page": 1,
    "per_page": 10,
    "total": 42,
    "total_pages": 5
  }
}
```

---

## 🧪 What to Test

- Search updates the list (client name)
- Status dropdown filters results
- Pagination triggers server-side fetches
- Refresh button re-fetches campaigns
- Loading spinner/message appears during fetch
- Error message appears if API is unreachable
- Empty state appears when no results are returned

---

## 🧠 Architectural Notes

- API access is isolated in `/src/api`
- Shared data contracts live in `/src/types`
- Page-level state is managed in `/src/pages/Dashboard.tsx`
- UI components are reusable and stateless where possible
- Server-side pagination is enforced (no client-side slicing)

---

## 🛠 Troubleshooting

### CORS Errors
If your WordPress site runs on a different origin than the Vite dev server, you may see CORS errors.

**Options:**
- Use a Vite dev proxy
- Enable CORS headers in WordPress for local development

---

## 👤 Author

Built as part of a technical challenge simulating real-world development at **Naritive Tech**.
