/**
 * Created by DELL on 2017/3/31.
 */
$(function(){
    
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elems.forEach(function(html) {
        var switchery = new Switchery(html);
    });

});
