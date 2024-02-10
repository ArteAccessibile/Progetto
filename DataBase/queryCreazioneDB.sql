
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
    data_nascita date NOT NULL,
    ruolo ENUM('utente', 'admin') NOT NULL DEFAULT 'utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Crea la tabella artista
CREATE TABLE artista (
    utente varchar(40) PRIMARY KEY REFERENCES utente(email) ON DELETE CASCADE,
    descrizione TEXT NOT NULL,
    pseudonimo varchar(30),
    email_contatto varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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


-- Crea la tabella preferito
CREATE TABLE preferito (
    utente varchar (40) REFERENCES utente(email) ON DELETE CASCADE,
    opera BIGINT REFERENCES opera(id),
    PRIMARY KEY (utente, opera)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


