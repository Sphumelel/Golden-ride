
document.getElementById('createAccountLink').addEventListener('click', (e) => {
    e.preventDefault();

    // Create a form element
    const formHTML = `
        <form id="createAccountForm">
            <h2>Create Account</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
            
            <button type="submit">Create Account</button>
        </form>
    `;

    // Insert the form into the formContainer div
    document.getElementById('formContainer').innerHTML = formHTML;
    
    // Optional: Add form submission handler
    document.getElementById('createAccountForm').addEventListener('submit', (formEvent) => {
        formEvent.preventDefault();
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // You can add validation or AJAX call here

        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        alert('Account created successfully!'); // Example success message
        // You can proceed with further actions, such as sending data to a server.
    });
});
    