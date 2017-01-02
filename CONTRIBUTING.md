# Contributing to Snaglogger

Contributions are welcome to this project! Before creating a pull request or creating an issue, please read through this document to understand the expectations being set for contributions.

## Design rationale

The purpose of this library is to do one thing: provide a way to send logging data to Bugsnag via the PSR-3 set of interfaces.

To accomplish this goal, two design principles are used:

- Provide **one** sensible, quick way to use the logger that works for the "80% use case" without additional customization
- Provide abstractions that do not break encapsulation so that downstream users can customize the usage of the logger to their desired use case.

To that end, contributions that improve the "80% use case" or provide better abstractions for customizing the logger's functionality will generally be welcomed, while contributions that stray too far from those principles will not.

## Preparing to contribute

### Issues

You do not need to supply code in order to contribute. Bug reports and functionality requests are welcome in the form of issues. Check out [Daniel Beck](http://ddbeck.com)'s "[Writing feature requests and bug reports that get results](http://www.hackwriting.com/2012/09/19/writing-feature-requests-and-bug-reports-that-get-results-2/)" if you need help getting started.

### Code changes

### Scope

If you're planning on making a large or architectural change, please create an issue first to discuss it. Otherwise, feel free to open a pull request directly with your change.

Please make sure your change is a single, atomic commit: if you plan on changing multiple things, a separate PR for each of the changes makes it much easier to review and accept them.

### Testing

Please also make sure your code passes all existing unit tests and code style guidelines:

```sh
./vendor/bin/phpunit
./vendor/bin/phpcs -n --standard=PSR2 src/ tests/
```

If you've added additional functionality, additional unit tests covering the "[happy path](https://en.wikipedia.org/wiki/Happy_path)" and any common [exceptional scenarios](https://en.wikipedia.org/wiki/Negative_test) are required.

### Review

Once you've created your pull request, one of the project maintainers will review your code. It may take some time before someone is able to take a look at it. Once you've addressed any concerns or requested changes from the maintainers, your change will be merged.

## Contributor Covenant Code of Conduct

### Our Pledge

In the interest of fostering an open and welcoming environment, we as contributors and maintainers pledge to making participation in our project and our community a harassment-free experience for everyone, regardless of age, body size, disability, ethnicity, gender identity and expression, level of experience, nationality, personal appearance, race, religion, or sexual identity and orientation.

### Our Standards

Examples of behavior that contributes to creating a positive environment include:

* Using welcoming and inclusive language
* Being respectful of differing viewpoints and experiences
* Gracefully accepting constructive criticism
* Focusing on what is best for the community
* Showing empathy towards other community members

Examples of unacceptable behavior by participants include:

* The use of sexualized language or imagery and unwelcome sexual attention or advances
* Trolling, insulting/derogatory comments, and personal or political attacks
* Public or private harassment
* Publishing others' private information, such as a physical or electronic address, without explicit permission
* Other conduct which could reasonably be considered inappropriate in a professional setting

### Our Responsibilities

Project maintainers are responsible for clarifying the standards of acceptable behavior and are expected to take appropriate and fair corrective action in response to any instances of unacceptable behavior.

Project maintainers have the right and responsibility to remove, edit, or reject comments, commits, code, wiki edits, issues, and other contributions that are not aligned to this Code of Conduct, or to ban temporarily or permanently any contributor for other behaviors that they deem inappropriate, threatening, offensive, or harmful.

### Scope

This Code of Conduct applies both within project spaces and in public spaces when an individual is representing the project or its community. Examples of representing a project or community include using an official project e-mail address, posting via an official social media account, or acting as an appointed representative at an online or offline event. Representation of a project may be further defined and clarified by project maintainers.

### Enforcement

Instances of abusive, harassing, or otherwise unacceptable behavior may be reported by contacting the project owner at <mark@marktrapp.com>. All complaints will be reviewed and investigated and will result in a response that is deemed necessary and appropriate to the circumstances. The project team is obligated to maintain confidentiality with regard to the reporter of an incident. Further details of specific enforcement policies may be posted separately.

Project maintainers who do not follow or enforce the Code of Conduct in good faith may face temporary or permanent repercussions as determined by other members of the project's leadership.

### Attribution

This Code of Conduct is adapted from the [Contributor Covenant](http://contributor-covenant.org), version 1.4, available at [http://contributor-covenant.org/version/1/4](http://contributor-covenant.org/version/1/4/)
