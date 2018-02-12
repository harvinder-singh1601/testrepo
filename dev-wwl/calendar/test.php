<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title></title></head>
<?php
if($_REQUEST['sub'])
{
   // echo $_REQUEST['d1'];
    echo date("y-m-d",strtotime($_REQUEST['d1']));
}
?>
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jquery.1.4.2.js"></script>
<script type="text/javascript" src="jsDatePick.jquery.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){		
		
		g_globalObject = new JsDatePick({
			useMode:1,
			isStripped:true,
			target:"inputfield"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
		
		
		
		
		g_globalObject2 = new JsDatePick({
			useMode:1,
			isStripped:false,
			target:"inputfield1",
			cellColorScheme:"beige"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
		
		
		
	};
</script>
</head>
<body>
	<h2>jsDatePick's Javascript Calendar usage example using jQuery - direct HTML appending</h2>
    
    This example will show the direct HTML appending version of the calendar
    <br />
    in two versions. one way is with the outside design and the other without.
    <br />
    This is done easily by using the <i>isStripped</i> property which you should supply in the Startup settings object.
    <br />
    Please take a look at the source of this file to fully understand how to use this calendar.
    <br />
    
    <div id="div3_example" style="margin:10px 0 30px 0; border:dashed 1px red; width:205px; height:230px;">
    	
    </div>
    
    
    <div id="div4_example" style="margin:10px 0 30px 0; border:dashed 1px blue; width:230px; height:250px;">
    	
    </div>
    
    
    <div id="div3_example_result" style="height:20px; line-height:20px; margin:10px 0 0 0; border:dashed 1px #666;"></div>
        
</body>
</html>
<form>
<input type="text" size="12" id="inputfield"  name="d1"/>
<input type="text" size="12" id="inputfield1"  name="d1"/>
<input type="submit" name="sub" id="sub">
</form>
</body>
</html>