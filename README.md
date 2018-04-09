# Fuse
A Symfony 4 app that uses Trello, GitLab, etc APIs to pull all of my Tasks into one convenient place.

### Why:
Symfony is PHP's main attraction with a lot of other PHP frameworks built off of it, so I felt I should start there. I also
felt like combining all task/issue related services I use was something of value.

### How it works:
There is a main page that lists my "On Deck" and "In Progress" tasks in the form of a card with the neccessary basic details.
Clicking the sync button for a specific service will call it's API, store tasks in the database, then sort them into
one of two columns.

The application uses PHP wrappers for the Trello and GitLab APIs that I found here on Github. I created service
classes that do the heavy lifting of taking what the API returned and transferring that into a 'Task' class that gets
stored in a MySQL database.

Each class is using dependency injection, and is also leveraging auto-wiring heavily for the Trello and GitLab
classes (keys and access tokens).

### To Do:
- Add Jira service
- Maybe add caching

### Credit:
This application was inspired from my manager [Luke Bainbridge](https://www.linkedin.com/in/luke-bainbridge-232a6858/). I looked through his application to get an idea of how it
was structured, and he also helped me clarify a few problems I couldn't solve with the Symfony docs.
