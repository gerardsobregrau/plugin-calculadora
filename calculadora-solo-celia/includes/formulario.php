<div id="calculadora-celia" class="cc-wizard">
  <div class="cc-step-indicator">
    <div class="step-1 active">Pagos</div>
    <div class="step-2">Deudas</div>
    <div class="step-3">Ingresos</div>
    <div class="step-4">Resultado</div>
  </div>
  <div class="cc-steps">
    <div class="cc-step active" data-step="0">
      <label>¿Cuánto destina cada mes a pagar sus préstamos y tarjetas? (€)</label>
      <input type="range" id="cc-pagos" min="50" max="3000" step="1" value="300" oninput="document.getElementById('cc-pagos-value').innerText = this.value + ' €'">
      <div id="cc-pagos-value">300 €</div>
      <button type="button" class="cc-next">Siguiente</button>
    </div>
    <div class="cc-step" data-step="1">
      <div id="cc-deudas-container"></div>
      <button type="button" onclick="ccAddDeuda()">+ Añadir otra deuda</button><br>
      <button type="button" class="cc-prev">Volver</button>
      <button type="button" class="cc-next">Siguiente</button>
    </div>
    <div class="cc-step" data-step="2">
      <label>¿Cuáles son sus ingresos mensuales netos? (€)</label>
      <input type="number" id="cc-ingresos" min="0" required><br>
      <button type="button" class="cc-prev">Volver</button>
      <button type="button" id="cc-calc">Calcular</button>
    </div>
    <div class="cc-step" data-step="3">
      <div class="cc-result-final">
        Tu nueva mensualidad con DEBALIA: <span id="cc-cuota"></span> / mes
      </div>
      <p>Esto reemplaza todos los pagos de su préstamo y tarjeta existentes y será su nuevo pago mensual único.</p>
      <p>Total a pagar: <span id="cc-total-pagar"></span></p>
      <p>Plazo estimado: <span id="cc-plazo"></span> meses</p>

      <!-- Contenedor para el formulario HubSpot -->
      <div id="hubspot-formulario-celia">
        <script src="https://js-eu1.hsforms.net/forms/embed/25029379.js" defer></script>
        <div class="hs-form-frame" data-region="eu1" data-form-id="14cf8322-da79-4988-8631-56f6d7eca69f" data-portal-id="25029379"></div>
      </div>

      <button type="button" class="cc-prev">Volver</button>
    </div>
  </div>
  <div class="cc-progress"><div class="cc-progress-bar"></div></div>
</div>

<!-- Form previously loaded dynamically via hbspt.forms.create; we're now using the new HubSpot embed snippet above. -->
