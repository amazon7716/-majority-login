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
      border-top-left-radius: 10px; /* Apply border-radius to top-left of flag container */
      border-bottom-left-radius: 10px; /* Apply border-radius to bottom-left of flag container */
    }

    .iti__tel-input {
      border: none !important;
      border-top-right-radius: 10px; /* Apply border-radius to top-right of input */
      border-bottom-right-radius: 10px; /* Apply border-radius to bottom-right of input */
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
    }

    /* Style for individual list items (countries) */
    .iti__country-list {
      padding: 0;
      margin: 0;
      list-style: none;
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
</script>

</body>
</html>