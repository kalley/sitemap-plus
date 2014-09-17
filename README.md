# Sitemap - plus extensions

This package builds XML and text sitemaps. Sitemap indexes are still in the works, but are currently not implemented.

## Package Installation

Add the following line to your composer.json file:

```javascript
"kalley/sitemap-plus": "dev-master"
```

or run `composer require kalley/sitemap-plus:dev-master` from the command line

Add this line of code to the ```providers``` array located in your ```app/config/app.php``` file:
```php
'Kalley\SitemapPlus\SitemapPlusServiceProvider',
```

### Configuration

coming soon...

## Example

```php
Route::get('sitemap{ext?}', function($ext = '.xml') {
  return App::make('sitemap-plus')
    ->addUrl(URL::to('/'), '2014-09-09', null, '1.0', function($url) {
      $url->isMobile(true)
        ->addVideo('http://thumbnail', 'Sample video', '', null, 'http://playerloc', function($video) {
          $video->family_friendly = 'yes';
          $video->addPrice('20.00', 'USD')
            ->addPrice('25.00', 'EUR', function($price) {
              $price->resolution = 'HD';
            });
        })
        ->addImage('http://location');
    })
    ->addUrl(URL::to('about'))
    ->render($ext);
})
  ->where(['ext' => '\.(txt|xml)']);
```

For full API, see the wiki


## Support

Bugs and feature request are tracked on [GitHub](https://github.com/kalley/sitemap-plus/issues)

## License

This package is released under the MIT License.
