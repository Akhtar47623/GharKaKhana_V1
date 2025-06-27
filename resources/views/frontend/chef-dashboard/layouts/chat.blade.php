<div class="chatbox">
    <div class="chatbox-close"></div>
        <div class="custom-tab-1">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#messages">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tickets">Tickets</a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane fade active show" id="messages" role="tabpanel">
                    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
                        <div class="card-header chat-list-header text-center">
                            <span></span>
                            <div><h6 class="mb-1">Customer List</h6></div>
                            <span></span>
                        </div>
                        <div class="card-body contacts_body p-0 dz-scroll  " id="DZ_W_Contacts_Body">

                            <ul class="contacts">
                                
                            </ul>
                        </div>
                    </div>
                    <div class="card chat dz-chat-history-box d-none">
                        <div class="card-header chat-list-header text-center">
                            <a href="javascript:;" class="dz-chat-history-back">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><polygon points="0 0 24 0 24 24 0 24"/><rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000) " x="14" y="7" width="2" height="10" rx="1"/><path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) "/></g></svg>
                            </a>
                            <div>
                                <h6 class="mb-1" id="msg-user-nm">Message with Chef</h6>                                
                            </div>              
                            
                        </div>

                        <div class="card-body msg_card_body dz-scroll" id="DZ_W_Contacts_Body3">
                            
                        </div>
                        <div class="card-footer type_msg">
                            {{ Form::open(['url' => route('send'), 'method'=>'POST', 'files'=>true, 'name' => 'frmMessage', 'id' => 'frmMessage']) }}
                            <div class="input-group">                                
                                <textarea class="form-control" name="message" placeholder="Type your message..."></textarea>
                                <input type="hidden" id="to_id" name="to_id">
                                <div class="input-group-append">
                                    <button type="submit" id="btnSubmit" class="btn btn-warning"><i class="fa fa-location-arrow"></i></button>
                                </div>                                
                            </div>
                            {{ Form::close() }}
                            
                        </div>
                    </div>                    
                </div>

                <div class="tab-pane fade" id="tickets" role="tabpanel">
                    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
                        <div class="card-header chat-list-header text-center">
                            <span></span>
                            <div><h6 class="mb-1">Ticket List</h6></div>
                            <span></span>
                        </div>
                        <div class="card-body contacts_body p-0 dz-scroll" id="DZ_W_Contacts_Body11">
                            
                            <ul class="contacts">
                                
                            </ul>
                        </div>
                    </div>
                    <div class="card chat dz-chat-history-box d-none">
                        <div class="card-header chat-list-header text-center">
                            <a href="javascript:;" class="dz-chat-history-back">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><polygon points="0 0 24 0 24 24 0 24"/><rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000) " x="14" y="7" width="2" height="10" rx="1"/><path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) "/></g></svg>
                            </a>
                            <div>
                                <h6 class="mb-1"  id="tic-user-nm">Chat with Ticket User</h6>                                
                            </div>              
                            <div class="dropdown show">
                                <button type="button" class="btn btn-defualt light sharp" data-toggle="dropdown" aria-expanded="true">
                             
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-78px, -81px, 0px);">
                                     <button type="button" class="btn btn-defualt light sharp closeTicket" data-action="{{route('ticket-close')}}" aria-expanded="true" id="closeTicket">Close</button>
                                </div>
                            </div>  
                        </div>

                        <div class="card-body msg_card_body dz-scroll" id="DZ_W_Contacts_Body1">
                            
                        </div>
                        <div class="card-footer type_msg">
                            {{ Form::open(['url' => route('send-ticket-message'), 'method'=>'POST', 'files'=>true, 'name' => 'frmTicketMessage', 'id' => 'frmTicketMessage']) }}
                            <div class="input-group">                                
                                <textarea class="form-control" name="message" placeholder="Type your message..."></textarea>
                                  <input type="hidden" id="orderId" name="order_id">
                                   <input type="hidden" id="toId" name="to_id">
                                <div class="input-group-append">
                                    <button type="submit" id="btnTicSubmit" class="btn btn-warning"><i class="fa fa-location-arrow"></i></button>
                                </div>                                
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>                        
                </div>                
            </div>
        </div>
    </div>
</div>

