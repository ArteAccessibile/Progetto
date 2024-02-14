
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
('artist', 'Da quando ho scoperto che l&#039;intelligenza artificiale poteva creare immagini, non sono stato pi&ugrave; lo stesso. Era diventata la mia ragione di vita.', 'artist', 'artist@gmail.com');


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
INSERT INTO `opera` (`id`, `artista`, `titolo`, `desc_abbrev`, `descrizione`, `data_creazione`) VALUES
(1, 'artist', 'sere allegre in agosto', 'Ragazze in campo fiorito incantate dai fuochi d&#039;artificio', 'In mezzo a un profumato campo di fiori in una tranquilla notte d&#039;estate, una madre ed una figlia, una accanto all&#039;altra, con le spalle rivolte verso di noi, osservano con stupore lo spettacolo colorato dei fuochi d&#039;artificio che illuminano il cielo scuro. Le loro figure emanano un senso di meraviglia e gioia, le teste inclinate verso l&#039;alto, affascinate dalla spettacolare rappresentazione. In questo sereno momento, tra la bellezza  e la magia dei fuochi d&#039;artificio, si rinsalda un legame, creando un ricordo prezioso dell&#039;incanto estivo.', '2024-01-10'),
(3, 'artist', 'Sere_festive_di_agosto', 'Ragazze in campo fiorito incantate dai fuochi d&#039;artificio', 'In mezzo a un profumato campo di fiori in una tranquilla notte d&#039;estate, una madre ed una figlia, una accanto all&#039;altra, con le spalle rivolte verso di noi, osservano con stupore lo spettacolo colorato dei fuochi d&#039;artificio che illuminano il cielo scuro. Le loro figure emanano un senso di meraviglia e gioia, le teste inclinate verso l&#039;alto, affascinate dalla spettacolare rappresentazione. In questo sereno momento, tra la bellezza  e la magia dei fuochi d&#039;artificio, si rinsalda un legame, creando un ricordo prezioso dell&#039;incanto estivo.', '2024-02-10'),
(4, 'artist', 'Quiete_dopo_la_tempesta', 'Quiete dopo la tempesta. Arte impressionista.', 'In un capolavoro impressionista, il dopo tempesta si svela con una bellezza serena. Pennellate di toni tenui ritraggono un cielo che si schiarisce dai grigi tumultuosi a pastelli delicati, riflettendo la luce del sole che squarcia le nuvole dissipate. Gli alberi ondeggianno con grazia, mentre un fiume tranquillo serpeggia nel paesaggio, la sua superficie riflette il delicato gioco di luci e ombre. In mezzo alla pace, resti della tempesta persistono - un&#039;accozzaglia di rami caduti e la terra bagnata dalla pioggia - ma l&#039;insieme della scena trasuda un senso di rinnovamento, catturando l&#039;essenza senza tempo della resilienza della natura.', '2024-02-09'),
(5, 'artist', 'Venezia_disabitata', 'una Venezia disabitata.', 'In un&#039;immagine suggestiva di Venezia, &egrave; visibile l&#039;assenza del tocco umano da parecchio tempo. I canali, un tempo animati, giacciono stagnanti, soffocati da alghe e detriti, mentre i maestosi palazzi si sgretolano sotto il peso dell&#039;abbandono. La natura riafferma il suo dominio mentre le piante rampicanti si arrampicano sulle facciate in rovina, e il silenzio regna dove un tempo risuonava il suono del riso tra le strade labirintiche. Questo quadro spettrale parla di una citt&agrave; sospesa nel tempo, dove il passare dei secoli ha cancellato tutto tranne i malinconici sussurri della sua antica gloria.', '2024-02-08'),
(6, 'artist', 'NaturaModerna', 'Natura e macchine combinate in un paesaggio.', 'In questa opera d&#039;arte, l&#039;armonia tra natura e macchinari si svela in una fusione affascinante.  L&#039;aria vibra con il ritmo dei pistoni, mentre la flora convive con le meraviglie meccaniche in un mondo dove i confini tra naturale e artificiale si confondono in una sinfonia affascinante di innovazione e bellezza organica.', '2024-02-01'),
(7, 'artist', 'Umani_Contro_Macchine', 'Umanit&agrave; contro macchine', 'In un&#039;opera d&#039;arte ispirata allo stile steampunk, l&#039;umanit&agrave; si impegna in una guerra implacabile contro macchine senzienti. Mastodontici colossi meccanici si scontrano con controparti umane che utilizzano armi costruite con macchinari alimentati a vapore. Il paesaggio &egrave; un contrasto tra estetica vittoriana e tecnologia futuristica, dove fabbriche fumanti si mescolano a complessi meccanismi a orologeria. In questo ambiente alternativo si svolge la lotta per la sopravvivenza, echeggiando il conflitto senza tempo tra l&#039;uomo e le creazioni della sua stessa mano.', '2024-02-07'),
(8, 'artist', 'GattoGamberetto', 'Gamberetto con testa di gatto', 'In questa opera tanto simpatica quanto surreale, un gambero cotto assume un&#039;imprevista svolta con la testa di un gatto. La delicata carne rosa del gambero contrasta con il pelo e i baffi della testa del gatto, creando una bizzarra ma intrigante giustapposizione tra due creature distinte. Questa creazione surreale sfida la percezione dello spettatore, invitando alla contemplazione sui confini tra realt&agrave; e immaginazione.', '2024-02-03');



-- Crea la tabella preferito
CREATE TABLE preferito (
    utente varchar(40) REFERENCES utente(email) ON DELETE CASCADE,
    opera INT REFERENCES opera(id),
    PRIMARY KEY (utente, opera)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Inserisci valori nella tabella preferito

