# Base de donnees

Ce dossier contient l'export SQL de la structure de la base `bdd_paie`.

Le fichier `bdd_paie.sql` contient :
- la creation de la base ;
- les tables ;
- les vues ;
- les routines et triggers disponibles.

Il ne contient pas les donnees de production afin d'eviter de publier des informations RH/paie dans le depot GitHub public.

Pour importer la structure en local :

```bash
mysql -u root -p < database/bdd_paie.sql
```
