/**
 * Solar designer state.
 *
 * Yields are Google's own per-panel figures, so totals are the sum of the
 * panels actually selected rather than a linear scaling of the maximum.
 * Panels arrive sorted best-first, which is why a system of N is the first N.
 */
window.solarDesigner = function (config = {}) {
    return {
        panels: config.initialPanels || 1,

        /** Per-panel annual kWh, best first. */
        yields: config.yields || [],

        panelWatts: config.panelWatts || 400,
        tariff: config.tariff || 12,
        co2Factor: config.co2Factor || 0.7,
        costPerKw: config.costPerKw || 55000,

        /** Modelled seasonal weights, already normalised server-side. */
        monthlyWeights: config.monthlyWeights || [],

        get systemKw() {
            return (this.panels * this.panelWatts) / 1000;
        },

        get annualKwh() {
            let total = 0;

            for (let i = 0; i < this.panels && i < this.yields.length; i++) {
                total += this.yields[i];
            }

            return total;
        },

        get monthlyKwh() {
            return this.annualKwh / 12;
        },

        get annualSavings() {
            return this.annualKwh * this.tariff;
        },

        get co2Tonnes() {
            return (this.annualKwh * this.co2Factor) / 1000;
        },

        get installCost() {
            return this.systemKw * this.costPerKw;
        },

        get paybackYears() {
            return this.annualSavings > 0 ? this.installCost / this.annualSavings : null;
        },

        /** Monthly kWh for the bar chart. */
        get monthly() {
            return this.monthlyWeights.map((month) => ({
                label: month.label,
                value: this.annualKwh * month.weight,
            }));
        },

        get monthlyPeak() {
            return Math.max(...this.monthly.map((m) => m.value), 1);
        },

        barHeight(value) {
            return Math.max((value / this.monthlyPeak) * 100, 2) + '%';
        },

        // ── formatting ───────────────────────────────────────────────

        get formattedKw() {
            return this.systemKw.toFixed(2);
        },

        get formattedAnnual() {
            return Math.round(this.annualKwh).toLocaleString();
        },

        get formattedMonthly() {
            return Math.round(this.monthlyKwh).toLocaleString();
        },

        get formattedSavings() {
            return '₱' + Math.round(this.annualSavings).toLocaleString();
        },

        get formattedCost() {
            return '₱' + Math.round(this.installCost).toLocaleString();
        },

        get formattedPayback() {
            return this.paybackYears ? this.paybackYears.toFixed(1) + ' yrs' : '—';
        },

        get formattedCo2() {
            return this.co2Tonnes.toFixed(1) + ' t';
        },

        money(value) {
            return Math.round(value).toLocaleString();
        },
    };
};
