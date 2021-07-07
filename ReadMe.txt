FINAL PROJECT

Group Members
* Muneeb Bin Amer (21-10579)
* Mohid Ali Gill (21-10842)
* Maham Jamil (21-10053)

********* INSTRUCTIONS **********
* Run the application first which will take you to index.php and Database wil be created
* We have included a file entries.php in Database folder
* Simply type in http://localhost/projectstructure/Database/entries.php which will add a few entries
in tables just to start off.

********* LOGIN INFO ***********
*** ADMIN ***
username: A-101
pasw: admin

*** STUDENT ***
username: S-101
pasw: student

*** BLOCKED STUDENT ***
UserID = S-102
Pasw = iamblocked

*** TEACHER ***
username: T-101
pasw: teacher

To start you can use these accounts to login.
***********************************************

* Proper session handling has been done in session.php which is included in every file.
* We have taken care of two important scenarios.
1- If the user tries to access any portal or page without logging in. He will be redirected
back to login.
2- If the user logs in (Session starts) and opens another tab and then tries to access any portal
other than the one he's already logged in. He will be taken back to his logged in portal.

* If you dont logout you will stay logged in.

* All the functions for respective portals are in functions.php file of that respective folder.

* A Student can view and add new courses only after a Teacher has requested for a course from the
available list of courses and admin approves the request.

