<script>
    $(document).ready(function(){
            var URL = 'http://monitoring.dev/';
            var deviceCount;
            var deviceDemanded = 0;
            var timerId;
            $('#groups').focus(function(){
            	$('#groups').css('background', 'white');
                    $.ajax({
                            url: URL+'device/groups',
                            success: function(html){
                                $('#groups').html(html);
                            }
                        });
                });
            $.ajax({
                    url: URL+'device/count',
                    success: function(count){
                    	deviceCount= count;
                    	$(".info").html("Всего утсройств: "+count);
                    }
                });          
				function demand(){
					//==
					var limit = $("#limit").val();
					var grp = $("#groups").val();
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
                    data: {from: deviceDemanded-limit, cnt: limit, grp: grp},
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
            	if($.isNumeric($("#delay").val()) && $.isNumeric($("#limit").val()) )
            	{
					var delay = $("#delay").val()*1000;
            	timerId = setInterval(function() {
  					demand();
				}, delay);
				}
				else
					alert("Needed fields are empty or not numeric!");        	
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
<!--	<select id="groups" name="">
        <option>
            Filter
        </option>
    </select>--> <input id="up" type="submit" value="Обновить"/>
    <input id="limit" type="text" placeholder="Число устрйоств" value=""/>
    <input id="delay" type="text" placeholder="Задержка(сек)" value=""/>
    <input id="timer" type="text" placeholder="Обновление (сек)" value=""/>
    <select id="groups" name="">
        <option value="-1">
            Фильтр
        </option>
    </select>
    <select id="status" name="">
        <option>
            Статус
        </option>
    </select>
    <label class="info"></label>
</div>


	<div class="map">
	</div>