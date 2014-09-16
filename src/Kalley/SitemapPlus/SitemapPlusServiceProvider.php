<?php namespace Kalley\SitemapPlus;

use Illuminate\Support\ServiceProvider;

class SitemapPlusServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('kalley/sitemap-plus');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('sitemap-plus', function($app) {
          return new Sitemap($app['config']->get('sitemap-plus'), $app['cache'], $app['request']);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('sitemap-plus');
	}

}
