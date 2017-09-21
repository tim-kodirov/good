<ul class="nav nav-pills nav-stacked">
  <li class="{{Request::is('office') ? 'active' : ''}}"><a href="{{ route('office') }}">Остаток</a></li>
  <li class="{{Request::is('office/export') ? 'active' : ''}}"><a href="{{ route('office.export') }}">Расходы</a></li>
  <li class="{{Request::is('office/import') ? 'active' : ''}}"><a href="{{ route('office.import') }}">Приходы</a></li>
</ul>