<?php

Route::get('baskets/{data}', \Anditsung\NovaUgBaskets\Http\Controllers\BasketController::class . '@basketLabelPDF');
