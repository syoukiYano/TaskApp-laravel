@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <!-- フォルダー -->
      <div class="col col-md-3">                
        <div class="card">
          <div class="card-header clearfix">
            フォルダ
            <div class="float-right">  
              <a class="btn btn-create" data-toggle="modal" data-target="#CreateFolder"><i class="fas fa-plus fa-lg"></i></a>              
            </div>
          </div>     
          <div class="list-group">
            @foreach($folders as $folder)
            <a href="{{ route('tasks.index',['id'=>$folder->id]) }}" class="list-group-item bg-blue {{ $folders_id === $folder->id ? 'active': ''}}">
            {{$folder->title}}
            </a>
            @endforeach
          </div>
        </div>
      </div>
      <!-- タスク -->
      <div class="column col-md-9">
        <div class="card">
          <div class="card-header clearfix">
          {{$current_folder->title}}->タスク
          
          <div class="float-right">     
          <a class="btn btn-create" data-toggle="modal" data-target="#CreateTask" data-whatever="{{ $folders_id }}"><i class="fas fa-plus fa-lg"></i></a>          
          </div>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th>タイトル</th>
              <th>状態</th>
              <th>期限</th>
              <th></th>
            </tr>
            </thead>
            <tbody>                  
              @foreach($tasks as $task)
                <tr>                                                                
                  <td>{{ $task->title }}</td>
                  <td>
                    <span class="badge {{$task->status_class}}">{{ $task->status_label }}</span>                    
                  </td>
                  <td>{{ $task->formatted_due_date }}</td>
                  <td><a href="#" data-toggle="modal" data-target="#EditTask" data-folders_id="{{ $folders_id }}" data-tasks_id="{{ $task->id }}" data-tasks="{{ $task }}">編集</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>          
          @if($tasks->isEmpty())
          <div class="card-body text-center">
              <tr class="text-right">
                  <td><a class="btn btn-create" data-toggle="modal" data-target="#CreateTask" data-whatever="{{ $folders_id }}"><i class="fas fa-plus"></i> タスクを追加してみよう！</a></td>
              </tr>
          </div>
          @endif
        </div>
      </div>
      <!-- モーダルウィンドウ 新規フォルダー -->
      <div class="modal fade" id="CreateFolder" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form action="{{ route('folders.create') }}" method="post">
                      <div class="modal-header">
                          <h4><div class="modal-title" id="myModalLabel">新規フォルダー</div></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
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
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>                                
                          {{csrf_field() }}                                                      
                          <input type="submit" value="作成" class="btn btn-success">                                
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <!-- モーダルウィンドウ 新規タスク -->
      <div class="modal fade" id="CreateTask" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form action="" method="post"><!-- actionをjQueryで変更 -->
                      <div class="modal-header">
                          <h4><div class="modal-title" id="myModalLabel">新規タスク作成</div></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          @if($errors->any())
                            <div class="alert alert-danger">
                              @foreach($errors->all() as $message)
                                <p>{{ $message }}</p>
                              @endforeach
                            </div>
                          @endif
                          <div class="form-group">
                            <label for="text">タイトル:</label>
                            <input name="title" value="{{ old('title') }}" type="text" id="text" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="select">いつやるか？</label>
                            <select name="status" class="form-control" id="select">
                              <option value="1">今でしょ！</option>
                              <option value="2">ちょ待ち</option>                              
                              <option value="3">分からん</option>
                            </select>                                                        
                          </div>
                          <div class="form-group">
                            <div id="datePicker" data-target-input="nearest">
                              <label for="datePicker">期日:</label>
                              <input name="due_date" value="{{ old('due_date') }}" type="text" class="form-control form-control-sm datetimepicker-input" data-target="#datePicker" data-toggle="datetimepicker"/>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>                                
                          {{csrf_field() }}                                                      
                          <input type="submit" value="作成" class="btn btn-success">                                
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <!-- モーダルウィンドウ タスク編集 -->
      <div class="modal fade" id="EditTask" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">                  
                  <div class="modal-header">
                      <h4><div class="modal-title" id="myModalLabel">タスク編集</div></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      @if($errors->any())
                        <div class="alert alert-danger">
                          @foreach($errors->all() as $message)
                            <p>{{ $message }}</p>
                          @endforeach
                        </div>
                      @endif
                      <form action="" method="post" id="Editform"><!-- actionをjQueryで変更 -->
                      <div class="form-group">
                        <label for="text">タイトル:</label>
                        <input name="title" value="a" type="text" id="Titleform" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="select">いつやるか？</label>
                        <select name="status" class="form-control" id="Selectform">
                          <option value="1">今でしょ！</option>
                          <option value="2">ちょ待ち</option>                              
                          <option value="3">分からんw</option>
                          <option value="4">終わった！</option>
                        </select>                                                        
                      </div>
                      <div class="form-group">
                        <div id="datePicker" data-target-input="nearest">
                          <label for="datePicker">期日:</label>
                          <input name="due_date" value="{{ old('due_date') }}" id ="Dateform" type="text" class="form-control form-control-sm datetimepicker-input" data-target="#datePicker" data-toggle="datetimepicker"/>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>                                
                      {{csrf_field() }}                                                      
                      <input type="submit" value="完了" class="btn btn-success"> 
                      </form>
                      <form action="" method="post" id="Deleteform"><!-- actionをjQueryで変更 -->
                          {{csrf_field() }}
                          <input type="submit" value="削除" class="btn btn-danger">
                      </form>                                                
                  </div>
              </div>
          </div>
      </div>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <!-- Tempus Dominus Script -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg==" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/locale/ja.min.js" integrity="sha512-rElveAU5iG1CzHqi7KbG1T4DQIUCqhitISZ9nqJ2Z4TP0z4Aba64xYhwcBhHQMddRq27/OKbzEFZLOJarNStLg==" crossorigin="anonymous"></script>
      <!-- Moment.js -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0/js/tempusdominus-bootstrap-4.min.js"></script>
      <!-- jQuery -->
      <script>
            // モーダルウィンドウにパラメーター引き渡し
            $('#CreateTask').on('show.bs.modal', function (event) {
            var Createbutton = $(event.relatedTarget)
            var Createrecipient = Createbutton.data('whatever')                       
            $('form').attr('action','/folders/'+Createrecipient+'/tasks/create');
            })
            $('#EditTask').on('show.bs.modal', function (event) {
            var Editbutton = $(event.relatedTarget)
            var folderId = Editbutton.data('folders_id')
            var task = Editbutton.data('tasks')
            // $(this).find('.modal-label').text('No.'+folderId)
            // $(this).find('.modal-labels').text('No.'+taskId)
            $('#Editform').attr('action','/folders/'+folderId+'/tasks/'+task['id']+'/edit');
            $('#Deleteform').attr('action','/folders/'+folderId+'/tasks/'+task['id']+'/delete');
            $('#Titleform').attr('value',task['title']);
            $('#Dateform').attr('value',task['due_date']);       
            })
            
            $(function () {
              $('#datePicker').datetimepicker({locale: 'ja', dayViewHeaderFormat: 'YYYY年M月' ,format: 'YYYY/MM/DD'});    
            });
      </script>
    </div>
  </div>
@endsection