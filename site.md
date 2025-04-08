# Site Management Guide

The **Baizonn Learning Center** website uses the custom **Viridian** WordPress theme. This guide outlines how to update content, manage styling, use navigation, and perform essential site maintenance.

---

## Pages vs Posts (adding new content)

All content on the site is structured using **pages**.

- Use **Pages** (not Posts) to create and manage content for the site.
- Navigate to the WordPress dashboard -> Pages to edit existing content or create a new page.
- When creating a new page, you can choose between the "Default template" and "Full-Width page" under Quick Edit -> Template.

---

## Navigation
To update the site's main menu:

1. Go to **Appearance > Menus**.
2. Select `nav-menu (Primary)`.
3. Check the box for any new page on the left and click "Add to Menu".
4. Drag to reorder the items.
5. Click "Save Menu".

## Common Updates
- Edit text or images on any page by navigating to Pages and selecting the page.
- To embed a video, add an Embed block and paste the YouTube URL.
- Use Group and Column blocks to structure layouts and automatically trigger Viridian styles.

## Plugins
The site uses the following plugins:

- **All-In-One WP Migration:**
For manual backup and small migration of the website. Without the premium version, the website is too large to sync to production, so its is a backup tool instead.
  1. Install and activate the plugin.  
  2. Go to its menu, choose "Export" to create a backup file.  
  3. Download and store the backup (use as backup since syncing to production isn’t supported without premium).

- **WPVivid Backup:**
Main manual backup tool that exports a backup of the staging site and 'restores' it on the production.
  1. Install and activate WPVivid Backup.  
  2. Navigate to its dashboard menu on the staging site.  
  3. Click "Backup" to export a backup file, then use the "Restore" option on production to import it.

- **Theme Check:**
Used to check the validity of the theme.
  1. Install and activate Theme Check.  
  2. Open the Theme Check interface via the admin menu.  
  3. Select the active theme and run the test to review any issues.

- **WPForms Lite:**
Used on the registration page to create fill-in forms.
  1. Install and activate WPForms Lite.  
  2. Create a new form using a template in the WPForms interface.  
  3. Customise the fields as needed and embed the form on the registration page.

## Settings
- On staging, a `Custom Structure` may be used for testing.
- Permalinks should be set to `Post name` in production (go to Settings -> Permalinks).
