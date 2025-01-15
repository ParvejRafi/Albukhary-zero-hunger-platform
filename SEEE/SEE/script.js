document.addEventListener("DOMContentLoaded", () => {
    const exchangeRates = {
        MYR: 1, // Base currency
        USD: 0.22,
        EUR: 0.20,
        GBP: 0.18,
    };

    // Update donation amounts based on selected currency
    function updateDonationAmounts(type) {
        const currencySelector = document.getElementById(
            type === 'monthly' ? 'currency-selector' : 'currency-selector-once'
        );
        const selectedCurrency = currencySelector.value;
        const donationOptions = document.querySelectorAll(
            type === 'monthly' ? '#monthly-donations .donation-button' : '#one-time-donations .donation-button'
        );

        donationOptions.forEach((button) => {
            const baseAmount = button.getAttribute('data-amount');
            if (baseAmount) {
                const convertedAmount = (baseAmount * exchangeRates[selectedCurrency]).toFixed(2);
                button.textContent = `${selectedCurrency} ${convertedAmount}`;
            } else {
                button.textContent = 'Other';
            }
        });
    }

    // Redirect user to payment page
    function redirectToPayment(amount, type) {
        if (amount === 'other') {
            const customAmount = prompt('Enter your donation amount:');
            if (!customAmount || isNaN(customAmount) || customAmount <= 0) {
                alert('Please enter a valid amount.');
                return;
            }
            amount = customAmount;
        }

        const currencySelector = document.getElementById(
            type === 'monthly' ? 'currency-selector' : 'currency-selector-once'
        );
        const selectedCurrency = currencySelector.value;

        // Debugging: Log the redirection URL
        console.log(`Redirecting to payment.html with amount: ${amount} and currency: ${selectedCurrency}`);
        alert(`Redirecting to payment.html?amount=${amount}&currency=${selectedCurrency}`);

        // Redirect to payment page
        window.location.href = `payment.html?amount=${amount}&currency=${selectedCurrency}&type=${type}`;
    }

    // Attach event listeners to donation buttons
    const donationButtons = document.querySelectorAll(".donation-button");
    donationButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const amount = button.getAttribute("data-amount") || 'other';
            const type = button.closest("#monthly-donations") ? 'monthly' : 'one-time';
            redirectToPayment(amount, type);
        });
    });

    // Attach onchange event to currency selectors
    document.getElementById("currency-selector").addEventListener("change", () => {
        updateDonationAmounts("monthly");
    });

    document.getElementById("currency-selector-once").addEventListener("change", () => {
        updateDonationAmounts("one-time");
    });
    function subscribeToNewsletter(event) {
        event.preventDefault(); // Prevent form submission
        const emailInput = document.getElementById("newsletter-email");
        const email = emailInput.value.trim();
    
        // Simulate a success message
        const messageDiv = document.getElementById("newsletter-message");
        messageDiv.textContent = `Thank you for subscribing! Updates will be sent to ${email}.`;
        messageDiv.classList.remove("hidden");
    
        // Clear the email input field
        emailInput.value = "";
    
        // Optional: Simulate sending data to the server
        console.log(`Subscribed email: ${email}`);
    }
   document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.dropdown > a').forEach((menu) => {
        menu.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent navigating the parent link
            const dropdownMenu = menu.nextElementSibling;

            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach((menu) => {
                if (menu !== dropdownMenu) {
                    menu.style.display = 'none';
                }
            });

            // Toggle the current dropdown
            dropdownMenu.style.display =
                dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach((menu) => {
                menu.style.display = 'none';
            });
        }
        
    });
   });
 
   
});

document.addEventListener('DOMContentLoaded', () => {
    const mealTableBody = document.getElementById('meal-table-body');
    const totalQuantityField = document.getElementById('total-quantity');
    const totalAmountField = document.getElementById('total-amount');

    // Function to update Subtotal for a row
    function updateSubtotal(row) {
        const quantityInput = row.querySelector('td:nth-child(4) input');
        const subtotalInput = row.querySelector('td:nth-child(5) input');
        const quantity = parseInt(quantityInput.value) || 0;

        // Assume each menu item costs RM 96 (change this value if needed)
        const pricePerItem = 96;
        const subtotal = quantity * pricePerItem;

        // Update Subtotal field
        subtotalInput.value = subtotal;

        // Update the overall totals
        updateTotals();
    }

    // Function to update Total Quantity and Total Amount
    function updateTotals() {
        let totalQuantity = 0;
        let totalAmount = 0;

        // Loop through all rows to calculate totals
        const rows = mealTableBody.querySelectorAll('tr');
        rows.forEach((row) => {
            const quantity = parseInt(row.querySelector('td:nth-child(4) input').value) || 0;
            const subtotal = parseInt(row.querySelector('td:nth-child(5) input').value) || 0;

            totalQuantity += quantity;
            totalAmount += subtotal;
        });

        // Update the total fields
        totalQuantityField.value = totalQuantity;
        totalAmountField.value = totalAmount;
    }

    // Event Listener: Add new rows dynamically
    document.getElementById('add-more-button').addEventListener('click', () => {
        const newRow = `
            <tr>
                <td><input type="date"></td>
                <td>
                    <select>
                        <option>Any Branch</option>
                        <option>Kuala Lumpur</option>
                        <option>Penang</option>
                        <option>Johor Bahru</option>
                        <option>Alor Setar</option>
                        <option>Albukhary Student</option>
                    </select>
                </td>
                <td>
                    <select>
                        <option>Rice, Chicken and Egg</option>
                        <option>Vegetarian Meal</option>
                        <option>Fish and Chips</option>
                    </select>
                </td>
                <td><input type="number" value="0" min="0"></td>
                <td><input type="number" value="0" readonly></td>
                <td><button class="delete-row">❌</button></td>
            </tr>
        `;

        mealTableBody.insertAdjacentHTML('beforeend', newRow);
    });

    // Event Listener: Update Subtotal and Totals on Quantity Change
    mealTableBody.addEventListener('input', (e) => {
        if (e.target.closest('tr') && e.target.type === 'number') {
            const row = e.target.closest('tr');
            updateSubtotal(row);
        }
    });

    // Event Listener: Delete a row
    mealTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('delete-row')) {
            const row = e.target.closest('tr');
            row.remove();
            updateTotals(); // Update totals after removing a row
        }
    });
});



/* billing */
document.addEventListener('DOMContentLoaded', () => {
    const totalAmountField = document.getElementById('total-amount');
    const donateNowButton = document.getElementById('donate-now-button');
    const billingSection = document.getElementById('billing-section');
    const billingAmount = document.getElementById('billing-amount');
    const confirmPaymentButton = document.getElementById('confirm-payment-button');

    // Show Billing Section when "Donate Now" is clicked
    donateNowButton.addEventListener('click', () => {
        const totalAmount = parseInt(totalAmountField.value) || 0;
        billingAmount.textContent = totalAmount; // Set billing amount
        billingSection.style.display = 'block'; // Show billing section
    });

    // Handle Confirm Payment Button Click
    confirmPaymentButton.addEventListener('click', () => {
        const selectedPaymentMethod = document.getElementById('payment-method').value;
        alert(`Payment of RM ${billingAmount.textContent} confirmed via ${selectedPaymentMethod}!`);
        billingSection.style.display = 'none'; // Hide billing section after payment
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const provideInfoCheckbox = document.getElementById('provide-info');
    const userInfoForm = document.getElementById('user-info-form');
    const userForm = document.getElementById('user-form');

    // Show or hide the user information form when the checkbox is clicked
    provideInfoCheckbox.addEventListener('change', () => {
        if (provideInfoCheckbox.checked) {
            userInfoForm.style.display = 'block'; // Show the form
        } else {
            userInfoForm.style.display = 'none'; // Hide the form
        }
    });

    // Handle form submission
    userForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent page reload
        const userName = document.getElementById('user-name').value;
        const userEmail = document.getElementById('user-email').value;
        const userContact = document.getElementById('user-contact').value;

        alert(`Information Submitted:
Name: ${userName}
Email: ${userEmail}
Contact Number: ${userContact}`);
        // Hide the form after submission
        userInfoForm.style.display = 'none';
        provideInfoCheckbox.checked = false; // Uncheck the checkbox
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const mealTableBody = document.getElementById("meal-table-body");
    const totalQuantityInput = document.getElementById("total-quantity");
    const totalAmountInput = document.getElementById("total-amount");

    // Function to update rows based on total inputs
    function updateRowsFromTotals() {
        const totalQuantity = parseInt(totalQuantityInput.value) || 0;
        const totalAmount = parseInt(totalAmountInput.value) || 0;

        const rows = mealTableBody.querySelectorAll("tr");
        const rowCount = rows.length;

        if (rowCount === 0) return;

        const averageQuantity = Math.floor(totalQuantity / rowCount);
        const averageAmount = Math.floor(totalAmount / rowCount);

        let remainingQuantity = totalQuantity;
        let remainingAmount = totalAmount;

        rows.forEach((row, index) => {
            const quantityInput = row.querySelector("input[name='quantity']");
            const subTotalInput = row.querySelector("input[name='sub_total']");

            if (index === rowCount - 1) {
                // Allocate remaining to the last row
                quantityInput.value = remainingQuantity;
                subTotalInput.value = remainingAmount;
            } else {
                quantityInput.value = averageQuantity;
                subTotalInput.value = averageAmount;

                remainingQuantity -= averageQuantity;
                remainingAmount -= averageAmount;
            }
        });
    }

    // Function to update totals based on rows
    function updateTotalsFromRows() {
        let totalQuantity = 0;
        let totalAmount = 0;

        const rows = mealTableBody.querySelectorAll("tr");
        rows.forEach((row) => {
            const quantityInput = row.querySelector("input[name='quantity']");
            const subTotalInput = row.querySelector("input[name='sub_total']");

            const quantity = parseInt(quantityInput.value) || 0;
            const subTotal = parseInt(subTotalInput.value) || 0;

            totalQuantity += quantity;
            totalAmount += subTotal;
        });

        totalQuantityInput.value = totalQuantity;
        totalAmountInput.value = totalAmount;
    }

    // Listen for changes in the total inputs
    totalQuantityInput.addEventListener("input", updateRowsFromTotals);
    totalAmountInput.addEventListener("input", updateRowsFromTotals);

    // Listen for changes in the table rows
    mealTableBody.addEventListener("input", function (e) {
        if (e.target.name === "quantity" || e.target.name === "sub_total") {
            updateTotalsFromRows();
        }
    });

    // Listen for delete button clicks
    mealTableBody.addEventListener("click", function (e) {
        if (e.target.classList.contains("delete-row")) {
            e.target.closest("tr").remove();
            updateTotalsFromRows();
        }
    });

    // Initial update of totals
    updateTotalsFromRows();
});
