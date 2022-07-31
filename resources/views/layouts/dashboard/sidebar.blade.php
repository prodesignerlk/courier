@php
    $user = \Illuminate\Support\Facades\Auth::user();
    $orderMgt = [$user->can('waybill-reservation.view'), $user->can('waybill-reservation.create'), $user->can('order.create'), $user->can('order.view')];
    $processOperation = [$user->can('pickup-pending.view'), $user->can('pickup-collected.view'), $user->can('pickup-collected.mark'), $user->can('pickup-dispatched.view'), $user->can('pickup-dispatched.mark')];
    $distribute = [
        $user->can('order-collected.view'),
        $user->can('order-collected.mark'),
        $user->can('order-dispatched.view'),
        $user->can('order-dispatch.mark'),
        $user->can('order-to-be-receive.view'),
        $user->can('order-received.view'),
        $user->can('order-received.mark')
    ];

    $handover = [
        $user->can('order-assign-to-agent.view'),
        $user->can('order-assign-to-agent.mark'),
        $user->can('order-delivered.view'),
        $user->can('order-delivered.mark'),
        $user->can('order-reschedule.view'),
        $user->can('order-reschedule.mark'),
        $user->can('order-deliver-fail.view')
    ];

    $fail = [
        $user->can('order-miss-route.view'),
        $user->can('order-re-route.view'),
        $user->can('order-re-route.mark'),
        $user->can('order-return-to-hub.view'),
        $user->can('order-return-to-hub.mark'),
        $user->can('order-return-to-seller.view'),
        $user->can('order-return-to-seller.mark')
    ];

    $finance = [
         $user->can('invoice.view'),
         $user->can('daily-invoice.view'),
         $user->can('daily-deposit.view'),
         $user->can('daily-deposit.confirm')
    ];

    $userMgt = [
         $user->can('user.view')
    ];

    $setting = [$user->can('setting.view'), $user->can('setting.create')];



@endphp
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{route('home')}}" class="sidebar-brand">
            Courier<span>Pro</span>
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
                <a href="{{route('home')}}" class="nav-link">
                    <i class="link-icon text-success" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            @php
                //Waybill reservation feature check
                $waybill_option = App\Models\Setting::where([['feature', 'waybill_option']]);
                if($waybill_option != null){
                    $waybill_option = $waybill_option->first()->waybill_option;
                }else{
                    $waybill_option = 'null';
                }
            @endphp

            @if(in_array('1', $orderMgt))
                <li class="nav-item nav-category">Order Management</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#orderMgt" role="button" aria-expanded="false"
                       aria-controls="emails" id="req-ex">
                        <i class="link-icon text-success" data-feather="send"></i>
                        <span class="link-title">Order Management&nbsp;</span>
                        <div class="text-white invisible pendingLeads" role="status">
                            <span
                                class="badge badge-light badge-pill bg-warning text-black text-header-pendingLeads"></span>
                        </div>
                        <i class="link-arrow" data-feather="chevron-down" id="toggle-indicator"></i>
                    </a>
                    <div class="collapse" id="orderMgt">
                        <ul class="nav sub-menu">
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
                            {{--<li class="nav-item">
                                <a href="{{ route('barcode-print') }}" class="nav-link">Barcode Print</a>
                            </li>--}}
                        </ul>
                    </div>
                </li>
            @endif

            @if(in_array('1', $processOperation))
                <li class="nav-item nav-category">Process Operation</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#processMgt" role="button" aria-expanded="false"
                       aria-controls="emails" id="req-ex">
                        <i class="link-icon text-success" data-feather="send"></i>
                        <span class="link-title">Process Operation&nbsp;</span>
                        <div class="text-white invisible pendingLeads" role="status">
                            <span
                                class="badge badge-light badge-pill bg-warning text-black text-header-pendingLeads"></span>
                        </div>
                        <i class="link-arrow" data-feather="chevron-down" id="toggle-indicator"></i>
                    </a>
                    <div class="collapse" id="processMgt">
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
                    </div>
                </li>
            @endif

            @if(in_array('1', $distribute))
                <li class="nav-item nav-category">Distribute</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#distribute" role="button" aria-expanded="false"
                       aria-controls="emails" id="req-ex">
                        <i class="link-icon text-success" data-feather="send"></i>
                        <span class="link-title">Distribute&nbsp;</span>
                        <div class="text-white invisible pendingLeads" role="status">
                            <span
                                class="badge badge-light badge-pill bg-warning text-black text-header-pendingLeads"></span>
                        </div>
                        <i class="link-arrow" data-feather="chevron-down" id="toggle-indicator"></i>
                    </a>
                    <div class="collapse" id="distribute">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('dis_collected_orders_get') }}" class="nav-link">Collect Processing
                                    Orders</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dis_dispatched_orders_get') }}" class="nav-link">Dispatch Orders</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dis_to_be_receive_orders_get') }}" class="nav-link">To Be Receive
                                    Packages</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dis_received_orders_get') }}" class="nav-link">Receive Orders</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if(in_array('1', $handover))
                <li class="nav-item nav-category">Handover</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#handover" role="button" aria-expanded="false"
                       aria-controls="emails" id="req-ex">
                        <i class="link-icon text-success" data-feather="send"></i>
                        <span class="link-title">Handover&nbsp;</span>
                        <div class="text-white invisible pendingLeads" role="status">
                            <span
                                class="badge badge-light badge-pill bg-warning text-black text-header-pendingLeads"></span>
                        </div>
                        <i class="link-arrow" data-feather="chevron-down" id="toggle-indicator"></i>
                    </a>
                    <div class="collapse" id="handover">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('hand_assign_to_agent_orders_get') }}" class="nav-link">Assign to
                                    Agent</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hand_delivered_orders_get') }}" class="nav-link">Delivered</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hand_reschedule_orders_get') }}" class="nav-link">Re-Schedule</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hand_deliver_fail_orders_get') }}" class="nav-link">Deliver
                                    Fails </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if(in_array('1', $fail))
                <li class="nav-item nav-category">Fails</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#fails" role="button" aria-expanded="false"
                       aria-controls="emails" id="req-ex">
                        <i class="link-icon text-success" data-feather="send"></i>
                        <span class="link-title">Fails&nbsp;</span>
                        <div class="text-white invisible pendingLeads" role="status">
                            <span
                                class="badge badge-light badge-pill bg-warning text-black text-header-pendingLeads"></span>
                        </div>
                        <i class="link-arrow" data-feather="chevron-down" id="toggle-indicator"></i>
                    </a>
                    <div class="collapse" id="fails">
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
            @endif

            @if(in_array('1', $finance))
                <li class="nav-item nav-category">Finance</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#finance" role="button" aria-expanded="false"
                       aria-controls="emails" id="req-ex">
                        <i class="link-icon text-success" data-feather="send"></i>
                        <span class="link-title">Finance&nbsp;</span>
                        <div class="text-white invisible pendingLeads" role="status">
                            <span
                                class="badge badge-light badge-pill bg-warning text-black text-header-pendingLeads"></span>
                        </div>
                        <i class="link-arrow" data-feather="chevron-down" id="toggle-indicator"></i>
                    </a>
                    <div class="collapse" id="finance">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{route('daily_finance')}}" class="nav-link">Daily Finance</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('daily_Deposit_get')}}" class="nav-link">Daily Deposit</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('seller_invoice')}}" class="nav-link">Seller's Invoice</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if(in_array('1', $userMgt))
                <li class="nav-item nav-category">User Management</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#user" role="button" aria-expanded="false"
                       aria-controls="emails" id="req-ex">
                        <i class="link-icon text-success" data-feather="send"></i>
                        <span class="link-title">User Management&nbsp;</span>
                        <div class="text-white invisible pendingLeads" role="status">
                            <span
                                class="badge badge-light badge-pill bg-warning text-black text-header-pendingLeads"></span>
                        </div>
                        <i class="link-arrow" data-feather="chevron-down" id="toggle-indicator"></i>
                    </a>
                    <div class="collapse" id="user">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{route('seller_view_and_create')}}" class="nav-link">Sellers</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('rider_view_and_create')}}" class="nav-link">Rider</a>
                            </li>
                            {{--<li class="nav-item">
                                <a href="{{route('seller_invoice')}}" class="nav-link">Staff</a>
                            </li>--}}
                        </ul>
                    </div>
                </li>
            @endif

            @if(in_array('1', $setting))
                <li class="nav-item nav-category">Settings</li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#setting" role="button" aria-expanded="false"
                       aria-controls="emails" id="req-ex">
                        <i class="link-icon text-success" data-feather="send"></i>
                        <span class="link-title">Settings&nbsp;</span>
                        <div class="text-white invisible pendingLeads" role="status">
                            <span
                                class="badge badge-light badge-pill bg-warning text-black text-header-pendingLeads"></span>
                        </div>
                        <i class="link-arrow" data-feather="chevron-down" id="toggle-indicator"></i>
                    </a>
                    <div class="collapse" id="setting">
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
            @endif

        </ul>
    </div>
</nav>
