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
INSERT INTO `settings` VALUES (1,'softhunter.net','dhaka','01765620368','admin@softhunter.net','USD',NULL,NULL,'','�PNG\r\n\Z\n\0\0\0\rIHDR\0\0r\0\0r\0\0\0\���;\0\0\0xPLTE���������\�\�׫�����������������������������\�\�\�\�\�ʭ��\�\�\�\�\�ݩ�����\�\�쳳�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�\�ڵ��\�\�齽���񿿿\�\�Ĺ��������#\�\�H\0\0\�IDATx\�\���\0\0\0\0�����\0\0\0\0\0\0\0\0\0\0\0\0\0\0�]{[V�\0�nH\�-�\\D���ñ\nkʙ3\�Q���z\�uWjӝ\n��\��}\��\�S�\�L� ����v�\�1e�#S�ϱ�ums�7�\�R7Q*o�]7�\r?�\�JG.*��G�!�\�\�\�\�*��\�63u�\�1gxjLҋ��\�Q\�S\�!�E�����|\�+u\�F���:DӼ7gF\�$��\�%rDxr.UW騿\�\�4]�a�Q\�\�*\�2�\Z8��C�nC[\�K|s�$L@\�\�	�����0\�-H\�8;\�=��BW;\Z�\�ϊ��p-�\�\�\�[��$�\Z��`�\0arQ�1�c�́\�Ӟ\n�?�\�LsC{ї\��U\�д��2��r+\��la^�\���8̎\'\re~\��%���et>�K�y\�\�M�J�##̫B�� �4�3Q*�\�.�-,\���Ƕ_+�u\�aA({˯E�\0aQac��x\�aY|�{R,#X���̓aq�b�pn\�\Z�G��\�\�+V���O�E\�rXw�}\�\"*w�SZ;�{\'X\'rP��@E�pX�t\�\\��u�V\�x\�0�b\�ʖ܄��4 	\�}\������N�`��\�\�.Te�_�R�6�F�fF=��@WB�!\�t58A{G\���\0\�Z`-\�`��\�z`{��\��bas?��w{;�qB�^Q��K&\�F�_���ZЯx�L��Ҩ�\�\n�\0m�u�xE�\�\�\�o\\vE�r�Z|�-\�\�\�¬\�s+�v\�\���3B�̏����IT�hS\��\'���.3\�.\�5��\0\�\��\�uA\0\�>\\��\�\�7G\�\�?Oq�Iď�Y�̧�C�!���\�\'�E�=��\���Z)�M]t/-*`>\�.\�d�ΪD�\� ٢�|��tf���-\�����\�V;b;U\�JC�\��-\�ip�.\�M8X��3\�\�bN�6w�>As2��uA�A4\�(�x�\��4��AR\�l{1�\�\Z�\�\�U��C�C`9ɉu�\�0�C~�ӣo4�&�0�\�X\�<\�{A�Н�W\�\�tc7\�u\�D!W;eչQ�\'S�F8yD��rZi\�+>i\�v�\���\�\�\�N\�\ns�Tw�S@O�xBh\�=�q�c4EWV\�i�\�\�:\��\'��)�\�Y;Ш2��w��@V\�\0�Ȭ�\�$�c\�)w\�\�,d\�8l��w\�@�)B`c-\�F?B}e,�)\�E\��Gk��N)[gLg�/,���$3\�n��2��:ϳ\�(\�\��g\�]#\0s^�(g\�\�>*\�\n�\��p��RE�i\���\�\�7���0\r\�8�/\�\�!PGh,��}\�L�P�C�װ\�+���Y{\0�72�\�b�f:\�w���y��3��Z�)\�w\�\"�Ԗ��5��y[\�\�M\�y\�P�-�b�\"\�Oҭ_\�i\�S�ٿA�j	\n蓜7ѳ`�\�af�3ħB~����U�(\�\��M�XߴQ\�\'�hE\��+��G\�\�$�L\n�蟍\�\�\�gVy<\r�g��)�\����U�\0\�\�\�r\�:�\�\�;)\�m�Ɠ{�nOx�6�?)\���Z\�*��\�o\\\�	��|����\�+A�p¹Ra5)\��&\�Lu�4[غ��c\�\�\�\�9;�\�M\�U9\�\�E�q\��\�;\�3�ENG\�\����wz\�\'�*zf�� �\'\�\�\�{��W�HJ]`م=\�\�\�\�&\�\��\�\�\0!\�Y��U�B��,�p`\��\�C\�(ʽ�,���yQ#Y�C�=�e�r\��\�\"\�\�(\ZM!.c�boBU|\�Hbj�p\�\�6m.\�\�`�\Z\�;��Q\�o�#��\n\�\")K:Ҵ�$�ADn�\�O���\�-�ʳj\�>\�H\�C#�>���1.�F{A)W\��H\�\�A\�tA\�\�~.RB49UM�*�+�\�\�2%�ő\�q\�(]�\�Q:��[\�\�:Q\�iL�2\\\��\�\�\�qHY��n���\'\�A@! �AK=���c\�%\0\��K��;\'�O\�I�}�\�R\�Q,a�w�\'�}K�z-\���b3�t�.�&ߎ2[k\� \0&�&\��S%Iz�v\�Ixཾ�W\�85��\�{\�AIb��M�ۑ\�V�\"�ʁ�Y����\�}�2�@����^j��v�T\�4�`�|�*\�߮\��z��\�D�!�}M�ol��\�\��B\�g\�\nX]T{w\�Q��kO^�\�\'Z}��FU\�#Y	֙\"�~k\�\�0G�\n�Qi+m-\�}\'q�\��\�.չ��\�(N^�#�U�:���\�!ڲ�>�$+ehOI�0임؃�5X%M�v�.\�8Λ��c��\�\n�zi\"$���\�7\�b�enB\���e+��\�#3�\�[&\�jdgyU�]\�]]Ш��\�\�ȅKP�A���a�\�\�\�\"X��\����Ñ!�nn&�\�ܪ�\�e׈9!i\��K\�\�Z�\�E\�D��+\��Bh���\�\�a���b�\�\���\�>\�\�s�Fr\r�p?\�0���bＶā0\�H��W��o�i�z7��\�H\�eNrB�\�\�h��ٕ#;\�fuN�H�I�n灠���ro�+;���|`O\�$\�>ոc\��\�򵜊kZ4��\�\�\�\��/CZ�+6�f\�P�;\�/�q�\��C�9���ݒ1|)G\��{\�b�\�\� �\�Qr��P��Ҁ/8O��\�n��\�PR~{\Z�\��\��\�c�r���Jᓣ�q\�\�M>�|7�S\�C�T�LF�\���\�\�C\�\�`\�A&EI܅\�NCݸ�\�t^�\�I{��f\�*9r|\��m7�ܒ�\�A�\�\��E�\\�@\�N�\�����ɖ\n:7Jn,<\�\��8�%)��H�\�`\�喒�\�\��{��S[\�Ē\�-9��\�\�i\�r\�ឲm\�h�beɿ�մ^r�,�\�MAy���\'ې��j˲SO�˷�\�tޙ�^q\�<9�\r]��m1\�%��͑\�X�y����^E��2\�|vʜ~��x\�fv\�t0o5\�	\�ü�jAǱ�B\�\�\���\�!��G\�|B���a��cS\Z4��*]I�{�D���\'\�\�\�\�ew��^��s����ܧ���\��\�\�!��\�%j�\�*�}Y\�ߎ=GY�a\�ucL}(�r�\�0�uwM\�[�7�\���\�\n�/I�\�\�c��i��!W�\�\�ځO{7it��+HI�v8�ɕX�ajԗ�+\�&��M�\�{c\�\�\�\�y�h75\�{�}��R\��Q\�KeU.\�\�%4�\��?�|���밚#Ew�\�\�!\�*�/���\�Wk��1t\�mf|����H(ɦ�%h�Is+�jᬬO)~�F�:2\�5�o\�\rɕU�\�\�Mt\�\"f�q��\\���a��\'\�cP�\�0�\�j\�M?�C��ʭD+oV����\��\�¤Ѻԋ\�E2�\�\�n{�\��f\��\��uܬ�\�\��deMY퇐��\'\�`\�\��w���x\�a׶EQ\�\�\��K@8{u\�+Z�O\�\0Ɯ/�6��ke\�\�\'-�\�d�gUg\�$N+���>��W�I�R�\�Ǳ��W\�\�*�\\jm�\�\��ٱ\�Lun.���\�!B��	A�����[\�׃�Kا\�#� �\�;�u�M\�\���\'�\�u�7\\7I\��\�V��\nyA�e��_\�uA��\�\�lӢT�p�P\�L\�R\�RZ+\n�B��#(�\�\�g[\Zhj+o�\�2\�\�\rkխ��|�	4���\��{k�`]�F=\�u\\\�<����$7w�0���#\�e�\�7��C��\�t\�y�3d�^�m�\�\���\�F0��hA\�\r�f+I�V\�U�\��7\0p]2K�\�$9\"0\�;z#W>Ê��|��� ̠˧T��9�$�\�\�\�2�Bvj\�Y����a�OAN\�$�\�#\�$\�X�Y�\�\�\�J�n�\'��\��i�����w 8ޮ�ӿ�\�\�j\�%�3 ;D\Z\�\�E8s�!��\�F\�\�\�]\�\�hO�\�h4\�ß�1\�]��\������]�U?\�e%\"]{瘫2�}\�D��S3ͺ\�c��!<�g���ו\����/J��ڄcpx\�1�`\��\�P�/|QJ}�͍��&��8�\�\�Jo󢪧\�8�����\�\��Y:\�\�]כ\�K\�j\��jpA�\�/�+\"j	\\\�ܚT�\�\�)*�۸5\�.\�XQmY\�\�.ܡ~�ݷ\�\�2@�Kr8�\��;GdF^�@+�\�Tj�/�\���\�ҺǾ�E��\�2�\�=��Aȗ�\�g=�d_ڿ�^J�,0�-y���� �\�/=H�*w`�\���\�\�8^\��B\�m�\�\"\��j1kn\�	,\0�s\\��\�/�	��ċs���\�\���~Rj\�9 ,\�P�\�`1�*�=\�hT��݅v#t�M�[,zy.�d\�|}D�A�׿\"Am\�9XD��쇂���$��OQ�\rDX\Z2��ak�v\�\'tj�\07�i<@6<y/\�px��\�\�\�\����2W\�`UF\�7�V%��0<QsK^ �;\�&\�\����\��[\�G�/)�K���x��,j�\�\��=%�G\�\n�\�ԞC�!�Dc�/�r\��\\\�h�CW	gz��T�]\�D\����=���\��ej]�\�\�V!Oqέ2$ ^� �c��;\�jS�\�:\"@p� ��\��.�z�\�Z�o�(a��[��?2\�\�\�\��`OXKl\� D\��8\r���G\�jp	Ay\�\Z�� \�kW��M�\�Σ}�0y¾�\�\� ��^�\�\�j����\��0q �XЭ5�\�\Z��\�dD\�M�\�uߵ&� �xP�\r\�\�x\Z8ς\�kD�#�!agiB\�B�A7jY�U0\�%�c�	�ڃ\�ve� \�\�Jr&t���Jr&t��Y%��r\0d;�\�\�\�\�~z x�&�\�8�&ߐ�%Gׄa���\0+q.KZ;Jr\0�\��\��\r�;��VI���&�\�$=q.��|\�\\q.K��\�\r�\�DQ��x�\�D\�1P\\5#\�\�SͿҊ�ܬ���lMv!}�|�:S��$\�\�}A�o�ʰ�<j�\�%\�vJ�Hވ�|�$���$�P���\�b!^\'H�\�$,y�+\�? a-H�X��\�t+K�%9/\�)�\�?�$}\�\r�\�?�$}�\�P��>J�K(\�_%�%�䯏��2\���\�(\�/�\�ˣ$�����Ac%,+DP�IjQ��k(\�pzQ\�f��u\�?\�\�A\r\0\0���P�\�mP�3]_�!\0\0\0\0\0\0\0\0\0\0\0\0\0\0�-\�i�W-`\0\0\0\0IEND�B`�','0000-00-00 00:00:00','2018-01-09 23:21:53');
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
