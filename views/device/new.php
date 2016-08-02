<script>

    $(document).ready(function(){
    	var timerId = setTimeout(function tick() {
  $("#add").click();
  timerId = setTimeout(tick, 2000);
}, 2000);
/*function test(){
	$("#add").click();
}*/
//setTimeout( test, 1000);
            var URL = 'http://monitoring.dev/';
            var countProp=1;
            $('#groups').focus(function(){
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
                        var prop = $("#p"+i+" #pname").val();
                        if(prop!==undefined || prop!==""){
                            properies[properies.length] = prop;
                            properies[properies.length] = $("#p"+i+" #oid").val();
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
                        	alert('IP-Addres and/or Device type are/is missed!');
                    }
                    else{
                        alert('Not enough properties!');
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
                   /* $("#"+id).animate({
                       opasity: 1
                    }, 500, function() {*/
                    $("ol").append('<li id="'+id+'"><input id="pname" type="text" placeholder="Name property"/><label for=""> OID: </label><input id="oid" type="text" placeholder="Fill in OID"/><img class="del" src="public/images/del.png" alt="'+id+'" /></li>');
                    $('#'+id).css({opacity: 0, visibility: "visible"}).animate({opacity: 1}, 200);
                   /* $("ol").css('opacity: 1');
                    });*/
                });
        });
</script>
<link rel="stylesheet" href="<?php echo URL; ?>public/css/device.css">
<center>
    <h2>
        Add new device
    </h2>
</center>
<hr/>
<fieldset id="create_device">
<table>
	<tr>
		<td><label for="">
        <b>
            IP Device
        </b>
    </label></td>
		<td> <input id="ip" type="text" placeholder="Enter IP-Adress" /></td>
		<td><select id="groups" name="">
        <option>
            Please choose type...
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
		<td><input id="timeout" type="text" placeholder="Timeout(ms)" value="100"/></td>
		<td></td>
	</tr>
</table>
    <h2>
        Properties <img id="add" src="public/images/add.png" alt="" />
    </h2>
    <ol>
        <li id="p1">
            <input id="pname" type="text" placeholder="Name property" />
            <label for="">
                OID:
            </label><input id="oid" type="text" placeholder="Fill in OID"/><img class="del" src="public/images/del.png" alt="p1" />
        </li>

    </ol>
    <input id="target" type="submit" value="Add" />
</fieldset>
<hr/>