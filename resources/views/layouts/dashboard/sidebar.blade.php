<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Courier<span> Pro</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Send Email</span>
                </a>
            </li>
            <li class="nav-item nav-category">Student Management</li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails" id="req-ex">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Student Requests</span> &nbsp;
                    <div class="spinner-grow spinner-grow-sm text-white invisible pending-header-req" role="status">
                        <span class="badge badge-light badge-pill bg-warning text-black text-header-indicater"></span>
                    </div>
                    <i class="link-arrow" data-feather="chevron-down" id="toggle-indicater"></i>
                </a>
                <div class="collapse" id="emails">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Pending Requests &nbsp;
                                <div class="spinner-grow spinner-grow-sm text-white invisible pending-sub-req" role="status">
                                    <span class="badge badge-light badge-pill bg-danger text-white text-sub-indicater"></span>
                                </div>
                            </a>
                            
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Selected Requests</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Selected Under Condition</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Rejected Requests</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item nav-category">User Management</li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#userser" role="button" aria-expanded="false" aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">User Settings</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="userser">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Staff</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Agents</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item nav-category">Settings</li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#settings" role="button" aria-expanded="false" aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Settings</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="settings">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('sms-settings')}}" class="nav-link">SMS Settings</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
