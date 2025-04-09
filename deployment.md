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
2. Clone the repository using GitHub onto your preferred IDE:
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
- `main`: Production-ready code, only merged after complete testing.
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
6. After confirming changes on the staging site, merge `staging` into `main`, whilst resolving any conflicts, to deploy live.
Below is an improved explanation that clearly outlines what conflict markers are and how to resolve them when editing within GitHub’s interface:

### How to Resolve Merge Conflicts on GitHub
When you encounter a merge conflict in GitHub, the affected file will display conflict markers that separate the differing versions. For example, you might see something like this:

```markdown
<<<<<<< HEAD
Your current changes
=======
Incoming changes from another branch
>>>>>>> feature-branch
```

These markers indicate:
- **`<<<<<<< HEAD`**: The beginning of your current branch’s changes.
- **`=======`**: A divider between your changes and the changes from the other branch.
- **`>>>>>>> feature-branch`**: The end of the incoming changes from the specified branch.

### Steps to Resolve the Conflict
1. **Review the Changes**  
   Look at both versions of the code to understand what changes have been made. Decide if you want to keep one version or if you need to merge parts of both.

2. **Edit the File**  
   Remove the conflict markers (`<<<<<<<`, `=======`, `>>>>>>>`) along with any code that you no longer want. Modify the code as necessary so that it integrates the desired parts from both versions into a coherent final version.

3. **Save Your Changes**  
   After resolving the conflict by cleaning up the markers and ensuring the code works as intended, 'mark the conflict as resolved' in the GitHub editor.

---

## Local Development to Staging Using GitHub Actions
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

## Staging to Production Sync Using WPvivid Backup
Since we didn’t have a GitHub action in place, we used the **WPvivid Backup** plugin to sync changes from our staging site to production. Follow these steps:

1. **Install & Activate WPvivid Backup**  
   - On both staging and production sites, go to 'Plugins' > 'Add New'.  
   - Search for “WPvivid Backup,” then install and activate the plugin.

2. **Backup the Staging Site**  
   - In the staging dashboard, access the **WPvivid Backup** menu.  
   - Configure your backup settings (selecting database, files, themes, and plugins as needed).  
   - Click **Backup** and wait for the process to complete.

3. **Migrate the Backup to Production**  
   - **Direct Push:** Use the **Migrate** tab in WPvivid to transfer the backup directly to production by following the on-screen instructions.  
   - **Manual Transfer:** Alternatively, download the backup file from the staging site. On the production site, open WPvivid Backup, go to the Import tab, upload the backup file, and complete the restore process.

4. **Post-Migration Check**  
   - Verify that the sync was successful by browsing the production site after clearing your site cache (ctrl+f5).  
   - Side Note: Quickly check the media library. Occasionally, month metadata in URLs (`/MM/`) may prevent images from displaying correctly, so a brief review of the media files is recommended.

---

## Project Management
We use **Trello** to manage team tasks and workflows. The board is structured as follows:
- **Next Actions** - Tasks ready to begin.
- **To-Do** - Assigned but not started.
- **In Progress** - Currently being developed.
- **Done** - Completed and deployed to staging or live.

All Trello updates are automatically lodged within our group [Slack channel](https://app.slack.com/client/T0C3E7EP2/G011K4DHGG6), which keeps a relevant version history of changes. Task assigning and updates are discussed in weekly team meetings (Monday 5:30pm).

Regular group communication is done within our [Group 6 Discord server](https://discord.gg/v8tc53sZ) (Lindsay is already a member). <br>
The server uses different dedicated channels to organised discussions. They go as follows:
- **Important-dates** - Used to track due dates
- **Important-links** - Collects all relevant links to external sites
- **Project-updates** - Place to provide major updates to the project (outside of Slack messages)
- **Meeting-times** - Posts regular meeting time and meeting history
- **General** - Place for any and all main group discussions

The [Slack channel](https://app.slack.com/client/T0C3E7EP2/G011K4DHGG6) is used to automatically track any changes made to the Trello board or GitHub repo.

---

## Testing and Automation
**Local Testing:**  
- After installing WordPress locally, activate the custom `Viridian` theme and import the [Theme Unit Test data](https://codex.wordpress.org/Theme_Unit_Test) to verify compatibility.
  
**CI/CD:**  
- We use **GitHub Actions** for staging deployment workflow that checks for deployment errors and conflicts before automatic merging/syncing <br>
- We enforce PHP linting via `.phpcs.xml.dist`.

**Theme Validation:**  
- Run the [Theme Check plugin](https://wordpress.org/plugins/theme-check/) to ensure compliance with WordPress standards. <br>
- The plugin will list errors and recommendations to fix. You will see a menu like:
![image](https://github.com/user-attachments/assets/b536a484-4ebd-4050-a580-1c0af791bdcf)
