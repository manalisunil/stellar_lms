<div class="container-fluid mt-1">
    
    <div class="card card_top_orenge ">
        <div class="card-body">
            <div class="p-0">
                <!-- Modal body -->
                <div class="row ">
                    <div class="col-lg-9 text-left">
                        <h5 class="modal-title pl-3" id="exampleModalLabel">
                            <a href="{{ route('orderlist') }}" style="text-decoration:none;">
                                <img class="mensuicon" src="{{asset('app-assets/assets/images/backs.png')}}" style="width:1.3rem;height:1.3rem;margin-right: 10px;">
                            </a>
                        Update Order </h5>
                    </div>
                    <div class="col-lg-1 pt-2">
                        <label for="unique-id-input" class="">Order Unique Id  :</b></label>
                    </div>
                    <div class="col-lg-2 pt-2">
                        <div class="unique-id-input pt-1 "><b class="orderID"> {{$order_openinfo->order_unique_id}}</b><i class=" ml-3 fa-solid fa-eye or_audit"  onclick="showaudit({{$order_openinfo->id}})"></i> </div>
                    </div></div>
                    <div class="card  card_top_green" >
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-lg-1">
                                    <label for="city-input" class="">Client :</b> </label>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-condtrol mt-1">sdf </div>
                                </div>
                                <div class="col-lg-1">
                                    <label for="phone-no-input" class=""> Address  :</b></label>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-condtrol mt-1">asd </div>
                                </div>
                               
                            </div>
                           
                           
                            
                        </div>
                </div>          
            </div>
        </div>