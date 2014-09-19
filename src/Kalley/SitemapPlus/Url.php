<?php namespace Kalley\SitemapPlus;

use Kalley\SitemapPlus\Extensions\News;
use Kalley\SitemapPlus\Extensions\Video;
use Kalley\SitemapPlus\Extensions\Image;
use Illuminate\Support\Collection;
use Closure;
use Carbon\Carbon;
use DateTime;

class Url {

  protected $sitemap;
  public $video = [];
  public $image = [];
  public $translations = [];
  public $mobile = false;

  protected $props = [];

  public function __construct($sitemap, $loc, $lastmod = null, $changefreq = null, $priority = null) {
    $this->sitemap = $sitemap;
    $this->loc = $loc;
    if ( $lastmod !== null && ! ( $lastmod instanceof Carbon ) ) {
      if ( $lastmod instanceof DateTime ) {
        $lastmod = Carbon::instance($lastmod)->toW3CString();
      } else {
        $lastmod = Carbon::parse($lastmod)->toW3CString();
      }
    }
    $this->lastmod = $lastmod;
    $this->changefreq = $changefreq;
    $this->priority = $priority;
  }

  public function addImage($loc, Closure $inline = null) {
    $this->sitemap->addNamespace('image');
    $image = new Image($loc);
    $this->image[] = $image;
    if ( $inline !== null ) {
      $inline($image);
    }
    return $this;
  }

  public function addVideo($thumbnail_loc, $title, $description, $content_loc = null, $player_loc = null, Closure $inline = null) {
    $this->sitemap->addNamespace('video');
    $video = new Video($thumbnail_loc, $title, $description, $content_loc, $player_loc);
    $this->video[] = $video;
    if ( $inline !== null ) {
      $inline($video);
    }
    return $this;
  }

  public function addNews($publication_name, $publication_language, $title, $publication_date = null, Closure $inline = null) {
    $this->sitemap->addNamespace('news');
    if ( $publication_date === null ) {
      $publication_date = $this->lastmod;
    }
    $news = new News($publication_name, $publication_language, $title, $publication_date);
    $this->news = $news;
    if ( $inline !== null ) {
      $inline($news);
    }
    return $this;
  }

  public function addTranslation($language, $loc) {
    $this->translations[] = [
      'rel' => 'alternate',
      'hreflang' => $language,
      'href' => $loc,
    ];
    return $this;
  }

  public function isMobile($bool = null) {
    if ( $bool === null ) {
      return $this->mobile;
    }
    $this->sitemap->addNamespace('mobile');
    $this->mobile = (bool)$bool;
    return $this;
  }
}
