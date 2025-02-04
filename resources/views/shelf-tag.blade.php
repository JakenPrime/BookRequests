<div style="text-align:center">
    <h2>{{ $book->course }}</h2>
    <h2>{{ $book->name }}</h2>
    <br>
    <h3>{{ $book->title }}</h3>
    <br>
    <br>
    @foreach($book->teachers as $item)
    <p>{{ $item }}</p>
    @endforeach
</div>