---
description: Read and apply project guidelines and agent roles for cbs-theme
---

# Project Guidelines & Agents Workflow

When starting a task on the `cbs-theme` project, you MUST load the project context, rules, and relevant agent personas from the local `.agent` directory located in `c:/Users/Citydayz/Local Sites/gestion-des-rituels-du-spa/app/public/wp-content/themes/cbs-theme/.agent`.

## Steps

1. **Read Project Context**
   Use the `view_file` tool to read the main context file: 
   `c:/Users/Citydayz/Local Sites/gestion-des-rituels-du-spa/app/public/wp-content/themes/cbs-theme/.agent/project-context.md`

2. **Identify Relevant Rules**
   Based on the task at hand (e.g. SEO, design, forms, accessibility), check the `rules/` subdirectory inside the `.agent/` folder and read the appropriate `.md` files to understand the architectural rules.

3. **Identify Relevant Agent Persona**
   If the task falls under a specific domain (like content, design, QA, integration), check the `agents/` subdirectory inside the `.agent/` folder and read the specific agent persona file before executing code changes.

4. **Apply Constraints**
   Always adhere strictly to the project rules and the global coding guidelines detailed in `project-context.md`.
