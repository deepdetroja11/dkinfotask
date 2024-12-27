document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.getElementById('itemsContainer');

    const addRow = () => {
        const rows = document.querySelectorAll('.item-row');
        const lastIndex = rows.length;
        $.ajax({
            url: routeInvoiceData,
            type: 'GET',
            data: {
                index: lastIndex
            },
            success: function(html) {
                itemsContainer.insertAdjacentHTML('beforeend', html);
            },
            error: function() {
                alert('Failed to load row. Please try again.');
            },
        });
    };

    const removeRow = (button) => {
        const row = button.closest('.item-row');
        if (row && itemsContainer.querySelectorAll('.item-row').length > 1) {
            const subtotalInput = row.querySelector('.subtotal-input');
            const subtotal = parseFloat(subtotalInput.value) || 0;
            const totalInput = document.querySelector('.total-input');
            const currentTotal = parseFloat(totalInput.value) || 0;

            totalInput.value = (currentTotal - subtotal).toFixed(2);
            row.remove();
        } else {
            alert('At least one row is required.');
        }
    };

    itemsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-row-btn')) {
            addRow();
        } else if (event.target.classList.contains('remove-row-btn')) {
            removeRow(event.target);
        }
    });
});
