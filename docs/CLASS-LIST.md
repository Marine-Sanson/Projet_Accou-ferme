Class-list

Models : les classes qui représentent vos données

User
Admin extends User
Page
Product
Variety extends Product
News
Recipe extends News

Managers : les classes qui interagissent avec la base de données

RoutingManager
UserManager
PageManager
ProductManager
VarietyManager
NewsManager

Controllers : les classes qui gèrent la logique de votre site (affichage des templates, traitement de formulaires)

RoutingController
HomeController
UserController
PageController
ProductController
VarietyController
NewsController
AutenticationController
