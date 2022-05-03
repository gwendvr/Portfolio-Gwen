# Création des tables
(wireframe)
1. Création d'une table **CompetenceProjet** sur le portfolio : `php bin/console make:Entity`.
2. Ensuite j'ajoute la relation **ManyToOne** à cette même table.
3. Je fais fais une migration en base de données pour ajouter ces nouvelles entities.

# Création des compétences
1. J'ajoute dans le **AdminController** les liens vers la page création, des compétences.
2. Ensuite je créer un formulaire pour les compétences avec la commande `php bin/console make:Form`.
3. Dans le formulaire créer j'ajoute un boutton enregistrer avec une class : `SubmitType::class`, afin de pouvoir enregistrer la compétence en base de donées.
4. Je complète mon controller en ajoutantle formulaire, et en ajoutant les redirections.
5. J'ajoute le template twig qui va gérer la partie front.
6. J'ajoute un bouton dans l'index du dossier **Admin** afin de pouvoir accéder au formulaire.
7. Enfin je créer les compétences.

# Ajout des compétences dans les projets
1. J'ajoute dans le formulaire des projet les compétences à choisir.
2. Je met en forme dans le Twig.

# Ajout VichUploader
1. Pour importer Vich je fais la commande : `php composer.phar require vich/uploader-bundle`, je met *yes* à la question `Do you want to execute this recipe?`.
2. Ensuite dans le fichier **vich_uploader.yaml** je fais le mapping pour récupérer les fichiés upload dans un dossier.
3. Je met le lien `uri_prefix: /images/projets` qui va être relié à mon dossier public.
4. Ensuite dans mon entity **Project** j'ajoute avant la class project `@Vich\Uploadable`.
