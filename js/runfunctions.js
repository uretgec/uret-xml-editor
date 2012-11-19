$(document).ready(function(){
	var uadd = $("a#add");
	var udelete = $("a#delete");
	var uconfig = $("#config");
	var tag_type = $("#tag_type");
	var add_new = $("#add_new a");

	uadd.live('click',function(){
		var config_count = $(".config").length;
		uconfig.append('<li class="config" id="u'+config_count+'"><p><label for="title_name">Title</label>:<input name="u'+config_count+'[title_name]" id="title_name"><span class="desc">Write input label title</span></p><p><label for="tag_name">Tag Name</label>:<input name="u'+config_count+'[tag_name]" id="tag_name"><span class="desc">Write xml element name</span></p><p><label for="tag_desc">Tag Desc</label>:<input name="u'+config_count+'[tag_desc]" id="tag_desc"><span class="desc">Write this option description</span></p><p><label for="tag_type">Tag Type</label>:<select name="u'+config_count+'[tag_type]" id="tag_type"><option value="text">Text Box</option><option value="textarea">Textarea</option><option value="selectbox">Selectbox</option><option value="radio">Radio Box</option><option value="checkbox">Check Box</option><option value="image">Image Box</option><option value="multitext">Multi Text Box</option><option value="multitextarea">Multi Textarea</option><option value="multiselectbox">Multi Selectbox</option><option value="multiradio">Multi Radio Box</option><option value="multicheckbox">Multi Check Box</option><option value="multiimage">Multi Image Box</option></select><span class="desc">Select input box\'s type</span></p><p id="wed" style="display:none;"><label for="type_value">Tag Values</label>:<input name="u'+config_count+'[type_value]" id="type_value"><span class="desc">Write custom values (Not ready)</span></p><a href="#" id="delete">Delete</a></li>');
		return false;
	});
	udelete.live('click',function(){
		$(this).parent().remove();
		return false;
	});
	add_new.live('click',function(){
		var licount = $("#creator li").length;
		$("#creator").append(
	      $("#creator li:last").clone(true).attr("id","u"+licount).find(":input").each(function(i){ $(this).attr("name", function(z, val){ var lastcount = val.match(/[0-9]+/g); return val.replace("u"+lastcount,"u"+licount); }).val(""); }).end()
	    );
	    return false;
	});
	tag_type.live('change',function() {
        var value = $(this).children('option:selected').val();
        var id = $(this).parents("li");
        if(value == "selectbox" || value == "radio" || value == "checkbox" || value == "image") {
        	$(id).find("p#wed").show();
        } else {
        	$(id).find("p#wed").hide();
        }
    });
    $("#config,#creator").sortable({ axis: "y",cursor: "move",placeholder: "ui-state-highlight",revert: false });
});