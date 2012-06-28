{if $pagename eq "edit_page"}
<!-- Start CodeMirror -->
{literal}
<script type="text/javascript">
  var textarea = document.getElementById('editor');
  var editor = new MirrorFrame(CodeMirror.replace(textarea), {
    height: "600px",
	content: textarea.value,
	parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
	parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "tokenizephp.js", "parsephp.js", "parsephphtmlmixed.js"],
	stylesheet: ["../modules/codemirror/source/xmlcolors.css", "../modules/codemirror/source/jscolors.css", "../modules/codemirror/source/csscolors.css", "../modules/codemirror/source/phpcolors.css"],
    path: "../modules/codemirror/source/",
    continuousScanning: 500,
    lineNumbers: true,
	autoMatchParens: true,
    textWrapping: false
  });
</script>
{/literal}
<!-- End CodeMirror -->
{/if}