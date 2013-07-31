<?php
// header
	$lang['installer'] = '安装程序';
	$lang['Welcome'] = '欢迎';
	$lang['Install'] = '安装';
	$lang['Upgrade'] = '升级';
	$lang['Troubleshooter'] = '疑难解答';
	$lang['Step'] = '步骤';
	$lang['Readme'] = '说明';
	$lang['Admin'] = '管理';
	$lang['Home'] = '首页';
	$lang['Install_instruct'] = '请准备好你的MYSQL数据库信息. 如需升级请点击升级链接.';
	$lang['Upgrade_instruct'] = '升级将对你的MYSQL数据库做出永久修改.你最好在开始前先做一个备份.';
	$lang['Troubleshooter_instruct'] = '疑难解答将检查常见错误，比如错误的文件夹权限设定等';

// intro / step 1
	$lang['WelcomeToInstaller'] = '欢迎进入Pligg安装程序!';
	$lang['Introduction'] = '简介';
	$lang['WelcomeToThe'] = '欢迎加入 <a href="http://www.pligg.com" target="_blank">Pligg 内容管理系统</a>. 安装前请先访问<a href="http://www.pligg.com/download.php" target="_blank">官方下载页面</a>以确认你下载的是最新的安装包.';
	$lang['Bugs'] = '当你访问 Pligg.com 时, 请先查看一下 Pligg 社区提供的文档. 我们同时建议你注册 <a href="http://forums.pligg.com/" target="_blank">Pligg 论坛</a>, 在这里你可以下载免费的插件, 模板和其他对你的网站有用的资源. 如果你发现Pligg里有Bug, 请 <a href="http://forums.pligg.com/projects/pligg-cms/index.html" target="_blank">点击这里提交报告</a> 我们会在今后的版本里修复这些BUG的.';
	$lang['Installation'] = '安装方法 (请仔细阅读)';
	$lang['OnceFamiliar'] = '<p>如果这是你第一次安装Pligg，请认真阅读下面各段文字. 如果你需要 <a href="./upgrade.php">升级</a> 老的版本, 请点击页面上方的升级标签. 警告: 在已有Pligg系统中运行安装程序将覆盖你所有的内容和设置, 所以在继续前请确认这是你想执行的操作.</p><br />
	<ol>
		<li>把文件 settings.php.default 改名为 settings.php</li>
		<li>重命名/languages/lang_english.conf.default lang_english.conf</li>
		<li>重命名/languages/lang_chinese_simplified.conf.default lang_chinese_simplified.conf</li>
		<li>把文件 /libs/dbconnect.php.default 改名为 dbconnect.php</li>
		<li>把以下目录的访问权限设为755(CHMOD 755) , 如果在安装过程中仍然出错则改为 777.</li>
		<ol>
			<li>/admin/backup/</li>
			<li>/avatars/groups_uploaded/</li>
			<li>/avatars/user_uploaded/</li>
			<li>/cache/</li>
			<li>/languages/ (这个目录下的所有文件访问权限设为777)</li>
		</ol>
		<li>4. 把以下文件访问权限设置为666 (CHMOD 666) </li>
		<ol>
			<li>/libs/dbconnect.php</li>
			<li>settings.php</li>
		</ol>
	</ol>
	如果你已经看过了Pligg论坛的贴子,并理解了Pligg的设计理念,你可以进行下一步安装程序了.';

// step 2
	$lang['EnterMySQL'] = '在这里输入你的MYSQL数据库设置,如果你不知道你的MYSQL数据库是如何设置的,请阅读你的主机托管商提供的文档,或者直接与他们联系.';
	$lang['DatabaseName'] = '数据库名称';
	$lang['DatabaseUsername'] = '数据库用户名';
	$lang['DatabasePassword'] = '数据库访问密码';
	$lang['DatabaseServer'] = '数据库主机';
	$lang['TablePrefix'] = '数据库的表名前缀';
	$lang['PrefixExample'] = '(如: "pligg_" 那么用户表users将保存为pligg_users)';
	$lang['CheckSettings'] = '检查设置';
	$lang['Errors'] = '请修复上述错误,然后刷新本页,暂停安装!';
	$lang['LangNotFound'] = '没有被发现。请删除所有语言文件的默认扩展名，然后再试一次。';

// step 3
	$lang['ConnectionEstab'] = '初始化数据库连接...';
	$lang['FoundDb'] = '找到数据库...';
	$lang['dbconnect'] = '\'/libs/dbconnect.php\' 保存完毕.';
	$lang['NoErrors'] = '没有发现错误, 可以继续下一步安装了...';
	$lang['Next'] = '下一步';
	$lang['GoBack'] = '返回';
	$lang['Error2-1'] = '无法写入文件 \'libs/dbconnect.php\'.';
	$lang['Error2-2'] = '无法打开文件 \'/libs/dbconnect.php\' 供写入.';
	$lang['Error2-3'] = '已连接到数据库服务器, 但是数据库名称有误.';
	$lang['Error2-4'] = '提供的信息无法连接数据库 <b>服务器</b> .';

// step 4
	$lang['CreatingTables'] = '<p><strong>创建数据表...</strong></p>';
	$lang['TablesGood'] = '<p><strong>数据表创建成功!</strong></p><hr />';
	$lang['Error3-1'] = '<p>创建数据表出错.</p>';
	$lang['Error3-2'] = '<p>无法连接数据库.</p>';
	$lang['EnterAdmin'] = '<p><strong>请输入你的管理员帐号信息:</strong><br />请牢记你的管理员帐号信息,你需要使用它来登入到后台设置你的网站.</p>';
	$lang['AdminLogin'] = '管理员用户名';
	$lang['AdminPassword'] = '管理员密码';
	$lang['ConfirmPassword'] = '重复输入管理员密码';
	$lang['AdminEmail'] = '管理员的E-mail';
	$lang['SiteTitleLabel'] = '网站名称';
	$lang['CreateAdmin'] = '创建管理员帐号';

// Step 5
	$lang['Error5-1'] = '请填写所有的内容,不要留空.';
	$lang['Error5-2'] = '密码核对出错,请返回重新输入两遍密码.';
	$lang['AddingAdmin'] = '添加管理员帐号...';
	$lang['InstallSuccess'] = '<a href="../">你的Pligg站点</a>已经成功创建!';
	$lang['InstallSuccessMessage'] = '恭喜你，你已设立的Pligg CMS网站！当你的网站是功能齐全的在这一点上，你会想要做的一点点清理，按照下列指示，以确保您的网站。';
	$lang['WhatToDo'] = '接下来还要做什么:';
	$lang['WhatToDoList'] = '		<li><p>将 "/libs/dbconnect.php" 的访问权限改为 644, 我们不会再去修改这个文件了.</p></li>
		<li><p>如果你已成功安装了Pligg,请从服务器上<strong>删除</strong>  "/install" 这个目录.</p></li>
		<li><p>用你刚才设置的管理员帐号 <a href="../admin/admin_index.php">登录</a>管理界面. 系统会提示你更多的操作信息.</p></li>
		<li><p>用管理界面<a href="../admin/admin_config.php">配置你的网站信息</a> .</p></li>
		<li><p>如果有问题，你可以访问 <a href="http://forums.pligg.com/">Pligg 论坛</a> , 或者就来告诉我们一下你做了一个新站.</p></li>';

// Upgrade
	$lang['UpgradeHome'] = '<p>的Pligg通过点击下面的按钮，将数据库升级到最新版本。它还将增加新的短语的最新产品附加语言文件的底部。您仍然需要上传新文件，并手动更新模板完全与兼容的最新版本。</p><p>我们建议您备份您的网站和数据库到本地计算机，然后再继续，因为升级过程将进行永久性更改你的MySQL数据库。</p>';
	$lang['UpgradeAreYouSure'] = '你确定你想升级你的数据库和语言文件吗?';
	$lang['UpgradeYes'] = '是的';
	$lang['UpgradeLanguage'] = 'Pligg已成功更新了你的语言文件,现在已包括了最新的内容.';
	$lang['UpgradingTables'] = '<strong>更新数据库...</strong>';
	$lang['LanguageUpdate'] = '<strong>更新语言文件...</strong>';
	$lang['IfNoError'] = '如果没有任何出错信息那么升级已经完成!';
	$lang['PleaseFix'] = '暂停更新，请修复上述错误!';
	
// Errors
	$lang['NotFound'] = '没有找到!';
	$lang['CacheNotFound'] = '没有找到! 请在根目录下手工创建 /cache .';
	$lang['DbconnectNotFound'] = '没有找到! 试试把 dbconnect.php.default 改名为 dbconnect.php';
	$lang['SettingsNotFound'] = '没有找到! 试试把 settings.php.default 改名为 settings.php';
	$lang['ZeroBytes'] = '是 0 字节.';
	$lang['NotEditable'] = '不可写. 请修改它的访问权限为 777( CHMOD 777 )';
	
?>