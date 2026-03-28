# code review

## First

**main.go**

```go
package main

import (
    "fmt"
    "net/http"
)

func main() {
    http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
        fmt.Fprintf(w, "<html><body>Welcome to the Go Web Server! Visit /greet, /about, or /contact</body></html>")
    })

    http.HandleFunc("/about", func(w http.ResponseWriter, r *http.Request) {
        fmt.Fprintf(w, "<html><body><h1>About Us</h1><p>We are a team of passionate Gophers...</p></body></html>")
    })

    http.HandleFunc("/contact", func(w http.ResponseWriter, r *http.Request) {
        fmt.Fprintf(w, "<html><body><h1>Contact Us</h1><p>Email us at contact@example.com</p></body></html>")
    })

    http.HandleFunc("/greet", func(w http.ResponseWriter, r *http.Request) {
        name := r.URL.Query().Get("name")
        response := fmt.Sprintf("<html><body><h1>Hello, %s!</h1></body></html>", name)
        fmt.Fprint(w, response)
    })

    fmt.Println("Server is running at http://localhost:8080/")
    http.ListenAndServe(":8080", nil)
}
```

---

## Findings

### XSS

* in /greet endpoint user input is not escaped that lead to XSS when user input is <script>alert(document.cookie)</script> the cookie will be sent to the attacker when he visits the page


---

## Second

**main.js**

```javascript
const express = require('express');
const axios = require('axios');

const app = express();

app.get('/profile', (req, res) => {
    console.log('Received request for /profile');

    // Simulated profile data
    const profileData = {
        name: 'John Doe',
        role: 'Developer'
    };
    
    res.json(profileData);
    console.log('Sent profile data response');
});

app.get('/fetch-data', async (req, res) => {
    const url = req.query.url;
    console.log(`Received request for /fetch-data with URL: ${url}`);
    
    try {
        const response = await axios.get(url);
        res.send(response.data);
        console.log(`Data fetched and sent for URL: ${url}`);
    } catch (error) {
        console.error(`Error fetching data from URL: ${url}`, error);
        res.status(500).send('Error fetching data');
    }
});

app.listen(3000, () => {
    console.log('Server running on port 3000');
});
```
## Findings

### SSRF 

* in /fetch-data endpoint the `url` parameter is taken directly from the user and passed without validation to `axios.get(url)`. An attacker can pass internal network IPs like `http://localhost:3000` or cloud metadata endpoints (`http://169.254.169.254`) to force the server to make requests to internal resources, bypassing firewalls and leaking sensitive internal data back to the attacker.


