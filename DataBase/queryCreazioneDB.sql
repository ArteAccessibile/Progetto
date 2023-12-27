CREATE TABLE utente (
    email varchar(40) PRIMARY KEY,
    psw char(64) NOT NULL,
    nome varchar(20) NOT NULL,
    cognome varchar(20) NOT NULL,
    data_nascita date NOT NULL
);

CREATE TABLE artista (
    utente varchar(40) PRIMARY KEY REFERENCES utente(email),
    descrizione varchar NOT NULL,
    pseudonimo varchar(30),
    email_contatto varchar(30) NOT NULL
);

CREATE TABLE opera (
    id serial PRIMARY KEY,
    artista varchar(40) REFERENCES artista(utente) NOT NULL,
    titolo varchar(50) NOT NULL,
    desc_abbrev varchar(200) NOT NULL,
    descrizione varchar NOT NULL,
    data_creazione date NOT NULL
);

CREATE TABLE preferito (
    utente varchar (40) REFERENCES utente(email),
    opera BIGINT REFERENCES opera(id),
    PRIMARY KEY (utente, opera)
);

ALTER TABLE opera ADD UNIQUE (titolo, artista);

