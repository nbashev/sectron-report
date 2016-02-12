<?php

// windows issue
// if path to wkhtmltopdf has spaces,
// the page will fail
//
// alternative use of double quotes in single quotes

return array(

    'pdf' => array(
        'enabled' => true,
        'binary' => public_path('/bin/wkhtmltopdf'),
        // 'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
        'timeout' => false,
        'options' => array(
            'print-media-type' => true,
            'footer-font-size' => 8,
            'footer-center' => '- [page] -',
        ),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => array(),
    ),

);
