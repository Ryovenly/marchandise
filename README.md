# marchandise

- Créer une application avec des produits et des catégories, relation ManyToMany entre produits et catégories
- Un produit a : nom, description, prix, 0 à N catégories
- Une catégorie a : nom, 0 à N produits


Créer sa base de donnée:

Commande à réaliser:
composer require orm orm-fixtures api-platform fzaninotto/faker
composer require symfony/maker-bundle --dev 
<----> 
Envoyer les données en base:

php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

Définir un endpoint pour les produits qui permet d'avoir un filtre sur le prix du produit (inférieur à, supérieur à, dans une fourchette de prix, etc...)

http://localhost:8000/api/produits?prix[gte]=200&page=1
http://localhost:8000/api/produits?prix[lte]=200&page=1
http://localhost:8000/api/produits?prix[gt]=14&prix[lt]=200&page=1

Le endpoint des catégories permettra de chercher une catégorie par nom
http://localhost:8000/api/categories?nom=aut



Une catégorie sérialisée inclura les informations de chaque produit (id, nom, description, prix)
Un produit sérialisé inclura les informations de la ou les catégories associées (id, nom)

Y avait une erreur disant que y avait trop de paramètres à serialiser et qu'il fallait augmenter la capacité en mettant ces paramètres sur:
@ApiResource(attributes={"force_eager"=false,"normalization_context": {"groups"={"user_read"}, "enable_max_depth"=true}})