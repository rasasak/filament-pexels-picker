<?php

return [
    'label' => 'Vybrat z Pexels',
    'description' => 'Můžete vybrat 1 fotku.|Můžete vybrat :numberOfSelectableImages fotek.',
    'form' => [
        'fields' => [
            'search' => [
                'placeholder' => 'Vyhledat fotky...',
            ],
            'square_mode' => [
                'label' => 'Square Mode',
            ],
        ],
    ],
    'actions' => [
        'next_page' => [
            'label' => 'Další',
        ],
        'previous_page' => [
            'label' => 'Předchozí',
        ],
    ],
    'no_search_results' => "Sorry, your search didn't return any results.<br>Please try a different search.",
];
