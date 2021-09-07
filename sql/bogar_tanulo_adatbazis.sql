-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Sze 07. 18:12
-- Kiszolgáló verziója: 10.1.19-MariaDB
-- PHP verzió: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `bogar_tanulo_adatbazis`
--

CREATE SCHEMA `bogar_tanulo_adatbazis` ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `bogar`
--

CREATE TABLE `bogar_tanulo_adatbazis`.`bogar` (
  `id` int(11) NOT NULL,
  `nev` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `bogar`
--

INSERT INTO `bogar_tanulo_adatbazis`.`bogar` (`id`, `nev`) VALUES
(1, 'poloska'),
(2, 'katicabogar'),
(3, 'szarvasbogar'),
(4, 'hangya'),
(5, 'pok'),
(6, 'meh'),
(7, 'darazs'),
(8, 'kullancs'),
(9, 'krumplibogar'),
(10, 'tucsok'),
(11, 'saska'),
(12, 'szunyog'),
(13, 'legy');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `bogar_tanulo_adatbazis`.`felhasznalo` (
  `id` int(11) NOT NULL,
  `felhasznalo_nev` varchar(45) DEFAULT NULL,
  `jelszo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `bogar_tanulo_adatbazis`.`felhasznalo` (`id`, `felhasznalo_nev`, `jelszo`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kep`
--

CREATE TABLE `bogar_tanulo_adatbazis`.`kep` (
  `id` int(11) NOT NULL,
  `fajl_nev` varchar(45) DEFAULT NULL,
  `szelesseg_pixel` int(11) DEFAULT NULL,
  `magassag_pixel` int(11) DEFAULT NULL,
  `aranytavolsag_pixel` double DEFAULT NULL,
  `aranytavolsag_mm` double DEFAULT NULL,
  `felhasznalo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `kep`
--

INSERT INTO `bogar_tanulo_adatbazis`.`kep` (`id`, `fajl_nev`, `szelesseg_pixel`, `magassag_pixel`, `aranytavolsag_pixel`, `aranytavolsag_mm`, `felhasznalo_id`) VALUES
(21, 'images.jpg', 255, 198, 42.396251856930036, 22, 1),
(22, 'IMG_20201020_115132.jpg', 3840, 5120, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kivagas`
--

CREATE TABLE `bogar_tanulo_adatbazis`.`kivagas` (
  `id` int(11) NOT NULL,
  `kezdo_koordinata_x` double DEFAULT NULL,
  `kezdo_koordinata_y` double DEFAULT NULL,
  `szelesseg_pixel` double DEFAULT NULL,
  `magassag_pixel` double DEFAULT NULL,
  `ido` datetime DEFAULT NULL,
  `kep_id` int(11) DEFAULT NULL,
  `bogar_id` int(11) DEFAULT NULL,
  `felhasznalo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `kivagas`
--

INSERT INTO `bogar_tanulo_adatbazis`.`kivagas` (`id`, `kezdo_koordinata_x`, `kezdo_koordinata_y`, `szelesseg_pixel`, `magassag_pixel`, `ido`, `kep_id`, `bogar_id`, `felhasznalo_id`) VALUES
(2, 134.03110332293627, 116.16748582839361, 9.330176077545508, 18.66031229239984, '2021-09-07 17:30:06', 21, 6, 1),
(3, 106.33015991434394, 83.29786848993238, 14.300168212800743, 9.53344315768509, '2021-09-07 17:31:05', 21, 13, 1),
(4, 1962.2189374062966, 1948.977370689655, 112.07191716641714, 190.3689092953525, '2021-09-07 17:31:56', 22, 11, 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `bogar`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`bogar`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `felhasznalo`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`felhasznalo`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `kep`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`kep`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- A tábla indexei `kivagas`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`kivagas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`),
  ADD KEY `bogar_id` (`bogar_id`),
  ADD KEY `kep_id` (`kep_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `bogar`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`bogar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT a táblához `felhasznalo`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`felhasznalo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT a táblához `kep`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`kep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT a táblához `kivagas`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`kivagas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `kep`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`kep`
  ADD CONSTRAINT `fk_kep_felhasznalo` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`);

--
-- Megkötések a táblához `kivagas`
--
ALTER TABLE `bogar_tanulo_adatbazis`.`kivagas`
  ADD CONSTRAINT `fk_kivagas_bogar` FOREIGN KEY (`bogar_id`) REFERENCES `bogar` (`id`),
  ADD CONSTRAINT `fk_kivagas_felhasznalo` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`),
  ADD CONSTRAINT `fk_kivagas_kep` FOREIGN KEY (`kep_id`) REFERENCES `kep` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
