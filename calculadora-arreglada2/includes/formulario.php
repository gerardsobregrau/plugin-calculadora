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
document.addEventListener("DOMContentLoaded", function () {
  // Función para intentar prellenar los campos
  function intentarPrellenar() {
    // Buscar el formulario HubSpot en el DOM
    const hubspotForm = document.querySelector("#hubspot-formulario form");
    
    if (hubspotForm) {
      // Si encontramos el formulario, agregar campos ocultos
      const pagosActuales = document.getElementById("cd-pagos").value;
      const totalDeuda = document.getElementById("cd-total-pagar").innerText.replace(" €", "");
      const cuotaMensual = document.getElementById("cd-cuota").innerText.replace(" €", "");
      const plazoMeses = document.getElementById("cd-plazo").innerText;
      
      // Crear y agregar campos ocultos
      const campos = [
        {name: 'pagos_mensuales_actuales', value: pagosActuales},
        {name: 'total_deuda', value: totalDeuda},
        {name: 'cuota_mensual', value: cuotaMensual},
        {name: 'plazo_meses', value: plazoMeses}
      ];
      
      campos.forEach(campo => {
        // Verificar si el campo ya existe
        let input = hubspotForm.querySelector(`input[name="${campo.name}"]`);
        if (!input) {
          // Si no existe, crearlo
          input = document.createElement('input');
          input.type = 'hidden';
          input.name = campo.name;
          hubspotForm.appendChild(input);
        }
        input.value = campo.value;
      });
      
      console.log('Campos prellenados correctamente');
    } else {
      // Si no encontramos el formulario, intentar de nuevo
      setTimeout(intentarPrellenar, 500);
    }
  }
  
  // Cargar el formulario cuando se hace clic en calcular
  document.getElementById("cd-calc").addEventListener("click", function () {
    setTimeout(intentarPrellenar, 1500);
  });
});
</script>