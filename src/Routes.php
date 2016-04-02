<?php

return [
    // Global.
    ['GET',  '/record-appraisal', ['Fotheby\Controllers\Appraisals', 'display']],
    ['POST', '/record-appraisal', ['Fotheby\Controllers\Appraisals', 'insert']],

    // Clients.
    ['GET',  '/new-client-selection', ['Fotheby\Controllers\ClientNewSelection', 'display']],
    ['POST', '/new-client-selected',  ['Fotheby\Controllers\ClientNewSelection', 'store']],
    ['GET',  '/new-client-selected',  ['Fotheby\Controllers\ClientNewSelection', 'retrieve']],

    ['GET',  '/existing-client-selection', ['Fotheby\Controllers\ClientExistingSelection', 'display']],
    ['POST', '/existing-client-selected',  ['Fotheby\Controllers\ClientExistingSelection', 'store']],
    ['GET',  '/existing-client-selected',  ['Fotheby\Controllers\ClientExistingSelection', 'retrieve']],
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
    ['GET',  '/item-dimensions',      ['Fotheby\Controllers\ItemDimensionSelection', 'display']],
    ['POST', '/item-dimensions-set',  ['Fotheby\Controllers\ItemDimensionSelection', 'store']],
    ['GET',  '/item-dimensions-set',  ['Fotheby\Controllers\ItemDimensionSelection', 'retrieve']],

    // Item Weight
    ['GET',  '/item-weight',      ['Fotheby\Controllers\ItemWeightSelection', 'display']],
    ['POST', '/item-weight-set',  ['Fotheby\Controllers\ItemWeightSelection', 'store']],
    ['GET',  '/item-weight-set',  ['Fotheby\Controllers\ItemWeightSelection', 'retrieve']],

    // Item Images
    ['GET',  '/item-images',      ['Fotheby\Controllers\ItemImageSelection', 'display']],
    ['POST', '/item-images-set',  ['Fotheby\Controllers\ItemImageSelection', 'store']],
    ['GET',  '/item-images-set',  ['Fotheby\Controllers\ItemImageSelection', 'retrieve']],

    ['POST', '/image-upload',     ['Fotheby\Controllers\ItemImageSelection', 'upload']],

];



