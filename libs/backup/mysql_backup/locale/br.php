<?php

/**
 * MySQL Backup Pro Protuguese brasilian translation
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - en.php
 * @access public
 **/
 // Traduzido por Leandro Fernandes <soumaisjava@yahoo.com.br>
// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";

$GONX["deleteconfirm"] = ' Você está certo que deseja apagar este arquivo?\nClique OK para confirmar.';

$GONX["header"] = '<html>
<head>
<title>'.$GONX["title"].'</title>
<style type="text/css" media="screen">@import "style.css";</style>
<script language="JavaScript" type="text/javascript">
<!--
function ConfirmDelete() {
	return confirm("'.$GONX["deleteconfirm"].'");
}
//-->
</script>
</head>
<body>
';

// Home page content
$GONX['homepage'] = "<b>".$GONX["title"]."</b> é uma solução completa para criar e restaurar backup's da base MySQL.<br/>
			O uso da aplicação é muito fácil :
			<ul>
			<li>Primeiro <a href=\"?go=config\" class=tab-g>configure</a> Sua aplicação (init.php deve possuir chmod como 0777).</li>
			<li>Para criar um backup apenas clique <a href=\"?go=create\" class=tab-g>Criar um Backup</a>.</li>
			<li>Você pode <a href=\"?go=list\" class=tab-g>listar</a> Restaurar backup's disponíveis.</li>
			</ul>
			não esqueça de proteger o diretório de \"backup\", e é recomendável não ser um diretório acessível pela web, onde o sistema cria uma copia segura do banco de dados.
			<br/><br/>
			Database usada : <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " está instalado";
$GONX["notinstalled"] = " não está instalado";
$GONX["compression"] = "Módulo de compressão do PHP";
$GONX["autherror"] = " Por favor entre com um nome de usuário correto e senha para acessa esta área";

$GONX["home"] = "Home";
$GONX["create"] = "Criar um Backup";
$GONX["list"] = "Listar/Importar backup";
$GONX["optimize"] = "Otimizar";
$GONX["monitor"] = "Monitorar";
$GONX["logout"] = "Logout";
			
$GONX["backup"] = "Backup de";
$GONX["iscorrectcreat"] = "foi criado em";
$GONX["iscorrectimport"] = "foi importado para o banco de dados";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;seleciona por backups disponíveis";
$GONX["importbackupfile"] = "Ou faz upload do arquivo aqui";
$GONX["delete"] = "Apagar";
$GONX["nobckupfile"] = "Não existem arquivos de backup disponíveis. Clique em <a href=\"?go=create\" class=tab-g>Criar um backup</a> para criar um backup do banco de dados";
$GONX["importbackup"] = "Importar arquivo de Backup";
$GONX["configure"] = "Configurar";
$GONX["configureapp"] = "Configurar sua applicação </b><i>(Chmod 0777 init.php antes de usar esta aplicação)</i>";
$GONX["totalbackupsize"] = "Tamanho total do diretório de backup";
$GONX["chgdisplayorder"] = "Mudar a ordem de exibição";
$GONX["next"] = "Próximo";
$GONX["prev"] = "Anterior";

$GONX["structonly"] = "Estrutura somente";
$GONX["checkall"] = "Marcar todos";
$GONX["uncheckall"] = "Desmarcar todos";
$GONX["tablesmenuhelp"] = "<u>Help</u>  : Se você ver <label>labels</label> ele permite que faça mudanças nas tabelas.";
$GONX["backupholedb"] = "clique aqui para criar uma regra de backup para o banco de dados :";
$GONX["selecttables"] = "Ou selecione as tabelas de backup agora :";

$GONX["ignoredtables"] = "Tabela iginorada";
$GONX["reservedwords"] = "Palavra reservada do MySQL";

?>