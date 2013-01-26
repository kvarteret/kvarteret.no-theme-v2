# Kvarteret.no Wordpress Theme v2
This repository is the Kvarteret Wordpress theme. It is somewhat based on the 2013 Wordpress theme, but with major modifications.

## Setup
### Wordpress
Wordpress is a PHP-based system for blogging and general content management.

In order to install Wordpress locally you will need:
- Apache
- MySQL
- PHP

### Istalling the server and Wordpress Windows 
Firstly you will have to install the WAMP stack. An easy solution is the executables offered by [wampserver.com](http://www.wampserver.com/en/)

In order to install Wordpress you will have to download the latest version of [Wordpress](http://wordpress.org), navigate to the apache folder C:\wamp\www, create a new folder "kvarteret.no" and unzip the files here.

Now you can start wampserver and navigate to [http://localhost/kvarteret.no](http://localhost/kvarteret.no) in your prefered webbrowser in order to start the Wordpress installer.

DB details (using defaults for wampserver): 
username: root
password:
server: localhost

(yes, there is no password, leave the field blank)

### Debian/Ubuntu
You can install/configure the LAMP stack using tasksel.

apt-get install tasksel
tasksel install lamp-server

This will install and configure everything for you.

In order to install Wordpress you will have to download the latest version of [Wordpress](http://wordpress.org), navigate to the apache folder /var/www, create a new folder "kvarteret.no" and unzip the files here.

Now you can start wampserver and navigate to [http://localhost/kvarteret.no](http://localhost/kvarteret.no) in your prefered webbrowser in order to start the Wordpress installer.

You might have to chmod the Wordpress files if you want Wordpress to be able to update itself. You can do this with the "chmod 0777" command.

### Mac/OS X
[MAMP](http://www.mamp.info/) (Mac Apache MySQL PHP) is a webstack for Mac OS X, and the easiest way to set up a webstack on OS X.
You may use the default ports and password (MySQL is only accessible on localhost).

To install [Wordpress](http://wordpress.org), go to their website and download their newest version. Place the wordpress folder in /Applications/MAMP/htdocs.
Start Apache and MySQL via the MAMP GUI interface and go to [http://localhost/wordpress](http://localhost/wordpress) to start the installation of Wordpress.

## Installing the theme
Download/Git clone this repository into */www/kvarteret.no/wp-content/themes. 
Go to http://localhost/kvarteret.no/wp-admin, click appearance and choose the theme.

## Dependencies/Third party libraries
The Wordpress theme is dependent on a few external libraries.

### CSS: SASS and Lattice
The CSS is developed using SASS (a CSS preprocessor) which can be set up using the instructions found on http://sass-lang.com/
The grid used is based on the Lattice CSS framework, which can be found on [github.com/Torthu/Lattice](https://github.com/Torthu/Lattice)

### Javascript: jQuery and parts of Bootstrap
We use [jQuery](http://jquery.com) for DOM traversing, AJAX, etc.
The [Twitter Bootstrap slider plugin](http://twitter.github.com/bootstrap/javascript.html#carousel) for the frontpage slider.

### Plugins
The event page and the pictures page is dependant on homebrew Wordpress plugins.

#### Event plugin
Can be found on [github.com/kvarteret/dak-event-wordpress-plugin-v2](https://github.com/kvarteret/dak-event-wordpress-plugin-v2)

#### SmugMug/Picture plugin 
Can be found on [github.com/kvarteret/dak-smugmug-wordpress-plugin-v2](https://github.com/kvarteret/dak-smugmug-wordpress-plugin-v2)

## Code style

### CSS
The CSS is written using SASS and can be compiled to any style or minified.

#### Some general conventions
We use tabs and not spaces for indentation.
e.g 
```` css
ul {
  styles
}
  li {
    styles
  }
````
Elements are placed roughly chronologically as they are displayed/coded in the HTML.

The CSS follows the OOCSS convention. Basically any reusable CSS should be extracted to its own class in order to reuse it i other elements.
IDs should in general only be used in order to style truly unique elements, so use classes.

### Javascript
We use plugins from Twitter Bootstrap, namely the jQuery slider.

### PHP
PHP: do whatever you want as long as it is readable.

### HTML
We use the HTML 5 doctype.
In general elements should be as semantically correct as possible, this means that you should use nav, section, article, header, footer, etc. where applicable and limit your use of divs and spans.
