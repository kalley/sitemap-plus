# Sitemap - plus extensions

This is not production ready. Well, for anything beyond what's below. But there's no further information just yet.


```
Route::get('sitemap{ext?}', function($ext = '.xml') {
  $sitemap = App::make('sitemap-plus');

  $sitemap->addUrl(URL::to('/'), '2014-09-09', null, '1.0', function($url) {
    $url->addVideo('http://thumbnail', 'Sample video', '', null, 'http://playerloc', function($video) {
      $video->family_friendly = 'yes';
      $video->addPrice('20.00', 'USD')
        ->addPrice('25.00', 'EUR', function($price) {
          $price->resolution = 'HD';
        });
    })
      ->addImage('http://location');
  })
    ->addUrl(URL::to('about'));

  return $sitemap->render($ext);
})
  ->where(['ext' => '\.(txt|xml)']);
```
