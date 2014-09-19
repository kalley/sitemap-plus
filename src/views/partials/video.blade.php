@foreach ( $videos as $video )
    <video:video>
@foreach ( $video->toArray() as $prop => $val )
@if ( $prop === 'tag' )
@foreach ( $val as $tag )
      <video:tag>{{ $tag }}</video:tag>
@endforeach
@elseif ( $prop === 'price' )
@foreach ( $val as $price )
      <video:price{{ HTML::attributes(array_diff_key((array)$price, ['text' => ''])) }}>{{ $price->text }}</video:price>
@endforeach
@elseif ( is_array($val) )
      <video:{{ $prop }}{{ HTML::attributes(array_diff_key($val, ['text' => ''])) }}>{{ $val['text'] }}</video:{{ $prop }}>
@elseif ( ! is_null($val) )
      <video:{{ $prop }}>{{ $val }}</video:{{ $prop }}>
@endif
@endforeach
    </video:video>
@endforeach
