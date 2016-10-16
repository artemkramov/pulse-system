-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 16 2016 г., 18:32
-- Версия сервера: 10.1.16-MariaDB
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `diploma`
--

DELIMITER $$
--
-- Функции
--
CREATE DEFINER=`root`@`localhost` FUNCTION `returnNumericOnly`(`str` VARCHAR(1000)) RETURNS varchar(1000) CHARSET utf8
BEGIN
  DECLARE counter INT DEFAULT 0;
  DECLARE strLength INT DEFAULT 0;
  DECLARE strChar VARCHAR(1000) DEFAULT '' ;
  DECLARE retVal VARCHAR(1000) DEFAULT '';
  SET strLength = LENGTH(str);
  WHILE strLength > 0 DO
    SET counter = counter+1;
    SET strChar = SUBSTRING(str,counter,1);
    IF strChar REGEXP('[0-9]+') = 1
      THEN SET retVal = CONCAT(retVal,strChar);
    END IF;
    SET strLength = strLength -1;
    SET strChar = NULL;
  END WHILE;
RETURN retVal;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `street` tinytext NOT NULL,
  `building` varchar(10) NOT NULL,
  `flat` varchar(10) DEFAULT NULL,
  `zip` varchar(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `address`
--

INSERT INTO `address` (`id`, `phone`, `country_id`, `city`, `region`, `street`, `building`, `flat`, `zip`, `user_id`) VALUES
(4, '0501493132', 1, 'Poltava', 'Myrgorod', 'lenina', '34234', '', '344234', 47);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1470000223),
('admin', '32', 1469962054),
('admin', '33', 1469996415),
('admin', '34', 1469996479),
('admin', '7', 1457030690),
('admin', '8', 1457030722),
('employee', '10', 1464244325),
('employee', '11', 1457110756),
('employee', '12', 1457110796),
('employee', '13', 1457110836),
('employee', '14', 1457110869),
('employee', '15', 1457514681),
('employee', '16', 1457110935),
('employee', '17', 1457110968),
('employee', '18', 1457110999),
('employee', '19', 1457111027),
('employee', '2', 1457030671),
('employee', '20', 1457111064),
('employee', '21', 1457111114),
('employee', '22', 1457111144),
('employee', '23', 1457111200),
('employee', '24', 1457111229),
('employee', '25', 1457111272),
('employee', '26', 1457514817),
('employee', '27', 1457609530),
('employee', '28', 1457622928),
('employee', '29', 1458058257),
('employee', '7', 1457030690),
('employee', '9', 1457030749),
('operator', '30', 1476628974);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `parent_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`, `parent_id`) VALUES
('admin', 1, 'Administrator', NULL, NULL, 1457028578, 1472991546, NULL),
('content', 2, 'Content management', NULL, NULL, 1469903227, 1469903227, ''),
('content/posts', 2, 'Posts management', NULL, NULL, 1469903256, 1469903256, 'content'),
('dashboard/default/index', 2, 'Dashboard', NULL, NULL, 1468306058, 1468306516, ''),
('i18n', 2, 'Translation management', NULL, NULL, 1464245784, 1464245784, NULL),
('operator', 1, 'Operator', NULL, NULL, 1476628916, 1476629100, NULL),
('permit/access', 2, 'Role and permission management', NULL, NULL, 1457031451, 1457031915, NULL),
('products', 2, 'Shop management', NULL, NULL, 1470493916, 1470493916, ''),
('products/categories', 2, 'Category management', NULL, NULL, 1470493949, 1470493949, 'products'),
('products/characteristic-groups', 2, 'Characteristic group management', NULL, NULL, 1470571801, 1470571801, 'products'),
('products/characteristics', 2, 'Characteristic management', NULL, NULL, 1470583744, 1470583744, 'products'),
('products/email-settings', 2, 'Email setting management', NULL, NULL, 1472546012, 1472546012, 'products/products'),
('products/email-templates', 2, 'Email templates management', NULL, NULL, 1472497313, 1472537484, 'products/products'),
('products/kits', 2, 'Kit management', NULL, NULL, 1471679008, 1471679008, 'products/products'),
('products/orders', 2, 'Order management', NULL, NULL, 1472463630, 1472463630, 'products/products'),
('products/payment-types', 2, 'Payment type management', NULL, NULL, 1472473845, 1472473845, 'products/products'),
('products/products', 2, 'Products management', NULL, NULL, 1465389945, 1465389945, NULL),
('products/products/index', 2, 'Products list', NULL, NULL, 1466062609, 1467648432, 'products/products'),
('products/products/view', 2, 'Products view item', 'isAuthorManyToMany', NULL, 1466065286, 1467648441, 'products/products'),
('products/sales', 2, 'Sales management', NULL, NULL, 1472887378, 1472887378, 'products/products'),
('settings', 2, 'Settings management', NULL, NULL, 1467648490, 1467819771, ''),
('settings/brands', 2, 'Brand management', NULL, NULL, 1465308163, 1467648516, 'settings'),
('settings/contact-form-settings/index', 2, 'Contact form settings list', NULL, NULL, 1470330678, 1470330678, 'settings'),
('settings/contact-form-settings/update', 2, 'Contact form settings update', NULL, NULL, 1470330545, 1470330545, 'settings'),
('settings/contact-form-settings/view', 2, 'Contact form settings view', NULL, NULL, 1470330524, 1470330524, 'settings'),
('settings/currencies', 2, 'Currency management', NULL, NULL, 1466605394, 1467648528, 'settings'),
('settings/settings', 2, 'Setting components management', NULL, NULL, 1472991531, 1472991531, 'settings'),
('settings/social-links', 2, 'Social links management', NULL, NULL, 1470214931, 1470214931, 'settings'),
('settings/stocks', 2, 'Stock management', NULL, NULL, 1470330620, 1470330620, 'settings'),
('settings/templates', 2, 'Template management', NULL, NULL, 1465215892, 1467648539, 'settings'),
('users', 2, 'User management', NULL, NULL, 1457028692, 1457031410, NULL),
('users/customers/index', 2, 'Client heart beat index', NULL, NULL, 1476629074, 1476629074, 'users'),
('users/users/change-password', 2, 'Change password', NULL, NULL, 1457105560, 1467648581, 'users'),
('users/users/update', 2, 'Update own profile', NULL, NULL, 1464271347, 1467648597, 'users');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'content'),
('admin', 'content/posts'),
('admin', 'dashboard/default/index'),
('admin', 'i18n'),
('admin', 'permit/access'),
('admin', 'products/categories'),
('admin', 'products/characteristic-groups'),
('admin', 'products/characteristics'),
('admin', 'products/email-settings'),
('admin', 'products/email-templates'),
('admin', 'products/kits'),
('admin', 'products/orders'),
('admin', 'products/payment-types'),
('admin', 'products/products'),
('admin', 'products/sales'),
('admin', 'settings/brands'),
('admin', 'settings/contact-form-settings/index'),
('admin', 'settings/contact-form-settings/update'),
('admin', 'settings/contact-form-settings/view'),
('admin', 'settings/currencies'),
('admin', 'settings/settings'),
('admin', 'settings/social-links'),
('admin', 'settings/stocks'),
('admin', 'settings/templates'),
('admin', 'users'),
('employee', 'reports/jobs/create'),
('employee', 'reports/jobs/project-employee'),
('employee', 'users/users/change-password'),
('operator', 'users/customers/index'),
('sales_organization', 'customers/customers/index'),
('sales_organization', 'users/users/change-password');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 'O:19:"app\\rbac\\AuthorRule":3:{s:4:"name";s:8:"isAuthor";s:9:"createdAt";i:1466665166;s:9:"updatedAt";i:1466665166;}', 1466665166, 1466665166),
('isAuthorManyToMany', 'O:29:"app\\rbac\\AuthorManyToManyRule":3:{s:4:"name";s:18:"isAuthorManyToMany";s:9:"createdAt";i:1467467624;s:9:"updatedAt";i:1467467624;}', 1467467624, 1467467624),
('isItself', 'O:19:"app\\rbac\\ItselfRule":3:{s:4:"name";s:8:"isItself";s:9:"createdAt";i:1467465859;s:9:"updatedAt";i:1467465859;}', 1467465859, 1467465859);

-- --------------------------------------------------------

--
-- Структура таблицы `contact_form_setting`
--

CREATE TABLE IF NOT EXISTS `contact_form_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `contact_form_setting`
--

INSERT INTO `contact_form_setting` (`id`, `to`, `from`, `subject`, `body`) VALUES
(1, 'artemkramov@gmail.com', 'shop@jenadin.com.ua', 'Данные с контактной формы', '<p>From: [CONTACT_FORM_NAME]&nbsp;&lt;[CONTACT_FORM_EMAIL]&gt;</p>\r\n<p>&nbsp;</p>\r\n<p>Message body:</p>\r\n<p>[CONTACT_FORM_MESSAGE]</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(60) DEFAULT NULL,
  `title_ua` varchar(60) DEFAULT NULL,
  `title_be` varchar(60) DEFAULT NULL,
  `title_en` varchar(60) DEFAULT NULL,
  `title_es` varchar(60) DEFAULT NULL,
  `title_pt` varchar(60) DEFAULT NULL,
  `title_de` varchar(60) DEFAULT NULL,
  `title_fr` varchar(60) DEFAULT NULL,
  `title_it` varchar(60) DEFAULT NULL,
  `title_pl` varchar(60) DEFAULT NULL,
  `title_ja` varchar(60) DEFAULT NULL,
  `title_lt` varchar(60) DEFAULT NULL,
  `title_lv` varchar(60) DEFAULT NULL,
  `title_cz` varchar(60) DEFAULT NULL,
  `iso` varchar(2) NOT NULL,
  `currency_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `currency_id` (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=236 ;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `title_ru`, `title_ua`, `title_be`, `title_en`, `title_es`, `title_pt`, `title_de`, `title_fr`, `title_it`, `title_pl`, `title_ja`, `title_lt`, `title_lv`, `title_cz`, `iso`, `currency_id`) VALUES
(1, 'Украина', 'Україна', 'Украіна', 'Ukraine', 'Ucrania', 'Ucrânia', 'Ukraine', 'Ukraine', 'Ucraina', 'Ukraina', 'ウクライナ', 'Ukraina', 'Ukraina', 'Ukrajina', 'ua', 1),
(2, 'Россия', 'Росiя', 'Расея', 'Russia', 'Rusia', 'Rússia', 'Russland', 'Russie', 'Russia', 'Rosja', 'ロシア', 'Rusija', 'Krievija', 'Rusko', 'ru', 2),
(3, 'Беларусь', 'Бiлорусь', 'Беларусь', 'Belarus', 'Bielorrusia', 'Bielorrússia', 'Weißrussland', 'Belorus', 'Bielorussia', 'Białoruś', 'ベラルーシ', 'Baltarusija', 'Baltkrievija', 'Bělorusko', 'by', 2),
(4, 'Казахстан', 'Казахстан', 'Казахстан', 'Kazakhstan', 'Kazajistán', 'Cazaquistão', 'Kasachstan', 'Kazakhstan', 'Kazakistan', 'Kazachstan', 'カザフスタン', 'Kazachstanas', 'Kazahstāna', 'Kazachstán', 'kz', 2),
(5, 'Азербайджан', 'Азербайджан', 'Азэрбайджан', 'Azerbaijan', 'Azerbaiyán', 'Azerbaijão', 'Aserbaidschan', 'Azerbaïdjan', 'Azerbaijan', 'Azerbejdżan', 'アゼルバイジャン', 'Azerbaidžanas', 'Azerbaidžāna', 'Ázerbajdžán', 'az', 2),
(6, 'Армения', 'Вiрменiя', 'Арменія', 'Armenia', 'Armenia', 'Arménia', 'Armenien', 'Arménie', 'Armenia', 'Armenia', 'アルメニア', 'Armėnija', 'Armēnija', 'Arménie', 'am', 2),
(7, 'Грузия', 'Грузiя', 'Грузія', 'Georgia', 'Georgia', 'Geórgia', 'Georgien', 'Géorgie', 'Georgia', 'Gruzja', 'グルジア', 'Gruzija', 'Gruzija', 'Gruzie', 'ge', 2),
(8, 'Израиль', 'Iзраїль', 'Ізраіль', 'Israel', 'Israel', 'Israel', 'Israel', 'Israël', 'Israele', 'Izrael', 'イスラエル', 'Izraelis', 'Izraela', 'Izrael', 'il', 2),
(9, 'США', 'США', 'ЗША', 'USA', 'EE.UU.', 'EUA', 'USA', 'USA', 'Stati Uniti', 'USA', 'アメリカ合衆国', 'JAV', 'ASV', 'USA', 'us', 2),
(10, 'Канада', 'Канада', 'Канада', 'Canada', 'Canadá', 'Canadá', 'Kanada', 'Canada', 'Canada', 'Kanada', 'カナダ', 'Kanada', 'Kanāda', 'Kanada', 'ca', 2),
(11, 'Кыргызстан', 'Киргизстан', 'Кыргызтан', 'Kyrgyzstan', 'Kirguistán', 'Quirguistão', 'Kirgisistan', 'Kirghizstan', 'Kyrgyzstan', 'Kirgistan', 'キルギスタン', 'Kirgizija', 'Kirgizstāna', 'Kyrgyzstán', 'kg', 2),
(12, 'Латвия', 'Латвiя', 'Латвія', 'Latvia', 'Letonia', 'Letónia', 'Lettland', 'Lettonie', 'Lettonia', 'Łotwa', 'ラトヴィア', 'Latvija', 'Latvija', 'Lotyšsko', 'lv', 2),
(13, 'Литва', 'Литва', 'Летува', 'Lithuania', 'Lituania', 'Lituânia', 'Litauen', 'Lituanie', 'Lituania', 'Litwa', 'リトアニア', 'Lietuva', 'Lietuva', 'Litva', 'lt', 2),
(14, 'Эстония', 'Естонiя', 'Эстонія', 'Estonia', 'Estonia', 'Estónia', 'Estland', 'Estonie', 'Estonia', 'Estonia', 'エストニア', 'Estija', 'Igaunija', 'Estonsko', 'ee', 2),
(15, 'Молдова', 'Молдова', 'Малдова', 'Moldova', 'Moldavia', 'Moldávia', 'Moldavien', 'Moldavie', 'Moldavia', 'Mołdawia', 'モルドバ', 'Moldova', 'Moldova', 'Moldavsko', 'md', 2),
(16, 'Таджикистан', 'Таджикистан', 'Таджыкістан', 'Tajikistan', 'Tadjikistán', 'Tadjiquistão', 'Tadschikistan', 'Tadjikistan', 'Tajikistan', 'Tadżykistan', 'タジキスタン', 'Tadžikistanas', 'Tadžikistāna', 'Tádžikistán', 'tj', 2),
(17, 'Туркменистан', 'Туркменістан', 'Туркмэністан', 'Turkmenistan', 'Turkmenistán', 'Turquemenistão', 'Turkmenistan', 'Turkménistan', 'Turkmenistan', 'Turkmenistan', 'トルクメニスタン', 'Turkmėnistanas', 'Turkmenistāna', 'Turkmenistán', 'tm', 2),
(18, 'Узбекистан', 'Узбекистан', 'Узбэкістан', 'Uzbekistan', 'Uzbekistán', 'Uzbequistão', 'Usbekistan', 'Ouzbékistan', 'Uzbekistan', 'Uzbekistan', 'ウズベキスタン', 'Uzbekistanas', 'Uzbekistāna', 'Uzbekistán', 'uz', 2),
(19, 'Австралия', 'Австралiя', 'Аўстралія', 'Australia', 'Australia', 'Austrália', 'Australien', 'Australie', 'Australia', 'Australia', 'オーストラリア', 'Australija', 'Austrālija', 'Austrálie', 'au', 2),
(20, 'Австрия', 'Австрiя', 'Аўстрыя', 'Austria', 'Austria', 'Áustria', 'Österreich', 'Autriche', 'Austria', 'Austria', 'オーストリア', 'Austrija', 'Austrija', 'Rakousko', 'at', 2),
(21, 'Албания', 'Албанiя', 'Альбанія', 'Albania', 'Albania', 'Albânia', 'Albanien', 'Albanie', 'Albania', 'Albania', 'アルバニア', 'Albanija', 'Albānija', 'Albánie', 'al', 2),
(22, 'Алжир', 'Алжир', 'Альжыр', 'Algeria', 'Argelia', 'Argélia', 'Algerien', 'Algérie', 'Algeria', 'Algeria', 'アルジェリア', 'Alžyras', 'Alžīrija', 'Alžírsko', 'dz', 2),
(23, 'Американское Самоа', 'Американське Самоа', 'Амэрыканскае Самоа', 'American Samoa', 'Samoa Americana', 'Samoa Americana', 'Amerikanisch Samoa', 'Samoa américaines', 'Samoa Americana', 'Samoa Amerykańskie', 'アメリカ領サモア', 'Amerikos Samoa', 'Amerikas Samoa', 'Americká Samoa', 'ds', 2),
(24, 'Ангилья', 'Ангілья', 'Анґілья', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'アンギラ', 'Angilija', 'Angilja', 'Anguilla', 'ai', 2),
(25, 'Ангола', 'Ангола', 'Ангола', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola', 'アンゴラ', 'Angola', 'Angola', 'Angola', 'ao', 2),
(26, 'Андорра', 'Андорра', 'Андора', 'Andorra', 'Andorra', 'Andorra', 'Andorra', 'Andorre', 'Andorra', 'Andorra', 'アンドラ', 'Andora', 'Andora', 'Andorra', 'ad', 2),
(27, 'Антигуа и Барбуда', 'Антiгуа i Барбуда', 'Антыгуа і Барбуда', 'Antigua and Barbuda', 'Antigua y Barbuda', 'Antígua e Barbuda', 'Antigua und Barbuda', 'Antigua et Barbuda', 'Antigua e Barbuda', 'Antigua i Barbuda', 'アンティグア・バーブーダ', 'Antikva ir Barbuda', 'Antigva un Barbuda', 'Antigua a Barbuda', 'ag', 2),
(28, 'Аргентина', 'Аргентина', 'Аргентына', 'Argentina', 'Argentina', 'Argentina', 'Argentinien', 'Argentine', 'Argentina', 'Argentyna', 'アルゼンチン', 'Argentina', 'Argentīna', 'Argentina', 'ar', 2),
(29, 'Аруба', 'Аруба', 'Аруба', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'アルバ', 'Aruba', 'Aruba', 'Aruba', 'aw', 2),
(30, 'Афганистан', 'Афганiстан', 'Аўганістан', 'Afghanistan', 'Afganistán', 'Afeganistão', 'Afghanistan', 'Afghanistan', 'Afghanistan', 'Afganistan', 'アフガニスタン', 'Afganistanas', 'Afganistāna', 'Afghánistán', 'af', 2),
(31, 'Багамы', 'Багами', 'Багамы', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahama', 'バハマ', 'Bahamai', 'Bahamu salas', 'Bahamy', 'bs', 2),
(32, 'Бангладеш', 'Бангладеш', 'Бангладэш', 'Bangladesh', 'Bangladesh', 'Bangladesh', 'Bangladesch', 'Bengladesh', 'Bangladesh', 'Bangladesz', 'バングラディシュ', 'Bangladešas', 'Bangladeša', 'Bangladéš', 'bd', 2),
(33, 'Барбадос', 'Барбадос', 'Барбадос', 'Barbados', 'Barbados', 'Barbados', 'Barbados', 'Barbades', 'Barbados', 'Barbados', 'バルバドス', 'Barbadosas', 'Barbadosa', 'Barbados', 'bb', 2),
(34, 'Бахрейн', 'Бахрейн', 'Бахрэйн', 'Bahrain', 'Bahréin', 'Bahrein', 'Bahrain', 'Bahreïn', 'Bahrain', 'Bahrain', 'バーレーン', 'Bahreinas', 'Bahreina', 'Bahrajn', 'bh', 2),
(35, 'Белиз', 'Белiз', 'Бэліз', 'Belize', 'Belice', 'Belize', 'Belize', 'Bélize', 'Belize', 'Belize', 'ベリーズ', 'Belizas', 'Belīza', 'Belize', 'bz', 2),
(36, 'Бельгия', 'Бельгiя', 'Бэльгія', 'Belgium', 'Bélgica', 'Bélgica', 'Belgien', 'Belgique', 'Belgio', 'Belgia', 'ベルギー', 'Belgija', 'Beļģija', 'Belgie', 'be', 2),
(37, 'Бенин', 'Бенiн', 'Бэнін', 'Benin', 'Benín', 'Benin', 'Benin', 'Bénin', 'Benin', 'Benin', 'ベナン', 'Beninas', 'Benīna', 'Benin', 'bj', 2),
(38, 'Бермуды', 'Бермуди', 'Бэрмуды', 'Bermuda', 'Bermudas', 'Bermudas', 'Bermudas', 'Bermudes', 'Bermuda', 'Bermudy', 'バミューダ', 'Bermudai', 'Bermudu salas', 'Bermudské ostrovy', 'bm', 2),
(39, 'Болгария', 'Болгарiя', 'Баўгарыя', 'Bulgaria', 'Bulgaria', 'Bulgária', 'Bulgarien', 'Bulgarie', 'Bulgaria', 'Bułgaria', 'ブルガリア', 'Bulgarija', 'Bulgārija', 'Bulharsko', 'bg', 2),
(40, 'Боливия', 'Болiвiя', 'Балівія', 'Bolivia', 'Bolivia', 'Bolívia', 'Bolivien', 'Bolivie', 'Bolivia', 'Boliwia', 'ボリビア', 'Bolivija', 'Bolīvija', 'Bolívie', 'bo', 2),
(41, 'Босния и Герцеговина', 'Боснiя i Герцеговина', 'Босьнія й Герцаґавіна', 'Bosnia and Herzegovina', 'Bosnia y Herzegovina', 'Bósnia e Herzegovina', 'Bosnien-Herzegowina', 'Bosnie Herzégovine', 'Bosnia Herzegovina', 'Bośnia and Herzegowina', 'ボスニア・ヘルツェゴビナ', 'Bosnija ir Hercegovina', 'Bosnija un Hercogovīna', 'Bosna a Hercegovina', 'ba', 2),
(42, 'Ботсвана', 'Ботсвана', 'Батсвана', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'ボツワナ', 'Botsvana', 'Botstvana', 'Botswana', 'bw', 2),
(43, 'Бразилия', 'Бразилiя', 'Бразылія', 'Brazil', 'Brasil', 'Brasil', 'Brasilien', 'Brésil', 'Brasile', 'Brazylia', 'ブラジル', 'Brazilija', 'Brazīlija', 'Brazílie', 'br', 2),
(44, 'Бруней-Даруссалам', 'Бруней-Дарусалам', 'Брунэй-Дарусалам', 'Brunei Darussalam', 'Brunéi', 'Brunei Darussalam', 'Brunei Darussalam', 'Bruneï', 'Brunei Darussalam', 'Brunei', 'ブルネイ・ダルサラーム', 'Brunėjaus Dar Es Salamas', 'Bruneja', 'Brunej', 'bn', 2),
(45, 'Буркина-Фасо', 'Буркина-Фасо', 'Буркіна-Фасо', 'Burkina Faso', 'Burkina Faso', 'Burkina Faso', 'Burkina Faso', 'Burkina Faso', 'Burkina Faso', 'Burkina Faso', 'ブルキナファソ', 'Burkina Faso', 'Burkinafaso', 'Burkina Faso', 'bf', 2),
(46, 'Бурунди', 'Бурундi', 'Бурундзі', 'Burundi', 'Burundi', 'Burundi', 'Burundi', 'Burundi', 'Burundi', 'Burundi', 'ブルンジ', 'Burundis', 'Burundi', 'Burundi', 'bi', 2),
(47, 'Бутан', 'Бутан', 'Бутан', 'Bhutan', 'Bután', 'Butão', 'Bhutan', 'Bouthan', 'Bhutan', 'Bhutan', 'ブータン', 'Butanas', 'Butāna', 'Bhútán', 'bt', 2),
(48, 'Вануату', 'Вануату', 'Вануату', 'Vanuatu', 'Vanuatu', 'Vanuatu', 'Vanuatu', 'Vanuatu', 'Vanuatu', 'Vanuatu', 'バヌアツ', 'Vanuatu', 'Vanuatu', 'Vanuatu', 'vu', 2),
(49, 'Великобритания', 'Великобританiя', 'Вялікабрытанія', 'United Kingdom', 'Gran Bretaña', 'Reino Unido', 'Großbritannien', 'Grande-Bretagne', 'Regno Unito', 'Wielka Brytania', 'イギリス', 'Didžioji Britanija', 'Apvienotā Karaliste', 'Velká Británie', 'gb', 2),
(50, 'Венгрия', 'Угорщина', 'Вугоршчына', 'Hungary', 'Hungría', 'Hungria', 'Ungarn', 'Hongrie', 'Ungheria', 'Węgry', 'ハンガリー', 'Vengrija', 'Ungārija', 'Maďarsko', 'hu', 2),
(51, 'Венесуэла', 'Венесуела', 'Вэнэсуэла', 'Venezuela', 'Venezuela', 'Venezuela', 'Venezuela', 'Vénézuela', 'Venezuela', 'Wenezuela', 'ベネズエラ', 'Venesuela', 'Venesuela', 'Venezuela', 've', 2),
(52, 'Виргинские острова, Британские', 'Вiргiнськi острови, Британськi', 'Віргінскія выспы, Брытанскія', 'British Virgin Islands', 'Islas Vírgenes Británicas', 'Ilhas Virgens Britânicas', 'Britische Jungferninseln', 'Iles Vierges Britanniques', 'Isole Virgin Britanniche', 'Brytyjskie Wyspy Dziewicze', 'イギリス領ヴァージン諸島', 'Mergelių salos, Didžioji Britanija', 'Virdžīnijas salas, Apvienotā Karaliste', 'Britské Panenské ostrovy', 'vg', 2),
(53, 'Виргинские острова, США', 'Вiргiнськi острови, США', 'Віргінскія выспы, ЗША', 'US Virgin Islands', 'Islas Virginia (EE.UU.)', 'Ilhas Virgens Americanas', 'US Jungferninseln', 'Iles Vierges Américaines', 'Isole Virgin degli Stati Uniti', 'Amerykańskie Wyspy Dziewicze', 'アメリカ領ヴァージン諸島', 'Mergelių salos, JAV', 'Virdžīnijas salas, ASV', 'Americké Panenské ostrovy', 'vi', 2),
(54, 'Восточный Тимор', 'Схiдний Тимор', 'Усходні Тымор', 'East Timor', 'Timor Oriental', 'Timor-Leste', 'Ost Timor', 'Timor oriental', 'Timor Est', 'Wschodni Timor', '東ティモール', 'Rytų Timoras', 'Austrumu Timora', 'Východní Timor', 'tp', 2),
(55, 'Вьетнам', 'В''єтнам', 'Віетнам', 'Vietnam', 'Vietnam', 'Vietname', 'Vietnam', 'Vietnam', 'Vietnam', 'Wietnam', 'ヴェトナム', 'Vietnamas', 'Vjetnama', 'Vietnam', 'vn', 2),
(56, 'Габон', 'Габон', 'Габон', 'Gabon', 'Gabón', 'Gabão', 'Gabon', 'Gabon', 'Gabon', 'Gabon', 'ガボン', 'Gabonas', 'Gabona', 'Gabon', 'ga', 2),
(57, 'Гаити', 'Гаїтi', 'Гаіці', 'Haiti', 'Haití', 'Haiti', 'Haiti', 'Haïti', 'Haiti', 'Haiti', 'ハイチ', 'Haitis', 'Haiti', 'Haiti', 'ht', 2),
(58, 'Гайана', 'Гайана', 'Гаяна', 'Guyana', 'Guyana', 'Guiana', 'Guyana', 'Guyana', 'Guyana', 'Gujana', 'ガイアナ', 'Gajana', 'Gajana', 'Guyana', 'gy', 2),
(59, 'Гамбия', 'Гамбiя', 'Гамбія', 'Gambia', 'Gambia', 'Gâmbia', 'Gambia', 'Gambie', 'Gambia', 'Gambia', 'ガンビア', 'Gambija', 'Gambija', 'Gambie', 'gm', 2),
(60, 'Гана', 'Гана', 'Гана', 'Ghana', 'Ghana', 'Gana', 'Ghana', 'Ghana', 'Ghana', 'Ghana', 'ガーナ', 'Gana', 'Gana', 'Ghana', 'gh', 2),
(61, 'Гваделупа', 'Гваделупа', 'Ґўадэлюпа', 'Guadeloupe', 'Guadalupe (Francia)', 'Guadalupe', 'Guadeloupe', 'Guadeloupe', 'Guadeloupe', 'Guadeloupa', 'グアドループ', 'Gvadelupa', 'Gvadelupa', 'Guadeloupe', 'gp', 2),
(62, 'Гватемала', 'Гватемала', 'Гватэмала', 'Guatemala', 'Guatemala', 'Guatemala', 'Guatemala', 'Guatemala', 'Guatemala', 'Guatemala', 'グアテマラ', 'Gvatemala', 'Gvatemala', 'Guatemala', 'gt', 2),
(63, 'Гвинея', 'Гвiнея', 'Гвінэя', 'Guinea', 'Guinea', 'Guiné', 'Guinea', 'Guinée', 'Guinea', 'Gwinea', 'ギニア', 'Gvinėja', 'Gvineja', 'Guinea', 'gn', 2),
(64, 'Гвинея-Бисау', 'Гвiнея-Бiсау', 'Гвінэя-Бісава', 'Guinea-Bissau', 'Guinea-Bissau', 'Guiné-Bissau', 'Guinea-Bissau', 'Guinée Bissau', 'Guinea-Bissau', 'Gwinea-Bissau', 'ギニア・ビサウ', 'Gvinėja Bisau', 'Gvineja-Bisava', 'Guinea-Bissau', 'gw', 2),
(65, 'Германия', 'Нiмеччина', 'Нямеччына', 'Germany', 'Alemania', 'Alemanha', 'Deutschland', 'Allemagne', 'Germania', 'Niemcy', 'ドイツ', 'Vokietija', 'Vācija', 'Německo', 'de', 2),
(66, 'Гибралтар', 'Гiбралтар', 'Гібралтар', 'Gibraltar', 'Gibraltar', 'Gibraltar', 'Gibraltar', 'Gibraltar', 'Gibilterra', 'Gibraltar', 'ジブラルタル', 'Gibraltaras', 'Gibraltāra', 'Gibraltar', 'gi', 2),
(67, 'Гондурас', 'Гондурас', 'Гандурас', 'Honduras', 'Honduras', 'Gordura', 'Honduras', 'Honduras', 'Honduras', 'Honduras', 'ホンジュラス', 'Hondūras', 'Gondurasa', 'Honduras', 'hn', 2),
(68, 'Гонконг', 'Гонконг', 'Ганконг', 'Hong Kong', 'Hong Kong', 'Hong Kong', 'Hong Kong', 'Hong Kong', 'Hong Kong', 'Hong Kong', '香港', 'Honkongas', 'Gonkonga', 'Hongkong', 'hk', 2),
(69, 'Гренада', 'Гренада', 'Грэнада', 'Grenada', 'Granada', 'Granada', 'Grenada', 'Grenade', 'Grenada', 'Grenada', 'グレナダ', 'Grenada', 'Granāda', 'Grenada', 'gd', 2),
(70, 'Гренландия', 'Гренландiя', 'Грэнляндыя', 'Greenland', 'Groenlandia', 'Gronelândia<br>', 'Grönland', 'Groenland', 'Groenlandia', 'Grenlandia', 'グリーンランド', 'Grenlandija', 'Grenlande', 'Grónsko', 'gl', 2),
(71, 'Греция', 'Грецiя', 'Грэцыя', 'Greece', 'Grecia', 'Grécia', 'Griechenland', 'Grèce', 'Grecia', 'Grecja', 'ギリシャ', 'Graikija', 'Grieķija', 'Řecko', 'gr', 2),
(72, 'Гуам', 'Гуам', 'Гуам', 'Guam', 'Guam', 'Guam', 'Guam', 'Guam', 'Guam', 'Guam', 'グアム', 'Guamas', 'Guama', 'Guam', 'gu', 2),
(73, 'Дания', 'Данiя', 'Данія', 'Denmark', 'Dinamarca', 'Dinamarca', 'Dänemark', 'Danemark', 'Danimarca', 'Dania', 'デンマーク', 'Danija', 'Dānija', 'Dánsko', 'dk', 2),
(74, 'Доминика', 'Домiнiка', 'Дамініка', 'Dominica', 'Dominica', 'Dominica', 'Dominica', 'Dominique', 'Dominica', 'Dominika', 'ドミニカ', 'Dominika', 'Dominika', 'Dominika', 'dm', 2),
(75, 'Доминиканская Республика', 'Домiнiканська Республiка', 'Дамініканская Рэспубліка', 'Dominican Republic', 'República Dominicana', 'República Dominicana', 'Dominikanische Republik', 'République dominicaine', 'Repubblica Domenicana', 'Dominikana', 'ドミニカ共和国', 'Dominikos Respublika', 'Dominikānas Republika', 'Dominikánská republika', 'do', 2),
(76, 'Египет', 'Єгипет', 'Эгіпэт', 'Egypt', 'Egipto', 'Egito', 'Ägypten', 'Egypte', 'Egitto', 'Egipt', 'エジプト', 'Egiptas', 'Ēģipte', 'Egypt', 'eg', 2),
(77, 'Замбия', 'Замбiя', 'Замбія', 'Zambia', 'Zambia', 'Zâmbia', 'Sambia', 'Zambie', 'Egitto', 'Zambia', 'ザンビア', 'Zambija', 'Zambija', 'Zambie', 'zm', 2),
(78, 'Западная Сахара', 'Захiдна Сахара', 'Заходняя Сахара', 'Western Sahara', 'Sáhara Occidental', 'Saara Ocidental', 'Westsahara', 'Sahara occidental', 'Sahara Occidentale', 'Sahara Zachodnia', '西サハラ', 'Vakarų Sachara', 'Rietumsahāra', 'Západní Sahara', 'eh', 2),
(79, 'Зимбабве', 'Зiмбабве', 'Зімбабвэ', 'Zimbabwe', 'Zimbabue', 'Zimbabwe', 'Simbabwe', 'Zimbabwe', 'Zimbabwe', 'Zimbabwe', 'ジンバブエ', 'Zimbabvė', 'Zimbabve', 'Zimbabwe', 'zw', 2),
(80, 'Индия', 'Iндiя', 'Індыя', 'India', 'India', 'Índia', 'Indien', 'Inde', 'India', 'Indie', 'インド', 'Indija', 'Indija', 'Indie', 'in', 2),
(81, 'Индонезия', 'Iндонезiя', 'Інданэзія', 'Indonesia', 'Indonesia', 'Indonésia', 'Indonesien', 'Indonésie', 'Indonesia', 'Indonezja', 'インドネシア', 'Indonezija', 'Indonēzija', 'Indonésie', 'id', 2),
(82, 'Иордания', 'Йорданiя', 'Іярданія', 'Jordan', 'Jordania', 'Jordânia', 'Jordanien', 'Jordanie', 'Giordania', 'Jordania', 'ヨルダン', 'Jordanija', 'Jordānija', 'Jordánsko', 'jo', 2),
(83, 'Ирак', 'Iрак', 'Ірак', 'Iraq', 'Irak', 'Iraque', 'Irak', 'Irak', 'Iraq', 'Irak', 'イラク', 'Irakas', 'Irāka', 'Irák', 'iq', 2),
(84, 'Иран', 'Iран', 'Іран', 'Iran', 'Irán', 'Irão', 'Iran', 'Iran', 'Iran', 'Iran', 'イラン', 'Iranas', 'Irāna', 'Írán', '', 2),
(85, 'Ирландия', 'Iрландiя', 'Ірляндыя', 'Ireland', 'Irlanda', 'Irlanda', 'Irland', 'Irlande', 'Irlanda', 'Irlandia', 'アイルランド', 'Airija', 'Īrija', 'Irsko', 'ie', 2),
(86, 'Исландия', 'Iсландiя', 'Ісьляндыя', 'Iceland', 'Islandia', 'Islândia', 'Island', 'Islande', 'Islanda', 'Islandia', 'アイスランド', 'Islandija', 'Īslande', 'Island', 'is', 2),
(87, 'Испания', 'Iспанiя', 'Гішпанія', 'Spain', 'España', 'Espanha', 'Spanien', 'Espagne', 'Spagna', 'Hiszpania', 'スペイン', 'Ispanija', 'Spānija', 'Španělsko', 'es', 2),
(88, 'Италия', 'Iталiя', 'Італія', 'Italy', 'Italia', 'Itália', 'Italien', 'Italie', 'Italia', 'Włochy', 'イタリア', 'Italija', 'Itālija', 'Itálie', 'it', 2),
(89, 'Йемен', 'Йемен', 'Емэн', 'Yemen', 'Yemen', 'Iémen', 'Jemen', 'Yémen', 'Yemen', 'Jemen', 'イエメン', 'Jemenas', 'Jemena', 'Jemen', 'ye', 2),
(90, 'Кабо-Верде', 'Кабо-Верде', 'Каба-Вэрдэ', 'Cape Verde', 'Cabo Verde', 'Cabo Verde', 'Kap Verde', 'Cap Vert', 'Cabo Verde', 'Cape Verde', 'カーボベルデ', 'Žaliasis Kyšulys', 'Kaboverde', 'Kapverdy', 'cv', 2),
(91, 'Камбоджа', 'Камбоджа', 'Камбоджа', 'Cambodia', 'Camboya', 'Camboja', 'Kambodscha', 'Cambodge', 'Cambogia', 'Kambodża', 'カンボジア', 'Kambodža', 'Kambodža', 'Kambodža', 'kh', 2),
(92, 'Камерун', 'Камерун', 'Камэрун', 'Cameroon', 'Camerún', 'Camarões', 'Kamerun', 'Cameroun', 'Camerun', 'Kamerun', 'カメルーン', 'Kamerūnas', 'Kameruna', 'Kamerun', 'cm', 2),
(93, 'Катар', 'Катар', 'Катар', 'Qatar', 'Qatar', 'Qatar', 'Katar', 'Qatar', 'Qatar', 'Katar', 'カタール', 'Kataras', 'Katāra', 'Katar', 'qa', 2),
(94, 'Кения', 'Кенiя', 'Кенія', 'Kenya', 'Kenia', 'Quénia', 'Kenia', 'Kenya', 'Kenia', 'Kenia', 'ケニア', 'Kenija', 'Kēnija', 'Keňa', 'ke', 2),
(95, 'Кипр', 'Кiпр', 'Кіпар', 'Cyprus', 'Chipre', 'Chipre', 'Zypern', 'Chypre', 'Cipro', 'Cypr', 'キプロス', 'Kipras', 'Kipra', 'Kypr', 'cy', 2),
(96, 'Кирибати', 'Кiрiбатi', 'Кірыбаты', 'Kiribati', 'Kiribati', 'Kiribati', 'Kiribati', 'Kiribati', 'Kiribati', 'Kiribati', 'キリバス', 'Kiribatis', 'Ķiribati', 'Kiribati', 'ki', 2),
(97, 'Китай', 'Китай', 'Кітай', 'China', 'China', 'China', 'China', 'Chine', 'Cina', 'Chiny', '中国', 'Kinija', 'Ķīna', 'Čína', 'cn', 2),
(98, 'Колумбия', 'Колумбiя', 'Калюмбія', 'Colombia', 'Colombia', 'Colômbia', 'Kolumbien', 'Colombie', 'Colombia', 'Kolumbia', 'コロンビア', 'Kolumbija', 'Kolumbija', 'Kolumbie', 'co', 2),
(99, 'Коморы', 'Комори', 'Каморы', 'Comoros', 'Comoras', 'Comores', 'Komoren', 'Comores', 'Comoros', 'Komory', 'コモロ諸島', 'Komorai', 'Komoru salas', 'Komory', 'km', 2),
(100, 'Конго', 'Конго', 'Конга', 'Congo', 'Congo', 'Congo', 'Kongo', 'Congo', 'Congo', 'Kongo', 'コンゴ', 'Kongas', 'Kongo', 'Kongo (Brazzaville)', 'cg', 2),
(101, 'Конго, демократическая республика', 'Конго, демократична республiка', 'Конга, дэмакратычная рэспубліка', 'Congo, Democratic Republic', 'República Democrática del Congo', 'República Democrática do Congo', 'Kongo, Demokratische Republik', 'République démocratique du Congo', 'Congo, Repubblica Democratica', 'Demokratyczna Republika Konga', 'コンゴ民主共和国', 'Kongo Demokratinė Respublika', 'Kongo Demokrātiskā Republika', 'Demokratická republika Kongo', 'cd', 2),
(102, 'Коста-Рика', 'Коста-Рiка', 'Коста-Рыка', 'Costa Rica', 'Costa Rica', 'Costa Rica', 'Costa Rica', 'Costa Rica', 'Costa Rica', 'Costa Rica', 'コスタリカ', 'Kosta Rika', 'Kostarika', 'Kostarika', 'cr', 2),
(103, 'Кот д`Ивуар', 'Кот-д''iвуар', 'Кот д`Івуар', 'Côte d`Ivoire', 'Costa de Marfil', 'Costa do Marfim', 'Elfenbeinküste', 'Côte d''Ivoire', 'Costa d''Avorio', 'Wybrzeże Kości Słoniowej', 'コートジボアール', 'Dramblio Kaulo Krantas', 'Kotdivuāra', 'Pobřeží slonoviny', 'ci', 2),
(104, 'Куба', 'Куба', 'Куба', 'Cuba', 'Cuba', 'Cuba', 'Kuba', 'Cuba', 'Cuba', 'Kuba', 'キューバ', 'Kuba', 'Kuba', 'Kuba', 'cu', 2),
(105, 'Кувейт', 'Кувейт', 'Кувэйт', 'Kuwait', 'Kuwait', 'Kuwait<br>', 'Kuwait', 'Koweït', 'Kuwait', 'Kuwejt', 'クウェート', 'Kuveitas', 'Kuveita', 'Kuvajt', 'kw', 2),
(106, 'Лаос', 'Лаос', 'Ляос', 'Laos', 'Laos', 'Laos', 'Laos', 'Laos', 'Laos', 'Laos', 'ラオス', 'Laosas', 'Laosa', 'Laos', 'la', 2),
(107, 'Лесото', 'Лесото', 'Лесота', 'Lesotho', 'Lesoto', 'Lesoto', 'Lesotho', 'Leshoto', 'Lesotho', 'Lesotho', 'レソト', 'Lesotas', 'Lesoto', 'Lesotho', 'ls', 2),
(108, 'Либерия', 'Лiберiя', 'Лібэрыя', 'Liberia', 'Liberia', 'Libéria', 'Liberia', 'Libéria', 'Liberia', 'Liberia', 'リベリア', 'Liberija', 'Libērija', 'Libérie', 'lr', 2),
(109, 'Ливан', 'Лiван', 'Лібан', 'Lebanon', 'Líbano', 'Líbano', 'Libanon', 'Liban', 'Libano', 'Liban', 'レバノン', 'Libanas', 'Livāna', 'Libanon', 'lb', 2),
(110, 'Ливия', 'Лiвiя', 'Лібія', 'Libya', 'Libia', 'Líbia', 'Libyen', 'Lybie', 'Libia', 'Libia', 'リビア', 'Libija ', 'Lībija', 'Lybie', 'ly', 2),
(111, 'Лихтенштейн', 'Лiхтенштейн', 'Ліхтэнштайн', 'Liechtenstein', 'Liechtenstein', 'Liechtenstein', 'Liechtenstein', 'Liechtenstein', 'Liechtenstein', 'Liechtenstein', 'リヒテンシュタイン', 'Lichtenšteinas', 'Lihtenšteina', 'Lichtenštejnsko', 'li', 2),
(112, 'Люксембург', 'Люксембург', 'Люксэмбург', 'Luxembourg', 'Luxemburgo', 'Luxemburgo', 'Luxemburg', 'Luxembourg', 'Lussemburgo', 'Luxembourg', 'ルクセンブルク', 'Liuksemburgas', 'Luksemburga', 'Lucembursko', 'lu', 2),
(113, 'Маврикий', 'Маврикiй', 'Маўрыцы', 'Mauritius', 'Mauricio', 'Maurícia', 'Mauritius', 'Maurice', 'Mauritius', 'Mauritius', 'モーリシャス', 'Mauricijus', 'Mavrikija', 'Mauricius', 'mu', 2),
(114, 'Мавритания', 'Мавританiя', 'Маўрытанія', 'Mauritania', 'Mauritania', 'Mauritânia', 'Mauretanien', 'Mauritanie', 'Mauritania', 'Mauretania', 'モーリタニア', 'Mauritanija', 'Mavritānija', 'Mauritánie', 'mr', 2),
(115, 'Мадагаскар', 'Мадагаскар', 'Мадагаскар', 'Madagascar', 'Madagascar', 'Madagáscar', 'Madagaskar', 'Madagascar', 'Madagascar', 'Madagaskar', 'マダガスカル', 'Madagaskaras', 'Madagaskāra', 'Madagaskar', 'mg', 2),
(116, 'Макао', 'Макао', 'Макаа', 'Macau', 'Macao', 'Macau', 'Macao', 'Macao', 'Macao', 'Makao', 'マカオ', 'Macao', 'Makao', 'Macao', 'mo', 2),
(117, 'Македония', 'Македонiя', 'Македонія', 'Macedonia', 'Macedonia', 'Macedónia', 'Mazedonien', 'Macédoine', 'Macedonia', 'Macedonia', 'マケドニア', 'Makedonija', 'Makedonija', 'Makedonie', 'mk', 2),
(118, 'Малави', 'Малавi', 'Малаві', 'Malawi', 'Malawi', 'Malawi', 'Malawi', 'Malawi', 'Malawi', 'Malawi', 'マラウィ', 'Malavis<br>', 'Malavi', 'Malawi', 'mw', 2),
(119, 'Малайзия', 'Малайзiя', 'Малайзія', 'Malaysia', 'Malasia', 'Malásia', 'Malaysia', 'Malaisie', 'Malesia', 'Malezja', 'マレーシア', 'Malaizija', 'Malaizija', 'Malajsie', 'my', 2),
(120, 'Мали', 'Малi', 'Малі', 'Mali', 'Mali', 'Mali', 'Mali', 'Mali', 'Mali', 'Mali', 'マリ', 'Malis', 'Mali', 'Mali', 'ml', 2),
(121, 'Мальдивы', 'Мальдiви', 'Мальдывы', 'Maldives', 'Maldivas', 'Maldivas', 'Malediven', 'Maldives', 'Maldive', 'Malediwy', 'モルジブ', 'Maldyvai', 'Maldīvas', 'Maledivy', 'mv', 2),
(122, 'Мальта', 'Мальта', 'Мальта', 'Malta', 'Malta', 'Malta', 'Malta', 'Malte', 'Malta', 'Malta', 'マルタ', 'Malta', 'Malta', 'Malta', 'mt', 2),
(123, 'Марокко', 'Марокко', 'Марока', 'Morocco', 'Marruecos', 'Marrocos', 'Marokko', 'Maroc', 'Marocco', 'Maroko', 'モロッコ', 'Marokas', 'Maroka', 'Maroko', 'ma', 2),
(124, 'Мартиника', 'Мартинiка', 'Мартыніка', 'Martinique', 'Martinica', 'Martinica', 'Martinique', 'Martinique', 'Martinique', 'Martynika', 'マルティニク', 'Martinika', 'Martinika', 'Martinik', 'mq', 2),
(125, 'Маршалловы Острова', 'Маршаловi острови', 'Маршалавыя Выспы', 'Marshall Islands', 'Islas Marshall', 'Ilhas Marshall', 'Marshallinseln', 'Iles Marshall', 'Isole Marshall', 'Wyspy Marshalla', 'マーシャル諸島', 'Maršalų salos', 'Maršalu salas', 'Marhallovy ostrovy', 'mh', 2),
(126, 'Мексика', 'Мексика', 'Мэксыка', 'Mexico', 'México', 'México', 'Mexiko', 'Mexique', 'Messico', 'Meksyk', 'メキシコ', 'Meksika', 'Meksika', 'Mexiko', 'mx', 2),
(127, 'Микронезия, федеративные штаты', 'Мiкронезiя, федеративнi штати', 'Мікранэзія, фэдэратыўныя штаты', 'Micronesia', 'Estados Federados de Micronesia', 'Micronésia', 'Mikronesien', 'Etats fédérés de Micronésie', 'Micronesia', 'Mikronezja', 'ミクロネシア連邦', 'Mikronezijos Federacinės Valstijos', 'Mikronēzija', 'Mikronésie', 'fm', 2),
(128, 'Мозамбик', 'Мозамбiк', 'Мазамбік', 'Mozambique', 'Mozambique', 'Moçambique', 'Mosambik', 'Mozambique', 'Mozambico', 'Mozambik', 'モザンビーク', 'Mozambikas', 'Mozambika', 'Mosambik', 'mz', 2),
(129, 'Монако', 'Монако', 'Манака', 'Monaco', 'Mónaco', 'Mónaco', 'Monaco', 'Monaco', 'Monaco', 'Monako', 'モナコ', 'Monakas', 'Monako', 'Monako', 'mc', 2),
(130, 'Монголия', 'Монголiя', 'Манголія', 'Mongolia', 'Mongolia', 'Mongólia', 'Mongolei', 'Mongolie', 'Mongolia', 'Mongolia', 'モンゴル', 'Mongolija', 'Mongolija', 'Mongolsko', 'mn', 2),
(131, 'Монтсеррат', 'Монтсеррат', 'Мантсэрат', 'Montserrat', 'Montserrat', 'Montserrat', 'Montserrat', 'Montserrat', 'Montserrat', 'Montserrat', 'モントセラト', 'Monseratas', 'Montserrata', 'Montserrat', 'ms', 2),
(132, 'Мьянма', 'М''янма', 'М''янма', 'Myanmar', 'Birmania', 'Mianmar', 'Myanmar', 'Birmanie', 'Myanmar', 'Birma', 'ミャンマー', 'Birma', 'Mjanma', 'Myanmar', 'mm', 2),
(133, 'Намибия', 'Намiбiя', 'Намібія', 'Namibia', 'Namibia', 'Namíbia', 'Namibia', 'Namibie', 'Namibia', 'Namibia', 'ナミビア', 'Namibija', 'Namībija', 'Namibie', 'na', 2),
(134, 'Науру', 'Науру', 'Навуру', 'Nauru', 'Nauru', 'Nauru', 'Nauru', 'Nauru', 'Nauru', 'Nauru', 'ナウル', 'Nauru', 'Nauru', 'Nauru', 'nr', 2),
(135, 'Непал', 'Непал', 'Нэпал', 'Nepal', 'Nepal', 'Nepal', 'Nepal', 'Népal', 'Nepal', 'Nepal', 'ネパール', 'Nepalas', 'Nepāla', 'Nepál', 'np', 2),
(136, 'Нигер', 'Нiгер', 'Нігер', 'Niger', 'Níger', 'Níger', 'Niger', 'Niger', 'Niger', 'Niger', 'ニジェール', 'Nigeris', 'Nigera', 'Niger', 'ne', 2),
(137, 'Нигерия', 'Нiгерiя', 'Нігерыя', 'Nigeria', 'Nigeria', 'Nigéria', 'Nigeria', 'Nigéria', 'Nigeria', 'Nigeria', 'ナイジェリア', 'Nigerija', 'Nigērija', 'Nigérie', 'ng', 2),
(138, 'Кюрасао', 'Кюрасао', 'Кюрасаа', 'Curaçao', 'Antillas Holandesas', 'Curaçao', 'Niederländische Antillen', 'Antilles Néerlandaises', 'Antille Olandesi', 'Curacao', 'キュラソー島', 'Kiurasao ', 'Nīderlandes Antilas', 'Curaçao', 'cw', 2),
(139, 'Нидерланды', 'Нiдерланди', 'Нідэрлянды', 'Netherlands', 'Holanda', 'Países Baixos', 'Niederlande', 'Pays-Bas', 'Olanda', 'Holandia', 'オランダ', 'Nyderlandai', 'Nīderlande', 'Nizozemsko', 'nl', 2),
(140, 'Никарагуа', 'Нiкарагуа', 'Нікарагуа', 'Nicaragua', 'Nicaragua', 'Nicarágua', 'Nicaragua', 'Nicaragua', 'Nicaragua', 'Nikaragua', 'ニカラグア', 'Nikaragva', 'Nikaragva', 'Nikaragua', 'ni', 2),
(141, 'Ниуэ', 'Нiуе', 'Нівуэ', 'Niue', 'Niue', 'Niue', 'Niue', 'Niue', 'Niue', 'Niue', 'ニウエ', 'Niue<br>', 'Niue', 'Niue', 'nu', 2),
(142, 'Новая Зеландия', 'Нова Зеландiя', 'Новая Зэляндыя', 'New Zealand', 'Nueva Zelanda', 'Nova Zelândia', 'Neuseeland', 'Nouvelle Zélande', 'Nuova Zelanda', 'Nowa Zelandia', 'ニュージーランド', 'Naujoji Zelandija', 'Jaunzelande', 'Nový Zéland', 'nz', 2),
(143, 'Новая Каледония', 'Нова Каледонiя', 'Новая Каледонія', 'New Caledonia', 'Nueva Caledonia', 'Nova Caledónia', 'Neukaledonien', 'Nouvelle Calédonie', 'Nuova Caledonia', 'Nowa Kaledonia', 'ニューカレドニア', 'Naujoji Kaledonija', 'Jaunkaledonija', 'Nová Kaledonie', 'nc', 2),
(144, 'Норвегия', 'Норвегiя', 'Нарвэгія', 'Norway', 'Noruega', 'Noruega', 'Norwegen', 'Norvège', 'Norvegia', 'Norwegia', 'ノルウェー', 'Norvegija', 'Norvēģija', 'Norsko', 'no', 2),
(145, 'Объединенные Арабские Эмираты', 'Об''єднанi Арабськi Емiрати', 'Аб''яднаныя Арабскія Эміраты', 'United Arab Emirates', 'Emiratos Árabes Unidos', 'Emirados Árabes Unidos', 'Vereinigte Arabische Emirate', 'Emirats Arabes Unis', 'Emirati Arabi Uniti', 'Zjednoczone Emiraty Arabskie', 'アラブ首長国連邦', 'Jungtiniai Arabų Emyratai', 'Apvienotie Arābu Emirati', 'Spojené arabské emiráty', 'ae', 2),
(146, 'Оман', 'Оман', 'Аман', 'Oman', 'Omán', 'Omã', 'Oman', 'Oman', 'Oman', 'Oman', 'オマーン', 'Omanas', 'Omāna', 'Omán', 'om', 2),
(147, 'Остров Мэн', 'Острiв Мен', 'Выспа Мэн', 'Isle of Man', 'Islas Man', 'Ilha de Man', 'Insel Man', 'Ile de Man', 'Isola di Man', 'Isle of Man', 'マン島', 'Meno sala', 'Mēna', 'Ostrov Man', 'im', 2),
(148, 'Остров Норфолк', 'Острiв Норфолк', 'Выспа Норфалк', 'Norfolk Island', 'Islas Norfolk', 'Ilha Norfolk', 'Norfolkinsel', 'Ile Norfolk', 'Isola di Norfolk', 'Wyspa Norfolk', 'ノーフォーク諸島', 'Norfolko sala', 'Norfolka', 'Ostrov Norfolk', 'nf', 2),
(149, 'Острова Кайман', 'Острови Кайман', 'Выспы Кайман', 'Cayman Islands', 'Islas Caimán', 'Ilhas Caimão', 'Kaimaninseln', 'Iles Caïman', 'Isole Cayman', 'Kajmany', 'ケイマン諸島', 'Kaimanų salos', 'Kaimana salas', 'Kajmanské ostrovy', 'ky', 2),
(150, 'Острова Кука', 'Острови Кука', 'Выспы Кука', 'Cook Islands', 'Islas Cook', 'Ilha Cook', 'Cook-Inseln', 'Iles Cook', 'Isole Cook', 'Wyspy Cooka', 'クック諸島', 'Kuko salos', 'Kūka salas', 'Cookovy ostrovy', 'ck', 2),
(151, 'Острова Теркс и Кайкос', 'Острови Теркс i Кайкос', 'Выспы Тэркс і Кайкос', 'Turks and Caicos Islands', 'Islas Turcas y Caicos', 'Ilhas Turcas e Caicos', 'Turks- und Caicos Inseln', 'Iles Turques et Caïques', 'Isole Turks e Caicos', 'Turks i Caicos', 'タークス・カイコス諸島', 'Terkso ir Kaikoso salos', 'Tērksas un Kaikosas', 'Ostrovy Turks a Caicos', 'tc', 2),
(152, 'Пакистан', 'Пакистан', 'Пакістан', 'Pakistan', 'Pakistán', 'Paquistão', 'Pakistan', 'Pakistan', 'Pakistan', 'Pakistan', 'パキスタン', 'Pakistanas', 'Pakistāna', 'Pákistán', 'pk', 2),
(153, 'Палау', 'Палау', 'Палаў', 'Palau', 'Palaos', 'Palau', 'Palau', 'Palaos', 'Palau', 'Palau', 'パラウ', 'Palau', 'Palava', 'Palau', 'pw', 2),
(154, 'Палестинская автономия', 'Палестинська автономiя', 'Палестынская аўтаномія', 'Palestine', 'Palestina', 'Autoridade Nacional Palestiniana', 'Palestina', 'Palestine', 'ANP', 'Palestyna', 'パレスティナ自治区', 'Palestinos teritorija', 'Palestīnas autonomija', 'Palestina', 'ps', 2),
(155, 'Панама', 'Панама', 'Панама', 'Panama', 'Panamá', 'Panamá', 'Panama', 'Panama', 'Panama', 'Panama', 'パナマ', 'Panama', 'Panama', 'Panama', 'pa', 2),
(156, 'Папуа - Новая Гвинея', 'Папуа - Нова Гвiнея', 'Папуа - Новая Ґвінэя', 'Papua New Guinea', 'Papúa Nueva Guinea', 'Papua-Nova Guiné', 'Papua-Neuguinea', 'Papouasie-Nouvelle Guinée', 'Papua Nuova Guinea', 'Papua Nowa Gwinea', 'パプア・ニューギニア', 'Papua - Naujoji Gvinėja', 'Papua Jaungvineja', 'Papua Nová Guinea', 'pg', 2),
(157, 'Парагвай', 'Парагвай', 'Параґвай', 'Paraguay', 'Paraguay', 'Paraguai', 'Paraguay', 'Paraguay', 'Paraguay', 'Paragwaj', 'パラグアイ', 'Paragvajus', 'Paragvaja', 'Paraguay', 'py', 2),
(158, 'Перу', 'Перу', 'Пэру', 'Peru', 'Perú', 'Peru', 'Peru', 'Pérou', 'Peru', 'Peru', 'ペルー', 'Peru', 'Peru', 'Peru', 'pe', 2),
(159, 'Питкерн', 'Пiткерн', 'Піткэрн', 'Pitcairn Islands', 'Islas Pitcairn', 'Ilhas Pitcairn', 'Pitcairn-Inseln', 'Iles Pitcairn', 'Isole Pitcairn', 'Wyspy Pitcairn', 'ピトケアン諸島', 'Pitkernas', 'Pitkerna', 'Pitcairnovy ostrovy', 'pn', 2),
(160, 'Польша', 'Польща', 'Польшча', 'Poland', 'Polonia', 'Polónia', 'Polen', 'Pologne', 'Polonia', 'Polska', 'ポーランド', 'Lenkija', 'Polija', 'Polsko', 'pl', 2),
(161, 'Португалия', 'Португалiя', 'Партугалія', 'Portugal', 'Portugal', 'Portugal', 'Portugal', 'Portugal', 'Portogallo', 'Portugalia', 'ポルトガル', 'Portugalija', 'Portugāle', 'Portugalsko', 'pt', 2),
(162, 'Пуэрто-Рико', 'Пуерто-Рiко', 'Пуэрта-Рыка', 'Puerto Rico', 'Puerto Rico', 'Porto Rico', 'Puerto Rico', 'Porto Rico', 'Puerto Rico', 'Puerto Rico', 'プエルトリコ', 'Puerto Rikas', 'Puerto Riko', 'Portoriko', 'pr', 2),
(163, 'Реюньон', 'Реюньон', 'Рэюньён', 'Réunion', 'Reunión', 'Réunion', 'Réunion', 'Réunion', 'Réunion', 'Réunion', 'レユニオン', 'Reunionas', 'Reinjona', 'Réunion', 're', 2),
(164, 'Руанда', 'Руанда', 'Руанда', 'Rwanda', 'Ruanda', 'Ruanda', 'Ruanda', 'Rwanda', 'Ruanda', 'Rwanda', 'ルアンダ', 'Ruanda', 'Ruanda', 'Rwanda', 'rw', 2),
(165, 'Румыния', 'Румунiя', 'Румынія', 'Romania', 'Rumanía', 'Roménia', 'Rumänien', 'Roumanie', 'Romania', 'Rumunia', 'ルーマニア', 'Rumunija', 'Rumānija', 'Rumunsko', 'ro', 2),
(166, 'Сальвадор', 'Сальвадор', 'Сальвадор', 'El Salvador', 'El Salvador', 'Salvador', 'El Salvador', 'Salvador', 'El Salvador', 'Salwador', 'サルバドール', 'Salvadoras', 'Salvadora', 'Salvador', 'sv', 2),
(167, 'Самоа', 'Самоа', 'Самоа', 'Samoa', 'Samoa', 'Samoa', 'Samoa', 'Samoa', 'Samoa', 'Samoa', 'サモア', 'Samoa', 'Samoa', 'Samoa', 'ws', 2),
(168, 'Сан-Марино', 'Сан-Марiно', 'Сан-Марына', 'San Marino', 'San Marino', 'San Marino', 'San Marino', 'Saint-Marin', 'San Marino', 'San Marino', 'サンマリノ', 'San Marinas', 'Sanmarino', 'San Marino', 'sm', 2),
(169, 'Сан-Томе и Принсипи', 'Сан-Томе i Прiнсiпi', 'Сан-Тамэ й Прынсыпі', 'São Tomé and Príncipe', 'Santo Tomé y Príncipe', 'São Tomé e Príncipe', 'São Tomé und Príncipe', 'Sao-Tomé et Principe', 'São Tomé e Príncipe', 'Wyspy São Tomé i Książęca', 'サントメ・プリンシペ', 'San Tomė ir Prinsipė', 'San Tome un Prinsipi', 'Svatý Tomáš a Princův ostrov', 'st', 2),
(170, 'Саудовская Аравия', 'Саудiвська Аравiя', 'Саудаўская Арабія', 'Saudi Arabia', 'Arabia Saudí', 'Arábia Saudita', 'Saudi Arabien', 'Arabie Saoudite', 'Arabia Saudita', 'Arabia Saudyjska', 'サウジアラビア', 'Saudo Arabija', 'Sauda Arābija', 'Saúdská Arábie', 'sa', 2),
(171, 'Свазиленд', 'Свазiленд', 'Свазылэнд', 'Swaziland', 'Suazilandia', 'Suazilândia', 'Swasiland', 'Swaziland', 'Swaziland', 'Swaziland', 'スワジランド', 'Svazilendas', 'Svazilenda', 'Svazijsko', 'sz', 2),
(172, 'Святая Елена', 'Святої Єлени', 'Сьвятая Алена', 'Saint Helena', 'Santa Helena', 'Santa Elena', 'St. Helena', 'Sainte Hélène', 'Sant''Elena', 'Wyspa Św. Heleny', 'セントヘレナ', 'ŠV. Elenos sala', 'Svētās Helēnas Sala', 'Svatá Helena', 'sh', 2),
(173, 'Северная Корея', 'Пiвнiчна Корея', 'Паўночная Карэя', 'North Korea', 'Corea del Norte', 'Coreia do Norte', 'Nordkorea', 'Corée du Nord', 'Corea del Nord', 'Korea Północna', '北朝鮮', 'Šiaurės Korėja', 'Ziemeļkoreja', 'Severní Korea', 'kp', 2),
(174, 'Северные Марианские острова', 'Пiвнiчнi Марiанськi острови', 'Паўночныя Марыянскія выспы', 'Northern Mariana Islands', 'Islas Marianas del Norte', 'Ilhas Marianas', 'Nördliche Marianen', 'Iles Mariannes du Nord', 'Isole Northern Mariana', 'Wyspy Północnej Mariany', '北マリアナ諸島', 'Šiaurės Marianų salos', 'Ziemeļu Marianas Salas', 'Mariánské ostrovy', 'mp', 2),
(175, 'Сейшелы', 'Сейшели', 'Сэйшэлы', 'Seychelles', 'Seychelles', 'Seicheles', 'Seychellen', 'Seychelles', 'Seychelles', 'Seszele', 'セイシェル', 'Seišeliai', 'Seišelu salas', 'Seychely', 'sc', 2),
(176, 'Сенегал', 'Сенегал', 'Сэнэгал', 'Senegal', 'Senegal', 'Senegal', 'Senegal', 'Sénégal', 'Senegal', 'Senegal', 'セネガル', 'Senegalas<br>', 'Senegāla', 'Senegal', 'sn', 2),
(177, 'Сент-Винсент', 'Сент-Вiнсент', 'Сэнт-Вінцэнт', 'Saint Vincent and the Grenadines', 'San Vicente', 'São Vicente', 'St. Vincent und die Grenadinen', 'Saint-Vincent', 'Saint Vincent e Grenadines', 'Saint Vincent i Grenadyny', 'セントビンセント', 'Sent Vincentas', 'Sentvinsenta', 'Svatý Vincent a Grenadiny', 'vc', 2),
(178, 'Сент-Китс и Невис', 'Сент-Китс i Невiс', 'Сэнт-Кітз і Нэвіс', 'Saint Kitts and Nevis', 'San Cristóbal y Nieves', 'São Cristóvão e Nevis', 'St. Kitts und Nevis', 'Saint-Christophe et Niévès', 'Saint Kitts e Nevis', 'Saint Kitts i Nevis', 'クリストファー・ネイビス', 'Sent Kitsas ir Nevis', 'Sentkitsa un Nevisa', 'Svatý Kryštof a Nevis', 'kn', 2),
(179, 'Сент-Люсия', 'Сент-Люсiя', 'Сэнт-Люсія', 'Saint Lucia', 'Santa Lucía', 'Santa Lúcia', 'St. Lucia', 'Sainte-Lucie', 'Saint Lucia', 'Santa Lucia', 'セントルシア', 'Sent Liucija', 'Sentlusija', 'Svatá Lucie', 'lc', 2),
(180, 'Сент-Пьер и Микелон', 'Сент-Пьєр i Мiкелон', 'Сэн-П’ер і Мікелён', 'Saint Pierre and Miquelon', 'San Pedro y Miguelón', 'Saint-Pierre e Miquelon', 'Saint-Pierre und Miquelon', 'Saint-Pierre et Miquelon', 'Saint Pierre e Miquelon', 'Saint Pierre i Miquelon', 'サンピエール島・ミクロン島', 'Sen Pjeras ir Mikelonas', 'Senpjēra un Mikelona', 'Saint-Pierre a Miquelon', 'pm', 2),
(181, 'Сербия', 'Сербiя', 'Сэрбія', 'Serbia', 'Serbia', 'Sérvia', 'Serbien', 'Serbie', 'Serbia', 'Serbia', 'セルビア', 'Serbija', 'Serbija', 'Srbsko', 'rs', 2),
(182, 'Сингапур', 'Сiнгапур', 'Сынґапур', 'Singapore', 'Singapur', 'Singapura', 'Singapur', 'Singapour', 'Singapore', 'Singapur', 'シンガポール', 'Singapūras', 'Singapūra', 'Singapur', 'sg', 2),
(183, 'Сирийская Арабская Республика', 'Сiрiйська Арабська Республiка', 'Сырыйская Арабская Рэспубліка', 'Syria', 'Siria', 'República Árabe da Síria', 'Syrien', 'Syrie', 'Siria', 'Syria', 'シリア・アラブ共和国', 'Sirija', 'Sīrija', 'Sýrie', 'sy', 2),
(184, 'Словакия', 'Словаччина', 'Славаччына', 'Slovakia', 'Eslovaquia', 'Eslováquia', 'Slowakei', 'Slovaquie', 'Slovacchia', 'Słowacja', 'スロヴァキア', 'Slovakija', 'Slovākija', 'Slovensko', 'sk', 2),
(185, 'Словения', 'Словенiя', 'Славенія', 'Slovenia', 'Eslovenia', 'Eslovénia', 'Slowenien', 'Slovénie', 'Slovenia', 'Słowenia', 'スロベニア', 'Slovėnija', 'Slovēnija', 'Slovinsko', 'si', 2),
(186, 'Соломоновы Острова', 'Соломоновi Острови', 'Саламонавы выспы', 'Solomon Islands', 'Islas Salomón', 'Ilhas Salomão', 'Salomoninseln', 'Iles Salomon', 'Isole Solomon', 'Wyspy Solomona', 'ソロモン諸島', 'Saliamono salos', 'Zālamanu salas', 'Šalomounovy ostrovy', 'sb', 2),
(187, 'Сомали', 'Сомалi', 'Самалі', 'Somalia', 'Somalia', 'Somália', 'Somalia', 'Somalie', 'Somalia', 'Somalia', 'ソマリア', 'Somalis', 'Somali', 'Somálsko', 'so', 2),
(188, 'Судан', 'Судан', 'Судан', 'Sudan', 'Sudán', 'Sudão', 'Sudan', 'Soudan', 'Sudan', 'Sudan', 'スーダン', 'Sudanas', 'Sudāna', 'Súdán', 'sd', 2),
(189, 'Суринам', 'Сурiнам', 'Сурынам', 'Suriname', 'Surinam', 'Suriname', 'Suriname', 'Surinam', 'Suriname', 'Surinam', 'スリナム', 'Surinamas', 'Surinama', 'Surinam', 'sr', 2),
(190, 'Сьерра-Леоне', 'Сьєрра-Леоне', 'Сьера-Леонэ', 'Sierra Leone', 'Sierra Leona', 'Serra Leoa', 'Sierra Leone', 'Sierra Leone', 'Sierra Leone', 'Sierra Leone', 'シエラレオネ', 'Siera Leonė', 'Sjero-Leone', 'Sierra Leone', 'sl', 2),
(191, 'Таиланд', 'Таїланд', 'Тайлянд', 'Thailand', 'Tailandia', 'Tailândia', 'Thailand', 'Thaïlande', 'Tailandia', 'Tajlandia', 'タイ', 'Tailandas', 'Tailanda', 'Thajsko', 'th', 2),
(192, 'Тайвань', 'Тайвань', 'Тайвань', 'Taiwan', 'Taiwan', 'Taiwan', 'Taiwan', 'Taïwan', 'Taiwan', 'Tajwan', '台湾', 'Taivanas', 'Taivāna', 'Tchaj-wan', 'tw', 2),
(193, 'Танзания', 'Танзанiя', 'Танзанія', 'Tanzania', 'Tanzania', 'Tanzânia', 'Tansania', 'Tanzanie', 'Tanzania', 'Tanzania', 'タンザニア', 'Tanzanija', 'Tanzānija', 'Tanzanie', 'tz', 2),
(194, 'Того', 'Того', 'Тога', 'Togo', 'Togo', 'Togo', 'Togo', 'Togo', 'Togo', 'Togo', 'トーゴ', 'Togas', 'Togo', 'Togo', 'tg', 2),
(195, 'Токелау', 'Токелау', 'Такелаў', 'Tokelau', 'Tokelau', 'Tokelau', 'Tokelau', 'Tokelau', 'Tokelau', 'Tokelau', 'トケラウ', 'Tokelau', 'Tokelava', 'Tokelau', 'tk', 2),
(196, 'Тонга', 'Тонга', 'Тонга', 'Tonga', 'Tonga', 'Tonga', 'Tonga', 'Tonga', 'Tonga', 'Tonga', 'トンガ', 'Tongas', 'Tonga', 'Tonga', 'to', 2),
(197, 'Тринидад и Тобаго', 'Тринiдад i Тобаго', 'Трынідад і Табага', 'Trinidad and Tobago', 'Trinidad y Tobago', 'Trinidad e Tobago', 'Trinidad und Tobago', 'Trinité et Tobago', 'Trinidad e Tobago', 'Trinidad and Tobago', 'トリニダード・トバゴ', 'Trinidadas ir Tobagas', 'Trindada un Tobago', 'Trinidad a Tobago', 'tt', 2),
(198, 'Тувалу', 'Тувалу', 'Тувалу', 'Tuvalu', 'Tuvalu', 'Tuvalu', 'Tuvalu', 'Tuvalu', 'Tuvalu', 'Tuvalu', 'ツバル', 'Tuvalu', 'Tuvalu', 'Tuvalu', 'tv', 2),
(199, 'Тунис', 'Тунiс', 'Туніс', 'Tunisia', 'Túnez', 'Tunísia', 'Tunesien', 'Tunisie', 'Tunisia', 'Tunezja', 'チュニス', 'Tunisas', 'Tunisija', 'Tunisko', 'tn', 2),
(200, 'Турция', 'Туреччина', 'Турэччына', 'Turkey', 'Turquía', 'Turquia', 'Türkei', 'Turquie', 'Turchia', 'Turcja', 'トルコ', 'Turkija', 'Turcija', 'Turecko', 'tr', 2),
(201, 'Уганда', 'Уганда', 'Уганда', 'Uganda', 'Uganda', 'Uganda', 'Uganda', 'Ouganda', 'Uganda', 'Uganda', 'ウガンダ', 'Uganda', 'Uganda', 'Uganda', 'ug', 2),
(202, 'Уоллис и Футуна', 'Уоллiс i Футуна', 'Ўоліс і Футуна', 'Wallis and Futuna', 'Wallis y Futuna', 'Wallis e Futuna', 'Wallis und Futuna', 'Wallis et Futuna', 'Wallis e Futuna', 'Wallis i Futuna', 'ウォリス・フツナ', 'Vallisas ir Futuna', 'Volisa un Futuna', 'Wallis a Futuna', 'wf', 2),
(203, 'Уругвай', 'Уругвай', 'Уруґвай', 'Uruguay', 'Uruguay', 'Uruguai', 'Uruguay', 'Uruguay', 'Uruguay', 'Urugwaj', 'ウルグアイ', 'Urugvajus', 'Urugvaja', 'Uruguay', 'uy', 2),
(204, 'Фарерские острова', 'Фарерськi острови', 'Фарэрскія выспы', 'Faroe Islands', 'Islas Feroe', 'Ilhas Feroe', 'Färöer', 'Iles Féroé', 'Isole Faroe', 'Wyspy Owcze', 'フェロー諸島', 'Farerų salos', 'Fāru salas', 'Faerské ostrovy', 'fo', 2),
(205, 'Фиджи', 'Фiджi', 'Фіджы', 'Fiji', 'Fiyi', 'Fiji', 'Fidschi', 'Fidji', 'Fiji', 'Fidżi', 'フィジー', 'Fidžis', 'Fidži', 'Fidži', 'fj', 2),
(206, 'Филиппины', 'Фiлiппiни', 'Філіпіны', 'Philippines', 'Filipinas', 'Filipinas', 'Philippinen', 'Philippines', 'Filippine', 'Filipiny', 'フィリピン', 'Filipinai', 'Filipīnas', 'Filipíny', 'ph', 2),
(207, 'Финляндия', 'Фiнляндiя', 'Фінляндыя', 'Finland', 'Finlandia', 'Finlândia', 'Finnland', 'Finlande', 'Finlandia', 'Finlandia', 'フィンランド', 'Suomija', 'Somija', 'Finsko', 'fi', 2),
(208, 'Фолклендские острова', 'Фолклендськi острови', 'Фальклэндзкія выспы', 'Falkland Islands', 'Islas Malvinas', 'Ilhas Malvinas', 'Falkland Inseln', 'Iles Malouines', 'Isole Falkland/Malvinas', 'Wyspy Falklandzkie', 'フォークランド諸島', 'Folklendų salos', 'Folklendas salas', 'Falklandské ostrovy', 'fk', 2),
(209, 'Франция', 'Францiя', 'Францыя', 'France', 'Francia', 'França', 'Frankreich', 'France', 'Francia', 'Francja', 'フランス', 'Prancūzija', 'Francija', 'Francie', 'fr', 2),
(210, 'Французская Гвиана', 'Французька Гвiана', 'Француская Гвіяна', 'French Guiana', 'Guayana Francesa', 'Guiana Francesa', 'Französisch-Guayana', 'Guyane française', 'Guiana Francese', 'Gujana Francuska', 'フランス領ガイアナ', 'Prancūzijos Gviana', 'Franču Gviāna', 'Francouzská Guyana', 'gf', 2),
(211, 'Французская Полинезия', 'Французька Полiнезiя', 'Француская Палінэзія', 'French Polynesia', 'Polinesia Francesa', 'Polinésia Francesa', 'Französisch Polynesien', 'Polynésie française', 'Polinesia Francese', 'Polinezja Francuska', 'フランス領ポリネシア', 'Prancūzijos Polinezija', 'Fraņču Polinēzija', 'Francouzská Polynésie', 'pf', 2),
(212, 'Хорватия', 'Хорватiя', 'Харватыя', 'Croatia', 'Croacia', 'Croácia', 'Kroatien', 'Croatie', 'Croazia', 'Chorwacja', 'クロアチア', 'Kroatija', 'Horvātija', 'Chorvatsko', 'hr', 2);
INSERT INTO `country` (`id`, `title_ru`, `title_ua`, `title_be`, `title_en`, `title_es`, `title_pt`, `title_de`, `title_fr`, `title_it`, `title_pl`, `title_ja`, `title_lt`, `title_lv`, `title_cz`, `iso`, `currency_id`) VALUES
(213, 'Центрально-Африканская Республика', 'Центрально-Aфриканська Республiка', 'Цэнтральна-Афрыканская Рэспубліка', 'Central African Republic', 'República Centroafricana', 'República Centro-Africana', 'Zentralafrikanische Republik', 'République centrafricaine', 'Repubblica Centro Africana', 'Republika Środkowo-Afrykańska', '中央アフリカ共和国', 'Centrinės Afrikos Respublika', 'Centrālāfrikas Republika', 'Středoafrická republika', 'cf', 2),
(214, 'Чад', 'Чад', 'Чад', 'Chad', 'Chad', 'Chade', 'Tschad', 'Tchad', 'Chad', 'Czad', 'チャド', 'Čadas', 'Čada', 'Čad', 'td', 2),
(215, 'Чехия', 'Чехiя', 'Чэхія', 'Czech Republic', 'Chequia', 'República Checa', 'Tschechische Republik', 'République tchèque', 'Repubblica Ceca', 'Czechy', 'チェコ', 'Čekija', 'Čehija', 'Česká republika', 'cz', 2),
(216, 'Чили', 'Чилi', 'Чылі', 'Chile', 'Chile', 'Chile', 'Chile', 'Chili', 'Cile', 'Chile', 'チリ', 'Čilė', 'Čīle', 'Chile', 'cl', 2),
(217, 'Швейцария', 'Швейцарiя', 'Швайцарыя', 'Switzerland', 'Suiza', 'Suíça', 'Schweiz', 'Suisse', 'Svizzera', 'Szwajcaria', 'スイス', 'Šveicarija', 'Šveice', 'Švýcarsko', 'ch', 2),
(218, 'Швеция', 'Швецiя', 'Швэцыя', 'Sweden', 'Suecia', 'Suécia', 'Schweden', 'Suède', 'Svezia', 'Szwecja', 'スウェーデン', 'Švedija', 'Zviedrija', 'Švédsko', 'se', 2),
(219, 'Шпицберген и Ян Майен', 'Шпiцберген i Ян Майен', 'Шпіцбэрґен і Ян Маен', 'Svalbard and Jan Mayen', 'Spitsbergen y Jan Mayen', 'Spitsbergen  e Jan Mayen', 'Svalbard und Jan Mayen', 'Spitzberg et Jan Mayen', 'Svalbard e Jan Mayen', 'Svalbard i Jan Mayen', 'スピッツベルゲン島・ヤンマイエン島', 'Svalbardo ir Jan Majen salos', 'Špicbergena', 'Špicberky a Jan Mayen', 'sj', 2),
(220, 'Шри-Ланка', 'Шрi-Ланка', 'Шры-Лянка', 'Sri Lanka', 'Sri-Lanka', 'Sri Lanka', 'Sri Lanka', 'Sri Lanka', 'Sri Lanka', 'Sri Lanka', 'スリランカ', 'Šri Lanka', 'Šrilanka', 'Srí Lanka', 'lk', 2),
(221, 'Эквадор', 'Еквадор', 'Эквадор', 'Ecuador', 'Ecuador', 'Equador', 'Ecuador', 'Equateur', 'Ecuador', 'Ekwador', 'エクアドル', 'Ekvadoras', 'Ekvadora', 'Ekvádor', 'ec', 2),
(222, 'Экваториальная Гвинея', 'Екваторiальна Гвiнея', 'Экватарыяльная Гвінэя', 'Equatorial Guinea', 'Guinea Ecuatorial', 'Guiné Equatorial', 'Äquatorialguinea', 'Guinée équatoriale', 'Guinea Equatoriale', 'Gwinea Równikowa', '赤道ギニア', 'Pusiaujo Gvinėja', 'Ekvotoriāla Gvineja', 'Rovníková Guinea', 'gq', 2),
(223, 'Эритрея', 'Ерiтрея', 'Эрытрэя', 'Eritrea', 'Eritrea', 'Eritreia', 'Eritrea', 'Erythrée', 'Eritrea', 'Erytrea', 'エリトリア', 'Eritrėja', 'Eritreja', 'Eritrea', 'er', 2),
(224, 'Эфиопия', 'Ефiопiя', 'Этыёпія', 'Ethiopia', 'Etiopía', 'Etiópia', 'Äthiopien', 'Ethiopie', 'Etiopia', 'Etiopia', 'エチオピア', 'Etiopija', 'Etiopija', 'Etiopie', 'et', 2),
(226, 'Южная Корея', 'Пiвденна Корея', 'Паўднёвая Карэя', 'South Korea', 'Corea del Sur', 'Coreia do Sul', 'Südkorea', 'Corée du Sud', 'Corea del Sud', 'Korea Południowa', '大韓民国', 'Pietų Korėja', 'Dienvidkoreja', 'Jižní Korea', 'kr', 2),
(227, 'Южно-Африканская Республика', 'Пiвденно-Африканська Республiка', 'Паўднёва-Афрыканская Рэспубліка', 'South Africa', 'República de Sudáfrica', 'República da África do Sul', 'Südafrika', 'Afrique du Sud', 'Sud Africa', 'RPA', '南アフリカ共和国', 'Pietų Afrikos Respublika', 'Dienvidāfrikas Republika', 'Jihoafrická republika', 'za', 2),
(228, 'Ямайка', 'Ямайка', 'Ямайка', 'Jamaica', 'Jamaica', 'Jamaica', 'Jamaika', 'Jamaïque', 'Giamaica', 'Jamajka', 'ジャマイカ', 'Jamaika', 'Jamaika', 'Jamajka', 'jm', 2),
(229, 'Япония', 'Японiя', 'Японія', 'Japan', 'Japón', 'Japão', 'Japan', 'Japon', 'Giappone', 'Japonia', '日本', 'Japonija', 'Japāna', 'Japonsko', 'jp', 2),
(230, 'Черногория', 'Чорногорiя', 'Чарнагорыя', 'Montenegro', 'Montenegro', 'Montenegro', 'Montenegro', 'Monténégro', 'Montenegro', 'Czarnogóra', 'モンテネグロ', 'Juodkalnija', 'Melnkalne', 'Černá Hora', 'me', 2),
(231, 'Джибути', 'Джiбутi', 'Джыбуці', 'Djibouti', 'Yibuti', 'Djibouti', 'Djibouti', 'Djibouti', 'Djibouti', 'Dżibuti', 'ジブチ', 'Džibutis', 'Džibuti', 'Džibutsko', 'dj', 2),
(232, 'Южный Судан', 'Південний Судан', 'Паўднёвы Судан', 'South Sudan', 'Sudán del Sur', 'Sudão do Sul', 'Republik Südsudan', 'République du Soudan du Sud', 'Repubblica del Sudan del Sud', 'Sudan Południowy', '南スーダン', 'Pietų Sudanas ', 'South Sudan', 'Jižní Súdán', 'ss', 2),
(233, 'Ватикан', 'Ватикан', 'Ватыкан', 'Vatican', 'Vaticano', 'Vaticano', 'Vatikan', 'Vatican', 'Vaticano', 'Watykan', 'ヴァチカン', 'Vatikanas', 'Vatican', 'Vatikán', 'va', 2),
(234, 'Синт-Мартен', 'Сінт-Мартен', 'Сінт-Мартэн', 'Sint Maarten', 'Sint Maarten', 'São Martinho (Caraíbas)', 'Sint Maarten', 'Saint-Martin', 'Sint Maarten', 'Saint Martin', 'シント・マールテン', 'Sint Martenas ', 'Sint Maarten', 'Sint Maarten', 'mf', 2),
(235, 'Бонайре, Синт-Эстатиус и Саба', 'Бонайре, Сінт-Естатіус і Саба', 'Банайрэ, Сінт-Эстатыюс і Саба', 'Bonaire, Sint Eustatius and Saba', 'Bonaire, San Eustaquio y Saba', 'Bonaire, Santo Eustáquio e Saba ', 'Bonaire, Sint Eustatius und Saba', 'Bonaire, Saint-Eustache et Saba', 'Bonaire, Sint Eustatius e Saba', 'Bonaire, Sint Eustatius i Saba', 'BES諸島', 'Bonairė, Sint Estatijus ir Saba', 'Bonaire, Sint Eustatius and Saba', 'Karibské Nizozemsko', 'bq', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `iso_4217` varchar(10) NOT NULL,
  `sign` varchar(10) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `show_after_price` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `name`, `iso_4217`, `sign`, `is_default`, `show_after_price`) VALUES
(1, 'Гривня', 'UAH', '₴', 1, 1),
(2, 'Евро', 'EUR', '€', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `mac_address` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `notes` text,
  `date_registrated` date NOT NULL,
  `gender_id` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `customer`
--

INSERT INTO `customer` (`id`, `user_id`, `mac_address`, `name`, `notes`, `date_registrated`, `gender_id`, `age`) VALUES
(30, 47, '74:69:69:2d:30:31', 'Летенко Гаврило', '', '2016-09-23', 1, 23);

-- --------------------------------------------------------

--
-- Структура таблицы `customer_operator`
--

CREATE TABLE IF NOT EXISTS `customer_operator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `operator_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `operator_id` (`operator_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `customer_operator`
--

INSERT INTO `customer_operator` (`id`, `customer_id`, `operator_id`) VALUES
(2, 30, 30);

-- --------------------------------------------------------

--
-- Структура таблицы `exchange_rate`
--

CREATE TABLE IF NOT EXISTS `exchange_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ccy` varchar(10) NOT NULL,
  `base_ccy` varchar(10) NOT NULL,
  `buy` double NOT NULL,
  `sale` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ccy` (`ccy`,`base_ccy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Дамп данных таблицы `exchange_rate`
--

INSERT INTO `exchange_rate` (`id`, `ccy`, `base_ccy`, `buy`, `sale`) VALUES
(1, 'EUR', 'UAH', 27.75487, 27.49367),
(2, 'RUR', 'UAH', 0.38289, 0.38309),
(3, 'USD', 'UAH', 24.81659, 24.81826),
(4, 'BTC', 'USD', 566.225, 625.8276),
(5, 'EUR', 'UAH', 27.71566, 27.75487),
(6, 'RUR', 'UAH', 0.38261, 0.38289),
(7, 'USD', 'UAH', 24.85041, 24.81659),
(8, 'BTC', 'USD', 559.6154, 618.5222),
(9, 'EUR', 'UAH', 28.49599, 28.28997),
(10, 'RUR', 'UAH', 0.39609, 0.39205),
(11, 'USD', 'UAH', 25.17091, 25.08866),
(12, 'BTC', 'USD', 544.9141, 602.2735),
(13, 'EUR', 'UAH', 28.49599, 28.28997),
(14, 'RUR', 'UAH', 0.39609, 0.39205),
(15, 'USD', 'UAH', 25.17091, 25.08866),
(16, 'BTC', 'USD', 545.021, 602.3916),
(17, 'EUR', 'UAH', 28.49599, 28.28997),
(18, 'RUR', 'UAH', 0.39609, 0.39205),
(19, 'USD', 'UAH', 25.17091, 25.08866),
(20, 'BTC', 'USD', 545.021, 602.3916),
(21, 'EUR', 'UAH', 28.49599, 28.28997),
(22, 'RUR', 'UAH', 0.39609, 0.39205),
(23, 'USD', 'UAH', 25.17091, 25.08866),
(24, 'BTC', 'USD', 545.002, 602.3706),
(25, 'EUR', 'UAH', 28.49599, 28.28997),
(26, 'RUR', 'UAH', 0.39609, 0.39205),
(27, 'USD', 'UAH', 25.17091, 25.08866),
(28, 'BTC', 'USD', 545.002, 602.3706),
(29, 'EUR', 'UAH', 28.49599, 28.28997),
(30, 'RUR', 'UAH', 0.39609, 0.39205),
(31, 'USD', 'UAH', 25.17091, 25.08866),
(32, 'BTC', 'USD', 545.002, 602.3706),
(33, 'EUR', 'UAH', 28.49599, 28.28997),
(34, 'RUR', 'UAH', 0.39609, 0.39205),
(35, 'USD', 'UAH', 25.17091, 25.08866),
(36, 'BTC', 'USD', 544.9461, 602.3089),
(37, 'EUR', 'UAH', 28.49599, 28.28997),
(38, 'RUR', 'UAH', 0.39609, 0.39205),
(39, 'USD', 'UAH', 25.17091, 25.08866),
(40, 'BTC', 'USD', 544.8215, 602.1711),
(41, 'EUR', 'UAH', 28.43976, 28.43976),
(42, 'RUR', 'UAH', 0.41233, 0.41233),
(43, 'USD', 'UAH', 25.8074, 25.8074),
(44, 'BTC', 'USD', 608.3551, 672.3925);

-- --------------------------------------------------------

--
-- Структура таблицы `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `gender`
--

INSERT INTO `gender` (`id`, `alias`) VALUES
(1, 'male'),
(2, 'female');

-- --------------------------------------------------------

--
-- Структура таблицы `genderlang`
--

CREATE TABLE IF NOT EXISTS `genderlang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_id` int(11) NOT NULL,
  `language` varchar(10) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gender_id` (`gender_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `genderlang`
--

INSERT INTO `genderlang` (`id`, `gender_id`, `language`, `title`) VALUES
(5, 1, 'en', 'Male'),
(6, 1, 'ru', 'Мужской'),
(7, 1, 'ua', 'Чоловіча'),
(8, 2, 'en', 'Woman'),
(9, 2, 'ru', 'Женский'),
(10, 2, 'ua', 'Жіноча');

-- --------------------------------------------------------

--
-- Структура таблицы `heart_beat`
--

CREATE TABLE IF NOT EXISTS `heart_beat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ibi` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=301 ;

--
-- Дамп данных таблицы `heart_beat`
--

INSERT INTO `heart_beat` (`id`, `user_id`, `ibi`) VALUES
(1, 47, '2016-10-16 12:51:41.900400'),
(2, 47, '2016-10-16 12:51:42.542811'),
(3, 47, '2016-10-16 12:51:43.149452'),
(4, 47, '2016-10-16 12:51:43.864582'),
(5, 47, '2016-10-16 12:51:44.445636'),
(6, 47, '2016-10-16 12:51:45.029856'),
(7, 47, '2016-10-16 12:51:45.591571'),
(8, 47, '2016-10-16 12:51:46.178122'),
(9, 47, '2016-10-16 12:51:46.709750'),
(10, 47, '2016-10-16 12:51:47.273249'),
(11, 47, '2016-10-16 12:51:47.966591'),
(12, 47, '2016-10-16 12:51:48.516288'),
(13, 47, '2016-10-16 12:51:49.116690'),
(14, 47, '2016-10-16 12:51:49.660201'),
(15, 47, '2016-10-16 12:51:50.243913'),
(16, 47, '2016-10-16 12:51:50.788284'),
(17, 47, '2016-10-16 12:51:51.350941'),
(18, 47, '2016-10-16 12:51:51.946408'),
(19, 47, '2016-10-16 12:51:52.500853'),
(20, 47, '2016-10-16 12:51:53.090477'),
(21, 47, '2016-10-16 12:51:53.628881'),
(22, 47, '2016-10-16 12:51:54.221131'),
(23, 47, '2016-10-16 12:51:54.762715'),
(24, 47, '2016-10-16 12:51:55.401719'),
(25, 47, '2016-10-16 12:51:56.008967'),
(26, 47, '2016-10-16 12:51:56.539642'),
(27, 47, '2016-10-16 12:51:57.133309'),
(28, 47, '2016-10-16 12:51:57.761946'),
(29, 47, '2016-10-16 12:51:58.409539'),
(30, 47, '2016-10-16 12:51:59.146396'),
(31, 47, '2016-10-16 12:51:59.758652'),
(32, 47, '2016-10-16 12:52:00.512211'),
(33, 47, '2016-10-16 12:52:01.097694'),
(34, 47, '2016-10-16 12:52:01.642693'),
(35, 47, '2016-10-16 12:52:02.238561'),
(36, 47, '2016-10-16 12:52:02.814412'),
(37, 47, '2016-10-16 12:52:03.392568'),
(38, 47, '2016-10-16 12:52:03.971677'),
(39, 47, '2016-10-16 12:52:04.556817'),
(40, 47, '2016-10-16 12:52:05.149121'),
(41, 47, '2016-10-16 12:52:05.696247'),
(42, 47, '2016-10-16 12:52:06.314040'),
(43, 47, '2016-10-16 12:52:06.941581'),
(44, 47, '2016-10-16 12:52:07.508118'),
(45, 47, '2016-10-16 12:52:08.091052'),
(46, 47, '2016-10-16 12:52:08.631846'),
(47, 47, '2016-10-16 12:52:09.219756'),
(48, 47, '2016-10-16 12:52:09.779482'),
(49, 47, '2016-10-16 12:52:10.413749'),
(50, 47, '2016-10-16 12:52:11.078670'),
(51, 47, '2016-10-16 12:52:11.627992'),
(52, 47, '2016-10-16 12:52:12.228854'),
(53, 47, '2016-10-16 12:52:12.824950'),
(54, 47, '2016-10-16 12:52:13.412230'),
(55, 47, '2016-10-16 12:52:13.966994'),
(56, 47, '2016-10-16 12:52:14.542640'),
(57, 47, '2016-10-16 12:52:15.162777'),
(58, 47, '2016-10-16 12:52:15.759975'),
(59, 47, '2016-10-16 12:52:16.359713'),
(60, 47, '2016-10-16 12:52:16.910438'),
(61, 47, '2016-10-16 12:52:17.458706'),
(62, 47, '2016-10-16 12:52:18.007633'),
(63, 47, '2016-10-16 12:52:18.565056'),
(64, 47, '2016-10-16 12:52:19.106697'),
(65, 47, '2016-10-16 12:52:19.667941'),
(66, 47, '2016-10-16 12:52:20.256645'),
(67, 47, '2016-10-16 12:52:20.864672'),
(68, 47, '2016-10-16 12:52:21.405640'),
(69, 47, '2016-10-16 12:52:21.951760'),
(70, 47, '2016-10-16 12:52:22.516277'),
(71, 47, '2016-10-16 12:52:23.113716'),
(72, 47, '2016-10-16 12:52:23.664562'),
(73, 47, '2016-10-16 12:52:24.264897'),
(74, 47, '2016-10-16 12:52:24.817333'),
(75, 47, '2016-10-16 12:52:25.434427'),
(76, 47, '2016-10-16 12:52:26.005341'),
(77, 47, '2016-10-16 12:52:26.570451'),
(78, 47, '2016-10-16 12:52:27.168259'),
(79, 47, '2016-10-16 12:52:27.713010'),
(80, 47, '2016-10-16 12:52:28.262109'),
(81, 47, '2016-10-16 12:52:28.820189'),
(82, 47, '2016-10-16 12:52:29.457918'),
(83, 47, '2016-10-16 12:52:30.067130'),
(84, 47, '2016-10-16 12:52:30.620645'),
(85, 47, '2016-10-16 12:52:31.212306'),
(86, 47, '2016-10-16 12:52:31.762236'),
(87, 47, '2016-10-16 12:52:32.346890'),
(88, 47, '2016-10-16 12:52:32.933975'),
(89, 47, '2016-10-16 12:52:33.486793'),
(90, 47, '2016-10-16 12:52:34.040277'),
(91, 47, '2016-10-16 12:52:34.582898'),
(92, 47, '2016-10-16 12:52:35.122216'),
(93, 47, '2016-10-16 12:52:35.759290'),
(94, 47, '2016-10-16 12:52:36.346160'),
(95, 47, '2016-10-16 12:52:36.930920'),
(96, 47, '2016-10-16 12:52:37.480069'),
(97, 47, '2016-10-16 12:52:38.027177'),
(98, 47, '2016-10-16 12:52:38.571292'),
(99, 47, '2016-10-16 12:52:39.159938'),
(100, 47, '2016-10-16 12:52:39.728929'),
(101, 47, '2016-10-16 12:52:40.317735'),
(102, 47, '2016-10-16 12:52:40.902346'),
(103, 47, '2016-10-16 12:52:41.442493'),
(104, 47, '2016-10-16 12:52:42.045618'),
(105, 47, '2016-10-16 12:52:42.604023'),
(106, 47, '2016-10-16 12:52:43.215642'),
(107, 47, '2016-10-16 12:52:43.766427'),
(108, 47, '2016-10-16 12:52:44.391566'),
(109, 47, '2016-10-16 12:52:44.959630'),
(110, 47, '2016-10-16 12:52:45.527964'),
(111, 47, '2016-10-16 12:52:46.124145'),
(112, 47, '2016-10-16 12:52:46.682182'),
(113, 47, '2016-10-16 12:52:47.271061'),
(114, 47, '2016-10-16 12:52:47.897340'),
(115, 47, '2016-10-16 12:52:48.454520'),
(116, 47, '2016-10-16 12:52:49.045632'),
(117, 47, '2016-10-16 12:52:49.597584'),
(118, 47, '2016-10-16 12:52:50.207580'),
(119, 47, '2016-10-16 12:52:50.754931'),
(120, 47, '2016-10-16 12:52:51.345738'),
(121, 47, '2016-10-16 12:52:51.942101'),
(122, 47, '2016-10-16 12:52:52.509201'),
(123, 47, '2016-10-16 12:52:53.096581'),
(124, 47, '2016-10-16 12:52:53.669944'),
(125, 47, '2016-10-16 12:52:54.246001'),
(126, 47, '2016-10-16 12:52:54.813315'),
(127, 47, '2016-10-16 12:52:55.403737'),
(128, 47, '2016-10-16 12:52:56.039502'),
(129, 47, '2016-10-16 12:52:56.603424'),
(130, 47, '2016-10-16 12:52:57.191651'),
(131, 47, '2016-10-16 12:52:57.787869'),
(132, 47, '2016-10-16 12:52:58.389661'),
(133, 47, '2016-10-16 12:52:59.028257'),
(134, 47, '2016-10-16 12:52:59.593292'),
(135, 47, '2016-10-16 12:53:00.144940'),
(136, 47, '2016-10-16 12:53:00.700747'),
(137, 47, '2016-10-16 12:53:01.255535'),
(138, 47, '2016-10-16 12:53:01.859154'),
(139, 47, '2016-10-16 12:53:02.438748'),
(140, 47, '2016-10-16 12:53:02.988138'),
(141, 47, '2016-10-16 12:53:03.543079'),
(142, 47, '2016-10-16 12:53:04.200485'),
(143, 47, '2016-10-16 12:53:04.808654'),
(144, 47, '2016-10-16 12:53:05.407762'),
(145, 47, '2016-10-16 12:53:05.975573'),
(146, 47, '2016-10-16 12:53:06.534537'),
(147, 47, '2016-10-16 12:53:07.097754'),
(148, 47, '2016-10-16 12:53:07.665291'),
(149, 47, '2016-10-16 12:53:08.307014'),
(150, 47, '2016-10-16 12:53:08.916344');

-- --------------------------------------------------------

--
-- Структура таблицы `heart_beat_rate`
--

CREATE TABLE IF NOT EXISTS `heart_beat_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `min_age` int(11) NOT NULL,
  `max_age` int(11) NOT NULL,
  `min_beat` int(11) NOT NULL,
  `max_beat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Дамп данных таблицы `heart_beat_rate`
--

INSERT INTO `heart_beat_rate` (`id`, `min_age`, `max_age`, `min_beat`, `max_beat`) VALUES
(62, 0, 1, 102, 162),
(63, 1, 4, 94, 154),
(64, 4, 6, 86, 126),
(65, 6, 8, 78, 118),
(66, 8, 10, 68, 108),
(67, 10, 12, 60, 100),
(68, 12, 15, 55, 95),
(69, 15, 50, 60, 80),
(70, 50, 60, 64, 84),
(71, 60, 80, 69, 89);

-- --------------------------------------------------------

--
-- Структура таблицы `job`
--

CREATE TABLE IF NOT EXISTS `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `job`
--

INSERT INTO `job` (`id`, `name`, `method`) VALUES
(6, 'Update exchange rate', 'crUpdateExchangeRate'),
(7, 'Searching for disease', 'crDetectDisease');

-- --------------------------------------------------------

--
-- Структура таблицы `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` smallint(6) NOT NULL DEFAULT '0',
  `date_update` int(11) NOT NULL,
  `date_create` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `lang`
--

INSERT INTO `lang` (`id`, `url`, `local`, `name`, `default`, `date_update`, `date_create`, `currency_id`) VALUES
(1, 'en', 'en_EN', 'English', 0, 1463386881, 1463386881, 2),
(4, 'ru', 'ru_RU', 'Русский', 1, 1463386881, 1463386881, 1),
(5, 'ua', 'uk_UA', 'Українська', 0, 1463386881, 1463386881, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `sort` int(11) DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `bean_type` varchar(255) DEFAULT NULL,
  `bean_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `menu_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_type_id` (`menu_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `created_at`, `updated_at`, `sort`, `parent_id`, `bean_type`, `bean_id`, `url`, `enabled`, `menu_type_id`) VALUES
(4, 1470075960, 1474639405, 2, NULL, 'post', 7, NULL, 1, 1),
(19, 1471097238, 1471097621, 5, NULL, 'post', 7, NULL, 1, 2),
(20, 1471097288, 1471097621, 6, NULL, 'post', 7, NULL, 1, 2),
(21, 1471097351, 1471097621, 7, NULL, 'post', 7, NULL, 1, 2),
(24, 1471097512, 1471097622, 10, NULL, 'post', 7, NULL, 1, 2),
(25, 1472761472, 1474639304, 0, NULL, 'post', 7, '', 1, 1),
(26, 1472798746, 1474639405, 1, NULL, 'post', 12, NULL, 1, 1),
(27, 1472798843, 1472798843, 2, 7, 'post', 7, NULL, 1, 1),
(28, 1472798948, 1472798948, NULL, 8, 'post', 7, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `menulang`
--

CREATE TABLE IF NOT EXISTS `menulang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `language` varchar(6) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`menu_id`),
  KEY `language` (`language`),
  KEY `menu_id` (`menu_id`),
  KEY `menu_id_2` (`menu_id`,`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Дамп данных таблицы `menulang`
--

INSERT INTO `menulang` (`id`, `menu_id`, `language`, `title`) VALUES
(10, 4, 'en', 'Contacs'),
(11, 4, 'ru', 'Контакты'),
(12, 4, 'ua', 'Контакти'),
(55, 19, 'en', 'Questions and answers'),
(56, 19, 'ru', 'Вопросы и ответы'),
(57, 19, 'ua', 'Питання і відповіді'),
(58, 20, 'en', 'About us'),
(59, 20, 'ru', 'О нас'),
(60, 20, 'ua', 'Про нас'),
(61, 21, 'en', 'Career'),
(62, 21, 'ru', 'Карьера'),
(63, 21, 'ua', 'Кар''єра'),
(70, 24, 'en', 'Terms & conditions'),
(71, 24, 'ru', 'Правила и условия'),
(72, 24, 'ua', 'Правила і умови'),
(73, 25, 'en', 'Main'),
(74, 25, 'ru', 'Главная'),
(75, 25, 'ua', 'Головна'),
(76, 26, 'en', 'About us'),
(77, 26, 'ru', 'Про нас'),
(78, 26, 'ua', 'Про нас'),
(79, 27, 'en', 'Products catalog'),
(80, 27, 'ru', 'Каталог изделий'),
(81, 27, 'ua', 'Каталог виробів'),
(82, 28, 'en', 'Model creation'),
(83, 28, 'ru', 'Создание моделей'),
(84, 28, 'ua', 'Створення моделей');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_type`
--

CREATE TABLE IF NOT EXISTS `menu_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `menu_type`
--

INSERT INTO `menu_type` (`id`, `name`, `alias`) VALUES
(1, 'Header', 'header'),
(2, 'Footer', 'footer');

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL DEFAULT '0',
  `language` varchar(255) NOT NULL DEFAULT '',
  `translation` text,
  PRIMARY KEY (`id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `language`, `translation`) VALUES
(252, 'ru', '(не задано)'),
(252, 'ua', '(не задано)'),
(253, 'ru', 'Возникла внутренняя ошибка сервера.'),
(253, 'ua', 'Виникла внутрішня помилка сервера.'),
(254, 'ru', 'Вы уверены, что хотите удалить этот элемент?'),
(254, 'ua', 'Ви впевнені, що хочете видалити цей елемент?'),
(255, 'ru', 'Удалить'),
(255, 'ua', 'Видалити'),
(256, 'ru', 'Ошибка'),
(256, 'ua', 'Помилка'),
(257, 'ru', 'Загрузка файла не удалась.'),
(257, 'ua', 'Завантаження файлу не вдалося.'),
(258, 'ru', 'Главная'),
(258, 'ua', 'Головна'),
(259, 'ru', 'Неправильное значение параметра "{param}".'),
(259, 'ua', 'Отримано невірне значення для параметра "{param}".'),
(260, 'ru', 'Требуется вход.'),
(260, 'ua', 'Необхідно увійти'),
(261, 'ru', 'Отсутствуют обязательные аргументы: {params}'),
(261, 'ua', 'Відсутні обовʼязкові аргументи: {params}'),
(262, 'ru', 'Отсутствуют обязательные параметры: {params}'),
(262, 'ua', 'Відсутні обовʼязкові параметри: {params}'),
(263, 'ru', 'Нет'),
(263, 'ua', 'Ні'),
(264, 'ru', 'Ничего не найдено.'),
(264, 'ua', 'Нічого не знайдено.'),
(265, 'ru', 'Разрешена загрузка файлов только со следующими MIME-типами: {mimeTypes}.'),
(265, 'ua', 'Дозволені файли лише з наступними MIME-типами: {mimeTypes}.'),
(266, 'ru', 'Разрешена загрузка файлов только со следующими расширениями: {extensions}.'),
(266, 'ua', 'Дозволені файли лише з наступними розширеннями: {extensions}.'),
(267, 'ru', 'Страница не найдена.'),
(267, 'ua', 'Сторінка не знайдена.'),
(268, 'ru', 'Исправьте следующие ошибки:'),
(268, 'ua', 'Будь ласка, виправте наступні помилки:'),
(269, 'ru', 'Загрузите файл.'),
(269, 'ua', 'Будь ласка, завантажте файл.'),
(270, 'ru', 'Показаны записи <b>{begin, number}-{end, number}</b> из <b>{totalCount, number}</b>.'),
(270, 'ua', 'Показані <b>{begin, number}-{end, number}</b> із <b>{totalCount, number}</b> {totalCount, plural, one{запису} other{записів}}.'),
(271, 'ru', 'Файл «{file}» не является изображением.'),
(271, 'ua', 'Файл "{file}" не є зображенням.'),
(272, 'ru', 'Файл «{file}» слишком большой. Размер не должен превышать {formattedLimit}.'),
(272, 'ua', 'Файл "{file}" занадто великий. Розмір не повинен перевищувати {formattedLimit}.'),
(273, 'ru', 'Файл «{file}» слишком маленький. Размер должен быть более {formattedLimit}.'),
(273, 'ua', 'Файл "{file}" занадто малий. Розмір повинен бути більше, ніж {formattedLimit}.'),
(274, 'ru', 'Неверный формат значения «{attribute}».'),
(274, 'ua', 'Невірний формат значення "{attribute}".'),
(275, 'ru', 'Файл «{file}» слишком большой. Высота не должна превышать {limit, number} {limit, plural, one{пиксель} few{пикселя} many{пикселей} other{пикселя}}.'),
(275, 'ua', 'Зображення "{file}" занадто велике. Висота не повинна перевищувати {limit, number} {limit, plural, one{піксель} few{пікселя} many{пікселів} other{пікселя}}.'),
(276, 'ru', 'Файл «{file}» слишком большой. Ширина не должна превышать {limit, number} {limit, plural, one{пиксель} few{пикселя} many{пикселей} other{пикселя}}.'),
(276, 'ua', 'Зображення "{file}" занадто велике. Ширина не повинна перевищувати {limit, number} {limit, plural, one{піксель} few{пікселя} many{пікселів} other{пікселя}}.'),
(277, 'ru', 'Файл «{file}» слишком маленький. Высота должна быть более {limit, number} {limit, plural, one{пиксель} few{пикселя} many{пикселей} other{пикселя}}.'),
(277, 'ua', 'Зображення "{file}" занадто мале. Висота повинна бути більше, ніж {limit, number} {limit, plural, one{піксель} few{пікселя} many{пікселів} other{пікселя}}.'),
(278, 'ru', 'Файл «{file}» слишком маленький. Ширина должна быть более {limit, number} {limit, plural, one{пиксель} few{пикселя} many{пикселей} other{пикселя}}.'),
(278, 'ua', 'Зображення "{file}" занадто мале. Ширина повинна бути більше, ніж {limit, number} {limit, plural, one{піксель} few{пікселя} many{пікселів} other{пікселя}}.'),
(279, 'ru', 'Запрашиваемый файл представления "{name}" не найден.'),
(279, 'ua', 'Представлення "{name}" не знайдено.'),
(280, 'ru', 'Неправильный проверочный код.'),
(280, 'ua', 'Невірний код перевірки.'),
(281, 'ru', 'Всего <b>{count, number}</b> {count, plural, one{запись} few{записи} many{записей} other{записи}}.'),
(281, 'ua', 'Всього <b>{count, number}</b> {count, plural, one{запис} few{записи} many{записів} other{записи}}.'),
(282, 'ru', 'Не удалось проверить переданные данные.'),
(282, 'ua', 'Не вдалося перевірити передані дані.'),
(283, 'ru', 'Неизвестная опция: --{name}'),
(283, 'ua', 'Невідома опція : --{name}'),
(284, 'ru', 'Редактировать'),
(284, 'ua', 'Оновити'),
(285, 'ru', 'Просмотр'),
(285, 'ua', 'Переглянути'),
(286, 'ru', 'Да'),
(286, 'ua', 'Так'),
(287, 'ru', 'Вам не разрешено производить данное действие.'),
(287, 'ua', 'Вам не дозволено виконувати дану дію.'),
(288, 'ru', 'Вы не можете загружать более {limit, number} {limit, plural, one{файла} few{файлов} many{файлов} other{файла}}.'),
(288, 'ua', 'Ви не можете завантажувати більше {limit, number} {limit, plural, one{файла} few{файлів} many{файлів} other{файла}}.'),
(289, 'ru', 'через {delta, plural, =1{день} one{# день} few{# дня} many{# дней} other{# дня}}'),
(289, 'ua', 'через {delta, plural, =1{день} one{# день} few{# дні} many{# днів} other{# дні}}'),
(290, 'ru', 'через {delta, plural, =1{минуту} one{# минуту} few{# минуты} many{# минут} other{# минуты}}'),
(290, 'ua', 'через {delta, plural, =1{хвилину} one{# хвилину} few{# хвилини} many{# хвилин} other{# хвилини}}'),
(291, 'ru', 'через {delta, plural, =1{месяц} one{# месяц} few{# месяца} many{# месяцев} other{# месяца}}'),
(291, 'ua', 'через {delta, plural, =1{місяць} one{# місяць} few{# місяці} many{# місяців} other{# місяці}}'),
(292, 'ru', 'через {delta, plural, =1{секунду} one{# секунду} few{# секунды} many{# секунд} other{# секунды}}'),
(292, 'ua', 'через {delta, plural, =1{секунду} one{# секунду} few{# секунди} many{# секунд} other{# секунди}}'),
(293, 'ru', 'через {delta, plural, =1{год} one{# год} few{# года} many{# лет} other{# года}}'),
(293, 'ua', 'через {delta, plural, =1{рік} one{# рік} few{# роки} many{# років} other{# роки}}'),
(294, 'ru', 'через {delta, plural, =1{час} one{# час} few{# часа} many{# часов} other{# часа}}'),
(294, 'ua', 'через {delta, plural, =1{годину} one{# годину} few{# години} many{# годин} other{# години}}'),
(295, 'ru', 'прямо сейчас'),
(295, 'ua', 'саме зараз'),
(296, 'ru', 'введённое значение'),
(296, 'ua', 'введене значення'),
(297, 'ru', 'Значение «{value}» для «{attribute}» уже занято.'),
(297, 'ua', 'Значення «{value}» для «{attribute}» вже зайнято.'),
(298, 'ru', 'Необходимо заполнить «{attribute}».'),
(298, 'ua', 'Необхідно заповнити "{attribute}".'),
(299, 'ru', 'Значение «{attribute}» неверно.'),
(299, 'ua', 'Значення "{attribute}" не вірне.'),
(300, 'ru', 'Значение «{attribute}» не является правильным URL.'),
(300, 'ua', 'Значення "{attribute}" не є правильним URL.'),
(301, 'ru', 'Значение «{attribute}» не является правильным email адресом.'),
(301, 'ua', 'Значення "{attribute}" не є правильною email адресою.'),
(302, 'ru', 'Значение «{attribute}» должно быть равно «{requiredValue}».'),
(302, 'ua', 'Значення "{attribute}" має бути рівним "{requiredValue}".'),
(303, 'ru', 'Значение «{attribute}» должно быть числом.'),
(303, 'ua', 'Значення "{attribute}" має бути числом.'),
(304, 'ru', 'Значение «{attribute}» должно быть строкой.'),
(304, 'ua', 'Значення "{attribute}" має бути текстовим рядком.'),
(305, 'ru', 'Значение «{attribute}» должно быть целым числом.'),
(305, 'ua', 'Значення "{attribute}" має бути цілим числом.'),
(306, 'ru', 'Значение «{attribute}» должно быть равно «{true}» или «{false}».'),
(306, 'ua', 'Значення "{attribute}" має дорівнювати "{true}" або "{false}".'),
(311, 'ru', 'Значение «{attribute}» не должно превышать {max}.'),
(311, 'ua', 'Значення "{attribute}" не повинно перевищувати {max}.'),
(312, 'ru', 'Значение «{attribute}» должно быть не меньше {min}.'),
(312, 'ua', 'Значення "{attribute}" має бути більшим {min}.'),
(315, 'ru', 'Значение «{attribute}» должно содержать минимум {min, number} {min, plural, one{символ} few{символа} many{символов} other{символа}}.'),
(315, 'ua', 'Значення "{attribute}" повинно містити мінімум {min, number} {min, plural, one{символ} few{символа} many{символів} other{символа}}.'),
(316, 'ru', 'Значение «{attribute}» должно содержать максимум {max, number} {max, plural, one{символ} few{символа} many{символов} other{символа}}.'),
(316, 'ua', 'Значення "{attribute}" повинно містити максимум {max, number} {max, plural, one{символ} few{символа} many{символів} other{символа}}.'),
(317, 'ru', 'Значение «{attribute}» должно содержать {length, number} {length, plural, one{символ} few{символа} many{символов} other{символа}}.'),
(317, 'ua', 'Значення "{attribute}" повинно містити {length, number} {length, plural, one{символ} few{символа} many{символів} other{символа}}.'),
(318, 'ru', '{delta, plural, =1{день} one{# день} few{# дня} many{# дней} other{# дня}} назад'),
(318, 'ua', '{delta, plural, =1{день} one{день} few{# дні} many{# днів} other{# дні}} тому'),
(319, 'ru', '{delta, plural, =1{минуту} one{# минуту} few{# минуты} many{# минут} other{# минуты}} назад'),
(319, 'ua', '{delta, plural, =1{хвилину} one{# хвилину} few{# хвилини} many{# хвилин} other{# хвилини}} тому'),
(320, 'ru', '{delta, plural, =1{месяц} one{# месяц} few{# месяца} many{# месяцев} other{# месяца}} назад'),
(320, 'ua', '{delta, plural, =1{місяць} one{# місяць} few{# місяці} many{# місяців} other{# місяці}} тому'),
(321, 'ru', '{delta, plural, =1{секунду} one{# секунду} few{# секунды} many{# секунд} other{# секунды}} назад'),
(321, 'ua', '{delta, plural, =1{секунду} one{# секунду} few{# секунди} many{# секунд} other{# секунди}} тому'),
(322, 'ru', '{delta, plural, =1{год} one{# год} few{# года} many{# лет} other{# года}} назад'),
(322, 'ua', '{delta, plural, =1{рік} one{# рік} few{# роки} many{# років} other{# роки}} тому'),
(323, 'ru', '{delta, plural, =1{час} one{# час} few{# часа} many{# часов} other{# часа}} назад'),
(323, 'ua', '{delta, plural, =1{година} one{# година} few{# години} many{# годин} other{# години}} тому'),
(324, 'ru', '{nFormatted} Б'),
(324, 'ua', '{nFormatted} Б'),
(325, 'ru', '{nFormatted} ГБ'),
(325, 'ua', '{nFormatted} Гб'),
(326, 'ru', '{nFormatted} ГиБ'),
(326, 'ua', '{nFormatted} ГіБ'),
(327, 'ru', '{nFormatted} КБ'),
(327, 'ua', '{nFormatted} Кб'),
(328, 'ru', '{nFormatted} КиБ'),
(328, 'ua', '{nFormatted} КіБ'),
(329, 'ru', '{nFormatted} МБ'),
(329, 'ua', '{nFormatted} Мб'),
(330, 'ru', '{nFormatted} МиБ'),
(330, 'ua', '{nFormatted} МіБ'),
(331, 'ru', '{nFormatted} ПБ'),
(331, 'ua', '{nFormatted} Пб'),
(332, 'ru', '{nFormatted} ПиБ'),
(332, 'ua', '{nFormatted} ПіБ'),
(333, 'ru', '{nFormatted} ТБ'),
(333, 'ua', '{nFormatted} Тб'),
(334, 'ru', '{nFormatted} ТиБ'),
(334, 'ua', '{nFormatted} ТіБ'),
(335, 'ru', '{nFormatted} {n, plural, one{байт} few{байта} many{байтов} other{байта}}'),
(335, 'ua', '{nFormatted} {n, plural, one{байт} few{байта} many{байтів} other{байта}}'),
(336, 'ru', '{nFormatted} {n, plural, one{гибибайт} few{гибибайта} many{гибибайтов} other{гибибайта}}'),
(336, 'ua', '{nFormatted} {n, plural, one{гібібайт} few{гібібайта} many{гібібайтів} other{гібібайта}}'),
(337, 'ru', '{nFormatted} {n, plural, one{гигабайт} few{гигабайта} many{гигабайтов} other{гигабайта}}'),
(337, 'ua', '{nFormatted} {n, plural, one{гігабайт} few{гігабайта} many{гігабайтів} other{гігабайта}}'),
(338, 'ru', '{nFormatted} {n, plural, one{кибибайт} few{кибибайта} many{кибибайтов} other{кибибайта}}'),
(338, 'ua', '{nFormatted} {n, plural, one{кібібайт} few{кібібайта} many{кібібайтів} other{кібібайта}}'),
(339, 'ru', '{nFormatted} {n, plural, one{килобайт} few{килобайта} many{килобайтов} other{килобайта}}'),
(339, 'ua', '{nFormatted} {n, plural, one{кілобайт} few{кілобайта} many{кілобайтів} other{кілобайта}}'),
(340, 'ru', '{nFormatted} {n, plural, one{мебибайт} few{мебибайта} many{мебибайтов} other{мебибайта}}'),
(340, 'ua', '{nFormatted} {n, plural, one{мебібайт} few{мебібайта} many{мебібайтів} other{мебібайта}}'),
(341, 'ru', '{nFormatted} {n, plural, one{мегабайт} few{мегабайта} many{мегабайтов} other{мегабайта}}'),
(341, 'ua', '{nFormatted} {n, plural, one{мегабайт} few{мегабайта} many{мегабайтів} other{мегабайта}}'),
(342, 'ru', '{nFormatted} {n, plural, one{пебибайт} few{пебибайта} many{пебибайтов} other{пебибайта}}'),
(342, 'ua', '{nFormatted} {n, plural, one{пебібайт} few{пебібайта} many{пебібайтів} other{пебібайта}}'),
(343, 'ru', '{nFormatted} {n, plural, one{петабайт} few{петабайта} many{петабайтов} other{петабайта}}'),
(343, 'ua', '{nFormatted} {n, plural, one{петабайт} few{петабайта} many{петабайтів} other{петабайта}}'),
(344, 'ru', '{nFormatted} {n, plural, one{тебибайт} few{тебибайта} many{тебибайтов} other{тебибайта}}'),
(344, 'ua', '{nFormatted} {n, plural, one{тебібайт} few{тебібайта} many{тебібайтів} other{тебібайта}}'),
(345, 'ru', '{nFormatted} {n, plural, one{терабайт} few{терабайта} many{терабайтов} other{терабайта}}'),
(345, 'ua', '{nFormatted} {n, plural, one{терабайт} few{терабайта} many{терабайтів} other{терабайта}}'),
(537, 'en', ''),
(537, 'nl', NULL),
(537, 'ru', 'Переводы'),
(537, 'ua', 'Переклади'),
(538, 'en', 'ID'),
(538, 'nl', NULL),
(538, 'ru', 'ID'),
(538, 'ua', 'ID'),
(538, 'uk', NULL),
(539, 'en', ''),
(539, 'nl', NULL),
(539, 'ru', 'Сообщение'),
(539, 'ua', 'Повідомлення'),
(540, 'en', ''),
(540, 'nl', NULL),
(540, 'ru', 'Категория'),
(540, 'ua', 'Категорія'),
(541, 'en', ''),
(541, 'nl', NULL),
(541, 'ru', 'Статус'),
(541, 'ua', 'Статус'),
(541, 'uk', NULL),
(542, 'en', ''),
(542, 'nl', NULL),
(542, 'ru', 'Переведено'),
(542, 'ua', 'Перекладено'),
(543, 'en', ''),
(543, 'nl', NULL),
(543, 'ru', 'Не переведено'),
(543, 'ua', 'Не перекладено'),
(544, 'en', NULL),
(544, 'nl', NULL),
(544, 'ru', NULL),
(544, 'ua', NULL),
(545, 'en', ''),
(545, 'nl', NULL),
(545, 'ru', 'Меню'),
(545, 'ua', 'Меню'),
(546, 'en', NULL),
(546, 'nl', NULL),
(546, 'ru', NULL),
(546, 'ua', NULL),
(547, 'en', ''),
(547, 'nl', NULL),
(547, 'ru', 'Профиль'),
(547, 'ua', 'Профіль'),
(548, 'en', ''),
(548, 'nl', NULL),
(548, 'ru', 'Пользователи'),
(548, 'ua', 'Користувачі'),
(549, 'en', ''),
(549, 'nl', NULL),
(549, 'ru', 'Данные продукта'),
(549, 'ua', 'Дані продукту'),
(550, 'en', ''),
(550, 'nl', NULL),
(550, 'ru', 'Бренды'),
(550, 'ua', 'Бренди'),
(551, 'en', ''),
(551, 'nl', NULL),
(551, 'ru', 'Логин'),
(551, 'ua', 'Логін'),
(552, 'en', ''),
(552, 'nl', NULL),
(552, 'ru', 'Настройки'),
(552, 'ua', 'Налаштування'),
(553, 'en', ''),
(553, 'nl', NULL),
(553, 'ru', 'Шаблоны'),
(553, 'ua', 'Шаблони'),
(554, 'en', ''),
(554, 'nl', NULL),
(554, 'ru', 'Валюта'),
(554, 'ua', 'Валюта'),
(555, 'en', ''),
(555, 'nl', NULL),
(555, 'ru', 'Обновить'),
(555, 'ua', 'Оновити'),
(556, 'en', ''),
(556, 'nl', NULL),
(556, 'ru', 'Перевод'),
(556, 'ua', 'Переклад'),
(557, 'en', ''),
(557, 'nl', NULL),
(557, 'ru', 'Назад к списку'),
(557, 'ua', 'Назад до списку'),
(558, 'ru', 'Значение «{attribute}» должно быть равно «{compareValueOrAttribute}».'),
(558, 'ua', 'Значення "{attribute}" повинно бути рівним "{compareValueOrAttribute}".'),
(559, 'ru', 'Значение «{attribute}» должно быть больше значения «{compareValueOrAttribute}».'),
(559, 'ua', 'Значення "{attribute}" повинно бути більшим значення "{compareValueOrAttribute}".'),
(560, 'ru', 'Значение «{attribute}» должно быть больше или равно значения «{compareValueOrAttribute}».'),
(560, 'ua', 'Значення "{attribute}" повинно бути більшим або дорівнювати значенню "{compareValueOrAttribute}".'),
(561, 'ru', 'Значение «{attribute}» должно быть меньше значения «{compareValueOrAttribute}».'),
(561, 'ua', 'Значення "{attribute}" повинно бути меншим значення "{compareValueOrAttribute}".'),
(562, 'ru', 'Значение «{attribute}» должно быть меньше или равно значения «{compareValueOrAttribute}».'),
(562, 'ua', 'Значення "{attribute}" повинно бути меншим або дорівнювати значенню "{compareValueOrAttribute}".'),
(563, 'ru', 'Значение «{attribute}» не должно быть равно «{compareValueOrAttribute}».'),
(563, 'ua', 'Значення "{attribute}" не повинно бути рівним "{compareValueOrAttribute}".'),
(564, 'ru', 'Значение «{attribute}» содержит неверную маску подсети.'),
(564, 'ua', 'Значення «{attribute}» містить неправильну маску підмережі.'),
(565, 'ru', 'Значение «{attribute}» не входит в список разрешенных диапазонов адресов.'),
(565, 'ua', 'Значення «{attribute}» не входить в список дозволених діапазонів адрес.'),
(566, 'ru', 'Значение «{attribute}» должно быть правильным IP адресом.'),
(566, 'ua', 'Значення «{attribute}» повинно бути правильною IP адресою.'),
(567, 'ru', 'Значение «{attribute}» должно быть IP адресом с подсетью.'),
(567, 'ua', 'Значення «{attribute}» повинно бути IP адресою з підмережею.'),
(568, 'ru', 'Значение «{attribute}» не должно быть подсетью.'),
(568, 'ua', 'Значення «{attribute}» не повинно бути підмережею.'),
(569, 'ru', 'Значение «{attribute}» не должно быть IPv4 адресом.'),
(569, 'ua', 'Значення «{attribute}» не повинно бути IPv4 адресою.'),
(570, 'ru', 'Значение «{attribute}» не должно быть IPv6 адресом.'),
(570, 'ua', 'Значення «{attribute}» не повинно бути IPv6 адресою.'),
(571, 'ru', '{delta, plural, one{# день} few{# дня} many{# дней} other{# дней}}'),
(571, 'ua', '{delta, plural, one{# день} few{# дні} many{# днів} other{# днів}}'),
(572, 'ru', '{delta, plural, one{# час} few{# часа} many{# часов} other{# часов}}'),
(572, 'ua', '{delta, plural, one{# година} few{# години} many{# годин} other{# годин}}'),
(573, 'ru', '{delta, plural, one{# минута} few{# минуты} many{# минут} other{# минут}}'),
(573, 'ua', '{delta, plural, one{# хвилина} few{# хвилини} many{# хвилин} other{# хвилин}}'),
(574, 'ru', '{delta, plural, one{# месяц} few{# месяца} many{# месяцев} other{# месяцев}}'),
(574, 'ua', '{delta, plural, one{# місяць} few{# місяця} many{# місяців} other{# місяців}}'),
(575, 'ru', '{delta, plural, one{# секунда} few{# секунды} many{# секунд} other{# секунд}}'),
(575, 'ua', '{delta, plural, one{# секунда} few{# секунди} many{# секунд} other{# секунд}}'),
(576, 'ru', '{delta, plural, one{# год} few{# года} many{# лет} other{# лет}}'),
(576, 'ua', '{delta, plural, one{# рік} few{# роки} many{# років} other{# років}}'),
(577, 'en', ''),
(577, 'ru', 'Обновлено'),
(577, 'ua', 'Оновлено'),
(578, 'en', ''),
(578, 'ru', 'Создать'),
(578, 'ua', 'Створити'),
(579, 'en', ''),
(579, 'ru', 'Пользователь'),
(579, 'ua', 'Користувач'),
(579, 'uk', NULL),
(580, 'en', ''),
(580, 'ru', 'Имя пользователя'),
(580, 'ua', 'Ім''я користувача'),
(581, 'en', NULL),
(581, 'ru', NULL),
(581, 'ua', NULL),
(581, 'uk', NULL),
(582, 'en', NULL),
(582, 'ru', NULL),
(582, 'ua', NULL),
(583, 'en', NULL),
(583, 'ru', NULL),
(583, 'ua', NULL),
(584, 'en', NULL),
(584, 'ru', NULL),
(584, 'ua', NULL),
(585, 'en', ''),
(585, 'ru', 'Создан'),
(585, 'ua', 'Створений'),
(585, 'uk', NULL),
(586, 'en', ''),
(586, 'ru', 'Обновлен'),
(586, 'ua', 'Оновлений'),
(586, 'uk', NULL),
(587, 'en', NULL),
(587, 'ru', NULL),
(587, 'ua', NULL),
(588, 'en', ''),
(588, 'ru', 'Новый пароль'),
(588, 'ua', 'Новий пароль'),
(589, 'en', ''),
(589, 'ru', 'Новый пароль (повторение)'),
(589, 'ua', 'Новий пароль (повторення)'),
(590, 'en', ''),
(590, 'ru', 'Роль'),
(590, 'ua', 'Роль'),
(591, 'en', 'Delete'),
(591, 'ru', 'Удалить'),
(591, 'ua', 'Видалити'),
(592, 'en', ''),
(592, 'ru', 'Вы уверены, что хотите удалить эту запись?'),
(592, 'ua', 'Ви впевнені, що хочете видалити цей запис?'),
(593, 'en', ''),
(593, 'ru', 'Роли'),
(593, 'ua', 'Ролі'),
(594, 'en', ''),
(594, 'ru', 'Бренд'),
(594, 'ua', 'Бренд'),
(595, 'en', ''),
(595, 'ru', 'Название'),
(595, 'ua', 'Назва'),
(596, 'en', ''),
(596, 'ru', 'Создать'),
(596, 'ua', 'Створити'),
(597, 'en', ''),
(597, 'ru', 'Шаблон'),
(597, 'ua', 'Шаблон'),
(598, 'en', ''),
(598, 'ru', 'Алиас'),
(598, 'ua', 'Аліас'),
(599, 'en', ''),
(599, 'ru', 'Текст'),
(599, 'ua', 'Текст'),
(600, 'en', ''),
(600, 'ru', 'Валюты'),
(600, 'ua', 'Валюти'),
(601, 'en', ''),
(601, 'ru', 'По умлочанию'),
(601, 'ua', 'За замовченням'),
(602, 'en', ''),
(602, 'ru', 'Нет'),
(602, 'ua', 'Ні'),
(603, 'en', ''),
(603, 'ru', 'Да'),
(603, 'ua', 'Так'),
(604, 'en', NULL),
(604, 'ru', NULL),
(604, 'ua', NULL),
(605, 'en', ''),
(605, 'ru', 'Вход'),
(605, 'ua', 'Вхід'),
(606, 'en', ''),
(606, 'ru', 'Логин'),
(606, 'ua', 'Логін'),
(606, 'uk', NULL),
(607, 'en', ''),
(607, 'ru', 'Войдите для начала Вашей сессии'),
(607, 'ua', 'Ввійдіть для початку Вашої сесії'),
(608, 'en', 'Sign out'),
(608, 'ru', 'Выход'),
(608, 'ua', 'Вихід'),
(609, 'en', 'Enabled'),
(609, 'ru', 'Включено'),
(609, 'ua', 'Ввімкнено'),
(610, 'en', NULL),
(610, 'ru', NULL),
(610, 'ua', NULL),
(611, 'en', NULL),
(611, 'ru', NULL),
(611, 'ua', NULL),
(612, 'en', NULL),
(612, 'ru', NULL),
(612, 'ua', NULL),
(613, 'en', NULL),
(613, 'ru', NULL),
(613, 'ua', NULL),
(614, 'en', NULL),
(614, 'ru', NULL),
(614, 'ua', NULL),
(615, 'en', NULL),
(615, 'ru', NULL),
(615, 'ua', NULL),
(616, 'en', NULL),
(616, 'ru', NULL),
(616, 'ua', NULL),
(617, 'en', NULL),
(617, 'ru', NULL),
(617, 'ua', NULL),
(618, 'en', NULL),
(618, 'ru', NULL),
(618, 'ua', NULL),
(619, 'en', ''),
(619, 'ru', 'Сохранить'),
(619, 'ua', 'Зберегти'),
(620, 'en', ''),
(620, 'ru', 'Операция проведена успешно.'),
(620, 'ua', 'Операція проведена успішно.'),
(621, 'en', NULL),
(621, 'ru', NULL),
(621, 'ua', NULL),
(622, 'en', NULL),
(622, 'ru', NULL),
(622, 'ua', NULL),
(623, 'en', NULL),
(623, 'ru', NULL),
(623, 'ua', NULL),
(624, 'en', NULL),
(624, 'ru', NULL),
(624, 'ua', NULL),
(625, 'en', NULL),
(625, 'ru', NULL),
(625, 'ua', NULL),
(626, 'en', NULL),
(626, 'ru', NULL),
(626, 'ua', NULL),
(627, 'en', ''),
(627, 'ru', 'Записи'),
(627, 'ua', 'Записи'),
(628, 'en', ''),
(628, 'ru', 'Запись'),
(628, 'ua', 'Запис'),
(629, 'en', NULL),
(629, 'ru', NULL),
(629, 'ua', NULL),
(630, 'en', NULL),
(630, 'ru', NULL),
(630, 'ua', NULL),
(631, 'en', NULL),
(631, 'ru', NULL),
(631, 'ua', NULL),
(632, 'en', NULL),
(632, 'ru', NULL),
(632, 'ua', NULL),
(633, 'en', ''),
(633, 'ru', 'Страна'),
(633, 'ua', 'Країна'),
(633, 'uk', NULL),
(634, 'en', ''),
(634, 'ru', 'Населенный пункт'),
(634, 'ua', 'Населений пункт'),
(634, 'uk', NULL),
(635, 'en', ''),
(635, 'ru', 'Улица'),
(635, 'ua', 'Вулиця'),
(635, 'uk', NULL),
(636, 'en', ''),
(636, 'ru', 'Почтовый индекс'),
(636, 'ua', 'Поштовий індекс'),
(636, 'uk', NULL),
(637, 'en', NULL),
(637, 'ru', NULL),
(637, 'ua', NULL),
(638, 'en', NULL),
(638, 'ru', NULL),
(638, 'ua', NULL),
(639, 'en', NULL),
(639, 'ru', NULL),
(639, 'ua', NULL),
(640, 'en', NULL),
(640, 'ru', NULL),
(640, 'ua', NULL),
(641, 'en', NULL),
(641, 'ru', NULL),
(641, 'ua', NULL),
(642, 'en', NULL),
(642, 'ru', NULL),
(642, 'ua', NULL),
(643, 'en', NULL),
(643, 'ru', NULL),
(643, 'ua', NULL),
(644, 'en', NULL),
(644, 'ru', NULL),
(644, 'ua', NULL),
(645, 'en', NULL),
(645, 'ru', NULL),
(645, 'ua', NULL),
(646, 'en', NULL),
(646, 'ru', NULL),
(646, 'ua', NULL),
(647, 'en', NULL),
(647, 'ru', NULL),
(647, 'ua', NULL),
(648, 'en', 'Date registrated'),
(648, 'ru', 'Дата регистрации'),
(648, 'ua', 'Дата реєстрації'),
(649, 'en', NULL),
(649, 'ru', NULL),
(649, 'ua', NULL),
(650, 'en', NULL),
(650, 'ru', NULL),
(650, 'ua', NULL),
(651, 'en', NULL),
(651, 'ru', NULL),
(651, 'ua', NULL),
(652, 'en', NULL),
(652, 'ru', NULL),
(652, 'ua', NULL),
(653, 'en', NULL),
(653, 'ru', NULL),
(653, 'ua', NULL),
(654, 'en', NULL),
(654, 'ru', NULL),
(654, 'ua', NULL),
(655, 'en', NULL),
(655, 'ru', NULL),
(655, 'ua', NULL),
(656, 'en', NULL),
(656, 'ru', NULL),
(656, 'ua', NULL),
(657, 'en', NULL),
(657, 'ru', NULL),
(657, 'ua', NULL),
(658, 'en', 'Title'),
(658, 'ru', 'Заголовок'),
(658, 'ua', 'Заголовок'),
(659, 'en', 'Content'),
(659, 'ru', 'Контент'),
(659, 'ua', 'Контент'),
(660, 'en', 'Sort'),
(660, 'ru', 'Порядок'),
(660, 'ua', 'Порядок'),
(661, 'en', ''),
(661, 'ru', 'Родительський элемент'),
(661, 'ua', 'Батьківський елемент'),
(662, 'en', ''),
(662, 'ru', 'Тип сущности'),
(662, 'ua', 'Тип сутності'),
(663, 'en', ''),
(663, 'ru', 'Сущность'),
(663, 'ua', 'Сутність'),
(664, 'en', ''),
(664, 'ru', 'Введите URL вручную:'),
(664, 'ua', 'Введіть URL власноруч:'),
(665, 'en', 'Sort action'),
(665, 'ru', 'Сортировать'),
(665, 'ua', 'Сортувати'),
(666, 'en', ''),
(666, 'ru', 'Социальные сети'),
(666, 'ua', 'Соціальні мережі'),
(667, 'en', ''),
(667, 'ru', 'Социальная сеть'),
(667, 'ua', 'Соціальна мережа'),
(668, 'en', 'Page not found'),
(668, 'ru', 'Страница не найдена'),
(668, 'ua', 'Сторінку не знайдено'),
(669, 'en', ''),
(669, 'ru', 'Ошибка случилась в результате обработки Вашего запроса. '),
(669, 'ua', 'Помилка сталася в результаті обробки Вашого запиту.'),
(670, 'en', ''),
(670, 'ru', 'Напишите нам, если Вы думаете, что это серверная ошибка. Спасибо.'),
(670, 'ua', 'Напишіть нам, якщо Ви вважаєте, що це серверна помилка. Дякуємо.'),
(671, 'en', ''),
(671, 'ru', 'Склады'),
(671, 'ua', 'Склади'),
(672, 'en', ''),
(672, 'ru', 'Склад'),
(672, 'ua', 'Склад'),
(673, 'en', ''),
(673, 'ru', 'Где купить'),
(673, 'ua', 'Де купити'),
(674, 'en', ''),
(674, 'ru', 'Напишите нам'),
(674, 'ua', 'Напишіть нам'),
(675, 'en', ''),
(675, 'ru', 'Ваше имя'),
(675, 'ua', 'Ваше ім''я'),
(676, 'en', ''),
(676, 'ru', 'Ваш email'),
(676, 'ua', 'Ваш email'),
(677, 'en', ''),
(677, 'ru', 'Ваше сообщение'),
(677, 'ua', 'Ваше повідомлення'),
(678, 'en', ''),
(678, 'ru', 'Отправить'),
(678, 'ua', 'Відправити'),
(679, 'en', ''),
(679, 'ru', 'Адресат'),
(679, 'ua', 'Адресат'),
(680, 'en', ''),
(680, 'ru', 'Отправитель'),
(680, 'ua', 'Відправник'),
(681, 'en', ''),
(681, 'ru', 'Тема'),
(681, 'ua', 'Тема'),
(682, 'en', ''),
(682, 'ru', 'Настройки контактной формы'),
(682, 'ua', 'Налаштування контактної форми'),
(683, 'en', ''),
(683, 'ru', 'Контактная форма'),
(683, 'ua', 'Контактна форма'),
(684, 'en', ''),
(684, 'ru', 'Настройка контактной формы'),
(684, 'ua', 'Налаштування контактної форми'),
(685, 'en', ''),
(685, 'ru', 'Ваше сообщение успешно отправлено. Спасибо.'),
(685, 'ua', 'Ваше повідомлення успішно відправлене. Дякуємо.'),
(686, 'en', ''),
(686, 'ru', 'Слайдеры'),
(686, 'ua', 'Слайдери'),
(687, 'en', ''),
(687, 'ru', 'Слайдер'),
(687, 'ua', 'Слайдер'),
(688, 'en', ''),
(688, 'ru', 'Изображения'),
(688, 'ua', 'Зображення'),
(689, 'en', ''),
(689, 'ru', 'Изображение'),
(689, 'ua', 'Зображення'),
(690, 'en', NULL),
(690, 'ru', NULL),
(690, 'ua', NULL),
(691, 'en', NULL),
(691, 'ru', NULL),
(691, 'ua', NULL),
(692, 'en', ''),
(692, 'ru', 'Главная страница'),
(692, 'ua', 'Головна сторінка'),
(693, 'en', ''),
(693, 'ru', 'Родительская категория'),
(693, 'ua', 'Батьківська категорія'),
(694, 'en', ''),
(694, 'ru', 'Категории'),
(694, 'ua', 'Категорії'),
(695, 'en', ''),
(695, 'ru', 'Магазин'),
(695, 'ua', 'Магазин'),
(696, 'en', ''),
(696, 'ru', 'Группы характеристик'),
(696, 'ua', 'Групи характеристик'),
(697, 'en', ''),
(697, 'ru', 'Группа характеристик'),
(697, 'ua', 'Група характеристик'),
(698, 'en', ''),
(698, 'ru', 'Характеристики'),
(698, 'ua', 'Характеристики'),
(699, 'en', ''),
(699, 'ru', 'Характеристика'),
(699, 'ua', 'Характеристика'),
(700, 'en', ''),
(700, 'ru', 'Артикул'),
(700, 'ua', 'Артикул'),
(701, 'en', ''),
(701, 'ru', 'Цена'),
(701, 'ua', 'Ціна'),
(702, 'en', ''),
(702, 'ru', 'На складе'),
(702, 'ua', 'На складі'),
(703, 'en', ''),
(703, 'ru', 'Товары'),
(703, 'ua', 'Товари'),
(704, 'en', ''),
(704, 'ru', 'Товар'),
(704, 'ua', 'Товар'),
(704, 'uk', NULL),
(705, 'en', ''),
(705, 'ru', 'Выберите'),
(705, 'ua', 'Виберіть'),
(706, 'en', ''),
(706, 'ru', 'Простой товар'),
(706, 'ua', 'Простий товар'),
(707, 'en', ''),
(707, 'ru', 'Вариативный продукт'),
(707, 'ua', 'Варіативний продукт'),
(708, 'en', ''),
(708, 'ru', 'Тип'),
(708, 'ua', 'Тип'),
(709, 'en', ''),
(709, 'ru', 'Вариации'),
(709, 'ua', 'Варіації'),
(710, 'en', NULL),
(710, 'ru', NULL),
(710, 'ua', NULL),
(711, 'en', ''),
(711, 'ru', 'Галерея'),
(711, 'ua', 'Галерея'),
(712, 'en', ''),
(712, 'ru', 'Категории товаров'),
(712, 'ua', 'Категорії товарів'),
(713, 'en', ''),
(713, 'ru', 'Фильтр'),
(713, 'ua', 'Фільтр'),
(714, 'en', ''),
(714, 'ru', 'Категории товаров'),
(714, 'ua', 'Категорії товарів'),
(715, 'en', ''),
(715, 'ru', 'Просмотреть'),
(715, 'ua', 'Переглянути'),
(716, 'en', ''),
(716, 'ru', 'Нет в наличии'),
(716, 'ua', 'Немає в наявності'),
(717, 'en', ''),
(717, 'ru', 'Типы меню'),
(717, 'ua', 'Типи меню'),
(718, 'en', ''),
(718, 'ru', 'Тип меню'),
(718, 'ua', 'Тип меню'),
(719, 'en', ''),
(719, 'ru', 'Полезная информация'),
(719, 'ua', 'Корисна інформація'),
(719, 'uk', NULL),
(720, 'en', 'Clear'),
(720, 'ru', 'Очистить'),
(720, 'ua', 'Очистити'),
(721, 'en', 'result(s)'),
(721, 'ru', 'результат(а)'),
(721, 'ua', 'результат(и)'),
(722, 'en', ''),
(722, 'ru', 'Количество товаров:'),
(722, 'ua', 'Кількість товарів:'),
(723, 'en', ''),
(723, 'ru', 'Цена по спаданию'),
(723, 'ua', 'Ціна за спаданням'),
(724, 'en', ''),
(724, 'ru', 'Цена по возрастанию'),
(724, 'ua', 'Ціна за зростанням'),
(725, 'en', ''),
(725, 'ru', 'Сортировать по'),
(725, 'ua', 'Сортувати по'),
(726, 'en', ''),
(726, 'ru', 'Краткое описание'),
(726, 'ua', 'Короткий опис'),
(727, 'en', ''),
(727, 'ru', 'Показывать после цены'),
(727, 'ua', 'Показувати після ціни'),
(728, 'en', ''),
(728, 'ru', 'Добавить в корзину'),
(728, 'ua', 'Додати до кошику'),
(729, 'en', ''),
(729, 'ru', 'Выберите размер'),
(729, 'ua', 'Оберіть розмір'),
(730, 'en', ''),
(730, 'ru', 'Количество'),
(730, 'ua', 'Кількість'),
(731, 'en', ''),
(731, 'ru', 'Необходимо выбрать размер'),
(731, 'ua', 'Необхідно обрати розмір'),
(732, 'en', ''),
(732, 'ru', 'Необходимо ввести количество'),
(732, 'ua', 'Необхідно ввести кількість'),
(733, 'en', ''),
(733, 'ru', 'Добавить к избранным'),
(733, 'ua', 'Додати до бажаних'),
(734, 'en', ''),
(734, 'ru', 'Вход в личный кабинет'),
(734, 'ua', 'Вхід в особистий кабінет'),
(735, 'en', ''),
(735, 'ru', 'Пароль'),
(735, 'ua', 'Пароль'),
(736, 'en', ''),
(736, 'ru', 'Запомнить меня'),
(736, 'ua', 'Запам''ятати мене'),
(737, 'en', ''),
(737, 'ru', 'Вход'),
(737, 'ua', 'Вхід'),
(738, 'en', NULL),
(738, 'ru', NULL),
(738, 'ua', NULL),
(739, 'en', ''),
(739, 'ru', 'Забыли пароль?'),
(739, 'ua', 'Забули пароль?'),
(740, 'en', ''),
(740, 'ru', 'Неверный логин или пароль.'),
(740, 'ua', 'Невірний логін чи пароль.'),
(741, 'en', ''),
(741, 'ru', 'Регистрация'),
(741, 'ua', 'Реєстрація'),
(741, 'uk', NULL),
(742, 'en', ''),
(742, 'ru', 'Этот логин уже используется.'),
(742, 'ua', 'Цей логін вже використовується.'),
(743, 'en', ''),
(743, 'ru', 'Этот email уже используется.'),
(743, 'ua', 'Цей email вже використовується.'),
(744, 'en', ''),
(744, 'ru', 'Я хочу получать новости от Jenadin'),
(744, 'ua', 'Я хочу отримувати новини від Jenadin'),
(745, 'en', ''),
(745, 'ru', 'Подписка'),
(745, 'ua', 'Підписка'),
(746, 'en', ''),
(746, 'ru', 'Оставайтесь с нами'),
(746, 'ua', 'Залишайтеся з нами'),
(746, 'uk', NULL),
(747, 'en', ''),
(747, 'ru', 'Подписаться на новости'),
(747, 'ua', 'Підписатися на новини'),
(747, 'uk', NULL),
(748, 'en', ''),
(748, 'ru', 'Новости'),
(748, 'ua', 'Новини'),
(749, 'en', ''),
(749, 'ru', 'Новость'),
(749, 'ua', 'Новини'),
(750, 'en', ''),
(750, 'ru', 'Вы уверены, что хотите разослать новость?'),
(750, 'ua', 'Ви впевнені, що хочете розіслати новину?'),
(751, 'en', ''),
(751, 'ru', 'Видео'),
(751, 'ua', 'Відео'),
(752, 'en', ''),
(752, 'ru', 'Удалить'),
(752, 'ua', 'Видалити'),
(753, 'en', ''),
(753, 'ru', 'Комплекты'),
(753, 'ua', 'Комплекти'),
(754, 'en', ''),
(754, 'ru', 'Комплект'),
(754, 'ua', 'Комплект'),
(755, 'en', NULL),
(755, 'ru', NULL),
(755, 'ua', NULL),
(756, 'en', ''),
(756, 'ru', 'Как носить'),
(756, 'ua', 'Як носити'),
(757, 'en', ''),
(757, 'ru', 'Вам также может понравиться'),
(757, 'ua', 'Вам також може сподобатися'),
(758, 'en', ''),
(758, 'ru', 'Корзина'),
(758, 'ua', 'Кошик'),
(758, 'uk', NULL),
(759, 'en', ''),
(759, 'ru', 'Продолжить покупки'),
(759, 'ua', 'Продовжити покупки'),
(760, 'en', ''),
(760, 'ru', 'Цена за товар:'),
(760, 'ua', 'Ціна за товар:'),
(761, 'en', ''),
(761, 'ru', 'Сумма:'),
(761, 'ua', 'Сума:'),
(762, 'en', ''),
(762, 'ru', 'Корзина успешно обновлена.'),
(762, 'ua', 'Кошик успішно оновлено.'),
(763, 'en', ''),
(763, 'ru', 'В корзине нет товаров.'),
(763, 'ua', 'У кошику немає товарів.'),
(764, 'en', ''),
(764, 'ru', 'Сумма в корзине'),
(764, 'ua', 'Сума в кошику'),
(765, 'en', ''),
(765, 'ru', 'Итого'),
(765, 'ua', 'Разом'),
(765, 'uk', NULL),
(766, 'en', ''),
(766, 'ru', 'Оформить заказ'),
(766, 'ua', 'Оформити замовлення'),
(767, 'en', NULL),
(767, 'ru', NULL),
(767, 'ua', NULL),
(768, 'en', ''),
(768, 'ru', 'Размера нет на складе.'),
(768, 'ua', 'Розміру немає на складі.'),
(769, 'en', ''),
(769, 'ru', 'Сброс пароля'),
(769, 'ua', 'Скидання пароля'),
(770, 'en', 'Please fill out your email. A link to reset password will be sent there.'),
(770, 'ru', 'Пожалуйста, введите email. Ссылка для сброса пароля будет отправлена на этот адрес.'),
(770, 'ua', 'Будь ласка, введіть email. Посилання для скидування паролю буде відправлене на цю адресу.'),
(771, 'en', ''),
(771, 'ru', 'Сброс пароля для Jenadin'),
(771, 'ua', 'Скидання пароля для Jenadin'),
(772, 'en', ''),
(772, 'ru', 'Привет'),
(772, 'ua', 'Привіт'),
(773, 'en', ''),
(773, 'ru', 'Следуйте за ссылкой ниже для сброса пароля.'),
(773, 'ua', 'Слідуйте за посиланням нижче для скидування пароля.'),
(774, 'en', ''),
(774, 'ru', 'Нет пользователя с таким email.'),
(774, 'ua', 'Немає користувача з таким email.'),
(775, 'en', ''),
(775, 'ru', 'Проверьте email для дальнейших инструкций.'),
(775, 'ua', 'Перевірте email для подальших інструкцій.'),
(776, 'en', ''),
(776, 'ru', 'Сбросить пароль'),
(776, 'ua', 'Скинуть пароль'),
(777, 'en', ''),
(777, 'ru', 'Пожалуйста, выберите новый пароль:'),
(777, 'ua', 'Будь ласка, виберіть новий пароль:'),
(778, 'en', ''),
(778, 'ru', 'Новый пароль был сохранен.'),
(778, 'ua', 'Новий пароль був збережений.'),
(779, 'en', 'Hello, %s. (%s). From your account dashboard you can view your recent orders, manage your shipping and billing addresses and edit your password and account details.'),
(779, 'ru', 'Здравствуйте, %s (%s). В консоли вашего аккаунта вы можете просматривать недавние заказы, настроить адрес доставки и реквизиты оплаты, а также изменить пароль и анкету.'),
(779, 'ua', 'Привіт %s. (%s). В консолі Вашого акаунту Ви можете переглядати замовлення, налаштувати адресу доставки та реквізити оплати, а також змінити пароль і анкету.'),
(780, 'en', ''),
(780, 'ru', 'Выход'),
(780, 'ua', 'Вихід'),
(781, 'en', ''),
(781, 'ru', 'Детали профиля'),
(781, 'ua', 'Деталі профіля'),
(782, 'en', ''),
(782, 'ru', 'Адрес'),
(782, 'ua', 'Адреса'),
(783, 'en', ''),
(783, 'ru', 'Просмотр или редактирование даных пользователя.'),
(783, 'ua', 'Перегляд чи редагування даних користувача.'),
(784, 'en', ''),
(784, 'ru', 'Редактирование даных о адресе.'),
(784, 'ua', 'Редагування даних про адресу.'),
(785, 'en', ''),
(785, 'ru', 'Избранное'),
(785, 'ua', 'Вибране'),
(785, 'uk', NULL),
(786, 'en', ''),
(786, 'ru', 'Заказы'),
(786, 'ua', 'Замовлення'),
(787, 'en', ''),
(787, 'ru', 'Просмотр истории заказов.'),
(787, 'ua', 'Перегляд історії замовлень.'),
(788, 'en', ''),
(788, 'ru', 'Просмотр избранных товаров.'),
(788, 'ua', 'Перегляд вибраних товарів.'),
(789, 'en', ''),
(789, 'ru', 'Назад к просмотру профиля'),
(789, 'ua', 'Назад до перегляду профілю'),
(790, 'en', ''),
(790, 'ru', 'Профиль успешно обновлен.'),
(790, 'ua', 'Профіль успішно оновлений.'),
(791, 'en', ''),
(791, 'ru', 'Адрес'),
(791, 'ua', 'Адреса'),
(791, 'uk', NULL),
(792, 'en', ''),
(792, 'ru', 'Имя'),
(792, 'ua', 'Ім''я'),
(792, 'uk', NULL),
(793, 'en', ''),
(793, 'ru', 'Фамилия'),
(793, 'ua', 'Прізвище'),
(793, 'uk', NULL),
(794, 'en', ''),
(794, 'ru', 'Телефон'),
(794, 'ua', 'Телефон'),
(794, 'uk', NULL),
(795, 'en', ''),
(795, 'ru', 'Область'),
(795, 'ua', 'Область'),
(795, 'uk', NULL),
(796, 'en', ''),
(796, 'ru', 'Дом'),
(796, 'ua', 'Будинок'),
(796, 'uk', NULL),
(797, 'en', ''),
(797, 'ru', 'Квартира'),
(797, 'ua', 'Квартира'),
(797, 'uk', NULL),
(798, 'en', ''),
(798, 'ru', 'Адрес успешно обновлен.'),
(798, 'ua', 'Адреса успішно оновлена.'),
(799, 'en', ''),
(799, 'ru', 'Товар был успешно удален с избранных.'),
(799, 'ua', 'Товар був успішно видалений з вибраних.'),
(800, 'en', 'There is no product in your wish list.'),
(800, 'ru', 'В списке избранных нет товаров.'),
(800, 'ua', 'У списку вибраних немає товарів.'),
(801, 'en', ''),
(801, 'ru', 'Примечание'),
(801, 'ua', 'Замітка'),
(801, 'uk', NULL),
(802, 'en', ''),
(802, 'ru', 'Тип платежа'),
(802, 'ua', 'Тип платежу'),
(802, 'uk', NULL),
(803, 'en', ''),
(803, 'ru', 'Заказ'),
(803, 'ua', 'Замовлення'),
(804, 'en', ''),
(804, 'ru', 'Оформление заказа'),
(804, 'ua', 'Оформлення замовлення'),
(804, 'uk', NULL),
(805, 'en', ''),
(805, 'ru', 'Детали оплаты'),
(805, 'ua', 'Деталі замовлення'),
(805, 'uk', NULL),
(806, 'en', ''),
(806, 'ru', 'Ваш заказ'),
(806, 'ua', 'Ваше замовлення'),
(806, 'uk', NULL),
(807, 'en', ''),
(807, 'ru', 'Общая цена'),
(807, 'ua', 'Загальна ціна'),
(807, 'uk', NULL),
(808, 'en', ''),
(808, 'ru', 'Типы платежа'),
(808, 'ua', 'Типи платежу'),
(809, 'en', ''),
(809, 'ru', 'Разместить заказ'),
(809, 'ua', 'Розмістити замовлення'),
(809, 'uk', NULL),
(810, 'en', ''),
(810, 'ru', 'Получатели'),
(810, 'ua', 'Отримувачі'),
(811, 'en', ''),
(811, 'ru', 'Тема письма'),
(811, 'ua', 'Тема листа'),
(812, 'en', ''),
(812, 'ru', 'Шаблоны писем'),
(812, 'ua', 'Шаблони листів'),
(813, 'en', ''),
(813, 'ru', 'Шаблон письма'),
(813, 'ua', 'Шаблон листа'),
(814, 'en', ''),
(814, 'ru', 'Просмотр письма'),
(814, 'ua', 'Перегляд листа'),
(815, 'en', NULL),
(815, 'ru', NULL),
(815, 'ua', NULL),
(816, 'en', ''),
(816, 'ru', 'Имя "От кого"'),
(816, 'ua', 'Ім''я "Від кого"'),
(817, 'en', ''),
(817, 'ru', 'Адрес отправителя'),
(817, 'ua', 'Адреса відправника'),
(818, 'en', NULL),
(818, 'ru', NULL),
(818, 'ua', NULL),
(819, 'en', ''),
(819, 'ru', 'Настройки email'),
(819, 'ua', 'Налаштування email'),
(820, 'en', ''),
(820, 'ru', 'Настройка email'),
(820, 'ua', 'Налаштування email'),
(821, 'en', 'You have received an order from %s %s. The order is as follows:'),
(821, 'ru', 'Вы получили заказ от %s %s. Детали заказа:'),
(821, 'ua', 'Ви отримали замовлення від %s %s. Деталі замовлення:'),
(822, 'en', ''),
(822, 'ru', 'Информация о клиенте'),
(822, 'ua', 'Інформація про клієнта'),
(823, 'en', ''),
(823, 'ru', 'Спасибо!'),
(823, 'ua', 'Дякуємо!'),
(824, 'en', ''),
(824, 'ru', 'Ваш заказ принят!'),
(824, 'ua', 'Ваше замовлення прийняте!'),
(825, 'en', ''),
(825, 'ru', 'Наш менеджер свяжется с вами'),
(825, 'ua', 'Наш менеджер зв''яжеться з вами'),
(826, 'en', 'Hi there. Your recent order on Jenadin has been completed. Your order details are shown below for your reference:'),
(826, 'ru', 'Здравствуйте. Ваш недавний заказ от Jenadin был выполнен. Информация о заказе предоставлена ниже для вашего удобства:'),
(826, 'ua', 'Привіт. Ваше нещодавнє замовлення від Jenadin було завершено. Деталі Вашого замовлення, наведені нижче для вашої довідки:'),
(827, 'en', ''),
(827, 'ru', 'Ваш заказ успешно принят!'),
(827, 'ua', 'Ваше замовлення успішно прийняте!'),
(828, 'en', ''),
(828, 'ru', 'Номер'),
(828, 'ua', 'Номер'),
(829, 'en', ''),
(829, 'ru', 'В обработке'),
(829, 'ua', 'В обробці'),
(830, 'en', ''),
(830, 'ru', 'Оплачен'),
(830, 'ua', 'Оплачений'),
(831, 'en', ''),
(831, 'ru', 'Отказан'),
(831, 'ua', 'Відмовлений'),
(832, 'en', ''),
(832, 'ru', 'Ничего не выбрано'),
(832, 'ua', 'Нічого не вибрано'),
(833, 'en', ''),
(833, 'ru', 'Позиции'),
(833, 'ua', 'Позиції'),
(834, 'en', ''),
(834, 'ru', 'Ваша корзина пуста.'),
(834, 'ua', 'Ваш кошик пустий.'),
(835, 'en', ''),
(835, 'ru', 'Открыть меню'),
(835, 'ua', 'Відкрити меню'),
(835, 'uk', NULL),
(836, 'en', ''),
(836, 'ru', 'Поиск'),
(836, 'ua', 'Пошук'),
(836, 'uk', NULL),
(837, 'en', ''),
(837, 'ru', 'Назад'),
(837, 'ua', 'Назад'),
(837, 'uk', NULL),
(838, 'en', ''),
(838, 'ru', 'Мой кабинет'),
(838, 'ua', 'Мій кабінет'),
(838, 'uk', NULL),
(839, 'en', NULL),
(839, 'ru', NULL),
(839, 'ua', NULL),
(840, 'en', NULL),
(840, 'ru', NULL),
(840, 'ua', NULL),
(841, 'en', '');
INSERT INTO `message` (`id`, `language`, `translation`) VALUES
(841, 'ru', 'Процент, %'),
(841, 'ua', 'Відсоток, %'),
(842, 'en', ''),
(842, 'ru', 'Акции'),
(842, 'ua', 'Акції'),
(843, 'en', ''),
(843, 'ru', 'Акция'),
(843, 'ua', 'Акція'),
(844, 'en', ''),
(844, 'ru', 'Загрузить товары с коллекции:'),
(844, 'ua', 'Завантажити товари з колеції:'),
(845, 'en', NULL),
(845, 'ru', 'Вы уверены, что хотите добавить выбраную коллекцию?'),
(845, 'ua', 'Ви впевнені, що хочете додати обрану колекцію?'),
(846, 'en', 'Sale'),
(846, 'ru', 'Распродажа'),
(846, 'ua', 'Розпродаж'),
(847, 'en', ''),
(847, 'ru', 'Новинка'),
(847, 'ua', 'Новинка'),
(848, 'en', 'Novelties'),
(848, 'ru', 'Новинки'),
(848, 'ua', 'Новинки'),
(849, 'en', 'Novelty'),
(849, 'ru', 'Новинка'),
(849, 'ua', 'Новинка'),
(850, 'en', ''),
(850, 'ru', 'Размер и характеристики'),
(850, 'ua', 'Розмір і характеристики'),
(851, 'en', ''),
(851, 'ru', 'Примечания производителя'),
(851, 'ua', 'Замітки виробника'),
(852, 'en', ''),
(852, 'ru', 'Иконка'),
(852, 'ua', 'Іконка'),
(853, 'en', ''),
(853, 'ru', 'Таблица размеров'),
(853, 'ua', 'Таблиця розмірів'),
(854, 'en', 'Basket'),
(854, 'ru', 'Корзина'),
(854, 'ua', 'Кошик'),
(855, 'en', 'You have added the product to the basket:'),
(855, 'ru', 'Вы добавили товар в корзину:'),
(855, 'ua', 'Ви додали товар у кошик:'),
(856, 'en', ''),
(856, 'ru', 'Успешно добавлено'),
(856, 'ua', 'Успішно додано'),
(857, 'en', ''),
(857, 'ru', 'В ожидании оплаты'),
(857, 'ua', 'В очікуванні оплати'),
(858, 'en', 'Congratulations! You have placed your order. Below is the link to proceed the payment.'),
(858, 'ru', 'Поздравляем! Вы разместили заказ. Ниже ссылка для оплаты заказа.'),
(858, 'ua', 'Вітаємо! Ви розмістили своє замовлення. Нижче посилання для оплати замовлення. '),
(859, 'en', ''),
(859, 'ru', 'Результаты поиска:'),
(859, 'ua', 'Результати пошуку:'),
(860, 'en', NULL),
(860, 'ru', NULL),
(860, 'ua', NULL),
(861, 'en', ''),
(861, 'ru', 'Нет результатов, задовольняющих запрос:'),
(861, 'ua', 'Немає результатів, які задовольняють запит:'),
(862, 'en', ''),
(862, 'ru', 'Журналы'),
(862, 'ua', 'Журнали'),
(863, 'en', ''),
(863, 'ru', 'Журнал'),
(863, 'ua', 'Журнал'),
(864, 'en', ''),
(864, 'ru', 'Страницы'),
(864, 'ua', 'Сторінки'),
(865, 'en', ''),
(865, 'ru', 'Дата заказа'),
(865, 'ua', 'Дата замовлення'),
(866, 'en', NULL),
(866, 'ru', NULL),
(866, 'ua', NULL),
(867, 'en', ''),
(867, 'ru', 'Персональные данные'),
(867, 'ua', 'Персональні дані'),
(868, 'en', ''),
(868, 'ru', 'Данные о заказе'),
(868, 'ua', 'Дані замовлення'),
(869, 'en', ''),
(869, 'ru', 'Назад к списку заказов'),
(869, 'ua', 'Назад до списку замовлень'),
(870, 'en', 'Nothing was found.'),
(870, 'ru', 'Ничего не найдено.'),
(870, 'ua', 'Нічого не знайдено.'),
(871, 'en', ''),
(871, 'ru', 'SEO описание для категории товара'),
(871, 'ua', 'SEO опис для категорії товару'),
(872, 'en', NULL),
(872, 'ru', NULL),
(872, 'ua', NULL),
(873, 'en', NULL),
(873, 'ru', NULL),
(873, 'ua', NULL),
(874, 'en', NULL),
(874, 'ru', NULL),
(874, 'ua', NULL),
(875, 'en', NULL),
(875, 'ru', NULL),
(875, 'ua', NULL),
(876, 'en', NULL),
(876, 'ru', NULL),
(876, 'ua', NULL),
(877, 'en', NULL),
(877, 'ru', NULL),
(877, 'ua', NULL),
(878, 'en', 'You have added the product to the basket:'),
(878, 'ru', 'Вы добавили товар в корзину:'),
(878, 'ua', 'Ви додали товар у кошик:'),
(879, 'en', NULL),
(879, 'ru', NULL),
(879, 'ua', NULL),
(880, 'en', NULL),
(880, 'ru', NULL),
(880, 'ua', NULL),
(881, 'en', NULL),
(881, 'ru', NULL),
(881, 'ua', NULL),
(882, 'en', NULL),
(882, 'ru', NULL),
(882, 'ua', NULL),
(883, 'en', ''),
(883, 'ru', 'Пациенты'),
(883, 'ua', 'Пацієнти'),
(884, 'en', ''),
(884, 'ru', 'Пациент'),
(884, 'ua', 'Пацієнт'),
(885, 'en', ''),
(885, 'ru', 'Значение'),
(885, 'ua', 'Значення'),
(886, 'en', NULL),
(886, 'ru', NULL),
(886, 'ua', NULL),
(887, 'en', ''),
(887, 'ru', 'Начальное время'),
(887, 'ua', 'Початковий час'),
(888, 'en', ''),
(888, 'ru', 'Конечное время'),
(888, 'ua', 'Кінцевий час'),
(889, 'en', ''),
(889, 'ru', 'Построить график'),
(889, 'ua', 'Побудувати графік'),
(890, 'en', ''),
(890, 'ru', 'Печать'),
(890, 'ua', 'Друк'),
(891, 'en', 'Pulse'),
(891, 'ru', 'Пульс'),
(891, 'ua', 'Пульс'),
(892, 'en', ''),
(892, 'ru', 'Пол'),
(892, 'ua', 'Стать'),
(893, 'en', ''),
(893, 'ru', 'Возраст'),
(893, 'ua', 'Вік'),
(894, 'en', ''),
(894, 'ru', 'Таблица ЧСС'),
(894, 'ua', 'Таблиця ЧСС'),
(895, 'en', ''),
(895, 'ru', 'Мин. возраст'),
(895, 'ua', 'Мін. вік'),
(896, 'en', ''),
(896, 'ru', 'Макс. возраст'),
(896, 'ua', 'Макс. вік'),
(897, 'en', ''),
(897, 'ru', 'Мин. количество ударов'),
(897, 'ua', 'Мін. кількість ударів'),
(898, 'en', ''),
(898, 'ru', 'Макс. количество ударов'),
(898, 'ua', 'Макс. кількість ударів'),
(899, 'en', NULL),
(899, 'ru', NULL),
(899, 'ua', NULL),
(900, 'en', ''),
(900, 'ru', 'Операторы'),
(900, 'ua', 'Оператори'),
(901, 'en', NULL),
(901, 'ru', NULL),
(901, 'ua', NULL),
(902, 'en', ''),
(902, 'ru', 'Опасный пульс:'),
(902, 'ua', 'Небезпечний пульс:');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1455877224),
('m130524_201442_init', 1455877230),
('m140506_102106_rbac_init', 1457026314),
('m160220_100848_add_new_field_to_user', 1455963027),
('m160516_081703_lang', 1463386881),
('m160516_095736_lang_translations', 1463393919);

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `alias` varchar(255) NOT NULL,
  `template` varchar(20) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`id`, `created_at`, `updated_at`, `enabled`, `alias`, `template`, `default`) VALUES
(7, 1469967549, 1474908016, 1, 'contacts', 'content', 0),
(12, 1470297947, 1474639612, 1, 'about-us', 'content', 0),
(15, 1470398188, 1470401479, 1, 'main', 'content-main', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `postlang`
--

CREATE TABLE IF NOT EXISTS `postlang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `language` varchar(6) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Дамп данных таблицы `postlang`
--

INSERT INTO `postlang` (`id`, `post_id`, `language`, `title`, `content`) VALUES
(16, 7, 'en', 'Contacts', '<p>Контакти</p>'),
(17, 7, 'ru', 'Контакты', ''),
(18, 7, 'ua', 'Контакти', '<div class="vc_row wpb_row vc_row-fluid">\r\n<div class="contact-form wpb_column vc_column_container vc_col-sm-4">\r\n<div class="wpb_wrapper">\r\n<div class="wpb_text_column wpb_content_element  vc_custom_1457444242684">\r\n<div class="wpb_wrapper">\r\n<p>Контакти</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>'),
(31, 12, 'en', 'About us', '<p>Про нас</p>'),
(32, 12, 'ru', 'О нас', '<p>Про нас</p>'),
(33, 12, 'ua', 'Про нас', '<p>Про нас</p>'),
(40, 15, 'en', 'Main page', '<p>English</p>'),
(41, 15, 'ru', 'Главная страница', '<p>Русский</p>'),
(42, 15, 'ua', 'Головна сторінка', '<p>Українська</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `setting`
--

INSERT INTO `setting` (`id`, `phone`) VALUES
(1, '+ 38 (050) 984-34-32');

-- --------------------------------------------------------

--
-- Структура таблицы `settinglang`
--

CREATE TABLE IF NOT EXISTS `settinglang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_id` int(11) NOT NULL,
  `language` varchar(10) NOT NULL,
  `table_size` text NOT NULL,
  `seo_category_description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_id` (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `settinglang`
--

INSERT INTO `settinglang` (`id`, `setting_id`, `language`, `table_size`, `seo_category_description`) VALUES
(1, 1, 'en', '<table class="table-size" width="100%">\r\n<tbody>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;S</td>\r\n<td style="height: 13px;">&nbsp;M</td>\r\n<td style="height: 13px;">L&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;XL</td>\r\n<td style="height: 13px;">&nbsp;XXL</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td class="subtitle-cell" style="height: 13px;" colspan="6">FEMALE ROLL-NECK SWEATERS, JUMPERS</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Chest, cm&nbsp;</td>\r\n<td style="height: 13px;">86-94&nbsp;</td>\r\n<td style="height: 13px;">90-108</td>\r\n<td style="height: 13px;">94-102</td>\r\n<td style="height: 13px;">98-106</td>\r\n<td style="height: 13px;">102-108&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Waist, cm&nbsp;</td>\r\n<td style="height: 13px;">56-68</td>\r\n<td style="height: 13px;">64-72</td>\r\n<td style="height: 13px;">72-80&nbsp;</td>\r\n<td style="height: 13px;">80-88&nbsp;</td>\r\n<td style="height: 13px;">88-96&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Hip, cm&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n</tr>\r\n<tr class="row-offset" style="height: 13px;">\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td class="subtitle-cell" style="height: 13px;" colspan="6">FEMALE DRESSES, SKIRTS</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Chest, cm&nbsp;</td>\r\n<td style="height: 13px;">86&nbsp;</td>\r\n<td style="height: 13px;">90&nbsp;</td>\r\n<td style="height: 13px;">94&nbsp;</td>\r\n<td style="height: 13px;">98&nbsp;</td>\r\n<td style="height: 13px;">102&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Waist, cm&nbsp;</td>\r\n<td style="height: 13px;">68&nbsp;</td>\r\n<td style="height: 13px;">72&nbsp;</td>\r\n<td style="height: 13px;">76&nbsp;</td>\r\n<td style="height: 13px;">82&nbsp;</td>\r\n<td style="height: 13px;">90&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Hip, cm&nbsp;</td>\r\n<td style="height: 13px;">92&nbsp;</td>\r\n<td style="height: 13px;">96&nbsp;</td>\r\n<td style="height: 13px;">100&nbsp;</td>\r\n<td style="height: 13px;">108</td>\r\n<td style="height: 13px;">116&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'Top clothing online at Jenadin.com.ua. Wide variety of clothing:'),
(2, 1, 'ru', '<table class="table-size" width="100%">\r\n<tbody>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;S</td>\r\n<td style="height: 13px;">&nbsp;M</td>\r\n<td style="height: 13px;">L&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;XL</td>\r\n<td style="height: 13px;">&nbsp;XXL</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td class="subtitle-cell" style="height: 13px;" colspan="6">FEMALE ROLL-NECK SWEATERS, JUMPERS</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Chest, cm&nbsp;</td>\r\n<td style="height: 13px;">86-94&nbsp;</td>\r\n<td style="height: 13px;">90-108</td>\r\n<td style="height: 13px;">94-102</td>\r\n<td style="height: 13px;">98-106</td>\r\n<td style="height: 13px;">102-108&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Waist, cm&nbsp;</td>\r\n<td style="height: 13px;">56-68</td>\r\n<td style="height: 13px;">64-72</td>\r\n<td style="height: 13px;">72-80&nbsp;</td>\r\n<td style="height: 13px;">80-88&nbsp;</td>\r\n<td style="height: 13px;">88-96&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Hip, cm&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n</tr>\r\n<tr class="row-offset" style="height: 13px;">\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td class="subtitle-cell" style="height: 13px;" colspan="6">FEMALE DRESSES, SKIRTS</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Chest, cm&nbsp;</td>\r\n<td style="height: 13px;">86&nbsp;</td>\r\n<td style="height: 13px;">90&nbsp;</td>\r\n<td style="height: 13px;">94&nbsp;</td>\r\n<td style="height: 13px;">98&nbsp;</td>\r\n<td style="height: 13px;">102&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Waist, cm&nbsp;</td>\r\n<td style="height: 13px;">68&nbsp;</td>\r\n<td style="height: 13px;">72&nbsp;</td>\r\n<td style="height: 13px;">76&nbsp;</td>\r\n<td style="height: 13px;">82&nbsp;</td>\r\n<td style="height: 13px;">90&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Hip, cm&nbsp;</td>\r\n<td style="height: 13px;">92&nbsp;</td>\r\n<td style="height: 13px;">96&nbsp;</td>\r\n<td style="height: 13px;">100&nbsp;</td>\r\n<td style="height: 13px;">108</td>\r\n<td style="height: 13px;">116&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'Широкий выбор одежды он-лайн на Jenadin.com.ua. Ассортимент одежды:'),
(3, 1, 'ua', '<table class="table-size" width="100%">\r\n<tbody>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;S</td>\r\n<td style="height: 13px;">&nbsp;M</td>\r\n<td style="height: 13px;">L&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;XL</td>\r\n<td style="height: 13px;">&nbsp;XXL</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td class="subtitle-cell" style="height: 13px;" colspan="6">FEMALE ROLL-NECK SWEATERS, JUMPERS</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Chest, cm&nbsp;</td>\r\n<td style="height: 13px;">86-94&nbsp;</td>\r\n<td style="height: 13px;">90-108</td>\r\n<td style="height: 13px;">94-102</td>\r\n<td style="height: 13px;">98-106</td>\r\n<td style="height: 13px;">102-108&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Waist, cm&nbsp;</td>\r\n<td style="height: 13px;">56-68</td>\r\n<td style="height: 13px;">64-72</td>\r\n<td style="height: 13px;">72-80&nbsp;</td>\r\n<td style="height: 13px;">80-88&nbsp;</td>\r\n<td style="height: 13px;">88-96&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Hip, cm&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n</tr>\r\n<tr class="row-offset" style="height: 13px;">\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n<td style="height: 13px;">&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td class="subtitle-cell" style="height: 13px;" colspan="6">FEMALE DRESSES, SKIRTS</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Chest, cm&nbsp;</td>\r\n<td style="height: 13px;">86&nbsp;</td>\r\n<td style="height: 13px;">90&nbsp;</td>\r\n<td style="height: 13px;">94&nbsp;</td>\r\n<td style="height: 13px;">98&nbsp;</td>\r\n<td style="height: 13px;">102&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Waist, cm&nbsp;</td>\r\n<td style="height: 13px;">68&nbsp;</td>\r\n<td style="height: 13px;">72&nbsp;</td>\r\n<td style="height: 13px;">76&nbsp;</td>\r\n<td style="height: 13px;">82&nbsp;</td>\r\n<td style="height: 13px;">90&nbsp;</td>\r\n</tr>\r\n<tr style="height: 13px;">\r\n<td style="height: 13px;">Hip, cm&nbsp;</td>\r\n<td style="height: 13px;">92&nbsp;</td>\r\n<td style="height: 13px;">96&nbsp;</td>\r\n<td style="height: 13px;">100&nbsp;</td>\r\n<td style="height: 13px;">108</td>\r\n<td style="height: 13px;">116&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'Широкий вибір одягу он-лайн на Jenadin.com.ua. Асортимент одягу:');

-- --------------------------------------------------------

--
-- Структура таблицы `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `slider`
--

INSERT INTO `slider` (`id`, `name`, `alias`) VALUES
(1, 'Главная страница', 'main-page');

-- --------------------------------------------------------

--
-- Структура таблицы `slider_item`
--

CREATE TABLE IF NOT EXISTS `slider_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `slider_id` (`slider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=103 ;

--
-- Дамп данных таблицы `slider_item`
--

INSERT INTO `slider_item` (`id`, `slider_id`, `image`, `url`, `sort`) VALUES
(101, 1, '/uploads/sliders/1/25_11672_oboi_create_1920x1200.jpg', '', 0),
(102, 1, '/uploads/sliders/1/25_11847_oboi_svetjashhijsja_sinij_shestiugolnik_1920x1200.jpg', '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `source_message`
--

CREATE TABLE IF NOT EXISTS `source_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=903 ;

--
-- Дамп данных таблицы `source_message`
--

INSERT INTO `source_message` (`id`, `category`, `message`) VALUES
(252, 'yii', '(not set)'),
(253, 'yii', 'An internal server error occurred.'),
(254, 'yii', 'Are you sure you want to delete this item?'),
(255, 'yii', 'Delete'),
(256, 'yii', 'Error'),
(257, 'yii', 'File upload failed.'),
(258, 'yii', 'Home'),
(259, 'yii', 'Invalid data received for parameter "{param}".'),
(260, 'yii', 'Login Required'),
(261, 'yii', 'Missing required arguments: {params}'),
(262, 'yii', 'Missing required parameters: {params}'),
(263, 'yii', 'No'),
(264, 'yii', 'No results found.'),
(265, 'yii', 'Only files with these MIME types are allowed: {mimeTypes}.'),
(266, 'yii', 'Only files with these extensions are allowed: {extensions}.'),
(267, 'yii', 'Page not found.'),
(268, 'yii', 'Please fix the following errors:'),
(269, 'yii', 'Please upload a file.'),
(270, 'yii', 'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{item} other{items}}.'),
(271, 'yii', 'The file "{file}" is not an image.'),
(272, 'yii', 'The file "{file}" is too big. Its size cannot exceed {formattedLimit}.'),
(273, 'yii', 'The file "{file}" is too small. Its size cannot be smaller than {formattedLimit}.'),
(274, 'yii', 'The format of {attribute} is invalid.'),
(275, 'yii', 'The image "{file}" is too large. The height cannot be larger than {limit, number} {limit, plural, one{pixel} other{pixels}}.'),
(276, 'yii', 'The image "{file}" is too large. The width cannot be larger than {limit, number} {limit, plural, one{pixel} other{pixels}}.'),
(277, 'yii', 'The image "{file}" is too small. The height cannot be smaller than {limit, number} {limit, plural, one{pixel} other{pixels}}.'),
(278, 'yii', 'The image "{file}" is too small. The width cannot be smaller than {limit, number} {limit, plural, one{pixel} other{pixels}}.'),
(279, 'yii', 'The requested view "{name}" was not found.'),
(280, 'yii', 'The verification code is incorrect.'),
(281, 'yii', 'Total <b>{count, number}</b> {count, plural, one{item} other{items}}.'),
(282, 'yii', 'Unable to verify your data submission.'),
(283, 'yii', 'Unknown option: --{name}'),
(284, 'yii', 'Update'),
(285, 'yii', 'View'),
(286, 'yii', 'Yes'),
(287, 'yii', 'You are not allowed to perform this action.'),
(288, 'yii', 'You can upload at most {limit, number} {limit, plural, one{file} other{files}}.'),
(289, 'yii', 'in {delta, plural, =1{a day} other{# days}}'),
(290, 'yii', 'in {delta, plural, =1{a minute} other{# minutes}}'),
(291, 'yii', 'in {delta, plural, =1{a month} other{# months}}'),
(292, 'yii', 'in {delta, plural, =1{a second} other{# seconds}}'),
(293, 'yii', 'in {delta, plural, =1{a year} other{# years}}'),
(294, 'yii', 'in {delta, plural, =1{an hour} other{# hours}}'),
(295, 'yii', 'just now'),
(296, 'yii', 'the input value'),
(297, 'yii', '{attribute} "{value}" has already been taken.'),
(298, 'yii', '{attribute} cannot be blank.'),
(299, 'yii', '{attribute} is invalid.'),
(300, 'yii', '{attribute} is not a valid URL.'),
(301, 'yii', '{attribute} is not a valid email address.'),
(302, 'yii', '{attribute} must be "{requiredValue}".'),
(303, 'yii', '{attribute} must be a number.'),
(304, 'yii', '{attribute} must be a string.'),
(305, 'yii', '{attribute} must be an integer.'),
(306, 'yii', '{attribute} must be either "{true}" or "{false}".'),
(307, 'yii', '{attribute} must be greater than "{compareValue}".'),
(308, 'yii', '{attribute} must be greater than or equal to "{compareValue}".'),
(309, 'yii', '{attribute} must be less than "{compareValue}".'),
(310, 'yii', '{attribute} must be less than or equal to "{compareValue}".'),
(311, 'yii', '{attribute} must be no greater than {max}.'),
(312, 'yii', '{attribute} must be no less than {min}.'),
(313, 'yii', '{attribute} must be repeated exactly.'),
(314, 'yii', '{attribute} must not be equal to "{compareValue}".'),
(315, 'yii', '{attribute} should contain at least {min, number} {min, plural, one{character} other{characters}}.'),
(316, 'yii', '{attribute} should contain at most {max, number} {max, plural, one{character} other{characters}}.'),
(317, 'yii', '{attribute} should contain {length, number} {length, plural, one{character} other{characters}}.'),
(318, 'yii', '{delta, plural, =1{a day} other{# days}} ago'),
(319, 'yii', '{delta, plural, =1{a minute} other{# minutes}} ago'),
(320, 'yii', '{delta, plural, =1{a month} other{# months}} ago'),
(321, 'yii', '{delta, plural, =1{a second} other{# seconds}} ago'),
(322, 'yii', '{delta, plural, =1{a year} other{# years}} ago'),
(323, 'yii', '{delta, plural, =1{an hour} other{# hours}} ago'),
(324, 'yii', '{nFormatted} B'),
(325, 'yii', '{nFormatted} GB'),
(326, 'yii', '{nFormatted} GiB'),
(327, 'yii', '{nFormatted} KB'),
(328, 'yii', '{nFormatted} KiB'),
(329, 'yii', '{nFormatted} MB'),
(330, 'yii', '{nFormatted} MiB'),
(331, 'yii', '{nFormatted} PB'),
(332, 'yii', '{nFormatted} PiB'),
(333, 'yii', '{nFormatted} TB'),
(334, 'yii', '{nFormatted} TiB'),
(335, 'yii', '{nFormatted} {n, plural, =1{byte} other{bytes}}'),
(336, 'yii', '{nFormatted} {n, plural, =1{gibibyte} other{gibibytes}}'),
(337, 'yii', '{nFormatted} {n, plural, =1{gigabyte} other{gigabytes}}'),
(338, 'yii', '{nFormatted} {n, plural, =1{kibibyte} other{kibibytes}}'),
(339, 'yii', '{nFormatted} {n, plural, =1{kilobyte} other{kilobytes}}'),
(340, 'yii', '{nFormatted} {n, plural, =1{mebibyte} other{mebibytes}}'),
(341, 'yii', '{nFormatted} {n, plural, =1{megabyte} other{megabytes}}'),
(342, 'yii', '{nFormatted} {n, plural, =1{pebibyte} other{pebibytes}}'),
(343, 'yii', '{nFormatted} {n, plural, =1{petabyte} other{petabytes}}'),
(344, 'yii', '{nFormatted} {n, plural, =1{tebibyte} other{tebibytes}}'),
(345, 'yii', '{nFormatted} {n, plural, =1{terabyte} other{terabytes}}'),
(537, 'common/modules/i18n', 'Translations'),
(538, 'common/modules/i18n', 'Id'),
(539, 'common/modules/i18n', 'Message'),
(540, 'common/modules/i18n', 'Category'),
(541, 'common/modules/i18n', 'Status'),
(542, 'common/modules/i18n', 'Translated'),
(543, 'common/modules/i18n', 'Not translated'),
(544, 'common/modules/i18n', 'Online'),
(545, 'common/modules/i18n', 'Menu'),
(546, 'common/modules/i18n', 'Dashboard'),
(547, 'common/modules/i18n', 'Profile'),
(548, 'common/modules/i18n', 'Users'),
(549, 'common/modules/i18n', 'Productdetails'),
(550, 'common/modules/i18n', 'Brands'),
(551, 'common/modules/i18n', 'Login'),
(552, 'common/modules/i18n', 'Settings'),
(553, 'common/modules/i18n', 'Templates'),
(554, 'common/modules/i18n', 'Currency'),
(555, 'common/modules/i18n', 'Update'),
(556, 'common/modules/i18n', 'Translation'),
(557, 'common/modules/i18n', 'Back to list'),
(558, 'yii', '{attribute} must be equal to "{compareValueOrAttribute}".'),
(559, 'yii', '{attribute} must be greater than "{compareValueOrAttribute}".'),
(560, 'yii', '{attribute} must be greater than or equal to "{compareValueOrAttribute}".'),
(561, 'yii', '{attribute} must be less than "{compareValueOrAttribute}".'),
(562, 'yii', '{attribute} must be less than or equal to "{compareValueOrAttribute}".'),
(563, 'yii', '{attribute} must not be equal to "{compareValueOrAttribute}".'),
(564, 'yii', '{attribute} contains wrong subnet mask.'),
(565, 'yii', '{attribute} is not in the allowed range.'),
(566, 'yii', '{attribute} must be a valid IP address.'),
(567, 'yii', '{attribute} must be an IP address with specified subnet.'),
(568, 'yii', '{attribute} must not be a subnet.'),
(569, 'yii', '{attribute} must not be an IPv4 address.'),
(570, 'yii', '{attribute} must not be an IPv6 address.'),
(571, 'yii', '{delta, plural, =1{1 day} other{# days}}'),
(572, 'yii', '{delta, plural, =1{1 hour} other{# hours}}'),
(573, 'yii', '{delta, plural, =1{1 minute} other{# minutes}}'),
(574, 'yii', '{delta, plural, =1{1 month} other{# months}}'),
(575, 'yii', '{delta, plural, =1{1 second} other{# seconds}}'),
(576, 'yii', '{delta, plural, =1{1 year} other{# years}}'),
(577, 'common/modules/i18n', 'Updated'),
(578, 'common/modules/i18n', 'Create '),
(579, 'common/modules/i18n', 'User'),
(580, 'common/modules/i18n', 'Username'),
(581, 'common/modules/i18n', 'Email'),
(582, 'common/modules/i18n', 'Authkey'),
(583, 'common/modules/i18n', 'Passwordhash'),
(584, 'common/modules/i18n', 'Passwordresettoken'),
(585, 'common/modules/i18n', 'Createdat'),
(586, 'common/modules/i18n', 'Updatedat'),
(587, 'common/modules/i18n', 'Logo'),
(588, 'common/modules/i18n', 'New Password'),
(589, 'common/modules/i18n', 'New Password Repeat'),
(590, 'common/modules/i18n', 'Role'),
(591, 'common/modules/i18n', 'Delete'),
(592, 'common/modules/i18n', 'Are you sure you want to delete this item?'),
(593, 'common/modules/i18n', 'Roles'),
(594, 'common/modules/i18n', 'Brand'),
(595, 'common/modules/i18n', 'Name'),
(596, 'common/modules/i18n', 'Create'),
(597, 'common/modules/i18n', 'Template'),
(598, 'common/modules/i18n', 'Alias'),
(599, 'common/modules/i18n', 'Text'),
(600, 'common/modules/i18n', 'Currencies'),
(601, 'common/modules/i18n', 'Default'),
(602, 'common/modules/i18n', 'No'),
(603, 'common/modules/i18n', 'Yes'),
(604, 'common/modules/i18n', 'ISO 4217'),
(605, 'common/modules/i18n', 'Sign'),
(606, 'common/modules/i18n', 'Sign in'),
(607, 'common/modules/i18n', 'Sign in to start your session'),
(608, 'common/modules/i18n', 'Sign out'),
(609, 'common/modules/i18n', 'Enabled'),
(610, 'common/modules/i18n', 'Access rules'),
(611, 'common/modules/i18n', 'Add new rule'),
(612, 'common/modules/i18n', 'Rule'),
(613, 'common/modules/i18n', 'Description'),
(614, 'common/modules/i18n', 'Create rule'),
(615, 'common/modules/i18n', 'Edit rule'),
(616, 'common/modules/i18n', 'Text description'),
(617, 'common/modules/i18n', 'Allowed access'),
(618, 'common/modules/i18n', 'Parent permission'),
(619, 'common/modules/i18n', 'Save'),
(620, 'common/modules/i18n', 'Operation is done successfully.'),
(621, 'common/modules/i18n', 'Edit rule: '),
(622, 'common/modules/i18n', 'Role management'),
(623, 'common/modules/i18n', 'Add role'),
(624, 'common/modules/i18n', 'Allowed accesses'),
(625, 'common/modules/i18n', 'Edit role: '),
(626, 'common/modules/i18n', 'Role name'),
(627, 'common/modules/i18n', 'Posts'),
(628, 'common/modules/i18n', 'Post'),
(629, 'common/modules/i18n', 'Customer number'),
(630, 'common/modules/i18n', 'Bankaccountnumber'),
(631, 'common/modules/i18n', 'Bankaccountname'),
(632, 'common/modules/i18n', 'Customer ID'),
(633, 'common/modules/i18n', 'Country'),
(634, 'common/modules/i18n', 'City'),
(635, 'common/modules/i18n', 'Street'),
(636, 'common/modules/i18n', 'Zip'),
(637, 'common/modules/i18n', 'Salutation'),
(638, 'common/modules/i18n', 'Date start'),
(639, 'common/modules/i18n', 'Date end'),
(640, 'common/modules/i18n', 'Invoice number'),
(641, 'common/modules/i18n', 'Invoice subtotal'),
(642, 'common/modules/i18n', 'Invoice VAT'),
(643, 'common/modules/i18n', 'Invoice total'),
(644, 'common/modules/i18n', 'Location'),
(645, 'common/modules/i18n', 'Amount'),
(646, 'common/modules/i18n', 'Pallet'),
(647, 'common/modules/i18n', 'Bar number'),
(648, 'common/modules/i18n', 'Dateregistrated'),
(649, 'common/modules/i18n', 'Storage code'),
(650, 'common/modules/i18n', 'Storage description'),
(651, 'common/modules/i18n', 'Storage basis'),
(652, 'common/modules/i18n', 'Storage amount'),
(653, 'common/modules/i18n', 'Storage date start'),
(654, 'common/modules/i18n', 'Storage date end'),
(655, 'common/modules/i18n', 'Storage percentage'),
(656, 'common/modules/i18n', 'Storage price'),
(657, 'common/modules/i18n', 'Storage date out'),
(658, 'common/modules/i18n', 'Title'),
(659, 'common/modules/i18n', 'Content'),
(660, 'common/modules/i18n', 'Sort'),
(661, 'common/modules/i18n', 'Parent menu'),
(662, 'common/modules/i18n', 'Bean type'),
(663, 'common/modules/i18n', 'Bean'),
(664, 'common/modules/i18n', 'Enter the URL manually:'),
(665, 'common/modules/i18n', 'Sort action'),
(666, 'common/modules/i18n', 'Social networks'),
(667, 'common/modules/i18n', 'Social network'),
(668, 'common/modules/i18n', 'Not Found (#404)'),
(669, 'common/modules/i18n', 'The above error occurred while the Web server was processing your request.'),
(670, 'common/modules/i18n', 'Please contact us if you think this is a server error. Thank you.'),
(671, 'common/modules/i18n', 'Stocks'),
(672, 'common/modules/i18n', 'Stock'),
(673, 'common/modules/i18n', 'Where to buy'),
(674, 'common/modules/i18n', 'Contact us'),
(675, 'common/modules/i18n', 'Your name'),
(676, 'common/modules/i18n', 'Your email'),
(677, 'common/modules/i18n', 'Your message'),
(678, 'common/modules/i18n', 'Send'),
(679, 'common/modules/i18n', 'To'),
(680, 'common/modules/i18n', 'From'),
(681, 'common/modules/i18n', 'Subject'),
(682, 'common/modules/i18n', 'Contact form settings'),
(683, 'common/modules/i18n', 'Contact form'),
(684, 'common/modules/i18n', 'Contact form setting'),
(685, 'common/modules/i18n', 'Your message was sent successfully. Thank you.'),
(686, 'common/modules/i18n', 'Sliders'),
(687, 'common/modules/i18n', 'Slider'),
(688, 'common/modules/i18n', 'Images'),
(689, 'common/modules/i18n', 'Image'),
(690, 'common/modules/i18n', 'Link'),
(691, 'common/modules/i18n', 'Bad Request (#400)'),
(692, 'common/modules/i18n', 'Default page'),
(693, 'common/modules/i18n', 'Parent category'),
(694, 'common/modules/i18n', 'Categories'),
(695, 'common/modules/i18n', 'Shop'),
(696, 'common/modules/i18n', 'Characteristic groups'),
(697, 'common/modules/i18n', 'Characteristic group'),
(698, 'common/modules/i18n', 'Characteristics'),
(699, 'common/modules/i18n', 'Characteristic'),
(700, 'common/modules/i18n', 'Vendor code'),
(701, 'common/modules/i18n', 'Price'),
(702, 'common/modules/i18n', 'In stock'),
(703, 'common/modules/i18n', 'Products'),
(704, 'common/modules/i18n', 'Product'),
(705, 'common/modules/i18n', 'Select'),
(706, 'common/modules/i18n', 'Simple product'),
(707, 'common/modules/i18n', 'Variation'),
(708, 'common/modules/i18n', 'Type'),
(709, 'common/modules/i18n', 'Variations'),
(710, 'common/modules/i18n', 'Размер'),
(711, 'common/modules/i18n', 'Gallery'),
(712, 'common/modules/i18n', 'Product categories '),
(713, 'common/modules/i18n', 'Filter'),
(714, 'common/modules/i18n', 'Product categories'),
(715, 'common/modules/i18n', 'View'),
(716, 'common/modules/i18n', 'Not available'),
(717, 'common/modules/i18n', 'Menu types'),
(718, 'common/modules/i18n', 'Menu type'),
(719, 'common/modules/i18n', 'Useful Information'),
(720, 'common/modules/i18n', 'Clear'),
(721, 'common/modules/i18n', 'Result(s)'),
(722, 'common/modules/i18n', 'Count of products:'),
(723, 'common/modules/i18n', 'Price High to Low'),
(724, 'common/modules/i18n', 'Price Low to High'),
(725, 'common/modules/i18n', 'Sort by'),
(726, 'common/modules/i18n', 'Short description'),
(727, 'common/modules/i18n', 'Show after price'),
(728, 'common/modules/i18n', 'Add to shopping bag'),
(729, 'common/modules/i18n', 'Choose your size'),
(730, 'common/modules/i18n', 'Count'),
(731, 'common/modules/i18n', 'You need to choose a size'),
(732, 'common/modules/i18n', 'You need to enter a count'),
(733, 'common/modules/i18n', 'Add to wish list'),
(734, 'common/modules/i18n', 'Enter to the cabinet'),
(735, 'common/modules/i18n', 'Password'),
(736, 'common/modules/i18n', 'Remember me'),
(737, 'common/modules/i18n', 'Enter'),
(738, 'common/modules/i18n', 'If you forgot your password you can'),
(739, 'common/modules/i18n', 'Forget password?'),
(740, 'common/modules/i18n', 'Incorrect username or password.'),
(741, 'common/modules/i18n', 'Signup'),
(742, 'common/modules/i18n', 'This username has already been taken.'),
(743, 'common/modules/i18n', 'This email address has already been taken.'),
(744, 'common/modules/i18n', 'I would like to receive news from Jenadin'),
(745, 'common/modules/i18n', 'Subscription'),
(746, 'common/modules/i18n', 'Stay in touch'),
(747, 'common/modules/i18n', 'Sign up for news'),
(748, 'common/modules/i18n', 'Novelties'),
(749, 'common/modules/i18n', 'Novelty'),
(750, 'common/modules/i18n', 'Are you sure you want to send novelty?'),
(751, 'common/modules/i18n', 'Video'),
(752, 'common/modules/i18n', 'Remove'),
(753, 'common/modules/i18n', 'Kits'),
(754, 'common/modules/i18n', 'Kit'),
(755, 'common/modules/i18n', 'remove'),
(756, 'common/modules/i18n', 'How to wear it'),
(757, 'common/modules/i18n', 'You may also like it'),
(758, 'common/modules/i18n', 'Basket'),
(759, 'common/modules/i18n', 'Continue shopping'),
(760, 'common/modules/i18n', 'Unit price:'),
(761, 'common/modules/i18n', 'Total:'),
(762, 'common/modules/i18n', 'Basket is updated successfully.'),
(763, 'common/modules/i18n', 'You basket is empty.'),
(764, 'common/modules/i18n', 'Sum in the basket'),
(765, 'common/modules/i18n', 'In total'),
(766, 'common/modules/i18n', 'Proceed checkout'),
(767, 'common/modules/i18n', 'The size is '),
(768, 'common/modules/i18n', 'The size is out of stock.'),
(769, 'common/modules/i18n', 'Request password reset'),
(770, 'common/modules/i18n', 'A link to reset password will be sent there.'),
(771, 'common/modules/i18n', 'Password reset for Jenadin'),
(772, 'common/modules/i18n', 'Hello'),
(773, 'common/modules/i18n', 'Follow the link below to reset your password:'),
(774, 'common/modules/i18n', 'There is no user with such email.'),
(775, 'common/modules/i18n', 'Check your email for further instructions.'),
(776, 'common/modules/i18n', 'Reset password'),
(777, 'common/modules/i18n', 'Please choose your new password:'),
(778, 'common/modules/i18n', 'New password was saved.'),
(779, 'common/modules/i18n', 'Hello, %s%. (%s). In your account you can see your orders.'),
(780, 'common/modules/i18n', 'Exit'),
(781, 'common/modules/i18n', 'Account details'),
(782, 'common/modules/i18n', 'Address book'),
(783, 'common/modules/i18n', 'View or change your sign-in information.'),
(784, 'common/modules/i18n', 'Edit address data.'),
(785, 'common/modules/i18n', 'Wish list'),
(786, 'common/modules/i18n', 'Orders'),
(787, 'common/modules/i18n', 'View your order history.'),
(788, 'common/modules/i18n', 'View your favourite products.'),
(789, 'common/modules/i18n', 'Back to profile view'),
(790, 'common/modules/i18n', 'Profile is updated successfully.'),
(791, 'common/modules/i18n', 'Address'),
(792, 'common/modules/i18n', 'First name'),
(793, 'common/modules/i18n', 'Last name'),
(794, 'common/modules/i18n', 'Phone'),
(795, 'common/modules/i18n', 'Region'),
(796, 'common/modules/i18n', 'Building'),
(797, 'common/modules/i18n', 'Flat'),
(798, 'common/modules/i18n', 'Address is updated successfully.'),
(799, 'common/modules/i18n', 'The product was removed from the wish list'),
(800, 'common/modules/i18n', 'There is no product in your wish list'),
(801, 'common/modules/i18n', 'Notes'),
(802, 'common/modules/i18n', 'Payment type'),
(803, 'common/modules/i18n', 'Order'),
(804, 'common/modules/i18n', 'Checkout'),
(805, 'common/modules/i18n', 'Payment details'),
(806, 'common/modules/i18n', 'Your order'),
(807, 'common/modules/i18n', 'Total price'),
(808, 'common/modules/i18n', 'Payment types'),
(809, 'common/modules/i18n', 'Place order'),
(810, 'common/modules/i18n', 'Receivers'),
(811, 'common/modules/i18n', 'Email subject'),
(812, 'common/modules/i18n', 'Email templates'),
(813, 'common/modules/i18n', 'Email template'),
(814, 'common/modules/i18n', 'Email preview'),
(815, 'common/modules/i18n', 'ID'),
(816, 'common/modules/i18n', 'Subject from'),
(817, 'common/modules/i18n', 'Email from'),
(818, 'common/modules/i18n', 'Footer'),
(819, 'common/modules/i18n', 'Email settings'),
(820, 'common/modules/i18n', 'Email setting'),
(821, 'common/modules/i18n', 'You got order from '),
(822, 'common/modules/i18n', 'Information about the client'),
(823, 'common/modules/i18n', 'Thanks!'),
(824, 'common/modules/i18n', 'Your order is accepted!'),
(825, 'common/modules/i18n', 'Our manager will contact you'),
(826, 'common/modules/i18n', 'Hi there. Your recent order on Jenadin has been completed.'),
(827, 'common/modules/i18n', 'Your order was accepted successfully!'),
(828, 'common/modules/i18n', 'Number'),
(829, 'common/modules/i18n', 'Concept'),
(830, 'common/modules/i18n', 'Paid'),
(831, 'common/modules/i18n', 'Refused'),
(832, 'common/modules/i18n', 'Nothing is selected'),
(833, 'common/modules/i18n', 'Positions'),
(834, 'common/modules/i18n', '	You basket is empty.'),
(835, 'common/modules/i18n', 'Open menu'),
(836, 'common/modules/i18n', 'Search'),
(837, 'common/modules/i18n', 'Back'),
(838, 'common/modules/i18n', 'My account'),
(839, 'common/modules/i18n', 'Created at'),
(840, 'common/modules/i18n', 'Updated at'),
(841, 'common/modules/i18n', 'Percentage'),
(842, 'common/modules/i18n', 'Sales'),
(843, 'common/modules/i18n', 'Sale'),
(844, 'common/modules/i18n', 'Load products from the collection:'),
(845, 'javascript', 'Are you sure you want to add this collection?'),
(846, 'common/modules/i18n', 'Sell-out'),
(847, 'common/modules/i18n', 'Latest'),
(848, 'common/modules/i18n', 'Novelties products'),
(849, 'common/modules/i18n', 'Latest product'),
(850, 'common/modules/i18n', 'Size & fit information'),
(851, 'common/modules/i18n', 'Editor notes'),
(852, 'common/modules/i18n', 'Icon'),
(853, 'common/modules/i18n', 'Table size'),
(854, 'javascript', 'Basket'),
(855, 'javascript', 'You have added to the basket:'),
(856, 'common/modules/i18n', 'Successfully added'),
(857, 'common/modules/i18n', 'Pay waited'),
(858, 'common/modules/i18n', 'Congratulations! You have placed your order.'),
(859, 'common/modules/i18n', 'Search results:'),
(861, 'common/modules/i18n', 'No results matching the query:'),
(862, 'common/modules/i18n', 'Magazines'),
(863, 'common/modules/i18n', 'Magazine'),
(864, 'common/modules/i18n', 'Pages'),
(865, 'common/modules/i18n', 'Order date'),
(866, 'common/modules/i18n', 'User data'),
(867, 'common/modules/i18n', 'Personal data'),
(868, 'common/modules/i18n', 'Order data'),
(869, 'common/modules/i18n', 'Back to order list'),
(870, 'common/modules/i18n', 'Nothing was found'),
(871, 'common/modules/i18n', 'Seo category description'),
(872, 'common/modules/i18n', 'Invalid Configuration'),
(873, 'common/modules/i18n', 'Ошибка (#2)'),
(874, 'common/modules/i18n', 'Error'),
(875, 'common/modules/i18n', 'Error (#8)'),
(876, 'common/modules/i18n', 'Розмір'),
(877, 'common/modules/i18n', 'javascript'),
(878, 'common/modules/i18n', 'You have added to the basket:'),
(879, 'common/modules/i18n', 'Database Exception (#42)'),
(880, 'common/modules/i18n', 'Unknown Property'),
(881, 'common/modules/i18n', 'Invalid Configuration (#101)'),
(882, 'common/modules/i18n', 'MAC'),
(883, 'common/modules/i18n', 'Customers'),
(884, 'common/modules/i18n', 'Customer'),
(885, 'common/modules/i18n', 'Value'),
(886, 'common/modules/i18n', 'Unsupported Media Type (#415)'),
(887, 'common/modules/i18n', 'Start time'),
(888, 'common/modules/i18n', 'End time'),
(889, 'common/modules/i18n', 'Show plot'),
(890, 'common/modules/i18n', 'Print'),
(891, 'javascript', 'Pulse'),
(892, 'common/modules/i18n', 'Gender'),
(893, 'common/modules/i18n', 'Age'),
(894, 'common/modules/i18n', 'Heart beat table'),
(895, 'common/modules/i18n', 'Min age'),
(896, 'common/modules/i18n', 'Max age'),
(897, 'common/modules/i18n', 'Min beat'),
(898, 'common/modules/i18n', 'Max beat'),
(899, 'common/modules/i18n', 'Create role'),
(900, 'common/modules/i18n', 'Operators'),
(901, 'common/modules/i18n', 'BPM'),
(902, 'common/modules/i18n', 'Threat from ');

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `job_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `crontab` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `name`, `job_id`, `status`, `crontab`) VALUES
(7, 'Disease detection', 7, 'running', '* * * * *');

-- --------------------------------------------------------

--
-- Структура таблицы `threat`
--

CREATE TABLE IF NOT EXISTS `threat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `alias` varchar(255) CHARACTER SET utf8 NOT NULL,
  `bpm` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `threat`
--

INSERT INTO `threat` (`id`, `customer_id`, `created_at`, `alias`, `bpm`) VALUES
(2, 30, '2016-10-16 15:59:30', 'tachycardia', 100),
(3, 30, '2016-10-16 16:08:07', 'tachycardia', 100),
(4, 30, '2016-10-16 16:08:14', 'tachycardia', 100),
(5, 30, '2016-10-16 16:09:05', 'tachycardia', 100),
(6, 30, '2016-10-16 16:11:14', 'tachycardia', 100),
(7, 30, '2016-10-16 16:12:15', 'tachycardia', 100),
(8, 30, '2016-10-16 16:13:35', 'tachycardia', 100),
(9, 30, '2016-10-16 16:14:49', 'tachycardia', 100),
(10, 30, '2016-10-16 16:15:23', 'tachycardia', 100),
(11, 30, '2016-10-16 16:16:01', 'tachycardia', 100),
(12, 30, '2016-10-16 16:16:56', 'tachycardia', 100),
(13, 30, '2016-10-16 16:17:20', 'tachycardia', 100),
(14, 30, '2016-10-16 16:19:13', 'tachycardia', 100),
(15, 30, '2016-10-16 16:19:57', 'tachycardia', 100),
(16, 30, '2016-10-16 16:20:14', 'tachycardia', 100),
(17, 30, '2016-10-16 16:22:04', 'tachycardia', 100),
(18, 30, '2016-10-16 16:22:23', 'tachycardia', 100),
(19, 30, '2016-10-16 16:22:33', 'tachycardia', 100),
(20, 30, '2016-10-16 16:23:14', 'tachycardia', 100),
(21, 30, '2016-10-16 16:27:38', 'tachycardia', 100);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscription` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=48 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `logo`, `subscription`) VALUES
(1, 'admin', 'V-Cym0VAr8UvLBmmLSHJID6XlMaqaXyZ', '$2y$13$wx3ceUtuQVUiwXhZUn9N2.ClZq2jF/JymqR4JZZLHI0abmLtmGly.', NULL, 'artemkramov@yahoo.com', 10, 1455877362, 1474639838, NULL, 1),
(30, 'akramov', '', '$2y$13$8AfAtunPCVr1gltkcd0yrOKbgJXmqvLIbZScK1Vy0hZGYbyrvobpW', 'flepYLC6C_tO4m9Eeh1R_K3GH3bJ32DQ_1472047294', 'artemkramov@gmail.com', 10, 1464245955, 1476628974, '', 1),
(31, 'user', 'NEvVqyxhS_uYXwAFuXXEAxwEs8boy0-4', '$2y$13$TEVTC01MWd8/9OZjxY7TMOBvqxp9NmDyuHc/D/IYeEKnwm7aQw0T2', '25lmAAEaVH8j6B-Wk07bBgH5tRjUT-T5_1472042259', 'chutovo_kram@i.ua', 10, 1471539355, 1472042260, NULL, 0),
(38, 'user1', 'e0GXfN5sXA5mRFBQUssX47SDZucqD4vp', '$2y$13$xa/.96vHpSlPTTbMaP3ntehOyBA4uAChKQPzfC9KYyytEofFkW522', NULL, 'chutovo_kramq@i.ua', 10, 1471590998, 1471605097, NULL, 0),
(39, 'gfg@gh.gf', '58sW7ySfGaEikzl8Le4R0dB9i9PmNHC1', '$2y$13$b6ns5jL2oKKhHgaPbahfsORaceIiD7zwTFZkTd/INXNswvC17J8su', NULL, 'fgh@fg.fd', 10, 1472822939, 1472822939, NULL, 1),
(40, 'test_user', 'd6QnNLurwg3vObzqGEEKCVfcEqO6eviU', '$2y$13$KwBpyIv9.nnqNEve23/0Tu9UvQdD/e0CC5ZuQ.j8pXYPm0w48tUWa', NULL, 'test_user@fd.rt', 10, 1473606411, 1473606411, NULL, 1),
(47, 'letitbe', '', '$2y$13$Pn3ZLTrrUSUwHN4qSFzlbO5FXizVi6oa6P.ZdFJ3ohwvRHPXGzqE.', NULL, 'letitbe@mail.com', 10, 1474648113, 1474648113, NULL, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `country`
--
ALTER TABLE `country`
  ADD CONSTRAINT `country_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`);

--
-- Ограничения внешнего ключа таблицы `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `customer_operator`
--
ALTER TABLE `customer_operator`
  ADD CONSTRAINT `customer_operator_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_operator_ibfk_2` FOREIGN KEY (`operator_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `genderlang`
--
ALTER TABLE `genderlang`
  ADD CONSTRAINT `genderlang_ibfk_1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `heart_beat`
--
ALTER TABLE `heart_beat`
  ADD CONSTRAINT `heart_beat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `menulang`
--
ALTER TABLE `menulang`
  ADD CONSTRAINT `menulang_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `threat`
--
ALTER TABLE `threat`
  ADD CONSTRAINT `threat_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
