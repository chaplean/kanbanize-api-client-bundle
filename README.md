# ⚠ Bundle in progress ⚠

# ChapleanKanbanizeApiClientBundle

> CI Badges. [![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/chaplean/[projectname]/issues)



## Table of content

* [Installation](#Installation)
* [Configuration](#Configuration)
* [Usage](#Usage)
* [Versioning](#Versioning)
* [Contributing](#Contributing)
* [Hacking](#Hacking)
* [License](#License)

## Installation

> Instructions to install the project. For bundles it might be something along the lines of:

You can use [composer](https://getcomposer.org) to install [projectname]:
```bash
composer require chaplean/kanbanize-api-client-bundle
```

## Configuration

#### Import config

```yaml
imports:
    - { resource: '@ChapleanKanbanizeApiClientBundle/Resources/config/config.yml' }
```

#### Define parameters

In your `parameters.yml`

```yaml
chaplean_kanbanize_api_v1.url: 'kanbanize url api'
chaplean_kanbanize_api_v1.apikey: 'your apikey'
```

## Usage

You can use 2 versions of the API.

Version 1: `KanbanizeApiV1` (see: https://kanbanize.com/api)

Available routes:

| Method | Description |
| :--- | :--- |
| getProjectsAndBoards()   | Get projects and boards     |
| postBoardStructure()     | Get board structure         |
| postFullBoardStructure() | Get full board structure    |
| postBoardSettings()      | Get board settings          |
| postBoardActivities()    | Get board activities        |
| postCreateTask()         | Create a new task           |
| postTaskDetails()        | Get details for one task    |
| postTasksDetails()       | Get details for many task   |
| postAllTasks()           | Get all tasks for one board |
| postLogTimeActivities()  | Create a new task           |

Version 2 (beta): `KanbanizeApi` (see: https://\<your team>.kanbanize.com/openapi/#/)

Available functions:

| Method | Description |
| :--- | :--- |
| getChildCards()        | Get a list of child cards                 |
| putChildCard()         | Make a card a child of a given card       |
| getParentCards()       | Get a list of parent cards                |
| putParentCard()        | Make a card a parent of a given card      |
| getPredecessorCards()  | Get a list of predecessor cards           |
| putPredecessorCard()   | Make a card a predecessor of a given card |
| getSuccessorCards()    | Get a list of successor cards             |
| putSuccessorCard()     | Make a card a successor of a given card   |


## Versioning

kanbanize-api-client-bundle follows [semantic versioning](https://semver.org/). In short the scheme is MAJOR.MINOR.PATCH where
1. MAJOR is bumped when there is a breaking change,
2. MINOR is bumped when a new feature is added in a backward-compatible way,
3. PATCH is bumped when a bug is fixed in a backward-compatible way.

Versions bellow 1.0.0 are considered experimental and breaking changes may occur at any time.

## Contributing

Contributions are welcomed! There are many ways to contribute, and we appreciate all of them. Here are some of the major ones:

* [Bug Reports](https://github.com/chaplean/[projectname]/issues): While we strive for quality software, bugs can happen and we can't fix issues we're not aware of. So please report even if you're not sure about it or just want to ask a question. If anything the issue might indicate that the documentation can still be improved!
* [Feature Request](https://github.com/chaplean/[projectname]/issues): You have a use case not covered by the current api? Want to suggest a change or add something? We'd be glad to read about it and start a discussion to try to find the best possible solution.
* [Pull Request](https://github.com/chaplean/[projectname]/pulls): Want to contribute code or documentation? We'd love that! If you need help to get started, GitHub as [documentation](https://help.github.com/articles/about-pull-requests/) on pull requests. We use the ["fork and pull model"](https://help.github.com/articles/about-collaborative-development-models/) were contributors push changes to their personnal fork and then create pull requests to the main repository. Please make your pull requests against the `master` branch.

As a reminder, all contributors are expected to follow our [Code of Conduct](CODE_OF_CONDUCT.md).

## Hacking

> When applicable describe how to perform various common actions when working on the project. For example:

You might find the following commands usefull when hacking on this project:

```bash
# Install dependencies
composer install

# Run tests
bin/phpunit
```

## License

kanbanize-api-client-bundle is distributed under the terms of the MIT license.

[comment]: # (Contributions must be made available under the same license.)

See [LICENSE](LICENSE.md) for details.
