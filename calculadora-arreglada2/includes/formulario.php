<div id="calculadora-deudas" class="cd-wizard">
  <div class="cd-step-indicator">
    <div class="step-1 active">Pagos</div>
    <div class="step-2">Deudas</div>
    <div class="step-3">Ingresos</div>
    <div class="step-4">Resultado</div>
  </div>
  <div class="cd-steps">
    <div class="cd-step active" data-step="0">
      <label>¿Cuánto destina cada mes a pagar sus préstamos y tarjetas? (€)</label>
      <input type="range" id="cd-pagos" min="50" max="3000" step="1" value="300" oninput="document.getElementById('cd-pagos-value').innerText = this.value + ' €'">
      <div id="cd-pagos-value">300 €</div>
      <button type="button" class="cd-next">Siguiente</button>
    </div>
    <div class="cd-step" data-step="1">
      <div id="cd-deudas-container"></div>
      <button type="button" onclick="cdAddDeuda()">+ Añadir otra deuda</button><br>
      <button type="button" class="cd-prev">Volver</button>
      <button type="button" class="cd-next">Siguiente</button>
    </div>
    <div class="cd-step" data-step="2">
      <label>¿Cuáles son sus ingresos mensuales netos? (€)</label>
      <input type="number" id="cd-ingresos" min="0" required><br>
      <button type="button" class="cd-prev">Volver</button>
      <button type="button" id="cd-calc">Calcular</button>
    </div>
    <div class="cd-step" data-step="3">
      <div class="cd-result-final">
        Tu nueva mensualidad con DEBALIA: <span id="cd-cuota"></span> / mes
      </div>
      <p>Esto reemplaza todos los pagos de su préstamo y tarjeta existentes y será su nuevo pago mensual único.</p>
      <p>Total a pagar: <span id="cd-total-pagar"></span></p>
      <p>Plazo estimado: <span id="cd-plazo"></span> meses</p>

      <!-- Contenedor para el formulario HubSpot -->
      <div id="hubspot-formulario" class="hs-form-frame" 
           data-region="eu1" 
           data-form-id="14cf8322-da79-4988-8631-56f6d7eca69f" 
           data-portal-id="25029379"></div>

      <button type="button" class="cd-prev">Volver</button>
    </div>
  </div>
  <div class="cd-progress"><div class="cd-progress-bar"></div></div>
</div>

<!-- Script oficial de HubSpot para incrustar formularios -->
<script src="https://js-eu1.hsforms.net/forms/embed/25029379.js" defer></script>

<script>
  // Función para rellenar campos ocultos dentro del iframe de HubSpot
  function prellenarCampos() {
    const iframe = document.querySelector("#hubspot-formulario iframe");
    if (!iframe) {
      // Si aún no está cargado, prueba otra vez en 300ms
      setTimeout(prellenarCampos, 300);
      return;
    }

    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

    function rellenarCampo(name, value) {
      const input = iframeDoc.querySelector(`input[name="${name}"]`);
      if (input) input.value = value;
    }

    rellenarCampo('pagos_mensuales_actuales', document.getElementById("cd-pagos").value);
    rellenarCampo('total_deuda', document.getElementById("cd-total-pagar").innerText.replace(" €", ""));
    rellenarCampo('cuota_mensual', document.getElementById("cd-cuota").innerText.replace(" €", ""));
    rellenarCampo('plazo_meses', document.getElementById("cd-plazo").innerText);
  }

  document.addEventListener("DOMContentLoaded", function () {
    // Cuando pulses el botón calcular, luego espera y rellena el formulario
    document.getElementById("cd-calc").addEventListener("click", function () {
      setTimeout(prellenarCampos, 1000);
    });
  });
</script>