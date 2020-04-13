@extends ('layouts.master')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script> 

@section('content')
<h1>{{$user->FullName}}</h1> 
<hr>
   <div class="table-responsive">
    <table id="user_table" class="table table-striped table-sm">
     <thead>
      <tr id='presence'>
        <th>Дата присутствия</th>
        <th>Отработанное время</th>
        <th>Состояние</th>
        <th>Комментарий</th>
        <th>action</th>
      </tr>
     </thead>
    </table>
   </div>

  </div>

<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-body">
        <h4 class="modal-title"></h4>
         <span id="form_result"></span>
         <form method="post" id="sample_form" class="form-horizontal">
          @csrf
          <div class="form-group">
            <label class="control-label" >Отработанное время: </label>
            
             <input type="text" name="work_time" id="work_time" class="form-control" />
            
           </div>
            <div class="form-group">
                <label for="condition">Статус: </label>
                <select class="form-control form-control" id="condition" name="condition" aria-describedby="condition">
                    @foreach($EmployeePresenceStatus as $condition)
                            <option value="{{$condition->id}}">{{$condition->name}}</option>
                    @endforeach
                </select>
            </div>

                <div class="form-group">
                    <label for="comment">Комментарий: </label>
                    <textarea class="form-control" id="comment" rows="3" name="comment"></textarea>
                </div>
                <br />
                <div class="form-group" align="center">
                 <input type="hidden" name="action" id="action" value="Add" />
                 <input type="hidden" name="hidden_id" id="hidden_id" />
                 <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                </div>
         </form>
        </div>
     </div>
    </div>
</div>

<script>
$(document).ready(function(){

 $('#user_table').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
   url: '{{ url('EmployeePresence/'.$user->user_id) }}',
  },
  columns: [
   {
    data: 'presence_date',
    name: 'presence_date'
   },
   {
    data: 'work_time',
    name: 'work_time'
   },
   {
    data: 'condition',
    name: 'condition'
   },
   {
    data: 'comment',
    name: 'comment'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ],
  "language": {
    "processing": "Подождите...",
    "search": "Поиск:",
    "lengthMenu": "Показать _MENU_ записей",
    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
    "infoEmpty": "Записи с 0 до 0 из 0 записей",
    "infoFiltered": "(отфильтровано из _MAX_ записей)",
    "infoPostFix": "",
    "loadingRecords": "Загрузка записей...",
    "zeroRecords": "Записи отсутствуют.",
    "emptyTable": "В таблице отсутствуют данные",
    "paginate": {
            "first": "Первая",
            "previous": "Предыдущая",
            "next": "Следующая",
            "last": "Последняя"
    },
    "aria": {
        "sortAscending": ": активировать для сортировки столбца по возрастанию",
        "sortDescending": ": активировать для сортировки столбца по убыванию"
    },

        "emptyTable": "<p>введите данные для поиска</p>"
  }
 });

 $('#sample_form').on('submit', function(event){
  event.preventDefault();
  action_url = "{{ url('EmployeePresence/'.$user->user_id.'/update') }}";
  

  $.ajax({
   url: action_url,
   method:"POST",
   data:$(this).serialize(),
   dataType:"json",
   success:function(data)
   {
    var html = '';
    if(data.errors)
    {
     html = '<div class="alert alert-danger">';
     for(var count = 0; count < data.errors.length; count++)
     {
      html += '<p>' + data.errors[count] + '</p>';
     }
     html += '</div>';
    }
    if(data.success)
    {
     html = '<div class="alert alert-success">' + data.success + '</div>';
     $('#sample_form')[0].reset();
     
     $('#user_table').DataTable().ajax.reload();
    }
    $('#form_result').html(html);
    $('#work_time').val(data.result.work_time);
    $('#condition').val(data.result.condition);
    $('#comment').val(data.result.comment);
   }
  });
 });
    

 $(document).on('click', 'tr', function(){
  var id = $(this).attr('id');
  $('#form_result').html('');
  $.ajax({
   url :"/lk/EmployeePresence/"+id+"/edit",
   dataType:"json",
   success:function(data)
   {
    $('#work_time').val(data.result.work_time);
    $('#condition').val(data.result.condition);
    $('#comment').val(data.result.comment);
    $('#hidden_id').val(id);
    $('.modal-title').text(data.result.presence_date.split(' ')[0]);
    $('#action_button').val('Сохранить');
    $('#action').val('Сохранить');
    $('#formModal').modal('show');
   }
  })
 });

});
</script>

@endsection