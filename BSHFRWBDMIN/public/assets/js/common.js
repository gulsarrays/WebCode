$(document).ready(function(){
	$("#sort").change(function(){
		url = baseUrl + '/users/' + $("#sort").val();
		if($("#search").val().length > 0) {
		    var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                url = baseUrl + '/users/' + $("#sort").val();
            }
            else{
			url = url + '/' + $("#search").val();
            }
		}
		window.location.href = url;
	}); 
	$("#sort-group").change(function(){
		url = baseUrl + '/groups/' + $("#sort-group").val();
		if($("#search").val().length > 0) {
		    var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                url = baseUrl + '/groups/' + $("#sort-group").val();
            }
            else{
			url = url + '/' + $("#search").val();
            }
		}
		window.location.href = url;
	}); 
	$("#sort-chat").change(function(){
        url = baseUrl + '/chat-history/' + $("#sort-chat").val();
        if($("#search-from").val().length > 0) {
            var str = $("#search-from").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                url = baseUrl + '/chat-history/' + $("#sort-chat").val();
            }
            else{
            url = url + '/' + $("#search-from").val();
            }
        }
        window.location.href = url;
    }); 
	$("#sort-group_by_id").change(function(){
        url = baseUrl + '/group/' +$("#groupid").val() +'/'+ $("#sort-group_by_id").val();
        if($("#search").val().length > 0) {
            var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                url = baseUrl + '/group/' +$("#groupid").val() +'/'+ $("#sort-group_by_id").val();
            }
            else{
            url = url + '/' + $("#search").val();
            }
        }
        window.location.href = url;
    }); 
	$('#search-group-by-id').on('submit', function(e){
        e.preventDefault();
        if($("#search").val().length > 0) {
            var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                window.location.href = baseUrl + '/group/' + $("#groupid").val()+'/'+ $("#sort-group_by_id").val();
            }
            else{
            window.location.href = baseUrl + '/group/' + $("#groupid").val() +'/'+ $("#sort-group_by_id").val()+ '/' + $("#search").val();
            }
        } else {
            alert("Please type any keyword to search");
            window.location.href = baseUrl + '/group/' + $("#groupid").val()+'/'+ $("#sort-group_by_id").val();
        }
    });
	$("#sort-group-details").change(function(){
	    id = $("#group-id").val()
        url = baseUrl + '/group-details/' + id +'/' + $("#sort-group-details").val();
        if($("#search").val().length > 0) {
            var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                url = baseUrl + '/group-details/' + id +'/' + $("#sort-group-details").val();
            }
            else{
            url = url + '/' + $("#search").val();
            }
        }
        window.location.href = url;
    }); 

	$('#searchuser').on('submit', function(e){
	    e.preventDefault();
	    if($("#search").val().length > 0) {
	        var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                window.location.href = baseUrl + '/users/' + $("#sort").val();
            }
            else{
	    	window.location.href = baseUrl + '/users/' + $("#sort").val() + '/' + $("#search").val();
            }
	    } else {
	    	alert("Please type any keyword to search");
	    	window.location.href = baseUrl + '/users/' + $("#sort").val();
	    }
	});
	
	   $('#search-chat').on('submit', function(e){
	        e.preventDefault();
	        url = baseUrl + '/chat-history/' +  $("#sort-chat").val();
	        if($("#search-from").val().length > 0) {
	            var str = $("#search-from").val();
	            if(/^[a-zA-Z0-9- ]*$/.test(str) === false) {
	                alert('Your search string contains illegal characters.');
	                window.location.href = baseUrl + '/chat-history/' + $("#sort-chat").val();
	            }
	            else{
	            window.location.href = baseUrl + '/chat-history/' + $("#sort-chat").val() + '/' + $("#search-from").val();
	            }
	        } else {
	            alert("Please type any keyword to search");
	            window.location.href = url;
	        }
	    });
	   
	   $('#search-chat-date').on('submit', function(e){
           e.preventDefault();
           url = baseUrl + '/chat-history/' +  $("#sort-chat").val();
          if($("#from-date").val().length > 0) {
              window.location.href = url + '/' +'null'+'/' + $("#from-date").val()+'/'+$("#to-date").val();
	        }
          else{
              window.location.href = url + '/' +'null'+'/' + 'null'+'/'+$("#to-date").val();
          }

       });
	$('#search-contact').on('submit', function(e){
	    e.preventDefault();
	    id = $("#user-id").val()
	    if($("#search").val().length > 0) {
	        var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                window.location.href = baseUrl+'/'+id + '/contacts';
            }else{
	    	window.location.href = baseUrl+'/'+id + '/contacts/'+ $("#search").val();
            }
	    } else {
	    	alert("Please type any keyword to search");
	    	window.location.href = baseUrl+'/'+id + '/contacts';
	    }
	});
	$('#search-group').on('submit', function(e){
	    e.preventDefault();
	    if($("#search").val().length > 0) {
	        var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                window.location.href = baseUrl + '/groups/' + $("#sort-group").val();
            }
            else{
	    	window.location.href = baseUrl + '/groups/' + $("#sort-group").val() + '/' + $("#search").val();
            }
	    } else {
	    	alert("Please type any keyword to search");
	    	window.location.href = baseUrl + '/groups/' + $("#sort-group").val();
	    }
	});
	$('#search-group-contact').on('submit', function(e){
	    e.preventDefault();
	    id = $("#group-id").val()
	    if($("#search").val().length > 0) {
	        var str = $("#search").val();
            if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
                alert('Your search string contains illegal characters.');
                window.location.href = baseUrl + '/group-details/' + id ;
            }else{
	    	window.location.href = baseUrl + '/group-details/' + id + '/'+ $("#sort-group-details").val() +'/' + $("#search").val();
            }
	    } else {
	        alert("Please type any keyword to search");
	    	window.location.href = baseUrl + '/group-details/' + id ;
	    }
	});
	
	$('.confirm').click(function() {
        return window.confirm("Are you sure you want to do this action?");
    });
	
	$( "#deleteall" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one user.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#manage-datas" ).submit();
			}
		}
	});	
	
	$( "#deleteallagenda" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Agenda.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#agenda-datas" ).submit();
			}
		}
	});	
	
	$( "#deleteallreadview" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one pre read view.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#read-view-datas" ).submit();
			}
		}
	});	
	
	$( "#deleteallsurveys" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one survey.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#surveys-datas" ).submit();
			}
		}
	});
	
	$( "#survey-questions-delete-all" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Survey question.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#survey-questions-datas" ).submit();
			}
		}
	});
	
	$( "#delete-all-quiz-category" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Quiz Category.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#category-datas" ).submit();
			}
		}
	});
	
	$( "#quiz-delete-all" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Quiz.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#quiz-datas" ).submit();
			}
		}
	});
	
	$( "#delete-all-tasks" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Task.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#tasks-datas" ).submit();
			}
		}
	});
	
	$( "#delete-all-consume" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least Media.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#consume-datas" ).submit();
			}
		}
	});
	
	$( "#delete-ar-triggers" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one AR-Trigger.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#trigger-datas" ).submit();
			}
		}
	});
	
	$( "#delete-video-studies" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Video case studies.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#video-studies" ).submit();
			}
		}
	});
	
	$( "#delete-all-clients" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Client.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#delete-clients" ).submit();
			}
		}
	});
	
	$( "#delete-all-maxims" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Maxims.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#delete-maxims" ).submit();
			}
		}
	});
	
	$( "#delete-all-founders" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Founder.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#delete-founders" ).submit();
			}
		}
	});
	
	$( "#delete-all-tasks-geo" ).click(function() {
		if($('input[type="checkbox"]:checked').length == 0) {
			alert("Please select at least one Tasks Geo.");
			return false;
		} else {
			if(window.confirm("Are you sure you want to do this action?")) {
				$( "#geo-tasks-geo-datas" ).submit();
			}
		}
	});
	
	$('#read-view-image').change(function() { 
		$( "#read-view-upload" ).submit();
	});
	
	$( ".pre-read-view-delete" ).click(function() {
		if(window.confirm("Are you sure you want to do this action?")) {
			var id = $(this).attr('id');
			window.location.href = baseUrl + '/pre-read-views/images/delete/'+id;
		}
	});
	
	$('#read-consume-image').change(function() { 
		$( "#read-consume-upload" ).submit();
	});
	$('.cancel_btn').click(function(){    
	      history.go(-1);
});


$('#confirm-delete').on('show.bs.modal', function(e) {
  $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
$('#confirm-change').on('show.bs.modal', function(e) {
  $(this).find('.btn-yes').attr('href', $(e.relatedTarget).data('href'));
});
$('.multiselectall').change(function(){
	if($('.multiselectall').prop('checked')){
		$('.multiselect').each(function(){
			$(this).prop('checked',true);
		})
	}
	else{
		$('.multiselect').each(function(){
			$(this).prop('checked',false);
		})
	}
});
$('.multiselect').click(function(){
	if($(this).prop('checked')){
		if($('#total_data_count').val()==$('.multiselect:checked').length){
			$('.multiselectall').prop('checked',true);
		}
	}
	else{
		$('.multiselectall').prop('checked',false);
	}
})
$('.deleteAll').click(function(){
	var val ='';
    $('.multiselect:checked').each(function(i){
      val = val+$(this).val()+'~';
    });
   if(val.length>0){
	   var url=$('.deleteAll').data('href');
	   url=url+"/"+val;
	   $('#confirm-delete').modal('show');
	   $('.btn-ok').click(function(){
		 $('.btn-ok').attr('href',url);
	   }); 
   }
   else{
	   alert("Please select atleast one checkbox");
   }
});
$('#log-out').click(function(){
	var url=$('#log-out').data('href');
	   $('#confirm-logout').modal('show');
	   $('.btn-ok').click(function(){
		 $('.btn-ok').attr('href',url);
	   }); 
  
});
$('#message_slim').slimscroll({
  height: '100%',
  width: '100%',
  railVisible: true,
  alwaysVisible: true,
  start: 'bottom',
  allowPageScroll: true  
});
});

$(document).ready(function(){
	$(".sidebar-toggle").click(function(){
		$('.sidebar-menu').toggleClass('menu-collapse');
	})
})
