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
