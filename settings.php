<?php 

$settings = [
    
    /*
     * Код страны для таргетинга.
     * ISO: https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
     */
    
    'country_code' => "US",
    
    
    'targeting' => [
    
        /*
         * Настройки таргетинга
         */
        
        // Платформа
        'Mobile' => true,
        'Tablet' => true,
        'Desktop' => true,
        
        // Операционная система для моб. устройств
        'AndroidOS' => true,
        'iOS' => true,
        
        // Популярные устройства
        'iPad' => true,
        'iPhone' => true,
        
    ],
    
];

?>