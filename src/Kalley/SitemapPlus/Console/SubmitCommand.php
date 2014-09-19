<?php namespace Kalley\SitemapPlus\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SubmitCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'sitemap-plus:submit';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Submit your sitemap to various search engines';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct($app) {
    parent::__construct();
    $this->app = $app ?: app();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function fire() {
    $sitemap = $this->app['url']->to($this->argument('sitemap_url'));
    $all = $this->option('all');
    if ( $all ) {
      $engines = ['google', 'bing'];
    } else {
      $engines = preg_split("/,\s*/", $this->option('engines'));
    }
    $success = [];
    foreach ( $engines as $engine ) {
      $this->info("Sending sitemap to $engine");
      if ( $this->sendRequest($engine, $sitemap) !== 200 ) {
        $this->error("failed to send to $engine");
      } else {
        $success[] = $engine;
      }
    }
    if ( count($success) ) {
      $this->info("Successfully submitted $sitemap to " . implode(", ", $success));
    }
  }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments() {
    return [
      ['sitemap_url', InputArgument::REQUIRED, 'The sitemap url to submit'],
    ];
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions() {
    return [
      ['all', 'a', InputOption::VALUE_NONE, 'Submit to all supported search engines. Same as --engines=google,bing'],
      ['engines', null, InputOption::VALUE_OPTIONAL, 'Comma-separated list of search engines. Valid values are "google", "bing"'],
    ];
  }

  protected function sendRequest($site, $sitemap_url) {
    $url = 'http://www.' . $site . '.com/ping?sitemap=' . rawurlencode($sitemap_url);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $code;
  }

}
