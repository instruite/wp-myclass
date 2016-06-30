<?php 
/*
Plugin Name: WP MyClass
Plugin URI: https://github.com/instruite/wp-myclass
Description: Custom Classes for WordPress
Author: Hemant Nandrajog (aka instruite)
Author URI: http://instruite
Version: 0.0.1
*/

namespace WP_MYClass;

  /**
   * Function to make sure PHP finds the right files when the classes are initiated
   * Use php spl_autoload_register to load all the required classes
   * All _ will be converted to - and name of classes converted to lowercases
   * TODO - Add more description
  **/
  spl_autoload_register('\WP_MYClass\autoload_function');
  function autoload_function( $class ) {
    $class = str_replace( '\\', DIRECTORY_SEPARATOR, str_replace( '_', '-', strtolower($class) ) );
	  // create the actual filepath
    $filePath = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $class . '.php';
    // check if the file exists
    if(file_exists($filePath))
    {
      // require once on the file
      require_once $filePath;
    }
  }
