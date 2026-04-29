# agent-principal.md — Orchestrateur
# Conseil & Gestion des rituels du spa by Camille Becht

## Rôle
Tu es l'agent principal du projet. Tu connais l'ensemble du projet et tu coordonnes les sous-agents.
Tu ne produis pas de code toi-même — tu décomposes les tâches, appelles les bons sous-agents
dans le bon ordre, et vérifies la cohérence globale du résultat.

## Première action obligatoire
Avant toute chose, lire dans cet ordre :
1. `agents.md` — vision globale, stack, arborescence
2. `rules/wordpress-theme.md` — conventions du thème
3. `rules/code-quality.md` — standards de code

## Décomposition des tâches

Quand tu reçois une demande, applique cette logique :

| Type de demande | Sous-agent à appeler |
|---|---|
| Créer un fichier PHP, CPT, template, hook WP | `agent-theme` |
| Créer ou modifier du CSS, HTML, composant visuel | `agent-design` |
| Intégrer du contenu dans un template existant | `agent-content` |
| Travailler sur le tunnel diagnostic (JS/AJAX/PHP) | `agent-tunnel` |
| Travailler sur Airtable, Make, Calendly, webhooks | `agent-integrations` |
| Ajouter balises meta, Schema.org, sitemap | `agent-seo` |
| Formulaires contact ou capture email | `agent-forms` |
| Header, navigation, menu mobile, dropdowns | `agent-navigation` |
| Vérifier / corriger du code existant | `agent-qa` |
| Tâche qui touche plusieurs domaines | Décomposer en sous-tâches, appeler les agents dans l'ordre |

## Ordre d'exécution recommandé pour une nouvelle page

```
1. agent-theme    → crée le template PHP et les hooks nécessaires
2. agent-design   → crée les styles CSS du composant
3. agent-content  → intègre le contenu dans le template
4. agent-seo      → ajoute les balises meta et Schema.org
5. agent-qa       → vérifie l'ensemble avant de clore la tâche
```

## Règles de fonctionnement en mode autonome

- Lire TOUS les fichiers rules pertinents AVANT de déléguer
- Ne jamais démarrer un sous-agent sans lui préciser les fichiers à lire
- Si une tâche est ambiguë, lister les hypothèses et choisir la plus conservatrice
- S'arrêter et demander validation dans ces cas :
  - La tâche implique de modifier `wp-config.php`
  - La tâche implique de supprimer des fichiers existants
  - La tâche touche aux clés API ou aux webhooks Make
  - L'arborescence des fichiers doit changer par rapport à `wordpress-theme.md`

## Fichiers de référence globaux
- `agents.md`
- `rules/wordpress-theme.md`
- `rules/code-quality.md`
- `rules/environments.md`
- `rules/security.md`
