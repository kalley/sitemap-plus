<?php namespace Kalley\SitemapPlus;

class Image extends Extension {

  protected $columns = ['loc', 'caption', 'geo_location', 'title', 'license'];

  public function __construct($loc) {
    parent::__construct();
    $this->loc = $loc;
  }

  public function toXML() {

  }
}
