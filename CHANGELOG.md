# Changelog

## 1.0.3

- Validate configuration values before formatting anonymous chat so malformed YAML does not cause a type error.
- Apply color codes from the configured template before inserting player text. Player supplied ampersand codes are no longer interpreted as formatting.
- Remove one optional space after the `[*]` prefix and ignore an empty anonymous message.
- Add a pinned DevTools build with PHPStan level max and PHAR validation.

## 1.0.2

- Declare plugin API 5.0.0.
