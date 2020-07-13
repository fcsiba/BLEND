<div class="site-menubar-body">
  <div>
    <div>
      <ul class="site-menu" data-plugin="menu">
        <li class="site-menu-item {{ request()->is('student-dashboard') ? 'active' : '' }}">
            <a href="{{ route('students.index') }}">
                <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                <span class="site-menu-title">Dashboard</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('student-course-list') ? 'active' : '' }}">
            <a href="{{ route('students.pastcourses') }}">
                <i class="site-menu-icon fas fa-chalkboard" aria-hidden="true"></i>
                <span class="site-menu-title"> Past Completed Courses</span>
            </a>
        </li>
      </ul>

      
    </div>
  </div>
</div>