// alert(plugin_data.ajax_url);

;(function($){
    $(document).ready(function(){
        $('.action_button').on('click',function(){
            let task = $(this).data('task');
            window[task]();
        });
    });
})(jQuery);

function demo_data(){
    var $ = jQuery;
    $.post(
        plugin_data.ajax_url, {'action' : 'aj_simple' ,'data' : 'hello world'}, function(data){
            console.log(data);
            $('.mydata').html(data);
        }
    )
}
function more_data(){
    var $ = jQuery;
    $.ajax({
        url: plugin_data.ajax_url,
        method: 'POST',
        data:{
            'action' : 'ajax_more',
            'data' : 'more name'
        },
        success: function(data){
            console.log(data);
            $('.moredata').html(data.a_name);
        }
    })
}
function ajax_nonce(){
    var $ = jQuery;
    $.ajax({
        url: plugin_data.ajax_url,
        method: 'POST',
        data:{
            'action' : 'aj_protected',
            'data' : 'more name',
            'a_nonce' : plugin_data.aj_nonce
        },
        success: function(data){
            console.log(data);
            $('.securedata').html(data);
        }
    })
}