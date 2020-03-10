@extends('admin_panel.layouts.master')

{{-- Web site Title --}}
@section('title')
    Competition Info
    @parent
@stop
@section('header_styles')
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset("assets/tree/dtree.css")}}">
    <script src="{{asset("assets/tree/dtree.js")}}"></script>
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/pages/buttons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/pages/advbuttons.css') }}" rel="stylesheet" type="text/css"/>
@stop
@section('breadcrumb')
    <h4 class="page-title">Competition Information</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
        </li>
        <li class  ="breadcrumb-item "><a href="#">Competitions Manage</a></li>
        <li class=" breadcrumb-item active">Competition</li>
    </ol>
@endsection
{{-- Montent --}}
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Competition Information</h4>
                        <form class="form-horizontal" id = "infoForm" action="{{url("admin/competition/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Name</label>
                                <div class="col-md-9">
                                    <input name="name" type="text" placeholder="Name" class="form-control" value = "{{$info['name']}}"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Slug</label>
                                <div class="col-md-9">
                                    <input name="slug" type="text" placeholder="Slug" class="form-control" value = "{{$info['slug']}}"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name"></label>
                                <div class="col-md-9">
                                    <textarea name = "small_description" placeholder="Small description" class = "form-control">{{$info['small_description']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name"></label>
                                <div class="col-md-9">
                                    <textarea name = "full_description" placeholder="Full description" class = "form-control">{{$info['full_description']}}</textarea>
                                </div>    
                            </div>
                            <div class = "form-group row">
                                <label class="col-md-3 control-label" for="name">Photos</label>
                                <div class="col-md-9" >
                                    <div class = "one-pic-wrapper" style = "position:relative;">
                                       <span class = "wrp" style = "padding-top:180px;">
                                           <span class="upl-selBtnWr" onclick = "onClickFilgDlg('#mainProductImg');">
                                               <label for="upl-fileInp" class="mb-0" style = "padding:10px 20px;">Add photos</label>
                                           </span>
                                           <div class="addPhotosMsgPnl" id="up-addPicMsgPanel">
                                            <p class="addUptoMsg" style="display: inline;">
                                                Add up to 12 photos
                                                We don't allow photos with extra borders, text or artwork.</p>
                                            </div>
                                       </span>
                                        <div class = "@if($info['main_image'] == '') hidden @endif" style = "position:absolute; left:0; right:0;top:0; bottom:0">
                                            <img id = "mainProductImg_img" class = "productImg" style = "width:100%;" @if($info['main_image'] != '') src = "{{correctImgPath1($info['main_image'])}}" @endif/>
                                            <input type = "hidden" id = "mainProductImg_val" class = "productImgData"  value = "{{correctImgPath1($info['main_image'])}}" />
                                        </div>
                                        <div class = " delBtnWrapper" style = "position:absolute; width:30px; right:0;height: 30px; bottom:0" onclick = "delImage(this)">
                                            <i class = "fa fa-trash cursor" ></i>
                                        </div>
                                    </div>

                                    <div class = "thumbsWrap">
                                        <ul id = "tg-thumbs" style = "margin-top:0px;">
                                            @for($i=0; $i<12; $i++)
                                                <li data-i = "{{$i}}">
                                               <span class = "tg-li">
                                                   <a class = "addPicBtn @if($i>($imgListMax+1)) hidden @endif" href = "javascript:void(0)" onclick = "onClickFilgDlg('#mainProductImg{{$i}}');">
                                                       <b>Add photos</b>
                                                   </a>
                                                   <div class = "@if($imgList[$i] == '') hidden @endif " style = "position:absolute; left:0; right:0;top:0; bottom:0">
                                                       <img id = "mainProductImg{{$i}}_img" class = "productImg subProductImg" style = "width:100%;" @if($imgList[$i] != '') src = "{{correctImgPath1($imgList[$i])}}" @endif/>
                                                       <input type = "hidden" class = "productImgData" id = "mainProductImg{{$i}}_val" value = "@if($imgList[$i] != ''){{$imgList[$i]}}  @endif" />
                                                   </div>
                                                   <div class = "@if($imgList[$i] == '') hidden @endif delBtnWrapper" style = "position:absolute; width:30px; right:0;height: 30px; bottom:0" onclick = "delImage(this,1)">
                                                       <i class = "fa fa-trash cursor" ></i>
                                                   </div>
                                               </span>

                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Normal Price</label>
                                <div class="col-md-9">
                                    <input name="normal_price" type = "number" placeholder="Normal Price" class="form-control" value = "{{$info['normal_price']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Sale Price</label>
                                <div class="col-md-9">
                                    <input name="price" type = "number" placeholder="Sale Price" class="form-control" value = "{{$info['price']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Number of tickets</label>
                                <div class="col-md-9">
                                    <input name="total_num" type = "number" @if($id*1 >0) readonly @endif placeholder="Number of tickets" class="form-control" value = "{{$info['total_num']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Deadline Date</label>
                                <div class="col-md-9">
                                    <input name="deadline_date" data-date-format="YYYY-MM-DD" placeholder="yyyy-mm-dd"  class="form-control date-picker" value = "{{$info['deadline_date']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Auto extend</label>
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"  onclick = "onclickAutoExtend(this)" @if($info['auto_extend']*1 == 1) checked @endif class="custom-checkbox" id = "auto_extend">&nbsp; Auto extend
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row @if($info['auto_extend']*1 == 0) hidden @endif">
                                <label class="col-md-3 control-label" for="name">Number of hours to extend</label>
                                <div class="col-md-9">
                                    <input name="hours_extend" type = "number"  placeholder="Number of hours to extend" class="form-control" value = "{{$info['hours_extend']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Max ticket per user</label>
                                <div class="col-md-9">
                                    <input name="max_per_user" type = "number"  placeholder="Max ticket per user" class="form-control " value = "{{$info['max_per_user']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="name">Sort tickets in number of tabs</label>
                                <div class="col-md-9">
                                    <input name="count_per_tab"  placeholder="Sort tickets in number of tabs" class="form-control" value = "{{$info['count_per_tab']}}">
                                </div>
                            </div>
                            <div class="form-position row " >
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">QA Editor</h4>
                        <div class="form-group row">
                            <label class="col-md-3 control-label" for="name">Question</label>
                            <div class="col-md-9">
                                <input name="question" type = "text"  placeholder="Question" class="form-control" value = "{{$info['question']}}">
                            </div>
                        </div>
                        <div class = "clearfix"></div>
                        <div id = "answerRect">
                            @foreach($answerList as $key => $item)
                                @if($item['answer_type']*1 == 0)
                                    <div class = "form-group row">
                                        <input type = "hidden" name = "anwer_type" value = "0"/>
                                        <input type = "hidden" name = "id" value = "{{$item['id']}}"/>
                                        <label class="col-md-3 control-label">Answer</label>
                                        <div class="col-md-6">
                                            <input type = "text"  name='answer' placeholder="Answer" class="form-control" value = "{{$item['answer']}}">
                                        </div>
                                        <div class = "col-md-1" style = "margin-top:10px;">
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" class="custom-radio"  name = "is_true" @if($item['is_true']*1 == 1) checked @endif  >&nbsp; True Answer
                                                </label>
                                            </div>
                                        </div>
                                        <div class = "col-md-2" style = "margin-top:10px;">
                                            <a class = "underline" href = "javascript:void(0)" onclick = "removeAnswer(this)">Remove</a>
                                        </div>
                                    </div>
                                @else
                                    <div class ="form-group row">
                                        <input type = "hidden" name = "anwer_type" value = "1"/>
                                        <input type = "hidden" name = "id" value = "{{$item['id']}}"/>
                                        <label class="col-md-3 control-label">Answer</label>
                                        <div class="col-md-3">
                                            <img style = "width:100px; height:100px;" id = "answerImg{{$key}}_img" src = "{{correctImgPath1($item['answer'])}}" onerror="noExitImg(this)"/>
                                            <input type = "hidden" class = "answerImgData" id = "answerImg{{$key}}_val" value = "{{$item['answer']}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <a href = "javascript:void(0)" onclick = "onClickFilgDlg('#answerImg{{$key}}');">
                                                file
                                            </a>
                                        </div>
                                        <div class = "col-md-1">
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" class="custom-radio" name = "is_true" @if($item['is_true']*1 == 1) checked @endif >&nbsp; True Answer
                                                </label>
                                            </div>
                                        </div>
                                        <div class = "col-md-2">    &nbsp;
                                            <a class = "underline" href = "javascript:void(0)" onclick = "removeAnswer(this)">Remove</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="form-position row"  style = "margin-top:10px;">
                            <div class="col-md-12 text-left">
                                <button type="button" class="btn btn-responsive btn-primary btn-sm" onclick = "addAnswerDlg();">Add Answer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("admin_panel/dlg/crop_dlg")
    @include("admin_panel/dlg/answer_type_setting")
    </section>
    
@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script  src="{{ asset('assets/vendors/summernote/summernote.min.js') }}"  type="text/javascript"></script>
    <script>
        function removeAnswer(obj){
            confirmMsg("Do you delete the item?", function(){
                    $(obj).parent().parent().remove();    
            });
            
        }
        $(document).ready(function() {
            $(".productImg").hover(function(){
                $(this).parent().next().removeClass("hidden");
            }, function(e){
                if(!$(e.relatedTarget).hasClass("delBtnWrapper")){
                    $(this).parent().next().addClass("hidden");
                }

            });

        });
        
        function addAnswerDlg(){
            $("#answerTypeSettingDlg").modal("show");
        }
        
        function onclickAutoExtend(obj){
            if($(obj).prop("checked")){
                $("input[name='hours_extend']").parent().parent().removeClass("hidden");
            }else{
                $("input[name='hours_extend']").parent().parent().addClass("hidden");
            }
        }

        function nextShowInsertImgBtn(obj){
            var liObj = $(obj).parent().parent().parent();
            var i = liObj.attr("data-i");
            if(i != '11'){
                var nextLiObj = liObj.next();
                nextLiObj.find(".addPicBtn").removeClass("hidden");
            }

        }
        $(document).ready(function() {
            $("#infoForm").validate({
                rules: {
                    name: "required",
                    slug: "required",
                    price: {required:true,number:true},
                    total_num: {required:true,digits:true},
                    max_per_user: {required:true,digits:true},
                    count_per_tab: {required:true,digits:true},
                    deadline_date: "required",
                    question: "required",
                    hours_extend: {number:true},
                },
                messages: {
                },
                errorPlacement: function (error, element) {
                    if($(element).closest('div').children().filter("div.error-div").length < 1)
                        $(element).closest('div').append("<div class='error-div'></div>");
                    $(element).closest('div').children().filter("div.error-div").append(error);
                },
                submitHandler: function(form){
                    var auto_extend = $(form).find("#auto_extend").prop("checked");
                    if(auto_extend){
                        var hours_extend = $("input[name='hours_extend']").val();
                        if(hours_extend == ""){
                            errorMsg("Please input the Hours Extend");
                            return;
                        }
                    }
                    var datas = new FormData();
                    datas.append('_token', _token);

                    var url = $(form).attr("action");
                    url += "?"+$(form).serialize();

                    //datas.append('param', JSON.stringify(param));
                    $(".productImgData").each(function(){
                        datas.append($(this).attr("id"), $(this).val());
                    });
                    var answerParam = getAnswerParam();
                    if(answerParam.status == "0"){
                        errorMsg(answerParam.msg);
                        return;
                    }else{
                        datas.append("answerList", JSON.stringify(answerParam.list));
                        datas.append("question", answerParam.question);
                    }

                    loading_start();
                    $.ajax({
                        url: url,
                        data: datas,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        type: 'POST',
                        beforeSend: function (data, status) {
                        },
                        success: function (data) {
                            loading_stop();
                            if (data.status == 1) {
                                successMsg(data.msg, function(){
                                    window.location.href = "{{url("admin/competition")}}";
                                });
                            } else {
                                errorMsg(data.msg);
                                return false
                            }
                        },
                        error: function (data, status, e) {
                            loading_stop();
                            errorMsg("errors happens");
                            return false;
                        }
                    });
                    return false;
                }
            });
        })
        
        
        function getAnswerParam(){
            var ret = new Object();
            var answerList = new Array();
            var result = true;
            var answer = "";
            var anwer_type = "";
            var is_true = "";
            var true_count = 0;
            var id = 0;
            var ele = new Object();
            var question = $("input[name='question']").val();
            if(question == ""){
                ret.status = "0";
                ret.msg = "Please input the question";
                return ret;
            }
            if($("#answerRect .form-group").length==0){
                ret.status = "0";
                ret.msg = "Please add answer";
                return ret;
            }
            $("#answerRect .form-group").each(function(){
                ele = new Object();
                answer_type = $(this).find("input[name='anwer_type']").val();
                if(answer_type=="0"){
                    answer = $(this).find("input[name='answer']").val();
                }else{
                    answer = $(this).find(".answerImgData").val();
                }
                if(answer == ""){
                    result = false;
                }
                is_true = 0;
                if($(this).find("input[type='radio']").prop("checked")){
                    is_true = 1;
                }
                if(is_true == 1){
                    true_count++;
                }
                id = 0;
                if($(this).find("input[name='id']").length > 0){
                    id = $(this).find("input[name='id']").val();
                }
                ele.id = id;
                ele.is_true = is_true;
                ele.answer_type = answer_type;
                ele.answer = answer;
                answerList[answerList.length] = ele;
            });
            
            if(!result){
                ret.status = "0";
                ret.msg = "Please write all the answer filled";
                return ret;
            }
            
            if(true_count == 0 || true_count > 1){
                ret.status = "0";
                ret.msg = "True answer only one";
                return ret;
            }
            
            ret.status = "1";
            ret.list = answerList;
            ret.question = question;
            return ret;
        }
        function delImage(obj, isSubImg){
            $(obj).prev().find("img").attr("src", "");
            $(obj).prev().find("img").next().val("");
            $(obj).prev().addClass("hidden");
            $(obj).addClass("hidden");

        }

        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop

