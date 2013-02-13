
#		Creating and Editing Your Child Theme
#		Written by: Justin Hedani

> " Just get a job? Why don’t I strap on my job helmet and squeeze down into a job cannon and fire off into job land, where jobs grow on little jobbies?!" -Charlie

#		I. Making sure you're in the right place.
		If you are reading this document with the intent to edit the design of the course make sure that:
			a) you're a design team member who has been issued a published course,
			b) that the folder this document you are reading is in its own folder titled ("course-courseNumber" or "course-art175")
			c) you have both this theme and its parent (wp-theme-course-parent) active in your wordpress install.

#		II. Configure your child theme
		Since we are using LESS and Bootstrap in our workflow, we'll need to set up a few basic things before we get started. Be sure to have a LESS compiler
		installed on your computer. Here are some useful OSX compilers:
			a) "Less" by Incident57: http://incident57.com/less/ (free, less robust)
			b) "Codekit" by Incident57: http://incident57.com/codekit/ (paid, more robust)

		1. Look through course-style-config.less and course-style-variables.less and modify any necessary configuration to your desire

#		III. Adding hand-crafted CSS/LESS

		1. Set your compiler to export the less/course-style.less to css/course-style.css.
		2. Add newly hand-crafted LESS to course-style.less

#		IV. Modifying templates and adding custom Wordpress functions
		In the event you need to add custom wordpress functions:
			1. Place your functions is functions.php

		In the even you need to modify/add a parent theme template:
			1. First attempt to use the following hooks provided by our theme in functions.php (a list resides there.)
			2. If that doesn't work, copy the desired template you wish to modify into the root of this child theme folder. Modify as necessary.