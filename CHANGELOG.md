# Changelog

## v1.1.0

Breaking changes:
    **None**
    
New features:
* `postCreateTask` updated:
    * Optional request parameters `workflow`, `workflowid` and `workflowname` added.
        
Bug fixes:
    **None**

## v1.0.0

Breaking changes:
    **None**
    
New features:
* Partial implementation of the version 1 and 2 of Kanbanize API
    * For version 1 API, you can:
        * Get projects and boards
        * Get board structure
        * Get full board structure
        * Get board settings
        * Get board activities
        * Create a new task
        * Get details for one task 
        * Get details for many task
        * Get all tasks for one board
        * Get log time activities
    * For version 2 API, you can:
        * Get a list of child cards
        * Make a card a child of a given card 
        * Get a list of parent cards
        * Make a card a parent of a given card 
        * Get a list of predecessor cards
        * Make a card a predecessor of a given card 
        * Get a list of successor cards
        * Make a card a successor of a given card 
        
Bug fixes:
    **None**