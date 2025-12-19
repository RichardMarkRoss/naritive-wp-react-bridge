# Naritive Bridge – WordPress Plugin

This WordPress plugin provides the **legacy backend foundation** for the Naritive WordPress ↔ React Bridge challenge.

It registers a custom **Campaign** data model, exposes campaign data via a **custom REST API**, and includes a **secure legacy-style frontend form** for campaign creation.

---

## 📦 What This Plugin Does

### Core Features
- Registers a **Campaign** Custom Post Type (CPT)
- Stores structured campaign metadata
- Provides a frontend form for creating campaigns (legacy-compatible)
- Exposes campaign data via a **public, read-only REST API**
- Supports pagination, filtering, and search at the API level
- Uses no heavy third-party WordPress libraries (ACF, CPT UI, etc.)

---

## 🗂️ Plugin Structure

```text
naritive-bridge/
├── naritive-bridge.php
├── includes/
│   ├── Plugin.php
│   ├── CampaignCPT.php
│   ├── CampaignMeta.php
│   ├── RestController.php
│   └── Shortcodes/
│       └── CreateCampaign.php
└── assets/
    └── js/
        └── form.js (optional / unused)
```

---

## 🔧 Installation & Setup (Local)

### Prerequisites
- WordPress (recommended: **LocalWP**)
- PHP 8.0+
- MySQL

### Steps

1. Clone or download the repository.

2. Copy the plugin folder:
   ```text
   /plugin
   ```
   Rename it to:
   ```text
   naritive-bridge
   ```

3. Move it into your WordPress installation:
   ```text
   wp-content/plugins/naritive-bridge/
   ```

4. Log into **WordPress Admin** → **Plugins** → Activate **Naritive Bridge**.

---

## ✅ What to Expect After Activation

### In WordPress Admin
- A new menu item: **Campaigns**
- Ability to add/edit Campaigns from the admin UI

### Available Campaign Fields
| Field        | Type    |
|-------------|---------|
| Title        | String  |
| Client Name  | String  |
| Budget       | Numeric |
| Start Date   | Date    |
| Status       | Active / Paused |

---

## 📝 Frontend Campaign Creation Form

### How to Use

1. Create a new **Page** in WordPress.
2. Add the shortcode:
   ```text
   [naritive_create_campaign]
   ```
3. Publish the page.
4. Visit the page on the frontend.

### Behavior
- Secure POST-based form submission
- Nonce verification
- Input sanitization and validation
- On success, the campaign is saved and a confirmation message is shown

> Note: The form intentionally uses classic PHP POST handling to reflect legacy WordPress patterns.

---

## 🔌 REST API

### Endpoint

```http
GET /wp-json/naritive/v1/campaigns
```

This endpoint is **public and read-only** and returns only safe, required campaign fields.

---

### Supported Query Parameters

| Parameter     | Description |
|---------------|------------|
| `page`        | Page number (default: 1) |
| `per_page`    | Items per page (1–50, default: 10) |
| `status`      | `active` or `paused` |
| `budget_min`  | Minimum budget |
| `budget_max`  | Maximum budget |
| `search`      | Search by client name |

---

### Example Requests

```text
/wp-json/naritive/v1/campaigns?page=1&per_page=5
```

```text
/wp-json/naritive/v1/campaigns?status=active&search=acme
```

```text
/wp-json/naritive/v1/campaigns?budget_min=1000&budget_max=50000
```

---

## 📤 Example JSON Response

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

## 🔐 Security Considerations

- Nonce verification on all form submissions
- Input sanitization and validation
- REST API exposes **no internal WordPress user or system data**
- Public API is strictly **read-only**

---

## 🧪 Testing Checklist

- [ ] Plugin activates without errors
- [ ] Campaign CPT visible in WP Admin
- [ ] Frontend form creates campaigns successfully
- [ ] REST endpoint returns expected JSON
- [ ] Pagination, filtering, and search behave correctly

---

## ℹ️ Notes

- `assets/js/form.js` is included as a placeholder for legacy AJAX enhancement and is not required for core functionality.
- The plugin is designed to be consumed by a modern frontend (React dashboard).

---

## 👤 Author

Built as part of a technical challenge simulating real-world development at **Naritive Tech**.
