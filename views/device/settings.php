<script>
function UnHide( eThis ){
        if( eThis.innerHTML.charCodeAt(0) == 9658 ){
            eThis.innerHTML = '&#9660;'
            eThis.parentNode.parentNode.parentNode.className = '';
        }else{
            eThis.innerHTML = '&#9658;'
            eThis.parentNode.parentNode.parentNode.className = 'cl';
        }
        return false;
    }
    $(document).ready(function(){
            var URL = 'http://monitoring.dev/';
            var countProp=1;
            $.ajax({
                            url: URL+'device/groups',
                            success: function(html){
                                $('#groups').html(html);
                            }
                        });
            $('#groups').change(function(){
                    
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
<link rel="stylesheet" href="<?php echo URL; ?>public/css/settings.css">
<link rel="stylesheet" href="<?php echo URL; ?>public/css/tree.css">
<link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
<center>
    <h2>
        Настройки
    </h2>
</center>
<hr/>
<label>Тип устрйоств</label>
<select id="groups">
        <option>
            Выбрать...
        </option>
    </select>
 <div class="oids">
 	<table>
    <thead >
        <tr>
            <td>Problem</td>
            <td>Solution</td>
        </tr>
    </thead>
    <tbody>
     <tr>
         <td>new item</td>
         <td>new item</td>
       </tr>
       <tr>
         <td>new item</td>
         <td>new item</td>
       </tr>
          <tr>
         <td>new item</td>
         <td>new item</td>
       </tr>
          <tr>
         <td>new item</td>
         <td>new item</td>
       </tr>   
    </tbody>
</table>
 </div>

<fieldset id="group_setings" hidden>
<!--    <h2>
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
    <input id="target" type="submit" value="Add" />-->
</fieldset>
<hr/>
<div class="treeview">
    <ul>
        <li>
            <div><p><a href="#" class="sc" onclick="return UnHide(this)">&#9660;</a>
                <a href="#">Настрйоки</a></p></div>
            <ul>
                <li class="cl">
                    <div>
                        <p>
                            <a href="#" class="sc" onclick="return UnHide(this)">&#9658;</a>
                            <a href="#">События</a>
                        </p>
                    </div>
                    <ul>
                        <li>
                            <div>
                                <p>
                                    <a href="#"><img src="i-photoshop.gif" class="i" />Photoshop</a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <p>
                                    <a href="#"><img src="i-illustrator.gif" class="i" />Illustrator</a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <p>
                                    <a href="#"><img src="i-indesign.gif" class="i" />InDesign</a>
                                </p>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="cl">
                    <div>
                        <p>
                            <a href="#" class="sc" onclick="return UnHide(this)">&#9658;</a>
                            <a href="#">Оповещения</a>
                        </p>
                    </div>
                    <ul>
                        <li>
                            <div>
                                <p>
                                    <a href="#"><img src="i-word.gif" class="i" />Word</a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <p>
                                    <a href="#"><img src="i-excel.gif" class="i" />Excel</a>
                                </p>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>
    </ul>
</div>