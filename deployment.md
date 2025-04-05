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