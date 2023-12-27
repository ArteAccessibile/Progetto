USE fgiacomutest;

DROP TABLE IF EXISTS preferito;
DROP TABLE IF EXISTS opera;
DROP TABLE IF EXISTS artista;
DROP TABLE IF EXISTS utente;


CREATE TABLE utente (
    email varchar(40) PRIMARY KEY,
    psw char(64) NOT NULL,
    nome varchar(20) NOT NULL,
    cognome varchar(20) NOT NULL,
    data_nascita date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET = utf8;;

CREATE TABLE artista (
    utente varchar(40) PRIMARY KEY REFERENCES utente(email),
    descrizione TEXT NOT NULL,
    pseudonimo varchar(30),
    email_contatto varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET = utf8;;

CREATE TABLE opera (
    id INT PRIMARY KEY AUTO_INCREMENT,
    artista varchar(40) REFERENCES artista(utente) NOT NULL,
    titolo varchar(50) NOT NULL,
    desc_abbrev varchar(200) NOT NULL,
    descrizione TEXT NOT NULL,
    data_creazione date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET = utf8;;

CREATE TABLE preferito (
    utente varchar (40) REFERENCES utente(email),
    opera BIGINT REFERENCES opera(id),
    PRIMARY KEY (utente, opera)
) ENGINE=InnoDB DEFAULT CHARSET = utf8;;

ALTER TABLE opera ADD UNIQUE (titolo, artista);

