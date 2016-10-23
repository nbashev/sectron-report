@extends('layouts.master')

@section('content')

<div class="container">

	<div class="row">
		<div class="col-md-12">

			<div class="tabbable" >
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#reports" aria-controls="reports" role="tab" data-toggle="tab">Тековни извештаи</a></li>
					<li role="presentation"><a href="#reports-period" aria-controls="reports-period" role="tab" data-toggle="tab">Извештаи за период</a></li>
				</ul>

				<div class="tab-content">

					<div role="tabpanel" class="tab-pane active" id="reports">

						@include('layouts.partials.forms.add-new-report')
						{{-- {{dd($report_types[0]->name)}} --}}
						<table id="table_t1" class="table table-condensed"
								data-classes="table-no-bordered"
								data-search="true"
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

						<ul id="context-menu" class="dropdown-menu">
						    <li data-item="edit"><a>Измени</a></li>
						    <li data-item="delete"><a>Избриши</a></li>
						    <li class="divider"></li>
						    <li data-item="add"><a>Внеси нов</a></li>
						</ul>

						<hr>
					</div>

					<div role="tabpanel" class="tab-pane" id="reports-period">
						<br>
						<form class="form-horizontal">
							<div class="form-group">
							{{-- <label for="dt_p" class="pull-left col-xs-3 control-label">Одберете период на извештаите:</label> --}}
								<div class="col-xs-4">
									<div id="dt_p" class="input-group input-daterange">
									    <input id="from_period" type="text" class="form-control">
									    <span class="input-group-addon"> до </span>
									    <input id="to_period" type="text" class="form-control">
									</div>
								</div>
								<div class="col-xs-1 col-offset-xs-1">
						            <button type="button" id="btn_get_reports" class="btn btn-default">Пребарај</button>
								</div>
								<div class="col-xs-7 pull-righ-div">
									<label class="pull-right col-xs-7 control-label">Пронајдени се вкупно: <span id="rows_count_table" ></span> записи</label>
								</div>
							</div>
						</form>

						<table id="table_t2" class="table table-condensed"
								data-classes="table-no-bordered"
								data-locale="mk-MK"
								data-search="true"
								style="display: none">
							<thead>
								<tr>
									<th data-field="user_name">Вработен</th>
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
			<!--/Tabbable-->

		</div>
	</div>

<div id="modal_confirm" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Бришење на извештај</h4>
      </div>
      <div class="modal-body">
        <p>Дали сте сигурни дека сакате да го избришете одбраниот извештај</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_modal_no" class="btn btn-default btn-sm" data-dismiss="modal">НЕ</button>
        <button type="button" id="btn_modal_yes" class="btn btn-danger btn-sm">ДА</button>
      </div>
    </div>
  </div>
</div>

</div>
@endsection

@section('styles')
<style type="text/css">
	
	#rows_count_table {
		color: red;
	}


</style>
@endsection

@section('scripts')
<script type="text/javascript">


$(document).ready(function(){

moment.locale('mk');
$('#rows_count_table').parent().hide()

// globaly userd vars
$table = $('#table_t1');
from_period = '';
to_period = '';
$table_range = $('#table_t2');
reports = {!! json_encode($reports->toArray()) !!};
weekNum = {{$weekNum}};
list_to_delete = []
list_id = 1;
current_row = 0;
// --------------------

// initialize the datepickers
$('.input-group.date').datepicker({
    todayBtn: "linked",
    language: "mk",
    autoclose: true,
    weekStart: 1,
    todayHighlight: true,
    daysOfWeekHighlighted: "0,6",
});
$('#dt_1 input').val(moment().format('DD.MM.YYYY'))

// initial fill of dates range
$('#from_period').val(moment().startOf('year').format('DD.MM.YYYY'));
$('#to_period').val(moment().format('DD.MM.YYYY'));


$('#dt_p').each(function() {
    $(this).datepicker({
    	todayBtn: "linked",
	    language: "mk",
	    autoclose: true,
	    weekStart: 1,
	    weekStart: 1,
    	todayHighlight: true,
    	daysOfWeekHighlighted: "0,6",
	});
});

$('#from_period').datepicker('update');
$('#to_period').datepicker('update');

from_period = moment($('#from_period').val(), 'DD.MM.YYYY').format("YYYY-MM-DD");
to_period = moment($('#to_period').val(), 'DD.MM.YYYY').format("YYYY-MM-DD");

$('#from_period').datepicker({
	setDate: moment().startOf('year').format('DD.MM.YYYY')
}).on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        from_period = moment($('#from_period').val(), 'DD.MM.YYYY').format("YYYY-MM-DD");
        $('#to_period').datepicker('setStartDate', startDate);
    });

$('#to_period').datepicker({
	setDate: moment().format('DD.MM.YYYY')
}).on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        to_period = moment($('#to_period').val(), 'DD.MM.YYYY').format("YYYY-MM-DD");
    });


// store values from datepicker
// $('#from_period').on('change', function(){
// 	from_period = moment($('#from_period').val(), 'DD.MM.YYYY').format("YYYY-MM-DD");
// 	console.log(from_period)
// })
// $('#to_period').on('change', function(){
// 	to_period = moment($('#to_period').val(), 'DD.MM.YYYY').format("YYYY-MM-DD");
// 	console.log(to_period)
// })


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

// context menu functionality
$table.bootstrapTable({data:reports,
	contextMenu: '#context-menu',
    contextMenuAutoClickRow: true,
    // onClickRow: function(row, $el){
    //    $('#table_t1').find('.success').removeClass('success');
    //    $el.addClass('success');
    // },
    onContextMenuItem: function(row, $el){
       if($el.data("item") == "edit"){
           console.log("Edit: " + row.type_name + ' ' + row.datetime + ' ' + row);
           fn_edit_item(row);
       } else if($el.data("item") == "delete"){
           console.log("Delete: " + row.type_name + ' ' + row.datetime + ' ' + row);
           fn_delete_item(row, event)
       } else if($el.data("item") == "add"){
           console.log("Add new");
           prep_to_add_report();
       }
    }
});

// Functions for context menu
// ----------------------------------

function fn_edit_item(row) {
	// console.log(row)
	current_row = row.id
	$("form").attr("form-mode", "edit")
	$("form legend").text("Промена на извештај")
	//
	$table.bootstrapTable('destroy');
	$table.remove();

	$('#add-new-report').css('margin-top', '50px')
	$("#btn_send").hide()

	// fill the fields
	$('#dt_1 input').val(row.datetime_org)
	$("#dt_1 input").attr('disabled', true)
	$('#select option[value="'+row.type.id+'"]').prop('selected', true)
	$("#list_group td[list-id=1]").html(row.lists[0].text)
	// update to the aproppriate list-id
	$("#list_group td[list-id=1]").attr("list-id", row.lists[0].id)

	// copy original list and remove the first item
	new_list = row.lists
	new_list.shift()
	console.log(new_list)

	$.each(new_list, function(index, val) {
		console.log(val.text)
		$("#list_group").append("<tr><td class=\"col-lg-11 list-element\" list-id="+val.id+">"+ val.text +"</td><td class=\"col-lg-1\"><button type=\"button\" class=\"btn btn-default btn_minus\" btn-id="+ val.id + "><i class=\"glyphicon glyphicon-minus\"></i></button></td></tr>")
	})

	// show the populated form
	$('#add-new-report').show()

}

function fn_delete_item(row) {
	current_row = row.id
	$('#modal_confirm').modal('show')
}
// bind event for confirm delition
$('#btn_modal_yes').on('click', function() {
	$('#modal_confirm').modal('hide')

	$.ajax({
	    	type: 'POST',
	    	url: '/delete/' + current_row,
	    	success:function(data){
	    		console.log(data)
	    		window.location.reload();
	    	}
	    })
})

$('#context-menu').hover(function() {
    $(this).css('cursor','pointer');
});


$(".fixed-table-toolbar").append("<div class=\"pull-left\"><h3>Календарска недела: " + weekNum + "</h3></div>")

$("#add_report").on('click', function(){
	$('a[data-toggle="tab"]:first').tab('show')
	prep_to_add_report();
})

function prep_to_add_report() {
	$("#table_t1").bootstrapTable('destroy');
	$("#table_t1").remove();

	// change the form mode and title
	$("form").attr("form-mode", "add")
	$("form legend").text("Внесување на нов извештај")

	$('#add-new-report').css('margin-top', '50px')
	$("#btn_update").hide()
	$('#add-new-report').show()
}

// ----------------------------------------------------------------------
//				MODAL
// ----------------------------------------------------------------------


// ----------------------------------------------------------------------
//			E V E N T S
// ----------------------------------------------------------------------

$(document.body).on("click", ".list-element", function(event) {
	console.log(event.target)
	$(event.target).attr("contentEditable", true);
})
$(document.body).on("blur", ".list-element", function(event) {
	$(event.target).attr("contentEditable", false);
})
$(document.body).on("copy", function(event) {
	console.log(event.target)
})

// if search box is empty, clear the fields
$(document.body).on("blur", ".search input:eq(1)", function(event) {
	if($(".search input:eq(1)").val() == "") {
		$(".hidden-datetime").css('visibility', 'hidden');
		$(".hidden-username").css('visibility', 'hidden');
		console.log("empty search")
	}
})

$(document.body).on("input", ".search input:eq(1)", function(event) {
	// console.log("input:" + this.value)
	$('#rows_count_table').text($table_range.bootstrapTable('getData').length)
})

$('#table_t2').on('search.bs.table', function () {
    console.log('search event occured...')
	$('#rows_count_table').parent().show()
    $('#rows_count_table').text($table_range.bootstrapTable('getData').length)
});


// ----------------------------------------------------------------------

// this button will add more rows of list table
$("#btn_add_list").on("click", function() {
	list_id++;
	var form_mode = ($("form").attr("form-mode") == "edit") ? 0 : list_id
	$("#list_group").append("<tr><td class=\"col-lg-11 list-element\" list-id="+form_mode+"></td><td class=\"col-lg-1\"><button type=\"button\" class=\"btn btn-default btn_minus\" btn-id="+ form_mode + "><i class=\"glyphicon glyphicon-minus\"></i></button></td></tr>")
})

// removes row of items table
$(document.body).on("click", ".btn_minus", function(event) {
	if(event.target.type != "button") {
		del_id = $(event.target).parent().attr('btn-id')
	} else {
		del_id = $(event.target).attr('btn-id')
	}
	if($("form").attr("form-mode") == "edit" && del_id != 0) {
		// console.log(del_id + " ")
		list_to_delete.push(del_id);
	}
	$("#list_group [list-id="+ del_id +"]").closest('tr').remove()

})

// get input data and add it
function get_input_data() {
	var send_data = {}
	var datetimeval = moment($('#dt_1 input').val(), "DD.MM.YYYY");
	send_data['datetime'] = datetimeval.format("YYYY-MM-DD HH:mm:ss")
	send_data['type_id'] = $("#select option:selected").val()
	// console.log(send_data)
	var list = []
	var list_to_update = []
	var list_new = []
	$('#list_group tr').each(function (index, val) {

		var text = $(this).find("td:first").text()
		if(text.trim() != "") {
			if($(this).find("td:first").attr("list-id") == 0) {
				list_new.push($(this).find("td:first").text());
			} else {
				list_to_update.push($(this).find("td:first").attr("list-id"))
				// console.log($(this).find("td:first").clone().children().remove().end().text())
				list.push($(this).find("td:first").text())
			}
		}
	})
	send_data['list'] = list
	// used for update + add new
	send_data['list_new'] = list_new
	send_data['list_to_update'] = list_to_update
	send_data['list_to_delete'] = list_to_delete

	JSON.stringify(send_data)
	return send_data
}

$("#btn_update").on("click", function() {
	// console.log(get_input_data())
	$.ajax({
	    	type: 'POST',
	    	url: '/edit/' + current_row,
	    	data: {data:get_input_data()},
	    	success:function(data){
	    		console.log(data)
	    		window.location.reload();
	    	}
	    })
})

// send and store report and corespondig list in DB
$("#btn_send").on("click", function() {

	$.ajax({
	    	type: 'POST',
	    	url: '/',
	    	data: {data:get_input_data()},
	    	success:function(data){
	    		console.log(data)
	    		window.location.reload();
	    	}
	    })
})

$("#btn_reset").on("click", function() {
	get_input_data()
	window.location.reload();
})

// generate pdf report from time period
$("#generate_report").on("click", function(event) {
	event.preventDefault();
	if($('.nav-tabs .active a').attr('aria-controls') == "reports") {
		console.log('generate report')
		window.location.href = '/pdf';
	} else {
		console.log('generate period report')
		var period_url = '/pdf-period/' + from_period + '/' + to_period;
		window.location.href = period_url;
	}
})

// get the requested reports
$("#btn_get_reports").on('click', function() {

		
		// modifications to the find status label for search
		$('#rows_count_table').parent().show()
		$('#rows_count_table').parent().css({"padding-right":"0" })


		reports_range = [];
	    var get_url = '/reports/' + from_period + '/' + to_period;

	    $.ajax({
	    	type: 'GET',
	    	url: get_url,
	    	success:function(data){
				reports_range = data;

				// update the finded items
				$('#rows_count_table').text(reports_range.length)
	    		// console.log(reports_range.length)

				var prev_date = moment("2000-01-01").format("DD/MM/YYYY");
				$.each( reports_range, function( key, value ) {


					if(moment(value.datetime).format("DD.MM.YYYY") == prev_date)	{
						prev_date = moment(value.datetime).format("DD.MM.YYYY");
						value["datetime_org"] = moment(value.datetime).format("DD.MM.YYYY");
						value.datetime = "<span class=\"hidden-datetime\" style=\"visibility: hidden\">" + moment(value.datetime).format("dddd, DD.MM.YYYY") + "</span>";
						value["user_name"] = "<span class=\"hidden-username\" style=\"visibility: hidden\">" + value.user.name + "</span>";
					} else {
						prev_date = moment(value.datetime).format("DD.MM.YYYY");
						value["datetime_org"] = moment(value.datetime).format("DD.MM.YYYY");
						value.datetime = moment(value.datetime).format("dddd, DD.MM.YYYY");
						value["user_name"] = value.user.name
					}
					//value.datetime = moment(value.datetime).format("dddd, DD.MM.YYYY");
					value["type_name"] = value.type.name;
					var lista = value.lists;
					var text_lista = "";
					$.each( lista, function( key, value ) {
						text_lista +="<li>" + value.text + "</li>";
					})
					value["nova_lista"] = text_lista;
					// console.log(value.user.name)
				});

			$table_range.show();
			$table_range.bootstrapTable('destroy');

			$table_range.bootstrapTable({
				data:reports_range,
				onSearch: function (event) {
				        $(".hidden-datetime").css('visibility', 'visible');
						$(".hidden-username").css('visibility', 'visible');						
				    }
				});

	    	}
	    })

    	console.log(from_period + " * " + to_period);
    });


});

</script>
@endsection
