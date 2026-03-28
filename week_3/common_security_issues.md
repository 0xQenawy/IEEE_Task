# The Most Common Security Issues: Exploitation and Mitigation

## 1. Injection

Injection occur when untrusted data is sent to an interpreter as part of a command or query
The most common form is SQL Injection but it can also affect NoSQL, OS commands, and LDAP.

### How Hackers Exploit It
An attacker supplies malicious input for example ` 1' OR 1='1 ` into a form field or URL parameter and the application inadvertently executes this as code within the database This allows the attacker to view, modify or delete sensitive data or even gain administrative access to the database.

### Mitigation Strategies
*   **Use Prepared Statements (Parameterized Queries):** This is the most effective defense 
It ensures that the database treats user input as data not as executable code.
*   **Allow-list Input Validation:** Strictly validate input against a known set of safe values.
*   **Escape All User Supplied Input:** If parameterized queries are not possible, carefully escape special characters before using them in queries.

## 2. Cross-Site Scripting (XSS)

XSS vulnerabilities occur when an application includes untrusted data in a web page without proper validation or escaping. 

### How Hackers Exploit It
Attackers inject malicious scripts into a web page viewed by other users and When the victim loads the page their browser executes the script. This can be used to steal session cookies, redirect the user to malicious sites, deface websites, or perform actions on behalf of the user.
There are mainly three types: Reflected XSS, Stored XSS, and DOM-based XSS.

### Mitigation Strategies
*   **Context-Aware Output Encoding:** Encode data before inserting it into the HTML document and the encoding must match the context (HTML body, JavaScript, CSS, URL).
*   **Sanitize HTML Input:** If users are allowed to submit HTML content (like in text editor), use an HTML sanitization library to strip out dangerous tags and attributes.
*   **Implement Content Security Policy (CSP):** CSP is an HTTP header that allows site operators to restrict the resources (such as JavaScript, CSS, Images) that a browser can load for a given page, significantly reducing the impact of XSS.

## 3. Broken Access Control (Including IDOR)

Broken Access Control means users can perform actions outside of their intended permissions and a common subset is Insecure Direct Object Reference (IDOR), where an application exposes a reference to an internal implementation object.

### How Hackers Exploit It
An attacker modifies a parameter (like a user ID in a URL: `example.com/profile?id=123` changed to `id=124`) to access data belonging to another user. If the server does not verify that the logged-in user has authorization to view user 124's profile, the exploit succeeds. Attackers can also force browsing to administrative pages like `example.com/admin_panel` if access controls are not strictly enforced.

### Mitigation Strategies
*   **Implement Role-Based Access Control:** Clearly define roles and permissions, and enforce them consistently across the application.
*   **Deny by Default:** Unless a user is explicitly granted access to a resource, they should be denied.
*   **Server-Side Checks:** Never rely on the client (hiding a button in the UI) to enforce access control. Always verify permissions on the server for every sensitive request.

## 4. Broken Authentication and Session Management

This occurs when authentication and session management functions are implemented incorrectly, allowing attackers to compromise passwords, keys, or session tokens.

### How Hackers Exploit It
Attackers use techniques like credential stuffing (using lists of compromised passwords from other breaches) and brute-forcing. They might also exploit session fixation vulnerabilities or take advantage of infinite session timeouts to hijack an active account.

### Mitigation Strategies
*   **Implement Multi-Factor Authentication (MFA):** This is the strongest defense against credential theft.
*   **Enforce Strong Password Policies:** Require complexity, length, and check against lists of known breached passwords.
*   **Secure Session Management:** 
    *   Generate a new session ID after login.
    *   Set the `Secure` and `HttpOnly` flags and the `SameSite` attribute on session cookies.
    *   Implement strict session timeouts and absolute expiration times.
*   **Rate Limiting against Brute Force:** Limit the number of failed login attempts from a given IP address.


