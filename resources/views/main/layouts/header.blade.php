<div class="header">

        <!-- Logo -->
        <div class="header-left">
          
        </div>
        <!-- /Logo -->

        <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

        <!-- Header Menu -->
        <ul class="nav user-menu">

            <li class="nav-item dropdown has-arrow main-drop">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <span>{{Auth::user()->name}}</span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/logout">გასვლა</a>
                </div>
            </li>
        </ul>
        <!-- /Header Menu -->

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                    class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="login.html">გასვლა</a>
            </div>
        </div>
        <!-- /Mobile Menu -->

    </div>
    <!-- /Header -->

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="active">
                        <a href="{{ route('employee.index')}}"><i class="la la-ticket"></i> <span>თანამშრომლები</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('branch.index')}}"><i class="la la-ticket"></i> <span>ფილიალები</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('department.index')}}"><i class="la la-ticket"></i> <span>დეპარტამენტებია</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('sms.index')}}"><i class="la la-ticket"></i> <span>შეტყობინების გაგზავნა</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Sidebar -->