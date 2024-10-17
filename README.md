# Factory - Jela Svijeta

This API is built with Laravel, designed to manage and retrieve meals, categories, tags, and ingredients. The API supports multilingual content and allows clients to request specific relationships (e.g., ingredients, tags, and categories) through flexible query parameters.

## Features

- **Retrieve Meals:** Fetch meals with optional filters for tags, ingredients, and categories.
- **Multilingual Support:** Handle translations based on the requested language.
- **Pagination:** Control the number of meals returned per page.
- **Eager Loading:** Use the `with` parameter to include related data like tags, ingredients, and categories.

## Table of Contents

- [Features](#features)
- [Pacages Used](#pacages-used)
- [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Models & Relationships](#models--relationships)
- [Database Schema](#database-schema)
- [Validation](#validation)
- [Translations](#translations)
- [Error Handling](#error-handling)

## Pacages Used

- [Faker](https://fakerphp.org/): For generating fake data in database seeders.
- [Laravel Translatable](https://github.com/Astrotomic/laravel-translatable): For handling translations in models.

## Instalation

1. **Clone the repository**
    `git clone https://github.com/yourusername/meals-api.git`
    `cd meals-api`
2. **Instal the dependencies**
    `composer install`
3. **Configure your `.env` file**
    `cp .env.example .env`
    - Setup your database configuration
4. **Run database migration and seeder**
    `php artisan migrate --seed`
5. **Start the development server**
    `php artisan serve`

## Usage

- **Example request:** ```.../meals?per_page=2&tags=4&lang=en_GB&with=category,ingredients,tags&page=1```
- **Example response:**
  ```{
  "meta": {
    "currentPage": 1,
    "totalItems": 4,
    "itemsPerPage": 2,
    "totalPages": 2
  },
  "data": [
    {
      "id": 6,
      "title": "I'm sure.",
      "description": "Who ever saw in my time, but.",
      "status": "created",
      "category": {
        "id": 1,
        "title": "But they.",
        "slug": "aut-aliquid-eveniet"
      },
      "tags": [
        {
          "id": 4,
          "title": "HAVE you.",
          "slug": "nesciunt-maiores-ea"
        },
        {
          "id": 8,
          "title": "Alice as.",
          "slug": "est-voluptatum-repellat"
        },
        {
          "id": 3,
          "title": "The door.",
          "slug": "sapiente-non-et"
        }
      ],
      "ingredients": [
        {
          "id": 15,
          "title": "Alice to.",
          "slug": "dolores-architecto-iusto"
        },
        {
          "id": 22,
          "title": "Five and.",
          "slug": "occaecati-necessitatibus-sed"
        }
      ]
    },
    {
      "id": 7,
      "title": "I get it.",
      "description": "I should think you might.",
      "status": "created",
      "category": {
        "id": 3,
        "title": "THAT'S a.",
        "slug": "laborum-assumenda-voluptate"
      },
      "tags": [
        {
          "id": 4,
          "title": "HAVE you.",
          "slug": "nesciunt-maiores-ea"
        }
      ],
      "ingredients": [
        {
          "id": 13,
          "title": "On which.",
          "slug": "quae-maiores-id"
        },
        {
          "id": 9,
          "title": "Duchess!.",
          "slug": "excepturi-sapiente-delectus"
        }
      ]
    }
  ],
  "links": {
    "prev": null,
    "next": "http://127.0.0.1:8000/meals?page=2",
    "self": "http://127.0.0.1:8000/meals?page=1"
  }
}```

## API Endpoints

Retrive a paginated list of meals
**Query parameters:**
- `per_page` (optional): number of meals per page
- `tags` (optional): filter by tags ID
- `lang` (required): language code for translation (available codes : `en_GB`, `hr_HR` (also outputs english words, as the Faker pacage doesn't support used method in Croatian), `de_DE`)
- `with` (optional): Include related data (comma-separated, e.g., `category`, `tags`, `ingredients`)
- `page` (optional): page numebr of pagination

## Models & Relationships

- **Meal:**
  - Relationships: `belongsTo` Category, `belongsToMany` Tags, `belongsToMany` Ingredients
- **Category:**
  - Relationship: `hasMany` Meals
- **Tag:**
  - Relationship: `belongsToMany` Meals
- **Ingredient:**
  - Relationship: `belongsToMany` Meals

## Database Schema

| Command | Description |
| --- | --- |
| meals | ID, status, category_id, created_at, updated_at |
| meal_translations | ID, meal_id, locale, title, description |
| categories | ID, slug, created_at, updated_at |
| category_translations | ID, category_id, locale, title |
| ingredients | ID, slug, created_at, updated_at |
| ingredient_translations | ID, ingredient_id, locale, title |
| tags | ID, slug, created_at, updated_at |
| tag_translations | ID, tag_id, locale, title |
| languages | ID, locale, language, created_at, updated_at |
| meal_ingredient | ID, meal_id, ingredient_id |
| meal_tag | ID, meal_id, tag_id |

## Validation

- `per_page`: integer between 1 and 100
- `tags`: nullable integer
- `lang`: required string
- `with`: nullable string
- `page`: integer with minimum value of 1

## Translations

Translations are retrieved by calling the `translate($lang)` method on each model.
- Languages Supported: Each model supports multiple languages through the translation table.

## Error Handling

If validation fails or any other error occurs, the API returns a 400 or 500 response with an appropriate error message.

Example Error Response:
```
{
    "per_page": [
        "The per_page must be an integer."
    ],
    "lang": [
        "The lang field is required."
    ]
}

```
