Lab 3 updates:
We had a difficult time trying to find time related data for our XML document.
Instead we went with a list of all the establishments with a liquor only license in the lower mainland.
These are sorted by city and include the name of the establishment, the address and the seating capacity.
I believe that if we are going to be making charts later that we can use those to do so in an interesting way.

File updates:
Added xml folder under data
Added xml list of bars in the lower mainland
Modified the menu to include 'Bars' via /application/config/config.php
Added 'bars.php' under /application/views using suggested code
Added 'bars.php' under /application/controllers using previous template and suggested code
Modified /assets/css/main.css using suggested code

-------------------------------------------------------------------------------------------

Lab 4 updates:
Revised XML document to remove locations that aren't actually bars or pubs.
Our original document was based on liquor only license data.

File updates:
Added source to the XML document.
Fixed ampersands in XML document.
Added <BRANCH> attribute to XML document
Added DTD file to /data/xml
Added DTD validation code to /application/views/bars.php 
Added validation routines suggested to /application/controllers/bars.php

Validation shows as OK

-------------------------------------------------------------------------------------------

Assignment 1 updates:
Added media, posts and contacts tables to hostpapa database and populated them
Unfortunately there were a few things that I didn't initially understand as well as I thought I did so did not have time to clean up the code the way I would have liked.  
Included docx on hostpapa site
Cleaned up DTD a little bit.  Going to rework xml data quite a bit in the near future, though so not too worried about it.

File updates:
Added database library and _mymodel, _mymodel2, posts and media models to config/autoload. The basis of these was supplied.
Updated config/database.php to work both at home and abroad
Added supplied models/posts and models/media files
Modified views/view, controlers/view and added views/view1 to show posts from database
Modified controllers/welcome to use posts from database
Shed several tears

----------------------------------------------------------------------------------------

Lab 6 Updates
Added
    Models:         users_dao, activeuser
    Controllers:    login, logout, postmtce, usermtce
    Database:       users, ci_session

Modified:
    Models:         _mymodel
    Controllers:    MY_Controller

activeuser is a wrapper for all things session related
post and user maintenance are accessible to admin,
post is accessible to user,
user roles exist for guest and visitor, but currently have no application
logout controller could be made to show a logout page, but for now just redirects

changed _mymodel get_array($key) to use ->get rather than ->query
added some more base functionality to MY_Controller for login and such

shed less tears than last time

----------------------------------------------------------------------------------------

Lab7 Updates
Bootstrap integrated into the framework.
Field level templating incorporated into controllers.
Database rebuilt for better functionality.
Added images model for access to images.
Added accounts page as a starting point for later profile development.
Date picker added to post maintenance.
Image uploaded added to both post maintenance and user maintenance. 

---------------------------------------------------------------------------------------

Assignment 2 Updates

CKEditor
	Added makeCKEditor() to formfieldhelpers
	Added CKE to caboose
	Swapped text area in postmtce for CKE
KCFinder
	Added KCFinder to CKEditor
	probably a mistake. Not useful. Will remove
Image uploader
	Redid addFile() backed in images_dao
	Now works on posts and users
Tags
	Added Tags table to database
	Added tags textfield to postmtce
	Created tags_dao for backend
	*Tags cannot yet be removed from a post, only new ones added*
Blog
	Added post and tag controller
	tag sidebar contains all tags known in database
Controllers/postmtce
    changed unset($posting['updated']); to $posting['updated']=NULL; so that 
        the database would add the current timestamp to the updated field when
        any changes are being made.
	views/postedit.php
	controllers/postmtce.php
    	add cancel button to edit post page
	scripts/all_tables.sql
    	added current timestamp if value null for posts/updated
	views/_template.php
    	make title a link to homepage
    Replace $_GET error messages with flashdata
Posts
	users cannot edit other users posts


---------------------------------------------------------------------------------------

Lab 8 Updates


XML-RPC

	*Capo controller capable of handling incoming requests from the syndicate
	*Admin and Postmtce controllers send out info to the syndicate on state change


Admin Page
	
	*Admin users can now access the admin controller from their account page
	*From there they can change the site title, and plug, which are also tied
		to the main title bar of the site

	*Admins can also force a refresh to the syndicate if it failed to get an update
		or a database change was made directly.

	*Flashdata messages will report any errors returned by the syndicate


Rebuilt Accounts page
	
	*Now with user picture
	*Shows all posts submitted by the user
	*Sidebar allows user to access any controllers they are authorized to use


Posts Maintenance

	*Now with image buttons (new form-field component)
	*Admins will get a button to sync the specified post with the syndicate if
		it was not appearing for some reason
	*Users can only edit and delete their own posts
	*Shortened story field down to just a snippit so the page isn't unreasonably long
	*Flashdata error messages report syndicate syncing problems
	*Added "Are you sure?" to deleting of posts to prevent one-click delete.


Log in/out

	*Improved redirect logic and added flashdata error messages so you can have some
		clue what is going on when you're trying to log in


Blog
	
	*Fixed issue where images would occasionally overflow into the next post down



**Admin Login: 
	name JPerry
	pass TieGuy

**User Login
	name MJackson
	pass Thriller

---------------------------------------------------------------------------------------

Lab 9 Updates:

Added Schema to data/xml