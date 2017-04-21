
var blockOuter = $('.sort-wrap');
var sortAjax = 0;
if(blockOuter.hasClass('ajax')){
    sortAjax = 1;
}
function  afterFilterSend (data){
    if(sortAjax!=1){
        return false;
    }
    $('.sort-wrap').html($(data).find('.sort-wrap').html())
    if (typeof afterSortUpdate == 'function') {
        afterSortUpdate();
    }
    if($('#eFiltr_results').length){
        var scroll_el = $('#eFiltr_results')
        if ($(scroll_el).length != 0) {
            $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 500);
        }
    }
}
$('body').on('click change','.set-display-field',function (event) {
    var val;
    var status = false;
    if(event.type=='change' && $(this).val()!='0' && $(this).val()!='' && typeof $(this).val() !='undefined' && $(this).val()!=null){ //у нас selected
        val = $(this).val()
        status = true;
    }
    if(event.type=='click' && $(this)[0].tagName=='A'){ //клик по кнопке
        val = $(this).data('value')
        status = true;
    }
    if(status==true){
        event.preventDefault()
        var filter = $('#eFiltr');
        if(filter.length && sortAjax==1){//на странице есть форма eFiltre
            filter.prepend('<input name="sortDisplay" value="'+val+'" />')
            filter.submit()
        }
        else { //обновляем постом
            $.post(location.href,{sortDisplay:val},function () {
                location.reload()
            })
        }
    }
})
$('body').on('click change','.set-sort-field',function (event) {
    var val;
    var status = false;
    if(event.type=='change' && $(this).val()!='0' && $(this).val()!='' && typeof $(this).val() !='undefined' && $(this).val()!=null){ //у нас selected
        val = $(this).val()
        status = true;
    }
    if(event.type=='click' && $(this)[0].tagName=='A'){ //клик по кнопке
        val = $(this).data('value')
        status = true;
    }
    if(status==true){
        event.preventDefault()
        var filter = $('#eFiltr');
        if(filter.length && sortAjax==1){//на странице есть форма eFiltre
            filter.prepend('<input name="sortBy" value="'+val+'" />')
            filter.submit()
        }
        else{
            $.post(location.href,{sortBy:val},function () {
                location.reload()
            })
        }
    }
})
