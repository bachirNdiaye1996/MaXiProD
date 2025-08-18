<?php
$cars = array( 
        "car1" => array (   
            "brand" => 'BMW',
            "license" => '30-KL-PO',    
            "price" => 10000
            ),

        "car2" => array (
           "brand" => 'Mercedes',
           "license" => '51-ZD-ZD',
           "price" => 20000
        ),

        "car3" => array (
           "brand" => 'Maserati',
           "license" => 'JB-47-02',
           "price" => 30000
        )
     );

foreach($cars as $car)
    printf("%-10s %s\n",  $car['brand'], $car['license']);