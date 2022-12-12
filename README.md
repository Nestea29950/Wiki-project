<p align="center">
  <img src="https://static.wikia.nocookie.net/minecraft_gamepedia/images/a/a7/Wiki_header2_rev6.png/revision/latest?cb=20211013130132" style="width:225px; height:100px;" />
</p>
 <h3 align="center">Projet wiki</h3>


</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Sommaire</summary>
  <ol>
	  <li><a href="#Technologie">Technologies Utilisées</a></li>
    <li><a href="#Installation">Installation</a></li>
    <li><a href="#Prérequis">Les Prérequis</a></li>
    <li><a href="#Utilisation">Utilisation</a></li>
  </ol>
</details>


# Technologie

Lors de la réalisation de ce projet, nous avons utilisés différentes technologies :
* [Symfony](https://symfony.com/)

<p align="right">(<a href="#top">Retour en haut</a>)</p>

<!-- Installation -->
# Installation

Afin de pouvoir visualiser et utiliser notre projet, il est néccessaire de procéder à quelques actions :


<p>Entrez les commandes suivantes :</p>

<ul> 
<li>composer require symfony/runtime</li>
<li>symfony console doctrine:database:create</li>
<li>symfony console make:migration</li>
<li>php bin/console doctrine:migrations:migrate</li>
</ul>



# Prérequis


* Télécharger Composer [getcomposer.com](https://getcomposer.org/download/)

Vous aurez aussi besoin du script de la création de la base de données accéssible dans le projet en format .sql

<p align="right">(<a href="#top">Retour en haut</a>)</p>

<!-- Utilisation -->

# Utilisation

Le projet est constitué de différentes pages :

* une page d'accueil
* une page d'ajout d'article
* une page de consultation d'article
* une page de consultation des categories
* une page d'ajout de catégories
* une page de modification des articles
* une page de modification des categories


<p align="right">(<a href="#top">Retour en haut</a>)</p>

