# Project: Nano Green Dot Portfolio

**Last Updated:** August 27, 2025

## 1. Project Overview

This project is the development of a custom portfolio website for Nano Green Dot. The site will be a modern, minimalist platform to showcase their work, provide contact information, and detail their professional background. The website is built on WordPress using a custom block theme.

---

## 2. Project Status

**Progress:** 1/15 Tasks Complete

`[##............................]` 7%

---

## 3. Project Architecture

* **Platform:** WordPress (Single Site)
* **Development Environment:** Local by Flywheel
* **Theme:** **"nano-design-build"** (codename for our custom block theme, based on the `v.0.0.1` prototype). It is a fully custom block theme designed for performance and ease of content management.
* **Key Plugins:**
    * **Contact Form:** TBD (Recommendation: Contact Form 7 or WPForms)
    * **SEO:** TBD (Recommendation: Yoast SEO or Rank Math)
    * **Performance:** TBD (Recommendation: an image optimization plugin like Smush or Imagify)
* **Version Control:** Git
    * **Hosting:** GitHub (or similar)
    * **Main Branch:** `main` (Production Ready)
    * **Development Branch:** `develop`

---

## 4. Vibe-Kanban Prompting Protocol

All development tasks assigned to the Vibe-Kanban coding agent will be issued via a structured JSON prompt. This ensures clarity, reduces ambiguity, and creates a documented record of tasks.

### JSON Prompt Structure

```json
{
  "task_id": "X.X.X",
  "task_title": "A brief, human-readable title for the task.",
  "objective": "A clear, one-sentence goal for what this task will accomplish.",
  "context": "Information on why this task is necessary and how it fits into the larger project. Mention any preceding tasks or dependencies.",
  "requirements": [
    "A detailed, step-by-step list of actions the agent must take.",
    "Each step should be clear, concise, and actionable.",
    "Include specific file names, code snippets, or commands where necessary."
  ],
  "acceptance_criteria": [
    "A list of conditions that must be met for the task to be considered complete.",
    "These should be verifiable outcomes, e.g., 'The contact page template is created at templates/page-contact.html'."
  ],
  "file_scope": [
    "A list of all files/directories that are expected to be created, modified, or deleted during this task."
  ],
  "post_task_actions": [
      "Update the project README.md.",
      "Mark the corresponding task in the Development Roadmap as complete using '[x]'.",
      "Update the Project Status progress bar and task count.",
      "Add a plain English entry to the Changelog with the format: 'YYYY-MM-DD: Completed Task X.X: Task Title.'"
  ]
}
```

---

## 5. Development Roadmap

The project will be developed in four distinct phases.

### Phase 1: Foundation & Setup (In Progress)

* [ ] **1.1:** Initialize Git repository and project structure.
* [x] **1.2:** Clean and prepare the `v.0.0.1` theme files into the new "nano-design-build" theme structure.
* [ ] **1.3:** Define global styles and fonts in `theme.json`.

### Phase 2: Core Page & Template Construction

* [ ] **2.1:** Build the site header and footer patterns.
* [ ] **2.2:** Develop the "Home" page template.
* [ ] **2.3:** Develop the "About" page template.
* [ ] **2.4:** Develop the "Contact" page template.
* [ ] **2.5:** Develop the "Portfolio" archive template and single project post template.

### Phase 3: Functionality & Polish

* [ ] **3.1:** Implement and style the contact form.
* [ ] **3.2:** Ensure all templates are fully responsive across desktop, tablet, and mobile.
* [ ] **3.3:** Basic SEO setup and metadata implementation.
* [ ] **3.4:** Cross-browser compatibility testing.

### Phase 4: Pre-launch & Deployment

* [ ] **4.1:** Performance optimization (image compression, asset loading).
* [ ] **4.2:** Final client review and content population.
* [ ] **4.3:** Create a deployment plan and deploy to the live server.

---

## 6. Changelog

* **2025-09-19:** Completed Task 1.2: Front Page Block Scaffold (Exact Parity).
* **2025-08-27:** Project Initialized. Roadmap and protocols established.
