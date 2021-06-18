-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2021 at 03:05 PM
-- Server version: 5.7.13-log
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wisecp`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocked`
--

CREATE TABLE `blocked` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reason` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `endtime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kind` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kind_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `visibility` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'visible',
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `options` text COLLATE utf8mb4_unicode_ci,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent`, `type`, `kind`, `kind_id`, `status`, `visibility`, `rank`, `options`, `ctime`, `notes`) VALUES
(2, 0, 'articles', NULL, 0, 'active', 'visible', 2, '[]', '2017-10-18 12:37:00', NULL),
(3, 0, 'articles', NULL, 0, 'active', 'visible', 3, '[]', '2017-10-18 12:37:00', NULL),
(4, 0, 'articles', NULL, 0, 'active', 'visible', 4, '[]', '2017-10-18 12:37:00', NULL),
(5, 0, 'knowledgebase', NULL, 0, 'active', 'visible', 1, '[]', '2017-10-24 00:00:00', NULL),
(6, 0, 'knowledgebase', NULL, 0, 'active', 'visible', 2, '[]', '2017-10-24 00:00:00', NULL),
(7, 0, 'knowledgebase', NULL, 0, 'active', 'visible', 3, '[]', '2017-10-24 00:00:00', NULL),
(8, 0, 'knowledgebase', NULL, 0, 'active', 'visible', 0, '[]', '2017-10-24 00:00:00', NULL),
(197, 194, 'products', 'special', 194, 'active', 'visible', 3, '{\"color\":\"\",\"list_template\":1,\"icon\":\"\"}', '2018-03-23 17:05:38', NULL),
(164, 0, 'products', 'hosting', 0, 'active', 'visible', 1, '{\"color\":\"\",\"icon\":\"\"}', '2018-03-18 00:40:08', NULL),
(165, 0, 'products', 'hosting', 0, 'active', 'visible', 2, '{\"color\":\"\",\"icon\":\"\"}', '2018-03-18 00:50:53', NULL),
(166, 0, 'products', 'hosting', 0, 'active', 'visible', 3, '{\"color\":\"\",\"icon\":\"\"}', '2018-03-18 00:54:00', NULL),
(206, 0, 'software', '', 0, 'active', 'visible', 1, '{\"icon\":\"\"}', '2018-04-04 16:57:38', NULL),
(213, 0, 'predefined_replies', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(214, 0, 'articles', NULL, 0, 'active', 'visible', 1, '[]', '2018-05-09 14:38:49', NULL),
(23, 0, 'products', 'server', 0, 'active', 'visible', 1, '{\"color\":\"\",\"list_template\":2,\"icon\":\"fa fa-server\"}', '2017-11-06 10:55:11', NULL),
(24, 23, 'products', 'server', 0, 'active', 'visible', 2, '{\"color\":\"#BA0000\",\"list_template\":2,\"icon\":\"\"}', '2017-11-06 10:57:45', NULL),
(25, 23, 'products', 'server', 0, 'active', 'visible', 1, '{\"color\":\"\",\"list_template\":2,\"icon\":\"\"}', '2017-12-28 00:00:00', NULL),
(26, 23, 'products', 'server', 0, 'active', 'visible', 3, '{\"color\":\"#D1A900\",\"list_template\":2,\"icon\":\"\"}', '2017-12-28 00:00:00', NULL),
(161, 0, 'addon', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(162, 0, 'requirement', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(163, 0, 'requirement', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(160, 0, 'addon', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(167, 0, 'addon', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(168, 0, 'requirement', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(171, 25, 'products', 'server', 0, 'active', 'visible', 1, '{\"color\":\"\",\"list_template\":2,\"icon\":\"\"}', '2018-03-20 11:42:02', NULL),
(172, 25, 'products', 'server', 0, 'active', 'visible', 2, '{\"color\":\"\",\"list_template\":2,\"icon\":\"\"}', '2018-03-20 11:43:11', NULL),
(173, 0, 'products', 'server', 0, 'active', 'visible', 2, '{\"color\":\"\",\"list_template\":1,\"icon\":\"ion-ios-cloud\"}', '2018-03-20 11:48:44', NULL),
(174, 173, 'products', 'server', 0, 'active', 'visible', 3, '{\"color\":\"#D72424\",\"list_template\":1,\"icon\":\"\"}', '2018-03-20 22:17:41', NULL),
(175, 173, 'products', 'server', 0, 'active', 'visible', 2, '{\"color\":\"#D7B41E\",\"list_template\":1,\"icon\":\"\"}', '2018-03-20 22:21:12', NULL),
(176, 173, 'products', 'server', 0, 'active', 'visible', 1, '{\"color\":\"#346DA6\",\"list_template\":1,\"icon\":\"\"}', '2018-03-20 22:22:55', NULL),
(196, 194, 'products', 'special', 194, 'active', 'visible', 2, '{\"color\":\"\",\"list_template\":2,\"icon\":\"\"}', '2018-03-23 17:04:15', NULL),
(195, 194, 'products', 'special', 194, 'active', 'visible', 1, '{\"color\":\"\",\"list_template\":1,\"icon\":\"\"}', '2018-03-23 17:03:53', NULL),
(194, 0, 'products', 'special', 0, 'active', 'visible', 0, '{\"color\":\"#546169\",\"upgrading\":true,\"list_template\":0}', '2018-03-23 16:41:47', NULL),
(200, 0, 'addon', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(215, 0, 'references', NULL, 0, 'active', 'visible', 1, '[]', '2018-05-10 12:00:09', NULL),
(233, 0, 'software', '', 0, 'active', 'visible', 2, '{\"icon\":\"\"}', '2018-07-02 12:52:18', NULL),
(234, 0, 'software', '', 0, 'active', 'visible', 3, '{\"icon\":\"\"}', '2018-07-02 12:55:29', NULL),
(232, 0, 'references', NULL, 0, 'active', 'visible', 2, '[]', '2018-07-02 10:54:22', NULL),
(223, 0, 'predefined_replies', NULL, 0, 'active', 'visible', 0, NULL, '1881-05-19 00:00:00', NULL),
(235, 0, 'software', '', 0, 'active', 'visible', 4, '{\"icon\":\"\"}', '2018-07-02 12:57:48', NULL),
(236, 0, 'references', NULL, 0, 'active', 'visible', 3, '[]', '2018-07-02 14:35:34', NULL),
(242, 240, 'products', 'special', 240, 'inactive', 'invisible', 1, '{\"color\":\"\",\"list_template\":1,\"icon\":\"\"}', '2020-02-26 15:01:58', NULL),
(241, 240, 'products', 'special', 240, 'inactive', 'invisible', 2, '{\"color\":\"\",\"list_template\":1,\"icon\":\"\"}', '2020-02-26 15:00:01', NULL),
(240, 0, 'products', 'special', 0, 'inactive', 'invisible', 0, '{\"color\":\"\",\"upgrading\":false,\"ctoc-service-transfer\":{\"status\":false,\"limit\":\"\"},\"list_template\":1}', '2020-02-26 14:49:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories_lang`
--

CREATE TABLE `categories_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faq` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories_lang`
--

INSERT INTO `categories_lang` (`id`, `owner_id`, `lang`, `title`, `route`, `sub_title`, `content`, `seo_title`, `seo_keywords`, `seo_description`, `faq`, `options`) VALUES
(180, 215, 'tr', 'Test Bir Referans Kategorisi', 'test-bir-referans-kategorisi', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Test Bir Referans Kategorisi', '', '', NULL, ''),
(2, 2, 'tr', 'Grafik & Web Tasarım', 'grafik-web-tasarim', '', '', '', '', '', NULL, ''),
(3, 3, 'tr', 'Reklam & Tanıtım', 'reklam-tanitim', '', '', '', '', '', NULL, ''),
(4, 4, 'tr', 'Web Yazılım', 'web-yazilim', '', '', 'Web Yazılım', '', '', NULL, ''),
(5, 5, 'tr', 'Alan Adı Yönetimi', 'alan-adi-yonetimi', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Alan Adı Yönetimi', 'alan adı,domain', 'Alan Adı Yönetimi ile ilgili soru ve cevaplar.', NULL, ''),
(6, 6, 'tr', 'Genel', 'genel', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Genel', 'Genel', 'Genelde sorulan soru ve cevaplar.', NULL, ''),
(7, 7, 'tr', 'Reseller Hosting', 'reseller-hosting', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Reseller Hosting', 'Reseller Hosting', 'Reseller Hosting ile ilgili soru ve cevaplar.', NULL, ''),
(8, 8, 'tr', 'Sunucu/VPS/VDS', 'sunucu-vps-vds', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Sunucu/VPS/VDS', 'Sunucu/VPS/VDS', 'Sunucu/VPS/VDS ile ilgili soru ve cevaplar.', NULL, ''),
(159, 194, 'tr', 'Google SEO Hizmetleri', 'google-seo-hizmetleri', 'Garantili Google SEO Hizmetleri ile kalıcı ve hızlı şekilde yükselin.', '<div class=\"hostingozellikler\">\r\n<div id=\"wrapper\">\r\n\r\n<div class=\"hostozellk\">\r\n<img src=\"{SITE-URL}templates/website/images/site-transfer.png\" width=\"auto\" height=\"auto\">\r\n<h4>Sitelerinizi Ücretsiz Taşıyoruz!</h4>\r\n<p>cPanel\'den > cPanel\'e tüm sunucu ve hosting siparişlerinizde web sitelerinizi ücretsiz taşıyoruz.</p>\r\n</div>\r\n\r\n<div class=\"hostozellk\" id=\"hostrightozellk\">\r\n<img src=\"{SITE-URL}templates/website/images/bireysel-hosting.png\" width=\"auto\" height=\"auto\">\r\n<h4>Uzman Olmanız Gerekmez!</h4>\r\n<p>Sunucu yönetimi ve güvenliği için uzman olmanız gerekmiyor. Alanında tecrübeli ve uzman ekibimiz sayesinde sunucularınız emin ellerdedir.</p>\r\n</div>\r\n\r\n<div class=\"hostozellk\">\r\n<img src=\"{SITE-URL}templates/website/images/2.png\" width=\"auto\" height=\"auto\">\r\n<h4>Full Performans ve Tam Donanım</h4>\r\n<p>Tüm sunucularımız modern trendlere uygun donanım ve yazılımlarla sürekli olarak güncel tutulmakta ve sizlere sunulmaktadır.</p>\r\n</div>\r\n\r\n<div class=\"hostozellk\" id=\"hostrightozellk\">\r\n<img src=\"{SITE-URL}templates/website/images/seal_maximum_security.png\" width=\"auto\" height=\"auto\">\r\n<h4>Sorunsuz ve Güvenli!</h4>\r\n<p>Sunucularımızda, bilinen tüm optimizasyon ve güvenlik tedbirleri uygulanmakta olup, herhangi bir olumsuz durum yaşanmaması için gerekli tedbirler alınmaktadır.</p>\r\n</div>\r\n<div class=\"clear\"></div>\r\n</div>\r\n</div>', 'Google SEO Hizmetleri', 'google seo, seo, ucuz seo, kaliteli seo, profesyonel seo, kurumsal seo', 'Garantili Google SEO Hizmetleri ile kalıcı ve hızlı şekilde yükselin.', '[{\"title\":\"SEO Nedir?\",\"description\":\"SEO, “Search Engine Optimization” ve “Search Engine Optimizer” kelimelerinin kısaltmasıdır. Türkçe’ye çevirdiğimizde “Arama Motoru Optimizasyonu” ve “Arama Motoru Optimizasyonu yapan kişi” anlamları çıkar. Amaç; çeşitli yöntemler kullanarak Google, Yandex, Bing gibi arama motorlarında web sitenizin arama sonuçlarında en başlarda çıkmasını sağlamaktır.\"},{\"title\":\"SEO çalışmalarının etkisini ne zaman görebiliriz ?\",\"description\":\"Aslında bu sitenizin durumuna göre, potansiyeline göre değişmekte. Eğer web siteniz hali hazırda yoğun ziyaret edilen bir web sitesi ise çalışmalarımızın meyvesini hemen görebilirsiniz. Bu tarz büyük web sitelerinde sadece on-page seo (sayfa içi) düzenlemeleri bile yapmak fark yaratmaktadır. Fakat kelime bazlı yükseliş ise asıl konu, 1 Hafta ile 3 Hafta arasında bu süre değişebilmektedir.\"},{\"title\":\"SEO çalışmalarınız herhangi bir risk içermekte mi ?\",\"description\":\"Kesinlikle hayır. Seo çalışmalarını son derece doğal şekillerde gerçekleştiriyoruz. Çalışmalarımızın tümünün odağında kullanıcı bulunduğundan ve site kalitesini arttırmaya yönelik hedeflerimizden ötürü bugüne kadar hiçbir müşterimize kötü bir sonuç yaşatmıyoruz.\"},{\"title\":\"Web sitemiz ne kadar sürede ilk sayfaya çıkar ?\",\"description\":\"Bu sorunun ne yazık ki tam bir cevabı yok, fakat bugüne kadar yaptığımız çalışmalar göstermekte ki; genel olarak ilk sayfada iyi bir yerlere gelebilmek 1 AY ile 3 Ay arasında sürmektedir.\"},{\"title\":\"Rakiplerimiz için çalışma durumunuz var mı ?\",\"description\":\"Hiçbir şekilde aynı sektörden 2 farklı firma için çalışma gerçekleştirmeyiz.\"},{\"title\":\"Ne kadar sürede ilk sayfada yer alacağım?\",\"description\":\"İlk sayfaya çıkma süresi kelime ve seo hizmeti istediğiniz siteye göre değişiklik göstermektedir. Şu ana kadar Uzman Seo olarak yaptığımız Google Optimizasyon çalışmalarının başarıya ulaşması 5 gün ile 4 ay arasında değişiklik göstermiştir. Uzman Seo olarak her müşterimizle 6 ay içerisinde ilk sayfaya çıkarılmaması durumunda ücretin tamamı geri ödenecektir şeklinde sözleşme yapılmaktadır.\"},{\"title\":\"Google aramalarında sponsor üst ve sağ tarafdaki alanlarda mı çıkacağız.\",\"description\":\"Hayır, Google’da sağ ve üst kısımda yer alan Sponsor Bağlantı olarak yer alan alanlar Google Adwords reklamlarıdır. O alanda reklam vererek ilk sayfada yer alabilirsiniz. Fakat bunun için sürekli olarak reklam bütçesi ayrılmalıdır. Seo danışmanlığı ise web sitenizin Google’da sol kısımda yer alan organik arama sonuçları arasında sitenizin ilk sayfaya yükseltilmesidir.\"}]', ''),
(171, 206, 'tr', 'Kurumsal Firma Scriptleri', 'kurumsal-firma-scriptleri', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Kurumsal Firma Scriptleri', 'kurumsal firma scripti, firma scripti, firma sitesi, sektörel firma scripti, kurumsal script', 'Kurumsal Firma Scripti ile firma, kurum ya da kuruşunuzun etkileyici, ilgi çekici ve akılda kalıcı bir web sitesi olsun.', '', ''),
(178, 213, 'tr', 'Örnek Hazır Cevap Kategorisi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 214, 'tr', 'Google SEO', 'google-seo', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Google SEO', '', '', NULL, ''),
(188, 223, 'tr', 'Test bir hazır cevap kategorisi 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(295, 223, 'en', 'Test a ready answer category 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(296, 23, 'en', 'Dedicated Servers', 'dedicated-servers', 'Full-featured, full-performance dedicated servers at various locations.', '', 'Dedicated Servers', 'Dedicated Servers', 'Full-featured, full-performance dedicated servers at various locations.', '[{\"title\":\"What is a dedicated server?\",\"description\":\"Dedicated server is a server leasing solution where all the resources of a physical server (software and hardware) are allocated to a single user. You can install the operating system you need the server you are renting, you can manage your server with the desired hosting control panel.\"},{\"title\":\"What is the delivery time of the dedicated server?\",\"description\":\"Dedicated Server installation is delivered within the same day by setting hardware and software features that you prefer during ordering.\"},{\"title\":\"Do you make refunds?\",\"description\":\"Unfortunately, there is no reimbursement guarantee for server orders.\"},{\"title\":\"Do you provide technical support for server management?\",\"description\":\"All our servers are delivered as unmanaged and you need to provide your own management and control. However, we provide technical support on issues such as problems, errors or information.\"},{\"title\":\"Do you make security settings and optimizations?\",\"description\":\"All server orders are provided with necessary security configurations and optimization procedures before delivery, and your side is delivered in this way.\"}]', NULL),
(313, 168, 'en', 'Software', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(314, 167, 'en', 'Software', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(315, 161, 'en', 'Web Hosting', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(316, 163, 'en', 'Web Hosting', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(317, 162, 'en', 'Servers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(318, 160, 'en', 'Servers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(319, 166, 'en', 'Reseller Hosting', 'reseller-hosting', 'Provide full-fledged web hosting services at affordable prices without being limited by Reseller Hosting.', '', 'Reseller Hosting', 'reseller hosting, cheap reseller', 'Provide full-fledged web hosting services at affordable prices without being limited by Reseller Hosting.', '', NULL),
(297, 24, 'en', 'Turkey Location (Dedicated Servers)', 'turkey-location-dedicated-servers', 'Turkey\'s location, fully equipped, full performance of dedicated servers.', '', 'Turkey Location (Dedicated Servers)', '', '', '', NULL),
(298, 25, 'en', 'France Location (Dedicated Servers)', 'france-location-dedicated-servers', 'France location, fully equipped, full performance dedicated servers.', '', 'France Location (Dedicated Servers)', '', '', '', NULL),
(299, 26, 'en', 'Germany Location (Dedicated Servers)', 'germany-location-dedicated-servers', 'Germany location, fully equipped, full performance dedicated servers.', '', 'Germany Location (Dedicated Servers)', '', '', '', NULL),
(300, 171, 'en', 'Starter Level Servers', 'starter-level-servers', 'Ideal hosts for low-scale hosting solutions.', '', 'Starter Level Servers', '', '', '', NULL),
(301, 172, 'en', 'Price / Performance Servers', 'price-performance-servers', 'Affordable and high performance servers.', '', 'Price / Performance Servers', '', '', '', NULL),
(302, 195, 'en', 'SEO Packages', 'seo-packages', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', '', 'SEO Packages', '', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', '', '{\"columns\":[{\"id\":\"1\",\"name\":\"Neque porro\"},{\"id\":\"2\",\"name\":\"quisquam est\"},{\"id\":\"3\",\"name\":\"dolorem ipsum\"},{\"id\":\"4\",\"name\":\"dolor sit amet\"}],\"columns_lid\":4}'),
(303, 174, 'en', 'Turkey Location (VDS / VPS)', 'turkey-location-vds-vps', 'Turkey\'s location, fully equipped, full performance VDS / VPS', '', 'Turkey Location (VDS / VPS)', 'Turkey Location (VDS / VPS)', 'Turkey\'s location, fully equipped, full performance VDS / VPS', '', NULL),
(304, 175, 'en', 'Germany Location (VDS / VPS)', 'germany-location-vds-vps', 'Germany location, full performance VDS / VPS.', '', 'Germany Location (VDS / VPS)', '', '', '', NULL),
(305, 176, 'en', 'France Location (VDS / VPS)', 'france-location-vds-vps', 'France location, fully equipped, full performance VDS / VPS', '', 'France Location (VDS / VPS)', '', '', '', NULL),
(306, 196, 'en', 'Article Backlink Packages', 'article-backlink-packages', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', '', 'Article Backlink Packages', '', '', '', '{\"columns\":[{\"id\":1,\"name\":\"Domain Age\"},{\"id\":2,\"name\":\"Google Index\"},{\"id\":3,\"name\":\"Domain Authority (DA)\"},{\"id\":4,\"name\":\"Page Authority (PA)\"},{\"id\":5,\"name\":\"Alexa\"}],\"columns_lid\":5}'),
(307, 197, 'en', 'Backlink Packages', 'backlink-packages', 'Profile link, bookmarks, directory packages, blog backlink, forum backlinks.', '', 'Backlink Packages', '', '', '', ''),
(308, 200, 'en', 'Almanya Location Servers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(323, 233, 'en', 'Real Estate Scripts', 'real-estate-scripts', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Real Estate Scripts', '', '', '', ''),
(310, 165, 'en', 'Professional SSD Hosting', 'professional-ssd-hosting', 'If you have a lot of websites and are looking for a top level web hosting solution, you can look at our professional hosting packages.', '', 'Professional SSD Hosting', 'Professional SSD Hosting', 'If you have a lot of websites and are looking for a top level web hosting solution, you can look at our professional hosting packages.', '', NULL),
(311, 164, 'en', 'Cheap SSD Hosting', 'cheap-ssd-hosting', 'If you are looking for a low cost solution, our affordable web hosting packages are for you. And with the advantage of SSD!', '', 'Cheap SSD Hosting', 'Cheap SSD Hosting', 'If you are looking for a low cost solution, our affordable web hosting packages are for you. And with the advantage of SSD!', '', NULL),
(312, 173, 'en', 'SSD Virtual Servers (VDS / VPS)', 'ssd-virtual-servers-vds-vps', 'Full-featured, full-performance VDS / VPS packages with the best virtualization solutions.', '', 'SSD Virtual Servers (VDS / VPS)', '', '', '[{\"title\":\"What is VDS \\/ VPS Virtual Server?\",\"description\":\"VDS (Virtual Dedicated Server) is an abbreviation of English expression. In other words, the virtual system is the server system obtained by the resources that are assigned. This method is more reliable and performance than other virtualization technologies. Resources such as Ram, CPU and Disk, which are allocated from the main server, are within real limits. The resource assigned to a user leaves the system. It is not shared with another user. For example, if you order your server with 8 GB of RAM, even if you use 8 GB of RAM, you will be assigned and dropped from the system. In other systems, if the assigned resources are empty, it can be used by a different user, so the service is slower for everyone in total.\"},{\"title\":\"What is VDS \\/ VPS Server Delivery Time?\",\"description\":\"Upon approval of VDS \\/ VPS server orders, the installation is completed within the same day and the server is delivered.\"},{\"title\":\"What are the VDS \\/ VPS Virtual Server Advantages?\",\"description\":\"Shared hosting servers have features that can not be changed. For this reason, you can optimize your virtual server as you like in your specific projects and adjust your settings as you like. You can organize your server according to your project, not the server.\"},{\"title\":\"VDS \\/ VPS How many sites can be hosted on the server?\",\"description\":\"This is entirely due to your site\'s visitor count and resource consumption. Whether you have a single site or dozens of sites, if you are optimizing well, you can host your sites with average daily 5K and 15K hits on different packages. The less load your sites place on the server, the higher your performance ratio will be at that level.\"}]', NULL),
(23, 23, 'tr', 'Fiziksel Sunucular (Dedicated)', 'fiziksel-sunucular-dedicated', 'Her bütçeye uygun, çeşitli lokasyonlarda, tam donanımlı, full performans fiziksel sunucular.', '', 'Fiziksel Sunucular (Dedicated)', 'dedicated sunucu, sunucu kirala, fiziksel sunucular, dedicated sunucu kirala', 'Her bütçeye uygun, çeşitli lokasyonlarda, tam donanımlı, full performans fiziksel sunucular.', '[{\"title\":\"Fiziksel sunucu (dedicated server) nedir?\",\"description\":\"Dedicated server, fiziksel bir sunucunun tüm kaynaklarının (yazılımsal ve donanımsal) tek bir kullanıcıya tahsis edildiği sunucu kiralama çözümüdür. Kiraladığınız sunucuya ihtiyacınız olan işletim sistemini kurabilir, sunucunuzu dilediğiniz hosting kontrol paneli ile yönetebilirsiniz.\"},{\"title\":\"Fiziksel sunucu (dedicated server) teslimat süresi nedir?\",\"description\":\"Fiziksel Sunucu (Dedicated Server) kurulumu, sipariş sırasında tercih etmiş olduğunuz donanım ve yazılımsal özelliklerle, firmamız tarafından gerçekleştirilmekte ve aynı gün içerisinde teslim edilmektedir.\"},{\"title\":\"Ücret iadesi yapıyor musunuz?\",\"description\":\"Maalesef, sunucu siparişlerinde ücret iade garantisi bulunmamaktadır. \"},{\"title\":\"Sunucu yönetimi konusunda teknik destek veriyor musunuz?\",\"description\":\"Tüm sunucularımız unmanaged (yönetimsiz) olarak teslim edilmekte olup sunucunuzun yönetim ve kontrolünü bizzat sizin sağlamanız gerekmektedir. Ancak herhangi bir sorun, hata ya da bilgi edinme gibi hususlarda teknik destek sunmaktayız.\"},{\"title\":\"Güvenlik ayarlamaları ve optimizasyon yapıyor musunuz?\",\"description\":\"Tüm sunucu siparişlerinde teslimattan önce gerekli güvenlik yapılandırmaları ve optimizasyon işlemleri sağlanmakta ve tarafınıza bu şekilde teslim edilmektedir.\"}]', NULL),
(24, 24, 'tr', 'Türkiye Lokasyon (Fiziksel Sunucular)', 'turkiye-lokasyon-fiziksel-sunucular', 'Her bütçeye uygun, Türkiye lokasyon, tam donanımlı, full performans fiziksel sunucular.', '', '', '', '', '', NULL),
(25, 25, 'tr', 'Fransa Lokasyon (Fiziksel Sunucular)', 'fransa-lokasyon-fiziksel-sunucular', 'Her bütçeye uygun, Fransa lokasyon, tam donanımlı, full performans fiziksel sunucular.', '', '', '', '', '', NULL),
(26, 26, 'tr', 'Almanya Lokasyon (Fiziksel Sunucular)', 'almanya-lokasyon-fiziksel-sunucular', 'Her bütçeye uygun, Almanya lokasyon, tam donanımlı, full performans fiziksel sunucular.', '', '', '', '', '', NULL),
(136, 171, 'tr', 'Giriş Seviyesi Sunucular', 'giris-seviyesi-sunucular', 'Düşük ölçekli barındırma çözümleri için ideal sunucular.', '', '', '', '', '', NULL),
(137, 172, 'tr', 'Fiyat / Performans Sunucuları', 'fiyat-performans-sunuculari', 'Uygun fiyat ve yüksek performanslı sunucular.', '', '', '', '', '', NULL),
(160, 195, 'tr', 'SEO Paketleri', 'seo-paketleri', 'Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına', '', 'SEO Paketleri', '', 'Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına', '', '{\"columns\":[{\"id\":\"1\",\"name\":\"aegaegaeg\"},{\"id\":\"2\",\"name\":\"aegaegaegaeg\"},{\"id\":\"3\",\"name\":\"aegaegaegaega\"},{\"id\":\"4\",\"name\":\"aegaegaegaeg\"}],\"columns_lid\":4}'),
(139, 174, 'tr', 'Türkiye Lokasyon (VDS/VPS)', 'turkiye-lokasyon-vds-vps', 'Her bütçeye uygun, Türkiye lokasyon, tam donanımlı, full performans VDS/VPS', '', 'Türkiye Lokasyon (VDS/VPS)', 'Türkiye Lokasyon (VDS/VPS)', 'Her bütçeye uygun, Türkiye lokasyon, tam donanımlı, full performans VDS/VPS', '', NULL),
(140, 175, 'tr', 'Almanya Lokasyon (VDS/VPS)', 'almanya-lokasyon-vds-vps', 'Her bütçeye uygun, Almanya lokasyon, tam donanımlı, full performans VDS/VPS', '', '', '', '', '', NULL),
(141, 176, 'tr', 'Fransa Lokasyon (VDS/VPS)', 'fransa-lokasyon-vds-vps', 'Her bütçeye uygun, Fransa lokasyon, tam donanımlı, full performans VDS/VPS', '', '', '', '', '', NULL),
(161, 196, 'tr', 'Tanıtım Yazısı Paketleri', 'tanitim-yazisi-paketleri', 'Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına', '', '', '', '', '', '{\"columns\":[{\"id\":1,\"name\":\"Site Yaşı\"},{\"id\":2,\"name\":\"Google Index\"},{\"id\":3,\"name\":\"Domain Authority (DA)\"},{\"id\":4,\"name\":\"Page Authority (PA)\"},{\"id\":5,\"name\":\"Alexa\"}],\"columns_lid\":5}'),
(162, 197, 'tr', 'Backlink Paketleri', 'backlink-paketleri', 'Profil link, imleme, dizin paketleri, blog backlink', '', '', '', '', '', ''),
(165, 200, 'tr', 'Almanya Location Servers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 165, 'tr', 'Profesyonel SSD Hosting', 'profesyonel-ssd-hosting', 'Çok sayıda web sitesi barındırıyor ve üst düzey web hosting çözümü arıyorsanız, profesyonel hosting paketlerimizi inceyebilirsiniz.', '', 'Profesyonel SSD Hosting', 'Profesyonel SSD Hosting', 'Çok sayıda web sitesi barındırıyor ve üst düzey web hosting çözümü arıyorsanız, profesyonel hosting paketlerimizi inceyebilirsiniz.', '', NULL),
(129, 164, 'tr', 'Ekonomik SSD Hosting', 'ekonomik-ssd-hosting', 'Düşük maliyetli çözüm arıyorsanız, ekonomik web hosting paketlerimiz tam size göre. Üstelik SSD avantajı ile!', '', 'Cheap SSD Hosting', 'Cheap SSD Hosting,economical hosting, ssd hosting, cheap hosting, cheap web hosting', 'If you are looking for a low cost solution, our affordable web hosting packages are for you. And with the advantage of SSD!', '', NULL),
(138, 173, 'tr', 'SSD Sanal Sunucular (VDS/VPS)', 'ssd-sanal-sunucular-vds-vps', 'En iyi sanallaştırma çözümleri ile, tam donanımlı, full performans VDS/VPS paketleri.', '', '', '', '', '[{\"title\":\"VDS\\/VPS Sanal Sunucu Nedir?\",\"description\":\"VDS (Virtual Dedicated Server) İngilizce ifadesinin kısaltmasıdır. Yani sanal atanan kaynaklar ile elde edilen sunucu sistemidir. Bu yöntem diğer sanallaştırma teknolojilerine göre daha performanslı ve güvenlidir. Ana sunucudan atanan Ram, CPU ve Disk gibi kaynaklar gerçek sınırlar içerisindedir. Bir kullanıcıya atanan kaynak sistemden ayrılır. Başka bir kullanıcı ile paylaştırılmaz. Örneğin sunucunuzu 8 GB ram ile sipariş ettiğinizde kullanmasınız bile 8 GB ram size atanır ve sistemden düşer. Diğer sistemlerde ise atanan kaynaklar boş ise farklı bir kullanıcı tarafından kullanılabildiği için sistem yoğunlunda toplamda herkesin hizmeti yavaşlar.\"},{\"title\":\"VDS\\/VPS Sunucuların Teslimat Süresi Nedir?\",\"description\":\"VDS\\/VPS sunucu siparişlerinin onaylanmasının ardından aynı gün içerisinde kurulum tamamlanıp müşterilerimize teslim edilmektedir.\"},{\"title\":\"VDS\\/VPS Sanal Sunucu\'nun Avantajları Nelerdir?\",\"description\":\"Paylaşımlı hosting sunucularıda değiştirilemeyecek fonkisyonlar vardır.Bu nedenle özel projelerinizde sanal sunucunuzu istediğiniz şekilde optimize edebilir ve dilediğiniz ayarları yapabilirsiniz.Projenizi sunucuya göre değil, sunucunuzu projenize göre düzenleyebilirsiniz.\"},{\"title\":\" VDS\\/VPS Sunucular\'da Ne Kadar Site Yayını Yapılabilir?\",\"description\":\"Bu miktar tamamen sizin sitelerinizin hitlerine ve kaynak tüketimlerine bağlı bir miktardır.İster tek bir siteniz olsun, ister onlarca siteniz olsun, iyi optimize edilmiş siteler ile farklı paketler üzerinde günlük ortalama 5K ile 15K hitleri bulunan sitelerinizin yayınlarını yapabilirsiniz.Siteleriniz sunucuya ne kadar az yük verir ise sizin performans oranınız o seviyede artacaktır.\"}]', NULL),
(133, 168, 'tr', 'Software', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 167, 'tr', 'Software', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 161, 'tr', 'Web Hosting', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 163, 'tr', 'Web Hosting', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 162, 'tr', 'Servers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 160, 'tr', 'Servers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 166, 'tr', 'Bayi (Reseller) Hosting', 'bayi-reseller-hosting', 'Bayi (Reseller) Hosting ile limitlere takılmadan, uygun fiyatlarla, tam donanımlı web hosting hizmeti verin.', '', 'Bayi (Reseller) Hosting', 'Bayi (Reseller) Hosting, reseller hosting, bayi hosting, ucuz reseller', 'Bayi (Reseller) Hosting ile limitlere takılmadan, uygun fiyatlarla, tam donanımlı web hosting hizmeti verin.', '', NULL),
(291, 213, 'en', 'Sample Ready to Answer Category', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(292, 214, 'en', 'Google SEO', 'google-seo', '', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'Google SEO', 'Google SEO', 'Google SEO', NULL, ''),
(286, 8, 'en', 'Server/VPS/VDS', 'server-vps-vds', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Server/VPS/VDS', '', '', NULL, ''),
(287, 194, 'en', 'Google SEO Services', 'google-seo-services', 'Guaranteed permanent and rises quickly with Google SEO Services.', '<div class=\"hostingozellikler\">\r\n<div id=\"wrapper\">\r\n\r\n<div class=\"hostozellk\">\r\n<img src=\"{SITE-URL}templates/website/images/site-transfer.png\" width=\"auto\" height=\"auto\">\r\n<h4>Test Example Title</h4>\r\n<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>\r\n</div>\r\n\r\n<div class=\"hostozellk\" id=\"hostrightozellk\">\r\n<img src=\"{SITE-URL}templates/website/images/bireysel-hosting.png\" width=\"auto\" height=\"auto\">\r\n<h4>Test Example Title</h4>\r\n<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>\r\n</div>\r\n\r\n<div class=\"hostozellk\">\r\n<img src=\"{SITE-URL}templates/website/images/2.png\" width=\"auto\" height=\"auto\">\r\n<h4>Test Example Title</h4>\r\n<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>\r\n</div>\r\n\r\n<div class=\"hostozellk\" id=\"hostrightozellk\">\r\n<img src=\"{SITE-URL}templates/website/images/seal_maximum_security.png\" width=\"auto\" height=\"auto\">\r\n<h4>Test Example Title</h4>\r\n<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>\r\n</div>\r\n<div class=\"clear\"></div>\r\n</div>\r\n</div>', 'Google SEO Services', 'Google SEO Services', 'Guaranteed permanent and rises quickly with Google SEO Services.', '', ''),
(324, 234, 'tr', 'Rent A Car Scriptleri', 'rent-a-car-scriptleri', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Rent A Car Scriptleri', '', '', '', ''),
(325, 234, 'en', 'Rent A Car Scripts', 'rent-a-car-scripts', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Rent A Car Scripts', '', '', '', ''),
(288, 206, 'en', 'Company Script', 'company-script', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Company Script', '', '', '', ''),
(322, 233, 'tr', 'Emlak Scriptleri', 'emlak-scriptleri', '', '<p><strong>Lorem Ipsum</strong>, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500\'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960\'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.</p>', 'Emlak Scriptleri', '', '', '', ''),
(284, 6, 'en', 'General', 'general', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'General', '', '', NULL, ''),
(285, 7, 'en', 'Reseller Hosting', 'reseller-hosting', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Reseller Hosting', 'Reseller Hosting', '', NULL, ''),
(279, 215, 'en', 'Test a Reference Category', 'test-a-reference-category', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Test a Reference Category', '', '', NULL, ''),
(280, 2, 'en', 'Graphics & Web Design', 'graphics-web-design', '', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'Graphics & Web Design', 'Graphics & Web Design', 'Graphics & Web Design', NULL, ''),
(281, 3, 'en', 'Advertisement & Promotion', 'advertisement-promotion', '', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'Advertisement & Promotion', 'Advertisement & Promotion', 'Advertisement & Promotion', NULL, ''),
(282, 4, 'en', 'Web Software Development', 'web-software-development', '', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'Web Software Development', 'Web Software Development', 'Web Software Development', NULL, ''),
(283, 5, 'en', 'Domain Name Registry', 'domain-name-registry', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Domain Name Registry', '', '', NULL, '');
INSERT INTO `categories_lang` (`id`, `owner_id`, `lang`, `title`, `route`, `sub_title`, `content`, `seo_title`, `seo_keywords`, `seo_description`, `faq`, `options`) VALUES
(320, 232, 'tr', 'Test İkinci Referans Kategorisi', 'test-ikinci-referans-kategorisi', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'Test İkinci Referans Kategorisi', '', '', NULL, ''),
(321, 232, 'en', 'Test Second Reference Category', 'test-second-reference-category', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Test Second Reference Category', '', '', NULL, ''),
(326, 235, 'tr', 'İnşaat Scriptleri', 'insaat-scriptleri', '', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'İnşaat Scriptleri', '', '', '', ''),
(327, 235, 'en', 'Construction Scripts', 'construction-scripts', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Construction Scripts', '', '', '', ''),
(328, 236, 'tr', 'Örnek Üçüncü Bir Kategori', 'ornek-ucuncu-bir-kategori', '', '<p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir. İnternet\'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200\'den fazla Latince sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır. Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan sözcüklerden uzaktır.</p>\r\n<p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir. İnternet\'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200\'den fazla Latince sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır. Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan sözcüklerden uzaktır.</p>', 'Örnek Üçüncü Bir Kategori', '', '', NULL, ''),
(329, 236, 'en', 'Example Third Category', 'example-third-category', '', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'Example Third Category', '', '', NULL, ''),
(382, 242, 'en', 'Unbranded License', 'unbranded-license', 'Buy WISECP Unbranded licenses', '', 'WISECP Unbranded License', 'Buy,WISECP,Unbranded,licenses', 'Buy WISECP Unbranded licenses', '', '{\"columns\":null,\"columns_lid\":0}'),
(381, 242, 'tr', 'Markasız (Unbranded)', 'markasiz-unbranded', 'WISECP markasız (Unbranded) lisans satın alın', '', 'Markasız (Unbranded) Lisans', 'WISECP,markasız,(Unbranded),lisans,satın,alın', 'WISECP markasız (Unbranded) lisans satın alın', '', '{\"columns\":null,\"columns_lid\":0}'),
(380, 241, 'en', 'Branded License', 'branded-license', 'Buy WISECP Branded licenses', '', 'WISECP Branded License', 'Buy,WISECP,Branded,licenses', 'Buy WISECP Branded licenses', '', '{\"columns\":null,\"columns_lid\":0}'),
(379, 241, 'tr', 'Markalı (Branded)', 'markali-branded', 'WISECP Markalı (Branded) lisans satın alın', '', 'Markalı (Branded)', 'WISECP,Markalı,(Branded),lisans,satın,alın', 'WISECP Markalı (Branded) lisans satın alın', '', '{\"columns\":null,\"columns_lid\":0}'),
(378, 240, 'en', 'WISECP Licenses', 'wisecp-licenses', 'Get WISECP license at affordable prices', '', 'WISECP Licenses', 'wisecp licenses, wisecp license purchase, wisecp reseller', 'Get WISECP license at affordable prices', '[{\"title\":\"Are you WISECP\'s authorized reseller?\",\"description\":\"Yes, our company is an official reseller authorized by WISECP. If you want to confirm this, you can contact www.wisecp.com\"},{\"title\":\"Can I change my license information?\",\"description\":\"You can change your domain license information free and instantaneously through your customer panel at any time.\"},{\"title\":\"I\'m using WHMCS, can I switch to WISECP?\",\"description\":\"Of course you can. In order to upgrade from WHMCS to WISECP, you can easily do this process in seconds without any data loss, with our specially developed transfer tool. For more information, please <strong> <a href=\'https:\\/\\/www.docs.wisecp.com\\/en\\/kb\\/import-from-whmcs\' target=\'_blank\'>click here.<\\/a><\\/strong>\"},{\"title\":\"Are updates \\/ upgrades paid for?\",\"description\":\"In all license types, updates are offered for free for life. When a new version is announced, you will not pay any fees for it.\"},{\"title\":\"Do I have to pay anything other than the license fee?\",\"description\":\"No need. You do not pay anything other than the license fee.\"},{\"title\":\"Do you give technical support?\",\"description\":\"Of course. You can get technical support at any time for the system\'s standard operation or if any problems are detected.\"},{\"title\":\"Do you make additional modules, plugins and features?\",\"description\":\"In such matters, we look at our workload and the demand, and we will inform you. Please contact us for your requests. \"},{\"title\":\"Can I host on my own server?\",\"description\":\"Of course. This is possible if you have a server with the standard features that the software needs to run.<br><br>For detailed information about minimum server requirements, <a target=\\\"_blank\\\" href=\\\"https:\\/\\/docs.wisecp.com\\/en\\/kb\\/system-requirements\\\"><strong>please click here.<\\/strong><\\/a>\"}]', '{\"columns\":null,\"columns_lid\":0}'),
(377, 240, 'tr', 'WISECP Lisansları', 'wisecp-lisanslari', 'Uygun fiyatlarla WISECP lisansına sahip olun.', '', 'WISECP Lisansları', 'wisecp lisans, wisecp lisansları, wisecp lisansı satın al, wisecp bayileri,', 'Uygun fiyatlarla WISECP lisansına sahip olun.', '[{\"title\":\"Siz WISECP\'nin yetkili satıcısı mısınız?\",\"description\":\"Evet, firmamız WISECP tarafından yetkilendirilmiş resmi bir satıcıdır. Bunu teyit etmek isterseniz www.wisecp.com üzerinden iletişim sağlayabilirsiniz.\"},{\"title\":\"Lisansımı değiştirebilir veya transfer edebilir miyim?\",\"description\":\"Alan adı lisans bilginizi dilediğiniz zaman müşteri paneliniz üzerinden ücretsiz ve anlık değiştirebilirsiniz.\"},{\"title\":\"WHMCS kullanıyorum, WISECP\'ye geçiş yapabilir miyim?\",\"description\":\" Elbette yapabilirsiniz. WHMCS\'den WISECP\'ye geçiş yapabilmeniz için, özel olarak geliştirdiğimiz transfer aracı ile bu işlemi saniyeler içerisinde, herhangi bir veri kaybı olmadan, kolaylıkla yapabilirsiniz. Detaylı bilgi için <strong><a href=\\\"https:\\/\\/www.docs.wisecp.com\\/tr\\/kb\\/whmcsden-iceri-aktarma\\\" target=\\\"_blank\\\">lütfen tıklayın.<\\/a><\\/strong>       \"},{\"title\":\"Güncelleme\\/Yükseltme ücretli mi?\",\"description\":\" Tüm lisans türlerinde güncellemeler ömürboyu ücretsiz sunulmaktadır. Yeni bir sürüm duyurulduğunda bunun için süre fark etmeksizin herhangi bir ücret ödemezsiniz.\"},{\"title\":\"Lisans ücretinden başka ücret ödemem gerekir mi?\",\"description\":\"Hayır gerekmez. Yazılım için lisans ücretinden başka bir ücret ödemezsiniz. \"},{\"title\":\"Teknik destek veriyor musunuz?\",\"description\":\" Elbette veriyoruz. Satın aldığınız ürün hakkında sistemin standart işleyişi ile ilgili takıldığınız konular veya sorun yaşadığınız herhangi bir konuda destek alabilirsiniz.\"},{\"title\":\"Ek modül, eklenti veya özellik yapar mısınız?\",\"description\":\"Bu gibi konularda iş yoğunluğu ve taleplerinize göre değerlendirme yapılarak tarafınıza bilgi verilmektedir. Talepleriniz için lütfen bizimle iletişim kurunuz.\"},{\"title\":\"Kendi hostumda barındırabilir miyim?\",\"description\":\"Elbette barındırabilirsiniz. Yazılımın çalışabilmesi için ihtiyaç duyduğu standart donanımlara sahip bir sunucunuz var ise bu mümkündür.<br><br>Minimum sunucu gereksinimleri hakkında bilgi almak için <a target=\\\"_blank\\\" href=\\\"https:\\/\\/docs.wisecp.com\\/tr\\/kb\\/sistem-gereksinimleri\\\"><strong>lütfen tıklayınız.<\\/strong><\\/a>\"}]', '{\"columns\":null,\"columns_lid\":0}');

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

CREATE TABLE `checkouts` (
  `id` bigint(16) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `items` text COLLATE utf8mb4_unicode_ci,
  `data` text COLLATE utf8mb4_unicode_ci,
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `mdfdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`, `slug`) VALUES
(1, 227, 'Adana', 'adana'),
(2, 227, 'Adıyaman', 'adiyaman'),
(3, 227, 'Afyonkarahisar', 'afyonkarahisar'),
(4, 227, 'Ağrı', 'agri'),
(5, 227, 'Amasya', 'amasya'),
(6, 227, 'Ankara', 'ankara'),
(7, 227, 'Antalya', 'antalya'),
(8, 227, 'Artvin', 'artvin'),
(9, 227, 'Aydın', 'aydin'),
(10, 227, 'Balıkesir', 'balikesir'),
(11, 227, 'Bilecik', 'bilecik'),
(12, 227, 'Bingöl', 'bingol'),
(13, 227, 'Bitlis', 'bitlis'),
(14, 227, 'Bolu', 'bolu'),
(15, 227, 'Burdur', 'burdur'),
(16, 227, 'Bursa', 'bursa'),
(17, 227, 'Çanakkale', 'canakkale'),
(18, 227, 'Çankırı', 'cankiri'),
(19, 227, 'Çorum', 'corum'),
(20, 227, 'Denizli', 'denizli'),
(21, 227, 'Diyarbakır', 'diyarbakir'),
(22, 227, 'Edirne', 'edirne'),
(23, 227, 'Elazığ', 'elazig'),
(24, 227, 'Erzincan', 'erzincan'),
(25, 227, 'Erzurum', 'erzurum'),
(26, 227, 'Eskişehir', 'eskisehir'),
(27, 227, 'Gaziantep', 'gaziantep'),
(28, 227, 'Giresun', 'giresun'),
(29, 227, 'Gümüşhane', 'gumushane'),
(30, 227, 'Hakkari', 'hakkari'),
(31, 227, 'Hatay', 'hatay'),
(32, 227, 'Isparta', 'isparta'),
(33, 227, 'Mersin', 'mersin'),
(34, 227, 'İstanbul', 'istanbul'),
(35, 227, 'İzmir', 'izmir'),
(36, 227, 'Kars', 'kars'),
(37, 227, 'Kastamonu', 'kastamonu'),
(38, 227, 'Kayseri', 'kayseri'),
(39, 227, 'Kırklareli', 'kirklareli'),
(40, 227, 'Kırşehir', 'kirsehir'),
(41, 227, 'Kocaeli', 'kocaeli'),
(42, 227, 'Konya', 'konya'),
(43, 227, 'Kütahya', 'kutahya'),
(44, 227, 'Malatya', 'malatya'),
(45, 227, 'Manisa', 'manisa'),
(46, 227, 'Kahramanmaraş', 'kahramanmaras'),
(47, 227, 'Mardin', 'mardin'),
(48, 227, 'Muğla', 'mugla'),
(49, 227, 'Muş', 'mus'),
(50, 227, 'Nevşehir', 'nevsehir'),
(51, 227, 'Niğde', 'nigde'),
(52, 227, 'Ordu', 'ordu'),
(53, 227, 'Rize', 'rize'),
(54, 227, 'Sakarya', 'sakarya'),
(55, 227, 'Samsun', 'samsun'),
(56, 227, 'Siirt', 'siirt'),
(57, 227, 'Sinop', 'sinop'),
(58, 227, 'Sivas', 'sivas'),
(59, 227, 'Tekirdağ', 'tekirdag'),
(60, 227, 'Tokat', 'tokat'),
(61, 227, 'Trabzon', 'trabzon'),
(62, 227, 'Tunceli', 'tunceli'),
(63, 227, 'Şanlıurfa', 'sanliurfa'),
(64, 227, 'Uşak', 'usak'),
(65, 227, 'Van', 'van'),
(66, 227, 'Yozgat', 'yozgat'),
(67, 227, 'Zonguldak', 'zonguldak'),
(68, 227, 'Aksaray', 'aksaray'),
(69, 227, 'Bayburt', 'bayburt'),
(70, 227, 'Karaman', 'karaman'),
(71, 227, 'Kırıkkale', 'kirikkale'),
(72, 227, 'Batman', 'batman'),
(73, 227, 'Şırnak', 'sirnak'),
(74, 227, 'Bartın', 'bartin'),
(75, 227, 'Ardahan', 'ardahan'),
(76, 227, 'Iğdır', 'igdir'),
(77, 227, 'Yalova', 'yalova'),
(78, 227, 'Karabük', 'karabuk'),
(79, 227, 'Kilis', 'kilis'),
(80, 227, 'Osmaniye', 'osmaniye'),
(81, 227, 'Düzce', 'duzce'),
(84, 1, 'Badakhshan', 'badakhshan'),
(85, 1, 'Badghis', 'badghis'),
(86, 1, 'Baghlan', 'baghlan'),
(87, 1, 'Balkh', 'balkh'),
(88, 1, 'Bamian', 'bamian'),
(89, 1, 'Farah', 'farah'),
(90, 1, 'Faryab', 'faryab'),
(91, 1, 'Ghazni', 'ghazni'),
(92, 1, 'Ghowr', 'ghowr'),
(93, 1, 'Helmand', 'helmand'),
(94, 1, 'Herat', 'herat'),
(95, 1, 'Jowzjan', 'jowzjan'),
(96, 1, 'Kabul', 'kabul'),
(97, 1, 'Kandahar', 'kandahar'),
(98, 1, 'Kapisa', 'kapisa'),
(99, 1, 'Khost', 'khost'),
(100, 1, 'Konar', 'konar'),
(101, 1, 'Kondoz', 'kondoz'),
(102, 1, 'Laghman', 'laghman'),
(103, 1, 'Lowgar', 'lowgar'),
(104, 1, 'Nangrahar', 'nangrahar'),
(105, 1, 'Nimruz', 'nimruz'),
(106, 1, 'Nurestan', 'nurestan'),
(107, 1, 'Oruzgan', 'oruzgan'),
(108, 1, 'Paktia', 'paktia'),
(109, 1, 'Paktika', 'paktika'),
(110, 1, 'Parwan', 'parwan'),
(111, 1, 'Samangan', 'samangan'),
(112, 1, 'Sar-e Pol', 'sar-e-pol'),
(113, 1, 'Takhar', 'takhar'),
(114, 1, 'Wardak', 'wardak'),
(115, 1, 'Zabol', 'zabol'),
(116, 2, 'Berat', 'berat'),
(117, 2, 'Bulqize', 'bulqize'),
(118, 2, 'Delvine', 'delvine'),
(119, 2, 'Devoll', 'devoll'),
(120, 2, 'Diber', 'diber'),
(121, 2, 'Durres', 'durres'),
(122, 2, 'Elbasan', 'elbasan'),
(123, 2, 'Kolonje', 'kolonje'),
(124, 2, 'Fier', 'fier'),
(125, 2, 'Gjirokaster', 'gjirokaster'),
(126, 2, 'Gramsh', 'gramsh'),
(127, 2, 'Has', 'has'),
(128, 2, 'Kavaje', 'kavaje'),
(129, 2, 'Kurbin', 'kurbin'),
(130, 2, 'Kucove', 'kucove'),
(131, 2, 'Korce', 'korce'),
(132, 2, 'Kruje', 'kruje'),
(133, 2, 'Kukes', 'kukes'),
(134, 2, 'Librazhd', 'librazhd'),
(135, 2, 'Lezhe', 'lezhe'),
(136, 2, 'Lushnje', 'lushnje'),
(137, 2, 'Malesi e Madhe', 'malesi-e-madhe'),
(138, 2, 'Mallakaster', 'mallakaster'),
(139, 2, 'Mat', 'mat'),
(140, 2, 'Mirdite', 'mirdite'),
(141, 2, 'Peqin', 'peqin'),
(142, 2, 'Permet', 'permet'),
(143, 2, 'Pogradec', 'pogradec'),
(144, 2, 'Puke', 'puke'),
(145, 2, 'Shkoder', 'shkoder'),
(146, 2, 'Skrapar', 'skrapar'),
(147, 2, 'Sarande', 'sarande'),
(148, 2, 'Tepelene', 'tepelene'),
(149, 2, 'Tropoje', 'tropoje'),
(150, 2, 'Tirane', 'tirane'),
(151, 2, 'Vlore', 'vlore'),
(152, 3, 'Adrar', 'adrar'),
(153, 3, 'Ain Defla', 'ain-defla'),
(154, 3, 'Ain Temouchent', 'ain-temouchent'),
(155, 3, 'Alger', 'alger'),
(156, 3, 'Annaba', 'annaba'),
(157, 3, 'Batna', 'batna'),
(158, 3, 'Bechar', 'bechar'),
(159, 3, 'Bejaia', 'bejaia'),
(160, 3, 'Biskra', 'biskra'),
(161, 3, 'Blida', 'blida'),
(162, 3, 'Bordj Bou Arreridj', 'bordj-bou-arreridj'),
(163, 3, 'Bouira', 'bouira'),
(164, 3, 'Boumerdes', 'boumerdes'),
(165, 3, 'Chlef', 'chlef'),
(166, 3, 'Constantine', 'constantine'),
(167, 3, 'Djelfa', 'djelfa'),
(168, 3, 'El Bayadh', 'el-bayadh'),
(169, 3, 'El Oued', 'el-oued'),
(170, 3, 'El Tarf', 'el-tarf'),
(171, 3, 'Ghardaia', 'ghardaia'),
(172, 3, 'Guelma', 'guelma'),
(173, 3, 'Illizi', 'illizi'),
(174, 3, 'Jijel', 'jijel'),
(175, 3, 'Khenchela', 'khenchela'),
(176, 3, 'Laghouat', 'laghouat'),
(177, 3, 'Muaskar', 'muaskar'),
(178, 3, 'Medea', 'medea'),
(179, 3, 'Mila', 'mila'),
(180, 3, 'Mostaganem', 'mostaganem'),
(181, 3, 'M\'Sila', 'm-sila'),
(182, 3, 'Naama', 'naama'),
(183, 3, 'Oran', 'oran'),
(184, 3, 'Ouargla', 'ouargla'),
(185, 3, 'Oum el-Bouaghi', 'oum-el-bouaghi'),
(186, 3, 'Relizane', 'relizane'),
(187, 3, 'Saida', 'saida'),
(188, 3, 'Setif', 'setif'),
(189, 3, 'Sidi Bel Abbes', 'sidi-bel-abbes'),
(190, 3, 'Skikda', 'skikda'),
(191, 3, 'Souk Ahras', 'souk-ahras'),
(192, 3, 'Tamanghasset', 'tamanghasset'),
(193, 3, 'Tebessa', 'tebessa'),
(194, 3, 'Tiaret', 'tiaret'),
(195, 3, 'Tindouf', 'tindouf'),
(196, 3, 'Tipaza', 'tipaza'),
(197, 3, 'Tissemsilt', 'tissemsilt'),
(198, 3, 'Tizi Ouzou', 'tizi-ouzou'),
(199, 3, 'Tlemcen', 'tlemcen'),
(200, 4, 'Eastern', 'eastern'),
(201, 4, 'Manu\'a', 'manu-a'),
(202, 4, 'Rose Island', 'rose-island'),
(203, 4, 'Swains Island', 'swains-island'),
(204, 4, 'Western', 'western'),
(205, 5, 'Andorra la Vella', 'andorra-la-vella'),
(206, 5, 'Canillo', 'canillo'),
(207, 5, 'Encamp', 'encamp'),
(208, 5, 'Escaldes-Engordany', 'escaldes-engordany'),
(209, 5, 'La Massana', 'la-massana'),
(210, 5, 'Ordino', 'ordino'),
(211, 5, 'Sant Julia de Loria', 'sant-julia-de-loria'),
(212, 6, 'Bengo', 'bengo'),
(213, 6, 'Benguela', 'benguela'),
(214, 6, 'Bie', 'bie'),
(215, 6, 'Cabinda', 'cabinda'),
(216, 6, 'Cuando-Cubango', 'cuando-cubango'),
(217, 6, 'Cuanza Norte', 'cuanza-norte'),
(218, 6, 'Cuanza Sul', 'cuanza-sul'),
(219, 6, 'Cunene', 'cunene'),
(220, 6, 'Huambo', 'huambo'),
(221, 6, 'Huila', 'huila'),
(222, 6, 'Luanda', 'luanda'),
(223, 6, 'Lunda Norte', 'lunda-norte'),
(224, 6, 'Lunda Sul', 'lunda-sul'),
(225, 6, 'Malange', 'malange'),
(226, 6, 'Moxico', 'moxico'),
(227, 6, 'Namibe', 'namibe'),
(228, 6, 'Uige', 'uige'),
(229, 6, 'Zaire', 'zaire'),
(230, 9, 'Saint George', 'saint-george'),
(231, 9, 'Saint John', 'saint-john'),
(232, 9, 'Saint Mary', 'saint-mary'),
(233, 9, 'Saint Paul', 'saint-paul'),
(234, 9, 'Saint Peter', 'saint-peter'),
(235, 9, 'Saint Philip', 'saint-philip'),
(236, 9, 'Barbuda', 'barbuda'),
(237, 9, 'Redonda', 'redonda'),
(238, 10, 'Antartida e Islas del Atlantico', 'antartida-e-islas-del-atlantico'),
(239, 10, 'Buenos Aires', 'buenos-aires'),
(240, 10, 'Catamarca', 'catamarca'),
(241, 10, 'Chaco', 'chaco'),
(242, 10, 'Chubut', 'chubut'),
(243, 10, 'Cordoba', 'cordoba'),
(244, 10, 'Corrientes', 'corrientes'),
(245, 10, 'Distrito Federal', 'distrito-federal'),
(246, 10, 'Entre Rios', 'entre-rios'),
(247, 10, 'Formosa', 'formosa'),
(248, 10, 'Jujuy', 'jujuy'),
(249, 10, 'La Pampa', 'la-pampa'),
(250, 10, 'La Rioja', 'la-rioja'),
(251, 10, 'Mendoza', 'mendoza'),
(252, 10, 'Misiones', 'misiones'),
(253, 10, 'Neuquen', 'neuquen'),
(254, 10, 'Rio Negro', 'rio-negro'),
(255, 10, 'Salta', 'salta'),
(256, 10, 'San Juan', 'san-juan'),
(257, 10, 'San Luis', 'san-luis'),
(258, 10, 'Santa Cruz', 'santa-cruz'),
(259, 10, 'Santa Fe', 'santa-fe'),
(260, 10, 'Santiago del Estero', 'santiago-del-estero'),
(261, 10, 'Tierra del Fuego', 'tierra-del-fuego'),
(262, 10, 'Tucuman', 'tucuman'),
(263, 11, 'Aragatsotn', 'aragatsotn'),
(264, 11, 'Ararat', 'ararat'),
(265, 11, 'Armavir', 'armavir'),
(266, 11, 'Geghark\'unik\'', 'geghark-unik'),
(267, 11, 'Kotayk\'', 'kotayk'),
(268, 11, 'Lorri', 'lorri'),
(269, 11, 'Shirak', 'shirak'),
(270, 11, 'Syunik\'', 'syunik'),
(271, 11, 'Tavush', 'tavush'),
(272, 11, 'Vayots\' Dzor', 'vayots-dzor'),
(273, 11, 'Yerevan', 'yerevan'),
(274, 13, 'Australian Capital Territory', 'australian-capital-territory'),
(275, 13, 'New South Wales', 'new-south-wales'),
(276, 13, 'Northern Territory', 'northern-territory'),
(277, 13, 'Queensland', 'queensland'),
(278, 13, 'South Australia', 'south-australia'),
(279, 13, 'Tasmania', 'tasmania'),
(280, 13, 'Victoria', 'victoria'),
(281, 13, 'Western Australia', 'western-australia'),
(282, 14, 'Burgenland', 'burgenland'),
(283, 14, 'Kärnten', 'karnten'),
(284, 14, 'Niederösterreich', 'niederosterreich'),
(285, 14, 'Oberösterreich', 'oberosterreich'),
(286, 14, 'Salzburg', 'salzburg'),
(287, 14, 'Steiermark', 'steiermark'),
(288, 14, 'Tirol', 'tirol'),
(289, 14, 'Vorarlberg', 'vorarlberg'),
(290, 14, 'Wien', 'wien'),
(291, 15, 'Ali Bayramli', 'ali-bayramli'),
(292, 15, 'Abseron', 'abseron'),
(293, 15, 'AgcabAdi', 'agcabadi'),
(294, 15, 'Agdam', 'agdam'),
(295, 15, 'Agdas', 'agdas'),
(296, 15, 'Agstafa', 'agstafa'),
(297, 15, 'Agsu', 'agsu'),
(298, 15, 'Astara', 'astara'),
(299, 15, 'Baki', 'baki'),
(300, 15, 'BabAk', 'babak'),
(301, 15, 'BalakAn', 'balakan'),
(302, 15, 'BArdA', 'barda'),
(303, 15, 'Beylaqan', 'beylaqan'),
(304, 15, 'Bilasuvar', 'bilasuvar'),
(305, 15, 'Cabrayil', 'cabrayil'),
(306, 15, 'Calilabab', 'calilabab'),
(307, 15, 'Culfa', 'culfa'),
(308, 15, 'Daskasan', 'daskasan'),
(309, 15, 'Davaci', 'davaci'),
(310, 15, 'Fuzuli', 'fuzuli'),
(311, 15, 'Ganca', 'ganca'),
(312, 15, 'Gadabay', 'gadabay'),
(313, 15, 'Goranboy', 'goranboy'),
(314, 15, 'Goycay', 'goycay'),
(315, 15, 'Haciqabul', 'haciqabul'),
(316, 15, 'Imisli', 'imisli'),
(317, 15, 'Ismayilli', 'ismayilli'),
(318, 15, 'Kalbacar', 'kalbacar'),
(319, 15, 'Kurdamir', 'kurdamir'),
(320, 15, 'Lankaran', 'lankaran'),
(321, 15, 'Lacin', 'lacin'),
(322, 15, 'Lankaran', 'lankaran'),
(323, 15, 'Lerik', 'lerik'),
(324, 15, 'Masalli', 'masalli'),
(325, 15, 'Mingacevir', 'mingacevir'),
(326, 15, 'Naftalan', 'naftalan'),
(327, 15, 'Neftcala', 'neftcala'),
(328, 15, 'Oguz', 'oguz'),
(329, 15, 'Ordubad', 'ordubad'),
(330, 15, 'Qabala', 'qabala'),
(331, 15, 'Qax', 'qax'),
(332, 15, 'Qazax', 'qazax'),
(333, 15, 'Qobustan', 'qobustan'),
(334, 15, 'Quba', 'quba'),
(335, 15, 'Qubadli', 'qubadli'),
(336, 15, 'Qusar', 'qusar'),
(337, 15, 'Saki', 'saki'),
(338, 15, 'Saatli', 'saatli'),
(339, 15, 'Sabirabad', 'sabirabad'),
(340, 15, 'Sadarak', 'sadarak'),
(341, 15, 'Sahbuz', 'sahbuz'),
(342, 15, 'Saki', 'saki'),
(343, 15, 'Salyan', 'salyan'),
(344, 15, 'Sumqayit', 'sumqayit'),
(345, 15, 'Samaxi', 'samaxi'),
(346, 15, 'Samkir', 'samkir'),
(347, 15, 'Samux', 'samux'),
(348, 15, 'Sarur', 'sarur'),
(349, 15, 'Siyazan', 'siyazan'),
(350, 15, 'Susa', 'susa'),
(351, 15, 'Susa', 'susa'),
(352, 15, 'Tartar', 'tartar'),
(353, 15, 'Tovuz', 'tovuz'),
(354, 15, 'Ucar', 'ucar'),
(355, 15, 'Xankandi', 'xankandi'),
(356, 15, 'Xacmaz', 'xacmaz'),
(357, 15, 'Xanlar', 'xanlar'),
(358, 15, 'Xizi', 'xizi'),
(359, 15, 'Xocali', 'xocali'),
(360, 15, 'Xocavand', 'xocavand'),
(361, 15, 'Yardimli', 'yardimli'),
(362, 15, 'Yevlax', 'yevlax'),
(363, 15, 'Zangilan', 'zangilan'),
(364, 15, 'Zaqatala', 'zaqatala'),
(365, 15, 'Zardab', 'zardab'),
(366, 15, 'Naxcivan', 'naxcivan'),
(367, 16, 'Acklins', 'acklins'),
(368, 16, 'Berry Islands', 'berry-islands'),
(369, 16, 'Bimini', 'bimini'),
(370, 16, 'Black Point', 'black-point'),
(371, 16, 'Cat Island', 'cat-island'),
(372, 16, 'Central Abaco', 'central-abaco'),
(373, 16, 'Central Andros', 'central-andros'),
(374, 16, 'Central Eleuthera', 'central-eleuthera'),
(375, 16, 'City of Freeport', 'city-of-freeport'),
(376, 16, 'Crooked Island', 'crooked-island'),
(377, 16, 'East Grand Bahama', 'east-grand-bahama'),
(378, 16, 'Exuma', 'exuma'),
(379, 16, 'Grand Cay', 'grand-cay'),
(380, 16, 'Harbour Island', 'harbour-island'),
(381, 16, 'Hope Town', 'hope-town'),
(382, 16, 'Inagua', 'inagua'),
(383, 16, 'Long Island', 'long-island'),
(384, 16, 'Mangrove Cay', 'mangrove-cay'),
(385, 16, 'Mayaguana', 'mayaguana'),
(386, 16, 'Moore\'s Island', 'moore-s-island'),
(387, 16, 'North Abaco', 'north-abaco'),
(388, 16, 'North Andros', 'north-andros'),
(389, 16, 'North Eleuthera', 'north-eleuthera'),
(390, 16, 'Ragged Island', 'ragged-island'),
(391, 16, 'Rum Cay', 'rum-cay'),
(392, 16, 'San Salvador', 'san-salvador'),
(393, 16, 'South Abaco', 'south-abaco'),
(394, 16, 'South Andros', 'south-andros'),
(395, 16, 'South Eleuthera', 'south-eleuthera'),
(396, 16, 'Spanish Wells', 'spanish-wells'),
(397, 16, 'West Grand Bahama', 'west-grand-bahama'),
(398, 17, 'Capital', 'capital'),
(399, 17, 'Central', 'central'),
(400, 17, 'Muharraq', 'muharraq'),
(401, 17, 'Northern', 'northern'),
(402, 17, 'Southern', 'southern'),
(403, 18, 'Barisal', 'barisal'),
(404, 18, 'Chittagong', 'chittagong'),
(405, 18, 'Dhaka', 'dhaka'),
(406, 18, 'Khulna', 'khulna'),
(407, 18, 'Rajshahi', 'rajshahi'),
(408, 18, 'Sylhet', 'sylhet'),
(409, 19, 'Christ Church', 'christ-church'),
(410, 19, 'Saint Andrew', 'saint-andrew'),
(411, 19, 'Saint George', 'saint-george'),
(412, 19, 'Saint James', 'saint-james'),
(413, 19, 'Saint John', 'saint-john'),
(414, 19, 'Saint Joseph', 'saint-joseph'),
(415, 19, 'Saint Lucy', 'saint-lucy'),
(416, 19, 'Saint Michael', 'saint-michael'),
(417, 19, 'Saint Peter', 'saint-peter'),
(418, 19, 'Saint Philip', 'saint-philip'),
(419, 19, 'Saint Thomas', 'saint-thomas'),
(420, 20, 'Brestskaya (Brest)', 'brestskaya-brest'),
(421, 20, 'Homyel\'skaya (Homyel\')', 'homyel-skaya-homyel'),
(422, 20, 'Horad Minsk', 'horad-minsk'),
(423, 20, 'Hrodzyenskaya (Hrodna)', 'hrodzyenskaya-hrodna'),
(424, 20, 'Mahilyowskaya (Mahilyow)', 'mahilyowskaya-mahilyow'),
(425, 20, 'Minskaya', 'minskaya'),
(426, 20, 'Vitsyebskaya (Vitsyebsk)', 'vitsyebskaya-vitsyebsk'),
(427, 21, 'Antwerpen', 'antwerpen'),
(428, 21, 'Brabant Wallon', 'brabant-wallon'),
(429, 21, 'Hainaut', 'hainaut'),
(430, 21, 'Liège', 'liege'),
(431, 21, 'Limburg', 'limburg'),
(432, 21, 'Luxembourg', 'luxembourg'),
(433, 21, 'Namur', 'namur'),
(434, 21, 'Oost-Vlaanderen', 'oost-vlaanderen'),
(435, 21, 'Vlaams Brabant', 'vlaams-brabant'),
(436, 21, 'West-Vlaanderen', 'west-vlaanderen'),
(437, 21, 'Brussels-Capital Region', 'brussels-capital-region'),
(438, 22, 'Belize', 'belize'),
(439, 22, 'Cayo', 'cayo'),
(440, 22, 'Corozal', 'corozal'),
(441, 22, 'Orange Walk', 'orange-walk'),
(442, 22, 'Stann Creek', 'stann-creek'),
(443, 22, 'Toledo', 'toledo'),
(444, 23, 'Alibori', 'alibori'),
(445, 23, 'Atakora', 'atakora'),
(446, 23, 'Atlantique', 'atlantique'),
(447, 23, 'Borgou', 'borgou'),
(448, 23, 'Collines', 'collines'),
(449, 23, 'Donga', 'donga'),
(450, 23, 'Kouffo', 'kouffo'),
(451, 23, 'Littoral', 'littoral'),
(452, 23, 'Mono', 'mono'),
(453, 23, 'Oueme', 'oueme'),
(454, 23, 'Plateau', 'plateau'),
(455, 23, 'Zou', 'zou'),
(456, 24, 'Devonshire', 'devonshire'),
(457, 24, 'Hamilton City', 'hamilton-city'),
(458, 24, 'Hamilton', 'hamilton'),
(459, 24, 'Paget', 'paget'),
(460, 24, 'Pembroke', 'pembroke'),
(461, 24, 'Saint George City', 'saint-george-city'),
(462, 24, 'Saint George\'s', 'saint-george-s'),
(463, 24, 'Sandys', 'sandys'),
(464, 24, 'Smith\'s', 'smith-s'),
(465, 24, 'Southampton', 'southampton'),
(466, 24, 'Warwick', 'warwick'),
(467, 25, 'Bumthang', 'bumthang'),
(468, 25, 'Chukha', 'chukha'),
(469, 25, 'Dagana', 'dagana'),
(470, 25, 'Gasa', 'gasa'),
(471, 25, 'Haa', 'haa'),
(472, 25, 'Lhuntse', 'lhuntse'),
(473, 25, 'Mongar', 'mongar'),
(474, 25, 'Paro', 'paro'),
(475, 25, 'Pemagatshel', 'pemagatshel'),
(476, 25, 'Punakha', 'punakha'),
(477, 25, 'Samdrup Jongkhar', 'samdrup-jongkhar'),
(478, 25, 'Samtse', 'samtse'),
(479, 25, 'Sarpang', 'sarpang'),
(480, 25, 'Thimphu', 'thimphu'),
(481, 25, 'Trashigang', 'trashigang'),
(482, 25, 'Trashiyangste', 'trashiyangste'),
(483, 25, 'Trongsa', 'trongsa'),
(484, 25, 'Tsirang', 'tsirang'),
(485, 25, 'Wangdue Phodrang', 'wangdue-phodrang'),
(486, 25, 'Zhemgang', 'zhemgang'),
(487, 26, 'Beni', 'beni'),
(488, 26, 'Chuquisaca', 'chuquisaca'),
(489, 26, 'Cochabamba', 'cochabamba'),
(490, 26, 'La Paz', 'la-paz'),
(491, 26, 'Oruro', 'oruro'),
(492, 26, 'Pando', 'pando'),
(493, 26, 'Potosi', 'potosi'),
(494, 26, 'Santa Cruz', 'santa-cruz'),
(495, 26, 'Tarija', 'tarija'),
(496, 28, 'Brcko district', 'brcko-district'),
(497, 28, 'Unsko-Sanski Kanton', 'unsko-sanski-kanton'),
(498, 28, 'Posavski Kanton', 'posavski-kanton'),
(499, 28, 'Tuzlanski Kanton', 'tuzlanski-kanton'),
(500, 28, 'Zenicko-Dobojski Kanton', 'zenicko-dobojski-kanton'),
(501, 28, 'Bosanskopodrinjski Kanton', 'bosanskopodrinjski-kanton'),
(502, 28, 'Srednjebosanski Kanton', 'srednjebosanski-kanton'),
(503, 28, 'Hercegovacko-neretvanski Kanton', 'hercegovacko-neretvanski-kanton'),
(504, 28, 'Zapadnohercegovacka Zupanija', 'zapadnohercegovacka-zupanija'),
(505, 28, 'Kanton Sarajevo', 'kanton-sarajevo'),
(506, 28, 'Zapadnobosanska', 'zapadnobosanska'),
(507, 28, 'Banja Luka', 'banja-luka'),
(508, 28, 'Doboj', 'doboj'),
(509, 28, 'Bijeljina', 'bijeljina'),
(510, 28, 'Vlasenica', 'vlasenica'),
(511, 28, 'Sarajevo-Romanija or Sokolac', 'sarajevo-romanija-or-sokolac'),
(512, 28, 'Foca', 'foca'),
(513, 28, 'Trebinje', 'trebinje'),
(514, 29, 'Central', 'central'),
(515, 29, 'Ghanzi', 'ghanzi'),
(516, 29, 'Kgalagadi', 'kgalagadi'),
(517, 29, 'Kgatleng', 'kgatleng'),
(518, 29, 'Kweneng', 'kweneng'),
(519, 29, 'Ngamiland', 'ngamiland'),
(520, 29, 'North East', 'north-east'),
(521, 29, 'North West', 'north-west'),
(522, 29, 'South East', 'south-east'),
(523, 29, 'Southern', 'southern'),
(524, 31, 'Acre', 'acre'),
(525, 31, 'Alagoas', 'alagoas'),
(526, 31, 'Amapá', 'amapa'),
(527, 31, 'Amazonas', 'amazonas'),
(528, 31, 'Bahia', 'bahia'),
(529, 31, 'Ceará', 'ceara'),
(530, 31, 'Distrito Federal', 'distrito-federal'),
(531, 31, 'Espírito Santo', 'espirito-santo'),
(532, 31, 'Goiás', 'goias'),
(533, 31, 'Maranhão', 'maranhao'),
(534, 31, 'Mato Grosso', 'mato-grosso'),
(535, 31, 'Mato Grosso do Sul', 'mato-grosso-do-sul'),
(536, 31, 'Minas Gerais', 'minas-gerais'),
(537, 31, 'Pará', 'para'),
(538, 31, 'Paraíba', 'paraiba'),
(539, 31, 'Paraná', 'parana'),
(540, 31, 'Pernambuco', 'pernambuco'),
(541, 31, 'Piauí', 'piaui'),
(542, 31, 'Rio de Janeiro', 'rio-de-janeiro'),
(543, 31, 'Rio Grande do Norte', 'rio-grande-do-norte'),
(544, 31, 'Rio Grande do Sul', 'rio-grande-do-sul'),
(545, 31, 'Rondônia', 'rondonia'),
(546, 31, 'Roraima', 'roraima'),
(547, 31, 'Santa Catarina', 'santa-catarina'),
(548, 31, 'São Paulo', 'sao-paulo'),
(549, 31, 'Sergipe', 'sergipe'),
(550, 31, 'Tocantins', 'tocantins'),
(551, 32, 'Peros Banhos', 'peros-banhos'),
(552, 32, 'Salomon Islands', 'salomon-islands'),
(553, 32, 'Nelsons Island', 'nelsons-island'),
(554, 32, 'Three Brothers', 'three-brothers'),
(555, 32, 'Eagle Islands', 'eagle-islands'),
(556, 32, 'Danger Island', 'danger-island'),
(557, 32, 'Egmont Islands', 'egmont-islands'),
(558, 32, 'Diego Garcia', 'diego-garcia'),
(559, 33, 'Belait', 'belait'),
(560, 33, 'Brunei and Muara', 'brunei-and-muara'),
(561, 33, 'Temburong', 'temburong'),
(562, 33, 'Tutong', 'tutong'),
(563, 34, 'Blagoevgrad', 'blagoevgrad'),
(564, 34, 'Burgas', 'burgas'),
(565, 34, 'Dobrich', 'dobrich'),
(566, 34, 'Gabrovo', 'gabrovo'),
(567, 34, 'Haskovo', 'haskovo'),
(568, 34, 'Kardjali', 'kardjali'),
(569, 34, 'Kyustendil', 'kyustendil'),
(570, 34, 'Lovech', 'lovech'),
(571, 34, 'Montana', 'montana'),
(572, 34, 'Pazardjik', 'pazardjik'),
(573, 34, 'Pernik', 'pernik'),
(574, 34, 'Pleven', 'pleven'),
(575, 34, 'Plovdiv', 'plovdiv'),
(576, 34, 'Razgrad', 'razgrad'),
(577, 34, 'Shumen', 'shumen'),
(578, 34, 'Silistra', 'silistra'),
(579, 34, 'Sliven', 'sliven'),
(580, 34, 'Smolyan', 'smolyan'),
(581, 34, 'Sofia', 'sofia'),
(582, 34, 'Sofia - town', 'sofia-town'),
(583, 34, 'Stara Zagora', 'stara-zagora'),
(584, 34, 'Targovishte', 'targovishte'),
(585, 34, 'Varna', 'varna'),
(586, 34, 'Veliko Tarnovo', 'veliko-tarnovo'),
(587, 34, 'Vidin', 'vidin'),
(588, 34, 'Vratza', 'vratza'),
(589, 34, 'Yambol', 'yambol'),
(590, 34, 'Ruse', 'ruse'),
(591, 35, 'Bale', 'bale'),
(592, 35, 'Bam', 'bam'),
(593, 35, 'Banwa', 'banwa'),
(594, 35, 'Bazega', 'bazega'),
(595, 35, 'Bougouriba', 'bougouriba'),
(596, 35, 'Boulgou', 'boulgou'),
(597, 35, 'Boulkiemde', 'boulkiemde'),
(598, 35, 'Comoe', 'comoe'),
(599, 35, 'Ganzourgou', 'ganzourgou'),
(600, 35, 'Gnagna', 'gnagna'),
(601, 35, 'Gourma', 'gourma'),
(602, 35, 'Houet', 'houet'),
(603, 35, 'Ioba', 'ioba'),
(604, 35, 'Kadiogo', 'kadiogo'),
(605, 35, 'Kenedougou', 'kenedougou'),
(606, 35, 'Komondjari', 'komondjari'),
(607, 35, 'Kompienga', 'kompienga'),
(608, 35, 'Kossi', 'kossi'),
(609, 35, 'Koulpelogo', 'koulpelogo'),
(610, 35, 'Kouritenga', 'kouritenga'),
(611, 35, 'Kourweogo', 'kourweogo'),
(612, 35, 'Leraba', 'leraba'),
(613, 35, 'Loroum', 'loroum'),
(614, 35, 'Mouhoun', 'mouhoun'),
(615, 35, 'Nahouri', 'nahouri'),
(616, 35, 'Namentenga', 'namentenga'),
(617, 35, 'Nayala', 'nayala'),
(618, 35, 'Noumbiel', 'noumbiel'),
(619, 35, 'Oubritenga', 'oubritenga'),
(620, 35, 'Oudalan', 'oudalan'),
(621, 35, 'Passore', 'passore'),
(622, 35, 'Poni', 'poni'),
(623, 35, 'Sanguie', 'sanguie'),
(624, 35, 'Sanmatenga', 'sanmatenga'),
(625, 35, 'Seno', 'seno'),
(626, 35, 'Sissili', 'sissili'),
(627, 35, 'Soum', 'soum'),
(628, 35, 'Sourou', 'sourou'),
(629, 35, 'Tapoa', 'tapoa'),
(630, 35, 'Tuy', 'tuy'),
(631, 35, 'Yagha', 'yagha'),
(632, 35, 'Yatenga', 'yatenga'),
(633, 35, 'Ziro', 'ziro'),
(634, 35, 'Zondoma', 'zondoma'),
(635, 35, 'Zoundweogo', 'zoundweogo'),
(636, 36, 'Bubanza', 'bubanza'),
(637, 36, 'Bujumbura', 'bujumbura'),
(638, 36, 'Bururi', 'bururi'),
(639, 36, 'Cankuzo', 'cankuzo'),
(640, 36, 'Cibitoke', 'cibitoke'),
(641, 36, 'Gitega', 'gitega'),
(642, 36, 'Karuzi', 'karuzi'),
(643, 36, 'Kayanza', 'kayanza'),
(644, 36, 'Kirundo', 'kirundo'),
(645, 36, 'Makamba', 'makamba'),
(646, 36, 'Muramvya', 'muramvya'),
(647, 36, 'Muyinga', 'muyinga'),
(648, 36, 'Mwaro', 'mwaro'),
(649, 36, 'Ngozi', 'ngozi'),
(650, 36, 'Rutana', 'rutana'),
(651, 36, 'Ruyigi', 'ruyigi'),
(652, 37, 'Phnom Penh', 'phnom-penh'),
(653, 37, 'Preah Seihanu (Kompong Som or Sihanoukville)', 'preah-seihanu-kompong-som-or-sihanoukville'),
(654, 37, 'Pailin', 'pailin'),
(655, 37, 'Keb', 'keb'),
(656, 37, 'Banteay Meanchey', 'banteay-meanchey'),
(657, 37, 'Battambang', 'battambang'),
(658, 37, 'Kampong Cham', 'kampong-cham'),
(659, 37, 'Kampong Chhnang', 'kampong-chhnang'),
(660, 37, 'Kampong Speu', 'kampong-speu'),
(661, 37, 'Kampong Som', 'kampong-som'),
(662, 37, 'Kampong Thom', 'kampong-thom'),
(663, 37, 'Kampot', 'kampot'),
(664, 37, 'Kandal', 'kandal'),
(665, 37, 'Kaoh Kong', 'kaoh-kong'),
(666, 37, 'Kratie', 'kratie'),
(667, 37, 'Mondul Kiri', 'mondul-kiri'),
(668, 37, 'Oddar Meancheay', 'oddar-meancheay'),
(669, 37, 'Pursat', 'pursat'),
(670, 37, 'Preah Vihear', 'preah-vihear'),
(671, 37, 'Prey Veng', 'prey-veng'),
(672, 37, 'Ratanak Kiri', 'ratanak-kiri'),
(673, 37, 'Siemreap', 'siemreap'),
(674, 37, 'Stung Treng', 'stung-treng'),
(675, 37, 'Svay Rieng', 'svay-rieng'),
(676, 37, 'Takeo', 'takeo'),
(677, 38, 'Adamawa (Adamaoua)', 'adamawa-adamaoua'),
(678, 38, 'Centre', 'centre'),
(679, 38, 'East (Est)', 'east-est'),
(680, 38, 'Extreme North (Extreme-Nord)', 'extreme-north-extreme-nord'),
(681, 38, 'Littoral', 'littoral'),
(682, 38, 'North (Nord)', 'north-nord'),
(683, 38, 'Northwest (Nord-Ouest)', 'northwest-nord-ouest'),
(684, 38, 'West (Ouest)', 'west-ouest'),
(685, 38, 'South (Sud)', 'south-sud'),
(686, 38, 'Southwest (Sud-Ouest).', 'southwest-sud-ouest'),
(687, 39, 'Alberta', 'alberta'),
(688, 39, 'British Columbia', 'british-columbia'),
(689, 39, 'Manitoba', 'manitoba'),
(690, 39, 'New Brunswick', 'new-brunswick'),
(691, 39, 'Newfoundland and Labrador', 'newfoundland-and-labrador'),
(692, 39, 'Northwest Territories', 'northwest-territories'),
(693, 39, 'Nova Scotia', 'nova-scotia'),
(694, 39, 'Nunavut', 'nunavut'),
(695, 39, 'Ontario', 'ontario'),
(696, 39, 'Prince Edward Island', 'prince-edward-island'),
(697, 39, 'Québec', 'quebec'),
(698, 39, 'Saskatchewan', 'saskatchewan'),
(699, 39, 'Yukon Territory', 'yukon-territory'),
(700, 40, 'Boa Vista', 'boa-vista'),
(701, 40, 'Brava', 'brava'),
(702, 40, 'Calheta de Sao Miguel', 'calheta-de-sao-miguel'),
(703, 40, 'Maio', 'maio'),
(704, 40, 'Mosteiros', 'mosteiros'),
(705, 40, 'Paul', 'paul'),
(706, 40, 'Porto Novo', 'porto-novo'),
(707, 40, 'Praia', 'praia'),
(708, 40, 'Ribeira Grande', 'ribeira-grande'),
(709, 40, 'Sal', 'sal'),
(710, 40, 'Santa Catarina', 'santa-catarina'),
(711, 40, 'Santa Cruz', 'santa-cruz'),
(712, 40, 'Sao Domingos', 'sao-domingos'),
(713, 40, 'Sao Filipe', 'sao-filipe'),
(714, 40, 'Sao Nicolau', 'sao-nicolau'),
(715, 40, 'Sao Vicente', 'sao-vicente'),
(716, 40, 'Tarrafal', 'tarrafal'),
(717, 41, 'Creek', 'creek'),
(718, 41, 'Eastern', 'eastern'),
(719, 41, 'Midland', 'midland'),
(720, 41, 'South Town', 'south-town'),
(721, 41, 'Spot Bay', 'spot-bay'),
(722, 41, 'Stake Bay', 'stake-bay'),
(723, 41, 'West End', 'west-end'),
(724, 41, 'Western', 'western'),
(725, 42, 'Bamingui-Bangoran', 'bamingui-bangoran'),
(726, 42, 'Basse-Kotto', 'basse-kotto'),
(727, 42, 'Haute-Kotto', 'haute-kotto'),
(728, 42, 'Haut-Mbomou', 'haut-mbomou'),
(729, 42, 'Kemo', 'kemo'),
(730, 42, 'Lobaye', 'lobaye'),
(731, 42, 'Mambere-KadeÔ', 'mambere-kadeo'),
(732, 42, 'Mbomou', 'mbomou'),
(733, 42, 'Nana-Mambere', 'nana-mambere'),
(734, 42, 'Ombella-M\'Poko', 'ombella-m-poko'),
(735, 42, 'Ouaka', 'ouaka'),
(736, 42, 'Ouham', 'ouham'),
(737, 42, 'Ouham-Pende', 'ouham-pende'),
(738, 42, 'Vakaga', 'vakaga'),
(739, 42, 'Nana-Grebizi', 'nana-grebizi'),
(740, 42, 'Sangha-Mbaere', 'sangha-mbaere'),
(741, 42, 'Bangui', 'bangui'),
(742, 43, 'Batha', 'batha'),
(743, 43, 'Biltine', 'biltine'),
(744, 43, 'Borkou-Ennedi-Tibesti', 'borkou-ennedi-tibesti'),
(745, 43, 'Chari-Baguirmi', 'chari-baguirmi'),
(746, 43, 'Guera', 'guera'),
(747, 43, 'Kanem', 'kanem'),
(748, 43, 'Lac', 'lac'),
(749, 43, 'Logone Occidental', 'logone-occidental'),
(750, 43, 'Logone Oriental', 'logone-oriental'),
(751, 43, 'Mayo-Kebbi', 'mayo-kebbi'),
(752, 43, 'Moyen-Chari', 'moyen-chari'),
(753, 43, 'Ouaddai', 'ouaddai'),
(754, 43, 'Salamat', 'salamat'),
(755, 43, 'Tandjile', 'tandjile'),
(756, 44, 'Aisen del General Carlos Ibanez', 'aisen-del-general-carlos-ibanez'),
(757, 44, 'Antofagasta', 'antofagasta'),
(758, 44, 'Araucania', 'araucania'),
(759, 44, 'Atacama', 'atacama'),
(760, 44, 'Bio-Bio', 'bio-bio'),
(761, 44, 'Coquimbo', 'coquimbo'),
(762, 44, 'Libertador General Bernardo O\'Higgins', 'libertador-general-bernardo-o-higgins'),
(763, 44, 'Los Lagos', 'los-lagos'),
(764, 44, 'Magallanes y de la Antartica Chilena', 'magallanes-y-de-la-antartica-chilena'),
(765, 44, 'Maule', 'maule'),
(766, 44, 'Region Metropolitana', 'region-metropolitana'),
(767, 44, 'Tarapaca', 'tarapaca'),
(768, 44, 'Valparaiso', 'valparaiso'),
(769, 44, 'Arica y Parinacota', 'arica-y-parinacota'),
(770, 44, 'Los Rios', 'los-rios'),
(771, 45, 'Anhui', 'anhui'),
(772, 45, 'Beijing', 'beijing'),
(773, 45, 'Chongqing', 'chongqing'),
(774, 45, 'Fujian', 'fujian'),
(775, 45, 'Gansu', 'gansu'),
(776, 45, 'Guangdong', 'guangdong'),
(777, 45, 'Guangxi', 'guangxi'),
(778, 45, 'Guizhou', 'guizhou'),
(779, 45, 'Hainan', 'hainan'),
(780, 45, 'Hebei', 'hebei'),
(781, 45, 'Heilongjiang', 'heilongjiang'),
(782, 45, 'Henan', 'henan'),
(783, 45, 'Hong Kong', 'hong-kong'),
(784, 45, 'Hubei', 'hubei'),
(785, 45, 'Hunan', 'hunan'),
(786, 45, 'Inner Mongolia', 'inner-mongolia'),
(787, 45, 'Jiangsu', 'jiangsu'),
(788, 45, 'Jiangxi', 'jiangxi'),
(789, 45, 'Jilin', 'jilin'),
(790, 45, 'Liaoning', 'liaoning'),
(791, 45, 'Macau', 'macau'),
(792, 45, 'Ningxia', 'ningxia'),
(793, 45, 'Shaanxi', 'shaanxi'),
(794, 45, 'Shandong', 'shandong'),
(795, 45, 'Shanghai', 'shanghai'),
(796, 45, 'Shanxi', 'shanxi'),
(797, 45, 'Sichuan', 'sichuan'),
(798, 45, 'Tianjin', 'tianjin'),
(799, 45, 'Xinjiang', 'xinjiang'),
(800, 45, 'Yunnan', 'yunnan'),
(801, 45, 'Zhejiang', 'zhejiang'),
(802, 45, 'Qinghai', 'qinghai'),
(803, 47, 'Direction Island', 'direction-island'),
(804, 47, 'Home Island', 'home-island'),
(805, 47, 'Horsburgh Island', 'horsburgh-island'),
(806, 47, 'South Island', 'south-island'),
(807, 47, 'West Island', 'west-island'),
(808, 48, 'Amazonas', 'amazonas'),
(809, 48, 'Antioquia', 'antioquia'),
(810, 48, 'Arauca', 'arauca'),
(811, 48, 'Atlantico', 'atlantico'),
(812, 48, 'Bogota D.C.', 'bogota-d-c'),
(813, 48, 'Bolivar', 'bolivar'),
(814, 48, 'Boyaca', 'boyaca'),
(815, 48, 'Caldas', 'caldas'),
(816, 48, 'Caqueta', 'caqueta'),
(817, 48, 'Casanare', 'casanare'),
(818, 48, 'Cauca', 'cauca'),
(819, 48, 'Cesar', 'cesar'),
(820, 48, 'Choco', 'choco'),
(821, 48, 'Cordoba', 'cordoba'),
(822, 48, 'Cundinamarca', 'cundinamarca'),
(823, 48, 'Guainia', 'guainia'),
(824, 48, 'Guajira', 'guajira'),
(825, 48, 'Guaviare', 'guaviare'),
(826, 48, 'Huila', 'huila'),
(827, 48, 'Magdalena', 'magdalena'),
(828, 48, 'Meta', 'meta'),
(829, 48, 'Narino', 'narino'),
(830, 48, 'Norte de Santander', 'norte-de-santander'),
(831, 48, 'Putumayo', 'putumayo'),
(832, 48, 'Quindio', 'quindio'),
(833, 48, 'Risaralda', 'risaralda'),
(834, 48, 'San Andres y Providencia', 'san-andres-y-providencia'),
(835, 48, 'Santander', 'santander'),
(836, 48, 'Sucre', 'sucre'),
(837, 48, 'Tolima', 'tolima'),
(838, 48, 'Valle del Cauca', 'valle-del-cauca'),
(839, 48, 'Vaupes', 'vaupes'),
(840, 48, 'Vichada', 'vichada'),
(841, 49, 'Grande Comore', 'grande-comore'),
(842, 49, 'Anjouan', 'anjouan'),
(843, 49, 'Moheli', 'moheli'),
(844, 50, 'Bouenza', 'bouenza'),
(845, 50, 'Brazzaville', 'brazzaville'),
(846, 50, 'Cuvette', 'cuvette'),
(847, 50, 'Cuvette-Ouest', 'cuvette-ouest'),
(848, 50, 'Kouilou', 'kouilou'),
(849, 50, 'Lekoumou', 'lekoumou'),
(850, 50, 'Likouala', 'likouala'),
(851, 50, 'Niari', 'niari'),
(852, 50, 'Plateaux', 'plateaux'),
(853, 50, 'Pool', 'pool'),
(854, 50, 'Sangha', 'sangha'),
(855, 52, 'Pukapuka', 'pukapuka'),
(856, 52, 'Rakahanga', 'rakahanga'),
(857, 52, 'Manihiki', 'manihiki'),
(858, 52, 'Penrhyn', 'penrhyn'),
(859, 52, 'Nassau Island', 'nassau-island'),
(860, 52, 'Surwarrow', 'surwarrow'),
(861, 52, 'Palmerston', 'palmerston'),
(862, 52, 'Aitutaki', 'aitutaki'),
(863, 52, 'Manuae', 'manuae'),
(864, 52, 'Takutea', 'takutea'),
(865, 52, 'Mitiaro', 'mitiaro'),
(866, 52, 'Atiu', 'atiu'),
(867, 52, 'Mauke', 'mauke'),
(868, 52, 'Rarotonga', 'rarotonga'),
(869, 52, 'Mangaia', 'mangaia'),
(870, 53, 'Alajuela', 'alajuela'),
(871, 53, 'Cartago', 'cartago'),
(872, 53, 'Guanacaste', 'guanacaste'),
(873, 53, 'Heredia', 'heredia'),
(874, 53, 'Limon', 'limon'),
(875, 53, 'Puntarenas', 'puntarenas'),
(876, 53, 'San Jose', 'san-jose'),
(877, 59, 'Abengourou', 'abengourou'),
(878, 59, 'Abidjan', 'abidjan'),
(879, 59, 'Aboisso', 'aboisso'),
(880, 59, 'Adiake', 'adiake'),
(881, 59, 'Adzope', 'adzope'),
(882, 59, 'Agboville', 'agboville'),
(883, 59, 'Agnibilekrou', 'agnibilekrou'),
(884, 59, 'Alepe', 'alepe'),
(885, 59, 'Bocanda', 'bocanda'),
(886, 59, 'Bangolo', 'bangolo'),
(887, 59, 'Beoumi', 'beoumi'),
(888, 59, 'Biankouma', 'biankouma'),
(889, 59, 'Bondoukou', 'bondoukou'),
(890, 59, 'Bongouanou', 'bongouanou'),
(891, 59, 'Bouafle', 'bouafle'),
(892, 59, 'Bouake', 'bouake'),
(893, 59, 'Bouna', 'bouna'),
(894, 59, 'Boundiali', 'boundiali'),
(895, 59, 'Dabakala', 'dabakala'),
(896, 59, 'Dabou', 'dabou'),
(897, 59, 'Daloa', 'daloa'),
(898, 59, 'Danane', 'danane'),
(899, 59, 'Daoukro', 'daoukro'),
(900, 59, 'Dimbokro', 'dimbokro'),
(901, 59, 'Divo', 'divo'),
(902, 59, 'Duekoue', 'duekoue'),
(903, 59, 'Ferkessedougou', 'ferkessedougou'),
(904, 59, 'Gagnoa', 'gagnoa'),
(905, 59, 'Grand-Bassam', 'grand-bassam'),
(906, 59, 'Grand-Lahou', 'grand-lahou'),
(907, 59, 'Guiglo', 'guiglo'),
(908, 59, 'Issia', 'issia'),
(909, 59, 'Jacqueville', 'jacqueville'),
(910, 59, 'Katiola', 'katiola'),
(911, 59, 'Korhogo', 'korhogo'),
(912, 59, 'Lakota', 'lakota'),
(913, 59, 'Man', 'man'),
(914, 59, 'Mankono', 'mankono'),
(915, 59, 'Mbahiakro', 'mbahiakro'),
(916, 59, 'Odienne', 'odienne'),
(917, 59, 'Oume', 'oume'),
(918, 59, 'Sakassou', 'sakassou'),
(919, 59, 'San-Pedro', 'san-pedro'),
(920, 59, 'Sassandra', 'sassandra'),
(921, 59, 'Seguela', 'seguela'),
(922, 59, 'Sinfra', 'sinfra'),
(923, 59, 'Soubre', 'soubre'),
(924, 59, 'Tabou', 'tabou'),
(925, 59, 'Tanda', 'tanda'),
(926, 59, 'Tiebissou', 'tiebissou'),
(927, 59, 'Tingrela', 'tingrela'),
(928, 59, 'Tiassale', 'tiassale'),
(929, 59, 'Touba', 'touba'),
(930, 59, 'Toulepleu', 'toulepleu'),
(931, 59, 'Toumodi', 'toumodi'),
(932, 59, 'Vavoua', 'vavoua'),
(933, 59, 'Yamoussoukro', 'yamoussoukro'),
(934, 59, 'Zuenoula', 'zuenoula'),
(935, 54, 'Bjelovarsko-bilogorska', 'bjelovarsko-bilogorska'),
(936, 54, 'Grad Zagreb', 'grad-zagreb'),
(937, 54, 'Dubrovačko-neretvanska', 'dubrovacko-neretvanska'),
(938, 54, 'Istarska', 'istarska'),
(939, 54, 'Karlovačka', 'karlovacka'),
(940, 54, 'Koprivničko-križevačka', 'koprivnicko-krizevacka'),
(941, 54, 'Krapinsko-zagorska', 'krapinsko-zagorska'),
(942, 54, 'Ličko-senjska', 'licko-senjska'),
(943, 54, 'Međimurska', 'međimurska'),
(944, 54, 'Osječko-baranjska', 'osjecko-baranjska'),
(945, 54, 'Požeško-slavonska', 'pozesko-slavonska'),
(946, 54, 'Primorsko-goranska', 'primorsko-goranska'),
(947, 54, 'Šibensko-kninska', 'sibensko-kninska'),
(948, 54, 'Sisačko-moslavačka', 'sisacko-moslavacka'),
(949, 54, 'Brodsko-posavska', 'brodsko-posavska'),
(950, 54, 'Splitsko-dalmatinska', 'splitsko-dalmatinska'),
(951, 54, 'Varaždinska', 'varazdinska'),
(952, 54, 'Virovitičko-podravska', 'viroviticko-podravska'),
(953, 54, 'Vukovarsko-srijemska', 'vukovarsko-srijemska'),
(954, 54, 'Zadarska', 'zadarska'),
(955, 54, 'Zagrebačka', 'zagrebacka'),
(956, 55, 'Camaguey', 'camaguey'),
(957, 55, 'Ciego de Avila', 'ciego-de-avila'),
(958, 55, 'Cienfuegos', 'cienfuegos'),
(959, 55, 'Ciudad de La Habana', 'ciudad-de-la-habana'),
(960, 55, 'Granma', 'granma'),
(961, 55, 'Guantanamo', 'guantanamo'),
(962, 55, 'Holguin', 'holguin'),
(963, 55, 'Isla de la Juventud', 'isla-de-la-juventud'),
(964, 55, 'La Habana', 'la-habana'),
(965, 55, 'Las Tunas', 'las-tunas'),
(966, 55, 'Matanzas', 'matanzas'),
(967, 55, 'Pinar del Rio', 'pinar-del-rio'),
(968, 55, 'Sancti Spiritus', 'sancti-spiritus'),
(969, 55, 'Santiago de Cuba', 'santiago-de-cuba'),
(970, 55, 'Villa Clara', 'villa-clara'),
(971, 57, 'Famagusta', 'famagusta'),
(972, 57, 'Kyrenia', 'kyrenia'),
(973, 57, 'Larnaca', 'larnaca'),
(974, 57, 'Limassol', 'limassol'),
(975, 57, 'Nicosia', 'nicosia'),
(976, 57, 'Paphos', 'paphos'),
(977, 58, 'Ústecký', 'ustecky'),
(978, 58, 'Jihočeský', 'jihocesky'),
(979, 58, 'Jihomoravský', 'jihomoravsky'),
(980, 58, 'Karlovarský', 'karlovarsky'),
(981, 58, 'Královehradecký', 'kralovehradecky'),
(982, 58, 'Liberecký', 'liberecky'),
(983, 58, 'Moravskoslezský', 'moravskoslezsky'),
(984, 58, 'Olomoucký', 'olomoucky'),
(985, 58, 'Pardubický', 'pardubicky'),
(986, 58, 'Plzeňský', 'plzensky'),
(987, 58, 'Praha', 'praha'),
(988, 58, 'Středočeský', 'stredocesky'),
(989, 58, 'Vysočina', 'vysocina'),
(990, 58, 'Zlínský', 'zlinsky'),
(991, 60, 'Arhus', 'arhus'),
(992, 60, 'Bornholm', 'bornholm'),
(993, 60, 'Copenhagen', 'copenhagen'),
(994, 60, 'Faroe Islands', 'faroe-islands'),
(995, 60, 'Frederiksborg', 'frederiksborg'),
(996, 60, 'Fyn', 'fyn'),
(997, 60, 'Kobenhavn', 'kobenhavn'),
(998, 60, 'Nordjylland', 'nordjylland'),
(999, 60, 'Ribe', 'ribe'),
(1000, 60, 'Ringkobing', 'ringkobing'),
(1001, 60, 'Roskilde', 'roskilde'),
(1002, 60, 'Sonderjylland', 'sonderjylland'),
(1003, 60, 'Storstrom', 'storstrom'),
(1004, 60, 'Vejle', 'vejle'),
(1005, 60, 'Vestjælland', 'vestjaelland'),
(1006, 60, 'Viborg', 'viborg'),
(1007, 61, '\'Ali Sabih', 'ali-sabih'),
(1008, 61, 'Dikhil', 'dikhil'),
(1009, 61, 'Djibouti', 'djibouti'),
(1010, 61, 'Obock', 'obock'),
(1011, 61, 'Tadjoura', 'tadjoura'),
(1012, 62, 'Saint Andrew Parish', 'saint-andrew-parish'),
(1013, 62, 'Saint David Parish', 'saint-david-parish'),
(1014, 62, 'Saint George Parish', 'saint-george-parish'),
(1015, 62, 'Saint John Parish', 'saint-john-parish'),
(1016, 62, 'Saint Joseph Parish', 'saint-joseph-parish'),
(1017, 62, 'Saint Luke Parish', 'saint-luke-parish'),
(1018, 62, 'Saint Mark Parish', 'saint-mark-parish'),
(1019, 62, 'Saint Patrick Parish', 'saint-patrick-parish'),
(1020, 62, 'Saint Paul Parish', 'saint-paul-parish'),
(1021, 62, 'Saint Peter Parish', 'saint-peter-parish'),
(1022, 63, 'Distrito Nacional', 'distrito-nacional'),
(1023, 63, 'Azua', 'azua'),
(1024, 63, 'Baoruco', 'baoruco'),
(1025, 63, 'Barahona', 'barahona'),
(1026, 63, 'Dajabon', 'dajabon'),
(1027, 63, 'Duarte', 'duarte'),
(1028, 63, 'Elias Pina', 'elias-pina'),
(1029, 63, 'El Seybo', 'el-seybo'),
(1030, 63, 'Espaillat', 'espaillat'),
(1031, 63, 'Hato Mayor', 'hato-mayor'),
(1032, 63, 'Independencia', 'independencia'),
(1033, 63, 'La Altagracia', 'la-altagracia'),
(1034, 63, 'La Romana', 'la-romana'),
(1035, 63, 'La Vega', 'la-vega'),
(1036, 63, 'Maria Trinidad Sanchez', 'maria-trinidad-sanchez'),
(1037, 63, 'Monsenor Nouel', 'monsenor-nouel'),
(1038, 63, 'Monte Cristi', 'monte-cristi'),
(1039, 63, 'Monte Plata', 'monte-plata'),
(1040, 63, 'Pedernales', 'pedernales'),
(1041, 63, 'Peravia (Bani)', 'peravia-bani'),
(1042, 63, 'Puerto Plata', 'puerto-plata'),
(1043, 63, 'Salcedo', 'salcedo'),
(1044, 63, 'Samana', 'samana'),
(1045, 63, 'Sanchez Ramirez', 'sanchez-ramirez'),
(1046, 63, 'San Cristobal', 'san-cristobal'),
(1047, 63, 'San Jose de Ocoa', 'san-jose-de-ocoa'),
(1048, 63, 'San Juan', 'san-juan'),
(1049, 63, 'San Pedro de Macoris', 'san-pedro-de-macoris'),
(1050, 63, 'Santiago', 'santiago'),
(1051, 63, 'Santiago Rodriguez', 'santiago-rodriguez'),
(1052, 63, 'Santo Domingo', 'santo-domingo'),
(1053, 63, 'Valverde', 'valverde'),
(1054, 221, 'Aileu', 'aileu'),
(1055, 221, 'Ainaro', 'ainaro'),
(1056, 221, 'Baucau', 'baucau'),
(1057, 221, 'Bobonaro', 'bobonaro'),
(1058, 221, 'Cova Lima', 'cova-lima'),
(1059, 221, 'Dili', 'dili'),
(1060, 221, 'Ermera', 'ermera'),
(1061, 221, 'Lautem', 'lautem'),
(1062, 221, 'Liquica', 'liquica'),
(1063, 221, 'Manatuto', 'manatuto'),
(1064, 221, 'Manufahi', 'manufahi'),
(1065, 221, 'Oecussi', 'oecussi'),
(1066, 221, 'Viqueque', 'viqueque'),
(1067, 64, 'Azuay', 'azuay'),
(1068, 64, 'Bolivar', 'bolivar'),
(1069, 64, 'Cañar', 'canar'),
(1070, 64, 'Carchi', 'carchi'),
(1071, 64, 'Chimborazo', 'chimborazo'),
(1072, 64, 'Cotopaxi', 'cotopaxi'),
(1073, 64, 'El Oro', 'el-oro'),
(1074, 64, 'Esmeraldas', 'esmeraldas'),
(1075, 64, 'Galápagos', 'galapagos'),
(1076, 64, 'Guayas', 'guayas'),
(1077, 64, 'Imbabura', 'imbabura'),
(1078, 64, 'Loja', 'loja'),
(1079, 64, 'Los Rios', 'los-rios'),
(1080, 64, 'Manabí', 'manabi'),
(1081, 64, 'Morona Santiago', 'morona-santiago'),
(1082, 64, 'Napo', 'napo'),
(1083, 64, 'Orellana', 'orellana'),
(1084, 64, 'Pastaza', 'pastaza'),
(1085, 64, 'Pichincha', 'pichincha'),
(1086, 64, 'Sucumbíos', 'sucumbios'),
(1087, 64, 'Tungurahua', 'tungurahua'),
(1088, 64, 'Zamora Chinchipe', 'zamora-chinchipe'),
(1089, 65, 'Ad Daqahliyah', 'ad-daqahliyah'),
(1090, 65, 'Al Bahr al Ahmar', 'al-bahr-al-ahmar'),
(1091, 65, 'Al Buhayrah', 'al-buhayrah'),
(1092, 65, 'Al Fayyum', 'al-fayyum'),
(1093, 65, 'Al Gharbiyah', 'al-gharbiyah'),
(1094, 65, 'Al Iskandariyah', 'al-iskandariyah'),
(1095, 65, 'Al Isma\'iliyah', 'al-isma-iliyah'),
(1096, 65, 'Al Jizah', 'al-jizah'),
(1097, 65, 'Al Minufiyah', 'al-minufiyah'),
(1098, 65, 'Al Minya', 'al-minya'),
(1099, 65, 'Al Qahirah', 'al-qahirah'),
(1100, 65, 'Al Qalyubiyah', 'al-qalyubiyah'),
(1101, 65, 'Al Wadi al Jadid', 'al-wadi-al-jadid'),
(1102, 65, 'Ash Sharqiyah', 'ash-sharqiyah'),
(1103, 65, 'As Suways', 'as-suways'),
(1104, 65, 'Aswan', 'aswan'),
(1105, 65, 'Asyut', 'asyut'),
(1106, 65, 'Bani Suwayf', 'bani-suwayf'),
(1107, 65, 'Bur Sa\'id', 'bur-sa-id'),
(1108, 65, 'Dumyat', 'dumyat'),
(1109, 65, 'Janub Sina\'', 'janub-sina'),
(1110, 65, 'Kafr ash Shaykh', 'kafr-ash-shaykh'),
(1111, 65, 'Matruh', 'matruh'),
(1112, 65, 'Qina', 'qina'),
(1113, 65, 'Shamal Sina\'', 'shamal-sina'),
(1114, 65, 'Suhaj', 'suhaj'),
(1115, 66, 'Ahuachapan', 'ahuachapan'),
(1116, 66, 'Cabanas', 'cabanas'),
(1117, 66, 'Chalatenango', 'chalatenango'),
(1118, 66, 'Cuscatlan', 'cuscatlan'),
(1119, 66, 'La Libertad', 'la-libertad'),
(1120, 66, 'La Paz', 'la-paz'),
(1121, 66, 'La Union', 'la-union'),
(1122, 66, 'Morazan', 'morazan'),
(1123, 66, 'San Miguel', 'san-miguel'),
(1124, 66, 'San Salvador', 'san-salvador'),
(1125, 66, 'San Vicente', 'san-vicente'),
(1126, 66, 'Santa Ana', 'santa-ana'),
(1127, 66, 'Sonsonate', 'sonsonate'),
(1128, 66, 'Usulutan', 'usulutan'),
(1129, 67, 'Provincia Annobon', 'provincia-annobon'),
(1130, 67, 'Provincia Bioko Norte', 'provincia-bioko-norte'),
(1131, 67, 'Provincia Bioko Sur', 'provincia-bioko-sur'),
(1132, 67, 'Provincia Centro Sur', 'provincia-centro-sur'),
(1133, 67, 'Provincia Kie-Ntem', 'provincia-kie-ntem'),
(1134, 67, 'Provincia Litoral', 'provincia-litoral'),
(1135, 67, 'Provincia Wele-Nzas', 'provincia-wele-nzas'),
(1136, 68, 'Central (Maekel)', 'central-maekel'),
(1137, 68, 'Anseba (Keren)', 'anseba-keren'),
(1138, 68, 'Southern Red Sea (Debub-Keih-Bahri)', 'southern-red-sea-debub-keih-bahri'),
(1139, 68, 'Northern Red Sea (Semien-Keih-Bahri)', 'northern-red-sea-semien-keih-bahri'),
(1140, 68, 'Southern (Debub)', 'southern-debub'),
(1141, 68, 'Gash-Barka (Barentu)', 'gash-barka-barentu'),
(1142, 69, 'Harjumaa (Tallinn)', 'harjumaa-tallinn'),
(1143, 69, 'Hiiumaa (Kardla)', 'hiiumaa-kardla'),
(1144, 69, 'Ida-Virumaa (Johvi)', 'ida-virumaa-johvi'),
(1145, 69, 'Jarvamaa (Paide)', 'jarvamaa-paide'),
(1146, 69, 'Jogevamaa (Jogeva)', 'jogevamaa-jogeva'),
(1147, 69, 'Laane-Virumaa (Rakvere)', 'laane-virumaa-rakvere'),
(1148, 69, 'Laanemaa (Haapsalu)', 'laanemaa-haapsalu'),
(1149, 69, 'Parnumaa (Parnu)', 'parnumaa-parnu'),
(1150, 69, 'Polvamaa (Polva)', 'polvamaa-polva'),
(1151, 69, 'Raplamaa (Rapla)', 'raplamaa-rapla'),
(1152, 69, 'Saaremaa (Kuessaare)', 'saaremaa-kuessaare'),
(1153, 69, 'Tartumaa (Tartu)', 'tartumaa-tartu'),
(1154, 69, 'Valgamaa (Valga)', 'valgamaa-valga'),
(1155, 69, 'Viljandimaa (Viljandi)', 'viljandimaa-viljandi'),
(1156, 69, 'Vorumaa (Voru)', 'vorumaa-voru'),
(1157, 70, 'Afar', 'afar'),
(1158, 70, 'Amhara', 'amhara'),
(1159, 70, 'Benishangul-Gumaz', 'benishangul-gumaz'),
(1160, 70, 'Gambela', 'gambela'),
(1161, 70, 'Hariai', 'hariai'),
(1162, 70, 'Oromia', 'oromia'),
(1163, 70, 'Somali', 'somali'),
(1164, 70, 'Southern Nations - Nationalities and Peoples Region', 'southern-nations-nationalities-and-peoples-region'),
(1165, 70, 'Tigray', 'tigray'),
(1166, 70, 'Addis Ababa', 'addis-ababa'),
(1167, 70, 'Dire Dawa', 'dire-dawa'),
(1168, 73, 'Central Division', 'central-division'),
(1169, 73, 'Northern Division', 'northern-division'),
(1170, 73, 'Eastern Division', 'eastern-division'),
(1171, 73, 'Western Division', 'western-division'),
(1172, 73, 'Rotuma', 'rotuma'),
(1173, 74, 'Ahvenanmaan lääni', 'ahvenanmaan-laani'),
(1174, 74, 'Etelä-Suomen lääni', 'etela-suomen-laani'),
(1175, 74, 'Itä-Suomen lääni', 'ita-suomen-laani'),
(1176, 74, 'Länsi-Suomen lääni', 'lansi-suomen-laani'),
(1177, 74, 'Lapin lääni', 'lapin-laani'),
(1178, 74, 'Oulun lääni', 'oulun-laani'),
(1179, 75, 'Ain', 'ain'),
(1180, 75, 'Aisne', 'aisne'),
(1181, 75, 'Allier', 'allier'),
(1182, 75, 'Alpes de Haute Provence', 'alpes-de-haute-provence'),
(1183, 75, 'Hautes-Alpes', 'hautes-alpes'),
(1184, 75, 'Alpes Maritimes', 'alpes-maritimes'),
(1185, 75, 'Ardèche', 'ardeche'),
(1186, 75, 'Ardennes', 'ardennes'),
(1187, 75, 'Ariège', 'ariege'),
(1188, 75, 'Aube', 'aube'),
(1189, 75, 'Aude', 'aude'),
(1190, 75, 'Aveyron', 'aveyron'),
(1191, 75, 'Bouches du Rhône', 'bouches-du-rhone'),
(1192, 75, 'Calvados', 'calvados'),
(1193, 75, 'Cantal', 'cantal'),
(1194, 75, 'Charente', 'charente'),
(1195, 75, 'Charente Maritime', 'charente-maritime'),
(1196, 75, 'Cher', 'cher'),
(1197, 75, 'Corrèze', 'correze'),
(1198, 75, 'Corse du Sud', 'corse-du-sud'),
(1199, 75, 'Haute Corse', 'haute-corse'),
(1200, 75, 'Côte d&#039;or', 'cote-d-039-or'),
(1201, 75, 'Côtes d&#039;Armor', 'cotes-d-039-armor'),
(1202, 75, 'Creuse', 'creuse'),
(1203, 75, 'Dordogne', 'dordogne'),
(1204, 75, 'Doubs', 'doubs'),
(1205, 75, 'Drôme', 'drome'),
(1206, 75, 'Eure', 'eure'),
(1207, 75, 'Eure et Loir', 'eure-et-loir'),
(1208, 75, 'Finistère', 'finistere'),
(1209, 75, 'Gard', 'gard'),
(1210, 75, 'Haute Garonne', 'haute-garonne'),
(1211, 75, 'Gers', 'gers'),
(1212, 75, 'Gironde', 'gironde'),
(1213, 75, 'Hérault', 'herault'),
(1214, 75, 'Ille et Vilaine', 'ille-et-vilaine'),
(1215, 75, 'Indre', 'indre'),
(1216, 75, 'Indre et Loire', 'indre-et-loire'),
(1217, 75, 'Isére', 'isere'),
(1218, 75, 'Jura', 'jura'),
(1219, 75, 'Landes', 'landes'),
(1220, 75, 'Loir et Cher', 'loir-et-cher'),
(1221, 75, 'Loire', 'loire'),
(1222, 75, 'Haute Loire', 'haute-loire'),
(1223, 75, 'Loire Atlantique', 'loire-atlantique'),
(1224, 75, 'Loiret', 'loiret'),
(1225, 75, 'Lot', 'lot'),
(1226, 75, 'Lot et Garonne', 'lot-et-garonne'),
(1227, 75, 'Lozère', 'lozere'),
(1228, 75, 'Maine et Loire', 'maine-et-loire'),
(1229, 75, 'Manche', 'manche'),
(1230, 75, 'Marne', 'marne'),
(1231, 75, 'Haute Marne', 'haute-marne'),
(1232, 75, 'Mayenne', 'mayenne'),
(1233, 75, 'Meurthe et Moselle', 'meurthe-et-moselle'),
(1234, 75, 'Meuse', 'meuse'),
(1235, 75, 'Morbihan', 'morbihan'),
(1236, 75, 'Moselle', 'moselle'),
(1237, 75, 'Nièvre', 'nievre'),
(1238, 75, 'Nord', 'nord'),
(1239, 75, 'Oise', 'oise'),
(1240, 75, 'Orne', 'orne'),
(1241, 75, 'Pas de Calais', 'pas-de-calais'),
(1242, 75, 'Puy de Dôme', 'puy-de-dome'),
(1243, 75, 'Pyrénées Atlantiques', 'pyrenees-atlantiques'),
(1244, 75, 'Hautes Pyrénées', 'hautes-pyrenees'),
(1245, 75, 'Pyrénées Orientales', 'pyrenees-orientales'),
(1246, 75, 'Bas Rhin', 'bas-rhin'),
(1247, 75, 'Haut Rhin', 'haut-rhin'),
(1248, 75, 'Rhône', 'rhone'),
(1249, 75, 'Haute Saône', 'haute-saone'),
(1250, 75, 'Saône et Loire', 'saone-et-loire'),
(1251, 75, 'Sarthe', 'sarthe'),
(1252, 75, 'Savoie', 'savoie'),
(1253, 75, 'Haute Savoie', 'haute-savoie'),
(1254, 75, 'Paris', 'paris'),
(1255, 75, 'Seine Maritime', 'seine-maritime'),
(1256, 75, 'Seine et Marne', 'seine-et-marne'),
(1257, 75, 'Yvelines', 'yvelines'),
(1258, 75, 'Deux Sèvres', 'deux-sevres'),
(1259, 75, 'Somme', 'somme'),
(1260, 75, 'Tarn', 'tarn'),
(1261, 75, 'Tarn et Garonne', 'tarn-et-garonne'),
(1262, 75, 'Var', 'var'),
(1263, 75, 'Vaucluse', 'vaucluse'),
(1264, 75, 'Vendée', 'vendee'),
(1265, 75, 'Vienne', 'vienne'),
(1266, 75, 'Haute Vienne', 'haute-vienne'),
(1267, 75, 'Vosges', 'vosges'),
(1268, 75, 'Yonne', 'yonne'),
(1269, 75, 'Territoire de Belfort', 'territoire-de-belfort'),
(1270, 75, 'Essonne', 'essonne'),
(1271, 75, 'Hauts de Seine', 'hauts-de-seine'),
(1272, 75, 'Seine St-Denis', 'seine-st-denis'),
(1273, 75, 'Val de Marne', 'val-de-marne'),
(1274, 75, 'Val d\'Oise', 'val-d-oise'),
(1275, 77, 'Archipel des Marquises', 'archipel-des-marquises'),
(1276, 77, 'Archipel des Tuamotu', 'archipel-des-tuamotu'),
(1277, 77, 'Archipel des Tubuai', 'archipel-des-tubuai'),
(1278, 77, 'Iles du Vent', 'iles-du-vent'),
(1279, 77, 'Iles Sous-le-Vent', 'iles-sous-le-vent'),
(1280, 78, 'Iles Crozet', 'iles-crozet'),
(1281, 78, 'Iles Kerguelen', 'iles-kerguelen'),
(1282, 78, 'Ile Amsterdam', 'ile-amsterdam'),
(1283, 78, 'Ile Saint-Paul', 'ile-saint-paul'),
(1284, 78, 'Adelie Land', 'adelie-land'),
(1285, 79, 'Estuaire', 'estuaire'),
(1286, 79, 'Haut-Ogooue', 'haut-ogooue'),
(1287, 79, 'Moyen-Ogooue', 'moyen-ogooue'),
(1288, 79, 'Ngounie', 'ngounie'),
(1289, 79, 'Nyanga', 'nyanga'),
(1290, 79, 'Ogooue-Ivindo', 'ogooue-ivindo'),
(1291, 79, 'Ogooue-Lolo', 'ogooue-lolo'),
(1292, 79, 'Ogooue-Maritime', 'ogooue-maritime'),
(1293, 79, 'Woleu-Ntem', 'woleu-ntem'),
(1294, 80, 'Banjul', 'banjul'),
(1295, 80, 'Basse', 'basse'),
(1296, 80, 'Brikama', 'brikama'),
(1297, 80, 'Janjangbure', 'janjangbure'),
(1298, 80, 'Kanifeng', 'kanifeng'),
(1299, 80, 'Kerewan', 'kerewan'),
(1300, 80, 'Kuntaur', 'kuntaur'),
(1301, 80, 'Mansakonko', 'mansakonko'),
(1302, 80, 'Lower River', 'lower-river'),
(1303, 80, 'Central River', 'central-river'),
(1304, 80, 'North Bank', 'north-bank'),
(1305, 80, 'Upper River', 'upper-river'),
(1306, 80, 'Western', 'western'),
(1307, 81, 'Abkhazia', 'abkhazia'),
(1308, 81, 'Ajaria', 'ajaria'),
(1309, 81, 'Tbilisi', 'tbilisi'),
(1310, 81, 'Guria', 'guria'),
(1311, 81, 'Imereti', 'imereti'),
(1312, 81, 'Kakheti', 'kakheti'),
(1313, 81, 'Kvemo Kartli', 'kvemo-kartli'),
(1314, 81, 'Mtskheta-Mtianeti', 'mtskheta-mtianeti'),
(1315, 81, 'Racha Lechkhumi and Kvemo Svanet', 'racha-lechkhumi-and-kvemo-svanet'),
(1316, 81, 'Samegrelo-Zemo Svaneti', 'samegrelo-zemo-svaneti'),
(1317, 81, 'Samtskhe-Javakheti', 'samtskhe-javakheti'),
(1318, 81, 'Shida Kartli', 'shida-kartli'),
(1319, 82, 'Baden-Württemberg', 'baden-wurttemberg'),
(1320, 82, 'Bayern', 'bayern'),
(1321, 82, 'Berlin', 'berlin'),
(1322, 82, 'Brandenburg', 'brandenburg'),
(1323, 82, 'Bremen', 'bremen'),
(1324, 82, 'Hamburg', 'hamburg'),
(1325, 82, 'Hessen', 'hessen'),
(1326, 82, 'Mecklenburg-Vorpommern', 'mecklenburg-vorpommern'),
(1327, 82, 'Niedersachsen', 'niedersachsen'),
(1328, 82, 'Nordrhein-Westfalen', 'nordrhein-westfalen'),
(1329, 82, 'Rheinland-Pfalz', 'rheinland-pfalz'),
(1330, 82, 'Saarland', 'saarland'),
(1331, 82, 'Sachsen', 'sachsen'),
(1332, 82, 'Sachsen-Anhalt', 'sachsen-anhalt'),
(1333, 82, 'Schleswig-Holstein', 'schleswig-holstein'),
(1334, 82, 'Thüringen', 'thuringen'),
(1335, 83, 'Ashanti Region', 'ashanti-region'),
(1336, 83, 'Brong-Ahafo Region', 'brong-ahafo-region'),
(1337, 83, 'Central Region', 'central-region'),
(1338, 83, 'Eastern Region', 'eastern-region'),
(1339, 83, 'Greater Accra Region', 'greater-accra-region'),
(1340, 83, 'Northern Region', 'northern-region'),
(1341, 83, 'Upper East Region', 'upper-east-region'),
(1342, 83, 'Upper West Region', 'upper-west-region'),
(1343, 83, 'Volta Region', 'volta-region'),
(1344, 83, 'Western Region', 'western-region'),
(1345, 85, 'Attica', 'attica'),
(1346, 85, 'Central Greece', 'central-greece'),
(1347, 85, 'Central Macedonia', 'central-macedonia'),
(1348, 85, 'Crete', 'crete'),
(1349, 85, 'East Macedonia and Thrace', 'east-macedonia-and-thrace'),
(1350, 85, 'Epirus', 'epirus'),
(1351, 85, 'Ionian Islands', 'ionian-islands'),
(1352, 85, 'North Aegean', 'north-aegean'),
(1353, 85, 'Peloponnesos', 'peloponnesos'),
(1354, 85, 'South Aegean', 'south-aegean'),
(1355, 85, 'Thessaly', 'thessaly'),
(1356, 85, 'West Greece', 'west-greece'),
(1357, 85, 'West Macedonia', 'west-macedonia'),
(1358, 86, 'Avannaa', 'avannaa'),
(1359, 86, 'Tunu', 'tunu'),
(1360, 86, 'Kitaa', 'kitaa'),
(1361, 87, 'Saint Andrew', 'saint-andrew'),
(1362, 87, 'Saint David', 'saint-david'),
(1363, 87, 'Saint George', 'saint-george'),
(1364, 87, 'Saint John', 'saint-john'),
(1365, 87, 'Saint Mark', 'saint-mark'),
(1366, 87, 'Saint Patrick', 'saint-patrick'),
(1367, 87, 'Carriacou', 'carriacou'),
(1368, 87, 'Petit Martinique', 'petit-martinique'),
(1369, 90, 'Alta Verapaz', 'alta-verapaz'),
(1370, 90, 'Baja Verapaz', 'baja-verapaz'),
(1371, 90, 'Chimaltenango', 'chimaltenango'),
(1372, 90, 'Chiquimula', 'chiquimula'),
(1373, 90, 'El Peten', 'el-peten'),
(1374, 90, 'El Progreso', 'el-progreso'),
(1375, 90, 'El Quiche', 'el-quiche'),
(1376, 90, 'Escuintla', 'escuintla'),
(1377, 90, 'Guatemala', 'guatemala'),
(1378, 90, 'Huehuetenango', 'huehuetenango'),
(1379, 90, 'Izabal', 'izabal'),
(1380, 90, 'Jalapa', 'jalapa'),
(1381, 90, 'Jutiapa', 'jutiapa'),
(1382, 90, 'Quetzaltenango', 'quetzaltenango'),
(1383, 90, 'Retalhuleu', 'retalhuleu'),
(1384, 90, 'Sacatepequez', 'sacatepequez'),
(1385, 90, 'San Marcos', 'san-marcos'),
(1386, 90, 'Santa Rosa', 'santa-rosa'),
(1387, 90, 'Solola', 'solola'),
(1388, 90, 'Suchitepequez', 'suchitepequez'),
(1389, 90, 'Totonicapan', 'totonicapan'),
(1390, 90, 'Zacapa', 'zacapa');
INSERT INTO `cities` (`id`, `country_id`, `name`, `slug`) VALUES
(1391, 92, 'Conakry', 'conakry'),
(1392, 92, 'Beyla', 'beyla'),
(1393, 92, 'Boffa', 'boffa'),
(1394, 92, 'Boke', 'boke'),
(1395, 92, 'Coyah', 'coyah'),
(1396, 92, 'Dabola', 'dabola'),
(1397, 92, 'Dalaba', 'dalaba'),
(1398, 92, 'Dinguiraye', 'dinguiraye'),
(1399, 92, 'Dubreka', 'dubreka'),
(1400, 92, 'Faranah', 'faranah'),
(1401, 92, 'Forecariah', 'forecariah'),
(1402, 92, 'Fria', 'fria'),
(1403, 92, 'Gaoual', 'gaoual'),
(1404, 92, 'Gueckedou', 'gueckedou'),
(1405, 92, 'Kankan', 'kankan'),
(1406, 92, 'Kerouane', 'kerouane'),
(1407, 92, 'Kindia', 'kindia'),
(1408, 92, 'Kissidougou', 'kissidougou'),
(1409, 92, 'Koubia', 'koubia'),
(1410, 92, 'Koundara', 'koundara'),
(1411, 92, 'Kouroussa', 'kouroussa'),
(1412, 92, 'Labe', 'labe'),
(1413, 92, 'Lelouma', 'lelouma'),
(1414, 92, 'Lola', 'lola'),
(1415, 92, 'Macenta', 'macenta'),
(1416, 92, 'Mali', 'mali'),
(1417, 92, 'Mamou', 'mamou'),
(1418, 92, 'Mandiana', 'mandiana'),
(1419, 92, 'Nzerekore', 'nzerekore'),
(1420, 92, 'Pita', 'pita'),
(1421, 92, 'Siguiri', 'siguiri'),
(1422, 92, 'Telimele', 'telimele'),
(1423, 92, 'Tougue', 'tougue'),
(1424, 92, 'Yomou', 'yomou'),
(1425, 93, 'Bafata Region', 'bafata-region'),
(1426, 93, 'Biombo Region', 'biombo-region'),
(1427, 93, 'Bissau Region', 'bissau-region'),
(1428, 93, 'Bolama Region', 'bolama-region'),
(1429, 93, 'Cacheu Region', 'cacheu-region'),
(1430, 93, 'Gabu Region', 'gabu-region'),
(1431, 93, 'Oio Region', 'oio-region'),
(1432, 93, 'Quinara Region', 'quinara-region'),
(1433, 93, 'Tombali Region', 'tombali-region'),
(1434, 94, 'Barima-Waini', 'barima-waini'),
(1435, 94, 'Cuyuni-Mazaruni', 'cuyuni-mazaruni'),
(1436, 94, 'Demerara-Mahaica', 'demerara-mahaica'),
(1437, 94, 'East Berbice-Corentyne', 'east-berbice-corentyne'),
(1438, 94, 'Essequibo Islands-West Demerara', 'essequibo-islands-west-demerara'),
(1439, 94, 'Mahaica-Berbice', 'mahaica-berbice'),
(1440, 94, 'Pomeroon-Supenaam', 'pomeroon-supenaam'),
(1441, 94, 'Potaro-Siparuni', 'potaro-siparuni'),
(1442, 94, 'Upper Demerara-Berbice', 'upper-demerara-berbice'),
(1443, 94, 'Upper Takutu-Upper Essequibo', 'upper-takutu-upper-essequibo'),
(1444, 95, 'Artibonite', 'artibonite'),
(1445, 95, 'Centre', 'centre'),
(1446, 95, 'Grand\'Anse', 'grand-anse'),
(1447, 95, 'Nord', 'nord'),
(1448, 95, 'Nord-Est', 'nord-est'),
(1449, 95, 'Nord-Ouest', 'nord-ouest'),
(1450, 95, 'Ouest', 'ouest'),
(1451, 95, 'Sud', 'sud'),
(1452, 95, 'Sud-Est', 'sud-est'),
(1453, 96, 'Flat Island', 'flat-island'),
(1454, 96, 'McDonald Island', 'mcdonald-island'),
(1455, 96, 'Shag Island', 'shag-island'),
(1456, 96, 'Heard Island', 'heard-island'),
(1457, 98, 'Atlantida', 'atlantida'),
(1458, 98, 'Choluteca', 'choluteca'),
(1459, 98, 'Colon', 'colon'),
(1460, 98, 'Comayagua', 'comayagua'),
(1461, 98, 'Copan', 'copan'),
(1462, 98, 'Cortes', 'cortes'),
(1463, 98, 'El Paraiso', 'el-paraiso'),
(1464, 98, 'Francisco Morazan', 'francisco-morazan'),
(1465, 98, 'Gracias a Dios', 'gracias-a-dios'),
(1466, 98, 'Intibuca', 'intibuca'),
(1467, 98, 'Islas de la Bahia (Bay Islands)', 'islas-de-la-bahia-bay-islands'),
(1468, 98, 'La Paz', 'la-paz'),
(1469, 98, 'Lempira', 'lempira'),
(1470, 98, 'Ocotepeque', 'ocotepeque'),
(1471, 98, 'Olancho', 'olancho'),
(1472, 98, 'Santa Barbara', 'santa-barbara'),
(1473, 98, 'Valle', 'valle'),
(1474, 98, 'Yoro', 'yoro'),
(1475, 99, 'Central and Western Hong Kong Island', 'central-and-western-hong-kong-island'),
(1476, 99, 'Eastern Hong Kong Island', 'eastern-hong-kong-island'),
(1477, 99, 'Southern Hong Kong Island', 'southern-hong-kong-island'),
(1478, 99, 'Wan Chai Hong Kong Island', 'wan-chai-hong-kong-island'),
(1479, 99, 'Kowloon City Kowloon', 'kowloon-city-kowloon'),
(1480, 99, 'Kwun Tong Kowloon', 'kwun-tong-kowloon'),
(1481, 99, 'Sham Shui Po Kowloon', 'sham-shui-po-kowloon'),
(1482, 99, 'Wong Tai Sin Kowloon', 'wong-tai-sin-kowloon'),
(1483, 99, 'Yau Tsim Mong Kowloon', 'yau-tsim-mong-kowloon'),
(1484, 99, 'Islands New Territories', 'islands-new-territories'),
(1485, 99, 'Kwai Tsing New Territories', 'kwai-tsing-new-territories'),
(1486, 99, 'North New Territories', 'north-new-territories'),
(1487, 99, 'Sai Kung New Territories', 'sai-kung-new-territories'),
(1488, 99, 'Sha Tin New Territories', 'sha-tin-new-territories'),
(1489, 99, 'Tai Po New Territories', 'tai-po-new-territories'),
(1490, 99, 'Tsuen Wan New Territories', 'tsuen-wan-new-territories'),
(1491, 99, 'Tuen Mun New Territories', 'tuen-mun-new-territories'),
(1492, 99, 'Yuen Long New Territories', 'yuen-long-new-territories'),
(1493, 101, 'Austurland', 'austurland'),
(1494, 101, 'Hofuoborgarsvaeoi', 'hofuoborgarsvaeoi'),
(1495, 101, 'Norourland eystra', 'norourland-eystra'),
(1496, 101, 'Norourland vestra', 'norourland-vestra'),
(1497, 101, 'Suourland', 'suourland'),
(1498, 101, 'Suournes', 'suournes'),
(1499, 101, 'Vestfiroir', 'vestfiroir'),
(1500, 101, 'Vesturland', 'vesturland'),
(1501, 102, 'Andaman and Nicobar Islands', 'andaman-and-nicobar-islands'),
(1502, 102, 'Andhra Pradesh', 'andhra-pradesh'),
(1503, 102, 'Arunachal Pradesh', 'arunachal-pradesh'),
(1504, 102, 'Assam', 'assam'),
(1505, 102, 'Bihar', 'bihar'),
(1506, 102, 'Chandigarh', 'chandigarh'),
(1507, 102, 'Dadra and Nagar Haveli', 'dadra-and-nagar-haveli'),
(1508, 102, 'Daman and Diu', 'daman-and-diu'),
(1509, 102, 'Delhi', 'delhi'),
(1510, 102, 'Goa', 'goa'),
(1511, 102, 'Gujarat', 'gujarat'),
(1512, 102, 'Haryana', 'haryana'),
(1513, 102, 'Himachal Pradesh', 'himachal-pradesh'),
(1514, 102, 'Jammu and Kashmir', 'jammu-and-kashmir'),
(1515, 102, 'Karnataka', 'karnataka'),
(1516, 102, 'Kerala', 'kerala'),
(1517, 102, 'Lakshadweep Islands', 'lakshadweep-islands'),
(1518, 102, 'Madhya Pradesh', 'madhya-pradesh'),
(1519, 102, 'Maharashtra', 'maharashtra'),
(1520, 102, 'Manipur', 'manipur'),
(1521, 102, 'Meghalaya', 'meghalaya'),
(1522, 102, 'Mizoram', 'mizoram'),
(1523, 102, 'Nagaland', 'nagaland'),
(1524, 102, 'Orissa', 'orissa'),
(1525, 102, 'Puducherry', 'puducherry'),
(1526, 102, 'Punjab', 'punjab'),
(1527, 102, 'Rajasthan', 'rajasthan'),
(1528, 102, 'Sikkim', 'sikkim'),
(1529, 102, 'Tamil Nadu', 'tamil-nadu'),
(1530, 102, 'Tripura', 'tripura'),
(1531, 102, 'Uttar Pradesh', 'uttar-pradesh'),
(1532, 102, 'West Bengal', 'west-bengal'),
(1533, 102, 'Telangana', 'telangana'),
(1534, 103, 'Aceh', 'aceh'),
(1535, 103, 'Bali', 'bali'),
(1536, 103, 'Banten', 'banten'),
(1537, 103, 'Bengkulu', 'bengkulu'),
(1538, 103, 'Kalimantan Utara', 'kalimantan-utara'),
(1539, 103, 'Gorontalo', 'gorontalo'),
(1540, 103, 'Jakarta', 'jakarta'),
(1541, 103, 'Jambi', 'jambi'),
(1542, 103, 'Jawa Barat', 'jawa-barat'),
(1543, 103, 'Jawa Tengah', 'jawa-tengah'),
(1544, 103, 'Jawa Timur', 'jawa-timur'),
(1545, 103, 'Kalimantan Barat', 'kalimantan-barat'),
(1546, 103, 'Kalimantan Selatan', 'kalimantan-selatan'),
(1547, 103, 'Kalimantan Tengah', 'kalimantan-tengah'),
(1548, 103, 'Kalimantan Timur', 'kalimantan-timur'),
(1549, 103, 'Kepulauan Bangka Belitung', 'kepulauan-bangka-belitung'),
(1550, 103, 'Lampung', 'lampung'),
(1551, 103, 'Maluku', 'maluku'),
(1552, 103, 'Maluku Utara', 'maluku-utara'),
(1553, 103, 'Nusa Tenggara Barat', 'nusa-tenggara-barat'),
(1554, 103, 'Nusa Tenggara Timur', 'nusa-tenggara-timur'),
(1555, 103, 'Papua', 'papua'),
(1556, 103, 'Riau', 'riau'),
(1557, 103, 'Sulawesi Selatan', 'sulawesi-selatan'),
(1558, 103, 'Sulawesi Tengah', 'sulawesi-tengah'),
(1559, 103, 'Sulawesi Tenggara', 'sulawesi-tenggara'),
(1560, 103, 'Sulawesi Utara', 'sulawesi-utara'),
(1561, 103, 'Sumatera Barat', 'sumatera-barat'),
(1562, 103, 'Sumatera Selatan', 'sumatera-selatan'),
(1563, 103, 'Sumatera Utara', 'sumatera-utara'),
(1564, 103, 'Yogyakarta', 'yogyakarta'),
(1565, 103, 'Papua Barat', 'papua-barat'),
(1566, 103, 'Sulawesi Barat', 'sulawesi-barat'),
(1567, 103, 'Kepulauan Riau', 'kepulauan-riau'),
(1568, 104, 'Tehran', 'tehran'),
(1569, 104, 'Qom', 'qom'),
(1570, 104, 'Markazi', 'markazi'),
(1571, 104, 'Qazvin', 'qazvin'),
(1572, 104, 'Gilan', 'gilan'),
(1573, 104, 'Ardabil', 'ardabil'),
(1574, 104, 'Zanjan', 'zanjan'),
(1575, 104, 'East Azarbaijan', 'east-azarbaijan'),
(1576, 104, 'West Azarbaijan', 'west-azarbaijan'),
(1577, 104, 'Kurdistan', 'kurdistan'),
(1578, 104, 'Hamadan', 'hamadan'),
(1579, 104, 'Kermanshah', 'kermanshah'),
(1580, 104, 'Ilam', 'ilam'),
(1581, 104, 'Lorestan', 'lorestan'),
(1582, 104, 'Khuzestan', 'khuzestan'),
(1583, 104, 'Chahar Mahaal and Bakhtiari', 'chahar-mahaal-and-bakhtiari'),
(1584, 104, 'Kohkiluyeh and Buyer Ahmad', 'kohkiluyeh-and-buyer-ahmad'),
(1585, 104, 'Bushehr', 'bushehr'),
(1586, 104, 'Fars', 'fars'),
(1587, 104, 'Hormozgan', 'hormozgan'),
(1588, 104, 'Sistan and Baluchistan', 'sistan-and-baluchistan'),
(1589, 104, 'Kerman', 'kerman'),
(1590, 104, 'Yazd', 'yazd'),
(1591, 104, 'Esfahan', 'esfahan'),
(1592, 104, 'Semnan', 'semnan'),
(1593, 104, 'Mazandaran', 'mazandaran'),
(1594, 104, 'Golestan', 'golestan'),
(1595, 104, 'North Khorasan', 'north-khorasan'),
(1596, 104, 'Razavi Khorasan', 'razavi-khorasan'),
(1597, 104, 'South Khorasan', 'south-khorasan'),
(1598, 104, 'Alborz', 'alborz'),
(1599, 105, 'Baghdad', 'baghdad'),
(1600, 105, 'Salah ad Din', 'salah-ad-din'),
(1601, 105, 'Diyala', 'diyala'),
(1602, 105, 'Wasit', 'wasit'),
(1603, 105, 'Maysan', 'maysan'),
(1604, 105, 'Al Basrah', 'al-basrah'),
(1605, 105, 'Dhi Qar', 'dhi-qar'),
(1606, 105, 'Al Muthanna', 'al-muthanna'),
(1607, 105, 'Al Qadisyah', 'al-qadisyah'),
(1608, 105, 'Babil', 'babil'),
(1609, 105, 'Al Karbala', 'al-karbala'),
(1610, 105, 'An Najaf', 'an-najaf'),
(1611, 105, 'Al Anbar', 'al-anbar'),
(1612, 105, 'Ninawa', 'ninawa'),
(1613, 105, 'Dahuk', 'dahuk'),
(1614, 105, 'Arbil', 'arbil'),
(1615, 105, 'At Ta\'mim', 'at-ta-mim'),
(1616, 105, 'As Sulaymaniyah', 'as-sulaymaniyah'),
(1617, 106, 'Carlow', 'carlow'),
(1618, 106, 'Cavan', 'cavan'),
(1619, 106, 'Clare', 'clare'),
(1620, 106, 'Cork', 'cork'),
(1621, 106, 'Donegal', 'donegal'),
(1622, 106, 'Dublin', 'dublin'),
(1623, 106, 'Galway', 'galway'),
(1624, 106, 'Kerry', 'kerry'),
(1625, 106, 'Kildare', 'kildare'),
(1626, 106, 'Kilkenny', 'kilkenny'),
(1627, 106, 'Laois', 'laois'),
(1628, 106, 'Leitrim', 'leitrim'),
(1629, 106, 'Limerick', 'limerick'),
(1630, 106, 'Longford', 'longford'),
(1631, 106, 'Louth', 'louth'),
(1632, 106, 'Mayo', 'mayo'),
(1633, 106, 'Meath', 'meath'),
(1634, 106, 'Monaghan', 'monaghan'),
(1635, 106, 'Offaly', 'offaly'),
(1636, 106, 'Roscommon', 'roscommon'),
(1637, 106, 'Sligo', 'sligo'),
(1638, 106, 'Tipperary', 'tipperary'),
(1639, 106, 'Waterford', 'waterford'),
(1640, 106, 'Westmeath', 'westmeath'),
(1641, 106, 'Wexford', 'wexford'),
(1642, 106, 'Wicklow', 'wicklow'),
(1643, 108, 'Be\'er Sheva', 'be-er-sheva'),
(1644, 108, 'Bika\'at Hayarden', 'bika-at-hayarden'),
(1645, 108, 'Eilat and Arava', 'eilat-and-arava'),
(1646, 108, 'Galil', 'galil'),
(1647, 108, 'Haifa', 'haifa'),
(1648, 108, 'Jehuda Mountains', 'jehuda-mountains'),
(1649, 108, 'Jerusalem', 'jerusalem'),
(1650, 108, 'Negev', 'negev'),
(1651, 108, 'Semaria', 'semaria'),
(1652, 108, 'Sharon', 'sharon'),
(1653, 108, 'Tel Aviv (Gosh Dan)', 'tel-aviv-gosh-dan'),
(1654, 109, 'Agrigento', 'agrigento'),
(1655, 109, 'Alessandria', 'alessandria'),
(1656, 109, 'Ancona', 'ancona'),
(1657, 109, 'Aosta', 'aosta'),
(1658, 109, 'Arezzo', 'arezzo'),
(1659, 109, 'Ascoli Piceno', 'ascoli-piceno'),
(1660, 109, 'Asti', 'asti'),
(1661, 109, 'Avellino', 'avellino'),
(1662, 109, 'Bari', 'bari'),
(1663, 109, 'Belluno', 'belluno'),
(1664, 109, 'Benevento', 'benevento'),
(1665, 109, 'Bergamo', 'bergamo'),
(1666, 109, 'Biella', 'biella'),
(1667, 109, 'Bologna', 'bologna'),
(1668, 109, 'Bolzano', 'bolzano'),
(1669, 109, 'Brescia', 'brescia'),
(1670, 109, 'Brindisi', 'brindisi'),
(1671, 109, 'Cagliari', 'cagliari'),
(1672, 109, 'Caltanissetta', 'caltanissetta'),
(1673, 109, 'Campobasso', 'campobasso'),
(1674, 109, 'Caserta', 'caserta'),
(1675, 109, 'Catania', 'catania'),
(1676, 109, 'Catanzaro', 'catanzaro'),
(1677, 109, 'Chieti', 'chieti'),
(1678, 109, 'Como', 'como'),
(1679, 109, 'Cosenza', 'cosenza'),
(1680, 109, 'Cremona', 'cremona'),
(1681, 109, 'Crotone', 'crotone'),
(1682, 109, 'Cuneo', 'cuneo'),
(1683, 109, 'Enna', 'enna'),
(1684, 109, 'Ferrara', 'ferrara'),
(1685, 109, 'Firenze', 'firenze'),
(1686, 109, 'Foggia', 'foggia'),
(1687, 109, 'Forli-Cesena', 'forli-cesena'),
(1688, 109, 'Frosinone', 'frosinone'),
(1689, 109, 'Genova', 'genova'),
(1690, 109, 'Gorizia', 'gorizia'),
(1691, 109, 'Grosseto', 'grosseto'),
(1692, 109, 'Imperia', 'imperia'),
(1693, 109, 'Isernia', 'isernia'),
(1694, 109, 'L&#39;Aquila', 'l-39-aquila'),
(1695, 109, 'La Spezia', 'la-spezia'),
(1696, 109, 'Latina', 'latina'),
(1697, 109, 'Lecce', 'lecce'),
(1698, 109, 'Lecco', 'lecco'),
(1699, 109, 'Livorno', 'livorno'),
(1700, 109, 'Lodi', 'lodi'),
(1701, 109, 'Lucca', 'lucca'),
(1702, 109, 'Macerata', 'macerata'),
(1703, 109, 'Mantova', 'mantova'),
(1704, 109, 'Massa-Carrara', 'massa-carrara'),
(1705, 109, 'Matera', 'matera'),
(1706, 109, 'Messina', 'messina'),
(1707, 109, 'Milano', 'milano'),
(1708, 109, 'Modena', 'modena'),
(1709, 109, 'Napoli', 'napoli'),
(1710, 109, 'Novara', 'novara'),
(1711, 109, 'Nuoro', 'nuoro'),
(1712, 109, 'Oristano', 'oristano'),
(1713, 109, 'Padova', 'padova'),
(1714, 109, 'Palermo', 'palermo'),
(1715, 109, 'Parma', 'parma'),
(1716, 109, 'Pavia', 'pavia'),
(1717, 109, 'Perugia', 'perugia'),
(1718, 109, 'Pesaro e Urbino', 'pesaro-e-urbino'),
(1719, 109, 'Pescara', 'pescara'),
(1720, 109, 'Piacenza', 'piacenza'),
(1721, 109, 'Pisa', 'pisa'),
(1722, 109, 'Pistoia', 'pistoia'),
(1723, 109, 'Pordenone', 'pordenone'),
(1724, 109, 'Potenza', 'potenza'),
(1725, 109, 'Prato', 'prato'),
(1726, 109, 'Ragusa', 'ragusa'),
(1727, 109, 'Ravenna', 'ravenna'),
(1728, 109, 'Reggio Calabria', 'reggio-calabria'),
(1729, 109, 'Reggio Emilia', 'reggio-emilia'),
(1730, 109, 'Rieti', 'rieti'),
(1731, 109, 'Rimini', 'rimini'),
(1732, 109, 'Roma', 'roma'),
(1733, 109, 'Rovigo', 'rovigo'),
(1734, 109, 'Salerno', 'salerno'),
(1735, 109, 'Sassari', 'sassari'),
(1736, 109, 'Savona', 'savona'),
(1737, 109, 'Siena', 'siena'),
(1738, 109, 'Siracusa', 'siracusa'),
(1739, 109, 'Sondrio', 'sondrio'),
(1740, 109, 'Taranto', 'taranto'),
(1741, 109, 'Teramo', 'teramo'),
(1742, 109, 'Terni', 'terni'),
(1743, 109, 'Torino', 'torino'),
(1744, 109, 'Trapani', 'trapani'),
(1745, 109, 'Trento', 'trento'),
(1746, 109, 'Treviso', 'treviso'),
(1747, 109, 'Trieste', 'trieste'),
(1748, 109, 'Udine', 'udine'),
(1749, 109, 'Varese', 'varese'),
(1750, 109, 'Venezia', 'venezia'),
(1751, 109, 'Verbano-Cusio-Ossola', 'verbano-cusio-ossola'),
(1752, 109, 'Vercelli', 'vercelli'),
(1753, 109, 'Verona', 'verona'),
(1754, 109, 'Vibo Valentia', 'vibo-valentia'),
(1755, 109, 'Vicenza', 'vicenza'),
(1756, 109, 'Viterbo', 'viterbo'),
(1757, 109, 'Barletta-Andria-Trani', 'barletta-andria-trani'),
(1758, 109, 'Fermo', 'fermo'),
(1759, 109, 'Monza Brianza', 'monza-brianza'),
(1760, 110, 'Clarendon Parish', 'clarendon-parish'),
(1761, 110, 'Hanover Parish', 'hanover-parish'),
(1762, 110, 'Kingston Parish', 'kingston-parish'),
(1763, 110, 'Manchester Parish', 'manchester-parish'),
(1764, 110, 'Portland Parish', 'portland-parish'),
(1765, 110, 'Saint Andrew Parish', 'saint-andrew-parish'),
(1766, 110, 'Saint Ann Parish', 'saint-ann-parish'),
(1767, 110, 'Saint Catherine Parish', 'saint-catherine-parish'),
(1768, 110, 'Saint Elizabeth Parish', 'saint-elizabeth-parish'),
(1769, 110, 'Saint James Parish', 'saint-james-parish'),
(1770, 110, 'Saint Mary Parish', 'saint-mary-parish'),
(1771, 110, 'Saint Thomas Parish', 'saint-thomas-parish'),
(1772, 110, 'Trelawny Parish', 'trelawny-parish'),
(1773, 110, 'Westmoreland Parish', 'westmoreland-parish'),
(1774, 111, 'Aichi', 'aichi'),
(1775, 111, 'Akita', 'akita'),
(1776, 111, 'Aomori', 'aomori'),
(1777, 111, 'Chiba', 'chiba'),
(1778, 111, 'Ehime', 'ehime'),
(1779, 111, 'Fukui', 'fukui'),
(1780, 111, 'Fukuoka', 'fukuoka'),
(1781, 111, 'Fukushima', 'fukushima'),
(1782, 111, 'Gifu', 'gifu'),
(1783, 111, 'Gumma', 'gumma'),
(1784, 111, 'Hiroshima', 'hiroshima'),
(1785, 111, 'Hokkaido', 'hokkaido'),
(1786, 111, 'Hyogo', 'hyogo'),
(1787, 111, 'Ibaraki', 'ibaraki'),
(1788, 111, 'Ishikawa', 'ishikawa'),
(1789, 111, 'Iwate', 'iwate'),
(1790, 111, 'Kagawa', 'kagawa'),
(1791, 111, 'Kagoshima', 'kagoshima'),
(1792, 111, 'Kanagawa', 'kanagawa'),
(1793, 111, 'Kochi', 'kochi'),
(1794, 111, 'Kumamoto', 'kumamoto'),
(1795, 111, 'Kyoto', 'kyoto'),
(1796, 111, 'Mie', 'mie'),
(1797, 111, 'Miyagi', 'miyagi'),
(1798, 111, 'Miyazaki', 'miyazaki'),
(1799, 111, 'Nagano', 'nagano'),
(1800, 111, 'Nagasaki', 'nagasaki'),
(1801, 111, 'Nara', 'nara'),
(1802, 111, 'Niigata', 'niigata'),
(1803, 111, 'Oita', 'oita'),
(1804, 111, 'Okayama', 'okayama'),
(1805, 111, 'Okinawa', 'okinawa'),
(1806, 111, 'Osaka', 'osaka'),
(1807, 111, 'Saga', 'saga'),
(1808, 111, 'Saitama', 'saitama'),
(1809, 111, 'Shiga', 'shiga'),
(1810, 111, 'Shimane', 'shimane'),
(1811, 111, 'Shizuoka', 'shizuoka'),
(1812, 111, 'Tochigi', 'tochigi'),
(1813, 111, 'Tokushima', 'tokushima'),
(1814, 111, 'Tokyo', 'tokyo'),
(1815, 111, 'Tottori', 'tottori'),
(1816, 111, 'Toyama', 'toyama'),
(1817, 111, 'Wakayama', 'wakayama'),
(1818, 111, 'Yamagata', 'yamagata'),
(1819, 111, 'Yamaguchi', 'yamaguchi'),
(1820, 111, 'Yamanashi', 'yamanashi'),
(1821, 113, '\'Amman', 'amman'),
(1822, 113, 'Ajlun', 'ajlun'),
(1823, 113, 'Al \'Aqabah', 'al-aqabah'),
(1824, 113, 'Al Balqa\'', 'al-balqa'),
(1825, 113, 'Al Karak', 'al-karak'),
(1826, 113, 'Al Mafraq', 'al-mafraq'),
(1827, 113, 'At Tafilah', 'at-tafilah'),
(1828, 113, 'Az Zarqa\'', 'az-zarqa'),
(1829, 113, 'Irbid', 'irbid'),
(1830, 113, 'Jarash', 'jarash'),
(1831, 113, 'Ma\'an', 'ma-an'),
(1832, 113, 'Madaba', 'madaba'),
(1833, 114, 'Almaty', 'almaty'),
(1834, 114, 'Almaty City', 'almaty-city'),
(1835, 114, 'Aqmola', 'aqmola'),
(1836, 114, 'Aqtobe', 'aqtobe'),
(1837, 114, 'Astana City', 'astana-city'),
(1838, 114, 'Atyrau', 'atyrau'),
(1839, 114, 'Batys Qazaqstan', 'batys-qazaqstan'),
(1840, 114, 'Bayqongyr City', 'bayqongyr-city'),
(1841, 114, 'Mangghystau', 'mangghystau'),
(1842, 114, 'Ongtustik Qazaqstan', 'ongtustik-qazaqstan'),
(1843, 114, 'Pavlodar', 'pavlodar'),
(1844, 114, 'Qaraghandy', 'qaraghandy'),
(1845, 114, 'Qostanay', 'qostanay'),
(1846, 114, 'Qyzylorda', 'qyzylorda'),
(1847, 114, 'Shyghys Qazaqstan', 'shyghys-qazaqstan'),
(1848, 114, 'Soltustik Qazaqstan', 'soltustik-qazaqstan'),
(1849, 114, 'Zhambyl', 'zhambyl'),
(1850, 115, 'Central', 'central'),
(1851, 115, 'Coast', 'coast'),
(1852, 115, 'Eastern', 'eastern'),
(1853, 115, 'Nairobi Area', 'nairobi-area'),
(1854, 115, 'North Eastern', 'north-eastern'),
(1855, 115, 'Nyanza', 'nyanza'),
(1856, 115, 'Rift Valley', 'rift-valley'),
(1857, 115, 'Western', 'western'),
(1858, 116, 'Abaiang', 'abaiang'),
(1859, 116, 'Abemama', 'abemama'),
(1860, 116, 'Aranuka', 'aranuka'),
(1861, 116, 'Arorae', 'arorae'),
(1862, 116, 'Banaba', 'banaba'),
(1863, 116, 'Beru', 'beru'),
(1864, 116, 'Butaritari', 'butaritari'),
(1865, 116, 'Kanton', 'kanton'),
(1866, 116, 'Kiritimati', 'kiritimati'),
(1867, 116, 'Kuria', 'kuria'),
(1868, 116, 'Maiana', 'maiana'),
(1869, 116, 'Makin', 'makin'),
(1870, 116, 'Marakei', 'marakei'),
(1871, 116, 'Nikunau', 'nikunau'),
(1872, 116, 'Nonouti', 'nonouti'),
(1873, 116, 'Onotoa', 'onotoa'),
(1874, 116, 'Tabiteuea', 'tabiteuea'),
(1875, 116, 'Tabuaeran', 'tabuaeran'),
(1876, 116, 'Tamana', 'tamana'),
(1877, 116, 'Tarawa', 'tarawa'),
(1878, 116, 'Teraina', 'teraina'),
(1879, 117, 'Chagang-do', 'chagang-do'),
(1880, 117, 'Hamgyong-bukto', 'hamgyong-bukto'),
(1881, 117, 'Hamgyong-namdo', 'hamgyong-namdo'),
(1882, 117, 'Hwanghae-bukto', 'hwanghae-bukto'),
(1883, 117, 'Hwanghae-namdo', 'hwanghae-namdo'),
(1884, 117, 'Kangwon-do', 'kangwon-do'),
(1885, 117, 'P\'yongan-bukto', 'p-yongan-bukto'),
(1886, 117, 'P\'yongan-namdo', 'p-yongan-namdo'),
(1887, 117, 'Ryanggang-do (Yanggang-do)', 'ryanggang-do-yanggang-do'),
(1888, 117, 'Rason Directly Governed City', 'rason-directly-governed-city'),
(1889, 117, 'P\'yongyang Special City', 'p-yongyang-special-city'),
(1890, 118, 'Ch\'ungch\'ong-bukto', 'ch-ungch-ong-bukto'),
(1891, 118, 'Ch\'ungch\'ong-namdo', 'ch-ungch-ong-namdo'),
(1892, 118, 'Cheju-do', 'cheju-do'),
(1893, 118, 'Cholla-bukto', 'cholla-bukto'),
(1894, 118, 'Cholla-namdo', 'cholla-namdo'),
(1895, 118, 'Inch\'on-gwangyoksi', 'inch-on-gwangyoksi'),
(1896, 118, 'Kangwon-do', 'kangwon-do'),
(1897, 118, 'Kwangju-gwangyoksi', 'kwangju-gwangyoksi'),
(1898, 118, 'Kyonggi-do', 'kyonggi-do'),
(1899, 118, 'Kyongsang-bukto', 'kyongsang-bukto'),
(1900, 118, 'Kyongsang-namdo', 'kyongsang-namdo'),
(1901, 118, 'Pusan-gwangyoksi', 'pusan-gwangyoksi'),
(1902, 118, 'Soul-t\'ukpyolsi', 'soul-t-ukpyolsi'),
(1903, 118, 'Taegu-gwangyoksi', 'taegu-gwangyoksi'),
(1904, 118, 'Taejon-gwangyoksi', 'taejon-gwangyoksi'),
(1905, 119, 'Al \'Asimah', 'al-asimah'),
(1906, 119, 'Al Ahmadi', 'al-ahmadi'),
(1907, 119, 'Al Farwaniyah', 'al-farwaniyah'),
(1908, 119, 'Al Jahra\'', 'al-jahra'),
(1909, 119, 'Hawalli', 'hawalli'),
(1910, 120, 'Bishkek', 'bishkek'),
(1911, 120, 'Batken', 'batken'),
(1912, 120, 'Chu', 'chu'),
(1913, 120, 'Jalal-Abad', 'jalal-abad'),
(1914, 120, 'Naryn', 'naryn'),
(1915, 120, 'Osh', 'osh'),
(1916, 120, 'Talas', 'talas'),
(1917, 120, 'Ysyk-Kol', 'ysyk-kol'),
(1918, 121, 'Vientiane', 'vientiane'),
(1919, 121, 'Attapu', 'attapu'),
(1920, 121, 'Bokeo', 'bokeo'),
(1921, 121, 'Bolikhamxai', 'bolikhamxai'),
(1922, 121, 'Champasak', 'champasak'),
(1923, 121, 'Houaphan', 'houaphan'),
(1924, 121, 'Khammouan', 'khammouan'),
(1925, 121, 'Louang Namtha', 'louang-namtha'),
(1926, 121, 'Louangphabang', 'louangphabang'),
(1927, 121, 'Oudomxai', 'oudomxai'),
(1928, 121, 'Phongsali', 'phongsali'),
(1929, 121, 'Salavan', 'salavan'),
(1930, 121, 'Savannakhet', 'savannakhet'),
(1931, 121, 'Vientiane', 'vientiane'),
(1932, 121, 'Xaignabouli', 'xaignabouli'),
(1933, 121, 'Xekong', 'xekong'),
(1934, 121, 'Xiangkhoang', 'xiangkhoang'),
(1935, 121, 'Xaisomboun', 'xaisomboun'),
(1936, 122, 'Ainaži, Salacgrīvas novads', 'ainazi-salacgrivas-novads'),
(1937, 122, 'Aizkraukle, Aizkraukles novads', 'aizkraukle-aizkraukles-novads'),
(1938, 122, 'Aizkraukles novads', 'aizkraukles-novads'),
(1939, 122, 'Aizpute, Aizputes novads', 'aizpute-aizputes-novads'),
(1940, 122, 'Aizputes novads', 'aizputes-novads'),
(1941, 122, 'Aknīste, Aknīstes novads', 'akniste-aknistes-novads'),
(1942, 122, 'Aknīstes novads', 'aknistes-novads'),
(1943, 122, 'Aloja, Alojas novads', 'aloja-alojas-novads'),
(1944, 122, 'Alojas novads', 'alojas-novads'),
(1945, 122, 'Alsungas novads', 'alsungas-novads'),
(1946, 122, 'Alūksne, Alūksnes novads', 'aluksne-aluksnes-novads'),
(1947, 122, 'Alūksnes novads', 'aluksnes-novads'),
(1948, 122, 'Amatas novads', 'amatas-novads'),
(1949, 122, 'Ape, Apes novads', 'ape-apes-novads'),
(1950, 122, 'Apes novads', 'apes-novads'),
(1951, 122, 'Auce, Auces novads', 'auce-auces-novads'),
(1952, 122, 'Auces novads', 'auces-novads'),
(1953, 122, 'Ādažu novads', 'adazu-novads'),
(1954, 122, 'Babītes novads', 'babites-novads'),
(1955, 122, 'Baldone, Baldones novads', 'baldone-baldones-novads'),
(1956, 122, 'Baldones novads', 'baldones-novads'),
(1957, 122, 'Baloži, Ķekavas novads', 'balozi-kekavas-novads'),
(1958, 122, 'Baltinavas novads', 'baltinavas-novads'),
(1959, 122, 'Balvi, Balvu novads', 'balvi-balvu-novads'),
(1960, 122, 'Balvu novads', 'balvu-novads'),
(1961, 122, 'Bauska, Bauskas novads', 'bauska-bauskas-novads'),
(1962, 122, 'Bauskas novads', 'bauskas-novads'),
(1963, 122, 'Beverīnas novads', 'beverinas-novads'),
(1964, 122, 'Brocēni, Brocēnu novads', 'broceni-brocenu-novads'),
(1965, 122, 'Brocēnu novads', 'brocenu-novads'),
(1966, 122, 'Burtnieku novads', 'burtnieku-novads'),
(1967, 122, 'Carnikavas novads', 'carnikavas-novads'),
(1968, 122, 'Cesvaine, Cesvaines novads', 'cesvaine-cesvaines-novads'),
(1969, 122, 'Cesvaines novads', 'cesvaines-novads'),
(1970, 122, 'Cēsis, Cēsu novads', 'cesis-cesu-novads'),
(1971, 122, 'Cēsu novads', 'cesu-novads'),
(1972, 122, 'Ciblas novads', 'ciblas-novads'),
(1973, 122, 'Dagda, Dagdas novads', 'dagda-dagdas-novads'),
(1974, 122, 'Dagdas novads', 'dagdas-novads'),
(1975, 122, 'Daugavpils', 'daugavpils'),
(1976, 122, 'Daugavpils novads', 'daugavpils-novads'),
(1977, 122, 'Dobele, Dobeles novads', 'dobele-dobeles-novads'),
(1978, 122, 'Dobeles novads', 'dobeles-novads'),
(1979, 122, 'Dundagas novads', 'dundagas-novads'),
(1980, 122, 'Durbe, Durbes novads', 'durbe-durbes-novads'),
(1981, 122, 'Durbes novads', 'durbes-novads'),
(1982, 122, 'Engures novads', 'engures-novads'),
(1983, 122, 'Ērgļu novads', 'erglu-novads'),
(1984, 122, 'Garkalnes novads', 'garkalnes-novads'),
(1985, 122, 'Grobiņa, Grobiņas novads', 'grobina-grobinas-novads'),
(1986, 122, 'Grobiņas novads', 'grobinas-novads'),
(1987, 122, 'Gulbene, Gulbenes novads', 'gulbene-gulbenes-novads'),
(1988, 122, 'Gulbenes novads', 'gulbenes-novads'),
(1989, 122, 'Iecavas novads', 'iecavas-novads'),
(1990, 122, 'Ikšķile, Ikšķiles novads', 'ikskile-ikskiles-novads'),
(1991, 122, 'Ikšķiles novads', 'ikskiles-novads'),
(1992, 122, 'Ilūkste, Ilūkstes novads', 'ilukste-ilukstes-novads'),
(1993, 122, 'Ilūkstes novads', 'ilukstes-novads'),
(1994, 122, 'Inčukalna novads', 'incukalna-novads'),
(1995, 122, 'Jaunjelgava, Jaunjelgavas novads', 'jaunjelgava-jaunjelgavas-novads'),
(1996, 122, 'Jaunjelgavas novads', 'jaunjelgavas-novads'),
(1997, 122, 'Jaunpiebalgas novads', 'jaunpiebalgas-novads'),
(1998, 122, 'Jaunpils novads', 'jaunpils-novads'),
(1999, 122, 'Jelgava', 'jelgava'),
(2000, 122, 'Jelgavas novads', 'jelgavas-novads'),
(2001, 122, 'Jēkabpils', 'jekabpils'),
(2002, 122, 'Jēkabpils novads', 'jekabpils-novads'),
(2003, 122, 'Jūrmala', 'jurmala'),
(2004, 122, 'Kalnciems, Jelgavas novads', 'kalnciems-jelgavas-novads'),
(2005, 122, 'Kandava, Kandavas novads', 'kandava-kandavas-novads'),
(2006, 122, 'Kandavas novads', 'kandavas-novads'),
(2007, 122, 'Kārsava, Kārsavas novads', 'karsava-karsavas-novads'),
(2008, 122, 'Kārsavas novads', 'karsavas-novads'),
(2009, 122, 'Kocēnu novads ,bij. Valmieras)', 'kocenu-novads-bij-valmieras'),
(2010, 122, 'Kokneses novads', 'kokneses-novads'),
(2011, 122, 'Krāslava, Krāslavas novads', 'kraslava-kraslavas-novads'),
(2012, 122, 'Krāslavas novads', 'kraslavas-novads'),
(2013, 122, 'Krimuldas novads', 'krimuldas-novads'),
(2014, 122, 'Krustpils novads', 'krustpils-novads'),
(2015, 122, 'Kuldīga, Kuldīgas novads', 'kuldiga-kuldigas-novads'),
(2016, 122, 'Kuldīgas novads', 'kuldigas-novads'),
(2017, 122, 'Ķeguma novads', 'keguma-novads'),
(2018, 122, 'Ķegums, Ķeguma novads', 'kegums-keguma-novads'),
(2019, 122, 'Ķekavas novads', 'kekavas-novads'),
(2020, 122, 'Lielvārde, Lielvārdes novads', 'lielvarde-lielvardes-novads'),
(2021, 122, 'Lielvārdes novads', 'lielvardes-novads'),
(2022, 122, 'Liepāja', 'liepaja'),
(2023, 122, 'Limbaži, Limbažu novads', 'limbazi-limbazu-novads'),
(2024, 122, 'Limbažu novads', 'limbazu-novads'),
(2025, 122, 'Līgatne, Līgatnes novads', 'ligatne-ligatnes-novads'),
(2026, 122, 'Līgatnes novads', 'ligatnes-novads'),
(2027, 122, 'Līvāni, Līvānu novads', 'livani-livanu-novads'),
(2028, 122, 'Līvānu novads', 'livanu-novads'),
(2029, 122, 'Lubāna, Lubānas novads', 'lubana-lubanas-novads'),
(2030, 122, 'Lubānas novads', 'lubanas-novads'),
(2031, 122, 'Ludza, Ludzas novads', 'ludza-ludzas-novads'),
(2032, 122, 'Ludzas novads', 'ludzas-novads'),
(2033, 122, 'Madona, Madonas novads', 'madona-madonas-novads'),
(2034, 122, 'Madonas novads', 'madonas-novads'),
(2035, 122, 'Mazsalaca, Mazsalacas novads', 'mazsalaca-mazsalacas-novads'),
(2036, 122, 'Mazsalacas novads', 'mazsalacas-novads'),
(2037, 122, 'Mālpils novads', 'malpils-novads'),
(2038, 122, 'Mārupes novads', 'marupes-novads'),
(2039, 122, 'Mērsraga novads', 'mersraga-novads'),
(2040, 122, 'Naukšēnu novads', 'nauksenu-novads'),
(2041, 122, 'Neretas novads', 'neretas-novads'),
(2042, 122, 'Nīcas novads', 'nicas-novads'),
(2043, 122, 'Ogre, Ogres novads', 'ogre-ogres-novads'),
(2044, 122, 'Ogres novads', 'ogres-novads'),
(2045, 122, 'Olaine, Olaines novads', 'olaine-olaines-novads'),
(2046, 122, 'Olaines novads', 'olaines-novads'),
(2047, 122, 'Ozolnieku novads', 'ozolnieku-novads'),
(2048, 122, 'Pārgaujas novads', 'pargaujas-novads'),
(2049, 122, 'Pāvilosta, Pāvilostas novads', 'pavilosta-pavilostas-novads'),
(2050, 122, 'Pāvilostas novads', 'pavilostas-novads'),
(2051, 122, 'Piltene, Ventspils novads', 'piltene-ventspils-novads'),
(2052, 122, 'Pļaviņas, Pļaviņu novads', 'plavinas-plavinu-novads'),
(2053, 122, 'Pļaviņu novads', 'plavinu-novads'),
(2054, 122, 'Preiļi, Preiļu novads', 'preili-preilu-novads'),
(2055, 122, 'Preiļu novads', 'preilu-novads'),
(2056, 122, 'Priekule, Priekules novads', 'priekule-priekules-novads'),
(2057, 122, 'Priekules novads', 'priekules-novads'),
(2058, 122, 'Priekuļu novads', 'priekulu-novads'),
(2059, 122, 'Raunas novads', 'raunas-novads'),
(2060, 122, 'Rēzekne', 'rezekne'),
(2061, 122, 'Rēzeknes novads', 'rezeknes-novads'),
(2062, 122, 'Riebiņu novads', 'riebinu-novads'),
(2063, 122, 'Rīga', 'riga'),
(2064, 122, 'Rojas novads', 'rojas-novads'),
(2065, 122, 'Ropažu novads', 'ropazu-novads'),
(2066, 122, 'Rucavas novads', 'rucavas-novads'),
(2067, 122, 'Rugāju novads', 'rugaju-novads'),
(2068, 122, 'Rundāles novads', 'rundales-novads'),
(2069, 122, 'Rūjiena, Rūjienas novads', 'rujiena-rujienas-novads'),
(2070, 122, 'Rūjienas novads', 'rujienas-novads'),
(2071, 122, 'Sabile, Talsu novads', 'sabile-talsu-novads'),
(2072, 122, 'Salacgrīva, Salacgrīvas novads', 'salacgriva-salacgrivas-novads'),
(2073, 122, 'Salacgrīvas novads', 'salacgrivas-novads'),
(2074, 122, 'Salas novads', 'salas-novads'),
(2075, 122, 'Salaspils novads', 'salaspils-novads'),
(2076, 122, 'Salaspils, Salaspils novads', 'salaspils-salaspils-novads'),
(2077, 122, 'Saldus novads', 'saldus-novads'),
(2078, 122, 'Saldus, Saldus novads', 'saldus-saldus-novads'),
(2079, 122, 'Saulkrasti, Saulkrastu novads', 'saulkrasti-saulkrastu-novads'),
(2080, 122, 'Saulkrastu novads', 'saulkrastu-novads'),
(2081, 122, 'Seda, Strenču novads', 'seda-strencu-novads'),
(2082, 122, 'Sējas novads', 'sejas-novads'),
(2083, 122, 'Sigulda, Siguldas novads', 'sigulda-siguldas-novads'),
(2084, 122, 'Siguldas novads', 'siguldas-novads'),
(2085, 122, 'Skrīveru novads', 'skriveru-novads'),
(2086, 122, 'Skrunda, Skrundas novads', 'skrunda-skrundas-novads'),
(2087, 122, 'Skrundas novads', 'skrundas-novads'),
(2088, 122, 'Smiltene, Smiltenes novads', 'smiltene-smiltenes-novads'),
(2089, 122, 'Smiltenes novads', 'smiltenes-novads'),
(2090, 122, 'Staicele, Alojas novads', 'staicele-alojas-novads'),
(2091, 122, 'Stende, Talsu novads', 'stende-talsu-novads'),
(2092, 122, 'Stopiņu novads', 'stopinu-novads'),
(2093, 122, 'Strenči, Strenču novads', 'strenci-strencu-novads'),
(2094, 122, 'Strenču novads', 'strencu-novads'),
(2095, 122, 'Subate, Ilūkstes novads', 'subate-ilukstes-novads'),
(2096, 122, 'Talsi, Talsu novads', 'talsi-talsu-novads'),
(2097, 122, 'Talsu novads', 'talsu-novads'),
(2098, 122, 'Tērvetes novads', 'tervetes-novads'),
(2099, 122, 'Tukuma novads', 'tukuma-novads'),
(2100, 122, 'Tukums, Tukuma novads', 'tukums-tukuma-novads'),
(2101, 122, 'Vaiņodes novads', 'vainodes-novads'),
(2102, 122, 'Valdemārpils, Talsu novads', 'valdemarpils-talsu-novads'),
(2103, 122, 'Valka, Valkas novads', 'valka-valkas-novads'),
(2104, 122, 'Valkas novads', 'valkas-novads'),
(2105, 122, 'Valmiera', 'valmiera'),
(2106, 122, 'Vangaži, Inčukalna novads', 'vangazi-incukalna-novads'),
(2107, 122, 'Varakļāni, Varakļānu novads', 'varaklani-varaklanu-novads'),
(2108, 122, 'Varakļānu novads', 'varaklanu-novads'),
(2109, 122, 'Vārkavas novads', 'varkavas-novads'),
(2110, 122, 'Vecpiebalgas novads', 'vecpiebalgas-novads'),
(2111, 122, 'Vecumnieku novads', 'vecumnieku-novads'),
(2112, 122, 'Ventspils', 'ventspils'),
(2113, 122, 'Ventspils novads', 'ventspils-novads'),
(2114, 122, 'Viesīte, Viesītes novads', 'viesite-viesites-novads'),
(2115, 122, 'Viesītes novads', 'viesites-novads'),
(2116, 122, 'Viļaka, Viļakas novads', 'vilaka-vilakas-novads'),
(2117, 122, 'Viļakas novads', 'vilakas-novads'),
(2118, 122, 'Viļāni, Viļānu novads', 'vilani-vilanu-novads'),
(2119, 122, 'Viļānu novads', 'vilanu-novads'),
(2120, 122, 'Zilupe, Zilupes novads', 'zilupe-zilupes-novads'),
(2121, 122, 'Zilupes novads', 'zilupes-novads'),
(2122, 123, 'Beirut', 'beirut'),
(2123, 123, 'Bekaa', 'bekaa'),
(2124, 123, 'Mount Lebanon', 'mount-lebanon'),
(2125, 123, 'Nabatieh', 'nabatieh'),
(2126, 123, 'North', 'north'),
(2127, 123, 'South', 'south'),
(2128, 124, 'Berea', 'berea'),
(2129, 124, 'Butha-Buthe', 'butha-buthe'),
(2130, 124, 'Leribe', 'leribe'),
(2131, 124, 'Mafeteng', 'mafeteng'),
(2132, 124, 'Maseru', 'maseru'),
(2133, 124, 'Mohale\'s Hoek', 'mohale-s-hoek'),
(2134, 124, 'Mokhotlong', 'mokhotlong'),
(2135, 124, 'Qacha\'s Nek', 'qacha-s-nek'),
(2136, 124, 'Quthing', 'quthing'),
(2137, 124, 'Thaba-Tseka', 'thaba-tseka'),
(2138, 125, 'Bomi', 'bomi'),
(2139, 125, 'Bong', 'bong'),
(2140, 125, 'Grand Bassa', 'grand-bassa'),
(2141, 125, 'Grand Cape Mount', 'grand-cape-mount'),
(2142, 125, 'Grand Gedeh', 'grand-gedeh'),
(2143, 125, 'Grand Kru', 'grand-kru'),
(2144, 125, 'Lofa', 'lofa'),
(2145, 125, 'Margibi', 'margibi'),
(2146, 125, 'Maryland', 'maryland'),
(2147, 125, 'Montserrado', 'montserrado'),
(2148, 125, 'Nimba', 'nimba'),
(2149, 125, 'River Cess', 'river-cess'),
(2150, 125, 'Sinoe', 'sinoe'),
(2151, 126, 'Ajdabiya', 'ajdabiya'),
(2152, 126, 'Al \'Aziziyah', 'al-aziziyah'),
(2153, 126, 'Al Fatih', 'al-fatih'),
(2154, 126, 'Al Jabal al Akhdar', 'al-jabal-al-akhdar'),
(2155, 126, 'Al Jufrah', 'al-jufrah'),
(2156, 126, 'Al Khums', 'al-khums'),
(2157, 126, 'Al Kufrah', 'al-kufrah'),
(2158, 126, 'An Nuqat al Khams', 'an-nuqat-al-khams'),
(2159, 126, 'Ash Shati\'', 'ash-shati'),
(2160, 126, 'Awbari', 'awbari'),
(2161, 126, 'Az Zawiyah', 'az-zawiyah'),
(2162, 126, 'Banghazi', 'banghazi'),
(2163, 126, 'Darnah', 'darnah'),
(2164, 126, 'Ghadamis', 'ghadamis'),
(2165, 126, 'Gharyan', 'gharyan'),
(2166, 126, 'Misratah', 'misratah'),
(2167, 126, 'Murzuq', 'murzuq'),
(2168, 126, 'Sabha', 'sabha'),
(2169, 126, 'Sawfajjin', 'sawfajjin'),
(2170, 126, 'Surt', 'surt'),
(2171, 126, 'Tarabulus (Tripoli)', 'tarabulus-tripoli'),
(2172, 126, 'Tarhunah', 'tarhunah'),
(2173, 126, 'Tubruq', 'tubruq'),
(2174, 126, 'Yafran', 'yafran'),
(2175, 126, 'Zlitan', 'zlitan'),
(2176, 127, 'Vaduz', 'vaduz'),
(2177, 127, 'Schaan', 'schaan'),
(2178, 127, 'Balzers', 'balzers'),
(2179, 127, 'Triesen', 'triesen'),
(2180, 127, 'Eschen', 'eschen'),
(2181, 127, 'Mauren', 'mauren'),
(2182, 127, 'Triesenberg', 'triesenberg'),
(2183, 127, 'Ruggell', 'ruggell'),
(2184, 127, 'Gamprin', 'gamprin'),
(2185, 127, 'Schellenberg', 'schellenberg'),
(2186, 127, 'Planken', 'planken'),
(2187, 128, 'Alytus', 'alytus'),
(2188, 128, 'Kaunas', 'kaunas'),
(2189, 128, 'Klaipeda', 'klaipeda'),
(2190, 128, 'Marijampole', 'marijampole'),
(2191, 128, 'Panevezys', 'panevezys'),
(2192, 128, 'Siauliai', 'siauliai'),
(2193, 128, 'Taurage', 'taurage'),
(2194, 128, 'Telsiai', 'telsiai'),
(2195, 128, 'Utena', 'utena'),
(2196, 128, 'Vilnius', 'vilnius'),
(2197, 129, 'Diekirch', 'diekirch'),
(2198, 129, 'Clervaux', 'clervaux'),
(2199, 129, 'Redange', 'redange'),
(2200, 129, 'Vianden', 'vianden'),
(2201, 129, 'Wiltz', 'wiltz'),
(2202, 129, 'Grevenmacher', 'grevenmacher'),
(2203, 129, 'Echternach', 'echternach'),
(2204, 129, 'Remich', 'remich'),
(2205, 129, 'Luxembourg', 'luxembourg'),
(2206, 129, 'Capellen', 'capellen'),
(2207, 129, 'Esch-sur-Alzette', 'esch-sur-alzette'),
(2208, 129, 'Mersch', 'mersch'),
(2209, 130, 'Our Lady Fatima Parish', 'our-lady-fatima-parish'),
(2210, 130, 'St. Anthony Parish', 'st-anthony-parish'),
(2211, 130, 'St. Lazarus Parish', 'st-lazarus-parish'),
(2212, 130, 'Cathedral Parish', 'cathedral-parish'),
(2213, 130, 'St. Lawrence Parish', 'st-lawrence-parish'),
(2214, 132, 'Antananarivo', 'antananarivo'),
(2215, 132, 'Antsiranana', 'antsiranana'),
(2216, 132, 'Fianarantsoa', 'fianarantsoa'),
(2217, 132, 'Mahajanga', 'mahajanga'),
(2218, 132, 'Toamasina', 'toamasina'),
(2219, 132, 'Toliara', 'toliara'),
(2220, 133, 'Balaka', 'balaka'),
(2221, 133, 'Blantyre', 'blantyre'),
(2222, 133, 'Chikwawa', 'chikwawa'),
(2223, 133, 'Chiradzulu', 'chiradzulu'),
(2224, 133, 'Chitipa', 'chitipa'),
(2225, 133, 'Dedza', 'dedza'),
(2226, 133, 'Dowa', 'dowa'),
(2227, 133, 'Karonga', 'karonga'),
(2228, 133, 'Kasungu', 'kasungu'),
(2229, 133, 'Likoma', 'likoma'),
(2230, 133, 'Lilongwe', 'lilongwe'),
(2231, 133, 'Machinga', 'machinga'),
(2232, 133, 'Mangochi', 'mangochi'),
(2233, 133, 'Mchinji', 'mchinji'),
(2234, 133, 'Mulanje', 'mulanje'),
(2235, 133, 'Mwanza', 'mwanza'),
(2236, 133, 'Mzimba', 'mzimba'),
(2237, 133, 'Ntcheu', 'ntcheu'),
(2238, 133, 'Nkhata Bay', 'nkhata-bay'),
(2239, 133, 'Nkhotakota', 'nkhotakota'),
(2240, 133, 'Nsanje', 'nsanje'),
(2241, 133, 'Ntchisi', 'ntchisi'),
(2242, 133, 'Phalombe', 'phalombe'),
(2243, 133, 'Rumphi', 'rumphi'),
(2244, 133, 'Salima', 'salima'),
(2245, 133, 'Thyolo', 'thyolo'),
(2246, 133, 'Zomba', 'zomba'),
(2247, 134, 'Johor', 'johor'),
(2248, 134, 'Kedah', 'kedah'),
(2249, 134, 'Kelantan', 'kelantan'),
(2250, 134, 'Labuan', 'labuan'),
(2251, 134, 'Melaka', 'melaka'),
(2252, 134, 'Negeri Sembilan', 'negeri-sembilan'),
(2253, 134, 'Pahang', 'pahang'),
(2254, 134, 'Perak', 'perak'),
(2255, 134, 'Perlis', 'perlis'),
(2256, 134, 'Pulau Pinang', 'pulau-pinang'),
(2257, 134, 'Sabah', 'sabah'),
(2258, 134, 'Sarawak', 'sarawak'),
(2259, 134, 'Selangor', 'selangor'),
(2260, 134, 'Terengganu', 'terengganu'),
(2261, 134, 'Kuala Lumpur', 'kuala-lumpur'),
(2262, 134, 'Putrajaya', 'putrajaya'),
(2263, 135, 'Thiladhunmathi Uthuru', 'thiladhunmathi-uthuru'),
(2264, 135, 'Thiladhunmathi Dhekunu', 'thiladhunmathi-dhekunu'),
(2265, 135, 'Miladhunmadulu Uthuru', 'miladhunmadulu-uthuru'),
(2266, 135, 'Miladhunmadulu Dhekunu', 'miladhunmadulu-dhekunu'),
(2267, 135, 'Maalhosmadulu Uthuru', 'maalhosmadulu-uthuru'),
(2268, 135, 'Maalhosmadulu Dhekunu', 'maalhosmadulu-dhekunu'),
(2269, 135, 'Faadhippolhu', 'faadhippolhu'),
(2270, 135, 'Male Atoll', 'male-atoll'),
(2271, 135, 'Ari Atoll Uthuru', 'ari-atoll-uthuru'),
(2272, 135, 'Ari Atoll Dheknu', 'ari-atoll-dheknu'),
(2273, 135, 'Felidhe Atoll', 'felidhe-atoll'),
(2274, 135, 'Mulaku Atoll', 'mulaku-atoll'),
(2275, 135, 'Nilandhe Atoll Uthuru', 'nilandhe-atoll-uthuru'),
(2276, 135, 'Nilandhe Atoll Dhekunu', 'nilandhe-atoll-dhekunu'),
(2277, 135, 'Kolhumadulu', 'kolhumadulu'),
(2278, 135, 'Hadhdhunmathi', 'hadhdhunmathi'),
(2279, 135, 'Huvadhu Atoll Uthuru', 'huvadhu-atoll-uthuru'),
(2280, 135, 'Huvadhu Atoll Dhekunu', 'huvadhu-atoll-dhekunu'),
(2281, 135, 'Fua Mulaku', 'fua-mulaku'),
(2282, 135, 'Addu', 'addu'),
(2283, 136, 'Gao', 'gao'),
(2284, 136, 'Kayes', 'kayes'),
(2285, 136, 'Kidal', 'kidal'),
(2286, 136, 'Koulikoro', 'koulikoro'),
(2287, 136, 'Mopti', 'mopti'),
(2288, 136, 'Segou', 'segou'),
(2289, 136, 'Sikasso', 'sikasso'),
(2290, 136, 'Tombouctou', 'tombouctou'),
(2291, 136, 'Bamako Capital District', 'bamako-capital-district'),
(2292, 137, 'Attard', 'attard'),
(2293, 137, 'Balzan', 'balzan'),
(2294, 137, 'Birgu', 'birgu'),
(2295, 137, 'Birkirkara', 'birkirkara'),
(2296, 137, 'Birzebbuga', 'birzebbuga'),
(2297, 137, 'Bormla', 'bormla'),
(2298, 137, 'Dingli', 'dingli'),
(2299, 137, 'Fgura', 'fgura'),
(2300, 137, 'Floriana', 'floriana'),
(2301, 137, 'Gudja', 'gudja'),
(2302, 137, 'Gzira', 'gzira'),
(2303, 137, 'Gargur', 'gargur'),
(2304, 137, 'Gaxaq', 'gaxaq'),
(2305, 137, 'Hamrun', 'hamrun'),
(2306, 137, 'Iklin', 'iklin'),
(2307, 137, 'Isla', 'isla'),
(2308, 137, 'Kalkara', 'kalkara'),
(2309, 137, 'Kirkop', 'kirkop'),
(2310, 137, 'Lija', 'lija'),
(2311, 137, 'Luqa', 'luqa'),
(2312, 137, 'Marsa', 'marsa'),
(2313, 137, 'Marsaskala', 'marsaskala'),
(2314, 137, 'Marsaxlokk', 'marsaxlokk'),
(2315, 137, 'Mdina', 'mdina'),
(2316, 137, 'Melliea', 'melliea'),
(2317, 137, 'Mgarr', 'mgarr'),
(2318, 137, 'Mosta', 'mosta'),
(2319, 137, 'Mqabba', 'mqabba'),
(2320, 137, 'Msida', 'msida'),
(2321, 137, 'Mtarfa', 'mtarfa'),
(2322, 137, 'Naxxar', 'naxxar'),
(2323, 137, 'Paola', 'paola'),
(2324, 137, 'Pembroke', 'pembroke'),
(2325, 137, 'Pieta', 'pieta'),
(2326, 137, 'Qormi', 'qormi'),
(2327, 137, 'Qrendi', 'qrendi'),
(2328, 137, 'Rabat', 'rabat'),
(2329, 137, 'Safi', 'safi'),
(2330, 137, 'San Giljan', 'san-giljan'),
(2331, 137, 'Santa Lucija', 'santa-lucija'),
(2332, 137, 'San Pawl il-Bahar', 'san-pawl-il-bahar'),
(2333, 137, 'San Gwann', 'san-gwann'),
(2334, 137, 'Santa Venera', 'santa-venera'),
(2335, 137, 'Siggiewi', 'siggiewi'),
(2336, 137, 'Sliema', 'sliema'),
(2337, 137, 'Swieqi', 'swieqi'),
(2338, 137, 'Ta Xbiex', 'ta-xbiex'),
(2339, 137, 'Tarxien', 'tarxien'),
(2340, 137, 'Valletta', 'valletta'),
(2341, 137, 'Xgajra', 'xgajra'),
(2342, 137, 'Zabbar', 'zabbar'),
(2343, 137, 'Zebbug', 'zebbug'),
(2344, 137, 'Zejtun', 'zejtun'),
(2345, 137, 'Zurrieq', 'zurrieq'),
(2346, 137, 'Fontana', 'fontana'),
(2347, 137, 'Ghajnsielem', 'ghajnsielem'),
(2348, 137, 'Gharb', 'gharb'),
(2349, 137, 'Ghasri', 'ghasri'),
(2350, 137, 'Kercem', 'kercem'),
(2351, 137, 'Munxar', 'munxar'),
(2352, 137, 'Nadur', 'nadur'),
(2353, 137, 'Qala', 'qala'),
(2354, 137, 'Victoria', 'victoria'),
(2355, 137, 'San Lawrenz', 'san-lawrenz'),
(2356, 137, 'Sannat', 'sannat'),
(2357, 137, 'Xagra', 'xagra'),
(2358, 137, 'Xewkija', 'xewkija'),
(2359, 137, 'Zebbug', 'zebbug'),
(2360, 138, 'Ailinginae', 'ailinginae'),
(2361, 138, 'Ailinglaplap', 'ailinglaplap'),
(2362, 138, 'Ailuk', 'ailuk'),
(2363, 138, 'Arno', 'arno'),
(2364, 138, 'Aur', 'aur'),
(2365, 138, 'Bikar', 'bikar'),
(2366, 138, 'Bikini', 'bikini'),
(2367, 138, 'Bokak', 'bokak'),
(2368, 138, 'Ebon', 'ebon'),
(2369, 138, 'Enewetak', 'enewetak'),
(2370, 138, 'Erikub', 'erikub'),
(2371, 138, 'Jabat', 'jabat'),
(2372, 138, 'Jaluit', 'jaluit'),
(2373, 138, 'Jemo', 'jemo'),
(2374, 138, 'Kili', 'kili'),
(2375, 138, 'Kwajalein', 'kwajalein'),
(2376, 138, 'Lae', 'lae'),
(2377, 138, 'Lib', 'lib'),
(2378, 138, 'Likiep', 'likiep'),
(2379, 138, 'Majuro', 'majuro'),
(2380, 138, 'Maloelap', 'maloelap'),
(2381, 138, 'Mejit', 'mejit'),
(2382, 138, 'Mili', 'mili'),
(2383, 138, 'Namorik', 'namorik'),
(2384, 138, 'Namu', 'namu'),
(2385, 138, 'Rongelap', 'rongelap'),
(2386, 138, 'Rongrik', 'rongrik'),
(2387, 138, 'Toke', 'toke'),
(2388, 138, 'Ujae', 'ujae'),
(2389, 138, 'Ujelang', 'ujelang'),
(2390, 138, 'Utirik', 'utirik'),
(2391, 138, 'Wotho', 'wotho'),
(2392, 138, 'Wotje', 'wotje'),
(2393, 140, 'Adrar', 'adrar'),
(2394, 140, 'Assaba', 'assaba'),
(2395, 140, 'Brakna', 'brakna'),
(2396, 140, 'Dakhlet Nouadhibou', 'dakhlet-nouadhibou'),
(2397, 140, 'Gorgol', 'gorgol'),
(2398, 140, 'Guidimaka', 'guidimaka'),
(2399, 140, 'Hodh Ech Chargui', 'hodh-ech-chargui'),
(2400, 140, 'Hodh El Gharbi', 'hodh-el-gharbi'),
(2401, 140, 'Inchiri', 'inchiri'),
(2402, 140, 'Tagant', 'tagant'),
(2403, 140, 'Tiris Zemmour', 'tiris-zemmour'),
(2404, 140, 'Trarza', 'trarza'),
(2405, 140, 'Nouakchott', 'nouakchott'),
(2406, 141, 'Beau Bassin-Rose Hill', 'beau-bassin-rose-hill'),
(2407, 141, 'Curepipe', 'curepipe'),
(2408, 141, 'Port Louis', 'port-louis'),
(2409, 141, 'Quatre Bornes', 'quatre-bornes'),
(2410, 141, 'Vacoas-Phoenix', 'vacoas-phoenix'),
(2411, 141, 'Agalega Islands', 'agalega-islands'),
(2412, 141, 'Cargados Carajos Shoals (Saint Brandon Islands)', 'cargados-carajos-shoals-saint-brandon-islands'),
(2413, 141, 'Rodrigues', 'rodrigues'),
(2414, 141, 'Black River', 'black-river'),
(2415, 141, 'Flacq', 'flacq'),
(2416, 141, 'Grand Port', 'grand-port'),
(2417, 141, 'Moka', 'moka'),
(2418, 141, 'Pamplemousses', 'pamplemousses'),
(2419, 141, 'Plaines Wilhems', 'plaines-wilhems'),
(2420, 141, 'Port Louis', 'port-louis'),
(2421, 141, 'Riviere du Rempart', 'riviere-du-rempart'),
(2422, 141, 'Savanne', 'savanne'),
(2423, 143, 'Baja California Norte', 'baja-california-norte'),
(2424, 143, 'Baja California Sur', 'baja-california-sur'),
(2425, 143, 'Campeche', 'campeche'),
(2426, 143, 'Chiapas', 'chiapas'),
(2427, 143, 'Chihuahua', 'chihuahua'),
(2428, 143, 'Coahuila de Zaragoza', 'coahuila-de-zaragoza'),
(2429, 143, 'Colima', 'colima'),
(2430, 143, 'Distrito Federal', 'distrito-federal'),
(2431, 143, 'Durango', 'durango'),
(2432, 143, 'Guanajuato', 'guanajuato'),
(2433, 143, 'Guerrero', 'guerrero'),
(2434, 143, 'Hidalgo', 'hidalgo'),
(2435, 143, 'Jalisco', 'jalisco'),
(2436, 143, 'Mexico', 'mexico'),
(2437, 143, 'Michoacan de Ocampo', 'michoacan-de-ocampo'),
(2438, 143, 'Morelos', 'morelos'),
(2439, 143, 'Nayarit', 'nayarit'),
(2440, 143, 'Nuevo Leon', 'nuevo-leon'),
(2441, 143, 'Oaxaca', 'oaxaca'),
(2442, 143, 'Puebla', 'puebla'),
(2443, 143, 'Queretaro de Arteaga', 'queretaro-de-arteaga'),
(2444, 143, 'Quintana Roo', 'quintana-roo'),
(2445, 143, 'San Luis Potosi', 'san-luis-potosi'),
(2446, 143, 'Sinaloa', 'sinaloa'),
(2447, 143, 'Sonora', 'sonora'),
(2448, 143, 'Tabasco', 'tabasco'),
(2449, 143, 'Tamaulipas', 'tamaulipas'),
(2450, 143, 'Tlaxcala', 'tlaxcala'),
(2451, 143, 'Veracruz-Llave', 'veracruz-llave'),
(2452, 143, 'Yucatan', 'yucatan'),
(2453, 143, 'Zacatecas', 'zacatecas'),
(2454, 143, 'Aguascalientes', 'aguascalientes'),
(2455, 144, 'Chuuk', 'chuuk'),
(2456, 144, 'Kosrae', 'kosrae'),
(2457, 144, 'Pohnpei', 'pohnpei'),
(2458, 144, 'Yap', 'yap'),
(2459, 145, 'Gagauzia', 'gagauzia'),
(2460, 145, 'Chisinau', 'chisinau'),
(2461, 145, 'Balti', 'balti'),
(2462, 145, 'Cahul', 'cahul'),
(2463, 145, 'Edinet', 'edinet'),
(2464, 145, 'Lapusna', 'lapusna'),
(2465, 145, 'Orhei', 'orhei'),
(2466, 145, 'Soroca', 'soroca'),
(2467, 145, 'Tighina', 'tighina'),
(2468, 145, 'Ungheni', 'ungheni'),
(2469, 145, 'St‚nga Nistrului', 'st-nga-nistrului'),
(2470, 146, 'Fontvieille', 'fontvieille'),
(2471, 146, 'La Condamine', 'la-condamine'),
(2472, 146, 'Monaco-Ville', 'monaco-ville'),
(2473, 146, 'Monte-Carlo', 'monte-carlo'),
(2474, 147, 'Ulanbaatar', 'ulanbaatar'),
(2475, 147, 'Orhon', 'orhon'),
(2476, 147, 'Darhan uul', 'darhan-uul'),
(2477, 147, 'Hentiy', 'hentiy'),
(2478, 147, 'Hovsgol', 'hovsgol'),
(2479, 147, 'Hovd', 'hovd'),
(2480, 147, 'Uvs', 'uvs'),
(2481, 147, 'Tov', 'tov'),
(2482, 147, 'Selenge', 'selenge'),
(2483, 147, 'Suhbaatar', 'suhbaatar'),
(2484, 147, 'Omnogovi', 'omnogovi'),
(2485, 147, 'Ovorhangay', 'ovorhangay'),
(2486, 147, 'Dzavhan', 'dzavhan'),
(2487, 147, 'DundgovL', 'dundgovl'),
(2488, 147, 'Dornod', 'dornod'),
(2489, 147, 'Dornogov', 'dornogov'),
(2490, 147, 'Govi-Sumber', 'govi-sumber'),
(2491, 147, 'Govi-Altay', 'govi-altay'),
(2492, 147, 'Bulgan', 'bulgan'),
(2493, 147, 'Bayanhongor', 'bayanhongor'),
(2494, 147, 'Bayan-Olgiy', 'bayan-olgiy'),
(2495, 147, 'Arhangay', 'arhangay'),
(2496, 149, 'Saint Anthony', 'saint-anthony'),
(2497, 149, 'Saint Georges', 'saint-georges'),
(2498, 149, 'Saint Peter', 'saint-peter'),
(2499, 150, 'Agadir', 'agadir'),
(2500, 150, 'Al Hoceima', 'al-hoceima'),
(2501, 150, 'Azilal', 'azilal'),
(2502, 150, 'Beni Mellal', 'beni-mellal'),
(2503, 150, 'Ben Slimane', 'ben-slimane'),
(2504, 150, 'Boulemane', 'boulemane'),
(2505, 150, 'Casablanca', 'casablanca'),
(2506, 150, 'Chaouen', 'chaouen'),
(2507, 150, 'El Jadida', 'el-jadida'),
(2508, 150, 'El Kelaa des Sraghna', 'el-kelaa-des-sraghna'),
(2509, 150, 'Er Rachidia', 'er-rachidia'),
(2510, 150, 'Essaouira', 'essaouira'),
(2511, 150, 'Fes', 'fes'),
(2512, 150, 'Figuig', 'figuig'),
(2513, 150, 'Guelmim', 'guelmim'),
(2514, 150, 'Ifrane', 'ifrane'),
(2515, 150, 'Kenitra', 'kenitra'),
(2516, 150, 'Khemisset', 'khemisset'),
(2517, 150, 'Khenifra', 'khenifra'),
(2518, 150, 'Khouribga', 'khouribga'),
(2519, 150, 'Laayoune', 'laayoune'),
(2520, 150, 'Larache', 'larache'),
(2521, 150, 'Marrakech', 'marrakech'),
(2522, 150, 'Meknes', 'meknes'),
(2523, 150, 'Nador', 'nador'),
(2524, 150, 'Ouarzazate', 'ouarzazate'),
(2525, 150, 'Oujda', 'oujda'),
(2526, 150, 'Rabat-Sale', 'rabat-sale'),
(2527, 150, 'Safi', 'safi'),
(2528, 150, 'Settat', 'settat'),
(2529, 150, 'Sidi Kacem', 'sidi-kacem'),
(2530, 150, 'Tangier', 'tangier'),
(2531, 150, 'Tan-Tan', 'tan-tan'),
(2532, 150, 'Taounate', 'taounate'),
(2533, 150, 'Taroudannt', 'taroudannt'),
(2534, 150, 'Tata', 'tata'),
(2535, 150, 'Taza', 'taza'),
(2536, 150, 'Tetouan', 'tetouan'),
(2537, 150, 'Tiznit', 'tiznit'),
(2538, 150, 'Ad Dakhla', 'ad-dakhla'),
(2539, 150, 'Boujdour', 'boujdour'),
(2540, 150, 'Es Smara', 'es-smara'),
(2541, 151, 'Cabo Delgado', 'cabo-delgado'),
(2542, 151, 'Gaza', 'gaza'),
(2543, 151, 'Inhambane', 'inhambane'),
(2544, 151, 'Manica', 'manica'),
(2545, 151, 'Maputo (city)', 'maputo-city'),
(2546, 151, 'Maputo', 'maputo'),
(2547, 151, 'Nampula', 'nampula'),
(2548, 151, 'Niassa', 'niassa'),
(2549, 151, 'Sofala', 'sofala'),
(2550, 151, 'Tete', 'tete'),
(2551, 151, 'Zambezia', 'zambezia'),
(2552, 152, 'Ayeyarwady', 'ayeyarwady'),
(2553, 152, 'Bago', 'bago'),
(2554, 152, 'Magway', 'magway'),
(2555, 152, 'Mandalay', 'mandalay'),
(2556, 152, 'Sagaing', 'sagaing'),
(2557, 152, 'Tanintharyi', 'tanintharyi'),
(2558, 152, 'Yangon', 'yangon'),
(2559, 152, 'Chin State', 'chin-state'),
(2560, 152, 'Kachin State', 'kachin-state'),
(2561, 152, 'Kayah State', 'kayah-state'),
(2562, 152, 'Kayin State', 'kayin-state'),
(2563, 152, 'Mon State', 'mon-state'),
(2564, 152, 'Rakhine State', 'rakhine-state'),
(2565, 152, 'Shan State', 'shan-state'),
(2566, 153, 'Caprivi', 'caprivi'),
(2567, 153, 'Erongo', 'erongo'),
(2568, 153, 'Hardap', 'hardap'),
(2569, 153, 'Karas', 'karas'),
(2570, 153, 'Kavango', 'kavango'),
(2571, 153, 'Khomas', 'khomas'),
(2572, 153, 'Kunene', 'kunene'),
(2573, 153, 'Ohangwena', 'ohangwena'),
(2574, 153, 'Omaheke', 'omaheke'),
(2575, 153, 'Omusati', 'omusati'),
(2576, 153, 'Oshana', 'oshana'),
(2577, 153, 'Oshikoto', 'oshikoto'),
(2578, 153, 'Otjozondjupa', 'otjozondjupa'),
(2579, 154, 'Aiwo', 'aiwo'),
(2580, 154, 'Anabar', 'anabar'),
(2581, 154, 'Anetan', 'anetan'),
(2582, 154, 'Anibare', 'anibare'),
(2583, 154, 'Baiti', 'baiti'),
(2584, 154, 'Boe', 'boe'),
(2585, 154, 'Buada', 'buada'),
(2586, 154, 'Denigomodu', 'denigomodu'),
(2587, 154, 'Ewa', 'ewa'),
(2588, 154, 'Ijuw', 'ijuw'),
(2589, 154, 'Meneng', 'meneng'),
(2590, 154, 'Nibok', 'nibok'),
(2591, 154, 'Uaboe', 'uaboe'),
(2592, 154, 'Yaren', 'yaren'),
(2593, 155, 'Bagmati', 'bagmati'),
(2594, 155, 'Bheri', 'bheri'),
(2595, 155, 'Dhawalagiri', 'dhawalagiri'),
(2596, 155, 'Gandaki', 'gandaki'),
(2597, 155, 'Janakpur', 'janakpur'),
(2598, 155, 'Karnali', 'karnali'),
(2599, 155, 'Kosi', 'kosi'),
(2600, 155, 'Lumbini', 'lumbini'),
(2601, 155, 'Mahakali', 'mahakali'),
(2602, 155, 'Mechi', 'mechi'),
(2603, 155, 'Narayani', 'narayani'),
(2604, 155, 'Rapti', 'rapti'),
(2605, 155, 'Sagarmatha', 'sagarmatha'),
(2606, 155, 'Seti', 'seti'),
(2607, 156, 'Drenthe', 'drenthe'),
(2608, 156, 'Flevoland', 'flevoland'),
(2609, 156, 'Friesland', 'friesland'),
(2610, 156, 'Gelderland', 'gelderland'),
(2611, 156, 'Groningen', 'groningen'),
(2612, 156, 'Limburg', 'limburg'),
(2613, 156, 'Noord-Brabant', 'noord-brabant'),
(2614, 156, 'Noord-Holland', 'noord-holland'),
(2615, 156, 'Overijssel', 'overijssel'),
(2616, 156, 'Utrecht', 'utrecht'),
(2617, 156, 'Zeeland', 'zeeland'),
(2618, 156, 'Zuid-Holland', 'zuid-holland'),
(2619, 157, 'Iles Loyaute', 'iles-loyaute'),
(2620, 157, 'Nord', 'nord'),
(2621, 157, 'Sud', 'sud'),
(2622, 158, 'Auckland', 'auckland'),
(2623, 158, 'Bay of Plenty', 'bay-of-plenty'),
(2624, 158, 'Canterbury', 'canterbury'),
(2625, 158, 'Coromandel', 'coromandel'),
(2626, 158, 'Gisborne', 'gisborne'),
(2627, 158, 'Fiordland', 'fiordland'),
(2628, 158, 'Hawke\'s Bay', 'hawke-s-bay'),
(2629, 158, 'Marlborough', 'marlborough'),
(2630, 158, 'Manawatu-Wanganui', 'manawatu-wanganui'),
(2631, 158, 'Mt Cook-Mackenzie', 'mt-cook-mackenzie'),
(2632, 158, 'Nelson', 'nelson'),
(2633, 158, 'Northland', 'northland'),
(2634, 158, 'Otago', 'otago'),
(2635, 158, 'Southland', 'southland'),
(2636, 158, 'Taranaki', 'taranaki'),
(2637, 158, 'Wellington', 'wellington'),
(2638, 158, 'Waikato', 'waikato'),
(2639, 158, 'Wairarapa', 'wairarapa'),
(2640, 158, 'West Coast', 'west-coast'),
(2641, 159, 'Atlantico Norte', 'atlantico-norte'),
(2642, 159, 'Atlantico Sur', 'atlantico-sur'),
(2643, 159, 'Boaco', 'boaco'),
(2644, 159, 'Carazo', 'carazo'),
(2645, 159, 'Chinandega', 'chinandega'),
(2646, 159, 'Chontales', 'chontales'),
(2647, 159, 'Esteli', 'esteli'),
(2648, 159, 'Granada', 'granada'),
(2649, 159, 'Jinotega', 'jinotega'),
(2650, 159, 'Leon', 'leon'),
(2651, 159, 'Madriz', 'madriz'),
(2652, 159, 'Managua', 'managua'),
(2653, 159, 'Masaya', 'masaya');
INSERT INTO `cities` (`id`, `country_id`, `name`, `slug`) VALUES
(2654, 159, 'Matagalpa', 'matagalpa'),
(2655, 159, 'Nuevo Segovia', 'nuevo-segovia'),
(2656, 159, 'Rio San Juan', 'rio-san-juan'),
(2657, 159, 'Rivas', 'rivas'),
(2658, 160, 'Agadez', 'agadez'),
(2659, 160, 'Diffa', 'diffa'),
(2660, 160, 'Dosso', 'dosso'),
(2661, 160, 'Maradi', 'maradi'),
(2662, 160, 'Niamey', 'niamey'),
(2663, 160, 'Tahoua', 'tahoua'),
(2664, 160, 'Tillaberi', 'tillaberi'),
(2665, 160, 'Zinder', 'zinder'),
(2666, 161, 'Abia', 'abia'),
(2667, 161, 'Abuja Federal Capital Territory', 'abuja-federal-capital-territory'),
(2668, 161, 'Adamawa', 'adamawa'),
(2669, 161, 'Akwa Ibom', 'akwa-ibom'),
(2670, 161, 'Anambra', 'anambra'),
(2671, 161, 'Bauchi', 'bauchi'),
(2672, 161, 'Bayelsa', 'bayelsa'),
(2673, 161, 'Benue', 'benue'),
(2674, 161, 'Borno', 'borno'),
(2675, 161, 'Cross River', 'cross-river'),
(2676, 161, 'Delta', 'delta'),
(2677, 161, 'Ebonyi', 'ebonyi'),
(2678, 161, 'Edo', 'edo'),
(2679, 161, 'Ekiti', 'ekiti'),
(2680, 161, 'Enugu', 'enugu'),
(2681, 161, 'Gombe', 'gombe'),
(2682, 161, 'Imo', 'imo'),
(2683, 161, 'Jigawa', 'jigawa'),
(2684, 161, 'Kaduna', 'kaduna'),
(2685, 161, 'Kano', 'kano'),
(2686, 161, 'Katsina', 'katsina'),
(2687, 161, 'Kebbi', 'kebbi'),
(2688, 161, 'Kogi', 'kogi'),
(2689, 161, 'Kwara', 'kwara'),
(2690, 161, 'Lagos', 'lagos'),
(2691, 161, 'Nassarawa', 'nassarawa'),
(2692, 161, 'Niger', 'niger'),
(2693, 161, 'Ogun', 'ogun'),
(2694, 161, 'Ondo', 'ondo'),
(2695, 161, 'Osun', 'osun'),
(2696, 161, 'Oyo', 'oyo'),
(2697, 161, 'Plateau', 'plateau'),
(2698, 161, 'Rivers', 'rivers'),
(2699, 161, 'Sokoto', 'sokoto'),
(2700, 161, 'Taraba', 'taraba'),
(2701, 161, 'Yobe', 'yobe'),
(2702, 161, 'Zamfara', 'zamfara'),
(2703, 164, 'Northern Islands', 'northern-islands'),
(2704, 164, 'Rota', 'rota'),
(2705, 164, 'Saipan', 'saipan'),
(2706, 164, 'Tinian', 'tinian'),
(2707, 165, 'Akershus', 'akershus'),
(2708, 165, 'Aust-Agder', 'aust-agder'),
(2709, 165, 'Buskerud', 'buskerud'),
(2710, 165, 'Finnmark', 'finnmark'),
(2711, 165, 'Hedmark', 'hedmark'),
(2712, 165, 'Hordaland', 'hordaland'),
(2713, 165, 'More og Romdal', 'more-og-romdal'),
(2714, 165, 'Nord-Trondelag', 'nord-trondelag'),
(2715, 165, 'Nordland', 'nordland'),
(2716, 165, 'Ostfold', 'ostfold'),
(2717, 165, 'Oppland', 'oppland'),
(2718, 165, 'Oslo', 'oslo'),
(2719, 165, 'Rogaland', 'rogaland'),
(2720, 165, 'Sor-Trondelag', 'sor-trondelag'),
(2721, 165, 'Sogn og Fjordane', 'sogn-og-fjordane'),
(2722, 165, 'Svalbard', 'svalbard'),
(2723, 165, 'Telemark', 'telemark'),
(2724, 165, 'Troms', 'troms'),
(2725, 165, 'Vest-Agder', 'vest-agder'),
(2726, 165, 'Vestfold', 'vestfold'),
(2727, 166, 'Ad Dakhiliyah', 'ad-dakhiliyah'),
(2728, 166, 'Al Batinah', 'al-batinah'),
(2729, 166, 'Al Wusta', 'al-wusta'),
(2730, 166, 'Ash Sharqiyah', 'ash-sharqiyah'),
(2731, 166, 'Az Zahirah', 'az-zahirah'),
(2732, 166, 'Masqat', 'masqat'),
(2733, 166, 'Musandam', 'musandam'),
(2734, 166, 'Zufar', 'zufar'),
(2735, 167, 'Balochistan', 'balochistan'),
(2736, 167, 'Federally Administered Tribal Areas', 'federally-administered-tribal-areas'),
(2737, 167, 'Islamabad Capital Territory', 'islamabad-capital-territory'),
(2738, 167, 'North-West Frontier', 'north-west-frontier'),
(2739, 167, 'Punjab', 'punjab'),
(2740, 167, 'Sindh', 'sindh'),
(2741, 168, 'Aimeliik', 'aimeliik'),
(2742, 168, 'Airai', 'airai'),
(2743, 168, 'Angaur', 'angaur'),
(2744, 168, 'Hatohobei', 'hatohobei'),
(2745, 168, 'Kayangel', 'kayangel'),
(2746, 168, 'Koror', 'koror'),
(2747, 168, 'Melekeok', 'melekeok'),
(2748, 168, 'Ngaraard', 'ngaraard'),
(2749, 168, 'Ngarchelong', 'ngarchelong'),
(2750, 168, 'Ngardmau', 'ngardmau'),
(2751, 168, 'Ngatpang', 'ngatpang'),
(2752, 168, 'Ngchesar', 'ngchesar'),
(2753, 168, 'Ngeremlengui', 'ngeremlengui'),
(2754, 168, 'Ngiwal', 'ngiwal'),
(2755, 168, 'Peleliu', 'peleliu'),
(2756, 168, 'Sonsorol', 'sonsorol'),
(2757, 170, 'Bocas del Toro', 'bocas-del-toro'),
(2758, 170, 'Chiriqui', 'chiriqui'),
(2759, 170, 'Cocle', 'cocle'),
(2760, 170, 'Colon', 'colon'),
(2761, 170, 'Darien', 'darien'),
(2762, 170, 'Herrera', 'herrera'),
(2763, 170, 'Los Santos', 'los-santos'),
(2764, 170, 'Panama', 'panama'),
(2765, 170, 'San Blas', 'san-blas'),
(2766, 170, 'Veraguas', 'veraguas'),
(2767, 171, 'Bougainville', 'bougainville'),
(2768, 171, 'Central', 'central'),
(2769, 171, 'Chimbu', 'chimbu'),
(2770, 171, 'Eastern Highlands', 'eastern-highlands'),
(2771, 171, 'East New Britain', 'east-new-britain'),
(2772, 171, 'East Sepik', 'east-sepik'),
(2773, 171, 'Enga', 'enga'),
(2774, 171, 'Gulf', 'gulf'),
(2775, 171, 'Madang', 'madang'),
(2776, 171, 'Manus', 'manus'),
(2777, 171, 'Milne Bay', 'milne-bay'),
(2778, 171, 'Morobe', 'morobe'),
(2779, 171, 'National Capital', 'national-capital'),
(2780, 171, 'New Ireland', 'new-ireland'),
(2781, 171, 'Northern', 'northern'),
(2782, 171, 'Sandaun', 'sandaun'),
(2783, 171, 'Southern Highlands', 'southern-highlands'),
(2784, 171, 'Western', 'western'),
(2785, 171, 'Western Highlands', 'western-highlands'),
(2786, 171, 'West New Britain', 'west-new-britain'),
(2787, 172, 'Alto Paraguay', 'alto-paraguay'),
(2788, 172, 'Alto Parana', 'alto-parana'),
(2789, 172, 'Amambay', 'amambay'),
(2790, 172, 'Asuncion', 'asuncion'),
(2791, 172, 'Boqueron', 'boqueron'),
(2792, 172, 'Caaguazu', 'caaguazu'),
(2793, 172, 'Caazapa', 'caazapa'),
(2794, 172, 'Canindeyu', 'canindeyu'),
(2795, 172, 'Central', 'central'),
(2796, 172, 'Concepcion', 'concepcion'),
(2797, 172, 'Cordillera', 'cordillera'),
(2798, 172, 'Guaira', 'guaira'),
(2799, 172, 'Itapua', 'itapua'),
(2800, 172, 'Misiones', 'misiones'),
(2801, 172, 'Neembucu', 'neembucu'),
(2802, 172, 'Paraguari', 'paraguari'),
(2803, 172, 'Presidente Hayes', 'presidente-hayes'),
(2804, 172, 'San Pedro', 'san-pedro'),
(2805, 173, 'Amazonas', 'amazonas'),
(2806, 173, 'Ancash', 'ancash'),
(2807, 173, 'Apurimac', 'apurimac'),
(2808, 173, 'Arequipa', 'arequipa'),
(2809, 173, 'Ayacucho', 'ayacucho'),
(2810, 173, 'Cajamarca', 'cajamarca'),
(2811, 173, 'Callao', 'callao'),
(2812, 173, 'Cusco', 'cusco'),
(2813, 173, 'Huancavelica', 'huancavelica'),
(2814, 173, 'Huanuco', 'huanuco'),
(2815, 173, 'Ica', 'ica'),
(2816, 173, 'Junin', 'junin'),
(2817, 173, 'La Libertad', 'la-libertad'),
(2818, 173, 'Lambayeque', 'lambayeque'),
(2819, 173, 'Lima', 'lima'),
(2820, 173, 'Loreto', 'loreto'),
(2821, 173, 'Madre de Dios', 'madre-de-dios'),
(2822, 173, 'Moquegua', 'moquegua'),
(2823, 173, 'Pasco', 'pasco'),
(2824, 173, 'Piura', 'piura'),
(2825, 173, 'Puno', 'puno'),
(2826, 173, 'San Martin', 'san-martin'),
(2827, 173, 'Tacna', 'tacna'),
(2828, 173, 'Tumbes', 'tumbes'),
(2829, 173, 'Ucayali', 'ucayali'),
(2830, 174, 'Abra', 'abra'),
(2831, 174, 'Agusan del Norte', 'agusan-del-norte'),
(2832, 174, 'Agusan del Sur', 'agusan-del-sur'),
(2833, 174, 'Aklan', 'aklan'),
(2834, 174, 'Albay', 'albay'),
(2835, 174, 'Antique', 'antique'),
(2836, 174, 'Apayao', 'apayao'),
(2837, 174, 'Aurora', 'aurora'),
(2838, 174, 'Basilan', 'basilan'),
(2839, 174, 'Bataan', 'bataan'),
(2840, 174, 'Batanes', 'batanes'),
(2841, 174, 'Batangas', 'batangas'),
(2842, 174, 'Biliran', 'biliran'),
(2843, 174, 'Benguet', 'benguet'),
(2844, 174, 'Bohol', 'bohol'),
(2845, 174, 'Bukidnon', 'bukidnon'),
(2846, 174, 'Bulacan', 'bulacan'),
(2847, 174, 'Cagayan', 'cagayan'),
(2848, 174, 'Camarines Norte', 'camarines-norte'),
(2849, 174, 'Camarines Sur', 'camarines-sur'),
(2850, 174, 'Camiguin', 'camiguin'),
(2851, 174, 'Capiz', 'capiz'),
(2852, 174, 'Catanduanes', 'catanduanes'),
(2853, 174, 'Cavite', 'cavite'),
(2854, 174, 'Cebu', 'cebu'),
(2855, 174, 'Compostela', 'compostela'),
(2856, 174, 'Davao del Norte', 'davao-del-norte'),
(2857, 174, 'Davao del Sur', 'davao-del-sur'),
(2858, 174, 'Davao Oriental', 'davao-oriental'),
(2859, 174, 'Eastern Samar', 'eastern-samar'),
(2860, 174, 'Guimaras', 'guimaras'),
(2861, 174, 'Ifugao', 'ifugao'),
(2862, 174, 'Ilocos Norte', 'ilocos-norte'),
(2863, 174, 'Ilocos Sur', 'ilocos-sur'),
(2864, 174, 'Iloilo', 'iloilo'),
(2865, 174, 'Isabela', 'isabela'),
(2866, 174, 'Kalinga', 'kalinga'),
(2867, 174, 'Laguna', 'laguna'),
(2868, 174, 'Lanao del Norte', 'lanao-del-norte'),
(2869, 174, 'Lanao del Sur', 'lanao-del-sur'),
(2870, 174, 'La Union', 'la-union'),
(2871, 174, 'Leyte', 'leyte'),
(2872, 174, 'Maguindanao', 'maguindanao'),
(2873, 174, 'Marinduque', 'marinduque'),
(2874, 174, 'Masbate', 'masbate'),
(2875, 174, 'Mindoro Occidental', 'mindoro-occidental'),
(2876, 174, 'Mindoro Oriental', 'mindoro-oriental'),
(2877, 174, 'Misamis Occidental', 'misamis-occidental'),
(2878, 174, 'Misamis Oriental', 'misamis-oriental'),
(2879, 174, 'Mountain', 'mountain'),
(2880, 174, 'Negros Occidental', 'negros-occidental'),
(2881, 174, 'Negros Oriental', 'negros-oriental'),
(2882, 174, 'North Cotabato', 'north-cotabato'),
(2883, 174, 'Northern Samar', 'northern-samar'),
(2884, 174, 'Nueva Ecija', 'nueva-ecija'),
(2885, 174, 'Nueva Vizcaya', 'nueva-vizcaya'),
(2886, 174, 'Palawan', 'palawan'),
(2887, 174, 'Pampanga', 'pampanga'),
(2888, 174, 'Pangasinan', 'pangasinan'),
(2889, 174, 'Quezon', 'quezon'),
(2890, 174, 'Quirino', 'quirino'),
(2891, 174, 'Rizal', 'rizal'),
(2892, 174, 'Romblon', 'romblon'),
(2893, 174, 'Samar', 'samar'),
(2894, 174, 'Sarangani', 'sarangani'),
(2895, 174, 'Siquijor', 'siquijor'),
(2896, 174, 'Sorsogon', 'sorsogon'),
(2897, 174, 'South Cotabato', 'south-cotabato'),
(2898, 174, 'Southern Leyte', 'southern-leyte'),
(2899, 174, 'Sultan Kudarat', 'sultan-kudarat'),
(2900, 174, 'Sulu', 'sulu'),
(2901, 174, 'Surigao del Norte', 'surigao-del-norte'),
(2902, 174, 'Surigao del Sur', 'surigao-del-sur'),
(2903, 174, 'Tarlac', 'tarlac'),
(2904, 174, 'Tawi-Tawi', 'tawi-tawi'),
(2905, 174, 'Zambales', 'zambales'),
(2906, 174, 'Zamboanga del Norte', 'zamboanga-del-norte'),
(2907, 174, 'Zamboanga del Sur', 'zamboanga-del-sur'),
(2908, 174, 'Zamboanga Sibugay', 'zamboanga-sibugay'),
(2909, 176, 'Dolnoslaskie', 'dolnoslaskie'),
(2910, 176, 'Kujawsko-Pomorskie', 'kujawsko-pomorskie'),
(2911, 176, 'Lodzkie', 'lodzkie'),
(2912, 176, 'Lubelskie', 'lubelskie'),
(2913, 176, 'Lubuskie', 'lubuskie'),
(2914, 176, 'Malopolskie', 'malopolskie'),
(2915, 176, 'Mazowieckie', 'mazowieckie'),
(2916, 176, 'Opolskie', 'opolskie'),
(2917, 176, 'Podkarpackie', 'podkarpackie'),
(2918, 176, 'Podlaskie', 'podlaskie'),
(2919, 176, 'Pomorskie', 'pomorskie'),
(2920, 176, 'Slaskie', 'slaskie'),
(2921, 176, 'Swietokrzyskie', 'swietokrzyskie'),
(2922, 176, 'Warminsko-Mazurskie', 'warminsko-mazurskie'),
(2923, 176, 'Wielkopolskie', 'wielkopolskie'),
(2924, 176, 'Zachodniopomorskie', 'zachodniopomorskie'),
(2925, 177, 'Açores', 'acores'),
(2926, 177, 'Aveiro', 'aveiro'),
(2927, 177, 'Beja', 'beja'),
(2928, 177, 'Braga', 'braga'),
(2929, 177, 'Bragança', 'braganca'),
(2930, 177, 'Castelo Branco', 'castelo-branco'),
(2931, 177, 'Coimbra', 'coimbra'),
(2932, 177, 'Évora', 'evora'),
(2933, 177, 'Faro', 'faro'),
(2934, 177, 'Guarda', 'guarda'),
(2935, 177, 'Leiria', 'leiria'),
(2936, 177, 'Lisboa', 'lisboa'),
(2937, 177, 'Madeira', 'madeira'),
(2938, 177, 'Portalegre', 'portalegre'),
(2939, 177, 'Porto', 'porto'),
(2940, 177, 'Santarém', 'santarem'),
(2941, 177, 'Setúbal', 'setubal'),
(2942, 177, 'Viana do Castelo', 'viana-do-castelo'),
(2943, 177, 'Vila Real', 'vila-real'),
(2944, 177, 'Viseu', 'viseu'),
(2945, 179, 'Ad Dawhah', 'ad-dawhah'),
(2946, 179, 'Al Ghuwayriyah', 'al-ghuwayriyah'),
(2947, 179, 'Al Jumayliyah', 'al-jumayliyah'),
(2948, 179, 'Al Khawr', 'al-khawr'),
(2949, 179, 'Al Wakrah', 'al-wakrah'),
(2950, 179, 'Ar Rayyan', 'ar-rayyan'),
(2951, 179, 'Jarayan al Batinah', 'jarayan-al-batinah'),
(2952, 179, 'Madinat ash Shamal', 'madinat-ash-shamal'),
(2953, 179, 'Umm Sa\'id', 'umm-sa-id'),
(2954, 179, 'Umm Salal', 'umm-salal'),
(2955, 180, 'Alba', 'alba'),
(2956, 180, 'Arad', 'arad'),
(2957, 180, 'Arges', 'arges'),
(2958, 180, 'Bacau', 'bacau'),
(2959, 180, 'Bihor', 'bihor'),
(2960, 180, 'Bistrita-Nasaud', 'bistrita-nasaud'),
(2961, 180, 'Botosani', 'botosani'),
(2962, 180, 'Brasov', 'brasov'),
(2963, 180, 'Braila', 'braila'),
(2964, 180, 'Bucuresti', 'bucuresti'),
(2965, 180, 'Buzau', 'buzau'),
(2966, 180, 'Caras-Severin', 'caras-severin'),
(2967, 180, 'Calarasi', 'calarasi'),
(2968, 180, 'Cluj', 'cluj'),
(2969, 180, 'Constanta', 'constanta'),
(2970, 180, 'Covasna', 'covasna'),
(2971, 180, 'Dimbovita', 'dimbovita'),
(2972, 180, 'Dolj', 'dolj'),
(2973, 180, 'Galati', 'galati'),
(2974, 180, 'Giurgiu', 'giurgiu'),
(2975, 180, 'Gorj', 'gorj'),
(2976, 180, 'Harghita', 'harghita'),
(2977, 180, 'Hunedoara', 'hunedoara'),
(2978, 180, 'Ialomita', 'ialomita'),
(2979, 180, 'Iasi', 'iasi'),
(2980, 180, 'Ilfov', 'ilfov'),
(2981, 180, 'Maramures', 'maramures'),
(2982, 180, 'Mehedinti', 'mehedinti'),
(2983, 180, 'Mures', 'mures'),
(2984, 180, 'Neamt', 'neamt'),
(2985, 180, 'Olt', 'olt'),
(2986, 180, 'Prahova', 'prahova'),
(2987, 180, 'Satu-Mare', 'satu-mare'),
(2988, 180, 'Salaj', 'salaj'),
(2989, 180, 'Sibiu', 'sibiu'),
(2990, 180, 'Suceava', 'suceava'),
(2991, 180, 'Teleorman', 'teleorman'),
(2992, 180, 'Timis', 'timis'),
(2993, 180, 'Tulcea', 'tulcea'),
(2994, 180, 'Vaslui', 'vaslui'),
(2995, 180, 'Valcea', 'valcea'),
(2996, 180, 'Vrancea', 'vrancea'),
(2997, 181, 'Abakan', 'abakan'),
(2998, 181, 'Aginskoye', 'aginskoye'),
(2999, 181, 'Anadyr', 'anadyr'),
(3000, 181, 'Arkahangelsk', 'arkahangelsk'),
(3001, 181, 'Astrakhan', 'astrakhan'),
(3002, 181, 'Barnaul', 'barnaul'),
(3003, 181, 'Belgorod', 'belgorod'),
(3004, 181, 'Birobidzhan', 'birobidzhan'),
(3005, 181, 'Blagoveshchensk', 'blagoveshchensk'),
(3006, 181, 'Bryansk', 'bryansk'),
(3007, 181, 'Cheboksary', 'cheboksary'),
(3008, 181, 'Chelyabinsk', 'chelyabinsk'),
(3009, 181, 'Cherkessk', 'cherkessk'),
(3010, 181, 'Chita', 'chita'),
(3011, 181, 'Dudinka', 'dudinka'),
(3012, 181, 'Elista', 'elista'),
(3013, 181, 'Gorno-Altaysk', 'gorno-altaysk'),
(3014, 181, 'Groznyy', 'groznyy'),
(3015, 181, 'Irkutsk', 'irkutsk'),
(3016, 181, 'Ivanovo', 'ivanovo'),
(3017, 181, 'Izhevsk', 'izhevsk'),
(3018, 181, 'Kalinigrad', 'kalinigrad'),
(3019, 181, 'Kaluga', 'kaluga'),
(3020, 181, 'Kasnodar', 'kasnodar'),
(3021, 181, 'Kazan', 'kazan'),
(3022, 181, 'Kemerovo', 'kemerovo'),
(3023, 181, 'Khabarovsk', 'khabarovsk'),
(3024, 181, 'Khanty-Mansiysk', 'khanty-mansiysk'),
(3025, 181, 'Kostroma', 'kostroma'),
(3026, 181, 'Krasnodar', 'krasnodar'),
(3027, 181, 'Krasnoyarsk', 'krasnoyarsk'),
(3028, 181, 'Kudymkar', 'kudymkar'),
(3029, 181, 'Kurgan', 'kurgan'),
(3030, 181, 'Kursk', 'kursk'),
(3031, 181, 'Kyzyl', 'kyzyl'),
(3032, 181, 'Lipetsk', 'lipetsk'),
(3033, 181, 'Magadan', 'magadan'),
(3034, 181, 'Makhachkala', 'makhachkala'),
(3035, 181, 'Maykop', 'maykop'),
(3036, 181, 'Moscow', 'moscow'),
(3037, 181, 'Murmansk', 'murmansk'),
(3038, 181, 'Nalchik', 'nalchik'),
(3039, 181, 'Naryan Mar', 'naryan-mar'),
(3040, 181, 'Nazran', 'nazran'),
(3041, 181, 'Nizhniy Novgorod', 'nizhniy-novgorod'),
(3042, 181, 'Novgorod', 'novgorod'),
(3043, 181, 'Novosibirsk', 'novosibirsk'),
(3044, 181, 'Omsk', 'omsk'),
(3045, 181, 'Orel', 'orel'),
(3046, 181, 'Orenburg', 'orenburg'),
(3047, 181, 'Palana', 'palana'),
(3048, 181, 'Penza', 'penza'),
(3049, 181, 'Perm', 'perm'),
(3050, 181, 'Petropavlovsk-Kamchatskiy', 'petropavlovsk-kamchatskiy'),
(3051, 181, 'Petrozavodsk', 'petrozavodsk'),
(3052, 181, 'Pskov', 'pskov'),
(3053, 181, 'Rostov-na-Donu', 'rostov-na-donu'),
(3054, 181, 'Ryazan', 'ryazan'),
(3055, 181, 'Salekhard', 'salekhard'),
(3056, 181, 'Samara', 'samara'),
(3057, 181, 'Saransk', 'saransk'),
(3058, 181, 'Saratov', 'saratov'),
(3059, 181, 'Smolensk', 'smolensk'),
(3060, 181, 'St. Petersburg', 'st-petersburg'),
(3061, 181, 'Stavropol', 'stavropol'),
(3062, 181, 'Syktyvkar', 'syktyvkar'),
(3063, 181, 'Tambov', 'tambov'),
(3064, 181, 'Tomsk', 'tomsk'),
(3065, 181, 'Tula', 'tula'),
(3066, 181, 'Tura', 'tura'),
(3067, 181, 'Tver', 'tver'),
(3068, 181, 'Tyumen', 'tyumen'),
(3069, 181, 'Ufa', 'ufa'),
(3070, 181, 'Ul\'yanovsk', 'ul-yanovsk'),
(3071, 181, 'Ulan-Ude', 'ulan-ude'),
(3072, 181, 'Ust\'-Ordynskiy', 'ust-ordynskiy'),
(3073, 181, 'Vladikavkaz', 'vladikavkaz'),
(3074, 181, 'Vladimir', 'vladimir'),
(3075, 181, 'Vladivostok', 'vladivostok'),
(3076, 181, 'Volgograd', 'volgograd'),
(3077, 181, 'Vologda', 'vologda'),
(3078, 181, 'Voronezh', 'voronezh'),
(3079, 181, 'Vyatka', 'vyatka'),
(3080, 181, 'Yakutsk', 'yakutsk'),
(3081, 181, 'Yaroslavl', 'yaroslavl'),
(3082, 181, 'Yekaterinburg', 'yekaterinburg'),
(3083, 181, 'Yoshkar-Ola', 'yoshkar-ola'),
(3084, 182, 'Butare', 'butare'),
(3085, 182, 'Byumba', 'byumba'),
(3086, 182, 'Cyangugu', 'cyangugu'),
(3087, 182, 'Gikongoro', 'gikongoro'),
(3088, 182, 'Gisenyi', 'gisenyi'),
(3089, 182, 'Gitarama', 'gitarama'),
(3090, 182, 'Kibungo', 'kibungo'),
(3091, 182, 'Kibuye', 'kibuye'),
(3092, 182, 'Kigali Rurale', 'kigali-rurale'),
(3093, 182, 'Kigali-ville', 'kigali-ville'),
(3094, 182, 'Ruhengeri', 'ruhengeri'),
(3095, 182, 'Umutara', 'umutara'),
(3096, 186, 'Christ Church Nichola Town', 'christ-church-nichola-town'),
(3097, 186, 'Saint Anne Sandy Point', 'saint-anne-sandy-point'),
(3098, 186, 'Saint George Basseterre', 'saint-george-basseterre'),
(3099, 186, 'Saint George Gingerland', 'saint-george-gingerland'),
(3100, 186, 'Saint James Windward', 'saint-james-windward'),
(3101, 186, 'Saint John Capesterre', 'saint-john-capesterre'),
(3102, 186, 'Saint John Figtree', 'saint-john-figtree'),
(3103, 186, 'Saint Mary Cayon', 'saint-mary-cayon'),
(3104, 186, 'Saint Paul Capesterre', 'saint-paul-capesterre'),
(3105, 186, 'Saint Paul Charlestown', 'saint-paul-charlestown'),
(3106, 186, 'Saint Peter Basseterre', 'saint-peter-basseterre'),
(3107, 186, 'Saint Thomas Lowland', 'saint-thomas-lowland'),
(3108, 186, 'Saint Thomas Middle Island', 'saint-thomas-middle-island'),
(3109, 186, 'Trinity Palmetto Point', 'trinity-palmetto-point'),
(3110, 187, 'Anse-la-Raye', 'anse-la-raye'),
(3111, 187, 'Castries', 'castries'),
(3112, 187, 'Choiseul', 'choiseul'),
(3113, 187, 'Dauphin', 'dauphin'),
(3114, 187, 'Dennery', 'dennery'),
(3115, 187, 'Gros-Islet', 'gros-islet'),
(3116, 187, 'Laborie', 'laborie'),
(3117, 187, 'Micoud', 'micoud'),
(3118, 187, 'Praslin', 'praslin'),
(3119, 187, 'Soufriere', 'soufriere'),
(3120, 187, 'Vieux-Fort', 'vieux-fort'),
(3121, 190, 'Charlotte', 'charlotte'),
(3122, 190, 'Grenadines', 'grenadines'),
(3123, 190, 'Saint Andrew', 'saint-andrew'),
(3124, 190, 'Saint David', 'saint-david'),
(3125, 190, 'Saint George', 'saint-george'),
(3126, 190, 'Saint Patrick', 'saint-patrick'),
(3127, 191, 'A\'ana', 'a-ana'),
(3128, 191, 'Aiga-i-le-Tai', 'aiga-i-le-tai'),
(3129, 191, 'Atua', 'atua'),
(3130, 191, 'Fa\'asaleleaga', 'fa-asaleleaga'),
(3131, 191, 'Gaga\'emauga', 'gaga-emauga'),
(3132, 191, 'Gagaifomauga', 'gagaifomauga'),
(3133, 191, 'Palauli', 'palauli'),
(3134, 191, 'Satupa\'itea', 'satupa-itea'),
(3135, 191, 'Tuamasaga', 'tuamasaga'),
(3136, 191, 'Va\'a-o-Fonoti', 'va-a-o-fonoti'),
(3137, 191, 'Vaisigano', 'vaisigano'),
(3138, 192, 'Acquaviva', 'acquaviva'),
(3139, 192, 'Borgo Maggiore', 'borgo-maggiore'),
(3140, 192, 'Chiesanuova', 'chiesanuova'),
(3141, 192, 'Domagnano', 'domagnano'),
(3142, 192, 'Faetano', 'faetano'),
(3143, 192, 'Fiorentino', 'fiorentino'),
(3144, 192, 'Montegiardino', 'montegiardino'),
(3145, 192, 'Citta di San Marino', 'citta-di-san-marino'),
(3146, 192, 'Serravalle', 'serravalle'),
(3147, 193, 'Sao Tome', 'sao-tome'),
(3148, 193, 'Principe', 'principe'),
(3149, 194, 'Al Bahah', 'al-bahah'),
(3150, 194, 'Al Hudud ash Shamaliyah', 'al-hudud-ash-shamaliyah'),
(3151, 194, 'Al Jawf', 'al-jawf'),
(3152, 194, 'Al Madinah', 'al-madinah'),
(3153, 194, 'Al Qasim', 'al-qasim'),
(3154, 194, 'Ar Riyad', 'ar-riyad'),
(3155, 194, 'Ash Sharqiyah (Eastern)', 'ash-sharqiyah-eastern'),
(3156, 194, '\'Asir', 'asir'),
(3157, 194, 'Ha\'il', 'ha-il'),
(3158, 194, 'Jizan', 'jizan'),
(3159, 194, 'Makkah', 'makkah'),
(3160, 194, 'Najran', 'najran'),
(3161, 194, 'Tabuk', 'tabuk'),
(3162, 195, 'Dakar', 'dakar'),
(3163, 195, 'Diourbel', 'diourbel'),
(3164, 195, 'Fatick', 'fatick'),
(3165, 195, 'Kaolack', 'kaolack'),
(3166, 195, 'Kolda', 'kolda'),
(3167, 195, 'Louga', 'louga'),
(3168, 195, 'Matam', 'matam'),
(3169, 195, 'Saint-Louis', 'saint-louis'),
(3170, 195, 'Tambacounda', 'tambacounda'),
(3171, 195, 'Thies', 'thies'),
(3172, 195, 'Ziguinchor', 'ziguinchor'),
(3173, 197, 'Anse aux Pins', 'anse-aux-pins'),
(3174, 197, 'Anse Boileau', 'anse-boileau'),
(3175, 197, 'Anse Etoile', 'anse-etoile'),
(3176, 197, 'Anse Louis', 'anse-louis'),
(3177, 197, 'Anse Royale', 'anse-royale'),
(3178, 197, 'Baie Lazare', 'baie-lazare'),
(3179, 197, 'Baie Sainte Anne', 'baie-sainte-anne'),
(3180, 197, 'Beau Vallon', 'beau-vallon'),
(3181, 197, 'Bel Air', 'bel-air'),
(3182, 197, 'Bel Ombre', 'bel-ombre'),
(3183, 197, 'Cascade', 'cascade'),
(3184, 197, 'Glacis', 'glacis'),
(3185, 197, 'Grand\' Anse (on Mahe)', 'grand-anse-on-mahe'),
(3186, 197, 'Grand\' Anse (on Praslin)', 'grand-anse-on-praslin'),
(3187, 197, 'La Digue', 'la-digue'),
(3188, 197, 'La Riviere Anglaise', 'la-riviere-anglaise'),
(3189, 197, 'Mont Buxton', 'mont-buxton'),
(3190, 197, 'Mont Fleuri', 'mont-fleuri'),
(3191, 197, 'Plaisance', 'plaisance'),
(3192, 197, 'Pointe La Rue', 'pointe-la-rue'),
(3193, 197, 'Port Glaud', 'port-glaud'),
(3194, 197, 'Saint Louis', 'saint-louis'),
(3195, 197, 'Takamaka', 'takamaka'),
(3196, 198, 'Eastern', 'eastern'),
(3197, 198, 'Northern', 'northern'),
(3198, 198, 'Southern', 'southern'),
(3199, 198, 'Western', 'western'),
(3200, 201, 'Banskobystrický', 'banskobystricky'),
(3201, 201, 'Bratislavský', 'bratislavsky'),
(3202, 201, 'Košický', 'kosicky'),
(3203, 201, 'Nitriansky', 'nitriansky'),
(3204, 201, 'Prešovský', 'presovsky'),
(3205, 201, 'Trenčiansky', 'trenciansky'),
(3206, 201, 'Trnavský', 'trnavsky'),
(3207, 201, 'Žilinský', 'zilinsky'),
(3208, 202, 'Pomurska', 'pomurska'),
(3209, 202, 'Podravska', 'podravska'),
(3210, 202, 'Koroška', 'koroska'),
(3211, 202, 'Savinjska', 'savinjska'),
(3212, 202, 'Zasavska', 'zasavska'),
(3213, 202, 'Spodnjeposavska', 'spodnjeposavska'),
(3214, 202, 'Jugovzhodna Slovenija', 'jugovzhodna-slovenija'),
(3215, 202, 'Osrednjeslovenska', 'osrednjeslovenska'),
(3216, 202, 'Gorenjska', 'gorenjska'),
(3217, 202, 'Notranjsko-kraška', 'notranjsko-kraska'),
(3218, 202, 'Goriška', 'goriska'),
(3219, 202, 'Obalno-kraška', 'obalno-kraska'),
(3220, 203, 'Central', 'central'),
(3221, 203, 'Choiseul', 'choiseul'),
(3222, 203, 'Guadalcanal', 'guadalcanal'),
(3223, 203, 'Honiara', 'honiara'),
(3224, 203, 'Isabel', 'isabel'),
(3225, 203, 'Makira', 'makira'),
(3226, 203, 'Malaita', 'malaita'),
(3227, 203, 'Rennell and Bellona', 'rennell-and-bellona'),
(3228, 203, 'Temotu', 'temotu'),
(3229, 203, 'Western', 'western'),
(3230, 204, 'Awdal', 'awdal'),
(3231, 204, 'Bakool', 'bakool'),
(3232, 204, 'Banaadir', 'banaadir'),
(3233, 204, 'Bari', 'bari'),
(3234, 204, 'Bay', 'bay'),
(3235, 204, 'Galguduud', 'galguduud'),
(3236, 204, 'Gedo', 'gedo'),
(3237, 204, 'Hiiraan', 'hiiraan'),
(3238, 204, 'Jubbada Dhexe', 'jubbada-dhexe'),
(3239, 204, 'Jubbada Hoose', 'jubbada-hoose'),
(3240, 204, 'Mudug', 'mudug'),
(3241, 204, 'Nugaal', 'nugaal'),
(3242, 204, 'Sanaag', 'sanaag'),
(3243, 204, 'Shabeellaha Dhexe', 'shabeellaha-dhexe'),
(3244, 204, 'Shabeellaha Hoose', 'shabeellaha-hoose'),
(3245, 204, 'Sool', 'sool'),
(3246, 204, 'Togdheer', 'togdheer'),
(3247, 204, 'Woqooyi Galbeed', 'woqooyi-galbeed'),
(3248, 205, 'Eastern Cape', 'eastern-cape'),
(3249, 205, 'Free State', 'free-state'),
(3250, 205, 'Gauteng', 'gauteng'),
(3251, 205, 'KwaZulu-Natal', 'kwazulu-natal'),
(3252, 205, 'Limpopo', 'limpopo'),
(3253, 205, 'Mpumalanga', 'mpumalanga'),
(3254, 205, 'North West', 'north-west'),
(3255, 205, 'Northern Cape', 'northern-cape'),
(3256, 205, 'Western Cape', 'western-cape'),
(3257, 208, 'La Coruña', 'la-coruna'),
(3258, 208, 'Álava', 'alava'),
(3259, 208, 'Albacete', 'albacete'),
(3260, 208, 'Alicante', 'alicante'),
(3261, 208, 'Almeria', 'almeria'),
(3262, 208, 'Asturias', 'asturias'),
(3263, 208, 'Ávila', 'avila'),
(3264, 208, 'Badajoz', 'badajoz'),
(3265, 208, 'Baleares', 'baleares'),
(3266, 208, 'Barcelona', 'barcelona'),
(3267, 208, 'Burgos', 'burgos'),
(3268, 208, 'Cáceres', 'caceres'),
(3269, 208, 'Cádiz', 'cadiz'),
(3270, 208, 'Cantabria', 'cantabria'),
(3271, 208, 'Castellón', 'castellon'),
(3272, 208, 'Ceuta', 'ceuta'),
(3273, 208, 'Ciudad Real', 'ciudad-real'),
(3274, 208, 'Córdoba', 'cordoba'),
(3275, 208, 'Cuenca', 'cuenca'),
(3276, 208, 'Girona', 'girona'),
(3277, 208, 'Granada', 'granada'),
(3278, 208, 'Guadalajara', 'guadalajara'),
(3279, 208, 'Guipúzcoa', 'guipuzcoa'),
(3280, 208, 'Huelva', 'huelva'),
(3281, 208, 'Huesca', 'huesca'),
(3282, 208, 'Jaén', 'jaen'),
(3283, 208, 'La Rioja', 'la-rioja'),
(3284, 208, 'Las Palmas', 'las-palmas'),
(3285, 208, 'Leon', 'leon'),
(3286, 208, 'Lleida', 'lleida'),
(3287, 208, 'Lugo', 'lugo'),
(3288, 208, 'Madrid', 'madrid'),
(3289, 208, 'Malaga', 'malaga'),
(3290, 208, 'Melilla', 'melilla'),
(3291, 208, 'Murcia', 'murcia'),
(3292, 208, 'Navarra', 'navarra'),
(3293, 208, 'Ourense', 'ourense'),
(3294, 208, 'Palencia', 'palencia'),
(3295, 208, 'Pontevedra', 'pontevedra'),
(3296, 208, 'Salamanca', 'salamanca'),
(3297, 208, 'Santa Cruz de Tenerife', 'santa-cruz-de-tenerife'),
(3298, 208, 'Segovia', 'segovia'),
(3299, 208, 'Sevilla', 'sevilla'),
(3300, 208, 'Soria', 'soria'),
(3301, 208, 'Tarragona', 'tarragona'),
(3302, 208, 'Teruel', 'teruel'),
(3303, 208, 'Toledo', 'toledo'),
(3304, 208, 'Valencia', 'valencia'),
(3305, 208, 'Valladolid', 'valladolid'),
(3306, 208, 'Vizcaya', 'vizcaya'),
(3307, 208, 'Zamora', 'zamora'),
(3308, 208, 'Zaragoza', 'zaragoza'),
(3309, 209, 'Central', 'central'),
(3310, 209, 'Eastern', 'eastern'),
(3311, 209, 'North Central', 'north-central'),
(3312, 209, 'Northern', 'northern'),
(3313, 209, 'North Western', 'north-western'),
(3314, 209, 'Sabaragamuwa', 'sabaragamuwa'),
(3315, 209, 'Southern', 'southern'),
(3316, 209, 'Uva', 'uva'),
(3317, 209, 'Western', 'western'),
(3318, 185, 'Saint Helena', 'saint-helena'),
(3319, 189, 'Saint Pierre', 'saint-pierre'),
(3320, 189, 'Miquelon', 'miquelon'),
(3321, 210, 'A\'ali an Nil', 'a-ali-an-nil'),
(3322, 210, 'Al Bahr al Ahmar', 'al-bahr-al-ahmar'),
(3323, 210, 'Al Buhayrat', 'al-buhayrat'),
(3324, 210, 'Al Jazirah', 'al-jazirah'),
(3325, 210, 'Al Khartum', 'al-khartum'),
(3326, 210, 'Al Qadarif', 'al-qadarif'),
(3327, 210, 'Al Wahdah', 'al-wahdah'),
(3328, 210, 'An Nil al Abyad', 'an-nil-al-abyad'),
(3329, 210, 'An Nil al Azraq', 'an-nil-al-azraq'),
(3330, 210, 'Ash Shamaliyah', 'ash-shamaliyah'),
(3331, 210, 'Bahr al Jabal', 'bahr-al-jabal'),
(3332, 210, 'Gharb al Istiwa\'iyah', 'gharb-al-istiwa-iyah'),
(3333, 210, 'Gharb Bahr al Ghazal', 'gharb-bahr-al-ghazal'),
(3334, 210, 'Gharb Darfur', 'gharb-darfur'),
(3335, 210, 'Gharb Kurdufan', 'gharb-kurdufan'),
(3336, 210, 'Janub Darfur', 'janub-darfur'),
(3337, 210, 'Janub Kurdufan', 'janub-kurdufan'),
(3338, 210, 'Junqali', 'junqali'),
(3339, 210, 'Kassala', 'kassala'),
(3340, 210, 'Nahr an Nil', 'nahr-an-nil'),
(3341, 210, 'Shamal Bahr al Ghazal', 'shamal-bahr-al-ghazal'),
(3342, 210, 'Shamal Darfur', 'shamal-darfur'),
(3343, 210, 'Shamal Kurdufan', 'shamal-kurdufan'),
(3344, 210, 'Sharq al Istiwa\'iyah', 'sharq-al-istiwa-iyah'),
(3345, 210, 'Sinnar', 'sinnar'),
(3346, 210, 'Warab', 'warab'),
(3347, 211, 'Brokopondo', 'brokopondo'),
(3348, 211, 'Commewijne', 'commewijne'),
(3349, 211, 'Coronie', 'coronie'),
(3350, 211, 'Marowijne', 'marowijne'),
(3351, 211, 'Nickerie', 'nickerie'),
(3352, 211, 'Para', 'para'),
(3353, 211, 'Paramaribo', 'paramaribo'),
(3354, 211, 'Saramacca', 'saramacca'),
(3355, 211, 'Sipaliwini', 'sipaliwini'),
(3356, 211, 'Wanica', 'wanica'),
(3357, 213, 'Hhohho', 'hhohho'),
(3358, 213, 'Lubombo', 'lubombo'),
(3359, 213, 'Manzini', 'manzini'),
(3360, 213, 'Shishelweni', 'shishelweni'),
(3361, 214, 'Blekinge', 'blekinge'),
(3362, 214, 'Dalarna', 'dalarna'),
(3363, 214, 'Gävleborg', 'gavleborg'),
(3364, 214, 'Gotland', 'gotland'),
(3365, 214, 'Halland', 'halland'),
(3366, 214, 'Jämtland', 'jamtland'),
(3367, 214, 'Jönköping', 'jonkoping'),
(3368, 214, 'Kalmar', 'kalmar'),
(3369, 214, 'Kronoberg', 'kronoberg'),
(3370, 214, 'Norrbotten', 'norrbotten'),
(3371, 214, 'Örebro', 'orebro'),
(3372, 214, 'Östergötland', 'ostergotland'),
(3373, 214, 'Skåne', 'skane'),
(3374, 214, 'Södermanland', 'sodermanland'),
(3375, 214, 'Stockholm', 'stockholm'),
(3376, 214, 'Uppsala', 'uppsala'),
(3377, 214, 'Värmland', 'varmland'),
(3378, 214, 'Västerbotten', 'vasterbotten'),
(3379, 214, 'Västernorrland', 'vasternorrland'),
(3380, 214, 'Västmanland', 'vastmanland'),
(3381, 214, 'Västra Götaland', 'vastra-gotaland'),
(3382, 215, 'Aargau', 'aargau'),
(3383, 215, 'Appenzell Ausserrhoden', 'appenzell-ausserrhoden'),
(3384, 215, 'Appenzell Innerrhoden', 'appenzell-innerrhoden'),
(3385, 215, 'Basel-Stadt', 'basel-stadt'),
(3386, 215, 'Basel-Landschaft', 'basel-landschaft'),
(3387, 215, 'Bern', 'bern'),
(3388, 215, 'Fribourg', 'fribourg'),
(3389, 215, 'Genève', 'geneve'),
(3390, 215, 'Glarus', 'glarus'),
(3391, 215, 'Graubünden', 'graubunden'),
(3392, 215, 'Jura', 'jura'),
(3393, 215, 'Luzern', 'luzern'),
(3394, 215, 'Neuchâtel', 'neuchatel'),
(3395, 215, 'Nidwald', 'nidwald'),
(3396, 215, 'Obwald', 'obwald'),
(3397, 215, 'St. Gallen', 'st-gallen'),
(3398, 215, 'Schaffhausen', 'schaffhausen'),
(3399, 215, 'Schwyz', 'schwyz'),
(3400, 215, 'Solothurn', 'solothurn'),
(3401, 215, 'Thurgau', 'thurgau'),
(3402, 215, 'Ticino', 'ticino'),
(3403, 215, 'Uri', 'uri'),
(3404, 215, 'Valais', 'valais'),
(3405, 215, 'Vaud', 'vaud'),
(3406, 215, 'Zug', 'zug'),
(3407, 215, 'Zürich', 'zurich'),
(3408, 216, 'Al Hasakah', 'al-hasakah'),
(3409, 216, 'Al Ladhiqiyah', 'al-ladhiqiyah'),
(3410, 216, 'Al Qunaytirah', 'al-qunaytirah'),
(3411, 216, 'Ar Raqqah', 'ar-raqqah'),
(3412, 216, 'As Suwayda', 'as-suwayda'),
(3413, 216, 'Dara', 'dara'),
(3414, 216, 'Dayr az Zawr', 'dayr-az-zawr'),
(3415, 216, 'Dimashq', 'dimashq'),
(3416, 216, 'Halab', 'halab'),
(3417, 216, 'Hamah', 'hamah'),
(3418, 216, 'Hims', 'hims'),
(3419, 216, 'Idlib', 'idlib'),
(3420, 216, 'Rif Dimashq', 'rif-dimashq'),
(3421, 216, 'Tartus', 'tartus'),
(3422, 217, 'Chang-hua', 'chang-hua'),
(3423, 217, 'Chia-i', 'chia-i'),
(3424, 217, 'Hsin-chu', 'hsin-chu'),
(3425, 217, 'Hua-lien', 'hua-lien'),
(3426, 217, 'I-lan', 'i-lan'),
(3427, 217, 'Kao-hsiung county', 'kao-hsiung-county'),
(3428, 217, 'Kin-men', 'kin-men'),
(3429, 217, 'Lien-chiang', 'lien-chiang'),
(3430, 217, 'Miao-li', 'miao-li'),
(3431, 217, 'Nan-t\'ou', 'nan-t-ou'),
(3432, 217, 'P\'eng-hu', 'p-eng-hu'),
(3433, 217, 'P\'ing-tung', 'p-ing-tung'),
(3434, 217, 'T\'ai-chung', 't-ai-chung'),
(3435, 217, 'T\'ai-nan', 't-ai-nan'),
(3436, 217, 'T\'ai-pei county', 't-ai-pei-county'),
(3437, 217, 'T\'ai-tung', 't-ai-tung'),
(3438, 217, 'T\'ao-yuan', 't-ao-yuan'),
(3439, 217, 'Yun-lin', 'yun-lin'),
(3440, 217, 'Chia-i city', 'chia-i-city'),
(3441, 217, 'Chi-lung', 'chi-lung'),
(3442, 217, 'Hsin-chu', 'hsin-chu'),
(3443, 217, 'T\'ai-chung', 't-ai-chung'),
(3444, 217, 'T\'ai-nan', 't-ai-nan'),
(3445, 217, 'Kao-hsiung city', 'kao-hsiung-city'),
(3446, 217, 'T\'ai-pei city', 't-ai-pei-city'),
(3447, 218, 'Gorno-Badakhstan', 'gorno-badakhstan'),
(3448, 218, 'Khatlon', 'khatlon'),
(3449, 218, 'Sughd', 'sughd'),
(3450, 219, 'Arusha', 'arusha'),
(3451, 219, 'Dar es Salaam', 'dar-es-salaam'),
(3452, 219, 'Dodoma', 'dodoma'),
(3453, 219, 'Iringa', 'iringa'),
(3454, 219, 'Kagera', 'kagera'),
(3455, 219, 'Kigoma', 'kigoma'),
(3456, 219, 'Kilimanjaro', 'kilimanjaro'),
(3457, 219, 'Lindi', 'lindi'),
(3458, 219, 'Manyara', 'manyara'),
(3459, 219, 'Mara', 'mara'),
(3460, 219, 'Mbeya', 'mbeya'),
(3461, 219, 'Morogoro', 'morogoro'),
(3462, 219, 'Mtwara', 'mtwara'),
(3463, 219, 'Mwanza', 'mwanza'),
(3464, 219, 'Pemba North', 'pemba-north'),
(3465, 219, 'Pemba South', 'pemba-south'),
(3466, 219, 'Pwani', 'pwani'),
(3467, 219, 'Rukwa', 'rukwa'),
(3468, 219, 'Ruvuma', 'ruvuma'),
(3469, 219, 'Shinyanga', 'shinyanga'),
(3470, 219, 'Singida', 'singida'),
(3471, 219, 'Tabora', 'tabora'),
(3472, 219, 'Tanga', 'tanga'),
(3473, 219, 'Zanzibar Central/South', 'zanzibar-central-south'),
(3474, 219, 'Zanzibar North', 'zanzibar-north'),
(3475, 219, 'Zanzibar Urban/West', 'zanzibar-urban-west'),
(3476, 220, 'Amnat Charoen', 'amnat-charoen'),
(3477, 220, 'Ang Thong', 'ang-thong'),
(3478, 220, 'Ayutthaya', 'ayutthaya'),
(3479, 220, 'Bangkok', 'bangkok'),
(3480, 220, 'Buriram', 'buriram'),
(3481, 220, 'Chachoengsao', 'chachoengsao'),
(3482, 220, 'Chai Nat', 'chai-nat'),
(3483, 220, 'Chaiyaphum', 'chaiyaphum'),
(3484, 220, 'Chanthaburi', 'chanthaburi'),
(3485, 220, 'Chiang Mai', 'chiang-mai'),
(3486, 220, 'Chiang Rai', 'chiang-rai'),
(3487, 220, 'Chon Buri', 'chon-buri'),
(3488, 220, 'Chumphon', 'chumphon'),
(3489, 220, 'Kalasin', 'kalasin'),
(3490, 220, 'Kamphaeng Phet', 'kamphaeng-phet'),
(3491, 220, 'Kanchanaburi', 'kanchanaburi'),
(3492, 220, 'Khon Kaen', 'khon-kaen'),
(3493, 220, 'Krabi', 'krabi'),
(3494, 220, 'Lampang', 'lampang'),
(3495, 220, 'Lamphun', 'lamphun'),
(3496, 220, 'Loei', 'loei'),
(3497, 220, 'Lop Buri', 'lop-buri'),
(3498, 220, 'Mae Hong Son', 'mae-hong-son'),
(3499, 220, 'Maha Sarakham', 'maha-sarakham'),
(3500, 220, 'Mukdahan', 'mukdahan'),
(3501, 220, 'Nakhon Nayok', 'nakhon-nayok'),
(3502, 220, 'Nakhon Pathom', 'nakhon-pathom'),
(3503, 220, 'Nakhon Phanom', 'nakhon-phanom'),
(3504, 220, 'Nakhon Ratchasima', 'nakhon-ratchasima'),
(3505, 220, 'Nakhon Sawan', 'nakhon-sawan'),
(3506, 220, 'Nakhon Si Thammarat', 'nakhon-si-thammarat'),
(3507, 220, 'Nan', 'nan'),
(3508, 220, 'Narathiwat', 'narathiwat'),
(3509, 220, 'Nong Bua Lamphu', 'nong-bua-lamphu'),
(3510, 220, 'Nong Khai', 'nong-khai'),
(3511, 220, 'Nonthaburi', 'nonthaburi'),
(3512, 220, 'Pathum Thani', 'pathum-thani'),
(3513, 220, 'Pattani', 'pattani'),
(3514, 220, 'Phangnga', 'phangnga'),
(3515, 220, 'Phatthalung', 'phatthalung'),
(3516, 220, 'Phayao', 'phayao'),
(3517, 220, 'Phetchabun', 'phetchabun'),
(3518, 220, 'Phetchaburi', 'phetchaburi'),
(3519, 220, 'Phichit', 'phichit'),
(3520, 220, 'Phitsanulok', 'phitsanulok'),
(3521, 220, 'Phrae', 'phrae'),
(3522, 220, 'Phuket', 'phuket'),
(3523, 220, 'Prachin Buri', 'prachin-buri'),
(3524, 220, 'Prachuap Khiri Khan', 'prachuap-khiri-khan'),
(3525, 220, 'Ranong', 'ranong'),
(3526, 220, 'Ratchaburi', 'ratchaburi'),
(3527, 220, 'Rayong', 'rayong'),
(3528, 220, 'Roi Et', 'roi-et'),
(3529, 220, 'Sa Kaeo', 'sa-kaeo'),
(3530, 220, 'Sakon Nakhon', 'sakon-nakhon'),
(3531, 220, 'Samut Prakan', 'samut-prakan'),
(3532, 220, 'Samut Sakhon', 'samut-sakhon'),
(3533, 220, 'Samut Songkhram', 'samut-songkhram'),
(3534, 220, 'Sara Buri', 'sara-buri'),
(3535, 220, 'Satun', 'satun'),
(3536, 220, 'Sing Buri', 'sing-buri'),
(3537, 220, 'Sisaket', 'sisaket'),
(3538, 220, 'Songkhla', 'songkhla'),
(3539, 220, 'Sukhothai', 'sukhothai'),
(3540, 220, 'Suphan Buri', 'suphan-buri'),
(3541, 220, 'Surat Thani', 'surat-thani'),
(3542, 220, 'Surin', 'surin'),
(3543, 220, 'Tak', 'tak'),
(3544, 220, 'Trang', 'trang'),
(3545, 220, 'Trat', 'trat'),
(3546, 220, 'Ubon Ratchathani', 'ubon-ratchathani'),
(3547, 220, 'Udon Thani', 'udon-thani'),
(3548, 220, 'Uthai Thani', 'uthai-thani'),
(3549, 220, 'Uttaradit', 'uttaradit'),
(3550, 220, 'Yala', 'yala'),
(3551, 220, 'Yasothon', 'yasothon'),
(3552, 222, 'Kara', 'kara'),
(3553, 222, 'Plateaux', 'plateaux'),
(3554, 222, 'Savanes', 'savanes'),
(3555, 222, 'Centrale', 'centrale'),
(3556, 222, 'Maritime', 'maritime'),
(3557, 223, 'Atafu', 'atafu'),
(3558, 223, 'Fakaofo', 'fakaofo'),
(3559, 223, 'Nukunonu', 'nukunonu'),
(3560, 224, 'Ha\'apai', 'ha-apai'),
(3561, 224, 'Tongatapu', 'tongatapu'),
(3562, 224, 'Vava\'u', 'vava-u'),
(3563, 225, 'Couva/Tabaquite/Talparo', 'couva-tabaquite-talparo'),
(3564, 225, 'Diego Martin', 'diego-martin'),
(3565, 225, 'Mayaro/Rio Claro', 'mayaro-rio-claro'),
(3566, 225, 'Penal/Debe', 'penal-debe'),
(3567, 225, 'Princes Town', 'princes-town'),
(3568, 225, 'Sangre Grande', 'sangre-grande'),
(3569, 225, 'San Juan/Laventille', 'san-juan-laventille'),
(3570, 225, 'Siparia', 'siparia'),
(3571, 225, 'Tunapuna/Piarco', 'tunapuna-piarco'),
(3572, 225, 'Port of Spain', 'port-of-spain'),
(3573, 225, 'San Fernando', 'san-fernando'),
(3574, 225, 'Arima', 'arima'),
(3575, 225, 'Point Fortin', 'point-fortin'),
(3576, 225, 'Chaguanas', 'chaguanas'),
(3577, 225, 'Tobago', 'tobago'),
(3578, 226, 'Ariana', 'ariana'),
(3579, 226, 'Beja', 'beja'),
(3580, 226, 'Ben Arous', 'ben-arous'),
(3581, 226, 'Bizerte', 'bizerte'),
(3582, 226, 'Gabes', 'gabes'),
(3583, 226, 'Gafsa', 'gafsa'),
(3584, 226, 'Jendouba', 'jendouba'),
(3585, 226, 'Kairouan', 'kairouan'),
(3586, 226, 'Kasserine', 'kasserine'),
(3587, 226, 'Kebili', 'kebili'),
(3588, 226, 'Kef', 'kef'),
(3589, 226, 'Mahdia', 'mahdia'),
(3590, 226, 'Manouba', 'manouba'),
(3591, 226, 'Medenine', 'medenine'),
(3592, 226, 'Monastir', 'monastir'),
(3593, 226, 'Nabeul', 'nabeul'),
(3594, 226, 'Sfax', 'sfax'),
(3595, 226, 'Sidi', 'sidi'),
(3596, 226, 'Siliana', 'siliana'),
(3597, 226, 'Sousse', 'sousse'),
(3598, 226, 'Tataouine', 'tataouine'),
(3599, 226, 'Tozeur', 'tozeur'),
(3600, 226, 'Tunis', 'tunis'),
(3601, 226, 'Zaghouan', 'zaghouan'),
(3602, 228, 'Ahal Welayaty', 'ahal-welayaty'),
(3603, 228, 'Balkan Welayaty', 'balkan-welayaty'),
(3604, 228, 'Dashhowuz Welayaty', 'dashhowuz-welayaty'),
(3605, 228, 'Lebap Welayaty', 'lebap-welayaty'),
(3606, 228, 'Mary Welayaty', 'mary-welayaty'),
(3607, 229, 'Ambergris Cays', 'ambergris-cays'),
(3608, 229, 'Dellis Cay', 'dellis-cay'),
(3609, 229, 'French Cay', 'french-cay'),
(3610, 229, 'Little Water Cay', 'little-water-cay'),
(3611, 229, 'Parrot Cay', 'parrot-cay'),
(3612, 229, 'Pine Cay', 'pine-cay'),
(3613, 229, 'Salt Cay', 'salt-cay'),
(3614, 229, 'Grand Turk', 'grand-turk'),
(3615, 229, 'South Caicos', 'south-caicos'),
(3616, 229, 'East Caicos', 'east-caicos'),
(3617, 229, 'Middle Caicos', 'middle-caicos'),
(3618, 229, 'North Caicos', 'north-caicos'),
(3619, 229, 'Providenciales', 'providenciales'),
(3620, 229, 'West Caicos', 'west-caicos'),
(3621, 230, 'Nanumanga', 'nanumanga'),
(3622, 230, 'Niulakita', 'niulakita'),
(3623, 230, 'Niutao', 'niutao'),
(3624, 230, 'Funafuti', 'funafuti'),
(3625, 230, 'Nanumea', 'nanumea'),
(3626, 230, 'Nui', 'nui'),
(3627, 230, 'Nukufetau', 'nukufetau'),
(3628, 230, 'Nukulaelae', 'nukulaelae'),
(3629, 230, 'Vaitupu', 'vaitupu'),
(3630, 231, 'Kalangala', 'kalangala'),
(3631, 231, 'Kampala', 'kampala'),
(3632, 231, 'Kayunga', 'kayunga'),
(3633, 231, 'Kiboga', 'kiboga'),
(3634, 231, 'Luwero', 'luwero'),
(3635, 231, 'Masaka', 'masaka'),
(3636, 231, 'Mpigi', 'mpigi'),
(3637, 231, 'Mubende', 'mubende'),
(3638, 231, 'Mukono', 'mukono'),
(3639, 231, 'Nakasongola', 'nakasongola'),
(3640, 231, 'Rakai', 'rakai'),
(3641, 231, 'Sembabule', 'sembabule'),
(3642, 231, 'Wakiso', 'wakiso'),
(3643, 231, 'Bugiri', 'bugiri'),
(3644, 231, 'Busia', 'busia'),
(3645, 231, 'Iganga', 'iganga'),
(3646, 231, 'Jinja', 'jinja'),
(3647, 231, 'Kaberamaido', 'kaberamaido'),
(3648, 231, 'Kamuli', 'kamuli'),
(3649, 231, 'Kapchorwa', 'kapchorwa'),
(3650, 231, 'Katakwi', 'katakwi'),
(3651, 231, 'Kumi', 'kumi'),
(3652, 231, 'Mayuge', 'mayuge'),
(3653, 231, 'Mbale', 'mbale'),
(3654, 231, 'Pallisa', 'pallisa'),
(3655, 231, 'Sironko', 'sironko'),
(3656, 231, 'Soroti', 'soroti'),
(3657, 231, 'Tororo', 'tororo'),
(3658, 231, 'Adjumani', 'adjumani'),
(3659, 231, 'Apac', 'apac'),
(3660, 231, 'Arua', 'arua'),
(3661, 231, 'Gulu', 'gulu'),
(3662, 231, 'Kitgum', 'kitgum'),
(3663, 231, 'Kotido', 'kotido'),
(3664, 231, 'Lira', 'lira'),
(3665, 231, 'Moroto', 'moroto'),
(3666, 231, 'Moyo', 'moyo'),
(3667, 231, 'Nakapiripirit', 'nakapiripirit'),
(3668, 231, 'Nebbi', 'nebbi'),
(3669, 231, 'Pader', 'pader'),
(3670, 231, 'Yumbe', 'yumbe'),
(3671, 231, 'Bundibugyo', 'bundibugyo'),
(3672, 231, 'Bushenyi', 'bushenyi'),
(3673, 231, 'Hoima', 'hoima'),
(3674, 231, 'Kabale', 'kabale'),
(3675, 231, 'Kabarole', 'kabarole'),
(3676, 231, 'Kamwenge', 'kamwenge'),
(3677, 231, 'Kanungu', 'kanungu'),
(3678, 231, 'Kasese', 'kasese'),
(3679, 231, 'Kibaale', 'kibaale'),
(3680, 231, 'Kisoro', 'kisoro'),
(3681, 231, 'Kyenjojo', 'kyenjojo'),
(3682, 231, 'Masindi', 'masindi'),
(3683, 231, 'Mbarara', 'mbarara'),
(3684, 231, 'Ntungamo', 'ntungamo'),
(3685, 231, 'Rukungiri', 'rukungiri'),
(3686, 232, 'Cherkas\'ka Oblast\'', 'cherkas-ka-oblast'),
(3687, 232, 'Chernihivs\'ka Oblast\'', 'chernihivs-ka-oblast'),
(3688, 232, 'Chernivets\'ka Oblast\'', 'chernivets-ka-oblast'),
(3689, 232, 'Crimea', 'crimea'),
(3690, 232, 'Dnipropetrovs\'ka Oblast\'', 'dnipropetrovs-ka-oblast'),
(3691, 232, 'Donets\'ka Oblast\'', 'donets-ka-oblast'),
(3692, 232, 'Ivano-Frankivs\'ka Oblast\'', 'ivano-frankivs-ka-oblast'),
(3693, 232, 'Khersons\'ka Oblast\'', 'khersons-ka-oblast'),
(3694, 232, 'Khmel\'nyts\'ka Oblast\'', 'khmel-nyts-ka-oblast'),
(3695, 232, 'Kirovohrads\'ka Oblast\'', 'kirovohrads-ka-oblast'),
(3696, 232, 'Kyiv', 'kyiv'),
(3697, 232, 'Kyivs\'ka Oblast\'', 'kyivs-ka-oblast'),
(3698, 232, 'Luhans\'ka Oblast\'', 'luhans-ka-oblast'),
(3699, 232, 'L\'vivs\'ka Oblast\'', 'l-vivs-ka-oblast'),
(3700, 232, 'Mykolayivs\'ka Oblast\'', 'mykolayivs-ka-oblast'),
(3701, 232, 'Odes\'ka Oblast\'', 'odes-ka-oblast'),
(3702, 232, 'Poltavs\'ka Oblast\'', 'poltavs-ka-oblast'),
(3703, 232, 'Rivnens\'ka Oblast\'', 'rivnens-ka-oblast'),
(3704, 232, 'Sevastopol\'', 'sevastopol'),
(3705, 232, 'Sums\'ka Oblast\'', 'sums-ka-oblast'),
(3706, 232, 'Ternopil\'s\'ka Oblast\'', 'ternopil-s-ka-oblast'),
(3707, 232, 'Vinnyts\'ka Oblast\'', 'vinnyts-ka-oblast'),
(3708, 232, 'Volyns\'ka Oblast\'', 'volyns-ka-oblast'),
(3709, 232, 'Zakarpats\'ka Oblast\'', 'zakarpats-ka-oblast'),
(3710, 232, 'Zaporiz\'ka Oblast\'', 'zaporiz-ka-oblast'),
(3711, 232, 'Zhytomyrs\'ka oblast\'', 'zhytomyrs-ka-oblast'),
(3712, 232, 'Kharkivs\'ka Oblast\'', 'kharkivs-ka-oblast'),
(3713, 233, 'Abu Dhabi', 'abu-dhabi'),
(3714, 233, '\'Ajman', 'ajman'),
(3715, 233, 'Al Fujayrah', 'al-fujayrah'),
(3716, 233, 'Ash Shariqah', 'ash-shariqah'),
(3717, 233, 'Dubai', 'dubai'),
(3718, 233, 'R\'as al Khaymah', 'r-as-al-khaymah'),
(3719, 233, 'Umm al Qaywayn', 'umm-al-qaywayn'),
(3720, 234, 'Aberdeen', 'aberdeen'),
(3721, 234, 'Aberdeenshire', 'aberdeenshire'),
(3722, 234, 'Anglesey', 'anglesey'),
(3723, 234, 'Angus', 'angus'),
(3724, 234, 'Argyll and Bute', 'argyll-and-bute'),
(3725, 234, 'Bedfordshire', 'bedfordshire'),
(3726, 234, 'Berkshire', 'berkshire'),
(3727, 234, 'Blaenau Gwent', 'blaenau-gwent'),
(3728, 234, 'Bridgend', 'bridgend'),
(3729, 234, 'Bristol', 'bristol'),
(3730, 234, 'Buckinghamshire', 'buckinghamshire'),
(3731, 234, 'Caerphilly', 'caerphilly'),
(3732, 234, 'Cambridgeshire', 'cambridgeshire'),
(3733, 234, 'Cardiff', 'cardiff'),
(3734, 234, 'Carmarthenshire', 'carmarthenshire'),
(3735, 234, 'Ceredigion', 'ceredigion'),
(3736, 234, 'Cheshire', 'cheshire'),
(3737, 234, 'Clackmannanshire', 'clackmannanshire'),
(3738, 234, 'Conwy', 'conwy'),
(3739, 234, 'Cornwall', 'cornwall'),
(3740, 234, 'Denbighshire', 'denbighshire'),
(3741, 234, 'Derbyshire', 'derbyshire'),
(3742, 234, 'Devon', 'devon'),
(3743, 234, 'Dorset', 'dorset'),
(3744, 234, 'Dumfries and Galloway', 'dumfries-and-galloway'),
(3745, 234, 'Dundee', 'dundee'),
(3746, 234, 'Durham', 'durham'),
(3747, 234, 'East Ayrshire', 'east-ayrshire'),
(3748, 234, 'East Dunbartonshire', 'east-dunbartonshire'),
(3749, 234, 'East Lothian', 'east-lothian'),
(3750, 234, 'East Renfrewshire', 'east-renfrewshire'),
(3751, 234, 'East Riding of Yorkshire', 'east-riding-of-yorkshire'),
(3752, 234, 'East Sussex', 'east-sussex'),
(3753, 234, 'Edinburgh', 'edinburgh'),
(3754, 234, 'Essex', 'essex'),
(3755, 234, 'Falkirk', 'falkirk'),
(3756, 234, 'Fife', 'fife'),
(3757, 234, 'Flintshire', 'flintshire'),
(3758, 234, 'Glasgow', 'glasgow'),
(3759, 234, 'Gloucestershire', 'gloucestershire'),
(3760, 234, 'Greater London', 'greater-london'),
(3761, 234, 'Greater Manchester', 'greater-manchester'),
(3762, 234, 'Gwynedd', 'gwynedd'),
(3763, 234, 'Hampshire', 'hampshire'),
(3764, 234, 'Herefordshire', 'herefordshire'),
(3765, 234, 'Hertfordshire', 'hertfordshire'),
(3766, 234, 'Highlands', 'highlands'),
(3767, 234, 'Inverclyde', 'inverclyde'),
(3768, 234, 'Isle of Wight', 'isle-of-wight'),
(3769, 234, 'Kent', 'kent'),
(3770, 234, 'Lancashire', 'lancashire'),
(3771, 234, 'Leicestershire', 'leicestershire'),
(3772, 234, 'Lincolnshire', 'lincolnshire'),
(3773, 234, 'Merseyside', 'merseyside'),
(3774, 234, 'Merthyr Tydfil', 'merthyr-tydfil'),
(3775, 234, 'Midlothian', 'midlothian'),
(3776, 234, 'Monmouthshire', 'monmouthshire'),
(3777, 234, 'Moray', 'moray'),
(3778, 234, 'Neath Port Talbot', 'neath-port-talbot'),
(3779, 234, 'Newport', 'newport'),
(3780, 234, 'Norfolk', 'norfolk'),
(3781, 234, 'North Ayrshire', 'north-ayrshire'),
(3782, 234, 'North Lanarkshire', 'north-lanarkshire'),
(3783, 234, 'North Yorkshire', 'north-yorkshire'),
(3784, 234, 'Northamptonshire', 'northamptonshire'),
(3785, 234, 'Northumberland', 'northumberland'),
(3786, 234, 'Nottinghamshire', 'nottinghamshire'),
(3787, 234, 'Orkney Islands', 'orkney-islands'),
(3788, 234, 'Oxfordshire', 'oxfordshire'),
(3789, 234, 'Pembrokeshire', 'pembrokeshire'),
(3790, 234, 'Perth and Kinross', 'perth-and-kinross'),
(3791, 234, 'Powys', 'powys'),
(3792, 234, 'Renfrewshire', 'renfrewshire'),
(3793, 234, 'Rhondda Cynon Taff', 'rhondda-cynon-taff'),
(3794, 234, 'Rutland', 'rutland'),
(3795, 234, 'Scottish Borders', 'scottish-borders'),
(3796, 234, 'Shetland Islands', 'shetland-islands'),
(3797, 234, 'Shropshire', 'shropshire'),
(3798, 234, 'Somerset', 'somerset'),
(3799, 234, 'South Ayrshire', 'south-ayrshire'),
(3800, 234, 'South Lanarkshire', 'south-lanarkshire'),
(3801, 234, 'South Yorkshire', 'south-yorkshire'),
(3802, 234, 'Staffordshire', 'staffordshire'),
(3803, 234, 'Stirling', 'stirling'),
(3804, 234, 'Suffolk', 'suffolk'),
(3805, 234, 'Surrey', 'surrey'),
(3806, 234, 'Swansea', 'swansea'),
(3807, 234, 'Torfaen', 'torfaen'),
(3808, 234, 'Tyne and Wear', 'tyne-and-wear'),
(3809, 234, 'Vale of Glamorgan', 'vale-of-glamorgan'),
(3810, 234, 'Warwickshire', 'warwickshire'),
(3811, 234, 'West Dunbartonshire', 'west-dunbartonshire'),
(3812, 234, 'West Lothian', 'west-lothian'),
(3813, 234, 'West Midlands', 'west-midlands'),
(3814, 234, 'West Sussex', 'west-sussex'),
(3815, 234, 'West Yorkshire', 'west-yorkshire'),
(3816, 234, 'Western Isles', 'western-isles'),
(3817, 234, 'Wiltshire', 'wiltshire'),
(3818, 234, 'Worcestershire', 'worcestershire'),
(3819, 234, 'Wrexham', 'wrexham'),
(3820, 234, 'County Antrim', 'county-antrim'),
(3821, 234, 'County Armagh', 'county-armagh'),
(3822, 234, 'County Down', 'county-down'),
(3823, 234, 'County Fermanagh', 'county-fermanagh'),
(3824, 234, 'County Londonderry', 'county-londonderry'),
(3825, 234, 'County Tyrone', 'county-tyrone'),
(3826, 234, 'Cumbria', 'cumbria'),
(3827, 235, 'Alabama', 'alabama'),
(3828, 235, 'Alaska', 'alaska'),
(3829, 235, 'American Samoa', 'american-samoa'),
(3830, 235, 'Arizona', 'arizona'),
(3831, 235, 'Arkansas', 'arkansas'),
(3832, 235, 'Armed Forces Africa', 'armed-forces-africa'),
(3833, 235, 'Armed Forces Americas', 'armed-forces-americas'),
(3834, 235, 'Armed Forces Canada', 'armed-forces-canada'),
(3835, 235, 'Armed Forces Europe', 'armed-forces-europe'),
(3836, 235, 'Armed Forces Middle East', 'armed-forces-middle-east'),
(3837, 235, 'Armed Forces Pacific', 'armed-forces-pacific'),
(3838, 235, 'California', 'california'),
(3839, 235, 'Colorado', 'colorado'),
(3840, 235, 'Connecticut', 'connecticut'),
(3841, 235, 'Delaware', 'delaware'),
(3842, 235, 'District of Columbia', 'district-of-columbia'),
(3843, 235, 'Federated States Of Micronesia', 'federated-states-of-micronesia'),
(3844, 235, 'Florida', 'florida'),
(3845, 235, 'Georgia', 'georgia'),
(3846, 235, 'Guam', 'guam'),
(3847, 235, 'Hawaii', 'hawaii'),
(3848, 235, 'Idaho', 'idaho'),
(3849, 235, 'Illinois', 'illinois'),
(3850, 235, 'Indiana', 'indiana'),
(3851, 235, 'Iowa', 'iowa'),
(3852, 235, 'Kansas', 'kansas'),
(3853, 235, 'Kentucky', 'kentucky'),
(3854, 235, 'Louisiana', 'louisiana'),
(3855, 235, 'Maine', 'maine'),
(3856, 235, 'Marshall Islands', 'marshall-islands'),
(3857, 235, 'Maryland', 'maryland'),
(3858, 235, 'Massachusetts', 'massachusetts'),
(3859, 235, 'Michigan', 'michigan'),
(3860, 235, 'Minnesota', 'minnesota'),
(3861, 235, 'Mississippi', 'mississippi'),
(3862, 235, 'Missouri', 'missouri'),
(3863, 235, 'Montana', 'montana'),
(3864, 235, 'Nebraska', 'nebraska'),
(3865, 235, 'Nevada', 'nevada'),
(3866, 235, 'New Hampshire', 'new-hampshire'),
(3867, 235, 'New Jersey', 'new-jersey'),
(3868, 235, 'New Mexico', 'new-mexico'),
(3869, 235, 'New York', 'new-york'),
(3870, 235, 'North Carolina', 'north-carolina'),
(3871, 235, 'North Dakota', 'north-dakota'),
(3872, 235, 'Northern Mariana Islands', 'northern-mariana-islands'),
(3873, 235, 'Ohio', 'ohio'),
(3874, 235, 'Oklahoma', 'oklahoma'),
(3875, 235, 'Oregon', 'oregon'),
(3876, 235, 'Palau', 'palau'),
(3877, 235, 'Pennsylvania', 'pennsylvania'),
(3878, 235, 'Puerto Rico', 'puerto-rico'),
(3879, 235, 'Rhode Island', 'rhode-island'),
(3880, 235, 'South Carolina', 'south-carolina'),
(3881, 235, 'South Dakota', 'south-dakota'),
(3882, 235, 'Tennessee', 'tennessee'),
(3883, 235, 'Texas', 'texas'),
(3884, 235, 'Utah', 'utah'),
(3885, 235, 'Vermont', 'vermont'),
(3886, 235, 'Virgin Islands', 'virgin-islands'),
(3887, 235, 'Virginia', 'virginia'),
(3888, 235, 'Washington', 'washington'),
(3889, 235, 'West Virginia', 'west-virginia'),
(3890, 235, 'Wisconsin', 'wisconsin'),
(3891, 235, 'Wyoming', 'wyoming'),
(3892, 236, 'Baker Island', 'baker-island'),
(3893, 236, 'Howland Island', 'howland-island'),
(3894, 236, 'Jarvis Island', 'jarvis-island'),
(3895, 236, 'Johnston Atoll', 'johnston-atoll'),
(3896, 236, 'Kingman Reef', 'kingman-reef'),
(3897, 236, 'Midway Atoll', 'midway-atoll'),
(3898, 236, 'Navassa Island', 'navassa-island'),
(3899, 236, 'Palmyra Atoll', 'palmyra-atoll'),
(3900, 236, 'Wake Island', 'wake-island'),
(3901, 237, 'Artigas', 'artigas'),
(3902, 237, 'Canelones', 'canelones'),
(3903, 237, 'Cerro Largo', 'cerro-largo'),
(3904, 237, 'Colonia', 'colonia'),
(3905, 237, 'Durazno', 'durazno'),
(3906, 237, 'Flores', 'flores'),
(3907, 237, 'Florida', 'florida'),
(3908, 237, 'Lavalleja', 'lavalleja'),
(3909, 237, 'Maldonado', 'maldonado'),
(3910, 237, 'Montevideo', 'montevideo'),
(3911, 237, 'Paysandu', 'paysandu'),
(3912, 237, 'Rio Negro', 'rio-negro'),
(3913, 237, 'Rivera', 'rivera'),
(3914, 237, 'Rocha', 'rocha'),
(3915, 237, 'Salto', 'salto'),
(3916, 237, 'San Jose', 'san-jose'),
(3917, 237, 'Soriano', 'soriano'),
(3918, 237, 'Tacuarembo', 'tacuarembo'),
(3919, 237, 'Treinta y Tres', 'treinta-y-tres'),
(3920, 238, 'Andijon', 'andijon'),
(3921, 238, 'Buxoro', 'buxoro'),
(3922, 238, 'Farg\'ona', 'farg-ona'),
(3923, 238, 'Jizzax', 'jizzax'),
(3924, 238, 'Namangan', 'namangan'),
(3925, 238, 'Navoiy', 'navoiy'),
(3926, 238, 'Qashqadaryo', 'qashqadaryo'),
(3927, 238, 'Qoraqalpog\'iston Republikasi', 'qoraqalpog-iston-republikasi'),
(3928, 238, 'Samarqand', 'samarqand'),
(3929, 238, 'Sirdaryo', 'sirdaryo'),
(3930, 238, 'Surxondaryo', 'surxondaryo'),
(3931, 238, 'Toshkent City', 'toshkent-city'),
(3932, 238, 'Toshkent Region', 'toshkent-region'),
(3933, 238, 'Xorazm', 'xorazm'),
(3934, 239, 'Malampa', 'malampa'),
(3935, 239, 'Penama', 'penama'),
(3936, 239, 'Sanma', 'sanma'),
(3937, 239, 'Shefa', 'shefa'),
(3938, 239, 'Tafea', 'tafea'),
(3939, 239, 'Torba', 'torba'),
(3940, 240, 'Amazonas', 'amazonas'),
(3941, 240, 'Anzoategui', 'anzoategui'),
(3942, 240, 'Apure', 'apure'),
(3943, 240, 'Aragua', 'aragua'),
(3944, 240, 'Barinas', 'barinas'),
(3945, 240, 'Bolivar', 'bolivar'),
(3946, 240, 'Carabobo', 'carabobo'),
(3947, 240, 'Cojedes', 'cojedes'),
(3948, 240, 'Delta Amacuro', 'delta-amacuro'),
(3949, 240, 'Dependencias Federales', 'dependencias-federales'),
(3950, 240, 'Distrito Federal', 'distrito-federal'),
(3951, 240, 'Falcon', 'falcon'),
(3952, 240, 'Guarico', 'guarico'),
(3953, 240, 'Lara', 'lara'),
(3954, 240, 'Merida', 'merida'),
(3955, 240, 'Miranda', 'miranda'),
(3956, 240, 'Monagas', 'monagas'),
(3957, 240, 'Nueva Esparta', 'nueva-esparta'),
(3958, 240, 'Portuguesa', 'portuguesa'),
(3959, 240, 'Sucre', 'sucre'),
(3960, 240, 'Tachira', 'tachira'),
(3961, 240, 'Trujillo', 'trujillo'),
(3962, 240, 'Vargas', 'vargas'),
(3963, 240, 'Yaracuy', 'yaracuy'),
(3964, 240, 'Zulia', 'zulia'),
(3965, 241, 'An Giang', 'an-giang'),
(3966, 241, 'Bac Giang', 'bac-giang'),
(3967, 241, 'Bac Kan', 'bac-kan'),
(3968, 241, 'Bac Lieu', 'bac-lieu'),
(3969, 241, 'Bac Ninh', 'bac-ninh'),
(3970, 241, 'Ba Ria-Vung Tau', 'ba-ria-vung-tau');
INSERT INTO `cities` (`id`, `country_id`, `name`, `slug`) VALUES
(3971, 241, 'Ben Tre', 'ben-tre'),
(3972, 241, 'Binh Dinh', 'binh-dinh'),
(3973, 241, 'Binh Duong', 'binh-duong'),
(3974, 241, 'Binh Phuoc', 'binh-phuoc'),
(3975, 241, 'Binh Thuan', 'binh-thuan'),
(3976, 241, 'Ca Mau', 'ca-mau'),
(3977, 241, 'Can Tho', 'can-tho'),
(3978, 241, 'Cao Bang', 'cao-bang'),
(3979, 241, 'Dak Lak', 'dak-lak'),
(3980, 241, 'Dak Nong', 'dak-nong'),
(3981, 241, 'Da Nang', 'da-nang'),
(3982, 241, 'Dien Bien', 'dien-bien'),
(3983, 241, 'Dong Nai', 'dong-nai'),
(3984, 241, 'Dong Thap', 'dong-thap'),
(3985, 241, 'Gia Lai', 'gia-lai'),
(3986, 241, 'Ha Giang', 'ha-giang'),
(3987, 241, 'Hai Duong', 'hai-duong'),
(3988, 241, 'Hai Phong', 'hai-phong'),
(3989, 241, 'Ha Nam', 'ha-nam'),
(3990, 241, 'Ha Noi', 'ha-noi'),
(3991, 241, 'Ha Tay', 'ha-tay'),
(3992, 241, 'Ha Tinh', 'ha-tinh'),
(3993, 241, 'Hoa Binh', 'hoa-binh'),
(3994, 241, 'Ho Chi Minh City', 'ho-chi-minh-city'),
(3995, 241, 'Hau Giang', 'hau-giang'),
(3996, 241, 'Hung Yen', 'hung-yen'),
(3997, 243, 'Saint Croix', 'saint-croix'),
(3998, 243, 'Saint John', 'saint-john'),
(3999, 243, 'Saint Thomas', 'saint-thomas'),
(4000, 244, 'Alo', 'alo'),
(4001, 244, 'Sigave', 'sigave'),
(4002, 244, 'Wallis', 'wallis'),
(4003, 246, 'Abyan', 'abyan'),
(4004, 246, 'Adan', 'adan'),
(4005, 246, 'Amran', 'amran'),
(4006, 246, 'Al Bayda', 'al-bayda'),
(4007, 246, 'Ad Dali', 'ad-dali'),
(4008, 246, 'Dhamar', 'dhamar'),
(4009, 246, 'Hadramawt', 'hadramawt'),
(4010, 246, 'Hajjah', 'hajjah'),
(4011, 246, 'Al Hudaydah', 'al-hudaydah'),
(4012, 246, 'Ibb', 'ibb'),
(4013, 246, 'Al Jawf', 'al-jawf'),
(4014, 246, 'Lahij', 'lahij'),
(4015, 246, 'Ma\'rib', 'ma-rib'),
(4016, 246, 'Al Mahrah', 'al-mahrah'),
(4017, 246, 'Al Mahwit', 'al-mahwit'),
(4018, 246, 'Sa\'dah', 'sa-dah'),
(4019, 246, 'San\'a', 'san-a'),
(4020, 246, 'Shabwah', 'shabwah'),
(4021, 246, 'Ta\'izz', 'ta-izz'),
(4022, 51, 'Bas-Congo', 'bas-congo'),
(4023, 51, 'Bandundu', 'bandundu'),
(4024, 51, 'Equateur', 'equateur'),
(4025, 51, 'Katanga', 'katanga'),
(4026, 51, 'Kasai-Oriental', 'kasai-oriental'),
(4027, 51, 'Kinshasa', 'kinshasa'),
(4028, 51, 'Kasai-Occidental', 'kasai-occidental'),
(4029, 51, 'Maniema', 'maniema'),
(4030, 51, 'Nord-Kivu', 'nord-kivu'),
(4031, 51, 'Orientale', 'orientale'),
(4032, 51, 'Sud-Kivu', 'sud-kivu'),
(4033, 247, 'Central', 'central'),
(4034, 247, 'Copperbelt', 'copperbelt'),
(4035, 247, 'Eastern', 'eastern'),
(4036, 247, 'Luapula', 'luapula'),
(4037, 247, 'Lusaka', 'lusaka'),
(4038, 247, 'Northern', 'northern'),
(4039, 247, 'North-Western', 'north-western'),
(4040, 247, 'Southern', 'southern'),
(4041, 247, 'Western', 'western'),
(4042, 248, 'Bulawayo', 'bulawayo'),
(4043, 248, 'Harare', 'harare'),
(4044, 248, 'Manicaland', 'manicaland'),
(4045, 248, 'Mashonaland Central', 'mashonaland-central'),
(4046, 248, 'Mashonaland East', 'mashonaland-east'),
(4047, 248, 'Mashonaland West', 'mashonaland-west'),
(4048, 248, 'Masvingo', 'masvingo'),
(4049, 248, 'Matabeleland North', 'matabeleland-north'),
(4050, 248, 'Matabeleland South', 'matabeleland-south'),
(4051, 248, 'Midlands', 'midlands'),
(4052, 148, 'Andrijevica', 'andrijevica'),
(4053, 148, 'Bar', 'bar'),
(4054, 148, 'Berane', 'berane'),
(4055, 148, 'Bijelo Polje', 'bijelo-polje'),
(4056, 148, 'Budva', 'budva'),
(4057, 148, 'Cetinje', 'cetinje'),
(4058, 148, 'Danilovgrad', 'danilovgrad'),
(4059, 148, 'Herceg-Novi', 'herceg-novi'),
(4060, 148, 'Kolašin', 'kolasin'),
(4061, 148, 'Kotor', 'kotor'),
(4062, 148, 'Mojkovac', 'mojkovac'),
(4063, 148, 'Nikšić', 'niksic'),
(4064, 148, 'Plav', 'plav'),
(4065, 148, 'Pljevlja', 'pljevlja'),
(4066, 148, 'Plužine', 'pluzine'),
(4067, 148, 'Podgorica', 'podgorica'),
(4068, 148, 'Rožaje', 'rozaje'),
(4069, 148, 'Šavnik', 'savnik'),
(4070, 148, 'Tivat', 'tivat'),
(4071, 148, 'Ulcinj', 'ulcinj'),
(4072, 148, 'Žabljak', 'zabljak'),
(4073, 196, 'Belgrade', 'belgrade'),
(4074, 196, 'North Bačka', 'north-backa'),
(4075, 196, 'Central Banat', 'central-banat'),
(4076, 196, 'North Banat', 'north-banat'),
(4077, 196, 'South Banat', 'south-banat'),
(4078, 196, 'West Bačka', 'west-backa'),
(4079, 196, 'South Bačka', 'south-backa'),
(4080, 196, 'Srem', 'srem'),
(4081, 196, 'Mačva', 'macva'),
(4082, 196, 'Kolubara', 'kolubara'),
(4083, 196, 'Podunavlje', 'podunavlje'),
(4084, 196, 'Braničevo', 'branicevo'),
(4085, 196, 'Šumadija', 'sumadija'),
(4086, 196, 'Pomoravlje', 'pomoravlje'),
(4087, 196, 'Bor', 'bor'),
(4088, 196, 'Zaječar', 'zajecar'),
(4089, 196, 'Zlatibor', 'zlatibor'),
(4090, 196, 'Moravica', 'moravica'),
(4091, 196, 'Raška', 'raska'),
(4092, 196, 'Rasina', 'rasina'),
(4093, 196, 'Nišava', 'nisava'),
(4094, 196, 'Toplica', 'toplica'),
(4095, 196, 'Pirot', 'pirot'),
(4096, 196, 'Jablanica', 'jablanica'),
(4097, 196, 'Pčinja', 'pcinja'),
(4098, 27, 'Bonaire', 'bonaire'),
(4099, 27, 'Saba', 'saba'),
(4100, 27, 'Sint Eustatius', 'sint-eustatius'),
(4101, 207, 'Central Equatoria', 'central-equatoria'),
(4102, 207, 'Eastern Equatoria', 'eastern-equatoria'),
(4103, 207, 'Jonglei', 'jonglei'),
(4104, 207, 'Lakes', 'lakes'),
(4105, 207, 'Northern Bahr el-Ghazal', 'northern-bahr-el-ghazal'),
(4106, 207, 'Unity', 'unity'),
(4107, 207, 'Upper Nile', 'upper-nile'),
(4108, 207, 'Warrap', 'warrap'),
(4109, 207, 'Western Bahr el-Ghazal', 'western-bahr-el-ghazal'),
(4110, 207, 'Western Equatoria', 'western-equatoria'),
(4111, 174, 'Manila', 'manila'),
(4112, 57, 'Lefkoşe', 'lefkose'),
(4113, 57, 'Gazimagusa', 'gazimagusa'),
(4114, 57, 'Girne', 'girne'),
(4115, 57, 'Güzelyurt', 'guzelyurt'),
(4116, 57, 'Maraş', 'maras'),
(4117, 57, 'Karpaz', 'karpaz'),
(4118, 57, 'İskele', 'iskele');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `admin_message` text COLLATE utf8mb4_unicode_ci,
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `unread` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE `counties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `city_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`id`, `country_id`, `city_id`, `name`, `slug`) VALUES
(1, 227, 1, 'Seyhan', 'seyhan'),
(2, 227, 1, 'Yüreğir', 'yuregir'),
(3, 227, 1, 'Sarıçam', 'saricam'),
(4, 227, 1, 'Çukurova', 'cukurova'),
(5, 227, 1, 'Aladağ(Karsantı)', 'aladagkarsanti'),
(6, 227, 1, 'Ceyhan', 'ceyhan'),
(7, 227, 1, 'Feke', 'feke'),
(8, 227, 1, 'İmamoğlu', 'imamoglu'),
(9, 227, 1, 'Karaisalı', 'karaisali'),
(10, 227, 1, 'Karataş', 'karatas'),
(11, 227, 1, 'Kozan', 'kozan'),
(12, 227, 1, 'Pozantı', 'pozanti'),
(13, 227, 1, 'Saimbeyli', 'saimbeyli'),
(14, 227, 1, 'Tufanbeyli', 'tufanbeyli'),
(15, 227, 1, 'Yumurtalık', 'yumurtalik'),
(16, 227, 2, 'Adıyaman', 'adiyaman'),
(17, 227, 2, 'Besni', 'besni'),
(18, 227, 2, 'Çelikhan', 'celikhan'),
(19, 227, 2, 'Gerger', 'gerger'),
(20, 227, 2, 'Gölbaşı', 'golbasi'),
(21, 227, 2, 'Kahta', 'kahta'),
(22, 227, 2, 'Samsat', 'samsat'),
(23, 227, 2, 'Sincik', 'sincik'),
(24, 227, 2, 'Tut', 'tut'),
(25, 227, 3, 'Afyonkarahisar', 'afyonkarahisar'),
(26, 227, 3, 'Başmakçı', 'basmakci'),
(27, 227, 3, 'Bayat', 'bayat'),
(28, 227, 3, 'Bolvadin', 'bolvadin'),
(29, 227, 3, 'Çay', 'cay'),
(30, 227, 3, 'Çobanlar', 'cobanlar'),
(31, 227, 3, 'Dazkırı', 'dazkiri'),
(32, 227, 3, 'Dinar', 'dinar'),
(33, 227, 3, 'Emirdağ', 'emirdag'),
(34, 227, 3, 'Evciler', 'evciler'),
(35, 227, 3, 'Hocalar', 'hocalar'),
(36, 227, 3, 'İhsaniye', 'ihsaniye'),
(37, 227, 3, 'İscehisar', 'iscehisar'),
(38, 227, 3, 'Kızılören', 'kiziloren'),
(39, 227, 3, 'Sandıklı', 'sandikli'),
(40, 227, 3, 'Sincanlı(Sinanpaşa)', 'sincanlisinanpasa'),
(41, 227, 3, 'Sultandağı', 'sultandagi'),
(42, 227, 3, 'Şuhut', 'suhut'),
(43, 227, 4, 'Ağrı', 'agri'),
(44, 227, 4, 'Diyadin', 'diyadin'),
(45, 227, 4, 'Doğubeyazıt', 'dogubeyazit'),
(46, 227, 4, 'Eleşkirt', 'eleskirt'),
(47, 227, 4, 'Hamur', 'hamur'),
(48, 227, 4, 'Patnos', 'patnos'),
(49, 227, 4, 'Taşlıçay', 'taslicay'),
(50, 227, 4, 'Tutak', 'tutak'),
(51, 227, 5, 'Amasya', 'amasya'),
(52, 227, 5, 'Göynücek', 'goynucek'),
(53, 227, 5, 'Gümüşhacıköy', 'gumushacikoy'),
(54, 227, 5, 'Hamamözü', 'hamamozu'),
(55, 227, 5, 'Merzifon', 'merzifon'),
(56, 227, 5, 'Suluova', 'suluova'),
(57, 227, 5, 'Taşova', 'tasova'),
(58, 227, 6, 'Altındağ', 'altindag'),
(59, 227, 6, 'Çankaya', 'cankaya'),
(60, 227, 6, 'Etimesgut', 'etimesgut'),
(61, 227, 6, 'Keçiören', 'kecioren'),
(62, 227, 6, 'Mamak', 'mamak'),
(63, 227, 6, 'Sincan', 'sincan'),
(64, 227, 6, 'Yenimahalle', 'yenimahalle'),
(65, 227, 6, 'Gölbaşı', 'golbasi'),
(66, 227, 6, 'Pursaklar', 'pursaklar'),
(67, 227, 6, 'Akyurt', 'akyurt'),
(68, 227, 6, 'Ayaş', 'ayas'),
(69, 227, 6, 'Bala', 'bala'),
(70, 227, 6, 'Beypazarı', 'beypazari'),
(71, 227, 6, 'Çamlıdere', 'camlidere'),
(72, 227, 6, 'Çubuk', 'cubuk'),
(73, 227, 6, 'Elmadağ', 'elmadag'),
(74, 227, 6, 'Evren', 'evren'),
(75, 227, 6, 'Güdül', 'gudul'),
(76, 227, 6, 'Haymana', 'haymana'),
(77, 227, 6, 'Kalecik', 'kalecik'),
(78, 227, 6, 'Kazan', 'kazan'),
(79, 227, 6, 'Kızılcahamam', 'kizilcahamam'),
(80, 227, 6, 'Nallıhan', 'nallihan'),
(81, 227, 6, 'Polatlı', 'polatli'),
(82, 227, 6, 'Şereflikoçhisar', 'sereflikochisar'),
(83, 227, 7, 'Muratpaşa', 'muratpasa'),
(84, 227, 7, 'Kepez', 'kepez'),
(85, 227, 7, 'Konyaaltı', 'konyaalti'),
(86, 227, 7, 'Aksu', 'aksu'),
(87, 227, 7, 'Döşemealtı', 'dosemealti'),
(88, 227, 7, 'Akseki', 'akseki'),
(89, 227, 7, 'Alanya', 'alanya'),
(90, 227, 7, 'Elmalı', 'elmali'),
(91, 227, 7, 'Finike', 'finike'),
(92, 227, 7, 'Gazipaşa', 'gazipasa'),
(93, 227, 7, 'Gündoğmuş', 'gundogmus'),
(94, 227, 7, 'İbradı(Aydınkent)', 'ibradiaydinkent'),
(95, 227, 7, 'Kale(Demre)', 'kaledemre'),
(96, 227, 7, 'Kaş', 'kas'),
(97, 227, 7, 'Kemer', 'kemer'),
(98, 227, 7, 'Korkuteli', 'korkuteli'),
(99, 227, 7, 'Kumluca', 'kumluca'),
(100, 227, 7, 'Manavgat', 'manavgat'),
(101, 227, 7, 'Serik', 'serik'),
(102, 227, 8, 'Artvin', 'artvin'),
(103, 227, 8, 'Ardanuç', 'ardanuc'),
(104, 227, 8, 'Arhavi', 'arhavi'),
(105, 227, 8, 'Borçka', 'borcka'),
(106, 227, 8, 'Hopa', 'hopa'),
(107, 227, 8, 'Murgul(Göktaş)', 'murgulgoktas'),
(108, 227, 8, 'Şavşat', 'savsat'),
(109, 227, 8, 'Yusufeli', 'yusufeli'),
(110, 227, 9, 'Aydın', 'aydin'),
(111, 227, 9, 'Bozdoğan', 'bozdogan'),
(112, 227, 9, 'Buharkent(Çubukdağı)', 'buharkentcubukdagi'),
(113, 227, 9, 'Çine', 'cine'),
(114, 227, 9, 'Germencik', 'germencik'),
(115, 227, 9, 'İncirliova', 'incirliova'),
(116, 227, 9, 'Karacasu', 'karacasu'),
(117, 227, 9, 'Karpuzlu', 'karpuzlu'),
(118, 227, 9, 'Koçarlı', 'kocarli'),
(119, 227, 9, 'Köşk', 'kosk'),
(120, 227, 9, 'Kuşadası', 'kusadasi'),
(121, 227, 9, 'Kuyucak', 'kuyucak'),
(122, 227, 9, 'Nazilli', 'nazilli'),
(123, 227, 9, 'Söke', 'soke'),
(124, 227, 9, 'Sultanhisar', 'sultanhisar'),
(125, 227, 9, 'Didim', 'didimyenihisar'),
(126, 227, 9, 'Yenipazar', 'yenipazar'),
(127, 227, 10, 'Balıkesir', 'balikesir'),
(128, 227, 10, 'Ayvalık', 'ayvalik'),
(129, 227, 10, 'Balya', 'balya'),
(130, 227, 10, 'Bandırma', 'bandirma'),
(131, 227, 10, 'Bigadiç', 'bigadic'),
(132, 227, 10, 'Burhaniye', 'burhaniye'),
(133, 227, 10, 'Dursunbey', 'dursunbey'),
(134, 227, 10, 'Edremit', 'edremit'),
(135, 227, 10, 'Erdek', 'erdek'),
(136, 227, 10, 'Gömeç', 'gomec'),
(137, 227, 10, 'Gönen', 'gonen'),
(138, 227, 10, 'Havran', 'havran'),
(139, 227, 10, 'İvrindi', 'ivrindi'),
(140, 227, 10, 'Kepsut', 'kepsut'),
(141, 227, 10, 'Manyas', 'manyas'),
(142, 227, 10, 'Marmara', 'marmara'),
(143, 227, 10, 'Savaştepe', 'savastepe'),
(144, 227, 10, 'Sındırgı', 'sindirgi'),
(145, 227, 10, 'Susurluk', 'susurluk'),
(146, 227, 11, 'Bilecik', 'bilecik'),
(147, 227, 11, 'Bozüyük', 'bozuyuk'),
(148, 227, 11, 'Gölpazarı', 'golpazari'),
(149, 227, 11, 'İnhisar', 'inhisar'),
(150, 227, 11, 'Osmaneli', 'osmaneli'),
(151, 227, 11, 'Pazaryeri', 'pazaryeri'),
(152, 227, 11, 'Söğüt', 'sogut'),
(153, 227, 11, 'Yenipazar', 'yenipazar'),
(154, 227, 12, 'Bingöl', 'bingol'),
(155, 227, 12, 'Adaklı', 'adakli'),
(156, 227, 12, 'Genç', 'genc'),
(157, 227, 12, 'Karlıova', 'karliova'),
(158, 227, 12, 'Kığı', 'kigi'),
(159, 227, 12, 'Solhan', 'solhan'),
(160, 227, 12, 'Yayladere', 'yayladere'),
(161, 227, 12, 'Yedisu', 'yedisu'),
(162, 227, 13, 'Bitlis', 'bitlis'),
(163, 227, 13, 'Adilcevaz', 'adilcevaz'),
(164, 227, 13, 'Ahlat', 'ahlat'),
(165, 227, 13, 'Güroymak', 'guroymak'),
(166, 227, 13, 'Hizan', 'hizan'),
(167, 227, 13, 'Mutki', 'mutki'),
(168, 227, 13, 'Tatvan', 'tatvan'),
(169, 227, 14, 'Bolu', 'bolu'),
(170, 227, 14, 'Dörtdivan', 'dortdivan'),
(171, 227, 14, 'Gerede', 'gerede'),
(172, 227, 14, 'Göynük', 'goynuk'),
(173, 227, 14, 'Kıbrıscık', 'kibriscik'),
(174, 227, 14, 'Mengen', 'mengen'),
(175, 227, 14, 'Mudurnu', 'mudurnu'),
(176, 227, 14, 'Seben', 'seben'),
(177, 227, 14, 'Yeniçağa', 'yenicaga'),
(178, 227, 15, 'Burdur', 'burdur'),
(179, 227, 15, 'Ağlasun', 'aglasun'),
(180, 227, 15, 'Altınyayla(Dirmil)', 'altinyayladirmil'),
(181, 227, 15, 'Bucak', 'bucak'),
(182, 227, 15, 'Çavdır', 'cavdir'),
(183, 227, 15, 'Çeltikçi', 'celtikci'),
(184, 227, 15, 'Gölhisar', 'golhisar'),
(185, 227, 15, 'Karamanlı', 'karamanli'),
(186, 227, 15, 'Kemer', 'kemer'),
(187, 227, 15, 'Tefenni', 'tefenni'),
(188, 227, 15, 'Yeşilova', 'yesilova'),
(189, 227, 16, 'Nilüfer', 'nilufer'),
(190, 227, 16, 'Osmangazi', 'osmangazi'),
(191, 227, 16, 'Yıldırım', 'yildirim'),
(192, 227, 16, 'Büyükorhan', 'buyukorhan'),
(193, 227, 16, 'Gemlik', 'gemlik'),
(194, 227, 16, 'Gürsu', 'gursu'),
(195, 227, 16, 'Harmancık', 'harmancik'),
(196, 227, 16, 'İnegöl', 'inegol'),
(197, 227, 16, 'İznik', 'iznik'),
(198, 227, 16, 'Karacabey', 'karacabey'),
(199, 227, 16, 'Keles', 'keles'),
(200, 227, 16, 'Kestel', 'kestel'),
(201, 227, 16, 'Mudanya', 'mudanya'),
(202, 227, 16, 'Mustafakemalpaşa', 'mustafakemalpasa'),
(203, 227, 16, 'Orhaneli', 'orhaneli'),
(204, 227, 16, 'Orhangazi', 'orhangazi'),
(205, 227, 16, 'Yenişehir', 'yenisehir'),
(206, 227, 17, 'Çanakkale', 'canakkale'),
(207, 227, 17, 'Ayvacık-Assos', 'ayvacikassos'),
(208, 227, 17, 'Bayramiç', 'bayramic'),
(209, 227, 17, 'Biga', 'biga'),
(210, 227, 17, 'Bozcaada', 'bozcaada'),
(211, 227, 17, 'Çan', 'can'),
(212, 227, 17, 'Eceabat', 'eceabat'),
(213, 227, 17, 'Ezine', 'ezine'),
(214, 227, 17, 'Gelibolu', 'gelibolu'),
(215, 227, 17, 'Gökçeada(İmroz)', 'gokceadaimroz'),
(216, 227, 17, 'Lapseki', 'lapseki'),
(217, 227, 17, 'Yenice', 'yenice'),
(218, 227, 18, 'Çankırı', 'cankiri'),
(219, 227, 18, 'Atkaracalar', 'atkaracalar'),
(220, 227, 18, 'Bayramören', 'bayramoren'),
(221, 227, 18, 'Çerkeş', 'cerkes'),
(222, 227, 18, 'Eldivan', 'eldivan'),
(223, 227, 18, 'Ilgaz', 'ilgaz'),
(224, 227, 18, 'Kızılırmak', 'kizilirmak'),
(225, 227, 18, 'Korgun', 'korgun'),
(226, 227, 18, 'Kurşunlu', 'kursunlu'),
(227, 227, 18, 'Orta', 'orta'),
(228, 227, 18, 'Şabanözü', 'sabanozu'),
(229, 227, 18, 'Yapraklı', 'yaprakli'),
(230, 227, 19, 'Çorum', 'corum'),
(231, 227, 19, 'Alaca', 'alaca'),
(232, 227, 19, 'Bayat', 'bayat'),
(233, 227, 19, 'Boğazkale', 'bogazkale'),
(234, 227, 19, 'Dodurga', 'dodurga'),
(235, 227, 19, 'İskilip', 'iskilip'),
(236, 227, 19, 'Kargı', 'kargi'),
(237, 227, 19, 'Laçin', 'lacin'),
(238, 227, 19, 'Mecitözü', 'mecitozu'),
(239, 227, 19, 'Oğuzlar(Karaören)', 'oguzlarkaraoren'),
(240, 227, 19, 'Ortaköy', 'ortakoy'),
(241, 227, 19, 'Osmancık', 'osmancik'),
(242, 227, 19, 'Sungurlu', 'sungurlu'),
(243, 227, 19, 'Uğurludağ', 'ugurludag'),
(244, 227, 20, 'Denizli', 'denizli'),
(245, 227, 20, 'Acıpayam', 'acipayam'),
(246, 227, 20, 'Akköy', 'akkoy'),
(247, 227, 20, 'Babadağ', 'babadag'),
(248, 227, 20, 'Baklan', 'baklan'),
(249, 227, 20, 'Bekilli', 'bekilli'),
(250, 227, 20, 'Beyağaç', 'beyagac'),
(251, 227, 20, 'Bozkurt', 'bozkurt'),
(252, 227, 20, 'Buldan', 'buldan'),
(253, 227, 20, 'Çal', 'cal'),
(254, 227, 20, 'Çameli', 'cameli'),
(255, 227, 20, 'Çardak', 'cardak'),
(256, 227, 20, 'Çivril', 'civril'),
(257, 227, 20, 'Güney', 'guney'),
(258, 227, 20, 'Honaz', 'honaz'),
(259, 227, 20, 'Kale', 'kale'),
(260, 227, 20, 'Sarayköy', 'saraykoy'),
(261, 227, 20, 'Serinhisar', 'serinhisar'),
(262, 227, 20, 'Tavas', 'tavas'),
(263, 227, 21, 'Sur', 'sur'),
(264, 227, 21, 'Bağlar', 'baglar'),
(265, 227, 21, 'Yenişehir', 'yenisehir'),
(266, 227, 21, 'Kayapınar', 'kayapinar'),
(267, 227, 21, 'Bismil', 'bismil'),
(268, 227, 21, 'Çermik', 'cermik'),
(269, 227, 21, 'Çınar', 'cinar'),
(270, 227, 21, 'Çüngüş', 'cungus'),
(271, 227, 21, 'Dicle', 'dicle'),
(272, 227, 21, 'Eğil', 'egil'),
(273, 227, 21, 'Ergani', 'ergani'),
(274, 227, 21, 'Hani', 'hani'),
(275, 227, 21, 'Hazro', 'hazro'),
(276, 227, 21, 'Kocaköy', 'kocakoy'),
(277, 227, 21, 'Kulp', 'kulp'),
(278, 227, 21, 'Lice', 'lice'),
(279, 227, 21, 'Silvan', 'silvan'),
(280, 227, 22, 'Edirne', 'edirne'),
(281, 227, 22, 'Enez', 'enez'),
(282, 227, 22, 'Havsa', 'havsa'),
(283, 227, 22, 'İpsala', 'ipsala'),
(284, 227, 22, 'Keşan', 'kesan'),
(285, 227, 22, 'Lalapaşa', 'lalapasa'),
(286, 227, 22, 'Meriç', 'meric'),
(287, 227, 22, 'Süleoğlu(Süloğlu)', 'suleoglusuloglu'),
(288, 227, 22, 'Uzunköprü', 'uzunkopru'),
(289, 227, 23, 'Elazığ', 'elazig'),
(290, 227, 23, 'Ağın', 'agin'),
(291, 227, 23, 'Alacakaya', 'alacakaya'),
(292, 227, 23, 'Arıcak', 'aricak'),
(293, 227, 23, 'Baskil', 'baskil'),
(294, 227, 23, 'Karakoçan', 'karakocan'),
(295, 227, 23, 'Keban', 'keban'),
(296, 227, 23, 'Kovancılar', 'kovancilar'),
(297, 227, 23, 'Maden', 'maden'),
(298, 227, 23, 'Palu', 'palu'),
(299, 227, 23, 'Sivrice', 'sivrice'),
(300, 227, 24, 'Erzincan', 'erzincan'),
(301, 227, 24, 'Çayırlı', 'cayirli'),
(302, 227, 24, 'İliç(Ilıç)', 'ilicilic'),
(303, 227, 24, 'Kemah', 'kemah'),
(304, 227, 24, 'Kemaliye', 'kemaliye'),
(305, 227, 24, 'Otlukbeli', 'otlukbeli'),
(306, 227, 24, 'Refahiye', 'refahiye'),
(307, 227, 24, 'Tercan', 'tercan'),
(308, 227, 24, 'Üzümlü', 'uzumlu'),
(309, 227, 25, 'Palandöken', 'palandoken'),
(310, 227, 25, 'Yakutiye', 'yakutiye'),
(311, 227, 25, 'Aziziye(Ilıca)', 'aziziyeilica'),
(312, 227, 25, 'Aşkale', 'askale'),
(313, 227, 25, 'Çat', 'cat'),
(314, 227, 25, 'Hınıs', 'hinis'),
(315, 227, 25, 'Horasan', 'horasan'),
(316, 227, 25, 'İspir', 'ispir'),
(317, 227, 25, 'Karaçoban', 'karacoban'),
(318, 227, 25, 'Karayazı', 'karayazi'),
(319, 227, 25, 'Köprüköy', 'koprukoy'),
(320, 227, 25, 'Narman', 'narman'),
(321, 227, 25, 'Oltu', 'oltu'),
(322, 227, 25, 'Olur', 'olur'),
(323, 227, 25, 'Pasinler', 'pasinler'),
(324, 227, 25, 'Pazaryolu', 'pazaryolu'),
(325, 227, 25, 'Şenkaya', 'senkaya'),
(326, 227, 25, 'Tekman', 'tekman'),
(327, 227, 25, 'Tortum', 'tortum'),
(328, 227, 25, 'Uzundere', 'uzundere'),
(329, 227, 26, 'Odunpazarı', 'odunpazari'),
(330, 227, 26, 'Tepebaşı', 'tepebasi'),
(331, 227, 26, 'Alpu', 'alpu'),
(332, 227, 26, 'Beylikova', 'beylikova'),
(333, 227, 26, 'Çifteler', 'cifteler'),
(334, 227, 26, 'Günyüzü', 'gunyuzu'),
(335, 227, 26, 'Han', 'han'),
(336, 227, 26, 'İnönü', 'inonu'),
(337, 227, 26, 'Mahmudiye', 'mahmudiye'),
(338, 227, 26, 'Mihalgazi', 'mihalgazi'),
(339, 227, 26, 'Mihalıçcık', 'mihaliccik'),
(340, 227, 26, 'Sarıcakaya', 'saricakaya'),
(341, 227, 26, 'Seyitgazi', 'seyitgazi'),
(342, 227, 26, 'Sivrihisar', 'sivrihisar'),
(343, 227, 27, 'Şahinbey', 'sahinbey'),
(344, 227, 27, 'Şehitkamil', 'sehitkamil'),
(345, 227, 27, 'Oğuzeli', 'oguzeli'),
(346, 227, 27, 'Araban', 'araban'),
(347, 227, 27, 'İslahiye', 'islahiye'),
(348, 227, 27, 'Karkamış', 'karkamis'),
(349, 227, 27, 'Nizip', 'nizip'),
(350, 227, 27, 'Nurdağı', 'nurdagi'),
(351, 227, 27, 'Yavuzeli', 'yavuzeli'),
(352, 227, 28, 'Giresun', 'giresun'),
(353, 227, 28, 'Alucra', 'alucra'),
(354, 227, 28, 'Bulancak', 'bulancak'),
(355, 227, 28, 'Çamoluk', 'camoluk'),
(356, 227, 28, 'Çanakçı', 'canakci'),
(357, 227, 28, 'Dereli', 'dereli'),
(358, 227, 28, 'Doğankent', 'dogankent'),
(359, 227, 28, 'Espiye', 'espiye'),
(360, 227, 28, 'Eynesil', 'eynesil'),
(361, 227, 28, 'Görele', 'gorele'),
(362, 227, 28, 'Güce', 'guce'),
(363, 227, 28, 'Keşap', 'kesap'),
(364, 227, 28, 'Piraziz', 'piraziz'),
(365, 227, 28, 'Şebinkarahisar', 'sebinkarahisar'),
(366, 227, 28, 'Tirebolu', 'tirebolu'),
(367, 227, 28, 'Yağlıdere', 'yaglidere'),
(368, 227, 29, 'Gümüşhane', 'gumushane'),
(369, 227, 29, 'Kelkit', 'kelkit'),
(370, 227, 29, 'Köse', 'kose'),
(371, 227, 29, 'Kürtün', 'kurtun'),
(372, 227, 29, 'Şiran', 'siran'),
(373, 227, 29, 'Torul', 'torul'),
(374, 227, 30, 'Hakkari', 'hakkari'),
(375, 227, 30, 'Çukurca', 'cukurca'),
(376, 227, 30, 'Şemdinli', 'semdinli'),
(377, 227, 30, 'Yüksekova', 'yuksekova'),
(378, 227, 31, 'Antakya', 'antakya'),
(379, 227, 31, 'Altınözü', 'altinozu'),
(380, 227, 31, 'Belen', 'belen'),
(381, 227, 31, 'Dörtyol', 'dortyol'),
(382, 227, 31, 'Erzin', 'erzin'),
(383, 227, 31, 'Hassa', 'hassa'),
(384, 227, 31, 'İskenderun', 'iskenderun'),
(385, 227, 31, 'Kırıkhan', 'kirikhan'),
(386, 227, 31, 'Kumlu', 'kumlu'),
(387, 227, 31, 'Reyhanlı', 'reyhanli'),
(388, 227, 31, 'Samandağ', 'samandag'),
(389, 227, 31, 'Yayladağı', 'yayladagi'),
(390, 227, 32, 'Isparta', 'isparta'),
(391, 227, 32, 'Aksu', 'aksu'),
(392, 227, 32, 'Atabey', 'atabey'),
(393, 227, 32, 'Eğridir(Eğirdir)', 'egridiregirdir'),
(394, 227, 32, 'Gelendost', 'gelendost'),
(395, 227, 32, 'Gönen', 'gonen'),
(396, 227, 32, 'Keçiborlu', 'keciborlu'),
(397, 227, 32, 'Senirkent', 'senirkent'),
(398, 227, 32, 'Sütçüler', 'sutculer'),
(399, 227, 32, 'Şarkikaraağaç', 'sarkikaraagac'),
(400, 227, 32, 'Uluborlu', 'uluborlu'),
(401, 227, 32, 'Yalvaç', 'yalvac'),
(402, 227, 32, 'Yenişarbademli', 'yenisarbademli'),
(403, 227, 33, 'Akdeniz', 'akdeniz'),
(404, 227, 33, 'Yenişehir', 'yenisehir'),
(405, 227, 33, 'Toroslar', 'toroslar'),
(406, 227, 33, 'Mezitli', 'mezitli'),
(407, 227, 33, 'Anamur', 'anamur'),
(408, 227, 33, 'Aydıncık', 'aydincik'),
(409, 227, 33, 'Bozyazı', 'bozyazi'),
(410, 227, 33, 'Çamlıyayla', 'camliyayla'),
(411, 227, 33, 'Erdemli', 'erdemli'),
(412, 227, 33, 'Gülnar(Gülpınar)', 'gulnargulpinar'),
(413, 227, 33, 'Mut', 'mut'),
(414, 227, 33, 'Silifke', 'silifke'),
(415, 227, 33, 'Tarsus', 'tarsus'),
(416, 227, 34, 'Bakırköy', 'bakirkoy'),
(417, 227, 34, 'Bayrampaşa', 'bayrampasa'),
(418, 227, 34, 'Beşiktaş', 'besiktas'),
(419, 227, 34, 'Beyoğlu', 'beyoglu'),
(420, 227, 34, 'Arnavutköy', 'arnavutkoy'),
(421, 227, 34, 'Eyüp', 'eyup'),
(422, 227, 34, 'Fatih', 'fatih'),
(423, 227, 34, 'Gaziosmanpaşa', 'gaziosmanpasa'),
(424, 227, 34, 'Kağıthane', 'kagithane'),
(425, 227, 34, 'Küçükçekmece', 'kucukcekmece'),
(426, 227, 34, 'Sarıyer', 'sariyer'),
(427, 227, 34, 'Şişli', 'sisli'),
(428, 227, 34, 'Zeytinburnu', 'zeytinburnu'),
(429, 227, 34, 'Avcılar', 'avcilar'),
(430, 227, 34, 'Güngören', 'gungoren'),
(431, 227, 34, 'Bahçelievler', 'bahcelievler'),
(432, 227, 34, 'Bağcılar', 'bagcilar'),
(433, 227, 34, 'Esenler', 'esenler'),
(434, 227, 34, 'Başakşehir', 'basaksehir'),
(435, 227, 34, 'Beylikdüzü', 'beylikduzu'),
(436, 227, 34, 'Esenyurt', 'esenyurt'),
(437, 227, 34, 'Sultangazi', 'sultangazi'),
(438, 227, 34, 'Adalar', 'adalar'),
(439, 227, 34, 'Beykoz', 'beykoz'),
(440, 227, 34, 'Kadıköy', 'kadikoy'),
(441, 227, 34, 'Kartal', 'kartal'),
(442, 227, 34, 'Pendik', 'pendik'),
(443, 227, 34, 'Ümraniye', 'umraniye'),
(444, 227, 34, 'Üsküdar', 'uskudar'),
(445, 227, 34, 'Tuzla', 'tuzla'),
(446, 227, 34, 'Maltepe', 'maltepe'),
(447, 227, 34, 'Ataşehir', 'atasehir'),
(448, 227, 34, 'Çekmeköy', 'cekmekoy'),
(449, 227, 34, 'Sancaktepe', 'sancaktepe'),
(450, 227, 34, 'Büyükçekmece', 'buyukcekmece'),
(451, 227, 34, 'Çatalca', 'catalca'),
(452, 227, 34, 'Silivri', 'silivri'),
(453, 227, 34, 'Şile', 'sile'),
(454, 227, 34, 'Sultanbeyli', 'sultanbeyli'),
(455, 227, 35, 'Aliağa', 'aliaga'),
(456, 227, 35, 'Balçova', 'balcova'),
(457, 227, 35, 'Bayındır', 'bayindir'),
(458, 227, 35, 'Bornova', 'bornova'),
(459, 227, 35, 'Buca', 'buca'),
(460, 227, 35, 'Çiğli', 'cigli'),
(461, 227, 35, 'Foça', 'foca'),
(462, 227, 35, 'Gaziemir', 'gaziemir'),
(463, 227, 35, 'Güzelbahçe', 'guzelbahce'),
(464, 227, 35, 'Karşıyaka', 'karsiyaka'),
(465, 227, 35, 'Kemalpaşa', 'kemalpasa'),
(466, 227, 35, 'Konak', 'konak'),
(467, 227, 35, 'Cumaovası(Menderes)', 'cumaovasimenderes'),
(468, 227, 35, 'Menemen', 'menemen'),
(469, 227, 35, 'Narlıdere', 'narlidere'),
(470, 227, 35, 'Seferihisar', 'seferihisar'),
(471, 227, 35, 'Selçuk', 'selcuk'),
(472, 227, 35, 'Torbalı', 'torbali'),
(473, 227, 35, 'Urla', 'urla'),
(474, 227, 35, 'Bayraklı', 'bayrakli'),
(475, 227, 35, 'Karabağlar', 'karabaglar'),
(476, 227, 35, 'Bergama', 'bergama'),
(477, 227, 35, 'Beydağ', 'beydag'),
(478, 227, 35, 'Çeşme', 'cesme'),
(479, 227, 35, 'Dikili', 'dikili'),
(480, 227, 35, 'Karaburun', 'karaburun'),
(481, 227, 35, 'Kınık', 'kinik'),
(482, 227, 35, 'Kiraz', 'kiraz'),
(483, 227, 35, 'Ödemiş', 'odemis'),
(484, 227, 35, 'Tire', 'tire'),
(485, 227, 36, 'Kars', 'kars'),
(486, 227, 36, 'Akyaka', 'akyaka'),
(487, 227, 36, 'Arpaçay', 'arpacay'),
(488, 227, 36, 'Digor', 'digor'),
(489, 227, 36, 'Kağızman', 'kagizman'),
(490, 227, 36, 'Sarıkamış', 'sarikamis'),
(491, 227, 36, 'Selim', 'selim'),
(492, 227, 36, 'Susuz', 'susuz'),
(493, 227, 37, 'Kastamonu', 'kastamonu'),
(494, 227, 37, 'Abana', 'abana'),
(495, 227, 37, 'Ağlı', 'agli'),
(496, 227, 37, 'Araç', 'arac'),
(497, 227, 37, 'Azdavay', 'azdavay'),
(498, 227, 37, 'Bozkurt', 'bozkurt'),
(499, 227, 37, 'Cide', 'cide'),
(500, 227, 37, 'Çatalzeytin', 'catalzeytin'),
(501, 227, 37, 'Daday', 'daday'),
(502, 227, 37, 'Devrekani', 'devrekani'),
(503, 227, 37, 'Doğanyurt', 'doganyurt'),
(504, 227, 37, 'Hanönü(Gökçeağaç)', 'hanonugokceagac'),
(505, 227, 37, 'İhsangazi', 'ihsangazi'),
(506, 227, 37, 'İnebolu', 'inebolu'),
(507, 227, 37, 'Küre', 'kure'),
(508, 227, 37, 'Pınarbaşı', 'pinarbasi'),
(509, 227, 37, 'Seydiler', 'seydiler'),
(510, 227, 37, 'Şenpazar', 'senpazar'),
(511, 227, 37, 'Taşköprü', 'taskopru'),
(512, 227, 37, 'Tosya', 'tosya'),
(513, 227, 38, 'Kocasinan', 'kocasinan'),
(514, 227, 38, 'Melikgazi', 'melikgazi'),
(515, 227, 38, 'Talas', 'talas'),
(516, 227, 38, 'Akkışla', 'akkisla'),
(517, 227, 38, 'Bünyan', 'bunyan'),
(518, 227, 38, 'Develi', 'develi'),
(519, 227, 38, 'Felahiye', 'felahiye'),
(520, 227, 38, 'Hacılar', 'hacilar'),
(521, 227, 38, 'İncesu', 'incesu'),
(522, 227, 38, 'Özvatan(Çukur)', 'ozvatancukur'),
(523, 227, 38, 'Pınarbaşı', 'pinarbasi'),
(524, 227, 38, 'Sarıoğlan', 'sarioglan'),
(525, 227, 38, 'Sarız', 'sariz'),
(526, 227, 38, 'Tomarza', 'tomarza'),
(527, 227, 38, 'Yahyalı', 'yahyali'),
(528, 227, 38, 'Yeşilhisar', 'yesilhisar'),
(529, 227, 39, 'Kırklareli', 'kirklareli'),
(530, 227, 39, 'Babaeski', 'babaeski'),
(531, 227, 39, 'Demirköy', 'demirkoy'),
(532, 227, 39, 'Kofçaz', 'kofcaz'),
(533, 227, 39, 'Lüleburgaz', 'luleburgaz'),
(534, 227, 39, 'Pehlivanköy', 'pehlivankoy'),
(535, 227, 39, 'Pınarhisar', 'pinarhisar'),
(536, 227, 39, 'Vize', 'vize'),
(537, 227, 40, 'Kırşehir', 'kirsehir'),
(538, 227, 40, 'Akçakent', 'akcakent'),
(539, 227, 40, 'Akpınar', 'akpinar'),
(540, 227, 40, 'Boztepe', 'boztepe'),
(541, 227, 40, 'Çiçekdağı', 'cicekdagi'),
(542, 227, 40, 'Kaman', 'kaman'),
(543, 227, 40, 'Mucur', 'mucur'),
(544, 227, 41, 'İzmit', 'izmit'),
(545, 227, 41, 'Başiskele', 'basiskele'),
(546, 227, 41, 'Çayırova', 'cayirova'),
(547, 227, 41, 'Darıca', 'darica'),
(548, 227, 41, 'Dilovası', 'dilovasi'),
(549, 227, 41, 'Kartepe', 'kartepe'),
(550, 227, 41, 'Gebze', 'gebze'),
(551, 227, 41, 'Gölcük', 'golcuk'),
(552, 227, 41, 'Kandıra', 'kandira'),
(553, 227, 41, 'Karamürsel', 'karamursel'),
(554, 227, 41, 'Körfez', 'korfez'),
(555, 227, 41, 'Derince', 'derince'),
(556, 227, 42, 'Karatay', 'karatay'),
(557, 227, 42, 'Meram', 'meram'),
(558, 227, 42, 'Selçuklu', 'selcuklu'),
(559, 227, 42, 'Ahırlı', 'ahirli'),
(560, 227, 42, 'Akören', 'akoren'),
(561, 227, 42, 'Akşehir', 'aksehir'),
(562, 227, 42, 'Altınekin', 'altinekin'),
(563, 227, 42, 'Beyşehir', 'beysehir'),
(564, 227, 42, 'Bozkır', 'bozkir'),
(565, 227, 42, 'Cihanbeyli', 'cihanbeyli'),
(566, 227, 42, 'Çeltik', 'celtik'),
(567, 227, 42, 'Çumra', 'cumra'),
(568, 227, 42, 'Derbent', 'derbent'),
(569, 227, 42, 'Derebucak', 'derebucak'),
(570, 227, 42, 'Doğanhisar', 'doganhisar'),
(571, 227, 42, 'Emirgazi', 'emirgazi'),
(572, 227, 42, 'Ereğli', 'eregli'),
(573, 227, 42, 'Güneysınır', 'guneysinir'),
(574, 227, 42, 'Hadim', 'hadim'),
(575, 227, 42, 'Halkapınar', 'halkapinar'),
(576, 227, 42, 'Hüyük', 'huyuk'),
(577, 227, 42, 'Ilgın', 'ilgin'),
(578, 227, 42, 'Kadınhanı', 'kadinhani'),
(579, 227, 42, 'Karapınar', 'karapinar'),
(580, 227, 42, 'Kulu', 'kulu'),
(581, 227, 42, 'Sarayönü', 'sarayonu'),
(582, 227, 42, 'Seydişehir', 'seydisehir'),
(583, 227, 42, 'Taşkent', 'taskent'),
(584, 227, 42, 'Tuzlukçu', 'tuzlukcu'),
(585, 227, 42, 'Yalıhüyük', 'yalihuyuk'),
(586, 227, 42, 'Yunak', 'yunak'),
(587, 227, 43, 'Kütahya', 'kutahya'),
(588, 227, 43, 'Altıntaş', 'altintas'),
(589, 227, 43, 'Aslanapa', 'aslanapa'),
(590, 227, 43, 'Çavdarhisar', 'cavdarhisar'),
(591, 227, 43, 'Domaniç', 'domanic'),
(592, 227, 43, 'Dumlupınar', 'dumlupinar'),
(593, 227, 43, 'Emet', 'emet'),
(594, 227, 43, 'Gediz', 'gediz'),
(595, 227, 43, 'Hisarcık', 'hisarcik'),
(596, 227, 43, 'Pazarlar', 'pazarlar'),
(597, 227, 43, 'Simav', 'simav'),
(598, 227, 43, 'Şaphane', 'saphane'),
(599, 227, 43, 'Tavşanlı', 'tavsanli'),
(600, 227, 43, 'Tunçbilek', 'tuncbilek'),
(601, 227, 44, 'Malatya', 'malatya'),
(602, 227, 44, 'Akçadağ', 'akcadag'),
(603, 227, 44, 'Arapkir', 'arapkir'),
(604, 227, 44, 'Arguvan', 'arguvan'),
(605, 227, 44, 'Battalgazi', 'battalgazi'),
(606, 227, 44, 'Darende', 'darende'),
(607, 227, 44, 'Doğanşehir', 'dogansehir'),
(608, 227, 44, 'Doğanyol', 'doganyol'),
(609, 227, 44, 'Hekimhan', 'hekimhan'),
(610, 227, 44, 'Kale', 'kale'),
(611, 227, 44, 'Kuluncak', 'kuluncak'),
(612, 227, 44, 'Pötürge', 'poturge'),
(613, 227, 44, 'Yazıhan', 'yazihan'),
(614, 227, 44, 'Yeşilyurt', 'yesilyurt'),
(615, 227, 45, 'Manisa', 'manisa'),
(616, 227, 45, 'Ahmetli', 'ahmetli'),
(617, 227, 45, 'Akhisar', 'akhisar'),
(618, 227, 45, 'Alaşehir', 'alasehir'),
(619, 227, 45, 'Demirci', 'demirci'),
(620, 227, 45, 'Gölmarmara', 'golmarmara'),
(621, 227, 45, 'Gördes', 'gordes'),
(622, 227, 45, 'Kırkağaç', 'kirkagac'),
(623, 227, 45, 'Köprübaşı', 'koprubasi'),
(624, 227, 45, 'Kula', 'kula'),
(625, 227, 45, 'Salihli', 'salihli'),
(626, 227, 45, 'Sarıgöl', 'sarigol'),
(627, 227, 45, 'Saruhanlı', 'saruhanli'),
(628, 227, 45, 'Selendi', 'selendi'),
(629, 227, 45, 'Soma', 'soma'),
(630, 227, 45, 'Turgutlu', 'turgutlu'),
(631, 227, 46, 'Kahramanmaraş', 'kahramanmaras'),
(632, 227, 46, 'Afşin', 'afsin'),
(633, 227, 46, 'Andırın', 'andirin'),
(634, 227, 46, 'Çağlayancerit', 'caglayancerit'),
(635, 227, 46, 'Ekinözü', 'ekinozu'),
(636, 227, 46, 'Elbistan', 'elbistan'),
(637, 227, 46, 'Göksun', 'goksun'),
(638, 227, 46, 'Nurhak', 'nurhak'),
(639, 227, 46, 'Pazarcık', 'pazarcik'),
(640, 227, 46, 'Türkoğlu', 'turkoglu'),
(641, 227, 47, 'Mardin', 'mardin'),
(642, 227, 47, 'Dargeçit', 'dargecit'),
(643, 227, 47, 'Derik', 'derik'),
(644, 227, 47, 'Kızıltepe', 'kiziltepe'),
(645, 227, 47, 'Mazıdağı', 'mazidagi'),
(646, 227, 47, 'Midyat(Estel)', 'midyatestel'),
(647, 227, 47, 'Nusaybin', 'nusaybin'),
(648, 227, 47, 'Ömerli', 'omerli'),
(649, 227, 47, 'Savur', 'savur'),
(650, 227, 47, 'Yeşilli', 'yesilli'),
(651, 227, 48, 'Muğla', 'mugla'),
(652, 227, 48, 'Bodrum', 'bodrum'),
(653, 227, 48, 'Dalaman', 'dalaman'),
(654, 227, 48, 'Datça', 'datca'),
(655, 227, 48, 'Fethiye', 'fethiye'),
(656, 227, 48, 'Kavaklıdere', 'kavaklidere'),
(657, 227, 48, 'Köyceğiz', 'koycegiz'),
(658, 227, 48, 'Marmaris', 'marmaris'),
(659, 227, 48, 'Milas', 'milas'),
(660, 227, 48, 'Ortaca', 'ortaca'),
(661, 227, 48, 'Ula', 'ula'),
(662, 227, 48, 'Yatağan', 'yatagan'),
(663, 227, 49, 'Muş', 'mus'),
(664, 227, 49, 'Bulanık', 'bulanik'),
(665, 227, 49, 'Hasköy', 'haskoy'),
(666, 227, 49, 'Korkut', 'korkut'),
(667, 227, 49, 'Malazgirt', 'malazgirt'),
(668, 227, 49, 'Varto', 'varto'),
(669, 227, 50, 'Nevşehir', 'nevsehir'),
(670, 227, 50, 'Acıgöl', 'acigol'),
(671, 227, 50, 'Avanos', 'avanos'),
(672, 227, 50, 'Derinkuyu', 'derinkuyu'),
(673, 227, 50, 'Gülşehir', 'gulsehir'),
(674, 227, 50, 'Hacıbektaş', 'hacibektas'),
(675, 227, 50, 'Kozaklı', 'kozakli'),
(676, 227, 50, 'Göreme', 'goreme'),
(677, 227, 51, 'Niğde', 'nigde'),
(678, 227, 51, 'Altunhisar', 'altunhisar'),
(679, 227, 51, 'Bor', 'bor'),
(680, 227, 51, 'Çamardı', 'camardi'),
(681, 227, 51, 'Çiftlik(Özyurt)', 'ciftlikozyurt'),
(682, 227, 51, 'Ulukışla', 'ulukisla'),
(683, 227, 52, 'Ordu', 'ordu'),
(684, 227, 52, 'Akkuş', 'akkus'),
(685, 227, 52, 'Aybastı', 'aybasti'),
(686, 227, 52, 'Çamaş', 'camas'),
(687, 227, 52, 'Çatalpınar', 'catalpinar'),
(688, 227, 52, 'Çaybaşı', 'caybasi'),
(689, 227, 52, 'Fatsa', 'fatsa'),
(690, 227, 52, 'Gölköy', 'golkoy'),
(691, 227, 52, 'Gülyalı', 'gulyali'),
(692, 227, 52, 'Gürgentepe', 'gurgentepe'),
(693, 227, 52, 'İkizce', 'ikizce'),
(694, 227, 52, 'Karadüz(Kabadüz)', 'karaduzkabaduz'),
(695, 227, 52, 'Kabataş', 'kabatas'),
(696, 227, 52, 'Korgan', 'korgan'),
(697, 227, 52, 'Kumru', 'kumru'),
(698, 227, 52, 'Mesudiye', 'mesudiye'),
(699, 227, 52, 'Perşembe', 'persembe'),
(700, 227, 52, 'Ulubey', 'ulubey'),
(701, 227, 52, 'Ünye', 'unye'),
(702, 227, 53, 'Rize', 'rize'),
(703, 227, 53, 'Ardeşen', 'ardesen'),
(704, 227, 53, 'Çamlıhemşin', 'camlihemsin'),
(705, 227, 53, 'Çayeli', 'cayeli'),
(706, 227, 53, 'Derepazarı', 'derepazari'),
(707, 227, 53, 'Fındıklı', 'findikli'),
(708, 227, 53, 'Güneysu', 'guneysu'),
(709, 227, 53, 'Hemşin', 'hemsin'),
(710, 227, 53, 'İkizdere', 'ikizdere'),
(711, 227, 53, 'İyidere', 'iyidere'),
(712, 227, 53, 'Kalkandere', 'kalkandere'),
(713, 227, 53, 'Pazar', 'pazar'),
(714, 227, 54, 'Adapazarı', 'adapazari'),
(715, 227, 54, 'Hendek', 'hendek'),
(716, 227, 54, 'Arifiye', 'arifiye'),
(717, 227, 54, 'Erenler', 'erenler'),
(718, 227, 54, 'Serdivan', 'serdivan'),
(719, 227, 54, 'Akyazı', 'akyazi'),
(720, 227, 54, 'Ferizli', 'ferizli'),
(721, 227, 54, 'Geyve', 'geyve'),
(722, 227, 54, 'Karapürçek', 'karapurcek'),
(723, 227, 54, 'Karasu', 'karasu'),
(724, 227, 54, 'Kaynarca', 'kaynarca'),
(725, 227, 54, 'Kocaali', 'kocaali'),
(726, 227, 54, 'Pamukova', 'pamukova'),
(727, 227, 54, 'Sapanca', 'sapanca'),
(728, 227, 54, 'Söğütlü', 'sogutlu'),
(729, 227, 54, 'Taraklı', 'tarakli'),
(730, 227, 55, 'Atakum', 'atakum'),
(731, 227, 55, 'İlkadım', 'ilkadim'),
(732, 227, 55, 'Canik', 'canik'),
(733, 227, 55, 'Tekkeköy', 'tekkekoy'),
(734, 227, 55, 'Alaçam', 'alacam'),
(735, 227, 55, 'Asarcık', 'asarcik'),
(736, 227, 55, 'Ayvacık', 'ayvacik'),
(737, 227, 55, 'Bafra', 'bafra'),
(738, 227, 55, 'Çarşamba', 'carsamba'),
(739, 227, 55, 'Havza', 'havza'),
(740, 227, 55, 'Kavak', 'kavak'),
(741, 227, 55, 'Ladik', 'ladik'),
(742, 227, 55, '19Mayıs(Ballıca)', '19mayisballica'),
(743, 227, 55, 'Salıpazarı', 'salipazari'),
(744, 227, 55, 'Terme', 'terme'),
(745, 227, 55, 'Vezirköprü', 'vezirkopru'),
(746, 227, 55, 'Yakakent', 'yakakent'),
(747, 227, 56, 'Siirt', 'siirt'),
(748, 227, 56, 'Baykan', 'baykan'),
(749, 227, 56, 'Eruh', 'eruh'),
(750, 227, 56, 'Kurtalan', 'kurtalan'),
(751, 227, 56, 'Pervari', 'pervari'),
(752, 227, 56, 'Aydınlar', 'aydinlar'),
(753, 227, 56, 'Şirvan', 'sirvan'),
(754, 227, 57, 'Sinop', 'sinop'),
(755, 227, 57, 'Ayancık', 'ayancik'),
(756, 227, 57, 'Boyabat', 'boyabat'),
(757, 227, 57, 'Dikmen', 'dikmen'),
(758, 227, 57, 'Durağan', 'duragan'),
(759, 227, 57, 'Erfelek', 'erfelek'),
(760, 227, 57, 'Gerze', 'gerze'),
(761, 227, 57, 'Saraydüzü', 'sarayduzu'),
(762, 227, 57, 'Türkeli', 'turkeli'),
(763, 227, 58, 'Sivas', 'sivas'),
(764, 227, 58, 'Akıncılar', 'akincilar'),
(765, 227, 58, 'Altınyayla', 'altinyayla'),
(766, 227, 58, 'Divriği', 'divrigi'),
(767, 227, 58, 'Doğanşar', 'dogansar'),
(768, 227, 58, 'Gemerek', 'gemerek'),
(769, 227, 58, 'Gölova', 'golova'),
(770, 227, 58, 'Gürün', 'gurun'),
(771, 227, 58, 'Hafik', 'hafik'),
(772, 227, 58, 'İmranlı', 'imranli'),
(773, 227, 58, 'Kangal', 'kangal'),
(774, 227, 58, 'Koyulhisar', 'koyulhisar'),
(775, 227, 58, 'Suşehri', 'susehri'),
(776, 227, 58, 'Şarkışla', 'sarkisla'),
(777, 227, 58, 'Ulaş', 'ulas'),
(778, 227, 58, 'Yıldızeli', 'yildizeli'),
(779, 227, 58, 'Zara', 'zara'),
(780, 227, 59, 'Tekirdağ', 'tekirdag'),
(781, 227, 59, 'Çerkezköy', 'cerkezkoy'),
(782, 227, 59, 'Çorlu', 'corlu'),
(783, 227, 59, 'Hayrabolu', 'hayrabolu'),
(784, 227, 59, 'Malkara', 'malkara'),
(785, 227, 59, 'Marmaraereğlisi', 'marmaraereglisi'),
(786, 227, 59, 'Muratlı', 'muratli'),
(787, 227, 59, 'Saray', 'saray'),
(788, 227, 59, 'Şarköy', 'sarkoy'),
(789, 227, 60, 'Tokat', 'tokat'),
(790, 227, 60, 'Almus', 'almus'),
(791, 227, 60, 'Artova', 'artova'),
(792, 227, 60, 'Başçiftlik', 'basciftlik'),
(793, 227, 60, 'Erbaa', 'erbaa'),
(794, 227, 60, 'Niksar', 'niksar'),
(795, 227, 60, 'Pazar', 'pazar'),
(796, 227, 60, 'Reşadiye', 'resadiye'),
(797, 227, 60, 'Sulusaray', 'sulusaray'),
(798, 227, 60, 'Turhal', 'turhal'),
(799, 227, 60, 'Yeşilyurt', 'yesilyurt'),
(800, 227, 60, 'Zile', 'zile'),
(801, 227, 61, 'Trabzon', 'trabzon'),
(802, 227, 61, 'Akçaabat', 'akcaabat'),
(803, 227, 61, 'Araklı', 'arakli'),
(804, 227, 61, 'Arsin', 'arsin'),
(805, 227, 61, 'Beşikdüzü', 'besikduzu'),
(806, 227, 61, 'Çarşıbaşı', 'carsibasi'),
(807, 227, 61, 'Çaykara', 'caykara'),
(808, 227, 61, 'Dernekpazarı', 'dernekpazari'),
(809, 227, 61, 'Düzköy', 'duzkoy'),
(810, 227, 61, 'Hayrat', 'hayrat'),
(811, 227, 61, 'Köprübaşı', 'koprubasi'),
(812, 227, 61, 'Maçka', 'macka'),
(813, 227, 61, 'Of', 'of'),
(814, 227, 61, 'Sürmene', 'surmene'),
(815, 227, 61, 'Şalpazarı', 'salpazari'),
(816, 227, 61, 'Tonya', 'tonya'),
(817, 227, 61, 'Vakfıkebir', 'vakfikebir'),
(818, 227, 61, 'Yomra', 'yomra'),
(819, 227, 62, 'Tunceli', 'tunceli'),
(820, 227, 62, 'Çemişgezek', 'cemisgezek'),
(821, 227, 62, 'Hozat', 'hozat'),
(822, 227, 62, 'Mazgirt', 'mazgirt'),
(823, 227, 62, 'Nazımiye', 'nazimiye'),
(824, 227, 62, 'Ovacık', 'ovacik'),
(825, 227, 62, 'Pertek', 'pertek'),
(826, 227, 62, 'Pülümür', 'pulumur'),
(827, 227, 63, 'Şanlıurfa', 'sanliurfa'),
(828, 227, 63, 'Akçakale', 'akcakale'),
(829, 227, 63, 'Birecik', 'birecik'),
(830, 227, 63, 'Bozova', 'bozova'),
(831, 227, 63, 'Ceylanpınar', 'ceylanpinar'),
(832, 227, 63, 'Halfeti', 'halfeti'),
(833, 227, 63, 'Harran', 'harran'),
(834, 227, 63, 'Hilvan', 'hilvan'),
(835, 227, 63, 'Siverek', 'siverek'),
(836, 227, 63, 'Suruç', 'suruc'),
(837, 227, 63, 'Viranşehir', 'viransehir'),
(838, 227, 64, 'Uşak', 'usak'),
(839, 227, 64, 'Banaz', 'banaz'),
(840, 227, 64, 'Eşme', 'esme'),
(841, 227, 64, 'Karahallı', 'karahalli'),
(842, 227, 64, 'Sivaslı', 'sivasli'),
(843, 227, 64, 'Ulubey', 'ulubey'),
(844, 227, 65, 'Van', 'van'),
(845, 227, 65, 'Bahçesaray', 'bahcesaray'),
(846, 227, 65, 'Başkale', 'baskale'),
(847, 227, 65, 'Çaldıran', 'caldiran'),
(848, 227, 65, 'Çatak', 'catak'),
(849, 227, 65, 'Edremit(Gümüşdere)', 'edremitgumusdere'),
(850, 227, 65, 'Erciş', 'ercis'),
(851, 227, 65, 'Gevaş', 'gevas'),
(852, 227, 65, 'Gürpınar', 'gurpinar'),
(853, 227, 65, 'Muradiye', 'muradiye'),
(854, 227, 65, 'Özalp', 'ozalp'),
(855, 227, 65, 'Saray', 'saray'),
(856, 227, 66, 'Yozgat', 'yozgat'),
(857, 227, 66, 'Akdağmadeni', 'akdagmadeni'),
(858, 227, 66, 'Aydıncık', 'aydincik'),
(859, 227, 66, 'Boğazlıyan', 'bogazliyan'),
(860, 227, 66, 'Çandır', 'candir'),
(861, 227, 66, 'Çayıralan', 'cayiralan'),
(862, 227, 66, 'Çekerek', 'cekerek'),
(863, 227, 66, 'Kadışehri', 'kadisehri'),
(864, 227, 66, 'Saraykent', 'saraykent'),
(865, 227, 66, 'Sarıkaya', 'sarikaya'),
(866, 227, 66, 'Sorgun', 'sorgun'),
(867, 227, 66, 'Şefaatli', 'sefaatli'),
(868, 227, 66, 'Yenifakılı', 'yenifakili'),
(869, 227, 66, 'Yerköy', 'yerkoy'),
(870, 227, 67, 'Zonguldak', 'zonguldak'),
(871, 227, 67, 'Alaplı', 'alapli'),
(872, 227, 67, 'Çaycuma', 'caycuma'),
(873, 227, 67, 'Devrek', 'devrek'),
(874, 227, 67, 'Karadenizereğli', 'karadenizeregli'),
(875, 227, 67, 'Gökçebey', 'gokcebey'),
(876, 227, 68, 'Aksaray', 'aksaray'),
(877, 227, 68, 'Ağaçören', 'agacoren'),
(878, 227, 68, 'Eskil', 'eskil'),
(879, 227, 68, 'Gülağaç(Ağaçlı)', 'gulagacagacli'),
(880, 227, 68, 'Güzelyurt', 'guzelyurt'),
(881, 227, 68, 'Ortaköy', 'ortakoy'),
(882, 227, 68, 'Sarıyahşi', 'sariyahsi'),
(883, 227, 69, 'Bayburt', 'bayburt'),
(884, 227, 69, 'Aydıntepe', 'aydintepe'),
(885, 227, 69, 'Demirözü', 'demirozu'),
(886, 227, 70, 'Karaman', 'karaman'),
(887, 227, 70, 'Ayrancı', 'ayranci'),
(888, 227, 70, 'Başyayla', 'basyayla'),
(889, 227, 70, 'Ermenek', 'ermenek'),
(890, 227, 70, 'Kazımkarabekir', 'kazimkarabekir'),
(891, 227, 70, 'Sarıveliler', 'sariveliler'),
(892, 227, 71, 'Kırıkkale', 'kirikkale'),
(893, 227, 71, 'Bahşili', 'bahsili'),
(894, 227, 71, 'Balışeyh', 'baliseyh'),
(895, 227, 71, 'Çelebi', 'celebi'),
(896, 227, 71, 'Delice', 'delice'),
(897, 227, 71, 'Karakeçili', 'karakecili'),
(898, 227, 71, 'Keskin', 'keskin'),
(899, 227, 71, 'Sulakyurt', 'sulakyurt'),
(900, 227, 71, 'Yahşihan', 'yahsihan'),
(901, 227, 72, 'Batman', 'batman'),
(902, 227, 72, 'Beşiri', 'besiri'),
(903, 227, 72, 'Gercüş', 'gercus'),
(904, 227, 72, 'Hasankeyf', 'hasankeyf'),
(905, 227, 72, 'Kozluk', 'kozluk'),
(906, 227, 72, 'Sason', 'sason'),
(907, 227, 73, 'Şırnak', 'sirnak'),
(908, 227, 73, 'Beytüşşebap', 'beytussebap'),
(909, 227, 73, 'Cizre', 'cizre'),
(910, 227, 73, 'Güçlükonak', 'guclukonak'),
(911, 227, 73, 'İdil', 'idil'),
(912, 227, 73, 'Silopi', 'silopi'),
(913, 227, 73, 'Uludere', 'uludere'),
(914, 227, 74, 'Bartın', 'bartin'),
(915, 227, 74, 'Amasra', 'amasra'),
(916, 227, 74, 'Kurucaşile', 'kurucasile'),
(917, 227, 74, 'Ulus', 'ulus'),
(918, 227, 75, 'Ardahan', 'ardahan'),
(919, 227, 75, 'Çıldır', 'cildir'),
(920, 227, 75, 'Damal', 'damal'),
(921, 227, 75, 'Göle', 'gole'),
(922, 227, 75, 'Hanak', 'hanak'),
(923, 227, 75, 'Posof', 'posof'),
(924, 227, 76, 'Iğdır', 'igdir'),
(925, 227, 76, 'Aralık', 'aralik'),
(926, 227, 76, 'Karakoyunlu', 'karakoyunlu'),
(927, 227, 76, 'Tuzluca', 'tuzluca'),
(928, 227, 77, 'Yalova', 'yalova'),
(929, 227, 77, 'Altınova', 'altinova'),
(930, 227, 77, 'Armutlu', 'armutlu'),
(931, 227, 77, 'Çiftlikköy', 'ciftlikkoy'),
(932, 227, 77, 'Çınarcık', 'cinarcik'),
(933, 227, 77, 'Termal', 'termal'),
(934, 227, 78, 'Karabük', 'karabuk'),
(935, 227, 78, 'Eflani', 'eflani'),
(936, 227, 78, 'Eskipazar', 'eskipazar'),
(937, 227, 78, 'Ovacık', 'ovacik'),
(938, 227, 78, 'Safranbolu', 'safranbolu'),
(939, 227, 78, 'Yenice', 'yenice'),
(940, 227, 79, 'Kilis', 'kilis'),
(941, 227, 79, 'Elbeyli', 'elbeyli'),
(942, 227, 79, 'Musabeyli', 'musabeyli'),
(943, 227, 79, 'Polateli', 'polateli'),
(944, 227, 80, 'Osmaniye', 'osmaniye'),
(945, 227, 80, 'Bahçe', 'bahce'),
(946, 227, 80, 'Düziçi', 'duzici'),
(947, 227, 80, 'Hasanbeyli', 'hasanbeyli'),
(948, 227, 80, 'Kadirli', 'kadirli'),
(949, 227, 80, 'Sumbas', 'sumbas'),
(950, 227, 80, 'Toprakkale', 'toprakkale'),
(951, 227, 81, 'Düzce', 'duzce'),
(952, 227, 81, 'Akçakoca', 'akcakoca'),
(953, 227, 81, 'Cumayeri', 'cumayeri'),
(954, 227, 81, 'Çilimli', 'cilimli'),
(955, 227, 81, 'Gölyaka', 'golyaka'),
(956, 227, 81, 'Gümüşova', 'gumusova'),
(957, 227, 81, 'Kaynaşlı', 'kaynasli'),
(958, 227, 81, 'Yığılca', 'yigilca'),
(962, 227, 20, 'Pamukkale', 'pamukkale'),
(963, 227, 7, 'Olympos', 'olympos'),
(964, 227, 7, 'Çıralı', 'cirali'),
(965, 227, 7, 'Kaleiçi', 'kaleici'),
(967, 227, 33, 'Kızkalesi', 'kizkalesi'),
(968, 227, 20, 'Karahayit', 'karahayit'),
(974, 227, 46, 'Onikişubat', 'onikisubat'),
(975, 227, 46, 'Dülkadiroğlu', 'dulkadiroglu'),
(976, 227, 20, 'Merkezefendi', 'merkezefendi');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) UNSIGNED NOT NULL,
  `common_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `native_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `a2_iso` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `a3_iso` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tld` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calling_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capital` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subregion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `languages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latlng` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `common_name`, `native_name`, `a2_iso`, `a3_iso`, `tld`, `currency`, `calling_code`, `capital`, `region`, `subregion`, `languages`, `latlng`) VALUES
(1, 'Afghanistan', 'افغانستان', 'AF', 'AFG', '.af', 'AFN', '93', 'Kabul', 'Asia', 'Southern Asia', 'ps,tk', '33,65'),
(2, 'Albania', 'Shqipëria', 'AL', 'ALB', '.al', 'ALL', '355', 'Tirana', 'Europe', 'Southern Europe', 'sq', '41,20'),
(3, 'Algeria', 'الجزائر', 'DZ', 'DZA', '.dz,الجزائ', 'DZD', '213', 'Algiers', 'Africa', 'Northern Africa', 'ar', '28,3'),
(4, 'American Samoa', 'American Samoa', 'AS', 'ASM', '.as', 'USD', '1684', 'Pago Pago', 'Oceania', 'Polynesia', 'en,sm', '-14.33333333,-170'),
(5, 'Andorra', 'Andorra', 'AD', 'AND', '.ad', 'EUR', '376', 'Andorra la Vella', 'Europe', 'Southern Europe', 'ca', '42.5,1.5'),
(6, 'Angola', 'Angola', 'AO', 'AGO', '.ao', 'AOA', '244', 'Luanda', 'Africa', 'Middle Africa', 'pt', '-12.5,18.5'),
(7, 'Anguilla', 'Anguilla', 'AI', 'AIA', '.ai', 'XCD', '1264', 'The Valley', 'Americas', 'Caribbean', 'en', '18.25,-63.16666666'),
(8, 'Antarctica', 'Antarctica', 'AQ', 'ATA', '.aq', '', '', '', 'Antarctic', '', 'en', '-90,0'),
(9, 'Antigua and Barbuda', 'Antigua and Barbuda', 'AG', 'ATG', '.ag', 'XCD', '1268', 'Saint John\'s', 'Americas', 'Caribbean', 'en', '17.05,-61.8'),
(10, 'Argentina', 'Argentina', 'AR', 'ARG', '.ar', 'ARS', '54', 'Buenos Aires', 'Americas', 'South America', 'gn,es', '-34,-64'),
(11, 'Armenia', 'Հայաստան', 'AM', 'ARM', '.am', 'AMD', '374', 'Yerevan', 'Asia', 'Western Asia', 'hy', '40,45'),
(12, 'Aruba', 'Aruba', 'AW', 'ABW', '.aw', 'AWG', '297', 'Oranjestad', 'Americas', 'Caribbean', 'nl', '12.5,-69.96666666'),
(13, 'Australia', 'Australia', 'AU', 'AUS', '.au', 'AUD', '61', 'Canberra', 'Oceania', 'Australia and New Zealand', 'en', '-27,133'),
(14, 'Austria', 'Österreich', 'AT', 'AUT', '.at', 'EUR', '43', 'Vienna', 'Europe', 'Western Europe', 'de,hu,sl', '47.33333333,13.33333333'),
(15, 'Azerbaijan', 'Azərbaycan', 'AZ', 'AZE', '.az', 'AZN', '994', 'Baku', 'Asia', 'Western Asia', 'az,tr,ru', '40.5,47.5'),
(16, 'Bahamas', 'Bahamas', 'BS', 'BHS', '.bs', 'BSD', '1242', 'Nassau', 'Americas', 'Caribbean', 'en', '24.25,-76'),
(17, 'Bahrain', '‏البحرين', 'BH', 'BHR', '.bh', 'BHD', '973', 'Manama', 'Asia', 'Western Asia', 'ar', '26,50.55'),
(18, 'Bangladesh', 'বাংলাদেশ', 'BD', 'BGD', '.bd', 'BDT', '880', 'Dhaka', 'Asia', 'Southern Asia', 'bn', '24,90'),
(19, 'Barbados', 'Barbados', 'BB', 'BRB', '.bb', 'BBD', '1246', 'Bridgetown', 'Americas', 'Caribbean', 'en', '13.16666666,-59.53333333'),
(20, 'Belarus', 'Белару́сь', 'BY', 'BLR', '.by', 'BYN', '375', 'Minsk', 'Europe', 'Eastern Europe', 'be,ru', '53,28'),
(21, 'Belgium', 'Belgien', 'BE', 'BEL', '.be', 'EUR', '32', 'Brussels', 'Europe', 'Western Europe', 'de,fr,nl', '50.83333333,4'),
(22, 'Belize', 'Belize', 'BZ', 'BLZ', '.bz', 'BZD', '501', 'Belmopan', 'Americas', 'Central America', 'en,es', '17.25,-88.75'),
(23, 'Benin', 'Bénin', 'BJ', 'BEN', '.bj', 'XOF', '229', 'Porto-Novo', 'Africa', 'Western Africa', 'fr', '9.5,2.25'),
(24, 'Bermuda', 'Bermuda', 'BM', 'BMU', '.bm', 'BMD', '1441', 'Hamilton', 'Americas', 'Northern America', 'en', '32.33333333,-64.75'),
(25, 'Bhutan', 'འབྲུག་ཡུལ་', 'BT', 'BTN', '.bt', 'BTN,INR', '975', 'Thimphu', 'Asia', 'Southern Asia', 'dz', '27.5,90.5'),
(26, 'Bolivia', 'Wuliwya', 'BO', 'BOL', '.bo', 'BOB,BOV', '591', 'Sucre', 'Americas', 'South America', 'ay,gn,qu,es', '-17,-65'),
(27, 'Caribbean Netherlands', 'Caribisch Nederland', 'BQ', 'BES', '.bq,.nl', 'USD', '599', '', 'Americas', 'Caribbean', 'en,nl', '12.18,-68.25'),
(28, 'Bosnia and Herzegovina', 'Bosna i Hercegovina', 'BA', 'BIH', '.ba', 'BAM', '387', 'Sarajevo', 'Europe', 'Southern Europe', 'bs,hr,sr', '44,18'),
(29, 'Botswana', 'Botswana', 'BW', 'BWA', '.bw', 'BWP', '267', 'Gaborone', 'Africa', 'Southern Africa', 'en,tn', '-22,24'),
(30, 'Bouvet Island', 'Bouvetøya', 'BV', 'BVT', '.bv', 'NOK', '', '', 'Antarctic', '', 'no', '-54.43333333,3.4'),
(31, 'Brazil', 'Brasil', 'BR', 'BRA', '.br', 'BRL', '55', 'Brasília', 'Americas', 'South America', 'pt', '-10,-55'),
(32, 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'IO', 'IOT', '.io', 'USD', '246', 'Diego Garcia', 'Africa', 'Eastern Africa', 'en', '-6,71.5'),
(33, 'Brunei', 'Negara Brunei Darussalam', 'BN', 'BRN', '.bn', 'BND', '673', 'Bandar Seri Begawan', 'Asia', 'South-Eastern Asia', 'ms', '4.5,114.66666666'),
(34, 'Bulgaria', 'България', 'BG', 'BGR', '.bg', 'BGN', '359', 'Sofia', 'Europe', 'Eastern Europe', 'bg', '43,25'),
(35, 'Burkina Faso', 'Burkina Faso', 'BF', 'BFA', '.bf', 'XOF', '226', 'Ouagadougou', 'Africa', 'Western Africa', 'fr', '13,-2'),
(36, 'Burundi', 'Burundi', 'BI', 'BDI', '.bi', 'BIF', '257', 'Bujumbura', 'Africa', 'Eastern Africa', 'fr,rn', '-3.5,30'),
(37, 'Cambodia', 'Kâmpŭchéa', 'KH', 'KHM', '.kh', 'KHR', '855', 'Phnom Penh', 'Asia', 'South-Eastern Asia', 'km', '13,105'),
(38, 'Cameroon', 'Cameroon', 'CM', 'CMR', '.cm', 'XAF', '237', 'Yaoundé', 'Africa', 'Middle Africa', 'en,fr', '6,12'),
(39, 'Canada', 'Canada', 'CA', 'CAN', '.ca', 'CAD', '1', 'Ottawa', 'Americas', 'Northern America', 'en,fr', '60,-95'),
(40, 'Cape Verde', 'Cabo Verde', 'CV', 'CPV', '.cv', 'CVE', '238', 'Praia', 'Africa', 'Western Africa', 'pt', '16,-24'),
(41, 'Cayman Islands', 'Cayman Islands', 'KY', 'CYM', '.ky', 'KYD', '1345', 'George Town', 'Americas', 'Caribbean', 'en', '19.5,-80.5'),
(42, 'Central African Republic', 'République centrafricaine', 'CF', 'CAF', '.cf', 'XAF', '236', 'Bangui', 'Africa', 'Middle Africa', 'fr,sg', '7,21'),
(43, 'Chad', 'تشاد‎', 'TD', 'TCD', '.td', 'XAF', '235', 'N\'Djamena', 'Africa', 'Middle Africa', 'ar,fr', '15,19'),
(44, 'Chile', 'Chile', 'CL', 'CHL', '.cl', 'CLF,CLP', '56', 'Santiago', 'Americas', 'South America', 'es', '-30,-71'),
(45, 'China', '中国', 'CN', 'CHN', '.cn,.中国,.中', 'CNY', '86', 'Beijing', 'Asia', 'Eastern Asia', 'zh', '35,105'),
(46, 'Christmas Island', 'Christmas Island', 'CX', 'CXR', '.cx', 'AUD', '61', 'Flying Fish Cove', 'Oceania', 'Australia and New Zealand', 'en', '-10.5,105.66666666'),
(47, 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 'CC', 'CCK', '.cc', 'AUD', '61', 'West Island', 'Oceania', 'Australia and New Zealand', 'en', '-12.5,96.83333333'),
(48, 'Colombia', 'Colombia', 'CO', 'COL', '.co', 'COP', '57', 'Bogotá', 'Americas', 'South America', 'es', '4,-72'),
(49, 'Comoros', 'القمر‎', 'KM', 'COM', '.km', 'KMF', '269', 'Moroni', 'Africa', 'Eastern Africa', 'ar,fr', '-12.16666666,44.25'),
(50, 'Republic of the Congo', 'République du Congo', 'CG', 'COG', '.cg', 'XAF', '242', 'Brazzaville', 'Africa', 'Middle Africa', 'fr,kg,ln', '-1,15'),
(51, 'DR Congo', 'RD Congo', 'CD', 'COD', '.cd', 'CDF', '243', 'Kinshasa', 'Africa', 'Middle Africa', 'fr,kg,ln,sw', '0,25'),
(52, 'Cook Islands', 'Cook Islands', 'CK', 'COK', '.ck', 'NZD,CKD', '682', 'Avarua', 'Oceania', 'Polynesia', 'en', '-21.23333333,-159.76666666'),
(53, 'Costa Rica', 'Costa Rica', 'CR', 'CRI', '.cr', 'CRC', '506', 'San José', 'Americas', 'Central America', 'es', '10,-84'),
(54, 'Croatia', 'Hrvatska', 'HR', 'HRV', '.hr', 'HRK', '385', 'Zagreb', 'Europe', 'Southern Europe', 'hr', '45.16666666,15.5'),
(55, 'Cuba', 'Cuba', 'CU', 'CUB', '.cu', 'CUC,CUP', '53', 'Havana', 'Americas', 'Caribbean', 'es', '21.5,-80'),
(56, 'Curaçao', 'Curaçao', 'CW', 'CUW', '.cw', 'ANG', '5999', 'Willemstad', 'Americas', 'Caribbean', 'en,nl', '12.116667,-68.933333'),
(57, 'Cyprus', 'Κύπρος', 'CY', 'CYP', '.cy', 'EUR', '357', 'Nicosia', 'Europe', 'Eastern Europe', 'el,tr', '35,33'),
(58, 'Czechia', 'Česko', 'CZ', 'CZE', '.cz', 'CZK', '420', 'Prague', 'Europe', 'Eastern Europe', 'cs,sk', '49.75,15.5'),
(59, 'Ivory Coast', 'Côte d\'Ivoire', 'CI', 'CIV', '.ci', 'XOF', '225', 'Yamoussoukro', 'Africa', 'Western Africa', 'fr', '8,-5'),
(60, 'Denmark', 'Danmark', 'DK', 'DNK', '.dk', 'DKK', '45', 'Copenhagen', 'Europe', 'Northern Europe', 'da', '56,10'),
(61, 'Djibouti', 'جيبوتي‎', 'DJ', 'DJI', '.dj', 'DJF', '253', 'Djibouti', 'Africa', 'Eastern Africa', 'ar,fr', '11.5,43'),
(62, 'Dominica', 'Dominica', 'DM', 'DMA', '.dm', 'XCD', '1767', 'Roseau', 'Americas', 'Caribbean', 'en', '15.41666666,-61.33333333'),
(63, 'Dominican Republic', 'República Dominicana', 'DO', 'DOM', '.do', 'DOP', '1809,1829,', 'Santo Domingo', 'Americas', 'Caribbean', 'es', '19,-70.66666666'),
(64, 'Ecuador', 'Ecuador', 'EC', 'ECU', '.ec', 'USD', '593', 'Quito', 'Americas', 'South America', 'es', '-2,-77.5'),
(65, 'Egypt', 'مصر', 'EG', 'EGY', '.eg,.مصر', 'EGP', '20', 'Cairo', 'Africa', 'Northern Africa', 'ar', '27,30'),
(66, 'El Salvador', 'El Salvador', 'SV', 'SLV', '.sv', 'SVC,USD', '503', 'San Salvador', 'Americas', 'Central America', 'es', '13.83333333,-88.91666666'),
(67, 'Equatorial Guinea', 'Guinée équatoriale', 'GQ', 'GNQ', '.gq', 'XAF', '240', 'Malabo', 'Africa', 'Middle Africa', 'fr,pt,es', '2,10'),
(68, 'Eritrea', 'إرتريا‎', 'ER', 'ERI', '.er', 'ERN', '291', 'Asmara', 'Africa', 'Eastern Africa', 'ar,en,ti', '15,39'),
(69, 'Estonia', 'Eesti', 'EE', 'EST', '.ee', 'EUR', '372', 'Tallinn', 'Europe', 'Northern Europe', 'et', '59,26'),
(70, 'Ethiopia', 'ኢትዮጵያ', 'ET', 'ETH', '.et', 'ETB', '251', 'Addis Ababa', 'Africa', 'Eastern Africa', 'am', '8,38'),
(71, 'Falkland Islands', 'Falkland Islands', 'FK', 'FLK', '.fk', 'FKP', '500', 'Stanley', 'Americas', 'South America', 'en', '-51.75,-59'),
(72, 'Faroe Islands', 'Færøerne', 'FO', 'FRO', '.fo', 'DKK', '298', 'Tórshavn', 'Europe', 'Northern Europe', 'da,fo', '62,-7'),
(73, 'Fiji', 'Fiji', 'FJ', 'FJI', '.fj', 'FJD', '679', 'Suva', 'Oceania', 'Melanesia', 'en,fj', '-18,175'),
(74, 'Finland', 'Suomi', 'FI', 'FIN', '.fi', 'EUR', '358', 'Helsinki', 'Europe', 'Northern Europe', 'fi,sv', '64,26'),
(75, 'France', 'France', 'FR', 'FRA', '.fr', 'EUR', '33', 'Paris', 'Europe', 'Western Europe', 'fr', '46,2'),
(76, 'French Guiana', 'Guyane française', 'GF', 'GUF', '.gf', 'EUR', '594', 'Cayenne', 'Americas', 'South America', 'fr', '4,-53'),
(77, 'French Polynesia', 'Polynésie française', 'PF', 'PYF', '.pf', 'XPF', '689', 'Papeetē', 'Oceania', 'Polynesia', 'fr', '-15,-140'),
(78, 'French Southern and Antarctic Lands', 'Terres australes et antarctiques françaises', 'TF', 'ATF', '.tf', 'EUR', '', 'Port-aux-Français', 'Antarctic', '', 'fr', '-49.25,69.167'),
(79, 'Gabon', 'Gabon', 'GA', 'GAB', '.ga', 'XAF', '241', 'Libreville', 'Africa', 'Middle Africa', 'fr', '-1,11.75'),
(80, 'Gambia', 'Gambia', 'GM', 'GMB', '.gm', 'GMD', '220', 'Banjul', 'Africa', 'Western Africa', 'en', '13.46666666,-16.56666666'),
(81, 'Georgia', 'საქართველო', 'GE', 'GEO', '.ge', 'GEL', '995', 'Tbilisi', 'Asia', 'Western Asia', 'ka', '42,43.5'),
(82, 'Germany', 'Deutschland', 'DE', 'DEU', '.de', 'EUR', '49', 'Berlin', 'Europe', 'Western Europe', 'de', '51,9'),
(83, 'Ghana', 'Ghana', 'GH', 'GHA', '.gh', 'GHS', '233', 'Accra', 'Africa', 'Western Africa', 'en', '8,-2'),
(84, 'Gibraltar', 'Gibraltar', 'GI', 'GIB', '.gi', 'GIP', '350', 'Gibraltar', 'Europe', 'Southern Europe', 'en', '36.13333333,-5.35'),
(85, 'Greece', 'Ελλάδα', 'GR', 'GRC', '.gr', 'EUR', '30', 'Athens', 'Europe', 'Southern Europe', 'el', '39,22'),
(86, 'Greenland', 'Kalaallit Nunaat', 'GL', 'GRL', '.gl', 'DKK', '299', 'Nuuk', 'Americas', 'Northern America', 'kl', '72,-40'),
(87, 'Grenada', 'Grenada', 'GD', 'GRD', '.gd', 'XCD', '1473', 'St. George\'s', 'Americas', 'Caribbean', 'en', '12.11666666,-61.66666666'),
(88, 'Guadeloupe', 'Guadeloupe', 'GP', 'GLP', '.gp', 'EUR', '590', 'Basse-Terre', 'Americas', 'Caribbean', 'fr', '16.25,-61.583333'),
(89, 'Guam', 'Guåhån', 'GU', 'GUM', '.gu', 'USD', '1671', 'Hagåtña', 'Oceania', 'Micronesia', 'ch,en,es', '13.46666666,144.78333333'),
(90, 'Guatemala', 'Guatemala', 'GT', 'GTM', '.gt', 'GTQ', '502', 'Guatemala City', 'Americas', 'Central America', 'es', '15.5,-90.25'),
(91, 'Guernsey', 'Guernsey', 'GG', 'GGY', '.gg', 'GBP', '44', 'St. Peter Port', 'Europe', 'Northern Europe', 'en,fr', '49.46666666,-2.58333333'),
(92, 'Guinea', 'Guinée', 'GN', 'GIN', '.gn', 'GNF', '224', 'Conakry', 'Africa', 'Western Africa', 'fr', '11,-10'),
(93, 'Guinea-Bissau', 'Guiné-Bissau', 'GW', 'GNB', '.gw', 'XOF', '245', 'Bissau', 'Africa', 'Western Africa', 'pt', '12,-15'),
(94, 'Guyana', 'Guyana', 'GY', 'GUY', '.gy', 'GYD', '592', 'Georgetown', 'Americas', 'South America', 'en', '5,-59'),
(95, 'Haiti', 'Haïti', 'HT', 'HTI', '.ht', 'HTG,USD', '509', 'Port-au-Prince', 'Americas', 'Caribbean', 'fr,ht', '19,-72.41666666'),
(96, 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'HM', 'HMD', '.hm,.aq', 'AUD', '', '', 'Antarctic', '', 'en', '-53.1,72.51666666'),
(97, 'Vatican City', 'Vaticano', 'VA', 'VAT', '.va', 'EUR', '3906698,37', 'Vatican City', 'Europe', 'Southern Europe', 'it,la', '41.9,12.45'),
(98, 'Honduras', 'Honduras', 'HN', 'HND', '.hn', 'HNL', '504', 'Tegucigalpa', 'Americas', 'Central America', 'es', '15,-86.5'),
(99, 'Hong Kong', 'Hong Kong', 'HK', 'HKG', '.hk,.香港', 'HKD', '852', 'City of Victoria', 'Asia', 'Eastern Asia', 'en,zh', '22.267,114.188'),
(100, 'Hungary', 'Magyarország', 'HU', 'HUN', '.hu', 'HUF', '36', 'Budapest', 'Europe', 'Eastern Europe', 'hu', '47,20'),
(101, 'Iceland', 'Ísland', 'IS', 'ISL', '.is', 'ISK', '354', 'Reykjavik', 'Europe', 'Northern Europe', 'is', '65,-18'),
(102, 'India', 'India', 'IN', 'IND', '.in', 'INR', '91', 'New Delhi', 'Asia', 'Southern Asia', 'en,hi,ta', '20,77'),
(103, 'Indonesia', 'Indonesia', 'ID', 'IDN', '.id', 'IDR', '62', 'Jakarta', 'Asia', 'South-Eastern Asia', 'id', '-5,120'),
(104, 'Iran', 'ایران', 'IR', 'IRN', '.ir,ایران.', 'IRR', '98', 'Tehran', 'Asia', 'Southern Asia', 'fa', '32,53'),
(105, 'Iraq', 'العراق', 'IQ', 'IRQ', '.iq', 'IQD', '964', 'Baghdad', 'Asia', 'Western Asia', 'ar', '33,44'),
(106, 'Ireland', 'Ireland', 'IE', 'IRL', '.ie', 'EUR', '353', 'Dublin', 'Europe', 'Northern Europe', 'en,ga', '53,-8'),
(107, 'Isle of Man', 'Isle of Man', 'IM', 'IMN', '.im', 'GBP', '44', 'Douglas', 'Europe', 'Northern Europe', 'en,gv', '54.25,-4.5'),
(108, 'Israel', 'إسرائيل', 'IL', 'ISR', '.il', 'ILS', '972', 'Jerusalem', 'Asia', 'Western Asia', 'ar,he', '31.47,35.13'),
(109, 'Italy', 'Italia', 'IT', 'ITA', '.it', 'EUR', '39', 'Rome', 'Europe', 'Southern Europe', 'it', '42.83333333,12.83333333'),
(110, 'Jamaica', 'Jamaica', 'JM', 'JAM', '.jm', 'JMD', '1876', 'Kingston', 'Americas', 'Caribbean', 'en', '18.25,-77.5'),
(111, 'Japan', '日本', 'JP', 'JPN', '.jp,.みんな', 'JPY', '81', 'Tokyo', 'Asia', 'Eastern Asia', 'ja', '36,138'),
(112, 'Jersey', 'Jersey', 'JE', 'JEY', '.je', 'GBP', '44', 'Saint Helier', 'Europe', 'Northern Europe', 'en,fr', '49.25,-2.16666666'),
(113, 'Jordan', 'الأردن', 'JO', 'JOR', '.jo,الاردن', 'JOD', '962', 'Amman', 'Asia', 'Western Asia', 'ar', '31,36'),
(114, 'Kazakhstan', 'Қазақстан', 'KZ', 'KAZ', '.kz,.қаз', 'KZT', '76,77', 'Astana', 'Asia', 'Central Asia', 'kk,ru', '48,68'),
(115, 'Kenya', 'Kenya', 'KE', 'KEN', '.ke', 'KES', '254', 'Nairobi', 'Africa', 'Eastern Africa', 'en,sw', '1,38'),
(116, 'Kiribati', 'Kiribati', 'KI', 'KIR', '.ki', 'AUD', '686', 'South Tarawa', 'Oceania', 'Micronesia', 'en', '1.41666666,173'),
(117, 'North Korea', '북한', 'KP', 'PRK', '.kp', 'KPW', '850', 'Pyongyang', 'Asia', 'Eastern Asia', 'ko', '40,127'),
(118, 'South Korea', '대한민국', 'KR', 'KOR', '.kr,.한국', 'KRW', '82', 'Seoul', 'Asia', 'Eastern Asia', 'ko', '37,127.5'),
(119, 'Kuwait', 'الكويت', 'KW', 'KWT', '.kw', 'KWD', '965', 'Kuwait City', 'Asia', 'Western Asia', 'ar', '29.5,45.75'),
(120, 'Kyrgyzstan', 'Кыргызстан', 'KG', 'KGZ', '.kg', 'KGS', '996', 'Bishkek', 'Asia', 'Central Asia', 'ky,ru', '41,75'),
(121, 'Laos', 'ສປປລາວ', 'LA', 'LAO', '.la', 'LAK', '856', 'Vientiane', 'Asia', 'South-Eastern Asia', 'lo', '18,105'),
(122, 'Latvia', 'Latvija', 'LV', 'LVA', '.lv', 'EUR', '371', 'Riga', 'Europe', 'Northern Europe', 'lv', '57,25'),
(123, 'Lebanon', 'لبنان', 'LB', 'LBN', '.lb', 'LBP', '961', 'Beirut', 'Asia', 'Western Asia', 'ar,fr', '33.83333333,35.83333333'),
(124, 'Lesotho', 'Lesotho', 'LS', 'LSO', '.ls', 'LSL,ZAR', '266', 'Maseru', 'Africa', 'Southern Africa', 'en,st', '-29.5,28.5'),
(125, 'Liberia', 'Liberia', 'LR', 'LBR', '.lr', 'LRD', '231', 'Monrovia', 'Africa', 'Western Africa', 'en', '6.5,-9.5'),
(126, 'Libya', '‏ليبيا', 'LY', 'LBY', '.ly', 'LYD', '218', 'Tripoli', 'Africa', 'Northern Africa', 'ar', '25,17'),
(127, 'Liechtenstein', 'Liechtenstein', 'LI', 'LIE', '.li', 'CHF', '423', 'Vaduz', 'Europe', 'Western Europe', 'de', '47.26666666,9.53333333'),
(128, 'Lithuania', 'Lietuva', 'LT', 'LTU', '.lt', 'EUR', '370', 'Vilnius', 'Europe', 'Northern Europe', 'lt', '56,24'),
(129, 'Luxembourg', 'Luxemburg', 'LU', 'LUX', '.lu', 'EUR', '352', 'Luxembourg', 'Europe', 'Western Europe', 'de,fr,lb', '49.75,6.16666666'),
(130, 'Macau', 'Macau', 'MO', 'MAC', '.mo', 'MOP', '853', '', 'Asia', 'Eastern Asia', 'pt,zh', '22.16666666,113.55'),
(131, 'Macedonia', 'Македонија', 'MK', 'MKD', '.mk', 'MKD', '389', 'Skopje', 'Europe', 'Southern Europe', 'mk', '41.83333333,22'),
(132, 'Madagascar', 'Madagascar', 'MG', 'MDG', '.mg', 'MGA', '261', 'Antananarivo', 'Africa', 'Eastern Africa', 'fr,mg', '-20,47'),
(133, 'Malawi', 'Malawi', 'MW', 'MWI', '.mw', 'MWK', '265', 'Lilongwe', 'Africa', 'Eastern Africa', 'en,ny', '-13.5,34'),
(134, 'Malaysia', 'Malaysia', 'MY', 'MYS', '.my', 'MYR', '60', 'Kuala Lumpur', 'Asia', 'South-Eastern Asia', 'en,ms', '2.5,112.5'),
(135, 'Maldives', 'ދިވެހިރާއްޖޭގެ', 'MV', 'MDV', '.mv', 'MVR', '960', 'Malé', 'Asia', 'Southern Asia', 'dv', '3.25,73'),
(136, 'Mali', 'Mali', 'ML', 'MLI', '.ml', 'XOF', '223', 'Bamako', 'Africa', 'Western Africa', 'fr', '17,-4'),
(137, 'Malta', 'Malta', 'MT', 'MLT', '.mt', 'EUR', '356', 'Valletta', 'Europe', 'Southern Europe', 'en,mt', '35.83333333,14.58333333'),
(138, 'Marshall Islands', 'Marshall Islands', 'MH', 'MHL', '.mh', 'USD', '692', 'Majuro', 'Oceania', 'Micronesia', 'en,mh', '9,168'),
(139, 'Martinique', 'Martinique', 'MQ', 'MTQ', '.mq', 'EUR', '596', 'Fort-de-France', 'Americas', 'Caribbean', 'fr', '14.666667,-61'),
(140, 'Mauritania', 'موريتانيا', 'MR', 'MRT', '.mr', 'MRO', '222', 'Nouakchott', 'Africa', 'Western Africa', 'ar', '20,-12'),
(141, 'Mauritius', 'Mauritius', 'MU', 'MUS', '.mu', 'MUR', '230', 'Port Louis', 'Africa', 'Eastern Africa', 'en,fr', '-20.28333333,57.55'),
(142, 'Mayotte', 'Mayotte', 'YT', 'MYT', '.yt', 'EUR', '262', 'Mamoudzou', 'Africa', 'Eastern Africa', 'fr', '-12.83333333,45.16666666'),
(143, 'Mexico', 'México', 'MX', 'MEX', '.mx', 'MXN', '52', 'Mexico City', 'Americas', 'Northern America', 'es', '23,-102'),
(144, 'Micronesia', 'Micronesia', 'FM', 'FSM', '.fm', 'USD', '691', 'Palikir', 'Oceania', 'Micronesia', 'en', '6.91666666,158.25'),
(145, 'Moldova', 'Moldova', 'MD', 'MDA', '.md', 'MDL', '373', 'Chișinău', 'Europe', 'Eastern Europe', 'ro', '47,29'),
(146, 'Monaco', 'Monaco', 'MC', 'MCO', '.mc', 'EUR', '377', 'Monaco', 'Europe', 'Western Europe', 'fr', '43.73333333,7.4'),
(147, 'Mongolia', 'Монгол улс', 'MN', 'MNG', '.mn', 'MNT', '976', 'Ulan Bator', 'Asia', 'Eastern Asia', 'mn', '46,105'),
(148, 'Montenegro', 'Црна Гора', 'ME', 'MNE', '.me', 'EUR', '382', 'Podgorica', 'Europe', 'Southern Europe', 'sr', '42.5,19.3'),
(149, 'Montserrat', 'Montserrat', 'MS', 'MSR', '.ms', 'XCD', '1664', 'Plymouth', 'Americas', 'Caribbean', 'en', '16.75,-62.2'),
(150, 'Morocco', 'المغرب', 'MA', 'MAR', '.ma,المغرب', 'MAD', '212', 'Rabat', 'Africa', 'Northern Africa', 'ar', '32,-5'),
(151, 'Mozambique', 'Moçambique', 'MZ', 'MOZ', '.mz', 'MZN', '258', 'Maputo', 'Africa', 'Eastern Africa', 'pt', '-18.25,35'),
(152, 'Myanmar', 'မြန်မာ', 'MM', 'MMR', '.mm', 'MMK', '95', 'Naypyidaw', 'Asia', 'South-Eastern Asia', 'my', '22,98'),
(153, 'Namibia', 'Namibië', 'NA', 'NAM', '.na', 'NAD,ZAR', '264', 'Windhoek', 'Africa', 'Southern Africa', 'af,de,en,hz,ng,tn', '-22,17'),
(154, 'Nauru', 'Nauru', 'NR', 'NRU', '.nr', 'AUD', '674', 'Yaren', 'Oceania', 'Micronesia', 'en,na', '-0.53333333,166.91666666'),
(155, 'Nepal', 'नेपाल', 'NP', 'NPL', '.np', 'NPR', '977', 'Kathmandu', 'Asia', 'Southern Asia', 'ne', '28,84'),
(156, 'Netherlands', 'Nederland', 'NL', 'NLD', '.nl', 'EUR', '31', 'Amsterdam', 'Europe', 'Western Europe', 'nl', '52.5,5.75'),
(157, 'New Caledonia', 'Nouvelle-Calédonie', 'NC', 'NCL', '.nc', 'XPF', '687', 'Nouméa', 'Oceania', 'Melanesia', 'fr', '-21.5,165.5'),
(158, 'New Zealand', 'New Zealand', 'NZ', 'NZL', '.nz', 'NZD', '64', 'Wellington', 'Oceania', 'Australia and New Zealand', 'en,mi', '-41,174'),
(159, 'Nicaragua', 'Nicaragua', 'NI', 'NIC', '.ni', 'NIO', '505', 'Managua', 'Americas', 'Central America', 'es', '13,-85'),
(160, 'Niger', 'Niger', 'NE', 'NER', '.ne', 'XOF', '227', 'Niamey', 'Africa', 'Western Africa', 'fr', '16,8'),
(161, 'Nigeria', 'Nigeria', 'NG', 'NGA', '.ng', 'NGN', '234', 'Abuja', 'Africa', 'Western Africa', 'en', '10,8'),
(162, 'Niue', 'Niue', 'NU', 'NIU', '.nu', 'NZD', '683', 'Alofi', 'Oceania', 'Polynesia', 'en', '-19.03333333,-169.86666666'),
(163, 'Norfolk Island', 'Norfolk Island', 'NF', 'NFK', '.nf', 'AUD', '672', 'Kingston', 'Oceania', 'Australia and New Zealand', 'en', '-29.03333333,167.95'),
(164, 'Northern Mariana Islands', 'Northern Mariana Islands', 'MP', 'MNP', '.mp', 'USD', '1670', 'Saipan', 'Oceania', 'Micronesia', 'ch,en', '15.2,145.75'),
(165, 'Norway', 'Noreg', 'NO', 'NOR', '.no', 'NOK', '47', 'Oslo', 'Europe', 'Northern Europe', 'nn,nb', '62,10'),
(166, 'Oman', 'عمان', 'OM', 'OMN', '.om', 'OMR', '968', 'Muscat', 'Asia', 'Western Asia', 'ar', '21,57'),
(167, 'Pakistan', 'Pakistan', 'PK', 'PAK', '.pk', 'PKR', '92', 'Islamabad', 'Asia', 'Southern Asia', 'en,ur', '30,70'),
(168, 'Palau', 'Palau', 'PW', 'PLW', '.pw', 'USD', '680', 'Ngerulmud', 'Oceania', 'Micronesia', 'en', '7.5,134.5'),
(169, 'Palestine', 'فلسطين', 'PS', 'PSE', '.ps,فلسطين', 'ILS', '970', 'Ramallah', 'Asia', 'Western Asia', 'ar', '31.9,35.2'),
(170, 'Panama', 'Panamá', 'PA', 'PAN', '.pa', 'PAB,USD', '507', 'Panama City', 'Americas', 'Central America', 'es', '9,-80'),
(171, 'Papua New Guinea', 'Papua New Guinea', 'PG', 'PNG', '.pg', 'PGK', '675', 'Port Moresby', 'Oceania', 'Melanesia', 'en,ho', '-6,147'),
(172, 'Paraguay', 'Paraguái', 'PY', 'PRY', '.py', 'PYG', '595', 'Asunción', 'Americas', 'South America', 'gn,es', '-23,-58'),
(173, 'Peru', 'Piruw', 'PE', 'PER', '.pe', 'PEN', '51', 'Lima', 'Americas', 'South America', 'ay,qu,es', '-10,-76'),
(174, 'Philippines', 'Philippines', 'PH', 'PHL', '.ph', 'PHP', '63', 'Manila', 'Asia', 'South-Eastern Asia', 'en', '13,122'),
(175, 'Pitcairn Islands', 'Pitcairn Islands', 'PN', 'PCN', '.pn', 'NZD', '64', 'Adamstown', 'Oceania', 'Polynesia', 'en', '-25.06666666,-130.1'),
(176, 'Poland', 'Polska', 'PL', 'POL', '.pl', 'PLN', '48', 'Warsaw', 'Europe', 'Eastern Europe', 'pl', '52,20'),
(177, 'Portugal', 'Portugal', 'PT', 'PRT', '.pt', 'EUR', '351', 'Lisbon', 'Europe', 'Southern Europe', 'pt', '39.5,-8'),
(178, 'Puerto Rico', 'Puerto Rico', 'PR', 'PRI', '.pr', 'USD', '1787,1939', 'San Juan', 'Americas', 'Caribbean', 'en,es', '18.25,-66.5'),
(179, 'Qatar', 'قطر', 'QA', 'QAT', '.qa,قطر.', 'QAR', '974', 'Doha', 'Asia', 'Western Asia', 'ar', '25.5,51.25'),
(180, 'Romania', 'România', 'RO', 'ROU', '.ro', 'RON', '40', 'Bucharest', 'Europe', 'Eastern Europe', 'ro', '46,25'),
(181, 'Russia', 'Россия', 'RU', 'RUS', '.ru,.su,.р', 'RUB', '7', 'Moscow', 'Europe', 'Eastern Europe', 'ru', '60,100'),
(182, 'Rwanda', 'Rwanda', 'RW', 'RWA', '.rw', 'RWF', '250', 'Kigali', 'Africa', 'Eastern Africa', 'en,fr,rw', '-2,30'),
(183, 'Réunion', 'La Réunion', 'RE', 'REU', '.re', 'EUR', '262', 'Saint-Denis', 'Africa', 'Eastern Africa', 'fr', '-21.15,55.5'),
(184, 'Saint Barthélemy', 'Saint-Barthélemy', 'BL', 'BLM', '.bl', 'EUR', '590', 'Gustavia', 'Americas', 'Caribbean', 'fr', '18.5,-63.41666666'),
(185, 'Saint Helena, Ascension and Tristan da Cunha', 'Saint Helena, Ascension and Tristan da Cunha', 'SH', 'SHN', '.sh,.ac', 'SHP,GBP', '290,247', 'Jamestown', 'Africa', 'Western Africa', 'en', '-15.95,-5.72'),
(186, 'Saint Kitts and Nevis', 'Saint Kitts and Nevis', 'KN', 'KNA', '.kn', 'XCD', '1869', 'Basseterre', 'Americas', 'Caribbean', 'en', '17.33333333,-62.75'),
(187, 'Saint Lucia', 'Saint Lucia', 'LC', 'LCA', '.lc', 'XCD', '1758', 'Castries', 'Americas', 'Caribbean', 'en', '13.88333333,-60.96666666'),
(188, 'Saint Martin', 'Saint-Martin', 'MF', 'MAF', '.fr,.gp', 'EUR', '590', 'Marigot', 'Americas', 'Caribbean', 'fr', '18.08333333,-63.95'),
(189, 'Saint Pierre and Miquelon', 'Saint-Pierre-et-Miquelon', 'PM', 'SPM', '.pm', 'EUR', '508', 'Saint-Pierre', 'Americas', 'Northern America', 'fr', '46.83333333,-56.33333333'),
(190, 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'VC', 'VCT', '.vc', 'XCD', '1784', 'Kingstown', 'Americas', 'Caribbean', 'en', '13.25,-61.2'),
(191, 'Samoa', 'Samoa', 'WS', 'WSM', '.ws', 'WST', '685', 'Apia', 'Oceania', 'Polynesia', 'en,sm', '-13.58333333,-172.33333333'),
(192, 'San Marino', 'San Marino', 'SM', 'SMR', '.sm', 'EUR', '378', 'City of San Marino', 'Europe', 'Southern Europe', 'it', '43.76666666,12.41666666'),
(193, 'São Tomé and Príncipe', 'São Tomé e Príncipe', 'ST', 'STP', '.st', 'STD', '239', 'São Tomé', 'Africa', 'Middle Africa', 'pt', '1,7'),
(194, 'Saudi Arabia', 'العربية السعودية', 'SA', 'SAU', '.sa,.السعو', 'SAR', '966', 'Riyadh', 'Asia', 'Western Asia', 'ar', '25,45'),
(195, 'Senegal', 'Sénégal', 'SN', 'SEN', '.sn', 'XOF', '221', 'Dakar', 'Africa', 'Western Africa', 'fr', '14,-14'),
(196, 'Serbia', 'Србија', 'RS', 'SRB', '.rs,.срб', 'RSD', '381', 'Belgrade', 'Europe', 'Southern Europe', 'sr', '44,21'),
(197, 'Seychelles', 'Sesel', 'SC', 'SYC', '.sc', 'SCR', '248', 'Victoria', 'Africa', 'Eastern Africa', 'en,fr', '-4.58333333,55.66666666'),
(198, 'Sierra Leone', 'Sierra Leone', 'SL', 'SLE', '.sl', 'SLL', '232', 'Freetown', 'Africa', 'Western Africa', 'en', '8.5,-11.5'),
(199, 'Singapore', '新加坡', 'SG', 'SGP', '.sg,.新加坡,.', 'SGD', '65', 'Singapore', 'Asia', 'South-Eastern Asia', 'zh,en,ms,ta', '1.36666666,103.8'),
(200, 'Sint Maarten', 'Sint Maarten', 'SX', 'SXM', '.sx', 'ANG', '1721', 'Philipsburg', 'Americas', 'Caribbean', 'en,fr,nl', '18.033333,-63.05'),
(201, 'Slovakia', 'Slovensko', 'SK', 'SVK', '.sk', 'EUR', '421', 'Bratislava', 'Europe', 'Central Europe', 'sk', '48.66666666,19.5'),
(202, 'Slovenia', 'Slovenija', 'SI', 'SVN', '.si', 'EUR', '386', 'Ljubljana', 'Europe', 'Southern Europe', 'sl', '46.11666666,14.81666666'),
(203, 'Solomon Islands', 'Solomon Islands', 'SB', 'SLB', '.sb', 'SBD', '677', 'Honiara', 'Oceania', 'Melanesia', 'en', '-8,159'),
(204, 'Somalia', 'الصومال‎‎', 'SO', 'SOM', '.so', 'SOS', '252', 'Mogadishu', 'Africa', 'Eastern Africa', 'ar,so', '10,49'),
(205, 'South Africa', 'South Africa', 'ZA', 'ZAF', '.za', 'ZAR', '27', 'Pretoria,Bloemfontein,Cape Town', 'Africa', 'Southern Africa', 'af,en,nr,st,ss,tn,ts,ve,xh,zu', '-29,24'),
(206, 'South Georgia', 'South Georgia', 'GS', 'SGS', '.gs', 'GBP', '500', 'King Edward Point', 'Antarctic', '', 'en', '-54.5,-37'),
(207, 'South Sudan', 'South Sudan', 'SS', 'SSD', '.ss', 'SSP', '211', 'Juba', 'Africa', 'Middle Africa', 'en', '7,30'),
(208, 'Spain', 'España', 'ES', 'ESP', '.es', 'EUR', '34', 'Madrid', 'Europe', 'Southern Europe', 'es', '40,-4'),
(209, 'Sri Lanka', 'ශ්‍රී ලංකාව', 'LK', 'LKA', '.lk,.இலங்க', 'LKR', '94', 'Colombo', 'Asia', 'Southern Asia', 'si,ta', '7,81'),
(210, 'Sudan', 'السودان', 'SD', 'SDN', '.sd', 'SDG', '249', 'Khartoum', 'Africa', 'Northern Africa', 'ar,en', '15,30'),
(211, 'Suriname', 'Suriname', 'SR', 'SUR', '.sr', 'SRD', '597', 'Paramaribo', 'Americas', 'South America', 'nl', '4,-56'),
(212, 'Svalbard and Jan Mayen', 'Svalbard og Jan Mayen', 'SJ', 'SJM', '.sj', 'NOK', '4779', 'Longyearbyen', 'Europe', 'Northern Europe', 'no', '78,20'),
(213, 'Swaziland', 'Swaziland', 'SZ', 'SWZ', '.sz', 'SZL', '268', 'Lobamba', 'Africa', 'Southern Africa', 'en,ss', '-26.5,31.5'),
(214, 'Sweden', 'Sverige', 'SE', 'SWE', '.se', 'SEK', '46', 'Stockholm', 'Europe', 'Northern Europe', 'sv', '62,15'),
(215, 'Switzerland', 'Suisse', 'CH', 'CHE', '.ch', 'CHE,CHF,CHW', '41', 'Bern', 'Europe', 'Western Europe', 'fr,de,it,rm', '47,8'),
(216, 'Syria', 'سوريا', 'SY', 'SYR', '.sy,سوريا.', 'SYP', '963', 'Damascus', 'Asia', 'Western Asia', 'ar', '35,38'),
(217, 'Taiwan', '台灣', 'TW', 'TWN', '.tw,.台灣,.台', 'TWD', '886', 'Taipei', 'Asia', 'Eastern Asia', 'zh', '23.5,121'),
(218, 'Tajikistan', 'Таджикистан', 'TJ', 'TJK', '.tj', 'TJS', '992', 'Dushanbe', 'Asia', 'Central Asia', 'ru,tg', '39,71'),
(219, 'Tanzania', 'Tanzania', 'TZ', 'TZA', '.tz', 'TZS', '255', 'Dodoma', 'Africa', 'Eastern Africa', 'en,sw', '-6,35'),
(220, 'Thailand', 'ประเทศไทย', 'TH', 'THA', '.th,.ไทย', 'THB', '66', 'Bangkok', 'Asia', 'South-Eastern Asia', 'th', '15,100'),
(221, 'Timor-Leste', 'Timor-Leste', 'TL', 'TLS', '.tl', 'USD', '670', 'Dili', 'Asia', 'South-Eastern Asia', 'pt', '-8.83333333,125.91666666'),
(222, 'Togo', 'Togo', 'TG', 'TGO', '.tg', 'XOF', '228', 'Lomé', 'Africa', 'Western Africa', 'fr', '8,1.16666666'),
(223, 'Tokelau', 'Tokelau', 'TK', 'TKL', '.tk', 'NZD', '690', 'Fakaofo', 'Oceania', 'Polynesia', 'en,sm', '-9,-172'),
(224, 'Tonga', 'Tonga', 'TO', 'TON', '.to', 'TOP', '676', 'Nuku\'alofa', 'Oceania', 'Polynesia', 'en,to', '-20,-175'),
(225, 'Trinidad and Tobago', 'Trinidad and Tobago', 'TT', 'TTO', '.tt', 'TTD', '1868', 'Port of Spain', 'Americas', 'Caribbean', 'en', '11,-61'),
(226, 'Tunisia', 'تونس', 'TN', 'TUN', '.tn', 'TND', '216', 'Tunis', 'Africa', 'Northern Africa', 'ar', '34,9'),
(227, 'Turkey', 'Türkiye', 'TR', 'TUR', '.tr', 'TRY', '90', 'Ankara', 'Asia', 'Western Asia', 'tr', '39,35'),
(228, 'Turkmenistan', 'Туркмения', 'TM', 'TKM', '.tm', 'TMT', '993', 'Ashgabat', 'Asia', 'Central Asia', 'ru,tk', '40,60'),
(229, 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'TC', 'TCA', '.tc', 'USD', '1649', 'Cockburn Town', 'Americas', 'Caribbean', 'en', '21.75,-71.58333333'),
(230, 'Tuvalu', 'Tuvalu', 'TV', 'TUV', '.tv', 'AUD', '688', 'Funafuti', 'Oceania', 'Polynesia', 'en', '-8,178'),
(231, 'Uganda', 'Uganda', 'UG', 'UGA', '.ug', 'UGX', '256', 'Kampala', 'Africa', 'Eastern Africa', 'en,sw', '1,32'),
(232, 'Ukraine', 'Україна', 'UA', 'UKR', '.ua,.укр', 'UAH', '380', 'Kyiv', 'Europe', 'Eastern Europe', 'uk', '49,32'),
(233, 'United Arab Emirates', 'دولة الإمارات العربية المتحدة', 'AE', 'ARE', '.ae,امارات', 'AED', '971', 'Abu Dhabi', 'Asia', 'Western Asia', 'ar', '24,54'),
(234, 'United Kingdom', 'United Kingdom', 'GB', 'GBR', '.uk', 'GBP', '44', 'London', 'Europe', 'Northern Europe', 'en', '54,-2'),
(235, 'United States', 'United States', 'US', 'USA', '.us', 'USD,USN,USS', '1', 'Washington D.C.', 'Americas', 'Northern America', 'en', '38,-97'),
(236, 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 'UM', 'UMI', '.us', 'USD', '', '', 'Americas', 'Northern America', 'en', '19.3,166.633333'),
(237, 'Uruguay', 'Uruguay', 'UY', 'URY', '.uy', 'UYI,UYU', '598', 'Montevideo', 'Americas', 'South America', 'es', '-33,-56'),
(238, 'Uzbekistan', 'Узбекистан', 'UZ', 'UZB', '.uz', 'UZS', '998', 'Tashkent', 'Asia', 'Central Asia', 'ru,uz', '41,64'),
(239, 'Vanuatu', 'Vanuatu', 'VU', 'VUT', '.vu', 'VUV', '678', 'Port Vila', 'Oceania', 'Melanesia', 'bi,en,fr', '-16,167'),
(240, 'Venezuela', 'Venezuela', 'VE', 'VEN', '.ve', 'VEF', '58', 'Caracas', 'Americas', 'South America', 'es', '8,-66'),
(241, 'Vietnam', 'Việt Nam', 'VN', 'VNM', '.vn', 'VND', '84', 'Hanoi', 'Asia', 'South-Eastern Asia', 'vi', '16.16666666,107.83333333'),
(242, 'British Virgin Islands', 'British Virgin Islands', 'VG', 'VGB', '.vg', 'USD', '1284', 'Road Town', 'Americas', 'Caribbean', 'en', '18.431383,-64.62305'),
(243, 'United States Virgin Islands', 'United States Virgin Islands', 'VI', 'VIR', '.vi', 'USD', '1340', 'Charlotte Amalie', 'Americas', 'Caribbean', 'en', '18.35,-64.933333'),
(244, 'Wallis and Futuna', 'Wallis et Futuna', 'WF', 'WLF', '.wf', 'XPF', '681', 'Mata-Utu', 'Oceania', 'Polynesia', 'fr', '-13.3,-176.2'),
(245, 'Western Sahara', 'Western Sahara', 'EH', 'ESH', '.eh', 'MAD,DZD,MRO', '212', 'El Aaiún', 'Africa', 'Northern Africa', 'es', '24.5,-13'),
(246, 'Yemen', 'اليَمَن', 'YE', 'YEM', '.ye', 'YER', '967', 'Sana\'a', 'Asia', 'Western Asia', 'ar', '15,48'),
(247, 'Zambia', 'Zambia', 'ZM', 'ZMB', '.zm', 'ZMW', '260', 'Lusaka', 'Africa', 'Eastern Africa', 'en', '-15,30'),
(248, 'Zimbabwe', 'Zimbabwe', 'ZW', 'ZWE', '.zw', 'ZWL', '263', 'Harare', 'Africa', 'Eastern Africa', 'en,nd,ny,sn,st,tn,ts,ve,xh', '-20,30'),
(251, 'Åland Islands', 'Åland', 'AX', 'ALA', '.ax', 'EUR', '358', 'Mariehamn', 'Europe', 'Northern Europe', 'sv', '60.116667,19.9'),
(252, 'Kosovo', 'Kosova', 'XK', 'UNK', '', 'EUR', '383', 'Pristina', 'Europe', 'Eastern Europe', 'sq,sr', '42.666667,21.166667');

-- --------------------------------------------------------

--
-- Table structure for table `countries_lang`
--

CREATE TABLE `countries_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries_lang`
--

INSERT INTO `countries_lang` (`id`, `owner_id`, `lang`, `name`, `slug`) VALUES
(1, 1, 'tr', 'Afganistan', 'afganistan'),
(2, 2, 'tr', 'Arnavutluk', 'arnavutluk'),
(3, 3, 'tr', 'Cezayir', 'cezayir'),
(4, 4, 'tr', 'Amerikan Samoası', 'amerikan-samoasi'),
(5, 5, 'tr', 'Andorra', 'andorra'),
(6, 6, 'tr', 'Angora', 'angora'),
(7, 7, 'tr', 'Anguilla', 'anguilla'),
(8, 8, 'tr', 'Antarktika', 'antarktika'),
(9, 9, 'tr', 'Antigua ve Barbuda', 'antigua-ve-barbuda'),
(10, 10, 'tr', 'Arjantin', 'arjantin'),
(11, 11, 'tr', 'Ermenistan', 'ermenistan'),
(12, 12, 'tr', 'Aruba', 'aruba'),
(13, 13, 'tr', 'Avustralya', 'avustralya'),
(14, 14, 'tr', 'Avusturya', 'avusturya'),
(15, 15, 'tr', 'Azerbeycan', 'azerbeycan'),
(16, 16, 'tr', 'Bahamalar', 'bahamalar'),
(17, 17, 'tr', 'Bahreyn', 'bahreyn'),
(18, 18, 'tr', 'Bangladeş', 'banglades'),
(19, 19, 'tr', 'Barbados', 'barbados'),
(20, 20, 'tr', 'Belarus', 'belarus'),
(21, 21, 'tr', 'Belçika', 'belcika'),
(22, 22, 'tr', 'Belize', 'belize'),
(23, 23, 'tr', 'Benin', 'benin'),
(24, 24, 'tr', 'Bermuda', 'bermuda'),
(25, 25, 'tr', 'Butan', 'butan'),
(26, 26, 'tr', 'Bolivya', 'bolivya'),
(27, 27, 'tr', 'Bonaire', 'bonaire'),
(28, 28, 'tr', 'Bosna Hersek', 'bosna-hersek'),
(29, 29, 'tr', 'Botsvana', 'botsvana'),
(30, 30, 'tr', 'Bouvet Adası', 'bouvet-adasi'),
(31, 31, 'tr', 'Brezilya', 'brezilya'),
(32, 32, 'tr', 'İngiliz Hint Okyanusu Bölgesi', 'ingiliz-hint-okyanusu-bolgesi'),
(33, 33, 'tr', 'Brunei Darussalam', 'brunei-darussalam'),
(34, 34, 'tr', 'Bulgaristan', 'bulgaristan'),
(35, 35, 'tr', 'Burkina Faso', 'burkina-faso'),
(36, 36, 'tr', 'Burundi', 'burundi'),
(37, 37, 'tr', 'Kamboçya', 'kambocya'),
(38, 38, 'tr', 'Kamerun', 'kamerun'),
(39, 39, 'tr', 'Kanada', 'kanada'),
(40, 40, 'tr', 'Cape Verde', 'cape-verde'),
(41, 41, 'tr', 'Cayman Adaları', 'cayman-adalari'),
(42, 42, 'tr', 'Orta Afrika Cumhuriyeti', 'orta-afrika-cumhuriyeti'),
(43, 43, 'tr', 'Çad', 'cad'),
(44, 44, 'tr', 'Şili', 'sili'),
(45, 45, 'tr', 'Çin', 'cin'),
(46, 46, 'tr', 'Noel Adası', 'noel-adasi'),
(47, 47, 'tr', 'Cocos (Keeling) Adaları', 'cocos-keeling-adalari'),
(48, 48, 'tr', 'Kolombiya', 'kolombiya'),
(49, 49, 'tr', 'Komorlar', 'komorlar'),
(50, 50, 'tr', 'Kongo', 'kongo'),
(51, 51, 'tr', 'Kongo Demokratik Cumhuriyeti', 'kongo-demokratik-cumhuriyeti'),
(52, 52, 'tr', 'Cook Adaları', 'cook-adalari'),
(53, 53, 'tr', 'Kosta Rika', 'kosta-rika'),
(54, 54, 'tr', 'Hırvatistan', 'hirvatistan'),
(55, 55, 'tr', 'Küba', 'kuba'),
(56, 56, 'tr', 'Curacao', 'curacao'),
(57, 57, 'tr', 'Kıbrıs', 'kibris'),
(58, 58, 'tr', 'Çek Cumhuriyeti', 'cek-cumhuriyeti'),
(59, 59, 'tr', 'Fildişi Sahili', 'fildisi-sahili'),
(60, 60, 'tr', 'Danimarka', 'danimarka'),
(61, 61, 'tr', 'Cibuti', 'cibuti'),
(62, 62, 'tr', 'Dominika', 'dominika'),
(63, 63, 'tr', 'Dominik Cumhuriyeti', 'dominik-cumhuriyeti'),
(64, 64, 'tr', 'Ekvador', 'ekvador'),
(65, 65, 'tr', 'Mısır', 'misir'),
(66, 66, 'tr', 'El Salvador', 'el-salvador'),
(67, 67, 'tr', 'Ekvator Ginesi', 'ekvator-ginesi'),
(68, 68, 'tr', 'Eritre', 'eritre'),
(69, 69, 'tr', 'Estonya', 'estonya'),
(70, 70, 'tr', 'Etiyopya', 'etiyopya'),
(71, 71, 'tr', 'Falkland Adaları (Malvinas)', 'falkland-adalari-malvinas'),
(72, 72, 'tr', 'Faroe Adaları', 'faroe-adalari'),
(73, 73, 'tr', 'Fiji', 'fiji'),
(74, 74, 'tr', 'Finlandiya', 'finlandiya'),
(75, 75, 'tr', 'Fransa', 'fransa'),
(76, 76, 'tr', 'Fransız Guyanası', 'fransiz-guyanasi'),
(77, 77, 'tr', 'Fransız Polinezyası', 'fransiz-polinezyasi'),
(78, 78, 'tr', 'Fransız Güney Bölgesi', 'fransiz-guney-bolgesi'),
(79, 79, 'tr', 'Gabon', 'gabon'),
(80, 80, 'tr', 'Gambiya', 'gambiya'),
(81, 81, 'tr', 'Gürcistan', 'gurcistan'),
(82, 82, 'tr', 'Almanya', 'almanya'),
(83, 83, 'tr', 'Gana', 'gana'),
(84, 84, 'tr', 'Cebelitarık', 'cebelitarik'),
(85, 85, 'tr', 'Yunanistan', 'yunanistan'),
(86, 86, 'tr', 'Grönland', 'gronland'),
(87, 87, 'tr', 'Grenada', 'grenada'),
(88, 88, 'tr', 'Guadeloupe', 'guadeloupe'),
(89, 89, 'tr', 'Guam', 'guam'),
(90, 90, 'tr', 'Guatemala', 'guatemala'),
(91, 91, 'tr', 'Guernsey', 'guernsey'),
(92, 92, 'tr', 'Gine', 'gine'),
(93, 93, 'tr', 'Gine-Bissau', 'gine-bissau'),
(94, 94, 'tr', 'Guyana', 'guyana'),
(95, 95, 'tr', 'Haiti', 'haiti'),
(96, 96, 'tr', 'Heard Adası ve McDonald Mcdonald Adaları', 'heard-adasi-ve-mcdonald-mcdonald-adalari'),
(97, 97, 'tr', 'Vatikan', 'vatikan'),
(98, 98, 'tr', 'Honduras', 'honduras'),
(99, 99, 'tr', 'Hong Kong', 'hong-kong'),
(100, 100, 'tr', 'Macaristan', 'macaristan'),
(101, 101, 'tr', 'İzlanda', 'izlanda'),
(102, 102, 'tr', 'Hindistan', 'hindistan'),
(103, 103, 'tr', 'Endonezya', 'endonezya'),
(104, 104, 'tr', 'İran, İslam Cumhuriyeti', 'iran-islam-cumhuriyeti'),
(105, 105, 'tr', 'Irak', 'irak'),
(106, 106, 'tr', 'İrlanda', 'irlanda'),
(107, 107, 'tr', 'Isle of Man', 'isle-of-man'),
(108, 108, 'tr', 'İsrail', 'israil'),
(109, 109, 'tr', 'İtalya', 'italya'),
(110, 110, 'tr', 'Jamaika', 'jamaika'),
(111, 111, 'tr', 'Japonya', 'japonya'),
(112, 112, 'tr', 'Jersey', 'jersey'),
(113, 113, 'tr', 'Ürdün', 'urdun'),
(114, 114, 'tr', 'Kazakistan', 'kazakistan'),
(115, 115, 'tr', 'Kenya', 'kenya'),
(116, 116, 'tr', 'Kiribati', 'kiribati'),
(117, 117, 'tr', 'Kore Demokratik Halk Cumhuriyeti', 'kore-demokratik-halk-cumhuriyeti'),
(118, 118, 'tr', 'Kore Cumhuriyeti', 'kore-cumhuriyeti'),
(119, 119, 'tr', 'Kuveyt', 'kuveyt'),
(120, 120, 'tr', 'Kırgızistan', 'kirgizistan'),
(121, 121, 'tr', 'Lao Halkı\'nın Demokratik Cumhuriyeti', 'lao-halki-nin-demokratik-cumhuriyeti'),
(122, 122, 'tr', 'Letonya', 'letonya'),
(123, 123, 'tr', 'Lübnan', 'lubnan'),
(124, 124, 'tr', 'Lesotho', 'lesotho'),
(125, 125, 'tr', 'Liberya', 'liberya'),
(126, 126, 'tr', 'Libya', 'libya'),
(127, 127, 'tr', 'Lihtenştayn', 'lihtenstayn'),
(128, 128, 'tr', 'Litvanya', 'litvanya'),
(129, 129, 'tr', 'Lüksemburg', 'luksemburg'),
(130, 130, 'tr', 'Macao', 'macao'),
(131, 131, 'tr', 'Makedonya, Eski Yugoslav Cumhuriyeti', 'makedonya-eski-yugoslav-cumhuriyeti'),
(132, 132, 'tr', 'Madagaskar', 'madagaskar'),
(133, 133, 'tr', 'Malawi', 'malawi'),
(134, 134, 'tr', 'Malezya', 'malezya'),
(135, 135, 'tr', 'Maldivler', 'maldivler'),
(136, 136, 'tr', 'Mali', 'mali'),
(137, 137, 'tr', 'Malta', 'malta'),
(138, 138, 'tr', 'Marşal Adaları', 'marsal-adalari'),
(139, 139, 'tr', 'Martinik', 'martinik'),
(140, 140, 'tr', 'Moritanya', 'moritanya'),
(141, 141, 'tr', 'Mauritius', 'mauritius'),
(142, 142, 'tr', 'Mayotte', 'mayotte'),
(143, 143, 'tr', 'Meksika', 'meksika'),
(144, 144, 'tr', 'Mikronezya, Federe Devletleri', 'mikronezya-federe-devletleri'),
(145, 145, 'tr', 'Moldova, Cumhuriyeti', 'moldova-cumhuriyeti'),
(146, 146, 'tr', 'Monako', 'monako'),
(147, 147, 'tr', 'Moğolistan', 'mogolistan'),
(148, 148, 'tr', 'Karadağ', 'karadag'),
(149, 149, 'tr', 'Montserrat', 'montserrat'),
(150, 150, 'tr', 'Fas', 'fas'),
(151, 151, 'tr', 'Mozambik', 'mozambik'),
(152, 152, 'tr', 'Myanmar', 'myanmar'),
(153, 153, 'tr', 'Namibya', 'namibya'),
(154, 154, 'tr', 'Nauru', 'nauru'),
(155, 155, 'tr', 'Nepal', 'nepal'),
(156, 156, 'tr', 'Hollanda', 'hollanda'),
(157, 157, 'tr', 'Yeni Kaledonya', 'yeni-kaledonya'),
(158, 158, 'tr', 'Yeni Zelanda', 'yeni-zelanda'),
(159, 159, 'tr', 'Nikaragua', 'nikaragua'),
(160, 160, 'tr', 'Nijer', 'nijer'),
(161, 161, 'tr', 'Nijerya', 'nijerya'),
(162, 162, 'tr', 'Niue', 'niue'),
(163, 163, 'tr', 'Norfolk Adası', 'norfolk-adasi'),
(164, 164, 'tr', 'Kuzey Mariana Adaları', 'kuzey-mariana-adalari'),
(165, 165, 'tr', 'Norveç', 'norvec'),
(166, 166, 'tr', 'Umman', 'umman'),
(167, 167, 'tr', 'Pakistan', 'pakistan'),
(168, 168, 'tr', 'Palau', 'palau'),
(169, 169, 'tr', 'Devletin Filistin', 'devletin-filistin'),
(170, 170, 'tr', 'Panama', 'panama'),
(171, 171, 'tr', 'Papua Yeni Gine', 'papua-yeni-gine'),
(172, 172, 'tr', 'Paraguay', 'paraguay'),
(173, 173, 'tr', 'Peru', 'peru'),
(174, 174, 'tr', 'Filipinler', 'filipinler'),
(175, 175, 'tr', 'Pitcairn', 'pitcairn'),
(176, 176, 'tr', 'Polonya', 'polonya'),
(177, 177, 'tr', 'Portekiz', 'portekiz'),
(178, 178, 'tr', 'Porto Riko', 'porto-riko'),
(179, 179, 'tr', 'Katar', 'katar'),
(180, 180, 'tr', 'Romanya', 'romanya'),
(181, 181, 'tr', 'Rusya Federasyonu', 'rusya-federasyonu'),
(182, 182, 'tr', 'Ruanda', 'ruanda'),
(183, 183, 'tr', 'Mayotte', 'mayotte'),
(184, 184, 'tr', 'Saint Barthelemy', 'saint-barthelemy'),
(185, 185, 'tr', 'Saint Helena', 'saint-helena'),
(186, 186, 'tr', 'Saint Kitts ve Nevis', 'saint-kitts-ve-nevis'),
(187, 187, 'tr', 'Saint Lucia', 'saint-lucia'),
(188, 188, 'tr', 'Saint Martin (Fransız bölümü)', 'saint-martin-fransiz-bolumu'),
(189, 189, 'tr', 'Saint Pierre ve Miquelon', 'saint-pierre-ve-miquelon'),
(190, 190, 'tr', 'Saint Vincent ve Grenadinler', 'saint-vincent-ve-grenadinler'),
(191, 191, 'tr', 'Samoa', 'samoa'),
(192, 192, 'tr', 'San Marino', 'san-marino'),
(193, 193, 'tr', 'Sao Tome ve Principe', 'sao-tome-ve-principe'),
(194, 194, 'tr', 'Suudi Arabistan', 'suudi-arabistan'),
(195, 195, 'tr', 'Senegal', 'senegal'),
(196, 196, 'tr', 'Sırbistan', 'sirbistan'),
(197, 197, 'tr', 'Seyşeller', 'seyseller'),
(198, 198, 'tr', 'Sierra Leone', 'sierra-leone'),
(199, 199, 'tr', 'Singapur', 'singapur'),
(200, 200, 'tr', 'Sint Maarten (Hollandaca bölümü)', 'sint-maarten-hollandaca-bolumu'),
(201, 201, 'tr', 'Slovakya', 'slovakya'),
(202, 202, 'tr', 'Slovenya', 'slovenya'),
(203, 203, 'tr', 'Solomon Adaları', 'solomon-adalari'),
(204, 204, 'tr', 'Somali', 'somali'),
(205, 205, 'tr', 'Güney Afrika', 'guney-afrika'),
(206, 206, 'tr', 'Güney Georgia ve Güney Sandviç Adaları', 'guney-georgia-ve-guney-sandvic-adalari'),
(207, 207, 'tr', 'Güney Sudan', 'guney-sudan'),
(208, 208, 'tr', 'ispanya', 'ispanya'),
(209, 209, 'tr', 'Sri Lanka', 'sri-lanka'),
(210, 210, 'tr', 'Sudan', 'sudan'),
(211, 211, 'tr', 'Surinam', 'surinam'),
(212, 212, 'tr', 'Svalbard ve Jan Mayen', 'svalbard-ve-jan-mayen'),
(213, 213, 'tr', 'Svaziland', 'svaziland'),
(214, 214, 'tr', 'İsveç', 'isvec'),
(215, 215, 'tr', 'İsviçre', 'isvicre'),
(216, 216, 'tr', 'Suriye Arap Cumhuriyeti', 'suriye-arap-cumhuriyeti'),
(217, 217, 'tr', 'Tayvan', 'tayvan'),
(218, 218, 'tr', 'Tacikistan', 'tacikistan'),
(219, 219, 'tr', 'Tanzanya Birleşik Cumhuriyeti', 'tanzanya-birlesik-cumhuriyeti'),
(220, 220, 'tr', 'Tayland', 'tayland'),
(221, 221, 'tr', 'Timor-Leste', 'timor-leste'),
(222, 222, 'tr', 'Togo', 'togo'),
(223, 223, 'tr', 'Tokelau', 'tokelau'),
(224, 224, 'tr', 'Tonga', 'tonga'),
(225, 225, 'tr', 'Trinidad ve Tobago', 'trinidad-ve-tobago'),
(226, 226, 'tr', 'Tunus', 'tunus'),
(227, 227, 'tr', 'Türkiye', 'turkiye'),
(228, 228, 'tr', 'Türkmenistan', 'turkmenistan'),
(229, 229, 'tr', 'Turks ve Caicos Adaları', 'turks-ve-caicos-adalari'),
(230, 230, 'tr', 'Tuvalu', 'tuvalu'),
(231, 231, 'tr', 'Uganda', 'uganda'),
(232, 232, 'tr', 'Ukrayna', 'ukrayna'),
(233, 233, 'tr', 'Birleşik Arap Emirlikleri', 'birlesik-arap-emirlikleri'),
(234, 234, 'tr', 'Birleşik Krallık', 'birlesik-krallik'),
(235, 235, 'tr', 'Amerika Birleşik Devletleri', 'amerika-birlesik-devletleri'),
(236, 236, 'tr', 'Amerika Birleşik Devletleri Küçük Dış Adaları', 'amerika-birlesik-devletleri-kucuk-dis-adalari'),
(237, 237, 'tr', 'Uruguay', 'uruguay'),
(238, 238, 'tr', 'Özbekistan', 'ozbekistan'),
(239, 239, 'tr', 'Vanuatu', 'vanuatu'),
(240, 240, 'tr', 'Venezuela', 'venezuela'),
(241, 241, 'tr', 'Viet Nam', 'viet-nam'),
(242, 242, 'tr', 'İngiliz Virgin Adaları', 'ingiliz-virgin-adalari'),
(243, 243, 'tr', 'ABD Virgin Adaları', 'abd-virgin-adalari'),
(244, 244, 'tr', 'Wallis ve Futuna', 'wallis-ve-futuna'),
(245, 245, 'tr', 'Batı Sahra', 'bati-sahra'),
(246, 246, 'tr', 'Yemen', 'yemen'),
(247, 247, 'tr', 'Zambiya', 'zambiya'),
(248, 248, 'tr', 'Zimbabve', 'zimbabve'),
(249, 1, 'en', 'Afghanistan', 'afghanistan'),
(250, 2, 'en', 'Albania', 'albania'),
(251, 3, 'en', 'Algeria', 'algeria'),
(252, 4, 'en', 'American Samoa', 'american-samoa'),
(253, 5, 'en', 'Andorra', 'andorra'),
(254, 6, 'en', 'Angola', 'angola'),
(255, 7, 'en', 'Anguilla', 'anguilla'),
(256, 8, 'en', 'Antarctica', 'antarctica'),
(257, 9, 'en', 'Antigua and Barbuda', 'antigua-and-barbuda'),
(258, 10, 'en', 'Argentina', 'argentina'),
(259, 11, 'en', 'Armenia', 'armenia'),
(260, 12, 'en', 'Aruba', 'aruba'),
(261, 13, 'en', 'Australia', 'australia'),
(262, 14, 'en', 'Austria', 'austria'),
(263, 15, 'en', 'Azerbaijan', 'azerbaijan'),
(264, 16, 'en', 'Bahamas', 'bahamas'),
(265, 17, 'en', 'Bahrain', 'bahrain'),
(266, 18, 'en', 'Bangladesh', 'bangladesh'),
(267, 19, 'en', 'Barbados', 'barbados'),
(268, 20, 'en', 'Belarus', 'belarus'),
(269, 21, 'en', 'Belgium', 'belgium'),
(270, 22, 'en', 'Belize', 'belize'),
(271, 23, 'en', 'Benin', 'benin'),
(272, 24, 'en', 'Bermuda', 'bermuda'),
(273, 25, 'en', 'Bhutan', 'bhutan'),
(274, 26, 'en', 'Bolivia', 'bolivia'),
(275, 27, 'en', 'Bonaire', 'bonaire'),
(276, 28, 'en', 'Bosnia and Herzegovina', 'bosnia-and-herzegovina'),
(277, 29, 'en', 'Botswana', 'botswana'),
(278, 30, 'en', 'Bouvet Island', 'bouvet-island'),
(279, 31, 'en', 'Brazil', 'brazil'),
(280, 32, 'en', 'British Indian Ocean Territory', 'british-indian-ocean-territory'),
(281, 33, 'en', 'Brunei Darussalam', 'brunei-darussalam'),
(282, 34, 'en', 'Bulgaria', 'bulgaria'),
(283, 35, 'en', 'Burkina Faso', 'burkina-faso'),
(284, 36, 'en', 'Burundi', 'burundi'),
(285, 37, 'en', 'Cambodia', 'cambodia'),
(286, 38, 'en', 'Cameroon', 'cameroon'),
(287, 39, 'en', 'Canada', 'canada'),
(288, 40, 'en', 'Cape Verde', 'cape-verde'),
(289, 41, 'en', 'Cayman Islands', 'cayman-islands'),
(290, 42, 'en', 'Central African Republic', 'central-african-republic'),
(291, 43, 'en', 'Chad', 'chad'),
(292, 44, 'en', 'Chile', 'chile'),
(293, 45, 'en', 'China', 'china'),
(294, 46, 'en', 'Christmas Island', 'christmas-island'),
(295, 47, 'en', 'Cocos (Keeling) Islands', 'cocos-keeling-islands'),
(296, 48, 'en', 'Colombia', 'colombia'),
(297, 49, 'en', 'Comoros', 'comoros'),
(298, 50, 'en', 'Congo', 'congo'),
(299, 51, 'en', 'Democratic Republic of the Congo', 'democratic-republic-of-the-congo'),
(300, 52, 'en', 'Cook Islands', 'cook-islands'),
(301, 53, 'en', 'Costa Rica', 'costa-rica'),
(302, 54, 'en', 'Croatia', 'croatia'),
(303, 55, 'en', 'Cuba', 'cuba'),
(304, 56, 'en', 'Curacao', 'curacao'),
(305, 57, 'en', 'Cyprus', 'cyprus'),
(306, 58, 'en', 'Czech Republic', 'czech-republic'),
(307, 59, 'en', 'Cote d\'Ivoire', 'cote-d-ivoire'),
(308, 60, 'en', 'Denmark', 'denmark'),
(309, 61, 'en', 'Djibouti', 'djibouti'),
(310, 62, 'en', 'Dominica', 'dominica'),
(311, 63, 'en', 'Dominican Republic', 'dominican-republic'),
(312, 64, 'en', 'Ecuador', 'ecuador'),
(313, 65, 'en', 'Egypt', 'egypt'),
(314, 66, 'en', 'El Salvador', 'el-salvador'),
(315, 67, 'en', 'Equatorial Guinea', 'equatorial-guinea'),
(316, 68, 'en', 'Eritrea', 'eritrea'),
(317, 69, 'en', 'Estonia', 'estonia'),
(318, 70, 'en', 'Ethiopia', 'ethiopia'),
(319, 71, 'en', 'Falkland Islands (Malvinas)', 'falkland-islands-malvinas'),
(320, 72, 'en', 'Faroe Islands', 'faroe-islands'),
(321, 73, 'en', 'Fiji', 'fiji'),
(322, 74, 'en', 'Finland', 'finland'),
(323, 75, 'en', 'France', 'france'),
(324, 76, 'en', 'French Guiana', 'french-guiana'),
(325, 77, 'en', 'French Polynesia', 'french-polynesia'),
(326, 78, 'en', 'French Southern Territories', 'french-southern-territories'),
(327, 79, 'en', 'Gabon', 'gabon'),
(328, 80, 'en', 'Gambia', 'gambia'),
(329, 81, 'en', 'Georgia', 'georgia'),
(330, 82, 'en', 'Germany', 'germany'),
(331, 83, 'en', 'Ghana', 'ghana'),
(332, 84, 'en', 'Gibraltar', 'gibraltar'),
(333, 85, 'en', 'Greece', 'greece'),
(334, 86, 'en', 'Greenland', 'greenland'),
(335, 87, 'en', 'Grenada', 'grenada'),
(336, 88, 'en', 'Guadeloupe', 'guadeloupe'),
(337, 89, 'en', 'Guam', 'guam'),
(338, 90, 'en', 'Guatemala', 'guatemala'),
(339, 91, 'en', 'Guernsey', 'guernsey'),
(340, 92, 'en', 'Guinea', 'guinea'),
(341, 93, 'en', 'Guinea-Bissau', 'guinea-bissau'),
(342, 94, 'en', 'Guyana', 'guyana'),
(343, 95, 'en', 'Haiti', 'haiti'),
(344, 96, 'en', 'Heard Island and McDonald Mcdonald Islands', 'heard-island-and-mcdonald-mcdonald-islands'),
(345, 97, 'en', 'Holy See (Vatican City State)', 'holy-see-vatican-city-state'),
(346, 98, 'en', 'Honduras', 'honduras'),
(347, 99, 'en', 'Hong Kong', 'hong-kong'),
(348, 100, 'en', 'Hungary', 'hungary'),
(349, 101, 'en', 'Iceland', 'iceland'),
(350, 102, 'en', 'India', 'india'),
(351, 103, 'en', 'Indonesia', 'indonesia'),
(352, 104, 'en', 'Iran, Islamic Republic of', 'iran-islamic-republic-of'),
(353, 105, 'en', 'Iraq', 'iraq'),
(354, 106, 'en', 'Ireland', 'ireland'),
(355, 107, 'en', 'Isle of Man', 'isle-of-man'),
(356, 108, 'en', 'Israel', 'israel'),
(357, 109, 'en', 'Italy', 'italy'),
(358, 110, 'en', 'Jamaica', 'jamaica'),
(359, 111, 'en', 'Japan', 'japan'),
(360, 112, 'en', 'Jersey', 'jersey'),
(361, 113, 'en', 'Jordan', 'jordan'),
(362, 114, 'en', 'Kazakhstan', 'kazakhstan'),
(363, 115, 'en', 'Kenya', 'kenya'),
(364, 116, 'en', 'Kiribati', 'kiribati'),
(365, 117, 'en', 'Korea, Democratic People\'s Republic of', 'korea-democratic-people-s-republic-of'),
(366, 118, 'en', 'Korea, Republic of', 'korea-republic-of'),
(367, 119, 'en', 'Kuwait', 'kuwait'),
(368, 120, 'en', 'Kyrgyzstan', 'kyrgyzstan'),
(369, 121, 'en', 'Lao People\'s Democratic Republic', 'lao-people-s-democratic-republic'),
(370, 122, 'en', 'Latvia', 'latvia'),
(371, 123, 'en', 'Lebanon', 'lebanon'),
(372, 124, 'en', 'Lesotho', 'lesotho'),
(373, 125, 'en', 'Liberia', 'liberia'),
(374, 126, 'en', 'Libya', 'libya'),
(375, 127, 'en', 'Liechtenstein', 'liechtenstein'),
(376, 128, 'en', 'Lithuania', 'lithuania'),
(377, 129, 'en', 'Luxembourg', 'luxembourg'),
(378, 130, 'en', 'Macao', 'macao'),
(379, 131, 'en', 'Macedonia, the Former Yugoslav Republic of', 'macedonia-the-former-yugoslav-republic-of'),
(380, 132, 'en', 'Madagascar', 'madagascar'),
(381, 133, 'en', 'Malawi', 'malawi'),
(382, 134, 'en', 'Malaysia', 'malaysia'),
(383, 135, 'en', 'Maldives', 'maldives'),
(384, 136, 'en', 'Mali', 'mali'),
(385, 137, 'en', 'Malta', 'malta'),
(386, 138, 'en', 'Marshall Islands', 'marshall-islands'),
(387, 139, 'en', 'Martinique', 'martinique'),
(388, 140, 'en', 'Mauritania', 'mauritania'),
(389, 141, 'en', 'Mauritius', 'mauritius'),
(390, 142, 'en', 'Mayotte', 'mayotte'),
(391, 143, 'en', 'Mexico', 'mexico'),
(392, 144, 'en', 'Micronesia, Federated States of', 'micronesia-federated-states-of'),
(393, 145, 'en', 'Moldova, Republic of', 'moldova-republic-of'),
(394, 146, 'en', 'Monaco', 'monaco'),
(395, 147, 'en', 'Mongolia', 'mongolia'),
(396, 148, 'en', 'Montenegro', 'montenegro'),
(397, 149, 'en', 'Montserrat', 'montserrat'),
(398, 150, 'en', 'Morocco', 'morocco'),
(399, 151, 'en', 'Mozambique', 'mozambique'),
(400, 152, 'en', 'Myanmar', 'myanmar'),
(401, 153, 'en', 'Namibia', 'namibia'),
(402, 154, 'en', 'Nauru', 'nauru'),
(403, 155, 'en', 'Nepal', 'nepal'),
(404, 156, 'en', 'Netherlands', 'netherlands'),
(405, 157, 'en', 'New Caledonia', 'new-caledonia'),
(406, 158, 'en', 'New Zealand', 'new-zealand'),
(407, 159, 'en', 'Nicaragua', 'nicaragua'),
(408, 160, 'en', 'Niger', 'niger'),
(409, 161, 'en', 'Nigeria', 'nigeria'),
(410, 162, 'en', 'Niue', 'niue'),
(411, 163, 'en', 'Norfolk Island', 'norfolk-island'),
(412, 164, 'en', 'Northern Mariana Islands', 'northern-mariana-islands'),
(413, 165, 'en', 'Norway', 'norway'),
(414, 166, 'en', 'Oman', 'oman'),
(415, 167, 'en', 'Pakistan', 'pakistan'),
(416, 168, 'en', 'Palau', 'palau'),
(417, 169, 'en', 'Palestine, State of', 'palestine-state-of'),
(418, 170, 'en', 'Panama', 'panama'),
(419, 171, 'en', 'Papua New Guinea', 'papua-new-guinea'),
(420, 172, 'en', 'Paraguay', 'paraguay'),
(421, 173, 'en', 'Peru', 'peru'),
(422, 174, 'en', 'Philippines', 'philippines'),
(423, 175, 'en', 'Pitcairn', 'pitcairn'),
(424, 176, 'en', 'Poland', 'poland'),
(425, 177, 'en', 'Portugal', 'portugal'),
(426, 178, 'en', 'Puerto Rico', 'puerto-rico'),
(427, 179, 'en', 'Qatar', 'qatar'),
(428, 180, 'en', 'Romania', 'romania'),
(429, 181, 'en', 'Russian Federation', 'russian-federation'),
(430, 182, 'en', 'Rwanda', 'rwanda'),
(431, 183, 'en', 'Reunion', 'reunion'),
(432, 184, 'en', 'Saint Barthelemy', 'saint-barthelemy'),
(433, 185, 'en', 'Saint Helena', 'saint-helena'),
(434, 186, 'en', 'Saint Kitts and Nevis', 'saint-kitts-and-nevis'),
(435, 187, 'en', 'Saint Lucia', 'saint-lucia'),
(436, 188, 'en', 'Saint Martin (French part)', 'saint-martin-french-part'),
(437, 189, 'en', 'Saint Pierre and Miquelon', 'saint-pierre-and-miquelon'),
(438, 190, 'en', 'Saint Vincent and the Grenadines', 'saint-vincent-and-the-grenadines'),
(439, 191, 'en', 'Samoa', 'samoa'),
(440, 192, 'en', 'San Marino', 'san-marino'),
(441, 193, 'en', 'Sao Tome and Principe', 'sao-tome-and-principe'),
(442, 194, 'en', 'Saudi Arabia', 'saudi-arabia'),
(443, 195, 'en', 'Senegal', 'senegal'),
(444, 196, 'en', 'Serbia', 'serbia'),
(445, 197, 'en', 'Seychelles', 'seychelles'),
(446, 198, 'en', 'Sierra Leone', 'sierra-leone'),
(447, 199, 'en', 'Singapore', 'singapore'),
(448, 200, 'en', 'Sint Maarten (Dutch part)', 'sint-maarten-dutch-part'),
(449, 201, 'en', 'Slovakia', 'slovakia'),
(450, 202, 'en', 'Slovenia', 'slovenia'),
(451, 203, 'en', 'Solomon Islands', 'solomon-islands'),
(452, 204, 'en', 'Somalia', 'somalia'),
(453, 205, 'en', 'South Africa', 'south-africa'),
(454, 206, 'en', 'South Georgia and the South Sandwich Islands', 'south-georgia-and-the-south-sandwich-islands'),
(455, 207, 'en', 'South Sudan', 'south-sudan'),
(456, 208, 'en', 'Spain', 'spain'),
(457, 209, 'en', 'Sri Lanka', 'sri-lanka'),
(458, 210, 'en', 'Sudan', 'sudan'),
(459, 211, 'en', 'Suriname', 'suriname'),
(460, 212, 'en', 'Svalbard and Jan Mayen', 'svalbard-and-jan-mayen'),
(461, 213, 'en', 'Swaziland', 'swaziland'),
(462, 214, 'en', 'Sweden', 'sweden'),
(463, 215, 'en', 'Switzerland', 'switzerland'),
(464, 216, 'en', 'Syrian Arab Republic', 'syrian-arab-republic'),
(465, 217, 'en', 'Taiwan', 'taiwan'),
(466, 218, 'en', 'Tajikistan', 'tajikistan'),
(467, 219, 'en', 'United Republic of Tanzania', 'united-republic-of-tanzania'),
(468, 220, 'en', 'Thailand', 'thailand'),
(469, 221, 'en', 'Timor-Leste', 'timor-leste'),
(470, 222, 'en', 'Togo', 'togo'),
(471, 223, 'en', 'Tokelau', 'tokelau'),
(472, 224, 'en', 'Tonga', 'tonga'),
(473, 225, 'en', 'Trinidad and Tobago', 'trinidad-and-tobago'),
(474, 226, 'en', 'Tunisia', 'tunisia'),
(475, 227, 'en', 'Turkey', 'turkey'),
(476, 228, 'en', 'Turkmenistan', 'turkmenistan'),
(477, 229, 'en', 'Turks and Caicos Islands', 'turks-and-caicos-islands'),
(478, 230, 'en', 'Tuvalu', 'tuvalu'),
(479, 231, 'en', 'Uganda', 'uganda'),
(480, 232, 'en', 'Ukraine', 'ukraine'),
(481, 233, 'en', 'United Arab Emirates', 'united-arab-emirates'),
(482, 234, 'en', 'United Kingdom', 'united-kingdom'),
(483, 235, 'en', 'United States', 'united-states'),
(484, 236, 'en', 'United States Minor Outlying Islands', 'united-states-minor-outlying-islands'),
(485, 237, 'en', 'Uruguay', 'uruguay'),
(486, 238, 'en', 'Uzbekistan', 'uzbekistan'),
(487, 239, 'en', 'Vanuatu', 'vanuatu'),
(488, 240, 'en', 'Venezuela', 'venezuela'),
(489, 241, 'en', 'Viet Nam', 'viet-nam'),
(490, 242, 'en', 'British Virgin Islands', 'british-virgin-islands'),
(491, 243, 'en', 'US Virgin Islands', 'us-virgin-islands'),
(492, 244, 'en', 'Wallis and Futuna', 'wallis-and-futuna'),
(493, 245, 'en', 'Western Sahara', 'western-sahara'),
(494, 246, 'en', 'Yemen', 'yemen'),
(495, 247, 'en', 'Zambia', 'zambia'),
(496, 248, 'en', 'Zimbabwe', 'zimbabwe'),
(501, 251, 'tr', 'Aland', 'aland'),
(502, 251, 'en', 'Aland Islands', 'aland'),
(503, 252, 'tr', 'Kosova', 'kosova'),
(504, 252, 'en', 'Kosovo', 'kosovo');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) UNSIGNED NOT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `code` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pservices` text COLLATE utf8mb4_unicode_ci,
  `period_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_duration` int(5) NOT NULL DEFAULT '0',
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `rate` int(5) NOT NULL DEFAULT '0',
  `amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `currency` int(3) NOT NULL DEFAULT '0',
  `uses` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `maxuses` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `taxfree` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `applyonce` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `newsignups` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `existingcustomer` int(1) NOT NULL DEFAULT '0',
  `dealership` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `use_merge` int(1) NOT NULL DEFAULT '0',
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `duedate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) UNSIGNED NOT NULL,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `local` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `country` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `countries` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decima` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thousand` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(10,5) NOT NULL DEFAULT '0.00000'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `status`, `local`, `country`, `countries`, `code`, `name`, `prefix`, `suffix`, `decima`, `thousand`, `rate`) VALUES
(1, 'inactive', 0, 'af_AF', NULL, 'AFN', 'Afghan Afghani', NULL, NULL, NULL, NULL, '0.00000'),
(2, 'inactive', 0, 'al_AL', NULL, 'ALL', 'Albanian lek', NULL, 'Lek', NULL, NULL, '0.00000'),
(3, 'inactive', 0, 'dz_DZ', NULL, 'DZD', 'Algerian dinar', NULL, NULL, NULL, NULL, '0.00000'),
(4, 'active', 0, 'en_US', 'AG,AR,AZ,BS,BB,BZ,BO,BR,CA,CL,CO,CR,CU,DM,DO,EC,SV,GF,GD,GT,GY,HT,HN,JM,MX,NI,PA,PY,PE,PR,SR,US,UY,VE', 'USD', 'US Dollar', '$', '', NULL, NULL, '0.19140'),
(5, 'active', 0, 'eu_EU', 'AT,BE,BG,HR,CY,CZ,EE,FI,FR,DE,GR,HU,IE,IT,LV,LT,LU,MT,NL,PL,PT,RO,RU,SK,SI,ES,SE,UA', 'EUR', 'Euro', '€', '', NULL, NULL, '0.16870'),
(6, 'inactive', 0, 'ao_AO', NULL, 'AOA', 'Angolan kwanza', NULL, NULL, NULL, NULL, '0.00000'),
(7, 'inactive', 0, 'ai_AI', NULL, 'XCD', 'East Caribbean dollar', NULL, NULL, NULL, NULL, '0.00000'),
(8, 'inactive', 0, 'ar_AR', NULL, 'ARS', 'Argentine peso', NULL, '$', NULL, NULL, '0.00000'),
(9, 'inactive', 0, 'am_AM', NULL, 'AMD', 'Armenian dram', NULL, NULL, NULL, NULL, '0.00000'),
(10, 'inactive', 0, 'aw_AW', NULL, 'AWG', 'Aruban guilder', NULL, NULL, NULL, NULL, '0.00000'),
(11, 'inactive', 0, 'au_AU', NULL, 'AUD', 'Australian dollar', NULL, '$', NULL, NULL, '0.00000'),
(12, 'inactive', 0, 'az_AZ', NULL, 'AZN', 'Manat', NULL, NULL, NULL, NULL, '0.35470'),
(13, 'inactive', 0, 'bs_BS', NULL, 'BSD', 'Bahamian dollar', NULL, '$', NULL, NULL, '0.00000'),
(14, 'inactive', 0, 'bh_BH', NULL, 'BHD', 'Bahraini dinar', NULL, NULL, NULL, NULL, '0.00000'),
(15, 'inactive', 0, 'bd_BD', NULL, 'BDT', 'Bangladeshi taka', NULL, NULL, NULL, NULL, '0.00000'),
(16, 'inactive', 0, 'bb_BB', NULL, 'BBD', 'Barbados dollar', NULL, NULL, NULL, NULL, '0.00000'),
(17, 'inactive', 0, 'by_BY', NULL, 'BYN', 'Belarusian ruble', NULL, 'Br', NULL, NULL, '0.00000'),
(18, 'inactive', 0, 'bz_BZ', NULL, 'BZD', 'Belize dollar', NULL, NULL, NULL, NULL, '0.00000'),
(19, 'inactive', 0, 'bj_BJ', NULL, 'XOF', 'CFA Franc BCEAO', NULL, NULL, NULL, NULL, '0.00000'),
(20, 'inactive', 0, 'bm_BM', NULL, 'BMD', 'Bermudian dollar', NULL, '$', NULL, NULL, '0.00000'),
(21, 'inactive', 0, 'bt_BT', NULL, 'BTN', 'Bhutanese ngultrum', NULL, NULL, NULL, NULL, '0.00000'),
(22, 'inactive', 0, 'bo_BO', NULL, 'BOB', 'Boliviano', NULL, NULL, NULL, NULL, '0.00000'),
(23, 'inactive', 0, 'ba_BA', NULL, 'BAM', 'Convertible mark', NULL, 'KM', NULL, NULL, '0.00000'),
(24, 'inactive', 0, 'bw_BW', NULL, 'BWP', 'Botswana pula', NULL, NULL, NULL, NULL, '0.00000'),
(25, 'inactive', 0, 'bv_BV', NULL, 'NOK', 'Norwegian krone', NULL, NULL, NULL, NULL, '0.00000'),
(26, 'inactive', 0, 'br_BR', NULL, 'BRL', 'Brazilian real', NULL, NULL, NULL, NULL, '0.00000'),
(27, 'active', 0, 'gb_GB', 'DK,GI,GG,JE,SH,GS,GB', 'GBP', 'British Pound', '£', '', NULL, NULL, '0.15040'),
(28, 'inactive', 0, 'bn_BN', NULL, 'BND', 'Brunei dollar', NULL, '$', NULL, NULL, '0.00000'),
(29, 'inactive', 0, 'bg_BG', NULL, 'BGN', 'Bulgarian lev', NULL, 'лв', NULL, NULL, '0.00000'),
(30, 'inactive', 0, 'bi_BI', NULL, 'BIF', 'Burundian franc', NULL, NULL, NULL, NULL, '0.00000'),
(31, 'inactive', 0, 'kh_KH', NULL, 'KHR', 'Cambodian riel', NULL, NULL, NULL, NULL, '0.00000'),
(32, 'inactive', 0, 'cm_CM', NULL, 'XAF', 'CFA Franc BEAC', NULL, NULL, NULL, NULL, '0.00000'),
(33, 'inactive', 0, 'ca_CA', NULL, 'CAD', 'Canadian dollar', NULL, '$', NULL, NULL, '0.00000'),
(34, 'inactive', 0, 'cv_CV', NULL, 'CVE', 'Cape Verde escudo', NULL, NULL, NULL, NULL, '0.00000'),
(35, 'inactive', 0, 'ky_KY', NULL, 'KYD', 'Cayman Islands dollar', NULL, NULL, NULL, NULL, '0.00000'),
(36, 'inactive', 0, 'cl_CL', NULL, 'CLP', 'Chilean peso', NULL, '$', NULL, NULL, '0.00000'),
(37, 'inactive', 0, 'cn_CN', NULL, 'CNY', 'Chinese yuan renminbi (RMB)', NULL, NULL, NULL, NULL, '0.00000'),
(38, 'inactive', 0, 'co_CO', NULL, 'COP', 'Colombian peso', NULL, NULL, NULL, NULL, '0.00000'),
(39, 'inactive', 0, 'km_KM', NULL, 'KMF', 'Comoro franc', NULL, NULL, NULL, NULL, '0.00000'),
(40, 'inactive', 0, 'ck_CK', NULL, 'NZD', 'New Zealand dollar', NULL, '$', NULL, NULL, '0.00000'),
(41, 'inactive', 0, 'cr_CR', NULL, 'CRC', 'Costa Rican colon', NULL, NULL, NULL, NULL, '0.00000'),
(42, 'inactive', 0, 'hr_HR', NULL, 'HRK', 'Croatian kuna', NULL, 'kn', NULL, NULL, '0.00000'),
(43, 'delete', 0, 'cu_CU', NULL, 'CUC', 'Cuban convertible Peso', NULL, NULL, NULL, NULL, '0.00000'),
(44, 'inactive', 0, 'cs_CS', NULL, 'CZK', 'Czech koruna', NULL, 'Kč', NULL, NULL, '0.00000'),
(45, 'inactive', 0, 'cd_CD', NULL, 'CDF', 'Congolese franc', NULL, NULL, NULL, NULL, '0.00000'),
(46, 'inactive', 0, 'dk_DK', NULL, 'DKK', 'Danish krone', NULL, NULL, NULL, NULL, '0.00000'),
(47, 'inactive', 0, 'dj_DJ', NULL, 'DJF', 'Djiboutian franc', NULL, NULL, NULL, NULL, '0.00000'),
(48, 'inactive', 0, 'do_DO', NULL, 'DOP', 'Dominican peso', NULL, 'RD$', NULL, NULL, '0.00000'),
(49, 'inactive', 0, 'eg_EG', NULL, 'EGP', 'Egyptian pound', NULL, '£', NULL, NULL, '0.00000'),
(50, 'inactive', 0, 'sv_SV', NULL, 'SVC', 'Salvadoran colon', NULL, NULL, NULL, NULL, '0.00000'),
(51, 'inactive', 0, 'er_ER', NULL, 'ERN', 'Eritrean nakfa', NULL, NULL, NULL, NULL, '0.00000'),
(52, 'inactive', 0, 'et_ET', NULL, 'ETB', 'Ethipian birr', NULL, NULL, NULL, NULL, '0.00000'),
(53, 'inactive', 0, 'fk_FK', NULL, 'FKP', 'Falkland Islands pound', NULL, NULL, NULL, NULL, '0.00000'),
(54, 'inactive', 0, 'fj_FJ', NULL, 'FJD', 'Fiji dollar', NULL, '$', NULL, NULL, '0.00000'),
(55, 'inactive', 0, 'pf_PF', NULL, 'XPF', 'French pacific franc', NULL, NULL, NULL, NULL, '0.00000'),
(56, 'inactive', 0, 'gm_GM', NULL, 'GMD', 'Gambian dalasi', NULL, NULL, NULL, NULL, '0.00000'),
(57, 'inactive', 0, 'ge_GE', NULL, 'GEL', 'Georgian lari', NULL, NULL, NULL, NULL, '0.00000'),
(58, 'inactive', 0, 'gh_GH', NULL, 'GHS', 'Ghanaian Cedi', NULL, NULL, NULL, NULL, '0.00000'),
(59, 'inactive', 0, 'gi_GI', NULL, 'GIP', 'Gibraltar pound', NULL, '£', NULL, NULL, '0.00000'),
(60, 'inactive', 0, 'gt_GT', NULL, 'GTQ', 'Guatemalan quetzal', NULL, NULL, NULL, NULL, '0.00000'),
(61, 'delete', 0, 'gg_GG', NULL, 'GGP', 'Guernsey Pound', NULL, '£', NULL, NULL, '0.00000'),
(62, 'inactive', 0, 'gn_GN', NULL, 'GNF', 'Guinean franc', NULL, NULL, NULL, NULL, '0.00000'),
(63, 'inactive', 0, 'gy_GY', NULL, 'GYD', 'Guyanese dollar', NULL, NULL, NULL, NULL, '0.00000'),
(64, 'inactive', 0, 'ht_HT', NULL, 'HTG', 'Haitian gourde', NULL, NULL, NULL, NULL, '0.00000'),
(65, 'inactive', 0, 'hn_HN', NULL, 'HNL', 'Honduran lempira', NULL, 'L', NULL, NULL, '0.00000'),
(66, 'inactive', 0, 'hk_HK', NULL, 'HKD', 'Hong Kong dollar', NULL, NULL, NULL, NULL, '0.00000'),
(67, 'inactive', 0, 'hu_HU', NULL, 'HUF', 'Hungarian forint', NULL, 'Ft', NULL, NULL, '0.00000'),
(68, 'inactive', 0, 'is_IS', NULL, 'ISK', 'Icelandic króna', NULL, NULL, NULL, NULL, '0.00000'),
(69, 'inactive', 0, 'in_IN', NULL, 'INR', 'Indian rupee', NULL, '', NULL, NULL, '0.00000'),
(70, 'inactive', 0, 'id_ID', NULL, 'IDR', 'Indonesian rupiah', NULL, NULL, NULL, NULL, '0.00000'),
(71, 'inactive', 0, 'ir_IR', NULL, 'IRR', 'Iranian rial', NULL, '﷼', NULL, NULL, '0.00000'),
(72, 'inactive', 0, 'iq_IQ', NULL, 'IQD', 'Iraqi dinar', NULL, NULL, NULL, NULL, '0.00000'),
(73, 'delete', 0, 'im_IM', NULL, 'IMP', 'Manx pound', NULL, NULL, NULL, NULL, '0.00000'),
(74, 'inactive', 0, 'il_IL', NULL, 'ILS', 'Israeli new shekel', NULL, '₪', NULL, NULL, '0.00000'),
(75, 'inactive', 0, 'jm_JM', NULL, 'JMD', 'Jamaican dollar', NULL, NULL, NULL, NULL, '0.00000'),
(76, 'inactive', 0, 'jp_JP', NULL, 'JPY', 'Japanese yen', NULL, '¥', NULL, NULL, '0.00000'),
(77, 'delete', 0, 'je_JE', NULL, 'JEP', 'Jersey pound', NULL, NULL, NULL, NULL, '0.00000'),
(78, 'inactive', 0, 'jo_JO', NULL, 'JOD', 'Jordanian dinar', NULL, NULL, NULL, NULL, '0.00000'),
(79, 'inactive', 0, 'kz_KZ', NULL, 'KZT', 'Kazakhstani tenge', NULL, 'лв', NULL, NULL, '0.00000'),
(80, 'inactive', 0, 'ke_KE', NULL, 'KES', 'Kenyan shilling', NULL, NULL, NULL, NULL, '0.00000'),
(81, 'inactive', 0, 'kw_KW', NULL, 'KWD', 'Kuwaiti dinar', NULL, NULL, NULL, NULL, '0.00000'),
(82, 'inactive', 0, 'kg_KG', NULL, 'KGS', 'Kyrgyzstani som', NULL, NULL, NULL, NULL, '0.00000'),
(83, 'inactive', 0, 'la_LA', NULL, 'LAK', 'Lao kip', NULL, '₭', NULL, NULL, '0.00000'),
(84, 'inactive', 0, 'lb_LB', NULL, 'LBP', 'Lebanese pound', NULL, NULL, NULL, NULL, '0.00000'),
(85, 'inactive', 0, 'ls_LS', NULL, 'LSL', 'Lesotho loti', NULL, NULL, NULL, NULL, '0.00000'),
(86, 'inactive', 0, 'lr_LR', NULL, 'LRD', 'Liberian dollar', NULL, '$', NULL, NULL, '0.00000'),
(87, 'inactive', 0, 'ly_LY', NULL, 'LYD', 'Libyan dinar', NULL, NULL, NULL, NULL, '0.00000'),
(88, 'inactive', 0, 'ch_CH', NULL, 'CHF', 'Swiss Franc', NULL, 'CHF', NULL, NULL, '0.24800'),
(89, 'inactive', 0, 'lt_LT', NULL, 'LTL', 'Lithuanian litas', NULL, NULL, NULL, NULL, '0.00000'),
(90, 'inactive', 0, 'mo_MO', NULL, 'MOP', 'Macanese pataca', NULL, NULL, NULL, NULL, '0.00000'),
(91, 'inactive', 0, 'mk_MK', NULL, 'MKD', 'Macedonian denar', NULL, NULL, NULL, NULL, '0.00000'),
(92, 'inactive', 0, 'mg_MG', NULL, 'MGA', 'Malagasy ariayry', NULL, NULL, NULL, NULL, '0.00000'),
(93, 'inactive', 0, 'mw_MW', NULL, 'MWK', 'Malawian kwacha', NULL, NULL, NULL, NULL, '0.00000'),
(94, 'inactive', 0, 'my_MY', NULL, 'MYR', 'Malaysian ringgit', NULL, 'RM', NULL, NULL, '0.00000'),
(95, 'inactive', 0, 'mv_MV', NULL, 'MVR', 'Maldivian rufiyaa', NULL, NULL, NULL, NULL, '0.00000'),
(96, 'delete', 0, 'mr_MR', NULL, 'MRU', 'Mauritanian ouguiya', NULL, NULL, NULL, NULL, '0.00000'),
(97, 'inactive', 0, 'mu_MU', NULL, 'MUR', 'Mauritian rupee', NULL, NULL, NULL, NULL, '0.00000'),
(98, 'inactive', 0, 'mx_MX', NULL, 'MXN', 'Mexican peso', NULL, '$', NULL, NULL, '0.00000'),
(99, 'inactive', 0, 'md_MD', NULL, 'MDL', 'Moldovan leu', NULL, NULL, NULL, NULL, '0.00000'),
(100, 'inactive', 0, 'mn_MN', NULL, 'MNT', 'Mongolian tugrik', NULL, NULL, NULL, NULL, '0.00000'),
(101, 'inactive', 0, 'ma_MA', NULL, 'MAD', 'Moroccan dirham', NULL, NULL, NULL, NULL, '0.00000'),
(102, 'inactive', 0, 'mz_MZ', NULL, 'MZN', 'Mozambican metical', NULL, 'MT', NULL, NULL, '0.00000'),
(103, 'inactive', 0, 'mm_MM', NULL, 'MMK', 'Myanma kyat', NULL, NULL, NULL, NULL, '0.00000'),
(104, 'inactive', 0, 'na_NA', NULL, 'NAD', 'Namibian dollar', NULL, NULL, NULL, NULL, '0.00000'),
(105, 'inactive', 0, 'np_NP', NULL, 'NPR', 'Nepalese rupee', NULL, '₨', NULL, NULL, '0.00000'),
(106, 'inactive', 0, 'an_AN', NULL, 'ANG', 'Netherlands Antillean guilder', NULL, NULL, NULL, NULL, '0.00000'),
(107, 'inactive', 0, 'ni_NI', NULL, 'NIO', 'Nicaraguan córdoba', NULL, NULL, NULL, NULL, '0.00000'),
(108, 'inactive', 0, 'ng_NG', NULL, 'NGN', 'Nigerian naira', NULL, '₦', NULL, NULL, '0.00000'),
(109, 'inactive', 0, 'kp_KP', NULL, 'KPW', 'North Korean won', NULL, NULL, NULL, NULL, '0.00000'),
(110, 'inactive', 0, 'om_OM', NULL, 'OMR', 'Omani rial', NULL, '﷼', NULL, NULL, '0.00000'),
(111, 'inactive', 0, 'pk_PK', NULL, 'PKR', 'Pakistani rupee', NULL, NULL, NULL, NULL, '0.00000'),
(112, 'inactive', 0, 'pa_PA', NULL, 'PAB', 'Panamanian balboa', NULL, 'B/.', NULL, NULL, '0.00000'),
(113, 'inactive', 0, 'pg_PG', NULL, 'PGK', 'Papua New Guinean kina', NULL, NULL, NULL, NULL, '0.00000'),
(114, 'inactive', 0, 'py_PY', NULL, 'PYG', 'Paraguayan guaraní', NULL, NULL, NULL, NULL, '0.00000'),
(115, 'inactive', 0, 'pe_PE', NULL, 'PEN', 'Peruvian nuevo sol', NULL, 'S/.', NULL, NULL, '0.00000'),
(116, 'inactive', 0, 'ph_PH', NULL, 'PHP', 'Philippine peso', NULL, NULL, NULL, NULL, '0.00000'),
(117, 'inactive', 0, 'pl_PL', NULL, 'PLN', 'Polish zloty', NULL, 'zł', NULL, NULL, '0.00000'),
(118, 'inactive', 0, 'qa_QA', NULL, 'QAR', 'Qatari riyal', NULL, NULL, NULL, NULL, '0.00000'),
(119, 'inactive', 0, 'ro_RO', NULL, 'RON', 'Romanian new Leu', NULL, 'lei', NULL, NULL, '0.00000'),
(120, 'inactive', 0, 'ru_RU', NULL, 'RUB', 'Russian Ruble', NULL, 'руб', NULL, NULL, '13.24460'),
(121, 'inactive', 0, 'rw_RW', NULL, 'RWF', 'Rwandan franc', NULL, NULL, NULL, NULL, '0.00000'),
(122, 'inactive', 0, 'sa_SA', NULL, 'SAR', 'Saudi riyal', NULL, NULL, NULL, NULL, '0.00000'),
(123, 'inactive', 0, 'rs_RS', NULL, 'RSD', 'Serbian dinar', NULL, 'Дин.', NULL, NULL, '0.00000'),
(124, 'inactive', 0, 'sc_SC', NULL, 'SCR', 'Seychelles rupee', NULL, NULL, NULL, NULL, '0.00000'),
(125, 'inactive', 0, 'sl_SL', NULL, 'SLL', 'Sierra Leonean leone', NULL, NULL, NULL, NULL, '0.00000'),
(126, 'inactive', 0, 'sg_SG', NULL, 'SGD', 'Singapore dollar', NULL, '$', NULL, NULL, '0.00000'),
(127, 'inactive', 0, 'sb_SB', NULL, 'SBD', 'Solomon Islands dollar', NULL, NULL, NULL, NULL, '0.00000'),
(128, 'inactive', 0, 'so_SO', NULL, 'SOS', 'Somali shilling', NULL, 'S', NULL, NULL, '0.00000'),
(129, 'inactive', 0, 'za_ZA', NULL, 'ZAR', 'South African rand', NULL, NULL, NULL, NULL, '0.00000'),
(130, 'inactive', 0, 'kr_KR', NULL, 'KRW', 'South Korean won', NULL, '₩', NULL, NULL, '0.00000'),
(131, 'delete', 0, 'ss_SS', NULL, 'SSP', 'South Sudanese Pound', NULL, NULL, NULL, NULL, '0.00000'),
(132, 'inactive', 0, 'lk_LK', NULL, 'LKR', 'Sri Lankan rupee', NULL, '₨', NULL, NULL, '0.00000'),
(133, 'inactive', 0, 'sh_SH', NULL, 'SHP', 'Saint Helena pound', NULL, '£', NULL, NULL, '0.00000'),
(134, 'delete', 0, 'st_ST', NULL, 'STN', 'São Tomé dobra', NULL, NULL, NULL, NULL, '0.00000'),
(135, 'inactive', 0, 'sd_SD', NULL, 'SDG', 'Sudanese pound', NULL, NULL, NULL, NULL, '0.00000'),
(136, 'inactive', 0, 'sr_SR', NULL, 'SRD', 'Surinamese dollar', NULL, NULL, NULL, NULL, '0.00000'),
(137, 'inactive', 0, 'sz_SZ', NULL, 'SZL', 'Swazi lilangeni', NULL, NULL, NULL, NULL, '0.00000'),
(138, 'inactive', 0, 'se_SE', NULL, 'SEK', 'Swedish krona', NULL, NULL, NULL, NULL, '0.00000'),
(139, 'inactive', 0, 'sy_SY', NULL, 'SYP', 'Syrian pound', NULL, '£', NULL, NULL, '0.00000'),
(140, 'inactive', 0, 'tw_TW', NULL, 'TWD', 'New Taiwan dollar', NULL, NULL, NULL, NULL, '0.00000'),
(141, 'inactive', 0, 'tj_TJ', NULL, 'TJS', 'Tajikistani somoni', NULL, NULL, NULL, NULL, '0.00000'),
(142, 'inactive', 0, 'tz_TZ', NULL, 'TZS', 'Tanzanian shilling', NULL, NULL, NULL, NULL, '0.00000'),
(143, 'inactive', 0, 'th_TH', NULL, 'THB', 'Thai baht', NULL, '฿', NULL, NULL, '0.00000'),
(144, 'inactive', 0, 'to_TO', NULL, 'TOP', 'Tongan pa\'anga', NULL, NULL, NULL, NULL, '0.00000'),
(145, 'inactive', 0, 'tt_TT', NULL, 'TTD', 'Trinidad dollar', NULL, NULL, NULL, NULL, '0.00000'),
(146, 'inactive', 0, 'tn_TN', NULL, 'TND', 'Tunisian dinar', NULL, NULL, NULL, NULL, '0.00000'),
(147, 'active', 1, 'tr_TR', NULL, 'TRY', 'Türk Lirası', NULL, ' ₺', NULL, NULL, '1.00000'),
(148, 'inactive', 0, 'tm_TM', NULL, 'TMT', 'Turkmenistani new manat', NULL, NULL, NULL, NULL, '0.00000'),
(149, 'inactive', 0, 'ug_UG', NULL, 'UGX', 'Ugandan shilling', NULL, NULL, NULL, NULL, '0.00000'),
(150, 'inactive', 0, 'ua_UA', NULL, 'UAH', 'Ukrainian hryvnia', NULL, '₴', NULL, NULL, '0.00000'),
(151, 'inactive', 0, 'ae_AE', NULL, 'AED', 'UAE dirham', NULL, NULL, NULL, NULL, '0.00000'),
(152, 'inactive', 0, 'uy_UY', NULL, 'UYU', 'Urugayan peso', NULL, NULL, NULL, NULL, '0.00000'),
(153, 'inactive', 0, 'uz_UZ', NULL, 'UZS', 'Uzbekitan som', NULL, 'лв', NULL, NULL, '0.00000'),
(154, 'inactive', 0, 'vu_VU', NULL, 'VUV', 'Vanuatu vatu', NULL, NULL, NULL, NULL, '0.00000'),
(155, 'inactive', 0, 've_VE', NULL, 'VEF', 'Venezualan bolivar fuerte', NULL, NULL, NULL, NULL, '0.00000'),
(156, 'inactive', 0, 'vn_VN', NULL, 'VND', 'Vietnamese Đồng', NULL, '₫', NULL, NULL, '0.00000'),
(157, 'inactive', 0, 'ws_WS', NULL, 'WST', 'Samoan tala', NULL, NULL, NULL, NULL, '0.00000'),
(158, 'inactive', 0, 'ye_YE', NULL, 'YER', 'Yemeni rial', NULL, NULL, NULL, NULL, '62.80630'),
(159, 'delete', 0, 'yu_YU', NULL, 'YUN', 'Yugoslav dinar', NULL, NULL, NULL, NULL, '0.00000'),
(160, 'inactive', 0, 'zm_ZM', NULL, 'ZMW', 'Zambian kwacha', NULL, NULL, NULL, NULL, '0.00000');

-- --------------------------------------------------------

--
-- Table structure for table `customer_feedbacks`
--

CREATE TABLE `customer_feedbacks` (
  `id` int(11) UNSIGNED NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `rank` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unread` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_feedbacks`
--

INSERT INTO `customer_feedbacks` (`id`, `status`, `full_name`, `company_name`, `email`, `ctime`, `rank`, `ip`, `unread`) VALUES
(8, 'approved', 'Ann T Brown', 'Total Quality Services LLC.', 'AnnTBrown@example.com', '2018-05-12 01:23:00', 1, '81.213.162.240', 1),
(10, 'approved', 'James R Miller', 'Architectural Genie Inc.', 'JamesRMiller@example.com', '2018-07-02 11:31:14', 2, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_feedbacks_lang`
--

CREATE TABLE `customer_feedbacks_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `message` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_feedbacks_lang`
--

INSERT INTO `customer_feedbacks_lang` (`id`, `owner_id`, `lang`, `message`) VALUES
(2, 8, 'tr', 'Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır.'),
(11, 8, 'en', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).'),
(13, 10, 'tr', 'Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır.'),
(14, 10, 'en', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `owner` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status_msg` text COLLATE utf8mb4_unicode_ci,
  `unread` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `data` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fraud_detected_records`
--

CREATE TABLE `fraud_detected_records` (
  `id` int(11) UNSIGNED NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `message` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income_expense`
--

CREATE TABLE `income_expense` (
  `id` int(11) UNSIGNED NOT NULL,
  `invoice_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'income',
  `amount` decimal(16,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `currency` int(11) NOT NULL DEFAULT '0',
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) UNSIGNED NOT NULL,
  `number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8mb4_unicode_ci,
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `duedate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `datepaid` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `refunddate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `local` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `legal` int(1) UNSIGNED NOT NULL,
  `taxed` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `taxed_file` text COLLATE utf8mb4_unicode_ci,
  `data` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ghost',
  `currency` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `taxation_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'exclusive',
  `taxrate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `subtotal` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `recurring` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `recurring_time` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `recurring_period` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `discounts` text COLLATE utf8mb4_unicode_ci,
  `used_coupons` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_promotions` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sendbta` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `sendbta_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `pmethod` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `pmethod_commission` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `pmethod_commission_rate` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `pmethod_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `pmethod_msg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `unread` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices_items`
--

CREATE TABLE `invoices_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `user_pid` int(11) NOT NULL DEFAULT '0',
  `options` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `taxexempt` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `total_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `currency` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `rank` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledgebase`
--

CREATE TABLE `knowledgebase` (
  `id` int(11) UNSIGNED NOT NULL,
  `category` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `categories` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `useful` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `useless` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `private` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `knowledgebase`
--

INSERT INTO `knowledgebase` (`id`, `category`, `categories`, `sidebar`, `visit_count`, `useful`, `useless`, `private`, `rank`, `ctime`) VALUES
(1, 5, NULL, NULL, 2, 0, 0, 0, 1, '2017-10-24 16:57:16'),
(2, 6, NULL, NULL, 2, 1, 0, 0, 1, '2017-10-24 16:58:26'),
(3, 5, NULL, NULL, 4, 1, 0, 0, 1, '2017-10-24 16:58:45'),
(4, 8, '7', NULL, 3, 3, 2, 0, 1, '2017-10-24 16:59:35'),
(5, 5, NULL, '', 5, 8, 2, 0, 0, '2017-10-25 10:39:27'),
(6, 6, NULL, '', 3, 12, 5, 0, 1, '2017-10-25 10:39:52'),
(7, 8, NULL, '', 9, 5, 5, 0, 1, '2017-10-25 10:40:30'),
(8, 0, NULL, '', 10, 5, 0, 1, 1, '2017-10-25 10:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `knowledgebase_lang`
--

CREATE TABLE `knowledgebase_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `seo_title` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `knowledgebase_lang`
--

INSERT INTO `knowledgebase_lang` (`id`, `owner_id`, `lang`, `route`, `title`, `content`, `seo_title`, `seo_keywords`, `seo_description`, `tags`) VALUES
(1, 1, 'tr', 'where-does-it-come-from', 'Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'Where does it come from?', 'Where does it come from?', 'Where does it come from?', NULL),
(2, 2, 'tr', 'where-can-i-get-some', 'Where can I get some?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod orci at elit consequat aliquam. Nam libero lectus, condimentum id velit quis, maximus efficitur lacus. Cras convallis, mi ac suscipit suscipit, ante nunc maximus leo, eu tincidunt tellus eros sit amet orci. In condimentum hendrerit metus id pretium. In sed turpis fermentum, dapibus erat non, laoreet neque. Maecenas nec sem at ante commodo scelerisque. Fusce luctus ante sagittis, fringilla mauris sed, ullamcorper risus. Phasellus porta purus vel risus condimentum, non sollicitudin mauris vehicula. Aliquam erat volutpat. Nullam orci odio, rutrum at bibendum eu, volutpat scelerisque tortor. Nullam nec hendrerit nulla, in iaculis sem.\r\n\r\nDonec dapibus nec turpis placerat rhoncus. Morbi leo sapien, consectetur a auctor quis, lacinia ut lorem. In hac habitasse platea dictumst. Nulla facilisi. Vestibulum nec elit augue. Donec tempor efficitur odio nec pretium. Nunc quis ipsum ac tellus hendrerit lobortis sed ut justo. Suspendisse a purus mattis nunc eleifend gravida. Proin non orci arcu. Mauris vestibulum condimentum quam, id dictum nisl bibendum a.\r\n\r\nUt tortor ex, interdum sit amet orci ut, iaculis vehicula justo. Sed venenatis ligula at porta imperdiet. In hac habitasse platea dictumst. In pulvinar, ligula vitae suscipit blandit, enim magna ultricies orci, a consectetur sem ante sed magna. Mauris a nisi porta orci rutrum tristique. Sed eu nisl porta metus cursus pretium non sed erat. Nulla mollis nulla eget ornare pretium. Nulla rutrum lacus vel odio mollis, nec rutrum metus placerat. Suspendisse tempus, lacus non varius imperdiet, ex purus fermentum velit, et dignissim magna nibh eget purus. Vivamus finibus scelerisque fermentum. Aenean fringilla venenatis velit, a venenatis tortor fringilla vel. Morbi orci felis, scelerisque porta scelerisque eget, finibus at leo.\r\n\r\nNulla mi augue, bibendum vitae ligula vitae, imperdiet malesuada ex. Maecenas eleifend iaculis dolor eget dapibus. Pellentesque non orci luctus, porttitor sem sed, cursus ante. Praesent a elementum arcu, eget feugiat libero. Nunc posuere aliquam ligula, vitae varius metus dignissim vel. Donec consequat ullamcorper leo, pharetra iaculis dui posuere vel. Cras neque mauris, iaculis in libero rutrum, vehicula venenatis ipsum. Nulla eget feugiat ipsum, at facilisis lorem. Cras at consectetur lacus, fringilla pharetra ante. Phasellus sit amet leo eu nunc vestibulum mattis. Sed et consectetur ipsum.\r\n\r\nPraesent tincidunt, nisl quis tempus cursus, est tellus consequat augue, et scelerisque erat massa sed ipsum. Nullam dictum pretium ipsum, ut maximus nibh iaculis vitae. Etiam auctor id turpis at suscipit. Nulla dolor ipsum, ornare eu maximus sed, pharetra at metus. Praesent venenatis, mauris quis ultricies lobortis, tortor eros scelerisque diam, facilisis tempor libero lorem a lectus. Vivamus mi lacus, cursus nec urna vitae, tincidunt vestibulum arcu. Nam vel tellus vitae sapien ultrices vestibulum sed et risus. Donec semper volutpat auctor. Aliquam turpis justo, rutrum vitae pulvinar id, tempus non leo. Praesent placerat, nisl et ornare pharetra, urna sapien pellentesque lorem, sit amet posuere ligula ipsum vel metus.', 'Where can I get some?', 'Where can I get some?', 'Where can I get some?', NULL),
(3, 3, 'tr', 'the-standard-lorem-ipsum-passage', 'The standard Lorem Ipsum passage, used since the 1500s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam risus sapien, molestie ac metus at, hendrerit condimentum nisl. Mauris varius, est at molestie vehicula, arcu tortor placerat elit, eget facilisis purus ante non libero. Donec vestibulum tortor sit amet dapibus dictum. Duis ut lectus vel lorem placerat posuere. Aliquam euismod sem quam, non viverra erat aliquet id. Donec nec ipsum leo. Sed bibendum eros id orci hendrerit, sit amet mattis lorem consequat. Nam vestibulum justo at ligula pharetra dapibus. Proin lobortis eget odio at consectetur. Vestibulum eget est magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat turpis ut arcu porttitor, quis imperdiet leo auctor. Praesent sagittis odio vitae arcu posuere, mollis fermentum odio lobortis. Aliquam ipsum purus, facilisis vel dignissim faucibus, feugiat id purus. Mauris et aliquet nisi. Donec vitae vulputate orci.\r\n\r\nPellentesque est lacus, semper in malesuada eu, fringilla vel urna. Etiam feugiat est sem, sed mollis mauris bibendum sit amet. Aenean condimentum tincidunt enim ac fringilla. Donec vel elit magna. Suspendisse mi enim, suscipit et laoreet eu, gravida nec quam. Praesent nec nisi sapien. Etiam pulvinar risus sagittis est fermentum tristique. Vestibulum id ligula commodo, tincidunt lorem in, euismod nibh. Mauris et pharetra lorem, vel luctus diam. Mauris aliquam velit lacus, vitae pulvinar dolor ultrices quis. Pellentesque posuere vulputate nulla ut viverra. Sed tortor nibh, imperdiet ac auctor quis, imperdiet et ante. Sed id odio sollicitudin, ultrices nisi nec, malesuada nulla. Donec sodales volutpat mi convallis blandit. Nam efficitur at massa ut lobortis.', 'The standard Lorem Ipsum passage, used since the 1500s', 'The standard Lorem Ipsum passage, used since the 1500s', 'The standard Lorem Ipsum passage, used since the 1500s', NULL),
(4, 4, 'tr', 'pellentesque-a-vulputate-turpis', 'Pellentesque a vulputate turpis', 'Pellentesque a vulputate turpis. Pellentesque tristique libero et suscipit rutrum. Quisque faucibus vehicula congue. Aliquam quis nibh iaculis, volutpat ligula at, suscipit erat. Etiam vel tincidunt enim. Maecenas sit amet iaculis dui. Etiam facilisis urna quam, in faucibus erat pulvinar quis. Donec at augue erat.\r\n\r\nNulla facilisi. Etiam fermentum scelerisque nisl, et viverra est auctor quis. Pellentesque viverra vulputate iaculis. Donec tristique dapibus consectetur. Praesent faucibus ac lectus vitae accumsan. Nam lobortis, enim at mollis consectetur, tellus orci imperdiet risus, vel egestas felis lacus in est. Cras accumsan tristique lectus vel gravida. Nam eu metus a neque accumsan mattis. Suspendisse eget auctor libero. Donec et condimentum sem, in viverra mauris. Sed ut augue consectetur risus egestas aliquet ac sed nunc. In hac habitasse platea dictumst. Integer luctus lorem dolor, eu dictum est pharetra sed. Morbi in semper libero, eu bibendum dolor. Fusce eget neque efficitur, ullamcorper nibh eget, venenatis augue. Etiam bibendum erat nec leo suscipit condimentum.\r\n\r\nVestibulum eget consectetur purus. Nulla eu quam et neque suscipit semper. Integer ullamcorper venenatis mollis. Fusce commodo eros felis, eget tincidunt eros auctor ac. Nullam id erat lorem. Etiam id lobortis lectus. Quisque semper augue quis tellus hendrerit, et fermentum mi commodo. Maecenas sollicitudin, enim a ultricies lacinia, ligula purus dapibus lacus, eu luctus enim sapien at nunc. Integer hendrerit sagittis suscipit. Nullam suscipit facilisis luctus.\r\n\r\nSed semper sit amet augue vitae fringilla. Etiam eu neque at sapien efficitur sodales. Integer porttitor ipsum sapien, a scelerisque velit egestas in. Quisque ac efficitur sem. Donec consectetur vestibulum diam a scelerisque. Etiam eget sem tempor, dictum libero at, mollis mi. Sed in viverra nulla, in venenatis leo. Donec non erat tristique, ornare sem id, pulvinar nunc. Ut non lobortis ligula. Vestibulum luctus, eros suscipit luctus condimentum, lorem enim luctus orci, ut ultrices leo risus nec dolor. Nulla cursus augue ut dignissim tempus. Nam vitae sollicitudin odio. Sed sollicitudin arcu fringilla magna lacinia convallis. Nunc faucibus dictum lectus, ac bibendum elit pellentesque malesuada.\r\n\r\nInteger sed fermentum mauris. Phasellus molestie velit sit amet diam vehicula, sed ornare mi varius. Nullam suscipit vehicula orci, nec viverra elit suscipit in. Fusce et lacus massa. Donec ac lacinia dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse rutrum velit at porta gravida. Nam nulla diam, venenatis cursus dictum ac, rutrum quis nibh. Quisque hendrerit ac ligula a pulvinar. Fusce ornare commodo velit, in posuere felis malesuada eget. Sed purus elit, tempor ut euismod ac, dapibus sit amet lectus. Duis mattis velit id euismod tempor.', 'Pellentesque a vulputate turpis', 'Pellentesque a vulputate turpis', 'Pellentesque a vulputate turpis', NULL),
(5, 5, 'tr', 'turk-dil-kurumu-tdk-nedir-tarihi-amaci', 'Türk Dil Kurumu (TDK) Nedir? (Tarihi, Amacı)', '<p>Türkçenin geliştirilmesi ve korunması için çaba sarf eden Türk Dil Kurumu, övgüler, eleştiriler ve tartışmalar arasında çalışan bir bilim kuruluşudur. Türk Dil Kurumu (TDK) Nedir? (Tarihi, Amacı) Türk Dil Kurumu (TDK), Başbakanlık Atatürk Kültür, Dil ve Tarih Yüksek Kurumu’na bağlı bir kuruluştur. Tüzel kişiliği olan kamu kurumudur. Türk dilinin zenginliğini ortaya çıkarmak amacıyla kurulmuştur. Ayrıca, “Türkçeyi diğer diller arasında değerine yaraşır bir biçimde yükseltmek” amacını güder. Türk dili ile ilgili çalışmalar yapan ve bu çalışmaların sonuçlarını yayınlayan kuruluştur. Merkezi Ankara’da bulunan TDK, Türkçeyi zenginleştirmenin yanında yabancı kelimelerin Türkçe karşılıklarını da bularak dil yozlaşmasının önüne geçmek için çaba sarf ediyor. Yabancı kelimelerle dolu tabelalar, medyadaki yabancılaşmış dil, teknolojik yozlaşma ile mücadele eden TDK, övgüler ve eleştiriler arasında, 1932 yılından beri görevini yürütmeye çalışıyor. Tarihçesi TDK, 12 Temmuz 1932 tarihinde Atatürk’ün emriyle kurulan dil bilim kurumudur. İlk kurulduğunda “Türk Dili Tetkik Cemiyeti” adı verilmiştir. Mustafa Kemal Atatürk, 1932 yılından itibaren ölümüne kadar kurumda “kurucu ve koruyucu genel başkan” sıfatıyla yer aldı. Diğer kurucuları, hepsi milletvekili olan dönemin ünlü edebiyatçıları Samih Rıfat Horozcu, Ruşen Eşref Ünaydın, Celâl Sahir Erozan ve Yakup Kadri Karaosmanoğlu’dur. Kurumun ilk başkanı Samih Rıfat Horozcu’dur. İsmet İnönü de, Atatürk’ün ölümünden sonra 25 Aralık 1973 yılına kadar “koruyucu başkan” sıfatıyla yer almıştır. TDK’yla ilgili bazı önemli tarihleri şöyle sıralayabiliriz; 26 Eylül – 5 Ekim 1932 tarihleri arasında Dolmabahçe Sarayı’nda Birinci Türk Dil Kurultayı yapıldı. Kurultayda, “lügat-ıstılah, gramer-sentaks, derleme, lenguistik-filoloji, etimoloji ve yayın” kollarında çalışma yapılması kararlaştırıldı. Sonraki kurultaylarda bu kollardan bazıları ayrıldı, bazıları tekrar birleştirildi; ancak ana çatı değiştirilmedi. İlk dil kurultayının açılış günü olan 26 Eylül, her yıl “Dil Bayramı” olarak kutlanıyor. 1934 yılında yapılan kurultayda Cemiyet’in adı “Türk Dili Araştırma Kurumu” olarak değiştirildi. 1936 yılındaki kurultayda kurumun adı “Türk Dil Kurumu” oldu. Atatürk’ün sağlığında Tarama ve Derleme Sözlüğü ile ilgili çalışmalar başladı. 1940’lı yıllarda Divânu Lügati’t-Türk ve Kutadgu Bilig adlı eserler yayınlandı. Atatürk’ün ölümünden sonra Türk aydınları arasında “Öz Türkçe” akımı tartışıldı. TDK, 1983 yılına kadar bu akımın öncülüğünü sürdürdü. TDK, 1940 yılında “kamu yararına çalışan dernekler” statüsüne alındı. 1951 yılında Demokrat Parti hükümeti tarafından kurumun ödeneği kesildi. 1982 Anayasası’nın ardından 1983 yılında TDK ve Türk Tarih Kurumu, Atatürk Kültür, Dil ve Tarih Yüksek Kurumu çatısı altında devletleştirildi ve dernek tüzel kişiliklerine son verildi. Atatürk, 1 Kasım 1936\'da Türkiye Büyük Millet Meclisi\'nin (TBMM) 5. dönem 2. yasama yılının açılış konuşmasında Türk Dil Kurumu ve Türk Tarih Kurumu hakkında şunları söyledi; “Türk Tarih Kurumu ile Türk Dil Kurumu’nun her gün yeni gerçek ufuklar açan, ciddî ve aralıksız çalışmalarını övgü ile anmak isterim. Bu iki ulusal kurumun, tarihimizin ve dilimizin, karanlıklar içinde unutulmuş derinliklerini, dünya kültüründe başlangıcı temsil ettiklerini, kabul edilebilir bilimsel belgelerle ortaya koydukça, yalnız Türk ulusunun değil, bütün bilim dünyasının ilgisini ve uyanmasını sağlayan, kutsal bir görev yapmakta olduklarını güvenle söyleyebilirim.” TDK, 1955-1983 yılları arasında çeşitli dallarda ödül verdi. Ödüller, Atatürk Kültür Dil ve Tarih Yüksek Kurumu bünyesine alındıktan sonra 1983 yılında kaldırıldı. TDK ödülü alan ünlü isimlerden bazıları şunlardır; Emre Kongar (1977 bilim ödülü), Behçet Necatigil (1964 sanat ödülü), Kemal Tahir (1968 roman ödülü), Orhan Kemal (1969 öykü ödülü), Aziz Nesin (1970 oyun ödülü), Çetin Altan (1978 deneme-eleştiri ödülü). Amacı ve Projeleri Türk Dili Tetkik Cemiyeti ilk kurulduğunda amacı, “Türk dilinin öz güzelliğini ve varsıllılığını ortaya çıkarmak, onu yeryüzü dilleri arasında değerine yaraşır yüksekliğe eriştirmek” olarak belirlenmiştir. TDK’nın günümüze yönelik amaçlarını şöyle başlıklarla sıralayabiliriz; Türkçeyi bilim, kültür, edebiyat ve öğretim dili olarak geliştirmek ve yaygınlaştırmak. Türkçenin her alanda doğru, güzel ve etkili kullanılmasına katkıda bulunmak. Türk dilinin zenginliklerinin korunup işlenerek gelecek kuşaklara aktarılmasını sağlamak. Akademik altyapıyı ve kurumsal donanımı güçlendirerek kurumun Türk dili alanındaki bilimsel yetkinliğini ortaya koymak. TDK bünyesinde, bu amaçlar çerçevesinde ilmî çalışmalar yürüten kollar bulunuyor: Türk Yazı Dilleri ve Ağızları Kolu, Türkçenin Eğitimi ve Öğretimi Kolu, Yazıt Bilimi Kolu, Sözlük Kolu, Yayın ve Tanıtma Kolu, Dil Bilimi ve Dil Bilgisi Kolu. TDK’nın devam eden projeleri de şunlardır; Türk Dili ile ilgili yabancı dillerdeki temel eserlerin tercüme edilmesi, Türkiye Türkçesi Köken Bilgisi (Etimolojik) Sözlüğü’nün hazırlanması, Türk işaret dili sisteminin oluşturulması, İşaret Dili Sözlüğü’nün hazırlanması, uzaktan öğretim yöntemiyle yabancılara Türkçe öğretimi yazılımı, farklı kültürlerin temel düşünce ve ilim eserlerinin Türkçeye çevirisi, Türk dili Belgeseli ve filmi yapımı… TDK’nin Yabancı Kelimelere Önerdiği Türkçe Karşılıklar TDK, Türkçenin yozlaşmasının önüne geçmek için Türk halkının diline yerleşmiş bazı yabancı kelimelere Türkçe karşılıklar buluyor. TDK bünyesindeki Yabancı Kelimelere Karşılıklar Çalışma Grubu tarafından vatandaşlardan gelen öneriler de dikkate alınarak bazı yabancı kelimeler Türkçeleştiriliyor. Türkçe karşılıklı kelimeler belirlenirken, kelimelerin kısaltılabilirliği, kısaltıldığına başka bir sözcüğün anlamıyla karışıp karışmadığı, telaffuzu ve toplumdaki yansıması dikkate alınıyor. TDK, kendi bünyesindeki birimleri dışında vatandaşlardan da “Türkçe karşılıklar” için öneriler alıyor. TDK’nın belirlediği Türkçe karşılıkların birçoğu tercih edilmeyebiliyor. Yani dile yerleşen yabancı kelimelerden kolay kolay vazgeçilmiyor. Bunun sebebi kültürel yozlaşmayla da bağlantılı. Yani kültürler yabancılaştıkça dil de yabancılaşıyor. Bu sebeple TDK’nin Türkçeyi zenginleştirme ve koruma mücadelesi halkın desteği ile doğru orantılı olarak değişiyor. TDK, son olarak Eylül 2017 tarihinde yaptığı bir bilgilendirme ile bazı yabancı kelimelere Türkçe karşılıklar belirlediğini açıkladı. Bu kelimeler ve Türkçe karşılıkları şunlar; petrol (yer yağı), doğalgaz (yer gazı), SMS (kısa bilgi, kısa haber), hyperloop (hız kovanı), smoothie (karsanbaç), julyen (şerit doğrama), store (sarma perde). TDK’nin bazı yabancı kelimeler için belirlediği; ancak pek kullanılmayan Türkçe karşılıkları da şöyle sırlayabiliriz; amblem (belirtke), aspiratör (emmeç), banliyö (yörekent), bypass (köprüleme), billboard (duyurumluk), çip (yonga), dart (oklama), duayen (aksakal), ekspres (özel ulak), eküri (ahırdaş), gurme (tatbilir), happy hour (indirim saatleri), kapora (güvenmelik), klip (görümsetme), light (yeğni), lot (tutam), metroseksüel (bakımlı erkek), migren (yarım baş ağrısı), navigasyon (yolbul), ordövr (yemekaltı), panik (ürkü), prime time (altın saatler), raket (vuraç), reenkarnasyon (ruh göçü), self-servis (seçal), sürpriz (şaşırtı), terör (yıldırı), tirbuşon (burgu), tribün (sekilik), türbülans (burgaç), ultrason (yansılanım), voleybol (uçan top), zapping (geçgeç). Süreli Yayınlar TDK bünyesinde bazı süreli yayınlar bulunuyor. İlk sayısı Ekim 1951 tarihinde yayınlanan “Türk Dili” adlı dil ve edebiyat dergisi, aylık bir dergidir. Altı ayda bir yayımlanan “Türk Dünyası Dil ve Edebiyat Dergisi”, uluslararası hakemli bir dergidir. Kazak, Kırgız, Tatar ve diğer Türk topluluklarının dil ve edebiyatla ilgili araştırmalarını yayımlar. “Türk Dili Araştırmaları Yıllığı – Belleten” de yılda bir kez yayımlanan ve bilimsel araştırmaları içeren bir yıllıktır. TDK, aynı zamanda yılda 30 ila 40 bilimsel eseri de yayın dünyasına kazandırmaktadır. Sözlükler TDK bünyesinde, internet sitesinde çevrimiçi olarak da faydalanılabilen 14 farklı sözlük bulunuyor: Güncel Türkçe Sözlük, Sesli Türkçe Sözlük, Büyük Türkçe Sözlük, Kişi Adları Sözlüğü Türk Lehçeleri Sözlüğü, Türkçede Batı Kökenli Kelimeler Sözlüğü, Bilim ve Sanat Terimleri Sözlüğü, Derleme Sözlüğü (Türkiye Türkçesi Ağızları Sözlüğü), Atasözleri ve Deyimler Sözlüğü, Tarama Sözlüğü, Türk İşaret Dili Sözlüğü, Uluslararası Metroloji Sözlüğü, İlaç ve Eczacılık Terimleri Sözlüğü, Hemşirelik Sözlüğü Yazım Kılavuzu, LexiQamus: Osmanlıca Kelime Çözücü. TDK Temelli Tartışmalar TDK, siyasi ve güncel konularda yapılan çeşitli tartışmaların odağında yer aldı. TDK’nın bazı önerileri tartışmalara yol açarken, bazen de asılsız iddialarla eleştiri oklarını üzerine çekti. Bunlardan bazıları şunlardır; Suriye’deki iç savaş sebebiyle yapılan haberlerde, Suriye Cumhurbaşkanı Beşar Esad’ın adı bazı basın kuruluşları tarafından “Beşar Esed” olarak kullanıldı. TDK, bunun üzerine “Beşşar Esed” adını önerdi. 2012-2013 yıllarında Mısır’daki protestoların ardından Cumhurbaşkanı Muhammed Mursi’nin görevden alınması üzerine TDK, “darbe” kelimesinin tanımını değiştirmekle eleştirildi. TDK, bir açıklama yaparak bu iddiayı yalanladı. 2013 yılındaki Gezi olaylarını eleştiren dönemin Başbakanı Recep Tayyip Erdoğan, eylemcilere “çapulcu” dedi. Bunun üzerine TDK’nın, “çapulcu” kelimesinin “Başkasının malını alan, yağma, talan eden kimse, talancı, yağmacı, plaçkacı” şeklindeki anlamını, “Düzene aykırı davranışlarda bulunan, düzeni bozan, plaçkacı” olarak değiştirdiği iddia edildi. TDK, bu iddiayı yalanladı ve değişiklik yapılmadığını açıkladı. Mart 2015 tarihinde “müsait” kelimesinin anlamının “flört etmeye hazır olan, kolayca flört edilen (kadın) olarak verilmesi uzun süren tartışmalara yol açtı. TDK, bunun üzerine, “Sözlükçünün görevi bir kelimeye kendi başına, masa başında yeni bir anlam katmak değil, yazı dilinde ve günlük dilde kullanılışlarına bakıp var olanı tespit ederek sözlüğe yansıtmaktır.” şeklinde bir açıklama yaptı. (Atatürk\'ün, el yazısı ile kaleme aldığı vasiyetindeki TDK ile ilgili bölüm...) Bunları Biliyor Musunuz? Atatürk’ün dil ile ilgili bir sözü şöyledir; “Ülkesini, yüksek istiklâlini korumasını bilen Türk milleti, dilini de yabancı diller boyunduruğundan kurtarmalıdır.” Atatürk, vasiyetinde, malvarlığının bir kısmını TDK’ya ve Türk Tarih Kurumu’na bağışladı. Günümüzde kullanılan matematiksel terimlerin hemen hemen tamamı Cumhuriyet kurulduktan sonra TDK tarafından Türkçeye kazandırılmıştır. 2017 yılı, Cumhurbaşkanı Recep Tayyip Erdoğan’ın himayesinde “Türk Dili Yılı” olarak ilan edildi. Bu amaçla, Türkçenin son yüzyılda yaşadığı kimi sorunlara ve bunların çözüm yollarına daha fazla dikkat çekmek ve duyarlılık oluşturmak için 2017 yılı boyunca bir dizi bilim, kültür ve sanat etkinlikleri düzenlendi. TDK’nın hazırladığı ve 2011 yılında 11. baskısı yayımlanan Türkçe Sözlükte 122 bin civarında kelime bulunuyor. TDK bünyesinde yaklaşık 800 yayın, 40 Bilim Kurulu üyesi ve 17 dil uzmanı bulunuyor. Bilim Kurulu üyelerinin 20’si Yüksek Öğretim Kurulu (YÖK); 20’si de Atatürk Kültür, Dil ve Tarih Yüksek Kurumu tarafından seçiliyor. Üyelerin birçoğu Türk üniversitelerinde çalışan Türkologlardır. Aynı zamanda bir araştırma kütüphanesi ve gezici kütüphaneleri bulunmaktadır. TDK’nın bünyesinde yaklaşık 80 personel bulunmaktadır. 2017 yılı bütçesi 15 milyon 778 bin liradır. Prof. Dr. Mustafa Sinan Kaçalın, 2012 yılından bu yana (2017) TDK başkanlığı görevini yürütüyor.</p>', 'Türk Dil Kurumu (TDK) Nedir? (Tarihi, Amacı)', 'Türk Dil Kurumu (TDK) Nedir? (Tarihi, Amacı)', 'Türk Dil Kurumu (TDK) Nedir? (Tarihi, Amacı)', ''),
(6, 6, 'tr', 'nasa-nedir-tarihi-programlari', 'NASA Nedir? (Tarihi, Programları)', '<p>NASA, Amerika Birleşik Devletleri’nin (ABD) uzay programlarını yürüten kurumdur. ABD’nin uzay çalışmalarına yön veren bir kurum olan NASA, “Ay’a ayak basan ilk insan” programı olan Apollo’yu başarıyla uygulamıştır. Amerika ile Rusya arasındaki uzay yarışında “uzaya ilk uydu ve ilk insan gönderme” yarışını Rusya, “Ay’a ilk insan gönderme” yarışını da Amerika kazandı. NASA, halen çok sayıda uzay programını yürütüyor ve uyguluyor. NASA, “National Aeronautics and Space Administration” ifadesinin kısaltmasıdır. Türkçesi “Ulusal Havacılık ve Uzay Dairesi” şeklindedir. Uzaya gidememe ihtimaliniz çok yüksek; ancak makalemizde NASA ve uzay çalışmaları ile ilgili birçok bilgiyi bulabilirsiniz.</p>', 'NASA Nedir? (Tarihi, Programları)', 'NASA Nedir? (Tarihi, Programları)', 'NASA Nedir? (Tarihi, Programları)', ''),
(7, 7, 'tr', 'nobel-odulu-nedir-neden-verilir', 'Nobel Ödülü Nedir, Neden Verilir?', '<p>Nobel Ödülü, dünyada bilinen en prestijli ödüldür. Ünlü kimyager ve dinamitin mucidi Alfred Nobel onuruna, servetinin faizi kullanılarak verilen ödüldür. Nobel Ödülü Nedir, Neden Verilir? Nobel Ödülü veya Nobel Ödülleri, her yıl 10 Aralık günü dağıtılan dünyanın en prestijli ödülüdür. Dinamitin mucidi Alfred Nobel onuruna, 1901 yılından bu yana insanlığa hizmet eden insanları ödüllendirmek amacıyla 6 dalda veriliyor. Türkiye’den Nobel Ödülü alan iki isim var; yazar Orhan Pamuk ve Prof. Dr. Aziz Sancar. Ödüller, gerçek veya tüzel kişilere verilebiliyor. Nobel ödülünün hikâyesi nedir, neden veriliyor hiç merak ettiniz mi? Bu soruların cevabını ve Nobel’le ilgili istatistiklerden, Nobel madalyasının özelliklerine kadar birçok bilgiyi makalemizde bulabilirsiniz. (Alfred Nobel ve vasiyetinden ilgili bölüm...) Alfred Bernard Nobel’in Vasiyeti ve Nobel Ödülleri İsveçli kimyager ve mucit Alfred B. Nobel, dinamitin mucididir. Patentini aldığı bu icadı sayesinde 20 ülkede 90 şirket aracılığı ile patlayıcı ve silah şirketleri kurdu. Birçok ülkenin patlayıcı ihtiyacını karşılamaya başladı ve devasa bir servetin sahibi oldu. Ancak kendisine yönelik “ölüm taciri”, “insanları hızla öldürmenin yolunu bularak zengin oldu” şeklindeki eleştirel haberler sebebiyle hayatının son yıllarında büyük üzüntü ve acılar yaşadı. Aslında barış yanlısı olan ve dünya barışı için çaba sarf eden Nobel, savaşları durduracağını düşündüğü buluşunun ölümcül bir silaha dönüştüğü fikri ile hüzne boğuldu. Kardeşi Ludvig Nobel öldüğünde, kendisinin öldüğünü sanan Fransız gazeteleri büyük bir hataya imza attı. Gazetelerin manşetlerinde “Ölüm taciri öldü” başlıkları atıldı. Bu olay, Nobel Ödülü fikrinin başlangıcı olarak görülüyor. Ölmeden önce 27 Kasım 1895 tarihinde kaleme aldığı vasiyetinde bu olaydan duyduğu üzüntünün izleri görülüyor. Vasiyetinde, icadı aracılığı ile dolaylı olarak kazandığı servetinin insanlığa hizmet edenlere dağıtılmasını istedi. Vasiyetinden yaklaşık 1 yıl sonra 10 Aralık 1896 tarihinde beyin kanaması geçirerek İtalya’nın San Remo kentinde hayata gözlerini yumdu. Vasiyeti, 30 Aralık 1896 tarihinde açıklandı. Ölümünden 5 yıl sonra da Nobel Ödülleri verilmeye başlandı. Nobel’in o dönemdeki servetinin günümüz değerinin 180 milyon avro olduğu belirtiliyor. Servetinin faizi, her yıl Nobel Ödülü bünyesinde para ödülü olarak dağıtılıyor. Para ödülü, her yıl faiz oranlarına göre değişiyor. 2017 yılında para ödülü 9 milyon kron (Yaklaşık 4 milyon lira) olarak belirlendi. Alfred Nobel’in vasiyeti şöyle; “Ardımdan bıraktığım gayrimenkulümün ve servetimin tamamı, aşağıdaki şekilde dağıtılacaktır. Kapital, emniyetli bir şekilde Fon\'da toplanmalıdır. Bu Fon\'un geliri her yıl insanlığa en büyük hizmeti yapan kişilere dağıtılmalıdır. Bu gelir beş ana bölüme ayrılmalı ve aşağıdaki şekilde dağıtılmalıdır. Bir kısım fizik sahasında en büyük keşfi yapan kişiye verilmelidir. Bir kısım kimya sahasında en büyük keşfi yapan kişiye verilmelidir. Bir kısmı fizyoloji ya da tıp alanında en büyük keşfi yapan kişiye verilmelidir. Bir kısım edebiyat sahasında en büyük eseri yazan kişiye verilmelidir. Bir kısım Milletlerarası barış ve kardeşlik için en büyük çalışmayı yapan kişiye verilmelidir. Fizik ve kimya konusundaki keşifler, İsveç ilim konseyince değerlendirilmelidir. Tıp konusundaki çalışmalar Stokholm\'deki Caroline Enstitüsü tarafından değerlendirilmelidir. Edebiyat ve barış konusundaki mükâfatlar İsveç Parlamentosu tarafından seçilen beş kişilik bir heyet tarafından değerlendirilmelidir. En büyük ve kesin arzum mükâfatlar adaylara dağıtılırken kesinlikle milliyet tefrika yapılmamasıdır. En mühimi, mükâfatı alacak şahıs bir İskandinavyalı da olabilir, olmayabilir de…” Nobel Vakfı Nobel Vakfı, Nobel ödüllerinin idari ve finansal yönetimi için 29 Haziran 1990 tarihinde kuruldu. Alfred Nobel’in vasiyeti üzerine kurulan özel bir kurumdur. Nobel Enstitüsü’nü harici olarak temsil eden Nobel Vakfı, Nobel Ödülleri ile ilgili etkinlikleri düzenler ve yönetir. Ayrıca Nobel Sempozyumu tertipler. Nobel’e layık görülenlere ne kadar para ödülü verileceğini de vakıf belirliyor. Nobel Ödülü Alanlar Nasıl Belirleniyor? Nobel Ödülüleri; fizik, kimya, tıp veya fizyoloji, edebiyat, ekonomi ve barış alanlarında veriliyor. İlk ödüller, 1901 yılında verildi. 1968 yılına kadar ekonomi hariç 5 dalda ödül veriliyordu. 1968 yılında ekonomi dalında da verilmesi kararlaştırıldı, ilk ekonomi ödülü 1969 yılında verildi. Ekonomi alanındaki ödüller, Sveriges Bank ve İsveç Merkez Bankası tarafından ekonomiye katkı sunan kişilere veriliyor. Ödüllerin verileceği isimleri seçen kurumlar ve komiteler var. Her kurum farklı bir dalın adayları arasından ödülü kazanan ismi veya kurumu seçiyor. İsveç Kraliyet Akademisi; fizik ve ekonomi dallarının adaylarını değerlendiriyor. İsveç Bilim Akademisi, kimya dalından ödül sahiplerini belirliyor. Karolinska Enstitüsü, fizyoloji veya tıp alanındaki adaylar arasından ödüle layık olanları seçiyor. Edebiyat dalındaki değerlendirmeleri İsveç Akademisi yapıyor. Norveç Nobel Komitesi ise, barış ödülü sahiplerini seçiyor. Nobel Ödülü’nü, belirlenen dallarda uluslararası düzeyde başarı elde etmiş kişiler veya kurumlar alabiliyor. İlgili komiteler tarafından yapılan değerlendirmeler sonucu ödülü almaya hak kazanan kişi veya kurumlara bir madalya, bir diploma ve her yıl farklı miktarlarda para ödülü veriliyor. Bir daldaki ödül, bir veya iki, hatta üç kişi arasında paylaşılabiliyor. Nobel Ödülleri, her yıl ekim ayı başında açıklanıyor; Alfred Nobel’in ölüm yıldönümü olan 10 Aralık günü de sahiplerine veriliyor.</p>', 'Nobel Ödülü Nedir, Neden Verilir?', 'Nobel Ödülü Nedir, Neden Verilir?', 'Nobel Ödülü Nedir, Neden Verilir?', ''),
(8, 8, 'tr', 'dilbilim-dilbilgisi-nedir', 'Dilbilim (Dilbilgisi) Nedir?', '<p>İnsan, dil ile anlaşır. Dil olmazsa toplum da olmaz. Bu yazıda, işi dil olan dilbilim alanını tanıtıyoruz.. Dilbilim (Dilbilgisi) Nedir? Dilbilim ve dilbilgisi, dil ile uzaktan yakından alakası olmayan - ya da alakası olmadığını sanan - insanlar için bile tanıdık bir kavramdır. Özellikle dilbilgisi, “gramer” terimiyle eş anlamı sanılır. Liselerde dil ve anlatım adındaki dersten ya da orta öğretim müfredatındaki Türkçe dersinden olsa gerek, yurdum insanının her bir ferdi dilbilgisinden, dolayısıyla gramerden haberdardır. Oysa, durum böyle değildir. Dilbilim, dilbilgisi sadece gramer yani yazımdan ibaret değildir ve de liseye kadar gösterilen dilbilgisi ile bilimsel olan yani akademide araştırma konusu olan dilbilgisi çok farklıdır. Neredeyse koca bir uçurum vardır. Biz, bu yazımızda bu koca uçurumun içini biraz da olsun dolduracak bilgiler vermeye çalışacak ve dilimiz yettiğince dilbilimi anlatmaya çalışacağız. Çok fazla tarihçeye inmeden, dilbilimini en eğlenceli şekilde anlatmaya özen göstereceğiz. Hadi başlayalım.. Dilbilim ve Dilbilgisi Nedir? Dilbilgisi, tüm dünya dillerini incelemeyi amaçlayan ve bu diller arasındaki çeşitli ilişkileri irdeleyen bir bilim dalıdır. Konusu, esas itibariyle tüm dillerdir. Dillerin neler olabileceği, dilbilimcinin bilgisine bağlıdır. Dil hakkında kuramlar üretir, belki tüm dilleri tek bir kökten geldiğine dair iddiaları inceler belki de dillerin doğuşu hakkında araştırma yapar. Her durumda, alanı genel olarak dildir ve çok büyük bir araştırma alanına sahiptir. Hatta bu yüzden, “gerçek” olduklarını iddia eden dilbilim bölümlerinin hemen hemen hepsi, dersleri İngilizce olarak vermeye özen gösterir: Mesela Boğaziçi Dilbilim, İngilizcedir. Yalnız bunun ne kadar gerekli olduğu tartışmaya açık bir konudur. Dilbilgisi, araştırmacının ait olduğu dille ilgili mümkün olan ne varsa bilmesini tahayyül eder. Bu bilgilerin arasında dilin en küçük parçası olan seslerin oluşumundan tutun da sözcüklerin metin içindeki görevleri, sözcüklerin metin dışı ya da metin içi anlamları, dildeki sözcüklerin anlam tarihçeleri, sözcük kökenleri ve daha birçok şey vardır. Bu bakımdan dilbilgisi, dilbilime göre daha az bir alanı araştırma sahası olarak belirler, lakin yine de fazla bir araştırma sahası olduğu için alt alanlara ayrılmaktadır. İşte bu alt alanlardan birisi de grammer yani dilin yazı kısmıdır. Pek çok kişi, dilin gramer ile sınırlı olduğunu düşünür ama işin aslı böyle değildir.</p>', 'Dilbilim (Dilbilgisi) Nedir?', 'Dilbilim (Dilbilgisi) Nedir?', 'Dilbilim (Dilbilgisi) Nedir?', 'aegaegae,gaegaegaegaeg'),
(49, 8, 'en', 'what-is-linguistics-grammar', 'What is Linguistics (Grammar)?', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'What is Linguistics (Grammar)?', '', '', 'what,why'),
(48, 7, 'en', 'why-nobel-prize-is-given', 'Why Nobel Prize is given?', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>', 'Why Nobel Prize is given?', '', '', 'what,why'),
(47, 6, 'en', 'what-is-nasa-history-programs', 'What is NASA? (History, Programs)', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'What is NASA? (History, Programs)', '', '', 'what,why'),
(46, 5, 'en', 'what-is-language-institution-history-purpose', 'What is Language Institution (History, Purpose)', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'What is Language Institution (History, Purpose)', '', '', 'what,why'),
(42, 1, 'en', 'where-does-it-come-from', 'Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'Where does it come from?', 'Where does it come from?', 'Where does it come from?', NULL),
(43, 2, 'en', 'where-can-i-get-some', 'Where can I get some?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod orci at elit consequat aliquam. Nam libero lectus, condimentum id velit quis, maximus efficitur lacus. Cras convallis, mi ac suscipit suscipit, ante nunc maximus leo, eu tincidunt tellus eros sit amet orci. In condimentum hendrerit metus id pretium. In sed turpis fermentum, dapibus erat non, laoreet neque. Maecenas nec sem at ante commodo scelerisque. Fusce luctus ante sagittis, fringilla mauris sed, ullamcorper risus. Phasellus porta purus vel risus condimentum, non sollicitudin mauris vehicula. Aliquam erat volutpat. Nullam orci odio, rutrum at bibendum eu, volutpat scelerisque tortor. Nullam nec hendrerit nulla, in iaculis sem.\r\n\r\nDonec dapibus nec turpis placerat rhoncus. Morbi leo sapien, consectetur a auctor quis, lacinia ut lorem. In hac habitasse platea dictumst. Nulla facilisi. Vestibulum nec elit augue. Donec tempor efficitur odio nec pretium. Nunc quis ipsum ac tellus hendrerit lobortis sed ut justo. Suspendisse a purus mattis nunc eleifend gravida. Proin non orci arcu. Mauris vestibulum condimentum quam, id dictum nisl bibendum a.\r\n\r\nUt tortor ex, interdum sit amet orci ut, iaculis vehicula justo. Sed venenatis ligula at porta imperdiet. In hac habitasse platea dictumst. In pulvinar, ligula vitae suscipit blandit, enim magna ultricies orci, a consectetur sem ante sed magna. Mauris a nisi porta orci rutrum tristique. Sed eu nisl porta metus cursus pretium non sed erat. Nulla mollis nulla eget ornare pretium. Nulla rutrum lacus vel odio mollis, nec rutrum metus placerat. Suspendisse tempus, lacus non varius imperdiet, ex purus fermentum velit, et dignissim magna nibh eget purus. Vivamus finibus scelerisque fermentum. Aenean fringilla venenatis velit, a venenatis tortor fringilla vel. Morbi orci felis, scelerisque porta scelerisque eget, finibus at leo.\r\n\r\nNulla mi augue, bibendum vitae ligula vitae, imperdiet malesuada ex. Maecenas eleifend iaculis dolor eget dapibus. Pellentesque non orci luctus, porttitor sem sed, cursus ante. Praesent a elementum arcu, eget feugiat libero. Nunc posuere aliquam ligula, vitae varius metus dignissim vel. Donec consequat ullamcorper leo, pharetra iaculis dui posuere vel. Cras neque mauris, iaculis in libero rutrum, vehicula venenatis ipsum. Nulla eget feugiat ipsum, at facilisis lorem. Cras at consectetur lacus, fringilla pharetra ante. Phasellus sit amet leo eu nunc vestibulum mattis. Sed et consectetur ipsum.\r\n\r\nPraesent tincidunt, nisl quis tempus cursus, est tellus consequat augue, et scelerisque erat massa sed ipsum. Nullam dictum pretium ipsum, ut maximus nibh iaculis vitae. Etiam auctor id turpis at suscipit. Nulla dolor ipsum, ornare eu maximus sed, pharetra at metus. Praesent venenatis, mauris quis ultricies lobortis, tortor eros scelerisque diam, facilisis tempor libero lorem a lectus. Vivamus mi lacus, cursus nec urna vitae, tincidunt vestibulum arcu. Nam vel tellus vitae sapien ultrices vestibulum sed et risus. Donec semper volutpat auctor. Aliquam turpis justo, rutrum vitae pulvinar id, tempus non leo. Praesent placerat, nisl et ornare pharetra, urna sapien pellentesque lorem, sit amet posuere ligula ipsum vel metus.', 'Where can I get some?', 'Where can I get some?', 'Where can I get some?', NULL),
(44, 3, 'en', 'the-standard-lorem-ipsum-passage', 'The standard Lorem Ipsum passage, used since the 1500s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam risus sapien, molestie ac metus at, hendrerit condimentum nisl. Mauris varius, est at molestie vehicula, arcu tortor placerat elit, eget facilisis purus ante non libero. Donec vestibulum tortor sit amet dapibus dictum. Duis ut lectus vel lorem placerat posuere. Aliquam euismod sem quam, non viverra erat aliquet id. Donec nec ipsum leo. Sed bibendum eros id orci hendrerit, sit amet mattis lorem consequat. Nam vestibulum justo at ligula pharetra dapibus. Proin lobortis eget odio at consectetur. Vestibulum eget est magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat turpis ut arcu porttitor, quis imperdiet leo auctor. Praesent sagittis odio vitae arcu posuere, mollis fermentum odio lobortis. Aliquam ipsum purus, facilisis vel dignissim faucibus, feugiat id purus. Mauris et aliquet nisi. Donec vitae vulputate orci.\r\n\r\nPellentesque est lacus, semper in malesuada eu, fringilla vel urna. Etiam feugiat est sem, sed mollis mauris bibendum sit amet. Aenean condimentum tincidunt enim ac fringilla. Donec vel elit magna. Suspendisse mi enim, suscipit et laoreet eu, gravida nec quam. Praesent nec nisi sapien. Etiam pulvinar risus sagittis est fermentum tristique. Vestibulum id ligula commodo, tincidunt lorem in, euismod nibh. Mauris et pharetra lorem, vel luctus diam. Mauris aliquam velit lacus, vitae pulvinar dolor ultrices quis. Pellentesque posuere vulputate nulla ut viverra. Sed tortor nibh, imperdiet ac auctor quis, imperdiet et ante. Sed id odio sollicitudin, ultrices nisi nec, malesuada nulla. Donec sodales volutpat mi convallis blandit. Nam efficitur at massa ut lobortis.', 'The standard Lorem Ipsum passage, used since the 1500s', 'The standard Lorem Ipsum passage, used since the 1500s', 'The standard Lorem Ipsum passage, used since the 1500s', NULL),
(45, 4, 'en', 'pellentesque-a-vulputate-turpis', 'Pellentesque a vulputate turpis', 'Pellentesque a vulputate turpis. Pellentesque tristique libero et suscipit rutrum. Quisque faucibus vehicula congue. Aliquam quis nibh iaculis, volutpat ligula at, suscipit erat. Etiam vel tincidunt enim. Maecenas sit amet iaculis dui. Etiam facilisis urna quam, in faucibus erat pulvinar quis. Donec at augue erat.\r\n\r\nNulla facilisi. Etiam fermentum scelerisque nisl, et viverra est auctor quis. Pellentesque viverra vulputate iaculis. Donec tristique dapibus consectetur. Praesent faucibus ac lectus vitae accumsan. Nam lobortis, enim at mollis consectetur, tellus orci imperdiet risus, vel egestas felis lacus in est. Cras accumsan tristique lectus vel gravida. Nam eu metus a neque accumsan mattis. Suspendisse eget auctor libero. Donec et condimentum sem, in viverra mauris. Sed ut augue consectetur risus egestas aliquet ac sed nunc. In hac habitasse platea dictumst. Integer luctus lorem dolor, eu dictum est pharetra sed. Morbi in semper libero, eu bibendum dolor. Fusce eget neque efficitur, ullamcorper nibh eget, venenatis augue. Etiam bibendum erat nec leo suscipit condimentum.\r\n\r\nVestibulum eget consectetur purus. Nulla eu quam et neque suscipit semper. Integer ullamcorper venenatis mollis. Fusce commodo eros felis, eget tincidunt eros auctor ac. Nullam id erat lorem. Etiam id lobortis lectus. Quisque semper augue quis tellus hendrerit, et fermentum mi commodo. Maecenas sollicitudin, enim a ultricies lacinia, ligula purus dapibus lacus, eu luctus enim sapien at nunc. Integer hendrerit sagittis suscipit. Nullam suscipit facilisis luctus.\r\n\r\nSed semper sit amet augue vitae fringilla. Etiam eu neque at sapien efficitur sodales. Integer porttitor ipsum sapien, a scelerisque velit egestas in. Quisque ac efficitur sem. Donec consectetur vestibulum diam a scelerisque. Etiam eget sem tempor, dictum libero at, mollis mi. Sed in viverra nulla, in venenatis leo. Donec non erat tristique, ornare sem id, pulvinar nunc. Ut non lobortis ligula. Vestibulum luctus, eros suscipit luctus condimentum, lorem enim luctus orci, ut ultrices leo risus nec dolor. Nulla cursus augue ut dignissim tempus. Nam vitae sollicitudin odio. Sed sollicitudin arcu fringilla magna lacinia convallis. Nunc faucibus dictum lectus, ac bibendum elit pellentesque malesuada.\r\n\r\nInteger sed fermentum mauris. Phasellus molestie velit sit amet diam vehicula, sed ornare mi varius. Nullam suscipit vehicula orci, nec viverra elit suscipit in. Fusce et lacus massa. Donec ac lacinia dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse rutrum velit at porta gravida. Nam nulla diam, venenatis cursus dictum ac, rutrum quis nibh. Quisque hendrerit ac ligula a pulvinar. Fusce ornare commodo velit, in posuere felis malesuada eget. Sed purus elit, tempor ut euismod ac, dapibus sit amet lectus. Duis mattis velit id euismod tempor.', 'Pellentesque a vulputate turpis', 'Pellentesque a vulputate turpis', 'Pellentesque a vulputate turpis', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mail_logs`
--

CREATE TABLE `mail_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `addresses` text COLLATE utf8mb4_unicode_ci,
  `data` text COLLATE utf8mb4_unicode_ci,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `private` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `target` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `onlyCa` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent`, `type`, `icon`, `rank`, `target`, `status`, `page`, `onlyCa`) VALUES
(2, 0, 'header', NULL, 0, 0, 'active', 'product-group/domain', 0),
(3, 0, 'header', NULL, 1, 0, 'active', 'product-group/hosting', 0),
(4, 0, 'header', NULL, 2, 0, 'active', 'product-group/server', 0),
(5, 0, 'header', NULL, 3, 0, 'active', 'product-group/software', 0),
(7, 0, 'header', NULL, 4, 0, 'active', 'product-group/hosting', 0),
(8, 0, 'header', NULL, 6, 0, 'active', '', 0),
(24, 8, 'header', NULL, 1, 0, 'active', 'pages/1', 0),
(12, 8, 'header', NULL, 0, 0, 'active', 'contact', 0),
(15, 0, 'footer', NULL, 0, 0, 'active', '', 0),
(25, 0, 'footer', NULL, 0, 0, 'inactive', 'pages/1', 0),
(94, 0, 'header', NULL, 5, 0, 'active', 'category/194', 0),
(35, 7, 'header', NULL, 1, 0, 'active', 'product-group/international-sms', 0),
(34, 7, 'header', NULL, 0, 0, 'active', 'product-group/sms', 0),
(87, 15, 'footer', NULL, 1, 0, 'active', 'references', 0),
(39, 15, 'footer', NULL, 7, 0, 'active', 'contract1', 0),
(40, 15, 'footer', NULL, 6, 0, 'active', 'contract2', 0),
(41, 15, 'footer', NULL, 0, 0, 'active', 'contact', 0),
(42, 15, 'footer', NULL, 4, 0, 'active', 'kbase', 0),
(43, 0, 'footer', NULL, 1, 0, 'active', '', 0),
(46, 43, 'footer', NULL, 0, 0, 'active', '', 0),
(48, 43, 'footer', NULL, 1, 0, 'active', '', 0),
(49, 43, 'footer', NULL, 2, 0, 'active', '', 0),
(50, 43, 'footer', NULL, 3, 0, 'active', '', 0),
(51, 43, 'footer', NULL, 4, 0, 'active', '', 0),
(52, 43, 'footer', NULL, 5, 0, 'active', '', 0),
(53, 43, 'footer', NULL, 6, 0, 'active', '', 0),
(54, 43, 'footer', NULL, 7, 0, 'active', '', 0),
(55, 0, 'footer', NULL, 3, 0, 'active', '', 0),
(56, 55, 'footer', NULL, 0, 0, 'active', '', 0),
(57, 55, 'footer', NULL, 1, 0, 'active', '', 0),
(58, 55, 'footer', NULL, 2, 0, 'active', '', 0),
(59, 55, 'footer', NULL, 5, 0, 'active', '', 0),
(60, 55, 'footer', NULL, 6, 0, 'active', '', 0),
(61, 55, 'footer', NULL, 7, 0, 'active', '', 0),
(62, 55, 'footer', NULL, 4, 0, 'active', '', 0),
(64, 55, 'footer', NULL, 3, 0, 'active', '', 0),
(65, 0, 'footer', NULL, 2, 0, 'active', '', 0),
(66, 65, 'footer', NULL, 3, 0, 'active', '', 0),
(67, 65, 'footer', NULL, 0, 0, 'active', '', 0),
(68, 65, 'footer', NULL, 1, 0, 'active', '', 0),
(69, 65, 'footer', NULL, 2, 0, 'active', '', 0),
(70, 65, 'footer', NULL, 6, 0, 'active', '', 0),
(71, 65, 'footer', NULL, 4, 0, 'active', '', 0),
(72, 65, 'footer', NULL, 5, 0, 'active', '', 0),
(73, 65, 'footer', NULL, 7, 0, 'active', '', 0),
(74, 0, 'pages-sidebar', NULL, 0, 0, 'active', 'pages/1', 0),
(76, 0, 'pages-sidebar', NULL, 7, 0, 'active', 'contract2', 0),
(77, 0, 'pages-sidebar', NULL, 6, 0, 'active', 'contract1', 0),
(79, 0, 'pages-sidebar', NULL, 2, 0, 'active', 'kbase', 0),
(81, 8, 'header', NULL, 3, 0, 'active', 'kbase', 0),
(86, 8, 'header', NULL, 5, 0, 'active', 'news', 0),
(83, 8, 'header', NULL, 2, 0, 'active', 'references', 0),
(84, 8, 'header', NULL, 4, 0, 'active', 'articles', 0),
(88, 15, 'footer', NULL, 2, 0, 'active', 'news', 0),
(89, 15, 'footer', NULL, 3, 0, 'active', 'articles', 0),
(90, 15, 'footer', NULL, 5, 0, 'active', 'license', 0),
(91, 0, 'pages-sidebar', NULL, 4, 0, 'active', 'news', 0),
(92, 0, 'pages-sidebar', NULL, 3, 0, 'active', 'articles', 0),
(93, 0, 'pages-sidebar', NULL, 1, 0, 'active', 'contact', 0),
(95, 0, 'clientArea', '', 0, 0, 'inactive', 'ca-dashboard', 1),
(96, 0, 'clientArea', '', 0, 0, 'active', '', 0),
(97, 96, 'clientArea', NULL, 0, 0, 'active', 'product-group/domain', 0),
(98, 96, 'clientArea', NULL, 1, 0, 'active', 'product-group/hosting', 0),
(99, 96, 'clientArea', NULL, 2, 0, 'active', 'product-group/server', 0),
(100, 0, 'clientArea', '', 10, 0, 'active', 'kbase', 0),
(101, 0, 'clientArea', 'fa fa-phone', 1, 0, 'inactive', 'contact', 0),
(102, 0, 'clientArea', '', 2, 0, 'active', 'create-account', 0),
(103, 0, 'clientArea', '', 1, 0, 'active', 'login-account', 0),
(104, 0, 'clientArea', '', 6, 0, 'active', 'ca-tickets', 1),
(105, 0, 'clientArea', '', 3, 0, 'active', 'ca-orders', 1),
(106, 0, 'clientArea', '', 4, 0, 'active', 'ca-domains', 1),
(108, 109, 'clientArea', '', 1, 0, 'active', 'ca-invoices', 1),
(109, 0, 'clientArea', '', 7, 0, 'active', 'ca-ac-information', 1),
(110, 109, 'clientArea', '', 2, 0, 'active', 'ca-messages', 1),
(111, 0, 'clientArea', 'fa fa-star', 5, 0, 'active', 'ca-addons', 1),
(112, 96, 'clientArea', '', 3, 0, 'active', 'product-group/software', 0),
(113, 96, 'clientArea', '', 4, 0, 'active', 'product-group/sms', 0),
(114, 96, 'clientArea', '', 5, 0, 'active', 'product-group/international-sms', 0),
(116, 109, 'clientArea', '', 0, 0, 'active', 'ca-ac-information', 1),
(117, 0, 'clientArea', '', 8, 0, 'active', 'ca-affiliate', 0),
(118, 0, 'clientArea', '', 9, 0, 'active', 'ca-reseller', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menus_lang`
--

CREATE TABLE `menus_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus_lang`
--

INSERT INTO `menus_lang` (`id`, `owner_id`, `lang`, `title`, `link`, `extra`) VALUES
(2, 2, 'tr', 'Alan Adı', '', ''),
(3, 3, 'tr', 'Web Hosting', '', '{\"mega\":{\"header_1\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/megamenubg1.jpg);background-size:100% auto;\\\">\\n<div class=\\\"padding20\\\">\\n\\n<div align=\\\"center\\\">\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}tr\\/kategori\\/hosting\\/ekonomik-ssd-hosting\\\">\\n<i class=\\\"fa fa-cloud\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Ekonomik SSD Hosting<\\/h5>\\nYıllık sadece <strong>39 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"ribbon\\\"><div>Popüler<\\/div><\\/div>\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}tr\\/kategori\\/hosting\\/profesyonel-ssd-hosting\\\">\\n<i class=\\\"fa fa-briefcase\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Profesyonel SSD Hosting<\\/h5>\\nYıllık sadece <strong>49 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}tr\\/kategori\\/hosting\\/bayi-reseller-hosting\\\">\\n<i class=\\\"fa fa-trophy\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Reseller Hosting<\\/h5>\\nAylık sadece <strong>15 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n<h4 style=\\\"font-weight: 400;\\n    margin-top: 20px;\\n    margin-bottom: 10px;\\n    color: #607d8a;\\\">Tüm web hosting paketlerimizde SSL sertifikası <strong>ÜCRETSİZ<\\/strong> sağlanmaktadır.<\\/h4>\\n<\\/div>\\n\\n<\\/div><\\/div>\",\"header_2\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/hostingbg.jpg);background-position: center center;    background-size: 100%;\\\">\\n<div id=\\\"wrapper\\\" style=\\\"position:relative;\\\">\\n<div class=\\\"padding30\\\">\\n\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}tr\\/kategori\\/ekonomik-ssd-hosting\\\">\\n<i class=\\\"fa fa-cloud\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Ekonomik SSD Hosting<\\/h5>\\nYıllık sadece <strong>39 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"ribbon\\\"><div>Popüler<\\/div><\\/div>\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}tr\\/kategori\\/profesyonel-ssd-hosting\\\">\\n<i class=\\\"fa fa-briefcase\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Profesyonel SSD Hosting<\\/h5>\\nYıllık sadece <strong>49 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}tr\\/kategori\\/bayi-reseller-hosting\\\">\\n<i class=\\\"fa fa-trophy\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Reseller Hosting<\\/h5>\\nAylık sadece <strong>19 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n<\\/div>\\n\\n<div class=\\\"digerhmzinfo\\\">\\n<span class=\\\"digerhzmucgen\\\"><\\/span>\\n<h5><strong>Ücretsiz SSL Sertifikası<\\/strong><\\/h5>\\n<p>Tüm web hosting paketlerimizde SSL sertifikası ücretsiz tanımlanmaktadır.<\\/p>\\n <a href=\\\"#\\\" id=\\\"freesslinfobtn\\\">İncele<\\/a>\\n\\n<\\/div>\\n<\\/div>\\n<\\/div>\"}}'),
(4, 4, 'tr', 'Sunucu', '', '{\"mega\":{\"header_1\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/megamenubg2.jpg);background-size:100% auto;\\\">\\n<div class=\\\"padding20\\\">\\n<div align=\\\"center\\\">\\n<div id=\\\"megamenuservice\\\" style=\\\"width:47%\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}tr\\/kategori\\/ssd-sanal-sunucular-vds-vps\\\">\\n<i class=\\\"fa fa-cloud\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">VPS\\/VDS<\\/h5>\\nAylık sadece <strong>39 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\" style=\\\"width:47%\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}tr\\/kategori\\/fiziksel-sunucular-dedicated\\\">\\n<i class=\\\"fa fa-server\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Fiziksel Sunucular<\\/h5>\\nAylık sadece <strong>69 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n\\n<h4 style=\\\"font-weight: 400;\\n    margin-top: 20px;\\n    margin-bottom: 10px;\\n    \\\">Full Terformans, Tam Donanım, Her Bütçeye Uygun Sunucu Kiralama Çözümleri.<\\/h4>\\n<\\/div>\\n<\\/div>\\n<\\/div>\",\"header_2\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/megamenu2bg.jpg);background-size:100% auto;\\\">\\n<div id=\\\"wrapper\\\" style=\\\"position:relative;\\\">\\n<div class=\\\"padding30\\\">\\n\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"#\\\">\\n<i class=\\\"fa fa-cloud\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">VPS\\/VDS<\\/h5>\\nAylık sadece <strong>49 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"ribbon\\\"><div>Popüler<\\/div><\\/div>\\n<div class=\\\"padding20\\\">\\n<a href=\\\"#\\\">\\n<i class=\\\"fa fa-briefcase\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Fiziksel Sunucular<\\/h5>\\nAylık sadece <strong>69 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"#\\\">\\n<i class=\\\"fa fa-trophy\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Co-Location<\\/h5>\\nAylık sadece <strong>129 TL<\\/strong>\'den başlayan fiyatlarla.<\\/a>\\n<\\/div>\\n<\\/div>\\n<\\/div>\\n\\n<div class=\\\"digerhmzinfo\\\">\\n                                <span class=\\\"digerhzmucgen\\\"><\\/span>\\n                                <h5><strong>Sunucu Kiralama<\\/strong><\\/h5>\\n                                <p>Her bütçeye uygun, istenilen lokasyonda, full performans, tam donanımlı sunucular.<\\/p>\\n                                <a href=\\\"#\\\" id=\\\"freesslinfobtn\\\">İncele<\\/a>\\n\\n<\\/div>\\n<\\/div>\\n<\\/div>\"}}'),
(5, 5, 'tr', 'Yazılım', 'yazilimlar', ''),
(7, 7, 'tr', 'Sms', '', '{\"mega\":{\"header_1\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/megamenubg3.jpg);background-size:100% auto;\\\">\\n<div class=\\\"padding20\\\">\\n\\n                                <center>\\n                                    <div id=\\\"megamenuservice\\\" style=\\\"width:44%\\\">\\n                                        <div class=\\\"padding20\\\">\\n                                            <a href=\\\"{SITE_URL}uluslararasi-sms\\\">\\n                                                <i class=\\\"fa fa-globe\\\" aria-hidden=\\\"true\\\"><\\/i>\\n                                                <h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Uluslararası Toplu SMS<\\/h5>\\n                                                Uluslararası toplu sms servisimiz ile tüm dünyaya en uygun fiyatlarla sms gönderin.<\\/a>\\n                                        <\\/div>\\n                                    <\\/div>\\n\\n                                    <div id=\\\"megamenuservice\\\" style=\\\"width:44%\\\">\\n                                        <div class=\\\"padding20\\\">\\n                                            <a href=\\\"{SITE_URL}kategori\\/sms\\\">\\n                                                <img src=\\\"https:\\/\\/image.flaticon.com\\/icons\\/svg\\/202\\/202984.svg\\\" style=\\\"height:50px\\\">\\n                                                <h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Türkiye Toplu SMS<\\/h5>\\n                                                Başlıklı, Anında Teslim toplu sms hizmeti ile, Tüm Türkiye\'ye sms gönderin.<\\/a>\\n                                        <\\/div>\\n                                    <\\/div>\\n\\n\\n                                    <h4 style=\\\"font-weight: 400;    margin-top: 20px;    margin-bottom: 10px;\\\">Taahhütsüz ve Süresiz \\/ Başlıklı \\/ Anında Teslim toplu sms hizmetlerimizden yararlanın.\\n                                    <\\/h4>\\n                                <\\/center>\\n\\n                            <\\/div>\\n<\\/div>\",\"header_2\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/megamenu-theme3bg.jpg);background-position: center center;    background-size: 100%;\\\">\\n<div id=\\\"wrapper\\\" style=\\\"position:relative;\\\">\\n\\n\\n<div class=\\\"padding30\\\">\\n\\n\\n<div id=\\\"megamenuservice\\\" style=\\\"width:36%;\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}uluslararasi-sms\\\">\\n<i class=\\\"fa fa-globe\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Uluslararası Toplu SMS<\\/h5>\\nUluslararası toplu sms servisimiz ile tüm dünyaya en uygun fiyatlarla sms gönderin.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\" style=\\\"width:36%;\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}kategori\\/sms\\\">\\n<img src=\\\"https:\\/\\/image.flaticon.com\\/icons\\/svg\\/202\\/202984.svg\\\" style=\\\"height:50px\\\">\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Türkiye Toplu SMS<\\/h5>\\nUluslararası toplu sms servisimiz ile tüm dünyaya en uygun fiyatlarla sms gönderin.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n\\n<\\/div>\\n\\n<div class=\\\"digerhmzinfo\\\">\\n                                <span class=\\\"digerhzmucgen\\\"><\\/span>\\n                                <h5><strong>Toplu SMS Hizmetleri<\\/strong><\\/h5>\\n                                <p>- Başlıklı SMS Gönderimi,<br>\\n- Hızlı SMS Teslimi,<br>\\n- Gelişmiş Api Dökümantasyon,<br>\\n- İletilmeyen SMS\'ler İade,<br>\\n- Ekonomik Fiyatlar.<\\/p>\\n                                <a href=\\\"#\\\" id=\\\"freesslinfobtn\\\">İncele<\\/a>\\n\\n<\\/div>\\n<\\/div>\\n<\\/div>\"}}'),
(8, 8, 'tr', 'Kurumsal', '', '{\"mega\":{\"header_2\":\"<div id=\\\"corporatemenu\\\" style=\\\"background-image: url({TEMPLATE_URL}images\\/corporatebg.jpg); \\\">\\n<div id=\\\"wrapper\\\" style=\\\"position:relative;\\\">\\n<div class=\\\"padding30\\\">\\n\\n\\n<div id=\\\"kurumsalmenulinks\\\" style=\\\"float:right;\\\">\\n                                    <h3><span>Müşteri Hizmetleri<\\/span><br>0850 123 45 67<\\/h3>\\n                                    <h3><span>E-Posta<\\/span><br>info@example.com<\\/h3>\\n                                <\\/div>\\n\\n                                                                                <div id=\\\"kurumsalmenulinks\\\">\\n                                                    <h4>Diğer Sayfalar<\\/h4>\\n                                                    <a href=\\\"{SITE_URL}urunler\\/is-ortakligi-bayilik\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> İş Ortaklığı (Bayilik)<\\/a><a href=\\\"{SITE_URL}lisans-dogrula\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Lisans Sorgulama<\\/a><a href=\\\"{SITE_URL}hizmet-ve-kullanim-sozlesmesi\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Hizmet ve Kullanım Sözleşmesi<\\/a><a href=\\\"{SITE_URL}kisisel-veriler-ve-genel-gizlilik-sozlesmesi\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Gizlilik Sözleşmesi<\\/a><a href=\\\"{SITE_URL}cerez-politikasi.html\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Çerez Politikası<\\/a>                                                <\\/div>\\n                                                                                                <div id=\\\"kurumsalmenulinks\\\">\\n                                                    <h4>Destek ve Yardım<\\/h4>\\n                                                    <a href=\\\"{SITE_URL}bilgi-bankasi\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Bilgi Bankası<\\/a><a href=\\\"{SITE_URL}hesabim\\/destek-talebi-olustur\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Destek Talebi Oluştur<\\/a><a href=\\\"{SITE_URL}yazilimlar#scriptsss\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Sıkça Sorulan Sorular<\\/a><a href=\\\"{SITE_URL}yazilar\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Blog\'tan Yazılar<\\/a>                                                <\\/div>\\n                                                                                                <div id=\\\"kurumsalmenulinks\\\">\\n                                                    <h4>Kurumsal Bilgiler<\\/h4>\\n                                                    <a href=\\\"{SITE_URL}iletisim\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> İletişim ve Kurumsal Bilgiler<\\/a><a href=\\\"{SITE_URL}hakkimizda.html\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Hakkımızda<\\/a><a href=\\\"{SITE_URL}referanslar\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Referanslar<\\/a> \\n                                                    <a href=\\\"{SITE_URL}haberler\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Haber ve Duyurular<\\/a>                                              <\\/div>\\n\\n\\n<div class=\\\"clear\\\"><\\/div>\\n<\\/div>\\n<\\/div>\"}}'),
(56, 24, 'tr', 'Hakkımızda', '', NULL),
(57, 25, 'tr', 'Hakkımızda', '', NULL),
(12, 12, 'tr', 'İletişim', 'iletisim', NULL),
(15, 15, 'tr', 'Site içi Bağlantılar', '', NULL),
(80, 48, 'tr', 'SEO Hosting', '', NULL),
(66, 34, 'tr', 'Toplu SMS', 'kategori/sms', NULL),
(67, 35, 'tr', 'Uluslararası Toplu  SMS', 'uluslararasi-sms', NULL),
(319, 89, 'tr', 'Blog\'tan Yazılar', '', NULL),
(317, 88, 'tr', 'Haber ve Duyurular', '', NULL),
(330, 94, 'en', 'Seo', '', ''),
(71, 39, 'tr', 'Hizmet Sözleşmesi', '#', NULL),
(72, 40, 'tr', 'Gizlilik Sözleşmesi', '#', NULL),
(73, 41, 'tr', 'Bize Ulaşın', '#', NULL),
(74, 42, 'tr', 'Bilgi Bankası', '#', NULL),
(75, 43, 'tr', 'Web Hosting', '', NULL),
(78, 46, 'tr', 'Sınırsız Web Hosting', '', NULL),
(87, 55, 'tr', 'Alan Adı Tescil', '', NULL),
(81, 49, 'tr', 'Wordpress Hosting', '', NULL),
(82, 50, 'tr', 'Bireysel Paketler', '', NULL),
(83, 51, 'tr', 'Kurumsal Paketler', '', NULL),
(84, 52, 'tr', 'WordPress Hosting', '', NULL),
(85, 53, 'tr', 'Joomla Hosting', '', NULL),
(86, 54, 'tr', 'OpenCart Hosting', '', NULL),
(88, 56, 'tr', '.com Alan Adı Tescil', '', NULL),
(89, 57, 'tr', '.net Alan Adı Tescil', '', NULL),
(90, 58, 'tr', '.org Alan Adı Tescil', '', NULL),
(91, 59, 'tr', '.pro Alan Adı Tescil', '', NULL),
(92, 60, 'tr', '.site Alan Adı Tescil', '', NULL),
(93, 61, 'tr', '.mobi Alan Adı Tescil', '', NULL),
(94, 62, 'tr', '.co  Alan Adı Tescil', '', NULL),
(97, 65, 'tr', 'Sunucu Hizmetleri', '', NULL),
(96, 64, 'tr', '.in Alan Adı Tescil', '', NULL),
(98, 66, 'tr', 'Türkiye Kiralık Sunucu', '', NULL),
(99, 67, 'tr', 'Almanya Kiralık Sunucu', '', NULL),
(100, 68, 'tr', 'Fransa Kiralık Sunucu', '', NULL),
(101, 69, 'tr', 'ABD Kiralık Sunucu', '', NULL),
(102, 70, 'tr', 'Türkiye VPS/VDS Sunucu', '', NULL),
(103, 71, 'tr', 'Almanya VPS/VDS Sunucu', '', NULL),
(104, 72, 'tr', 'Fransa VPS/VDS Sunucu', '', NULL),
(105, 73, 'tr', 'ABD VPS/VDS Sunucu', '', NULL),
(106, 74, 'tr', 'Hakkımızda', '', NULL),
(326, 92, 'en', 'Articles from Blog', '', NULL),
(108, 76, 'tr', 'Gizlilik Sözleşmesi', '', NULL),
(109, 77, 'tr', 'Hizmet Sözleşmesi', '', NULL),
(111, 79, 'tr', 'Bilgi Bankası', '', NULL),
(324, 91, 'en', 'News and Announcements', '', NULL),
(113, 81, 'tr', 'Bilgi Bankası', '', NULL),
(314, 86, 'en', 'News from Us', '', NULL),
(115, 83, 'tr', 'Referanslar', '', NULL),
(116, 84, 'tr', 'Blog\'tan Yazılar', '', NULL),
(321, 90, 'tr', 'Lisans Doğrulama', '', NULL),
(306, 79, 'en', 'Knowledge Base', '', NULL),
(304, 77, 'en', 'Service Agreement', '', NULL),
(303, 76, 'en', 'Privacy Policy', '', NULL),
(325, 92, 'tr', 'Yazılar', '', NULL),
(301, 74, 'en', 'About Us', '', NULL),
(327, 93, 'tr', 'Bize Ulaşın', '', NULL),
(300, 73, 'en', 'US VPS / VDS Server', '', NULL),
(299, 72, 'en', 'France VPS / VDS Server', '', NULL),
(298, 71, 'en', 'Germany VPS / VDS Server', '', NULL),
(297, 70, 'en', 'Turkey VPS / VDS Server', '', NULL),
(295, 68, 'en', 'France Dedicated Server', '', NULL),
(296, 69, 'en', 'US Dedicated Server', '', NULL),
(294, 67, 'en', 'Germany Dedicated Server', '', NULL),
(293, 66, 'en', 'Turkey Dedicated Servers', '', NULL),
(292, 64, 'en', '.in Domain Registration', '', NULL),
(291, 65, 'en', 'Server Services', '', NULL),
(290, 62, 'en', '.co Domain Registration', '', NULL),
(289, 61, 'en', '.pro Domain Registration', '', NULL),
(287, 59, 'en', '.site Domain Registration', '', NULL),
(288, 60, 'en', '.mobi Domain Registration', '', NULL),
(285, 57, 'en', '.net Domain Registration', '', NULL),
(286, 58, 'en', '.org Domain Registration', '', NULL),
(284, 56, 'en', '.com Domain Registration', '', NULL),
(283, 54, 'en', 'OpenCart Hosting', '', NULL),
(282, 53, 'en', 'Joomla Hosting', '', NULL),
(281, 52, 'en', 'WordPress Hosting', '', NULL),
(280, 51, 'en', 'Business Packages', '', NULL),
(279, 50, 'en', 'Individual Packages', '', NULL),
(278, 49, 'en', 'Wordpress Hosting', '', NULL),
(276, 55, 'en', 'Domain Name Registry', '', NULL),
(275, 46, 'en', 'Unlimited Web Hosting', '', NULL),
(272, 41, 'en', 'Contact Us', '#', NULL),
(273, 42, 'en', 'Knowledge Base', '#', NULL),
(274, 43, 'en', 'Web Hosting', '', NULL),
(271, 40, 'en', 'Privacy Policy', '#', NULL),
(315, 87, 'tr', 'Referanslar', '', NULL),
(329, 94, 'tr', 'Seo', '', ''),
(270, 39, 'en', 'Service Agreement', '#', NULL),
(318, 88, 'en', 'News from Us', '', NULL),
(316, 87, 'en', 'Our References', '', NULL),
(266, 35, 'en', 'International Bulk SMS', 'uluslararasi-sms', NULL),
(265, 34, 'en', 'Bulk SMS', 'kategori/sms', NULL),
(264, 48, 'en', 'SEO Hosting', '', NULL),
(262, 15, 'en', 'Other Links', '', NULL),
(259, 12, 'en', 'Contact Us', 'contact', NULL),
(322, 90, 'en', 'License Verification', '', NULL),
(257, 25, 'en', 'About Us', '', NULL),
(256, 24, 'en', 'Abous Us', '', NULL),
(255, 8, 'en', 'Corporate', '', '{\"mega\":{\"header_2\":\"<div id=\\\"corporatemenu\\\" style=\\\"background-image: url({TEMPLATE_URL}images\\/corporatebg.jpg); \\\">\\n<div id=\\\"wrapper\\\" style=\\\"position:relative;\\\">\\n<div class=\\\"padding30\\\">\\n\\n\\n<div id=\\\"kurumsalmenulinks\\\" style=\\\"float:right;\\\">\\n                                    <h3><span>Customer Service<\\/span><br>+1 732-776-6536<\\/h3>\\n                                    <h3><span>E-Mail<\\/span><br>info@example.com<\\/h3>\\n                                <\\/div>\\n\\n                                                                                <div id=\\\"kurumsalmenulinks\\\">\\n                                                    <h4>Other Pages<\\/h4>\\n                                                    <a href=\\\"{SITE_URL}en\\/category\\/partnership-dealership\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Partnership (Dealership)<\\/a>\\n                                                    <a href=\\\"{SITE_URL}en\\/license-verification\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> License Verification<\\/a>\\n                                                    <a href=\\\"{SITE_URL}en\\/service-and-use-agreement\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Service and Use Agreement<\\/a>\\n                                                    <a href=\\\"{SITE_URL}en\\/personal-data-and-general-privacy-agreement\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Privacy Policy<\\/a>\\n                                                    <a href=\\\"{SITE_URL}en\\/cookie-policy.html\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Cookie Policy<\\/a>                                                <\\/div>\\n                                                                                                <div id=\\\"kurumsalmenulinks\\\">\\n                                                    <h4>Support and Help<\\/h4>\\n                                                    <a href=\\\"{SITE_URL}en\\/knowledgebase\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Knowledge Base<\\/a>\\n                                                    <a href=\\\"{SITE_URL}en\\/myaccount\\/create-support-requests\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Create Support Request<\\/a>\\n                                                    <a href=\\\"{SITE_URL}en\\/softwares#scriptsss\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Frequently Asked Questions<\\/a><a href=\\\"{SITE_URL}en\\/articles\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Recent Posts from Blog<\\/a>                                                <\\/div>\\n                                                                                                <div id=\\\"kurumsalmenulinks\\\">\\n                                                    <h4>Corporate Information<\\/h4>\\n                                                    <a href=\\\"{SITE_URL}en\\/contact\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Contact Us<\\/a><a href=\\\"{SITE_URL}en\\/about-us.html\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> About Us<\\/a><a href=\\\"{SITE_URL}en\\/references\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> Our References<\\/a> \\n                                                    <a href=\\\"{SITE_URL}en\\/news\\\"><i class=\\\"fa fa-angle-right\\\" aria-hidden=\\\"true\\\"><\\/i> News and Announcements<\\/a>                                            <\\/div>\\n\\n\\n<div class=\\\"clear\\\"><\\/div>\\n<\\/div>\\n<\\/div>\"}}'),
(254, 7, 'en', 'Sms', '', ''),
(252, 5, 'en', 'Software', 'yazilimlar', ''),
(251, 4, 'en', 'Servers', '', '{\"mega\":{\"header_1\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/megamenubg2.jpg);background-size:100% auto;\\\">\\n<div class=\\\"padding20\\\">\\n<div align=\\\"center\\\">\\n<div id=\\\"megamenuservice\\\" style=\\\"width:47%\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}en\\/category\\/ssd-virtual-servers-vds-vps\\\">\\n<i class=\\\"fa fa-cloud\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">VPS\\/VDS<\\/h5>\\nPrices starting from only <strong>$39<\\/strong> per month.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\" style=\\\"width:47%\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}en\\/category\\/dedicated-servers\\\">\\n<i class=\\\"fa fa-server\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Dedicated Server<\\/h5>\\nPrices starting from only <strong>$59<\\/strong> per month.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n\\n<h4 style=\\\"font-weight: 400;\\n    margin-top: 20px;\\n    margin-bottom: 10px;\\n    \\\">Full performance, full hardware, server leasing solutions for every budget.<\\/h4>\\n<\\/div>\\n<\\/div>\\n<\\/div>\",\"header_2\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/megamenu2bg.jpg);background-position: center center;    background-size: 100%;\\\">\\n\\n<div id=\\\"wrapper\\\" style=\\\"position:relative;\\\">\\n<div class=\\\"padding30\\\">\\n\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"#\\\">\\n<i class=\\\"fa fa-cloud\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">VPS\\/VDS<\\/h5>\\nPrices starting from only <strong>$39<\\/strong> per month.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"ribbon\\\"><div>Popular<\\/div><\\/div>\\n<div class=\\\"padding20\\\">\\n<a href=\\\"#\\\">\\n<i class=\\\"fa fa-server\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Dedicated Server<\\/h5>\\nPrices starting from only <strong>$49<\\/strong> per month.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"#\\\">\\n<i class=\\\"fa fa-trophy\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Co-Location<\\/h5>\\nPrices starting from only <strong>$149<\\/strong> per month.<\\/a>\\n<\\/div>\\n<\\/div>\\n<\\/div>\\n\\n<div class=\\\"digerhmzinfo\\\">\\n                                <span class=\\\"digerhzmucgen\\\"><\\/span>\\n                                <h5><strong>Server Leasing<\\/strong><\\/h5>\\n                                <p>Full performance, fully equipped servers for every budget.<\\/p>\\n                                <a href=\\\"#\\\" id=\\\"freesslinfobtn\\\">Detail<\\/a>\\n\\n<\\/div>\\n<\\/div>\\n<\\/div>\"}}'),
(250, 3, 'en', 'Web Hosting', '', '{\"mega\":{\"header_1\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/megamenubg1.jpg);background-size:100% auto;\\\">\\n<div class=\\\"padding20\\\">\\n\\n<div align=\\\"center\\\">\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}en\\/category\\/hosting\\/cheap-ssd-hosting\\\">\\n<i class=\\\"fa fa-cloud\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Cheap SSD Hosting<\\/h5>\\nPrices starting from only <strong>$39<\\/strong> per year.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"ribbon\\\"><div>Popular<\\/div><\\/div>\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}en\\/category\\/hosting\\/professional-ssd-hosting\\\">\\n<i class=\\\"fa fa-briefcase\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Professional SSD Hosting<\\/h5>\\nPrices starting from only <strong>$49<\\/strong> per year.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}en\\/category\\/hosting\\/reseller-hosting\\\">\\n<i class=\\\"fa fa-trophy\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:16px;font-weight:600;margin: 12px 0px;\\\">Reseller Hosting<\\/h5>\\nPrices starting from only <strong>$9<\\/strong> per month.<\\/a>\\n<\\/div>\\n<\\/div>\\n<h4 style=\\\"font-weight: 400;\\n    margin-top: 20px;\\n    margin-bottom: 10px;\\n    color: #607d8a;\\\">SSL certificate is provided <strong>FREE<\\/strong> of charge in all our web hosting packages.<\\/h4>\\n<\\/div>\\n\\n<\\/div><\\/div>\",\"header_2\":\"<div style=\\\"background-image: url({TEMPLATE_URL}images\\/hostingbg.jpg);background-position: center center;    background-size: 100%;\\\">\\n<div id=\\\"wrapper\\\" style=\\\"position:relative;\\\">\\n<div class=\\\"padding30\\\">\\n\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}en\\/category\\/hosting\\/cheap-ssd-hosting\\\">\\n<i class=\\\"fa fa-cloud\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Cheap SSD Hosting<\\/h5>\\nPrices starting from only <strong>$39<\\/strong> per year.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"ribbon\\\"><div>Popular<\\/div><\\/div>\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}en\\/category\\/hosting\\/professional-ssd-hosting\\\">\\n<i class=\\\"fa fa-briefcase\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Professional SSD Hosting<\\/h5>\\nPrices starting from only <strong>$49<\\/strong> per year.<\\/a>\\n<\\/div>\\n<\\/div>\\n\\n<div id=\\\"megamenuservice\\\">\\n<div class=\\\"padding20\\\">\\n<a href=\\\"{SITE_URL}en\\/category\\/hosting\\/reseller-hosting\\\">\\n<i class=\\\"fa fa-trophy\\\" aria-hidden=\\\"true\\\"><\\/i>\\n<h5 style=\\\"font-size:15px;font-weight:600;margin: 12px 0px;\\\">Reseller Hosting<\\/h5>\\nPrices starting from only <strong>$19<\\/strong> per month.<\\/a>\\n<\\/div>\\n<\\/div>\\n<\\/div>\\n\\n<div class=\\\"digerhmzinfo\\\">\\n<span class=\\\"digerhzmucgen\\\"><\\/span>\\n<h5><strong>Free SSL Certificate<\\/strong><\\/h5>\\n<p>In all our web hosting packages, the SSL certificate is defined free of charge.<\\/p>\\n <a href=\\\"#\\\" id=\\\"freesslinfobtn\\\">Detail<\\/a>\\n\\n<\\/div>\\n<\\/div>\\n<\\/div>\"}}'),
(249, 2, 'en', 'Domain', 'domain', ''),
(323, 91, 'tr', 'Haber ve Duyurular', '', NULL),
(308, 81, 'en', 'Knowledge Base', 'bilgi-bankasi', NULL),
(313, 86, 'tr', 'Haber ve Duyurular', '', NULL),
(310, 83, 'en', 'Our References', 'referanslar', NULL),
(311, 84, 'en', 'Articles from Blog', 'yazilar', NULL),
(320, 89, 'en', 'Articles from Blog', '', NULL),
(328, 93, 'en', 'Contact Us', '', NULL),
(390, 95, 'tr', 'Anasayfa', '', ''),
(391, 95, 'en', 'Homepage', '', ''),
(392, 96, 'tr', 'Ürün Satın Al', '', ''),
(393, 96, 'en', 'Buy New Service', '', ''),
(394, 97, 'tr', 'Alan Adı Tescil/Transfer', '', ''),
(395, 97, 'en', 'Domain Register/Transfer', '', ''),
(396, 98, 'tr', 'Web Hosting', '', ''),
(397, 98, 'en', 'Web Hosting', '', ''),
(398, 99, 'tr', 'VPS / VDS Sunucular', '', ''),
(399, 99, 'en', 'VPS / VDS Servers', '', ''),
(400, 100, 'tr', 'Bilgi Bankası', '', ''),
(401, 100, 'en', 'Knowledge Base', '', ''),
(402, 101, 'tr', 'Bize Ulaşın', '', ''),
(403, 101, 'en', 'Contact Us', '', ''),
(404, 102, 'tr', 'Hesap Oluştur', '', ''),
(405, 102, 'en', 'Sign Up', '', ''),
(406, 103, 'tr', 'Giriş Yap', '', ''),
(407, 103, 'en', 'Sign In', '', ''),
(408, 104, 'tr', 'Destek', '', ''),
(409, 104, 'en', 'Support', '', ''),
(410, 105, 'tr', 'Ürün/Hizmetlerim', '', ''),
(411, 105, 'en', 'My Services', '', ''),
(412, 106, 'tr', 'Alan Adlarım', '', ''),
(413, 106, 'en', 'My Domains', '', ''),
(437, 118, 'en', 'Reseller Program', '', ''),
(436, 118, 'tr', 'Bayilik', '', ''),
(416, 108, 'tr', 'Faturalarım', '', ''),
(417, 108, 'en', 'My Invoices', '', ''),
(418, 109, 'tr', 'Hesabım', '', ''),
(419, 109, 'en', 'My Account', '', ''),
(420, 110, 'tr', 'Mesajlarım', '', ''),
(421, 110, 'en', 'My Messages', '', ''),
(422, 111, 'tr', 'Eklentiler', '', ''),
(423, 111, 'en', 'Plugins', '', ''),
(424, 112, 'tr', 'Yazılım', '', ''),
(425, 112, 'en', 'Software', '', ''),
(426, 113, 'tr', 'SMS Paketleri', '', ''),
(427, 113, 'en', 'SMS Packages', '', ''),
(428, 114, 'tr', 'Uluslararası SMS Servisi', '', ''),
(429, 114, 'en', 'International SMS Service', '', ''),
(432, 116, 'tr', 'Hesap Detaylarım', '', ''),
(433, 116, 'en', 'Account Details', '', ''),
(434, 117, 'tr', 'Satış Ortaklığı', '', ''),
(435, 117, 'en', 'Affiliate Program', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `template_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mail',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `criteria` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `newsletter` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `without_products` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `birthday_marketing` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `cc` text COLLATE utf8mb4_unicode_ci,
  `subject` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `submission_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_groups` text COLLATE utf8mb4_unicode_ci,
  `departments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `countries` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `languages` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `services` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `servers` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `addons` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `services_status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_status` text COLLATE utf8mb4_unicode_ci,
  `auto_submission` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `period` enum('onetime','recurring') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'onetime',
  `period_datetime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `period_month` int(11) NOT NULL DEFAULT '-1',
  `period_day` int(11) NOT NULL DEFAULT '-1',
  `period_hour` int(11) NOT NULL DEFAULT '-1',
  `period_minute` int(11) NOT NULL DEFAULT '-1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates_logs`
--

CREATE TABLE `notification_templates_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `reminding_date` date NOT NULL DEFAULT '1881-05-19',
  `reminding_time` time NOT NULL DEFAULT '00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `categories` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'visible',
  `visible_to_user` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `override_usrcurrency` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `taxexempt` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `addons` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirements` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `affiliate_disable` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `affiliate_rate` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `module` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_data` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `type`, `category`, `categories`, `sidebar`, `status`, `visibility`, `visible_to_user`, `rank`, `override_usrcurrency`, `taxexempt`, `addons`, `requirements`, `options`, `affiliate_disable`, `affiliate_rate`, `ctime`, `module`, `module_data`, `notes`) VALUES
(1, 'normal', 0, NULL, 'enable', 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '[]', 0, '0.00', '2017-10-10 12:33:08', NULL, NULL, NULL),
(38, 'articles', 214, NULL, 'enable', 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"hide_comments\":0}', 0, '0.00', '2018-05-30 01:05:54', NULL, NULL, NULL),
(35, 'news', 0, NULL, '', 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"hide_comments\":0}', 0, '0.00', '2018-05-30 00:49:43', NULL, NULL, NULL),
(12, 'news', 0, NULL, 'enable', 'active', 'visible', 1, 0, 0, 0, NULL, NULL, '{\"hide_comments\":0}', 0, '0.00', '2017-10-10 17:11:33', NULL, NULL, NULL),
(14, 'news', 0, NULL, 'enable', 'active', 'visible', 1, 0, 0, 0, NULL, NULL, '{\"hide_comments\":0}', 0, '0.00', '2017-10-10 17:11:33', NULL, NULL, NULL),
(37, 'articles', 2, NULL, 'enable', 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"hide_comments\":0}', 0, '0.00', '2018-05-30 01:01:54', NULL, NULL, NULL),
(39, 'articles', 4, NULL, '', 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"hide_comments\":0}', 0, '0.00', '2018-05-30 01:11:18', NULL, NULL, NULL),
(21, 'software', 206, NULL, NULL, 'active', 'visible', 0, 1, 0, 0, '19,20,21', '8,9', '{\"popular\":true,\"external_link\":\"\",\"demo_link\":\"http:\\/\\/www.demodomain.com\",\"demo_admin_link\":\"http:\\/\\/www.demodomain.com\\/admin\",\"download_link\":\"\",\"auto_approval\":\"1\",\"download_file\":\"2018-07-14\\/71d68b48b4f21371a3ad912.png\"}', 0, '0.00', '2018-04-05 10:49:28', NULL, NULL, ''),
(63, 'references', 232, NULL, NULL, 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"website\":\"http:\\/\\/www.example.com\"}', 0, '0.00', '2018-07-02 11:04:44', NULL, NULL, NULL),
(28, 'articles', 3, NULL, 'enable', 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"hide_comments\":0}', 0, '0.00', '2018-05-09 12:44:54', NULL, NULL, NULL),
(62, 'references', 215, NULL, NULL, 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"website\":\"http:\\/\\/www.example.com\"}', 0, '0.00', '2018-07-02 11:00:10', NULL, NULL, NULL),
(64, 'software', 233, NULL, NULL, 'active', 'visible', 0, 1, 0, 0, '19,20,21', '8,9', '{\"popular\":true,\"external_link\":\"\",\"demo_link\":\"http:\\/\\/www.demodomain.com\",\"demo_admin_link\":\"http:\\/\\/www.demodomain.com\\/admin\",\"download_link\":\"\",\"auto_approval\":\"1\",\"download_file\":\"2018-07-13\\/b33f7a372e09a1f10fd88fc.jpg\"}', 0, '0.00', '2018-07-02 13:49:31', NULL, NULL, ''),
(36, 'news', 0, NULL, 'enable', 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"hide_comments\":0}', 0, '0.00', '2018-05-30 00:55:03', NULL, NULL, NULL),
(65, 'software', 234, NULL, NULL, 'active', 'visible', 0, 1, 0, 0, '', '', '{\"popular\":true,\"external_link\":\"\",\"demo_link\":\"http:\\/\\/www.demodomain.com\",\"demo_admin_link\":\"http:\\/\\/www.demodomain.com\\/admin\",\"download_link\":\"\",\"auto_approval\":\"1\",\"download_file\":\"2018-07-14\\/1f01152c51a0c4e51f01287.png\"}', 0, '0.00', '2018-07-02 14:05:05', NULL, NULL, ''),
(66, 'references', 236, NULL, NULL, 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '{\"website\":\"http:\\/\\/www.example.com\"}', 0, '0.00', '2018-07-02 14:08:09', NULL, NULL, NULL),
(67, 'normal', 0, NULL, NULL, 'active', 'visible', 0, 0, 0, 0, NULL, NULL, '[]', 0, '0.00', '2020-12-16 15:37:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages_lang`
--

CREATE TABLE `pages_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages_lang`
--

INSERT INTO `pages_lang` (`id`, `owner_id`, `lang`, `title`, `content`, `route`, `seo_title`, `seo_keywords`, `seo_description`, `options`) VALUES
(1, 1, 'tr', 'Hakkımızda', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>\n<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'hakkimizda', 'Hakkımızda', 'Hakkımızda', 'Hakkımızda', ''),
(13, 12, 'tr', 'Satış Ortaklığı ve Bayilik', '<p>Yinelenen bir sayfa içeriğinin okuyucunun dikkatini dağıttığı bilinen bir gerçektir. Lorem Ipsum kullanmanın amacı, sürekli \'buraya metin gelecek, buraya metin gelecek\' yazmaya kıyasla daha dengeli bir harf dağılımı sağlayarak okunurluğu artırmasıdır. Şu anda birçok masaüstü yayıncılık paketi ve web sayfa düzenleyicisi, varsayılan mıgır metinler olarak Lorem Ipsum kullanmaktadır. Ayrıca arama motorlarında \'lorem ipsum\' anahtar sözcükleri ile arama yapıldığında henüz tasarım aşamasında olan çok sayıda site listelenir. Yıllar içinde, bazen kazara, bazen bilinçli olarak (örneğin mizah katılarak), çeşitli sürümleri geliştirilmiştir.</p>\n<p>Yinelenen bir sayfa içeriğinin okuyucunun dikkatini dağıttığı bilinen bir gerçektir. Lorem Ipsum kullanmanın amacı, sürekli \'buraya metin gelecek, buraya metin gelecek\' yazmaya kıyasla daha dengeli bir harf dağılımı sağlayarak okunurluğu artırmasıdır. Şu anda birçok masaüstü yayıncılık paketi ve web sayfa düzenleyicisi, varsayılan mıgır metinler olarak Lorem Ipsum kullanmaktadır. Ayrıca arama motorlarında \'lorem ipsum\' anahtar sözcükleri ile arama yapıldığında henüz tasarım aşamasında olan çok sayıda site listelenir. Yıllar içinde, bazen kazara, bazen bilinçli olarak (örneğin mizah katılarak), çeşitli sürümleri geliştirilmiştir.</p>', 'satis-ortakligi-ve-bayilik', '', '', '', ''),
(15, 14, 'tr', 'Web Sitemiz Yenilendi!', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'web-sitemiz-yenilendi', '', '', '', ''),
(67, 21, 'tr', 'Test bir Script', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>\r\n<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'test-bir-script', 'Platon Kurumsal V3', 'Platon Kurumsal V3, kurumsal script, firma scripti', 'Platon Kurumal V3 firma scripti ile, işletmenizi ön plana çıkararak rakiplerinize fark atın. Tüm ihtiyaçlarınız düşünülerek sizin için tasarlandı!', '{\"feature_blocks\":[{\"icon\":\"ion-eye\",\"title\":\"Modern ve Kreatif Tasarım\",\"description\":\"Tüm sektörler ile uyumlu, ilgi çekici ve akılda kalıcı, kreatif tasarım.\",\"detailed-description\":\"\"},{\"icon\":\"ion-code-working\",\"title\":\"Dinamik,Yönetilebilir ve Modern Alt Yapı\",\"description\":\"Platon Kurumsal firma scripti, ( Php, MySql(PDO), Css + xHtml, jQuery + Ajax )kullanılarak dizayn edilmiştir.\",\"detailed-description\":\"\"},{\"icon\":\"ion-iphone\",\"title\":\"Full Responsive (Mobil Uyumlu)\",\"description\":\"Mobil cihaz ve tabletlerle uyumlu responsive tasarım (Müşteri Paneli dahil.)\",\"detailed-description\":\"\"},{\"icon\":\"ion-paintbrush\",\"title\":\"Sınırsız Renk! (MultiColor)\",\"description\":\"Kurumsal renklerinize uyum sağlayacak şekilde tema renklerini dilediğiniz renktonu olarak değiştirebilirsiniz.\",\"detailed-description\":\"\"},{\"icon\":\"fa fa-language\",\"title\":\"Sınırsız Çoklu Dil! (Multi Language)\",\"description\":\"Gelişmiş dil yönetimi menusunden istediğiniz kadar dil ekleyebilir ve yönetebilirsiniz. Diller ziyaretçilerinizin tarayıcı diline göre otomatik aktif olmaktadır.\",\"detailed-description\":\"\"},{\"icon\":\"ion-ios-cart\",\"title\":\"Gelişmiş Ürün Yönetimi\",\"description\":\"Firmanıza ait ürünlerinizi kapsamlı olarak sitenize ekleyebilir ve yönetebilirsiniz.\",\"detailed-description\":\"\"},{\"icon\":\"ion-shuffle\",\"title\":\"Sınırsız Ürün Kategorileri\",\"description\":\"Sınırsız Ürün Kategorileri Ürün gruplarınızı sınırsız alt alta kategorize edebilir,  her ürün kategorisi için özel meta bilgilerive detaylı açıklamalar ekleyebilirsiniz.\",\"detailed-description\":\"\"},{\"icon\":\"ion-checkmark\",\"title\":\"Online Sipariş ve Ödeme\",\"description\":\"Müşterileriniz, bir müşteri hesabı oluşturarak online sipariş verebilir vekredi kartı ile ödeme yapabilirler.\",\"detailed-description\":\"\"},{\"icon\":\"ion-card\",\"title\":\"2 Farklı SANALPOS Entegrasyonu\",\"description\":\"2 Farklı SANALPOS Entegrasyonu\",\"detailed-description\":\"\"},{\"icon\":\"ion-ios-people\",\"title\":\"Gelişmiş Müşteri Paneli ve Üyelik\",\"description\":\"Müşterileriz için kullanımı kolay, kullanıcı dostu bir müşteri paneli ile 7\\/24 hizmet sunabilirsiniz. Dilerseniz üyelik sistemini pasif duruma da getirebilirsiniz.\",\"detailed-description\":\"\"},{\"icon\":\"ion-ios-search-strong\",\"title\":\"Ürün Arama\",\"description\":\"Ürün kategori listesinde bulunan arama formu aracılığı ile ürün bazlı arama yapılabilir. \",\"detailed-description\":\"Ayrıca ürün kodu ile arama yapıldığından direkt olarak ürün detay sayfası açılmaktadır.\"},{\"icon\":\"ion-alert-circled\",\"title\":\"T.C. Kimlik No Doğrulama ve Mobil Onay\",\"description\":\"Web siteniz üzerinden hesap oluşturulurken T.C. Kimlik No doğrulama yaptırabilir ve Mobil onay alabilirsiniz.\",\"detailed-description\":\"\"}],\"short_features\":\"<i class=\\\"ion-android-done\\\"><\\/i> Modern ve Şık Tasarım\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Full Responsive (Mobil Uyumlu)\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Gelişmiş Müşteri Paneli\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Online Sipariş ve Tahsilat\",\"requirements\":\"- Ioncube V5 ve üzeri.\\r\\n- Php 5.6 ve üzeri.\\r\\n- Apache Mod_Rewrite\\r\\n<strong>Linux \\/ cPanel Önerilir.<\\/strong>\\r\\n\",\"installation_instructions\":\"<p><strong>KURULUM;<\\/strong><\\/p>\\r\\n<ol>\\r\\n<li>Dosyalarınızı ftp\'nize aktarınız.<\\/li>\\r\\n<li>Hosting panelinizden yeni bir veri tabanı oluşturunuz.<\\/li>\\r\\n<li>Kurulum dosyasında bulunan \\\"DATA.sql\\\" dosyasını, oluşturduğunuz veritabanına aktarınız.<\\/li>\\r\\n<li>settings\\/DB.php dosyasında, veri tabanı bilgilerinizi girerek web sitenizi aktif edebilirsiniz.<\\/li>\\r\\n<\\/ol>\\r\\n<p><strong>ÖNEMLİ;<\\/strong><\\/p>\\r\\n<ul>\\r\\n<li>Yazılımımız en düşük 5.4 PHP sürümü ile çalışmaktadır.<\\/li>\\r\\n<li>Sunucunuzda güncel IONCUBE yüklü olmalıdır.<\\/li>\\r\\n<li>İletişim formları, SMTP bilgilerini girmediğiniz taktirde çalışmaz.<\\/li>\\r\\n<\\/ul>\\r\\n<p><strong>ADMIN GİRİŞ BİLGİLERİ<\\/strong> (Standart);<\\/p>\\r\\n<ul>\\r\\n<li>Admin Paneli : www.domainadiniz.com\\/admin<\\/li>\\r\\n<li>E-Posta : info@example.com<\\/li>\\r\\n<li>Parola : admin123<\\/li>\\r\\n<\\/ul>\",\"versions\":\"<p><strong>V2.1.1<\\/strong><br \\/>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br \\/>- Performans iyileştirmeleri yapıldı.<br \\/>- Güvenlik testlerinden geçirildi.<\\/p>\\r\\n<p><strong>V2.1.0<\\/strong><br \\/>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br \\/>- Performans iyileştirmeleri yapıldı.<br \\/>- Güvenlik testlerinden geçirildi.<\\/p>\\r\\n<p><strong>V2.1.0<\\/strong><br \\/>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br \\/>- Performans iyileştirmeleri yapıldı.<br \\/>- Güvenlik testlerinden geçirildi.<\\/p>\",\"tag1\":\"Mobil Uyumlu\",\"tag2\":\"Sınırsız Dil\"}'),
(74, 28, 'tr', 'Web Tasarım Fiyatları', '<p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir. İnternet\'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200\'den fazla Latince sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır. Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan sözcüklerden uzaktır.</p>\n<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'web-tasarim-fiyatlari', 'xxxxxasasxaxasx', 'ddadasdsdadad', 'aegaeg', ''),
(78, 35, 'tr', '1500\'lerden beri kullanılan standart Lorem Ipsum pasajı', '<p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p>\n<p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p>', '1500lerden-beri-kullanilan-standart-lorem-ipsum-pasaji', '', '', '', ''),
(79, 36, 'tr', 'Çiçero tarafından yazılan ', '<p>\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p>\n<p>\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p>', 'cicero-tarafindan-yazilan-de-finibus-bonorum', '', '', '', ''),
(80, 37, 'tr', 'Lorem Ipsum Nedir ve Ne Anlama Gelir?', '<p>Şimdilerde dijital dünyada sıkça karşımıza çıkan Lorem Ipsum aslında çok öncelere dayanıyor ve yıllardan beridir matbaa içerisinde de kullanılıyor. Lorem Ipsum en basit haliyle yapılan yazılı çalışmalarda yazının nasıl görüneceğini anlayabilmemiz için kullandığımız taslak bir metindir. Peki, gerek matbaada gerekse de dijital dünyada sürekli olarak kullanılan bu metnin tarihi nedir ve ne anlama gelir?</p>\n<h2><span style=\"font-size: 14pt;\"><strong>Lorem Ipsum\'un Tarihi</strong></span></h2>\n<p>Lorem Ipsum yaklaşık 500 yıl önce bir matbaacının baskılar için hazırladığı font model kitabında kullanılmıştır. Yıllar geçtikçe kullanım alanları da kullanan kişi sayısı da artarak devam etmiştir. Kullanan insanlar uzun yıllar bunun anlamsız kelimelerden oluşan bir metin olduğunu düşündüler. Ancak sonradan edinilen bulgular aslında gerçeğin çok farklı olduğunu ortaya koydu.</p>\n<p>Lorem Ipsum\'un tarihi milattan önce 45 (MÖ.43) yılına kadar dayanıyor. O tarihlerde Çiçero tarafından yazılan \"İyi ve Kötünün Uç Sınırları\" kitabının 1.30.32 paragrafında geçtiği sonradan öğrenilmiştir. Kitap aynı zamanda 1500\'lü yıllarda Avrupa\'da Rönesans dönemi ile popüler olmuş, aynı dönemde Lorem Ipsum\'u ilk kullanan matbaacıya da muhtemelen bu vesileyle ulaşmış.  </p>\n<h3><strong><span style=\"font-size: 14pt;\">Yıllardır kullanılan Lorem Ipsum taslağı;</span></strong></h3>\n<p>\"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', 'lorem-ipsum-nedir-ve-ne-anlama-gelir', '', '', '', ''),
(81, 38, 'tr', 'Lorem Ipsum Neden Kullanılır?', '<p>Yapılan araştırmalar gösteriyor ki, insanlar bir baskı ürününü ya da dijital tasarımı değerlendirirken kendilerini yazıya ve onun anlamına kaptırmadan objektif değerlendirme yapamıyorlar. Bu nedenle Lorem Ipsum insanların tasarıma daha iyi odaklanmaları ve aynı zamanda anlamlı bir yazı formuna çok benzer bir örnekle birlikte tasarımı görebilmeleri için kullanılır.  </p>\n<p>Bu kullanımın yıllarca süregelen bir gelenek olduğunu söyleyebiliriz. Günümüzde hala birçok insan tarafından aktif olarak kullanıldığını da düşünürsek, matbaa, online ve tasarım dünyasında kullanılmaması için hiçbir sebep yok.</p>\n<p>Örnek olarak oluşturulmuş 2 paragraf uzunluğundaki Lorem Ipsum örneğini de buraya bırakalım. Belki de arkasında yatan başka gizemleri de siz çözebilirsiniz.</p>\n<p>Yapılan araştırmalar gösteriyor ki, insanlar bir baskı ürününü ya da dijital tasarımı değerlendirirken kendilerini yazıya ve onun anlamına kaptırmadan objektif değerlendirme yapamıyorlar. Bu nedenle Lorem Ipsum insanların tasarıma daha iyi odaklanmaları ve aynı zamanda anlamlı bir yazı formuna çok benzer bir örnekle birlikte tasarımı görebilmeleri için kullanılır.  </p>\n<p>Bu kullanımın yıllarca süregelen bir gelenek olduğunu söyleyebiliriz. Günümüzde hala birçok insan tarafından aktif olarak kullanıldığını da düşünürsek, matbaa, online ve tasarım dünyasında kullanılmaması için hiçbir sebep yok.</p>\n<p>Örnek olarak oluşturulmuş 2 paragraf uzunluğundaki Lorem Ipsum örneğini de buraya bırakalım. Belki de arkasında yatan başka gizemleri de siz çözebilirsiniz.</p>', 'lorem-ipsum-neden-kullanilir', '', '', '', ''),
(82, 39, 'tr', 'Quisquam est qui dolorem ipsum', '<p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p>\r\n<p>\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p>', 'quisquam-est-qui-dolorem-ipsum', '', '', '', ''),
(113, 1, 'en', 'About Us', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'about-us', 'About Us', 'About Us', 'About Us', ''),
(114, 12, 'en', 'Sales Partnership and Dealership', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'sales-partnership-and-dealership', 'Sales Partnership and Dealership', 'Sales Partnership and Dealership', 'Sales Partnership and Dealership', ''),
(115, 14, 'en', 'Our Web Site is New!', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'our-web-site-is-new', 'Our Web Site is New!', 'Our Web Site is New!', 'Our Web Site is New!', ''),
(116, 21, 'en', 'Example a Script', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'example-a-script', 'Example a Script', '', '', '{\"short_features\":\"<i class =\\\"ion-android-done\\\"> <\\/i> Modern and Stylish Design\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Full Responsive\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Advanced Customer Panel\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Online Order and Payment\",\"requirements\":\"- Ioncube V5 and Higher.\\r\\n- Php 5.6 and Higher.\\r\\n- Apache Mod_Rewrite\\r\\n<strong>Linux \\/ cPanel Recommended.<\\/strong>\\r\\n\",\"installation_instructions\":\"<p><strong>INSTALL INFORMATIONS;<\\/strong><\\/p>\\r\\n<ol>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<\\/ol>\\r\\n<p><strong>IMPORTANT;<\\/strong><\\/p>\\r\\n<ul>\\r\\n<li>Our software works with the lowest PHP version 5.4.<\\/li>\\r\\n<li>Your server must have the high version IONCUBE.<\\/li>\\r\\n<li>Contact forms do not run if you do not enter SMTP information.<\\/li>\\r\\n<\\/ul>\\r\\n<p><strong>ADMIN LOGIN INFORMATION<\\/strong> (Standard);<\\/p>\\r\\n<ul>\\r\\n<li>Admin Panel: www.domainexample.com\\/admin<\\/li>\\r\\n<li>E-Mail: info@example.com<\\/li>\\r\\n<li>Pass: admin123<\\/li>\\r\\n<\\/ul>\",\"versions\":\"<p><strong>V2.1.1<\\/strong><br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p>\\r\\n<p><strong>V2.1.0<\\/strong><br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p>\\r\\n<p><strong>V2.1.0<\\/strong><br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p>\",\"tag1\":\"Full Responsive\",\"tag2\":\"Multilanguage\"}'),
(117, 28, 'en', 'Where does it come from?', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'where-does-it-come-from', 'Where does it come from?', 'Where does it come from?', 'Where does it come from?', ''),
(120, 35, 'en', 'Contrary to popular belief, Lorem Ipsum', '<p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p>\n<p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p>', 'contrary-to-popular-belief-lorem-ipsum', 'Contrary to popular belief, Lorem Ipsum', 'Contrary to popular belief, Lorem Ipsum', 'Contrary to popular belief, Lorem Ipsum', ''),
(121, 36, 'en', 'Neque porro quisquam est qui dolorem', '<p>\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p>\n<p>\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p>', 'neque-porro-quisquam-est-qui-dolorem', 'Neque porro quisquam est qui dolorem', 'Neque porro quisquam est qui dolorem', 'Neque porro quisquam est qui dolorem', ''),
(122, 37, 'en', 'The standard Lorem Ipsum passage, used since the 1500s', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>\n<h5>Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</h5>\n<p>\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p>\n<h5>1914 translation by H. Rackham</h5>\n<p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p>', 'the-standard-lorem-ipsum-passage-used-since-the-1500s', 'The standard Lorem Ipsum passage, used since the 1500s', 'The standard Lorem Ipsum passage, used since the 1500s', 'The standard Lorem Ipsum passage, used since the 1500s', ''),
(123, 38, 'en', 'Why is Lorem Ipsum used?', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'why-is-lorem-ipsum-used', 'Why is Lorem Ipsum used?', 'Why is Lorem Ipsum used?', 'Why is Lorem Ipsum used?', ''),
(124, 39, 'en', 'Quisquam est qui dolorem ipsum', '<p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p>\r\n<p>\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p>', 'quisquam-est-qui-dolorem-ipsum', '', '', '', ''),
(128, 62, 'tr', 'Örnek Bir Referans', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'ornek-bir-referans', 'Örnek Bir Referans', '', '', '{\"featured-info\":\"Öne çıkan bir özellik1\\r\\nÖne çıkan bir özellik2\\r\\nÖne çıkan bir özellik3\\r\\nÖne çıkan bir özellik4\",\"technical-info\":\"Teknik bir bilgi1\\r\\nTeknik bir bilgi2\\r\\nTeknik bir bilgi3\\r\\nTeknik bir bilgi4\"}');
INSERT INTO `pages_lang` (`id`, `owner_id`, `lang`, `title`, `content`, `route`, `seo_title`, `seo_keywords`, `seo_description`, `options`) VALUES
(129, 62, 'en', 'A Sample Reference', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'a-sample-reference', 'A Sample Reference', '', '', '{\"featured-info\":\"Featured feature1\\r\\nFeatured feature2\\r\\nFeatured feature3\\r\\nFeatured feature4\",\"technical-info\":\"Technical information1\\r\\nTechnical information2\\r\\nTechnical information3\\r\\nTechnical information4\"}'),
(130, 63, 'tr', 'Örnek İkinci Referans', '<p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir. İnternet\'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200\'den fazla Latince sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır. Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan sözcüklerden uzaktır.</p>\r\n<p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir. İnternet\'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200\'den fazla Latince sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır. Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan sözcüklerden uzaktır.</p>', 'ornek-ikinci-referans', '', '', '', '{\"featured-info\":\"Öne çıkan bir özellik1\\r\\nÖne çıkan bir özellik2\\r\\nÖne çıkan bir özellik3\\r\\nÖne çıkan bir özellik4\",\"technical-info\":\"Teknik bir bilgi1\\r\\nTeknik bir bilgi2\\r\\nTeknik bir bilgi3\\r\\nTeknik bir bilgi4\"}'),
(131, 63, 'en', 'Example Second Reference', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'example-second-reference', '', '', '', '{\"featured-info\":\"Featured feature1\\r\\nFeatured feature2\\r\\nFeatured feature3\\r\\nFeatured feature4\",\"technical-info\":\"Technical information1\\r\\nTechnical information2\\r\\nTechnical information3\\r\\nTechnical information4\"}'),
(132, 64, 'tr', 'Örnek Bir Emlak Scripti', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p><p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p><p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p><p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'ornek-bir-emlak-scripti', 'Örnek Bir Emlak Scripti', '', '', '{\"short_features\":\"<i class=\\\"ion-android-done\\\"><\\/i> Modern ve Şık Tasarım\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Full Responsive (Mobil Uyumlu)\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Gelişmiş Müşteri Paneli\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Online Sipariş ve Tahsilat\",\"requirements\":\"- Ioncube V5 ve üzeri.\\r\\n- Php 5.6 ve üzeri.\\r\\n- Apache Mod_Rewrite\\r\\n<strong>Linux \\/ cPanel Önerilir.<\\/strong>\\r\\n\",\"installation_instructions\":\"<p><strong>KURULUM;<\\/strong><\\/p><ol><li>Dosyalarınızı ftp\'nize aktarınız.<\\/li><li>Hosting panelinizden yeni bir veri tabanı oluşturunuz.<\\/li><li>Kurulum dosyasında bulunan \\\"DATA.sql\\\" dosyasını, oluşturduğunuz veritabanına aktarınız.<\\/li><li>settings\\/DB.php dosyasında, veri tabanı bilgilerinizi girerek web sitenizi aktif edebilirsiniz.<\\/li><\\/ol><p><strong>ÖNEMLİ;<\\/strong><\\/p><ul><li>Yazılımımız en düşük 5.4 PHP sürümü ile çalışmaktadır.<\\/li><li>Sunucunuzda güncel IONCUBE yüklü olmalıdır.<\\/li><li>İletişim formları, SMTP bilgilerini girmediğiniz taktirde çalışmaz.<\\/li><\\/ul><p><strong>ADMIN GİRİŞ BİLGİLERİ<\\/strong> (Standart);<\\/p><ul><li>Admin Paneli : www.domainadiniz.com\\/admin<\\/li><li>E-Posta : info@example.com<\\/li><li>Parola : admin123<\\/li><\\/ul>\",\"versions\":\"<p><strong>V2.1.1<\\/strong><br>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br>- Performans iyileştirmeleri yapıldı.<br>- Güvenlik testlerinden geçirildi.<\\/p><p><strong>V2.1.0<\\/strong><br>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br>- Performans iyileştirmeleri yapıldı.<br>- Güvenlik testlerinden geçirildi.<\\/p><p><strong>V2.1.0<\\/strong><br>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br>- Performans iyileştirmeleri yapıldı.<br>- Güvenlik testlerinden geçirildi.<\\/p>\",\"tag1\":\"Mobil Uyumlu\",\"tag2\":\"Sınırsız Dil\"}'),
(133, 64, 'en', 'Sample Real Estate Script', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'sample-real-estate-script', 'Sample Real Estate Script', '', '', '{\"short_features\":\"<i class =\\\"ion-android-done\\\"> <\\/i> Modern and Stylish Design\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Full Responsive\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Advanced Customer Panel\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Online Order and Payment\",\"requirements\":\"- Ioncube V5 and Higher.\\r\\n- Php 5.6 and Higher.\\r\\n- Apache Mod_Rewrite\\r\\n<strong>Linux \\/ cPanel Recommended.<\\/strong>\\r\\n\",\"installation_instructions\":\"<p><strong>INSTALL INFORMATIONS;<\\/strong><\\/p><ol><li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li><li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li><li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li><li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li><li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li><\\/ol><p><strong>IMPORTANT;<\\/strong><\\/p><ul><li>Our software works with the lowest PHP version 5.4.<\\/li><li>Your server must have the high version IONCUBE.<\\/li><li>Contact forms do not run if you do not enter SMTP information.<\\/li><\\/ul><p><strong>ADMIN LOGIN INFORMATION<\\/strong> (Standard);<\\/p><ul><li>Admin Panel: www.domainexample.com\\/admin<\\/li><li>E-Mail: info@example.com<\\/li><li>Pass: admin123<\\/li><\\/ul>\",\"versions\":\"<p><strong>V2.1.1<\\/strong><br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p><p><strong>V2.1.0<\\/strong><br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p><p><strong>V2.1.0<\\/strong><br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p>\",\"tag1\":\"Full Responsive\",\"tag2\":\"Multilanguage\"}'),
(134, 65, 'tr', 'Test Bir Rent A Car Scripti', '<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>\r\n<p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia\'daki Hampden-Sydney College\'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan \'consectetur\' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır. Lorm Ipsum, Çiçero tarafından M.Ö. 45 tarihinde kaleme alınan \"de Finibus Bonorum et Malorum\" (İyi ve Kötünün Uç Sınırları) eserinin 1.10.32 ve 1.10.33 sayılı bölümlerinden gelmektedir. Bu kitap, ahlak kuramı üzerine bir tezdir ve Rönesans döneminde çok popüler olmuştur. Lorem Ipsum pasajının ilk satırı olan \"Lorem ipsum dolor sit amet\" 1.10.32 sayılı bölümdeki bir satırdan gelmektedir.</p>\r\n<p>1500\'lerden beri kullanılmakta olan standard Lorem Ipsum metinleri ilgilenenler için yeniden üretilmiştir. Çiçero tarafından yazılan 1.10.32 ve 1.10.33 bölümleri de 1914 H. Rackham çevirisinden alınan İngilizce sürümleri eşliğinde özgün biçiminden yeniden üretilmiştir.</p>', 'test-bir-rent-a-car-scripti', '', '', '', '{\"short_features\":\"<i class=\\\"ion-android-done\\\"><\\/i> Modern ve Şık Tasarım\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Full Responsive (Mobil Uyumlu)\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Gelişmiş Müşteri Paneli\\r\\n<i class=\\\"ion-android-done\\\"><\\/i> Online Sipariş ve Tahsilat\",\"requirements\":\"- Ioncube V5 ve üzeri.\\r\\n- Php 5.6 ve üzeri.\\r\\n- Apache Mod_Rewrite\\r\\n<strong>Linux \\/ cPanel Önerilir.<\\/strong>\\r\\n\",\"installation_instructions\":\"<p><strong>KURULUM;<\\/strong><\\/p>\\r\\n<ol>\\r\\n<li>Dosyalarınızı ftp\'nize aktarınız.<\\/li>\\r\\n<li>Hosting panelinizden yeni bir veri tabanı oluşturunuz.<\\/li>\\r\\n<li>Kurulum dosyasında bulunan \\\"DATA.sql\\\" dosyasını, oluşturduğunuz veritabanına aktarınız.<\\/li>\\r\\n<li>settings\\/DB.php dosyasında, veri tabanı bilgilerinizi girerek web sitenizi aktif edebilirsiniz.<\\/li>\\r\\n<\\/ol>\\r\\n<p><strong>ÖNEMLİ;<\\/strong><\\/p>\\r\\n<ul>\\r\\n<li>Yazılımımız en düşük 5.4 PHP sürümü ile çalışmaktadır.<\\/li>\\r\\n<li>Sunucunuzda güncel IONCUBE yüklü olmalıdır.<\\/li>\\r\\n<li>İletişim formları, SMTP bilgilerini girmediğiniz taktirde çalışmaz.<\\/li>\\r\\n<\\/ul>\\r\\n<p><strong>ADMIN GİRİŞ BİLGİLERİ<\\/strong> (Standart);<\\/p>\\r\\n<ul>\\r\\n<li>Admin Paneli : www.domainadiniz.com\\/admin<\\/li>\\r\\n<li>E-Posta : info@example.com<\\/li>\\r\\n<li>Parola : admin123<\\/li>\\r\\n<\\/ul>\",\"versions\":\"<p><strong>V2.1.1<\\/strong><br \\/>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br \\/>- Performans iyileştirmeleri yapıldı.<br \\/>- Güvenlik testlerinden geçirildi.<\\/p>\\r\\n<p><strong>V2.1.0<\\/strong><br \\/>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br \\/>- Performans iyileştirmeleri yapıldı.<br \\/>- Güvenlik testlerinden geçirildi.<\\/p>\\r\\n<p><strong>V2.1.0<\\/strong><br \\/>- Fotoğrafların sunucuya optimizeli olarak yüklenmesi sağlandı. (Örn: 5MB fotoğraf sunucuya 195KB olarak yüklenmesi gibi.)<br \\/>- Performans iyileştirmeleri yapıldı.<br \\/>- Güvenlik testlerinden geçirildi.<\\/p>\",\"tag1\":\"Mobil Uyumlu\",\"tag2\":\"Sınırsız Dil\"}'),
(135, 65, 'en', 'Test A Rent A Car Script', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'test-a-rent-a-car-script', 'Test A Rent A Car Script', '', '', '{\"short_features\":\"<i class =\\\"ion-android-done\\\"> <\\/i> Modern and Stylish Design\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Full Responsive\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Advanced Customer Panel\\r\\n<i class =\\\"ion-android-done\\\"> <\\/i> Online Order and Payment\",\"requirements\":\"- Ioncube V5 and Higher.\\r\\n- Php 5.6 and Higher.\\r\\n- Apache Mod_Rewrite\\r\\n<strong>Linux \\/ cPanel Recommended.<\\/strong>\",\"installation_instructions\":\"<p><strong>INSTALL INFORMATIONS;<\\/strong><\\/p>\\r\\n<ol>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<li>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.<\\/li>\\r\\n<\\/ol>\\r\\n<p><strong>IMPORTANT;<\\/strong><\\/p>\\r\\n<ul>\\r\\n<li>Our software works with the lowest PHP version 5.4.<\\/li>\\r\\n<li>Your server must have the high version IONCUBE.<\\/li>\\r\\n<li>Contact forms do not run if you do not enter SMTP information.<\\/li>\\r\\n<\\/ul>\\r\\n<p><strong>ADMIN LOGIN INFORMATION<\\/strong> (Standard);<\\/p>\\r\\n<ul>\\r\\n<li>Admin Panel: www.domainexample.com\\/admin<\\/li>\\r\\n<li>E-Mail: info@example.com<\\/li>\\r\\n<li>Pass: admin123<\\/li>\\r\\n<\\/ul>\",\"versions\":\"<p><strong>V2.1.1<\\/strong><br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p>\\r\\n<p><strong>V2.1.0<\\/strong><br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p>\\r\\n<p><strong>V2.1.0<\\/strong><br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br \\/>- Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<\\/p>\",\"tag1\":\"Full Responsive\",\"tag2\":\"Multilanguage\"}'),
(136, 66, 'tr', 'Örnek Üçüncü Referans', '<p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir. İnternet\'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200\'den fazla Latince sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır. Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan sözcüklerden uzaktır.</p>\n<p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir. İnternet\'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200\'den fazla Latince sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır. Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan sözcüklerden uzaktır.</p>', 'ornek-ucuncu-referans', '', '', '', '{\"featured-info\":\"Öne çıkan bir özellik1\\nÖne çıkan bir özellik2\\nÖne çıkan bir özellik3\\nÖne çıkan bir özellik4\",\"technical-info\":\"Teknik bir bilgi1\\nTeknik bir bilgi2\\nTeknik bir bilgi3\\nTeknik bir bilgi4\"}'),
(137, 66, 'en', 'Example Third Reference', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 'example-third-reference', '', '', '', '{\"featured-info\":\"Featured feature1\\nFeatured feature2\\nFeatured feature3\\nFeatured feature4\",\"technical-info\":\"Technical information1\\nTechnical information2\\nTechnical information3\\nTechnical information4\"}'),
(138, 67, 'tr', 'Çerez Politikası', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'cerez-politikasi', 'Çerez Politikası', NULL, NULL, NULL),
(139, 67, 'tr', 'Cookie Policy', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'cookie-policy', 'Cookie Policy', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `periodic_outgoings`
--

CREATE TABLE `periodic_outgoings` (
  `id` int(11) UNSIGNED NOT NULL,
  `amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `currency` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `period_day` int(2) NOT NULL DEFAULT '1',
  `period_hour` int(2) NOT NULL DEFAULT '0',
  `period_minute` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `owner` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `owner_id`, `owner`, `reason`, `name`) VALUES
(9, 0, 'page_normal', 'header-background', 'page-normal-header-background.jpg'),
(10, 0, 'contact', 'header-background', 'contact-header-background.jpg'),
(11, 0, 'knowledgebase', 'header-background', 'knowledgebase-header-background.jpg'),
(12, 0, 'page_articles', 'header-background', 'page-articles-header-background.jpg'),
(13, 0, 'page_news', 'header-background', 'page-news-header-background.jpg'),
(14, 9, 'category', 'background-image', '2017-10-30/seo-background.jpg'),
(15, 13, 'category', 'background-image', '2017-10-30/seo-background.jpg'),
(22, 13, 'category', 'header-background', '2017-10-31/smspaketleri.jpg'),
(24, 0, 'page_software', 'header-background', 'page-software-header-background.jpg'),
(25, 0, 'articles', 'header-background', 'articles-header-background.jpg'),
(26, 0, 'news', 'header-background', 'news-header-background.jpg'),
(27, 0, 'softwares', 'header-background', 'softwares-header-background.jpg'),
(30, 0, 'domain', 'header-background', 'domain-header-background.jpg'),
(31, 0, 'order-steps', 'header-background', 'order-steps-header-background.jpg'),
(32, 0, 'basket', 'header-background', 'basket-header-background.jpg'),
(33, 0, 'account_sms', 'header-background', 'account-sms-header-background.jpg'),
(34, 1, 'user', 'profile-image', '2018-07-23/8fb13ea9fa968c84db6f5e9.jpg'),
(43, 0, 'block', 'about-us', '2018-02-06/slide2.jpg'),
(44, 0, 'block', 'about-us', '2018-02-06/dc688d4f09f8ef592e78583.jpg'),
(45, 0, 'block', 'about-us', '2018-02-06/4686fcd3cb509eb2c786fee.jpg'),
(46, 0, 'block', 'product-group__14', '2018-02-08/6c5f5e34e96aa28bae48178.jpg'),
(47, 0, 'block', 'about-us', '2018-02-08/146a7f731af1b177be345ca.jpg'),
(48, 0, 'block', 'product-group__14', '2018-02-08/9a524909ed841604b09f1c3.jpg'),
(49, 0, 'block', 'home-softwares', '2018-02-08/68eb9b2e76c8345cf24371b.jpg'),
(50, 0, 'account', 'header-background', 'account-header-background.jpg'),
(51, 0, 'hosting', 'header-background', 'hosting-header-background.jpg'),
(52, 0, 'server', 'header-background', 'server-header-background.jpg'),
(53, 0, 'special-products', 'header-background', 'special-products-header-background.jpg'),
(54, 0, 'sms', 'header-background', 'sms-header-background.jpg'),
(55, 0, 'block', 'group-hosting', '2018-02-15/f9b5a0de6f4e5a7c331dd85.jpg'),
(56, 0, 'block', 'group-server', '2018-02-15/2a9806179063cac6e4dddd8.jpg'),
(57, 0, 'block', 'group-hosting', '2018-02-21/ef244881f40d73fd5376d19.jpg'),
(58, 0, 'block', 'home-softwares', '2018-02-21/a4d73de930e26a7b6326344.jpg'),
(59, 0, 'block', 'home-softwares', '2018-02-21/9b7196ccbc88c07f2f79fc4.jpg'),
(73, 24, 'category', 'icon', '2018-03-20/581f9c9e7783a5df4018bd5.png'),
(74, 26, 'category', 'icon', '2018-03-20/7054c82c2e2598d19b35e33.png'),
(75, 25, 'category', 'icon', '2018-03-20/ec946abbadd154a7a6b329f.png'),
(80, 26, 'category', 'header-background', '2018-03-20/cc63e8d438d20ddbe89b480.jpg'),
(81, 25, 'category', 'header-background', '2018-03-20/732700fd672690a95b79193.jpg'),
(83, 24, 'category', 'header-background', '2018-03-20/ce1b333f37bf5cb3e4c6e03.jpg'),
(84, 173, 'category', 'header-background', '2018-03-20/5afd6e40dec143bdc0166ab.jpg'),
(85, 174, 'category', 'header-background', '2018-03-20/a2ac46fe1f52c4b5fddbde2.jpg'),
(86, 174, 'category', 'icon', '2018-03-20/a4f07c05d9bd8a66738bb54.png'),
(87, 175, 'category', 'header-background', '2018-03-20/28c172b0b0cd188f31a0e9f.jpg'),
(88, 175, 'category', 'icon', '2018-03-20/dfc7a557bb7361ecf88142f.png'),
(89, 176, 'category', 'header-background', '2018-03-20/0ad99f3bcaf941a609b5208.jpg'),
(90, 176, 'category', 'icon', '2018-03-20/8572b1ba6f07f525def200b.png'),
(95, 0, 'block', 'about-us', '2018-03-24/e51595d2427a76850306b7d.jpg'),
(96, 0, 'block', 'features', '2018-03-24/7e8d4055bbf714d94462836.jpg'),
(97, 0, 'block', 'features', '2018-03-24/fbbfb6c789406f09c193f7f.jpg'),
(98, 0, 'block', 'features', '2018-03-29/4481d529facf24c8c40e1a6.jpg'),
(99, 0, 'block', 'news-articles', '2018-03-29/760c5f5081b9e5b252231c1.jpg'),
(100, 0, 'block', 'features', '2018-03-30/86eb69e61a9aad1332455a1.jpg'),
(101, 0, 'block', 'features', '2018-03-30/146862948de38f4c33d5319.jpg'),
(102, 0, 'block', 'news-articles', '2018-03-30/bac411cf9d09c925ee04c20.jpg'),
(103, 0, 'block', 'news-articles', '2018-03-30/b85ee0981deffd0868ac606.jpg'),
(130, 0, 'references', 'header-background', 'references-header-background.jpg'),
(133, 35, 'page_news', 'cover', '2018-05-30/b65a2b6eee787e829bd6ac5.jpg'),
(134, 12, 'page_news', 'cover', '2018-05-30/45bde89eaf72231076de14e.jpg'),
(135, 36, 'page_news', 'cover', '2018-05-30/39ecae8cfbdc2406157deda.jpg'),
(136, 37, 'page_articles', 'cover', '2018-05-30/1ff847376cbe1f4d559fdd1.jpg'),
(137, 28, 'page_articles', 'cover', '2018-05-30/6e795c702222bdc998dc191.jpg'),
(138, 38, 'page_articles', 'cover', '2018-05-30/45098d3f3eb93e51c4b692f.jpg'),
(139, 39, 'page_articles', 'cover', '2018-05-30/2258e89f2449a92e1dde9a2.jpg'),
(140, 0, '404', 'header-background', '404-header-background.jpg'),
(141, 0, 'license', 'header-background', 'license-header-background.jpg'),
(142, 14, 'page_news', 'cover', '2018-06-12/aa1d13925f102be22930b0d.jpg'),
(156, 3, 'slides', 'main-image', '2018-07-01/250a340bc9d6e3b5532d0ae.jpg'),
(157, 7, 'slides', 'main-image', '2018-07-01/56824736fb07039113c11e6.jpg'),
(158, 2, 'slides', 'main-image', '2018-07-01/301103fc94ed8b81f306df8.jpg'),
(160, 8, 'slides', 'main-image', '2018-07-01/49e9e6203d258b46ee9db3d.jpg'),
(162, 62, 'page_references', 'mockup', '2018-07-02/03c6949007ccf7195db688d.jpg'),
(164, 63, 'page_references', 'mockup', '2018-07-02/d4a3a1fcab65a6e6b7ba4cb.jpg'),
(168, 8, 'customer_feedback', 'image', '2018-07-02/9f066b5576187be372efde9.jpg'),
(169, 10, 'customer_feedback', 'image', '2018-07-02/00bc8811397a612f227396f.jpg'),
(170, 21, 'page_software', 'cover', '2018-07-02/8a98fad4569a10acc0711fd.jpg'),
(171, 21, 'page_software', 'mockup', '2018-07-02/10a05fb5bb246ce4bbd0008.jpg'),
(172, 64, 'page_software', 'cover', '2018-07-02/828998b4d1b770754e6c49e.jpg'),
(173, 64, 'page_software', 'mockup', '2018-07-02/03f8586868d1592771fd9f2.png'),
(175, 65, 'page_software', 'cover', '2018-07-02/b6580bed1aec115f6c1f5a3.jpg'),
(178, 65, 'page_software', 'mockup', '2018-07-02/dbe36c3155e3a27fc63f23c.jpg'),
(180, 62, 'page_references', 'cover', '2018-07-02/2be83234b3169289f70e899.jpg'),
(181, 66, 'page_references', 'cover', '2018-07-02/30ea2b3db085c9e76881a63.png'),
(182, 66, 'page_references', 'mockup', '2018-07-02/cb7c186d4066b569584ac7e.jpg'),
(183, 63, 'page_references', 'cover', '2018-07-02/22146dd91b30bf00cfb8b70.jpg'),
(185, 9, 'slides', 'main-image', '2018-07-02/913ce429cfee3cd64fd2962.jpg'),
(186, 194, 'category', 'header-background', '2018-07-13/57d859512cf111cab178d85.jpg'),
(194, 51, 'product', 'order', '2018-07-16/42796afb9791da5b8672d42.png'),
(195, 50, 'product', 'order', '2018-08-03/0951d9d132bf84636b2d9fb.png'),
(197, 22, 'product', 'order', '2018-10-31/9b5f24c1c6c29fba785bd8a.png'),
(198, 0, 'block', 'features', '2018-11-21/5b9692f3ed23301f6e31909.jpg'),
(199, 0, 'block', 'features', '2018-12-05/fa07a6b466abf1fe27cf8c9.jpg'),
(200, 1, 'slides', 'main-image', '2018-12-06/37bacc3e4829927ef216e82.jpg'),
(201, 240, 'category', 'header-background', '2020-02-26/a0edf836ea422a8e3489d4f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `owner` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `time` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `cid` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `discount` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `lang`, `owner`, `owner_id`, `type`, `period`, `time`, `amount`, `cid`, `discount`, `rank`) VALUES
(153, 'none', 'products', 53, 'periodicals', 'none', 1, '40.0000', 4, '0', 0),
(152, 'none', 'products', 52, 'periodicals', 'none', 1, '25.0000', 4, '0', 0),
(151, 'none', 'products', 51, 'periodicals', 'month', 6, '400.0000', 4, '0', 0),
(150, 'none', 'products', 50, 'periodicals', 'month', 6, '200.0000', 4, '', 0),
(5, 'none', 'products', 2, 'periodicals', 'month', 1, '1800.0000', 4, '0', 0),
(6, 'none', 'products', 2, 'periodicals', 'month', 3, '1400.0000', 4, '0', 0),
(7, 'none', 'products', 2, 'periodicals', 'month', 6, '1200.0000', 4, '0', 0),
(8, 'none', 'products', 2, 'periodicals', 'year', 1, '2199.9900', 4, '0', 0),
(9, 'none', 'products', 3, 'periodicals', 'month', 1, '2200.0000', 4, '0', 0),
(10, 'none', 'products', 3, 'periodicals', 'month', 3, '2100.0000', 4, '0', 0),
(11, 'none', 'products', 3, 'periodicals', 'month', 6, '2000.0000', 4, '0', 0),
(12, 'none', 'products', 3, 'periodicals', 'year', 1, '3000.0000', 4, '0', 0),
(56, 'none', 'products', 17, 'periodicals', 'year', 1, '19.0000', 4, '0', 0),
(52, 'none', 'products', 15, 'periodicals', 'year', 1, '5.0000', 4, '0', 0),
(53, 'none', 'products', 16, 'periodicals', 'year', 1, '9.0000', 4, '', 0),
(54, 'none', 'products', 15, 'periodicals', 'year', 2, '10.0000', 4, '0', 1),
(55, 'none', 'products', 16, 'periodicals', 'year', 2, '18.0000', 4, '', 1),
(245, 'none', 'softwares', 21, 'periodicals', 'none', 1, '99.0000', 4, '0', 0),
(255, 'none', 'tld', 9, 'transfer', 'none', 0, '13.0000', 4, '0', 0),
(256, 'none', 'tld', 25, 'transfer', 'none', 0, '15.9000', 4, '0', 0),
(257, 'none', 'tld', 13, 'transfer', 'none', 0, '15.0000', 4, '0', 0),
(258, 'none', 'tld', 19, 'transfer', 'none', 0, '31.7000', 4, '0', 0),
(174, 'none', 'tld', 9, 'register', 'none', 0, '13.0000', 4, '0', 0),
(175, 'none', 'tld', 9, 'renewal', 'none', 0, '13.0000', 4, '0', 0),
(170, 'none', 'tld', 7, 'register', 'none', 0, '9.9900', 4, '0', 0),
(171, 'none', 'tld', 7, 'renewal', 'none', 0, '9.9900', 4, '0', 0),
(172, 'none', 'tld', 8, 'register', 'none', 0, '13.0000', 4, '0', 0),
(173, 'none', 'tld', 8, 'renewal', 'none', 0, '13.0000', 4, '0', 0),
(161, 'none', 'products', 61, 'sale', 'none', 0, '160.0000', 4, '0', 0),
(160, 'none', 'products', 60, 'sale', 'none', 0, '85.0000', 4, '0', 0),
(159, 'none', 'products', 59, 'sale', 'none', 0, '69.0000', 4, '0', 0),
(65, 'none', 'products', 22, 'periodicals', 'month', 1, '28.0000', 5, '0', 0),
(66, 'none', 'products', 23, 'periodicals', 'month', 1, '34.0000', 5, '0', 0),
(67, 'none', 'products', 24, 'periodicals', 'month', 1, '25.0000', 5, '0', 0),
(68, 'none', 'products', 25, 'periodicals', 'month', 1, '35.0000', 5, '0', 0),
(58, 'none', 'products', 18, 'periodicals', 'year', 1, '29.0000', 4, '0', 0),
(57, 'none', 'products', 17, 'periodicals', 'year', 2, '30.4000', 4, '20', 1),
(69, 'none', 'products', 26, 'periodicals', 'month', 1, '79.0000', 5, '0', 0),
(59, 'none', 'products', 18, 'periodicals', 'year', 2, '46.4000', 4, '20', 1),
(60, 'none', 'products', 19, 'periodicals', 'year', 1, '49.0000', 4, '0', 0),
(61, 'none', 'products', 19, 'periodicals', 'year', 2, '78.4000', 4, '20', 1),
(62, 'none', 'products', 20, 'periodicals', 'year', 1, '89.0000', 4, '0', 0),
(63, 'none', 'products', 20, 'periodicals', 'year', 2, '142.4000', 4, '20', 1),
(64, 'none', 'products', 21, 'periodicals', 'month', 1, '28.0000', 5, '0', 0),
(70, 'none', 'products', 27, 'periodicals', 'month', 1, '45.0000', 5, '0', 0),
(71, 'none', 'products', 28, 'periodicals', 'month', 1, '52.0000', 5, '0', 0),
(72, 'none', 'products', 29, 'periodicals', 'month', 1, '52.0000', 5, '0', 0),
(73, 'none', 'products', 30, 'periodicals', 'month', 1, '49.0000', 4, '0', 0),
(74, 'none', 'products', 31, 'periodicals', 'month', 1, '89.0000', 4, '0', 0),
(75, 'none', 'products', 32, 'periodicals', 'month', 1, '155.0000', 4, '0', 0),
(76, 'none', 'products', 21, 'periodicals', 'month', 3, '84.0000', 5, '0', 1),
(77, 'none', 'products', 21, 'periodicals', 'month', 6, '168.0000', 5, '0', 2),
(78, 'none', 'products', 21, 'periodicals', 'year', 1, '302.4000', 5, '10', 3),
(79, 'none', 'products', 22, 'periodicals', 'month', 3, '84.0000', 5, '0', 1),
(80, 'none', 'products', 22, 'periodicals', 'month', 6, '168.0000', 5, '0', 2),
(81, 'none', 'products', 22, 'periodicals', 'year', 1, '302.4000', 5, '10', 3),
(82, 'none', 'products', 23, 'periodicals', 'month', 3, '102.0000', 5, '0', 1),
(83, 'none', 'products', 23, 'periodicals', 'month', 6, '204.0000', 5, '0', 2),
(84, 'none', 'products', 23, 'periodicals', 'year', 1, '367.0000', 5, '10', 3),
(85, 'none', 'products', 33, 'periodicals', 'month', 1, '14.0000', 4, '0', 0),
(86, 'none', 'products', 33, 'periodicals', 'month', 3, '42.0000', 4, '0', 1),
(87, 'none', 'products', 33, 'periodicals', 'month', 6, '84.0000', 4, '0', 2),
(88, 'none', 'products', 33, 'periodicals', 'year', 1, '151.2000', 4, '10', 3),
(89, 'none', 'products', 34, 'periodicals', 'month', 1, '24.0000', 4, '0', 0),
(90, 'none', 'products', 34, 'periodicals', 'month', 3, '72.0000', 4, '0', 1),
(91, 'none', 'products', 34, 'periodicals', 'month', 6, '144.0000', 4, '0', 2),
(92, 'none', 'products', 34, 'periodicals', 'year', 1, '259.2000', 4, '10', 3),
(94, 'none', 'products', 36, 'periodicals', 'month', 1, '39.0000', 4, '0', 0),
(95, 'none', 'products', 36, 'periodicals', 'month', 3, '117.0000', 4, '0', 1),
(96, 'none', 'products', 36, 'periodicals', 'month', 6, '234.0000', 4, '0', 2),
(97, 'none', 'products', 36, 'periodicals', 'year', 1, '421.2000', 4, '10', 3),
(98, 'none', 'products', 37, 'periodicals', 'month', 1, '199.0000', 4, '0', 0),
(99, 'none', 'products', 37, 'periodicals', 'month', 3, '597.0000', 4, '0', 1),
(100, 'none', 'products', 37, 'periodicals', 'month', 6, '1.1900', 4, '0', 2),
(101, 'none', 'products', 37, 'periodicals', 'year', 1, '2.1500', 4, '10', 3),
(102, 'none', 'products', 30, 'periodicals', 'month', 3, '147.0000', 4, '0', 1),
(103, 'none', 'products', 30, 'periodicals', 'month', 6, '294.0000', 4, '0', 2),
(104, 'none', 'products', 30, 'periodicals', 'year', 1, '529.2000', 4, '10', 3),
(105, 'none', 'products', 31, 'periodicals', 'month', 3, '267.0000', 4, '0', 1),
(106, 'none', 'products', 31, 'periodicals', 'month', 6, '534.0000', 4, '0', 2),
(107, 'none', 'products', 31, 'periodicals', 'year', 1, '961.2000', 4, '10', 3),
(108, 'none', 'products', 32, 'periodicals', 'month', 3, '465.0000', 4, '0', 1),
(109, 'none', 'products', 32, 'periodicals', 'month', 6, '930.0000', 4, '0', 2),
(110, 'none', 'products', 32, 'periodicals', 'year', 1, '1.6700', 4, '10', 3),
(111, 'none', 'products', 38, 'periodicals', 'month', 1, '16.0000', 5, '0', 0),
(112, 'none', 'products', 38, 'periodicals', 'month', 3, '48.0000', 5, '0', 1),
(113, 'none', 'products', 38, 'periodicals', 'month', 6, '96.0000', 5, '0', 2),
(114, 'none', 'products', 38, 'periodicals', 'year', 1, '172.8000', 5, '10', 3),
(115, 'none', 'products', 39, 'periodicals', 'month', 1, '26.0000', 5, '0', 0),
(116, 'none', 'products', 39, 'periodicals', 'month', 3, '78.0000', 5, '0', 1),
(117, 'none', 'products', 39, 'periodicals', 'month', 6, '156.0000', 5, '0', 2),
(118, 'none', 'products', 39, 'periodicals', 'year', 1, '280.8000', 5, '10', 3),
(119, 'none', 'products', 40, 'periodicals', 'month', 1, '52.0000', 5, '0', 0),
(120, 'none', 'products', 40, 'periodicals', 'month', 3, '156.0000', 5, '0', 1),
(121, 'none', 'products', 40, 'periodicals', 'month', 6, '468.0000', 5, '0', 2),
(122, 'none', 'products', 40, 'periodicals', 'year', 1, '842.4000', 5, '10', 3),
(123, 'none', 'products', 41, 'periodicals', 'month', 1, '99.0000', 5, '0', 0),
(124, 'none', 'products', 41, 'periodicals', 'month', 3, '297.0000', 5, '0', 1),
(125, 'none', 'products', 41, 'periodicals', 'month', 6, '594.0000', 5, '0', 2),
(126, 'none', 'products', 41, 'periodicals', 'year', 1, '1.0700', 5, '10', 3),
(127, 'none', 'products', 42, 'periodicals', 'month', 1, '14.9900', 5, '0', 0),
(128, 'none', 'products', 42, 'periodicals', 'month', 3, '44.9700', 5, '0', 1),
(129, 'none', 'products', 42, 'periodicals', 'month', 6, '89.9400', 5, '0', 2),
(130, 'none', 'products', 42, 'periodicals', 'year', 1, '161.8900', 5, '10', 3),
(131, 'none', 'products', 43, 'periodicals', 'month', 1, '29.9900', 5, '0', 0),
(132, 'none', 'products', 43, 'periodicals', 'month', 3, '89.9700', 5, '0', 1),
(133, 'none', 'products', 43, 'periodicals', 'month', 6, '179.9400', 5, '0', 2),
(134, 'none', 'products', 43, 'periodicals', 'year', 1, '323.8900', 5, '10', 3),
(135, 'none', 'products', 44, 'periodicals', 'month', 1, '54.0000', 5, '0', 0),
(136, 'none', 'products', 44, 'periodicals', 'month', 3, '162.0000', 5, '0', 1),
(137, 'none', 'products', 44, 'periodicals', 'month', 6, '324.0000', 5, '0', 2),
(138, 'none', 'products', 44, 'periodicals', 'year', 1, '583.2000', 5, '10', 3),
(149, 'none', 'products', 49, 'periodicals', 'month', 1, '1.0000', 4, '0', 0),
(140, 'none', 'products', 27, 'periodicals', 'month', 3, '135.0000', 5, '0', 1),
(141, 'none', 'products', 27, 'periodicals', 'month', 6, '270.0000', 5, '0', 2),
(142, 'none', 'products', 27, 'periodicals', 'year', 1, '486.0000', 5, '10', 3),
(143, 'none', 'products', 26, 'periodicals', 'month', 3, '237.0000', 5, '0', 1),
(144, 'none', 'products', 26, 'periodicals', 'month', 6, '474.0000', 5, '0', 2),
(145, 'none', 'products', 26, 'periodicals', 'year', 1, '853.2000', 5, '10', 3),
(154, 'none', 'products', 54, 'periodicals', 'none', 1, '55.0000', 4, '0', 0),
(155, 'none', 'products', 55, 'periodicals', 'none', 1, '200.0000', 4, '0', 0),
(156, 'none', 'products', 56, 'periodicals', 'none', 1, '300.0000', 4, '0', 0),
(157, 'none', 'products', 57, 'periodicals', 'none', 1, '600.0000', 4, '0', 0),
(158, 'none', 'products', 58, 'sale', 'none', 0, '24.0000', 4, '0', 0),
(162, 'none', 'products', 62, 'sale', 'none', 0, '449.0000', 4, '0', 0),
(163, 'none', 'products', 63, 'sale', 'none', 0, '690.0000', 4, '0', 0),
(164, 'none', 'products', 64, 'sale', 'none', 0, '1195.0000', 4, '0', 0),
(165, 'none', 'products', 65, 'sale', 'none', 0, '2.7500', 4, '0', 0),
(182, 'none', 'tld', 13, 'register', 'none', 0, '15.0000', 4, '0', 0),
(183, 'none', 'tld', 13, 'renewal', 'none', 0, '15.0000', 4, '0', 0),
(184, 'none', 'tld', 14, 'register', 'none', 0, '24.1000', 4, '0', 0),
(185, 'none', 'tld', 14, 'renewal', 'none', 0, '24.1000', 4, '0', 0),
(186, 'none', 'tld', 15, 'register', 'none', 0, '16.6000', 4, '0', 0),
(187, 'none', 'tld', 15, 'renewal', 'none', 0, '16.6000', 4, '0', 0),
(188, 'none', 'tld', 16, 'register', 'none', 0, '12.8000', 4, '0', 0),
(189, 'none', 'tld', 16, 'renewal', 'none', 0, '12.8000', 4, '0', 0),
(190, 'none', 'tld', 17, 'register', 'none', 0, '12.8000', 4, '0', 0),
(191, 'none', 'tld', 17, 'renewal', 'none', 0, '12.8000', 4, '0', 0),
(192, 'none', 'tld', 18, 'register', 'none', 0, '9.6100', 4, '0', 0),
(193, 'none', 'tld', 18, 'renewal', 'none', 0, '9.6100', 4, '0', 0),
(194, 'none', 'tld', 19, 'register', 'none', 0, '31.7000', 4, '0', 0),
(195, 'none', 'tld', 19, 'renewal', 'none', 0, '31.7000', 4, '0', 0),
(196, 'none', 'tld', 20, 'register', 'none', 0, '8.9900', 4, '0', 0),
(197, 'none', 'tld', 20, 'renewal', 'none', 0, '8.9900', 4, '0', 0),
(198, 'none', 'tld', 21, 'register', 'none', 0, '8.9900', 4, '0', 0),
(199, 'none', 'tld', 21, 'renewal', 'none', 0, '8.9900', 4, '0', 0),
(202, 'none', 'tld', 23, 'register', 'none', 0, '9.7200', 4, '0', 0),
(203, 'none', 'tld', 23, 'renewal', 'none', 0, '9.7200', 4, '0', 0),
(204, 'none', 'tld', 24, 'register', 'none', 0, '10.0000', 4, '0', 0),
(205, 'none', 'tld', 24, 'renewal', 'none', 0, '10.0000', 4, '0', 0),
(206, 'none', 'tld', 25, 'register', 'none', 0, '15.9000', 4, '0', 0),
(207, 'none', 'tld', 25, 'renewal', 'none', 0, '15.9000', 4, '0', 0),
(210, 'none', 'tld', 27, 'register', 'none', 0, '38.0000', 4, '0', 0),
(211, 'none', 'tld', 27, 'renewal', 'none', 0, '38.0000', 4, '0', 0),
(212, 'none', 'tld', 28, 'register', 'none', 0, '30.4000', 4, '0', 0),
(213, 'none', 'tld', 28, 'renewal', 'none', 0, '30.4000', 4, '0', 0),
(214, 'none', 'tld', 29, 'register', 'none', 0, '21.0000', 4, '0', 0),
(215, 'none', 'tld', 29, 'renewal', 'none', 0, '21.0000', 4, '0', 0),
(216, 'none', 'tld', 30, 'register', 'none', 0, '12.0000', 4, '0', 0),
(217, 'none', 'tld', 30, 'renewal', 'none', 0, '12.0000', 4, '0', 0),
(218, 'none', 'tld', 31, 'register', 'none', 0, '16.6000', 4, '0', 0),
(219, 'none', 'tld', 31, 'renewal', 'none', 0, '16.6000', 4, '0', 0),
(220, 'none', 'tld', 32, 'register', 'none', 0, '30.0000', 4, '0', 0),
(221, 'none', 'tld', 32, 'renewal', 'none', 0, '30.0000', 4, '0', 0),
(222, 'none', 'tld', 33, 'register', 'none', 0, '29.2000', 4, '0', 0),
(223, 'none', 'tld', 33, 'renewal', 'none', 0, '29.2000', 4, '0', 0),
(224, 'none', 'tld', 34, 'register', 'none', 0, '39.2000', 4, '0', 0),
(225, 'none', 'tld', 34, 'renewal', 'none', 0, '39.2000', 4, '0', 0),
(226, 'none', 'tld', 35, 'register', 'none', 0, '8.9900', 4, '0', 0),
(227, 'none', 'tld', 35, 'renewal', 'none', 0, '8.9900', 4, '0', 0),
(260, 'none', 'tld', 33, 'transfer', 'none', 0, '29.2000', 4, '0', 0),
(259, 'none', 'tld', 24, 'transfer', 'none', 0, '10.0000', 4, '0', 0),
(1115, 'none', 'softwares', 64, 'periodicals', 'none', 1, '125.0000', 4, '0', 0),
(254, 'none', 'tld', 8, 'transfer', 'none', 0, '13.0000', 4, '0', 0),
(251, 'none', 'tld', 41, 'register', 'none', 0, '8.7500', 4, '0', 0),
(252, 'none', 'tld', 41, 'renewal', 'none', 0, '8.7500', 4, '0', 0),
(253, 'none', 'tld', 7, 'transfer', 'none', 0, '9.9900', 4, '0', 0),
(261, 'none', 'tld', 29, 'transfer', 'none', 0, '21.0000', 4, '0', 0),
(262, 'none', 'tld', 30, 'transfer', 'none', 0, '12.0000', 4, '0', 0),
(263, 'none', 'tld', 23, 'transfer', 'none', 0, '9.7200', 4, '0', 0),
(264, 'none', 'tld', 31, 'transfer', 'none', 0, '16.6000', 4, '0', 0),
(265, 'none', 'tld', 34, 'transfer', 'none', 0, '39.2000', 4, '0', 0),
(266, 'none', 'tld', 17, 'transfer', 'none', 0, '12.8000', 4, '0', 0),
(267, 'none', 'tld', 20, 'transfer', 'none', 0, '8.9900', 4, '0', 0),
(269, 'none', 'tld', 35, 'transfer', 'none', 0, '8.9900', 4, '0', 0),
(270, 'none', 'tld', 32, 'transfer', 'none', 0, '30.0000', 4, '0', 0),
(271, 'none', 'tld', 21, 'transfer', 'none', 0, '8.9900', 4, '0', 0),
(272, 'none', 'tld', 28, 'transfer', 'none', 0, '30.4000', 4, '0', 0),
(273, 'none', 'tld', 14, 'transfer', 'none', 0, '24.1000', 4, '0', 0),
(275, 'none', 'tld', 16, 'transfer', 'none', 0, '12.8000', 4, '0', 0),
(276, 'none', 'tld', 18, 'transfer', 'none', 0, '9.6100', 4, '0', 0),
(278, 'none', 'tld', 27, 'transfer', 'none', 0, '38.0000', 4, '0', 0),
(282, 'none', 'tld', 41, 'transfer', 'none', 0, '8.7500', 4, '0', 0),
(950, 'none', 'tld', 41, 'renewal', 'none', 0, '0.0000', 4, '0', 0),
(1072, 'none', 'tld', 15, 'transfer', 'none', 0, '16.6000', 4, '0', 0),
(1116, 'none', 'softwares', 65, 'periodicals', 'none', 1, '55.0000', 4, '0', 0),
(1164, 'none', 'products', 97, 'periodicals', 'year', 1, '124.0000', 4, '20', 0),
(1163, 'none', 'products', 96, 'periodicals', 'month', 1, '12.9000', 4, '', 0),
(1162, 'none', 'products', 95, 'periodicals', 'year', 1, '143.0000', 4, '20', 0),
(1161, 'none', 'products', 94, 'periodicals', 'month', 1, '14.9000', 4, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privileges` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `name`, `privileges`) VALUES
(1, 'Full Administrator', 'EDIT_YOUR_ACCOUNT,DASHBOARD_STATISTIC_INCOME,DASHBOARD_STATISTIC_CASH,DASHBOARD_STATISTIC_USER,DASHBOARD_STATISTIC_TICKETS,DASHBOARD_STATISTIC_OVINV,DASHBOARD_STATISTIC_UPDS,DASHBOARD_STATISTIC_SEPS,DASHBOARD_STATISTIC_TYRS,DASHBOARD_PANEL_LAST_ORDERS,DASHBOARD_PANEL_NOTES,DASHBOARD__PANEL_ONLINES,DASHBOARD__PANEL_CLIENT_ONLINES,DASHBOARD_PANEL_PENDING_INVOICES,DASHBOARD_PANEL_PENDING_TICKETS,DASHBOARD_PANEL_REMINDERS,DASHBOARD_PANEL_TASKS,SETTINGS_FRAUD_PROTECTION,SETTINGS_INFORMATIONS_CONFIGURE,SETTINGS_THEME_CONFIGURE,SETTINGS_HOME_CONFIGURE,SETTINGS_LOCALIZATION_CONFIGURE,SETTINGS_SEO_CONFIGURE,SETTINGS_BACKGROUNDS_CONFIGURE,SETTINGS_MEMBERSHIP_CONFIGURE,SETTINGS_OTHER_CONFIGURE,NOTIFICATIONS_TEMPLATES,FINANCIAL_TAXATION,MODULES_PAYMENT_SETTINGS,FINANCIAL_CURRENCIES,FINANCIAL_PROMOTIONS,FINANCIAL_COUPONS,SECURITY_SETTINGS,SECURITY_BACKUP,ADMIN_CONFIGURE,ADMIN_PRIVILEGES,ADMIN_DEPARTMENTS,AUTOMATION_SETTINGS,MODULES_MAIL_SETTINGS,MODULES_SMS_SETTINGS,MODULES_REGISTRARS_SETTINGS,MODULES_SERVERS_SETTINGS,PRODUCTS_LOOK,PRODUCTS_OPERATION,PRODUCTS_GROUP_LOOK,PRODUCTS_GROUP_OPERATION,PRODUCTS_API,ORDERS_LOOK,ORDERS_OPERATION,ORDERS_DELETE,INVOICES_LOOK,INVOICES_OPERATION,INVOICES_DELETE,INVOICES_CASH,CONTACT_FORM_LOOK,CONTACT_FORM_OPERATION,CONTACT_FORM_DELETE,TICKETS_LOOK,TICKETS_OPERATION,TICKETS_DELETE,TICKETS_PREDEFINED_REPLIES,TICKETS_CUSTOM_FIELDS,KNOWLEDGEBASE_LOOK,KNOWLEDGEBASE_OPERATION,KNOWLEDGEBASE_DELETE,USERS_LOOK,USERS_OPERATION,USERS_DELETE,USERS_MANAGE_CREDIT,USERS_AFFILIATE,USERS_DEALERSHIP,USERS_DOCUMENT_VERIFICATION,USERS_BLACKLIST,MANAGE_WEBSITE_LOOK,MANAGE_WEBSITE_OPERATION,MANAGE_WEBSITE_DELETE,WANALYTICS,TOOLS_ADDONS,TOOLS_BULK_MAIL,TOOLS_BULK_SMS,TOOLS_SMS_LOGS,TOOLS_MAIL_LOGS,TOOLS_ACTIONS,TOOLS_IMPORTS,TOOLS_REMINDERS,TOOLS_TASKS,TOOLS_BTK_REPORTS,LANGUAGES_LOOK,LANGUAGES_OPERATION,HELP_HEALTH,HELP_UPDATES_LOOK,HELP_UPDATES_OPERATION,HELP_LICENSE,HELP_USE_GUIDE,UPLOAD_EDITOR_PICTURE');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `category` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `categories` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'visible',
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `rank` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `stock` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `override_usrcurrency` int(1) NOT NULL DEFAULT '0',
  `taxexempt` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `upgrade` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `options` text COLLATE utf8mb4_unicode_ci,
  `affiliate_disable` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `affiliate_rate` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `upgradeable_products` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addons` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirements` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `module_data` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `type`, `type_id`, `category`, `categories`, `status`, `visibility`, `ctime`, `rank`, `stock`, `override_usrcurrency`, `taxexempt`, `upgrade`, `options`, `affiliate_disable`, `affiliate_rate`, `upgradeable_products`, `addons`, `requirements`, `module`, `module_data`, `notes`) VALUES
(52, 'special', 194, 196, NULL, 'active', 'visible', '2018-03-23 17:28:15', 1, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false}', 0, '0.00', NULL, '', '', 'none', NULL, ''),
(2, 'special', 9, 0, NULL, 'active', 'visible', '2017-10-28 14:28:11', 2, '0', 0, 0, 0, NULL, 0, '0.00', NULL, NULL, NULL, 'none', NULL, NULL),
(3, 'special', 9, 0, NULL, 'active', 'visible', '2017-10-28 14:44:22', 3, '0', 0, 0, 0, NULL, 0, '0.00', NULL, NULL, NULL, 'none', NULL, NULL),
(15, 'hosting', 0, 164, NULL, 'active', 'visible', '2018-03-19 10:18:47', 1, '', 1, 0, 0, '{\"panel_type\":\"SampleHostingCP\",\"panel_link\":\"\",\"disk_limit\":\"2048\",\"bandwidth_limit\":\"10240\",\"email_limit\":\"5\",\"database_limit\":\"5\",\"addons_limit\":\"0\",\"subdomain_limit\":\"3\",\"ftp_limit\":\"unlimited\",\"park_limit\":\"0\",\"max_email_per_hour\":\"60\",\"cpu_limit\":\"%20\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"\",\"ns2\":\"\",\"ns3\":\"\",\"ns4\":\"\"},\"server_id\":\"23\"}', 0, '1.00', '', '8,9', '', 'SampleHostingCP', '{\"example1\":\"asdasdsa1\",\"example2\":\"burak13579\",\"example3\":\"1\",\"example4\":\"Option 1\",\"example5\":\"opt2\",\"example6\":\"Option 3\",\"example7\":\"opt4\",\"example8\":\"dasdsad asdsadsa dasdsad asdsadsa dasdsad asdsadsa dasdsad asdsadsa dasdsad asdsadsa dasdsad asdsadsa dasdsad asdsadsa dasdsad asdsadsa \"}', ''),
(16, 'hosting', 0, 164, NULL, 'active', 'visible', '2018-03-19 13:18:38', 2, '', 0, 0, 0, '{\"panel_type\":\"DirectAdmin\",\"panel_link\":\"\",\"disk_limit\":\"100\",\"bandwidth_limit\":\"500\",\"email_limit\":\"unlimited\",\"database_limit\":\"unlimited\",\"addons_limit\":\"unlimited\",\"subdomain_limit\":\"unlimited\",\"ftp_limit\":\"unlimited\",\"park_limit\":\"unlimited\",\"max_email_per_hour\":\"unlimited\",\"cpu_limit\":\"%20\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"\",\"ns2\":\"\",\"ns3\":\"\",\"ns4\":\"\"},\"renewal_selection_hide\":false,\"auto_install\":1,\"popular\":true,\"server_id\":\"26\"}', 0, '0.00', '', '8,9', '', 'DirectAdmin', '{\"reseller_ip\":\"shared\",\"reseller_plan\":\"\"}', ''),
(22, 'server', 0, 24, NULL, 'active', 'visible', '2018-03-20 12:41:04', 2, '0', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"processor\":\"Intel C2750 - 8 Core\",\"ram\":\"8 GB\",\"disk-space\":\"120 GB SSD\",\"bandwidth\":\"1 Gbps\",\"raid\":\"Software\",\"server_id\":\"24\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '', 'SampleServerCP', '{\"example1\":\"sample asdsad\",\"example2\":\"sample\",\"example3\":\"1\",\"example4\":\"Option 2\",\"example5\":\"opt1\",\"example6\":\"Option 2\",\"example7\":\"opt1\",\"example8\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\"}', ''),
(17, 'hosting', 0, 164, NULL, 'active', 'visible', '2018-03-19 14:20:13', 3, '', 0, 0, 0, '{\"panel_type\":\"cPanel\",\"panel_link\":\"\",\"disk_limit\":\"100\",\"bandwidth_limit\":\"1024\",\"email_limit\":\"3\",\"database_limit\":\"3\",\"addons_limit\":\"0\",\"subdomain_limit\":\"2\",\"ftp_limit\":\"3\",\"park_limit\":\"0\",\"max_email_per_hour\":\"unlimited\",\"cpu_limit\":\"%20\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"ns3.sitemio.com\",\"ns2\":\"ns4.sitemio.com\",\"ns3\":\"\",\"ns4\":\"\"},\"renewal_selection_hide\":false,\"auto_install\":1,\"server_id\":\"27\"}', 0, '0.00', '', '8,9', '', 'cPanel', '{\"account_limit\":\"\",\"disk_limit\":\"\",\"bandwidth_limit\":\"\",\"acllist\":\"\",\"plan\":\"fdgdsemf_Package1\"}', ''),
(23, 'server', 0, 24, NULL, 'active', 'visible', '2018-03-20 12:45:47', 3, '0', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"Intel C2750 - 8 Core\",\"ram\":\"16 GB\",\"disk-space\":\"750 GB SATA\",\"bandwidth\":\"1 Gbps\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(18, 'hosting', 0, 165, NULL, 'active', 'visible', '2018-03-19 14:29:44', 1, '', 0, 0, 0, '{\"panel_type\":\"cPanel\",\"panel_link\":\"\",\"disk_limit\":\"unlimited\",\"bandwidth_limit\":\"10240\",\"email_limit\":\"unlimited\",\"database_limit\":\"unlimited\",\"addons_limit\":\"1\",\"subdomain_limit\":\"unlimited\",\"ftp_limit\":\"unlimited\",\"park_limit\":\"unlimited\",\"max_email_per_hour\":\"unlimited\",\"cpu_limit\":\"%20\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"ns3.sitemio.com\",\"ns2\":\"ns4.sitemio.com\",\"ns3\":\"\",\"ns4\":\"\"},\"renewal_selection_hide\":false,\"auto_install\":0}', 0, '0.00', '', '8,9', '', '', '', ''),
(19, 'hosting', 0, 165, NULL, 'active', 'visible', '2018-03-19 14:58:09', 2, '', 0, 0, 0, '{\"panel_type\":\"cPanel\",\"disk_limit\":\"3072\",\"bandwidth_limit\":\"30720\",\"email_limit\":\"unlimited\",\"database_limit\":\"unlimited\",\"addons_limit\":\"4\",\"subdomain_limit\":\"unlimited\",\"ftp_limit\":\"unlimited\",\"park_limit\":\"unlimited\",\"max_email_per_hour\":\"unlimited\",\"cpu_limit\":\"%20\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"ns3.sitemio.com\",\"ns2\":\"ns4.sitemio.com\",\"ns3\":\"\",\"ns4\":\"\"},\"popular\":true}', 0, '0.00', NULL, '8,9', NULL, 'none', NULL, ''),
(20, 'hosting', 0, 165, NULL, 'active', 'visible', '2018-03-19 15:11:21', 3, '', 0, 0, 0, '{\"panel_type\":\"cPanel\",\"panel_link\":\"\",\"disk_limit\":\"6144\",\"bandwidth_limit\":\"61440\",\"email_limit\":\"unlimited\",\"database_limit\":\"unlimited\",\"addons_limit\":\"9\",\"subdomain_limit\":\"unlimited\",\"ftp_limit\":\"unlimited\",\"park_limit\":\"unlimited\",\"max_email_per_hour\":\"unlimited\",\"cpu_limit\":\"%20\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"ns3.sitemio.com\",\"ns2\":\"ns4.sitemio.com\",\"ns3\":\"\",\"ns4\":\"\"},\"ctoc-service-transfer\":{\"status\":false,\"limit\":\"\"}}', 0, '0.00', NULL, '8,9', '', '', '', ''),
(21, 'server', 0, 24, NULL, 'active', 'visible', '2018-03-20 12:37:44', 1, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"renewal_selection_hide\":false,\"processor\":\"Intel C2750 - 8 Core\",\"ram\":\"8 GB\",\"disk-space\":\"750 GB SATA\",\"bandwidth\":\"1 Gbps\"}', 0, '0.00', '', '31,10,11,12,13,14,15,16', '', '', '', ''),
(24, 'server', 0, 171, NULL, 'active', 'visible', '2018-03-20 12:51:29', 1, '21', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"Intel C2350 1,70GHz\",\"ram\":\"4 GB\",\"disk-space\":\"1 x 120 GB SSD\",\"bandwidth\":\"1Gbps \\/ 200Mbps\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(25, 'server', 0, 171, NULL, 'active', 'visible', '2018-03-20 12:53:48', 2, '22', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"processor\":\"Intel C2750 2.40GHz\\t\",\"ram\":\"16 GB\",\"disk-space\":\"1 x 1TB SATA\",\"bandwidth\":\"1Gbps \\/ 200Mbps\"}', 0, '12.00', '', '10,11,12,13,14,15,16', '', '', '', ''),
(26, 'server', 0, 172, NULL, 'active', 'visible', '2018-03-20 12:56:37', 1, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"Intel Xeon W3520\",\"ram\":\"16 GB\",\"disk-space\":\"2 x 2TB SATA\",\"bandwidth\":\"1Gbps \\/ 250Mbps\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(27, 'server', 0, 171, NULL, 'active', 'visible', '2018-03-20 13:01:21', 3, '25', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"Intel C2750 2.40GHz\",\"ram\":\"16 GB\",\"disk-space\":\"1 x 250GB SSD\",\"bandwidth\":\"1Gbps \\/ 200Mbps\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(28, 'server', 0, 26, NULL, 'active', 'visible', '2018-03-20 13:10:57', 1, '20', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"Intel Core i7-920\",\"ram\":\"24 GB\",\"disk-space\":\"2 x 750 GB\",\"bandwidth\":\"1Gbps\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(29, 'server', 0, 26, NULL, 'active', 'visible', '2018-03-20 13:12:20', 2, '36', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"Intel Core i7-920\",\"ram\":\"8 GB\",\"disk-space\":\"2 x 750 GB\",\"bandwidth\":\"1Gbps\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(30, 'server', 0, 174, NULL, 'active', 'visible', '2018-03-20 13:20:48', 1, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"1600 MHZ\",\"ram\":\"1 GB RAM\",\"disk-space\":\"25 GB SSD\",\"bandwidth\":\"1Gbps \\/ Unlimited\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(31, 'server', 0, 174, NULL, 'active', 'visible', '2018-03-20 13:24:18', 2, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"processor\":\"2000 MHZ\",\"ram\":\"2 GB RAM\",\"disk-space\":\"50 GB SSD\",\"bandwidth\":\"1Gbps \\/ Unlimited\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '', '', '', ''),
(32, 'server', 0, 174, NULL, 'active', 'visible', '2018-03-20 13:47:29', 3, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":true,\"processor\":\"3000 MHZ\",\"ram\":\"4 GB RAM\",\"disk-space\":\"75 GB SSD\",\"bandwidth\":\"1Gbps \\/ Unlimited\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(33, 'hosting', 0, 166, NULL, 'active', 'visible', '2018-03-22 16:45:24', 1, NULL, 0, 0, 0, '{\"panel_type\":\"cPanel\",\"panel_link\":\"\",\"disk_limit\":\"1024\",\"bandwidth_limit\":\"unlimited\",\"email_limit\":\"unlimited\",\"database_limit\":\"unlimited\",\"addons_limit\":\"unlimited\",\"subdomain_limit\":\"unlimited\",\"ftp_limit\":\"unlimited\",\"park_limit\":\"unlimited\",\"max_email_per_hour\":\"100\",\"cpu_limit\":\"%35\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"ns1.sitemio.com\",\"ns2\":\"ns2.sitemio.com\",\"ns3\":\"\",\"ns4\":\"\"},\"renewal_selection_hide\":false,\"auto_install\":1,\"server_id\":\"27\"}', 0, '0.00', '', '8,9', '', 'cPanel', '{\"reseller\":\"1\",\"account_limit\":\"\",\"enable_resource_limits\":\"1\",\"disk_limit\":\"10240\",\"bandwidth_limit\":\"\",\"acllist\":\"\",\"plan\":\"1 GB\"}', ''),
(34, 'hosting', 0, 166, NULL, 'active', 'visible', '2018-03-22 17:23:37', 2, NULL, 0, 0, 0, '{\"panel_type\":\"cPanel\",\"disk_limit\":\"1000\",\"bandwidth_limit\":\"unlimited\",\"email_limit\":\"unlimited\",\"database_limit\":\"unlimited\",\"addons_limit\":\"unlimited\",\"subdomain_limit\":\"unlimited\",\"ftp_limit\":\"unlimited\",\"park_limit\":\"unlimited\",\"max_email_per_hour\":\"unlimited\",\"cpu_limit\":\"%35\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"ns1.sitemio.com\",\"ns2\":\"ns2.sitemio.com\",\"ns3\":\"\",\"ns4\":\"\"},\"popular\":true}', 0, '0.00', NULL, '8,9', NULL, 'none', NULL, ''),
(36, 'hosting', 0, 166, NULL, 'active', 'visible', '2018-03-22 18:00:28', 0, NULL, 0, 0, 0, '{\"panel_type\":\"cPanel\",\"panel_link\":\"\",\"disk_limit\":\"1000\",\"bandwidth_limit\":\"unlimited\",\"email_limit\":\"unlimited\",\"database_limit\":\"unlimited\",\"addons_limit\":\"unlimited\",\"subdomain_limit\":\"unlimited\",\"ftp_limit\":\"unlimited\",\"park_limit\":\"unlimited\",\"max_email_per_hour\":\"unlimited\",\"cpu_limit\":\"%35\",\"server_features\":[\"CloudLinux\",\"LiteSpeed\"],\"dns\":{\"ns1\":\"ns1.sitemio.com\",\"ns2\":\"ns2.sitemio.com\",\"ns3\":\"\",\"ns4\":\"\"},\"popular\":true}', 0, '8.00', '', '8,9', '', '', '', ''),
(37, 'server', 0, 174, NULL, 'active', 'visible', '2018-03-22 22:02:23', 4, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"4000 MHZ\",\"ram\":\"6 GB\",\"disk-space\":\"100 GB SSD\",\"bandwidth\":\"1Gbps \\/ Unlimited\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(38, 'server', 0, 176, NULL, 'active', 'visible', '2018-03-22 22:21:26', 1, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"processor\":\"1 Core\",\"ram\":\"1 GB\",\"disk-space\":\"30 GB SSD\",\"bandwidth\":\"1 Gbps \\/ Unlimited\"}', 0, '0.00', NULL, '28,10,11,12,13,14,15,16', '', '', '', ''),
(39, 'server', 0, 176, NULL, 'active', 'visible', '2018-03-23 13:41:04', 2, '', 0, 0, 0, '{\"popular\":true,\"auto_install\":0,\"processor\":\"2 Core\",\"ram\":\"2 GB RAM\",\"disk-space\":\"60 GB SSD\",\"bandwidth\":\"1Gbps \\/ Unlimited\"}', 0, '0.00', '', '10,11,12,13,14,15,16', '21', '', '', ''),
(40, 'server', 0, 176, NULL, 'active', 'visible', '2018-03-23 13:44:29', 3, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"3 Core\",\"ram\":\"4 GB RAM\",\"disk-space\":\"120 GB SSD\",\"bandwidth\":\"1Gbps \\/ Unlimited\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(41, 'server', 0, 176, NULL, 'active', 'visible', '2018-03-23 13:54:34', 4, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"4 Core\",\"ram\":\"6 GB RAM\",\"disk-space\":\"200 GB SSD\",\"bandwidth\":\"1Gbps \\/ Unlimited\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(42, 'server', 0, 175, NULL, 'active', 'visible', '2018-03-23 14:22:02', 1, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"processor\":\"4 Core\",\"ram\":\"12 GB RAM\",\"disk-space\":\"300 GB SSD\",\"bandwidth\":\"100 Mbit \\/ Unlimited\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(43, 'server', 0, 175, NULL, 'active', 'visible', '2018-03-23 14:33:57', 2, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":true,\"processor\":\"6 Core\",\"ram\":\"24 GB RAM\",\"disk-space\":\"600 GB SSD\",\"bandwidth\":\"100 Mbit \\/ Unlimited\"}', 0, '0.00', NULL, '10,11,12,13,14,15,16', '7,6,5,4', 'none', NULL, ''),
(44, 'server', 0, 175, NULL, 'active', 'visible', '2018-03-23 14:39:09', 3, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"hide-identifying-server-info\":0,\"processor\":\"10 Core\",\"ram\":\"50 GB RAM\",\"disk-space\":\"1200 GB SSD\",\"bandwidth\":\"1 Gbit \\/ Unlimited\"}', 0, '0.00', NULL, '', '', '', '', ''),
(49, 'special', 194, 195, NULL, 'active', 'visible', '2018-03-23 17:09:55', 1, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"cover_link\":\"\",\"renewal_selection_hide\":false,\"auto_install\":0,\"show_domain\":0}', 0, '0.00', '', '', '', 'none', '', ''),
(50, 'special', 194, 195, NULL, 'active', 'visible', '2018-03-23 17:14:49', 2, '', 0, 0, 0, '{\"popular\":true}', 0, '0.00', NULL, '', '', 'none', NULL, ''),
(51, 'special', 194, 195, NULL, 'active', 'visible', '2018-03-23 17:18:04', 3, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false}', 0, '0.00', NULL, '', '', 'none', NULL, ''),
(53, 'special', 194, 196, NULL, 'active', 'visible', '2018-03-23 17:28:48', 2, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":true,\"cover_link\":\"\",\"download_file\":\"2018-07-14\\/94a318c24fb746cbd8d076a.png\"}', 0, '0.00', NULL, '', '', 'none', NULL, ''),
(54, 'special', 194, 196, NULL, 'active', 'visible', '2018-03-23 17:30:46', 3, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"cover_link\":\"\"}', 0, '0.00', NULL, '', '', 'none', NULL, ''),
(55, 'special', 194, 197, NULL, 'active', 'visible', '2018-03-23 17:34:00', 1, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":false,\"cover_link\":\"\"}', 0, '0.00', NULL, '', '', 'none', NULL, ''),
(56, 'special', 194, 197, NULL, 'active', 'visible', '2018-03-23 17:34:51', 2, '', 0, 0, 0, '{\"external_link\":\"\",\"popular\":true,\"cover_link\":\"\"}', 0, '0.00', NULL, '', '', 'none', NULL, ''),
(57, 'special', 194, 197, NULL, 'active', 'visible', '2018-03-23 17:37:28', 3, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"show_domain\":0}', 0, '0.00', NULL, '', '', 'none', '', ''),
(58, 'sms', 0, 0, NULL, 'active', 'visible', '2018-03-24 20:36:06', 1, NULL, 0, 0, 0, '', 0, '0.00', NULL, NULL, NULL, 'none', NULL, ''),
(59, 'sms', 0, 0, NULL, 'active', 'visible', '2018-03-26 16:05:34', 2, NULL, 0, 0, 0, '{\"popular\":true}', 0, '0.00', NULL, NULL, NULL, 'none', NULL, ''),
(60, 'sms', 0, 0, NULL, 'active', 'visible', '2018-03-26 16:06:10', 3, NULL, 0, 0, 0, '', 0, '0.00', NULL, NULL, NULL, 'none', NULL, ''),
(61, 'sms', 0, 0, NULL, 'active', 'visible', '2018-03-26 16:06:59', 4, NULL, 0, 0, 0, '', 0, '0.00', NULL, NULL, NULL, 'none', NULL, ''),
(62, 'sms', 0, 0, NULL, 'active', 'visible', '2018-03-26 16:07:30', 5, NULL, 0, 0, 0, '', 0, '0.00', NULL, NULL, NULL, 'none', NULL, ''),
(63, 'sms', 0, 0, NULL, 'active', 'visible', '2018-03-26 16:08:15', 6, NULL, 0, 0, 0, '', 0, '0.00', NULL, NULL, NULL, 'none', NULL, ''),
(64, 'sms', 0, 0, NULL, 'active', 'visible', '2018-03-26 16:22:30', 7, NULL, 0, 0, 0, '', 0, '0.00', NULL, NULL, NULL, 'none', NULL, ''),
(65, 'sms', 0, 0, NULL, 'active', 'visible', '2018-03-26 16:22:55', 8, NULL, 0, 0, 0, '', 0, '0.00', NULL, NULL, NULL, 'none', NULL, ''),
(91, 'special', 237, 237, NULL, 'active', 'visible', '2019-05-08 12:14:25', 0, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":1,\"show_domain\":1}', 0, '0.00', NULL, '27', '', 'GogetSSL', '{\"product-id\":\"77\",\"disable_dcv_m\":[\"HTTP\",\"HTTPS\",\"DNS\"],\"sans_status\":\"1\",\"included_sans\":\"6\"}', ''),
(92, 'special', 239, 239, NULL, 'active', 'visible', '2019-12-12 16:48:31', 0, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"show_domain\":0}', 0, '0.00', NULL, '', '', 'BuycPanel', '{\"product\":\"cpanelprocloud\",\"Litespeed_cpu\":\"\"}', ''),
(93, 'special', 239, 239, NULL, 'active', 'visible', '2020-01-03 16:41:51', 0, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"show_domain\":0,\"renewal_selection_hide\":false}', 0, '15.00', '', '', '', 'none', '', ''),
(94, 'special', 240, 241, NULL, 'active', 'visible', '2020-02-26 15:05:10', 1, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":1,\"show_domain\":1,\"renewal_selection_hide\":false}', 0, '0.00', '', '', '', 'WISECPReseller', '{\"product\":\"171\"}', ''),
(95, 'special', 240, 241, NULL, 'active', 'visible', '2020-02-26 15:05:10', 1, '', 0, 0, 0, '{\"popular\":true,\"auto_install\":1,\"show_domain\":0,\"renewal_selection_hide\":false}', 0, '0.00', '', '', '', 'WISECPReseller', '{\"product\":\"92\"}', ''),
(96, 'special', 240, 242, NULL, 'active', 'visible', '2020-02-26 15:05:10', 1, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":1,\"show_domain\":1,\"renewal_selection_hide\":false}', 0, '0.00', '', '', '', 'WISECPReseller', '{\"product\":\"174\"}', ''),
(97, 'special', 240, 242, NULL, 'active', 'visible', '2020-02-26 15:05:10', 2, '', 0, 0, 0, '{\"popular\":true,\"auto_install\":1,\"show_domain\":1,\"renewal_selection_hide\":false}', 0, '0.00', '', '', '', 'WISECPReseller', '{\"product\":\"175\"}', ''),
(102, 'special', 240, 242, NULL, 'active', 'visible', '2020-09-01 13:32:10', 3, '', 0, 0, 0, '{\"popular\":false,\"auto_install\":0,\"show_domain\":1,\"renewal_selection_hide\":false}', 0, '0.00', '', '', '', 'WISECPReseller', '{\"product\":\"176\"}', '');

-- --------------------------------------------------------

--
-- Table structure for table `products_addons`
--

CREATE TABLE `products_addons` (
  `id` int(11) UNSIGNED NOT NULL,
  `mcategory` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `override_usrcurrency` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `taxexempt` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `requirements` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type_link` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id_link` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_addons`
--

INSERT INTO `products_addons` (`id`, `mcategory`, `category`, `status`, `rank`, `override_usrcurrency`, `taxexempt`, `requirements`, `product_type_link`, `product_id_link`) VALUES
(10, 'server', 160, 'active', 2, 0, 0, '', '', 0),
(8, 'hosting', 161, 'active', 0, 0, 0, '', NULL, 0),
(9, 'hosting', 161, 'active', 0, 0, 0, '', NULL, 0),
(11, 'server', 160, 'active', 3, 1, 0, '', NULL, 0),
(12, 'server', 160, 'active', 4, 0, 0, '', NULL, 0),
(13, 'server', 160, 'active', 5, 0, 0, '', '', 0),
(14, 'server', 160, 'active', 6, 0, 0, '', NULL, 0),
(15, 'server', 160, 'active', 7, 1, 0, '', NULL, 0),
(16, 'server', 160, 'active', 8, 1, 0, '', NULL, 0),
(19, 'software', 167, 'active', 0, 0, 0, '8', '', 0),
(20, 'software', 167, 'active', 0, 0, 0, '8,9', '', 0),
(21, 'software', 167, 'active', 0, 0, 0, '', NULL, 0),
(24, 'server', 200, 'active', 1, 0, 0, '', NULL, 0),
(27, 'special_237', 238, 'active', 0, 1, 0, '', '', 0),
(28, 'server', 160, 'active', 0, 0, 0, '', '', 0),
(29, 'software', 167, 'active', 0, 0, 0, '', '', 0),
(30, 'special_240', 243, 'active', 1, 0, 0, '', '', 0),
(31, 'server', 200, 'active', 0, 0, 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_addons_lang`
--

CREATE TABLE `products_addons_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `properties` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci,
  `lid` int(8) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_addons_lang`
--

INSERT INTO `products_addons_lang` (`id`, `owner_id`, `lang`, `name`, `description`, `type`, `properties`, `options`, `lid`) VALUES
(42, 11, 'tr', 'Kontrol Paneli', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"cPanel Kontrol Paneli (Trial)\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5},{\"id\":\"1\",\"name\":\"cPanel Kontrol Paneli (VDS)\",\"period\":\"month\",\"period_time\":1,\"amount\":19,\"cid\":4},{\"id\":\"2\",\"name\":\"cPanel Kontrol Paneli (Dedicated)\",\"period\":\"month\",\"period_time\":1,\"amount\":39,\"cid\":4},{\"id\":\"3\",\"name\":\"Plesk Web Host Edition\",\"period\":\"month\",\"period_time\":1,\"amount\":45,\"cid\":4},{\"id\":\"4\",\"name\":\"Plesk Kontrol Paneli (Trial)\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5},{\"id\":\"5\",\"name\":\"Directadmin (Dedicated)\",\"period\":\"month\",\"period_time\":1,\"amount\":25,\"cid\":4}]', 5),
(39, 8, 'tr', 'Yedekleme Hizmeti', 'Verileriniz, farklı ve özel yedekleme sunucularımızda ayrıca muhafaza edilir. Herhangi olumsuz bir durumda siteleriniz güvende olur.', 'radio', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"3 Günde bir Yedekle\",\"period\":\"year\",\"period_time\":1,\"amount\":5,\"cid\":4},{\"id\":\"1\",\"name\":\"7 Günde bir Yedekle\",\"period\":\"year\",\"period_time\":1,\"amount\":9,\"cid\":4}]', 1),
(41, 10, 'tr', 'İşletim Sistemi', '', 'select', '', '[{\"id\":\"0\",\"name\":\"Windows 7 Ultimate\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"1\",\"name\":\"Windows 8.1\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"2\",\"name\":\"Windows 10\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"3\",\"name\":\"Windows Server 2008 R2\",\"period\":\"none\",\"period_time\":0,\"amount\":7.9900000000000002131628207280300557613372802734375,\"cid\":5,\"module\":\"\"},{\"id\":\"4\",\"name\":\"Windows Server 2012 R2\",\"period\":\"none\",\"period_time\":0,\"amount\":9.9900000000000002131628207280300557613372802734375,\"cid\":5,\"module\":\"\"},{\"id\":\"5\",\"name\":\"CentOS 6.8\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"6\",\"name\":\"CentOS 7.2\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"7\",\"name\":\"Debian 7.5\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"8\",\"name\":\"Debian 8.3\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"9\",\"name\":\"Ubuntu Server 14.04\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"10\",\"name\":\"Ubuntu Server 15.10\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"11\",\"name\":\"VMware ESXi 5.x\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"12\",\"name\":\"VMware ESXi 6.x\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"13\",\"name\":\"FreeBSD 9.3\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"14\",\"name\":\"FreeBSD 10.2\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"}]', 14),
(40, 9, 'tr', 'Özel IP Tanımlama', 'Sitenize, paylaşımsız özel bir IP tanımlaması yapın. SEO ve mail trafiği olarak avantaj sağlayın.', 'radio', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"İstiyorum\",\"period\":\"year\",\"period_time\":1,\"amount\":3,\"cid\":4}]', 0),
(43, 12, 'tr', 'IP Adresi', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"1 adet IP Adresi\",\"period\":\"year\",\"period_time\":1,\"amount\":3,\"cid\":5},{\"id\":\"1\",\"name\":\"2 adet IP Adresi\",\"period\":\"year\",\"period_time\":1,\"amount\":6,\"cid\":5},{\"id\":\"2\",\"name\":\"4 adet IP Adresi\",\"period\":\"year\",\"period_time\":1,\"amount\":12,\"cid\":5},{\"id\":\"3\",\"name\":\"8 adet IP Adresi\",\"period\":\"year\",\"period_time\":1,\"amount\":24,\"cid\":5},{\"id\":\"4\",\"name\":\"16 adet IP Adresi\",\"period\":\"year\",\"period_time\":1,\"amount\":48,\"cid\":5}]', 4),
(44, 13, 'tr', 'Koruma Hizmeti', '', 'select', '', '[{\"id\":\"0\",\"name\":\"Standart Koruma [Otomasyon Bazlı]\",\"period\":\"month\",\"period_time\":0,\"amount\":0,\"cid\":147,\"module\":\"\"},{\"id\":\"1\",\"name\":\"960Gbps - Yurt dışı  - Voxility (1 IP)\",\"period\":\"month\",\"period_time\":1,\"amount\":75,\"cid\":147,\"module\":\"\"},{\"id\":\"2\",\"name\":\"2Gbps - Yurt içi (1 IP)\",\"period\":\"month\",\"period_time\":1,\"amount\":95,\"cid\":147,\"module\":\"\"},{\"id\":\"3\",\"name\":\"960Gbps Yurt dışı + 2Gbps Yurt içi (1 IP)\",\"period\":\"month\",\"period_time\":1,\"amount\":165,\"cid\":147,\"module\":\"\"}]', 3),
(45, 14, 'tr', 'Yedekleme Alanı', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"100 GB FTP Alanı\",\"period\":\"month\",\"period_time\":1,\"amount\":7,\"cid\":4},{\"id\":\"1\",\"name\":\"250 GB FTP Alanı\",\"period\":\"month\",\"period_time\":1,\"amount\":14,\"cid\":4},{\"id\":\"2\",\"name\":\"500 GB FTP Alanı\",\"period\":\"month\",\"period_time\":1,\"amount\":25,\"cid\":4},{\"id\":\"3\",\"name\":\"1 TB FTP Alanı\",\"period\":\"month\",\"period_time\":1,\"amount\":45,\"cid\":4}]', 3),
(46, 15, 'tr', 'LiteSpeed', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"VPS (2GB RAM ve 500 Eş zamanlı Bağlantı)\",\"period\":\"month\",\"period_time\":1,\"amount\":15,\"cid\":4},{\"id\":\"1\",\"name\":\"Ultra VPS (8GB RAM ve 800 Eş zamanlı Bağlantı)\",\"period\":\"month\",\"period_time\":1,\"amount\":24,\"cid\":4},{\"id\":\"2\",\"name\":\"Dedicated  (1 CPU İşlem Limiti)\",\"period\":\"month\",\"period_time\":1,\"amount\":34,\"cid\":4},{\"id\":\"3\",\"name\":\"Dedicated  (2 CPU İşlem Limiti)\",\"period\":\"month\",\"period_time\":1,\"amount\":52,\"cid\":4},{\"id\":\"4\",\"name\":\"Dedicated  (4 CPU İşlem Limiti)\",\"period\":\"month\",\"period_time\":1,\"amount\":69,\"cid\":4},{\"id\":\"5\",\"name\":\"Dedicated  (8 CPU İşlem Limiti)\",\"period\":\"month\",\"period_time\":1,\"amount\":95,\"cid\":4}]', 5),
(47, 16, 'tr', 'CloudLinux', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"İstiyorum\",\"period\":\"month\",\"period_time\":1,\"amount\":19,\"cid\":4}]', 0),
(50, 19, 'tr', 'Kurulum Hizmeti', 'Kurulumunuz en kısa sürede sağlanarak tarafınıza bilgilendirme yapılır.', 'checkbox', '', '[{\"id\":\"0\",\"name\":\"İstiyorum\",\"period\":\"none\",\"period_time\":1,\"amount\":1,\"cid\":4,\"module\":\"\"}]', 0),
(51, 20, 'tr', 'Yapılandırma ve Ayarlamalar', 'Kurulum sonrası logonuz ve kurumsal renkleriniz sitenize tanımlanır. Smtp, cronjob vb. gibi ayarlarınız yapılır.', 'checkbox', '', '[{\"id\":\"0\",\"name\":\"İstiyorum\",\"period\":\"none\",\"period_time\":1,\"amount\":25,\"cid\":147,\"module\":\"\"}]', 0),
(52, 21, 'tr', 'Teknik Destek', 'Satın aldığınız ürün ile ilgili teknik destek paketi alabilirsiniz. Sadece sistemsel işleyiş, ayarlar vb. hususlar için geçerlidir. Ek yazılım hizmeti değildir.  Aksi halde, ürün kaynaklı hata veya sorunlar dışında destek verilmemektedir. Her ürün için ayrıca paket alınması gerekmektedir.', 'checkbox', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"Standart Destek (Standart Öncelik)\",\"period\":\"month\",\"period_time\":3,\"amount\":15,\"cid\":147},{\"id\":\"1\",\"name\":\"Gold Destek (İleri Öncelik)\",\"period\":\"month\",\"period_time\":3,\"amount\":25,\"cid\":147},{\"id\":\"2\",\"name\":\"Platin Destek (Daimi Öncelik)\",\"period\":\"year\",\"period_time\":3,\"amount\":75,\"cid\":147}]', 2),
(55, 24, 'tr', 'İşletim Sistemi', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"Cent OS 7\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"1\",\"name\":\"Cent OS 6\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"2\",\"name\":\"Debian 9\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"3\",\"name\":\"Debian 8\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"4\",\"name\":\"Ubuntu 16.04\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"5\",\"name\":\"Ubuntu 17.10\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"6\",\"name\":\"Ubuntu 14.04\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"7\",\"name\":\"Fedora 27\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"8\",\"name\":\"openSUSE Leap 42.3\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"9\",\"name\":\"Arch Linux\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"10\",\"name\":\"Windows Server 2016 Datacenter (64 bit)\",\"period\":\"month\",\"period_time\":1,\"amount\":799,\"cid\":5},{\"id\":\"11\",\"name\":\"Windows Server 2012R2 Datacenter (64 bit)\",\"period\":\"month\",\"period_time\":1,\"amount\":799,\"cid\":5}]', 11),
(99, 21, 'en', 'Technical Support', 'You can get a technical support package for the product you are purchasing. Only system operation, settings, etc. It is not an additional software service. If you do not purchase the package, no support is provided except for product-related errors or problems. You also need to buy packages for each', 'checkbox', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"Standard Support (Standard Priority)\",\"period\":\"month\",\"period_time\":3,\"amount\":15,\"cid\":4},{\"id\":\"1\",\"name\":\"Gold Support (Advanced Priority)\",\"period\":\"month\",\"period_time\":3,\"amount\":25,\"cid\":4},{\"id\":\"2\",\"name\":\"Platinum Support (Permanent Priority)\",\"period\":\"month\",\"period_time\":3,\"amount\":75,\"cid\":4}]', 2),
(100, 24, 'en', 'Operation Systems', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"Cent OS 7\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"1\",\"name\":\"Cent OS 6\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"2\",\"name\":\"Debian 9\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"3\",\"name\":\"Debian 8\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"4\",\"name\":\"Ubuntu 16.04\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"5\",\"name\":\"Ubuntu 17.10\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"6\",\"name\":\"Ubuntu 14.04\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"7\",\"name\":\"Fedora 27\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"8\",\"name\":\"openSUSE Leap 42.3\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"9\",\"name\":\"Arch Linux\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":4},{\"id\":\"10\",\"name\":\"Windows Server 2016 Datacenter (64 bit)\",\"period\":\"month\",\"period_time\":1,\"amount\":799,\"cid\":5},{\"id\":\"11\",\"name\":\"Windows Server 2012R2 Datacenter (64 bit)\",\"period\":\"month\",\"period_time\":1,\"amount\":799,\"cid\":5}]', 11),
(98, 20, 'en', 'Configuration and Adjustments', 'After installation, your logotype and corporate colors are defined by us in your site. Smtp, CronJob and similar processes will be define by us.', 'checkbox', '', '[{\"id\":\"0\",\"name\":\"I Want.\",\"period\":\"none\",\"period_time\":1,\"amount\":15,\"cid\":4,\"module\":\"\"}]', 0),
(96, 16, 'en', 'CloudLinux', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"I want\",\"period\":\"month\",\"period_time\":1,\"amount\":19,\"cid\":4}]', 0),
(97, 19, 'en', 'Installation Service', 'Your setup will be provided as soon as possible and you will be informed.', 'checkbox', '', '[{\"id\":\"0\",\"name\":\"I Want.\",\"period\":\"none\",\"period_time\":1,\"amount\":10,\"cid\":4,\"module\":\"\"}]', 0),
(95, 15, 'en', 'LiteSpeed', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"VPS (2GB RAM and 500 Concurrent Connections)\",\"period\":\"month\",\"period_time\":1,\"amount\":15,\"cid\":4},{\"id\":\"1\",\"name\":\"Ultra VPS (8GB RAM and 800 Concurrent Connections)\",\"period\":\"month\",\"period_time\":1,\"amount\":24,\"cid\":4},{\"id\":\"2\",\"name\":\"Dedicated  (1 CPU)\",\"period\":\"month\",\"period_time\":1,\"amount\":34,\"cid\":4},{\"id\":\"3\",\"name\":\"Dedicated  (2 CPU)\",\"period\":\"month\",\"period_time\":1,\"amount\":52,\"cid\":4},{\"id\":\"4\",\"name\":\"Dedicated  (4 CPU)\",\"period\":\"month\",\"period_time\":1,\"amount\":69,\"cid\":4},{\"id\":\"5\",\"name\":\"Dedicated  (8 CPU)\",\"period\":\"month\",\"period_time\":1,\"amount\":95,\"cid\":4}]', 5),
(93, 13, 'en', 'Protection Service', '', 'select', '', '[{\"id\":\"0\",\"name\":\"Standard Protection [Automation Based]\",\"period\":\"month\",\"period_time\":0,\"amount\":0,\"cid\":4,\"module\":\"\"},{\"id\":\"1\",\"name\":\"960Gbps -  Voxility (1 IP)\",\"period\":\"month\",\"period_time\":1,\"amount\":75,\"cid\":4,\"module\":\"\"}]', 3),
(94, 14, 'en', 'Backup Area', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"100 GB FTP\",\"period\":\"month\",\"period_time\":1,\"amount\":7,\"cid\":4},{\"id\":\"1\",\"name\":\"250 GB FTP\",\"period\":\"month\",\"period_time\":1,\"amount\":14,\"cid\":4},{\"id\":\"2\",\"name\":\"500 GB FTP\",\"period\":\"month\",\"period_time\":1,\"amount\":25,\"cid\":4},{\"id\":\"3\",\"name\":\"1 TB FTP\",\"period\":\"month\",\"period_time\":1,\"amount\":45,\"cid\":4}]', 3),
(91, 9, 'en', 'Private IP', 'Define your site an unshared private IP address. Give advantage as SEO and mail traffic.', 'radio', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"I Want\",\"period\":\"year\",\"period_time\":1,\"amount\":3,\"cid\":4}]', 0),
(92, 12, 'en', 'Additional IP Address', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"1 IP\",\"period\":\"year\",\"period_time\":1,\"amount\":3,\"cid\":5},{\"id\":\"1\",\"name\":\"2 IP\",\"period\":\"year\",\"period_time\":1,\"amount\":6,\"cid\":5},{\"id\":\"2\",\"name\":\"4 IP\",\"period\":\"year\",\"period_time\":1,\"amount\":12,\"cid\":5},{\"id\":\"3\",\"name\":\"8 IP\",\"period\":\"year\",\"period_time\":1,\"amount\":24,\"cid\":5},{\"id\":\"4\",\"name\":\"16 IP\",\"period\":\"year\",\"period_time\":1,\"amount\":48,\"cid\":5}]', 4),
(89, 8, 'en', 'Backup Services', 'The data are stored separately on our separate and dedicated backup servers. In any adverse situation your sites will be safe.', 'radio', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"Backup Every 3 Days\",\"period\":\"year\",\"period_time\":1,\"amount\":5,\"cid\":4},{\"id\":\"1\",\"name\":\"Backup Every 7 Days\",\"period\":\"year\",\"period_time\":1,\"amount\":9,\"cid\":4}]', 1),
(90, 10, 'en', 'Operation System', '', 'select', '', '[{\"id\":\"0\",\"name\":\"Windows 7 Ultimate\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"1\",\"name\":\"Windows 8.1\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"2\",\"name\":\"Windows 10\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"3\",\"name\":\"Windows Server 2008 R2\",\"period\":\"none\",\"period_time\":0,\"amount\":7.9900000000000002131628207280300557613372802734375,\"cid\":5,\"module\":\"\"},{\"id\":\"4\",\"name\":\"Windows Server 2012 R2\",\"period\":\"none\",\"period_time\":0,\"amount\":9.9900000000000002131628207280300557613372802734375,\"cid\":5,\"module\":\"\"},{\"id\":\"5\",\"name\":\"CentOS 6.8\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"6\",\"name\":\"CentOS 7.2\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"7\",\"name\":\"Debian 7.5\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"8\",\"name\":\"Debian 8.3\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"9\",\"name\":\"Ubuntu Server 14.04\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"10\",\"name\":\"Ubuntu Server 15.10\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"11\",\"name\":\"VMware ESXi 5.x\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"12\",\"name\":\"VMware ESXi 6.x\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"13\",\"name\":\"FreeBSD 9.3\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"},{\"id\":\"14\",\"name\":\"FreeBSD 10.2\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5,\"module\":\"\"}]', 14),
(88, 11, 'en', 'Control Panel', '', 'select', '{\"compulsory\":false}', '[{\"id\":\"0\",\"name\":\"cPanel (Trial)\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5},{\"id\":\"1\",\"name\":\"cPanel  (VDS)\",\"period\":\"month\",\"period_time\":1,\"amount\":19,\"cid\":4},{\"id\":\"2\",\"name\":\"cPanel (Dedicated)\",\"period\":\"month\",\"period_time\":1,\"amount\":39,\"cid\":4},{\"id\":\"3\",\"name\":\"Plesk Web Host Edition\",\"period\":\"month\",\"period_time\":1,\"amount\":45,\"cid\":4},{\"id\":\"4\",\"name\":\"Plesk (Trial)\",\"period\":\"none\",\"period_time\":0,\"amount\":0,\"cid\":5},{\"id\":\"5\",\"name\":\"Directadmin (Dedicated)\",\"period\":\"month\",\"period_time\":1,\"amount\":25,\"cid\":4}]', 5),
(103, 27, 'tr', 'Additional SANs', '', 'quantity', '{\"max\":\"10\"}', '[{\"id\":\"0\",\"name\":\"SAN\",\"period\":\"year\",\"period_time\":1,\"amount\":2,\"cid\":5,\"module\":{\"GogetSSL\":{\"configurable\":{\"sans_count\":\"1\"}}}},{\"id\":\"1\",\"name\":\"SAN\",\"period\":\"year\",\"period_time\":2,\"amount\":4,\"cid\":5,\"module\":{\"GogetSSL\":{\"configurable\":{\"sans_count\":\"1\"}}}},{\"id\":\"3\",\"name\":\"SAN\",\"period\":\"year\",\"period_time\":3,\"amount\":6,\"cid\":5,\"module\":{\"GogetSSL\":{\"configurable\":{\"sans_count\":\"1\"}}}}]', 3),
(104, 27, 'en', 'Additional SANs', '', 'quantity', '{\"show_by_pp\":\"1\",\"max\":\"10\"}', '[{\"id\":\"0\",\"name\":\"SAN\",\"period\":\"month\",\"period_time\":6,\"amount\":10,\"cid\":5,\"module\":{\"GogetSSL\":{\"configurable\":{\"sans_count\":\"1\"}}}},{\"id\":\"4\",\"name\":\"SAN\",\"period\":\"year\",\"period_time\":1,\"amount\":20,\"cid\":5,\"module\":{\"GogetSSL\":{\"configurable\":{\"sans_count\":\"1\"}}}},{\"id\":\"5\",\"name\":\"SAN\",\"period\":\"year\",\"period_time\":2,\"amount\":40,\"cid\":5,\"module\":{\"GogetSSL\":{\"configurable\":{\"sans_count\":\"1\"}}}},{\"id\":\"6\",\"name\":\"SAN\",\"period\":\"year\",\"period_time\":3,\"amount\":60,\"cid\":5,\"module\":{\"GogetSSL\":{\"configurable\":{\"sans_count\":\"1\"}}}}]', 6),
(105, 28, 'tr', 'RAM', '', 'quantity', '{\"show_by_pp\":\"1\",\"max\":\"32\"}', '[{\"id\":\"0\",\"name\":\"GB\",\"period\":\"month\",\"period_time\":1,\"amount\":5,\"cid\":5,\"module\":\"\"},{\"id\":\"1\",\"name\":\"GB\",\"period\":\"month\",\"period_time\":3,\"amount\":10,\"cid\":5,\"module\":\"\"},{\"id\":\"2\",\"name\":\"GB\",\"period\":\"month\",\"period_time\":6,\"amount\":20,\"cid\":5,\"module\":\"\"},{\"id\":\"3\",\"name\":\"GB\",\"period\":\"year\",\"period_time\":1,\"amount\":40,\"cid\":5,\"module\":\"\"}]', 3),
(106, 28, 'en', 'RAM', '', 'quantity', '{\"min\":\"1\",\"max\":\"16\"}', '[{\"id\":\"0\",\"name\":\"\",\"period\":\"month\",\"period_time\":1,\"amount\":5,\"cid\":5,\"module\":\"\"},{\"id\":\"1\",\"name\":\"\",\"period\":\"month\",\"period_time\":3,\"amount\":10,\"cid\":5,\"module\":\"\"},{\"id\":\"2\",\"name\":\"\",\"period\":\"month\",\"period_time\":6,\"amount\":15,\"cid\":5,\"module\":\"\"},{\"id\":\"3\",\"name\":\"\",\"period\":\"month\",\"period_time\":9,\"amount\":20,\"cid\":5,\"module\":\"\"},{\"id\":\"4\",\"name\":\"\",\"period\":\"year\",\"period_time\":1,\"amount\":25,\"cid\":5,\"module\":\"\"}]', 4),
(125, 30, 'tr', 'Destek ve Güncelleme', 'Yıllık destek ve güncelleme paketi', 'checkbox', '', '[{\"id\":\"0\",\"name\":\"Evet,İstiyorum.\",\"period\":\"year\",\"period_time\":1,\"amount\":195,\"cid\":147,\"module\":\"\"}]', 0),
(126, 30, 'en', 'Support and Updates', 'Annual support and update package', 'checkbox', '', '[{\"id\":\"0\",\"name\":\"Yes, I Want.\",\"period\":\"year\",\"period_time\":1,\"amount\":35,\"cid\":4,\"module\":\"\"}]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_lang`
--

CREATE TABLE `products_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_lang`
--

INSERT INTO `products_lang` (`id`, `owner_id`, `lang`, `title`, `features`, `options`) VALUES
(81, 50, 'tr', 'Gold SEO', '3 Anahtar Kelime Seçimi\r\n12 Özgün Makale\r\n10 Google News Haber Tanıtım Yazısı\r\n2 Haber Sitesinden Tanıtım Yazısı\r\n50 Forum Tanıtım (Özgün Makale Hediye)\r\n10 Facebook Backlink\r\n10 Google Plus Backlink\r\n5 Diigo Backlink\r\n5 Scoop İt Backlink\r\n5 Plurk Backlink\r\n5 Pinterest Backlink\r\n5 Linkedin Backlink\r\n3 Tumblr Backlink\r\n3 Reddit Backlink', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(2, 2, 'tr', 'Gold', '6 Adet Anahtar Kelime\r\nKapsamlı Web Site Analizi\r\n10 Adet Makale/Tanıtım Yazımı\r\n10 Adet Web Sitede Tanıtım\r\n50 Adet Forumda Tanıtım Çalışması\r\nFaydalı Bağlantı Çalışmaları\r\nKurumsal Firma Kaydı\r\nOrganik Ziyaretçi Gönderimi\r\nAyrıntılı Periyodik Raporlama\r\nTeknik Destek <i class=\"fa fa-tag\"></i> <i class=\"fa fa-plus\"></i> <i class=\"fa fa-phone\"></i> <i class=\"fa fa-plus\"></i> <i class=\"fa fa-map-marker\"></i>', NULL),
(3, 3, 'tr', 'Platin', '12 Adet Anahtar Kelime\r\nKapsamlı Web Site Analizi\r\n20 Adet Makale/Tanıtım Yazımı\r\n20 Adet Web Sitede Tanıtım\r\n50 Adet Forumda Tanıtım Çalışması\r\nFaydalı Bağlantı Çalışmaları\r\nKurumsal Firma Kaydı\r\nOrganik Ziyaretçi Gönderimi\r\nAyrıntılı Periyodik Raporlama\r\nTeknik Destek <i class=\"fa fa-tag\"></i> <i class=\"fa fa-plus\"></i> <i class=\"fa fa-phone\"></i> <i class=\"fa fa-plus\"></i> <i class=\"fa fa-map-marker\"></i>', NULL),
(68, 37, 'tr', 'VDS SSD TR4', '100 GB SSD\n6 GB RAM\n4000 MHZ İşlemci\n1 Gbps / Limitsiz Trafik\n Seçilebilir İşletim Sistemi', '{\"location\":\"Türkiye\"}'),
(67, 36, 'tr', 'L BAYİ', '<b>30 GB Disk Alanı\nLimitsiz Aylık Trafik\nLimitsiz Site Barındırma</b>\nLimitsiz Alt Özellikler\nHızlı Kurulum\nWHM Panel\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%35 Cpu İzni', NULL),
(90, 59, 'tr', '3.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(53, 22, 'tr', 'TR DED 2', 'Intel C2750 - 8 Core\n8 GB\n120 GB SSD\n1 Gbps', '{\"location\":\"Türkiye\",\"external_link\":\"\"}'),
(54, 23, 'tr', 'TR DED 3', 'Intel C2750 - 8 Core\n16 GB\n750 GB SATA\n1 Gbps', '{\"location\":\"Türkiye\"}'),
(55, 24, 'tr', 'FR DED 1', 'Intel C2350 1,70GHz\n4 GB\n1 x 120 GB SSD\n1Gbps / 200Mbps', '{\"location\":\"Fransa\"}'),
(56, 25, 'tr', 'FR DED 2', 'Intel C2750 2.40GHz\n16 GB\n1 x 1TB SATA\n1Gbps / 200Mbps', '{\"location\":\"Fransa\",\"external_link\":\"\"}'),
(57, 26, 'tr', 'FR DED 4', 'Intel Xeon W3520\n16 GB\n2 x 2TB SATA\n1Gbps / 250Mbps', '{\"location\":\"Fransa\"}'),
(58, 27, 'tr', 'FR DED 3', 'Intel C2750 2.40GHz\n16 GB RAM\n1 x 250GB SSD\n1Gbps / 250Mbps Garanti', '{\"location\":\"Fransa\"}'),
(59, 28, 'tr', 'ALM DED 1', 'Intel Core i7-920\n24 GB\n2 x 750 GB\n1Gbps*', '{\"location\":\"Almanya\"}'),
(60, 29, 'tr', 'ALM DED 2', 'Intel Core i7-920\n8 GB\n2 x 750 GB\n1Gbps', '{\"location\":\"Almanya\"}'),
(61, 30, 'tr', 'VDS SSD TR1', '25 GB SSD\n1 GB RAM\n1600 MHZ İşlemci\n1Gbps / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Türkiye\"}'),
(62, 31, 'tr', 'VDS SSD TR2', '50 GB SSD\n2 GB RAM\n2000 MHZ İşlemci\n1Gbps / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Türkiye\",\"external_link\":\"\"}'),
(63, 32, 'tr', 'VDS SSD TR3', '75 GB SSD\n4 GB RAM\n3000 MHZ İşlemci\n1 Gbps / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Türkiye\"}'),
(65, 34, 'tr', 'M BAYİ', '<b>20 GB Disk Alanı\nLimitsiz Aylık Trafik\nLimitsiz Site Barındırma</b>\nLimitsiz Alt Özellikler\nHızlı Kurulum\nWHM Panel\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%35 Cpu İzni', NULL),
(51, 20, 'tr', 'PRO SSD 3', '<b>6 GB Disk Alanı\n60 GB Aylık Trafik\n10 Adet Site Barındırma</b>\nLimitsiz E-Mail Adresi\nLimitsiz MySQL\nLimitsiz FTP Hesabı\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%20 Cpu İzni', NULL),
(52, 21, 'tr', 'TR DED 1', 'Intel C2750 - 8 Core\n8 GB\n750 GB SATA\n1 Gbps', '{\"location\":\"Türkiye\",\"external_link\":\"\"}'),
(46, 15, 'tr', 'EKO SSD 1', '<b>100 MB Disk Alanı\n2 GB Aylık Trafik\n1 Adet Site Barındırma</b>\n5 Adet E-Mail Adresi\n2 Adet MySQL\n10 Adet FTP Hesabı\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%20 Cpu İzni', NULL),
(47, 16, 'tr', 'EKO SSD 2', '<b>250 MB Disk Alanı\n5 GB Aylık Trafik\n1 Adet Site Barındırma</b>\n10 Adet E-Mail Adresi\n5 Adet MySQL\nLimitsiz FTP Hesabı\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%20 Cpu İzni', '{\"external_link\":\"\"}'),
(48, 17, 'tr', 'EKO SSD 3', '<b>500 MB Disk Alanı\n10 GB Aylık Trafik\n1 Adet Site Barındırma</b>\nLimitsiz E-Mail Adresi\n10 Adet MySQL\nLimitsiz FTP Hesabı\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%20 Cpu İzni', '{\"external_link\":\"\"}'),
(50, 19, 'tr', 'PRO SSD 2', '<b>3 GB Disk Alanı\n30 GB Aylık Trafik\n5 Adet Site Barındırma</b>\nLimitsiz E-Mail Adresi\nLimitsiz MySQL\nLimitsiz FTP Hesabı\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%20 Cpu İzni', NULL),
(64, 33, 'tr', 'S BAYİ', '<b>10 GB Disk Alanı\nLimitsiz Aylık Trafik\nLimitsiz Site Barındırma</b>\nLimitsiz Alt Özellikler\nHızlı Kurulum\nWHM Panel\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%35 Cpu İzni', '{\"external_link\":\"\"}'),
(49, 18, 'tr', 'PRO SSD 1', '<b>1 GB Disk Alanı\n20 GB Aylık Trafik\n2 Adet Site Barındırma </b>\nLimitsiz E-Mail Adresi\nLimitsiz MySQL\nLimitsiz FTP Hesabı\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%20 Cpu İzni', '{\"external_link\":\"\"}'),
(69, 38, 'tr', 'VDS SSD FR 1', '30 GB SSD\n1 GB RAM\n1 Core İşlemci\n1Gbps / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Fransa\",\"external_link\":\"\"}'),
(70, 39, 'tr', 'VDS SSD FR 2', '60 GB SSD\n2 GB RAM\n2 Core İşlemci\n1Gbps / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Fransa\",\"external_link\":\"\"}'),
(71, 40, 'tr', 'VDS SSD FR 3', '120 GB SSD\n4 GB RAM\n3 Core İşlemci\n1Gbps / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Fransa\"}'),
(72, 41, 'tr', 'VDS SSD FR 4', '200 GB SSD\n6 GB RAM\n4 Core İşlemci\n1Gbps / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Fransa\"}'),
(73, 42, 'tr', 'VDS SSD DE 1', '<b>300 GB SSD\n12 GB Ram\n4 Core İşlemci</b>\n100 Mbit / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Almanya\"}'),
(74, 43, 'tr', 'VDS SSD DE 2', '<b>600 GB SSD\n24 GB Ram\n6 Core İşlemci</b>\n100 Mbit / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Almanya\"}'),
(75, 44, 'tr', 'VDS SSD DE 3', '<b>1200 GB SSD\n50 GB Ram\n10 Core İşlemci</b>\n1 Gbit / Limitsiz Trafik\nSeçilebilir İşletim Sistemi', '{\"location\":\"Almanya\",\"external_link\":\"\"}'),
(80, 49, 'tr', 'Silver SEO', '2 Anahtar Kelime Seçimi\n5 Özgün Makale\n5 Google News Haber Tanıtım Yazısı\n25 Forum Tanıtım (Özgün Makale Hediye)\n5 Facebook Backlink\n5 Google Plus Backlink\n3 Plurk Backlink\n3 Pinterest Backlink\n3 Tumblr Backlink\n3 Diigo Backlink', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(82, 51, 'tr', 'Platin SEO', '4 Anahtar Kelime Seçimi\r\n20 Özgün Makale\r\n15 Google News Haber Tanıtım Yazısı\r\n5 Haber Sitesinden Tanıtım Yazısı\r\n3 Pdf Backlink\r\n100 Forum Tanıtım (Özgün Makale Hediye)\r\n10 Facebook Backlink\r\n100 Forum Tanıtım\r\n10 Google Plus Backlink\r\n10 Diigo Backlink\r\n10 Scoop İt Backlink\r\n10 Plurk Backlink\r\n5 Pinterest Backlink\r\n5 Linkedin Backlink\r\n5 Tumblr Backlink\r\n5 Reddit Backlink\r\nBacklink Analizi\r\nSite Otoritesini Arttıracak Genel Çalışma', ''),
(83, 52, 'tr', 'SİTE 1', '{\"1\":\"3\",\"2\":\"750.000\",\"3\":\"24\",\"4\":\"26\",\"5\":\"1.250.000\"}', ''),
(84, 53, 'tr', 'SİTE 2', '{\"1\":\"5\",\"2\":\"1.254.860\",\"3\":\"38\",\"4\":\"42\",\"5\":\"3569\"}', ''),
(85, 54, 'tr', 'SİTE 3', '{\"1\":\"7\",\"2\":\"3.250.259\",\"3\":\"52\",\"4\":\"48\",\"5\":\"4520\"}', ''),
(86, 55, 'tr', 'Small Backlink', '2 anahtar kelime\nTürkçe Forum Tanıtımları\nA+ Kalite Profil Backlinkler\nYüksek Otoriteli Backlikler\nEdu-Gov Backlinkler\nRekabet Düzeyinde Social Bookmark\nGerçek Haber Sitesinde Kalıcı Tanıtım\nAraştırmaya Dayalı Özel Semantic Makale\nEkstra Hediye Çalışmalar\nAnahtar Kelime Analiz Raporu\nAyrıntılı Çalışma Raporu', ''),
(87, 56, 'tr', 'Medium Backlink', '3 anahtar kelime\nTürkçe Forum Tanıtımları\nA+ Kalite Profil Backlinkler\nYüksek Otoriteli Backlikler\nEdu-Gov Backlinkler\nRekabet Düzeyinde Social Bookmark\n2 Gerçek Haber Sitesinde Kalıcı Tanıtım\nAraştırmaya Dayalı 2 Özel Semantic Makale\nÖzel Rakip Analizi\nSektörel / Rakip Backlink\nEkstra Hediye Çalışmalar\nAnahtar Kelime Analiz Raporu\nAyrıntılı Çalışma Raporu', ''),
(88, 57, 'tr', 'Large Backlink', '6 anahtar kelime\nTürkçe Forum Tanıtımları\nA+ Kalite Profil Backlinkler\nYüksek Otoriteli Backlikler\nEdu-Gov Backlinkler\nRekabet Düzeyinde Social Bookmark\n4 Gerçek Haber Sitesinde Kalıcı Tanıtım\nAraştırmaya Dayalı 4 Özel Semantic Makale\nÖzel Rakip Analizi\nSektörel / Rakip Backlink\nEkstra Hediye Çalışmalar\nAnahtar Kelime Analiz Raporu\nAyrıntılı Çalışma Raporu', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(89, 58, 'tr', '1.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(91, 60, 'tr', '5.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(92, 61, 'tr', '10.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(93, 62, 'tr', '25.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(94, 63, 'tr', '50.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(95, 64, 'tr', '100.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(96, 65, 'tr', '255.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(267, 65, 'en', '250.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(265, 63, 'en', '50.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(266, 64, 'en', '100.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(262, 60, 'en', '5.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(263, 61, 'en', '10.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(264, 62, 'en', '25.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(261, 58, 'en', '1.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(260, 57, 'en', 'Large Backlink', '6 keywords\nForum Backlinks\nA + Quality Profile Backlinks\nHigh-Quality Backlinks\nEdu-Gov Backlinks\nCompetitive Social Bookmark\n4 Permanent Promotion in Real News Site\n4 Special Semantic Articles Based on Research\nSpecial Competitor Analysis\nSectoral / Competitor Backlink\nExtra Gift Works\nKeyword Analysis Report\nDetailed Working Report', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(257, 54, 'en', 'SITE 3', '{\"1\":\"7\",\"2\":\"3.250.259\",\"3\":\"52\",\"4\":\"48\",\"5\":\"4520\"}', ''),
(258, 55, 'en', 'Small Backlink', '2 keywords\nForum Backlinks\nA + Quality Profile Backlinks\nHigh-Quality Backlinks\nEdu-Gov Backlinks\nCompetitive Social Bookmark\nPermanent Promotion in Real News Site\nResearch-specific Semantic Article\nExtra Gift Works\nKeyword Analysis Report\nDetailed Working Report', ''),
(259, 56, 'en', 'Medium Backlink', '3 keywords\nForum Backlinks\nA + Quality Profile Backlinks\nHigh-Quality Backlinks\nEdu-Gov Backlinks\nCompetitive Social Bookmark\n2 Permanent Promotion in Real News Site\n2 Special Semantic Articles Based on Research\nSpecial Competitor Analysis\nSectoral / Competitor Backlink\nExtra Gift Works\nKeyword Analysis Report\nDetailed Working Report', ''),
(256, 53, 'en', 'SITE 2', '{\"1\":\"5\",\"2\":\"1.254.860\",\"3\":\"38\",\"4\":\"42\",\"5\":\"3569\"}', ''),
(255, 52, 'en', 'SITE 1', '{\"1\":\"3\",\"2\":\"750.000\",\"3\":\"24\",\"4\":\"26\",\"5\":\"1.250.000\"}', ''),
(253, 49, 'en', 'Silver SEO', '2 Keyword Selection\n5 Original Articles\n5 Google News News Feed\n25 Forum Presentation (Original Article Gift)\n5 Facebook Backlink\n5 Google Plus Backlink\n3 Plurk Backlink\n3 Pinterest Backlink\n3 Tumblr Backlink\n3 Diigo Backlink', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(254, 51, 'en', 'Platinium SEO', '4 Keyword Selection\r\n20 Original Articles\r\n15 Google News News Feed\r\nPromotion Written by 5 News Sites\r\n3 Pdf Backlink\r\n100 Forum Presentation (Original Article Gift)\r\n10 Facebook Backlink\r\n100 Forum Tanıtım\r\n10 Google Plus Backlink\r\n10 Diigo Backlink\r\n10 Scoop It Backlink\r\n10 Plurk Backlink\r\n5 Pinterest Backlink\r\n5 Linkedin Backlink\r\n5 Tumblr Backlink\r\n5 Reddit Backlink\r\nBacklink Analysis\r\nGeneral Work to Improve Site Authority', ''),
(252, 44, 'en', 'VDS SSD DE 3', '<b> 1200 GB SSD\n50 GB Ram\n10 Core Processor</b>\n1 Gbit / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"Germany\",\"external_link\":\"\"}'),
(250, 42, 'en', 'VDS SSD DE 1', '<b> 300 GB SSD\n12 GB Ram\n4 Core Processor </b>\n100 Mbit / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"Germany\"}'),
(251, 43, 'en', 'VDS SSD DE 2', '<b> 600 GB SSD\n24 GB Ram\n6 Core Processor </b>\n100 Mbit / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"Germany\"}'),
(249, 41, 'en', 'VDS SSD FR 4', '200 GB SSD\n6 GB RAM\n4 Core Processor\n1Gbps / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"France\"}'),
(248, 40, 'en', 'VDS SSD FR 3', '120 GB SSD\n4 GB RAM\n3 Core Processor\n1Gbps / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"France\"}'),
(247, 39, 'en', 'VDS SSD FR 2', '60 GB SSD\n2 GB RAM\n2 Core Processor\n1Gbps / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"France\",\"external_link\":\"\"}'),
(246, 38, 'en', 'VDS SSD FR 1', '30 GB SSD\n1 GB RAM\n1 Core Processor\n1Gbps / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"France\",\"external_link\":\"\"}'),
(243, 19, 'en', 'PRO SSD 2', '<b> 3 GB Disk Space\n30 GB Monthly Traffic\n5 Site Hosting </b>\nUnlimited Email \nUnlimited MySQL\nUnlimited FTP Account\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n20% Cpu', NULL),
(244, 33, 'en', 'S RESELLER', '<b> 10 GB Disk Space\nUnlimited Monthly Traffic\nUnlimited Site Hosting </b>\nNo Limit Sub Features\nQuick Installation\nWHM Panel\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n35% Cpu', '{\"external_link\":\"\"}'),
(245, 18, 'en', 'PRO SSD 1', '<b> 1 GB Disk Space\n20 GB Monthly Traffic\n2 Site Hosting </b>\nUnlimited E-Mail\nUnlimited MySQL\nUnlimited FTP Account\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n20% Cpu', '{\"external_link\":\"\"}'),
(242, 17, 'en', 'CHEAP SSD 3', '<b> 500 MB Disk Space\n10 GB Monthly Traffic\n1 Site Hosting </b>\nUnlimited E-Mail\n10 MySQL\nUnlimited FTP Account\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n20% Cpu', '{\"external_link\":\"\"}'),
(241, 16, 'en', 'CHEAP SSD 2', '<b> 250 MB Disk Space\n5 GB Monthly Traffic\n1 Site Hosting </b>\n10 E-Mail\n5 MySQL\nUnlimited FTP Account\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n20% Cpu', '{\"external_link\":\"\"}'),
(240, 15, 'en', 'CHEAP SSD 1', '<b> 100 MB Disk Space\n2 GB Monthly Traffic\n1 Site Hosting </b>\n5 E-Mail\n2 MySQL\n10 FTP Accounts\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n20% Cpu', NULL),
(237, 34, 'en', 'M RESELLER', '<b> 20 GB Disk Space\nUnlimited Monthly Traffic\nUnlimited Site Hosting </b>\nNo Limit Sub Features\nQuick Installation\nWHM Panel\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n35% Cpu', NULL),
(238, 20, 'en', 'PRO SSD 3', '<b> 6 GB Disk Space\n60 GB Monthly Traffic\n10 Site Hosting </b>\nUnlimited Email\nUnlimited MySQL\nUnlimited FTP Account\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n20% Cpu', NULL),
(239, 21, 'en', 'TR DED 1', 'Intel C2750 - 8 Core\n8 GB\n750 GB SATA\n1 Gbps', '{\"location\":\"Turkey\",\"external_link\":\"\"}'),
(236, 32, 'en', 'VDS SSD TR3', '75 GB SSD\n4 GB RAM\n3000 MHZ Processor\n1 Gbps / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"Turkey\"}'),
(235, 31, 'en', 'VDS SSD TR2', '50 GB SSD\n2 GB RAM\n2000 MHZ Processor\n1Gbps / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"Turkey\",\"external_link\":\"\"}'),
(232, 28, 'en', 'ALM DED 1', 'Intel Core i7-920\n24 GB\n2 x 750 GB\n1Gbps*', '{\"location\":\"Germany\"}'),
(233, 29, 'en', 'ALM DED 2', 'Intel Core i7-920\n8 GB\n2 x 750 GB\n1Gbps', '{\"location\":\"Germany\"}'),
(234, 30, 'en', 'VDS SSD TR1', '25 GB SSD\n1 GB RAM\n1600 MHZ Processor\n1Gbps / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"Turkey\"}'),
(225, 59, 'en', '3.000 SMS', 'Taahhütsüz ve Süresiz\nBaşlıklı Gönderim \nAnında Teslim \nDetaylı Raporlama \nİletilmeyen SMS\'ler İade! \nLimitsiz Başlık Tanımlama', NULL),
(226, 22, 'en', 'TR DED 2', 'Intel C2750 - 8 Core\n8 GB\n120 GB SSD\n1 Gbps', '{\"location\":\"Turkey\",\"external_link\":\"\"}'),
(227, 23, 'en', 'TR DED 3', 'Intel C2750 - 8 Core\n16 GB\n750 GB SATA\n1 Gbps', '{\"location\":\"Turkey\"}'),
(228, 24, 'en', 'FR DED 1', 'Intel C2350 1,70GHz\n4 GB\n1 x 120 GB SSD\n1Gbps / 200Mbps', '{\"location\":\"France\"}'),
(229, 25, 'en', 'FR DED 2', 'Intel C2750 2.40GHz\n16 GB\n1 x 1TB SATA\n1Gbps / 200Mbps', '{\"location\":\"France\",\"external_link\":\"\"}'),
(230, 26, 'en', 'FR DED 4', 'Intel Xeon W3520\n16 GB\n2 x 2TB SATA\n1Gbps / 250Mbps', '{\"location\":\"France\"}'),
(231, 27, 'en', 'FR DED 3', 'Intel C2750 2.40GHz\n16 GB RAM\n1 x 250GB SSD\n1Gbps / 250Mbps', '{\"location\":\"France\"}'),
(223, 37, 'en', 'VDS SSD TR4', '100 GB SSD\n6 GB RAM\n4000 MHZ Processor\n1 Gbps / Unlimited Traffic\nSelectable Operating System', '{\"location\":\"Turkey\"}'),
(224, 36, 'en', 'L RESELLER', '<b> 30 GB Disk Space\nUnlimited Monthly Traffic\nUnlimited Site Hosting </b>\nNo Limit Sub Features\nQuick Installation\nWHM Panel\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n35% Cpu', NULL),
(222, 3, 'en', 'Platin', '12 Adet Anahtar Kelime\r\nKapsamlı Web Site Analizi\r\n20 Adet Makale/Tanıtım Yazımı\r\n20 Adet Web Sitede Tanıtım\r\n50 Adet Forumda Tanıtım Çalışması\r\nFaydalı Bağlantı Çalışmaları\r\nKurumsal Firma Kaydı\r\nOrganik Ziyaretçi Gönderimi\r\nAyrıntılı Periyodik Raporlama\r\nTeknik Destek <i class=\"fa fa-tag\"></i> <i class=\"fa fa-plus\"></i> <i class=\"fa fa-phone\"></i> <i class=\"fa fa-plus\"></i> <i class=\"fa fa-map-marker\"></i>', NULL),
(221, 2, 'en', 'Gold', '6 Adet Anahtar Kelime\r\nKapsamlı Web Site Analizi\r\n10 Adet Makale/Tanıtım Yazımı\r\n10 Adet Web Sitede Tanıtım\r\n50 Adet Forumda Tanıtım Çalışması\r\nFaydalı Bağlantı Çalışmaları\r\nKurumsal Firma Kaydı\r\nOrganik Ziyaretçi Gönderimi\r\nAyrıntılı Periyodik Raporlama\r\nTeknik Destek <i class=\"fa fa-tag\"></i> <i class=\"fa fa-plus\"></i> <i class=\"fa fa-phone\"></i> <i class=\"fa fa-plus\"></i> <i class=\"fa fa-map-marker\"></i>', NULL),
(220, 50, 'en', 'Gold SEO', '3 Keyword Selection\r\n12 Original Articles\r\n10 Google News News Feed\r\nPromotion Letter from 2 News Sites\r\n50 Forum Presentation (Original Article Gift)\r\n10 Facebook Backlink\r\n10 Google Plus Backlink\r\n5 Diigo Backlink\r\n5 Scoop It Backlink\r\n5 Plurk Backlink\r\n5 Pinterest Backlink\r\n5 Linkedin Backlink\r\n3 Tumblr Backlink\r\n3 Reddit Backlink', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(268, 91, 'tr', 'Comodo PositiveSSL Multi-Domain', '', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(269, 91, 'en', 'Comodo PositiveSSL Multi-Domain', '', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(320, 92, 'en', 'buycpanel package1', '', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(319, 92, 'tr', 'buycpanel paket1', '', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(321, 93, 'tr', 'test', '', '{\"buy_button_name\":\"burakselvi96@gmail.com\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(322, 93, 'en', 'test', '', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(323, 94, 'tr', 'Startup', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Anında Aktivasyon</strong>\n\"Powered by WISECP\" Görünür\nÜcretsiz Destek & Güncelleme\nHiçbir Sınırlandırma Yok\nKendi Hostunuzda Barındırın', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(324, 94, 'en', 'Startup', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Instant Activation</strong>\nCan\'t remove \"Powered by WISECP\"\nFree support & update\nThere are no limits\nHost on your own server', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(325, 95, 'tr', 'Professional', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Anında Aktivasyon</strong>\n\"Powered by WISECP\" Görünmez\nÜcretsiz Destek & Güncelleme\nHiçbir Sınırlandırma Yok\nKendi Hostunuzda Barındırın', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(326, 95, 'en', 'Professional', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Instant Activation</strong>\nCan remove \"Powered by WISECP\"\nFree support & update\nThere are no limits\nHost on your own server', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(327, 96, 'tr', 'Startup', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Anında Aktivasyon</strong>\n\"Powered by WISECP\" Görünür\n1 Yıl Ücretsiz Destek & Güncelleme\n(Sonraki Her Yıl 195 TL)\nHiçbir Sınırlandırma Yok\nKendi Hostunuzda Barındırın', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(328, 96, 'en', 'Startup', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Instant Activation</strong>\nCan\'t remove \"Powered by WISECP\"\n1 Year free support and update\n(Next every year $35)\nThere are no limits\nHost on your own server', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(329, 97, 'tr', 'Professional', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Anında Aktivasyon</strong>\n\"Powered by WISECP\" Görünmez\n1 Yıl Ücretsiz Destek & Güncelleme\n(Sonraki Her Yıl 195 TL)\nHiçbir Sınırlandırma Yok\nKendi Hostunuzda Barındırın', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(330, 97, 'en', 'Professional', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Instant Activation</strong>\nCan remove \"Powered by WISECP\"\n1 Year free support and update\n(Next every year $35)\nThere are no limits\nHost on your own server', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(335, 100, 'tr', 'TEST PAKET', '<b>100 MB Disk Alanı\n5 GB Aylık Trafik\n1 Adet Site Barındırma</b>\n10 Adet E-Mail Adresi\n5 Adet MySQL\nLimitsiz FTP Hesabı\nLinux - cPanel\nLiteSpeed - Cloudlinux\nAnında Kurulum\n%20 Cpu İzni', '{\"external_link\":\"\"}'),
(336, 100, 'en', 'CHEAP SSD 2', '<b> 250 MB Disk Space\n5 GB Monthly Traffic\n1 Site Hosting </b>\n10 E-Mail\n5 MySQL\nUnlimited FTP Account\nLinux - cPanel\nLiteSpeed - Cloudlinux\nInstant Installation\n20% Cpu', '{\"external_link\":\"\"}'),
(339, 102, 'tr', 'Enterprise', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Anında Aktivasyon</strong>\n\"Powered by WISECP\" Görünmez\nÜcretsiz Destek & Güncelleme\n(Ömürboyu Ücretsiz!)\nHiçbir Sınırlandırma Yok\nKendi Hostunuzda Barındırın', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}'),
(340, 102, 'en', 'Enterprise', '<img height=\"26\" src=\"https://www.wisecp.com/images/logo2.svg\" style=\"margin: 10px;\">\n<strong>Instant Activation</strong>\nCan remove \"Powered by WISECP\"\nLifetime support & update\n(It\'s always free!)\nThere are no limits\nHost on your own server', '{\"buy_button_name\":\"\",\"external_link\":\"\",\"delivery_title_name\":\"\",\"delivery_title_description\":\"\"}');

-- --------------------------------------------------------

--
-- Table structure for table `products_requirements`
--

CREATE TABLE `products_requirements` (
  `id` int(11) UNSIGNED NOT NULL,
  `mcategory` varchar(20) DEFAULT NULL,
  `category` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `module_co_names` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_requirements`
--

INSERT INTO `products_requirements` (`id`, `mcategory`, `category`, `status`, `rank`, `module_co_names`) VALUES
(8, 'software', 168, 'active', 0, NULL),
(9, 'software', 168, 'active', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products_requirements_lang`
--

CREATE TABLE `products_requirements_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `properties` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci,
  `lid` int(8) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_requirements_lang`
--

INSERT INTO `products_requirements_lang` (`id`, `owner_id`, `lang`, `name`, `description`, `type`, `properties`, `options`, `lid`) VALUES
(14, 8, 'tr', 'Kurulum için Hosting Bilgileri', 'Kurulum için lütfen hosting erişim (cpanel/plesk vb.) bilgilerinizi iletiniz. (Hosting hizmetini tarafımızdan alıyorsanız bu alanı dikkate almayınız.)', 'textarea', '{\"compulsory\":false}', '[]', 0),
(15, 9, 'tr', 'Firma Logosu Yükle', 'Kurulum sonrası firma logonuzun yüklenmesi ve kurumsal renklerinizin tanımlanması için, lütfen firma logonuzu yükleyiniz.', 'file', '{\"compulsory\":\"1\"}', '[]', 0),
(52, 9, 'en', 'Upload a Your Company Logo', 'Please upload a logo to define a logo on the system and to describe corporate colors.', 'file', '{\"compulsory\":\"1\"}', '[]', 0),
(51, 8, 'en', 'Hosting Information for Installation', 'Please provide your hosting access (cPanel / plesk etc.) information for installation. (If you are receiving hosting service from us, do not consider this field.)', 'textarea', '{\"compulsory\":false}', '[]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `primary_product` text COLLATE utf8mb4_unicode_ci,
  `product` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period1` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `period2` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `period_time1` int(5) NOT NULL DEFAULT '1',
  `period_time2` int(5) NOT NULL DEFAULT '1',
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `rate` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `currency` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `applyonce` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `uses` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `maxuses` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `duedate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns4` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maxaccounts` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `username` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_hash` text COLLATE utf8mb4_unicode_ci,
  `secure` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `port` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `updowngrade_remove_server` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'then|2'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `extra` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `type`, `rank`, `status`, `ctime`, `extra`) VALUES
(1, NULL, 1, 'active', '2018-05-19 00:00:00', '{\"video\":{\"duration\":10,\"file\":\"2018-12-06\\/d6d4f3c75d44cd507d6af3f.mp4\"}}'),
(2, NULL, 2, 'active', '2018-05-19 00:00:00', ''),
(3, NULL, 6, 'active', '2018-05-19 00:00:00', NULL),
(7, NULL, 3, 'active', '2018-07-01 02:05:26', ''),
(8, NULL, 4, 'active', '2018-07-01 16:05:01', NULL),
(9, NULL, 5, 'active', '2018-07-02 23:25:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `slides_lang`
--

CREATE TABLE `slides_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slides_lang`
--

INSERT INTO `slides_lang` (`id`, `owner_id`, `lang`, `title`, `description`, `link`) VALUES
(1, 1, 'tr', 'VPS / VDS', 'Türkiye, Fransa, Almanya Lokasyon, Full Performans VPS/VDS.', '#'),
(2, 2, 'tr', 'Web Hosting', 'Her bütçeye uygun, tam donanımlı, profesyonel web hosting paketleri.', '#'),
(3, 3, 'tr', 'Garantili SEO', 'Garantili SEO hizmeti ile Google\'da kalıcı olarak yükselin.', '#'),
(22, 7, 'tr', 'Toplu SMS', 'En ekonomik fiyatlarla tüm dünyaya toplu sms gönderin.', '#'),
(19, 1, 'en', 'VPS / VDS', 'France, Germany and Turkey location, Full performance VPS/VDS.', '#'),
(20, 2, 'en', 'Web Hosting', 'Fully-equipped, professional web hosting packages for every budget.', '#'),
(21, 3, 'en', 'Guaranteed SEO', 'You permanently ascend on with guaranteed Google  SEO Service.', '#'),
(23, 7, 'en', 'Bulk SMS', 'Send bulk sms to all over the world at the most cheapest prices.', '#'),
(24, 8, 'tr', 'Gelişmiş Yazılımlar', 'Her bütçeye uygun, birbirinden özel, eşsiz yazılımlar.', '#'),
(25, 8, 'en', 'Advanced Softwares', 'Advanced, unique softwares for every budget.', '#'),
(26, 9, 'tr', 'Sosyal Medya Hizmetleri', 'Sosyal medya beğeni ve takipçi paketleri ile sosyal medyanın gücünü hissedin!', '#'),
(27, 9, 'en', 'Social Media Services', 'Feel the power of social media with social media likes and follower packs!', '#');

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `numbers` text COLLATE utf8mb4_unicode_ci,
  `data` text COLLATE utf8mb4_unicode_ci,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `private` int(1) NOT NULL DEFAULT '0',
  `owner` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `did` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(111) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locked` int(1) NOT NULL DEFAULT '0',
  `priority` int(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `lastreply` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `userunread` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `adminunread` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `service` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `assigned` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `assignedBy` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `custom_fields` text COLLATE utf8mb4_unicode_ci,
  `user_is_typing` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_attachments`
--

CREATE TABLE `tickets_attachments` (
  `id` int(11) UNSIGNED NOT NULL,
  `ticket_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reply_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_custom_fields`
--

CREATE TABLE `tickets_custom_fields` (
  `id` int(11) UNSIGNED NOT NULL,
  `did` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT 'active',
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_custom_fields_lang`
--

CREATE TABLE `tickets_custom_fields_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `properties` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci,
  `lid` int(8) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_departments`
--

CREATE TABLE `tickets_departments` (
  `id` int(11) UNSIGNED NOT NULL,
  `rank` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `appointees` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets_departments`
--

INSERT INTO `tickets_departments` (`id`, `rank`, `appointees`) VALUES
(1, 4, NULL),
(2, 3, NULL),
(3, 2, NULL),
(4, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_departments_lang`
--

CREATE TABLE `tickets_departments_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets_departments_lang`
--

INSERT INTO `tickets_departments_lang` (`id`, `owner_id`, `lang`, `name`, `description`) VALUES
(1, 1, 'tr', 'Teknik Destek', 'asda'),
(2, 2, 'tr', 'Muhasebe', 'Sipariş işlemleri ile ilgili departman.'),
(3, 3, 'tr', 'Sipariş', 'Sipariş işlemleri ile ilgili departman.'),
(4, 4, 'tr', 'Genel', 'Genel yönetim ile ilgili departman.'),
(19, 1, 'en', 'Technical Support', 'Department of Technical Support operations.'),
(20, 2, 'en', 'Billing', 'Department of accounting transactions.'),
(21, 3, 'en', 'Orders', 'Department of order processing.'),
(22, 4, 'en', 'General', 'General management related department.');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_predefined_replies`
--

CREATE TABLE `tickets_predefined_replies` (
  `id` int(11) UNSIGNED NOT NULL,
  `category` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets_predefined_replies`
--

INSERT INTO `tickets_predefined_replies` (`id`, `category`) VALUES
(3, 213),
(5, 223);

-- --------------------------------------------------------

--
-- Table structure for table `tickets_predefined_replies_lang`
--

CREATE TABLE `tickets_predefined_replies_lang` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets_predefined_replies_lang`
--

INSERT INTO `tickets_predefined_replies_lang` (`id`, `owner_id`, `lang`, `name`, `message`) VALUES
(3, 3, 'tr', 'Örnek bir hazır cevap içeriği', '<p>Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500\'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960\'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.</p>'),
(5, 5, 'tr', 'Test bir hazır cevap daha', '<p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir. İnternet\'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200\'den fazla Latince sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır. Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan sözcüklerden uzaktır.</p>'),
(11, 5, 'en', 'Test one more ready answer', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>'),
(10, 3, 'en', 'A sample ready-answer content', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_replies`
--

CREATE TABLE `tickets_replies` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `admin` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encrypted` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `message` text COLLATE utf8mb4_unicode_ci,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tldlist`
--

CREATE TABLE `tldlist` (
  `id` int(11) UNSIGNED NOT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `max_years` int(11) UNSIGNED NOT NULL DEFAULT '10',
  `paperwork` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `register_cost` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `renewal_cost` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `transfer_cost` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `promo_status` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `promo_register_price` decimal(16,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `promo_transfer_price` decimal(16,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `promo_duedate` date NOT NULL DEFAULT '1881-05-19',
  `currency` int(4) NOT NULL DEFAULT '0',
  `dns_manage` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `whois_privacy` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `epp_code` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `module` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `affiliate_disable` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `affiliate_rate` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tldlist`
--

INSERT INTO `tldlist` (`id`, `status`, `cdate`, `name`, `rank`, `max_years`, `paperwork`, `register_cost`, `renewal_cost`, `transfer_cost`, `promo_status`, `promo_register_price`, `promo_transfer_price`, `promo_duedate`, `currency`, `dns_manage`, `whois_privacy`, `epp_code`, `module`, `affiliate_disable`, `affiliate_rate`) VALUES
(8, 'active', '2018-03-27 01:06:38', 'net', 1, 10, 0, '11.8000', '11.8000', '11.8000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(9, 'active', '2018-03-27 01:06:38', 'org', 2, 10, 0, '11.8000', '11.8000', '11.8000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(7, 'active', '2018-03-27 01:06:38', 'com', 0, 10, 0, '9.4600', '9.4600', '9.4600', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(13, 'active', '2018-03-27 01:06:38', 'biz', 4, 10, 0, '12.0000', '12.0000', '12.0000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(14, 'active', '2018-03-27 01:06:38', 'bz', 20, 10, 0, '19.3000', '19.3000', '19.3000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(15, 'active', '2018-03-27 01:06:38', 'ca', 21, 10, 0, '13.2000', '13.2000', '13.2000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(16, 'active', '2018-03-27 01:06:38', 'cc', 22, 10, 0, '10.2000', '10.2000', '10.2000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(17, 'active', '2018-03-27 01:06:38', 'club', 14, 10, 0, '10.2000', '10.2000', '10.2000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(18, 'active', '2018-03-27 01:06:38', 'cn', 23, 10, 0, '7.6900', '7.6900', '7.6900', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(19, 'active', '2018-03-27 01:06:38', 'co', 5, 10, 0, '25.3000', '25.3000', '25.3000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(20, 'active', '2018-03-27 01:06:38', 'de', 15, 10, 0, '7.1900', '7.1900', '7.1900', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(21, 'active', '2018-03-27 01:06:38', 'es', 18, 10, 0, '7.1900', '7.1900', '7.1900', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(23, 'active', '2018-03-27 01:06:38', 'host', 11, 10, 0, '7.7700', '7.7700', '7.7700', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(24, 'active', '2018-03-27 01:06:38', 'in', 6, 10, 0, '8.0000', '8.0000', '8.0000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 0, 1, 'none', 0, '0.00'),
(25, 'active', '2018-03-27 01:06:38', 'info', 3, 10, 0, '12.7000', '12.7000', '12.7000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(27, 'active', '2018-03-27 01:06:38', 'la', 24, 10, 0, '30.4000', '30.4000', '30.4000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(28, 'active', '2018-03-27 01:06:38', 'me', 19, 10, 0, '24.3000', '24.3000', '24.3000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(29, 'active', '2018-03-27 01:06:38', 'mobi', 8, 10, 0, '16.8000', '16.8000', '16.8000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(30, 'active', '2018-03-27 01:06:38', 'name', 10, 10, 0, '9.5700', '9.5700', '9.5700', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(31, 'active', '2018-03-27 01:06:38', 'pro', 12, 10, 0, '13.2000', '13.2000', '13.2000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(32, 'active', '2018-03-27 01:06:38', 'ru', 17, 10, 0, '25.0000', '25.0000', '25.0000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(33, 'active', '2018-03-27 01:06:38', 'site', 7, 10, 0, '23.3000', '23.3000', '23.3000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(34, 'active', '2018-03-27 01:06:38', 'tv', 13, 10, 0, '31.4000', '31.4000', '31.4000', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(35, 'active', '2018-03-27 01:06:38', 'us', 16, 10, 0, '7.1900', '7.1900', '7.1900', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00'),
(41, 'active', '2018-04-18 18:53:59', 'top', 9, 10, 0, '7.9600', '7.9600', '7.9600', 0, '0.0000', '0.0000', '1881-05-19', 4, 1, 1, 1, 'none', 0, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `name` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creation_time` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `last_login_time` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `login_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secure_hash` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `lang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `country` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `currency` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `balance` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `balance_currency` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `balance_min` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `privilege` int(11) NOT NULL DEFAULT '0',
  `online` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `blacklist` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `aff_id` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `group_id`, `status`, `name`, `surname`, `full_name`, `company_name`, `phone`, `email`, `password`, `creation_time`, `last_login_time`, `login_token`, `secure_hash`, `ip`, `lang`, `country`, `currency`, `balance`, `balance_currency`, `balance_min`, `privilege`, `online`, `blacklist`, `aff_id`) VALUES
(1, 'admin', 0, 'active', 'Pro', 'Pro', 'Pro Pro', '', '201153081461', 'asdfking2017@gmail.com', 'VytIV05KcDRqbXJTbU5rZDFqdjJLQ1hWMkFITE5BWWJRMFZEVDErU1VPa2JoSUR1TE81Z25uQmFFT2Jrc3R0UW03NUpia3FET1d0ZWtkangxRnprbGc9PQ==', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '', NULL, '0.0.0.0', 'en', 0, 0, '0.0000', 0, '0.0000', 1, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_actions`
--

CREATE TABLE `users_actions` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locale_detail` text COLLATE utf8mb4_unicode_ci,
  `data` text COLLATE utf8mb4_unicode_ci,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_addresses`
--

CREATE TABLE `users_addresses` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `city` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `counti` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00000',
  `detouse` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_affiliates`
--

CREATE TABLE `users_affiliates` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `disabled` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_information` text COLLATE utf8mb4_unicode_ci,
  `commission_type` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission_period` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission_value` decimal(16,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `balance` decimal(16,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `currency` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_affiliate_history`
--

CREATE TABLE `users_affiliate_history` (
  `id` int(11) UNSIGNED NOT NULL,
  `affiliate_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `transaction_id` int(11) NOT NULL DEFAULT '0',
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(16,4) NOT NULL DEFAULT '0.0000'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_affiliate_hits`
--

CREATE TABLE `users_affiliate_hits` (
  `id` int(11) UNSIGNED NOT NULL,
  `affiliate_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `referrer_id` int(11) NOT NULL,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_affiliate_referrers`
--

CREATE TABLE `users_affiliate_referrers` (
  `id` int(11) UNSIGNED NOT NULL,
  `affiliate_id` int(11) NOT NULL DEFAULT '0',
  `referrer` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_affiliate_transactions`
--

CREATE TABLE `users_affiliate_transactions` (
  `id` int(11) UNSIGNED NOT NULL,
  `affiliate_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `order_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `clicked_ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `clearing_date` date NOT NULL DEFAULT '0000-00-00',
  `completed_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `currency` int(11) NOT NULL DEFAULT '0',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `commission` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `exchange` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_affiliate_withdrawals`
--

CREATE TABLE `users_affiliate_withdrawals` (
  `id` int(11) UNSIGNED NOT NULL,
  `affiliate_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completed_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gateway` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `gateway_info` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `currency` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'awaiting',
  `status_msg` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_credit_logs`
--

CREATE TABLE `users_credit_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'up',
  `amount` decimal(16,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `cid` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_custom_fields`
--

CREATE TABLE `users_custom_fields` (
  `id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `skey` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT 'inactive',
  `required` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `uneditable` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `template` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci,
  `rank` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_custom_fields`
--

INSERT INTO `users_custom_fields` (`id`, `lang`, `type`, `skey`, `name`, `status`, `required`, `uneditable`, `template`, `options`, `rank`) VALUES
(1, 'tr', 'radio', NULL, 'Cinsiyetiniz', 'active', 0, 0, NULL, 'Erkek,Kadın', 0),
(2, 'tr', 'select', NULL, 'Bizi Nereden Duydunuz?', 'active', 0, 0, NULL, 'Google,R10.Net,Diğer Webmaster siteleri', 1),
(31, 'tr', 'textarea', NULL, 'Notlarım', 'active', 0, 0, NULL, '', 2),
(121, 'en', 'select', NULL, 'How did you hear about us?', 'active', 0, 0, NULL, 'Google,Social Media,From a friend,Online Forums', 4),
(118, 'en', 'radio', NULL, 'Your Gender', 'active', 0, 0, NULL, 'Male,Female', 3),
(122, 'en', 'textarea', NULL, 'My Notes', 'active', 0, 0, NULL, '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users_document_filters`
--

CREATE TABLE `users_document_filters` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `rules` text COLLATE utf8mb4_unicode_ci,
  `fields` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_document_records`
--

CREATE TABLE `users_document_records` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `filter_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `field_lang` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `field_key` int(11) DEFAULT '0',
  `field_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `field_name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_value` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'awaiting',
  `status_msg` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unread` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_informations`
--

CREATE TABLE `users_informations` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_informations`
--

INSERT INTO `users_informations` (`id`, `owner_id`, `name`, `content`, `created_at`, `updated_at`) VALUES
(41, 1, 'notes', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 1, 'signature', '{\"tr\":\"Best Regards,\\nGood Works.\\nSupport Team.\\n\",\"en\":\"Best Regards,\\nGood Works.\\nSupport Team.\\n\"}', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users_last_logins`
--

CREATE TABLE `users_last_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latlng` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_products`
--

CREATE TABLE `users_products` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `invoice_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `subscription_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `type_id` int(5) NOT NULL DEFAULT '0',
  `product_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `period_time` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `total_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `amount` decimal(16,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `amount_cid` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `status_msg` text COLLATE utf8mb4_unicode_ci,
  `pmethod` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_pay` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `duedate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `suspend_date` date NOT NULL DEFAULT '0000-00-00',
  `cancel_date` date NOT NULL DEFAULT '0000-00-00',
  `renewaldate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `process_exemption_date` datetime NOT NULL DEFAULT '1881-05-19 23:59:59',
  `module` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `unread` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_products_addons`
--

CREATE TABLE `users_products_addons` (
  `id` int(11) UNSIGNED NOT NULL,
  `invoice_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `pmethod` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `addon_plink_relid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `addon_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `addon_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `addon_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_id` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `option_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_quantity` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `period_time` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `period` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `amount` decimal(16,4) UNSIGNED NOT NULL DEFAULT '0.0000',
  `cid` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'waiting',
  `status_msg` text COLLATE utf8mb4_unicode_ci,
  `module_data` text COLLATE utf8mb4_unicode_ci,
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `renewaldate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `duedate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `unread` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_products_requirements`
--

CREATE TABLE `users_products_requirements` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `requirement_key` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirement_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `requirement_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `response` text COLLATE utf8mb4_unicode_ci,
  `response_mkey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_co_names` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_products_subscriptions`
--

CREATE TABLE `users_products_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `module` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `status_msg` text COLLATE utf8mb4_unicode_ci,
  `identifier` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `first_paid_fee` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `last_paid_fee` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `next_payable_fee` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `last_paid_date` datetime NOT NULL DEFAULT '1971-01-01 00:00:00',
  `next_payable_date` datetime NOT NULL,
  `created_at` datetime DEFAULT '1971-01-01 00:00:00',
  `updated_at` datetime DEFAULT '1971-01-01 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_products_updowngrades`
--

CREATE TABLE `users_products_updowngrades` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `invoice_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `old_pid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `new_pid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'up',
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `status_msg` text COLLATE utf8mb4_unicode_ci,
  `refund` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `options` text COLLATE utf8mb4_unicode_ci,
  `unread` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_reminders`
--

CREATE TABLE `users_reminders` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `creation_time` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `period` enum('onetime','recurring') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'onetime',
  `period_datetime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `period_month` int(2) NOT NULL DEFAULT '-1',
  `period_day` int(2) NOT NULL DEFAULT '-1',
  `period_hour` int(2) NOT NULL DEFAULT '-1',
  `period_minute` int(2) NOT NULL DEFAULT '-1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_reminders_logs`
--

CREATE TABLE `users_reminders_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `reminding_date` date NOT NULL DEFAULT '1881-05-19',
  `reminding_time` time NOT NULL DEFAULT '00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_sms_groups`
--

CREATE TABLE `users_sms_groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numbers` text COLLATE utf8mb4_unicode_ci,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_sms_origins`
--

CREATE TABLE `users_sms_origins` (
  `id` int(10) UNSIGNED NOT NULL,
  `orkey` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctime` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `approved_date` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `attachments` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `status_message` text COLLATE utf8mb4_unicode_ci,
  `approved_countries` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unread` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_sms_origin_prereg`
--

CREATE TABLE `users_sms_origin_prereg` (
  `id` int(11) UNSIGNED NOT NULL,
  `origin_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ccode` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachments` text COLLATE utf8mb4_unicode_ci,
  `cdate` datetime NOT NULL DEFAULT '1881-05-19 00:00:00',
  `status` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_msg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_stored_cards`
--

CREATE TABLE `users_stored_cards` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `as_default` int(1) NOT NULL DEFAULT '0',
  `card_country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_schema` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ln4` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cvc` text COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_month` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_year` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_tasks`
--

CREATE TABLE `users_tasks` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `departments` text COLLATE utf8mb4_unicode_ci,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `c_date` date NOT NULL DEFAULT '1881-05-19',
  `due_date` date NOT NULL DEFAULT '1881-05-19',
  `status` enum('waiting','inprocess','completed','postponed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `status_note` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) UNSIGNED NOT NULL,
  `owner` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `owner_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `cdate` date NOT NULL DEFAULT '0000-00-00',
  `total` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocked`
--
ALTER TABLE `blocked`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_lang`
--
ALTER TABLE `categories_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counties`
--
ALTER TABLE `counties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries_lang`
--
ALTER TABLE `countries_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_feedbacks`
--
ALTER TABLE `customer_feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_feedbacks_lang`
--
ALTER TABLE `customer_feedbacks_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `name` (`name`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `fraud_detected_records`
--
ALTER TABLE `fraud_detected_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_expense`
--
ALTER TABLE `income_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `invoices_items`
--
ALTER TABLE `invoices_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_pid` (`user_pid`);

--
-- Indexes for table `knowledgebase`
--
ALTER TABLE `knowledgebase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knowledgebase_lang`
--
ALTER TABLE `knowledgebase_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_logs`
--
ALTER TABLE `mail_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus_lang`
--
ALTER TABLE `menus_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates_logs`
--
ALTER TABLE `notification_templates_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages_lang`
--
ALTER TABLE `pages_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periodic_outgoings`
--
ALTER TABLE `periodic_outgoings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_addons`
--
ALTER TABLE `products_addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_addons_lang`
--
ALTER TABLE `products_addons_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_lang`
--
ALTER TABLE `products_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_requirements`
--
ALTER TABLE `products_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_requirements_lang`
--
ALTER TABLE `products_requirements_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides_lang`
--
ALTER TABLE `slides_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `did` (`did`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned` (`assigned`),
  ADD KEY `service` (`service`);

--
-- Indexes for table `tickets_attachments`
--
ALTER TABLE `tickets_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `reply_id` (`reply_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tickets_custom_fields`
--
ALTER TABLE `tickets_custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_custom_fields_lang`
--
ALTER TABLE `tickets_custom_fields_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_departments`
--
ALTER TABLE `tickets_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_departments_lang`
--
ALTER TABLE `tickets_departments_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_predefined_replies`
--
ALTER TABLE `tickets_predefined_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_predefined_replies_lang`
--
ALTER TABLE `tickets_predefined_replies_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_replies`
--
ALTER TABLE `tickets_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `tldlist`
--
ALTER TABLE `tldlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_actions`
--
ALTER TABLE `users_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `reason` (`reason`(250)),
  ADD KEY `detail` (`detail`(250));

--
-- Indexes for table `users_addresses`
--
ALTER TABLE `users_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `users_affiliates`
--
ALTER TABLE `users_affiliates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `users_affiliate_history`
--
ALTER TABLE `users_affiliate_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_id` (`affiliate_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `users_affiliate_hits`
--
ALTER TABLE `users_affiliate_hits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_id` (`affiliate_id`),
  ADD KEY `referrer_id` (`referrer_id`);

--
-- Indexes for table `users_affiliate_referrers`
--
ALTER TABLE `users_affiliate_referrers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_id` (`affiliate_id`);

--
-- Indexes for table `users_affiliate_transactions`
--
ALTER TABLE `users_affiliate_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_id` (`affiliate_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users_affiliate_withdrawals`
--
ALTER TABLE `users_affiliate_withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_id` (`affiliate_id`);

--
-- Indexes for table `users_credit_logs`
--
ALTER TABLE `users_credit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_custom_fields`
--
ALTER TABLE `users_custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_document_filters`
--
ALTER TABLE `users_document_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_document_records`
--
ALTER TABLE `users_document_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_informations`
--
ALTER TABLE `users_informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `users_last_logins`
--
ALTER TABLE `users_last_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `users_products`
--
ALTER TABLE `users_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `users_products_addons`
--
ALTER TABLE `users_products_addons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `addon_id` (`addon_id`),
  ADD KEY `option_id` (`option_id`);

--
-- Indexes for table `users_products_requirements`
--
ALTER TABLE `users_products_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `users_products_subscriptions`
--
ALTER TABLE `users_products_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `identifier` (`identifier`(250));

--
-- Indexes for table `users_products_updowngrades`
--
ALTER TABLE `users_products_updowngrades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `users_reminders`
--
ALTER TABLE `users_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_reminders_logs`
--
ALTER TABLE `users_reminders_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_sms_groups`
--
ALTER TABLE `users_sms_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_sms_origins`
--
ALTER TABLE `users_sms_origins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_sms_origin_prereg`
--
ALTER TABLE `users_sms_origin_prereg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_stored_cards`
--
ALTER TABLE `users_stored_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_tasks`
--
ALTER TABLE `users_tasks`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `owner_id` (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocked`
--
ALTER TABLE `blocked`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;
--
-- AUTO_INCREMENT for table `categories_lang`
--
ALTER TABLE `categories_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=383;
--
-- AUTO_INCREMENT for table `checkouts`
--
ALTER TABLE `checkouts`
  MODIFY `id` bigint(16) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4119;
--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `counties`
--
ALTER TABLE `counties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=977;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;
--
-- AUTO_INCREMENT for table `countries_lang`
--
ALTER TABLE `countries_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;
--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT for table `customer_feedbacks`
--
ALTER TABLE `customer_feedbacks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `customer_feedbacks_lang`
--
ALTER TABLE `customer_feedbacks_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fraud_detected_records`
--
ALTER TABLE `fraud_detected_records`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `income_expense`
--
ALTER TABLE `income_expense`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices_items`
--
ALTER TABLE `invoices_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `knowledgebase`
--
ALTER TABLE `knowledgebase`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `knowledgebase_lang`
--
ALTER TABLE `knowledgebase_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `mail_logs`
--
ALTER TABLE `mail_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT for table `menus_lang`
--
ALTER TABLE `menus_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=438;
--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `notification_templates_logs`
--
ALTER TABLE `notification_templates_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `pages_lang`
--
ALTER TABLE `pages_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;
--
-- AUTO_INCREMENT for table `periodic_outgoings`
--
ALTER TABLE `periodic_outgoings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;
--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1165;
--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `products_addons`
--
ALTER TABLE `products_addons`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `products_addons_lang`
--
ALTER TABLE `products_addons_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `products_lang`
--
ALTER TABLE `products_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;
--
-- AUTO_INCREMENT for table `products_requirements`
--
ALTER TABLE `products_requirements`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `products_requirements_lang`
--
ALTER TABLE `products_requirements_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `slides_lang`
--
ALTER TABLE `slides_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets_attachments`
--
ALTER TABLE `tickets_attachments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets_custom_fields`
--
ALTER TABLE `tickets_custom_fields`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tickets_custom_fields_lang`
--
ALTER TABLE `tickets_custom_fields_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tickets_departments`
--
ALTER TABLE `tickets_departments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tickets_departments_lang`
--
ALTER TABLE `tickets_departments_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tickets_predefined_replies`
--
ALTER TABLE `tickets_predefined_replies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tickets_predefined_replies_lang`
--
ALTER TABLE `tickets_predefined_replies_lang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tickets_replies`
--
ALTER TABLE `tickets_replies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tldlist`
--
ALTER TABLE `tldlist`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_actions`
--
ALTER TABLE `users_actions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_addresses`
--
ALTER TABLE `users_addresses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_affiliates`
--
ALTER TABLE `users_affiliates`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_affiliate_history`
--
ALTER TABLE `users_affiliate_history`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_affiliate_hits`
--
ALTER TABLE `users_affiliate_hits`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_affiliate_referrers`
--
ALTER TABLE `users_affiliate_referrers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_affiliate_transactions`
--
ALTER TABLE `users_affiliate_transactions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_affiliate_withdrawals`
--
ALTER TABLE `users_affiliate_withdrawals`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_credit_logs`
--
ALTER TABLE `users_credit_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_custom_fields`
--
ALTER TABLE `users_custom_fields`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `users_document_filters`
--
ALTER TABLE `users_document_filters`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_document_records`
--
ALTER TABLE `users_document_records`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users_informations`
--
ALTER TABLE `users_informations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `users_last_logins`
--
ALTER TABLE `users_last_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_products`
--
ALTER TABLE `users_products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_products_addons`
--
ALTER TABLE `users_products_addons`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_products_requirements`
--
ALTER TABLE `users_products_requirements`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_products_subscriptions`
--
ALTER TABLE `users_products_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1234;
--
-- AUTO_INCREMENT for table `users_products_updowngrades`
--
ALTER TABLE `users_products_updowngrades`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_reminders`
--
ALTER TABLE `users_reminders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_reminders_logs`
--
ALTER TABLE `users_reminders_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_sms_groups`
--
ALTER TABLE `users_sms_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_sms_origins`
--
ALTER TABLE `users_sms_origins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_sms_origin_prereg`
--
ALTER TABLE `users_sms_origin_prereg`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_stored_cards`
--
ALTER TABLE `users_stored_cards`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users_tasks`
--
ALTER TABLE `users_tasks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
