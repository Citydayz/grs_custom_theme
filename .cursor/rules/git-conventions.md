# git-conventions.md — Conventions Git
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier définit les conventions de versionning Git du projet.
> Cursor doit les appliquer pour tous les commits, branches et tags.
> Référence : Conventional Commits (https://www.conventionalcommits.org)

---

## 1. Branches

```
main        → production — jamais de push direct
staging     → recette — déployé sur le serveur staging
develop     → branche de travail principale
feature/*   → nouvelle fonctionnalité
fix/*       → correction de bug
chore/*     → maintenance, mise à jour deps, refacto sans impact fonctionnel
docs/*      → documentation uniquement
```

### Nommage des branches

```
feature/tunnel-diagnostic
feature/page-methode-spa-profit
feature/integration-airtable
fix/nav-mobile-focus
fix/tunnel-scoring-calcul
chore/update-acf-fields
docs/update-roadmap
```

**Règles :**
- Tout en minuscules
- Tirets `-` uniquement
- Nom court et descriptif (3-5 mots max)
- Toujours partir de `develop`, jamais de `main`

---

## 2. Messages de commit

### Format Conventional Commits

```
<type>(<scope>): <description courte>

[corps optionnel — si le commit nécessite une explication]

[footer optionnel — ex: références, breaking changes]
```

### Types autorisés

| Type | Usage |
|---|---|
| `feat` | Nouvelle fonctionnalité |
| `fix` | Correction de bug |
| `style` | CSS, mise en forme (sans impact fonctionnel) |
| `refactor` | Refactorisation sans ajout de fonctionnalité ni fix |
| `perf` | Amélioration de performance |
| `test` | Ajout ou modification de tests |
| `docs` | Documentation uniquement |
| `chore` | Maintenance, config, dépendances |
| `security` | Correction de faille de sécurité |

### Scopes du projet

```
theme       → fichiers PHP du thème
design      → CSS / HTML composants
content     → intégration de contenu
tunnel      → tunnel diagnostic
integrations→ Airtable, Make, Calendly
seo         → balises, Schema, sitemap
nav         → navigation et header
forms       → formulaires
agents      → fichiers agents Cursor
rules       → fichiers rules Cursor
config      → wp-config, .htaccess, robots.txt
```

### Exemples de commits valides

```bash
feat(tunnel): add 10-question scoring logic with A/B/C levels
feat(integrations): add cbs_send_to_airtable() with error handling
fix(nav): fix focus not returning to toggle on menu close
fix(tunnel): fix score exceeding 30 on rapid click
style(design): update hero CTA button hover state to gold border
refactor(theme): extract diagnostic payload builder to helpers.php
perf(design): add lazy loading to all non-hero images
security(forms): add honeypot field to contact form
docs(rules): add forms.md and navigation.md
chore(agents): update agent-qa checklist with forms rules
```

### Exemples invalides

```bash
# ❌ Trop vague
fix: bug
update stuff
wip

# ❌ Mauvais format
Fixed the navigation bug on mobile
feat : nouveau formulaire  (espace avant les deux-points)

# ❌ Scope manquant sur les changements ciblés
feat: add airtable integration
```

---

## 3. Taille des commits

```
Règle : un commit = une intention
Trop petit : ne pas committer chaque ligne
Trop grand : ne pas committer "tout le site en une fois"
```

**Bon découpage :**
```bash
feat(theme): add front-page.php template structure
feat(design): add hero section CSS with video background
feat(content): integrate home page copy from content-structure.md
feat(seo): add homepage meta tags and Organization schema
```

**Mauvais :**
```bash
feat: add homepage with design content and seo  # trop groupé
```

---

## 4. Flux de travail

```bash
# 1. Créer la branche depuis develop
git checkout develop
git pull origin develop
git checkout -b feature/[nom]

# 2. Travailler, committer régulièrement
git add [fichiers concernés]
git commit -m "feat(scope): description"

# 3. Pousser et créer une PR vers develop
git push origin feature/[nom]

# 4. Merge develop → staging (recette)
git checkout staging
git merge develop
git push origin staging

# 5. Après validation, merge staging → main
git checkout main
git merge staging
git tag v[X.Y.Z]
git push origin main --tags
```

---

## 5. Tags de version

Format : `vMAJOR.MINOR.PATCH`

```bash
v1.0.0   → Mise en ligne initiale
v1.1.0   → Nouvelle fonctionnalité (ex: boutique pros)
v1.0.1   → Correction de bug en production
v2.0.0   → Refonte majeure
```

Chaque tag sur `main` doit correspondre à une entrée dans `CHANGELOG.md`.

```bash
# Créer un tag annoté (avec message)
git tag -a v1.0.0 -m "Mise en ligne initiale — site vitrine complet"
git push origin v1.0.0
```

---

## 6. Ce que Cursor doit faire

En mode agent autonome, Cursor doit :

```
✅ Créer une branche feature/* avant de commencer toute tâche
✅ Committer après chaque composant complété (pas après chaque ligne)
✅ Utiliser le format Conventional Commits sur tous les commits
✅ Mettre à jour CHANGELOG.md avant de proposer un merge sur main
✅ Taguer sur main après chaque déploiement validé
```

```
❌ Ne jamais pusher directement sur main
❌ Ne jamais committer wp-config.php
❌ Ne jamais committer les fichiers dans /wp-content/uploads/
❌ Ne jamais committer node_modules/ ou vendor/
```

---

*Référence : environments.md §6 (branches), CHANGELOG.md (versioning)*
