@extends('front/layouts/default')

@section('header_styles')
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('assets/admin_panel/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        #comp-history-table_wrapper .row{
            width:100% !important;
            
        }

        #comp-history-table_wrapper  label{
            display: inline-block !important; 
        }

        #comp-history-table_wrapper .pagination>.active>a,
        #comp-history-table_wrapper .pagination>.active>a:focus,
        #comp-history-table_wrapper .pagination>.active>a:hover,
        #comp-history-table_wrapper .pagination>.active>span, #comp-history-table_wrapper .pagination>.active>span:focus,
        #comp-history-table_wrapper .pagination>.active>span:hover {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        pagination>li:first-child>a, .pagination>li:first-child>span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }

        .pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .pagination>li>a, .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
    </style>
@stop

@section('title')
    Competition Name | Nitrous Competitions
@stop
@section("content")
    <style>
        #answers li.selected{
            border: solid 5px blue !important;
        }
    </style>
            <div class="competition-details-area pt-90 pb-90">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="competition-details-img">
                                <div>
                                    <img class="zoompro main-pic" src="{{url($info['main_image'])}}" alt=""  onerror = "noExitImg(obj)"/>
                                </div>
                                <div id="gallery" class="mt-20">
                                    @foreach($imgList as $item)
                                    <a data-image="{{url($item['img'])}}">
                                        <img src="{{url($item['img'])}}" onerror="noExitImg(obj)"  style = "width:90px; height:90px;" alt="">
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="competition-details-content pro-details-content-modify">
                                <h2>{{$info['name']}}</h2>
                                <div class="comp-details-price-wrap">
                                    <div class="competition-price">
                                        <span>£{{$info['price']}}</span>
                                        @if($info['normal_price'] != '')
                                        <span class="old">£{{$info['normal_price']}}</span>
                                        @endif    
                                    </div>
                                </div>
                                <p>{{$info['small_description']}}</p>
                                <div class="how-to-play pt-10">
                                    <h4>Entering Is Easy</h4>
                                        <ol>
                                            <li>Pick Ticket Nunbers Or Use Ramdon Number Selector</li>
                                            <li>Answer Competition Question</li>
                                            <li>Add To Cart</li>
                                        </ol>

                                </div>
                                <div class="competition-statts pt-10">
                                    <h4>Competition Statts</h4>
                                    <div class="table-responsive">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" class="text-center">
                                                        <div id="competition-timer">
                                                            <div id="days"></div>
                                                            <div id="hours"></div>
                                                            <div id="minutes"></div>
                                                            <div id="seconds"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Live Draw Date</td>
                                                    <td>{{date("d/m/Y ha", strtotime($info['deadline_date']))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Number Of Tickets</td>
                                                    <td>{{$info['total_num']}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tickets Sold</td>
                                                    <td>{{$info->getSoldCount()}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Remaining Tickets</td>
                                                    <td>{{$info->getRemainCount()}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="progress">
                                                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                          aria-valuemin="0" aria-valuemax="100" style="width:{{$info->getSoldPro()}}%">
                                                      </div>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="pick-number-area pt-40 pb-40">
        <div class="container">
            <div class="section-title text-center mb-40">
                <h3>1. Pick Your Ticket Number(s)</h3>
            </div>

            <div class="pick-numbers">
                <div class="number-tabs nav mb-10">
                    <?php 
                        $totalCount = $info['total_num']*1;
                        $perPageNum = $info['count_per_tab']*1;
                    ?>
                    <?php $k = 1;?>    
                    <?php for($i=1 ; $i<=$totalCount; $i+=$perPageNum) { ?>
                    <a data-toggle="tab" href="#tab{{$k}}" class="@if($k==1)active @endif">{{$i}}-{{($i+$perPageNum> $totalCount ? $totalCount:$i+$perPageNum-1)}}</a>
                    <?php $k++;} ?>
                    <a data-toggle="tab" href="#tab{{$k}}" class="">All Available</a>
                </div>
                <div class="row pt-20 pb-20">
                    <div class="col-lg-12 solid-btn">
                        <p><a class="btn" data-toggle="collapse" href="#collapseExample"  role="button" aria-expanded="false" aria-controls="collapseExample">
                            Use Random Number Picker <i class="las la-angle-double-down"></i></a>
                        </p>
                        <div class="collapse" id="collapseExample">
                          <div class="card card-body">
                            <h4>Select Number Of Tickets</h4>
                            <ul>
                                @foreach($availTicketList as $item)
                                <li  class = "hidden item{{$item['id']}} @if($item['status']*1 == 1) held  @elseif($item['status']*1 == 2) sold @endif"  data-no = "{{$item['ticket_no']}}" data-id = "{{$item['id']}}" onclick = "selectedItem1(this)" >{{$item['ticket_no']}}</li>
                                @endforeach
                                @for($i = 1 ; $i<=10; $i++)
                                <li data-cnt = "{{$i}}"  onclick = "showRandTicket('{{$i}}', '{{$info->id}}')" >{{$i}}</li>
                                @endfor    
                            </ul>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <?php $k=0;?>
                    <?php foreach($ticketList as $key => $ticket) { ?>
                        <?php if(($key+1) % $perPageNum == 1) {?>
                        <?php $k++ ; ?>    
                        <ul id="tab{{$k}}" class="tab-pane <?php if($k==1){ ?>active <?php } ?>">
                        <?php } ?>
                        <li class = " item{{$ticket['id']}} @if($ticket['status']*1 == 1) held  @elseif($ticket['status']*1 == 2) sold @endif" data-no = "{{$ticket['ticket_no']}}" data-id = "{{$ticket['id']}}" onclick = "selectedItem(this)" >
                            {{$ticket['ticket_no']}}
                            @if($ticket['status']*1 == 1)
                                <span>held</span>
                            @elseif($ticket['status']*1 == 2)
                                <span>sold</span>
                            @endif
                        </li>  
                    <?php if($key != 0 && (($key+1) % $perPageNum == 0) || $key +1 == count($ticketList)) { ?>
                    </ul>
                    <?php } ?>        
                    <?php } ?>
                     <ul id="tab{{$k+1}}" class="tab-pane">
                         @foreach($availTicketList as $ticket)
                             <li class = " item{{$ticket['id']}} @if($ticket['status']*1 == 1) held  @elseif($ticket['status']*1 == 2) sold @endif"  data-no = "{{$ticket['ticket_no']}}" data-id = "{{$ticket['id']}}" onclick = "selectedItem(this)">
                                 {{$ticket['ticket_no']}}
                                 @if($ticket['status']*1 == 1)
                                     <span>held</span>
                                 @elseif($ticket['status']*1 == 2)
                                     <span>sold</span>
                                 @endif
                             </li>
                         @endforeach    
                     </ul>
                </div>
                @if(Sentinel::getUser())
                <div class="row">
                    <div class="col-lg-12 numbers-picked mt-10">
                        <h5>Numbers picked :</h5>
                        <ul id = "pickedWrapper">
                            @foreach($cartTicketList as $cartTicket)
                            <li class="selected" data-id = "{{$cartTicket['id']}}" onclick = "removeSelectTicket('{{$cartTicket['id']}}')">{{$cartTicket['ticket_no']}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif    
            </div>
        </div>
    </div>
    <div class="question-area pt-20 pb-40">
        <div class="container">
            <div class="section-title text-center">
                <h3>2. Answer Question</h3>
            </div>
            <div class="question pt-20 pb-20">
                <p>{{$info['question']}}</p>
            </div>
            <div class="answers pt-20">
                <ul id="answers">
                    @foreach($info['anwers'] as $answer)
                    <li data-id = "{{$answer['id']}}" class="@if($answer['is_true']==0)incorrect @else correct @endif" onclick = "selectedAnswer(this)">
                        @if($answer['answer_type']*1 == 1)
                        <img src="{{url($answer['answer'])}}" onerror = "noExitImg(this)" style = "width:150px; height:150px;">
                        @else
                            <div style = "display:inline-block; width:150px; height:150px;line-height: 150px;text-align: center;font-size: 30px;">{!! $answer['answer'] !!}</div>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="add-to-cart-area pt-20 pb-40">
        <div class="container">
            <div class="solid-btn">
                <a href="javascript:void(0);" onclick ="insertBucket()" class="text-white">Add To Cart</a>
            </div>
        </div>
    </div>
    <div class="description-review-wrapper pb-90">
        <div class="container">
            <div class="row">
                <div class="ml-auto mr-auto col-lg-10">
                    <div class="dec-review-topbar nav mb-40">
                        <a class="active" data-toggle="tab" href="#comp-descrip">Description</a>
                        <a data-toggle="tab" href="#comp-hist">Competition History</a>
                    </div>
                    <div class="tab-content dec-review-bottom">
                        <div id="comp-descrip" class="tab-pane active">
                            <div class="description-wrap">
                                <p>{!! $info['full_description'] !!}</p>
                                <div class="alert alert-primary mt-20" role="alert">
                                  For all methods of entry, please navigate to the terms & conditions page.
                              </div>
                          </div>
                      </div>
                      <div id="comp-hist" class="tab-pane table-responsive">
                        <table id="comp-history-table" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                            <tr class="filters">
                                <th>Purchase Date</th>
                                <th>User</th>
                                <th>Ticket Number</th>
                            </tr>
                            </thead>
                            @foreach($info->getPurchasedTicketList() as $orderDetail)
                                <tr>
                                    <td class="date">{{date("S F Y n:i a", strtotime($orderDetail['order']['trans_time']))}}</td>
                                    <td class="username">@if(isset($orderDetail['order']['user'])){{$orderDetail['order']['user']->getFullNameAttribute()}} @else XXX @endif</td>
                                    <td class="ticket_number">{{$orderDetail['ticket']['ticket_no']}}</td>
                                </tr>
                            @endforeach
                            <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function makeTimer() {

        //		var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");
        var dealing_time = '{{$info['deadline_date']}}';
        var endTime = new Date(dealing_time);
        endTime = (Date.parse(endTime) / 1000);

        var now = new Date();
        now = (Date.parse(now) / 1000);

        var timeLeft = endTime - now;

        var days = Math.floor(timeLeft / 86400);
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

        if (hours < "10") { hours = "0" + hours; }
        if (minutes < "10") { minutes = "0" + minutes; }
        if (seconds < "10") { seconds = "0" + seconds; }

        $("#days").html(days + "<span>Days</span>");
        $("#hours").html(hours + "<span>Hours</span>");
        $("#minutes").html(minutes + "<span>Minutes</span>");
        $("#seconds").html(seconds + "<span>Seconds</span>");

    }

    setInterval(function() { makeTimer(); }, 1000);
    
</script>
    
@stop

@section("footer_scripts")
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script>
        var table = $('#comp-history-table').DataTable({
            processing: true,
            serverSide: false,
            /*columns: [
                { data: 'id', name: 'id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status'},
                { data: 'created_at', name:'created_at'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]*/
        });
        table.on( 'draw', function () {
           
        } );
        
        
    </script>
    <script>
        var avaliCount = "{{count($availTicketList)}}";
        avaliCount = parseInt(avaliCount);
        function showRandTicket1(){
            if(avaliCount <= 10){
                return;
            }
            var randArr = rndArr();
            
            $("#collapseExample li").addClass("hidden");
            for(var i =0 ; i<randArr.length; i++){
                var index = randArr[i];
                index--;
                $("#collapseExample li:eq("+index+")").removeClass("hidden");
            }
        }
        
        $(function(){
            //showRandTicket();
        });
        
        function showRandTicket(cnt, competition_id){
            var param = new Object();
            param._token = _token;
            param.cnt = cnt;
            param.competition_id = competition_id;
            param.picketTickets =getPickedTickets();
            var url = "{{url("competition/ajaxSelectRandTicket")}}";
            $.post(url, param, function(data){
                if(data.status == "1"){
                    var tickets = data.rndIds;
                    var tickect_a = tickets.split(",");
                    var ticket;
                    for(var i = 0; i <tickect_a.length; i++){
                        ticket = tickect_a[i];
                        selectedItem($(".item"+ticket+":eq(0)")[0]);
                    }
                }else if(data.status == "-1"){
                    showLoginModal();
                }else{
                    errorMsg(data.msg);
                }
            }, "json");
        }
        
        function rndArr(){
            var ret = new Array();
            var rnd ;
            var i, flag;
            while(ret.length <= 10){
                flag = true;
                rnd = Math.round(Math.random()*(avaliCount-1))+1;
                for(i=0; i<ret.length; i++){
                    if(ret[i]== rnd){
                        flag = false;
                        break;
                    }
                }

                if(flag){
                    ret[ret.length] = rnd;
                }
                
            }
            return ret;
        }
        
        function getPickedTickets(){
            var tickets = "";
            var ticket = "";
            $("#pickedWrapper li").each(function(){
                ticket = $(this).attr("data-id");
                tickets += (tickets==""?"":",")+ticket;
            });
            return tickets;
        }
    </script>
    <script>
        var maxPicketCount = "{{$info['max_per_user']}}";
        var readyTicketCount = "{{$ready_ticket_count}}";
        var soldTicketCount = "{{$sold_ticket_count}}";
        var competition_id = "{{$info['id']}}";
        
        $(function(){
           if(parseInt(readyTicketCount)>0){
               successMsg("You already hold "+readyTicketCount+" tickets for this competition");
           } 
        });
        function insertBucket(){
            @if(!Sentinel::getUser())
                    $("#login-modal").modal("show");
                    return;
            @endif    
            var tickets = getPickedTickets();
            
            
            if(tickets == ""){
                errorMsg("Please select tickets");
                return;
            }
            if($("#answers li.selected").length ==0){
                errorMsg("Please select answer");
                return;
            }
            var answerId = $("#answers li.selected").attr("data-id"); 
            var param = new Object();
            param.competition_id = competition_id;
            param.tickets = tickets;
            param.answerId = answerId;
            param._token = _token;
            var url = "{{url("competition/ajaxInsertBasket")}}";
            $.post(url, param, function(data){
                if(data.status == "1"){
                    successMsg(data.msg, function(){
                       window.location.href = "{{url("/cart")}}/{{$info['id']}}";
                    });
                }else if(data.status == "-1"){
                    showLoginModal();
                }else{
                    errorMsg(data.msg);
                }
            }, "json")
        }
        
        function selectedAnswer(obj){
             $("#answers li").removeClass("selected");
             $(obj).addClass("selected");
        }
        
        function getSelectedCount(){
            return $("#pickedWrapper").find("li").length;
        }
        
        
        function removeSelectTicket(id){
            $("#pickedWrapper li").each(function(){
                if($(this).attr("data-id") == id){
                    $(this).remove();
                    $(".item"+id).removeClass("selected");
                    $(".item"+id).removeClass("held");
                    $(".item"+id).find("span").remove();
                }
            })
        }
        function selectedItem(obj){
            var url = "{{url("competition/ajaxAvailSelectTicket")}}";
            var param = new Object();
            if($(obj).hasClass("selected")){
                //$(obj).removeClass("selected");
                removeSelectTicket($(obj).attr("data-id"));
                $(".item"+$(obj).attr("data-id")).removeClass("selected");
            }else{
                if(getSelectedCount() >= parseInt(maxPicketCount - soldTicketCount)){
                    errorMsg("The tickets number is over maximum!");
                    return;
                }
                param._token = _token;
                param.ticket_id = $(obj).attr("data-id");
                $.post(url, param, function(data){
                    if(data.status == "1"){
                        //$(obj).addClass("selected");
                        var id = $(obj).attr("data-id");
                        var no = $(obj).attr("data-no");
                        selectItem(id, no);
                    
                    }else if(data.status == "-1"){
                        showLoginModal();
                    }else{
                        errorMsg(data.msg);
                    }
                }, "json");
                
            }
            
        }
        
        function selectItem(id, no){
            $(".item"+id).addClass("selected");
            var html = `<li class="selected" data-id = "${id}" onclick = "removeSelectTicket('${id}')">${no}</li>`;
            $("#pickedWrapper").append(html);
        }
    </script>
@stop    