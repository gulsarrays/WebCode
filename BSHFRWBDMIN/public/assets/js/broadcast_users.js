function getListUsers(url){		
	var userData = "";
	var groupData = "";
	var numbers_selected = [];
	var groups_selected = [];
	
	//var previous_value = $('#selected_list').text(); 
	var previous_value = $('#selected_list_users').val();
	var split_value    = previous_value.split(',');
	for(j=0;j < split_value.length; j++){		
		var phone_numbers_split = split_value[j].split('_');		
		numbers_selected.push(phone_numbers_split[2]);		
	}	
	var previous_group_value = $('#selected_list_group').val();
	var group_split_value    = previous_group_value.split(',');
	for(k=0;k < group_split_value.length; k++){		
		var groups_split = group_split_value[k].split('_');			
		groups_selected.push(groups_split);		
		
	}
	
	$('#userlist_Modal').modal('show');
	
	$.ajax({
		type: "GET",
		data: {
			
		      format: 'json'
		},
		dataType: 'json',
        url: url+"/broadcast/broadcastusers",
                
        success: function (data) {
        	 userData = data;        	         	 
        	for (var i = 0; i < userData.users_details.user_details.length; i++) {        		
        		var name = userData.users_details.user_details[i]['name'];
        		var username = userData.users_details.user_details[i]['username'];
        		var mobile = userData.users_details.user_details[i]['mobile'];   
        		var user_image = userData.users_details.user_details[i]['image'];      		
        		var user_id = "user_names_"+username;        		
        		var k=0;
        		
        		for(var j=0;j<numbers_selected.length;j++){        			
        			if(numbers_selected[j] == mobile){        				
        				var checked = "checked";
        				var checkBox = "<input checked type=checkbox id=users_list onclick=refreshWindow('"+url+"') name=users_list value="+user_id+">";
        				console.log(checked);
        				k=1;
        			}
        			else if(k==0){            				
        				var checkBox = "<input type=checkbox id=users_list onclick=refreshWindow('"+url+"') name=users_list value="+user_id+">";        				
        			}        			
        		}
        		
        		$('#mobile_numbers').append('<tr>'+'<td>'+checkBox+name+'</td>'+'<td>'+mobile+'</td>'+'<td><img src="'+user_image+'"/></td>'+'</tr>');
        	}        	
        	           
        },
        error: function(data) {
        	
		   },
		   complete: function(data) {
			  
			   
		   }
	});
	
	$.ajax({
		type: "GET",
		data: {
			
		      format: 'json',
		      numbers_selected:numbers_selected
		      
		},
		dataType: 'json',
        url: url+"/broadcast/broadcastusers/getGroups",
                
        success: function (groups) {
        	 groupData = groups;
        	         	 
        	 for (var group_iterate = 0; group_iterate < groupData.group_details.data.length; group_iterate++) {
        		 var group_name = groupData.group_details.data[group_iterate].name;
        		 var group_image = groupData.group_details.data[group_iterate].image;
        		 var username = groupData.group_details.data[group_iterate].username;
        		 var group_id = "group_names_"+username;
        		 
        		 
        		 var groupk=0;
        		 
        		 for(var groupj=0;groupj<groups_selected.length;groupj++){   
        			 
        			 if(groups_selected[groupj] == username){        				 
        				 var checked = "checked";
        				 var group_checkBox = "<input checked onclick=refreshWindowGroups('"+url+"') type=checkbox id=group_list name=group_list value="+group_id+">";
        				 groupk=1;
        			 }
        			 else if(groupk ==0){
        				 var group_checkBox = "<input onclick=refreshWindowGroups('"+url+"') type=checkbox id=group_list name=group_list value="+group_id+">";
        			 }
        			 
        		 }
        		         		         		 
        		 $('#groups').append('<tr>'+'<td>'+group_checkBox+group_name+'</td>'+'<td><img src="'+group_image+'"/></td>'+'</tr>');
        		 
        	 }
        },
        error: function(data) {
        	
		},
		complete: function(data) {			  
			   
		}
	});
	
}
function doRefresh(url){
	$('#userlist_Modal').modal('hide');
	
	$('#mobile_numbers').empty();
	
	$('#groups').empty();
	
	
    	
}

function getNameFilter(){	
	var input, filter, table, tr, td, i;
	input = document.getElementById("name_filter");
	filter = input.value.toUpperCase();
	table = document.getElementById("mobile_numbers");
	tr = table.getElementsByTagName("tr");
	
	for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
}
function getPhoneFilter(){
	
	var input, filter, table, tr, td, i;
	input = document.getElementById("Phone_filter");
	filter = input.value.toUpperCase();
	table = document.getElementById("mobile_numbers");
	tr = table.getElementsByTagName("tr");
	
	for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
}

function getGroupFilter(){	
	var input, filter, table, tr, td, i;
	input = document.getElementById("group_filter");
	filter = input.value.toUpperCase();
	table = document.getElementById("groups");
	tr = table.getElementsByTagName("tr");
	
	for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
}

function refreshWindow(url){	
	var selected_list = $("input[name=users_list]:checked").map(
			     function () {return this.value;}).get().join(",");
	var numbers_selected = [];
	var split_value    = selected_list.split(',');
	
	for(j=0;j < split_value.length; j++){
		
		var phone_numbers_split = split_value[j].split('_');		
		numbers_selected.push(phone_numbers_split[2]);
		
	}	
	$.ajax({
		type: "GET",
		data: {
			
		      format: 'json',
		      numbers_selected:numbers_selected
		      
		},
		dataType: 'json',
        url: url+"/broadcast/broadcastusers/setsession",
                
        success: function (data) {
        	 userData = data;
        	 $('#selected_list').empty();
        	 for (var i = 0; i < userData.users_details.user_details.length; i++) {        		 
        		 var name = userData.users_details.user_details[i]['name'];
        		 var username = userData.users_details.user_details[i]['username'];
         		 var mobile = userData.users_details.user_details[i]['mobile'];  
         		 var pass_val = "'"+username+"'";         		 
         		//$('#selected_list').append('<tr>'+'<td>'+name+'</td>'+'<td>'+mobile+'</td>'+'</tr>');
         		$('#selected_list').append('<tr><td id=selected_list_'+username+'><td>'+name+'</td>'+'<td>'+mobile+'</td>'+'<td><a onclick="removeSelectedUser('+pass_val+')" class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" title="Delete" ></a></td></tr>');
        	 }
        	 
        },
        error: function(data) {
        	
		},
		complete: function(data) {			  
			   
		}
	});
	//console.log(numbers_selected);
	//$('#selected_list').html(selected_list);
	$('#selected_list_users').val(selected_list);
}

function refreshWindowGroups(url){
	var selected_list = $("input[name=group_list]:checked").map(
		     function () {return this.value;}).get().join(",");	
	
	var groups_selected = [];
	var split_value    = selected_list.split(',');
	
	for(j=0;j < split_value.length; j++){
		
		var groups_split = split_value[j].split('_');
		
		groups_selected.push(groups_split[2]);
		
		$.ajax({
			
			type: "GET",
			data: {
				
			      format: 'json',
			      groups_selected:groups_selected
			      
			},
			dataType: 'json',
	        url: url+"/broadcast/broadcastusers/getgroupssession",
	        success: function (data) {
	           groupData = data;
	           $('#selected_group').empty();
	           console.log(groupData.group_details);
	           for (var group_iterate = 0; group_iterate < groupData.group_details.length; group_iterate++) {
	        		 var group_name = groupData.group_details[group_iterate].name;
	        		 var group_image = groupData.group_details[group_iterate].image;
	        		 var username = groupData.group_details[group_iterate].username;
	        		 var pass_val = "'"+username+"'";
	        		 //$('#selected_group').append('<tr>'+'<td>'+group_name+'</td>'+'<td>'+group_image+'</td>'+'</tr>');
	        		 $('#selected_group').append('<div id=selected_group_'+username+'><div>'+group_name+'</div><div>'+group_image+'</div><a onclick="removeSelectedGroup('+pass_val+')" class="btn btn-box-tool fa fa-trash text-yellow" data-toggle="modal" title="Delete" ></a></div>');
	        		 
	        	 }
	        }
			
		});
		
	}
	
	$('#selected_list_group').val(groups_selected);

}
function removeSelectedUser(user){	
	var numbers_selected = [];
	var removed_val = [];
	var $hiddenValuesUsers=[];
	var previous_value = $('#selected_list_users').val();
	var split_value    = previous_value.split(',');
	for(j=0;j < split_value.length; j++){		
		var phone_numbers_split = split_value[j].split('_');
		numbers_selected.push(phone_numbers_split[2]);
	}
	for (var i=numbers_selected.length-1; i>=0; i--) {		
	    if (numbers_selected[i] == user) {	    	
	    	numbers_selected.splice(i, 1);
	    	$( "#selected_list_"+user ).remove();
	        
	    }
	}
	
	for(var array_length = 0; array_length < numbers_selected.length; array_length++ ){		
		$hiddenValuesUsers.push("user_names_"+numbers_selected[array_length]);
	}	
	$('#selected_list_users').val($hiddenValuesUsers);
		
}

function removeSelectedGroup(user){	
	var numbers_selected = [];
	var removed_val = [];
	var $hiddenValuesUsers=[];
	var previous_value = $('#selected_list_group').val();
	var split_value    = previous_value.split(',');	
	
	for(j=0;j < split_value.length; j++){		
		var phone_numbers_split = split_value[j].split('_');		
		numbers_selected.push(phone_numbers_split);
	}
	for (var i=numbers_selected.length-1; i>=0; i--) {		
	    if (numbers_selected[i] == user) {	    	
	    	numbers_selected.splice(i, 1);
	    	$( "#selected_group_"+user ).remove();
	        
	    }
	}
	
	for(var array_length = 0; array_length < numbers_selected.length; array_length++ ){		
		$hiddenValuesUsers.push("group_names_"+numbers_selected[array_length]);
	}	
	$('#selected_list_group').val($hiddenValuesUsers);
		
}

