<?php
/**
 * Include files based on the Instance's ClassName being created
 *
 * Gets Models from models/, can be extended to autoget other kind of classess
  *
 * For classes that doesn't form part of the core, you must include the file
 * by hand.
 *
 */
class Autoloader {
 
  public static function autoload($class_name)
  {
    $class_name = ucwords($class_name);
		
    /** Specific classes are inside this directories, either in app space, or in framework space. **/
    $named_directories = array
    (
		  'Model' => 'models/',
    );

    /** Selects the correct folder from the ClassName **/
    foreach ( $named_directories AS $name => $directory ) {
      if ( stristr( $class_name, $name ) && $class_name != $name ) {
        require_once  $directory . $class_name. '.php';
        return true;
      }
    }
	
    return false;
  }
  
  /**
   * Configure autoloading
   *
   * This is designed to play nice with other autoloaders.
   */
  public static function registerAutoload()
  {
    spl_autoload_register(array('Autoloader', 'autoload'));
  }

}