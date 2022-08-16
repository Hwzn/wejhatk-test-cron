<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            @if(auth('admin')->check())
                @include('dashboard.layouts.main-sidebar.admin-main-sidebar')
            @elseif(auth('student')->check())
               @include('dashboard.layouts.main-sidebar.student-main-sidebar')
            @elseif(auth('teacher')->check())
               @include('dashboard.layouts.main-sidebar.teacher-main-sidebar')
            @elseif(auth('parent')->check())
               @include('dashboard.layouts.main-sidebar.parent-main-sidebar')
            @endif
        </div>

        <!-- Left Sidebar End-->

        <!--=================================
