1. Cloner le repo : git clone https://votre-repository-git-url.git
   cd nom-du-dossier-du-proje

2. Demarrer le serveur : symfony server:start

3. Créer une tâche : curl -X POST http://localhost:8000/tasks \-H "Content-Type: application/json" \-d '{"title": "Test", "description": "alternance", "status": "en_Cours"}'

4. Modifier une tâche : curl -X PUT http://localhost:8000/tasks/1 \-H "Content-Type: application/json" \-d '{"title": "Test2", "status": "en_Cours"}'

5. Supprimer une tâche : curl -X DELETE http://localhost:8000/tasks/1
