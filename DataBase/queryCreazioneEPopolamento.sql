
USE fgiacomu; 
-- cambiare con il nome del database 

DROP TABLE if EXISTS utente;
DROP TABLE if EXISTS opera;
DROP TABLE if EXISTS preferito;
DROP TABLE if EXISTS artista;

-- Crea la tabella utente
CREATE TABLE utente (
    email varchar(40) PRIMARY KEY,
    psw char(64) NOT NULL,
    nome varchar(20) NOT NULL,
    cognome varchar(20) NOT NULL,
    ruolo ENUM('utente', 'admin') NOT NULL DEFAULT 'utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Inserisci valori nella tabella utente
INSERT INTO `utente` (`email`, `psw`, `nome`, `cognome`, `ruolo`) VALUES
('admin@gmail.com', '0c3e748f8e81a1bacce40b099971ee9b', 'Admin', 'Admin', 'admin'),
('artist@gmail.com', 'd06139ee930b89fd2a00bfa0a40831aa', 'Artist', 'Artist', 'utente'),
('user@gmail.com', '3aa93b8f8e9e599c9c7d4240acba8696', 'user', 'user', 'utente');


-- Crea la tabella artista
CREATE TABLE artista (
    utente varchar(40) PRIMARY KEY REFERENCES utente(email) ON DELETE CASCADE,
    descrizione TEXT NOT NULL,
    pseudonimo varchar(30),
    email_contatto varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Inserisci valori nella tabella artista
INSERT INTO `artista` (`utente`, `descrizione`, `pseudonimo`, `email_contatto`) VALUES
('artist@gmail.com', 'Il mio percorso per diventare artista inizi&ograve; con l&#039;avvento dell&#039;intelligenza artificiale nella creazione delle immagini. Da quel momento, &egrave; diventata la mia ragione di vita.', 'Artista con Pseudonimo', 'ArtistaPseudonimo@gmail.com');


-- Crea la tabella opera
CREATE TABLE opera (
    id INT PRIMARY KEY AUTO_INCREMENT,
    artista varchar(40) NOT NULL,
    titolo varchar(50) NOT NULL,
    desc_abbrev varchar(75) NOT NULL,
    descrizione TEXT NOT NULL,
    data_creazione date NOT NULL,
    FOREIGN KEY (artista) REFERENCES artista(utente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Inserisci valori nella tabella opera



-- Crea la tabella preferito
CREATE TABLE preferito (
    utente varchar(40) REFERENCES utente(email) ON DELETE CASCADE,
    opera INT REFERENCES opera(id),
    PRIMARY KEY (utente, opera)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Inserisci valori nella tabella preferito

