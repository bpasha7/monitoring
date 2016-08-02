<script>
    $(document).ready(function(){
            var URL = 'http://monitoring.dev/';
            $.ajax({
                    url: URL+'monitor/refresh',
                    success: function(html){
                        $('.map').html(html);
                        $('.map').fadeIn('200');
                    }
                });
                function test(){
					$('.map').append('<div class="device_refresh" ><img class="refresh" src="public/images/refresh.png" /><img class="printer" src="public/images/printer.png" /><label>test</label></div>');

				};
            $("#up").click(function(){
            	
            	var timerId = setTimeout(function tick() {
  					test();
  						timerId = setTimeout(tick, 2000);
					}, 2000);
            				});
				
				
			
            $(".map").on('click','img.refresh', function(){
                    var device_id = $(this).attr('deviceid');
                    if (  $('#d'+device_id).hasClass('device_off') )
                    $('#d'+device_id).addClass('device_refresh').removeClass('device_off');
                    else
                    $('#d'+device_id).removeClass('device_on').addClass('device_refresh');
                    $.ajax({
                            url: URL+'monitor/update',
                            type: "POST",
                            data: {
                                deviceid: device_id
                            },
                            success: function(html){
                                var result = $.parseJSON(html);
                                $('#d'+device_id).html(result[0]);
                                if(result[1])
                                $('#d'+device_id).removeClass('device_refresh').addClass('device_on');
                                else
                                $('#d'+device_id).removeClass('device_refresh').addClass('device_off');
                            }
                        });
                });
        });
</script>
<link rel="stylesheet" href="<?php echo URL; ?>public/css/monitor.css">
<div class="settings">
	<select id="groups" name="">
        <option>
            Filter
        </option>
    </select> <input id="up" type="submit" value="UP"/>
    <input id="limit" type="text" placeholder="Devices" value=""/>
    <input id="timeer" type="text" placeholder="Time in sec." value=""/>
</div>


	<div class="map">
</div>