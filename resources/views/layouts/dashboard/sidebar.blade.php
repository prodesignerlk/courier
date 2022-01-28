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
                <a class="nav-link" data-toggle="collapse" href="#odr_mng" role="button" aria-expanded="false" aria-controls="emails" id="req-ex">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Order Management</span> &nbsp;
                    <div class="spinner-grow spinner-grow-sm text-white invisible pending-header-req" role="status">
                        <span class="badge badge-light badge-pill bg-warning text-black text-header-indicater"></span>
                    </div>
                    <i class="link-arrow" data-feather="chevron-down" id="toggle-indicater"></i>
                </a>
                <div class="collapse" id="odr_mng">
                    <ul class="nav sub-menu">
                        @php
                            //Waybill reservation feature check
                            $org = Auth::user()->org_id;
                            $waybill_option = App\Models\Setting::where([['org_id', $org], ['feature', 'waybill_option']])->first()->waybill_option;
                
                        @endphp

                        @if ($waybill_option->option == 'Manual_range' || $waybill_option->option == 'Manual_qnt')
                            @can('waybill-reservation.view')
                                <li class="nav-item">
                                    <a href="{{route('waybill-reservation')}}" class="nav-link">Waybill Reservation</a>
                                </li>
                            @endcan
                        @endif
                        <li class="nav-item">
                            <a href="{{route('create-order')}}" class="nav-link">Create Order</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('my-orders')}}" class="nav-link">My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('barcode-print')}}" class="nav-link">Barcode Print</a>
                        </li>
                    </ul>
                </div>
            </li>
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
