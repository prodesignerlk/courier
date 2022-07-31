@extends('layouts.dashboard.main')

@section('content')
    @php
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp
    @if($user->hasRole('Super Admin'))
        <div class="card">
            <div class="card-header bg-primary text-white">
                Overall System Statistics
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats bg-gradient-green">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img width="80%"
                                             src="https://cdn2.iconfinder.com/data/icons/shopping-lineal-color/512/basket-256.png"
                                             alt="" srcset="">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title text-uppercase mb-0 text-black">Total Orders</h5>
                                        <span
                                            class="h3 font-weight-bold mb-0 text-black">{{$systemStatic['allOrd']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats bg-gradient-green">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img width="80%"
                                             src="https://cdn0.iconfinder.com/data/icons/ramadan-122/132/45-512.png"
                                             alt="" srcset="">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title text-uppercase mb-0 text-black">Sellers</h5>
                                        <span
                                            class="h3 font-weight-bold mb-0 text-black">{{$systemStatic['sellers']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats bg-gradient-green">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img width="80%"
                                             src="https://cdn1.iconfinder.com/data/icons/ecommerce-61/48/eccomerce_-_money-256.png"
                                             alt="" srcset="">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title text-uppercase text-black mb-0">Profit</h5>
                                        <span class="h3 font-weight-bold mb-0 text-black">Rs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats bg-gradient-green">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img width="80%"
                                             src="https://cdn4.iconfinder.com/data/icons/business-1221/24/Rank-256.png"
                                             alt=""
                                             srcset="">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title text-uppercase text-black mb-0">Delivery Rate</h5>
                                        <span
                                            class="h3 font-weight-bold mb-0 text-black">{{$systemStatic['deliveryRate']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats bg-gradient-green">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img width="80%"
                                            src="https://cdn4.iconfinder.com/data/icons/linec-business-e-commerce-logistics-1/512/8-128.png"
                                            alt="" srcset="">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title text-uppercase text-black mb-0">Total Failed Orders</h5>
                                        <span class="h3 font-weight-bold mb-0 text-black">{{ $failed_ord_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats bg-gradient-green">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img width="80%"
                                            src="https://cdn1.iconfinder.com/data/icons/ecommerce-61/48/eccomerce_-_carton_box_return-256.png"
                                            alt="" srcset="">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title text-uppercase text-black mb-0">Success Orders</h5>
                                        <span class="h3 font-weight-bold mb-0 text-black">{{ $delivered_ord_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <br>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            Order Statistics
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats bg-secondary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img width="80%"
                                         src="https://cdn3.iconfinder.com/data/icons/hotel-services-2-color-shadow/128/exchange_interchange_swapping_recovery_refresh_gift_swap_commutation_swop-512.png"
                                         alt="" srcset="">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title text-uppercase text-white mb-0">Processing ORD</h5>
                                    <span
                                        class="h3 font-weight-bold mb-0 text-white">{{$orderStatics['processingOrd']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats bg-secondary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img width="80%"
                                         src="https://cdn1.iconfinder.com/data/icons/miscellaneous-252-color-shadow/128/receivers_getter_collect_box_package_convenient_giveaway-512.png"
                                         alt="" srcset="">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title text-uppercase text-white mb-0">Collected ORD</h5>
                                    <span
                                        class="h3 font-weight-bold mb-0 text-white">{{$orderStatics['collectedOrd']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats bg-secondary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img width="80%"
                                         src="https://cdn1.iconfinder.com/data/icons/miscellaneous-256-color-shadow/128/your_give_gift-to-another_package_surprise_giveaway_present-512.png"
                                         alt="" srcset="">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title text-uppercase text-white mb-0">Assign Agent ORD</h5>
                                    <span
                                        class="h3 font-weight-bold mb-0 text-white">{{$orderStatics['assignedOrd']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats bg-secondary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img width="80%"
                                         src="https://cdn1.iconfinder.com/data/icons/delivery-vol1-vectoryland/512/cancel_shipping_reduce_shipments_shipments_cancel_cancel_vectoryland_box-512.png"
                                         alt="" srcset="">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title text-uppercase text-white mb-0">Miss Route ORD</h5>
                                    <span
                                        class="h3 font-weight-bold mb-0 text-white">{{$orderStatics['missRoutOrd']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats bg-secondary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img width="80%"
                                         src="https://cdn2.iconfinder.com/data/icons/shopping-and-retail-01-color-shadow/128/your-welcome_your_welcome_handshake_person_friends_meeting-512.png"
                                         alt="" srcset="">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title text-uppercase text-white mb-0">Reschedule ORD</h5>
                                    <span
                                        class="h3 font-weight-bold mb-0 text-white">{{$orderStatics['rescheduleOrd']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats bg-secondary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img width="80%"
                                         src="https://cdn2.iconfinder.com/data/icons/miscellaneous-57-color-shadow/128/return_comeback_repayment_regress_regression_gift-512.png"
                                         alt="" srcset="">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title text-uppercase text-white mb-0">Returned ORD</h5>
                                    <span class="h3 font-weight-bold mb-0 text-white">{{$orderStatics['return']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats bg-secondary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img width="80%"
                                         src="https://cdn0.iconfinder.com/data/icons/shipping-logistics-crayons-vol-1/256/Delivery_Cancelled-512.png"
                                         alt="" srcset="">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title text-uppercase text-white mb-0">Delivery Failed ORD</h5>
                                    <span class="h3 font-weight-bold mb-0 text-white">{{$orderStatics['failed']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats bg-secondary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img width="80%"
                                         src="https://cdn0.iconfinder.com/data/icons/miscellaneous-78-color-shadow/128/pack_parcel_gift_present_box_wraped_ribbon_-512.png"
                                         alt="" srcset="">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title text-uppercase text-white mb-0">Delivered ORD</h5>
                                    <span
                                        class="h3 font-weight-bold mb-0 text-white">{{$orderStatics['deliveredOrd']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
