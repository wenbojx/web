$(document).ready(function() {

})
function loadModalWin(id, url, title, width, height) {
    if( $("#"+id).is(":visible") ){
        return false;
    }
    new Boxy.load(url, {
        id:id,
        modal: false,
        title:title,
        closeText:"×",
        y:30,
        width:width,
        height:height
    });
};
function save_datas(url, data, element_id, msg, type, dataType){
    if (!url){
        done_error(element_id, msg.error);
    }
    type = type ? type : 'post';
    dataType = dataType ? dataType : 'json';
    $.ajax({
        url: url,
        type: type,
        data: data,
        dataType: dataType,
        //timeout: 1000,
        error: function(){
            done_error(element_id, msg.error);
        },
        success: function(datas){
            done_success(element_id, msg.success, datas);
        }
    });
}
function done_error(element_id, msg){
    $("#"+element_id).html(msg);
    //setTimeout( clean_msg_box(element_id), 50000);
}
function done_success(element_id, msg, datas){
    if(datas.flag == '0'){
        msg = datas.msg;
        done_error(element_id, msg);
    }
    $("#"+element_id).html(msg);
    //setTimeout( clean_msg_box(element_id), 50000);
}
function clean_msg_box(element_id){
    $("#"+element_id).html('');
}


