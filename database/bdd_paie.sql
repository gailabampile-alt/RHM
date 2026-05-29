-- MySQL dump 10.13  Distrib 5.7.17, for Win32 (AMD64)
--
-- Host: localhost    Database: bdd_paie
-- ------------------------------------------------------
-- Server version	5.7.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `bdd_paie`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `bdd_paie` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `bdd_paie`;

--
-- Temporary view structure for view `calcule_paie`
--

DROP TABLE IF EXISTS `calcule_paie`;
/*!50001 DROP VIEW IF EXISTS `calcule_paie`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `calcule_paie` AS SELECT 
 1 AS `Matricule`,
 1 AS `nom_ag`,
 1 AS `postnom_ag`,
 1 AS `prenom_ag`,
 1 AS `MontantSalaire`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie` (
  `id_cat` int(5) NOT NULL AUTO_INCREMENT,
  `lib_categorie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_activ`
--

DROP TABLE IF EXISTS `detail_agent_activ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_activ` (
  `id_det_ag_activite` int(11) NOT NULL AUTO_INCREMENT,
  `code_activ_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_byte` longtext COLLATE utf8mb4_unicode_ci,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_det_ag_activite`),
  KEY `idx_da_agent_statut` (`agent_ID`,`statut_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1674 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_direction`
--

DROP TABLE IF EXISTS `detail_agent_direction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_direction` (
  `id_det_ag_dir` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_byte` longtext COLLATE utf8mb4_unicode_ci,
  `direction_ID` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affecterPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_det_ag_dir`),
  KEY `idx_dd_agent_statut` (`agent_ID`,`statut_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1671 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_elpaie`
--

DROP TABLE IF EXISTS `detail_agent_elpaie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_elpaie` (
  `id_detail_Agent_Elpaie` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codepaie_ID` int(11) DEFAULT NULL,
  `mois` date DEFAULT NULL,
  `annee` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id_detail_Agent_Elpaie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_fonction`
--

DROP TABLE IF EXISTS `detail_agent_fonction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_fonction` (
  `id_det_ag_fonction` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_byte` longtext COLLATE utf8mb4_unicode_ci,
  `fonction_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_det_ag_fonction`),
  KEY `idx_df_agent_statut` (`agent_ID`,`statut_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1671 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_grade`
--

DROP TABLE IF EXISTS `detail_agent_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_grade` (
  `id_det_ag_gr` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_byte` longtext COLLATE utf8mb4_unicode_ci,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_det_ag_gr`),
  KEY `agent_ID` (`agent_ID`),
  KEY `idx_dag_agent` (`agent_ID`),
  KEY `idx_dag_grade` (`grade_ID`),
  KEY `idx_dag_statut` (`statut_ID`),
  KEY `idx_dg_agent_statut` (`agent_ID`,`statut_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1671 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_province`
--

DROP TABLE IF EXISTS `detail_agent_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_province` (
  `id_det_ag_prov` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_det_ag_prov`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_province_naissance`
--

DROP TABLE IF EXISTS `detail_agent_province_naissance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_province_naissance` (
  `id_det_ag_provNaiss` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinceNaiss_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_det_ag_provNaiss`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_siege`
--

DROP TABLE IF EXISTS `detail_agent_siege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_siege` (
  `id_det_ag_siege` int(11) NOT NULL AUTO_INCREMENT,
  `siege_ID` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `agent_ID` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_byte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_bin NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_det_ag_siege`),
  KEY `idx_das_agent` (`agent_ID`),
  KEY `idx_das_siege` (`siege_ID`),
  KEY `idx_das_statut` (`statut_ID`),
  KEY `idx_ds_agent_statut` (`agent_ID`,`statut_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1675 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_societe`
--

DROP TABLE IF EXISTS `detail_agent_societe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_societe` (
  `id_det_ag_soc` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `societe_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_byte` longtext COLLATE utf8mb4_unicode_ci,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_det_ag_soc`),
  KEY `idx_dsc_agent_statut` (`agent_ID`,`statut_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1671 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_agent_syndicat`
--

DROP TABLE IF EXISTS `detail_agent_syndicat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_agent_syndicat` (
  `idDetail_Agent_Syndicat` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `syndicat_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_byte` longtext COLLATE utf8mb4_unicode_ci,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idDetail_Agent_Syndicat`),
  KEY `idx_dsy_agent_statut` (`agent_ID`,`statut_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1671 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_codepaie_compt_eqcompt`
--

DROP TABLE IF EXISTS `detail_codepaie_compt_eqcompt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_codepaie_compt_eqcompt` (
  `Id_codepaie_imput` int(11) NOT NULL AUTO_INCREMENT,
  `code_paie_ID` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_compt_ID` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_EqCompt` int(11) NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_Creat` date NOT NULL,
  `date_Modif` date DEFAULT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Id_codepaie_imput`)
) ENGINE=MyISAM AUTO_INCREMENT=530 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_codepaieimp`
--

DROP TABLE IF EXISTS `detail_codepaieimp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_codepaieimp` (
  `id_detailCodePaieImp` int(11) NOT NULL,
  `codepaie_ID` int(11) DEFAULT NULL,
  `eqCompte` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creerpar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_codeImp` date DEFAULT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_modif_codeImp` date DEFAULT NULL,
  PRIMARY KEY (`id_detailCodePaieImp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_grade_bareme`
--

DROP TABLE IF EXISTS `detail_grade_bareme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_grade_bareme` (
  `id_grade_bar` int(5) NOT NULL AUTO_INCREMENT,
  `id_bar` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_grade` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Montant_bar` double DEFAULT NULL,
  `code_devise` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'CDF',
  `Date_debut` date NOT NULL,
  `Date_fin` date DEFAULT NULL,
  `Code_prov` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'act',
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creat` date NOT NULL,
  `date_modif` date DEFAULT NULL,
  PRIMARY KEY (`id_grade_bar`),
  KEY `id_bar` (`id_bar`),
  KEY `idx_dgb_grade` (`code_grade`),
  KEY `idx_dgb_idbar` (`id_bar`),
  KEY `idx_dgb_prov` (`Code_prov`),
  KEY `idx_dgb_grade_bar_prov_statut` (`code_grade`,`id_bar`,`Code_prov`,`statut`),
  KEY `idx_dgb_statut` (`statut`),
  KEY `idx_dgb_codeprov` (`Code_prov`)
) ENGINE=MyISAM AUTO_INCREMENT=3126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_nivetude_montant`
--

DROP TABLE IF EXISTS `detail_nivetude_montant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_nivetude_montant` (
  `id_det_nivetud_mont` int(11) NOT NULL AUTO_INCREMENT,
  `niv_etude_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codepaie` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` double NOT NULL,
  `monnaie_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'sysAdmin',
  PRIMARY KEY (`id_det_nivetud_mont`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `droits_acces`
--

DROP TABLE IF EXISTS `droits_acces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `droits_acces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(5) NOT NULL,
  `page_id` int(11) NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_Creat` date DEFAULT NULL,
  `date_Modif` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profil_id` (`id_role`),
  KEY `page_id` (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=344 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `monnaie`
--

DROP TABLE IF EXISTS `monnaie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monnaie` (
  `code_monnaie` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_monnaie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreation` date NOT NULL,
  `dateModif` date DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code_monnaie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `profils`
--

DROP TABLE IF EXISTS `profils`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_activite`
--

DROP TABLE IF EXISTS `t_activite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_activite` (
  `code_activ` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_activ` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `dateModif` date NOT NULL,
  PRIMARY KEY (`code_activ`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_agent`
--

DROP TABLE IF EXISTS `t_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_agent` (
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_ag` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postnom_ag` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_ag` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe_ag` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etatCiv_ag` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NumCNSS_ag` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ind_logement_ag` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nbreEnfant_ag` int(11) NOT NULL DEFAULT '0',
  `dateEngagemnt_ag` date DEFAULT NULL,
  `dateNaiss_ag` date DEFAULT NULL,
  `indiceCarburant` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NivEtude_ag` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indiceVoiture` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NumCompt` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provNaiss` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provOrig` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activiter_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alloc_fam_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_byte` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`matricule`),
  KEY `matricule` (`matricule`),
  KEY `idx_agent_matricule` (`matricule`),
  KEY `idx_agent_activite` (`activiter_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_alloc_famille`
--

DROP TABLE IF EXISTS `t_alloc_famille`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_alloc_famille` (
  `id_alloc` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codepaie` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle_alloc` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_alloc` double NOT NULL,
  `date_creat` date NOT NULL,
  `date_modif` date DEFAULT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_alloc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_anale`
--

DROP TABLE IF EXISTS `t_anale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_anale` (
  `id_anale` int(11) NOT NULL,
  `codepaie` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateAnal` date NOT NULL,
  `montant` double NOT NULL,
  PRIMARY KEY (`id_anale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_avance`
--

DROP TABLE IF EXISTS `t_avance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_avance` (
  `id_avc` int(11) NOT NULL AUTO_INCREMENT,
  `Agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` double NOT NULL,
  `code_monnaie` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_paie_ID` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `periodeAv` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creePar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateModif` date DEFAULT NULL,
  `date_avc` date NOT NULL,
  `valeur` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_avc`)
) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_bareme`
--

DROP TABLE IF EXISTS `t_bareme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_bareme` (
  `id_bar` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codepaie` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LibelleBar` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Creat_Par` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Date_Creat` date NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Date_Modif` date DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'act',
  PRIMARY KEY (`id_bar`),
  KEY `id_bar` (`id_bar`),
  KEY `idx_bareme_idbar` (`id_bar`),
  KEY `idx_bareme_statut` (`statut_ID`),
  KEY `idx_bareme_codepaie` (`codepaie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_billet`
--

DROP TABLE IF EXISTS `t_billet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_billet` (
  `id_billet` int(11) NOT NULL AUTO_INCREMENT,
  `code_bil` int(11) NOT NULL,
  `libelle_bil` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModif` datetime DEFAULT NULL,
  `monnaie_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_billet`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_calcule_paie`
--

DROP TABLE IF EXISTS `t_calcule_paie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_calcule_paie` (
  `id_cal` int(5) NOT NULL AUTO_INCREMENT,
  `Matricule` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PostNom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `N_inss` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_civil` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sit_famille` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(19) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EquiG` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codeEiPaie` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle_el_paie` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant_payer` decimal(18,2) DEFAULT NULL,
  `periode` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_paie` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_cal`),
  KEY `Matricule` (`Matricule`)
) ENGINE=MyISAM AUTO_INCREMENT=47766 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_calendrier_conge_engagement`
--

DROP TABLE IF EXISTS `t_calendrier_conge_engagement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_calendrier_conge_engagement` (
  `id_planning` int(11) NOT NULL AUTO_INCREMENT,
  `matricule` varchar(50) NOT NULL,
  `exercice` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nbre_jour` int(11) NOT NULL DEFAULT '0',
  `statut` varchar(20) NOT NULL DEFAULT 'planifie',
  `observation` text,
  `creerPar` varchar(50) DEFAULT NULL,
  `datecreat` date DEFAULT NULL,
  `modifierPar` varchar(50) DEFAULT NULL,
  `datemodif` date DEFAULT NULL,
  PRIMARY KEY (`id_planning`),
  UNIQUE KEY `uq_calendrier_conge_engagement` (`matricule`,`exercice`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_carburant`
--

DROP TABLE IF EXISTS `t_carburant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_carburant` (
  `id_carb` date NOT NULL,
  `prix_litre` float NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `taux_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_carb`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_codepaie`
--

DROP TABLE IF EXISTS `t_codepaie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_codepaie` (
  `codePaie` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_codePaie` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sens_ID` int(11) DEFAULT NULL,
  `imposable` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Date_Modif` date DEFAULT NULL,
  `Date_Creat` date DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'act',
  PRIMARY KEY (`codePaie`),
  KEY `idx_codepaie` (`codePaie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_conge`
--

DROP TABLE IF EXISTS `t_conge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_conge` (
  `id_conge` int(11) NOT NULL AUTO_INCREMENT,
  `id_dem_conge` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nbre_jour` int(11) NOT NULL,
  `statut` varchar(15) DEFAULT NULL,
  `document` text,
  `document_byte` longtext,
  `creerPar` varchar(10) DEFAULT NULL,
  `datecreat` date DEFAULT NULL,
  PRIMARY KEY (`id_conge`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_conjoint`
--

DROP TABLE IF EXISTS `t_conjoint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_conjoint` (
  `id_conj` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) CHARACTER SET latin1 NOT NULL,
  `nom_conj` varchar(25) CHARACTER SET latin1 NOT NULL,
  `postnom_conj` varchar(25) CHARACTER SET latin1 NOT NULL,
  `prenom_conj` varchar(25) CHARACTER SET latin1 NOT NULL,
  `sexe_conj` char(1) CHARACTER SET latin1 NOT NULL,
  `lieu_mariage` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_mariage` date DEFAULT NULL,
  `creerPar` varchar(10) CHARACTER SET latin1 NOT NULL,
  `dateCreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifierPar` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `dateModif` datetime DEFAULT NULL,
  `lieu_naiss` varchar(100) CHARACTER SET latin1 NOT NULL,
  `dateNaiss_conj` date NOT NULL,
  `statut_ID` varchar(10) CHARACTER SET latin1 NOT NULL,
  `fichier` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `fichier_byte` longtext CHARACTER SET latin1,
  PRIMARY KEY (`id_conj`),
  KEY `id_enf` (`id_conj`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_demandeconge`
--

DROP TABLE IF EXISTS `t_demandeconge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_demandeconge` (
  `id_demande` int(11) NOT NULL AUTO_INCREMENT,
  `id_typeconge` int(11) NOT NULL,
  `date_demande` date NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `excercice` varchar(30) NOT NULL,
  `nbrejr_solic` int(11) NOT NULL,
  `date_accord` date DEFAULT NULL,
  `nbrejr_accord` int(11) DEFAULT NULL,
  `matricule` varchar(10) NOT NULL,
  `AccordePar` varchar(10) DEFAULT NULL,
  `statut` varchar(20) DEFAULT 'naprv',
  `etat` varchar(10) NOT NULL DEFAULT 'act',
  `creerpar` varchar(10) NOT NULL,
  PRIMARY KEY (`id_demande`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_direction`
--

DROP TABLE IF EXISTS `t_direction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_direction` (
  `code_dir` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_dir` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creePar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'sysAdmin',
  PRIMARY KEY (`code_dir`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_doc_agent`
--

DROP TABLE IF EXISTS `t_doc_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_doc_agent` (
  `id_doc` int(11) NOT NULL AUTO_INCREMENT,
  `id_typedoc` int(11) NOT NULL,
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_doc` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation` longtext COLLATE utf8mb4_unicode_ci,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_byte` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datecreat` date NOT NULL,
  `modifierPar` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  PRIMARY KEY (`id_doc`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_droiotacces`
--

DROP TABLE IF EXISTS `t_droiotacces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_droiotacces` (
  `idDroit` int(10) NOT NULL AUTO_INCREMENT,
  `libelle_droit` varchar(100) NOT NULL,
  PRIMARY KEY (`idDroit`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_enfants_agent`
--

DROP TABLE IF EXISTS `t_enfants_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_enfants_agent` (
  `id_enf` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) NOT NULL,
  `nom_enf` varchar(25) NOT NULL,
  `postnom_enf` varchar(25) NOT NULL,
  `prenom_enf` varchar(25) NOT NULL,
  `sexe_enf` char(1) NOT NULL,
  `lien_filiation` varchar(50) NOT NULL,
  `creerPar` varchar(10) NOT NULL,
  `lieu_naiss` varchar(50) NOT NULL,
  `dateCreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifierPar` varchar(10) DEFAULT NULL,
  `dateModif` datetime DEFAULT NULL,
  `dateNaiss_enf` date NOT NULL,
  `statut_ID` varchar(10) NOT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `fichier_byte` longtext,
  PRIMARY KEY (`id_enf`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_eq_compt`
--

DROP TABLE IF EXISTS `t_eq_compt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_eq_compt` (
  `code_EqCompt` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_eqCompt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creePar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code_EqCompt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_eqpaie`
--

DROP TABLE IF EXISTS `t_eqpaie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_eqpaie` (
  `code_eqPaie` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_eqPaie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creePar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code_eqPaie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_fonction`
--

DROP TABLE IF EXISTS `t_fonction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_fonction` (
  `codeFonct` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelleFonct` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codePaie_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` double NOT NULL,
  `monnaie_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primer` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'sysAdmin',
  `dateCreation` date DEFAULT NULL,
  `dateModif` datetime DEFAULT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`codeFonct`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_grade`
--

DROP TABLE IF EXISTS `t_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_grade` (
  `code_grade` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_grade` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Eq_Paie_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Eq_Compt_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creePar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `Date_Creat` date NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `Date_Modif` date DEFAULT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'act',
  PRIMARY KEY (`code_grade`),
  KEY `code_grade` (`code_grade`),
  KEY `idx_grade_code` (`code_grade`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_heures`
--

DROP TABLE IF EXISTS `t_heures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_heures` (
  `id_pointage` int(11) NOT NULL AUTO_INCREMENT,
  `periode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `matric` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nbreh` int(5) DEFAULT NULL,
  `typeHeure` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codepaie` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creerpar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datecreat` date DEFAULT NULL,
  `modifierpar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datemodif` date DEFAULT NULL,
  PRIMARY KEY (`id_pointage`)
) ENGINE=MyISAM AUTO_INCREMENT=946 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_historique_conn`
--

DROP TABLE IF EXISTS `t_historique_conn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_historique_conn` (
  `id_histori_con` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_con` date NOT NULL,
  `heure_con` time NOT NULL,
  `date_decon` date DEFAULT NULL,
  `heure_decon` time DEFAULT NULL,
  PRIMARY KEY (`id_histori_con`)
) ENGINE=MyISAM AUTO_INCREMENT=593 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_historique_operation`
--

DROP TABLE IF EXISTS `t_historique_operation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_historique_operation` (
  `id_hist_op` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_op` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numRef_op` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_op` double DEFAULT NULL,
  `date_supp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_hist_op`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_imposa`
--

DROP TABLE IF EXISTS `t_imposa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_imposa` (
  `id_imp` int(11) NOT NULL AUTO_INCREMENT,
  `Matricule` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PostNom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `N_inss` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_civil` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sit_famille` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EquiG` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codeEiPaie` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle_el_paie` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant_payer` decimal(18,2) DEFAULT NULL,
  `periode` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_imp`),
  KEY `Matricule` (`Matricule`)
) ENGINE=MyISAM AUTO_INCREMENT=30095 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_niv_etud`
--

DROP TABLE IF EXISTS `t_niv_etud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_niv_etud` (
  `id_niv_etud` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_niv_etud` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'act',
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creat` date NOT NULL,
  `date_modif` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_pages`
--

DROP TABLE IF EXISTS `t_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_pages` (
  `id_page` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_page` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_souscat` int(5) DEFAULT NULL,
  `id_cat` int(11) NOT NULL,
  PRIMARY KEY (`id_page`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_paie`
--

DROP TABLE IF EXISTS `t_paie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_paie` (
  `id_paie` int(11) NOT NULL AUTO_INCREMENT,
  `Matricule` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PostNom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `N_inss` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_civil` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sit_famille` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EquiG` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codeEiPaie` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle_el_paie` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant_payer` decimal(18,2) DEFAULT NULL,
  `montant_a_retenir` decimal(18,2) DEFAULT NULL,
  `montant_imposa` decimal(18,2) DEFAULT NULL,
  `periode` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codesiege` varchar(10) DEFAULT NULL,
  `libelle_siege` varchar(30) DEFAULT NULL,
  `numCompt` varchar(30) DEFAULT NULL,
  `type_paie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_paie`)
) ENGINE=MyISAM AUTO_INCREMENT=114517 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_pointage`
--

DROP TABLE IF EXISTS `t_pointage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_pointage` (
  `id_pointage` int(11) NOT NULL AUTO_INCREMENT,
  `periode` varchar(50) DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `matric` varchar(10) DEFAULT NULL,
  `nbrejrs` int(5) DEFAULT NULL,
  `creerpar` varchar(10) NOT NULL DEFAULT 'sysAdmin',
  `datecreat` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifierpar` varchar(10) DEFAULT NULL,
  `datemodif` date DEFAULT NULL,
  PRIMARY KEY (`id_pointage`)
) ENGINE=MyISAM AUTO_INCREMENT=4254 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_pret`
--

DROP TABLE IF EXISTS `t_pret`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_pret` (
  `id_pret` int(11) NOT NULL AUTO_INCREMENT,
  `moisEpuration` int(11) NOT NULL,
  `periodePret` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `N_refPret` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montantPreter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `solde` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_a_retenir` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateDebut_retenir` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taux_Interet` float NOT NULL,
  `codePaie_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monnaie_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `dateModifier` date DEFAULT NULL,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siege_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_pret`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_prime`
--

DROP TABLE IF EXISTS `t_prime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_prime` (
  `id_prime` int(11) NOT NULL AUTO_INCREMENT,
  `codePrime` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montantPrime` float DEFAULT NULL,
  `devise_ID` int(11) DEFAULT NULL,
  `fonction_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codepaie_ID` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_prime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_prime_special`
--

DROP TABLE IF EXISTS `t_prime_special`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_prime_special` (
  `id_prim_spec` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codePaie_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_ps` double NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_prim_spec`)
) ENGINE=MyISAM AUTO_INCREMENT=671 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_prov_administrative`
--

DROP TABLE IF EXISTS `t_prov_administrative`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_prov_administrative` (
  `code_exProv` varchar(2) NOT NULL,
  `libelle_exProv` varchar(25) NOT NULL,
  `creerPar` varchar(10) NOT NULL,
  `modifierPar` varchar(10) NOT NULL,
  `statut_ID` varchar(10) NOT NULL,
  PRIMARY KEY (`code_exProv`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_province`
--

DROP TABLE IF EXISTS `t_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_province` (
  `code_prov` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_prov` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_provAdmin` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'sysAdmin',
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code_prov`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_retention`
--

DROP TABLE IF EXISTS `t_retention`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_retention` (
  `id_ret` int(11) NOT NULL AUTO_INCREMENT,
  `pret_ID` int(11) NOT NULL,
  `solde` float NOT NULL,
  `dateRet` date DEFAULT NULL,
  PRIMARY KEY (`id_ret`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_retenue`
--

DROP TABLE IF EXISTS `t_retenue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_retenue` (
  `id_ret` int(11) NOT NULL AUTO_INCREMENT,
  `Matricule` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PostNom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `N_inss` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_civil` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sit_famille` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EquiG` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codeEiPaie` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle_el_paie` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant_payer` decimal(18,2) DEFAULT NULL,
  `periode` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_ret`),
  KEY `Matricule` (`Matricule`)
) ENGINE=MyISAM AUTO_INCREMENT=24321 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_retsyndical`
--

DROP TABLE IF EXISTS `t_retsyndical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_retsyndical` (
  `id_retSyndi` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_retSyndi` date NOT NULL,
  `montant_retSyndi` float NOT NULL,
  `syndicat_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_retSyndi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_role_user`
--

DROP TABLE IF EXISTS `t_role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_role_user` (
  `id_role` int(5) NOT NULL AUTO_INCREMENT,
  `libelle_role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creePar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `date_creat` date DEFAULT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateModifier_role` date DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_sanct_agent`
--

DROP TABLE IF EXISTS `t_sanct_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_sanct_agent` (
  `id_sanct` int(11) NOT NULL AUTO_INCREMENT,
  `id_typesanct` int(11) NOT NULL,
  `matricule` varchar(10) NOT NULL,
  `ref_sanct` varchar(30) NOT NULL,
  `observation` longtext,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `sanction` varchar(255) NOT NULL,
  `sanction_byte` longtext NOT NULL,
  `creerPar` varchar(15) NOT NULL,
  `datecreat` date NOT NULL,
  `modifierPar` varchar(15) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `statut_sanct` varchar(20) NOT NULL DEFAULT 'act',
  PRIMARY KEY (`id_sanct`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_senspaie`
--

DROP TABLE IF EXISTS `t_senspaie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_senspaie` (
  `id_senspaie` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LibelleSens` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreeSens` date NOT NULL,
  `dateModifSens` date DEFAULT NULL,
  PRIMARY KEY (`id_senspaie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_siege`
--

DROP TABLE IF EXISTS `t_siege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_siege` (
  `code_sieg` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_sieg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typeSiege_ID` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_ID` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creePar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModif` datetime DEFAULT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code_sieg`),
  KEY `idx_siege_code` (`code_sieg`),
  KEY `idx_siege_statut` (`statut_ID`),
  KEY `idx_siege_statut_codesieg` (`statut_ID`,`code_sieg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_societe`
--

DROP TABLE IF EXISTS `t_societe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_societe` (
  `code_soc` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_soc` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creePar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`code_soc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_souscategorie`
--

DROP TABLE IF EXISTS `t_souscategorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_souscategorie` (
  `id_souscat` int(5) NOT NULL AUTO_INCREMENT,
  `lib_souscat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cat` int(5) NOT NULL,
  PRIMARY KEY (`id_souscat`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_stagiare`
--

DROP TABLE IF EXISTS `t_stagiare`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_stagiare` (
  `id_stg` int(11) NOT NULL AUTO_INCREMENT,
  `nom_stg` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postnom_stg` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_stg` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe_stg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etatCiv_stg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivEtude_stg` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siege_stg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir_stg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pOrigi_stg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pNaiss_stg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateNaiss` date NOT NULL,
  `dateDebut_stage` date NOT NULL,
  `photo_stg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_byte_stg` mediumtext COLLATE utf8mb4_unicode_ci,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_byte` mediumtext COLLATE utf8mb4_unicode_ci,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateFin_stg` date DEFAULT NULL,
  `histo_stg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_stg` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_stg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_stg`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_statut`
--

DROP TABLE IF EXISTS `t_statut`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_statut` (
  `code_st` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_st` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  PRIMARY KEY (`code_st`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_syndicat`
--

DROP TABLE IF EXISTS `t_syndicat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_syndicat` (
  `code_syndi` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_syndi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'sysAdmin',
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code_syndi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_taux`
--

DROP TABLE IF EXISTS `t_taux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_taux` (
  `id_taux` int(11) NOT NULL AUTO_INCREMENT,
  `montantTaux` decimal(10,0) NOT NULL,
  `monnaie_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'sysAdmin',
  `dateTaux` date NOT NULL,
  `statut_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_taux`),
  UNIQUE KEY `id_taux_UNIQUE` (`id_taux`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_typconge`
--

DROP TABLE IF EXISTS `t_typconge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_typconge` (
  `id_type_conge` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_conge` varchar(30) NOT NULL,
  `creerPar` varchar(15) NOT NULL,
  `datecreer` date NOT NULL,
  `modifierPar` varchar(15) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `statut` varchar(50) NOT NULL DEFAULT 'act',
  PRIMARY KEY (`id_type_conge`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_type_doc`
--

DROP TABLE IF EXISTS `t_type_doc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_type_doc` (
  `id_typedoc` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_typedoc` varchar(50) NOT NULL,
  `creerPar` varchar(15) NOT NULL,
  `datecreer` date NOT NULL,
  `modifierPar` varchar(15) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `statut` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_typedoc`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_type_heure`
--

DROP TABLE IF EXISTS `t_type_heure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_type_heure` (
  `id_type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typeheure` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codepaie` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_type_sanct`
--

DROP TABLE IF EXISTS `t_type_sanct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_type_sanct` (
  `id_typesanct` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_typesanct` varchar(50) NOT NULL,
  `creerPar` varchar(15) NOT NULL,
  `datecreer` date NOT NULL,
  `modifierPar` varchar(15) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `statut` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_typesanct`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_type_siege`
--

DROP TABLE IF EXISTS `t_type_siege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_type_siege` (
  `code_typSieg` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_typSieg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`code_typSieg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_utilisateurs`
--

DROP TABLE IF EXISTS `t_utilisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_utilisateurs` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `agent_ID` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validation` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Non_Valide',
  `creerPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `modifierPar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sysAdmin',
  `dateCreation` date NOT NULL,
  `dateLast_Modifi` date NOT NULL,
  `statut_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_user_ID` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_vehicule`
--

DROP TABLE IF EXISTS `t_vehicule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_vehicule` (
  `id_veh` int(11) NOT NULL AUTO_INCREMENT,
  `modele` varchar(50) NOT NULL,
  `agent_ID` varchar(10) NOT NULL,
  `numChassis` varchar(25) NOT NULL,
  `numPermis` varchar(25) NOT NULL,
  `numCarteRose` varchar(25) NOT NULL,
  `immatriculation` varchar(25) NOT NULL,
  `observation` varchar(255) DEFAULT NULL,
  `creerPar` varchar(10) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifierPar` varchar(10) DEFAULT NULL,
  `dateModif` datetime DEFAULT NULL,
  `statut_ID` varchar(10) NOT NULL DEFAULT 'act',
  PRIMARY KEY (`id_veh`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `v_agent`
--

DROP TABLE IF EXISTS `v_agent`;
/*!50001 DROP VIEW IF EXISTS `v_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_agent` AS SELECT 
 1 AS `matricule`,
 1 AS `nom_ag`,
 1 AS `postnom_ag`,
 1 AS `prenom_ag`,
 1 AS `sexe_ag`,
 1 AS `etatCiv_ag`,
 1 AS `NumCNSS_ag`,
 1 AS `ind_logement_ag`,
 1 AS `nbreEnfant_ag`,
 1 AS `dateEngagemnt_ag`,
 1 AS `dateNaiss_ag`,
 1 AS `indiceCarburant`,
 1 AS `NivEtude_ag`,
 1 AS `creerPar`,
 1 AS `modifierPar`,
 1 AS `indiceVoiture`,
 1 AS `NumCompt`,
 1 AS `provNaiss`,
 1 AS `provOrig`,
 1 AS `photo`,
 1 AS `photo_byte`,
 1 AS `code_activ`,
 1 AS `libelle_activ`,
 1 AS `code_dir`,
 1 AS `libelle_dir`,
 1 AS `codeFonct`,
 1 AS `libelleFonct`,
 1 AS `code_grade`,
 1 AS `libelle_grade`,
 1 AS `code_sieg`,
 1 AS `libelle_sieg`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_agent_seiegact`
--

DROP TABLE IF EXISTS `v_agent_seiegact`;
/*!50001 DROP VIEW IF EXISTS `v_agent_seiegact`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_agent_seiegact` AS SELECT 
 1 AS `matricule`,
 1 AS `nom`,
 1 AS `activiter_ID`,
 1 AS `sexe_ag`,
 1 AS `dateEngagemnt_ag`,
 1 AS `dateNaiss_ag`,
 1 AS `libelle_sieg`,
 1 AS `code_sieg`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ajout_anal`
--

DROP TABLE IF EXISTS `v_ajout_anal`;
/*!50001 DROP VIEW IF EXISTS `v_ajout_anal`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ajout_anal` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `anniversaire`,
 1 AS `montant_payer`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ajout_sal_brut`
--

DROP TABLE IF EXISTS `v_ajout_sal_brut`;
/*!50001 DROP VIEW IF EXISTS `v_ajout_sal_brut`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ajout_sal_brut` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `(t_calcule_paie.montant_payer/26)*30`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ajout_sal_brut01`
--

DROP TABLE IF EXISTS `v_ajout_sal_brut01`;
/*!50001 DROP VIEW IF EXISTS `v_ajout_sal_brut01`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ajout_sal_brut01` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `CodePaie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ajout_transp`
--

DROP TABLE IF EXISTS `v_ajout_transp`;
/*!50001 DROP VIEW IF EXISTS `v_ajout_transp`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ajout_transp` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `codeEiPaie`,
 1 AS `Montant`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ajoutanal_fevrie`
--

DROP TABLE IF EXISTS `v_ajoutanal_fevrie`;
/*!50001 DROP VIEW IF EXISTS `v_ajoutanal_fevrie`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ajoutanal_fevrie` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `anniversaire`,
 1 AS `montant_payer`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ajoutanal_fevrier`
--

DROP TABLE IF EXISTS `v_ajoutanal_fevrier`;
/*!50001 DROP VIEW IF EXISTS `v_ajoutanal_fevrier`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ajoutanal_fevrier` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `montant_payer`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_alloc_epouse`
--

DROP TABLE IF EXISTS `v_alloc_epouse`;
/*!50001 DROP VIEW IF EXISTS `v_alloc_epouse`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_alloc_epouse` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_alloc_famille`
--

DROP TABLE IF EXISTS `v_alloc_famille`;
/*!50001 DROP VIEW IF EXISTS `v_alloc_famille`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_alloc_famille` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_anal`
--

DROP TABLE IF EXISTS `v_anal`;
/*!50001 DROP VIEW IF EXISTS `v_anal`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_anal` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_anal_ret`
--

DROP TABLE IF EXISTS `v_anal_ret`;
/*!50001 DROP VIEW IF EXISTS `v_anal_ret`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_anal_ret` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_anciennete`
--

DROP TABLE IF EXISTS `v_anciennete`;
/*!50001 DROP VIEW IF EXISTS `v_anciennete`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_anciennete` AS SELECT 
 1 AS `matricule`,
 1 AS `nom_ag`,
 1 AS `anciennete_en_annees`,
 1 AS `anciennete_en_mois`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_aniv`
--

DROP TABLE IF EXISTS `v_aniv`;
/*!50001 DROP VIEW IF EXISTS `v_aniv`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_aniv` AS SELECT 
 1 AS `matricule`,
 1 AS `nom_ag`,
 1 AS `anniversaire`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_aniv_fevrier`
--

DROP TABLE IF EXISTS `v_aniv_fevrier`;
/*!50001 DROP VIEW IF EXISTS `v_aniv_fevrier`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_aniv_fevrier` AS SELECT 
 1 AS `matricule`,
 1 AS `nom_ag`,
 1 AS `anniversaire`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_aniv_janvier`
--

DROP TABLE IF EXISTS `v_aniv_janvier`;
/*!50001 DROP VIEW IF EXISTS `v_aniv_janvier`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_aniv_janvier` AS SELECT 
 1 AS `matricule`,
 1 AS `nom_ag`,
 1 AS `anniversaire`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_avance_cdf`
--

DROP TABLE IF EXISTS `v_avance_cdf`;
/*!50001 DROP VIEW IF EXISTS `v_avance_cdf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_avance_cdf` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_avance_franc`
--

DROP TABLE IF EXISTS `v_avance_franc`;
/*!50001 DROP VIEW IF EXISTS `v_avance_franc`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_avance_franc` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periodeAv`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_avance_us`
--

DROP TABLE IF EXISTS `v_avance_us`;
/*!50001 DROP VIEW IF EXISTS `v_avance_us`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_avance_us` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periodeAv`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_avance_usd`
--

DROP TABLE IF EXISTS `v_avance_usd`;
/*!50001 DROP VIEW IF EXISTS `v_avance_usd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_avance_usd` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_bareme`
--

DROP TABLE IF EXISTS `v_bareme`;
/*!50001 DROP VIEW IF EXISTS `v_bareme`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_bareme` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_bareme_ret`
--

DROP TABLE IF EXISTS `v_bareme_ret`;
/*!50001 DROP VIEW IF EXISTS `v_bareme_ret`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_bareme_ret` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_brut_net_impos`
--

DROP TABLE IF EXISTS `v_brut_net_impos`;
/*!50001 DROP VIEW IF EXISTS `v_brut_net_impos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_brut_net_impos` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_brut`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_brut_net_impos2`
--

DROP TABLE IF EXISTS `v_brut_net_impos2`;
/*!50001 DROP VIEW IF EXISTS `v_brut_net_impos2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_brut_net_impos2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_brut`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `v_calcule_paie`
--

DROP TABLE IF EXISTS `v_calcule_paie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `v_calcule_paie` (
  `id_cal` int(5) NOT NULL,
  `Matricule` varchar(15) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `PostNom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `N_inss` varchar(30) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `sit_famille` varchar(10) NOT NULL,
  `Nbre_pres` int(5) DEFAULT NULL,
  `grade` varchar(19) DEFAULT NULL,
  `EquiG` varchar(5) DEFAULT NULL,
  `codeEiPaie` varchar(10) DEFAULT NULL,
  `libelle_el_paie` varchar(30) DEFAULT NULL,
  `montant_payer` decimal(18,2) DEFAULT NULL,
  `montant_retenir` decimal(18,2) DEFAULT NULL,
  `montant_imposa` decimal(18,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `v_diplome`
--

DROP TABLE IF EXISTS `v_diplome`;
/*!50001 DROP VIEW IF EXISTS `v_diplome`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_diplome` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_fonction`
--

DROP TABLE IF EXISTS `v_fonction`;
/*!50001 DROP VIEW IF EXISTS `v_fonction`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_fonction` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_fonction_usd`
--

DROP TABLE IF EXISTS `v_fonction_usd`;
/*!50001 DROP VIEW IF EXISTS `v_fonction_usd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_fonction_usd` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_frais_dom`
--

DROP TABLE IF EXISTS `v_frais_dom`;
/*!50001 DROP VIEW IF EXISTS `v_frais_dom`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_frais_dom` AS SELECT 
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Code_Province_Bareme`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_heursup`
--

DROP TABLE IF EXISTS `v_heursup`;
/*!50001 DROP VIEW IF EXISTS `v_heursup`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_heursup` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_heursupl`
--

DROP TABLE IF EXISTS `v_heursupl`;
/*!50001 DROP VIEW IF EXISTS `v_heursupl`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_heursupl` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeEiPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_historique`
--

DROP TABLE IF EXISTS `v_historique`;
/*!50001 DROP VIEW IF EXISTS `v_historique`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_historique` AS SELECT 
 1 AS `siege`,
 1 AS `Profif`,
 1 AS `id_role`,
 1 AS `UserID`,
 1 AS `Noms`,
 1 AS `Date_Connexion`,
 1 AS `date_deconnexion`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_imt_reb_fdom`
--

DROP TABLE IF EXISTS `v_imt_reb_fdom`;
/*!50001 DROP VIEW IF EXISTS `v_imt_reb_fdom`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_imt_reb_fdom` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_imt_reb_fdom_int`
--

DROP TABLE IF EXISTS `v_imt_reb_fdom_int`;
/*!50001 DROP VIEW IF EXISTS `v_imt_reb_fdom_int`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_imt_reb_fdom_int` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_info_agent`
--

DROP TABLE IF EXISTS `v_info_agent`;
/*!50001 DROP VIEW IF EXISTS `v_info_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_info_agent` AS SELECT 
 1 AS `matricule`,
 1 AS `nom_ag`,
 1 AS `postnom_ag`,
 1 AS `prenom_ag`,
 1 AS `sexe_ag`,
 1 AS `etatCiv_ag`,
 1 AS `dateNaiss_ag`,
 1 AS `provNaiss`,
 1 AS `provOrig`,
 1 AS `adresse`,
 1 AS `phone`,
 1 AS `NumCNSS_ag`,
 1 AS `NumCompt`,
 1 AS `nbreEnfant_ag`,
 1 AS `ind_logement_ag`,
 1 AS `indiceCarburant`,
 1 AS `indiceVoiture`,
 1 AS `NivEtude_ag`,
 1 AS `dateEngagemnt_ag`,
 1 AS `photo`,
 1 AS `photo_byte`,
 1 AS `creerPar`,
 1 AS `modifierPar`,
 1 AS `code_activ`,
 1 AS `libelle_activ`,
 1 AS `code_dir`,
 1 AS `libelle_dir`,
 1 AS `codeFonct`,
 1 AS `libelleFonct`,
 1 AS `code_grade`,
 1 AS `libelle_grade`,
 1 AS `code_sieg`,
 1 AS `libelle_sieg`,
 1 AS `code_soc`,
 1 AS `libelle_soc`,
 1 AS `code_syndi`,
 1 AS `libelle_syndi`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_info_pret`
--

DROP TABLE IF EXISTS `v_info_pret`;
/*!50001 DROP VIEW IF EXISTS `v_info_pret`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_info_pret` AS SELECT 
 1 AS `id_pret`,
 1 AS `moisEpuration`,
 1 AS `periodePret`,
 1 AS `montantPreter`,
 1 AS `solde`,
 1 AS `montant_a_retenir`,
 1 AS `dateDebut_retenir`,
 1 AS `taux_Interet`,
 1 AS `creerPar`,
 1 AS `modifierPar`,
 1 AS `N_refPret`,
 1 AS `dateModifier`,
 1 AS `statut_ID`,
 1 AS `matricule`,
 1 AS `nom_ag`,
 1 AS `postnom_ag`,
 1 AS `prenom_ag`,
 1 AS `monnaie_ID`,
 1 AS `codePaie`,
 1 AS `libelle_codePaie`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_inpp`
--

DROP TABLE IF EXISTS `v_inpp`;
/*!50001 DROP VIEW IF EXISTS `v_inpp`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inpp` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_inpp_all`
--

DROP TABLE IF EXISTS `v_inpp_all`;
/*!50001 DROP VIEW IF EXISTS `v_inpp_all`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inpp_all` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_inpp_allep`
--

DROP TABLE IF EXISTS `v_inpp_allep`;
/*!50001 DROP VIEW IF EXISTS `v_inpp_allep`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inpp_allep` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_inpp_allep_cdd`
--

DROP TABLE IF EXISTS `v_inpp_allep_cdd`;
/*!50001 DROP VIEW IF EXISTS `v_inpp_allep_cdd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inpp_allep_cdd` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_inpp_cdd`
--

DROP TABLE IF EXISTS `v_inpp_cdd`;
/*!50001 DROP VIEW IF EXISTS `v_inpp_cdd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inpp_cdd` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_inpp_f`
--

DROP TABLE IF EXISTS `v_inpp_f`;
/*!50001 DROP VIEW IF EXISTS `v_inpp_f`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inpp_f` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_interim_franc`
--

DROP TABLE IF EXISTS `v_interim_franc`;
/*!50001 DROP VIEW IF EXISTS `v_interim_franc`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_interim_franc` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periodeAv`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_interim_us`
--

DROP TABLE IF EXISTS `v_interim_us`;
/*!50001 DROP VIEW IF EXISTS `v_interim_us`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_interim_us` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periodeAv`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipr_all`
--

DROP TABLE IF EXISTS `v_ipr_all`;
/*!50001 DROP VIEW IF EXISTS `v_ipr_all`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipr_all` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipr_bm`
--

DROP TABLE IF EXISTS `v_ipr_bm`;
/*!50001 DROP VIEW IF EXISTS `v_ipr_bm`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipr_bm` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipr_bm2`
--

DROP TABLE IF EXISTS `v_ipr_bm2`;
/*!50001 DROP VIEW IF EXISTS `v_ipr_bm2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipr_bm2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipr_bm22`
--

DROP TABLE IF EXISTS `v_ipr_bm22`;
/*!50001 DROP VIEW IF EXISTS `v_ipr_bm22`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipr_bm22` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipr_cdi_bc`
--

DROP TABLE IF EXISTS `v_ipr_cdi_bc`;
/*!50001 DROP VIEW IF EXISTS `v_ipr_cdi_bc`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipr_cdi_bc` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipr_cdi_bc2`
--

DROP TABLE IF EXISTS `v_ipr_cdi_bc2`;
/*!50001 DROP VIEW IF EXISTS `v_ipr_cdi_bc2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipr_cdi_bc2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipr_cdi_bm`
--

DROP TABLE IF EXISTS `v_ipr_cdi_bm`;
/*!50001 DROP VIEW IF EXISTS `v_ipr_cdi_bm`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipr_cdi_bm` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprac`
--

DROP TABLE IF EXISTS `v_iprac`;
/*!50001 DROP VIEW IF EXISTS `v_iprac`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprac` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprac2`
--

DROP TABLE IF EXISTS `v_iprac2`;
/*!50001 DROP VIEW IF EXISTS `v_iprac2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprac2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipram`
--

DROP TABLE IF EXISTS `v_ipram`;
/*!50001 DROP VIEW IF EXISTS `v_ipram`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipram` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ipram2`
--

DROP TABLE IF EXISTS `v_ipram2`;
/*!50001 DROP VIEW IF EXISTS `v_ipram2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ipram2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprbc`
--

DROP TABLE IF EXISTS `v_iprbc`;
/*!50001 DROP VIEW IF EXISTS `v_iprbc`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprbc` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprbc2`
--

DROP TABLE IF EXISTS `v_iprbc2`;
/*!50001 DROP VIEW IF EXISTS `v_iprbc2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprbc2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprcc`
--

DROP TABLE IF EXISTS `v_iprcc`;
/*!50001 DROP VIEW IF EXISTS `v_iprcc`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprcc` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprcc2`
--

DROP TABLE IF EXISTS `v_iprcc2`;
/*!50001 DROP VIEW IF EXISTS `v_iprcc2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprcc2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprcm`
--

DROP TABLE IF EXISTS `v_iprcm`;
/*!50001 DROP VIEW IF EXISTS `v_iprcm`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprcm` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprcm2`
--

DROP TABLE IF EXISTS `v_iprcm2`;
/*!50001 DROP VIEW IF EXISTS `v_iprcm2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprcm2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprdc`
--

DROP TABLE IF EXISTS `v_iprdc`;
/*!50001 DROP VIEW IF EXISTS `v_iprdc`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprdc` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprdc2`
--

DROP TABLE IF EXISTS `v_iprdc2`;
/*!50001 DROP VIEW IF EXISTS `v_iprdc2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprdc2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprdm`
--

DROP TABLE IF EXISTS `v_iprdm`;
/*!50001 DROP VIEW IF EXISTS `v_iprdm`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprdm` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_iprdm2`
--

DROP TABLE IF EXISTS `v_iprdm2`;
/*!50001 DROP VIEW IF EXISTS `v_iprdm2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_iprdm2` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_impot`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_liste_utilisateur`
--

DROP TABLE IF EXISTS `v_liste_utilisateur`;
/*!50001 DROP VIEW IF EXISTS `v_liste_utilisateur`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_liste_utilisateur` AS SELECT 
 1 AS `id_user`,
 1 AS `username`,
 1 AS `creerPar`,
 1 AS `modifierPar`,
 1 AS `dateCreation`,
 1 AS `dateLast_Modifi`,
 1 AS `agent_ID`,
 1 AS `nom_ag`,
 1 AS `postnom_ag`,
 1 AS `prenom_ag`,
 1 AS `libelle_dir`,
 1 AS `photo`,
 1 AS `libelle_st`,
 1 AS `code_st`,
 1 AS `id_role`,
 1 AS `libelle_role`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_net_a_payer`
--

DROP TABLE IF EXISTS `v_net_a_payer`;
/*!50001 DROP VIEW IF EXISTS `v_net_a_payer`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_net_a_payer` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_net_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_net_a_payer_r`
--

DROP TABLE IF EXISTS `v_net_a_payer_r`;
/*!50001 DROP VIEW IF EXISTS `v_net_a_payer_r`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_net_a_payer_r` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_net_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_onem`
--

DROP TABLE IF EXISTS `v_onem`;
/*!50001 DROP VIEW IF EXISTS `v_onem`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_onem` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_ONEM`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel10`
--

DROP TABLE IF EXISTS `v_prime_fidel10`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel10`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel10` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel10f`
--

DROP TABLE IF EXISTS `v_prime_fidel10f`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel10f`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel10f` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel10j`
--

DROP TABLE IF EXISTS `v_prime_fidel10j`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel10j`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel10j` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel15`
--

DROP TABLE IF EXISTS `v_prime_fidel15`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel15`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel15` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel15f`
--

DROP TABLE IF EXISTS `v_prime_fidel15f`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel15f`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel15f` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel15j`
--

DROP TABLE IF EXISTS `v_prime_fidel15j`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel15j`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel15j` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel20`
--

DROP TABLE IF EXISTS `v_prime_fidel20`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel20`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel20` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel20f`
--

DROP TABLE IF EXISTS `v_prime_fidel20f`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel20f`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel20f` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel20j`
--

DROP TABLE IF EXISTS `v_prime_fidel20j`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel20j`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel20j` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel25`
--

DROP TABLE IF EXISTS `v_prime_fidel25`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel25`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel25` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel25f`
--

DROP TABLE IF EXISTS `v_prime_fidel25f`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel25f`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel25f` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel25j`
--

DROP TABLE IF EXISTS `v_prime_fidel25j`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel25j`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel25j` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel30f`
--

DROP TABLE IF EXISTS `v_prime_fidel30f`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel30f`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel30f` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel30j`
--

DROP TABLE IF EXISTS `v_prime_fidel30j`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel30j`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel30j` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel35`
--

DROP TABLE IF EXISTS `v_prime_fidel35`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel35`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel35` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel35f`
--

DROP TABLE IF EXISTS `v_prime_fidel35f`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel35f`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel35f` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel35j`
--

DROP TABLE IF EXISTS `v_prime_fidel35j`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel35j`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel35j` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel40`
--

DROP TABLE IF EXISTS `v_prime_fidel40`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel40`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel40` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel40f`
--

DROP TABLE IF EXISTS `v_prime_fidel40f`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel40f`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel40f` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_fidel40j`
--

DROP TABLE IF EXISTS `v_prime_fidel40j`;
/*!50001 DROP VIEW IF EXISTS `v_prime_fidel40j`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_fidel40j` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_prime_special`
--

DROP TABLE IF EXISTS `v_prime_special`;
/*!50001 DROP VIEW IF EXISTS `v_prime_special`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_prime_special` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeEiPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_quote_part`
--

DROP TABLE IF EXISTS `v_quote_part`;
/*!50001 DROP VIEW IF EXISTS `v_quote_part`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_quote_part` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_reb_fdom`
--

DROP TABLE IF EXISTS `v_reb_fdom`;
/*!50001 DROP VIEW IF EXISTS `v_reb_fdom`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_reb_fdom` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_remb_dom`
--

DROP TABLE IF EXISTS `v_remb_dom`;
/*!50001 DROP VIEW IF EXISTS `v_remb_dom`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_remb_dom` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `PostNom`,
 1 AS `Prenom_`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ret_financement`
--

DROP TABLE IF EXISTS `v_ret_financement`;
/*!50001 DROP VIEW IF EXISTS `v_ret_financement`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ret_financement` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_financement`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ret_int_financement`
--

DROP TABLE IF EXISTS `v_ret_int_financement`;
/*!50001 DROP VIEW IF EXISTS `v_ret_int_financement`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ret_int_financement` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_interet`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_ret_pens`
--

DROP TABLE IF EXISTS `v_ret_pens`;
/*!50001 DROP VIEW IF EXISTS `v_ret_pens`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ret_pens` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_retsydic`
--

DROP TABLE IF EXISTS `v_retsydic`;
/*!50001 DROP VIEW IF EXISTS `v_retsydic`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_retsydic` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_retsyndyc`,
 1 AS `periode`,
 1 AS `codesiege`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_retsydic_all`
--

DROP TABLE IF EXISTS `v_retsydic_all`;
/*!50001 DROP VIEW IF EXISTS `v_retsydic_all`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_retsydic_all` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_retsyndyc`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_retsydic_autre`
--

DROP TABLE IF EXISTS `v_retsydic_autre`;
/*!50001 DROP VIEW IF EXISTS `v_retsydic_autre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_retsydic_autre` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_retsyndyc`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_retsydic_kin`
--

DROP TABLE IF EXISTS `v_retsydic_kin`;
/*!50001 DROP VIEW IF EXISTS `v_retsydic_kin`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_retsydic_kin` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_retsyndyc`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_synd_transt`
--

DROP TABLE IF EXISTS `v_synd_transt`;
/*!50001 DROP VIEW IF EXISTS `v_synd_transt`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_synd_transt` AS SELECT 
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_total_brut`
--

DROP TABLE IF EXISTS `v_total_brut`;
/*!50001 DROP VIEW IF EXISTS `v_total_brut`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_total_brut` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_total_brut`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_total_brut_imp`
--

DROP TABLE IF EXISTS `v_total_brut_imp`;
/*!50001 DROP VIEW IF EXISTS `v_total_brut_imp`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_total_brut_imp` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_imposa`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_total_retenue`
--

DROP TABLE IF EXISTS `v_total_retenue`;
/*!50001 DROP VIEW IF EXISTS `v_total_retenue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_total_retenue` AS SELECT 
 1 AS `Matricule`,
 1 AS `Nom`,
 1 AS `Postnom`,
 1 AS `Prenom`,
 1 AS `N_inss`,
 1 AS `sexe`,
 1 AS `etat_civil`,
 1 AS `sit_famille`,
 1 AS `grade`,
 1 AS `EquiG`,
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `Montant_total_retenue`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_transp_synd`
--

DROP TABLE IF EXISTS `v_transp_synd`;
/*!50001 DROP VIEW IF EXISTS `v_transp_synd`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_transp_synd` AS SELECT 
 1 AS `codeElPaie`,
 1 AS `libelle_el_paie`,
 1 AS `montant_payer`,
 1 AS `periode`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'bdd_paie'
--

--
-- Current Database: `bdd_paie`
--

USE `bdd_paie`;

--
-- Final view structure for view `calcule_paie`
--

/*!50001 DROP VIEW IF EXISTS `calcule_paie`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `calcule_paie` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `nom_ag`,`t_agent`.`postnom_ag` AS `postnom_ag`,`t_agent`.`prenom_ag` AS `prenom_ag`,sum(`detail_grade_bareme`.`Montant_bar`) AS `MontantSalaire` from ((((`detail_grade_bareme` join `t_grade` on((`t_grade`.`code_grade` = `detail_grade_bareme`.`code_grade`))) join `detail_agent_grade` on((`detail_agent_grade`.`grade_ID` = `t_grade`.`code_grade`))) join `t_agent` on((`t_agent`.`matricule` = `detail_agent_grade`.`agent_ID`))) join `t_anale` on((`t_anale`.`agent_ID` = `t_agent`.`matricule`))) where (`detail_grade_bareme`.`id_bar` <> '004') group by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_agent`
--

/*!50001 DROP VIEW IF EXISTS `v_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_agent` AS select `t_agent`.`matricule` AS `matricule`,`t_agent`.`nom_ag` AS `nom_ag`,`t_agent`.`postnom_ag` AS `postnom_ag`,`t_agent`.`prenom_ag` AS `prenom_ag`,`t_agent`.`sexe_ag` AS `sexe_ag`,`t_agent`.`etatCiv_ag` AS `etatCiv_ag`,`t_agent`.`NumCNSS_ag` AS `NumCNSS_ag`,`t_agent`.`ind_logement_ag` AS `ind_logement_ag`,`t_agent`.`nbreEnfant_ag` AS `nbreEnfant_ag`,`t_agent`.`dateEngagemnt_ag` AS `dateEngagemnt_ag`,`t_agent`.`dateNaiss_ag` AS `dateNaiss_ag`,`t_agent`.`indiceCarburant` AS `indiceCarburant`,`t_agent`.`NivEtude_ag` AS `NivEtude_ag`,`t_agent`.`creerPar` AS `creerPar`,`t_agent`.`modifierPar` AS `modifierPar`,`t_agent`.`indiceVoiture` AS `indiceVoiture`,`t_agent`.`NumCompt` AS `NumCompt`,`t_agent`.`provNaiss` AS `provNaiss`,`t_agent`.`provOrig` AS `provOrig`,`t_agent`.`photo` AS `photo`,`t_agent`.`photo_byte` AS `photo_byte`,`t_activite`.`code_activ` AS `code_activ`,`t_activite`.`libelle_activ` AS `libelle_activ`,`t_direction`.`code_dir` AS `code_dir`,`t_direction`.`libelle_dir` AS `libelle_dir`,`t_fonction`.`codeFonct` AS `codeFonct`,`t_fonction`.`libelleFonct` AS `libelleFonct`,`t_grade`.`code_grade` AS `code_grade`,`t_grade`.`libelle_grade` AS `libelle_grade`,`t_siege`.`code_sieg` AS `code_sieg`,`t_siege`.`libelle_sieg` AS `libelle_sieg` from ((((((((((`t_agent` join `detail_agent_activ` on((`detail_agent_activ`.`agent_ID` = `t_agent`.`matricule`))) join `t_activite` on((`t_activite`.`code_activ` = `detail_agent_activ`.`code_activ_ID`))) join `detail_agent_direction` on((`detail_agent_direction`.`agent_ID` = `t_agent`.`matricule`))) join `t_direction` on((`t_direction`.`code_dir` = `detail_agent_direction`.`direction_ID`))) join `detail_agent_fonction` on((`detail_agent_fonction`.`agent_ID` = `t_agent`.`matricule`))) join `t_fonction` on((`t_fonction`.`codeFonct` = `detail_agent_fonction`.`fonction_ID`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `t_agent`.`matricule`))) join `t_siege` on((`t_siege`.`code_sieg` = `detail_agent_siege`.`siege_ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_agent_seiegact`
--

/*!50001 DROP VIEW IF EXISTS `v_agent_seiegact`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_agent_seiegact` AS select `t_agent`.`matricule` AS `matricule`,concat(`t_agent`.`nom_ag`,' ',`t_agent`.`postnom_ag`,' ',`t_agent`.`prenom_ag`) AS `nom`,`t_agent`.`activiter_ID` AS `activiter_ID`,`t_agent`.`sexe_ag` AS `sexe_ag`,`t_agent`.`dateEngagemnt_ag` AS `dateEngagemnt_ag`,`t_agent`.`dateNaiss_ag` AS `dateNaiss_ag`,`t_siege`.`libelle_sieg` AS `libelle_sieg`,`t_siege`.`code_sieg` AS `code_sieg` from ((`t_agent` join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `t_agent`.`matricule`))) join `t_siege` on((`t_siege`.`code_sieg` = `detail_agent_siege`.`siege_ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ajout_anal`
--

/*!50001 DROP VIEW IF EXISTS `v_ajout_anal`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ajout_anal` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`PostNom` AS `PostNom`,`v_aniv`.`anniversaire` AS `anniversaire`,(sum(`t_calcule_paie`.`montant_payer`) * 0.05) AS `montant_payer` from (`t_calcule_paie` join `v_aniv` on((`v_aniv`.`matricule` = `t_calcule_paie`.`Matricule`))) where (`t_calcule_paie`.`codeEiPaie` between '001' and '006') group by `t_calcule_paie`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ajout_sal_brut`
--

/*!50001 DROP VIEW IF EXISTS `v_ajout_sal_brut`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ajout_sal_brut` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,((`t_calcule_paie`.`montant_payer` / 26) * 30) AS `(t_calcule_paie.montant_payer/26)*30` from (`t_calcule_paie` join `detail_agent_fonction` on((`detail_agent_fonction`.`agent_ID` = `t_calcule_paie`.`Matricule`))) where ((`detail_agent_fonction`.`fonction_ID` = '0050') and (`t_calcule_paie`.`codeEiPaie` = '001')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ajout_sal_brut01`
--

/*!50001 DROP VIEW IF EXISTS `v_ajout_sal_brut01`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ajout_sal_brut01` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`codeEiPaie` AS `CodePaie`,cast(((`t_calcule_paie`.`montant_payer` / 26) * 30) as decimal(18,2)) AS `montant_payer`,`t_calcule_paie`.`periode` AS `periode` from (`t_calcule_paie` join `detail_agent_fonction` on((`detail_agent_fonction`.`agent_ID` = `t_calcule_paie`.`Matricule`))) where ((`detail_agent_fonction`.`fonction_ID` = '0050') and (`t_calcule_paie`.`codeEiPaie` = '001')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ajout_transp`
--

/*!50001 DROP VIEW IF EXISTS `v_ajout_transp`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ajout_transp` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`codeEiPaie` AS `codeEiPaie`,cast(((`t_calcule_paie`.`montant_payer` / 26) * 30) as decimal(18,2)) AS `Montant`,`t_calcule_paie`.`periode` AS `periode` from (`t_calcule_paie` join `detail_agent_fonction` on((`detail_agent_fonction`.`agent_ID` = `t_calcule_paie`.`Matricule`))) where ((`detail_agent_fonction`.`fonction_ID` = '0050') and (`t_calcule_paie`.`codeEiPaie` = '231')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ajoutanal_fevrie`
--

/*!50001 DROP VIEW IF EXISTS `v_ajoutanal_fevrie`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ajoutanal_fevrie` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`PostNom` AS `PostNom`,`v_aniv_fevrier`.`anniversaire` AS `anniversaire`,(sum(`t_calcule_paie`.`montant_payer`) * 0.05) AS `montant_payer` from (`t_calcule_paie` join `v_aniv_fevrier` on((`v_aniv_fevrier`.`matricule` = `t_calcule_paie`.`Matricule`))) where (`t_calcule_paie`.`codeEiPaie` between '001' and '006') group by `t_calcule_paie`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ajoutanal_fevrier`
--

/*!50001 DROP VIEW IF EXISTS `v_ajoutanal_fevrier`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ajoutanal_fevrier` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`PostNom` AS `PostNom`,(sum(`t_calcule_paie`.`montant_payer`) * 0.05) AS `montant_payer` from (`t_calcule_paie` join `v_aniv_fevrier` on((`v_aniv_fevrier`.`matricule` = `t_calcule_paie`.`Matricule`))) where (`t_calcule_paie`.`codeEiPaie` between '001' and '006') group by `t_calcule_paie`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_alloc_epouse`
--

/*!50001 DROP VIEW IF EXISTS `v_alloc_epouse`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_alloc_epouse` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_alloc_famille`.`codepaie` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`t_alloc_famille`.`montant_alloc` AS `montant_payer`,NULL AS `periode` from ((((((`t_agent` join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_alloc_famille`.`codepaie`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_agent`.`sexe_ag` = 'M') and (`t_agent`.`etatCiv_ag` = 'M')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_alloc_famille`
--

/*!50001 DROP VIEW IF EXISTS `v_alloc_famille`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_alloc_famille` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_alloc_famille`.`codepaie` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,(`t_alloc_famille`.`montant_alloc` * `t_agent`.`nbreEnfant_ag`) AS `montant_payer`,NULL AS `periode` from ((((((`t_agent` join `t_alloc_famille` on((`t_agent`.`alloc_fam_ID` = `t_alloc_famille`.`id_alloc`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_alloc_famille`.`codepaie`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_agent`.`nbreEnfant_ag` <> 0)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_anal`
--

/*!50001 DROP VIEW IF EXISTS `v_anal`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_anal` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_anale`.`codepaie` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`t_anale`.`montant` AS `montant_payer`,NULL AS `periode` from ((((((`t_agent` join `t_anale` on((`t_anale`.`agent_ID` = `t_agent`.`matricule`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_anale`.`codepaie`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_anale`.`montant` <> 0)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_anal_ret`
--

/*!50001 DROP VIEW IF EXISTS `v_anal_ret`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_anal_ret` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_anale`.`codepaie` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`t_anale`.`montant` AS `montant_payer`,NULL AS `periode` from ((((((`t_agent` join `t_anale` on((`t_anale`.`agent_ID` = `t_agent`.`matricule`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_anale`.`codepaie`))) where ((`t_agent`.`activiter_ID` = '02') and (`t_anale`.`montant` <> 0)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_anciennete`
--

/*!50001 DROP VIEW IF EXISTS `v_anciennete`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_anciennete` AS select `t_agent`.`matricule` AS `matricule`,`t_agent`.`nom_ag` AS `nom_ag`,(year(curdate()) - year(`t_agent`.`dateEngagemnt_ag`)) AS `anciennete_en_annees`,(month(curdate()) - month(`t_agent`.`dateEngagemnt_ag`)) AS `anciennete_en_mois` from `t_agent` where (`t_agent`.`activiter_ID` = '01') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_aniv`
--

/*!50001 DROP VIEW IF EXISTS `v_aniv`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_aniv` AS select `t_agent`.`matricule` AS `matricule`,`t_agent`.`nom_ag` AS `nom_ag`,date_format(`t_agent`.`dateEngagemnt_ag`,'%d/%m') AS `anniversaire` from `t_agent` where ((`t_agent`.`activiter_ID` = '01') and (month(`t_agent`.`dateEngagemnt_ag`) = month(curdate()))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_aniv_fevrier`
--

/*!50001 DROP VIEW IF EXISTS `v_aniv_fevrier`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_aniv_fevrier` AS select `t_agent`.`matricule` AS `matricule`,`t_agent`.`nom_ag` AS `nom_ag`,date_format(`t_agent`.`dateEngagemnt_ag`,'%d/%m') AS `anniversaire` from `t_agent` where ((`t_agent`.`activiter_ID` = '01') and (month(`t_agent`.`dateEngagemnt_ag`) = month((curdate() - interval 2 month)))) order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_aniv_janvier`
--

/*!50001 DROP VIEW IF EXISTS `v_aniv_janvier`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_aniv_janvier` AS select `t_agent`.`matricule` AS `matricule`,`t_agent`.`nom_ag` AS `nom_ag`,date_format(`t_agent`.`dateEngagemnt_ag`,'%d/%m') AS `anniversaire` from `t_agent` where ((`t_agent`.`activiter_ID` = '01') and (month(`t_agent`.`dateEngagemnt_ag`) = '01')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_avance_cdf`
--

/*!50001 DROP VIEW IF EXISTS `v_avance_cdf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_avance_cdf` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_avance`.`code_paie_ID` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`t_avance`.`montant` AS `montant_payer`,NULL AS `periode` from ((((((`t_avance` join `t_agent` on((`t_avance`.`Agent_ID` = `t_agent`.`matricule`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_avance`.`code_paie_ID`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_avance`.`code_monnaie` = 'CDF')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_avance_franc`
--

/*!50001 DROP VIEW IF EXISTS `v_avance_franc`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_avance_franc` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_avance`.`code_paie_ID` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`t_avance`.`montant` AS `montant_payer`,`t_avance`.`periodeAv` AS `periodeAv` from ((((((`t_avance` join `t_agent` on((`t_avance`.`Agent_ID` = `t_agent`.`matricule`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_avance`.`code_paie_ID`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_avance`.`code_monnaie` = 'CDF') and (`t_avance`.`valeur` = 'A')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_avance_us`
--

/*!50001 DROP VIEW IF EXISTS `v_avance_us`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_avance_us` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_avance`.`code_paie_ID` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,(`t_avance`.`montant` * `t_taux`.`montantTaux`) AS `montant_payer`,`t_avance`.`periodeAv` AS `periodeAv` from (((((((`t_avance` join `t_agent` on((`t_avance`.`Agent_ID` = `t_agent`.`matricule`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_avance`.`code_paie_ID`))) join `t_taux` on((`t_taux`.`monnaie_ID` = `t_avance`.`code_monnaie`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_avance`.`code_monnaie` = 'USD') and (`t_taux`.`statut_ID` = 'act')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_avance_usd`
--

/*!50001 DROP VIEW IF EXISTS `v_avance_usd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_avance_usd` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_avance`.`code_paie_ID` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,(`t_avance`.`montant` * `t_taux`.`montantTaux`) AS `montant_payer`,NULL AS `periode` from (((((((`t_avance` join `t_agent` on((`t_avance`.`Agent_ID` = `t_agent`.`matricule`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_avance`.`code_paie_ID`))) join `t_taux` on((`t_taux`.`monnaie_ID` = `t_avance`.`code_monnaie`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_avance`.`code_monnaie` = 'USD') and (`t_taux`.`statut_ID` = 'act')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_bareme`
--

/*!50001 DROP VIEW IF EXISTS `v_bareme`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_bareme` AS select `a`.`matricule` AS `Matricule`,`a`.`nom_ag` AS `Nom`,`a`.`postnom_ag` AS `Postnom`,`a`.`prenom_ag` AS `Prenom_`,`a`.`NumCNSS_ag` AS `N_inss`,`a`.`sexe_ag` AS `sexe`,`a`.`etatCiv_ag` AS `etat_civil`,`a`.`nbreEnfant_ag` AS `sit_famille`,`dgb`.`code_grade` AS `grade`,`g`.`Eq_Paie_ID` AS `EquiG`,`b`.`codepaie` AS `codeElPaie`,`cp`.`libelle_codePaie` AS `libelle_el_paie`,`dgb`.`Montant_bar` AS `montant_payer`,NULL AS `periode` from (((((((`t_agent` `a` join `detail_agent_grade` `dag` on((`dag`.`agent_ID` = `a`.`matricule`))) join `t_grade` `g` on((`g`.`code_grade` = `dag`.`grade_ID`))) join `detail_grade_bareme` `dgb` on((`dgb`.`code_grade` = `g`.`code_grade`))) join `t_bareme` `b` on((`b`.`id_bar` = `dgb`.`id_bar`))) join `t_codepaie` `cp` on((`cp`.`codePaie` = `b`.`codepaie`))) join `detail_agent_siege` `das` on((`das`.`agent_ID` = `a`.`matricule`))) join `t_siege` `s` on((`s`.`code_sieg` = `das`.`siege_ID`))) where ((`a`.`activiter_ID` = '01') and (`b`.`statut_ID` = 'act') and (`s`.`statut_ID` = 'act') and (`dag`.`statut_ID` = 'act') and (`dgb`.`statut` = 'act') and (`das`.`statut_ID` = 'act') and (`dgb`.`Code_prov` = `s`.`province_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_bareme_ret`
--

/*!50001 DROP VIEW IF EXISTS `v_bareme_ret`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_bareme_ret` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_bareme`.`codepaie` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`detail_grade_bareme`.`Montant_bar` AS `montant_payer`,NULL AS `periode` from (((((`t_agent` join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_bareme`.`codepaie`))) where ((`t_agent`.`activiter_ID` = '02') and (`t_bareme`.`statut_ID` = 'act') and (`t_bareme`.`codepaie` = '001')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_brut_net_impos`
--

/*!50001 DROP VIEW IF EXISTS `v_brut_net_impos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_brut_net_impos` AS select `v_total_brut_imp`.`Matricule` AS `Matricule`,`v_total_brut_imp`.`Nom` AS `Nom`,`v_total_brut_imp`.`Postnom` AS `Postnom`,`v_total_brut_imp`.`Prenom` AS `Prenom`,`v_total_brut_imp`.`N_inss` AS `N_inss`,`v_total_brut_imp`.`sexe` AS `sexe`,`v_total_brut_imp`.`etat_civil` AS `etat_civil`,`v_total_brut_imp`.`sit_famille` AS `sit_famille`,`v_total_brut_imp`.`grade` AS `grade`,`v_total_brut_imp`.`EquiG` AS `EquiG`,'996' AS `codeElPaie`,'BRUT NET IMPOS' AS `libelle_el_paie`,(`v_total_brut_imp`.`Montant_imposa` - `v_ret_pens`.`montant_payer`) AS `Montant_brut`,`v_total_brut_imp`.`periode` AS `periode` from (`v_total_brut_imp` join `v_ret_pens` on((`v_total_brut_imp`.`Matricule` = `v_ret_pens`.`Matricule`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_brut_net_impos2`
--

/*!50001 DROP VIEW IF EXISTS `v_brut_net_impos2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_brut_net_impos2` AS select `v_total_brut_imp`.`Matricule` AS `Matricule`,`v_total_brut_imp`.`Nom` AS `Nom`,`v_total_brut_imp`.`Postnom` AS `Postnom`,`v_total_brut_imp`.`Prenom` AS `Prenom`,`v_total_brut_imp`.`N_inss` AS `N_inss`,`v_total_brut_imp`.`sexe` AS `sexe`,`v_total_brut_imp`.`etat_civil` AS `etat_civil`,`v_total_brut_imp`.`sit_famille` AS `sit_famille`,`v_total_brut_imp`.`grade` AS `grade`,`v_total_brut_imp`.`EquiG` AS `EquiG`,'996' AS `codeElPaie`,'BRUT NET IMPOS' AS `libelle_el_paie`,`v_total_brut_imp`.`Montant_imposa` AS `Montant_brut`,`v_total_brut_imp`.`periode` AS `periode` from ((`v_total_brut_imp` join `t_agent` on((`t_agent`.`matricule` = `v_total_brut_imp`.`Matricule`))) join `detail_agent_societe` on((`detail_agent_societe`.`agent_ID` = `t_agent`.`matricule`))) where (`detail_agent_societe`.`societe_ID` = '160') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_diplome`
--

/*!50001 DROP VIEW IF EXISTS `v_diplome`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_diplome` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`detail_nivetude_montant`.`codepaie` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`detail_nivetude_montant`.`montant` AS `montant_payer`,NULL AS `periode` from (((((((`t_agent` join `t_niv_etud` on((`t_niv_etud`.`id_niv_etud` = `t_agent`.`NivEtude_ag`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `detail_nivetude_montant` on((`detail_nivetude_montant`.`niv_etude_ID` = `t_niv_etud`.`id_niv_etud`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `detail_nivetude_montant`.`codepaie`))) where (`t_agent`.`activiter_ID` = '01') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_fonction`
--

/*!50001 DROP VIEW IF EXISTS `v_fonction`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_fonction` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_agent_grade`.`grade_ID` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_fonction`.`codePaie_ID` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`t_fonction`.`montant` AS `montant_payer`,NULL AS `periode` from (((((`t_agent` join `detail_agent_fonction` on((`detail_agent_fonction`.`agent_ID` = `t_agent`.`matricule`))) join `t_fonction` on((`t_fonction`.`codeFonct` = `detail_agent_fonction`.`fonction_ID`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_fonction`.`codePaie_ID`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_fonction`.`statut_ID` = 'act') and (`t_fonction`.`monnaie_ID` = 'CDF') and (`t_fonction`.`primer` = 'OUI') and (`detail_agent_fonction`.`statut_ID` = 'act') and (`t_grade`.`statut_ID` = 'act') and (`detail_agent_grade`.`statut_ID` = 'act')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_fonction_usd`
--

/*!50001 DROP VIEW IF EXISTS `v_fonction_usd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_fonction_usd` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_agent_grade`.`grade_ID` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_fonction`.`codePaie_ID` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,(`t_fonction`.`montant` * `t_taux`.`montantTaux`) AS `montant_payer`,NULL AS `periode` from ((((((`t_agent` join `detail_agent_fonction` on((`detail_agent_fonction`.`agent_ID` = `t_agent`.`matricule`))) join `t_fonction` on((`t_fonction`.`codeFonct` = `detail_agent_fonction`.`fonction_ID`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_fonction`.`codePaie_ID`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `t_taux` on((`t_taux`.`monnaie_ID` = `t_fonction`.`monnaie_ID`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_fonction`.`statut_ID` = 'act') and (`t_fonction`.`monnaie_ID` = 'USD') and (`t_fonction`.`primer` = 'OUI') and (`detail_agent_fonction`.`statut_ID` = 'act') and (`t_grade`.`statut_ID` = 'act') and (`detail_agent_grade`.`statut_ID` = 'act') and (`t_taux`.`statut_ID` = 'act')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_frais_dom`
--

/*!50001 DROP VIEW IF EXISTS `v_frais_dom`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_frais_dom` AS select '214' AS `codeElPaie`,'REMB.FRAIS DOMESTIQUES' AS `libelle_el_paie`,`detail_grade_bareme`.`Code_prov` AS `Code_Province_Bareme`,coalesce(sum(`detail_grade_bareme`.`Montant_bar`),0) AS `montant_payer`,NULL AS `periode` from ((`detail_grade_bareme` join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_bareme`.`codepaie`))) where ((`detail_grade_bareme`.`code_grade` = '02') and (`t_bareme`.`statut_ID` = 'act')) group by `detail_grade_bareme`.`Code_prov` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_heursup`
--

/*!50001 DROP VIEW IF EXISTS `v_heursup`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_heursup` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_type_heure`.`codepaie` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,((`t_heures`.`nbreh` * `detail_grade_bareme`.`Montant_bar`) / (26 / 8)) AS `montant_payer`,NULL AS `periode` from (((((((`t_heures` join `t_agent` on((`t_heures`.`matric` = `t_agent`.`matricule`))) join `t_type_heure` on((`t_type_heure`.`id_type` = `t_heures`.`typeHeure`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_type_heure`.`codepaie`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_heures`.`typeHeure` = 'N') and (`detail_grade_bareme`.`id_bar` = '001') and (`t_heures`.`nbreh` <> 0)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_heursupl`
--

/*!50001 DROP VIEW IF EXISTS `v_heursupl`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_heursupl` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`PostNom` AS `PostNom`,`t_calcule_paie`.`prenom` AS `prenom`,`t_calcule_paie`.`N_inss` AS `N_inss`,`t_calcule_paie`.`sexe` AS `sexe`,`t_calcule_paie`.`etat_civil` AS `etat_civil`,`t_calcule_paie`.`sit_famille` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,`t_calcule_paie`.`codeEiPaie` AS `codeEiPaie`,`t_calcule_paie`.`libelle_el_paie` AS `libelle_el_paie`,(((sum(`t_calcule_paie`.`montant_payer`) / (26 * 8)) * `t_heures`.`nbreh`) * 0.3) AS `montant_payer`,`t_heures`.`periode` AS `periode` from ((`t_calcule_paie` join `t_heures` on((`t_calcule_paie`.`Matricule` = `t_heures`.`matric`))) join `t_type_heure` on((`t_type_heure`.`id_type` = `t_heures`.`typeHeure`))) where ((`t_heures`.`typeHeure` = 'N') and (`t_calcule_paie`.`codeEiPaie` in ('001','006')) and (`t_heures`.`nbreh` <> 0)) group by `t_calcule_paie`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_historique`
--

/*!50001 DROP VIEW IF EXISTS `v_historique`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_historique` AS select `t_siege`.`libelle_sieg` AS `siege`,`t_role_user`.`libelle_role` AS `Profif`,`t_role_user`.`id_role` AS `id_role`,`t_utilisateurs`.`username` AS `UserID`,concat(`t_agent`.`nom_ag`,' ',`t_agent`.`postnom_ag`,' ',`t_agent`.`prenom_ag`) AS `Noms`,concat(`t_historique_conn`.`date_con`,' ',`t_historique_conn`.`heure_con`) AS `Date_Connexion`,concat(`t_historique_conn`.`date_decon`,' ',`t_historique_conn`.`heure_con`) AS `date_deconnexion` from (((((`t_historique_conn` join `t_utilisateurs` on((`t_utilisateurs`.`id_user` = `t_historique_conn`.`utilisateur_ID`))) join `t_agent` on((`t_agent`.`matricule` = `t_utilisateurs`.`agent_ID`))) join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `t_agent`.`matricule`))) join `t_siege` on((`t_siege`.`code_sieg` = `detail_agent_siege`.`siege_ID`))) join `t_role_user` on((`t_role_user`.`id_role` = `t_utilisateurs`.`role_user_ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_imt_reb_fdom`
--

/*!50001 DROP VIEW IF EXISTS `v_imt_reb_fdom`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_imt_reb_fdom` AS select distinct `v_bareme`.`Matricule` AS `Matricule`,`v_bareme`.`Nom` AS `Nom`,`v_bareme`.`Postnom` AS `PostNom`,`v_bareme`.`Prenom_` AS `Prenom_`,`v_bareme`.`N_inss` AS `N_inss`,`v_bareme`.`sexe` AS `sexe`,`v_bareme`.`etat_civil` AS `etat_civil`,`v_bareme`.`sit_famille` AS `sit_famille`,`v_bareme`.`grade` AS `grade`,`v_bareme`.`EquiG` AS `EquiG`,'214' AS `codeElPaie`,'REMB.FRAIS DOMESTIQUES' AS `libelle_el_paie`,`v_frais_dom`.`montant_payer` AS `montant_payer`,`v_bareme`.`periode` AS `periode` from (((((`v_bareme` join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `v_bareme`.`Matricule`))) join `t_siege` on((`t_siege`.`code_sieg` = `detail_agent_siege`.`siege_ID`))) join `v_frais_dom` on((`v_frais_dom`.`Code_Province_Bareme` = `t_siege`.`province_ID`))) join `detail_agent_fonction` on((`detail_agent_fonction`.`agent_ID` = `v_bareme`.`Matricule`))) join `t_fonction` on((`t_fonction`.`codeFonct` = `detail_agent_fonction`.`fonction_ID`))) where ((`v_bareme`.`grade` < 18) and (`t_fonction`.`codeFonct` in ('2080P','2050P','1760P','3021P','3022P','3001P','3002P','3011P','3012P')) and (`v_frais_dom`.`Code_Province_Bareme` = `t_siege`.`province_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_imt_reb_fdom_int`
--

/*!50001 DROP VIEW IF EXISTS `v_imt_reb_fdom_int`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_imt_reb_fdom_int` AS select distinct `v_bareme`.`Matricule` AS `Matricule`,`v_bareme`.`Nom` AS `Nom`,`v_bareme`.`Postnom` AS `PostNom`,`v_bareme`.`Prenom_` AS `Prenom_`,`v_bareme`.`N_inss` AS `N_inss`,`v_bareme`.`sexe` AS `sexe`,`v_bareme`.`etat_civil` AS `etat_civil`,`v_bareme`.`sit_famille` AS `sit_famille`,`v_bareme`.`grade` AS `grade`,`v_bareme`.`EquiG` AS `EquiG`,'215' AS `codeElPaie`,'INTERIM RBT FRS DOMESTIQUES' AS `libelle_el_paie`,`v_frais_dom`.`montant_payer` AS `montant_payer`,`v_bareme`.`periode` AS `periode` from (((((`v_bareme` join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `v_bareme`.`Matricule`))) join `t_siege` on((`t_siege`.`code_sieg` = `detail_agent_siege`.`siege_ID`))) join `v_frais_dom` on((`v_frais_dom`.`Code_Province_Bareme` = `t_siege`.`province_ID`))) join `detail_agent_fonction` on((`detail_agent_fonction`.`agent_ID` = `v_bareme`.`Matricule`))) join `t_fonction` on((`t_fonction`.`codeFonct` = `detail_agent_fonction`.`fonction_ID`))) where ((`v_bareme`.`grade` < 18) and (`t_fonction`.`codeFonct` in ('2081P','2051P','1761P'))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_info_agent`
--

/*!50001 DROP VIEW IF EXISTS `v_info_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_info_agent` AS select `a`.`matricule` AS `matricule`,`a`.`nom_ag` AS `nom_ag`,`a`.`postnom_ag` AS `postnom_ag`,`a`.`prenom_ag` AS `prenom_ag`,`a`.`sexe_ag` AS `sexe_ag`,`a`.`etatCiv_ag` AS `etatCiv_ag`,`a`.`dateNaiss_ag` AS `dateNaiss_ag`,`a`.`provNaiss` AS `provNaiss`,`a`.`provOrig` AS `provOrig`,`a`.`adresse` AS `adresse`,`a`.`phone` AS `phone`,`a`.`NumCNSS_ag` AS `NumCNSS_ag`,`a`.`NumCompt` AS `NumCompt`,`a`.`nbreEnfant_ag` AS `nbreEnfant_ag`,`a`.`ind_logement_ag` AS `ind_logement_ag`,`a`.`indiceCarburant` AS `indiceCarburant`,`a`.`indiceVoiture` AS `indiceVoiture`,`a`.`NivEtude_ag` AS `NivEtude_ag`,`a`.`dateEngagemnt_ag` AS `dateEngagemnt_ag`,`a`.`photo` AS `photo`,`a`.`photo_byte` AS `photo_byte`,`a`.`creerPar` AS `creerPar`,`a`.`modifierPar` AS `modifierPar`,`act`.`code_activ` AS `code_activ`,`act`.`libelle_activ` AS `libelle_activ`,`dir`.`code_dir` AS `code_dir`,`dir`.`libelle_dir` AS `libelle_dir`,`fn`.`codeFonct` AS `codeFonct`,`fn`.`libelleFonct` AS `libelleFonct`,`gr`.`code_grade` AS `code_grade`,`gr`.`libelle_grade` AS `libelle_grade`,`sg`.`code_sieg` AS `code_sieg`,`sg`.`libelle_sieg` AS `libelle_sieg`,`sc`.`code_soc` AS `code_soc`,`sc`.`libelle_soc` AS `libelle_soc`,`sy`.`code_syndi` AS `code_syndi`,`sy`.`libelle_syndi` AS `libelle_syndi` from ((((((((((((((`t_agent` `a` join `detail_agent_activ` `da` on(((`da`.`agent_ID` = `a`.`matricule`) and (`da`.`statut_ID` = 'act')))) join `t_activite` `act` on((`act`.`code_activ` = `da`.`code_activ_ID`))) join `detail_agent_direction` `dd` on(((`dd`.`agent_ID` = `a`.`matricule`) and (`dd`.`statut_ID` = 'act')))) join `t_direction` `dir` on((`dir`.`code_dir` = `dd`.`direction_ID`))) join `detail_agent_fonction` `df` on(((`df`.`agent_ID` = `a`.`matricule`) and (`df`.`statut_ID` = 'act')))) join `t_fonction` `fn` on((`fn`.`codeFonct` = `df`.`fonction_ID`))) join `detail_agent_grade` `dg` on(((`dg`.`agent_ID` = `a`.`matricule`) and (`dg`.`statut_ID` = 'act')))) join `t_grade` `gr` on((`gr`.`code_grade` = `dg`.`grade_ID`))) join `detail_agent_siege` `ds` on(((`ds`.`agent_ID` = `a`.`matricule`) and (`ds`.`statut_ID` = 'act')))) join `t_siege` `sg` on((`sg`.`code_sieg` = `ds`.`siege_ID`))) join `detail_agent_societe` `dsc` on(((`dsc`.`agent_ID` = `a`.`matricule`) and (`dsc`.`statut_ID` = 'act')))) join `t_societe` `sc` on((`sc`.`code_soc` = `dsc`.`societe_ID`))) join `detail_agent_syndicat` `dsy` on(((`dsy`.`agent_ID` = `a`.`matricule`) and (`dsy`.`statut_ID` = 'act')))) join `t_syndicat` `sy` on((`sy`.`code_syndi` = `dsy`.`syndicat_ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_info_pret`
--

/*!50001 DROP VIEW IF EXISTS `v_info_pret`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_info_pret` AS select `t_pret`.`id_pret` AS `id_pret`,`t_pret`.`moisEpuration` AS `moisEpuration`,`t_pret`.`periodePret` AS `periodePret`,`t_pret`.`montantPreter` AS `montantPreter`,`t_pret`.`solde` AS `solde`,`t_pret`.`montant_a_retenir` AS `montant_a_retenir`,`t_pret`.`dateDebut_retenir` AS `dateDebut_retenir`,`t_pret`.`taux_Interet` AS `taux_Interet`,`t_pret`.`creerPar` AS `creerPar`,`t_pret`.`modifierPar` AS `modifierPar`,`t_pret`.`N_refPret` AS `N_refPret`,`t_pret`.`dateModifier` AS `dateModifier`,`t_pret`.`statut_ID` AS `statut_ID`,`t_agent`.`matricule` AS `matricule`,`t_agent`.`nom_ag` AS `nom_ag`,`t_agent`.`postnom_ag` AS `postnom_ag`,`t_agent`.`prenom_ag` AS `prenom_ag`,`t_pret`.`monnaie_ID` AS `monnaie_ID`,`t_codepaie`.`codePaie` AS `codePaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_codePaie` from ((`t_pret` join `t_agent` on((`t_agent`.`matricule` = `t_pret`.`agent_ID`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_pret`.`codePaie_ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inpp`
--

/*!50001 DROP VIEW IF EXISTS `v_inpp`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_inpp` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'992' AS `codeElPaie`,'INPP' AS `libelle_el_paie`,((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.03) AS `montant_payer`,`t_calcule_paie`.`periode` AS `periode` from (((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'C') and (`t_agent`.`activiter_ID` = '01')) group by `t_calcule_paie`.`Matricule`,`t_calcule_paie`.`periode` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inpp_all`
--

/*!50001 DROP VIEW IF EXISTS `v_inpp_all`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_inpp_all` AS select `v_inpp_f`.`Matricule` AS `Matricule`,`v_inpp_f`.`Nom` AS `Nom`,`v_inpp_f`.`Postnom` AS `Postnom`,`v_inpp_f`.`Prenom` AS `Prenom`,`v_inpp_f`.`N_inss` AS `N_inss`,`v_inpp_f`.`sexe` AS `sexe`,`v_inpp_f`.`etat_civil` AS `etat_civil`,`v_inpp_f`.`sit_famille` AS `sit_famille`,`v_inpp_f`.`grade` AS `grade`,`v_inpp_f`.`EquiG` AS `EquiG`,`v_inpp_f`.`codeElPaie` AS `codeElPaie`,`v_inpp_f`.`libelle_el_paie` AS `libelle_el_paie`,`v_inpp_f`.`montant_payer` AS `montant_payer`,`v_inpp_f`.`periode` AS `periode` from `v_inpp_f` union all select `v_inpp`.`Matricule` AS `Matricule`,`v_inpp`.`Nom` AS `Nom`,`v_inpp`.`Postnom` AS `Postnom`,`v_inpp`.`Prenom` AS `Prenom`,`v_inpp`.`N_inss` AS `N_inss`,`v_inpp`.`sexe` AS `sexe`,`v_inpp`.`etat_civil` AS `etat_civil`,`v_inpp`.`sit_famille` AS `sit_famille`,`v_inpp`.`grade` AS `grade`,`v_inpp`.`EquiG` AS `EquiG`,`v_inpp`.`codeElPaie` AS `codeElPaie`,`v_inpp`.`libelle_el_paie` AS `libelle_el_paie`,`v_inpp`.`montant_payer` AS `montant_payer`,`v_inpp`.`periode` AS `periode` from `v_inpp` union all select `v_inpp_cdd`.`Matricule` AS `Matricule`,`v_inpp_cdd`.`Nom` AS `Nom`,`v_inpp_cdd`.`Postnom` AS `Postnom`,`v_inpp_cdd`.`Prenom` AS `Prenom`,`v_inpp_cdd`.`N_inss` AS `N_inss`,`v_inpp_cdd`.`sexe` AS `sexe`,`v_inpp_cdd`.`etat_civil` AS `etat_civil`,`v_inpp_cdd`.`sit_famille` AS `sit_famille`,`v_inpp_cdd`.`grade` AS `grade`,`v_inpp_cdd`.`EquiG` AS `EquiG`,`v_inpp_cdd`.`codeElPaie` AS `codeElPaie`,`v_inpp_cdd`.`libelle_el_paie` AS `libelle_el_paie`,`v_inpp_cdd`.`montant_payer` AS `montant_payer`,`v_inpp_cdd`.`periode` AS `periode` from `v_inpp_cdd` union all select `v_inpp_allep`.`Matricule` AS `Matricule`,`v_inpp_allep`.`Nom` AS `Nom`,`v_inpp_allep`.`Postnom` AS `Postnom`,`v_inpp_allep`.`Prenom` AS `Prenom`,`v_inpp_allep`.`N_inss` AS `N_inss`,`v_inpp_allep`.`sexe` AS `sexe`,`v_inpp_allep`.`etat_civil` AS `etat_civil`,`v_inpp_allep`.`sit_famille` AS `sit_famille`,`v_inpp_allep`.`grade` AS `grade`,`v_inpp_allep`.`EquiG` AS `EquiG`,`v_inpp_allep`.`codeElPaie` AS `codeElPaie`,`v_inpp_allep`.`libelle_el_paie` AS `libelle_el_paie`,`v_inpp_allep`.`montant_payer` AS `montant_payer`,`v_inpp_allep`.`periode` AS `periode` from `v_inpp_allep` union all select `v_inpp_allep_cdd`.`Matricule` AS `Matricule`,`v_inpp_allep_cdd`.`Nom` AS `Nom`,`v_inpp_allep_cdd`.`Postnom` AS `Postnom`,`v_inpp_allep_cdd`.`Prenom` AS `Prenom`,`v_inpp_allep_cdd`.`N_inss` AS `N_inss`,`v_inpp_allep_cdd`.`sexe` AS `sexe`,`v_inpp_allep_cdd`.`etat_civil` AS `etat_civil`,`v_inpp_allep_cdd`.`sit_famille` AS `sit_famille`,`v_inpp_allep_cdd`.`grade` AS `grade`,`v_inpp_allep_cdd`.`EquiG` AS `EquiG`,`v_inpp_allep_cdd`.`codeElPaie` AS `codeElPaie`,`v_inpp_allep_cdd`.`libelle_el_paie` AS `libelle_el_paie`,`v_inpp_allep_cdd`.`montant_payer` AS `montant_payer`,`v_inpp_allep_cdd`.`periode` AS `periode` from `v_inpp_allep_cdd` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inpp_allep`
--

/*!50001 DROP VIEW IF EXISTS `v_inpp_allep`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_inpp_allep` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'992' AS `codeElPaie`,'INPP' AS `libelle_el_paie`,((sum(`t_calcule_paie`.`montant_payer`) - (`v_alloc_epouse`.`montant_payer` + `v_ret_pens`.`montant_payer`)) * 0.03) AS `montant_payer`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_alloc_epouse` on((`v_alloc_epouse`.`Matricule` = `t_agent`.`matricule`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01')) group by `t_calcule_paie`.`Matricule`,`t_calcule_paie`.`periode` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inpp_allep_cdd`
--

/*!50001 DROP VIEW IF EXISTS `v_inpp_allep_cdd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_inpp_allep_cdd` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'992' AS `codeElPaie`,'INPP' AS `libelle_el_paie`,(sum((`t_calcule_paie`.`montant_payer` - `v_alloc_epouse`.`montant_payer`)) * 0.03) AS `montant_payer`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `v_alloc_epouse` on((`v_alloc_epouse`.`Matricule` = `t_agent`.`matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_societe` on((`detail_agent_societe`.`agent_ID` = `t_calcule_paie`.`Matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01') and (`t_agent`.`etatCiv_ag` = 'M') and (`detail_agent_societe`.`societe_ID` = '160')) group by `t_calcule_paie`.`Matricule`,`t_calcule_paie`.`periode` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inpp_cdd`
--

/*!50001 DROP VIEW IF EXISTS `v_inpp_cdd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_inpp_cdd` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'992' AS `codeElPaie`,'INPP' AS `libelle_el_paie`,(sum((`t_calcule_paie`.`montant_payer` - `v_alloc_epouse`.`montant_payer`)) * 0.03) AS `montant_payer`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `v_alloc_epouse` on((`v_alloc_epouse`.`Matricule` = `t_agent`.`matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_societe` on((`detail_agent_societe`.`agent_ID` = `t_calcule_paie`.`Matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01') and (`t_agent`.`etatCiv_ag` = 'M') and (`detail_agent_societe`.`societe_ID` = '160')) group by `t_calcule_paie`.`Matricule`,`t_calcule_paie`.`periode` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inpp_f`
--

/*!50001 DROP VIEW IF EXISTS `v_inpp_f`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_inpp_f` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'992' AS `codeElPaie`,'INPP' AS `libelle_el_paie`,((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.03) AS `montant_payer`,`t_calcule_paie`.`periode` AS `periode` from (((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`sexe_ag` = 'F') and (`t_agent`.`activiter_ID` = '01')) group by `t_calcule_paie`.`Matricule`,`t_calcule_paie`.`periode` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_interim_franc`
--

/*!50001 DROP VIEW IF EXISTS `v_interim_franc`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_interim_franc` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_avance`.`code_paie_ID` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,`t_avance`.`montant` AS `montant_payer`,`t_avance`.`periodeAv` AS `periodeAv` from ((((((`t_avance` join `t_agent` on((`t_avance`.`Agent_ID` = `t_agent`.`matricule`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_avance`.`code_paie_ID`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_avance`.`code_monnaie` = 'CDF') and (`t_avance`.`valeur` = 'I')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_interim_us`
--

/*!50001 DROP VIEW IF EXISTS `v_interim_us`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_interim_us` AS select distinct `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom_`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`detail_grade_bareme`.`code_grade` AS `grade`,`t_grade`.`Eq_Paie_ID` AS `EquiG`,`t_avance`.`code_paie_ID` AS `codeElPaie`,`t_codepaie`.`libelle_codePaie` AS `libelle_el_paie`,(`t_avance`.`montant` * `t_taux`.`montantTaux`) AS `montant_payer`,`t_avance`.`periodeAv` AS `periodeAv` from (((((((`t_avance` join `t_agent` on((`t_avance`.`Agent_ID` = `t_agent`.`matricule`))) join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_avance`.`code_paie_ID`))) join `t_taux` on((`t_taux`.`monnaie_ID` = `t_avance`.`code_monnaie`))) where ((`t_agent`.`activiter_ID` = '01') and (`t_avance`.`code_monnaie` = 'USD') and (`t_taux`.`statut_ID` = 'act') and (`t_avance`.`valeur` = 'I')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipr_all`
--

/*!50001 DROP VIEW IF EXISTS `v_ipr_all`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipr_all` AS select `v_iprdm2`.`Matricule` AS `Matricule`,`v_iprdm2`.`Nom` AS `Nom`,`v_iprdm2`.`Postnom` AS `Postnom`,`v_iprdm2`.`Prenom` AS `Prenom`,`v_iprdm2`.`N_inss` AS `N_inss`,`v_iprdm2`.`sexe` AS `sexe`,`v_iprdm2`.`etat_civil` AS `etat_civil`,`v_iprdm2`.`sit_famille` AS `sit_famille`,`v_iprdm2`.`grade` AS `grade`,`v_iprdm2`.`EquiG` AS `EquiG`,`v_iprdm2`.`codeElPaie` AS `codeElPaie`,`v_iprdm2`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprdm2`.`Montant_impot` AS `Montant_impot`,`v_iprdm2`.`periode` AS `periode` from `v_iprdm2` union all select `v_iprdm`.`Matricule` AS `Matricule`,`v_iprdm`.`Nom` AS `Nom`,`v_iprdm`.`Postnom` AS `Postnom`,`v_iprdm`.`Prenom` AS `Prenom`,`v_iprdm`.`N_inss` AS `N_inss`,`v_iprdm`.`sexe` AS `sexe`,`v_iprdm`.`etat_civil` AS `etat_civil`,`v_iprdm`.`sit_famille` AS `sit_famille`,`v_iprdm`.`grade` AS `grade`,`v_iprdm`.`EquiG` AS `EquiG`,`v_iprdm`.`codeElPaie` AS `codeElPaie`,`v_iprdm`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprdm`.`Montant_impot` AS `Montant_impot`,`v_iprdm`.`periode` AS `periode` from `v_iprdm` union all select `v_iprdc2`.`Matricule` AS `Matricule`,`v_iprdc2`.`Nom` AS `Nom`,`v_iprdc2`.`Postnom` AS `Postnom`,`v_iprdc2`.`Prenom` AS `Prenom`,`v_iprdc2`.`N_inss` AS `N_inss`,`v_iprdc2`.`sexe` AS `sexe`,`v_iprdc2`.`etat_civil` AS `etat_civil`,`v_iprdc2`.`sit_famille` AS `sit_famille`,`v_iprdc2`.`grade` AS `grade`,`v_iprdc2`.`EquiG` AS `EquiG`,`v_iprdc2`.`codeElPaie` AS `codeElPaie`,`v_iprdc2`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprdc2`.`Montant_impot` AS `Montant_impot`,`v_iprdc2`.`periode` AS `periode` from `v_iprdc2` union all select `v_iprdc`.`Matricule` AS `Matricule`,`v_iprdc`.`Nom` AS `Nom`,`v_iprdc`.`Postnom` AS `Postnom`,`v_iprdc`.`Prenom` AS `Prenom`,`v_iprdc`.`N_inss` AS `N_inss`,`v_iprdc`.`sexe` AS `sexe`,`v_iprdc`.`etat_civil` AS `etat_civil`,`v_iprdc`.`sit_famille` AS `sit_famille`,`v_iprdc`.`grade` AS `grade`,`v_iprdc`.`EquiG` AS `EquiG`,`v_iprdc`.`codeElPaie` AS `codeElPaie`,`v_iprdc`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprdc`.`Montant_impot` AS `Montant_impot`,`v_iprdc`.`periode` AS `periode` from `v_iprdc` union all select `v_iprcm2`.`Matricule` AS `Matricule`,`v_iprcm2`.`Nom` AS `Nom`,`v_iprcm2`.`Postnom` AS `Postnom`,`v_iprcm2`.`Prenom` AS `Prenom`,`v_iprcm2`.`N_inss` AS `N_inss`,`v_iprcm2`.`sexe` AS `sexe`,`v_iprcm2`.`etat_civil` AS `etat_civil`,`v_iprcm2`.`sit_famille` AS `sit_famille`,`v_iprcm2`.`grade` AS `grade`,`v_iprcm2`.`EquiG` AS `EquiG`,`v_iprcm2`.`codeElPaie` AS `codeElPaie`,`v_iprcm2`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprcm2`.`Montant_impot` AS `Montant_impot`,`v_iprcm2`.`periode` AS `periode` from `v_iprcm2` union all select `v_iprcm`.`Matricule` AS `Matricule`,`v_iprcm`.`Nom` AS `Nom`,`v_iprcm`.`Postnom` AS `Postnom`,`v_iprcm`.`Prenom` AS `Prenom`,`v_iprcm`.`N_inss` AS `N_inss`,`v_iprcm`.`sexe` AS `sexe`,`v_iprcm`.`etat_civil` AS `etat_civil`,`v_iprcm`.`sit_famille` AS `sit_famille`,`v_iprcm`.`grade` AS `grade`,`v_iprcm`.`EquiG` AS `EquiG`,`v_iprcm`.`codeElPaie` AS `codeElPaie`,`v_iprcm`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprcm`.`Montant_impot` AS `Montant_impot`,`v_iprcm`.`periode` AS `periode` from `v_iprcm` union all select `v_iprcc2`.`Matricule` AS `Matricule`,`v_iprcc2`.`Nom` AS `Nom`,`v_iprcc2`.`Postnom` AS `Postnom`,`v_iprcc2`.`Prenom` AS `Prenom`,`v_iprcc2`.`N_inss` AS `N_inss`,`v_iprcc2`.`sexe` AS `sexe`,`v_iprcc2`.`etat_civil` AS `etat_civil`,`v_iprcc2`.`sit_famille` AS `sit_famille`,`v_iprcc2`.`grade` AS `grade`,`v_iprcc2`.`EquiG` AS `EquiG`,`v_iprcc2`.`codeElPaie` AS `codeElPaie`,`v_iprcc2`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprcc2`.`Montant_impot` AS `Montant_impot`,`v_iprcc2`.`periode` AS `periode` from `v_iprcc2` union all select `v_iprcc`.`Matricule` AS `Matricule`,`v_iprcc`.`Nom` AS `Nom`,`v_iprcc`.`Postnom` AS `Postnom`,`v_iprcc`.`Prenom` AS `Prenom`,`v_iprcc`.`N_inss` AS `N_inss`,`v_iprcc`.`sexe` AS `sexe`,`v_iprcc`.`etat_civil` AS `etat_civil`,`v_iprcc`.`sit_famille` AS `sit_famille`,`v_iprcc`.`grade` AS `grade`,`v_iprcc`.`EquiG` AS `EquiG`,`v_iprcc`.`codeElPaie` AS `codeElPaie`,`v_iprcc`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprcc`.`Montant_impot` AS `Montant_impot`,`v_iprcc`.`periode` AS `periode` from `v_iprcc` union all select `v_iprbc2`.`Matricule` AS `Matricule`,`v_iprbc2`.`Nom` AS `Nom`,`v_iprbc2`.`Postnom` AS `Postnom`,`v_iprbc2`.`Prenom` AS `Prenom`,`v_iprbc2`.`N_inss` AS `N_inss`,`v_iprbc2`.`sexe` AS `sexe`,`v_iprbc2`.`etat_civil` AS `etat_civil`,`v_iprbc2`.`sit_famille` AS `sit_famille`,`v_iprbc2`.`grade` AS `grade`,`v_iprbc2`.`EquiG` AS `EquiG`,`v_iprbc2`.`codeElPaie` AS `codeElPaie`,`v_iprbc2`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprbc2`.`Montant_impot` AS `Montant_impot`,`v_iprbc2`.`periode` AS `periode` from `v_iprbc2` union all select `v_iprbc`.`Matricule` AS `Matricule`,`v_iprbc`.`Nom` AS `Nom`,`v_iprbc`.`Postnom` AS `Postnom`,`v_iprbc`.`Prenom` AS `Prenom`,`v_iprbc`.`N_inss` AS `N_inss`,`v_iprbc`.`sexe` AS `sexe`,`v_iprbc`.`etat_civil` AS `etat_civil`,`v_iprbc`.`sit_famille` AS `sit_famille`,`v_iprbc`.`grade` AS `grade`,`v_iprbc`.`EquiG` AS `EquiG`,`v_iprbc`.`codeElPaie` AS `codeElPaie`,`v_iprbc`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprbc`.`Montant_impot` AS `Montant_impot`,`v_iprbc`.`periode` AS `periode` from `v_iprbc` union all select `v_ipram2`.`Matricule` AS `Matricule`,`v_ipram2`.`Nom` AS `Nom`,`v_ipram2`.`Postnom` AS `Postnom`,`v_ipram2`.`Prenom` AS `Prenom`,`v_ipram2`.`N_inss` AS `N_inss`,`v_ipram2`.`sexe` AS `sexe`,`v_ipram2`.`etat_civil` AS `etat_civil`,`v_ipram2`.`sit_famille` AS `sit_famille`,`v_ipram2`.`grade` AS `grade`,`v_ipram2`.`EquiG` AS `EquiG`,`v_ipram2`.`codeElPaie` AS `codeElPaie`,`v_ipram2`.`libelle_el_paie` AS `libelle_el_paie`,`v_ipram2`.`Montant_impot` AS `Montant_impot`,`v_ipram2`.`periode` AS `periode` from `v_ipram2` union all select `v_ipram`.`Matricule` AS `Matricule`,`v_ipram`.`Nom` AS `Nom`,`v_ipram`.`Postnom` AS `Postnom`,`v_ipram`.`Prenom` AS `Prenom`,`v_ipram`.`N_inss` AS `N_inss`,`v_ipram`.`sexe` AS `sexe`,`v_ipram`.`etat_civil` AS `etat_civil`,`v_ipram`.`sit_famille` AS `sit_famille`,`v_ipram`.`grade` AS `grade`,`v_ipram`.`EquiG` AS `EquiG`,`v_ipram`.`codeElPaie` AS `codeElPaie`,`v_ipram`.`libelle_el_paie` AS `libelle_el_paie`,`v_ipram`.`Montant_impot` AS `Montant_impot`,`v_ipram`.`periode` AS `periode` from `v_ipram` union all select `v_iprac2`.`Matricule` AS `Matricule`,`v_iprac2`.`Nom` AS `Nom`,`v_iprac2`.`Postnom` AS `Postnom`,`v_iprac2`.`Prenom` AS `Prenom`,`v_iprac2`.`N_inss` AS `N_inss`,`v_iprac2`.`sexe` AS `sexe`,`v_iprac2`.`etat_civil` AS `etat_civil`,`v_iprac2`.`sit_famille` AS `sit_famille`,`v_iprac2`.`grade` AS `grade`,`v_iprac2`.`EquiG` AS `EquiG`,`v_iprac2`.`codeElPaie` AS `codeElPaie`,`v_iprac2`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprac2`.`Montant_impot` AS `Montant_impot`,`v_iprac2`.`periode` AS `periode` from `v_iprac2` union all select `v_iprac`.`Matricule` AS `Matricule`,`v_iprac`.`Nom` AS `Nom`,`v_iprac`.`Postnom` AS `Postnom`,`v_iprac`.`Prenom` AS `Prenom`,`v_iprac`.`N_inss` AS `N_inss`,`v_iprac`.`sexe` AS `sexe`,`v_iprac`.`etat_civil` AS `etat_civil`,`v_iprac`.`sit_famille` AS `sit_famille`,`v_iprac`.`grade` AS `grade`,`v_iprac`.`EquiG` AS `EquiG`,`v_iprac`.`codeElPaie` AS `codeElPaie`,`v_iprac`.`libelle_el_paie` AS `libelle_el_paie`,`v_iprac`.`Montant_impot` AS `Montant_impot`,`v_iprac`.`periode` AS `periode` from `v_iprac` union all select `v_ipr_bm2`.`Matricule` AS `Matricule`,`v_ipr_bm2`.`Nom` AS `Nom`,`v_ipr_bm2`.`Postnom` AS `Postnom`,`v_ipr_bm2`.`Prenom` AS `Prenom`,`v_ipr_bm2`.`N_inss` AS `N_inss`,`v_ipr_bm2`.`sexe` AS `sexe`,`v_ipr_bm2`.`etat_civil` AS `etat_civil`,`v_ipr_bm2`.`sit_famille` AS `sit_famille`,`v_ipr_bm2`.`grade` AS `grade`,`v_ipr_bm2`.`EquiG` AS `EquiG`,`v_ipr_bm2`.`codeElPaie` AS `codeElPaie`,`v_ipr_bm2`.`libelle_el_paie` AS `libelle_el_paie`,`v_ipr_bm2`.`Montant_impot` AS `Montant_impot`,`v_ipr_bm2`.`periode` AS `periode` from `v_ipr_bm2` union all select `v_ipr_bm`.`Matricule` AS `Matricule`,`v_ipr_bm`.`Nom` AS `Nom`,`v_ipr_bm`.`Postnom` AS `Postnom`,`v_ipr_bm`.`Prenom` AS `Prenom`,`v_ipr_bm`.`N_inss` AS `N_inss`,`v_ipr_bm`.`sexe` AS `sexe`,`v_ipr_bm`.`etat_civil` AS `etat_civil`,`v_ipr_bm`.`sit_famille` AS `sit_famille`,`v_ipr_bm`.`grade` AS `grade`,`v_ipr_bm`.`EquiG` AS `EquiG`,`v_ipr_bm`.`codeElPaie` AS `codeElPaie`,`v_ipr_bm`.`libelle_el_paie` AS `libelle_el_paie`,`v_ipr_bm`.`Montant_impot` AS `Montant_impot`,`v_ipr_bm`.`periode` AS `periode` from `v_ipr_bm` union all select `v_ipr_cdi_bc2`.`Matricule` AS `Matricule`,`v_ipr_cdi_bc2`.`Nom` AS `Nom`,`v_ipr_cdi_bc2`.`Postnom` AS `Postnom`,`v_ipr_cdi_bc2`.`Prenom` AS `Prenom`,`v_ipr_cdi_bc2`.`N_inss` AS `N_inss`,`v_ipr_cdi_bc2`.`sexe` AS `sexe`,`v_ipr_cdi_bc2`.`etat_civil` AS `etat_civil`,`v_ipr_cdi_bc2`.`sit_famille` AS `sit_famille`,`v_ipr_cdi_bc2`.`grade` AS `grade`,`v_ipr_cdi_bc2`.`EquiG` AS `EquiG`,`v_ipr_cdi_bc2`.`codeElPaie` AS `codeElPaie`,`v_ipr_cdi_bc2`.`libelle_el_paie` AS `libelle_el_paie`,`v_ipr_cdi_bc2`.`Montant_impot` AS `Montant_impot`,`v_ipr_cdi_bc2`.`periode` AS `periode` from `v_ipr_cdi_bc2` union all select `v_ipr_bm22`.`Matricule` AS `Matricule`,`v_ipr_bm22`.`Nom` AS `Nom`,`v_ipr_bm22`.`Postnom` AS `Postnom`,`v_ipr_bm22`.`Prenom` AS `Prenom`,`v_ipr_bm22`.`N_inss` AS `N_inss`,`v_ipr_bm22`.`sexe` AS `sexe`,`v_ipr_bm22`.`etat_civil` AS `etat_civil`,`v_ipr_bm22`.`sit_famille` AS `sit_famille`,`v_ipr_bm22`.`grade` AS `grade`,`v_ipr_bm22`.`EquiG` AS `EquiG`,`v_ipr_bm22`.`codeElPaie` AS `codeElPaie`,`v_ipr_bm22`.`libelle_el_paie` AS `libelle_el_paie`,`v_ipr_bm22`.`Montant_impot` AS `Montant_impot`,`v_ipr_bm22`.`periode` AS `periode` from `v_ipr_bm22` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipr_bm`
--

/*!50001 DROP VIEW IF EXISTS `v_ipr_bm`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipr_bm` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) - 162000) * 0.15) + 4860) - (((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) - 162000) * 0.15) + 4860) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '162000' and '1800000') and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipr_bm2`
--

/*!50001 DROP VIEW IF EXISTS `v_ipr_bm2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipr_bm2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) - 162000) * 0.15) + 4860) - (((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) - 162000) * 0.15) + 4860) * ((`t_agent`.`nbreEnfant_ag` + 1) * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`sexe_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '162000' and '1800000') and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipr_bm22`
--

/*!50001 DROP VIEW IF EXISTS `v_ipr_bm22`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipr_bm22` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 162000) * 0.15) + 4860) - (((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 162000) * 0.15) + 4860) * (`t_agent`.`nbreEnfant_ag` * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`sexe_ag` = 'F') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '162000' and '1800000') and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipr_cdi_bc`
--

/*!50001 DROP VIEW IF EXISTS `v_ipr_cdi_bc`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipr_cdi_bc` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,((((sum(`t_calcule_paie`.`montant_payer`) - 162000) * 0.15) + 4860) - ((((sum(`t_calcule_paie`.`montant_payer`) - 162000) * 0.15) + 4860) * (`t_agent`.`nbreEnfant_ag` * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_societe` on((`detail_agent_societe`.`agent_ID` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`detail_agent_societe`.`societe_ID` = '160') and (`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '162000' and '1800000') and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipr_cdi_bc2`
--

/*!50001 DROP VIEW IF EXISTS `v_ipr_cdi_bc2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipr_cdi_bc2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,((((sum(`t_calcule_paie`.`montant_payer`) - 162000) * 0.15) + 4860) - ((((sum(`t_calcule_paie`.`montant_payer`) - 162000) * 0.15) + 4860) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_societe` on((`detail_agent_societe`.`agent_ID` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`detail_agent_societe`.`societe_ID` = '160') and (`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '162000' and '1800000') and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipr_cdi_bm`
--

/*!50001 DROP VIEW IF EXISTS `v_ipr_cdi_bm`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipr_cdi_bm` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - `t_alloc_famille`.`montant_alloc`) - 162000) * 0.15) + 4860) - (((((sum(`t_calcule_paie`.`montant_payer`) - `t_alloc_famille`.`montant_alloc`) - 162000) * 0.15) + 4860) * ((`t_agent`.`nbreEnfant_ag` + 1) * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_societe` on((`detail_agent_societe`.`agent_ID` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`detail_agent_societe`.`societe_ID` = '160') and (`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '162000' and '1800000') and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprac`
--

/*!50001 DROP VIEW IF EXISTS `v_iprac`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprac` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.03) - (((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.03) * (`t_agent`.`nbreEnfant_ag` * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` < 162000) and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprac2`
--

/*!50001 DROP VIEW IF EXISTS `v_iprac2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprac2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.03) - (((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.03) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` < 162000) and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipram`
--

/*!50001 DROP VIEW IF EXISTS `v_ipram`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipram` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) * 0.03) - (((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) * 0.03) * ((`t_agent`.`nbreEnfant_ag` + 1) * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` < 162000) and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ipram2`
--

/*!50001 DROP VIEW IF EXISTS `v_ipram2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ipram2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) * 0.03) - (((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) * 0.03) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` < 162000) and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprbc`
--

/*!50001 DROP VIEW IF EXISTS `v_iprbc`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprbc` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 162000) * 0.15) + 4860) - (((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 162000) * 0.15) + 4860) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '162000' and '1800000') and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprbc2`
--

/*!50001 DROP VIEW IF EXISTS `v_iprbc2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprbc2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 162000) * 0.15) + 4860) - (((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 162000) * 0.15) + 4860) * (`t_agent`.`nbreEnfant_ag` * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '162000' and '1800000') and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule`,`t_calcule_paie`.`periode` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprcc`
--

/*!50001 DROP VIEW IF EXISTS `v_iprcc`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprcc` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 1800000) * 0.30) + 250560) - (((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 1800000) * 0.30) + 250560) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '1800001' and '3600000') and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprcc2`
--

/*!50001 DROP VIEW IF EXISTS `v_iprcc2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprcc2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 1800000) * 0.30) + 250560) - (((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) - 1800000) * 0.30) + 250560) * (`t_agent`.`nbreEnfant_ag` * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '1800001' and '3600000') and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprcm`
--

/*!50001 DROP VIEW IF EXISTS `v_iprcm`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprcm` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) - 1800000) * 0.30) + 250560) - (((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) - 1800000) * 0.30) + 250560) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '1800001' and '3600000') and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprcm2`
--

/*!50001 DROP VIEW IF EXISTS `v_iprcm2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprcm2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,(((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) - 1800000) * 0.30) + 250560) - (((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) - 1800000) * 0.30) + 250560) * ((`t_agent`.`nbreEnfant_ag` + 1) * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` between '1800001' and '3600000') and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprdc`
--

/*!50001 DROP VIEW IF EXISTS `v_iprdc`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprdc` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.40) + 790560) - ((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.40) + 790560) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` > 3600000) and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprdc2`
--

/*!50001 DROP VIEW IF EXISTS `v_iprdc2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprdc2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.40) + 790560) - ((((sum(`t_calcule_paie`.`montant_payer`) - `v_ret_pens`.`montant_payer`) * 0.40) + 790560) * (`t_agent`.`nbreEnfant_ag` * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` <> 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` > 3600000) and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprdm`
--

/*!50001 DROP VIEW IF EXISTS `v_iprdm`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprdm` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) * 0.40) + 790560) - ((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) * 0.40) + 790560) * (9 * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` > 3600000) and (`t_agent`.`nbreEnfant_ag` >= 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_iprdm2`
--

/*!50001 DROP VIEW IF EXISTS `v_iprdm2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_iprdm2` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'409' AS `codeElPaie`,'IMPOT PROF. REMUNERATION' AS `libelle_el_paie`,((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) * 0.40) + 790560) - ((((sum(`t_calcule_paie`.`montant_payer`) - (`v_ret_pens`.`montant_payer` + `t_alloc_famille`.`montant_alloc`)) * 0.40) + 790560) * ((`t_agent`.`nbreEnfant_ag` + 1) * 0.02))) AS `Montant_impot`,`t_calcule_paie`.`periode` AS `periode` from (((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `v_ret_pens` on((`v_ret_pens`.`Matricule` = `t_calcule_paie`.`Matricule`))) join `v_total_brut_imp` on(((`v_total_brut_imp`.`Matricule` = `t_calcule_paie`.`Matricule`) and (`v_total_brut_imp`.`periode` = `t_calcule_paie`.`periode`)))) join `t_alloc_famille` on((`t_alloc_famille`.`id_alloc` = `t_agent`.`etatCiv_ag`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`etatCiv_ag` = 'M') and (`t_agent`.`activiter_ID` = '01') and (`v_total_brut_imp`.`Montant_imposa` > 3600000) and (`t_agent`.`nbreEnfant_ag` < 9)) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_liste_utilisateur`
--

/*!50001 DROP VIEW IF EXISTS `v_liste_utilisateur`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_liste_utilisateur` AS select `t_utilisateurs`.`id_user` AS `id_user`,`t_utilisateurs`.`username` AS `username`,`t_utilisateurs`.`creerPar` AS `creerPar`,`t_utilisateurs`.`modifierPar` AS `modifierPar`,`t_utilisateurs`.`dateCreation` AS `dateCreation`,`t_utilisateurs`.`dateLast_Modifi` AS `dateLast_Modifi`,`t_utilisateurs`.`agent_ID` AS `agent_ID`,`t_agent`.`nom_ag` AS `nom_ag`,`t_agent`.`postnom_ag` AS `postnom_ag`,`t_agent`.`prenom_ag` AS `prenom_ag`,`t_direction`.`libelle_dir` AS `libelle_dir`,`t_agent`.`photo` AS `photo`,`t_statut`.`libelle_st` AS `libelle_st`,`t_statut`.`code_st` AS `code_st`,`t_role_user`.`id_role` AS `id_role`,`t_role_user`.`libelle_role` AS `libelle_role` from (((((`t_utilisateurs` join `t_agent` on((`t_agent`.`matricule` = `t_utilisateurs`.`agent_ID`))) join `t_statut` on((`t_statut`.`code_st` = `t_utilisateurs`.`statut_ID`))) join `t_role_user` on((`t_role_user`.`id_role` = `t_utilisateurs`.`role_user_ID`))) join `detail_agent_direction` on((`t_agent`.`matricule` = `detail_agent_direction`.`agent_ID`))) join `t_direction` on((`detail_agent_direction`.`direction_ID` = `t_direction`.`code_dir`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_net_a_payer`
--

/*!50001 DROP VIEW IF EXISTS `v_net_a_payer`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_net_a_payer` AS select distinct `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`PostNom` AS `Postnom`,`t_calcule_paie`.`prenom` AS `Prenom`,`t_calcule_paie`.`N_inss` AS `N_inss`,`t_calcule_paie`.`sexe` AS `sexe`,`t_calcule_paie`.`etat_civil` AS `etat_civil`,`t_calcule_paie`.`sit_famille` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'999' AS `codeElPaie`,'NET A PAYER' AS `libelle_el_paie`,(`t_calcule_paie`.`montant_payer` - `t_retenue`.`montant_payer`) AS `Montant_net_payer`,`t_calcule_paie`.`periode` AS `periode` from (`t_calcule_paie` join `t_retenue` on((`t_retenue`.`Matricule` = `t_calcule_paie`.`Matricule`))) where ((`t_calcule_paie`.`codeEiPaie` = '997') and (`t_retenue`.`codeEiPaie` = '998')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_net_a_payer_r`
--

/*!50001 DROP VIEW IF EXISTS `v_net_a_payer_r`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_net_a_payer_r` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`PostNom` AS `Postnom`,`t_calcule_paie`.`prenom` AS `Prenom`,`t_calcule_paie`.`N_inss` AS `N_inss`,`t_calcule_paie`.`sexe` AS `sexe`,`t_calcule_paie`.`etat_civil` AS `etat_civil`,`t_calcule_paie`.`sit_famille` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'999' AS `codeElPaie`,'NET A PAYER' AS `libelle_el_paie`,sum(`t_calcule_paie`.`montant_payer`) AS `Montant_net_payer`,`t_calcule_paie`.`periode` AS `periode` from `t_calcule_paie` group by `t_calcule_paie`.`Matricule` order by `t_calcule_paie`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_onem`
--

/*!50001 DROP VIEW IF EXISTS `v_onem`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_onem` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'993' AS `codeElPaie`,'ONEM' AS `libelle_el_paie`,(sum(`t_calcule_paie`.`montant_payer`) * 0.005) AS `Montant_ONEM`,`t_calcule_paie`.`periode` AS `periode` from ((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01')) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel10`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel10`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel10` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.5) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '10') and (`v_anciennete`.`anciennete_en_mois` = '0')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel10f`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel10f`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel10f` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.5) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '10') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel10j`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel10j`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel10j` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.5) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '10') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel15`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel15`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel15` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.6) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '15') and (`v_anciennete`.`anciennete_en_mois` = '0')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel15f`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel15f`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel15f` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.6) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '15') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel15j`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel15j`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel15j` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.6) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '15') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel20`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel20`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel20` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.75) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '20') and (`v_anciennete`.`anciennete_en_mois` = '0')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel20f`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel20f`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel20f` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.75) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '20') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel20j`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel20j`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel20j` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.75) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '20') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel25`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel25`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel25` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.85) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '25') and (`v_anciennete`.`anciennete_en_mois` = '0')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel25f`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel25f`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel25f` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.85) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '25') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel25j`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel25j`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel25j` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 0.85) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '25') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel30f`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel30f`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel30f` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 1) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '30') and (`v_anciennete`.`anciennete_en_mois` = '1')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel30j`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel30j`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel30j` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 1) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '30') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel35`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel35`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel35` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 1.25) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '35') and (`v_anciennete`.`anciennete_en_mois` = '0')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel35f`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel35f`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel35f` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 1.25) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '35') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel35j`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel35j`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel35j` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 1.25) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '35') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel40`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel40`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel40` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 1.50) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '40') and (`v_anciennete`.`anciennete_en_mois` = '0')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel40f`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel40f`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel40f` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 1.50) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '40') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_fidel40j`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_fidel40j`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_fidel40j` AS select `v_total_brut`.`Matricule` AS `Matricule`,`v_total_brut`.`Nom` AS `Nom`,`v_total_brut`.`Postnom` AS `Postnom`,`v_total_brut`.`Prenom` AS `Prenom`,`v_total_brut`.`N_inss` AS `N_inss`,`v_total_brut`.`sexe` AS `sexe`,`v_total_brut`.`etat_civil` AS `etat_civil`,`v_total_brut`.`sit_famille` AS `sit_famille`,`v_total_brut`.`grade` AS `grade`,`v_total_brut`.`EquiG` AS `EquiG`,'120' AS `codeElPaie`,'PRIME DE FIDEL' AS `libelle_el_paie`,(`v_total_brut`.`Montant_total_brut` * 1.50) AS `Montant_imposa`,`v_total_brut`.`periode` AS `periode` from (`v_total_brut` join `v_anciennete` on((`v_anciennete`.`matricule` = `v_total_brut`.`Matricule`))) where ((`v_anciennete`.`anciennete_en_annees` = '40') and (`v_anciennete`.`anciennete_en_mois` = '3')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_prime_special`
--

/*!50001 DROP VIEW IF EXISTS `v_prime_special`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_prime_special` AS select `a`.`matricule` AS `Matricule`,`a`.`nom_ag` AS `Nom`,`a`.`postnom_ag` AS `PostNom`,`a`.`prenom_ag` AS `prenom`,`a`.`NumCNSS_ag` AS `N_inss`,`a`.`sexe_ag` AS `sexe`,`a`.`etatCiv_ag` AS `etat_civil`,`a`.`nbreEnfant_ag` AS `sit_famille`,`d`.`grade_ID` AS `grade`,`g`.`Eq_Paie_ID` AS `EquiG`,`p`.`codePaie_ID` AS `codeEiPaie`,`c`.`libelle_codePaie` AS `libelle_el_paie`,`p`.`montant_ps` AS `montant_payer`,NULL AS `periode` from ((((`t_agent` `a` join `t_prime_special` `p` on((`a`.`matricule` = `p`.`agent_ID`))) join `detail_agent_grade` `d` on((`a`.`matricule` = `d`.`agent_ID`))) join `t_grade` `g` on((`d`.`grade_ID` = `g`.`code_grade`))) join `t_codepaie` `c` on((`c`.`codePaie` = `p`.`codePaie_ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_quote_part`
--

/*!50001 DROP VIEW IF EXISTS `v_quote_part`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_quote_part` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'994' AS `codeElPaie`,'QUOT-P.P-CNSS' AS `libelle_el_paie`,(sum(`t_calcule_paie`.`montant_payer`) * 0.13) AS `montant_payer`,`t_calcule_paie`.`periode` AS `periode` from (((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_societe` on((`detail_agent_societe`.`agent_ID` = `t_agent`.`matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01') and (`detail_agent_societe`.`societe_ID` <> '160')) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_reb_fdom`
--

/*!50001 DROP VIEW IF EXISTS `v_reb_fdom`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_reb_fdom` AS select `v_imt_reb_fdom`.`Matricule` AS `Matricule`,`v_imt_reb_fdom`.`Nom` AS `Nom`,`v_imt_reb_fdom`.`PostNom` AS `PostNom`,`v_imt_reb_fdom`.`Prenom_` AS `Prenom_`,`v_imt_reb_fdom`.`N_inss` AS `N_inss`,`v_imt_reb_fdom`.`sexe` AS `sexe`,`v_imt_reb_fdom`.`etat_civil` AS `etat_civil`,`v_imt_reb_fdom`.`sit_famille` AS `sit_famille`,`v_imt_reb_fdom`.`grade` AS `grade`,`v_imt_reb_fdom`.`EquiG` AS `EquiG`,`v_imt_reb_fdom`.`codeElPaie` AS `codeElPaie`,`v_imt_reb_fdom`.`libelle_el_paie` AS `libelle_el_paie`,`v_imt_reb_fdom`.`montant_payer` AS `montant_payer`,`v_imt_reb_fdom`.`periode` AS `periode` from `v_imt_reb_fdom` union all select `v_imt_reb_fdom_int`.`Matricule` AS `Matricule`,`v_imt_reb_fdom_int`.`Nom` AS `Nom`,`v_imt_reb_fdom_int`.`PostNom` AS `PostNom`,`v_imt_reb_fdom_int`.`Prenom_` AS `Prenom_`,`v_imt_reb_fdom_int`.`N_inss` AS `N_inss`,`v_imt_reb_fdom_int`.`sexe` AS `sexe`,`v_imt_reb_fdom_int`.`etat_civil` AS `etat_civil`,`v_imt_reb_fdom_int`.`sit_famille` AS `sit_famille`,`v_imt_reb_fdom_int`.`grade` AS `grade`,`v_imt_reb_fdom_int`.`EquiG` AS `EquiG`,`v_imt_reb_fdom_int`.`codeElPaie` AS `codeElPaie`,`v_imt_reb_fdom_int`.`libelle_el_paie` AS `libelle_el_paie`,`v_imt_reb_fdom_int`.`montant_payer` AS `montant_payer`,`v_imt_reb_fdom_int`.`periode` AS `periode` from `v_imt_reb_fdom_int` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_remb_dom`
--

/*!50001 DROP VIEW IF EXISTS `v_remb_dom`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_remb_dom` AS select distinct `v_bareme`.`Matricule` AS `Matricule`,`v_bareme`.`Nom` AS `Nom`,`v_bareme`.`Postnom` AS `PostNom`,`v_bareme`.`Prenom_` AS `Prenom_`,`v_bareme`.`N_inss` AS `N_inss`,`v_bareme`.`sexe` AS `sexe`,`v_bareme`.`etat_civil` AS `etat_civil`,`v_bareme`.`sit_famille` AS `sit_famille`,`v_bareme`.`grade` AS `grade`,`v_bareme`.`EquiG` AS `EquiG`,`v_frais_dom`.`codeElPaie` AS `codeElPaie`,`v_frais_dom`.`libelle_el_paie` AS `libelle_el_paie`,`v_frais_dom`.`montant_payer` AS `montant_payer`,`v_bareme`.`periode` AS `periode` from (((`v_bareme` join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `v_bareme`.`Matricule`))) join `t_siege` on((`t_siege`.`code_sieg` = `detail_agent_siege`.`siege_ID`))) join `v_frais_dom` on((`v_frais_dom`.`Code_Province_Bareme` = `t_siege`.`province_ID`))) where (`v_bareme`.`grade` between 18 and 20) order by `v_bareme`.`grade`,`t_siege`.`province_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ret_financement`
--

/*!50001 DROP VIEW IF EXISTS `v_ret_financement`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ret_financement` AS select `c`.`Matricule` AS `Matricule`,`c`.`Nom` AS `Nom`,`c`.`PostNom` AS `Postnom`,`c`.`prenom` AS `Prenom`,`c`.`N_inss` AS `N_inss`,`c`.`sexe` AS `sexe`,`c`.`etat_civil` AS `etat_civil`,`c`.`sit_famille` AS `sit_famille`,`c`.`grade` AS `grade`,`c`.`EquiG` AS `EquiG`,'383' AS `codeElPaie`,'FINANCEMENT(1)' AS `libelle_el_paie`,((`p`.`montant_a_retenir` - (`p`.`montant_a_retenir` * (`p`.`taux_Interet` / 100))) * `t`.`montantTaux`) AS `montant_financement`,`c`.`periode` AS `periode` from ((`bdd_paie`.`t_calcule_paie` `c` join (select `bdd_paie`.`t_pret`.`id_pret` AS `id_pret`,`bdd_paie`.`t_pret`.`moisEpuration` AS `moisEpuration`,`bdd_paie`.`t_pret`.`periodePret` AS `periodePret`,`bdd_paie`.`t_pret`.`N_refPret` AS `N_refPret`,`bdd_paie`.`t_pret`.`montantPreter` AS `montantPreter`,`bdd_paie`.`t_pret`.`solde` AS `solde`,`bdd_paie`.`t_pret`.`montant_a_retenir` AS `montant_a_retenir`,`bdd_paie`.`t_pret`.`dateDebut_retenir` AS `dateDebut_retenir`,`bdd_paie`.`t_pret`.`taux_Interet` AS `taux_Interet`,`bdd_paie`.`t_pret`.`codePaie_ID` AS `codePaie_ID`,`bdd_paie`.`t_pret`.`statut_ID` AS `statut_ID`,`bdd_paie`.`t_pret`.`monnaie_ID` AS `monnaie_ID`,`bdd_paie`.`t_pret`.`creerPar` AS `creerPar`,`bdd_paie`.`t_pret`.`modifierPar` AS `modifierPar`,`bdd_paie`.`t_pret`.`dateModifier` AS `dateModifier`,`bdd_paie`.`t_pret`.`agent_ID` AS `agent_ID`,`bdd_paie`.`t_pret`.`siege_ID` AS `siege_ID` from `bdd_paie`.`t_pret` where (`bdd_paie`.`t_pret`.`statut_ID` = 'act') order by `bdd_paie`.`t_pret`.`id_pret` desc) `p` on((`p`.`agent_ID` = `c`.`Matricule`))) join `bdd_paie`.`t_taux` `t` on((`t`.`monnaie_ID` = `p`.`monnaie_ID`))) where ((`t`.`statut_ID` = 'act') and (`p`.`monnaie_ID` = 'USD')) group by `c`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ret_int_financement`
--

/*!50001 DROP VIEW IF EXISTS `v_ret_int_financement`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ret_int_financement` AS select `c`.`Matricule` AS `Matricule`,`c`.`Nom` AS `Nom`,`c`.`PostNom` AS `Postnom`,`c`.`prenom` AS `Prenom`,`c`.`N_inss` AS `N_inss`,`c`.`sexe` AS `sexe`,`c`.`etat_civil` AS `etat_civil`,`c`.`sit_famille` AS `sit_famille`,`c`.`grade` AS `grade`,`c`.`EquiG` AS `EquiG`,'368' AS `codeElPaie`,'INTERET/FINANCEMENT' AS `libelle_el_paie`,((`p`.`montant_a_retenir` * (`p`.`taux_Interet` / 100)) * `t`.`montantTaux`) AS `montant_interet`,`c`.`periode` AS `periode` from ((`bdd_paie`.`t_calcule_paie` `c` join (select `bdd_paie`.`t_pret`.`id_pret` AS `id_pret`,`bdd_paie`.`t_pret`.`moisEpuration` AS `moisEpuration`,`bdd_paie`.`t_pret`.`periodePret` AS `periodePret`,`bdd_paie`.`t_pret`.`N_refPret` AS `N_refPret`,`bdd_paie`.`t_pret`.`montantPreter` AS `montantPreter`,`bdd_paie`.`t_pret`.`solde` AS `solde`,`bdd_paie`.`t_pret`.`montant_a_retenir` AS `montant_a_retenir`,`bdd_paie`.`t_pret`.`dateDebut_retenir` AS `dateDebut_retenir`,`bdd_paie`.`t_pret`.`taux_Interet` AS `taux_Interet`,`bdd_paie`.`t_pret`.`codePaie_ID` AS `codePaie_ID`,`bdd_paie`.`t_pret`.`statut_ID` AS `statut_ID`,`bdd_paie`.`t_pret`.`monnaie_ID` AS `monnaie_ID`,`bdd_paie`.`t_pret`.`creerPar` AS `creerPar`,`bdd_paie`.`t_pret`.`modifierPar` AS `modifierPar`,`bdd_paie`.`t_pret`.`dateModifier` AS `dateModifier`,`bdd_paie`.`t_pret`.`agent_ID` AS `agent_ID`,`bdd_paie`.`t_pret`.`siege_ID` AS `siege_ID` from `bdd_paie`.`t_pret` where (`bdd_paie`.`t_pret`.`statut_ID` = 'act') order by `bdd_paie`.`t_pret`.`id_pret` desc) `p` on((`p`.`agent_ID` = `c`.`Matricule`))) join `bdd_paie`.`t_taux` `t` on((`t`.`monnaie_ID` = `p`.`monnaie_ID`))) where ((`t`.`statut_ID` = 'act') and (`p`.`monnaie_ID` = 'USD')) group by `c`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ret_pens`
--

/*!50001 DROP VIEW IF EXISTS `v_ret_pens`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_ret_pens` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'408' AS `codeElPaie`,'RETENUE PENSION' AS `libelle_el_paie`,(sum(`t_calcule_paie`.`montant_payer`) * 0.05) AS `montant_payer`,`t_calcule_paie`.`periode` AS `periode` from (((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_societe` on((`detail_agent_societe`.`agent_ID` = `t_agent`.`matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01')) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_retsydic`
--

/*!50001 DROP VIEW IF EXISTS `v_retsydic`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_retsydic` AS select `a`.`matricule` AS `Matricule`,`a`.`nom_ag` AS `Nom`,`a`.`postnom_ag` AS `Postnom`,`a`.`prenom_ag` AS `Prenom`,`a`.`NumCNSS_ag` AS `N_inss`,`a`.`sexe_ag` AS `sexe`,`a`.`etatCiv_ag` AS `etat_civil`,`a`.`nbreEnfant_ag` AS `sit_famille`,`p`.`grade` AS `grade`,`p`.`EquiG` AS `EquiG`,'412' AS `codeElPaie`,'RETENUE SYNDICALE' AS `libelle_el_paie`,(sum(`p`.`montant_payer`) * 0.02) AS `Montant_retsyndyc`,`p`.`periode` AS `periode`,`p`.`codesiege` AS `codesiege` from ((((`t_paie` `p` join `t_agent` `a` on((`a`.`matricule` = `p`.`Matricule`))) join `t_codepaie` `c` on((`c`.`codePaie` = `p`.`codeEiPaie`))) join `detail_agent_siege` `ds` on(((`ds`.`agent_ID` = `a`.`matricule`) and (`ds`.`statut_ID` = 'act')))) join `detail_agent_syndicat` `sy` on(((`sy`.`agent_ID` = `a`.`matricule`) and (`sy`.`statut_ID` = 'act')))) where ((`c`.`imposable` = 'I') and (`a`.`activiter_ID` = '01')) group by `a`.`matricule`,`p`.`periode` order by `a`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_retsydic_all`
--

/*!50001 DROP VIEW IF EXISTS `v_retsydic_all`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_retsydic_all` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'412' AS `codeElPaie`,'RETENUE SYNDICALE' AS `libelle_el_paie`,(sum(`t_calcule_paie`.`montant_payer`) * 0.02) AS `Montant_retsyndyc`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `t_agent`.`matricule`))) join `detail_agent_syndicat` on((`detail_agent_syndicat`.`agent_ID` = `t_agent`.`matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01')) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_retsydic_autre`
--

/*!50001 DROP VIEW IF EXISTS `v_retsydic_autre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_retsydic_autre` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'412' AS `codeElPaie`,'RETENUE SYNDICALE' AS `libelle_el_paie`,(sum(`t_calcule_paie`.`montant_payer`) * 0.02) AS `Montant_retsyndyc`,`t_calcule_paie`.`periode` AS `periode` from ((((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `t_agent`.`matricule`))) join `detail_agent_syndicat` on((`detail_agent_syndicat`.`agent_ID` = `t_agent`.`matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01') and (`detail_agent_siege`.`siege_ID` > 199) and (`detail_agent_syndicat`.`syndicat_ID` <> 'No')) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_retsydic_kin`
--

/*!50001 DROP VIEW IF EXISTS `v_retsydic_kin`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_retsydic_kin` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_paie`.`grade` AS `grade`,`t_paie`.`EquiG` AS `EquiG`,'412' AS `codeElPaie`,'RETENUE SYNDICALE' AS `libelle_el_paie`,(sum(`t_paie`.`montant_payer`) * 0.02) AS `Montant_retsyndyc`,`t_paie`.`periode` AS `periode` from (((`t_paie` join `t_agent` on((`t_agent`.`matricule` = `t_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_paie`.`codeEiPaie`))) join `detail_agent_siege` on((`detail_agent_siege`.`agent_ID` = `t_agent`.`matricule`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01') and (`detail_agent_siege`.`siege_ID` < 200)) group by `t_agent`.`matricule`,`t_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_synd_transt`
--

/*!50001 DROP VIEW IF EXISTS `v_synd_transt`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_synd_transt` AS select distinct `t_bareme`.`codepaie` AS `codeElPaie`,`t_bareme`.`LibelleBar` AS `libelle_el_paie`,`detail_grade_bareme`.`Montant_bar` AS `montant_payer`,NULL AS `periode` from (((((`t_agent` join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_bareme`.`codepaie`))) where ((`detail_grade_bareme`.`code_grade` = '16') and (`t_bareme`.`codepaie` = '231')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_total_brut`
--

/*!50001 DROP VIEW IF EXISTS `v_total_brut`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_total_brut` AS select `t_calcule_paie`.`Matricule` AS `Matricule`,`t_calcule_paie`.`Nom` AS `Nom`,`t_calcule_paie`.`PostNom` AS `Postnom`,`t_calcule_paie`.`prenom` AS `Prenom`,`t_calcule_paie`.`N_inss` AS `N_inss`,`t_calcule_paie`.`sexe` AS `sexe`,`t_calcule_paie`.`etat_civil` AS `etat_civil`,`t_calcule_paie`.`sit_famille` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'997' AS `codeElPaie`,'TOTAL BRUT' AS `libelle_el_paie`,sum(`t_calcule_paie`.`montant_payer`) AS `Montant_total_brut`,`t_calcule_paie`.`periode` AS `periode` from `t_calcule_paie` group by `t_calcule_paie`.`Matricule`,`t_calcule_paie`.`periode` order by `t_calcule_paie`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_total_brut_imp`
--

/*!50001 DROP VIEW IF EXISTS `v_total_brut_imp`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_total_brut_imp` AS select `t_agent`.`matricule` AS `Matricule`,`t_agent`.`nom_ag` AS `Nom`,`t_agent`.`postnom_ag` AS `Postnom`,`t_agent`.`prenom_ag` AS `Prenom`,`t_agent`.`NumCNSS_ag` AS `N_inss`,`t_agent`.`sexe_ag` AS `sexe`,`t_agent`.`etatCiv_ag` AS `etat_civil`,`t_agent`.`nbreEnfant_ag` AS `sit_famille`,`t_calcule_paie`.`grade` AS `grade`,`t_calcule_paie`.`EquiG` AS `EquiG`,'995' AS `codeElPaie`,'TOTAL BRUT IMP' AS `libelle_el_paie`,sum(`t_calcule_paie`.`montant_payer`) AS `Montant_imposa`,`t_calcule_paie`.`periode` AS `periode` from ((`t_calcule_paie` join `t_agent` on((`t_agent`.`matricule` = `t_calcule_paie`.`Matricule`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_calcule_paie`.`codeEiPaie`))) where ((`t_codepaie`.`imposable` = 'I') and (`t_agent`.`activiter_ID` = '01')) group by `t_agent`.`matricule`,`t_calcule_paie`.`periode` order by `t_agent`.`matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_total_retenue`
--

/*!50001 DROP VIEW IF EXISTS `v_total_retenue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_total_retenue` AS select `t_retenue`.`Matricule` AS `Matricule`,`t_retenue`.`Nom` AS `Nom`,`t_retenue`.`PostNom` AS `Postnom`,`t_retenue`.`prenom` AS `Prenom`,`t_retenue`.`N_inss` AS `N_inss`,`t_retenue`.`sexe` AS `sexe`,`t_retenue`.`etat_civil` AS `etat_civil`,`t_retenue`.`sit_famille` AS `sit_famille`,`t_retenue`.`grade` AS `grade`,`t_retenue`.`EquiG` AS `EquiG`,'998' AS `codeElPaie`,'TOTAL RETENUE' AS `libelle_el_paie`,sum(`t_retenue`.`montant_payer`) AS `Montant_total_retenue`,`t_retenue`.`periode` AS `periode` from `t_retenue` group by `t_retenue`.`Matricule`,`t_retenue`.`periode` order by `t_retenue`.`Matricule` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_transp_synd`
--

/*!50001 DROP VIEW IF EXISTS `v_transp_synd`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_transp_synd` AS select distinct `t_bareme`.`codepaie` AS `codeElPaie`,`t_bareme`.`LibelleBar` AS `libelle_el_paie`,cast(`detail_grade_bareme`.`Montant_bar` as decimal(18,2)) AS `montant_payer`,NULL AS `periode` from (((((`t_agent` join `detail_agent_grade` on((`detail_agent_grade`.`agent_ID` = `t_agent`.`matricule`))) join `t_grade` on((`t_grade`.`code_grade` = `detail_agent_grade`.`grade_ID`))) join `detail_grade_bareme` on((`detail_grade_bareme`.`code_grade` = `t_grade`.`code_grade`))) join `t_bareme` on((`t_bareme`.`id_bar` = `detail_grade_bareme`.`id_bar`))) join `t_codepaie` on((`t_codepaie`.`codePaie` = `t_bareme`.`codepaie`))) where ((`detail_grade_bareme`.`code_grade` = '16') and (`t_bareme`.`codepaie` = '231')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pointage`
--

/*!50001 DROP VIEW IF EXISTS `v_pointage`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_pointage` AS select `c`.`Matricule` AS `Matricule`,`c`.`Nom` AS `Nom`,`c`.`PostNom` AS `PostNom`,`c`.`prenom` AS `prenom`,`c`.`N_inss` AS `N_inss`,`c`.`sexe` AS `sexe`,`c`.`etat_civil` AS `etat_civil`,`c`.`sit_famille` AS `sit_famille`,`c`.`grade` AS `grade`,`c`.`EquiG` AS `EquiG`,`c`.`codeEiPaie` AS `codeEiPaie`,`c`.`libelle_el_paie` AS `libelle_el_paie`,((`c`.`montant_payer` / 26) * `p`.`nbrejrs`) AS `montant_payer`,`c`.`periode` AS `periode` from (`bdd_paie`.`t_calcule_paie` `c` join `bdd_paie`.`t_pointage` `p` on(((convert(`p`.`matric` using utf8mb4) collate utf8mb4_unicode_ci) = `c`.`Matricule`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-29 10:19:34
