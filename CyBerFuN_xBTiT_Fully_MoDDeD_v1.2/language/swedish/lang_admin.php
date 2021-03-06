<?php
$language['charset']='ISO-8859-1';
$language['ACP_BAN_IP']='Bannlys Ipn';
$language['ACP_FORUM']='Forum inst�llningar';
$language['ACP_USER_GROUP']='Anv�ndar grupp inst�llningar';
$language['ACP_STYLES']='Stil Inst�llningar';
$language['ACP_LANGUAGES']='Spr�k Inst�llningar';
$language['ACP_CATEGORIES']='Kategori Inst�llningar';
$language['ACP_TRACKER_SETTINGS']="Trackerns Inst�llningar";
$language['ACP_OPTIMIZE_DB']='Optimera din Databas';
$language['ACP_CENSORED']='Censurerade ord Inst�llningar';
$language['ACP_DBUTILS']='Databas program';
$language['ACP_HACKS']='Hack';
$language['ACP_HACKS_CONFIG']='Hack Inst�llningar';
$language['ACP_MODULES']='Moduler';
$language['ACP_MODULES_CONFIG']='Modulernas Inst�llningar';
$language['ACP_MASSPM']='Mass privat medelande';
$language['ACP_PRUNE_TORRENTS']="Rensa Torrents";
$language['ACP_PRUNE_USERS']='Rensa Anv�ndare';
$language['ACP_SITE_LOG']='Visa sidans logg';
$language['ACP_SEARCH_DIFF']='Search Diff.';
$language['ACP_BLOCKS']='Block Inst�llningar';
$language['ACP_POLLS']='Omr�stnings Inst�llningar';
$language['ACP_MENU']='Admin Meny';
$language['ACP_FRONTEND']='Inneh�ll Inst�llningar';
$language['ACP_USERS_TOOLS']='Medlemsverktyg';
$language['ACP_TORRENTS_TOOLS']='Torrentverktyg';
$language['ACP_OTHER_TOOLS']='Diverse verktyg';
$language['ACP_MYSQL_STATS']='MySql Statistik';
$language['XBTT_BACKEND']='xbtt inst�llningar';
$language['XBTT_USE']='Anv�nd <a href="http://xbtt.sourceforge.net/tracker/" target="_blank">xbtt</a> som backend?';
$language['XBTT_URL']='xbtt base url dvs. http://localhost:2710';
$language['GENERAL_SETTINGS']='Allm�nna Inst�llningar';
$language['TRACKER_NAME']='Sidans namn';
$language['TRACKER_BASEURL']='Base Tracker URL (without last /)';
$language['TRACKER_ANNOUNCE']='Trackerns Announce URLS (en url per rad)'.($XBTT_USE?'<br />'."\n".'<span style="color:#FF0000; font-weight: bold;">Kontrollera announce adressen tv� g�nger, om du har valt xbtt backend...</span>':'');
$language['TRACKER_EMAIL']='Trackerns/�garens epost';
$language['TORRENT_FOLDER']='Torrent mapp';
$language['ALLOW_EXTERNAL']='Till�t externa torrents';
$language['ALLOW_GZIP']='anv�nd GZIP';
$language['ALLOW_DEBUG']='Visa debug info p� sidans botten';
$language['ALLOW_DHT']='Avaktivera DHT (privat flagga i torrent)<br />'."\n".'anv�nds bara p� nyuppladdade torrents';
$language['ALLOW_LIVESTATS']='Aktivera Live Stats (varning f�r h�g serverbelastning!)';
$language['ALLOW_SITELOG']='Aktivera enkel logg (logga info f�r torrents/medlemmar)';
$language['ALLOW_HISTORY']='Aktivera historia (torrents/medlemmar)';
$language['ALLOW_PRIVATE_ANNOUNCE']='Privat annonsering';
$language['ALLOW_PRIVATE_SCRAPE']='Privat skrapning';
$language['SHOW_UPLOADER']='Visa uppladdarens nick';
$language['USE_POPUP']='Anv�nd Pop-up f�nster f�r Torrents detaljer/peers';
$language['DEFAULT_LANGUAGE']='Standardspr�k';
$language['DEFAULT_CHARSET']='Standard teckenkodning<br />'."\n".'(om ditt spr�k inte visas korrekt, pr�va UTF-8)';
$language['DEFAULT_STYLE']='Standard style';
$language['MAX_USERS']='Max Anv�ndare (numeriskt, 0 = no limits)';
$language['MAX_TORRENTS_PER_PAGE']='Torrents per sida';
$language['SPECIFIC_SETTINGS']='Tracker specifika inst�llningar';
$language['SETTING_INTERVAL_SANITY']='Sj�lvkontroll intervall (numeriskt sekunder, 0 = avaktiverat)<br />Om aktiverat �r 1800 ett bra intervall(30 minuter)';
$language['SETTING_INTERVAL_EXTERNAL']='Uppdaterinsgintervall externa (numeriskt sekunder, 0 = avaktiverat)<br />Bereonde p� hur m�nga externa torrents';
$language['SETTING_INTERVAL_MAX_REANNOUNCE']='Maximualt �terannonseringsintervall (numeriskt sekunder)';
$language['SETTING_INTERVAL_MIN_REANNOUNCE']='Minsta �terannonseringsintervall (numeriskt sekunder)';
$language['SETTING_MAX_PEERS']='Max antal peers f�r f�rfr�gan (numeriskt)';
$language['SETTING_DYNAMIC']='Till�t dynamiska torrents (inte rekommenderat)';
$language['SETTING_NAT_CHECK']='Kontrollera NAT';
$language['SETTING_PERSISTENT_DB']='Uppr�tth�ll kontakter (Databas, inte rekommenderat)';
$language['SETTING_OVERRIDE_IP']='Till�t anv�ndare att k�ra �ver ip';
$language['SETTING_CALCULATE_SPEED']='Ber�kna hastighet och nedladdning (bytes)';
$language['SETTING_PEER_CACHING']='Cacha tabeller (avlastar i viss m�n)';
$language['SETTING_SEEDS_PID']='Max antal seedare med samma PID';
$language['SETTING_LEECHERS_PID']='Max antal leechers med samma PID';
$language['SETTING_VALIDATION']='Validation Mode';
$language['SETTING_CAPTCHA']='S�ker registrering (ImageCode, GD+Freetype m�ste finnas)';
$language['SETTING_FORUM']='Foruml�nk, kan vara:<br /><li><font color="#FF0000">intern</font> eller tom (inget v�rde) f�r internt forum</li><li><font color="#FF0000">smf</font> f�r integrerat <a target="_new" href="http://www.simplemachines.org">Simple Machines Forum</a></li><li>Your own forum solution (Specify url in the box)</li>';
$language['BLOCKS_SETTING']='Index/Block sidinst�llningar';
$language['SETTING_CLOCK']='Klocktyp';
$language['SETTING_NUM_NEWS']='Gr�ns f�r senaste nyhetsblock (numeriskt )';
$language['SETTING_NUM_POSTS']='Gr�ns f�r forumblock (numeriskt )';
$language['SETTING_NUM_LASTTORRENTS']='Gr�ns f�r senaste Torrentsblock (numeriskt )';
$language['SETTING_NUM_TOPTORRENTS']='Gr�ns f�r mest popul�ra Torrentsblock (numeriskt )';
$language['CLOCK_ANALOG']='Analog';
$language['CLOCK_DIGITAL']='Digital';
$language['CONFIG_SAVED']='Konfigurationen har sparats korrekt!';
$language['CACHE_SITE']='Cache intervall (numeriskt sekunder, 0 = avaktiverad)';
$language['ALL_FIELDS_REQUIRED']='Alla f�lt �r obligatoriska!';
$language['SETTING_CUT_LONG_NAME']='Avkorta l�nga torrentnamn efter x bokst�ver (0 = korta inte av)';
$language['MAILER_SETTINGS']='Mailer';
$language['SETTING_MAIL_TYPE']='Mail Typ';
$language['SETTING_SMTP_SERVER']='SMTP Server';
$language['SETTING_SMTP_PORT']='SMTP Port';
$language['SETTING_SMTP_USERNAME']='SMTP anv�ndarnamn';
$language['SETTING_SMTP_PASSWORD']='SMTP l�senord';
$language['SETTING_SMTP_PASSWORD_REPEAT']='SMTP l�senord (repetera)';
$language['XBTT_TABLES_ERROR']='Du m�ste importera xbtt tabeller (l�s xbtt installationsinstruktioner) till din databas innan du aktiverar xbtt backend!';
$language['XBTT_URL_ERROR']='xbtt base url �r obligatorisk!';
// BAN FORM
$language['BAN_NOTE']='H�r kan du se blockerade IPs och blockera nya IPs fr�n trackern.<br />'."\n".'Du m�ste skriva en serie av IPs fr�n (f�rsta IP) till (sista IP).';
$language['BAN_NOIP']='Finns inga blockerade IPs';
$language['BAN_FIRSTIP']='F�rsta IP';
$language['BAN_LASTIP']='Sista IP';
$language['BAN_COMMENTS']='Kommentarer';
$language['BAN_REMOVE']='Ta bort';
$language['BAN_BY']='Av';
$language['BAN_ADDED']='Datum';
$language['BAN_INSERT']='L�gg till ny blockerad IP-serie';
$language['BAN_IP_ERROR']='Felaktig IP-adress.';
$language['BAN_NO_IP_WRITE']='Du har inte skrivit n�gon IP-adress!';
$language['BAN_DELETED']='IP-serien har raderats fr�n databasen.<br />'."\n".'<br />'."\n".'<a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=banip&amp;action=read">Go back to Ban IP</a>';
// LANGUAGES
$language['LANGUAGE_SETTINGS']='Spr�kinst�llningar';
$language['LANGUAGE']='Spr�k';
$language['LANGUAGE_ADD']='L�gg till nytt spr�k';
$language['LANGUAGE_SAVED']='Spr�kinst�llningarna har sparats';
// STYLES
$language['STYLE_SETTINGS']='Style/Tema Inst�llningar';
$language['STYLE_EDIT']='�ndra Style';
$language['STYLE_ADD']='L�gg till ny Style';
$language['STYLE_NAME']='Style namn';
$language['STYLE_URL']='Style URL';
$language['STYLE_FOLDER']='Style mapp ';
$language['STYLE_NOTE']='H�r kan du hantera style-inst�llningar, men du m�ste ladda upp filerna med ftp eller sftp.';
// CATEGORIES
$language['CATEGORY_SETTINGS']='Kategori Inst�llningar';
$language['CATEGORY_IMAGE']='Kategori bild';
$language['CATEGORY_ADD']='L�gg till ny kategori';
$language['CATEGORY_SORT_INDEX']='Sortera Index';
$language['CATEGORY_FULL']='Kategori';
$language['CATEGORY_EDIT']='�ndra Kategori';
$language['CATEGORY_SUB']='Sub-kategori';
$language['CATEGORY_NAME']='Kategori';
// CENSORED
$language['CENSORED_NOTE']='Skriv <b>ett ord per rad</b> f�r att blockera det (�ndras till *censurerat*)';
$language['CENSORED_EDIT']='�ndra censurerade ord';
// BLOCKS
$language['BLOCKS_SETTINGS']='Block konfiguration';
$language['ENABLED']='Aktiverad';
$language['ORDER']='Ordning';
$language['BLOCK_NAME']='Blocknamn';
$language['BLOCK_POSITION']='Position';
$language['BLOCK_TITLE']='Spr�ktitel (anv�nds f�r den �versatta titeln)';
$language['BLOCK_USE_CACHE']='Cacha detta block?';
$language['ERR_BLOCK_NAME']='Du m�ste v�lja en av de aktiverade filerna i namnmenyn!';
$language['BLOCK_ADD_NEW']='L�gg till nytt Block';
// POLLS (more in lang_polls.php)
$language['POLLS_SETTINGS']='Omr�stnings konfiguration';
$language['POLLID']='Omr�stningsId';
$language['INSERT_NEW_POLL']='L�gg till ny omr�stning';
$language['CANT_FIND_POLL']='Hittar inte omr�stning';
$language['ADD_NEW_POLL']='L�gg till omr�stning';
// GROUPS
$language['USER_GROUPS']='Medlems/Grupp Inst�llningar (klicka p� gruppnamn)';
$language['VIEW_EDIT_DEL']='Visa/�ndra/Radera';
$language['CANT_DELETE_GROUP']='Denna Niv�/Grupp kan inte raderas!';
$language['GROUP_NAME']='Gruppnamn';
$language['GROUP_VIEW_NEWS']='Visa nyheter';
$language['GROUP_VIEW_FORUM']='Visa Forum';
$language['GROUP_EDIT_FORUM']='�ndra Forum';
$language['GROUP_BASE_LEVEL']='V�lj basniv�';
$language['GROUP_ERR_BASE_SEL']='Fel vid val av basniv�!';
$language['GROUP_DELETE_NEWS']='Radera nyheter';
$language['GROUP_PCOLOR']='Prefixf�rg (typ ';
$language['GROUP_SCOLOR']='Suffixf�rg (typ ';
$language['GROUP_VIEW_TORR']='Visa Torrents';
$language['GROUP_EDIT_TORR']='�ndra Torrents';
$language['GROUP_VIEW_USERS']='Visa medlemmar';
$language['GROUP_DELETE_TORR']='Radera Torrents';
$language['GROUP_EDIT_USERS']='�ndra medlemmar';
$language['GROUP_DOWNLOAD']='Kan ladda ned';
$language['GROUP_DELETE_USERS']='Radera medlemmar';
$language['GROUP_DELETE_FORUM']='Radera Forum';
$language['GROUP_GO_CP']='Kan administrera (Admin CP)';
$language['GROUP_EDIT_NEWS']='�ndra nyheter';
$language['GROUP_ADD_NEW']='L�gg till ny Grupp';
$language['GROUP_UPLOAD']='Kan ladda upp';
$language['GROUP_WT']='V�ntetid om ratio <1';
$language['GROUP_EDIT_GROUP']='�ndra Grupp';
$language['GROUP_VIEW']='Visa';
$language['GROUP_EDIT']='�ndra';
$language['GROUP_DELETE']='Radera';
$language['INSERT_USER_GROUP']='L�gg till ny medlem/grupp';
$language['ERR_CANT_FIND_GROUP']='Hittar inte denna grupp!';
$language['GROUP_DELETED']='Raderat grupp!';
// MASS PM
$language['USERS_FOUND']='hittade medlemmar';
$language['USERS_PMED']='medlemmar f�tt PM';
$language['WHO_PM']='Vem skall PMet skickas till?';
$language['MASS_SENT']='Mass-PM skickat!!!';
$language['MASS_PM']='Mass-PM';
$language['MASS_PM_ERROR']='F�r fasen skriv n�t innan du skickar det!!!!';
$language['RATIO_ONLY']='endast denna ratio';
$language['RATIO_GREAT']='mer �n denna ratio';
$language['RATIO_LOW']='mindre �n denna ratio';
$language['RATIO_FROM']='Fr�n';
$language['RATIO_TO']='Till';
$language['MASSPM_INFO']='Info';
// PRUNE USERS
$language['PRUNE_USERS_PRUNED']='Redigerat medlemslista';
$language['PRUNE_USERS']='Redigera medlemslista';
$language['PRUNE_USERS_INFO']='Antal dagar innan en medlem anses "d�d" (inte uppkopplad sedan x dagar ELLER har signat sedan x dagar och fortfarande utv�rderas/validates)';
// SEARCH DIFF
$language['SEARCH_DIFF']='S�k diff.';
$language['SEARCH_DIFF_MESSAGE']='Meddelande';
$language['DIFFERENCE']='Differens';
$language['SEARCH_DIFF_CHANGE_GROUP']='�ndra medlem/grupp';
// PRUNE TORRENTS
$language['PRUNE_TORRENTS_PRUNED']='�ndrat i torrentlistan';
$language['PRUNE_TORRENTS']='�ndra torrentlistan';
$language['PRUNE_TORRENTS_INFO']='Antal dagar innan en torrent anses "d�d"';
$language['LEECHERS']='leecher(s)';
$language['SEEDS']='seed(s)';
// DBUTILS
$language['DBUTILS_TABLENAME']='Tabellnamn';
$language['DBUTILS_RECORDS']='Poster';
$language['DBUTILS_DATALENGTH']='Datal�ngd';
$language['DBUTILS_OVERHEAD']='Overhead';
$language['DBUTILS_REPAIR']='Reparera';
$language['DBUTILS_OPTIMIZE']='Optimera';
$language['DBUTILS_ANALYSE']='Analysera';
$language['DBUTILS_CHECK']='Kontrollera';
$language['DBUTILS_DELETE']='Radera';
$language['DBUTILS_OPERATION']='Handling';
$language['DBUTILS_INFO']='Info';
$language['DBUTILS_STATUS']='Status';
$language['DBUTILS_TABLES']='Tabeller';
// MYSQL STATUS
$language['MYSQL_STATUS']='MySQL Status';
// SITE LOG
$language['SITE_LOG']='Site-logg';
// FORUMS
$language['FORUM_MIN_CREATE']='Min klass skapa';
$language['FORUM_MIN_WRITE']='Min klass skriva';
$language['FORUM_MIN_READ']='Min klass l�sa';
$language['FORUM_Inst�llningar']='Forum Inst�llningar';
$language['FORUM_EDIT']='�ndra Forum';
$language['FORUM_ADD_NEW']='L�gg till nytt Forum';
$language['FORUM_PARENT']='F�r�lder-forum';
$language['FORUM_SORRY_PARENT']='(Tyv�rr, kan inte ha f�r�lderforum, �r redan f�r�lderforum)';
$language['FORUM_PRUNE_1']='Det finns �mnen/Inl�gg i detta forum!<br />Du f�rlorar alla data...<br />';
$language['FORUM_PRUNE_2']='S�kert du vill radera detta forum';
$language['FORUM_PRUNE_3']='annars g� tillbaka.';
$language['FORUM_ERR_CANNOT_DELETE_PARENT']='Du kan inte radera ett forum som har underfourm! Flytta till ett annat forum och pr�va igen';
// MODULES
$language['ADD_NEW_MODULE']='L�gg till ny modul';
$language['TYPE']='Type';
$language['DATE_CHANGED']='Datum �ndrat';
$language['DATE_CREATED']='Skapat datum';
$language['ACTIVE_MODULES']='Aktiva moduler: ';
$language['NOT_ACTIVE_MODULES']='Icke aktiva moduler: ';
$language['TOTAL_MODULES']='Totalt antal moduler: ';
$language['DEACTIVATE']='Avaktivare';
$language['ACTIVATE']='Aktivera';
$language['STAFF']='Stab';
$language['MISC']='Diverse';
$language['TORRENT']='Torrent';
$language['STYLE']='Style';
$language['ID_MODULE']='ID';
// HACKS
$language['HACK_TITLE']='Titel';
$language['HACK_VERSION']='Version';
$language['HACK_AUTHOR']='F�rfattare';
$language['HACK_ADDED']='Tillagd';
$language['HACK_NONE']='Inga hack installerade';
$language['HACK_ADD_NEW']='L�gg till nytt hack';
$language['HACK_SELECT']='V�lj';
$language['HACK_STATUS']='Status';
$language['HACK_INSTALL']='Installera';
$language['HACK_UNINSTALL']='Avinstallera';
$language['HACK_INSTALLED_OK']='Hack har installerats!<br />'."\n".'F�r att se vilka hacks som �r installerade g� tillbaka till <a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=hacks&amp;action=read">admin kontrollpanel (Hacks)</a>';
$language['HACK_BAD_ID']='Fel vid h�mtning av hackinfo med detta ID.';
$language['HACK_UNINSTALLED_OK']='Hack har avinstallerats!<br />'."\n".'F�r att se vilka hacks som �r installerade g� tillbaka till <a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=hacks&amp;action=read">admin kontrollpanel (Hacks)</a>';
$language['HACK_OPERATION']='Handling';
$language['HACK_SOLUTION']='L�sning';
// added rev 520
$language['HACK_WHY_FTP']='N�gra av de filer hacket beh�ver modifiera �r inte skrivbara.<br />'."\n".'Du m�ste �ndra dessa r�ttigheter (chmod) eller skapa dessa filer och mappar. <br />'."\n".'Din FTP information kan vara tempor�rt cachad f�r korrekt funktion av hackinstalleraren.';
$language['HACK_FTP_SERVER']='FTP Server';
$language['HACK_FTP_PORT']='FTP Port';
$language['HACK_FTP_USERNAME']='FTP anv�ndarnamn';
$language['HACK_FTP_PASSWORD']='FTP l�senord';
$language['HACK_FTP_BASEDIR']='Lokal s�kv�g f�r xbtit (s�kv�g i roten vid inloggning med FTP)';
// USERS TOOLS
$language['USER_NOT_DELETE']='Du kan inte radera G�st eller dig sj�lv!';
$language['USER_NOT_EDIT']='Du kan inte �ndra  G�st eller dig sj�lv!';
$language['USER_NOT_DELETE_HIGHER']='Du kan inte radera medlemmar med h�gre ranking �n du sj�lv.';
$language['USER_NOT_EDIT_HIGHER']='Du kan inte �ndra medlemmar med h�gre ranking �n du sj�lv.';
$language['USER_NO_CHANGE']='Ingen f�r�ndring genomf�rd.';
?>