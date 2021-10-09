<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('hyperpay')
         ->group(function () {
             Route::get('/redirect/{cart}/{checkoutId}/{transactionId}', 'Devloops\HyperPay\Http\Controllers\HyperPayController@redirect')
                  ->name('hyperpay.redirect');

             Route::get('/process/{cart}/{checkoutId}/{transactionId}', 'Devloops\HyperPay\Http\Controllers\HyperPayController@process')
                  ->name('hyperpay.process');

             Route::get('/success/{cart}/{checkoutId}/{transactionId}', 'Devloops\HyperPay\Http\Controllers\HyperPayController@success')
                  ->name('hyperpay.success');

             Route::get('/cancel/{cart}/{checkoutId}/{transactionId}', 'Devloops\HyperPay\Http\Controllers\HyperPayController@cancel')
                  ->name('hyperpay.cancel');

             Route::any('/notify/{cart}', 'Devloops\HyperPay\Http\Controllers\HyperPayController@notify')
                  ->name('hyperpay.notify');
         });
});
