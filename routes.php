<?php

return [
    [
        'route' => '/trips',
        'method' => 'GET',
        'controller' => 'TripController',
        'action' => 'readTrips'
    ],
    [
        'route' => '/trips',
        'method' => 'POST',
        'controller' => 'TripController',
        'action' => 'createTrip'
    ],
    [
        'route' => '/trips/{Id}',
        'method' => 'PUT',
        'controller' => 'TripController',
        'action' => 'updateTrip'
    ],
    [
        'route' => '/trips/{Id}',
        'method' => 'DELETE',
        'controller' => 'TripController',
        'action' => 'deleteTrip'
    ],

    [
        'route' => '/countries',
        'method' => 'GET',
        'controller' => 'CountryController',
        'action' => 'readCountries'
    ],
    [
        'route' => '/countries',
        'method' => 'POST',
        'controller' => 'CountryController',
        'action' => 'createCountry'
    ],
    [
        'route' => '/countries/{Id}',
        'method' => 'PUT',
        'controller' => 'CountryController',
        'action' => 'updateCountry'
    ],
    [
        'route' => '/countries/{Id}',
        'method' => 'DELETE',
        'controller' => 'CountryController',
        'action' => 'deleteCountry'
    ],
];
