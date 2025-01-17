CREATE TABLE campagne(
   id_campagne INT AUTO_INCREMENT,
   code_campagne VARCHAR(255),
   nom_campagne VARCHAR(255),
   created_at DATE,
   modify_at DATE,
   PRIMARY KEY(id_campagne)
);

CREATE TABLE apporteur(
   id_apporteur INT AUTO_INCREMENT,
   code_apporteur VARCHAR(255),
   nom_apporteur VARCHAR(255),
   created_at DATE,
   modify_at DATE,
   PRIMARY KEY(id_apporteur)
);

CREATE TABLE campagne_apporteur(
   id_campagne INT,
   id_apporteur INT,
   PRIMARY KEY(id_campagne, id_apporteur),
   FOREIGN KEY(id_campagne) REFERENCES campagne(id_campagne),
   FOREIGN KEY(id_apporteur) REFERENCES apporteur(id_apporteur)
);
