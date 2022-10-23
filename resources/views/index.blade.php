<?php
 // articles
?>
<div style="text-align:center">
    <h1> Articles</h1>
    <br/>
    <br/>
    @foreach($articles as $article)
        <h3>{{ $article->title }}</h3>
        {{--<img src="{{$article->image}}" width="200" height="200"/>--}}
        <a href="/article/{{ $article->id }}" style="text-decoration: none; color:black"><p>{{ $article->description}}...... Read more </p></a>
        <br/>
    @endforeach
</div>

