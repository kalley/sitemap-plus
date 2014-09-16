@foreach ( $videos as $video )
    <video:video>
@foreach ( $video->toArray() as $prop => $val )
@if ( $prop === 'tag' )
@foreach ( $val as $tag )
      <video:tag>{{ $tag }}</video:tag>
@endforeach
@elseif ( $prop === 'price' )
@foreach ( $val as $price )
      <video:price{{ isset($price->currency) ? ' currency="' . $price->currency . '"' : '' }}{{ isset($price->type) ? ' type="' . $price->type . '"' : '' }}{{ isset($price->resolution) ? ' resolution="' . $price->resolution . '"' : '' }}>{{ $price->text }}</video:price>
@endforeach
@else
      <video:{{ $prop }}>{{ $val }}</video:{{ $prop }}>
@endif
@endforeach
    </video:video>
@endforeach
