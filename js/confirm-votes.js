function confirm(){
    
}
$(document).ready(function(){
    $("input[type='submit']").click(function(){
        var radioValue = $("input[name='<?php echo $cand_id; ?>']:checked").val();
        if(radioValue){
            console.log(radioValue);
        }
    });
    
});