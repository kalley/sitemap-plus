<?php namespace Kalley\SitemapPlus;

abstract class Extension {

  protected $columns = [];
  protected $props = [];
  protected $restricted = [];

  public function __construct() {
    $this->columns = array_combine($this->columns, $this->columns);
    $this->restricted = array_combine($this->restricted, $this->restricted);
  }

  public function __set($prop, $val) {
    if ( array_key_exists($prop, $this->columns) && ! array_key_exists($prop, $this->restricted) ) {
      $this->props[$prop] = $val;
    }
  }

  public function __get($prop) {
    return $this->props[$prop];
  }

  public function __isset($prop) {
    return isset($this->props[$prop]);
  }

  public function __unset($prop) {
    unset($this->props[$prop]);
  }

  public function toArray() {
    return $this->props;
  }
}
