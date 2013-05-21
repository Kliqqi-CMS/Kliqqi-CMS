{************************************
******* Registration Complete *******
*************************************}
<!-- register_complete_center.tpl -->
{checkActionsTpl location="tpl_pligg_register_complete_start"}
<p>
	{#PLIGG_Visual_Register_Thankyou#|sprintf:$get.user}
	{#PLIGG_Visual_Register_Noemail#}
	{assign var="email" value=#PLIGG_PassEmail_From#}
	{#PLIGG_Visual_Register_ToDo#|sprintf:$email}
</p>
{checkActionsTpl location="tpl_pligg_register_complete_end"}
<!--/register_complete_center.tpl -->