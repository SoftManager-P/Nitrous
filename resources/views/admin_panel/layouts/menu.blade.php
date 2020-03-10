<li class="has-submenu">
    <a href="{{url("admin/")}}">
        <i class="ti-dashboard"></i>
        <span>Dashboard</span>
    </a>
</li>

<li {!! (Request::is('admin/competition') || Request::is('admin/competition/create')  || Request::is('admin/competition/*') ? 'class="active has-submenu"' : 'class= "has-submenu"')!!}>
    <a href="#">
        <i class="ti-list"></i>
        <span class="title">COMPETITIONS</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="submenu">
        <li {!! (Request::is('admin/competition') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/competition') }}">
                <i class="fa fa-angle-double-right"></i>
                Competitions
            </a>
        </li>
        <li {!! (Request::is('admin/competition/getInfo/0') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/competition/getInfo/0') }}">
                <i class="fa fa-angle-double-right"></i>
                Add Competition
            </a>
        </li>
    </ul>
</li>

<li class="has-submenu @if(Request::is('admin/past/*')) active @endif">
    <a href="{{url("admin/past")}}">
        <i class="ti-dashboard"></i>
        <span>PAST WINNERS</span>
    </a>
</li>
<li {!! (Request::is('admin/order') || Request::is('admin/order/create')  || Request::is('admin/order/*') ?'class="active has-submenu"' : 'class= "has-submenu"') !!}>
    <a href="#">
        <i class="ti-receipt"></i>
        <span class="title">ORDERS</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="submenu">
        <li {!! (Request::is('admin/order') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/order') }}">
                <i class="fa fa-angle-double-right"></i>
                Orders
            </a>
        </li>
        <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!} class = "hidden">
            <a href="{{ URL::to('admin/users/create') }}">
                <i class="fa fa-angle-double-right"></i>
                Statistis
            </a>
        </li>
    </ul>
</li>

<li {!! (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/user_profile') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'class="active has-submenu"' : 'class= "has-submenu"') !!}>
    <a href="#">
        <i class="ti-user"></i>
        <span >Users</span>
    </a>
    <ul class="submenu">
        <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/users') }}">
                <i class="fa fa-angle-double-right"></i>
                Users
            </a>
        </li>
        <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/users/create') }}">
                <i class="fa fa-angle-double-right"></i>
                Add New User
            </a>
        </li>
        <li {!! (Request::is('admin/deleted_users') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/deleted_users') }}">
                <i class="fa fa-angle-double-right"></i>
                Deleted Users
            </a>
        </li>
    </ul>
</li>
<li class="has-submenu @if(Request::is('admin/promoCode/*')) active @endif">
    <a href="{{url("admin/promoCode")}}">
        <i class="ion-ios7-albums-outline"></i>
        <span>PROMO CODE</span>
    </a>
</li>




