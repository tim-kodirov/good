<ul class="nav nav-pills nav-stacked">
  <li class="{{Request::is('office') ? 'active' : ''}}"><a href="{{ route('store') }}">Остаток</a></li>
  <li class="{{Request::is('office/export') ? 'active' : ''}}"><a href="{{ route('store.export') }}">Расходы</a></li>
  <li class="{{Request::is('office/import') ? 'active' : ''}}"><a href="{{ route('store.import') }}">Приходы</a></li>
</ul>