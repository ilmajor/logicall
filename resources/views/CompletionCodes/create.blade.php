@extends ('layouts.master')
@section('content')
<h1>Создать код завершения.</h1> 
<hr>
  <div class="container">
    <form method="POST" action="/lk/CompletionCodes/{{$task->id}}/create">

      {{ csrf_field() }}

      <div class="form-group">
        <label for="Name">Название:</label>
        <input type="text" class="form-control" id="Name" name="Name" required>
      </div>
      <div class="form-group">
        <label for="code_name">Результат:</label>
        <input type="text" class="form-control" id="code_name" name="code_name" required>
      </div>
      <div class="form-group">
        <label for="code_descript">Описание:</label>
        <input type="text" class="form-control" id="code_descript" name="code_descript" required>
      </div>
      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">Логика</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="TRUE" name="TRUE">
                <label class="form-check-label" for="TRUE">TRUE</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="DIAL" name="DIAL">
                <label class="form-check-label" for="DIAL">Набор</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="PRESENTATION" name="PRESENTATION" >
                <label class="form-check-label" for="PRESENTATION">Презентация</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="CONSENT" name="CONSENT" >
                <label class="form-check-label" for="CONSENT">Согласие</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="CONSENT_OP" name="CONSENT_OP">
                <label class="form-check-label" for="CONSENT_OP">Согласие дополнительное</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="NotShow" name="NotShow" >
                <label class="form-check-label" for="NotShow">Не показывать</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="IsNotFinal" name="IsNotFinal" >
                <label class="form-check-label" for="IsNotFinal">Финальный</label>
              </div>
            </div>
          </div>
        </fieldset>
      @include('admin.layouts.errors')

      <button type="submit" class="btn btn-primary">Сохранить</button>
    </form> 
  </div>
@endsection