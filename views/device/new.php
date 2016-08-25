<script>
    $(document).ready(function(){
            var URL = 'http://monitoring.dev/';
            var countProp=1;
            var oids;
            $(function() {
    		$('#groups').focus();
    		});
            $("#create_device").on('focus', 'li .oidsname', function(){
            	var grp = $('#groups').val();
            	if(!$.isNumeric(grp))
            	{
					alert('Не выбран тип устрйоства');
					$('#groups').css('background', 'pink');
					return false;
				}
            		
            	var select_id = "#"+$(this).attr('id');
            	$.ajax({
                            url: URL+'device/oidsname',
                            type: "POST",
                            data: {
                                grp: grp
                            },
                            success: function(html){
                            	var result = $.parseJSON(html);
                            	oids = result[1];
                                $(select_id).html(result[0]);
                            }
                        });
            	});
           	 $("#create_device").on('mouseleave', '.oidsname', function(){
           		if(oids!==undefined){
           	 	var oid_id = $(this).val();
           	 	$(this).parent().children('#oid').val(oids[oid_id]);
           	 	}
           	 	});
           	 	
            $('#groups').focus(function(){
            	$('#groups').css('background', 'white');
                    $.ajax({
                            url: URL+'device/groups',
                            success: function(html){
                                $('#groups').html(html);
                            }
                        });
                });
            $("#target").click(function(){
                    var properies = [];
                    for(var i=1; i <= countProp; i++){
                        var prop = $("#s"+i).val();
                        if(prop!==undefined && prop!==""){
                            properies[properies.length] = prop;
                            //properies[properies.length] = $("#p"+i+" #oid").val();
                        }
                    }
                    if(properies.length>0)
                    {
                        var ip = $("#ip").val();
                        var grp = $("#groups").val();
                        var cmt = $("#community").val();
                        var tmo = $("#timeout").val();
                        if(ip!="" && grp !="")
                        $.ajax({
                                url: URL+'device/addDevice',
                                type: "POST",
                                data: {
                                    grp: grp, ip: ip,community: cmt, timeout: tmo, prop: properies
                                },
                                success: function(html){
                                    if(html == ""){
                                        alert("Device was added!");
                                        window.location.replace(URL+'monitor/on');
                                    }
                                    else
                                    alert(html);
                                }
                            });
                        else
                        	alert('IP-Адресс или свойства не заполнены!');
                    }
                    else{
                        alert('Не достаточно свойств!');
                    }
                    return false;
                });
            $("#create_device").on('click','img.del', function(){
                    if($( "ol li" ).length-1 == 0){
                        alert('Can not delete only property!');
                        return false;
                    }
                    var li_id = "#"+$(this).attr('alt')
                    $(li_id).animate({
                        opacity: 0
                    }, 200, function() {
                    $(li_id).remove();
                    });
                });
            $("#add").click(function(){
                    //var n = $( "ol li" ).length+1;
                    countProp++;
                    var id = "p"+countProp.toString();
                    $("ol").append('<li id="'+id+'"><select id="s'+countProp+'" class="oidsname"><option>Выберите свойтсво</option></select><label for=""> OID: </label><input id="oid" type="text" placeholder="Fill in OID" disabled/><img class="del" src="public/images/del.png" alt="'+id+'" /></li>');
                    $('#'+id).css({opacity: 0, visibility: "visible"}).animate({opacity: 1}, 200);
                });
        });
</script>
<link rel="stylesheet" href="<?php echo URL; ?>public/css/device.css">
<center>
    <h2>
       	Добавление нового устройства
    </h2>
</center>
<hr/>
<fieldset id="create_device">
<table class="main_prop">
	<tr>
		<td><label for="">
        <b>
            IP-адресс
        </b>
    </label></td>
		<td> <input id="ip" type="text" placeholder="Введите IP-адресс" /></td>
		<td><select id="groups" name="">
        <option>
            Выберите устройство
        </option>
    </select></td>
	</tr>
	<tr>
		<td><label for="">
        <b>
            Community 
        </b></label></td>
		<td><input id="community" type="text" placeholder="Community name" value="public"/></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="">
        <b>
            Timeout  
        </b>
    </label></td>
		<td><input id="timeout" type="text" placeholder="Timeout(ms)" value="10"/></td>
		<td></td>
	</tr>
</table>
    <h2>
        Свойства <img id="add" src="public/images/add.png" alt="" />
    </h2>
    <ol>
        <li id="p1">
        <select id="s1" class="oidsname">
        	<option>Выберите свойтсво</option>
        </select>
            <!--<input id="pname" type="text" placeholder="Name property" />-->
            <label for="">
                OID:
            </label><input id="oid" type="text" placeholder="Fill in OID" disabled/><img class="del" src="public/images/del.png" alt="p1" />
        </li>

    </ol>
    <input id="target" type="submit" value="Add" />
</fieldset>
<hr/>