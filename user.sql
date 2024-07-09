SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Kreiranje baze
CREATE DATABASE IF NOT EXISTS `user`;

USE `user`;

-- Tabela za gadgete

CREATE TABLE `gadget` (
    `idGadget` int(11) NOT NULL,
    `idTip` int(11) NOT NULL,
    `idProizvodjac` int(11) NOT NULL,
    `model` varchar(255) NOT NULL,
    `cena` int(11) NOT NULL,
    `kolicina` int(11) NOT NULL,
    `image` varchar(255) NOT NULL,
    `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `gadget` (`idGadget`, `idTip`, `idProizvodjac`, `model`, `cena`, `kolicina`, `image`) VALUES
(1, 1, 1, '14 Pro Max', 164990, 5, "apple1.jpg"),
(2, 1, 2, 'S24 Ultra', 142990, 7, "s24.jpg"),
(3, 5, 1, 'MacBook', 390990, 3, "laptop.jpg");

-- Tabela za korisnika

CREATE TABLE `korisnik` (
    `idKorisnik` int(11) NOT NULL,
    `imePrezime` varchar(255) NOT NULL,
    `idUloge` int(11) NOT NULL,
    `username` varchar(255) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `aktivan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `korisnik` (`idKorisnik`, `imePrezime`, `idUloge`, `username`, `password`, `aktivan`) VALUES
(1, 'Nikola Pajovic', 1, 'nikola', 'nikola', 1),
(2, 'John Doe', 2, 'john', 'john123', 1);

-- Tabela za cart

CREATE TABLE `cart` (
    `id` int(11) NOT NULL,
    `idGadget` int(11) NOT NULL,
    `idKorisnik` int(11) NOT NULL,
    `kolicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cart` (`id`, `idGadget`, `idKorisnik`, `kolicina`) VALUES
(3, 1, 2, 2),
(4, 2, 1, 4);

-- Tabela za s_proizvodjac

CREATE TABLE `s_proizvodjac` (
    `id` int(11) NOT NULL,
    `proizvodjac` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `s_proizvodjac` (`id`, `proizvodjac`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Huawei'),
(4, 'Honor'),
(5, 'Nokia');

-- Tabela za s_tip

CREATE TABLE `s_tip` (
    `id` int(11) NOT NULL,
    `tip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `s_tip` (`id`, `tip`) VALUES
(1, 'Telefon'),
(2, 'Televizor'),
(3, 'Slusalice'),
(4, 'Mis'),
(5, 'Laptop');

-- Kreiranje tabele za uloge korisnika

CREATE TABLE `uloge` (
    `idUloge` int(11) NOT NULL,
    `uloga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `uloge` (`idUloge`, `uloga`) VALUES
(1, 'Administrator'),
(2, 'Korisnik');

ALTER TABLE `gadget` ADD PRIMARY KEY(`idGadget`);
ALTER TABLE `korisnik` ADD PRIMARY KEY(`idKorisnik`);
ALTER TABLE `cart` ADD PRIMARY KEY(`id`);
ALTER TABLE `s_proizvodjac` ADD PRIMARY KEY(`id`);
ALTER TABLE `s_tip` ADD PRIMARY KEY (`id`);
ALTER TABLE `uloge` ADD PRIMARY KEY (`idUloge`);

ALTER TABLE `gadget` MODIFY `idGadget` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `korisnik` MODIFY `idKorisnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `cart` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `s_proizvodjac` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `s_tip` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `uloge` MODIFY `idUloge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
