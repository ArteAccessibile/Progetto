
USE arte_accessibile; 
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
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'utente'),
('artist', '0441f9e2d94c39a70e21b83829259aa4', 'artist', 'artist', 'utente'),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'user', 'utente');


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

