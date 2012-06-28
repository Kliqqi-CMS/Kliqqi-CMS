{if $pagename eq "admin_editor"}
<!-- Start CodeMirror -->
<script src="{$my_pligg_base}/modules/codemirror/source/codemirror.js" type="text/javascript"></script>
<script src="{$my_pligg_base}/modules/codemirror/source/mirrorframe.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/modules/codemirror/source/xmlcolors.css" media="screen">
{literal}
<style type="text/css">
  .CodeMirror-line-numbers {
	width: 2.2em;
	color: #aaa;
	background-color: #eee;
	text-align: right;
	padding-right: .3em;
	font:100% monospace;
	font-size: 10pt;
	padding-top: .6em;
	line-height:18px;
  }
</style>
{/literal}
<!-- End CodeMirror -->
{/if}