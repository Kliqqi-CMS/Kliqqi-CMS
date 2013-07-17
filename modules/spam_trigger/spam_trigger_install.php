<?php
	$module_info['name'] = 'Spam Trigger';
	$module_info['desc'] = 'This module will check all submitted comments and stories for common spam words';
	$module_info['version'] = 1.0;
	$module_info['settings_url'] = '../module.php?module=spam_trigger';
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/spam-trigger/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/spam-trigger/version/';

	global $db;
	$fields = $db->get_results("DESCRIBE ".table_links);
	if ($fields)
	    foreach ($fields as $field)
		if ($field->Field == 'link_status' && !strstr($field->Type,"'moderated'"))
		    $db->query("ALTER TABLE `".table_links."` CHANGE  `link_status`  `link_status` ".str_replace(')',",'moderated')",$field->Type)." DEFAULT  'discard'");

	if (get_misc_data('spam_trigger_light')=='')
	{
		misc_data_update('spam_trigger_light', 'arsehole
ass-pirate
ass pirate
assbandit
assbanger
assfucker
asshat
asshole
asspirate
assshole
asswipe
bastard
beaner
beastiality
bitch
blow job
blowjob
butt plug
butt-pirate
butt pirate
buttpirate
carpet muncher
carpetmuncher
clit
cock smoker
cocksmoker
cock sucker
cocksucker
cum dumpster
cumdumpster
cum slut
cumslut
cunnilingus
cunt
dick head
dickhead
dickwad
dickweed
dickwod
dike
dildo
douche bag
douche-bag
douchebag
dyke
ejaculat
erection
faggit
faggot
fagtard
farm sex
fuck
fudge packer
fudge-packer
fudgepacker
gayass
gay wad
gaywad
god damn
god-damn
goddamn
handjob
jerk off
jizz
jungle bunny
jungle-bunny
junglebunny
kike
kunt
nigga
nigger
orgasm
penis
porch monkey
porch-monkey
porchmonkey
prostitute
queef
rimjob
sexual
shit
spick
splooge
testicle
titty
twat
vagina
wank
xxx
abilify
adderall
adipex
advair diskus
ambien
aranesp
botox
celebrex
cialis
crestor
cyclen
cyclobenzaprine
cymbalta
dieting
effexor
epogen
fioricet
hydrocodone
ionamin
lamictal
levaquin
levitra
lexapro
lipitor
meridia
nexium
oxycontin
paxil
phendimetrazine
phentamine
phentermine
pheramones
pherimones
plavix
prevacid
procrit
protonix
risperdal
seroquel
singulair
topamax
tramadol
trim-spa
ultram
valium
valtrex
viagra
vicodin
vioxx
vytorin
xanax
zetia
zocor
zoloft
zyprexa
zyrtec
18+
acai berry
acai pill
adults only
adult web
apply online
auto loan
best rates
bulk email
buy direct
buy drugs
buy now
buy online
casino
cell phone
child porn
credit card
dating site
day-trading
debt free
degree program
descramble
diet pill
digital cble
direct tv
doctor approved
doctor prescribed
download full
dvd and bluray
dvd bluray
dvd storage
earn a college degree
earn a degree
earn extra money
easy money
ebay secret
ebay shop
erotic
escorts
explicit
find online
fire your boss
free cable
free cell phone
free dating
free degree
free diploma
free dvd
free games
free gift
free money
free offer
free phone
free reading
gambling
get rich quick
gingivitis
health products
heartburn
hormone
horny
incest
insurance
investment
investor
loan quote
loose weight
low interest
make money
medical exam
medications
money at home
mortgage
m0rtgage
movies online
must be 18
no purchase
nudist
online free
online marketing
online movies
online order
online poker
order now
order online
over 18
over 21
pain relief
pharmacy
prescription
production management
refinance
removes wrinkles
rolex
satellite tv
savings on
search engine
sexcapades
stop snoring
stop spam
vacation offers
video recorder
virgin
weight reduction
work at home');
	}
?>
