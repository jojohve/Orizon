<?php

return [
    [
        'route' => '/trips',
        'method' => 'GET',
        'controller' => 'TripController',
        'action' => 'getTrips'
    ],
    [
        'route' => '/trips',
        'method' => 'POST',
        'controller' => 'TripController',
        'action' => 'createTrip'
    ],
    [
        'route' => '/trips/{id}',
        'method' => 'PUT',
        'controller' => 'TripController',
        'action' => 'updateTrip'
    ],
    [
        'route' => '/trips/{id}',
        'method' => 'DELETE',
        'controller' => 'TripController',
        'action' => 'deleteTrip'
    ],

    [
        'route' => '/countries',
        'method' => 'GET',
        'controller' => 'CountryController',
        'action' => 'getCountries'
    ],
    [
        'route' => '/countries',
        'method' => 'POST',
        'controller' => 'CountryController',
        'action' => 'createCountry'
    ],
    [
        'route' => '/countries/{id}',
        'method' => 'PUT',
        'controller' => 'CountryController',
        'action' => 'updateCountry'
    ],
    [
        'route' => '/countries/{id}',
        'method' => 'DELETE',
        'controller' => 'CountryController',
        'action' => 'deleteCountry'
    ],
];
