<?php
// header
	$lang['installer'] = 'การติดตั้ง';
	$lang['Welcome'] = 'ยินดีต้อนรับ';
	$lang['Install'] = 'ติดตั้ง';
	$lang['Upgrade'] = 'อัพเกรด';
	$lang['Troubleshooter'] = 'ปัญหาที่พบบ่อย';
	$lang['Step'] = 'ขั้นที่';
	$lang['Readme'] = 'คำแนะนำ';
	$lang['Admin'] = 'ผู้ดูแล';
	$lang['Home'] = 'หน้าแรก';
	$lang['Install_instruct'] = 'Please have your MySQL information handy. See Upgrade to upgrade an existing site.';
	$lang['Upgrade_instruct'] = 'Upgrading will make modifications to your MySQL database. Be sure to backup before proceeding.';
	$lang['Troubleshooter_instruct'] = 'The Troubleshooter will detect common problems such as incorrect folder permissions';

// intro / step 1
	$lang['WelcomeToInstaller'] = 'ยินดีต้อนรับเข้าสู่การติดตั้ง Pligg!';
	$lang['Introduction'] = 'บทนำ';
	$lang['WelcomeToThe'] = 'ยินดีต้อนรับเข้าสู่ <a href="http://www.pligg.com" target="_blank">Pligg CMS</a>. ก่อนที่จะทำการติดตั้ง Pligg CMS กรุณาตรวจสอบให้แน่ใจว่าคุณมีเวอร์ชันล่าสุดของ Pligg อยู่ โดยตรวจสอบได้จาก <a href="http://www.pligg.com/download.php" target="_blank">หน้าดาวน์โหลด Pligg เวอร์ชั่นล่าสุด</a>.';
	$lang['Bugs'] = 'ขณะที่คุณอยู่ใน <a href="http://www.pligg.com/">Pligg.com</a>, กรุณาศึกษาข้อมูลด้วยตัวคุณเองจากเอกสารที่เรามีให้, พร้อมกับแนะนำให้คุณลงทะเบียนใน <a href="http://www.pligg.com/" target="_blank">เว็บบอร์ดของ Pligg</a> ที่ที่คุณจะได้พบกับโมดูลฟรี, เทมเพลตและสิ่งอื่นๆ ที่จะช่วยสร้างเว็บของคุณ. ถ้าคุณพบบั๊กหรือปัญหาการใช้งานด้านภาษาใน Pligg กรุณา <a href="http://forums.pligg.com/projects/pligg-cms/index.html">แจ้งบั๊ก</a> ตามช่องทางหรับรายงานบั๊ก ในหน้าเว็บของเรา เพื่อที่จะได้ปรับปรุงแก้ไขสำหรับเวอร์ชั่นถัดไปในอนาคต.</p>';
	$lang['Installation'] = 'การติดตั้ง (กรุณาอ่านด้วยความระมัดระวัง)';
	$lang['OnceFamiliar'] = '<p>ถ้านี่เป็นครั้งแรกที่คุณติดตั้ง Pligg คุณจะดำเนินการต่อไปได้หลังจากอ่านขั้นตอนข้างล่างอย่างระมัดระวังแล้ว. ถ้าต้องการ <a href="./upgrade.php">อัพเกรดเว็บไซต์</a> จากเวอร์ชั่นก่อนหน้านี้, ให้เรียกสคริปต์อัพเกรดโดยคลิ๊กที่เมนูอัพเกรดด้านบน. คำเตือน: ดำเนินการติดตั้งตามขั้นตอนนี้ในขณะที่มีเว็บ Pligg ติดตั้งอยู่แล้ว จะทำให้เรื่องที่ซับมิทมาทั้งหมดและการตั้งค่าต่างๆ ถูกเขียนทับ, ดังนั้นต้องแน่ใจว่าคุณต้องการติดตั้งใหม่ถึงจะเริ่มดำเนินการต่อด้านล่าง.</p><br />
	<ol>	
		<li>เปลี่ยนชื่อ settings.php.default เป็น settings.php</li>
		<li>ตั้งชื่อใหม่ /languages/lang_english.conf.default เพื่อ lang_english.conf</li>
		<li>ตั้งชื่อใหม่ /languages/lang_thai.conf.default เพื่อ lang_thai.conf</li>
		<li>ตั้งชื่อใหม่ /libs/dbconnect.php.default เพื่อ dbconnect.php</li>
		<li>ตั้งชื่อใหม่ /logs.default เพื่อ /logs</li>
		<li>CHMOD 777 โฟลเดอร์ต่อไปนี้, ถ้าพบปัญหาให้ลองใช้ 777.</li>
		<ol>
			<li>/admin/backup/</li>
			<li>/avatars/groups_uploaded/</li>
			<li>/avatars/user_uploaded/</li>
			<li>/cache/</li>
			<li>/languages/ (และไฟล์ทั้งหมดข้างในโฟลเดอร์นี้ก็ควรจะ CHMOD เป็น 777)</li>
		</ol>
		<li>CHMOD 666 ไฟล์ต่อไปนี้</li>
		<ol>
			<li>/libs/dbconnect.php</li>
			<li>settings.php</li>
		</ol>
	</ol>
	คุณอยู่ตอนนี้ผ่านมาส่วนที่ยากที่สุด! ดำเนินการขั้นตอนต่อไปที่จะติดตั้งลงบนเว็บฐานข้อมูล MySQL ของคุณ</p>';

// step 2
	$lang['EnterMySQL'] = 'ใส่รายละเอียดของฐานข้อมูล MySQL ด้านล่างนี้. ถ้าไม่รู้ข้อมูลสำหรับฐานข้อมูลของคุณ คุณควรจะไปตรวจสอบกับเว็บโฮสติ้งหรือติดต่อฝ่ายช่วยเหลือของเว็บโฮสติ้งที่คุณใช้โดยตรง.';
	$lang['DatabaseName'] = 'ชื่อฐานข้อมูล';
	$lang['DatabaseUsername'] = 'ชื่อผู้ใช้ฐานข้อมูล';
	$lang['DatabasePassword'] = 'รหัสผ่านฐานข้อมูล';
	$lang['DatabaseServer'] = 'เซิร์ฟเวอร์ฐานข้อมูล';
	$lang['TablePrefix'] = 'คำนำหน้าตาราง';
	$lang['PrefixExample'] = '(เช่น: "pligg_" จะทำให้ตารางชื่อ users กลายเป็น pligg_users)';
	$lang['CheckSettings'] = 'ตรวจสอบการตั้งค่า';
	$lang['Errors'] = 'กรุณาตรวจสอบข้อผิดพลาด, หยุดติดตั้ง!';

// step 3
	$lang['ConnectionEstab'] = 'กำลังติดต่อฐานข้อมูล...';
	$lang['FoundDb'] = 'พบฐานข้อมูลแล้ว...';
	$lang['dbconnect'] = 'อัพเดท \'/libs/dbconnect.php\' เรียบร้อยแล้ว.';
	$lang['NoErrors'] = 'ไม่มีข้อผิดพลาด, ดำเนินการในขั้นต่อไป...';
	$lang['Next'] = 'ดำเนินการต่อ';
	$lang['GoBack'] = 'ย้อนกลับ';
	$lang['Error2-1'] = 'ไม่สามารถเขียนไฟล์ \'libs/dbconnect.php\'.';
	$lang['Error2-2'] = 'ไม่สามารถเปิดไฟล์ \'/libs/dbconnect.php\' เพื่อเขียนข้อมูลลงไปได้.';
	$lang['Error2-3'] = 'เชื่อมต่อไปยังฐานข้อมูลแล้ว, แต่ชื่อฐานข้อมูลผิดพลาด.';
	$lang['Error2-4'] = 'ไม่สามารถเชื่อมต่อไปยัง <b>เซิร์ฟเวอร์</b> ของฐานข้อมูลโดยใช้รายละเอียดที่คุณกรอกมา.';

// step 4
	$lang['CreatingTables'] = '<p><strong>กำลังสร้างตารางในฐานข้อมูล...</strong></p>';
	$lang['TablesGood'] = '<p><strong>สร้างตารางในฐานข้อมูลเสร็จแล้ว!</strong></p><hr />';
	$lang['Error3-1'] = '<p>ไม่มีปัญหาในขั้นตอนการสร้างตารางในฐานข้อมูล.</p>';
	$lang['Error3-2'] = '<p>ไม่สามารถเชื่อมต่อฐานข้อมูลได้.</p>';
	$lang['EnterAdmin'] = '<p><strong>ใส่รายละเอียดบัญชีของผู้ดูแลระบบ:</strong><br />กรุณาใส่ข้อมูลต่อไปนี้เพื่อใช้ในการล็อกอินและเข้าไปจัดการในส่วนคอนโทรลพาแนลของผู้ดูแล.</p>';
	$lang['AdminLogin'] = 'ชื่อล็อกอินของผู้ดูแล';
	$lang['AdminPassword'] = 'รหัสผ่านของผู้ดูแล';
	$lang['ConfirmPassword'] = 'ยืนยันรหัสผ่าน';
	$lang['AdminEmail'] = 'อีเมล์ของผู้ดูแล';
	$lang['SiteTitleLabel'] = 'ชื่อเว็บไซต์';
	$lang['CreateAdmin'] = 'สร้างบัญชีผู้ดูแลใหม่';

// Step 5
	$lang['Error5-1'] = 'กรุณาใส่รายละเอียดสำหรับบัญชีผู้ดูแล.';
	$lang['Error5-2'] = 'รหัสผ่านไม่เหมือนกัน. กรุณาย้อนกลับไปและใส่รหัสผ่านใหม่.';
	$lang['AddingAdmin'] = 'กำลังเพิ่มบัญชีผู้ดูแล...';
	$lang['InstallSuccess'] = '<a href="../">เว็บ Pligg ของคุณ</a> ติดตั้งเสร็จสมบูรณ์แล้ว!';
	$lang['InstallSuccessMessage'] = 'ขอแสดงความยินดีที่คุณได้ตั้งค่าเว็บไซต์ Pligg CMS! ในขณะที่เว็บไซต์ของคุณทำงานได้อย่างสมบูรณ์ที่จุดนี้คุณจะต้องการที่จะทำเล็ก ๆ น้อย ๆ ทำความสะอาดโดยทำตามคำแนะนำด้านล่างเพื่อความปลอดภัยของเว็บไซต์ของคุณ';
	$lang['WhatToDo'] = 'ควรจะทำอะไรต่อ:';
	$lang['WhatToDoList'] = '		<li>chmod ไฟล์ "/libs/dbconnect.php" กลับไปเป็น 644, เราไม่จำเป็นต้องเปลี่ยนไฟล์นี้อีกแล้ว.</li>
		<li><strong>ลบ</strong> โฟลเดอร์ "/install" บนเว็บเซิร์ฟเวอร์ทิ้งไปเลยถ้าคุณติดตั้ง Pligg เสร็จสมบูรณ์แล้ว.</li>
		<li>เข้าสู่ระบบที่ <a href="../admin/admin_index.php">ส่วนของผู้ดูแล</a>. หลังจากล็อกอินครั้งแรก คุณจะได้พบกับหน้าต่างต้อนรับพร้อมข้อมูลวีธีใช้งาน Pligg.</li>
		<li><a href="../admin/admin_config.php">ตั้งค่าเว็บของคุณ</a> ผ่านทางส่วนของผู้ดูแล.</li>
		<li>เยี่ยมชม <a href="http://forums.pligg.com/">เว็บบอร์ด Pligg</a> ถ้าคุณมีข้อสงสัยอะไร, หรือแค่ต้องการมาโชว์เว็บ Pligg ของคุณ.</li>';
	$lang['ContinueToSite'] = 'ดำเนินการต่อไปยังเว็บไซต์ใหม่ของคุณ';

// Upgrade
	$lang['UpgradeHome'] = '<p>โดยคลิกที่ปุ่มด้านล่างโปรโมทจะมีการปรับฐานข้อมูลของคุณให้เป็นรุ่นล่าสุด นอกจากนี้ยังจะเพิ่มวลีใหม่โดยท้ายข้อมูลเพิ่มเติมครั้งล่าสุดที่ด้านล่างของไฟล์ภาษาของคุณ คุณยังจะต้องอัปโหลดไฟล์ใหม่และปรับปรุงตนเองแม่แบบของคุณจะเข้ากันได้อย่างเต็มที่กับรุ่นล่าสุด</p><p>เราขอแนะนำให้คุณสำรองข้อมูลเว็บไซต์และฐานข้อมูลไปยังเครื่องคอมพิวเตอร์ของคุณก่อนที่จะดำเนินการอัพเกรดเพราะจะทำให้การเปลี่ยนแปลงที่ถาวรไปยังฐานข้อมูล MySQL ของคุณ</p>';
	$lang['UpgradeAreYouSure'] = 'แน่ใจนะว่าต้องการอัพเกรดฐานข้อมูลและไฟล์ภาษา?';
	$lang['UpgradeYes'] = 'ใช่';
	$lang['UpgradeLanguage'] = 'สำเร็จ, Pligg อัพเดทไฟล์ภาษาเรียบร้อยแล้ว. ตอนนี้คุณได้รับไฟล์ภาษาเวอร์ชั่นล่าสุดแล้ว.';
	$lang['UpgradingTables'] = '<strong>กำลังอัพเกรดฐานข้อมูล...</strong>';
	$lang['LanguageUpdate'] = '<strong>กำลังอัพเกรดไฟล์ภาษา...</strong>';
	$lang['IfNoError'] = 'ถ้าไม่มีการแสดงข้อผิดพลาด ก็หมายความว่า, อัพเกรดเสร็จสมบูรณ์แล้ว!';
	$lang['PleaseFix'] = 'กรุณาแก้ไขตามข้อผิดพลาดที่ปรากฎ, อัพเกรดไม่สำเร็จ!';

// Errors
	$lang['NotFound'] = 'ไม่พบ!';
	$lang['CacheNotFound'] = 'ไม่พบ! สร้างโฟลเดอร์ใหม่ชื่อ /cache บนเซิร์ฟเวอร์.';
	$lang['DbconnectNotFound'] = 'ไม่พบ! ลองเปลี่ยนชื่อไฟล์ dbconnect.php.default เป็น dbconnect.php';
	$lang['SettingsNotFound'] = 'ไม่พบ! ลองเปลี่ยนชื่อไฟล์ settings.php.default เป็น settings.php';
	$lang['ZeroBytes'] = 'มีขนาด 0 ไบต์.';
	$lang['NotEditable'] = 'ไม่สามารถเขียนได้. กรุณา CHMOD เป็น 777';
	
?>