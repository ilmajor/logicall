@extends ('layouts.master')
@section('content')
  
  <h1>Претензии по FU</h1>
  <hr>

    <div class="table-responsive">
        <form method="POST" action="/lk/project/sberbankIndividualsController">

        {{ csrf_field() }}

            <div class="form-group">
                <label for="dataCall">Дата формирования заявки</label>
                <input type="date" class="form-control" id="dataCall" name="dataCall" aria-describedby="dataCall"  required>
            </div>
            <div class="form-group">
                <label for="webId" >№ заявки</label>
                <input type="text" class="form-control" name="webId" id="webId" required>

            </div>
            <div class="form-group">
                <label for="idClient" >ID предложения</label>
                <input type="text" class="form-control" name="idClient" id="idClient" required>

            </div>
            <div class="form-group">
                <label for="addressVsp" >№ ВСП:</label>
                <input type="text" class="form-control" name="addressVsp" id="addressVsp" required>

            </div>
            <div class="form-group">
                <label for="product">Продукт</label>
                <select class="form-control form-control" id="product" name="product" aria-describedby="product" required>
                    <option value=""></option>
                    <option value="Кредитные карты">Кредитные карты</option>
                    <option value="Премьер">Премьер</option>
                    <option value="Потребкредит">Потребкредит</option>
                </select>

            </div>
            <div class="form-group">
                <label for="validity" >Срок действия предложения по продукту</label>
                <input type="date" class="form-control" name="validity" id="validity" required>
            </div>
            <div class="form-group">
                <label for="appStatus" >Cтатус заявки, продукта</label>
                <input type="text" class="form-control" name="appStatus" id="appStatus" required>
            </div>

            <div class="form-group">
                <label for="comment">Суть проблемы:</label>
                <textarea class="form-control" id="comment" rows="3" name="comment"required></textarea>


            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form> 
    </div>


@endsection