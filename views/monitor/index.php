<script>
    $(document).ready(function(){
            var URL = 'http://monitoring.dev/';
            var deviceCount;
            var deviceDemanded = 0;
            var timerId;
            $.ajax({
                    url: URL+'device/count',
                    success: function(count){
                    	deviceCount= count;
                    }
                });          
                /*function test(){
                	var limit = $("#limit").val();
                	$('.map').fadeIn('200');
                	for(var i = 1; i < deviceCount; i+=limit)
                	$.ajax({
                    url: URL+'monitor/refresh',
                    type: "POST",
                    data: {from: i, to: i+limit},
                    success: function(html){
                        $('.map').append(html);                        
                    }
                });
					/*$('.map').append('<div class="device_refresh" ><img class="refresh" src="public/images/refresh.png" /><img class="printer" src="public/images/printer.png" /><label>test</label></div>');
				};*/
				function demand(){
					//==
					var limit = $("#limit").val();
					if(deviceDemanded >= deviceCount)
						{
							deviceDemanded = 0;
							clearInterval(timerId);
							return;
						}
					else
						deviceDemanded += parseInt(limit);
					$.ajax({
                    url: URL+'monitor/refresh',
                    type: "POST",
                    async: false,
                    data: {from: deviceDemanded-limit, cnt: limit},
                    context: this              
               		}).success(function(html){      
                       $('.map').animate({
                			opacity: 0.8
                			},150, function(){
                				$('.map').append(html);
                				$('.map').css("opacity","1");
                			});            
                      });   
				};
            $("#up").click(function(){
            	var delay = $("#delay").val()*1000;
            	timerId = setInterval(function() {
  					demand();
				}, delay);
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
    </select> <input id="up" type="submit" value="Refresh"/>
    <input id="limit" type="text" placeholder="Devices limit(num)" value=""/>
    <input id="delay" type="text" placeholder="Delay (sec)" value=""/>
    <input id="timer" type="text" placeholder="Refreshing (sec)" value=""/>
</div>


	<div class="map">
</div>