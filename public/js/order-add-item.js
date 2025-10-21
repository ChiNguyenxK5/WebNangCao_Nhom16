document.addEventListener('DOMContentLoaded', function(){
    const pizzaSelect = document.getElementById('add-pizza-id');
    const sizeSelect = document.getElementById('add-pizza-size');
    const qtyInput = document.getElementById('add-quantity');
    const priceEl = document.getElementById('add-item-price');

    function updatePrice(){
        if (!pizzaSelect) return;
        const price = Number(pizzaSelect.selectedOptions[0].dataset.price || 0);
        const size = sizeSelect.value;
        const qty = Number(qtyInput.value || 1);
        let unit = price;
        if (size === 'medium') unit = price * 1.2;
        else if (size === 'large') unit = price * 1.5;
        const total = Math.round(unit * qty);
        priceEl.textContent = total.toLocaleString('vi-VN') + '₫';
    }

    if (pizzaSelect) pizzaSelect.addEventListener('change', updatePrice);
    if (sizeSelect) sizeSelect.addEventListener('change', updatePrice);
    if (qtyInput) qtyInput.addEventListener('input', updatePrice);

    updatePrice();
});
