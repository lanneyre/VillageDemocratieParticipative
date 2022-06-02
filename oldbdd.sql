CREATE DATABASE IF NOT EXISTS projet_village_remplis;

USE projet_village_remplis;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS villageois
(
    villageois_EMAIL VARCHAR(255) PRIMARY KEY UNIQUE NOT NULL,
    villageois_nom VARCHAR(255) NOT NULL,
    villageois_prenom VARCHAR(255) NOT NULL,
    villageois_adresse VARCHAR(255) NOT NULL,
    villageois_date_naissance DATE NOT NULL,
    villageois_mot_de_passe VARCHAR(255) NOT NULL,
    villageois_privilege ENUM('privilege_admin','privilege_user', 'privilege_moderateur') NOT NULL,
    villageois_mandat ENUM('mandat_habitant','mandat_elu','mandat_delegue') NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS periode
(
    periode_date_debut DATE NOT NULL,
    periode_date_fin DATE NOT NULL,
	type_periode ENUM('publier','voter') NOT NULL,
	PRIMARY KEY (periode_date_debut,periode_date_fin,type_periode)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categorie
(
    categorie_ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    categorie_nom VARCHAR(255) NOT NULL,
    categorie_description VARCHAR(255) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS proposition
(
    proposition_ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    proposition_etat ENUM('etat_refusee','etat_validee','etat_reexaminee','etat_en_attente') NOT NULL,
    proposition_titre VARCHAR(255),
    proposition_description TEXT NOT NULL DEFAULT '',
    proposition_date date NOT NULL,
    proposition_img VARCHAR(255),
    fk_villageois_EMAIL VARCHAR(255),
    fk_categorie_ID INT,
    fk_periode_date_debut DATE,
    fk_periode_date_fin DATE,
	fk_type_periode ENUM('publier','voter') NOT NULL,
    FOREIGN KEY(fk_villageois_EMAIL) REFERENCES villageois(villageois_EMAIL),
    FOREIGN KEY(fk_categorie_ID) REFERENCES categorie(categorie_ID),
	FOREIGN KEY(fk_periode_date_debut,fk_periode_date_fin,fk_type_periode) REFERENCES periode(periode_date_debut,periode_date_fin,type_periode)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS commentaire
(
    commentaire_ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    commentaire_texte VARCHAR(255)  NOT NULL,
    commentaire_date DATE NOT NULL,
    fk_proposition_ID INT NOT NULL,
	fk_villageois_EMAIL VARCHAR(255),
	FOREIGN KEY(fk_villageois_EMAIL) REFERENCES villageois(villageois_EMAIL),
    FOREIGN KEY(fk_proposition_ID) REFERENCES proposition(proposition_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS vote
(
    fk_villageois_EMAIL VARCHAR(255),
	fk_proposition_ID INT(11),
    FOREIGN KEY(fk_villageois_EMAIL) REFERENCES villageois(villageois_EMAIL),
	FOREIGN KEY(fk_proposition_ID) REFERENCES proposition(proposition_ID),
	PRIMARY KEY (fk_villageois_EMAIL,fk_proposition_ID),
    points_attribues ENUM('1','2','3'),
	vote_date DATE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- INSERT INTO villageois
--     (villageois_EMAIL,villageois_nom,villageois_prenom,villageois_adresse,villageois_date_naissance,villageois_mot_de_passe,villageois_privilege,villageois_mandat)
-- VALUES 
--     ("robert@siliconvilla.fr","Durand","Robert","14 rue du square 06450 Roquebilliere","2000-06-15","monpassword","privilege_user","mandat_habitant"),
--     ("yves@village.fr","barat","yves","18 rue du lapin blanc 06450 Roquebilliere","1988-07-02","yvespassword","privilege_user","mandat_habitant"),
--     ("julia@oclastone.com","Manala","Julia","17 chemin de l'eglise 06450 Roquebilliere","2001-05-13","passdejulia","privilege_user","mandat_habitant"),
--     ("nathalie@google.fr","Renarde","Nathalie","52 rue du Soleil 06450 Roquebilliere","2002-12-05","nathrenardepass","privilege_user","mandat_habitant"),
--     ("michael@hotmail.fr","Goliaty","michael","07 rue du square 06450 Roquebilliere","1958-08-27","Goliatypass","privilege_user","mandat_habitant"),
--     ("mohamed@vokia.fr","Mussafa","Mohamed","1 rue du Lac 06450 Roquebilliere","1997-05-11","mohamedpass","privilege_moderateur","mandat_elu"),
--     ("johnadmin@roquebilliere.fr","Supreme","John","1 rue du Master 06450 Roquebilliere","1999-07-12","adminpass","privilege_admin","mandat_delegue");
    
-- INSERT INTO periode
-- 	(periode_date_debut,periode_date_fin,type_periode)
-- VALUES
-- 	("2022-07-01","2022-09-15","publier"),
-- 	("2022-09-16","2022-09-30","voter");
	
-- INSERT INTO categorie
-- 	(categorie_nom,categorie_description)
-- VALUES
-- 	("INFRASTRUCTURE","dapter l'habitat urbain aux besoins des hommes."),
-- 	("VIE COMMUNE","evenements et tout autre activitées qui te fait plaisir"),
-- 	("ASSOCIATIONS","informer les villageois des activités et propositions");
	
-- INSERT INTO proposition
-- 	(proposition_etat,proposition_titre,proposition_description,proposition_date,proposition_img,fk_villageois_EMAIL,fk_categorie_ID,fk_periode_date_debut,fk_periode_date_fin,fk_type_periode)
-- VALUES
-- 	("etat_en_attente","je veux du chocolat","c'est super le chocolat et il m'en faut ce mois-ci !!!","2022-07-10","","robert@siliconvilla.fr",2,"2022-07-01","2022-09-15","publier"),
-- 	("etat_en_attente","je veux du lait","avoir plus de lait ca serait pas mal !","2022-07-15","","nathalie@google.fr",2,"2022-07-01","2022-09-15","publier"),
-- 	("etat_en_attente","il faut refaire la route devant le bar des amis du loto","c'est une catastrophe et c'est dangereux !","2022-08-18","","yves@village.fr",1,"2022-07-01","2022-09-15","publier"),
-- 	("etat_en_attente","nouvelle assication des amis de la biere","ici on trouve les amateurs des meilleures bieres du monde","2022-08-21","","michael@hotmail.fr",3,"2022-07-01","2022-09-15","publier");

    
-- INSERT INTO commentaire
-- 	(commentaire_texte,commentaire_date,fk_villageois_EMAIL,fk_proposition_ID)
-- VALUES
-- 	("on est pas sortis de l'auberge","2022-07-12","nathalie@google.fr",1),
-- 	("mais non je suis pas d'accord il nous faut du chocolat","2022-07-13","julia@oclastone.com",1);
	
	
	
	
