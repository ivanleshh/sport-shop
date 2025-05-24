-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: localhost    Database: sport-shop
-- ------------------------------------------------------
-- Server version	8.0.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand`
--

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (1,'rps.jpg','Russian Performance Standard (RPS)'),(2,'atlecs.jpg','Atlecs'),(3,'levelUp.jpg','Level Up'),(4,'maxler.png','Maxler'),(8,'8_RWO10sEqSYj5O0XtquK5p6I-ef_QgmRe.jpg','CHIKALAB'),(9,'8_iLIA0mt_-wSt53XDa84Q_fgYM5x_82dB.png','Bombbar'),(10,'8_wTP8ejnjuooL9uQvvY6aig8Oks5wMYpd.jpg','Nattys');
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `total_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `product_amount` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (84,5,0.00,0);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_item`
--

DROP TABLE IF EXISTS `cart_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_item` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  `product_amount` int unsigned NOT NULL,
  `total_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_Id` (`product_id`),
  CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1051 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_item`
--

LOCK TABLES `cart_item` WRITE;
/*!40000 ALTER TABLE `cart_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,NULL,'Протеины','Для набора мышечной массы необходимо получать достаточное количество протеина. Он составляет основу ткани мышц, отвечает за самочувствие, иммунитет, выносливость. Белок можно получать и из обычной еды, но для большего эффекта лучше использовать белковые добавки.',NULL),(2,'casein.jpg','Казеин','Казеиновый протеин (казеин) — обогащенная медленными белками молочная смесь. Она отличается минимальным содержанием жиров и быстрых углеводов. Этот белок используют в сочетании с различными предтренировочными комплексами.',1),(3,'sivo.jpeg','Сывороточный','Сывороточный протеин изготавливают на основе молочной сыворотки. Этот продукт богат аминокислотами, витаминами, лактозой и другими питательными веществами. Он ускоряет обмен веществ и используется для похудения и набора мышечной массы.',1),(4,'izolyat.jpeg','Изолят','Изолят — это чистый молочный белок в порошковой форме. Он восстанавливает мышцы, связки и другие ткани организма после тренировки. Такая добавка помогает быстрее прогрессировать в пауэрлифтинге, бодибилдинге, легкой атлетике, ММА и других видах спорта.',1),(5,'gidroizolyat.jpeg','Гидролизат','Сывороточный гидролизованный протеин — пищевая добавка, которая быстро восполняет нехватку белков в рационе. Гидролизат является самым эффективным продуктом при наборе мышечной массы. Он быстро усваивается и вызывает мощный рост инсулина и аминокислот в крови.',1),(6,'multicomp.jpg','Мультикомпонентный','Мульти добавка включает сразу несколько видов белка. В составе могут присутствовать соевый, яичный, сывороточный, говяжий и другие типы протеина. Мультикомпонентные добавки помогают достичь максимально выраженного эффекта при наборе мышечной массы.',1),(7,'guvyaszh.jpeg','Говяжий','Говядина в натуральном виде – ценнейший источник белка с богатым составом аминокислот, но при этом весьма тяжелый для пищеварения продукт. Говяжий протеин сохраняет в себе все основные преимущества говядины и в то же время лишен ее недостатков, так как белок частично ферментирован.\r\n\r\nТакой протеин получают из мяса говядины, убирая из него все насыщенные жиры (холестерин в том числе). Получаемый чистый белок не подвергает ЖКТ нагрузке, отличается повышенной биологической ценностью и с легкостью усваивается.\r\n\r\nГовяжий протеин дает организму белок, необходимый для роста сухой качественной мышечной массы без лишнего жира. Также, продукт выступает хорошим источником натурального креатина, с помощью которого повышается уровень энергии, выносливости, поддерживается азотистый баланс, а также увеличивается мышечная сила. Он помогает ускорить восстановление после активных физических нагрузок.',1),(33,'8_1745256901_-yPgnc9vzLkoKpcpi5eCJzSjJVqgdZpu.jpeg','Растительный','Растительный протеин – уникальная белковая добавка, созданная для веганов, а также для людей, страдающих лактозной или глютеновой непереносимостью. Богатый аминокислотный состав включает незаменимые аминокислоты: лейцин, изолейцин и валин. 100% постный продукт.\r\n\r\nБлагодаря отсутствию в составе добавки продуктов животного происхождения, коктейли на основе растительного протеина легко усваиваются. Мышечная ткань получает достаточное для регенерации и роста количество белка, что способствует более эффективной организации тренировочного и восстановительного циклов.\r\n\r\nБлюда с добавлением растительного протеина хорошо насыщают, разгоняют метаболизм. Полезны для сосудов и кроветворной системы, предотвращают образование плохого холестерина.',1),(34,'8_1745256997_Lb2gbPc1BdnTvlzU-VmU4k6G1y3z8Zl3.jpeg','Яичный','Яйцо - это один из наиболее популярных продуктов питания, в том числе и спортивного, так как в нём содержится белок. Яичный протеин - основа спортивного питания атлетов старой школы. Белок яйца улучшает синтез мышечного протеина, обеспечивает увеличение объёма мышц, осуществляет стимуляцию анаболических реакций, уменьшает катаболизм. Он полностью усваивается человеческим организмом, даёт чувство насыщения, увеличивает силовые возможности, успешно применяется в диетах для похудения.',1),(35,'8_1745257097_In67CMh1Sy9PW75uc31rcfeE_PJm8a_a.jpg','Коктейли','Протеин – это спортивная добавка, представляющая собой белок, обогащённый различными аминокислотами. Протеин является строительным материалом, принимает участие в создании новых клеток.\r\n\r\nМногие спортсмены принимают протеин для того, чтобы набрать мышечную массу, либо наоборот похудеть, также протеин служит для восполнения дефицита белка, который не поступает из продуктов питания.',1),(36,'8_1745839369_JyiJfleUIoUzZPx0Xb4YnpUd4w9UcnLw.jpeg','Батончики','Фитнес батончики — одна из самых популярных форм спортивного питания. В нашем интернет-магазине представлены следующие варианты спортивных батончиков: протеиновые, энергетические, с L-карнитином.',NULL),(37,'8_1745840728_cgnJOa5tZdgAna2BIqHPlArdR4AZu2K6.webp','Протеиновые','Протеиновые батончики — это концентрированный источник питательных веществ. Нутрициологи утверждают, что употребление двух–трех снеков в день полностью удовлетворяет потребность организма в аминокислотах.\r\n\r\nВ таком спортпите содержится белок в легкоусвояемой форме, поэтому его прием за час до тренировки дает достаточно энергии и сил организму. Диетологи и тренеры рекомендуют использовать батончики в качестве дополнения к основному рациону.',36);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_property`
--

DROP TABLE IF EXISTS `category_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_property` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned NOT NULL,
  `property_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `property_id` (`property_id`),
  CONSTRAINT `category_property_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `category_property_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_property`
--

LOCK TABLES `category_property` WRITE;
/*!40000 ALTER TABLE `category_property` DISABLE KEYS */;
INSERT INTO `category_property` VALUES (94,2,89),(95,2,90),(96,2,91),(97,2,92),(99,2,94),(100,2,95),(101,2,96),(102,2,97),(103,2,98),(104,2,99),(105,2,100),(123,37,105),(132,36,88),(133,37,107),(134,37,89),(135,37,90),(136,37,91),(137,37,100),(138,37,88),(139,37,108);
/*!40000 ALTER TABLE `category_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compare_products`
--

DROP TABLE IF EXISTS `compare_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compare_products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `compare_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compare_products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compare_products`
--

LOCK TABLES `compare_products` WRITE;
/*!40000 ALTER TABLE `compare_products` DISABLE KEYS */;
INSERT INTO `compare_products` VALUES (1,5,3,0),(2,5,4,0),(3,5,5,0),(4,5,6,0),(8,5,36,0),(9,5,38,0),(10,5,39,0),(11,5,40,0);
/*!40000 ALTER TABLE `compare_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favourite_products`
--

DROP TABLE IF EXISTS `favourite_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favourite_products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `favourite_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `favourite_products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favourite_products`
--

LOCK TABLES `favourite_products` WRITE;
/*!40000 ALTER TABLE `favourite_products` DISABLE KEYS */;
INSERT INTO `favourite_products` VALUES (3,5,3,0),(4,5,5,0),(5,5,6,0),(6,5,4,0),(7,5,36,0),(8,5,38,0),(9,5,39,0),(10,5,40,0);
/*!40000 ALTER TABLE `favourite_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_item` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  `product_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_amount` int unsigned NOT NULL,
  `product_cost` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` VALUES (5,5,6,'Maxler 100% Golden Whey 907 гр',2,3890.00,7780.00),(6,5,4,'RPS Casein Protein 500 гр',1,1290.00,1290.00),(7,5,5,'LevelUp 100% Whey 908 гр',1,2490.00,2490.00),(8,6,3,'Atlecs Casein 454 гр',3,1990.00,5970.00),(9,6,4,'RPS Casein Protein 500 гр',1,1290.00,1290.00),(10,6,5,'LevelUp 100% Whey 908 гр',1,2490.00,2490.00),(11,7,3,'Atlecs Casein 454 гр',2,1990.00,3980.00),(12,12,5,'LevelUp 100% Whey 908 гр',1,2490.00,2490.00),(13,12,3,'Atlecs Casein 454 гр',1,1990.00,1990.00),(14,12,6,'Maxler 100% Golden Whey 907 гр',3,3890.00,11670.00),(15,12,4,'RPS Casein Protein 500 гр',4,1290.00,5160.00),(16,13,5,'LevelUp 100% Whey 908 гр',2,2490.00,4980.00),(17,13,4,'RPS Casein Protein 500 гр',1,1290.00,1290.00),(18,17,38,'Протеиновые батончики Малиновый чизкейк',1,1027.00,1027.00),(19,17,6,'Maxler 100% Golden Whey 907 гр',1,3890.00,3890.00),(20,17,39,'Батончики с арахисовой пастой Mix Box Peanut',2,756.00,1512.00),(21,17,36,'Протеиновый батончик CHIKABAR (кокос)',3,956.00,2868.00),(22,18,39,'Батончики с арахисовой пастой Mix Box Peanut',1,756.00,756.00),(23,18,36,'Протеиновый батончик CHIKABAR (кокос)',1,956.00,956.00),(24,19,38,'Протеиновые батончики Малиновый чизкейк',1,1027.00,1027.00),(25,19,39,'Батончики с арахисовой пастой Mix Box Peanut',1,756.00,756.00),(26,19,36,'Протеиновый батончик CHIKABAR (кокос)',1,956.00,956.00),(27,20,3,'Atlecs Casein 454 гр',1,1990.00,1990.00),(28,20,4,'RPS Casein Protein 500 гр',2,1290.00,2580.00),(29,21,3,'Atlecs Casein 454 гр',1,1990.00,1990.00),(30,21,40,'Протеиновые батончики \"Кокосовый торт\"',1,758.00,758.00),(31,21,4,'RPS Casein Protein 500 гр',1,1290.00,1290.00),(32,21,5,'LevelUp 100% Whey 908 гр',1,2490.00,2490.00);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type_pay_id` int unsigned NOT NULL,
  `pick_up_id` int unsigned DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_delivery` date DEFAULT NULL,
  `time_delivery` time DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `total_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `product_amount` int unsigned NOT NULL,
  `status_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delay_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `new_date_delivery` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pick_up_id` (`pick_up_id`),
  KEY `user_id` (`user_id`),
  KEY `type_pay_id` (`type_pay_id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`pick_up_id`) REFERENCES `pickup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`type_pay_id`) REFERENCES `typepay` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (5,'Иван','fds@fds.fd','+7(312)-321-32-23',1,2,NULL,NULL,NULL,NULL,11560.00,4,1,5,'2025-03-02 09:24:06','2025-04-01 11:08:27','123','2025-03-07'),(6,'Иван','sdfjds@jfds.fd','+7(321)-312-31-23',1,2,NULL,NULL,NULL,NULL,9750.00,5,2,5,'2025-03-06 21:03:24','2025-04-01 11:08:27','123','2025-03-14'),(7,'Иван','kfds@kfds.fsd','+7(321)-321-32-13',1,NULL,'fdsfsd','2025-03-27','12:33:00',NULL,3980.00,2,2,5,'2025-03-24 22:31:38','2025-03-24 22:38:15',NULL,NULL),(12,'аываыв','fsd@2fas.sd','+7(321)-432-43-24',1,1,NULL,NULL,NULL,NULL,21310.00,9,1,5,'2025-04-15 11:11:56','2025-04-15 11:11:56',NULL,NULL),(13,'аваыв','3f@fds.fd','+7(231)-432-43-24',1,1,NULL,NULL,NULL,NULL,6270.00,3,2,5,'2025-04-15 11:12:34','2025-04-15 11:14:20',NULL,NULL),(17,'Андрей','andrew2@gm.ad','+7(423)-432-43-24',2,4,NULL,NULL,NULL,NULL,9297.00,7,3,5,'2025-05-11 10:52:43','2025-05-11 21:30:27',NULL,NULL),(18,'Иван','fdsd@fsd.f','+7(324)-234-32-43',1,1,NULL,NULL,NULL,NULL,1712.00,2,2,5,'2025-05-11 11:13:54','2025-05-11 21:37:16','123','2025-05-13'),(19,'Савелий','fsd@f.fds','+7(432)-432-43-24',1,3,NULL,NULL,NULL,NULL,2739.00,3,3,5,'2025-05-11 11:37:02','2025-05-24 19:08:25','312','2025-05-22'),(20,'Савелий','fds@fsd.fd','+7(423)-432-43-24',1,NULL,'Россия, г. Долгопрудный, Тихая ул., д. 20 кв.197','2025-05-28','15:30:00','Комментарий курьеру Комментарий курьеру',4570.00,3,3,5,'2025-05-11 12:30:38','2025-05-11 22:22:31',NULL,NULL),(21,'аываыв','fsd@fds.fd','+7(321)-312-41-24',2,2,NULL,NULL,NULL,NULL,6528.00,4,1,5,'2025-05-18 15:54:49','2025-05-18 15:54:49',NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pickup`
--

DROP TABLE IF EXISTS `pickup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pickup` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pickup`
--

LOCK TABLES `pickup` WRITE;
/*!40000 ALTER TABLE `pickup` DISABLE KEYS */;
INSERT INTO `pickup` VALUES (1,'Солнечногорск, пл. Бухарестская, 38'),(2,'Солнечногорск, пер. Гоголя, 08'),(3,'Солнечногорск, ул. Косиора, 54'),(4,'Солнечногорск, ул. Гагарина, 29'),(5,'Солнечногорск, наб. Домодедовская, 65');
/*!40000 ALTER TABLE `pickup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL,
  `category_id` int unsigned NOT NULL,
  `count` int unsigned NOT NULL DEFAULT '0',
  `brand_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `brand_id` (`brand_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (3,'Atlecs Casein 454 гр','Мицеллярный казеин является одним из самых полноценных источников белка благодаря своему уникальному аминокислотному профилю. При приеме перед сном длительное время питает мышцы, способствуя наилучшему восстановлению и формированию сухой мышечной массы. ',1990.00,2,1,2),(4,'RPS Casein Protein 500 гр','Казеиновые протеины – это пищевые добавки с медленной скоростью усвоения. Casein Protein, производимый Russian Performance Standard, представляет собой сложный молочный продукт, являющийся источником практически всех аминокислот. ',1290.00,2,2,1),(5,'LevelUp 100% Whey 908 гр','Протеин 100% Whey от LevelUp производится на основе концентрата из сыворотки. И это не случайно: ведь сывороточный белок обладает легким и быстрым усвоением. К тому же, он богат незаменимыми аминокислотами BCAA и глютамином. Для получения продукта применяется ультрафильтрационная технология. Ну а исходным сырьем служит обычная молочная сыворотка, которая образуется, к примеру, при изготовлении сыров. В ходе данного способа обработки белок очищается от углеводов и жиров.',2490.00,3,76,3),(6,'Maxler 100% Golden Whey 907 гр','В состав 100% Golden Whey 908г входят концентрат, гидролизат и изолят сывороточного протеина. Действие протеина 100% Golden Whey от компании Maxler усилено высоким содержанием BCAA и L - глютамина.',3890.00,3,35,4),(36,'Протеиновый батончик CHIKABAR (кокос)','Представляем вам превосходное сочетание вкуса и пользы – CHIKABAR. Настоящая находка для любителей ярких вкусов, находящихся в поиске необычных десертов в спортивном и правильном питании. \r\n\r\nНежная основа батончика, содержащая протеин (концентрат и изолят сывороточного белка высокой степени очистки), мягчайшая начинка из орехов, и все это покрыто молочным шоколадом без сахара собственного производства. Яркий и насыщенный вкус при использовании только натуральных компонентов. Невероятное сочетание вкусов и натуральных ингредиентов - идеальный выбор для тех, кто следит за фигурой и хочет похудеть, не жертвуя вкусом ради пользы.',956.00,37,235,8),(38,'Протеиновые батончики Малиновый чизкейк','Классическая линейка Bombbar включает 17 разнообразных вкусов, среди которых можно без труда найти то, что придется по вкусу любому сладкоежке. В нашей линейке вы можете найти фруктовые и ягодные вкусы (клубника, манго и банан), а также десертные вкусы, такие как малиновый чизкейк, панкейк с черникой и смородиной, фисташковый пломбир и многие другие.',1027.00,37,10,9),(39,'Батончики с арахисовой пастой Mix Box Peanut','Шоколадные батончики Nattys &Go® Mix Box Peanut — это ассорти батончиков с арахисовой пастой внутри, покрытые слоем настоящего молочного шоколада без добавления сахара. Это очень вкусный, полезный и абсолютно натуральный перекус, который доставит много удовольствия и зарядит энергией! Теперь та самая арахисовая паста Nattys® всегда с собой, в удобной форме батончика to go — это вкусное и легкое лакомство, идеально для твоего полезного перекуса, без вреда для фигуры и здоровья, без сахара, создан из премиальных ингредиентов высшего качества, с честным и чистым составом. Nattys &Go® — это чистый заряд энергии и насыщение на длительное время. Источник растительного белка и клетчатки.',756.00,37,8,10),(40,'Протеиновые батончики \"Кокосовый торт\"','Протеиновые батончики Bombbar в натуральном шоколаде без добавленного сахара – невероятные десертные вкусы с высоким содержанием белка и минимумом быстрых углеводов. Эти небольшие помощники позволят сохранить чувство сытости между приемами пищи или в ситуациях, когда нет возможности полноценно пообедать. Сокращай калорийность перекусов вместе с Бомббар и худей эффективнее!',758.00,37,99,9);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_image`
--

DROP TABLE IF EXISTS `product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_image` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `product_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_image`
--

LOCK TABLES `product_image` WRITE;
/*!40000 ALTER TABLE `product_image` DISABLE KEYS */;
INSERT INTO `product_image` VALUES (3,'levelup_100.jpeg',5),(4,'maxler_100.jpg',6),(35,'8_1745839872_LqRpz6F71FwYq9QZOtuvStrNdMNGZPYb.webp',36),(36,'8_1745839872_eNFaGNGtJfrA71olPn9d8HZU7wFiGK5f.webp',36),(37,'8_1745839872_X-RXkqRKRXSHryClUODoFr3zeZzntGKA.webp',36),(39,'8_1745840018_1CA_PrKn7eTpoFOD38YgatSI7LQFl3zl.webp',36),(40,'8_1745861956_Wd7rrzfFkwTl_w7dBxf4cNUw8XKex3yx.webp',38),(41,'8_1745861956_QnGTCD-aa9QAX6yKMrjkvtmqgKve_9er.webp',38),(42,'8_1745862268_6qjqnIBledsIAgoXhIKggXOwgHKNueHZ.webp',39),(43,'8_1745862268_VHOwgiMMt9UFmIYTs6BUU3ObvIwms1Tt.webp',39),(44,'8_1745862268_zlDQKKVlb3qo9-Lt4pW4g-kwI30j8YDX.webp',39),(45,'8_1745943279_cNVHxUcdgOeVAqq8t_ZH4FrFSmm6yqSs.webp',40),(46,'8_1745943279_bK00KBFuSxAV9uNlZpeK2NZh8rdmhGfr.webp',40),(47,'8_1745943279_jEkuOaRyUwU1L3ccFE7Vix99H6iWVeaE.webp',40),(49,'8_1747300882_-QOhMyqo3_21pWoJnciTClJS1Bpny3Hx.webp',3),(50,'8_1747300882_kTtUH21vC7o97vS70k6NKxNaVD8ml_Uu.webp',3),(51,'8_1747300882_CmM88LUubz9YVkqG0US5D1K808UABGAH.webp',3),(52,'8_1747301440_Kb78SKJlqwAUzpJo52Eg64VKN0G7oLNS.webp',4);
/*!40000 ALTER TABLE `product_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_property`
--

DROP TABLE IF EXISTS `product_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_property` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `property_id` int unsigned NOT NULL,
  `property_value` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `property_id` (`property_id`),
  CONSTRAINT `product_property_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_property_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=363 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_property`
--

LOCK TABLES `product_property` WRITE;
/*!40000 ALTER TABLE `product_property` DISABLE KEYS */;
INSERT INTO `product_property` VALUES (59,38,105,'Малиновый чизкейк'),(60,38,107,'без сахара, без ГМО, без пальмового масла'),(61,38,89,'3.5'),(62,38,90,'4.3'),(63,38,91,'20'),(64,38,100,'174'),(65,38,88,'360'),(66,38,108,'12'),(67,39,105,'Ассорти, Арахисовое печенье, Шоколадный брауни, Соленая карамель, Воздушная кукуруза'),(68,39,107,'    без сахара, без ГМО, без консервантов, без пальмового масла'),(69,39,89,'20.7'),(70,39,90,'15.7'),(71,39,91,'7.2'),(72,39,100,'252'),(73,39,88,'274'),(74,39,108,'12'),(75,36,105,'Кокос'),(76,36,107,'без сахара, без ГМО, без пальмового масла'),(77,36,89,'3.5'),(78,36,90,'12'),(79,36,91,'15'),(80,36,100,'224'),(81,36,88,'360'),(82,36,108,'12'),(91,40,105,'Кокосовый торт'),(92,40,107,'без сахара, без ГМО, без пальмового масла'),(93,40,89,'2.6'),(94,40,90,'6.9'),(95,40,91,'10'),(96,40,100,'142'),(97,40,88,'360'),(98,40,108,'12'),(352,3,89,'1.5'),(353,3,90,'0.5'),(354,3,91,'23.4'),(355,3,92,'В сухом темном месте, При температуре от +10`С до +25`С'),(356,3,94,'6,2 г'),(357,3,95,'< 1,8 мкг'),(358,3,96,'< 0,3 мг'),(359,3,97,'0,1 мг'),(360,3,98,'30 мг'),(361,3,99,'648 мг'),(362,3,100,'105 ккал/441 кДж');
/*!40000 ALTER TABLE `product_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `property` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property`
--

LOCK TABLES `property` WRITE;
/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` VALUES (94,'BCAA'),(91,'Белок: грамм в 1 порции'),(95,'Витамин A'),(96,'Витамин С'),(106,'Вку'),(105,'Вкус'),(97,'Железо'),(90,'Жиры: грамм в 1 порции'),(99,'Кальций'),(108,'Количество в упаковке'),(98,'Натрий'),(107,'Не содержит'),(93,'Пищевая ценность'),(88,'Срок годности'),(89,'Углеводы: грамм в 1 порции'),(92,'Условия хранения'),(87,'Форма выпуска'),(100,'Энергетическая ценность');
/*!40000 ALTER TABLE `property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stars` enum('1','2','3','4','5') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `review` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (25,5,3,'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.','5',NULL,'2025-04-07 18:48:51'),(26,5,3,'Thanks a lot!',NULL,25,'2025-04-07 18:49:07'),(27,5,3,'123','4',NULL,'2025-04-07 18:50:33'),(28,5,3,'Очень вкусный казеин','5',NULL,'2025-04-07 20:04:26'),(81,5,3,'123',NULL,28,'2025-05-10 22:59:03'),(82,5,3,'123','3',NULL,'2025-05-10 22:59:11'),(83,5,3,'432',NULL,82,'2025-05-10 23:01:59'),(84,5,3,'321','5',NULL,'2025-05-10 23:02:06'),(85,5,4,'Всё очень хорошо!','5',NULL,'2025-05-18 15:22:34'),(86,5,4,'Дополнние комментария',NULL,85,'2025-05-18 15:22:53'),(87,5,4,'Норм','3',NULL,'2025-05-18 15:23:08'),(88,5,4,'Тест','1',NULL,'2025-05-18 15:23:33'),(89,5,4,'3','4',NULL,'2025-05-18 15:23:48'),(90,8,3,'Комментарий администратора',NULL,84,'2025-05-24 19:33:45');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'admin'),(2,'user');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bg_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Новый','primary'),(2,'В пути','warning'),(3,'Доставлен','success'),(4,'Доставка перенесена','danger');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typepay`
--

DROP TABLE IF EXISTS `typepay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `typepay` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typepay`
--

LOCK TABLES `typepay` WRITE;
/*!40000 ALTER TABLE `typepay` DISABLE KEYS */;
INSERT INTO `typepay` VALUES (1,'Наличные'),(2,'Банковская карта'),(3,'QR-код');
/*!40000 ALTER TABLE `typepay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int unsigned NOT NULL,
  `auth_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (5,'Иван','Лешок','demo-user1','demo-user1@das.asd','$2y$13$SDCJZly9BBPs9YqfsJ21JuDcEWyLDmfY193SxbF8GPaCXicMz90sa',2,'PcaBy_HxQYor6eb78FNlucc9gBgojYHU'),(8,'Иван','Иванов','sport-admin','sport-admin@ya.ru','$2y$13$BUatqydPPhZ5GfWplUSkLu1i9slljUcfFown/orwKJJ3tFtZ8FovO',1,'gV5gIpTLjp0_m0YizR78_PmfhkF40W_i');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-24 22:35:31
