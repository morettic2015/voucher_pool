about
===========

This is a test code submited to Vanhack

author
===========

Luis Augusto Machado Moretto <projetos@morettic.com.br>
website <https://morettic.com.br>

Introduction
===========

The objective is to create a voucher pool microservice based in PHP.
You can use whichever components, libraries and frameworks you prefer.
What is a voucher pool?

A voucher pool is a collection of (voucher) codes that can be used by customers (recipients)
to get discounts in a web shop.
Each code may only be used once and we would like to know when it was was used by the
recipient.

Since there can be many recipients in a voucher pool, we need a call that auto-generates
voucher codes for each recipient.

Here’s a screenshot from our software to give you an idea what it looks like:

Entities
- Recipient
- Name
- Email (unique)
- Special Offer
- Name
- fixed percentage discount
- Voucher Code
- unique randomly generated Code (at least 8 chars)
- assigned to a Recipient and a special offer
- Expiration Date
- Can just be used once
- Should track date of usage

Functionalities
===========
- For a given Special Offer and an expiration date generate for each Recipient a

Voucher Code
===========

- Provide an endpoint, reachable via HTTP, which receives a Voucher Code and Email and validates the Voucher Code. In Case it is valid, return the Percentage Discountand set the date of usage
- Extra: For a given Email, return all his valid Voucher Codes with the Name of the Special Offer Tasks
❏ Design a database schema
❏ Write an application
❏ Add an API endpoint for verifying and redeeming vouchers
❏ The code should be covered by tests
❏ Write a documentation with code examples for the implemented calls (Postman collection is a nice-to-have)

Hints
===========

- A micro-framework may help you get started quickly
- Security is not a concern - look at this as an internal app, no need for access control
- A system that works is appreciated, but the larger focus is on code quality etc.
- Tests may reveal inconsistencies or unexpected scenarios in the original specification
- Any further questions? Feel free to ask us!

Frameworks
===========

1. PHP UNIT
2. Slim Framework
3. Medoo
4. OnsenUI front end

Database
===========

1. MySQL

postman doc
===========

https://documenter.getpostman.com/view/5116892/RWToNGo6