<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>TajaKhana </title>

    <!-- Bootstrap -->
    <link href="{{asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('backend/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('backend/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('backend/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{asset('backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('backend/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('backend/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('backend/build/css/custom.min.css')}}" rel="stylesheet">

    @stack('styles')
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{route('home')}}" class="site_title"><i class="fa fa-paw"></i> <span>TajaKhana</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{Storage::disk('uploads')->url('user.png')}}" alt="User Image" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{Auth::user()->name}}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('user.index')}}">View Users</a></li>
                      <li><a href="{{route('user.create')}}">Create User</a></li>
                    </ul>
                  </li>
                  {{-- <li><a><i class="fa fa-ban"></i> Permission <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('permission.index')}}">View Permissions</a></li>
                        <li><a href="{{route('permission.create')}}">Create Permission</a></li>
                    </ul>
                  </li> --}}
                  <li><a><i class="fa fa-tag"></i> Role<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('role.index')}}">View Roles</a></li>
                      <li><a href="{{route('role.create')}}">Create Role</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-home"></i> Branchs<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('branch.index') }}">View Branches</a></li>
                      <li><a href="{{ route('branch.create') }}">Create Branch</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-user"></i> Chefs/Employees<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('chef.index') }}">View Employees</a></li>
                      <li><a href="{{ route('chef.create') }}">Create Employee</a></li>
                    </ul>
                  </li>
                  <li><a href="{{ route('category.index') }}"><i class="fa fa-list"></i> Item Categories</a></li>
                  <li><a><i class="fa fa-chevron-circle-down"></i> Menu Items<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('menuitem.index')}}">View Items</a></li>
                      <li><a href="{{route('combomenu.index')}}">View Combo Menus</a></li>
                      <li><a href="{{route('combomenuRequest.index')}}">View Combo Menu Requests</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-exchange"></i>Orders <span
                    class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('order.index') }}">All Orders</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-rss-square"></i>Blogs <span
                    class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('blogcategory.index') }}">Blog Categories</a></li>
                        <li><a href="{{ route('blog.index') }}">Our Blogs</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-book"></i>Cookbook <span
                    class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('cookbookcategory.index') }}">Cookbook Categories</a></li>
                        <li><a href="{{ route('cookbookitem.index') }}">Cookbook Items</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>Additional</h3>
                <ul class="nav side-menu">
                    <li><a href="{{ route('driver.index') }}"><i class="fa fa-truck"></i> Drivers</a></li>
                    <li><a href="{{ route('review.index') }}"><i class="fa fa-star"></i> Reviews</a></li>
                    <li><a href="{{route('subscriber.index')}}"><i class="fa fa-male"></i> Subscribers</a></li>
                    <li><a><i class="fa fa-cog"></i> Settings <span
                        class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('setting.index') }}">General</a></li>
                            <li><a href="{{ route('slider.index') }}">Slider Settings</a></li>
                        </ul>
                    </li>
                  {{-- <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li> --}}
                  {{-- <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li> --}}
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            {{-- <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div> --}}
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{Storage::disk('uploads')->url('user.png')}}" alt="User Image">{{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    {{-- <a class="dropdown-item"  href="javascript:;"> Profile</a>
                      <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a> --}}
                  {{-- <a class="dropdown-item"  href="javascript:;">Help</a> --}}
                    <a class="dropdown-item"  href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                                  <i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </li>

                @php
                    $newnotifications = DB::table('notifications')->where('is_read', 0)->count();
                    $newuser = DB::table('notifications')->where('type','App\Notifications\NewUserNotification')->where('is_read', 0)->count();
                    $neworder = DB::table('notifications')->where('type','App\Notifications\NewOrderNotification')->where('is_read', 0)->count();
                    $newcomborequest = DB::table('notifications')->where('type','App\Notifications\ComboRequestNotification')->where('is_read', 0)->count();
                @endphp
                <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="badge bg-green">{{$newnotifications}}</span>
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                      @if ($newuser > 0)
                        <li class="nav-item">
                            <a class="dropdown-item" href="{{route('user.index')}}">

                                <span>
                                    <i class="fa fa-user"></i><span style="font-size: 15px;"> &nbsp;<b>{{$newuser}}</b> new user has just registerd.</span>
                                </span>
                            </a>
                        </li>
                      @endif
                      @if ($neworder > 0)
                        <li class="nav-item">
                            <a class="dropdown-item" href="{{route('order.index')}}">
                                <span>
                                    <i class="fa fa-cutlery"></i><span style="font-size: 15px;"> &nbsp;<b>{{$neworder}}</b> new order has been received.</span>
                                </span>
                            </a>
                        </li>
                      @endif
                      @if ($newcomborequest > 0)
                        <li class="nav-item">
                            <a class="dropdown-item" href="{{route('combomenuRequest.index')}}">
                                <span>
                                    <i class="fa fa-cutlery"></i><span style="font-size: 15px;"> &nbsp;<b>{{$newcomborequest}}</b> new combo menu request has been received.</span>
                                </span>
                            </a>
                        </li>
                      @endif


                      @if ($newnotifications == 0)
                        <li class="nav-item">
                            <div class="text-center">
                            <a class="dropdown-item">
                                <strong>No new notifications</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            </div>
                        </li>

                      @endif

                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        @yield('content')
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <a href="https://tajakhana.tajamandi.com" target="_blank">TajaKhana</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('backend/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('backend/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('backend/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('backend/vendors/nprogress/nprogress.js')}}"></script>
    <!-- Chart.js -->
    <script src="{{asset('backend/vendors/Chart.js/dist/Chart.min.js')}}"></script>
    <!-- gauge.js -->
    <script src="{{asset('backend/vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('backend/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('backend/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('backend/vendors/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('backend/vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('backend/vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('backend/vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('backend//vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('backend/vendors/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <script src="{{asset('backend/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('backend/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('backend/vendors/flot.curvedlines/curvedLines.js')}}"></script>
    <!-- DateJS -->
    <script src="{{asset('backend/vendors/DateJS/build/date.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('backend/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('backend/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('backend/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('backend/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('backend/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('backend/build/js/custom.min.js')}}"></script>
    @stack('scripts')

  </body>
</html>
