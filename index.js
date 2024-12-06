const form = document.getElementById('form');
const errorContainer = document.querySelector('.error-messages');
const resultContainer = document.querySelector('.result-container'); // Container for success message

// Example API token (replace with actual token for real implementation)
const API_TOKEN = 'your-api-token-here';

form.addEventListener('submit', async event => {
  event.preventDefault();

  const data = new FormData(form);

  // Clear previous messages
  errorContainer.innerHTML = '';
  resultContainer.innerHTML = ''; // Clear previous success message

  try {
    // Asynchronous API call with authentication
    const res = await fetch('http://10.10.139.82:8000/api/patrons', {
      method: 'POST',
      body: data,
      headers: {
        'Authorization': `Bearer ${API_TOKEN}`,
      },
    });

    const resData = await res.json();
    console.log(resData);

    if (!res.ok) {
      // Handle and display error messages dynamically
      if (resData.errors && typeof resData.errors === 'object') {
        for (let field in resData.errors) {
          const fieldErrors = resData.errors[field];

          fieldErrors.forEach(errorMessage => {
            const errorMessageElement = document.createElement('div');
            errorMessageElement.classList.add('alert', 'alert-danger');
            errorMessageElement.textContent = `${field.charAt(0).toUpperCase() + field.slice(1)}: ${errorMessage}`;
            errorContainer.appendChild(errorMessageElement);
          });
        }
      }
    } else {
      // Dynamic DOM manipulation to display success message
      const successMessage = document.createElement('div');
      successMessage.classList.add('alert', 'alert-success');
      successMessage.textContent = `Registration successful! Patron ID: ${resData.id}`; // Assuming the API returns an ID

      resultContainer.appendChild(successMessage);

      // Optionally clear form inputs after success
      form.reset();
    }
  } catch (err) {
    console.error(err.message);
    const errorMessageElement = document.createElement('div');
    errorMessageElement.classList.add('alert', 'alert-danger');
    errorMessageElement.textContent = 'An error occurred. Please try again later.';
    errorContainer.appendChild(errorMessageElement);
  }
});
