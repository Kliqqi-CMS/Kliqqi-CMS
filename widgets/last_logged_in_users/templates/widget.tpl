{php}
function rel_time($from, $to = null)
 {
  $to = (($to === null) ? (time()) : ($to));
  $to = ((is_int($to)) ? ($to) : (strtotime($to)));
  $from = ((is_int($from)) ? ($from) : (strtotime($from)));

  $units = array
  (
   "year"   => 29030400, // seconds in a year   (12 months)
   "month"  => 2419200,  // seconds in a month  (4 weeks)
   "week"   => 604800,   // seconds in a week   (7 days)
   "day"    => 86400,    // seconds in a day    (24 hours)
   "hour"   => 3600,     // seconds in an hour  (60 minutes)
   "minute" => 60,       // seconds in a minute (60 seconds)
   "second" => 1         // 1 second
  );

  $diff = abs($from - $to);
  $suffix = (($from > $to) ? ("from now") : ("ago"));

  foreach($units as $unit => $mult)
   if($diff >= $mult)
   {
    $and = (($mult != 1) ? ("") : ("and "));
    $output .= ", ".$and.intval($diff / $mult)." ".$unit.((intval($diff / $mult) == 1) ? ("") : ("s"));
    $diff -= intval($diff / $mult) * $mult;
   }
  $output .= " ".$suffix;
  $output = substr($output, strlen(", "));

  return $output;
 }
{/php}

{literal}
<script type="text/javascript">
/****************************************************************************
* JavaScript Tool-Tips by lobo235 - www.netlobo.com
*
* This script allows you to add javascript tool-tips to your pages in a very
* unobtrusive manner. To learn more about using this script please visit
* http://www.netlobo.com/javascript_tooltips.html for usage examples.
****************************************************************************/

// Empty Variables to hold the mouse position and the window size
var mousePos = null;
var winSize = null;

// Set events to catch mouse position and window size
document.onmousemove = mouseMove;
window.onresize = windowResize;

// The mouseMove and mouseCoords function track the mouse position for us
function mouseMove(ev)
{
	ev = ev || window.event;
	mousePos = mouseCoords(ev);
}
function mouseCoords(ev)
{
	if(ev.pageX || ev.pageY){
		return {x:ev.pageX, y:ev.pageY};
	}
	return {
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
		y:ev.clientY + document.body.scrollTop  - document.body.clientTop
	};
}

// The windowResize function keeps track of the window size for us
function windowResize( )
{
	winSize = {
		x: ( document.body.clientWidth ) ? document.body.clientWidth : window.innerWidth ,
		y: ( document.body.clientHeight ) ? document.body.clientHeight : window.innerHeight
	}
}

// This function shows our tool-tips
function showTip( )
{
	var tip = document.getElementById('t'+this.id);
	tip.style.position = "absolute";
	var newTop = mousePos.y;
	var newLeft = mousePos.x - ( tip.clientWidth / 2 );
	if( newTop < 0 )
		newTop = mousePos.y + 1;
	if( newLeft < 0 )
		newLeft = 0;
	if( ( mousePos.x + ( tip.clientWidth / 1 ) ) >= winSize.x - 1 )
		newLeft = winSize.x - tip.clientWidth - 2;
	tip.style.top = newTop + "px";
	tip.style.left = newLeft + "px";
	tip.style.display = "block";
}

// This function moves the tool-tips when our mouse moves
function moveTip( )
{
	var tip = document.getElementById('t'+this.id);
	var newTop = mousePos.y - tip.clientHeight - 50;
	var newLeft = mousePos.x - ( tip.clientWidth / 1 );
	if( newTop < 0 )
		newTop = mousePos.y + 1;
	if( newLeft < 0 )
		newLeft = 0;
	if( ( mousePos.x + ( tip.clientWidth + 2 ) ) >= winSize.x - 1 )
		newLeft = winSize.x - tip.clientWidth - 2;
	tip.style.top = newTop + "px";
	tip.style.left = newLeft + "px";
}

// This function hides the tool-tips
function hideTip( )
{
	var tip = document.getElementById('t'+this.id);
	tip.style.display = "none";
}

// This function allows us to reference elements using their class attributes
document.getElementsByClassName = function(clsName){
	var retVal = new Array();
	var elements = document.getElementsByTagName("*");
	for(var i = 0;i < elements.length;i++){
		if(elements[i].className.indexOf(" ") >= 0){
			var classes = elements[i].className.split(" ");
			for(var j = 0;j < classes.length;j++){
				if(classes[j] == clsName)
					retVal.push(elements[i]);
			}
		}
		else if(elements[i].className == clsName)
		retVal.push(elements[i]);
	}
	return retVal;
}

// This is what runs when the page loads to set everything up
window.onload = function(){
	var ttips = document.getElementsByClassName('ttip');
	for( var i = 0; i < ttips.length; i++ )
	{
		ttips[i].onmouseover = showTip;
		ttips[i].onmouseout = hideTip;
		ttips[i].onmousemove = moveTip;
	}
	windowResize( );
}

</script>
{/literal}

{literal}
<style type="text/css">
.ttip {
	cursor: help;
	font-size: 9px;
	font-family:arial;
	font-weight:bold;
}
.info {
	font-size:9px;
	display: none;
	border: 1px solid #FC9;
	background-color:#FFC;
	padding: 2px;
	width: 250px;
	border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px;
}
</style>
{/literal}

<div style="background-image:url('{$my_base_url}{$my_pligg_base}/widgets/last_logged_in_users/templates/keys.jpg'); background-position:right top; background-repeat:no-repeat;">

	<p style="margin-bottom:10px;">The last {$limit_size} users to sign in:</p>
	<div style="margin:3px 0 12px 0;">
	
	<table>
			{php}
							
				mysql_connect(localhost,EZSQL_DB_USER,EZSQL_DB_PASSWORD);
				@mysql_select_db(EZSQL_DB_NAME) or die( "Unable to select database");
				
				$query  = "SELECT user_date, user_lastlogin, user_login, user_email, user_ip, user_enabled, user_lastip FROM pligg_users ORDER BY user_lastlogin DESC Limit ". $this->get_template_vars('limit_size');
				$result = mysql_query($query);
				
				$record = 1;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					
					$today = date("Y-m-d H:i:s");
					$lastWeek = time() - (3 * 24 * 60 * 60);
					$userdate = strtotime($row['user_date']);
					
					if($user_enabled=1){
						echo "<tr>";
							echo "<td><span style=\"font-weight: bold; font-size: 12px; color: ";
							if($userdate<=$lastWeek){ 
								echo "#069";
							}else{
								echo "#F09";
							}
							echo "\">{$row['user_login']}</span></td>";
							echo "<td><span class=\"ttip\" id=\"ttip{$record}\"> ".rel_time($row['user_lastlogin'])."</span>";
							echo "<div  id=\"tttip{$record}\" class=\"info\"><table><tr><td><strong>Last in:</strong></td><td>{$row['user_lastlogin']}</td></tr><tr><td><strong>Email:</strong></td><td>{$row['user_email']}</td></tr><tr><td><strong>Registered:</strong></td><td>{$row['user_date']}</td></tr><tr><td><strong>IP:</strong></td><td>{$row['user_ip']}</td></tr><tr><td><strong>Recent IP:</strong></td><td>{$row['user_lastip']}</td></tr></table></div></td>";
						echo "</tr>";
					}
					$record=$record+1;
				}
				
				mysql_close();
			{/php}
	</table>
	</div>
</div>
