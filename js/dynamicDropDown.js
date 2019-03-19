var LIST1_URL = "./server/list1.php";
var LIST2_URL = "./server/list2.php";
var LIST3_URL = "./server/list3.php";
var LIST4_URL = "./server/list4.php";

var dropDownDiv = "div_dynamic_dropDown"
var list1_div= "div_dropDown_1";
var list2_div = "div_dropDown_2";
var list3_div = "div_dropDown_3";
var list4_div = "div_dropDown_4";

var DEFAULT = 'default';


$( document ).ready(function() {
    console.log( "ready!" );
    
    fill_list1();			//Dynamically filling list1 
    clearAndDisableDropDown(dropDownDiv, list2_div);	//Clearing and disabling list2
    clearAndDisableDropDown(dropDownDiv, list3_div); 	//Clearing and disabling list3
	clearAndDisableDropDown(dropDownDiv, list4_div); 	//Clearing and disabling list4
	    
    /*
    	Attaching on change event to parent, so selecting any option will trigger this
    	After that depending on the option selected will display list in list2
    */ 
    $("#"+list1_div+" select").change(function(){
    	fill_list2($(this).val());
    });

    /*
    	Attaching on change event to parent, so selecting any option will trigger this
    	After that depending on the option selected will display list in list3
    */
    $("#"+list2_div+" select").change(function(){
    	var list1_value = $("#"+dropDownDiv + " #"+list1_div+" select option:selected").val();
    	fill_list3(list1_value,$(this).val());
    });

    /*
    	Attaching on change event to parent, so selecting any option will trigger this
    	After that depending on the option selected will display list in list4
    */
    $("#"+list3_div+" select").change(function(){
    	var list1_value = $("#"+dropDownDiv + " #"+list1_div+" select option:selected").val();
    	var list2_value = $("#"+dropDownDiv + " #"+list2_div+" select option:selected").val();
    	fill_list4(list1_value,list2_value,$(this).val());
    });
});


// This mehotd fills list1 by getting options from LIST1_URL 
function fill_list1(){
	fill_list(LIST1_URL, {'option':''} , list1_div);
}

/*
	parentOption : val of option selected in list1
	This method get options for list2 from LIST2_URL as per the parentOption supplied
	and disable List3
*/
function fill_list2(parentOption) {
	if( parentOption != DEFAULT ) {
		fill_list(LIST2_URL, {'option':parentOption} , list2_div);
	} else {
		clearAndDisableDropDown(dropDownDiv, list2_div);
	}

	clearAndDisableDropDown(dropDownDiv, list3_div);
	clearAndDisableDropDown(dropDownDiv, list4_div);
}


/*
	This method get options for list3 from LIST3_URL as per the list1 and list2 values supplied
*/
function fill_list3(list1_value,list2_value) {
	if( list2_value != DEFAULT ) {
		fill_list(LIST3_URL, {'option':list1_value+"#"+list2_value} , list3_div);
	}else {
		clearAndDisableDropDown(dropDownDiv, list3_div);
	}
	clearAndDisableDropDown(dropDownDiv, list4_div);
}

function fill_list4(list1_value, list2_value, list3_value) {
	if( list3_value != DEFAULT ) {
		fill_list(LIST4_URL, {'option':list1_value+"#"+list2_value+"#"+list3_value} , list4_div);
	}else {
		clearAndDisableDropDown(dropDownDiv, list4_div);
	}
}

/*
	Generic method that fetch options using ajax call that need to be displayed as drop down
*/
function fill_list(link, data, list_div) {
	$.ajax({
		type:"GET",
		url: link,
		dataType:"json",
		data : data,
		success:function(result){
			
			//clearing the drop down before appending new list 
			clearDropDown(dropDownDiv, list_div);

			for( key in result ) {
				appendToSelect(dropDownDiv, list_div , key , result[key]);
			}
		},
		failure:function(result){
			alert('Error Occured while fetching Parent List see logs');
			console.log("failure result:"+result);
		}
	});
}

/*
	Generic method to clear and disable drop Down list
*/
function clearAndDisableDropDown(parentId, id) {
	//$("#" + parentId + " #" + id +" select").find('option').append("<option val='none'>None").attr('disabled' , 'disabled');
	clearDropDown(parentId, id);
	$("#" + parentId + " #" + id +" select").append("<option val='defult'>Empty").attr('disabled' , 'disabled');
}

function clearDropDown(parentId, id){
	$("#" + parentId + " #" + id +" select").removeAttr('disabled');
	$("#" + parentId + " #" + id +" select").find('option').remove();
}

/*
	Generic method to add options to select tag in html
*/
function appendToSelect(parentId, id, optionValue, optionTitle){
	var option = "<option value="+optionValue+">"+optionTitle+"</option>";
	$("#"+parentId + " #"+id + " select").append(option);
}
