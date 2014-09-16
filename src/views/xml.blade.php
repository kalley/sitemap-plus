<{{ '?xml version="1.0" encoding="UTF-8"?' }}>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" {{ $sitemap->getNamespaces() }}>
@foreach ( $sitemap->urls as $url )
  <url>
    <loc>{{ $url->loc }}</loc>
    {{ $url->lastmod ? '<lastmod>' . $url->lastmod . '</lastmod>' : '' }}
    {{ $url->changefreq ? '<changefreq>' . $url->changefreq . '</changefreq>' : '' }}
    {{ $url->priority ? '<priority>' . $url->priority . '</priority>' : '' }}
@if ( $url->video )
    @include('sitemap-plus::partials/video', ['videos' => $url->video])
@endif
@if ( $url->image )
    @include('sitemap-plus::partials/image', ['images' => $url->image])
@endif
  </url>
@endforeach
</urlset>
