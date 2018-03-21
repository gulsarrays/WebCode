jQuery(document).ready(function($){

    // Date Picker
    $(".start-date").datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose:true, 
        showOtherMonths: true,
        selectOtherMonths: true
    })
    .attr('readonly', 'readonly');
    
    $(".end-date").datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose:true,
        showOtherMonths: true,
        selectOtherMonths: true
    })
    .attr('readonly', 'readonly');

    
    var offset = 300,
    offset_opacity = 1200,
    scroll_top_duration = 700,
    $back_to_top = $('.to-top');

    $(window).scroll(function(){
      ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('visible') : $back_to_top.removeClass('visible');
      if( $(this).scrollTop() > offset_opacity ) { 
         $back_to_top.addClass('visible');
     }
 });

    $back_to_top.on('click', function(event){
      event.preventDefault();
      $('body,html').animate({
         scrollTop: 0 ,
     }, scroll_top_duration
     );
  });


    /*----------------checkbox for form selection------------------*/
    $(".selectioncontainer :checkbox").change(function() {
        var str="<ul>";
        var arr = $(".selectioncontainer :checkbox:checked").map(function() { return $(this).next().text(); }).get();
        $.each( arr, function( key, i ) {
          str = str + "<li>"+i+"<span class='remove'>x</span></li>";
      });
        str = str + "</ul>";
        $("#listselected").html(str);

        $('#listselected li').on("click",".remove",function(){
          td.removeClass("rowSelected");
          $(".selectioncontainer :checkbox:checked").removeAttr("checked");
          $(this).parent().remove();
      });

        var td = $(this).parent(); 
        if (td.is('.rowSelected'))      
          td.removeClass("rowSelected");      
      else        
          td.addClass("rowSelected"); 
  });  

});

