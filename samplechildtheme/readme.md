#		Creating and Editing Your Child Theme
#		Written by: Justin Hedani

> " Just get a job? Why don’t I strap on my job helmet and squeeze down into a job cannon and fire off into job land, where jobs grow on little jobbies?!" -Charlie

#		I. Configure your child theme
		Since we are using LESS in our workflow, we'll need to set up a few basic things before we get started. Be sure to have a LESS compiler installed on your computer. Here are some useful OSX compilers:
			a) "Less" by Incident57: http://incident57.com/less/ (free, less robust)
			b) "Codekit" by Incident57: http://incident57.com/codekit/ (paid, more robust)

#		III. Adding hand-crafted CSS/LESS

		1. Set your compiler to export the less/course-style.less to css/course-style.css.
		2. Add newly hand-crafted LESS to course-style.less

#		IV. Modifying templates and adding custom Wordpress functions
		In the event you need to add custom wordpress functions:
			1. Place your functions is functions.php

		In the even you need to modify/add a parent theme template:
			1. First attempt to use the following hooks provided by our theme in functions.php (a list resides there.)
			2. If that doesn't work, copy the desired template you wish to modify into the root of this child theme folder. Modify as necessary.