document.addEventListener("DOMContentLoaded", function () {
  let currentStep = 0;
  const steps = document.querySelectorAll(".cd-step");
  const indicators = document.querySelectorAll(".cd-step-indicator div");
  const nextBtns = document.querySelectorAll(".cd-next");
  const prevBtns = document.querySelectorAll(".cd-prev");
  const progressBar = document.querySelector(".cd-progress-bar");

  function updateStep() {
    steps.forEach((step, i) => {
      step.classList.toggle("active", i === currentStep);
      indicators[i].classList.toggle("active", i === currentStep);
    });
    progressBar.style.width = ((currentStep) / (steps.length - 1)) * 100 + "%";
  }

  function validateStep(step) {
    if (step === 0) {
      return document.getElementById("cd-pagos").value >= 50;
    } else if (step === 1) {
      return document.querySelectorAll(".cd-deuda-bloque").length > 0;
    } else if (step === 2) {
      return document.getElementById("cd-ingresos").value.trim() !== "";
    }
    return true;
  }

  nextBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      if (validateStep(currentStep)) {
        currentStep++;
        updateStep();
      } else {
        alert("Por favor, rellena los campos requeridos antes de continuar.");
      }
    });
  });

  prevBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      if (currentStep > 0) {
        currentStep--;
        updateStep();
      }
    });
  });

  document.getElementById("cd-calc").addEventListener("click", () => {
    if (validateStep(currentStep)) {
      calcularResultado();
      currentStep++;
      updateStep();
    } else {
      alert("Por favor, introduce tus ingresos mensuales.");
    }
  });

  window.cdAddDeuda = function () {
    const container = document.getElementById("cd-deudas-container");
    const div = document.createElement("div");
    div.className = "cd-deuda-bloque";
    div.innerHTML = `
      <label>Importe de la deuda (€)</label>
      <input type="number" class="cd-deuda-importe" min="0" required>
      
      <label>Tipo de deuda</label>
      <select class="cd-deuda-tipo">
        <option value="Micros">Microcrédito</option>
        <option value="T.C.">Tarjeta de Crédito</option>
        <option value="Fondo deuda">Fondo deuda</option>
        <option value="L.C.">Línea de Crédito</option>
        <option value="Descubierto">Descubierto</option>
        <option value="P.P.">Préstamo Personal</option>
      </select>
      
      <label>¿Está en impago?</label>
      <select class="cd-deuda-impago">
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

    document.querySelectorAll(".cd-deuda-bloque").forEach(bloque => {
      const importe = parseFloat(bloque.querySelector(".cd-deuda-importe").value) || 0;
      const tipo = bloque.querySelector(".cd-deuda-tipo").value;
      const impago = bloque.querySelector(".cd-deuda-impago").value;

      let descuento = descuentos[tipo] || 0;

      let totalConDescuento = importe * (1 - descuento);

      if (impago === "Si") {
        totalConDescuento *= 1.005; // +0.5%
      } else {
        totalConDescuento *= 0.97; // -3%
      }

      totalFinal += totalConDescuento;
    });

    let plazo = 24;
    if (totalFinal > 5000 && totalFinal <= 15000) {
      plazo = 52;
    } else if (totalFinal > 15000) {
      plazo = 65;
    }

    const cuotaMin = 150 * 1.21; // mínimo 150€ + IVA
    let cuota = totalFinal / plazo;

    if (cuota < cuotaMin) {
      plazo = Math.ceil(totalFinal / cuotaMin);
      cuota = totalFinal / plazo;
    }

    document.getElementById("cd-total-pagar").innerText = totalFinal.toFixed(2) + " €";
    document.getElementById("cd-cuota").innerText = cuota.toFixed(2) + " €";
    document.getElementById("cd-plazo").innerText = plazo;
  }

  updateStep();
  cdAddDeuda();
});
