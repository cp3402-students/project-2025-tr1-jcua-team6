# Deployment Guide

This document outlines how to set up, develop, and deploy updates to the Viridian theme, from cloning the GitHub repo to publishing changes on the production website.

---

## Summary of Complete Workflow
1. Setting up your own local WordPress environment.
   1. Open your preferred IDE, locate the 'clone' option, clone the [existing theme repo](https://github.com/cp3402-students/project-2025-tr1-jcua-team6) via link.
   2. Install [LocalWP](https://localwp.com/) or your preferred tool for establishing a local environment.
<br>

2. Make changes in the correct location and test in your LocalWP environment.
    1. CSS changes -> `style.css`
       1. Default styles -> `Global & Generic Base`
       1. Theme styles -> `VIRIDIAN THEME STYLES`
       2. Custom CSS -> `Group Member / Custom Styles <name>`
    2. PHP changes -> `functions.php`
    3. HTML changes are all done within the default WordPress editor
<br>

3. Pushing your changes after testing.
    1. Create a feature branch.
    2. Add the changes to the branch.
    3. Commit changes to the branch with a message.
    4. Push changes to the repo to lodge a pull request.
<br>

4. Creating and validating a pull request.
    1. Visit the GitHub repo and look for a notification about a new change.
    2. Open the new window and select the two branches so that `staging` branch is the one having the `feature branch` merged into it.
    3. Add a descriptive comment on the changes that the branch makes, add contributors as validators, and lodge the request.
    4. Get a team member to review and make modifications to your pull request until it is satisfactory.
    5. Merge the `feature branch` with `staging` and add a comment detailing any modifications and the overall goal.
  <br>

5. Checking changes have been pushed to staging.
    1. Check the GitHub actions log to see if a new sync has been created.
    2. Visit the [staging website](http://209.38.89.77/), go to the respective page and press `ctrl + f5`
    3. > This clears the cache data on the webpage and refreshes it
    4. You should now be able to see your local changes on the staging website
<br>

6. Sync staging site with production.
    1. ...
    

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

