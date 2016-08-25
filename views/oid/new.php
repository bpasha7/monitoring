<script>
    $(document).ready(function(){
    	$(function() {
    		$('#groups').focus();
    		});
            var URL = 'http://monitoring.dev/';
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
             		var data = $("#create_oid").serialize();
             		$.ajax({
                                url: URL+'oid/add',
                                type: "POST",
                                data: data,
                                success: function(html){
                                    if(html == ""){
                                        alert("Добавлено!");
                                        $("input[type=text]").val('');
                                        //window.location.replace(URL+'monitor/on');
                                    }
                                    else
                                    alert(html);
                                }
                            });
             	});
        });
</script>
<link rel="stylesheet" href="<?php echo URL; ?>public/css/device.css">
<!--<center>
    <h2>
        База OID`ов
    </h2>
</center>
<hr/>-->
<center>
    <h2>
       	Добавление нового Oid`а
    </h2>
</center>
<fieldset id="create_oid">

<label for="">
        <b>
            Группа устройств
        </b>
    </label>
		<select id="groups" name="group">
        <option>
            Выберите группу
        </option>
    </select><br/>
		<label for="">
        <b>
            Название 
        </b></label>
		<input name="name" type="text" placeholder="Введите название"/>
		<label for="">
        <b>
            Oid  
        </b>
    </label>
		<input class="long" name="oid" type="text" placeholder="Введите OID(ы)"/><div class="tip"><img id="help" src="public/images/q.png" alt="" /><span class="tooltiptext">Введите OID или формулую.</br>Например 1.х.х.х.х.х.х.х.х/1.2.4.6.3.х.х.х.х*1000</span></div>
    </br><input id="target" type="submit" value="Add" />
</fieldset>
<hr/>
<!--    <h2>
        Просмотреть OID`ы <img id="eye" src="public/images/eye.png" alt="" />
    </h2>
<hr/>-->