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
            $.ajax({
            		type: "POST",
                    url: URL+'oid/showTree',
                    success: function(html){
                        $(".treeview").html(html);
                    }
                });
            $(".treeview").on('click','img.del', function(){
            	if(confirm('Подтвердите удаление'))
            	{
					var oid_id = $(this).attr('rel');
					var t = $(this).parent().parent();				
                     $.ajax({
            		type: "POST",
            		data: {oidid: oid_id},
            		url: URL+'oid/deleteOid',           	
                    success: function(html){
                        if(html=="")
                        {
                        	//alert('Oid удален!');	
                        	t.animate(
						{
							opacity: 0
						}, 200, function()
						{
							t.remove();
						});                     					
						}
                       	else
                       	{
							alert(html);
							return false;
						}
                       		
                       		
                    }
                    
                });					
				}
                });
        });
</script>
<link rel="stylesheet" href="<?php echo URL; ?>public/css/tree.css">
<link rel="stylesheet" href="<?php echo URL; ?>public/css/oid.css">
<link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
<center>
    <h2>
        База OID`ов
    </h2>
</center>
<hr/>
<div class="treeview">
	
</div>