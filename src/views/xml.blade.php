<{{ '?xml version="1.0" encoding="UTF-8"?' }}>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:xhtml="http://www.w3.org/1999/xhtml" {{ $sitemap->getNamespaces() }}>
@foreach ( $sitemap->urls as $url )
  <url>
    <loc>{{ $url->loc }}</loc>
<?php
echo $url->lastmod    ? "    <lastmod>{$url->lastmod}</lastmod>\n" : "";
echo $url->changefreq ? "    <changefreq>{$url->changefreq}</changefreq>\n" : "";
echo $url->priority   ? "    <priority>{$url->priority}</priority>\n" : "";
echo $url->isMobile() ? "    <mobile:mobile/>\n" : ""; ?>
@if ( $url->video )
    @include('sitemap-plus::partials/video', ['videos' => $url->video])
@endif
@if ( $url->image )
    @include('sitemap-plus::partials/image', ['images' => $url->image])
@endif
@if ( isset($url->news) )
    @include('sitemap-plus::partials/news', ['news' => $url->news])
@endif
@if ( $url->translations )
@foreach ( $url->translations as $translation )
    <xhtml:link{{ HTML::attributes($translation) }}/>
@endforeach
@endif
  </url>
@endforeach
</urlset>
