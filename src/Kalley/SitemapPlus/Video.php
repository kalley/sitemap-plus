<?php namespace Kalley\SitemapPlus;

use Illuminate\Support\Collection;
use Closure;

class Video extends Extension {

  protected $columns = ['thumbnail_loc', 'title', 'description', 'content_loc', 'player_loc', 'duration', 'expiration_date', 'view_count', 'rating', 'publication_date', 'family_friendly', 'category', 'restrictions', 'gallery_loc', 'price', 'requires_subscription', 'uploaded', 'platform', 'live', 'tag'];
  protected $restricted = ['price', 'restriction', 'platform'];

  public function __construct($thumbnail_loc, $title, $description, $content_loc = null, $player_loc = null) {
    parent::__construct();

    $this->thumbnail_loc = $thumbnail_loc;
    $this->title = $title;
    $this->description = $description;
    $this->content_loc = $content_loc;
    $this->player_loc = $player_loc;
    $this->tag = new Collection();
    $this->price = new Collection();
  }

  public function addTag($tag) {
    if ( $this->tag->count() < 32 ) {
      $this->tag[] = $tag;
      return $this;
    }
    throw new Exception('Only 32 tags are allowed');
  }

  public function addPrice($price, $currency, Closure $inline = null) {
    $price = (object)[
      'text' => $price,
      'currency' => $currency,
    ];
    if ( $inline !== null ) {
      $inline($price);
    }
    $this->price[] = $price;
    return $this;
  }

  public function addGallery($loc, $title = null) {
    $this->props['gallery_loc'] = (object)[
      'text' => $loc,
    ];
    if ( $title !== null ) {
      $this->props['gallery_loc']->title = $title;
    }
    return $this;
  }

  public function addRestriction($countries, $allow = true) {
    $this->props['restriction'] = [
      'text' => is_array($countries) ? implode(' ', $countries) : $countries,
      'relationship' => $allow ? 'allow' : 'deny',
    ];
    return $this;
  }

  public function addUploader($name, $info = null) {
    $this->props['uploader'] = (object)[
      'text' => $name,
    ];
    if ( $info !== null ) {
      $this->props['uploader']->info = $info;
    }
    return $this;
  }

  public function addPlatform($platforms, $allow = true) {
    $this->props['platform'] = [
      'text' => is_array($platforms) ? implode(' ', $platforms) : $platforms,
      'relationship' => $allow ? 'allow' : 'deny',
    ];
    return $this;
  }

}
