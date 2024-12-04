1. Cloner le repo : git clone https://votre-repository-git-url.git
   cd nom-du-dossier-du-proje

2. Demarrer le serveur : symfony server:start

3. Créer une tâche : curl -X POST http://localhost:8000/tasks \-H "Content-Type: application/json" \-d '{"title": "Test", "description": "alternance", "status": "en_Cours"}'

4. Modifier une tâche : curl -X PUT http://localhost:8000/tasks/1 \-H "Content-Type: application/json" \-d '{"title": "Test2", "status": "en_Cours"}'

5. Supprimer une tâche : curl -X DELETE http://localhost:8000/tasks/1

J'ai fait le question 1 à 3 et je me suis retrouvée bloqué lors de l'execution des commandes disant que le controlleur est en privée 

J'ai essayer d'aller au plus simple et à l'essentiel car je decouvre le Symfony et une autre maniere d'utiliser le PHP.
