<?php

$city = 'Yoshkar-Ola';
$variables = [
    'name' => 'Sergey Shambir',
    'company' => 'iSpring',
    'city' => 'HAHAHA HACKED',
];
$extractedCount = extract($variables, EXTR_SKIP);
print_r($extractedCount . "\n"); // 2
print_r($name . "\n"); // Sergey Shambir
print_r($company . "\n"); // iSpring
print_r($city . "\n"); // Yoshkar-Ola
