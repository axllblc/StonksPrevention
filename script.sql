#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Parcours
#------------------------------------------------------------

CREATE TABLE Parcours(
        idParcours          Int  Auto_increment  NOT NULL ,
        nomParcours         Varchar (50) NOT NULL ,
        descriptionParcours Varchar (50) NOT NULL ,
        etapeTeteParcours   Int NOT NULL
	,CONSTRAINT Parcours_PK PRIMARY KEY (idParcours)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Etape
#------------------------------------------------------------

CREATE TABLE Etape(
        idEtape          Int  Auto_increment  NOT NULL ,
        typeEtape        Enum ("questionLibre","QCM","plusOuMoins","vraiFaux") NOT NULL ,
        texteEtape       Varchar (50) NOT NULL ,
        imageEtape       Varchar (50) NOT NULL ,
        pointMaxEtape    Int NOT NULL ,
        explicationEtape Varchar (50) NOT NULL ,
        ordreEtape       Int NOT NULL ,
        nomEtape         Varchar (50) NOT NULL ,
        idParcours       Int NOT NULL
	,CONSTRAINT Etape_AK UNIQUE (nomEtape)
	,CONSTRAINT Etape_PK PRIMARY KEY (idEtape)

	,CONSTRAINT Etape_Parcours_FK FOREIGN KEY (idParcours) REFERENCES Parcours(idParcours)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Choix
#------------------------------------------------------------

CREATE TABLE Choix(
        idChoix    Int  Auto_increment  NOT NULL ,
        nomChoix   Varchar (50) NOT NULL ,
        pointChoix Int NOT NULL ,
        idEtape    Int NOT NULL
	,CONSTRAINT Choix_PK PRIMARY KEY (idChoix)

	,CONSTRAINT Choix_Etape_FK FOREIGN KEY (idEtape) REFERENCES Etape(idEtape)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        idUtilisateur         Int  Auto_increment  NOT NULL ,
        motDePasseUtilisateur Varchar (150) NOT NULL ,
        pseudoUtilisateur     Varchar (50) NOT NULL
	,CONSTRAINT Utilisateur_AK UNIQUE (pseudoUtilisateur)
	,CONSTRAINT Utilisateur_PK PRIMARY KEY (idUtilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: tentative
#------------------------------------------------------------

CREATE TABLE tentative(
        idTentative   Int  Auto_increment  NOT NULL ,
        idUtilisateur Int NOT NULL
	,CONSTRAINT tentative_PK PRIMARY KEY (idTentative)

	,CONSTRAINT tentative_Utilisateur_FK FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: tentaivechoix
#------------------------------------------------------------

CREATE TABLE tentaivechoix(
        idChoix     Int NOT NULL ,
        idTentative Int NOT NULL
	,CONSTRAINT tentaivechoix_PK PRIMARY KEY (idChoix,idTentative)

	,CONSTRAINT tentaivechoix_Choix_FK FOREIGN KEY (idChoix) REFERENCES Choix(idChoix)
	,CONSTRAINT tentaivechoix_tentative0_FK FOREIGN KEY (idTentative) REFERENCES tentative(idTentative)
)ENGINE=InnoDB;

