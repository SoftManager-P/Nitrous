<div class="modal in" id="answerTypeSettingDlg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Answer Type Setting Dialog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                
            </div>
            <div class="modal-body">
                <div class="form-group row label-floating">
                    <label class="control-label">Type: </label>
                    <select name = "answer_type" class = "form-control">
                        <option value = "0">Text</option>
                        <option value = "1">Image</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                <button type="button" class="btn btn-primary" onclick = "addAnswer()">Ok</button>
            </div>
        </div>
    </div>
</div>

<script>
    function addAnswer(){
        var answer_type = $("#answerTypeSettingDlg [name = 'answer_type']").val();
        var answer_count = $("#answerRect .form-group").length;
        answer_count = parseInt(answer_count)+1;
        if(answer_type == "0"){
            html = genTextItem(answer_count);
        }else{
            html = getImgItem(answer_count);
        }
        $("#answerRect").append(html);
        $("#answerTypeSettingDlg").modal("hide");
    }
    
    function genTextItem(answerCount){
        var html = `<div class = "form-group row">
                        <input type = "hidden" name = "anwer_type" value = "0"/>
                        <label class="col-md-3 control-label">Answer</label>
                        <div class="col-md-6">
                            <input type = "text" name = "answer"  placeholder="Answer" class="form-control" value = "">
                        </div>
                        <div class = "col-md-1" style = "margin-top:10px;">
                            <div class="radio-inline">
                                <label>
                                    <input type="radio" class="custom-radio"  name = "is_true" >&nbsp; True Answer
                                </label>
                            </div>
                        </div>
                        <div class = "col-md-2" style = "margin-top:10px;">
                            <a class = "underline" href = "javascript:void(0)" onclick = "removeAnswer(this)">Remove</a>
                        </div>
                    </div>`;
        return html;
    }
    
    function getImgItem(answerCount){
        var html =`<div class ="form-group row">
                        <input type = "hidden" name = "anwer_type" value = "1"/>
                        <label class="col-md-3 control-label">Answer</label>
                        <div class="col-md-3">
                            <img style = "width:100px; height:100px;" id = "answerImg${answerCount}_img"/>
                            <input type = "hidden" class = "answerImgData" id = "answerImg${answerCount}_val" value = "" />
                        </div>
                        <div class="col-md-3">
                            <a href = "javascript:void(0)" onclick = "onClickFilgDlg('#answerImg${answerCount}');">
                                file
                            </a>
                        </div>
                        <div class = "col-md-1">
                            <div class="radio-inline">
                                <label>
                                    <input type="radio" class="custom-radio" name = "is_true" >&nbsp; True Answer
                                </label>
                            </div>
                        </div>    
                        <div class = "col-md-2">    &nbsp;
                            <a class = "underline" href = "javascript:void(0)" onclick = "removeAnswer(this)">Remove</a>
                        </div>
                    </div>`;
        return html;
    }
</script>