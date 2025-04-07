# Deployment Guide

This document outlines how to set up, develop, and deploy updates to the Viridian theme.

---

## Local Development to Staging

A GitHub Action monitors the `staging` branch for changes and automatically deploys updates to the staging site.

**GitHub Secrets Required:**
- `DROPLET_ID`: The IP address of the staging site.
- `SSH_PRIVATE_KEY`: Used for SSH connection without a password.
- `SSH_USER`: The user that has SSH access and matches the SSH key.
- `WP_CONTENT_PATH`: The server path to the `wp-content` folder.

If the folder name of the theme (`startertheme/`) is changed, the `paths: 'startertheme/**'` rule must also be updated in the workflow.

Feature branches can be created off `staging`, and merging them into `staging` will trigger deployment.

---

## Version Control

We follow a structured Git branching model:

- `main`: Stable production-ready code.
- `staging`: For testing new features before merging to `main`.
- `feature/*`: Individual branches for new features or fixes.

### Workflow
1. Create a new branch from `staging`:
    ```bash
    git checkout staging
    git pull origin staging
    git checkout -b feature/your-feature-name
    ```
2. Make changes locally, then:
    ```bash
    git add .
    git commit -m "Describe your changes"
    git push origin feature/your-feature-name
    ```
3. Open a pull request into `staging` and review changes.
4. After testing on staging, merge into `main` to deploy live.

---

## Project Management

We use **Trello** for task tracking. Our board includes the following columns:
- **Next Actions** — Ready to be picked up.
- **To-Do** — Assigned tasks.
- **In Progress** — Tasks currently being developed.
- **Done** — Completed and deployed.

---

## Development Environment

1. Set up a local environment using [LocalWP](https://localwp.com/) or your preferred tool.
2. Clone the repository:
    ```bash
    git clone https://github.com/cp3402-students/project-2025-tr1-jcua-team6.git
    ```
3. Open the site in your development tool and activate the `Viridian` theme.
4. Make code changes and test them locally.

---

## Testing and Automation

- **Theme Check Plugin** is used to verify code compliance.
- **PHP linting** is enforced via `.phpcs.xml.dist`.
- Accessibility is tested using browser extensions like WAVE.
- GitHub Actions automatically deploy changes from staging.

_Add additional automation or validation tools here as needed._

