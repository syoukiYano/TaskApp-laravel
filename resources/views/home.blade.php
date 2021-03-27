@extends('layouts.app')

@section('content')        
<div class="container">
    <div class="row">
      <div class="col col-md-8 mx-auto">
        <div class="text-center">
          <h2>初めまして{{ Auth::user()->name }}さん！</h2>
          <p>ありがとう！！このアプリ{{ Auth::user()->id }}人目の登録者です！</p>
          <a class="btn btn-create"><i class="fas fa-plus"></i> 初めてのフォルダーを追加してみよう！</a>
        </div>
        <form action="{{ route('folders.create') }}" method="post">
          <h4>新規フォルダー</h4>              
          <div class="card-body">
              @if($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach($errors->all() as $message)
                          <li>{{ $message }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <div class="form-group">
                <label for="text1">フォルダー名:</label>
                <input type="text" id="text1" class="form-control" name="title" value="{{ old('title') }}" />
              </div>
          </div>
          <div class="modal-footer">              
              {{csrf_field() }}                                                      
              <input type="submit" value="作成" class="btn btn-success">                                
          </div>
      </form>
     </div>
  </div>
</div>    
@endsection
