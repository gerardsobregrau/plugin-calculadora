document.addEventListener("DOMContentLoaded", function () {
  let currentStep = 0;
  const steps = document.querySelectorAll(".cc-step");
  const indicators = document.querySelectorAll(".cc-step-indicator div");
  const nextBtns = document.querySelectorAll(".cc-next");
  const prevBtns = document.querySelectorAll(".cc-prev");
  const progressBar = document.querySelector(".cc-progress-bar");

  function updateStep() {
    steps.forEach((step, i) => {
      step.classList.toggle("active", i === currentStep);
      indicators[i].classList.toggle("active", i === currentStep);
    });
    progressBar.style.width = ((currentStep) / (steps.length - 1)) * 100 + "%";
  }

  function validateStep(step) {
    if (step === 0) return document.getElementById("cc-pagos").value >= 50;
    if (step === 1) return document.querySelectorAll(".cc-deuda-bloque").length > 0;
    if (step === 2) return document.getElementById("cc-ingresos").value.trim() !== "";
    return true;
  }

  nextBtns.forEach(btn => btn.addEventListener("click", () => {
    if (validateStep(currentStep)) {
      currentStep++;
      updateStep();
    } else {
      alert("Por favor, rellena los campos requeridos antes de continuar.");
    }
  }));

  prevBtns.forEach(btn => btn.addEventListener("click", () => {
    if (currentStep > 0) {
      currentStep--;
      updateStep();
    }
  }));

  document.getElementById("cc-calc").addEventListener("click", function () {
    if (validateStep(currentStep)) {
      calcularResultado();
      currentStep++;
      updateStep();
    } else {
      alert("Por favor, introduce tus ingresos mensuales.");
    }
  });

  window.ccAddDeuda = function () {
    const container = document.getElementById("cc-deudas-container");
    const div = document.createElement("div");
    div.className = "cc-deuda-bloque";
    div.innerHTML = `
      <label>Importe de la deuda (€)</label>
      <input type="number" class="cc-deuda-importe" min="0" required>
      <label>Tipo de deuda</label>
      <select class="cc-deuda-tipo">
        <option value="Micros">Microcrédito</option>
        <option value="T.C.">Tarjeta de Crédito</option>
        <option value="Fondo deuda">Fondo deuda</option>
        <option value="L.C.">Línea de Crédito</option>
        <option value="Descubierto">Descubierto</option>
        <option value="P.P.">Préstamo Personal</option>
      </select>
      <label>¿Está en impago?</label>
      <select class="cc-deuda-impago">
        <option value="No">No</option>
        <option value="Si">Sí</option>
      </select>
    `;
    container.appendChild(div);
  };

  function calcularResultado() {
    const descuentos = {
      "Micros": 0.20,
      "T.C.": 0.06,
      "Fondo deuda": 0.33,
      "L.C.": 0.13,
      "Descubierto": -0.06,
      "P.P.": -0.07,
    };
    let totalFinal = 0;

      document.querySelectorAll(".cc-deuda-bloque").forEach(bloque => {
        const importe = parseFloat(bloque.querySelector(".cc-deuda-importe").value) || 0;
        const tipo = bloque.querySelector(".cc-deuda-tipo").value;
        const impago = bloque.querySelector(".cc-deuda-impago").value;
      let descuento = descuentos[tipo] || 0;
      let totalConDescuento = importe * (1 - descuento);
      totalConDescuento *= impago === "Si" ? 1.005 : 0.97;
      totalFinal += totalConDescuento;
    });

    let plazo = totalFinal > 15000 ? 65 : totalFinal > 5000 ? 52 : 24;
    const cuotaMin = 150 * 1.21;
    let cuota = totalFinal / plazo;
    if (cuota < cuotaMin) {
      plazo = Math.ceil(totalFinal / cuotaMin);
      cuota = totalFinal / plazo;
    }

    document.getElementById("cc-total-pagar").innerText = totalFinal.toFixed(2) + " €";
    document.getElementById("cc-cuota").innerText = cuota.toFixed(2) + " €";
    document.getElementById("cc-plazo").innerText = plazo;
  }

  // Widget previously created dynamically here; the form is now embedded via the HubSpot embed script in the template.

  updateStep();
  ccAddDeuda();
});
