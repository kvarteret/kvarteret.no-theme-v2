#Kvarteret.no Wordpress Theme v2
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
TODO


## Dependencies/Third party libraries
The Wordpress theme is dependent on a few external libraries.

### CSS: SASS and Lattice
The CSS is developed using SASS (a CSS preprocessor) which can be set up using the instructions found on http://sass-lang.com/
The grid used is based on the Lattice CSS framework, which can be found on [github.com/Torthu/Lattice](https://github.com/Torthu/Lattice)

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
Sub elements are indented
e.g 
```` css
ul {
  styles
}
  li {
    styles
  }
````
