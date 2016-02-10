
<div class="row">
  <div class="col-md-6">
    <form id="add-new-report" class="form-horizontal" style="display:none" form-mode="add">
      <fieldset>
        <legend>Внесување на нов извештај</legend>
        <div class="form-group">
          <label for="dt_1" class="col-sm-2 control-label">Датум</label>
            <div class="col-xs-10">
              <div class="input-group date" id="dt_1">
                <input type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
              </div>
            </div>
        </div>
        <div class="form-group">
          <label for="select" class="col-xs-2 control-label">Вид</label>
          <div class="col-xs-10">

            <select class="form-control" id="select">
              @if($report_types != null)
                @foreach($report_types as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
              @endif
            </select>

          </div>
        </div>
        <div class="form-group">
          <label for="list_group" class="col-xs-2 control-label">Опис</label>
          <div class="col-xs-10">
            <table class="table">
              <tbody id="list_group">
                <tr>
                  <td class="col-xs-11 list-element" list-id=1></td>
                  <td class="col-xs-1"><button type="button" class="btn btn-default pull-right" id="btn_add_list" ><i class="glyphicon glyphicon-plus"></i></button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-10 col-xs-offset-2">
            <button type="reset" class="btn btn-default" id="btn_reset">Откажи</button>
            <button type="button" class="btn btn-primary" id="btn_send">Внеси</button>
            <button type="button" class="btn btn-primary" id="btn_update">Промени</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
