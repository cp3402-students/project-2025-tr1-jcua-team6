# Deployment
<br>
Describe your development and deployment workflow in enough detail that a
new team member or someone taking over the project could follow to successfully develop theme
updates locally, then test and deploy them to your staging and live sites. This should include aspects
such as project management, version control, testing and automation. Do not provide private details
like passwords.


## Local development to staging

A GitHub action monitors the staging branch for any changes and automatically applies them to the staging site. 

There are 4 secrets that need to be changed in the settings.

DROPLET_ID = The IP address of the staging site

SSH_PRIVATE_KEY = An SSH private key is used to connect with the server without needing a password, which helps with the autonomy of the action

SSH_USER = The user making the changes with SSH access with the corresponding public key of SSH_PRIVATE_KEY

WP_CONTENT_PATH = This is the path for the theme on the server

  

`paths: 'startertheme/**`

will need to be changed if the startertheme folder name is changed

  

Development branches can be separately created and once merged into staging will also trigger the action.













# Project management
We use Trello to manage all theme development tasks. The board is structured into the following columns:
- **Next Actions**: Unassigned tasks that are ready to be picked up.
- **To-Do**: Tasks that have been assigned but not yet started.
- **In Progress**: Tasks that are currently being worked on.
- **Done**: Completed tasks that have been implemented and deployed.
 
# Version Control
- **Main**: This is the live production branch, for stable and tested code.
- **Staging**: Used to test new features or fixes before they go live.
- **Branches**: Each new feature of fix should have its own branch.
 
# Workflow
1. Create a new branch off staging for your feature/fix.
```
git checkout staging
git pull origin staging
git checkout -b your-branch-name
```
2. Make your changes locally, commit regularly and push your branch to GitHub.
3. Open a pull request to merge your branch into staging.
4. If everything works as intended merge staging into main to deploy the changes to the live site.

# Development
1. Set up a local WordPress development environment such as [LocalWP](https://localwp.com/).
2. Clone the repo to your machine.
```
git clone https://github.com/cp3402-students/project-2025-tr1-jcua-team6.git
```
3. Make changes directly to the theme files.
4. Load the site locally to test and confirm everything works as intended.



