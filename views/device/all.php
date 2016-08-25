<link rel="stylesheet" href="<?php echo URL; ?>public/css/device.css">
<link rel="stylesheet" href="<?php echo URL; ?>public/css/settings.css">
<link rel="stylesheet" href="<?php echo URL; ?>public/css/footer.css">
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
            
        });
</script>
<center>
    <h2>
        Устрйоства
    </h2>
</center>
<hr/>