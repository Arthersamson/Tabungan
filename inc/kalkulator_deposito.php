<style>
  /* ================================
     DEPOSITO OVERLAY
  ================================= */
  #depositoOverlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    padding: 24px;
    overflow-y: auto;

    background: rgba(0, 0, 0, 0.68);
    backdrop-filter: blur(7px);
    -webkit-backdrop-filter: blur(7px);
  }

  #depositoOverlay.open {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* ================================
     MODAL
  ================================= */
  .deposito-modal {
    width: min(1050px, 100%);
    max-height: calc(100vh - 48px);
    overflow: auto;

    background: #fff;
    border-radius: 18px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.45);

    font-family: Arial, sans-serif;
  }

  /* ================================
     HEADER
  ================================= */
  .deposito-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    padding: 18px 22px;

    color: #fff;
    background: #0b2545;
  }

  .deposito-head-title {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .deposito-icon {
    padding: 10px 12px;
    border-radius: 10px;
    background: #ee6c4d;
  }

  .deposito-head h3 {
    margin: 0;
    font-size: 18px;
  }

  .deposito-head small {
    color: #cbd5e1;
  }

  .deposito-close {
    width: 38px;
    height: 38px;

    border: 0;
    border-radius: 9px;

    color: #fff;
    background: rgba(255, 255, 255, 0.12);

    font-size: 20px;
    cursor: pointer;
  }

  .deposito-close:hover {
    background: #dc3545;
  }

  /* ================================
     MAIN GRID
  ================================= */
  .deposito-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
  }

  .deposito-panel {
    padding: 26px;
  }

  .deposito-result {
    border-left: 1px solid #e5e7eb;
    background: #f8fafc;
  }

  /* ================================
     FORM
  ================================= */
  .deposito-row {
    margin-bottom: 20px;
  }

  .deposito-label {
    display: block;
    margin-bottom: 7px;

    color: #475569;

    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
  }

  .deposito-input {
    box-sizing: border-box;
    width: 100%;
    padding: 12px;

    border: 1px solid #cbd5e1;
    border-radius: 10px;
    outline: none;

    font-size: 18px;
    font-weight: 700;
  }

  .deposito-input:focus {
    border-color: #134074;
    box-shadow: 0 0 0 3px rgba(19, 64, 116, 0.12);
  }

  /* ================================
     QUICK NOMINAL BUTTON
  ================================= */
  .deposito-quick {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;

    margin-top: 8px;
  }

  .deposito-quick button {
    padding: 7px 10px;

    border: 0;
    border-radius: 8px;

    color: #334155;
    background: #e2e8f0;

    cursor: pointer;
  }

  .deposito-quick button:hover {
    color: #fff;
    background: #0b2545;
  }

  /* ================================
     TENOR BUTTON
  ================================= */
  .deposito-tenor {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
  }

  .deposito-tenor button {
    flex: 1;
    min-width: 60px;
    padding: 9px;

    border: 1px solid #cbd5e1;
    border-radius: 8px;

    background: #fff;

    cursor: pointer;
  }

  .deposito-tenor button.active {
    color: #fff;
    border-color: #0b2545;
    background: #0b2545;
  }

  /* ================================
     TAX CHECKBOX
  ================================= */
  .deposito-check {
    display: flex;
    align-items: center;
    gap: 8px;

    color: #475569;
    font-size: 13px;
  }

  /* ================================
     RESULT CARD
  ================================= */
  .deposito-main-card {
    margin-bottom: 18px;
    padding: 20px;

    border-radius: 14px;

    color: #fff;
    background: linear-gradient(135deg, #0b2545, #134074);
  }

  .deposito-main-card small {
    color: #cbd5e1;
  }

  .deposito-total {
    margin: 5px 0 12px;

    color: #fcd34d;

    font-size: 30px;
    font-weight: 800;
  }

  .deposito-two {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .deposito-stat {
    padding: 12px;

    border: 1px solid #e2e8f0;
    border-radius: 10px;

    background: #fff;
  }

  .deposito-stat span {
    display: block;

    color: #64748b;

    font-size: 11px;
  }

  .deposito-stat strong {
    display: block;
    margin-top: 4px;

    color: #0f172a;
  }

  /* ================================
     CHART
  ================================= */
  .deposito-chart {
    height: 180px;
    margin-top: 15px;
  }

  /* ================================
     FOOTER
  ================================= */
  .deposito-foot {
    padding: 0 26px 22px;

    text-align: right;
  }

  .deposito-reset {
    padding: 10px 16px;

    border: 0;
    border-radius: 9px;

    color: #334155;
    background: #e2e8f0;

    cursor: pointer;
  }

  .deposito-reset:hover {
    background: #cbd5e1;
  }

  /* ================================
     RESPONSIVE
  ================================= */
  @media (max-width: 768px) {
    #depositoOverlay {
      padding: 10px;
    }

    .deposito-modal {
      max-height: calc(100vh - 20px);
    }

    .deposito-grid {
      grid-template-columns: 1fr;
    }

    .deposito-result {
      border-top: 1px solid #e5e7eb;
      border-left: 0;
    }

    .deposito-panel {
      padding: 18px;
    }

    .deposito-foot {
      padding: 0 18px 18px;
    }
  }
</style>


<!-- ================================
     DEPOSITO CALCULATOR
================================= -->
<div
  id="depositoOverlay"
  aria-hidden="true"
  onclick="if(event.target === this) closeDepositCalculator()"
>
  <div
    class="deposito-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="depositoTitle"
  >

    <!-- HEADER -->
    <div class="deposito-head">

      <div class="deposito-head-title">
        <div class="deposito-icon">
          <i class="fas fa-calculator"></i>
        </div>

        <div>
          <h3 id="depositoTitle">
            Simulasi Kalkulator Deposito
          </h3>

          <small>
            Hitung estimasi imbal hasil deposito Anda
          </small>
        </div>
      </div>

      <button
        class="deposito-close"
        type="button"
        onclick="closeDepositCalculator()"
        aria-label="Tutup"
      >
        &times;
      </button>

    </div>


    <!-- CONTENT -->
    <div class="deposito-grid">

      <!-- INPUT PANEL -->
      <div class="deposito-panel">

        <!-- NOMINAL -->
        <div class="deposito-row">

          <label class="deposito-label">
            Nominal Deposito
          </label>

          <input
            id="depNominalDisplay"
            class="deposito-input"
            value="100.000.000"
            inputmode="numeric"
            oninput="depNominalInput(this)"
          >

          <input
            id="depNominal"
            type="hidden"
            value="100000000"
          >

          <div class="deposito-quick">

            <button
              type="button"
              onclick="depSetNominal(10000000)"
            >
              10 Juta
            </button>

            <button
              type="button"
              onclick="depSetNominal(50000000)"
            >
              50 Juta
            </button>

            <button
              type="button"
              onclick="depSetNominal(100000000)"
            >
              100 Juta
            </button>

            <button
              type="button"
              onclick="depSetNominal(500000000)"
            >
              500 Juta
            </button>

          </div>
        </div>


        <!-- TENOR -->
        <div class="deposito-row">

          <label class="deposito-label">
            Jangka Waktu
          </label>

          <div class="deposito-tenor">

            <button
              type="button"
              onclick="depSetTenor(1,this)"
            >
              1 Bln
            </button>

            <button
              type="button"
              onclick="depSetTenor(3,this)"
            >
              3 Bln
            </button>

            <button
              type="button"
              onclick="depSetTenor(6,this)"
            >
              6 Bln
            </button>

            <button
              type="button"
              onclick="depSetTenor(12,this)"
              class="active"
            >
              12 Bln
            </button>

          </div>

          <input
            id="depTenor"
            type="hidden"
            value="12"
          >

        </div>


        <!-- SUKU BUNGA -->
        <div class="deposito-row">

          <label class="deposito-label">
            Suku Bunga per Tahun (%)
          </label>

          <input
            id="depRate"
            class="deposito-input"
            type="number"
            step="0.01"
            value="6.75"
            min="0"
            oninput="calculateDepositWidget()"
          >

        </div>


        <!-- PAJAK -->
        <label class="deposito-check">

          <input
            id="depTax"
            type="checkbox"
            checked
            onchange="calculateDepositWidget()"
          >

          Terapkan pajak bunga 20%
          (untuk nominal &gt; Rp7.500.000)

        </label>

      </div>


      <!-- RESULT PANEL -->
      <div class="deposito-panel deposito-result">

        <!-- TOTAL -->
        <div class="deposito-main-card">

          <small>
            TOTAL PENGEMBALIAN SAAT JATUH TEMPO
          </small>

          <div
            class="deposito-total"
            id="depTotal"
          >
            Rp 0
          </div>

          <div
            style="
              display:flex;
              justify-content:space-between;
              font-size:12px;
            "
          >

            <span>Pokok</span>

            <strong id="depPrincipal">
              Rp 0
            </strong>

            <span>Bunga Nett</span>

            <strong id="depNet">
              Rp 0
            </strong>

          </div>

        </div>


        <!-- STATISTICS -->
        <div class="deposito-two">

          <div class="deposito-stat">
            <span>Bunga Kotor</span>

            <strong id="depGross">
              Rp 0
            </strong>
          </div>


          <div class="deposito-stat">
            <span>Pajak</span>

            <strong id="depTaxValue">
              Rp 0
            </strong>
          </div>


          <div class="deposito-stat">
            <span>Bunga Bersih / Bulan</span>

            <strong id="depMonthly">
              Rp 0
            </strong>
          </div>


          <div class="deposito-stat">
            <span>Tenor</span>

            <strong id="depTenorText">
              12 Bulan
            </strong>
          </div>

        </div>


        <!-- CHART -->
        <div class="deposito-chart">
          <canvas id="depositChartWidget"></canvas>
        </div>

      </div>

    </div>


    <!-- FOOTER -->
    <div class="deposito-foot">

      <button
        type="button"
        class="deposito-reset"
        onclick="resetDepositCalculator()"
      >
        <i class="fas fa-rotate-left"></i>
        Reset
      </button>

    </div>

  </div>
</div>


<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
  (function () {

    let depChart = null;


    const rp = n =>
      new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
      })
        .format(n || 0)
        .replace('IDR', 'Rp');


    window.openDepositCalculator = function () {

      const overlay =
        document.getElementById('depositoOverlay');

      overlay.classList.add('open');
      overlay.setAttribute('aria-hidden', 'false');

      document.body.style.overflow = 'hidden';

      calculateDepositWidget();
    };

    window.closeDepositCalculator = function () {

      const overlay =
        document.getElementById('depositoOverlay');

      overlay.classList.remove('open');
      overlay.setAttribute('aria-hidden', 'true');

      document.body.style.overflow = '';
    };

    window.depSetNominal = function (n) {

      document.getElementById('depNominal').value = n;

      document.getElementById('depNominalDisplay').value =
        n.toLocaleString('id-ID');

      calculateDepositWidget();
    };

    window.depNominalInput = function (el) {

      const n =
        parseInt(
          (el.value || '').replace(/\D/g, ''),
          10
        ) || 0;

      el.value = n.toLocaleString('id-ID');

      document.getElementById('depNominal').value = n;

      calculateDepositWidget();
    };


    window.depSetTenor = function (n, btn) {

      document.getElementById('depTenor').value = n;

      document
        .querySelectorAll('.deposito-tenor button')
        .forEach(b => b.classList.remove('active'));

      btn.classList.add('active');

      calculateDepositWidget();
    };


    window.calculateDepositWidget = function () {

      const nominal =
        Number(
          document.getElementById('depNominal').value
        ) || 0;

      const tenor =
        Number(
          document.getElementById('depTenor').value
        ) || 12;

      const rate =
        Number(
          document.getElementById('depRate').value
        ) || 0;

      const taxOn =
        document.getElementById('depTax').checked;


     
      const grossMonth =
          nominal * (rate / 100) * 30 / 365;

      
      const gross =
          grossMonth * tenor;


      const tax =
          (taxOn && nominal > 7500000)
              ? gross * 0.20
              : 0;


      const net =
          gross - tax;


      const total =
          nominal + net;



      document.getElementById('depTotal').textContent =
        rp(total);

      document.getElementById('depPrincipal').textContent =
        rp(nominal);

      document.getElementById('depNet').textContent =
        rp(net);

      document.getElementById('depGross').textContent =
        rp(gross);

      document.getElementById('depTaxValue').textContent =
        rp(tax);

      document.getElementById('depMonthly').textContent =
        rp(grossMonth - (tax / tenor));

      document.getElementById('depTenorText').textContent =
        tenor + ' Bulan';

      if (typeof Chart !== 'undefined') {

        const ctx =
          document
            .getElementById('depositChartWidget')
            .getContext('2d');


        if (depChart) {
          depChart.destroy();
        }


        depChart = new Chart(ctx, {

          type: 'doughnut',

          data: {
            labels: [
              'Pokok',
              'Bunga Bersih'
            ],

            datasets: [
              {
                data: [
                  nominal,
                  net
                ],

                backgroundColor: [
                  '#0B2545',
                  '#10B981'
                ],

                borderWidth: 2,
                borderColor: '#fff'
              }
            ]
          },

          options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
              legend: {
                position: 'bottom'
              }
            },

            cutout: '70%'
          }

        });
      }
    };


    window.resetDepositCalculator = function () {

      depSetNominal(100000000);

      document.getElementById('depRate').value =
        '6.75';

      document.getElementById('depTax').checked =
        true;

      document.getElementById('depTenor').value =
        '12';


      document
        .querySelectorAll('.deposito-tenor button')
        .forEach(b => b.classList.remove('active'));


      document
        .querySelectorAll('.deposito-tenor button')[3]
        .classList.add('active');


      calculateDepositWidget();
    };


    document.addEventListener('keydown', function (e) {

      if (e.key === 'Escape') {
        closeDepositCalculator();
      }

    });

  })();
</script>
