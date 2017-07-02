<?php

Route::get('/', 'HomeController');

Route::get('/error/<code>', 'ErrorController:error');

Route::abort(404);

?>