<?php

return [
    // Global.
    ['GET',  '/record-appraisal', ['Fotheby\Controllers\Appraisals', 'display']],
    ['POST', '/record-appraisal', ['Fotheby\Controllers\Appraisals', 'insert']],

    // Experts.
    ['GET',  '/expert-selection', ['Fotheby\Controllers\ExpertSelection', 'display']],
    ['POST', '/expert-selected',  ['Fotheby\Controllers\ExpertSelection', 'store']],
    ['GET',  '/expert-selected',  ['Fotheby\Controllers\ExpertSelection', 'retrieve']],
    // ['GET',  '/expert-selection/search/{data}',    ['Fotheby\Controllers\ExpertSelection', 'search']],

    ['GET',  '/category-selection', ['Fotheby\Controllers\CategorySelection', 'display']],
    ['POST', '/category-selected',  ['Fotheby\Controllers\CategorySelection', 'store']],
    ['GET',  '/category-selected',  ['Fotheby\Controllers\CategorySelection', 'retrieve']],
];



