<?php namespace Kalley\SitemapPlus;

use Illuminate\Support\Collection;
use Closure;
use Response;

class Sitemap {

  protected static $extensions = [
    'image'  => 'http://www.google.com/schemas/sitemap-image/1.1',
    'video'  => 'http://www.google.com/schemas/sitemap-video/1.1',
    'mobile' => 'http://www.google.com/schemas/sitemap-mobile/1.0',
    'news'   => 'http://www.google.com/schemas/sitemap-news/0.9',
  ];

  protected $config;
  protected $cache;
  protected $request;

  protected $ns = [
    '' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
  ];

  public function __construct(array $config, $cache, $request) {
    $this->config = $config;
    $this->cache = $cache;
    $this->request = $request;

    $this->urls = new Collection();
  }

  public function with($extension) {
    $extensions = func_get_args();
    foreach ( $extensions as $extension ) {
      $this->addNamespace($extension);
    }
    return $this;
  }

  public function getNamespaces() {
    return implode(" ", array_map(function($val, $key) {
      return 'xmlns' . ( empty($key) ? '' : ':' . $key ) . '="' . $val . '"';
    }, $this->ns, array_keys($this->ns)));
  }

  public function addNamespace($extension) {
    $this->ns[$extension] = self::$extensions[$extension];
    return $this;
  }

  public function addUrl($loc, $lastmod = null, $changefreq = null, $priority = null, Closure $inline = null) {
    $url = new Url($this, $loc, $lastmod, $changefreq, $priority);
    $this->urls[] = $url;
    if ( $inline !== null ) {
      $inline($url);
    }
    return $this;
  }

  public function render($type = 'xml') {
    $type = strpos($type, '.') === false ? $type : substr($type, 1);
    switch ( $type ) {
      case 'txt':
        $contentType = 'text/plain';
        break;
      default:
        $contentType = 'application/xml';
    }
    return Response::view('sitemap-plus::' . $type, ['sitemap' => $this])->header('Content-type', $contentType)->send();
  }

}
