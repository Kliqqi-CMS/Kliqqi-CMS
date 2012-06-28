{#PLIGG_Visual_Register_Thankyou#|sprintf:$get.user}

<br />
<span style="color:#c00;">{#PLIGG_Visual_Register_Noemail#}</span>

{assign var="email" value=#PLIGG_PassEmail_From#}
{#PLIGG_Visual_Register_ToDo#|sprintf:$email}
