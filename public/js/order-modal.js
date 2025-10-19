document.addEventListener('DOMContentLoaded', function () {
    function closeModal() {
        var modal = document.getElementById('order-modal');
        if (modal) modal.style.display = 'none';
    }

    document.querySelectorAll('.btn-book').forEach(function(btn){
        btn.addEventListener('click', function(){
            var id = this.dataset.pizzaId;
            var name = this.dataset.pizzaName;
            var price = this.dataset.pizzaPrice;
            var image = this.dataset.pizzaImage;

            var inputId = document.getElementById('modal-pizza-id');
            var nameEl = document.getElementById('modal-pizza-name');
            var priceEl = document.getElementById('modal-pizza-price');
            var imgEl = document.getElementById('modal-pizza-image');

            if (inputId) inputId.value = id;
            if (nameEl) nameEl.textContent = name;
            if (priceEl) priceEl.textContent = Number(price).toLocaleString() + ' VND';
            if (imgEl) imgEl.src = image;

            var modal = document.getElementById('order-modal');
            if (modal) {
                modal.style.display = 'flex';
                modal.scrollIntoView({behavior: 'smooth'});
            }
        });
    });

    var closeBtn = document.getElementById('order-modal-close');
    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    var cancelBtn = document.getElementById('order-modal-cancel');
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    var modalRoot = document.getElementById('order-modal');
    if (modalRoot) {
        modalRoot.addEventListener('click', function(e){
            if (e.target === this) closeModal();
        });
    }
});
