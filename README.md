# API-PROJECT

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/2dc074a9d3154e6a935e2365711a1b61)](https://www.codacy.com/gh/JEND-CODES/API-PROJECT/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=JEND-CODES/API-PROJECT&amp;utm_campaign=Badge_Grade)

[![SymfonyInsight](https://insight.symfony.com/projects/e987388d-6340-4e8c-aea9-b082f74aa4e9/big.svg)](https://insight.symfony.com/projects/e987388d-6340-4e8c-aea9-b082f74aa4e9)

## DÉMO => http://mobile.planetcode.fr

## HOMEPAGE

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/public/images/CapchaApiProject.png)

## DIAGRAMMES UML

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/diagrammes/Cas_Gestion_Api_P7_V2.png)

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/diagrammes/S%C3%A9quence_Authentification_P7_V4.png)

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/diagrammes/Diagramme_de_Classes_P7_V3.png)

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/diagrammes/Mod%C3%A8le_de_donn%C3%A9es_P7_V3.png)

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/diagrammes/Concepteur_BDD_Bilemo_v3.png)

## INSTRUCTIONS D'INSTALLATION
``` bash
* CLONEZ LE PROJET : git clone https://github.com/JEND-CODES/API-PROJECT

* INSTALLEZ LES DÉPENDANCES AVEC COMPOSER : composer install

* CRÉEZ LA BASE DE DONNÉES (FICHIER .ENV) : doctrine:database:create

* GÉNÉREZ LES FIXTURES : doctrine:fixtures:load

* LANCEZ VOTRE SERVEUR ET CONNECTEZ-VOUS À L APPLICATION

* GÉNÉREZ LE TOKEN JWT SUR LE ENDPOINT : POST /API/LOGIN

* UTILISEZ CE JETON POUR CHAQUE REQUÊTE VERS L API : BEARER <JWT_TOKEN>

* EN PRODUCTION VEILLEZ À CONFIGURER LE HTACCESS : RewriteCond %{HTTP:Authorization} ^(.*)
```

## CAPTURES

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/public/captures/capture_api_0.JPG)

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/public/captures/capture_api_1.JPG)

![API-PROJECT](https://raw.githubusercontent.com/JEND-CODES/API-PROJECT/main/public/captures/capture_api_2.JPG)
