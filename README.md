README
======


I've added a few files here for you guys to take a look at. This is something that I've previously written for other web apps. Its the login and register system. We dont have to use this if you want to start over but ... its already written. The files are as follows

**classes/Database.php**

/* This class is primarily used to interact with the database. This is so we can compartmentalise the DB interaction and keep all of the SQL queries in one central location. This class is a lower level class and is never instantiated as an object in the main interface rather, the other higher level classes and the functions defined in this class are inherited by higher level classes. I've left some residual functions from a previous application in there to give you an idea of how it should be used.
*/

**classes/Session.php**

/* This class is a generic class used by the application to keep track of the PHP Session started after a user logs in. There are also generic functions that do menial common tasks such as redirect the browser to a different page and checking if the user is logged in or not (eg. whether or not php has saved session data, which happens on user login.)
*/

**classes/Login.php**

/* This class takes care of authenticating the user upon login. It iteracts with the Database class to check login information against the db. This is the main interaction between the application and the db in the initial stages of the application (eg. the login page.). After the user is logged in, this class is not really used.
*/

**core/init.php**

/* This is the main loader file. This loads all of the classes if they havent been loaded already and initialises the PHP session. This file is common to all other files in the application and is included at the top of every file.
*/

**login.php**

/* This is the main interface file for the login page. This will be the main landing page of the webapp before the user logs in. This file handles the POST data from the login form onsubmit and also does the normal checks that should be common to every page (eg. check if a user is logged in already and redirect to the homepage if they are). This script also includes another file includes/pages/login.php which is just the html for the page. It is basic practice to template like this.
*/

**logout.php**

/* This is a simple script to kill the PHP session, essentially logging the user out, which in turn redirects back to the main login page.
*/

**register.php**

/* This script handles the form data from the form included from the file includes/pages/register.php which is again just the html for that page.
*/

OTHER MISC FILES INCLUDE...
---------------------------

**includes/head.php**

is just the html head that every file should have at the top. this is included in the core/init.php file.

**includes/i_index.php**

this is the section handling part of the application. This handles what page or section to be included into the index.php file based on a GET variable in the URL. This file is included in index.php.

**includes/main/***

are the generic header and footer of the webpage that are included in everyfile. This is just good templating practice.



THATS ALL I HAVE FOR NOW...
Give it a look over and if you guys have any questions on how it all comes together let me know.
