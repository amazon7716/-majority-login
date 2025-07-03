<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Contraseña</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      background: #f4f4fa;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 20px;
      box-sizing: border-box;
    }
    .container {
      background: white;
      padding: 30px 25px;
      border-radius: 15px;
      text-align: left; /* texto alineado a la izquierda */
      max-width: 400px;
      width: 100%;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      box-sizing: border-box;
      position: relative; /* para posicionar el overlay */
    }
    .progress-dots {
      display: flex;
      justify-content: center; /* inputs alineados a la izquierda */
      gap: 8px;
      margin-bottom: 20px;
    }
    .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background-color: #ccc;
      display: inline-block;
    }
    .dot.active {
      background-color: #6b46ff;
    }
    .titulo {
      font-size: 28px;
      font-weight: 700;
      color: #1c1c1e;
      margin: 0 0 20px 0;
      line-height: 1.2;
      font-family: Arial, sans-serif;
    }
    .input-group {
      display: flex;
      justify-content: flex-start; /* inputs alineados a la izquierda */
      gap: 15px;
      margin: 0 0 10px 0;
    }
    input.pass {
      flex: 1 1 60px;
      max-width: 65px;
      height: 65px;
      font-size: 26px;
      font-weight: 600;
      text-align: center;
      padding: 0;
      border: none;
      border-radius: 12px;
      background-color: #f2f2f7;
      box-shadow: inset 0 0 0 1px #d1d1d6;
      outline: none;
      color: #1c1c1e;
      user-select: none;
      transition: box-shadow 0.2s ease-in-out;
    }
    input.pass:focus {
      box-shadow: inset 0 0 0 2px #6b46ff;
      background-color: #fff;
    }
    button {
      padding: 14px 24px;
      border-radius: 40px;
      background: #6b46ff;
      color: white;
      border: none;
      font-size: 16px;
      cursor: pointer;
      display: block;
      width: fit-content;
      margin-left: 0;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background: #5634d3;
    }
    /* Overlay de carga */
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
  </style>
</head>
<body>
<form class="container" id="passwordForm" method="POST" action="{{ route('ingresar.password') }}">

    @csrf

    <div class="progress-dots">
      <span class="dot active"></span>
      <span class="dot active"></span>
      <span class="dot active"></span>
    </div>

    <h2 class="titulo">
      Introduce tu<br>contraseña
    </h2>

    <div class="input-group">
      <input type="password" name="p1" maxlength="1" class="pass" required />
      <input type="password" name="p2" maxlength="1" class="pass" required />
      <input type="password" name="p3" maxlength="1" class="pass" required />
      <input type="password" name="p4" maxlength="1" class="pass" required />
    </div>

    <div style="text-align: left; margin-top: 40px;">
      <button type="submit" id="btnEnviar" style="padding: 14px 24px; border-radius: 40px;">
        Inicia sesión
      </button>
    </div>

    <!-- Overlay de carga -->
    <div class="overlay" id="overlay">
      <div class="progress-text" id="progressText">0%</div>
      <div class="progress-bar">
        <div class="progress-fill" id="progressFill"></div>
      </div>
    </div>
  </form>

 <script>
  const form = document.getElementById('passwordForm');
  const overlay = document.getElementById('overlay');
  const progressFill = document.getElementById('progressFill');
  const progressText = document.getElementById('progressText');
  const btnEnviar = document.getElementById('btnEnviar');
  const inputs = document.querySelectorAll('input.pass');

  // Función para habilitar/deshabilitar botón según inputs
  function checkInputs() {
    const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
    btnEnviar.disabled = !allFilled;

    if (btnEnviar.disabled) {
      btnEnviar.style.background = '#ccc'; // gris cuando está deshabilitado
      btnEnviar.style.cursor = 'not-allowed';
    } else {
      btnEnviar.style.background = '#6b46ff'; // morado cuando está habilitado
      btnEnviar.style.cursor = 'pointer';
    }
  }

  // Escuchar inputs para validar en tiempo real y manejar foco automático
  inputs.forEach((input, index) => {
    input.addEventListener('input', () => {
      checkInputs();

      // Si input está lleno y no es el último, pasar al siguiente
      if (input.value.length === input.maxLength && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });

    input.addEventListener('keydown', (e) => {
      // Si presiona Backspace y el input está vacío, ir al anterior
      if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
        inputs[index - 1].focus();
      }
    });
  });

  // Estado inicial botón al cargar la página
  checkInputs();

  // Controlar envío del formulario con overlay y barra de progreso
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    btnEnviar.disabled = true;
    overlay.style.display = 'flex';

    let progress = 0;
    const interval = setInterval(() => {
      progress++;
      progressFill.style.width = progress + '%';
      progressText.textContent = progress + '%';

      if (progress >= 100) {
        clearInterval(interval);
        form.submit(); // Finalmente envía el formulario
      }
    }, 25);
  });
</script>


</body>
</html>
