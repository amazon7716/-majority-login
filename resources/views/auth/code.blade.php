<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Verifica código</title>
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
    }
    .container {
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
    form > div.input-group {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin: 20px 0 10px;
    }
    input.code {
      flex: 1 1 50px;
      max-width: 65px;
      text-align: center;
      font-size: 26px;
      padding: 18px 0;
      border: none;
      border-radius: 12px;
      background-color: #f2f2f7; /* gris claro */
      box-shadow: inset 0 0 0 1px #d1d1d6; /* borde sutil gris */
      transition: box-shadow 0.2s ease-in-out;
      outline: none;
      font-weight: 600;
      color: #1c1c1e;
      user-select: none;
    }
    input.code:focus {
      box-shadow: inset 0 0 0 2px #6b46ff;
      background-color: #fff;
    }
    .resend-text {
      text-align: center;
      font-size: 14px;
      color: #9ca3af;
      margin-bottom: 20px;
    }
    .resend-text a {
      color: #6b46ff;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
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
    .progress-indicators {
      margin-bottom: 20px;  /* para separarlo del título */
      text-align: center;   /* centrar puntos */
    }
  </style>
</head>
<body>
  <form class="container" method="POST" action="{{ route('verificar.codigo') }}">
    @csrf

    <!-- Puntos de progreso arriba y centrados -->
    <div class="progress-indicators">
      <span class="circle active"></span>
      <span class="circle active"></span>
      <span class="circle"></span>
    </div>

    <h2>Ingresa el código</h2>
    <p>Enviado a {{ $telefono }}</p>

    {{-- CAMPO OCULTO PARA MANTENER EL TELÉFONO --}}
    <input type="hidden" name="telefono" value="{{ $telefono }}" />

    <div class="input-group">
      <input type="text" name="c1" maxlength="1" class="code" required />
      <input type="text" name="c2" maxlength="1" class="code" required />
      <input type="text" name="c3" maxlength="1" class="code" required />
      <input type="text" name="c4" maxlength="1" class="code" required />
    </div>

    <div style="font-size: 17px; color: #9ca3af; text-align: center; margin-top: 10px; word-break: break-word;">
      ¿No recibiste el código? 
      <a href="#" style="color: #6b46ff; text-decoration: none; font-weight: 600; white-space: normal; display: inline;">
        Reenviar<br>código
      </a>
    </div>

    <div style="text-align: left; margin-top: 40px;">
      <button type="submit" id="btnEnviar" style="padding: 14px 24px; border-radius: 40px; background: #6b46ff; color: white; border: none; font-size: 16px; cursor: pointer;">
        Continuar
      </button>
    </div>
  </form>
  
<script>
  const inputs = document.querySelectorAll('input.code');
  const btn = document.getElementById('btnEnviar');

  function checkInputs() {
    const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
    btn.disabled = !allFilled;

    if (btn.disabled) {
      btn.style.background = '#ccc'; // gris deshabilitado
      btn.style.cursor = 'not-allowed';
    } else {
      btn.style.background = '#6b46ff'; // morado habilitado
      btn.style.cursor = 'pointer';
    }
  }

  inputs.forEach((input, index) => {
    input.addEventListener('input', () => {
      if (input.value.length === input.maxLength) {
        // Mueve el foco al siguiente input si existe
        if (index + 1 < inputs.length) {
          inputs[index + 1].focus();
        }
      }
      checkInputs();
    });

    // También permite retroceder con la tecla Backspace para editar fácilmente
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
        inputs[index - 1].focus();
      }
    });
  });

  // Inicializar estado botón al cargar
  checkInputs();
</script>


</body>
</html>
