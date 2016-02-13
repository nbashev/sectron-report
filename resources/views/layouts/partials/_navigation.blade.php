<nav id="master_nav" class="navbar navbar-default" style="margin-bottom: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<a class="navbar-brand" href="http://www.sectron.mk" >
        	<img alt="Brand" id="brand" src="/img/logo-circle.png">
      	</a>
    	{{-- <a href="#" class="pull-left"><img src="/img/sectron-brand.png"></a> --}}
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/">Преглед <span class="sr-only">(current)</span></a></li>
        <li><a id="add_report" href="#">Додади Извештај <span class="sr-only"></span></a></li>
        <li><a id="generate_report" href="/pdf">Генерирај Извештај &nbsp;<span class="glyphicon glyphicon-download-alt"></span></a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#!"><i class="fa fa-btn fa-sign-out"></i>Инфо</a></li>
            <li><a href="#!"><i class="fa fa-btn fa-sign-out"></i>Промени</a></li>
            <li class="divider"></li>
            <li><a href="/logout"><i class="fa fa-btn fa-sign-out"></i>Одјава</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>
<div id="nprogress-global" class="container-fluid">&nbsp;</div>

<style>
	#brand {
		max-height: 30px;
	}
</style>
