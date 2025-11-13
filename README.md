# Royal-Star-Resort
A PHP/MySQL resort management and booking application. Features role-based panels for guests, staff, and admins to manage bookings, payments, staff salaries, and rooms.


## Highlights
- Public site with booking flow, program packages, and gallery.
- Role-based authentication: `guest`, `staff`, `admin` with session redirects.
- Admin/Staff dashboards for staff CRUD, salary records, rooms, leave requests, and tasks.
- REST-like PHP APIs returning JSON, used by JS frontends via `fetch` and FormData.

## Tech Stack
- PHP 7.4+ (tested with PHP 8.x), Apache (XAMPP)
- MySQL/MariaDB via XAMPP
- Vanilla JS + Bootstrap, custom CSS

## Directory Structure
- `Guest&Public_Pages/` public pages: `home.php`, `room.php`, `program.php`, `gallery.php`, `blog.php`, `login.php`, `register.php`, `payment.php`, etc.
- `Admin&Staff_Panel/` admin and staff dashboards: `admin.php`, `employee.php`, `task_mang.php`, `salary_mang.php`, `room_mang.php`, `leave_mang.php`.
- `Booking&Public_APIs/` booking and public APIs: `api_process_booking.php`, `api_process_payment.php`, `api_get_bookings.php`, `api_get_booking_details.php`, `check_availability.php`, `api_program.php`.
- `Admin&Staff_APIs/` admin/staff APIs: `api_staff.php`, `api_salary.php`, `api_rooms.php`, `api_guests.php`, `api_add_task.php`, `api_update_task.php`, `api_leave_admin.php`.
- `Authentication/` login/register flows: `login_process.php`, `api_register.php`, `handle_registration.php`, `create_admin.php`, `logout.php`.
- `Database/` DB config and schema: `db_connect.php`, `royal_star_resort.sql`, `setup_database.php`, `test_db_connection.php`.
- `accommodations/`, `program/`, `Styling&Scripts/`, `photos/`, `uploads/` UI assets, pages, and uploads.

## Database
- Configure `Database/db_connect.php`:
  - `servername=localhost`, `username=root`, `password=''`, `dbname=royal_star_resort`.
  - Uses `mysqli` and sets charset `utf8mb4`. On failure, returns JSON error.
- Schema file: `Database/royal_star_resort.sql` (tables: `users`, `accommodations`, `bookings`, `booking_details`, `programs`, `salary_records`, `tasks`, `leave_requests`, `gallery`, `blogs`, `awards`, etc.).
- Quick tests: `Database/test_db_connection.php` checks connection and presence of key tables.

## Setup
1. Install XAMPP and start `Apache` and `MySQL`.
2. Copy this repo to `c:\xampp3\htdocs\miniproject` (or `C:\xampp\htdocs\miniproject`).
3. Create DB `royal_star_resort` and import `Database/royal_star_resort.sql` via phpMyAdmin.
4. Edit `Database/db_connect.php` if credentials differ.
5. Verify DB: open `http://localhost/miniproject/Database/test_db_connection.php`.
6. (Optional) `Database/setup_database.php` creates a minimal `users` table and seeds demo users.
7. Create an admin (if needed): `http://localhost/miniproject/Authentication/create_admin.php`.

## Running
- Public site: `http://localhost/miniproject/Guest&Public_Pages/home.php`
- Login: `http://localhost/miniproject/Guest&Public_Pages/login.php`
- Register: `http://localhost/miniproject/Guest&Public_Pages/register.php`
- Admin dashboard: `http://localhost/miniproject/Admin&Staff_Panel/admin.php`
- Staff dashboard: `http://localhost/miniproject/Admin&Staff_Panel/employee.php`

## Authentication & Sessions
- Login endpoint: `Authentication/login_process.php` (POST FormData `user`, `pass`).
  - On success, sets `$_SESSION['user_id']`, `username`, `role` and redirects by role:
    - `admin` -> `Admin&Staff_Panel/admin.php`
    - `staff` -> `Admin&Staff_Panel/employee.php`
    - `guest` -> `Guest&Public_Pages/guest.php`
- Registration endpoint (AJAX): `Authentication/api_register.php` (POST)
  - Keys: `name`, `email`, `username`, `password`, `conpass`, `mobileNumber`.
  - Creates `users` with role `guest` and hashed password.

## Booking Flow
- Accommodation pages (`accommodations/room*.php`) and `accommodations/accommodation_ajax.js` route to `Guest&Public_Pages/reservation.php` with `roomId`, `checkin`, `checkout`.
- Availability check: `Booking&Public_APIs/check_availability.php` (GET `check_in`, `check_out`) returns `{ unavailable_ids: number[] }`.
- Create booking: `Booking&Public_APIs/api_process_booking.php` (POST FormData)
  - Required: session `user_id`. Accepts: `roomId`, `checkin`, `checkout`, `programId` or `selectedPackages` (JSON), guest fields `fullName`, `email`, `phone`, `nationality`, `requests`, `totalPrice`, and file `identity_document`.
  - Performs overlap check on `booking_details` and inserts into `bookings` + `booking_details`. Supports admin/staff booking on behalf of a guest via `guest_user_id`.
- Payment page: `Guest&Public_Pages/payment.php` calls `Booking&Public_APIs/api_get_booking_details.php?id=<bookingId>` to render summary and then `Booking&Public_APIs/api_process_payment.php` (JSON body `{ bookingId, amount }`, requires session).
- List bookings: `Booking&Public_APIs/api_get_bookings.php` returns bookings for `$_SESSION['user_id']`.

## Admin & Staff APIs (JSON)
- `Admin&Staff_APIs/api_staff.php` (`action=fetch|add|update|delete`)
  - `add`: POST `name`, `email`, `phone`, `position`, `hire_date` -> creates `users` (role `staff`) and a `salary_records` row.
  - `update`: POST `id`, `name`, `email`, `phone`, `position`, `hire_date` -> updates `users` and latest `salary_records`.
  - `delete`: POST `id` -> deletes salary records then `users` row (role must be `staff`).
- `Admin&Staff_APIs/api_salary.php`
  - `fetch_employees`: search staff and latest salary summary.
  - `get_salary_details`: GET `id` -> returns basic salary and computed allowances/deductions.
  - `fetch_history`: GET `id` -> last 6 months salary records.
  - `save_record`/`fetch_monthly_summary` also present for salary management.
- `Admin&Staff_APIs/api_rooms.php` fetches accommodations with filters: `search`, `type`, `status`, `price`.
- `Admin&Staff_APIs/api_guests.php` creates guest bookings and ensures a `users` row exists for guest email.
- `Admin&Staff_APIs/api_leave_admin.php` returns leave requests joined with user details.

## Configuration & Assets
- DB config: `Database/db_connect.php`.
- Uploads: `uploads/documents/` stores identity documents from bookings.
- Frontend assets: `Styling&Scripts/style.css`, `style1.css`, `script.js`; accommodation pages use `accommodations/accommodation.css` and `accommodation_ajax.js`.

## Security Notes
- Never commit API keys. `Booking&Public_APIs/chatbot.php` contains a hardcoded Google API key; move to server-side env and restrict.
- Disallow PHP execution in `uploads/` (e.g., `.htaccess` with `php_flag engine off`) and validate file type/size.
- Use HTTPS for production; disable `display_errors` in production.
- Ensure session cookie settings (`httponly`, `secure` on HTTPS) and CSRF protection for sensitive actions.

## Troubleshooting
- Blank pages or 404: verify project path under `htdocs`; check URL casing.
- DB connection errors: confirm credentials and run `Database/test_db_connection.php`.
- Booking overlap errors: check existing `booking_details` for date conflicts.
- Login issues: make sure `users` table matches code expectations (`id`, `username`, `email`, `password`, `role`).

## Known Inconsistencies
- `Authentication/handle_login.php` selects `name` but schema uses `username`. Prefer `login_process.php`.
- Some legacy scripts reference `user` vs `users` table. Align new code to `users`.
- `check_availability.php` uses PDO with local creds instead of `db_connect.php` (mysqli). Consider centralizing DB access.

## Contributing
- Keep changes minimal and consistent with existing structure.
- Document new endpoints with method, params, and response shape.
- Avoid unrelated refactors in feature PRs.

  ## Employee Login
  user_id : noyal@gmail.com
  password:noyal@123

  ## Admin Login
  user_id : bijokbinoy2005@gmail.com
  password:bijo2005
