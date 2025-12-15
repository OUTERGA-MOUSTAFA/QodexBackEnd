# Qodex_Backend
# PHP
# Besoin visé ou problème rencontré
- Installation environnement back-end
- Conception base de données
- Generation base de données avec SQL
- Développement back-end avec PHP
  

## Lien To jira https://outergamoustafa-1764845699446.atlassian.net/jira/software/projects/KAN/boards/1


# Contexte Général
Objectif principal : créer une mini plateforme de quiz sécurisée où un enseignant peut créer des quiz organisés par catégories et où les étudiants peuvent y répondre.

# Améliorations apportées
CRUD complet pour toutes les entités
Sécurité renforcée (sessions, CSRF, XSS, SQL injection)
Validation et sanitization des données
Hashage sécurisé des mots de passe
Gestion des erreurs et logs

## Critères de sécurité :
Authentification
Session active et rôle enseignant/etudiant
Sanitization des champs
Token CSRF
Requêtes préparées
Vérification rôle enseignant
Validation que la catégorie existe
Minimum une question obligatoire

# Critères de performance
Optimisation Backend

## Utilisation obligatoire d’index sur les colonnes fréquentes : email, categorie_id, quiz_id, etudiant_id.

## Aucune requête SQL répétée inutilement (pas de doublons).

## Pagination systématique pour les listes longues : quiz, questions, résultats, utilisateurs.

## Temps de réponse ciblé : moins de 200 ms pour chaque requête logique.

## Requêtes préparées pour réduire le coût d’analyse SQL.

## Optimisation Frontend

## Chargement dynamique ou asynchrone des données (fetch/AJAX) quand nécessaire.

## Minification des fichiers CSS et JS pour réduire le poids.

## Limitation des manipulations complexes du DOM.

## Mise en cache des ressources statiques (images, css, js).

## Optimisation des Sessions

## Nettoyage automatique des sessions expirées.

## Regénération de l’ID après connexion pour limiter la surcharge serveur.

## Écriture minimale dans le stockage de session.

## Base de Données

## Respect de la normalisation (3NF) pour limiter la redondance.

## Indexation des clés étrangères pour accélérer les jointures.

## Réduction des full-scan grâce à des requêtes optimisées.

## Utilisation du soft-delete pour éviter l’accumulation de données supprimées dans les tables principales.

## Mots de passe hashés avec password_hash() (Argon2id ou Bcrypt).

## Regénération de l’ID session après connexion.

## Déconnexion : destruction complète des données de session.

## Vérification de l’unicité email à l’inscription.

## Protection CSRF

## Ajout d’un token CSRF unique pour chaque formulaire sensible.

## Vérification du token avant traitement des formulaires POST/PUT/DELETE.

## Expiration des tokens après un certain temps ou une utilisation.

## Protection XSS

## Échappement HTML pour toutes les sorties à l’écran (htmlspecialchars).

## Suppression de tout contenu scripté ou tags HTML dangereux.

## Vérification stricte des types de fichiers en upload.

## Protection SQL Injection

## Requêtes exclusivement préparées (aucune concaténation de chaînes).

## Validation stricte des types (int, email, etc.).

## Nettoyage des entrées avant insertion.

## Permissions et Contrôle d’Accès

## Vérification du rôle (enseignant/étudiant) avant chaque action.

## Un enseignant ne peut modifier que ses catégories, quiz et questions.

## Un étudiant ne peut consulter que ses propres résultats.

## Blocage de toute page sensible en accès direct sans authentification.

## Sécurité Backend / API

## Désactivation des erreurs en production (affichage off).

## Système de logs pour détecter les tentatives suspectes.

## Protection contre le brute-force (limitation des tentatives).

## En-têtes HTTP de sécurité recommandés :

## X-Frame-Options

## X-Content-Type-Options

## Content-Security-Policy (CSP)

## Sécurité des Données

## Aucune fuite d’informations sensibles.

## Vérification systématique de la taille et du format des champs.

## Soft-delete au lieu de suppression définitive.

## Vérification de l’origine des formulaires (Referrer) pour les POST importants.
