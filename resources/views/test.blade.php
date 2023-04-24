<dl>
    <dt>作品名</dt>
    @foreach($titles as $title)
        <dd>{{ $title }}</dd>
    @endforeach
    <br>
    <dt>あらすじ</dt>
    @foreach($details as $detail)
        <dd>{{ $detail }}</dd>
    @endforeach
</dl>
