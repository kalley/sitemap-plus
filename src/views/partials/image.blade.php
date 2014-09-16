@foreach ( $images as $image )
    <image:image>
@foreach ( $image->toArray() as $prop => $val )
      <image:{{ $prop }}>{{ $val }}</image:{{ $prop }}>
@endforeach
    </image:image>
@endforeach
