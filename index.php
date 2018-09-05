<?php
// The main enterance of the WeBake.
define( 'ABSPATH', dirname( __FILE__ ) . '/' );

//Make sure the WeBake is installed.
if(file_exists(ABSPATH . 'wb-config.php')){
    require_once('wb-includes/WeBake.class.php');
    new WeBake();
}else{
    header('Location: /wb-develop/install.php');
}
