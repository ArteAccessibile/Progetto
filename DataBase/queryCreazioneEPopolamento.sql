
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
INSERT INTO utente (email, psw, nome, cognome) VALUES
('email1@example.com', 'password1', 'Nome1', 'Cognome1'),
('email2@example.com', 'password2', 'Nome2', 'Cognome2'),
('admin@gmail.com','admin','admin','admin');

-- Crea la tabella artista
CREATE TABLE artista (
    utente varchar(40) PRIMARY KEY REFERENCES utente(email) ON DELETE CASCADE,
    descrizione TEXT NOT NULL,
    pseudonimo varchar(30),
    email_contatto varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Inserisci valori nella tabella artista
INSERT INTO artista (utente, descrizione, pseudonimo, email_contatto) VALUES
('email1@example.com', 'Descrizione artista 1', 'Pseudonimo1', 'email_artista1@example.com'),
('email2@example.com', 'Descrizione artista 2', 'Pseudonimo2', 'email_artista2@example.com');

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
INSERT INTO opera (artista, titolo, desc_abbrev, descrizione, data_creazione) VALUES
('email1@example.com', 'gattobaguette ', 'Descrizione abbreviata opera 1', 'Descrizione opera 1', '2023-01-01'),
('email2@example.com', 'gattomirtillo', 'Descrizione abbreviata opera 2', 'Descrizione opera 2', '2023-02-02');

-- Crea la tabella preferito
CREATE TABLE preferito (
    utente varchar(40) REFERENCES utente(email) ON DELETE CASCADE,
    opera INT REFERENCES opera(id),
    PRIMARY KEY (utente, opera)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Inserisci valori nella tabella preferito
INSERT INTO preferito (utente, opera) VALUES
('email1@example.com', 1),
('email2@example.com', 2);
