<?php

use src\Router;

if(Router::isApiCall()){
    require 'routes/api.php';
    exit();
}

require 'routes/web.php';