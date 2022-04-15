# Variable Inspector

Contributors: qriouslad  
Donate link: https://paypal.me/qriouslad  
Tags: php variables, variable dump, debug, developer  
Requires at least: 4.8  
Tested up to: 5.9.2  
Stable tag: 1.2.0  
Requires PHP: 5.6  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

![](.wordpress-org/banner-772x250.png)

Easily dump and centrally inspect your PHP variables for convenient debugging.

## Description

Variable Inspector allows you to easily inspect your PHP $variables in a visually clean manner at a central location in wp-admin. It aims to be an **easy and useful enough debug tool**. 

In scenarios where [Xdebug](https://xdebug.org/) or even something like [Ray](https://myray.app/) is not ideal or simply an overkill, Variable Inspector provides **a single-line code** (see "How to Use" below) to be used instead of [var_dump()](https://www.php.net/manual/en/function.var-dump.php), [var_export()](https://www.php.net/manual/en/function.var-export.php) and [print_r()](https://www.php.net/manual/en/function.print-r.php). 

Nothing is shown to site visitors nor being output on the frontend, and the **$variable content is nicely formatted for review** using var_dump(), var_export() and print_r() on the inspector page in wp-admin. Additionally, because it is a regular WordPress plugin, you simply install, activate and use without the need for complicated configuration.

Variable Inspector was originally inspired by [WP Logger](https://wordpress.org/plugins/wp-data-logger/).


### How to Use

Simply place the following line anywhere in your code after the `$variable_name` you'd like to inspect:

`do_action( 'inspect', [ 'variable_name', $variable_name ] );`

If you'd like to record the originating PHP file and line number, append the PHP magic constants `__FILE__` and `__LINE__` as follows.

`do_action( 'inspect', [ 'variable_name', $variable_name, __FILE__, __LINE__ ] );`

This would help you locate and clean up the inspector lines once you're done debugging. 

### Give Back

* [A nice review](https://wordpress.org/plugins/variable-inspector/#reviews) would be great!
* [Give feedback](https://wordpress.org/support/plugin/variable-inspector/) and help improve future versions.
* [Github repo](https://github.com/qriouslad/variable-inspector) to contribute code.
* [Donate](https://paypal.me/qriouslad) and support my work.

## Screenshots

1. The main Variable Inspector page
   ![The main Variable Inspector page](.wordpress-org/screenshot-1.png)

## Frequently Asked Questions

### How was this plugin built?

System Dashboard was built with: [WordPress Plugin Boilerplate](https://github.com/devinvinson/WordPress-Plugin-Boilerplate/) | [wppb.me](https://wppb.me/) | [CodeStar framework](https://github.com/Codestar/codestar-framework) | [Simple Accordion](https://codepen.io/gecugamo/pen/xGLyXe)

## Changelog

### 1.2.0 (2022.04.14)

* Fixed output buffering mistake causing the output of the '1' character in variable values
* NEW: implement tabbed output of var_export, var_dump and print_r

### 1.1.0 (2022.04.13)

* Fixed "Fatal error: Uncaught Error: Call to undefined function dbDelta()". Thanks to [@rashedul007](https://profiles.wordpress.org/rashedul007/) for [the fix](https://github.com/qriouslad/variable-inspector/pull/2)!

### 1.0.1 (2022.04.13)

* Initial stable release

## Upgrade Notice

None required yet.