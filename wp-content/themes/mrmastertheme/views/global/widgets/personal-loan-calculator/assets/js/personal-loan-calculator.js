(function () {
    'use strict';

    // Only run on pages that have Gravity Form #5
    var form = document.getElementById('gform_5');

    if (!form) return;

    // ── Completely disable Gravity Forms submission for this form ──

    // 1. Remove the form action & target so it can't POST anywhere
    form.removeAttribute('action');
    form.removeAttribute('target');

    // 2. Neutralize the submit button: strip inline onclick, change type to "button"
    var submitBtn = document.getElementById('gform_submit_button_5');
    if (submitBtn) {
        submitBtn.removeAttribute('onclick');
        submitBtn.setAttribute('type', 'button');
        submitBtn.removeAttribute('data-submission-type');
    }

    // 3. Remove the GF Ajax iframe so it can't receive a response
    var ajaxFrame = document.getElementById('gform_ajax_frame_5');
    if (ajaxFrame) ajaxFrame.remove();

    // 4. Remove the hidden gform_ajax input so GF doesn't think this is an Ajax form
    var ajaxInput = form.querySelector('input[name="gform_ajax"]');
    if (ajaxInput) ajaxInput.remove();

    // 5. Block any remaining submit attempts on the form itself
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        return false;
    }, true); // capture phase to fire before anything else

    // Cache field references
    var fields = {
        borrowedAmount: document.getElementById('input_5_23'),
        downPayment:    document.getElementById('input_5_24'),
        loanTerm:       document.getElementById('input_5_11'),
        interestRate:   document.getElementById('input_5_27')
    };

    // Build the results container and insert it after the form wrapper
    var resultsContainer = document.createElement('div');
    resultsContainer.id = 'personal-loan-results';
    resultsContainer.className = 'loan-calculator-results';
    resultsContainer.setAttribute('aria-live', 'polite');
    resultsContainer.style.display = 'none';

    resultsContainer.innerHTML =
        '<h3 class="results-heading">Your Estimated Loan Details</h3>' +
        '<div class="results-grid">' +
            '<div class="result-item">' +
                '<span class="result-label">Estimated Loan Amount</span>' +
                '<span class="result-value" id="result-personal-loan-amount">--</span>' +
            '</div>' +
            '<div class="result-item">' +
                '<span class="result-label">Monthly Payment</span>' +
                '<span class="result-value" id="result-personal-monthly-payment">--</span>' +
            '</div>' +
            '<div class="result-item">' +
                '<span class="result-label">Total Interest Paid</span>' +
                '<span class="result-value" id="result-personal-total-interest">--</span>' +
            '</div>' +
            '<div class="result-item">' +
                '<span class="result-label">Total Cost of Loan</span>' +
                '<span class="result-value" id="result-personal-total-cost">--</span>' +
            '</div>' +
        '</div>' +
        '<p class="results-disclaimer">* This is an estimate for informational purposes only. Actual loan terms may vary.</p>';

    var wrapper = document.getElementById('gform_wrapper_5');
    if (wrapper && wrapper.parentNode) {
        wrapper.parentNode.insertBefore(resultsContainer, wrapper.nextSibling);
    }

    // Helper: parse a number from an input value (strip $ , etc.)
    function parseNum(el) {
        if (!el) return 0;
        var raw = el.value.replace(/[^0-9.\-]/g, '');
        var num = parseFloat(raw);
        return isNaN(num) ? 0 : num;
    }

    // Helper: extract the numeric month count from the select value ("36 months" → 36)
    function parseTerm(el) {
        if (!el || !el.value) return 0;
        var match = el.value.match(/(\d+)/);
        return match ? parseInt(match[1], 10) : 0;
    }

    // Format a number as USD currency
    function formatCurrency(n) {
        return '$' + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    // Simple validation — returns an error message string or null
    function validate() {
        if (parseNum(fields.borrowedAmount) <= 0) return 'Please enter a valid Borrowed Amount.';
        if (parseTerm(fields.loanTerm) === 0)     return 'Please select a Loan Term.';
        if (parseNum(fields.interestRate) < 0)    return 'Interest Rate cannot be negative.';
        return null;
    }

    // Core calculation
    function calculate() {
        var error = validate();
        if (error) {
            showError(error);
            return;
        }

        var borrowedAmount = parseNum(fields.borrowedAmount);
        var downPayment    = parseNum(fields.downPayment);
        var rate           = parseNum(fields.interestRate);
        var termMonths     = parseTerm(fields.loanTerm);

        // Total loan amount
        var loanAmount = borrowedAmount - downPayment;

        // Guard against negative loan amount
        if (loanAmount <= 0) {
            showError('Your down payment exceeds the borrowed amount. No loan is needed!');
            return;
        }

        var monthlyPayment, totalCost, totalInterest;

        if (rate === 0) {
            // 0 % interest — simple division
            monthlyPayment = loanAmount / termMonths;
            totalCost      = loanAmount;
            totalInterest  = 0;
        } else {
            // Standard amortization formula: M = P * [r(1+r)^n] / [(1+r)^n - 1]
            var monthlyRate = (rate / 100) / 12;
            var factor      = Math.pow(1 + monthlyRate, termMonths);
            monthlyPayment  = loanAmount * (monthlyRate * factor) / (factor - 1);
            totalCost       = monthlyPayment * termMonths;
            totalInterest   = totalCost - loanAmount;
        }

        // Populate results
        document.getElementById('result-personal-loan-amount').textContent    = formatCurrency(loanAmount);
        document.getElementById('result-personal-monthly-payment').textContent = formatCurrency(monthlyPayment);
        document.getElementById('result-personal-total-interest').textContent  = formatCurrency(totalInterest);
        document.getElementById('result-personal-total-cost').textContent      = formatCurrency(totalCost);

        // Remove any previous error and show the results
        var existingError = resultsContainer.querySelector('.results-error');
        if (existingError) existingError.remove();
        resultsContainer.style.display = 'block';
        resultsContainer.querySelector('.results-heading').style.display = '';
        resultsContainer.querySelector('.results-grid').style.display = '';
        resultsContainer.querySelector('.results-disclaimer').style.display = '';

        // Smooth-scroll into view
        resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function showError(msg) {
        // Hide result rows but keep container visible for the error
        resultsContainer.style.display = 'block';
        resultsContainer.querySelector('.results-heading').style.display = 'none';
        resultsContainer.querySelector('.results-grid').style.display = 'none';
        resultsContainer.querySelector('.results-disclaimer').style.display = 'none';

        var existingError = resultsContainer.querySelector('.results-error');
        if (existingError) existingError.remove();

        var errorEl = document.createElement('p');
        errorEl.className = 'results-error';
        errorEl.textContent = msg;
        resultsContainer.prepend(errorEl);

        resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Bind calculate to the (now type="button") submit button
    if (submitBtn) {
        submitBtn.addEventListener('click', function () {
            calculate();
        });
    }
})();
