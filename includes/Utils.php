<?php
class Utils {
 
  public static function check_session()
  {
    if (!isset($_SESSION['id_user'])) {
      header("Location: /");
      die();
    } 
  }
}