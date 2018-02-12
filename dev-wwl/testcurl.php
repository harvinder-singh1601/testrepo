<?php
$url="https://goedu.org/setsession.php?val=67";

?>
<script>
 fdata.append("val","97");
    
    $.ajax({
        type: "POST",
        url: "https://goedu.org/setsession.php",
        //data:{action:"add",charity_name:charity_name,address:address,contact:contact,phone:phone,taxid:taxid,nonprofit:nonprofit}, 
        data:fdata,
        contentType: false,
        processData: false,
        success: function(data){
            
            
         alert(data);
         
         
          
        }
      }); 
</script>