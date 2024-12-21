@extends('layout')
@section('content')
@use('App\Models\User', 'User')
@use('App\Models\Article', 'Article')

@if(session('status'))
  <div class="alert alert-success">
      {{ session('status') }}
  </div>
@endif

<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Name Article</th>
      <th scope="col">Description</th>
      <th scope="col">Author</th>
      <th scope="col">Accept/Reject</th>
    </tr>
  </thead>
  <tbody>
    @foreach($comments as $comment)
    <tr>
      <th scope="row">{{$comment->created_at}}</th>
      <td>
        @php
          try {
            $article = Article::findOrFail($comment->article_id);
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $article = null;
          }
        @endphp

        @if($article)
          <a href="/article/{{ $article->id }}">{{ $article->name }}</a>
        @else
          <span>Article not found</span>
        @endif
      </td>
      <td>{{$comment->desc}}</td>
      
      @php
        try {
          $user = User::findOrFail($comment->user_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          $user = null;
        }
      @endphp
      
      <td>
        @if($user)
          {{ $user->name }}
        @else
          <span>User not found</span>
        @endif
      </td>

      <td class="text-center">
        @if(!$comment->accept)
          <a class="btn btn-success" href="/comment/{{$comment->id}}/accept">Accept</a>
        @else
          <a class="btn btn-warning" href="/comment/{{$comment->id}}/reject">Reject</a>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $comments->links() }}
@endsection
