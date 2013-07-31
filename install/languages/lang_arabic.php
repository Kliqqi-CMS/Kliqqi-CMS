<?php
// header
	$lang['installer'] = 'مثبت';
	$lang['Welcome'] = 'مرحبا';
	$lang['Install'] = 'تثبيت';
	$lang['Upgrade'] = 'ترقية';
	$lang['Troubleshooter'] = 'مكتشف الاخطاء';
	$lang['Step'] = 'خطوة';
	$lang['Readme'] = 'اقرأني';
	$lang['Admin'] = 'مدير';
	$lang['Home'] = 'الرئيسية';
	$lang['Install_instruct'] = 'رجاء احصل على بيانات MySQL الخاصة بك. اذهب الى ترقية للترقية من موقع موجود مسبقا.';
	$lang['Upgrade_instruct'] = 'الترقية ستقوم بتعديلات على قاعدة البيانات الخاصة بك. تأكد من قيامك بالنسخ الاحتياطي قبل المتابعة.';
	$lang['Troubleshooter_instruct'] = 'مكتشف الاخطاء سيتعرف على المشاكل الشائعة كصلاحيات المجلدات';

// intro / step 1
	$lang['WelcomeToInstaller'] = 'مرحبا بك في مثبت pligg!';
	$lang['Introduction'] = 'مقدمة';
	$lang['WelcomeToThe'] = 'مرحبا بكم مع <a href="http://www.pligg.com" target="_blank">Pligg Content Management System</a>. قبل التثبيت الرجاء التأكد من حصولك على أحدث اصداراتنا من <a href="http://www.pligg.com/download.php" target="_blank">the official Pligg Download Page</a>.';
	$lang['Bugs'] = 'عند زيارتك لموقع Pligg.com, رجاء قم بقراءة الوثائق المقدمة من مجموعتنا. كما نقترح عليك التسجيل معنا للحصول على الكثير من المصادر من خلال هذا الرابط<a href="http://forums.pligg.com/" target="_blank">Pligg Forum</a>. في حال وجدت أية مشاكل في النسخة التي تستخدمها الرجاء ابلاغنا عنها من خلال هذا الرابط <a href="http://forums.pligg.com/projects/pligg-cms/index.html" target="_blank">report it</a>.';
	$lang['Installation'] = 'التثبيت - اقرأها جيدا';
	$lang['OnceFamiliar'] = '<p>إذا كانت هذه مرتك الأولى التي تثبت فيها Pligg عليك متابعة التعليمات من خلال هذه الصفحة. اذا كنت تريد <a href="./upgrade.php">ترقية موقعك</a> من نسخة أقدم فقم بالنقر على ترقية. تحذير: قيامك بعملية التثبيت على موقع موجود مسبقا سيقوم بالكتابة على اليانات الموجودة.</p><br />
	<ol>
		<li>قم بإعادة تسمية settings.php.default إلى settings.php</li>
		<li>إعادة تسمية /languages/lang_english.conf.default إلى lang_english.conf</li>
		<li>قم بإعادة تسمية  /libs/dbconnect.php.default إلى dbconnect.php</li>
		<li>إعادة تسمية الدليل /logs.default إلى /logs</li>
		<li>بدل صلاحيات المجلدات التالية إلى 755 ، في حال حدوث خطأ حاول تغيره الى 777.</li>
		<ol>
			<li>/admin/backup/</li>
			<li>/avatars/groups_uploaded/</li>
			<li>/avatars/user_uploaded/</li>
			<li>/cache/</li>
			<li>/languages/ (جميع الملفات في هذا المجلد يجب ان تملك صلاحيات 777)</li>
		</ol>
		<li>4. بدل صلاحيات الملفات التالية الى 666</h4>
		<ol>
			<li>/libs/dbconnect.php</li>
			<li>settings.php</li>
		</ol>
	</ol>
	أنت الآن في الماضي الجزء الأصعب! المضي قدما إلى الخطوة التالية لتثبيت Pligg على قاعدة بيانات MySQL الخاص بك.';

// step 2
	$lang['EnterMySQL'] = 'قم بإدخال بيانات قاعدة البيانات الخاصة بك.';
	$lang['DatabaseName'] = 'إسم قاعدة البيانات';
	$lang['DatabaseUsername'] = 'إسم المستخدم';
	$lang['DatabasePassword'] = 'كلمة السر';
	$lang['DatabaseServer'] = 'رابط الخادم';
	$lang['TablePrefix'] = 'البادئة';
	$lang['PrefixExample'] = '(مثال: "pligg_" تجعل جدول المستخدم pligg_users)';
	$lang['CheckSettings'] = 'التحقق من الاعدادات';
	$lang['Errors'] = 'فشل التثبيت، الرجاء التحقق من المشكلات اعلاه!';
	$lang['LangNotFound'] = 'لم يتم العثور. يرجى إزالة التمديد. الافتراضية من جميع ملفات اللغة وحاول مرة أخرى.';

// step 3
	$lang['ConnectionEstab'] = 'تم تأسيس إتصال بقاعدة البيانات';
	$lang['FoundDb'] = 'قاعدة البيانات موجودة';
	$lang['dbconnect'] = '\'/libs/dbconnect.php\' حدث بنجاح.';
	$lang['NoErrors'] = 'لا أخطاء، انتقل للخطوة التالية';
	$lang['Next'] = 'التالي';
	$lang['GoBack'] = 'ارجع';
	$lang['Error2-1'] = 'لا يمكن الكتابة على \'libs/dbconnect.php\' .';
	$lang['Error2-2'] = 'لا يمكن فتح \'/libs/dbconnect.php\' للكتابة عليه.';
	$lang['Error2-3'] = 'تم الاتصال بقاعدة البيانات ، لكن اسم قاعدة الي.';
	$lang['Error2-4'] = 'لا يمكن الاتصال بخادم قاعدة البيانات، الرجاء التاكد من البيانات المدخلة.';

// step 4
	$lang['CreatingTables'] = '<p><strong>انشاء جداول....</strong></p>';
	$lang['TablesGood'] = '<p><strong>تم انشاء الجداول بنجاح!</strong></p><hr />';
	$lang['Error3-1'] = '<p>كان هناك مشكلة عند محاولة انشاء الجداول.</p>';
	$lang['Error3-2'] = '<p>لا يمكن الاتصال بقاعدة البيانات.</p>';
	$lang['EnterAdmin'] = '<p><strong>قم بادخال بيانات المدير:</strong><br />الرجاء الاحتفاظ بهذه البيانات.</p>';
	$lang['AdminLogin'] = 'إسم المدير';
	$lang['AdminPassword'] = 'كلمة السر';
	$lang['ConfirmPassword'] = 'تأكيد كلمة السر';
	$lang['AdminEmail'] = 'البريد الالكتروني';
	$lang['SiteTitleLabel'] = 'اسم الموقع';
	$lang['CreateAdmin'] = 'انشئ حساب المدير';

// Step 5
	$lang['Error5-1'] = 'الرجاء قم بتعبئة كل البيانات.';
	$lang['Error5-2'] = 'كلمة المرور غير متطابقة. الرجاء العودة واعادة ادخال كلمة المرور.';
	$lang['AddingAdmin'] = 'إضافة حساب المدير ... ';
	$lang['InstallSuccess'] = '<a href="../">موقع pligg الخاص بك</a> تم تثبيته بنجاح!';
	$lang['InstallSuccessMessage'] = 'تهانينا، قمت بإعداد موقع على شبكة الانترنت Pligg CMS! في حين موقعك يعمل بشكل كامل عند هذه النقطة، سوف تريد أن تفعل قليلا تنظيف باتباع الإرشادات أدناه لتأمين موقع الويب الخاص بك.';
	$lang['WhatToDo'] = 'ما هي الخطوة التالية:';
	$lang['WhatToDoList'] = '		<li><p>قم بارجاع صلاحيات "/libs/dbconnect.php" الى 644, لن تحتاج لتغيير هذه الاعدادات لاحقا.</p></li>
		<li><p><strong>قم بحذف</strong> مجلد "/install" من موقعك.</p></li>
		<li><p>قم بالدخول <a href="../admin/admin_index.php">لمنطقة المدير</a> باستخدام البيانات التي قمت بادخالها مسبقا.</p></li>
		<li><p><a href="../admin/admin_config.php">تحكم بموقعك</a> من منطقة المدير.</p></li>
		<li><p>قم بزيارة <a href="http://forums.pligg.com/">Pligg Forums</a> في حال كان لديك أية أسئلة أو أردت إبلاغنا عن موقعك الجديد.</p></li>';
	$lang['ContinueToSite'] = 'يواصل موقع الويب الخاص بك جديد';

// Upgrade
	$lang['UpgradeHome'] = 'سيتم تحديث قاعدة البيانات للنسخة 0.0.9 و ما بعدها. أيضا سيتم ترقية ملفات أخرى كملفات اللغة.<br /> الرجاء أخذ نسخة احتياطية من موقعك حيث ان عملية الترقية ستؤدي الى تغييرات كاملة في موقعك الحالي.';
	$lang['UpgradeAreYouSure'] = 'هل انت متأكد من كونك تريد ترقية قاعدة البيانات و ملف اللغة الخاصة بموقعك؟';
	$lang['UpgradeYes'] = 'نعم';
	$lang['UpgradeLanguage'] = 'تم ترقية ملف اللغة بنجاح.';
	$lang['UpgradingTables'] = '<strong>ترقية قاعدة البيانات ....</strong>';
	$lang['LanguageUpdate'] = '<strong>ترقية ملف اللغة ....</strong>';
	$lang['IfNoError'] = 'في حال عدم ظهور أية أخطاء فذلك يدل على انتهاء عملية الترقية';
	$lang['PleaseFix'] = 'الرجاء اصلاح الاخطاء. تم ايقاف عملية الترقية';
	
// Errors
	$lang['NotFound'] = 'غير موجود';
	$lang['CacheNotFound'] = 'لم يتم ايجاده. الرجاء القيام بانشاء مجلد باسم /cache في المجلد الاساسي للموقع.';
	$lang['DbconnectNotFound'] = 'لم يتم ايجاده. الرجاء القيام بتغيير اسم الملف dbconnect.php.default الى dbconnect.php';
	$lang['SettingsNotFound'] = 'لم يتم ايجاده. الرجاء القيام بتغيير اسم الملف settings.php.default الى settings.php';
	$lang['ZeroBytes'] = 'is 0 bytes.';
	$lang['NotEditable'] = 'غير قابل للكتابة. غير الصلاحيات الى 777';
	
?>