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
                <a class="nav-link" data-toggle="collapse" href="#odr_mng" role="button" aria-expanded="false"
                    aria-controls="emails" id="req-ex">
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
                            $waybill_option = App\Models\Setting::where([['feature', 'waybill_option']]);
                            if($waybill_option != null){
                                $waybill_option = $waybill_option->first()->waybill_option;
                            }else{
                                $waybill_option = 'null';
                            }

                        @endphp
                        @if ($waybill_option != null && ($waybill_option->option == 'Manual Range' || $waybill_option->option == 'Manual Qnt'))
                            @can('waybill-reservation.view')
                                <li class="nav-item">
                                    <a href="{{ route('waybill_reservation_post') }}" class="nav-link">Waybill
                                        Reservation</a>
                                </li>
                            @endcan
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('create_order_get') }}" class="nav-link">Create Order</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('my-orders') }}" class="nav-link">My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barcode-print') }}" class="nav-link">Barcode Print</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#stuClasses" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Process Operation</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="stuClasses">
                    <span class="link-title">Pickup</span>
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('pick_up_pending_orders_get') }}" class="nav-link">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pick_up_collected_orders_get') }}" class="nav-link">Collected</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pick_up_dispatched_orders_get') }}" class="nav-link">Dispatched</a>
                        </li>
                    </ul>
                    <span class="link-title">Distribute</span>
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('dis_collected_orders_get') }}" class="nav-link">Collect Processing Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dis_dispatched_orders_get') }}" class="nav-link">Dispatch Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dis_to_be_receive_orders_get') }}" class="nav-link">To Be Receive Packages</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dis_received_orders_get') }}" class="nav-link">Receive Orders</a>
                        </li>
                    </ul>
                    <span class="link-title">Handover</span>
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('hand_assign_to_agent_orders_get') }}" class="nav-link">Assign to Agent</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hand_delivered_orders_get') }}" class="nav-link">Delivered</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hand_reschedule_orders_get') }}" class="nav-link">Re-Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hand_deliver_fail_orders_get') }}" class="nav-link">Deliver Fails </a>
                        </li>
                    </ul>
                    <span class="link-title">Fails</span>
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('hand_miss_route_orders_get') }}" class="nav-link">Mis-Routs</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fail_re_route_orders_get') }}" class="nav-link">Re-route</a>
                        </li>
                        <li class="nav-item">
                            <a href="/fail/received-ho" class="nav-link">Received by HO (Return)</a>
                        </li>
                        <li class="nav-item">
                            <a href="/fail/return" class="nav-link">Return to Client (Return)</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#settings" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Finance</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="settings">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('daily_finance')}}" class="nav-link">Daily Finance</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('daily_Deposit_get')}}" class="nav-link">Daily Deposite</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('seller_invoice')}}" class="nav-link">Seller's Invoice</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#settings" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Settings</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="settings">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('sms-settings') }}" class="nav-link">SMS Settings</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('general-settings') }}" class="nav-link">General Settings</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('waybill_setting_get') }}" class="nav-link">Waybill Settings</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('default-settings') }}" class="nav-link">Default Settings</a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</nav>
