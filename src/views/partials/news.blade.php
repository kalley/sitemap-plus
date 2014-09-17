<news:news>
@foreach ( $news->toArray() as $key => $val )
      <news:{{ $key }}>@if ( is_array($val) )
@foreach ( $val as $k => $v )

        <news:{{ $k }}>{{ $v }}</news:{{ $k }}>@endforeach
<?= "\n      "; ?>
@else{{ $val }}@endif</news:{{ $key }}>
@endforeach
    </news:news>
