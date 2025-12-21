# Naritive WordPress ↔ React Bridge

This repository contains a **full-stack bridge application** that simulates real-world work at **Naritive Tech**.

It demonstrates how to connect a **legacy WordPress backend** with a **modern React + TypeScript dashboard**, focusing on **architecture, code quality, security, and workflow** rather than visual polish.

---

## 📦 Repository Overview

This is a **monorepo** containing two main parts:

```text
naritive-wp-react-bridge/
├── plugin/     # WordPress plugin (legacy backend)
├── dashboard/  # React + TypeScript dashboard (modern frontend)
└── .github/    # CI workflows and PR templates
```

---

## 🧩 Part 1: WordPress Plugin (Legacy Foundation)

Located in: `plugin/`

### Responsibilities
- Register a **Campaign** Custom Post Type (CPT)
- Store campaign metadata (client, budget, dates, status)
- Provide a secure **legacy-style frontend form** for creating campaigns
- Expose campaign data via a **custom REST API**
- Support server-side pagination, filtering, and search

### Documentation
📄 See **`plugin/README.md`** for:
- Local installation instructions
- How to activate and use the plugin
- REST API documentation and example JSON responses

---

## 🖥️ Part 2: React Dashboard (Modern Frontend)

Located in: `dashboard/`

### Responsibilities
- Consume the WordPress REST API
- Display campaigns in a clean table/grid layout
- Provide search, status filtering, and server-side pagination
- Handle loading, error, empty, and success states gracefully
- Demonstrate modern React + TypeScript best practices

### Documentation
📄 See **`dashboard/README.md`** for:
- How to install dependencies
- Environment variable setup
- How to start the development server

---

## 🔄 Part 3: Workflow & DevOps

This repository demonstrates professional workflow practices:

- Feature-based branching strategy
- Conventional commit messages
- Pull Request template for structured reviews
- GitHub Actions CI:
  - PHP linting for the WordPress plugin
  - Install, type-check, and build validation for the React dashboard
- Monorepo-friendly CI path filtering

No production deployment is configured — CI exists to validate correctness and delivery readiness.

---

## 🚀 Quick Start (Local)

1. Install and activate the WordPress plugin  
   → Follow **`plugin/README.md`**

2. Run the React dashboard  
   → Follow **`dashboard/README.md`**

Both parts are designed to run locally and independently.

---

## 🧠 Design Philosophy

- Prefer clarity and maintainability over over-engineering
- Keep a strict boundary between backend and frontend concerns
- Expose only safe, intentional data via the API
- Treat documentation and workflow as first-class citizens

---

## 👤 Author

Built as part of a technical challenge simulating a day of work at **Naritive Tech**.
