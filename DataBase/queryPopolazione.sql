INSERT INTO utente (email, psw, nome, cognome, data_nascita)
VALUES ('piero.infelice@gmail.com', 'b133a0c0e9bee3be20163d2ad31d6248db292aa6dcb1ee087a2aa50e0fc75ae2', 'Piero', 'Infelice', '2000-01-01');

INSERT INTO utente (email, psw, nome, cognome, data_nascita)
VALUES ('polnareff@gmail.com', 'b133a0c0e9bee3be20163d2ad31d6248db292aa6dcb1ee087a2aa50e0fc75ae2', 'Jean Pier', 'Polnareff', '1964-05-19');

INSERT INTO utente (email, psw, nome, cognome, data_nascita)
VALUES ('guido.mista@gmail.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Guido', 'Mista', '1982-12-3');

INSERT INTO utente (email, psw, nome, cognome, data_nascita)
VALUES ('mario.zucchero@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Mario', 'Zucchero', '1976-06-21');

INSERT INTO utente (email, psw, nome, cognome, data_nascita)
VALUES ('leone.abbacchio@gmail.com', '26ccf95ce773dc1f4d1a593bd561ecafcb1f2373b372f45d384dddbf200e92ad', 'Leone', 'Abbacchio', '1980-03-25');



INSERT INTO artista (utente, descrizione, pseudonimo, email_contatto)
values ('polnareff@gmail.com','Jean Pier Polnareff è un artista francese nato nel 1964 a Parigi. Si è laureato all’École nationale supérieure des beaux-arts nel 1986 e ha iniziato a esporre le sue opere in varie gallerie d’arte in Francia e all’estero. Il suo stile è caratterizzato da una forte influenza impressionista, con l’uso di colori vivaci e pennellate rapide per catturare la luce e l’atmosfera dei paesaggi francesi.Jean Pier Polnareff è considerato uno dei più importanti artisti contemporanei francesi, apprezzato per la sua capacità di trasmettere la bellezza e la poesia dei paesaggi del suo paese.','Polnareff','polnareff@arte.fr');

INSERT INTO artista (utente, descrizione,email_contatto)
values ('leone.abbacchio@gmail.com','Leone Abbacchio è un artista italiano nato nel 1980 a Roma. Si è laureato in Belle Arti presso l’Accademia di Roma e ha iniziato la sua carriera come poliziotto. Dopo aver subito un trauma durante il servizio, ha deciso di dedicarsi alla pittura come forma di terapia e di espressione. La sua opera si concentra principalmente sul tema delle forze dell’ordine, sia come eroi che come vittime, e sulle sfide che devono affrontare nella società moderna. Abbacchio utilizza tecniche miste, come olio, acrilico, collage e graffiti, per creare opere dinamiche e realistiche che catturano l’attenzione dello spettatore. Abbacchio ha esposto le sue opere in diverse gallerie e musei in Italia e all’estero, ricevendo numerosi premi e riconoscimenti. Attualmente vive e lavora a Milano.','leone@arte.it');



INSERT INTO opera (artista, titolo, desc_abbrev, descrizione, data_creazione)
VALUES ('polnareff@gmail.com','Tramonto','Opera rappresentante la città natale dell''artista Polnareff, travolta dal tramonto','L’opera d’arte è dipinta con pennellate rapide e leggere, tipiche dello stile di Ponareff. I colori sono vivaci e luminosi, e riflettono le sfumature del cielo al tramonto. Il paesaggio è composto da una serie di case basse e accoglienti, circondate da alberi e campi. Al centro del quadro, si vede una chiesa con un campanile, che sembra essere il punto di riferimento del villaggio. Sullo sfondo, si intravedono le colline e le montagne, che creano un contrasto con il cielo rosato. L’opera d’arte trasmette un senso di pace e armonia, e invita lo spettatore a immaginare la vita semplice e tranquilla degli abitanti del paese natale del pittore.','1992-06-11');

INSERT INTO opera (artista, titolo, desc_abbrev, descrizione, data_creazione)
VALUES ('polnareff@gmail.com','Malinconia','Opera rappresentante la Parigi degli anni ''90, in una giornata grigia','L’opera d’arte è un dipinto ad olio su tela, che raffigura una scena di Parigi negli anni 90, in una giornata grigia. Lo stile è impressionista, con pennellate veloci e sfocate, che creano un effetto di luce e movimento. Il punto di vista è quello di un osservatore che si trova su un ponte sul fiume Senna, e guarda verso la riva destra. Si vedono alcuni edifici storici, come il Louvre, il Palais Royal e il Museo d’Orsay, che si stagliano sullo sfondo grigio del cielo. Sul fiume, si notano alcune barche e dei riflessi dell’acqua. In primo piano, si vedono alcuni pedoni e ciclisti, che attraversano il ponte o si fermano a guardare il panorama. L’opera d’arte esprime un senso di nostalgia e malinconia, ma anche di vitalità e bellezza, tipici della città di Parigi.','1995-11-2');

INSERT INTO opera (artista, titolo, desc_abbrev, descrizione, data_creazione)
VALUES ('leone.abbacchio@gmail.com','Eroe','L''opera è un elogio alle forze dell''ordine e rappresenta un poliziotto che aiuta un anziana ad attraversare la strada','L’opera d’arte è un dipinto ad olio su tela, che raffigura una scena di solidarietà e altruismo. Un poliziotto in divisa, con un cappello e una pistola alla cintura, aiuta una vecchietta ad attraversare la strada. La vecchietta ha i capelli bianchi, un vestito a fiori e una borsa a tracolla. Il poliziotto le tiene la mano e la guida con gentilezza, mentre guarda il traffico. La strada è piena di auto, moto e autobus, che si fermano per lasciare passare i due. Nel cielo, si vedono delle nuvole bianche e azzurre, e degli angeli con le ali e le aureole, che indicano il poliziotto con le mani. Gli angeli hanno dei volti sorridenti e benevoli, e sembrano apprezzare il gesto del poliziotto. L’opera d’arte esprime un senso di gratitudine e ammirazione, e suggerisce che il poliziotto sia un eroe del quotidiano, che merita il rispetto e la benedizione degli angeli.','2005-10-12');

INSERT INTO opera (artista, titolo, desc_abbrev, descrizione, data_creazione)
VALUES ('leone.abbacchio@gmail.com','Ultima sera','L''opera raffigura l''artista ai tempi in cui era ancora in servizio, davanti ad una stazione di polizia durante una serata nebbiosa','L’opera d’arte è una pittura di stile realista. Il colore dominante è il blu, che crea un’atmosfera di malinconia e nostalgia. Il poliziotto è al centro della scena, vestito con la sua divisa e il suo berretto. Dietro di lui, si vede la stazione di polizia, illuminata da una luce fioca. La nebbia avvolge tutto, rendendo la scena sfocata e misteriosa. L’opera d’arte trasmette il senso di perdita e di identità dell’artista, che ha dovuto abbandonare la sua carriera a causa di un evento tragico.','2004-11-01');


INSERT INTO preferito(utente,opera) VALUES ('piero.infelice@gmail.com','2');
INSERT INTO preferito(utente,opera) VALUES ('mario.zucchero@gmail.com','1');





