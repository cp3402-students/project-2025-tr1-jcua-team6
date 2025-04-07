# Deployment Guide

This document outlines how to set up, develop, and deploy updates to the Viridian theme, from cloning the GitHub repo to publishing changes on the production website.

---

## Summary of Complete Workflow
1. **Setting up your own local WordPress environment.**
   1. Open your preferred IDE, locate the 'clone' option, and clone the [existing theme repo](https://github.com/cp3402-students/project-2025-tr1-jcua-team6).
   2. Install [LocalWP](https://localwp.com/) or your preferred tool for establishing a local WordPress development environment.
<br>

2. **Apply changes in the correct locations and test in your LocalWP environment.**
   1. CSS changes go in `style.css`:
      1. Default styles under `Global & Generic Base`
      2. Theme styles under `VIRIDIAN THEME STYLES`
      3. Contributor-specific styles in the `Group Member / Custom Styles <name>` section
   2. PHP modifications should be made in `functions.php` for block rendering logic and WordPress hooks.
   3. HTML content is created using the default WordPress block editor.
<br>

3. **Push your changes after testing.**
   1. Create a feature branch from the `staging` branch.
   2. Add your changes to the branch.
   3. Commit your changes with a descriptive message.
   4. Push your branch to the repository to initiate a pull request.
<br>

4. **Create and validate a pull request.**
   1. Visit the GitHub repository and check for notifications about new changes.
   2. Open a new window and select the branches so that the `staging` branch is set to merge with your feature branch.
   3. Add a detailed comment describing your changes, include contributors as validators, and submit the pull request.
   4. Have a team member review and suggest modifications until the pull request meets the required standards.
   5. Merge the feature branch into `staging`, and add a comment detailing any modifications and the overall objective.
<br>

5. **Verify that changes have been pushed to staging.**
   1. Check the GitHub Actions log to confirm a new sync has been initiated.
   2. Visit the [staging website](http://209.38.89.77/), navigate to the relevant page, and press `Ctrl + F5` to clear the browser cache and refresh the page.
   3. Your local changes should now be visible on the staging site.
<br>

6. **Sync staging with production.**
   1. Once stability on staging is confirmed, merge the `staging` branch into the `main` branch.
   2. GitHub Actions or manual deployment will then push the changes to the production environment.
  
---

## Local Development Environment
1. Install [LocalWP](https://localwp.com/) or another local WordPress environment tool.
2. Clone the repository using GitHub or your IDE:
    ```bash
    git clone https://github.com/cp3402-students/project-2025-tr1-jcua-team6.git
    ```
3. Set up a new site in LocalWP and map the `wp-content/themes/startertheme` directory to the cloned repo.
4. Open the site in your browser and activate the **Viridian** theme via the WordPress dashboard.
5. Make and test your code changes locally.

---

## Version Control
We use Git and GitHub for collaborative version control and branching.

### Branching Model
- `main`: Production-ready code, only merged after full testing.
- `staging`: Integration branch for validated features before production.
- `feature/*`: Feature-specific branches made off `staging`.

### Workflow
1. Create a new branch from `staging`:
    ```bash
    git checkout staging
    git pull origin staging
    git checkout -b feature/your-feature-name
    ```
2. Make your changes and test locally.
3. Add, commit, and push changes:
    ```bash
    git add .
    git commit -m "Your commit message"
    git push origin feature/your-feature-name
    ```
4. Open a pull request targeting `staging`, describe your changes, and assign reviewers.
5. Once approved, merge `feature/*` into `staging`.
6. After confirming changes on the staging site, merge `staging` into `main` to deploy live.

---

## Local Development to Staging
A GitHub Action automatically deploys updates to the staging site whenever the `staging` branch is updated.

### GitHub Actions Configuration
The workflow script watches changes to the theme directory (e.g. `startertheme/**`) and pushes them to the server.

**GitHub Secrets Required:**
- `DROPLET_ID`: IP address of the staging server.
- `SSH_PRIVATE_KEY`: Private key for authenticating over SSH.
- `SSH_USER`: Server user account associated with the SSH key.
- `WP_CONTENT_PATH`: Absolute path to the `wp-content` directory on the server.

**Note:** If the folder name changes, update `paths` in the GitHub Action workflow accordingly.

---

## Project Management
We use **Trello** to manage team tasks and workflows. The board is structured as follows:
- **Next Actions** — Tasks ready to begin.
- **To-Do** — Assigned but not started.
- **In Progress** — Currently being developed.
- **Done** — Completed and deployed to staging or live.
Trello links are shared in our group chat, and task updates are discussed in weekly team check-ins.

---

## Testing and Automation
All code changes are tested locally prior to staging.
- **GitHub Actions** — Handles CI/CD for the staging site.
- **PHP linting** — Enforced using `.phpcs.xml.dist`.
