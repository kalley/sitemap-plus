<?php namespace Kalley\SitemapPlus;

use Illuminate\Support\Collection;
use Closure;

class Url {

  protected $sitemap;
  public $video = [];
  public $image = [];

  public function __construct($sitemap, $loc, $lastmod = null, $changefreq = null, $priority = null) {
    $this->sitemap = $sitemap;
    $this->loc = $loc;
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
}
