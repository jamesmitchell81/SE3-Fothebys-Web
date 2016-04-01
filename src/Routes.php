<?php

return [
    // Global.
    ['GET',  '/record-appraisal', ['Fotheby\Controllers\Appraisals', 'display']],
    ['POST', '/record-appraisal', ['Fotheby\Controllers\Appraisals', 'insert']],

    // Clients.
    ['GET',  '/existing-client-selection', ['Fotheby\Controllers\ClientSelection', 'display']],
    ['POST', '/existing-client-selected',  ['Fotheby\Controllers\ClientSelection', 'store']],
    ['GET',  '/existing-client-selected',  ['Fotheby\Controllers\ClientSelection', 'retrieve']],
    // ['GET',  '/expert-selection/search/{data}',    ['Fotheby\Controllers\ExpertSelection', 'search']],

    // Experts.
    ['GET',  '/expert-selection', ['Fotheby\Controllers\ExpertSelection', 'display']],
    ['POST', '/expert-selected',  ['Fotheby\Controllers\ExpertSelection', 'store']],
    ['GET',  '/expert-selected',  ['Fotheby\Controllers\ExpertSelection', 'retrieve']],
    // ['GET',  '/expert-selection/search/{data}',    ['Fotheby\Controllers\ExpertSelection', 'search']],

    // Category
    ['GET',  '/category-selection', ['Fotheby\Controllers\CategorySelection', 'display']],
    ['POST', '/category-selected',  ['Fotheby\Controllers\CategorySelection', 'store']],
    ['GET',  '/category-selected',  ['Fotheby\Controllers\CategorySelection', 'retrieve']],

    // Date Period
    ['GET',  '/date-period-selection', ['Fotheby\Controllers\DatePeriodSelection', 'display']],
    ['POST', '/date-period-selected',  ['Fotheby\Controllers\DatePeriodSelection', 'store']],
    ['GET',  '/date-period-selected',  ['Fotheby\Controllers\DatePeriodSelection', 'retrieve']],

    // Item Dimension
    ['GET',  '/item-dimensions', ['Fotheby\Controllers\ItemDimensionSelection', 'display']],
    ['POST', '/item-dimensions-set',  ['Fotheby\Controllers\ItemDimensionSelection', 'store']],
    ['GET',  '/item-dimensions-set',  ['Fotheby\Controllers\ItemDimensionSelection', 'retrieve']],

    // Item Images
    ['GET',  '/item-images', ['Fotheby\Controllers\ItemDimensionSelection', 'display']],
    ['POST', '/item-images-set',  ['Fotheby\Controllers\ItemDimensionSelection', 'store']],
    ['GET',  '/item-images-set',  ['Fotheby\Controllers\ItemDimensionSelection', 'retrieve']],
];



