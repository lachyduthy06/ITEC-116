const form = document.getElementById('form');
const errorContainer = document.querySelector('.error-messages');
const resultContainer = document.querySelector('.result-container'); // Container for success message
const submitButton = document.querySelector('button[type="submit"]');

// Example API token
const API_TOKEN = 'your-api-token-here';

form.addEventListener('submit', async event => {
  event.preventDefault();
  errorContainer.innerHTML = ''; // Clear previous error messages
  resultContainer.innerHTML = ''; // Clear previous success message
  submitButton.disabled = true; // Disable the submit button to prevent multiple submissions
  submitButton.textContent = 'Submitting...'; // Update button text

  const data = new FormData(form);

  // Show loading message
  const loadingMessage = document.createElement('div');
  loadingMessage.classList.add('alert', 'alert-info');
  loadingMessage.textContent = 'Processing, please wait...';
  resultContainer.appendChild(loadingMessage);

  try {
    // Make asynchronous API call
    const res = await fetch('http://10.10.139.82:8000/api/patrons', {
      method: 'POST',
      body: data,
      headers: {
        'Authorization': `Bearer ${API_TOKEN}`,
      },
    });

    const resData = await res.json();
    console.log(resData);

    loadingMessage.remove(); // Remove loading message

    if (!res.ok) {
      // Handle errors and display error messages
      if (resData.errors && typeof resData.errors === 'object') {
        for (let field in resData.errors) {
          const fieldErrors = resData.errors[field];

          fieldErrors.forEach(errorMessage => {
            const errorMessageElement = document.createElement('div');
            errorMessageElement.classList.add('alert', 'alert-danger');
            errorMessageElement.textContent = `${field.charAt(0).toUpperCase() + field.slice(1)}: ${errorMessage}`;
            errorContainer.appendChild(errorMessageElement);
          });

          // Highlight the invalid field
          const fieldElement = document.querySelector(`#${field}`);
          fieldElement.classList.add('is-invalid');
        }
      }
    } else {
      // Handle success and display a success message
      const successMessage = document.createElement('div');
      successMessage.classList.add('alert', 'alert-success');
      successMessage.textContent = `Registration successful! Patron ID: ${resData.id}`;
      resultContainer.appendChild(successMessage);

      form.reset(); // Reset the form after success
    }
  } catch (err) {
    console.error(err.message);
    const errorMessageElement = document.createElement('div');
    errorMessageElement.classList.add('alert', 'alert-danger');
    errorMessageElement.textContent = 'An error occurred. Please try again later.';
    errorContainer.appendChild(errorMessageElement);
  } finally {
    submitButton.disabled = false; // Re-enable the submit button
    submitButton.textContent = 'Register'; // Reset button text
  }
});
