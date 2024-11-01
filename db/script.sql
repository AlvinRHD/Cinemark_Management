CREATE DATABASE  IF NOT EXISTS `cinemark_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinemark_db`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cinemark_db
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `funciones`
--

DROP TABLE IF EXISTS `funciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funciones` (
  `id_funcion` int NOT NULL AUTO_INCREMENT,
  `id_pelicula` int DEFAULT NULL,
  `id_sala` int DEFAULT NULL,
  `horario` time NOT NULL,
  `fecha` date NOT NULL,
  `asientos_ocupados` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `precio` decimal(10,2) NOT NULL DEFAULT '10.00',
  PRIMARY KEY (`id_funcion`),
  KEY `id_pelicula` (`id_pelicula`),
  KEY `id_sala` (`id_sala`),
  CONSTRAINT `funciones_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id_pelicula`),
  CONSTRAINT `funciones_ibfk_2` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funciones`
--

LOCK TABLES `funciones` WRITE;
/*!40000 ALTER TABLE `funciones` DISABLE KEYS */;
INSERT INTO `funciones` VALUES (8,9,2,'19:44:00','2024-10-30',NULL,10.00),(17,10,5,'16:03:00','2024-10-31','[\"5\"]',30.00),(18,10,5,'16:03:00','2024-10-31','[\"4\"]',30.00),(19,10,5,'16:03:00','2024-10-31','[\"5\",\"5\",\"1\",\"2\",\"3\",\"4\",\"5\",\"5\",\"5\",\"5\",\"5\"]',30.00),(20,11,5,'12:08:00','2024-11-01','[\"1\",\"2\",\"3\",\"4\",\"5\"]',2.99),(21,5,6,'13:10:00','2024-11-02',NULL,5.00),(22,6,7,'18:05:00','2024-11-01',NULL,5.00),(23,8,8,'12:30:00','2024-11-03',NULL,5.00),(24,12,10,'01:05:00','2024-11-02',NULL,5.00),(25,13,1,'12:10:00','2024-11-05','[\"1\"]',5.00),(26,14,6,'18:10:00','2024-10-28',NULL,5.00),(27,15,6,'19:10:00','2024-10-29',NULL,5.00),(28,16,8,'15:30:00','2024-10-29',NULL,5.00),(29,17,6,'16:40:00','2024-10-31',NULL,5.00),(30,18,7,'20:15:00','2024-10-31',NULL,5.00),(31,16,10,'22:00:00','2024-11-05',NULL,5.00),(32,20,9,'13:15:00','2024-11-01',NULL,5.00),(33,21,8,'11:15:00','2024-11-03',NULL,3.50),(34,22,10,'10:15:00','2024-11-02','[\"34\"]',3.50);
/*!40000 ALTER TABLE `funciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peliculas`
--

DROP TABLE IF EXISTS `peliculas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peliculas` (
  `id_pelicula` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `duracion` int DEFAULT NULL,
  `clasificacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `genero` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_pelicula`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peliculas`
--

LOCK TABLES `peliculas` WRITE;
/*!40000 ALTER TABLE `peliculas` DISABLE KEYS */;
INSERT INTO `peliculas` VALUES (5,'Intensa Mente 2','Secuela de \'Inside Out\'. Riley entra en la adolescencia y el Cuartel General de su cabeza sufre una repentina reforma para hacerle hueco a algo totalmente inesperado propio de la pubertad: ¡Nuevas emociones! Alegría, Tristeza, Ira, Miedo y Asco, con años de impecable gestión a sus espaldas (según ellos...) no saben muy bien qué sentir cuando aparece con enorme ímpetu Ansiedad. Y no viene sola: le acompañan envidia, vergüenza y aburrimiento',88,'todas las edades','Animacion','intensamente.jpg'),(6,'Transformer ONE','Es la historia jamás contada del origen de Optimus Prime y Megatron y de cómo pasaron de ser hermanos de armas que cambiaron el destino de Cybertron para siempre, a convertirse en enemigos acérrimos.',103,'Para mayores de 13 años','Animacion}','transformer.jpg'),(8,'Haikyu!! La batalla del basurero','El encuentro entre los equipos rivales de Karasuno y Nekoma hará que la tensión aumente, ya que ambos equipos están decididos a salir victoriosos en el campeonato nacional de voleibol. Primera película del proyecto en dos partes para el final de \'Haikyu!\'',85,'para todas las edades','Anime','hayiku.jpg'),(9,'Deadpool y Wolverine','Un apático Wade Wilson se afana en la vida civil tras dejar atrás sus días como Deadpool, un mercenario moralmente flexible. Pero cuando su mundo natal se enfrenta a una amenaza existencial, Wade debe volver a vestirse a regañadientes con un Lobezno aún más reacio a ayudar.',127,'Para mayores de 18 años','Accion/comedia','deadpool.jpg'),(10,'Un espia y medio','Espias que van a una mision',60,'PG','Acción','unespiaymedio.jpg'),(11,'Cocolito','Es un payasito de el salvador que hace reir a la gente',60,'G','Comedia','cocolito.jpg'),(12,'Bastardos sin Gloria','Segunda Guerra Mundial (1939-1945). En la Francia ocupada por los alemanes, Shosanna Dreyfus (Mélanie Laurent) presencia la ejecución de su familia por orden del coronel Hans Landa (Christoph Waltz). Después de huir a París, adopta una nueva identidad como propietaria de un cine. En otro lugar de Europa, el teniente Aldo Raine (Brad Pitt) adiestra a un grupo de soldados judíos (\"The Basterds\") para atacar objetivos concretos. Los hombres de Raine y una actriz alemana (Diane Kruger), que trabaja para los aliados, deben llevar a cabo una misión para hacer caer a los jefes del Tercer Reich. El destino quiere que todos se encuentren bajo la marquesina de un cine donde Shosanna espera para vengarse.',127,'PG-13','Comedia/Drama','bastardos.jpg'),(13,'Django sin cadenas','En Texas, dos años antes de estallar la Guerra Civil Americana, King Schultz (Christoph Waltz), un cazarrecompensas alemán que sigue la pista a unos asesinos para cobrar por sus cabezas, le promete al esclavo negro Django (Jamie Foxx) dejarlo en libertad si le ayuda a atraparlos. Él acepta, pues luego quiere ir a buscar a su esposa Broomhilda (Kerry Washington), esclava en una plantación del terrateniente Calvin Candie (Leonardo DiCaprio).',165,'NC-17','Drama/Romance','django.jpg'),(14,'Volver al Futuro','El adolescente Marty McFly es amigo de Doc, un científico al que todos toman por loco. Cuando Doc crea una máquina para viajar en el tiempo, un error fortuito hace que Marty llegue a 1955, año en el que sus futuros padres aún no se habían conocido. Después de impedir su primer encuentro, deberá conseguir que se conozcan y se casen; de lo contrario, su existencia no sería posible. (FILMAFFINITY)',116,'PG-13','Ciencia ficción/Aventura','futuro.jpg'),(15,'Volver al Futuro II','Aunque a Marty McFly todavía le falta tiempo para asimilar el hecho de estar viviendo dentro de la familia perfecta gracias a su anterior viaje en el tiempo, no le queda ni espacio para respirar cuando su amigo Doc aparece de improviso con la máquina del tiempo (mucho más modernizada), e insta a que le acompañen él y su novia a viajar al futuro para solucionar un problema con la ley que tendrá uno de sus futuros hijos. En la tremenda vorágine futurista, con todo lo que ello conlleva, del Hill Valley de 2015, la presencia de tales viajeros temporales causará un efecto mayor que el que iban a arreglar. Un almanaque deportivo y la posesión del secreto de la existencia de la máquina del tiempo por parte del siempre villano Biff Tannen, serán los ingredientes que conjugarán una causa-efecto en el pasado, en el presente y en el propio futuro, que hará que Marty y Doc se tengan que emplear a fondo para poner fin a la catástrofe a la que les lleva el destino.',118,'PG-13','Ciencia ficción/Aventura','volver2.jpg'),(16,'Volver al Futuro III','Marty McFly sigue en 1955 y su amigo Doc ha retrocedido al año 1885, la época del salvaje oeste. Éste le envía una carta donde comenta que la máquina del tiempo está averiada, y que es imposible repararla. Sin embargo no le preocupa estar atrapado en el pasado, pues allí es muy feliz trabajando de herrero aunque convive con malhechores. Pero Marty descubre una vieja tumba en la que lee que Doc murió en 1885 y, sin pensárselo dos veces, irá a rescatar a su amigo.',118,'PG-13','Ciencia ficción/Aventura','volverIII.jpg'),(17,'Y que paso ayer?','Historia de una desmadrada despedida de soltero en la que el novio y tres amigos se montan una gran juerga en Las Vegas. Como era de esperar, a la mañana siguiente tienen una resaca tan monumental que no pueden recordar nada de lo ocurrido la noche anterior. Lo más extraordinario es que el novio ha desaparecido y en la suite del hotel se encuentran un tigre y un bebé.',100,'NC-17','Comedia','paso.jpg'),(18,'Y que paso ayer ? parte 2','Alan (Zach Galifianakas), Stu (Ed Helms) y Phil (Bradley Cooper) vuelven a despertarse en otra habitación de otro hotel y, para no perder la costumbre, en esta ocasión tampoco recuerdan nada. Esta vez sólo saben que están en Tailandia, adonde han viajado, junto a Doug (Justin Bartha), para asistir a la boda de Stu con Lauren (Jamie Chung). El principal problema: el hermano menor de Lauren, Teddy, ha desaparecido. Y para encontrarlo intentarán recomponer su noche anterior, que al parecer ha contado con monos, monjes, transexuales... y Chow (Ken Jeong), claro.',102,'NC-17','Comedia','quepaso2.jpg'),(19,'Y que paso ayer ? parte 3','Tras la inesperada muerte de su padre, Alan (Zach Galifianakis) es llevado por sus amigos Phil (Bradley Cooper), Stu (Ed Helms) y Doug (Justin Bartha) a un centro especializado para que mejore. Esta vez no hay boda ni fiesta de despedida ¿Qué puede ir mal? Pues que cuando estos chicos salen a la carretera, y sobre todo cuando aparece Chow (Ken Jeong)... la suerte está echada. Tercera entrega de la franquicia iniciada en 2009 con \'Resacón en Las Vegas\'.',100,'NC-17','Comedia','quepaso3.jpg'),(20,'ted','Cuando John Bennett (Mark Wahlberg) era pequeño, deseaba que su osito de peluche Ted fuera un oso de verdad y, por desgracia, su sueño se hizo realidad. Más de veinte años después, Ted sigue con John y saca de quicio a su novia Lori, que empieza a perder la paciencia. Para colmo, a John no parece preocuparle su futuro profesional y se pasa la vida fumando porros con Ted. A pesar de ello, John intenta alcanzar la madurez, pero parece que para conseguirlo le resulta indispensable la ayuda de Ted.',106,'NC-17','Comedia','ted.jpg'),(21,'ted 2','Recién casados, Ted y Tami-Lynn quieren tener un bebé. Pero antes de ser padre, Ted tendrá que demostrar ante un tribunal de justicia que es una persona. Secuela de la exitosa \"Ted\" ',115,'NC-17','Comedia','ted2.jpg'),(22,'Animales fantasticos y donde encontrarlos','Año 1926. Newt Scamander acaba de completar un viaje por todo el mundo para encontrar y documentar una extraordinaria selección de criaturas mágicas. Llegando a Nueva York para hacer una breve parada en su camino, donde podría haber llegado y salido sin incidentes… pero no para un Muggle llamado Jacob, un caso perdido de magia, y la fuga de algunas criaturas fantásticas de Newt, que podrían causar problemas el mundo mágico y en el mundo Muggle.',133,'PG-13','Fantasía','animales.jpg');
/*!40000 ALTER TABLE `peliculas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salas`
--

DROP TABLE IF EXISTS `salas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salas` (
  `id_sala` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `capacidad` int NOT NULL,
  `estado` enum('ocupada','disponible') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'disponible',
  PRIMARY KEY (`id_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salas`
--

LOCK TABLES `salas` WRITE;
/*!40000 ALTER TABLE `salas` DISABLE KEYS */;
INSERT INTO `salas` VALUES (1,'Sala Magnum 1',50,'disponible'),(2,'Sala Magnum 2',60,'ocupada'),(4,'Sala prueba',10,'disponible'),(5,'Sala vip',5,'disponible'),(6,'Sala 1',75,'disponible'),(7,'Sala 2',75,'disponible'),(8,'Sala 3D',50,'disponible'),(9,'Sala DX',50,'disponible'),(10,'Sala 3',75,'disponible');
/*!40000 ALTER TABLE `salas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contrasena` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rol` enum('administrador','empleado','gerente') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'empleado',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Alvin Rosales','alvin@gmail.com','$2y$10$UL9Zjos.Hd43PwCO4cjKaeAJzam5wco5jIQ4IZyYhAjR7K5pMEpaC','administrador'),(2,'Roberto Carlos','robert@gmail.com','$2y$10$usm8xkqwI6AvSPuOySfit.psc43u1K0W.Ty8QfVdA/cTOoYuu131u','gerente'),(4,'jorge','jorge@gmail.com','$2y$10$ShAICnLlheRbObKJbCCMMud0wS8mtA6Syj5udgC.wUdvhED/ZGyPW','empleado');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `id_funcion` int DEFAULT NULL,
  `cantidad_boletos` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `id_funcion` (`id_funcion`),
  CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_funcion`) REFERENCES `funciones` (`id_funcion`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (14,25,1,5.00,'2024-10-31');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-31 23:31:27
