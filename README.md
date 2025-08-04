# Laravel License System

## Database migrations and seeders
```
php artisan migrate --seed
```
This will:
- Create the licenses table
- Seed 20 license etries with random keys and serial numbers.

## License activation endpoint
```
curl -X POST http://localhost:8000/api/license/activate -H "Accept: application/json" -H "Content-Type: application/json" -d '{"key":"XXXX-XXXX-XXXX-XXXX-XXXX-XXXX-XXXX-XXXX"}'
```

## License deactivation endpoint
```
curl -X POST http://localhost:8000/api/license/deactivate -H "Accept: application/json" -H "Content-Type: application/json" -d '{"serial_number":"XXXXXXXX"}'
```

## Tests
License activation and deactivation endpoints are tested for:

- Valid inputs activating/deactivating licenses correctly
- Validation errors
- Handling of non-existent licenses
- Proper HTTP status codes and JSON responses

```
php artisan test
```