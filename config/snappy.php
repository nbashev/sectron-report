<?php

return array(

    'pdf' => array(
        'enabled' => true,
        'binary' => public_path('bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => array(),
    ),

);
