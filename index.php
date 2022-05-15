<?php
  ob_start();
  define('RUNNING_FROM_ROOT', true);
  include 'public/index.php';
  echo "test";

 ?>
