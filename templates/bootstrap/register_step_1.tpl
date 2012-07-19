{************************************
*** Registration Step 2 Template ****
*************************************}
<!-- register_step_1.tpl -->
<p>
	{#PLIGG_Visual_Register_Thankyou#|sprintf:$get.user}
	{#PLIGG_Visual_Register_Noemail#}
	{assign var="email" value=#PLIGG_PassEmail_From#}
	{#PLIGG_Visual_Register_ToDo#|sprintf:$email}
</p>
<!--/register_step_1.tpl -->