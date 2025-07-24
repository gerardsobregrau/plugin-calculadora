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
      <div id="hubspot-formulario"></div>

      <button type="button" class="cd-prev">Volver</button>
    </div>
  </div>
  <div class="cd-progress"><div class="cd-progress-bar"></div></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("cd-calc").addEventListener("click", function () {
    // Aquí se asume que el cálculo ya se hizo en js/scripts.js y los valores están actualizados

    if (typeof hbspt === "undefined") {
      let script = document.createElement("script");
      script.src = "https://js-eu1.hsforms.net/forms/v2.js";
      script.onload = loadHubspotForm;
      document.head.appendChild(script);
    } else {
      loadHubspotForm();
    }
  });

  function loadHubspotForm() {
    // Evitar carga duplicada
    if (document.querySelector("#hubspot-formulario iframe")) return;

    hbspt.forms.create({
      region: "eu1",
      portalId: "25029379",
      formId: "14cf8322-da79-4988-8631-56f6d7eca69f",
      target: "#hubspot-formulario",
      onFormReady: function($form) {
        const pagosActuales = document.getElementById("cd-pagos").value;
        const totalDeuda = document.getElementById("cd-total-pagar").innerText.replace(" €", "");
        const cuotaMensual = document.getElementById("cd-cuota").innerText.replace(" €", "");
        const plazoMeses = document.getElementById("cd-plazo").innerText;

        const resumen = `🧾 Datos calculadora:\n` +
                        `- Pagos actuales: ${pagosActuales}\n` +
                        `- Total deuda: ${totalDeuda}\n` +
                        `- Nueva cuota mensual: ${cuotaMensual}\n` +
                        `- Plazo en meses: ${plazoMeses}`;

        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "resumen_calculadora";  // nombre interno HubSpot
        input.value = resumen;

        $form[0].appendChild(input);
      }
    });
  }
});
</script>
