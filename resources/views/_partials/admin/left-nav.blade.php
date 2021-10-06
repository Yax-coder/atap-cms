 **********************************************************************************************************************************************************
MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
  <div id="sidebar"  class="nav-collapse ">
      <!-- sidebar menu start-->
      <ul class="sidebar-menu" id="nav-accordion">
      
          <p class="centered"><a href="{{ url('profile') }}"><img src="/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
          <h5 class="centered">
            @if(Auth::user()->account_type == 1)
            {{ Auth::user()->lecturer->name }}
            <br><small>Admin</small>
            @elseif(Auth::user()->account_type == 2)
            {{ Auth::user()->lecturer->name }}
            <br><small>Lecturer</small>
            @else
            {{ Auth::user()->student->name }}
            <br><small>Student</small>
            @endif
          </h5>
            
          {{-- <li class="mt" data-page="dashboard">
              <a class="" href="{{ url('/dashboard') }}">
                  <i class="fa fa-dashboard"></i>
                  <span>Dashboard</span>
              </a>
          </li> --}}
          
          @if(Auth::user()->account_type == 1)
          <li class="" data-page="departments">
              <a class="" href="{{ url('/departments') }}">
                  <i class="fa fa-building"></i>
                  <span>Departments</span>
              </a>
          </li>
          @endif
            
          <li class="" data-page="courses">
              <a class="" href="{{ url('/courses') }}">
                  <i class="fa fa-dashboard"></i>
                  <span>Courses</span>
              </a>
          </li>
          
          @if(Auth::user()->account_type == 1)
          <li class="" data-page="lecturers">
              <a class="" href="{{ url('/lecturers') }}">
                  <i class="fa fa-dashboard"></i>
                  <span>Lecturers</span>
              </a>
          </li>
          @endif
          
          @if(Auth::user()->account_type == 1)
          <li class="" data-page="students">
              <a class="" href="{{ url('/students') }}">
                  <i class="fa fa-users"></i>
                  <span>Students</span>
              </a>
          </li>
          @endif
            
          <li class="" data-page="assignments">
              <a class="" href="{{ url('/assignments') }}">
                  <i class="fa fa-book"></i>
                  <span>Assignments</span>
              </a>
          </li>
            
          {{-- <li class="" data-page="profile">
              <a class="" href="{{ url('/profile') }}">
                  <i class="fa fa-user"></i>
                  <span>Profile</span>
              </a>
          </li> --}}
          
          @if(Auth::user()->account_type == 1)
          <li class="" data-page="administration">
              <a class="" href="{{ url('/administration/users') }}">
                  <i class="fa fa-lock"></i>
                  <span>Administration</span>
              </a>
          </li>
          @endif
            
          

          <!-- <li class="sub-menu">
              <a href="javascript:;" >
                  <i class="fa fa-desktop"></i>
                  <span>UI Elements</span>
              </a>
              <ul class="sub">
                  <li><a  href="general.html">General</a></li>
                  <li><a  href="buttons.html">Buttons</a></li>
                  <li><a  href="panels.html">Panels</a></li>
              </ul>
          </li>
          
          <li class="sub-menu">
              <a href="javascript:;" >
                  <i class="fa fa-cogs"></i>
                  <span>Components</span>
              </a>
              <ul class="sub">
                  <li><a  href="calendar.html">Calendar</a></li>
                  <li><a  href="gallery.html">Gallery</a></li>
                  <li><a  href="todo_list.html">Todo List</a></li>
              </ul>
          </li>
          <li class="sub-menu">
              <a href="javascript:;" >
                  <i class="fa fa-book"></i>
                  <span>Extra Pages</span>
              </a>
              <ul class="sub">
                  <li><a  href="blank.html">Blank Page</a></li>
                  <li><a  href="login.html">Login</a></li>
                  <li><a  href="lock_screen.html">Lock Screen</a></li>
              </ul>
          </li>
          <li class="sub-menu">
              <a href="javascript:;" >
                  <i class="fa fa-tasks"></i>
                  <span>Forms</span>
              </a>
              <ul class="sub">
                  <li><a  href="form_component.html">Form Components</a></li>
              </ul>
          </li>
          <li class="sub-menu">
              <a href="javascript:;" >
                  <i class="fa fa-th"></i>
                  <span>Data Tables</span>
              </a>
              <ul class="sub">
                  <li><a  href="basic_table.html">Basic Table</a></li>
                  <li><a  href="responsive_table.html">Responsive Table</a></li>
              </ul>
          </li>
          <li class="sub-menu">
              <a href="javascript:;" >
                  <i class=" fa fa-bar-chart-o"></i>
                  <span>Charts</span>
              </a>
              <ul class="sub">
                  <li><a  href="morris.html">Morris</a></li>
                  <li><a  href="chartjs.html">Chartjs</a></li>
              </ul>
          </li> -->

      </ul>
      <!-- sidebar menu end-->
  </div>
</aside>
<!--sidebar end