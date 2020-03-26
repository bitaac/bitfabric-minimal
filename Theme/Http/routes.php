<?php

Route::get('/theme/{asset}', 'ThemeAssetsController@handle')->where('asset', '(.*)');
