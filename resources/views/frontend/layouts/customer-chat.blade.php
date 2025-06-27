<!-- General Chat  -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/chat.css')}}">
<div class="message-popup">
    <div class="message-popup-wrap">
        <div class="message-popup-tab">
            <ul class="resp-tabs-list hor_1">
                <li>Messages</li>
                <li>Order</li>
            </ul>
            <div class="resp-tabs-container hor_1">
                <div>
                    <div class="messages-list-wrap">
                        <div class="messages-list">
                            <ul id="user-list">
                                <!-- Dynamic Data -->
                            </ul>
                        </div>
                        <div class="messages-chat-list" id="mess-chat-list">
                            <a href="javascript:;" title="" class="back-chat-btn"><i class="fas fa-arrow-left"></i></a>

                            <h6></h6>

                            <div class="messages-chat-messenger" id="message-chat">
                                <div class="chat">
                                    <div class="messages">      
                                        <div class="messages-content">
                                            <!-- <div class="message new">
                                                <figure class="avatar">
                                                    <img src="http://askavenue.com/img/17.jpg">
                                                </figure>first
                                                <div class="timestamp">14:7</div>                                     
                                            </div>
                                            <div class="message new right">
                                                <figure class="avatar">
                                                    <img src="http://askavenue.com/img/17.jpg">
                                                </figure>second
                                                <div class="timestamp">14:7</div>                                     
                                            </div>  -->                 
                                        </div>
                                    </div>
                                    <div class="message-box">                                        
                                        <textarea type="text" class="message-input" id="custMessage" placeholder="Type message..."></textarea>
                                        <input type="hidden" name="to_id" id="to_id">
                                        <button type="submit" class="message-submit" id="message-submit">Send</button>
                                    </div>
                                </div> 
                            </div>
                        </div>                        
                    </div>
                </div>
                <div>
                    <div class="messages-list-wrap">
                        <div class="messages-list">
                            <ul id="ticket-list">
                                <!--          <li data-attr="11">
                                    <div class="messages-list-box">
                                        <div class="messages-img" style="background-image: url({{asset('public/frontend/images/daniel-john.png')}});"></div>
                                        <div class="messages-list-content">
                                            <h3>Vishala Patel</h3>
                                            <p>Last Message</p>
                                        </div>
                                    </div>
                                </li> -->
                                
                            </ul>
                        </div>
                        <div class="messages-chat-list"  id="ticket-chat-list">
                            <a href="javascript:;" title="" class="back-chat-btn"><i class="fas fa-arrow-left"></i></a>     
                            <h6></h6>
                         

                            <div class="messages-chat-messenger" id="ticket-chat">
                                <div class="chat">
                                    <div class="messages">      
                                        <div class="messages-content gen-chat">
                                            <!-- <div class="message new">
                                                <figure class="avatar">
                                                    <img src="http://askavenue.com/img/17.jpg">
                                                </figure>a Hi there, I'm Jesse and you?
                                                <div class="timestamp">14:7</div>
                                                <div class="checkmark-sent-delivered">✓</div>
                                                <div class="checkmark-read">✓</div>
                                            </div>          -->         
                                        </div>
                                    </div>


                                    <div class="message-box">                                        
                                        <textarea type="text" class="message-input" id="ticketMessage" placeholder="Type message..."></textarea>
                                        <input type="hidden" name="ticket_to_id" id="ticket_to_id">
                                        <input type="hidden" name="order_id" id="order_id">
                                        <input type="hidden" name="ticket_id" id="ticket_id">
                                         <button type="submit" id="ticket-submit" class="message-submit">Send</button>
                                    </div>

                                </div> 
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.mCustomScrollbar.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/jquery.mCustomScrollbar.css')}}">
<script type="text/javascript" src="{{asset('public/frontend/js/pages/cust-chat.js')}}"></script>