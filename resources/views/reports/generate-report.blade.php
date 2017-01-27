@extends('layouts.report-master')

@section('content')

<div class="container page">
	<div class="row">
		<div class="col-xs-6">
			<img src="/img/logo.png" alt="Sectron">
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="col-xs-12">
					<div class="pull-right"><h3>СЕКТРОН ИЗВЕШТАЈ</h3></div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="pull-right"><h4>Вработен: <strong>{{$user->name}}</strong></h4></div>
				</div>
				<div class="col-xs-12">
					<div class="pull-right"><p>датум: <span id="report_date">{{ $dt }}</span></p></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="pull-left"><h3>Календарска недела: <strong>{{$weekNum}}</strong></h3></div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12">

			<table id="table_t1" class="table table-condensed"
					data-classes="table-no-bordered"
					data-locale="mk-MK">
				<thead>
					<tr>
						<th data-field="datetime">Датум</th>
						<th data-field="type_name">Вид на работа</th>
						<th data-field="nova_lista" data-width="60%">Опис</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

		</div>
	</div>
</div>


@endsection

@section('scripts')
<script type="text/javascript">


$(document).ready(function(){

moment.locale('mk');

// globaly userd vars
$table = $('#table_t1');
reports = {!! json_encode($reports->toArray()) !!};
weekNum = {{$weekNum}};
dt = '{{$dt}}'
list_to_delete = []
list_id = 1;
current_row = 0;
// --------------------


var format_report_date = moment($("#report_date").text()).format("dddd, DD.MM.YYYY HH:mm:ss");
$("#report_date").text(format_report_date);

var prev_date = moment("2000-01-01").format("DD/MM/YYYY");

$.each( reports, function( key, value ) {
	if(moment(value.datetime).format("DD.MM.YYYY") == prev_date)	{
		prev_date = moment(value.datetime).format("DD.MM.YYYY");
		value["datetime_org"] = moment(value.datetime).format("DD.MM.YYYY");
		value.datetime = "<span class=\"hidden-datetime\" style=\"visibility: hidden\">" + moment(value.datetime).format("dddd, DD.MM.YYYY") + "</span>";
	} else {
		prev_date = moment(value.datetime).format("DD.MM.YYYY");
		value["datetime_org"] = moment(value.datetime).format("DD.MM.YYYY");
		value.datetime = moment(value.datetime).format("dddd, DD.MM.YYYY");
	}
	//value.datetime = moment(value.datetime).format("dddd, DD.MM.YYYY");
	value["type_name"] = value.type.name;
	var lista = value.lists;
	var text_lista = "";
	$.each( lista, function( key, value ) {
		text_lista +="<li>" + value.text + "</li>";
	})
	value["nova_lista"] = text_lista;
});

$table.bootstrapTable({data:reports});

});

</script>
@endsection
