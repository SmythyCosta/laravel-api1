-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: laravel_api1
-- ------------------------------------------------------
-- Server version	5.7.19-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `company_name` longtext NOT NULL,
  `address` longtext NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `vat_percentage` int(2) DEFAULT NULL,
  `discount_percentage` int(2) DEFAULT NULL,
  `language` longtext,
  `image` blob,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'softhunter.net','dhaka','01765620368','admin@softhunter.net','USD',NULL,NULL,'','‰PNG\r\n\Z\n\0\0\0\rIHDR\0\0r\0\0r\0\0\0\ßú¡;\0\0\0xPLTEÿÿÿ   \×\××«««šššýýý£££ùùùûûûôôô¥¥¥§§§°°°\ç\ç\ç\Ê\ÊÊ­­­\ï\ï\ï\Ý\ÝÝ©©©ööö\ì\ìì³³³\Ç\Ç\Ç\à\à\à\Î\Î\Î\Ô\Ô\Ô\ä\ä\ä\Â\Â\Â\Ñ\Ñ\Ñ\Ú\ÚÚµµµ\é\éé½½½ñññ¿¿¿\Ä\ÄÄ¹¹¹»»»···#\Õ\ÛH\0\0\ÇIDATx\Ú\ìÁ\0\0\0\0€ ý©©\0\0\0\0\0\0\0\0\0\0\0\0\0\0˜]{[V¢\0šnH\Â-ƒ\\D”ÿÿÃ±\nkÊ™3\ÎQ—‡ôz\ãuWjÓ\nù›\Â÷}\ïÁ\íSÁ\ÈLü ‹÷¦©vº\éª1eœ#SóÏ±©ums¥7\îR7Q*o¯]7û\r?±\ÍJG.*’ÀGø!„\É\Ð\é\Ê*™Ÿ\Þ63u—\È1gxjLÒ‹¾¥\îQ\ìS\ä!¼Eªƒ“ùŒ|\Â+u\ëF€ˆð:DÓ¼7gF\Þ$²¦\È%rDxr.UWé¨¿\Ã\Û4]ŠaôQ\ê\×*\Þ2ò\Z8‰ðCùnC[\ÒK|sŠ$L@\Ê\Ö	ùŽˆµŽ0\ä˜-H\ß8;\Ã=ð‰BW;\Zÿ\ÇÏŠ¦„p-·\Ô\è\Ï[¼…$š\Zý‰`§\0arQŸ1òc©Ì\ËÓž\ný?¾\ÂLsC{Ñ—\Ä˜U\âÐ´ø§2—³r+\ê–¢la^œ\Îù±8ÌŽ\'\re~\ç„%¸†ºet>…Ky\Ì\ÈM J»##Ì«B„… ô4ž3Q*‹\á.-,\è–”Ç¶_+úu\ÊaA({Ë¯E¬\0aQac÷¤x\îaY|°{R,#Xž¶¹Íƒaqübópn\Ô\Z‘Gµ½\Ç\Ü+V€ƒµO¢E\ÜrXw­}\Ü\"*wSZ;›{\'X\'rP–þ@EœpX‡t\ì\\‡¶u´V\äx\Ø0ýb\ïÊ–Ü„ 4 	\Ä}\Æ¶±ÿÿ³NŒ`±°\ã\Ê.Te¶_¶R¡6•FŒfF=­¨@WB¾!\á›t58A{G\×ƒ¹\0\èZ`-\Æ`ž\èz`{ŒÁ\Üÿbas?÷üw{;‚qB¿^Q›K&\âFü_ Á‡ZÐ¯xµL‡Ò¨‹\Þ\nðª\0mðu¶xE¿\à\Ý\Õo\\vEþr¤Z|-\ë\Ì\è—Â¬\ïœs+v\ç\Âóý3B·Ì§¯¥ÀIT¬hS\íƒ\'û§.3\Ï.\ì‘5 ÿ\0\æ\Åö\ÄuA\0\Ì>\\¢£\Ü\Ô7G\Ð\Ë?Oq¿IÄòY¡Ì§”C´!ý§•\Þ\'†E»=…¥\Ü»¦Z)£M]t/-*`>\Û.\äd“ÎªDû\Û Ù¢£|›Àtfÿñ-\Ûû§¬‡\ÎV;b;U\ÖJC»\ÐÁ-\Ðip·.\ÌM8Xþ¶3\Å\ìbNº6w…>As2Á¦uAóA4\è(¯xò\Ëø4·óAR\Él{1õ\Í\Zù\è\ÐU¸ðCùC`9É‰uœ\Ü0ªC~°Ó£o4¦&ü0³\ÖX\ê<\Ê{AœÐòW\ã•\Çtc7\Òu\áD!W;eÕ¹Qö\'S¤F8yD‹›rZi\ë+>i\ëv·\ä÷‘\è\ê\êN\Þ\ns‚Tw•S@OùxBh\ï=¤qºc4EWV\íi³\Å\ç:\Çõ\'°Œ)¯\ÒY;Ð¨2¦”wþð@V\ç\0ŸÈ¬¤\Ö$ c\Ø)w\Ã\É,d\Ù8lºw\ã@½)B`c-\ÖF?B}e,˜)\ÑE\ä¢GkœŠN)[gLg¥/,ý“£$3\ån•¾2€º:Ï³\ï(\å\é¬óg\Þ]#\0s^®(g\æ\Ë>*\Ï\nž\Íûp«¼RE§i\Ìýš\Ë\å7€—ñ¿0\r\Ù8/\É\Ö!PGh,¢…}\ÆLùPðC‘×°\â+…§šY{\0÷72ó\íbˆf:\Êwžžòyø3„ŽZ÷)\Äw\ë\"–Ô–þ½5€¸y[\æ\ìM\Êy\ÖP­-½bý\"\àOÒ­_\Âi\ÃS¾Ù¿A¹j	\nè“œ7Ñ³`ô\Þaf•3Ä§B~§¡üŽU (\×\çð·MœXß´Q\Û\'ñhE\í”+¤µG\á\å$­L\nªèŸ\å\Ì\ÃgVy<\r”gü)º\Ôö©…U›\0\â’\Í\Är\Ä:–\å\Þ;)\ÖmÂˆ…Æ“{ˆnOx¾6»?)\ÊóZ\Ë*†\ì­o\\\Ö	°¼|þ±Žò£\Ò+A‡pÂ¹Ra5)\í÷&\éLuŠ4[Øº”§c\Ê\Ø\Ý\î9;³\äM\á”U9\×\ìEôq\Îò\Ù;\Ð3¾ENG\Õ\Þõ›µwz\ä‹\'‚*zf¢ ø\'\ã\æ\í{ˆ¢W¡HJ]`Ù…=\å\î–\à\Ã&\Ë\ÚÁ\à\Ó\0!\ÆY¡¬U§B—ˆ,»p`\èþ\âC\Ô(Ê½Œ,«¥€yQ#Y²Cî¯µ£=œe¾r\åªÀ\ç\"\Ç\Ó(\ZM!.cboBU|\ÇHbj²p\Ë\ß6m.\Æ\ê«`ƒ\Z\Ô;‚Q\Ío¡#„ \n\Å\")K:Ò´‹$šADn„\ÐO¿ýù\Ñ-²Ê³j\î>\àH\äC#¯> ®¸1.²F{A)W\ÇüH\Æ\â¬A\ätA\ã\Ý~.RB49UM¢*‚+Ž\Ë\ã2%§Å‘\Ûq\Î(]¤\ãQ:”™[\É\Ó:Q\éiLÀ2\\\è¨\Ù\í\ÏqHY±Àn”¹¿\'\æ†A@! ’AK=¿¿ÿc\ß%\0\Ü÷K©ú;\'†O\ÑIÀ}ò\ÒR\×Q,a¢w¸\'¢}K®z-\Ùþ®b3ûtÁ.§&ßŽ2[k\â \0&†&\îÁS%Izùv\ÄIxà½¾ W\Ñ85ùÿ\á{\âAIb˜­M¾Û‘\ØVž\"Êòƒ¢Y¶ù‘“\ï…}ö2þ@¹‹‹ò‘^j»ÿvñT\Ô4œ`§|¤*\Ïß®\Êôƒz¬ˆ\ÄDù!ð }M£ol¤ª\â\ÑóB\åg\Ô\nX]T{w\ÊQœkO^ò\Þ\'Z}­þFU\×#Y	Ö™\"»~k\ç\Â0G¾\nøQi+m-\î‡}\'q»\Òÿ\×.Õ¹³\â(N^ú#¡U©:‘»Á\Ä!Ú²‚>²$+ehOIó0ìž„Øƒþ5X%M´vô.\æ8Î›ù±cƒ¥\Ö\nˆzi\"$¡ü\è7\Ðb…enB\Å‹üe+¼ú\ê#3ñ\Ü[&\ÏjdgyUƒ]\è]]Ð¨µ\Ý\áÈ…KP»Aùž¡aü\Ó\Å\ä\"X”ó\Ô•¬¿Ã‘!önn&½\åÜª“\áe×ˆ9!i\à–K\Ë\ÙZó‘\×E\ÑDÀ£+\ÐÁBh©´¥\Ü\ía¢»Œb²\Å\ïõµ\Ó>\æ\âs²Fr\r®p?\ì0ñ™ôÿbï¼¶Ä0\ÌH¢÷Wüþo¸iÀz7Ž’\ãH\ßeNrBþ\à\Ñhª¦Ù•#;\ÎfuNŽH½I˜nç ‰˜úro²+;ù¦±|`O\Ã$\É>Õ¸c\Öó\ìòµœŠkZ4ý\Ý\ë\Ã\ÔÀ/CZÿ+6f\ÜPª;\ã/“qü\ÍÿCŠ9÷ºÝ’1|)G\Âó{\ìb”\Ü\åž Š\ÃQrù¶Pü›Ò€/8O« \ænŠ­\ÈPR~{\Z©\Êø\Þ­\Øcôr©˜°Já“£¯q\Ä\ÞM>¹|7ýS\ÒC±T«LF³\âùš\Ü\ÌC\Ý\Ç`\êœA&EIÜ…\èNCÝ¸ù\æt^ú\ïI{ñüf\×*9r|\Ìùm7Ü’Ÿ\ÈAŒ\Ó\×üE¯\\¯@\ìN‘\Æ³˜—™É–\n:7Jn,<\É\Èñ8¢%)û¼HŽ\ï`\Ïå–’¶\Õ\Åó{ž‰S[\ÚÄ’\×-9“ú\ç¡\ëi\àr\Ïáž²m\Ùh¸beÉ¿ Õ´^rù,°\ÕMAyù–ž\'Û©—jË²SO˜Ë·ñ\ãtÞ™÷^q\È<9ò\r]ý‰m1\å%¶·Í‘\ÈXõy£ˆŸ^E¿¨2\æ|vÊœ~û±x\êfv\Ét0o5\Å	\ÛÃ¼›jAÇ±ÀB\Ù\Ã\äÿ‡\Æ!¥G\Ø|Bœ•ôaòÿcS\Z4°–*]I¦{§Dƒ³¯\'\Ú\á\Å\í¬ewŠ’^™•sƒ¿¼–Ü§‹¤˜\Ç¥\ãœ\î!¦\á²%j‘\Í*}Y\æ”ßŽ=GYûa\ÅucL}(³rž\ì0®uwM\Ä[±7Ž\ã÷¤\ë\nº/I™\è\æc™ i°!W³\á­\ÐÚO{7itÀ¹+HIþv8öÉ•X¨ajÔ—²+\è&¢–Mñ\í{c\ç´\Æ\Õ\Ñy‘h75\Ù{}—¯R\ÉøQ\ÉKeU.\ã\æ%4Á\íŸ?Š|¢œ•ë°š#Ewö\Ù\Í!\É*„/ˆ§ò\ËWk“¿1t\æmf|—Œ‹¹H(É¦¦%h†Is+ÿjá¬¬î§ŸO)~þFû:2\é5‚o\ã\rÉ•U¹\ê\ìMt\í\"f¼qŒ\\œ·a­÷\'\ãÂŒcPþ\è0¦\Íj\ãM?ˆC£¬Ê­D+oV–·«\Îÿ\ÎÂ¤ÑºÔ‹\ÞE2ž\ì\ån{»\Úõf\ÕÁ\í÷uÜ¬£\í\ÖþdeMYí‡‚ó·‚\'\É`\Õ\åñwþ‹“x\Ça×¶EQ\ì\Û\ÍÁK@8{u\å¼+Z…O\å\0Æœ/¿6˜ke\Æ\ï\'-÷\Æd£gUg\à$N+£ò¶>„€W€I¿R±\ÚÇ±»ƒW\á\ä•*õ\\jmõ\Ã\èžÙ±\ÎLun.„™•\Õ!Bñµ	A§ºµª[\Ó×ƒÁKØ§\Â#„ °\Ä;¶u£M\Ð\íûµ\'\Äu7\\7I\Âü\ÐVò\nyA©e¥‘_\ÆuA¬º\Ò\ÏlÓ¢T™p®P\ËL\íR\ÓRZ+\n…B¡ø#(·\æ¬\ïg[\Zhj+oò\ì2\à\Õ\rkÕ­ž©|ÿ	4Š«\çðš{kµ`]…F=\ìu\\\í<†„„œ$7w„0† ó#\Ùe·\Ì7½ƒC‚‘\Ót\çyª3dù^÷m™\Ã\æú½\ÞF0ô¹hA\Ó\rf+I½V\ÖU»\Ïø7\0p]2K£\ã$9\"0\×;z#W>ÃŠš÷|ƒ‹„ Ì Ë§T–ú9$™\Ñ\ï\ë2“Bvj\ÚY£·žóa¾OAN\ã$¬\Ò#\ß$\ïX¸Y•\ë\íŸî—£\ÔJ³nŸ\'€ð\èðiü¶ôÀw 8Þ®öÓ¿›\â°\Ëj\ã%ƒ3 ;D\Z\Ì\ÂE8s½!ˆÿ\âF\á\Ô\ïª]\î\ÂhO¾\Çh4\ØÃŸª1\à]õº\Üþ¡û©ù]ðU?\Âe%\"]{ç˜«2ò}\ÝDÁ°S3Íº\Öcˆ—!<–g›ºƒ×•\×›úõ/J¦¿Ú„cpx\à1ó¶`\×Á\ãP•/|QJ}½Íù¿&º¶8¾\Ç\àJoó¢ª§\ë®8ŽÁ“«Á\å\×óY:\Ü\â‡]×›\íK\Ùj\ÚþjpA¸\Ò/¾+\"j	\\\ÏÜšT”\Û\×)*¥Û¸5\à.\ÐXQmY\â\á.Ü¡~•Ý·\ë\ê2@¼Kr8¤\àŠ;GdF^¼@+£\ÝTjÁ/ \Ëþ‘\åÒºÇ¾ôEü«\Û2¨\Ý=„ûAÈ—\ì¼g=Ád_Ú¿õ^J­,0…-y¥¾‡ð ˜\Í/=H³*w`–\Üý“\Â\Ã8^\áÿB\Ímý\à\"\Â°j1kn\Å	,\0¢s\\ý¶\Æ/³	‚°Ä‹sž‹€\Ä\Ùüª~Rj\ë9 ,\â°Pø\Ú`1“*ú=\ÇhT¸–Ý…v#tÂ‚°Mó[,zy.ðd\ç|}D„A–×¿\"Am\ë9XD¯¤ì‡‚¥Ÿ‹$ÁóOQº\rDX\Z2øôakžv\ë\'tjð\07¡i<@6<y/\î¶px€¬\Í\Ñ\Ï\ëÁœ›2W\ç`UF\Í7þV%ø€0<QsK^ š;\Í&\Í\ÆóÁö\Ïó[\ÖG°/)½Kñð„xö,jø\â\Õö=%ˆG\à\n²\ÖÔžC´!ÀDcó…/ªr\àý\\\ÞhòCW	gzý¦T»]\îD\à²½­=û€À\Âöej]›\è\ÌV!OqÎ­2$ ^™  c’„;\ÈjS\Ý:\"@pò ¶¯\Ù÷.ˆz¤\ÃZo€(aù¾[ÿ°?2\Í\â\à\è¢`OXKl\ê€ D\âƒ8\rö¡G\Íjp	Ay\Â\Zµ€ \ÇkW±¿M­\ÓÎ£}Ÿ0yÂ¾¢\Æ\Ñ ‚“^¿\Ù\Õjµªª \Øó0q ‚XÐ­5Á\Ð\ZžÁ\×dD\ÇM’\Äußµ&„ ‚xPø\r\Ô\Þx\Z8Ï‚\ä¢kDý#©!agiB\éB©A7jY¨U0\Ù%‡c¤	„Úƒ\äveò \ê\çJr&tš©‡Jr&t“ŽY%’›r\0d;‘\Æ\Ü\Þ\É~z x¾&Ž\Ì8±&ßþ%G×„a•®’\0+q.KZ;Jr\0¸\â¨\Óó\r‘;þ£VIþö&Š\ì $=q.‹¯|\Ä\\q.K™€\â\r¶\ÒDQº x§\ÒD\Ñ1P\\5#\é\ÅSÍ¿ÒŠ’Ü¬”¿òlMv!}°|¬:S€«$\ç\é}A’o÷Ê°–<j•\ä‚%\ÏvJòHÞˆ’|£$ÿ’¼$¹P’ó‘”\äb!^\'Hò\æ¨$,y™+\É? a-HòXöª\Ût+Kû%9/\Ð)”\ä?¢$}\Ð\r”\ä?¢$}”\ä—P’¿>JòK(\É_%ù%”ä¯’ü2\êöù\ê(\É/¢\ËË£$¿„’üõAc%,+DPñIjQþk(\ÞpzQ\éf»¬u\Å?\í\ÝA\r\0\0 ú´P\ámP„3]_¢!\0\0\0\0\0\0\0\0\0\0\0\0\0\0°-\Úi³W-`\0\0\0\0IEND®B`‚','0000-00-00 00:00:00','2018-01-09 23:21:53');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-20 17:56:17
