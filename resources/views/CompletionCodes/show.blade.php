@extends ('layouts.master')
@section('content')
<h1>{{$CompletionCode->Name}}</h1> 
<hr>
  <div class="container">
    <form method="POST" action="/lk/CompletionCodes/{{$task->id}}/{{$CompletionCode->Result}}">

      {{ csrf_field() }}

      <div class="form-group">
        <label for="Name">Название:</label>
        <input type="text" class="form-control" id="Name" name="Name" value="{{ $CompletionCode->Name }}" required>
      </div>
      <div class="form-group">
        <label for="code_name">Результат:</label>
        <input type="text" class="form-control" id="code_name" name="code_name" value="{{ $CompletionCode->code_name }}" required>
      </div>
      <div class="form-group">
        <label for="code_descript">Описание:</label>
        <input type="text" class="form-control" id="code_descript" name="code_descript" value="{{ $CompletionCode->code_descript }}" required>
      </div>
      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">Логика</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="TRUE" name="TRUE" {{$CompletionCode->TRUE == true ? 'checked': ''}}>
                <label class="form-check-label" for="TRUE">TRUE</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="DIAL" name="DIAL" {{$CompletionCode->DIAL == true ? 'checked': ''}}>
                <label class="form-check-label" for="DIAL">Набор</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="PRESENTATION" name="PRESENTATION" {{$CompletionCode->PRESENTATION == true ? 'checked': ''}}>
                <label class="form-check-label" for="PRESENTATION">Презентация</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="CONSENT" name="CONSENT" {{$CompletionCode->CONSENT == true ? 'checked': ''}}>
                <label class="form-check-label" for="CONSENT">Согласие</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="CONSENT_OP" name="CONSENT_OP" {{$CompletionCode->CONSENT_OP == true ? 'checked': ''}}>
                <label class="form-check-label" for="CONSENT_OP">Согласие дополнительное</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="NotShow" name="NotShow" {{$CompletionCode->NotShow == true ? 'checked': ''}}>
                <label class="form-check-label" for="NotShow">Не показывать</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="IsNotFinal" name="IsNotFinal" {{$CompletionCode->IsNotFinal == true ? 'checked': ''}}>
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