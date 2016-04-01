<?php

return [
    // Global.
    ['GET',  '/record-appraisal', ['Fotheby\Controllers\Appraisals', 'display']],
    ['POST', '/record-appraisal', ['Fotheby\Controllers\Appraisals', 'insert']],

    // Experts.
    ['GET',  '/expert-selection',  ['Fotheby\Controllers\ExpertSelection', 'display']],

];



