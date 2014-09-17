<?php namespace Kalley\SitemapPlus\Extensions;

use Kalley\SitemapPlus\Extension;
use Illuminate\Support\Collection;
use Closure;

class News extends Extension {

  protected $columns = ['publication', 'access', 'genres', 'publication_date', 'title', 'keywords', 'stock_tickers'];

  public function __construct($publication_name, $publication_language, $title, $publication_date) {
    parent::__construct();

    $this->publication = [
      'name' => $publication_name,
      'language' => $publication_language,
    ];
    $this->title = $title;
    $this->publication_date = $publication_date;
  }

  public function addGenres($genres) {
    if ( func_num_args() > 1 ) {
      $genres = func_get_args();
    }
    if ( is_array($genres) ) {
      $genres = implode(', ', $genres);
    }
    $this->genres = ( isset($this->genres) ? $this->genres . ' ' : '' ) . $genres;
    return $this;
  }

  public function addKeywords($keywords) {
    if ( func_num_args() > 1 ) {
      $keywords = func_get_args();
    }
    if ( is_array($keyword) ) {
      $keywords = implode(', ', $keywords);
    }
    $this->keywords = ( isset($this->keywords) ? $this->keywords . ' ' : '' ) . $keywords;
    return $this;
  }

  public function addStockTickers($stock_tickers) {
    if ( func_num_args() > 1 ) {
      $stock_tickers = func_get_args();
    }
    if ( is_array($stock_tickers) ) {
      $stock_tickers = implode(', ', $stock_tickers);
    }
    $this->stock_tickers = ( isset($this->stock_tickers) ? $this->stock_tickers . ' ' : '' ) . $stock_tickers;
    return $this;
  }

}
