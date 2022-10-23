<?php
  // article
?>
<div style="text-align:center">
    <h1> {{ $article->title }} </h1>

    <img src="{{ $article->image }}"/>
    <br/>
    <br/>

    {{ $article->description }}
</div>
