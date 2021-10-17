<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/image', function() {
    $files = Storage::files('public/insta');
    $randomFile = Arr::first(Arr::random($files, 1));
    $randomFileUrl = public_path(Storage::url($randomFile));
    $img = Image::make($randomFileUrl)->fit(1080);


    //$img->text("&copy; empowered woman", 540, 540);

    $quote = '"When something is important enough, you do it even if the odds are not in your favor."';

    $lines = explode("\n", wordwrap($quote, 30)); // break line after 120 characters
    //dd($lines);
    for ($i = 0; $i < count($lines); $i++) {
        $offset = 820 + ($i * 100); // 50 is line height
        $img->text($lines[$i], 110, $offset, function ($font) {
            $fonts = [
                'public/Montserrat-Regular.ttf',
                'public/RobotoSlab-Regular.ttf'
            ];
            $font->file(public_path(Storage::url($fonts[rand(0,1)])));
            $font->size(60);
            $font->color('#FFFFFF');
            $font->align('bottom');
            //$font->valign('top');
            //$font->angle(45);
        });
    }
    return $img->response('jpg');
});
