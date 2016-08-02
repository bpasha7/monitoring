<script>
    $(document).ready(function(){
            var URL = 'http://monitoring.dev/';
            $(document).keypress(function(e) {
                    if(e.which == 13) {
                        $(".search").click();
                    }
                });
            $(".search").click(function(){
                    var ip = $("#ip").val();
                    $.ajax({
                            url: URL+'device/editForm',
                            type: "POST",
                            data: {
                                ip: ip
                            },
                            success: function(html){
                                $('#edit_device').html(html);
                                $('#edit_device').fadeIn('200');
                            }
                        });
                    return false;
                });
            $("#edit_device").on('click', '#delete', function(){
            	var ip = $("#ip").val();
            	$.ajax({
                            url: URL+'device/deleteDevice',
                            type: "POST",
                            data: {
                                ip: ip
                            },
                            success: function(html){
                            	if(html == ""){
                                        alert("Device was added!");
                                        $('#edit_device').html("");
                               			$('#edit_device').fadeOut('200');
                                //window.location.replace(URL+'monitor/on');
                                    }
                                    else
                                   		alert(html);
                               
                            }
                        });
            	});
            $("#edit_device").on('click', '#target', function(){
                    var properies = [];
                    for(var i=1; i <= $( "ol li" ).length; i++){
                        var prop = $("#p"+i+" #pname").val();
                        if(prop!==undefined || prop!==""){
                            properies[properies.length] = prop;
                            properies[properies.length] = $("#p"+i+" #oid").val();
                        }
                    }
                    if(properies.length>0)
                    {
                        var ip = $("#ip").val();
                        var cmt = $("#community").val();
                        var tmo = $("#timeout").val();
                        $.ajax({
                                url: URL+'device/editDevice',
                                type: "POST",
                                data: {
                                    ip: ip, community: cmt, timeout: tmo, prop: properies
                                },
                                success: function(html){
                                    if(html == ""){
                                        alert("Device was edited!");
                                        window.location.replace(URL+'monitor/on');
                                    }
                                    else
                                    alert(html);
                                }
                            });
                    }
                    else{
                        alert('Not enough properties!');
                    }
                    return false;
                });
            $("#edit_device").on('click','img.del', function(){
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
            $("#edit_device").on('click','#add', function(){
                    //var n = $( "ol li" ).length+1;
                    var countProp = $( "ol li" ).length+1;
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
        Edit device<br/>
        <input id="ip" type="text" placeholder="Search by IP-addres" autofocus/><img class="search" src="public/images/search.png" alt="p1" />
    </h2>
</center>
<hr/>
<fieldset id="edit_device" hidden>

</fieldset>