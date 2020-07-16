# portfolio-toggl-invoice-generator
Invoice generator connected to Toggl API

### Functionalities (WIP):
 - create invoices based on Toggl Reporting API
 - customise the dates and the client in the Report
 - send the invoice by email to the client
 - save a local copy of the Invoice
 - generates an invoice in docx and converts to PDF if Libreoffice is available

### Stack:
- Languages:
PHP, JavaScript

- Database:
MariaDB

- Templating engine:
Smarty

- Dependency management:
Composer

- Testing:
PHPUnit

- Linting:
php-codesniffer (PSR2)


### Tasks:
  - [ ] Create a Word template for the invoice
  - [ ] Connect to Toggl API and download report with the data
  - [ ] Save invoice as docx file
  - [ ] Convert invoice to PDF
  - [ ] Build interface for invoice data manipulation
  - [ ] Insert invoices to the DB
  - [ ] Send invoice by email
  - [ ] Show all invoices on the page
  - [ ] Dockerize the app
