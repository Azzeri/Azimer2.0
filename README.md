# 🔥 Azimer - Fire Brigade Unit Management System

## 📌 About the Project

This personal project is designed to showcase my expertise in backend development and system architecture. Inspired by
Domain-Driven Design, it reflects my effort to implement a system using these methodologies. While it may seem
overengineered for such a simple system, that’s intentional — it’s a project meant to highlight my skills as a
developer.

The system's main purpose is to assist fire brigade unit employees in managing their equipment by planning maintenance
and recording usage.

At the moment, the project is in the early stages of development, but the overall design is roughly complete. Also, only
the backend API will be designed initially. Since I am not a frontend developer, the frontend will be created later.

## 🎨 Features

Below, I briefly describe the main features of the system. For more details, see the business
documentation: [Business Description](docs/Business/BusinessDescription.md).

- **Security** – Authentication, authorization, and login history of users.
- **Employee Management** – Managing basic data and roles of employees, who are also users of the system.
- **Fire Brigade Unit Management** – Managing fire brigade unit data and their hierarchies.
- **Fleet Management** – Managing the fleet of vehicles used by the units.
- **Equipment Management** – Recording all equipment used by fire brigade units, along with planning maintenance and
  recording usage.

## 🛠️ Technologies Used

- **Backend:** PHP 8 and Symfony 7
- **Database:** PostgreSQL and Elasticsearch
- **Version Control:** Git
- **Tests:** PEST
- **Containerization:** Docker
- **Quality Tools:** PHPStan, PHP_CodeSniffer, Psalm
- **Scaffolding:** Dunglas Symfony/Docker: [GitHub Link](https://github.com/dunglas/symfony-docker)
- **Other:** - Ecotone, to simplify orchestration.

## 📂 Project Structure

- **docs**
    - **Business** - In this folder, I keep all business-related documentation. It mostly consists of Context Mapper
      diagrams of Bounded Contexts and glossaries of ubiquitous language.
    - **Dunglas** - Here, I store all documentation provided by the Dunglas scaffolding, which is very useful for
      configuring environments.
- **src**
    - **App** - This folder contains the main application logic, split into bounded contexts.
        - **Bounded Context**
            - **Application** - Application layer for orchestration.
            - **Domain** - The entire business logic.
            - **Infrastructure** - Implementation details.
        - **UI** - Presentation layer, usually containing HTTP controllers and CLI commands.
- **tests**
    - **SampleProvider** - This folder contains classes that generate sample data.
    - **Unit** - Unit tests for each class in `src`, with matching namespaces for each file.
    - **Feature** - In the future, I plan to add feature tests here, preferably integrated with Gherkin.
- **Makefile.md** - Makefile for my most commonly used console commands.

## 🚀 Getting Started

### Installation

I recommend using Docker to quickly start the project. For more details, see the Dunglas
README: [Dunglas README](docs/Dunglas/README.md).

I also recommend checking the [Makefile](Makefile.md) for my most commonly used console commands.

## 📬 Contact

If you have any questions or suggestions, feel free to reach out:

- **Email:** your.email@example.com
- **LinkedIn:** [Your LinkedIn Profile](https://linkedin.com/in/yourprofile)
- **GitHub:** [Your GitHub Profile](https://github.com/your-username)

---
_This portfolio is constantly evolving. Stay tuned for updates!_ 🚀

