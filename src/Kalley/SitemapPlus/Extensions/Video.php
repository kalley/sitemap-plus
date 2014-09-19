<?php namespace Kalley\SitemapPlus\Extensions;

use Kalley\SitemapPlus\Extension;
use Illuminate\Support\Collection;
use Closure;
use Carbon\Carbon;

class Video extends Extension {

  protected $columns = ['thumbnail_loc', 'title', 'description', 'content_loc', 'player_loc', 'duration', 'expiration_date', 'view_count', 'rating', 'publication_date', 'family_friendly', 'category', 'restrictions', 'gallery_loc', 'price', 'requires_subscription', 'uploaded', 'platform', 'live', 'tag'];
  protected $restricted = ['price', 'restriction', 'platform', 'expiration_date', 'publication_date'];

  public function __construct($thumbnail_loc, $title, $description, $content_loc = null, $player_loc = null) {
    parent::__construct();

    $this->thumbnail_loc = $thumbnail_loc;
    $this->title = $title;
    $this->description = $description;
    $this->content_loc = $content_loc;
    if ( $player_loc !== null ) {
      $this->player_loc = [
        'allow_embed' => 'yes',
        'text' => $player_loc,
      ];
    }
    $this->props['tag'] = new Collection();
    $this->props['price'] = new Collection();
  }

  public function addExpirationDate($expiration_date) {
    if ( $expiration_date !== null && ! ( $expiration_date instanceof Carbon ) ) {
      $expiration_date = Carbon::parse($expiration_date)->toW3CString();
    }
    $this->props['expiration_date'] = $expiration_date;
  }

  public function addPublicationDate($publication_date) {
    if ( $publication_date !== null && ! ( $publication_date instanceof Carbon ) ) {
      $publication_date = Carbon::parse($publication_date)->toW3CString();
    }
    $this->props['publication_date'] = $publication_date;
  }

  public function addTags($tags) {
    if ( func_num_args() > 1 ) {
      $tags = func_get_args();
    }
    if ( ! is_array($tags) ) {
      $tags = [$tags];
    }
    if ( $this->tag->count() < 32 - count($tags) ) {
      $this->tag->merge($tags);
      return $this;
    }
    throw new Exception('Only 32 tags are allowed');
  }

  public function addPrice($price, $currency, Closure $inline = null) {
    $price = (object)[
      'text' => $price,
      'currency' => $currency,
    ];
    $this->price[] = $price;
    if ( $inline !== null ) {
      $inline($price);
    }
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
