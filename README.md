Here’s a more detailed guide to help you set up your Autobot application:
Setting Up Your Autobot Application

Follow these steps to set up and run the Autobot application on your local server:

Step 1: Download and Save the Folder to Your Local Server
Download the application files.
Extract the contents to your local server directory (e.g., htdocs for XAMPP, www for WAMP, or your designated web root folder for other environments).


Step 2: Create a MySQL Database and Run Migrations

Create a MySQL Database:

Open your MySQL management tool (like phpMyAdmin).

Create a new database (e.g., autobot_db).

Run Laravel Migrations:
Open a terminal or command prompt in the root directory of your Laravel application.
Run the following command to migrate the necessary tables to your database:


php artisan migrate 
This command will execute the migrations and create the necessary tables in your database.

Step 3: Configure Your Environment File

Open the .env File:

Find the .env file in the root directory of your Laravel project.

Open it in a text editor.

Set Up Your Pusher Configuration:
Locate the following lines in your .env file:
PUSHER_APP_ID=

PUSHER_APP_KEY=

PUSHER_APP_SECRET=

PUSHER_APP_CLUSTER=

Fill in your Pusher details (you can get these from your Pusher dashboard).

Configure Other Necessary Settings:

Ensure your database connection settings are correct:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=autobot_db
DB_USERNAME=root
DB_PASSWORD=


Replace DB_DATABASE, DB_USERNAME, and DB_PASSWORD with your specific database details.
Step 4: Set Up Your Cron Job or Run Scheduler Manually
Set Up a Cron Job (Recommended for production environments):
Open your server’s crontab file using the terminal:
crontab -e
Add the following line to the crontab file to run the Laravel scheduler every minute:
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
Replace /path-to-your-project with the absolute path to your Laravel project.
Run Scheduler Manually (Useful for testing and development):
Run the following command in your terminal:
php artisan schedule:run

Step 5: Run the Laravel Application and Frontend
Run the Laravel Server:
Start the server by running: php artisan serve
 This command will start the Laravel application on http://127.0.0.1:8000 by default.
Run the Frontend (Vue.js/Node Server):
 Open another terminal window and navigate to your project directory.
Run the command to compile your frontend assets:npm run dev
This will compile the Vue.js components and start the development server.
Step 6: Check for Errors in Your Setup
Verify Your Setup: Run the following endpoint in your browser to check if there are any setup errors:
GET http://your-local-server/folder/api/v1/autocreation

Replace folder with the actual path to your project.
Step 7: View the Number of Created Autobots in Real-Time
Open Your Browser:
Go to the file path of the folder in your browser to view the real-time count of created Autobots: http://your-local-server/foldername

Replace foldername with the name of the folder where your project is saved.
Summary
By following these steps, you will successfully set up the Autobot application on your local server, run the necessary background processes, and view real-time data. Make sure to replace placeholders with your specific configuration details for a smooth setup experience.


Api Documentation
https://docs.google.com/document/d/17RGP7td6K-8RNikkkiBSV9P-0GA6r3LDbntbqxyYZGw/edit?usp=sharing