@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="form-head d-flex mb-3 mb-md-5 align-items-start">
            <div class="mr-auto d-none d-lg-block">
                <a class="text-warning d-flex align-items-center mb-3 font-w500" href="{{route('order.view')}}" >
                    <svg class="mr-3" width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.274969 5.14888C0.27525 5.1486 0.275484 5.14827 0.275812 5.14799L5.17444 0.272997C5.54142 -0.0922061 6.135 -0.090847 6.5003 0.276184C6.86555 0.643168 6.86414 1.23675 6.49716 1.60199L3.20822 4.87499H23.0625C23.5803 4.87499 24 5.29471 24 5.81249C24 6.33027 23.5803 6.74999 23.0625 6.74999H3.20827L6.49711 10.023C6.86409 10.3882 6.8655 10.9818 6.50025 11.3488C6.13495 11.7159 5.54133 11.7171 5.17439 11.352L0.275764 6.47699C0.275483 6.47671 0.27525 6.47638 0.274921 6.4761C-0.0922505 6.10963 -0.0910778 5.51413 0.274969 5.14888Z" fill="#ffb800"/>
                    </svg>
                Back</a>
                
            </div>

        </div>
        <div class="row">

            <div class="col-md-4">
                @foreach($orderList as $o)
                <h3 class="text-black font-w600 mb-0 fs-14">{{__('sentence.orderid') }} #{{$o->id}}</h3>
                <a class="mb-0 text-black font-w500" href="#">{{__('sentence.ord') }}  /</a>
                <a class="mb-0 font-w500" href="#">{{__('sentence.orderd') }} </a>
                @endforeach
               
            </div>
            <div class="col-md-4">
                
                <h3 class="text-black font-w600 mb-0 fs-14">{{__('sentence.orderdate') }} : {{date('M d, Y',strtotime($o->delivery_date))}}</h3>
                <h3 class="text-black font-w600 mb-0 fs-14 mb-2"> {{__('sentence.delt') }} : {{date('h:i A',strtotime($o->delivery_time))}}</h3>
            </div>

            <div class="dropdown ml-auto mb-4 mr-4">
                <div class="btn btn-warning btn-rounded dropdown-toggle d-block  px-4 btn-sm" data-toggle="dropdown">
                    <i class="fas fa-print"></i>
                    Print
                </div>
                <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="{{route('generate.label',$o->id)}}" title="">Print Label</a>
                    <a class="dropdown-item" href="{{route('generate.order',$o->id)}}" title="" target="_blank">Print Order</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="widget-timeline-icon">
                                <ul class="timeline">
                                    @if(!empty($o->created_at_timezone))
                                    <li class="border-warning">
                                        <div class="icon bg-warning"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.penorder') }}</h6>
                                            <p class="fs-14 mb-0 ">{{$o->created_at_timezone}}</p>
                                        </a>
                                    </li>
                                    @else
                                    <li class="border-dark">
                                        <div class="icon bg-dark"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.penorder') }}</h6>
                                            <p class="fs-14 mb-0 "></p>
                                        </a>
                                    </li>
                                    @endif
                                    @if(!empty($o->accepted_at_timezone))
                                    <li class="border-warning">
                                        <div class="icon bg-warning"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.accorder') }}</h6>
                                            <p class="fs-14 mb-0 ">{{$o->accepted_at_timezone}}</p>
                                        </a>
                                    </li>
                                    @else
                                    <li class="border-dark">
                                        <div class="icon bg-dark"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.accorder') }}</h6>
                                            <p class="fs-14 mb-0 "></p>
                                        </a>
                                    </li>
                                    @endif
                                    @if(!empty($o->ready_at_timezone))
                                    <li class="border-warning">
                                        <div class="icon bg-warning"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.readyorder') }}</h6>
                                            <p class="fs-14 mb-0 ">{{$o->ready_at_timezone}}</p>
                                        </a>
                                    </li>
                                    @else
                                    <li class="border-dark">
                                        <div class="icon bg-dark"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.readyorder') }}</h6>
                                            <p class="fs-14 mb-0 "></p>
                                        </a>
                                    </li>
                                    @endif
                                    @if(!empty($o->delivery_at_timezone))
                                    <li class="border-warning">
                                        <div class="icon bg-warning"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.outfd') }}</h6>
                                            <p class="fs-14 mb-0 ">{{$o->delivery_at_timezone}}</p>
                                        </a>
                                    </li>
                                    @else
                                    <li class="border-dark">
                                        <div class="icon bg-dark"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.outfd') }}</h6>
                                            <p class="fs-14 mb-0 "></p>
                                        </a>
                                    </li>
                                    @endif
                                    @if(!empty($o->completed_at_timezone))
                                    <li class="border-warning">
                                        <div class="icon bg-warning"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.complorder') }}</h6>
                                            <p class="fs-14 mb-0 ">{{$o->completed_at_timezone}}</p>
                                        </a>
                                    </li>
                                    @else
                                    <li class="border-dark">
                                        <div class="icon bg-dark"></div>
                                        <a class="timeline-panel text-muted" href="#">
                                            <h6 class="mb-2 mt-0">{{__('sentence.complorder') }}</h6>
                                            <p class="fs-14 mb-0 "></p>
                                        </a>
                                    </li>
                                    @endif
                                </ul> 
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4 col-6">
                                        <h6 class="mb-2 mt-0">{{__('sentence.picdel') }}</h6>
                                        <p class="fs-14 mb-0 ">{{$o->pick_del_option==1?"Pickup":"Delivery"}}</p><br>
                                        @if($o->pick_del_option==2)
                                            <h6 class="mb-2 mt-0 fs-14">{{__('sentence.delby') }}</h6>
                                            <p class="fs-14 mb-0 ">{{$o->delivery_by==1?"Chef":"Delivery Company"}}</p><br>
                                        @endif
                                        <h6 class="mb-2 mt-0 fs-14">{{__('sentence.payments') }}</h6>
                                        <p class="fs-14 mb-0 ">{{$o->payment_method==1?"Not Paid(COD)":"Paid"}}</p><br>
                                        
                                       
                                    </div>
                                    <div class="col-xl-4 col-6">
                                        <h6 class="mb-2 mt-0 fs-14">{{__('sentence.itmtot') }}</h6>
                                        <p class="fs-14 mb-0 ">{{!empty($currency)?$currency->symbol:''}}{{$o->sub_total}}</p><br>
                                        @if($o->pick_del_option==2)
                                        <h6 class="mb-2 mt-0 fs-14">{{__('sentence.delamt') }}</h6>
                                        <p class="fs-14 mb-0 ">{{!empty($currency)?$currency->symbol:''}}{{$o->delivery_fee}}</p><br>
                                        <h6 class="mb-2 mt-0 fs-14">{{__('sentence.tipamt') }}</h6>
                                        <p class="fs-14 mb-0 ">{{!empty($currency)?$currency->symbol:''}}{{$o->tip_fee}}</p><br>
                                        @endif                                        
                                    </div>
                                    <div class="col-xl-4 col-6">
                                        <h6 class="mb-2 mt-0 fs-14">{{__('sentence.payamt') }}</h6>
                                        <p class="fs-16 mb-0 text-warning ">{{!empty($currency)?$currency->symbol:''}}{{$o->pay_total}}</p><br>
                                                                             
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($o->pick_del_option==2)
                    @if($deliveryDetail)
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body rounded" style="background:#3f4953;">
                                <div class="row mx-0 align-items-center">
                                    <div class="media align-items-center col-md-4 col-lg-6 px-0 mb-3 mb-md-0">
                                    <!--  <img class="mr-3 img-fluid rounded-circle" width="100" src="" alt="DexignZone"> -->
                                        <div class="media-body">
                                            <p class="text-white mb-1 wspace-no">Delivery Person</p>
                                            <h3 class="mb-1 text-white  fs-22">{{$deliveryDetail->name}}</h3>
                                            <small class="text-white wspace-no">Code {{$deliveryDetail->delivery_code}}</small>
                                        </div>
                                    </div>
                                    <div class="text-left text-lg-right col-xl-6 p-0 mt-lg-0 mt-3">
                                        <div class="iconbox mb-3 mr-3 mb-md-0">
                                            <i class="las la-phone"></i>
                                            <small>Telephone</small>
                                            <p>{{$deliveryDetail->mobile}}</p>
                                        </div>
                                        <div class="iconbox mb-md-0">
                                          <i class="las la-shipping-fast"></i>
                                          <small>{{__('sentence.delt') }}</small>
                                          <p>{{$deliveryDetail->delivery_time}}</p>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                @if(!empty($o->orderItems))
                                @foreach($o->orderItems as $i)
                                <div class="sp15 row border-bottom favorites-items p-3 align-items-center p-sm-4">
                                    <div class="col-xl-6 col-lg-6 col-sm-6 col-12 mb-3 mb-lg-0">
                                        <div class="media align-items-center">
                                            <img class="rounded mr-3" src="{{asset('public/frontend/images/menu')}}/{{$i->menu->photo}}" alt="" width="105">
                                            <div class="media-body">
                                                <small class="mt-0 mb-1 font-w500">MAIN COURSE</small>
                                                <h5 class="mb-2">{{$i->menu->item_name}}</h5>
                                                <em>
                                                    <?php $optionTotal=0; ?>
                                                    @if(!empty($o->orderItems))
                                                    @foreach($i->orderItemOptions as $opt)
                                                    {{$opt->option}}<br>
                                                    @php $optionTotal += $opt['rate'] @endphp
                                                     @endforeach
                                                     @endif
                                                     <span class="text-warning">{{__('sentence.adtotal')}}:{{!empty($currency)?$currency->symbol:''}}{{$optionTotal}}</span>                                       
                                                </em>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-sm-2 col-4 media text-center">

                                        <div class="media-body">
                                            <span class="text-black">{{__('sentence.qty') }}</span>
                                            <h4 class="text-black font-w600 mb-1">{{$i->qty}}</h4>                                       
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-sm-2 col-4 media text-center">

                                        <div class="media-body">
                                            <span class="text-black">{{__('sentence.rate') }}</span>
                                            <h4 class="text-black font-w600 mb-1">{{!empty($currency)?$currency->symbol:''}}{{$i->rate}}</h4>                                      
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-sm-2 col-4 text-center">
                                        <div class="media-body">
                                            <span class="text-black">{{__('sentence.total') }}</span>
                                            <h4 class="text-black font-w600 mb-1">{{!empty($currency)?$currency->symbol:''}}{{$i->total}}</h4>                           
                                        </div>

                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-sm-12 col-12">
                                        
                                            <h4 class="text-warning fs-12 font-w600 mb-1">{{__('sentence.speint') }}</h4> 
                                            <small class="fs-11">{{ $i->notes}}</small>  
                                       
                                    </div>
                                </div>
                               
                                @endforeach
                                @endif                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-xxl-12">

                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="media align-items-center">
                            <img class="mr-3 rounded-circle" src="{{asset('public/frontend/images/users')}}/{{$o->user->profile}}" width="90" alt="">

                            <div class="media-body">
                                <h6 class="text-black mb-3">{{$o->user->display_name}}</h6>
                                <span class="bgl-info fs-14 text-info p-2 rounded">Customer</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom">
                        <div class="media align-items-center">
                            <svg class="mr-4" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.9993 17.4712V20.7831C23.0006 21.0906 22.9375 21.3949 22.814 21.6766C22.6906 21.9583 22.5096 22.2112 22.2826 22.419C22.0556 22.6269 21.7876 22.7851 21.4958 22.8836C21.2039 22.9821 20.8947 23.0187 20.5879 22.991C17.1841 22.6219 13.9145 21.4611 11.0418 19.6019C8.36914 17.9069 6.10319 15.6455 4.40487 12.9781C2.53545 10.0981 1.37207 6.81909 1.00898 3.40674C0.981336 3.10146 1.01769 2.79378 1.11572 2.50329C1.21376 2.2128 1.37132 1.94586 1.57839 1.71947C1.78546 1.49308 2.03749 1.31221 2.31843 1.18836C2.59938 1.06451 2.90309 1.0004 3.21023 1.00011H6.52869C7.06551 0.994834 7.58594 1.18456 7.99297 1.53391C8.4 1.88326 8.66586 2.36841 8.74099 2.89892C8.88106 3.9588 9.14081 4.99946 9.5153 6.00106C9.66413 6.39619 9.69634 6.82562 9.60812 7.23847C9.51989 7.65131 9.31494 8.03026 9.01753 8.33042L7.61272 9.73245C9.18739 12.4963 11.4803 14.7847 14.2496 16.3562L15.6545 14.9542C15.9552 14.6574 16.3349 14.4528 16.7486 14.3648C17.1622 14.2767 17.5925 14.3089 17.9884 14.4574C18.992 14.8312 20.0348 15.0904 21.0967 15.2302C21.6341 15.3058 22.1248 15.576 22.4756 15.9892C22.8264 16.4024 23.0128 16.9298 22.9993 17.4712Z" stroke="#566069" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <h6 class="mb-0 text-black">{{$o->user->mobile}}</h6>
                        </div>
                    </div>
                    <div class="card-body border-bottom">
                        <div class="media align-items-center">
                            <a href="http://maps.google.com/?q={{$o->user->location->address}}"><svg class="mr-4" width="24" height="24" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" style="min-width: 24px;">
                                <path d="M28 13.3333C28 22.6667 16 30.6667 16 30.6667C16 30.6667 4 22.6667 4 13.3333C4 10.1507 5.26428 7.09848 7.51472 4.84805C9.76516 2.59761 12.8174 1.33333 16 1.33333C19.1826 1.33333 22.2348 2.59761 24.4853 4.84805C26.7357 7.09848 28 10.1507 28 13.3333Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16 17.3333C18.2091 17.3333 20 15.5425 20 13.3333C20 11.1242 18.2091 9.33333 16 9.33333C13.7909 9.33333 12 11.1242 12 13.3333C12 15.5425 13.7909 17.3333 16 17.3333Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg></a>
                            <h6 class="mb-0 text-black"><a href="http://maps.google.com/?q={{$o->user->location->address}}">{{$o->user->location->address}}</a></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8">
                                @if($o->status==2)
                                    <button class="btn btn-warning change-status"  data-status="accepted"  data-action="{{route('order.change-status')}}" data-id="{{($o->id)}}">{{__('sentence.accorder') }}</button>
                                    <button class="btn btn-warning change-status"  data-status="cancel"  data-action="{{route('order.change-status')}}" data-id="{{($o->id)}}">{{__('sentence.canorder') }}</button>
                                @elseif($o->status==4)
                                @if($o->delivery_by==1)
                                    <button class="btn btn-warning change-status"  data-status="ready"  data-action="{{route('order.change-status')}}" data-id="{{($o->id)}}">  {{__('sentence.ready') }}</button>
                                @else
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">  {{__('sentence.ready') }}</button>
                                @endif
                                @elseif($o->status==5)
                                    <button class="btn btn-warning change-status"   data-status="ready-for-delivery"  data-action="{{route('order.change-status')}}" data-id="{{($o->id)}}">  {{__('sentence.outfordel') }}</button>
                                @elseif($o->status==6)
                                    <button class="btn btn-warning change-status"   data-status="delivered"  data-action="{{route('order.change-status')}}" data-id="{{($o->id)}}">  {{__('sentence.delivered') }}</button>
                                @endif
                            </div>
                        </div>
                        <!-- <h6 class="text-black font-weight-bold mb-3 wspace-no">{{__('sentence.noteo') }}</h6>
                          <p>{{__('sentence.notedesc') }}</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delivery Detail</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
    </div>
    <div class="modal-body">
        {{ Form::open(['url' => route('delivery-detail'), 'method'=>'POST', 'files'=>true, 'name' => 'frmDeliveryDetail', 'id' => 'frmDeliveryDetail','class'=>"form-main"]) }}
        <input type="hidden" id='order_id' name="order_id" value="{{$o->id}}">
        <div class="row">
           <div class="col-xl-12">
              <div class="form-group row">
                <label class="col-sm-12">Delivery Person Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="del_name"  placeholder="" required="">
              </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-12"> Delivery Person Telephone</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" name="del_mo"  placeholder="" required="">
          </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-12 col-form-label"> Delivery Code</label>
        <div class="col-sm-12">
          <input type="text" class="form-control" name="delivery_code"  placeholder="" required="">
      </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-12 col-form-label">Delivery Time</label>
    <div class="col-sm-12">
      <input type="text" class="form-control" name="del_time"  placeholder="" required="" value="{{date('h:i A',strtotime($o->delivery_time))}}" readonly>
  </div>
</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-warning" id="btnSubmit" name="btnSubmit" >Submit</button>
</div>
{{ Form::close() }}
</div>
</div>
</div>
@endsection
@section('pageScript')
<script src="{{ asset('public/frontend/js/moment.min.js')}}"></script>
<script src="{{ asset('public/frontend/js/moment-timezone.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/order-detail.js')}}"></script>
@endsection 

