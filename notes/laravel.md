# Laravel Notes

### Eloquent Model Methods

**Eloquent** provides several methods to manipulate model attributes and persist data to the database.

- **`fill(array)`**: Mass-assigns an array of fields onto a model without saving to DB. Respects `$fillable`.
- **`forceFill(array)`**: Like `fill()` but bypasses the `$fillable` guard — assigns any field including non-fillable ones. Safe only when values come from internal code, not raw user input.
- **`validated()`**: Returns only the fields that passed validation from the request. Used with `fill()` to safely update model attributes.
- **`isDirty(attribute)`**: Returns `true` if the attribute has been changed but not yet saved to DB. Comes from Eloquent's `Model` class.
- **`save()`**: Persists the model's current state to the database.

#### Usage

1. **`fill()` + `validated()`**

    Safely update model attributes from a form request:

    ```php
    $user->fill($request->validated());
    $user->save();
    ```

2. **`isDirty()`**

    Reset email verification when email changes:

    ```php
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }
    ```

3. **`forceFill()`**

    Set non-fillable fields during password reset:

    ```php
    $user->forceFill([
        'password' => Hash::make($request->password),
        'remember_token' => Str::random(60),
    ])->save();
    ```

---

### ProfileController

**ProfileController** manages profile display, update, and account deletion using several Laravel patterns.

- **`RedirectResponse`**: PHP return type hint declaring the method returns an HTTP redirect. Used on `update` and `destroy`.
- **`@include` variable sharing**: Variables passed to a Blade view are automatically available in all `@include`d partials — no need to pass them again.
- **`validateWithBag(bag, rules)`**: Like `validate()` but stores errors in a named error bag. Useful when multiple forms share a page.
- **`MessageBag`**: A named container for validation errors. Naming bags prevents errors from one form appearing on another.
- **`Redirect::route()->with(key, value)`**: Redirects to a named route and flashes a value to the session for the next request.

#### Usage

1. **`validateWithBag()`**

    Validate with a named bag to isolate form errors:

    ```php
    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);
    ```

2. **`Redirect::route()->with()`**

    Redirect and flash a status message to the session:

    ```php
    return Redirect::route('profile.edit')->with('status', 'profile-updated');
    ```

---

### Authentication

**Laravel authentication** uses guards, rate limiting, and Form Requests to handle login securely.

- **`Auth::guard('web')->logout()`**: Logs out the user from the `web` guard (default session-based guard). Specify guard when multiple guards exist.
- **`LoginRequest`**: A custom Form Request at `app/Http/Requests/Auth/LoginRequest.php`. Handles validation + authentication together. Auto-injected by Laravel.
- **`throttleKey()`**: Builds a unique rate-limit key per user: `email|ip`. Tracks failed login attempts per email+IP combo.
- **`ensureIsNotRateLimited()`**: Checks if the throttle key has hit 5 failed attempts. Fires a `Lockout` event and throws an error with retry countdown.
- **`ValidationException::withMessages()`**: Throws a validation error with a custom message on a specific field. Shows in the form like a normal validation error.
- **RESTful naming**: In resource controllers, `create()` = show the form, `store()` = handle submission. `authenticate()` on `LoginRequest` does both.

#### Usage

1. **`throttleKey()`**

    Build a unique key per email + IP for rate limiting:

    ```php
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
    ```

2. **`ValidationException::withMessages()`**

    Show a login error on the email field:

    ```php
    throw ValidationException::withMessages([
        'email' => trans('auth.failed'),
    ]);
    ```

---

### Sessions

**Sessions** store data server-side between HTTP requests, since HTTP is stateless by nature.

- **Session drivers**: Configurable via `SESSION_DRIVER` in `.env` — `file`, `database`, `redis`, or `cookie`.
- **`auth.password_confirmed_at`**: Stored in the session (not the DB). Tracks when the user last confirmed their password.
- **Sessions vs tokens**: Sessions are server-side and instantly revokable — best for web apps. Access tokens are stateless — best for APIs. Refresh tokens extend API sessions.
- **Common uses**: Login persistence, flash messages, CSRF tokens, shopping carts, inactivity timeouts.

#### Usage

1. **Session storage locations by driver**

    - `file` → `storage/framework/sessions/`
    - `database` → `sessions` table (`payload` column, base64 encoded)
    - `redis` → Redis server
    - `cookie` → encrypted browser cookie

    This project uses `SESSION_DRIVER=database` — sessions are in the `sessions` table.

2. **Decoded session payload structure**

    ```
    a:4:{
      s:6:"_token";s:40:"abc123...";
      s:4:"auth";a:1:{s:20:"password_confirmed_at";i:1711234500;}
      s:6:"_flash";a:2:{s:3:"old";a:0:{}s:3:"new";a:0:{}}
    }
    ```

---

### Password Reset

**Password reset** uses signed URLs, token validation, and forced model updates for fields outside `$fillable`.

- **`Rules\Password::defaults()`**: Applies the globally configured password rules. Defaults to min 8 chars; configure once in `AppServiceProvider` to apply everywhere.
- **`forceFill()`**: Used to set `password` and `remember_token` (non-fillable fields) during reset. Safe because values are generated internally.
- **`ValidationException` import**: Required so IDEs and static analysis tools can resolve the class referenced in `@throws` annotations.

#### Usage

1. **Configure global password rules in `AppServiceProvider`**

    ```php
    Password::defaults(fn () => Password::min(8)
        ->mixedCase()
        ->numbers()
        ->symbols()
        ->uncompromised()
    );
    ```

2. **Reset password with `forceFill()`**

    ```php
    $user->forceFill([
        'password' => Hash::make($request->password),
        'remember_token' => Str::random(60),
    ])->save();
    ```

---

### Blade Directives

**`@props([...])`**: Declares component props in a Blade component. Pulls listed variables from component attributes instead of the parent view's scope.

**`$attributes->merge([...])`**: Merges extra attributes passed by the caller (e.g. `class="mt-4"`) with the component's default attributes. Caller can extend without overriding defaults.

**`<x-component-name :prop="value" />`**: Blade component syntax. Prefix with `x-`, pass props with `:prop=` (dynamic) or `prop=` (static string).

**`@csrf`**: Generates a hidden `<input type="hidden" name="_token" value="...">` field. Laravel verifies this token on every `POST`/`PUT`/`DELETE` request — rejects with `419` if missing or mismatched. Prevents CSRF attacks where a malicious site tricks a logged-in user's browser into submitting a form to your app.

**`__(string)`**: Laravel's translation helper. Looks up the string in lang files for the current locale. Falls back to the original string if no translation exists. Used throughout Breeze so the app is ready for multi-language support without later refactoring.

---

### Password Reset Link

**`Password::sendResetLink(['email' => ...])`**: Looks up user by email, generates a signed token, stores it in `password_reset_tokens` table, and sends the reset email. Returns a status string (`passwords.sent` or `passwords.user` if not found).

**`Password::RESET_LINK_SENT`**: String constant `"passwords.sent"`. Used to check if the email was dispatched successfully.

**Success**: `back()->with('status', __($status))` — redirects back and flashes a translated success message.

**Failure**: `back()->withInput()->withErrors(['email' => __($status)])` — redirects back, re-fills email, shows translated error on the email field.

---

### Redirects

**Laravel redirects** support named routes, intended URL fallbacks, and session flash data.

- **`redirect()->intended(fallback)`**: Redirects to the URL the user tried to visit before being sent to login. Falls back to `fallback` if none exists.
- **`route(name, absolute: false)`**: Generates a relative URL (e.g. `/dashboard`) instead of a full absolute URL.
- **`->with(key, value)`**: Flashes a value to the session for the next request only.

#### Usage

1. **`redirect()->intended()` after login**

    ```php
    return redirect()->intended(route('dashboard', absolute: false));
    ```

2. **Flash a status after profile update**

    ```php
    return Redirect::route('profile.edit')->with('status', 'profile-updated');
    ```

---

### Email Verification

**Email verification** is controlled by the `MustVerifyEmail` contract on the `User` model.

- **`hasVerifiedEmail()`**: Available via `Authenticatable` base — returns whether the user's email is verified.
- **`MustVerifyEmail`**: Must be implemented on `User` to enforce verification middleware. Without it, `hasVerifiedEmail()` exists but verification is not enforced.

#### Usage

1. **Enable email verification enforcement**

    Uncomment in `app/Models/User.php`:

    ```php
    class User extends Authenticatable implements MustVerifyEmail
    ```

---

### Tailwind / Vite

**Tailwind CSS** in Laravel is compiled by Vite and injected via the `@vite()` directive in Blade layouts.

- **`npm run dev`**: Starts Vite dev server with HMR. Must be running while browsing in development.
- **`npm run build`**: Compiles assets to `public/build/`. Required for production.
- **Styles not applying**: Most common cause is Vite not running or assets not built — `@vite()` fails silently and loads no CSS.

#### Usage

1. **Development**

    ```bash
    npm run dev
    ```

2. **Production**

    ```bash
    npm run build
    ```
