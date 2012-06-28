<?php

/**
 * MySQL Backup Pro Chinese translation
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @author Translation by Avenger <avenger@php.net> website : http://www.phpe.net/
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - zh.php
 * @access public
 **/
 
// Application title
$GONX["title"] = "MySQL Backup Pro&trade;";

$GONX["deleteconfirm"] = '确认要删除此文件吗？\n\n点击确认按钮继续。';

$GONX["header"] = '<html>
<head>
<title>'.$GONX["title"].'</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
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
$GONX['homepage'] = "<b>".$GONX["title"]."</b> 是一个针对 Mysql 数据库备份及恢复的完整解决方案。<br/> <br />
			使用步骤：
			<ul>
			<li>首先需要对您的程序进行 <a href=\"?go=config\" class=tab-g>配置</a> (linux下 init.php 的属性需要为 0777)。</li>
			<li>要创建一个备份，请点击 <a href=\"?go=create\" class=tab-g>创建备份</a>。</li>
			<li><a href=\"?go=list\" class=tab-g>点击这里</a> 查看已经存在的数据库备份。</li>
			</ul>
			别忘了保存好你的 \"backup\" 目录，一个比较好的办法是建立一个非 WEB 目录 (无法通过WEB访问) 用来保存您的备份数据。
			<br/><br/>
			当前数据库: <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " 已经被安装";
$GONX["notinstalled"] = " 还没有安装";
$GONX["compression"] = "PHP 压缩模块";
$GONX["autherror"] = " 请输入正确的认证信息";

$GONX["home"] = "主页";
$GONX["create"] = "创建备份";
$GONX["list"] = "备份列表/导入";
$GONX["optimize"] = "优化数据库";
$GONX["monitor"] = "数据库详情";
$GONX["logout"] = "注销";
			
$GONX["backup"] = "备份数据";
$GONX["iscorrectcreat"] = "成功创建";
$GONX["iscorrectimport"] = "成功被导入";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;在这里可以选择已经存在的备份数据进行恢复";
$GONX["importbackupfile"] = "或者在这里上传本地的备份数据";
$GONX["delete"] = "删除";
$GONX["nobckupfile"] = "没有任何备份数据存在。 点击 <a href=\"?go=create\" class=tab-g>创建备份</a> 来创建一个新的备份项目";
$GONX["importbackup"] = "导入备份文件";
$GONX["importbackupdump"] = "使用 MySQL Dump";
$GONX["configure"] = "初始化配置";
$GONX["configureapp"] = "初始化配置 </b><i>(请确认 init.php 的属性为可写 [0777])</i>";
$GONX["totalbackupsize"] = "备份目录总大小 ";
$GONX["chgdisplayorder"] = "排序";
$GONX["next"] = "下一个";
$GONX["prev"] = "上一个";

$GONX["structonly"] = "仅结构";
$GONX["checkall"] = "全选";
$GONX["uncheckall"] = "取消全选";
$GONX["tablesmenuhelp"] = "<u><b>提示</b></u>  : 如果您看到 <label>labels</label> 标志，表明这些数据库创建后有被更新过。";
$GONX["backupholedb"] = "点击这里对整个库进行完整备份:";
$GONX["selecttables"] = "或者在这里选择需要备份的表:";

$GONX["ignoredtables"] = "忽略的表";
$GONX["reservedwords"] = "Mysql 保留字";

?>