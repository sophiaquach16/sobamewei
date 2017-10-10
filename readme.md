##### IMPORTANT: This is the new repository for our project. We switched to the Laravel Framework since with the NodeJS framework we had to do a lot of nested callbacks (see http://callbackhell.com/).

# ConUShop

## Website Info

[www.conushop.com](http://conushop.com/)

**Admin Account:**

- Username: ```admin@conushop.com```
- Password: ```admin```

## Team 9 Members
- Jean-Michel Laliberté
- Alex Zhang
- Helen Zhang
- Batoul Yehia
- Yufeng Ding
- Sophia Quach
- Melissa Duong
- Karine Zhang
- Wei He

## Installation (do once)
1) We recommend that you use Xampp to run the Laravel framework app by following [this tutorial](https://www.codementor.io/magarrent/how-to-install-laravel-5-xampp-windows-du107u9ji).
2) Clone the Repository into htdocs with the folder named as laravel instead of ConUShop.

## Database Synchronization (do everytime the database model has been modified)
1) Go to ```http://localhost/phpmyadmin```
2) Click on SQL tab.
3) Open the ```databaseScript.sql``` file in the project folder with notepad. Copy and paste everything in the textarea of the SQL tab.
4) Click the "go" button.

## Dependencies Synchronization (do everytime the dependecy list changes)
1) Open the terminal.
2) Go to the project repository.
3) Type ```composer update --no-scripts``` and press enter to install the dependencies of the app.

## Open the website on your local computer
- Go to ```laravel.dev``` on your browser.
